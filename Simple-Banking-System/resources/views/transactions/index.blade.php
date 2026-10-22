<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <style>
        body { font-family: Arial; background: #f1f5f9; margin: 0; }
        .container { max-width: 1000px; margin: 60px auto; background: white; padding: 25px; border-radius: 8px; overflow-x: auto; }
        h1 { text-align: center; color: #1e293b; }
        .links { text-align: center; margin: 20px; }
        a { background: #2563eb; color: white; padding: 10px 14px; text-decoration: none; border-radius: 5px; margin: 5px; display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background: #e2e8f0; }
        .empty { color: #777; }
        .success { color: green; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h1>Transaction History</h1>
    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif
    <p>Account: {{ $account->account_number }}</p>
    <p>Balance: {{ number_format($account->balance, 2) }}</p>
    <div class="links">
        <a href="{{ route('transactions.create') }}">Create Transaction</a>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>
    <table>
        <thead>
            <tr><th>Account</th><th>Type</th><th>Amount</th><th>Reference</th><th>Date</th></tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->account_id }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->reference_number ?: 'N/A' }}</td>
                    <td>{{ $transaction->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">No transactions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>