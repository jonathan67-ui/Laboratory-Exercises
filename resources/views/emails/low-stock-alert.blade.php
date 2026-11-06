
<!DOCTYPE html>
<html>
<body style="font-family: Arial; padding: 20px;">
    <div style="background: #dc3545; color: white; padding: 20px;">
        <h2>Low Stock Alert</h2>
    </div>

    <div style="padding: 20px; background: #f8f9fa;">
        <p>The following products need restocking:</p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Available Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
