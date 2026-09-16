<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tasty Table Food Inventory</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --primary: #2E7D32;
            --secondary: #1B5E20;
            --background: #F4F9F4;
            --text: #112211;
            --accent: #4CAF50;
            --light-accent: #E8F5E9;
            --white: #FFFFFF;
            --border: #D0E2D0;
        }

        body {
            background-color: var(--background);
            color: var(--text);
        }

        .navbar {
            background-color: var(--primary);
        }

        .navbar-brand,
        .navbar-text {
            color: var(--white) !important;
            font-weight: bold;
        }

        .dashboard-title {
            color: var(--secondary);
            font-weight: bold;
        }

        .stat-card {
            border: 1px solid var(--border);
            border-left: 5px solid var(--primary);
            background-color: var(--white);
        }

        .stat-number {
            color: var(--primary);
            font-size: 28px;
            font-weight: bold;
        }

        .btn-success {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-success:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .table thead {
            background-color: var(--primary);
            color: var(--white);
        }

        .low-stock {
            color: #b02a37;
            font-weight: bold;
        }

        .in-stock {
            color: var(--primary);
            font-weight: bold;
        }

        .card {
            border: 1px solid var(--border);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">
                Tasty Table
            </a>

            <span class="navbar-text">
                Food Inventory Management
            </span>
        </div>
    </nav>

    <main class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please correct the following errors:</strong>

                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>