
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard | Forest Green</title>

    <style>
        :root {
            --forest: #0e7c47;
            --forest-light: #24543a;
            --leaf: #07842e;
            --sage: #e7efe5;
            --cream: #f7f8f3;
            --white: #ffffff;
            --text: #26372c;
            --muted: #718075;
            --border: #dce5d9;
            --danger: #b84242;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--cream);
            color: var(--text);
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 245px;
            padding: 28px 18px;
            background: var(--forest);
            color: white;
        }

        .brand {
            padding: 0 12px 30px;
            border-bottom: 1px solid #ffffff25;
        }

        .brand h2 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        .brand p {
            margin: 0;
            color: #c3d6c7;
            font-size: 12px;
        }

        .nav-label {
            margin: 28px 12px 12px;
            color: #b8cdbd;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-link {
            display: block;
            margin: 6px 0;
            padding: 13px 14px;
            border-radius: 8px;
            color: #e3eee5;
            text-decoration: none;
            font-size: 14px;
        }

        .nav-link.active,
        .nav-link:hover {
            background: var(--forest-light);
            color: white;
        }

        .sidebar-bottom {
            position: absolute;
            right: 18px;
            bottom: 24px;
            left: 18px;
        }

        .logout-button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ffffff55;
            border-radius: 8px;
            background: transparent;
            color: white;
            cursor: pointer;
        }

        .main {
            margin-left: 245px;
            padding: 32px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            margin: 0 0 8px;
            color: var(--forest);
            font-size: 28px;
        }

        .subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .date-label {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: white;
            color: var(--forest);
            font-size: 13px;
        }

        .welcome {
            margin-bottom: 24px;
            padding: 24px;
            border-radius: 14px;
            background: linear-gradient(120deg, #09713f, #39734b);
            color: white;
        }

        .welcome h2 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        .welcome p {
            margin: 0;
            color: #e0eee2;
            font-size: 14px;
            line-height: 1.6;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--white);
        }

        .stat-card .label {
            color: var(--muted);
            font-size: 13px;
        }

        .stat-card .number {
            margin-top: 12px;
            color: var(--forest);
            font-size: 30px;
            font-weight: bold;
        }

        .stat-card .note {
            margin-top: 8px;
            color: var(--leaf);
            font-size: 12px;
        }

        .panel {
            margin-bottom: 24px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: white;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h2 {
            margin: 0;
            color: var(--forest);
            font-size: 18px;
        }

        .panel-body {
            padding: 22px;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 7px;
            background: var(--leaf);
            color: white;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background: var(--forest);
        }

        .button-outline {
            border: 1px solid var(--leaf);
            background: white;
            color: var(--forest);
        }

        .button-outline:hover {
            background: var(--sage);
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 15px 20px;
            border-bottom: 1px solid #edf1eb;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #f2f6f0;
            color: var(--forest);
            font-size: 11px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        tbody tr:hover {
            background: #f8faf6;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: var(--sage);
            color: var(--forest);
            font-size: 11px;
            font-weight: bold;
        }

        .empty {
            padding: 24px;
            color: var(--muted);
            text-align: center;
        }

        .footer {
            padding: 8px 0 20px;
            color: var(--muted);
            font-size: 12px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
                padding: 18px;
            }

            .sidebar-bottom {
                position: static;
                margin-top: 20px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 24px;
            }

            .panel-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="brand">
            <h2> Tasty Table</h2>
            <p>Inventory Management System</p>
        </div>

        <p class="nav-label">Workspace</p>

        <a class="nav-link active"
           href="{{ route('inventory.index') }}">
            ▦ &nbsp; Dashboard
        </a>

        <a class="nav-link"
           href="{{ route('products.index') }}">
            ◈ &nbsp; Products
        </a>

        @if (Route::has('inventory.summary'))
            <a class="nav-link"
               href="{{ route('inventory.summary') }}">
                ▤ &nbsp; Inventory Summary
            </a>
        @endif

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout-button" type="submit">
                    ↪ &nbsp; Log out
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>Inventory Dashboard</h1>
                <p class="subtitle">
                    Monitor your products and inventory activity.
                </p>
            </div>

            <div class="date-label">
                {{ now()->format('F d, Y') }}
            </div>
        </header>

        <section class="welcome">
            <h2>Welcome back, {{ auth()->user()->name }}!</h2>
            <p>
                Here's an overview of your inventory.
                Keep your stock organized and up to date.
            </p>
        </section>

        <section class="stats">
            <div class="stat-card">
                <div class="label">Total Products</div>
                <div class="number">{{ $products->count() }}</div>
                <div class="note">Products in your catalog</div>
            </div>

            <div class="stat-card">
                <div class="label">Total Stock Units</div>
                <div class="number">
                    {{ $products->sum('quantity') }}
                </div>
                <div class="note">Units currently recorded</div>
            </div>

            <div class="stat-card">
                <div class="label">Recent Transactions</div>
                <div class="number">{{ $transactions->count() }}</div>
                <div class="note">Latest recorded activity</div>
            </div>
        </section>
        <section class="panel" id="notifications-panel">
            <div class="panel-header">
                <h2> Notifications</h2>
            </div>

            <div class="panel-body" id="notification-list" aria-live="polite">
                <p class="empty">Loading notifications...</p>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
    <h2>Recent Inventory Transactions</h2>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <button type="button" class="button"
                onclick="document.getElementById('transactionForm').style.display =
                document.getElementById('transactionForm').style.display === 'none' ? 'block' : 'none';">
            + New Transaction
        </button>

        @if (Route::has('inventory.summary'))
            <a class="button button-outline"
               href="{{ route('inventory.summary') }}">
                View Summary
            </a>
        @endif
    </div>
</div>

<div id="transactionForm" class="panel-body"
     style="display:none; border-bottom:1px solid var(--border);">
    <h3>Record New Transaction</h3>

    @if ($errors->any())
        <div style="color:#b84242; margin-bottom:12px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf

        <div style="margin-bottom:15px;">
            <label for="product_id">Product</label>
            <select id="product_id" name="product_id" required
                    style="display:block; width:100%; padding:10px; margin-top:6px;">
                <option value="">-- Select Product --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} (Stock: {{ $product->quantity }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label for="type">Transaction Type</label>
            <select id="type" name="type" required
                    style="display:block; width:100%; padding:10px; margin-top:6px;">
                <option value="">-- Select Type --</option>
                <option value="stock_in" {{ old('type') == 'stock_in' ? 'selected' : '' }}>Stock In</option>
                <option value="stock_out" {{ old('type') == 'stock_out' ? 'selected' : '' }}>Stock Out</option>
                <option value="return" {{ old('type') == 'return' ? 'selected' : '' }}>Return</option>
                <option value="damaged" {{ old('type') == 'damaged' ? 'selected' : '' }}>Damaged</option>
            </select>
        </div>

        <div style="margin-bottom:15px;">
            <label for="quantity">Quantity</label>
            <input id="quantity" type="number" name="quantity" min="1"
                   value="{{ old('quantity', 1) }}" required
                   style="display:block; width:100%; padding:10px; margin-top:6px;">
        </div>

        <div style="margin-bottom:15px;">
            <label for="notes">Notes (Optional)</label>
            <textarea id="notes" name="notes" rows="3"
                      style="display:block; width:100%; padding:10px; margin-top:6px;">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" class="button">Save Transaction</button>

        <button type="button" class="button button-outline"
                onclick="document.getElementById('transactionForm').style.display='none';">
            Cancel
        </button>
    </form>
</div>
            @if ($products->isEmpty())
                <div class="empty">
                    No products found. Add your first product to get started.
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @if ($product->quantity <= 0)
                                            <span class="badge"
                                                  style="background:#fce8e8;color:#a52b2b;">
                                                Out of Stock
                                            </span>
                                        @elseif ($product->quantity <= 10)
                                            <span class="badge"
                                                  style="background:#fff0d5;color:#875414;">
                                                Low Stock
                                            </span>
                                        @else
                                            <span class="badge">
                                                In Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="panel">
            <div class="panel-header">
                <h2>Recent Inventory Transactions</h2>
                @if (Route::has('inventory.summary'))
                    <a class="button button-outline"
                       href="{{ route('inventory.summary') }}">
                        View Summary
                    </a>
                @endif
            </div>

            @if ($transactions->isEmpty())
                <div class="empty">
                    No inventory transactions recorded yet.
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Transaction Type</th>
                                <th>Quantity</th>
                                <th>Recorded By</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $transaction->product->name ?? 'Deleted product' }}
                                    </td>
                                    <td>
                                        <span class="badge">
                                            {{ ucwords(str_replace('_', ' ', $transaction->type)) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>
                                        {{ $transaction->user->name ?? 'Unknown' }}
                                    </td>
                                    <td>
                                        {{ $transaction->created_at?->format('M d, Y h:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <div class="footer">
            Tasty Table Inventory System · Forest Green Edition
        </div>
    </main>
    @if ($errors->any())
    <script>
        document.getElementById('transactionForm').style.display = 'block';
    </script>
@endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('notification-list');
            if (!list) return;

            async function loadNotifications() {
                try {
                    const response = await fetch(
                        "{{ route('notifications.latest') }}",
                        {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        }
                    );

                    if (!response.ok) {
                        throw new Error('Notification request failed: ' + response.status);
                    }

                    const result = await response.json();
                    const notifications = Array.isArray(result.notifications)
                        ? result.notifications
                        : [];

                    list.replaceChildren();

                    if (notifications.length === 0) {
                        const empty = document.createElement('p');
                        empty.className = 'empty';
                        empty.textContent = 'No new notifications.';
                        list.appendChild(empty);
                        return;
                    }

                    notifications.forEach(function (notification) {
    const data = notification.data || {};

    const item = document.createElement('div');
    item.style.cssText =
        'display:flex; justify-content:space-between; align-items:center; gap:12px; padding:12px; margin-bottom:10px; background:#fff0d5; border:1px solid #f3c66b; border-left:5px solid #e0a000;';

    const content = document.createElement('div');

    const title = document.createElement('strong');
    title.style.color = '#9a5700';
    title.textContent = data.product_name || 'Inventory Alert';

    const message = document.createElement('p');
    message.style.cssText = 'margin:6px 0; color:#7c4a03;';
    message.textContent = data.message || 'New inventory notification.';

    const details = document.createElement('small');
    details.style.color = '#875414';
    details.textContent =
        'Stock: ' + (data.quantity ?? 'N/A') +
        ' · Reorder level: ' + (data.reorder_level ?? 'N/A');

    content.append(title, message, details);

    const closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.textContent = '×';
    closeButton.title = 'Remove notification';
    closeButton.setAttribute('aria-label', 'Remove notification');
    closeButton.style.cssText =
        'border:none; background:transparent; color:#dc2626; font-size:26px; font-weight:bold; cursor:pointer; padding:4px 10px;';

    closeButton.addEventListener('click', async function () {
        closeButton.disabled = true;

        try {
            const response = await fetch(
                '/notifications/' + encodeURIComponent(notification.id),
                {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                }
            );

            if (response.ok) {
                item.remove();
            } else {
                closeButton.disabled = false;
                alert('Could not remove notification. Please try again.');
            }
        } catch (error) {
            closeButton.disabled = false;
            alert('Could not connect to the server.');
        }
    });

    item.append(content, closeButton);
    list.appendChild(item);
});
                } catch (error) {
                    console.error('Could not refresh notifications:', error);
                    // Keep the current content visible if a temporary request fails.
                }
            }

            loadNotifications();
            setInterval(loadNotifications, 3000);
        });
    </script>
\n</body>
</html>
