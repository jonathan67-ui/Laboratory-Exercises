<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

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

        .form-container {
            width: 90%;
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #237a45;
            margin-top: 0;
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 8px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd8ce;
            border-radius: 8px;
            font: inherit;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #237a45;
            box-shadow: 0 0 0 3px rgba(35, 122, 69, 0.12);
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 22px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 12px 18px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background: #237a45;
            color: white;
        }

        .btn-primary:hover {
            background: #195c34;
        }

        .btn-cancel {
            background: #e5e7eb;
            color: #374151;
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: auto;
            }

            nav {
                padding: 16px 4%;
            }

            .brand {
                font-size: 17px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('products.index') }}" class="brand">
            Tasty Table Inventory
        </a>

        <a href="{{ route('products.index') }}" class="nav-button">
            Dashboard
        </a>
    </nav>

    <div class="form-container">
        <h1>Add Product</h1>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="sku">SKU</label>
                    <input type="text"
                           id="sku"
                           name="sku"
                           value="{{ old('sku') }}"
                           required>
                </div>

                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea id="description"
                              name="description">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text"
                           id="category"
                           name="category"
                           value="{{ old('category') }}">
                </div>

                <div class="form-group">
                    <label for="supplier">Supplier</label>
                    <input type="text"
                           id="supplier"
                           name="supplier"
                           value="{{ old('supplier') }}">
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number"
                           id="quantity"
                           name="quantity"
                           min="0"
                           value="{{ old('quantity', 0) }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="reorder_level">Reorder Level</label>
                    <input type="number"
                           id="reorder_level"
                           name="reorder_level"
                           min="0"
                           value="{{ old('reorder_level', 5) }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="unit_price">Unit Price</label>
                    <input type="number"
                           id="unit_price"
                           name="unit_price"
                           min="0"
                           step="0.01"
                           value="{{ old('unit_price', 0) }}"
                           required>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    Save Product
                </button>

                <a href="{{ route('products.index') }}" class="btn btn-cancel">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>