<div class="mb-3">
    <label class="form-label">Product Name</label>
    <input
        type="text"
        name="name"
        class="form-control"
        value="{{ old('name', $product->name ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">SKU</label>
    <input
        type="text"
        name="sku"
        class="form-control"
        value="{{ old('sku', $product->sku ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Category</label>
    <input
        type="text"
        name="category"
        class="form-control"
        value="{{ old('category', $product->category ?? '') }}"
        required>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Quantity</label>
        <input
            type="number"
            name="quantity"
            class="form-control"
            min="0"
            value="{{ old('quantity', $product->quantity ?? 0) }}"
            required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Reorder Level</label>
        <input
            type="number"
            name="reorder_level"
            class="form-control"
            min="0"
            value="{{ old('reorder_level', $product->reorder_level ?? 5) }}"
            required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Unit Price</label>
        <input
            type="number"
            name="unit_price"
            class="form-control"
            min="0"
            step="0.01"
            value="{{ old('unit_price', $product->unit_price ?? 0) }}"
            required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Supplier</label>
    <input
        type="text"
        name="supplier"
        class="form-control"
        value="{{ old('supplier', $product->supplier ?? '') }}">
</div>