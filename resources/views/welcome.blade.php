
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lab 7 | Procurement Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        :root {
            --forest: #228B22;
            --forest-dark: #14532d;
            --forest-light: #e8f5e9;
            --page-bg: #f3f8f3;
            --white: #ffffff;
        }

        body {
            margin: 0;
            background-color: var(--page-bg);
            font-family: Arial, sans-serif;
            color: #263b2b;
        }

        /* Navigation */
        .navbar-custom {
            background-color: var(--forest-dark);
            padding: 15px 25px;
        }

        .navbar-custom .navbar-brand {
            color: var(--white);
            font-size: 21px;
            font-weight: bold;
        }

        .navbar-custom a {
            color: var(--white);
            text-decoration: none;
        }

        .navbar-custom a:hover {
            color: #c8e6c9;
        }

        /* Dashboard header */
        .dashboard-header {
            background: linear-gradient(
                135deg,
                #14532d,
                #228B22
            );
            color: var(--white);
            padding: 45px 30px;
            border-radius: 0 0 18px 18px;
            margin-bottom: 35px;
        }

        .dashboard-header h1 {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            margin-bottom: 0;
            color: #e8f5e9;
        }

        /* Dashboard widgets */
        .widget-container {
            background-color: var(--white);
            border-top: 5px solid var(--forest);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            min-height: 150px;
            box-shadow: 0 4px 12px rgba(20, 83, 45, 0.10);
        }

        .widget-container h1,
        .widget-container h2,
        .widget-container h3,
        .widget-container h4,
        .widget-container h5 {
            color: var(--forest-dark);
            font-weight: bold;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--forest);
            border-color: var(--forest);
        }

        .btn-primary:hover {
            background-color: var(--forest-dark);
            border-color: var(--forest-dark);
        }

        .btn-outline-primary {
            color: var(--forest);
            border-color: var(--forest);
        }

        .btn-outline-primary:hover {
            background-color: var(--forest);
            border-color: var(--forest);
            color: white;
        }

        /* Links */
        a {
            color: var(--forest);
        }

        a:hover {
            color: var(--forest-dark);
        }

        /* Footer */
        .footer {
            background-color: var(--forest-dark);
            color: white;
            padding: 20px;
            margin-top: 35px;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 30px 20px;
            }

            .dashboard-header h1 {
                font-size: 24px;
            }

            .widget-container {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                LAB 7 | INVENTORY SYSTEM
            </a>

            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-outline-light btn-sm">
                            Home
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="btn btn-light btn-sm ms-2">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <header class="dashboard-header">
        <div class="container-fluid">
            <h1>Procurement Dashboard</h1>

            <p>
                Automated Inventory Replenishment and Supplier Management System
            </p>
        </div>
    </header>

    <!-- Main Dashboard Content -->
    <main class="container-fluid px-4">

        <div class="row">

            <!-- Pending Purchase Orders -->
            <div class="col-lg-6 col-md-12">
                <div class="widget-container">
                    @include('widgets.pending-orders')
                </div>
            </div>

            <!-- Recent Purchase Orders -->
            <div class="col-lg-6 col-md-12">
                <div class="widget-container">
                    @include('widgets.recent-orders')
                </div>
            </div>

            <!-- Supplier Performance -->
            <div class="col-lg-6 col-md-12">
                <div class="widget-container">
                    @include('widgets.supplier-performance')
                </div>
            </div>

            <!-- Reorder Alerts -->
            <div class="col-lg-6 col-md-12">
                <div class="widget-container">
                    @include('widgets.reorder-alerts')
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>
            LAB 7 - Advanced MVC Architecture
        </p>
        <small>
            Automated Inventory Replenishment and Supplier Management System
        </small>
    </footer>

</body>
</html>
