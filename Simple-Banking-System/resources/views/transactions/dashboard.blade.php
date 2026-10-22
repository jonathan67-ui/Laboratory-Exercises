<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Dashboard</title>
</head>
<body>
    <h1>Bank Dashboard</h1>

    <p>Total Accounts: <span id="totalAccounts">0</span></p>
    <p>Total Money: ₱<span id="totalMoney">0.00</span></p>
    <p>Transactions Today: <span id="totalTransactions">0</span></p>
    <p id="status"></p>

    <a href="{{ route('transactions.index') }}">Transactions</a>
    <a href="{{ route('transactions.create') }}">New Transaction</a>

    <script>
        async function updateDashboard() {
            const status = document.getElementById('status');

            try {
                const response = await fetch('/api/dashboard/stats', {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const data = await response.json();

                document.getElementById('totalAccounts').textContent =
                    data.total_accounts;

                document.getElementById('totalMoney').textContent =
                    Number(data.total_money).toLocaleString('en-PH', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                document.getElementById('totalTransactions').textContent =
                    data.total_transactions_today;

                status.textContent = 'Last updated: ' +
                    new Date().toLocaleTimeString();
            } catch (error) {
                status.textContent = 'Unable to load dashboard statistics.';
            }
        }

        updateDashboard();
        setInterval(updateDashboard, 30000);
    </script>
</body>
</html>