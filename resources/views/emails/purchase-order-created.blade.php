
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order Created</title>
</head>
<body style="font-family: Arial; background: #f4f4f4; padding: 20px;">
    <div style="background: #0d6efd; color: white; padding: 20px;">
        <h2>Inventory Management System</h2>
    </div>

    <div style="background: white; padding: 20px;">
        <h3>Purchase Order Created</h3>
        <p>A new purchase order has been created.</p>

        <p><strong>Reference:</strong>
            {{ $purchaseOrder->reference }}</p>

        <p><strong>Supplier:</strong>
            {{ $purchaseOrder->supplier->company_name }}</p>

        <p><strong>Total:</strong>
            {{ number_format($purchaseOrder->total, 2) }}</p>
    </div>
</body>
</html>
