<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transactions;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transactions::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'DESC')
            ->filter($request->only(['type', 'status', 'filter']))
            ->paginate(15)
            ->withQueryString();

        $summary = DB::table('transactions')
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->selectRaw('
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense,
                SUM(CASE WHEN type = "income" THEN amount ELSE -amount END) as balance
            ')
            ->first();

        return Inertia::render('Transaction', [ // Exactly matches your folder/file
            'transactions' => $transactions,
            'filters' => $request->all(['type', 'status', 'filter']),
            'summary' => [
                'balance' => $summary->balance ?? 0,
                'income' => $summary->income ?? 0,
                'expense' => $summary->expense ?? 0,
            ],
            'message' => session('message'),
        ]);
    ;}

    public function create()
    {
        return Inertia::render('Transaction/AddTransaction', [ // Exact match
            'categories' => Category::where('user_id', Auth::id())->get(),
            'currencies' => config('app.currencies'),
        ]);
    }

    public function edit(Transactions $transaction)
    {
        $this->authorize('update', $transaction);

        return Inertia::render('Transaction/EditTransaction', [ // Exact match
            'transaction' => $transaction,
            'categories' => Category::where('user_id', Auth::id())->get(),
            'currencies' => config('app.currencies'),
        ]);
    }


    public function update(Request $request, Transactions $transaction)
    {
        $this->authorize('update', $transaction);

        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:completed,pending,failed',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $transaction->update($request->only([
            'date', 'type', 'name', 'amount',
            'status', 'category_id', 'notes'
        ]));

        return redirect()
            ->route('transactions.index')
            ->with('message', 'Transaction updated successfully');
    }

    public function destroy(Transactions $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('message', 'Transaction moved to trash');
    }

    public function restore($id)
    {
        $transaction = Transactions::withTrashed()->findOrFail($id);
        $this->authorize('restore', $transaction);

        $transaction->restore();

        return redirect()
            ->route('transactions.index', ['filter' => 'only'])
            ->with('message', 'Transaction restored successfully');
    }

    public function forceDelete($id)
    {
        $transaction = Transactions::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $transaction);

        $transaction->forceDelete();

        return redirect()
            ->route('transactions.index', ['filter' => 'only'])
            ->with('message', 'Transaction permanently deleted');
    }
}
