
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Summary | Tasty Table</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7f2;
            color: #26372c;
        }

        .header {
            background: #183d2b;
            color: white;
            padding: 25px 6%;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 27px;
        }

        .header p {
            margin: 0;
            color: #d5e5d7;
            font-size: 14px;
        }

        .container {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 22px;
        }

        .back {
            display: inline-block;
            margin-bottom: 24px;
            color: #24543a;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .back:hover {
            text-decoration: underline;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .card {
            padding: 25px;
            background: white;
            border: 1px solid #dce5d9;
            border-radius: 13px;
            box-shadow: 0 4px 12px #183d2b0a;
        }

        .card-label {
            color: #718075;
            font-size: 14px;
        }

        .card-number {
            margin: 12px 0 6px;
            color: #183d2b;
            font-size: 36px;
            font-weight: bold;
        }

        .card-note {
            color: #39734b;
            font-size: 12px;
        }

        .warning .card-number {
            color: #a66b18;
        }

        .warning .card-note {
            color: #a66b18;
        }

        .panel {
            overflow: hidden;
            background: white;
            border: 1px solid #dce5d9;
            border-radius: 13px;
        }

        .panel-heading {
            padding: 22px 24px;
            border-bottom: 1px solid #dce5d9;
        }

        .panel-heading h2 {
            margin: 0 0 7px;
            color: #183d2b;
            font-size: 19px;
        }

        .panel-heading p {
            margin: 0;
            color: #718075;
            font-size: 13px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            padding: 16px 24px;
            text-align: left;
            border-bottom: 1px solid #edf1eb;
        }

        th {
            background: #e7efe5;
            color: #183d2b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        tbody tr:hover {
            background: #f8faf6;
        }

        .product-name {
            color: #26372c;
            font-weight: bold;
        }

        .quantity {
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .low {
            background: #fff0d5;
            color: #875414;
        }

        .normal {
            background: #e3f1e4;
            color: #24543a;
        }

        .footer {
            margin: 25px 0;
            color: #718075;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .container {
                margin-top: 22px;
                padding: 0 14px;
            }

            th, td {
                padding: 13px 15px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>Tasty Table</h1>
        <p>Inventory Management System · Inventory Summary</p>
    </header>

    <main class="container">
        <a class="back" href="{{ route('inventory.index') }}">
            ← Back to Dashboard
        </a>

        <div style="margin-bottom: 25px;">
            <h2 style="color:#183d2b; margin-bottom:8px;">
                Inventory Summary
            </h2>
            <p style="color:#718075; margin:0; font-size:14px;">
                Review your stock levels and identify products that need reordering.
            </p>
        </div>

        <section class="stats">
            <div class="card">
                <div class="card-label">Total Products</div>
                <div class="card-number">{{ $total_products }}</div>
                <div class="card-note">Products in your inventory</div>
            </div>

            <div class="card warning">
                <div class="card-label">Low-Stock Products</div>
                <div class="card-number">{{ $low_stock_count }}</div>
                <div class="card-note">Products at or below reorder level</div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-heading">
                <h2>Product Stock Levels</h2>
                <p>Compare current quantities with their reorder levels.</p>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="product-name">
                                    {{ $product->name }}
                                </td>
                                <td class="quantity">
                                    {{ $product->quantity }}
                                </td>
                                <td>{{ $product->reorder_level }}</td>
                                <td>
                                    @if ($product->quantity <= $product->reorder_level)
                                        <span class="status low">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="status normal">
                                            In Stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="footer">
            Tasty Table Inventory System · Forest Green Edition
            <br>
            Last updated: {{ now()->format('M d, Y h:i A') }}
        </div>
    </main>
</body>
</html>
