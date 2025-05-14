<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'transactions' => auth()->user()->transactions()->with('category')->latest()->get()
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = auth()->user()->transactions()->create($request->validated());
        return response()->json($transaction, 201);
    }

    // Add show(), update(), destroy() as needed...
}