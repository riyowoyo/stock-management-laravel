<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // List all transactions
    public function index()
    {
        $transactions = Transaction::with('product', 'user')->get();
        return view('transactions.index', compact('transactions'));
    }

    // Show form to create new transaction
    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    // Store new transaction
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Update product stock
        if($request->type === 'in') {
            $product->stock += $request->quantity;
        } else { // out
            if($product->stock < $request->quantity) {
                return back()->withErrors(['quantity' => 'Stock is not enough']);
            }
            $product->stock -= $request->quantity;
        }
        $product->save();

        // Save transaction
        Transaction::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction saved successfully.');
    }

    // Show form to edit transaction
    public function edit(Transaction $transaction)
    {
        $products = Product::all();
        return view('transactions.edit', compact('transaction', 'products'));
    }

    // Update transaction
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $oldQuantity = $transaction->quantity;
        $oldType = $transaction->type;

        $product = Product::findOrFail($request->product_id);

        // Revert old transaction stock
        if($oldType === 'in') $product->stock -= $oldQuantity;
        else $product->stock += $oldQuantity;

        // Apply new transaction stock
        if($request->type === 'in') $product->stock += $request->quantity;
        else {
            if($product->stock < $request->quantity) {
                return back()->withErrors(['quantity' => 'Stock is not enough']);
            }
            $product->stock -= $request->quantity;
        }

        $product->save();

        // Update transaction
        $transaction->update([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'type' => $request->type,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    // Delete transaction
    public function destroy(Transaction $transaction)
    {
        $product = $transaction->product;

        // Revert stock
        if($transaction->type === 'in') $product->stock -= $transaction->quantity;
        else $product->stock += $transaction->quantity;

        $product->save();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
