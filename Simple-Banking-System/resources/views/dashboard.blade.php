
<!DOCTYPE html>
<html>
<head>
    <title>Banking Dashboard</title>
    <style>
        body { font-family: Arial; background: #f1f5f9; margin: 0; }
        .container { max-width: 600px; margin: 80px auto; padding: 30px; background: white; border-radius: 8px; text-align: center; }
        h1 { color: #1e293b; }
        p { color: #64748b; }
        a { display: inline-block; margin: 10px; padding: 12px 18px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; }
        a:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Simple Banking System</h1>
        <p>Welcome to your banking dashboard.</p>
        <a href="{{ route('transactions.index') }}">Transaction History</a>
        <a href="{{ route('transactions.create') }}">Create Transaction</a>
    </div>
</body>
</html>
