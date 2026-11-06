
<!DOCTYPE html>
<html>
<head>
    <title>Products Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }
    </style>
</head>
<body>

    <h2>Products Inventory Report</h2>

    <p>Date: {{ date('Y-m-d') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Reorder Level</th>
                <th>Unit Price</th>
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
                    <td>{{ $product->unit_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
