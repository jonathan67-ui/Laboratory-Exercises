<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $account = $this->getAccount($request->user()->id);
        $transactions = $account->transactions()->latest()->get();

        return view('transactions.index', compact('account', 'transactions'));
    }

    public function create(Request $request)
    {
        $account = $this->getAccount($request->user()->id);

        return view('transactions.create', compact('account'));
    }

    public function store(Request $request)
    {
        $account = $this->getAccount($request->user()->id);

        $validator = Validator::make($request->all(), [
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
            'type' => ['required', 'in:deposit,withdrawal'],
            'amount' => ['required', 'numeric', 'min:1'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $validator->after(function ($validator) use ($request, $account) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            if ((int) $request->input('account_id') !== (int) $account->id) {
                $validator->errors()->add('account_id', 'The selected account is invalid.');
                return;
            }

            if ($request->input('type') === 'withdrawal') {
                $balance = (int) round((float) $account->balance * 100);
                $minimum = (int) round((float) $account->minimum_balance * 100);
                $amount = (int) round((float) $request->input('amount') * 100);

                if ($balance - $amount < 0 || $balance - $amount < $minimum) {
                    $validator->errors()->add(
                        'amount',
                        'Insufficient funds. Your minimum balance must be maintained.'
                    );
                }
            }
        });

        $validated = $validator->validate();

        DB::transaction(function () use ($account, $validated) {
            Transaction::create([
                'account_id' => $account->id,
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    private function getAccount(int $userId): Account
    {
        return Account::firstOrCreate(
            ['user_id' => $userId],
            [
                'account_number' => 'SB' . Str::upper(Str::random(12)),
                'balance' => 0.00,
                'minimum_balance' => 100.00,
            ]
        );
    }
}