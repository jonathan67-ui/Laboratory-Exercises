<!DOCTYPE html>
<html>
<head>
    <title>Create Transaction</title>
    <style>
        body { font-family: Arial; background: #f1f5f9; margin: 0; }
        .container { max-width: 400px; margin: 60px auto; background: white; padding: 25px; border-radius: 8px; }
        h1 { text-align: center; color: #1e293b; }
        label { display: block; margin: 12px 0 6px; }
        input, select { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 5px; }
        button, a { padding: 10px 14px; border: 0; border-radius: 5px; text-decoration: none; cursor: pointer; }
        button { background: #2563eb; color: white; }
        a { background: #64748b; color: white; }
        .actions { display: flex; justify-content: space-between; margin-top: 20px; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="container">
    <h1>Create Transaction</h1>
    <p>Account: {{ $account->account_number }}</p>
    <p>Balance: {{ number_format($account->balance, 2) }}</p>
    @if ($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif
    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf
        <input type="hidden" name="account_id" value="{{ $account->id }}">
        <label>Transaction Type</label>
        <select name="type" required>
            <option value="deposit">Deposit</option>
            <option value="withdrawal">Withdrawal</option>
        </select>
        <label>Amount</label>
        <input type="number" name="amount" min="1" step="0.01" value="{{ old('amount') }}" required>
        <label>Reference Number</label>
        <input type="text" name="reference_number" value="{{ old('reference_number') }}">
        <label>Notes</label>
        <input type="text" name="notes" value="{{ old('notes') }}">
        <div class="actions">
            <a href="{{ route('transactions.index') }}">Back</a>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
</body>
</html>