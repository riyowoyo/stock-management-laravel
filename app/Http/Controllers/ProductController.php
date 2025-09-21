<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('product_code', 'like', "%{$request->search}%");
        }

        $products = $query->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:products',
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric',
            'stock' => 'integer',
        ]);

        Product::create([
            'product_code' => $request->product_code,
            'name' => $request->name,
            'unit' => $request->unit,
            'price' => $request->price,
            'stock' => 0, // stok awal selalu 0
        ]);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show form to edit product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function exportStockCardPdf($id)
    {
        $product = Product::findOrFail($id);
        $transactions = $product->transactions()
            ->orderBy('date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $pdf = Pdf::loadView('products.stock-card-pdf', compact('product', 'transactions'));
        return $pdf->download('kartu-stok-' . $product->product_code . '.pdf');
    }

    public function exportStockCardExcel($id)
    {
        $product = Product::findOrFail($id);
        return Excel::download(new \App\Exports\StockCardExport($product), 'kartu-stok-' . $product->product_code . '.xlsx');
    }
    // Update product (Edit via form sendiri)
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $product->id,
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Delete product (modal)
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
