<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .navbar {
            background: #198754;
            color: white;
            padding: 18px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            background: #146c43;
            padding: 10px 16px;
            border-radius: 5px;
        }

        .container {
            width: 92%;
            max-width: 1250px;
            margin: 30px auto;
        }

        .alert {
            background: #d1e7dd;
            color: #0f5132;
            padding: 14px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 22px;
            border-radius: 8px;
            border-left: 5px solid #198754;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .summary-card h3 {
            margin: 0 0 10px;
            font-size: 15px;
            color: #777;
        }

        .summary-card h2 {
            margin: 0;
            font-size: 28px;
            color: #198754;
        }

        .products-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .products-header h2 {
            margin: 0;
        }

        .add-button {
            background: #198754;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #e9f7ef;
            color: #146c43;
        }

        .badge {
            padding: 5px 9px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-danger {
            background: #f8d7da;
            color: #842029;
        }

        .badge-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .action-button {
            border: none;
            color: white;
            padding: 7px 10px;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
        }

        .edit-button {
            background: #ffc107;
            color: #222;
        }

        .delete-button {
            background: #dc3545;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        @media (max-width: 900px) {
            .summary {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 15px;
            }

            .navbar h1 {
                font-size: 18px;
            }

            .container {
                width: 95%;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .products-header {
                gap: 15px;
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Inventory Dashboard</h1>
        <a href="{{ route('products.create') }}">Add Product</a>
    </div>

    <div class="container">

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="summary">
            <div class="summary-card">
                <h3>Total Products</h3>
                <h2>{{ $totalProducts }}</h2>
            </div>

            <div class="summary-card">
                <h3>Total Quantity</h3>
                <h2>{{ $totalQuantity }}</h2>
            </div>

            <div class="summary-card">
                <h3>Low Stock Items</h3>
                <h2>{{ $lowStock }}</h2>
            </div>

            <div class="summary-card">
                <h3>Total Inventory Value</h3>
                <h2>₱{{ number_format($totalValue, 2) }}</h2>
            </div>
        </div>

        <div class="products-card">
            <div class="products-header">
                <h2>Products from Database</h2>

                <a
                    class="add-button"
                    href="{{ route('products.create') }}"
                >
                    + Add Product
                </a>
            </div>

            @if($products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Reorder Level</th>
                            <th>Unit Price</th>
                            <th>Supplier</th>
                            <th>Stock Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->reorder_level }}</td>
                                <td>
                                    ₱{{ number_format($product->unit_price, 2) }}
                                </td>
                                <td>{{ $product->supplier }}</td>

                                <td>
                                    @if($product->quantity <= $product->reorder_level)
                                        <span class="badge badge-danger">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            In Stock
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a
                                        class="action-button edit-button"
                                        href="{{ route('products.edit', $product->id) }}"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('products.destroy', $product->id) }}"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete-button"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty">
                    No products found in the database.
                </div>
            @endif
        </div>
    </div>

</body>
</html>