<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionObserver
{
    public function created(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction) {
            $account = Account::whereKey($transaction->account_id)
                ->lockForUpdate()
                ->first();

            if (!$account) {
                throw ValidationException::withMessages([
                    'account_id' => 'Account not found.',
                ]);
            }

            $balance = (int) round((float) $account->balance * 100);
            $amount = (int) round((float) $transaction->amount * 100);
            $minimum = (int) round((float) $account->minimum_balance * 100);

            if ($amount < 1) {
                throw ValidationException::withMessages([
                    'amount' => 'Amount must be at least 1.',
                ]);
            }

            if ($transaction->type === 'deposit') {
                $newBalance = $balance + $amount;
            } elseif (in_array($transaction->type, ['withdrawal', 'transfer'])) {
                $newBalance = $balance - $amount;

                if ($newBalance < 0 || $newBalance < $minimum) {
                    throw ValidationException::withMessages([
                        'amount' => 'Insufficient funds. Your minimum balance must be maintained.',
                    ]);
                }
            } else {
                throw ValidationException::withMessages([
                    'type' => 'Invalid transaction type.',
                ]);
            }

            $account->balance = number_format($newBalance / 100, 2, '.', '');
            $account->save();
        });
    }
}