<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('product')->latest();

        if ($request->type && in_array($request->type, ['in', 'out'])) {
            $query->where('type', $request->type);
        }

        if ($request->search) {
            $query->whereHas(
                'product',
                fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('product_code', 'like', "%{$request->search}%")
            )->orWhere('description', 'like', "%{$request->search}%");
        }

        $transactions = $query->paginate(10)->withQueryString();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'out' && $product->stock < $request->quantity) {
            return back()
                ->withErrors(['quantity' => 'Stok tidak mencukupi untuk transaksi keluar.'])
                ->withInput();
        }

        $transaction = Transaction::create([
            'product_id'  => $request->product_id,
            'user_id' => auth()->id(),
            'type'        => $request->type,
            'quantity'    => $request->quantity,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        // update stok
        if ($transaction->type === 'in') {
            $product->stock += $transaction->quantity;
        } else {
            $product->stock -= $transaction->quantity;
        }
        $product->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        return view('transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'product_id' => 'required',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        // rollback stok lama
        $oldProduct = $transaction->product;
        if ($transaction->type === 'in') {
            $oldProduct->stock -= $transaction->quantity;
        } else {
            $oldProduct->stock += $transaction->quantity;
        }
        $oldProduct->save();

        $newProduct = Product::findOrFail($request->product_id);

        if ($request->type === 'out' && $newProduct->stock < $request->quantity) {
            // rollback
            if ($transaction->type === 'in') {
                $oldProduct->stock += $transaction->quantity;
            } else {
                $oldProduct->stock -= $transaction->quantity;
            }
            $oldProduct->save();

            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk update transaksi keluar.'])->withInput();
        }

        $transaction->update([
            'product_id'  => $request->product_id,
            'type'        => $request->type,
            'quantity'    => $request->quantity,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        if ($transaction->type === 'in') {
            $newProduct->stock += $transaction->quantity;
        } else {
            $newProduct->stock -= $transaction->quantity;
        }
        $newProduct->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate.');
    }

    public function stockCard($id)
    {
        $product = Product::findOrFail($id);

        $transactions = Transaction::where('product_id', $product->id)
            ->orderBy('date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('products.stock-card', compact('product', 'transactions'));
    }

    public function destroy(Transaction $transaction)
    {
        $product = $transaction->product;

        if ($transaction->type === 'in') {
            if ($product->stock < $transaction->quantity) {
                return redirect()->route('transactions.index')
                    ->with('error', 'Tidak bisa menghapus transaksi ini karena stok akan menjadi minus.');
            }
            $product->stock -= $transaction->quantity;
        } else {
            $product->stock += $transaction->quantity;
        }

        $product->save();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with('product');
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->get();
        $pdf = Pdf::loadView('transactions.pdf', compact('transactions'));
        return $pdf->download('transactions.pdf');
    }

    public function exportExcel(Request $request)
    {
        $type = $request->get('type');
        return Excel::download(new TransactionsExport($type), 'transactions.xlsx');
    }
}
