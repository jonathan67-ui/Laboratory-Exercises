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
            background: #f3f7f4;
            color: #26382c;
        }

        nav {
            background: #237a45;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .brand {
            font-size: 22px;
        }

        .nav-button {
            background: white;
            color: #237a45;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .container {
            width: 86%;
            max-width: 1200px;
            margin: 35px auto;
        }

        h1 {
            color: #237a45;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin: 25px 0;
        }

        .card,
        .panel {
            background: white;
            border-radius: 15px;
            padding: 24px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
        }

        .card h3 {
            color: #68766d;
            font-size: 15px;
        }

        .card p {
            color: #237a45;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #e4ebe6;
            text-align: left;
        }

        th {
            background: #edf5ef;
            color: #237a45;
        }

        .btn {
            border: none;
            border-radius: 7px;
            padding: 9px 13px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            display: inline-block;
            font-size: 13px;
        }

        .btn-primary {
            background: #237a45;
            color: white;
        }

        .btn-edit {
            background: #e0efff;
            color: #1d5f9e;
        }

        .btn-delete {
            background: #fee2e2;
            color: #a12626;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .in-stock {
            background: #d9f5df;
            color: #176b32;
        }

        .low-stock {
            background: #fee2e2;
            color: #a12626;
        }

        .alert {
            background: #d9f5df;
            color: #176b32;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 850px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .panel {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }
        }

        @media (max-width: 550px) {
            .cards {
                grid-template-columns: 1fr;
            }

            nav {
                padding: 16px 4%;
            }

            .container {
                width: 92%;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('products.index') }}" class="brand">
            Tasty Table Inventory
        </a>

        <a href="{{ route('products.create') }}" class="nav-button">
            + Add Product
        </a>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <h1>Inventory Dashboard</h1>

        <div class="cards">
            <div class="card">
                <h3>Total Products</h3>
                <p>{{ $totalProducts }}</p>
            </div>

            <div class="card">
                <h3>Total Quantity</h3>
                <p>{{ $totalQuantity }}</p>
            </div>

            <div class="card">
                <h3>Low Stock</h3>
                <p>{{ $lowStock }}</p>
            </div>

            <div class="card">
                <h3>Total Value</h3>
                <p>₱{{ number_format($totalValue, 2) }}</p>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Product List</h2>

                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    + Add Product
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category ?? 'N/A' }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>₱{{ number_format($product->unit_price, 2) }}</td>

                            <td>
                                @if($product->quantity <= $product->reorder_level)
                                    <span class="badge low-stock">Low Stock</span>
                                @else
                                    <span class="badge in-stock">In Stock</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="btn btn-edit">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-delete"
                                            onclick="return confirm('Delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>