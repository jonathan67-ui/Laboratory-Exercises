
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Tasty Table</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #183d2b, #39734b);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 38px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 20px 60px #102b1d55;
        }

        .brand {
            margin-bottom: 30px;
            text-align: center;
        }

        .brand-icon {
            width: 66px;
            height: 66px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border-radius: 18px;
            background: #e7efe5;
            font-size: 32px;
        }

        .brand h1 {
            margin: 0 0 8px;
            color: #183d2b;
            font-size: 26px;
        }

        .brand p {
            margin: 0;
            color: #718075;
            font-size: 13px;
        }

        h2 {
            margin: 0 0 8px;
            color: #183d2b;
            font-size: 22px;
        }

        .intro {
            margin: 0 0 25px;
            color: #718075;
            font-size: 14px;
            line-height: 1.6;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #26372c;
            font-size: 13px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            margin-bottom: 19px;
            border: 1px solid #dce5d9;
            border-radius: 9px;
            background: #fbfcfa;
            color: #26372c;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: #39734b;
            box-shadow: 0 0 0 3px #39734b20;
        }

        .error {
            margin: -12px 0 16px;
            color: #b84242;
            font-size: 12px;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 9px;
            background: #24543a;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background .2s;
        }

        .login-button:hover {
            background: #183d2b;
        }

        .register-link {
            margin: 24px 0 0;
            color: #718075;
            font-size: 13px;
            text-align: center;
        }

        .register-link a {
            color: #24543a;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 28px;
            color: #9aa69b;
            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
            }
        }
    </style>
</head>

<body>
    <main class="login-card">
        <div class="brand">
           
            <h1>Tasty Table</h1>
            <p>Inventory Management System</p>
        </div>

        <h2>Welcome back!</h2>
        <p class="intro">Log in to manage your products and inventory.</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <label for="email">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button class="login-button" type="submit">
                Log In
            </button>
        </form>

        <p class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Create an account</a>
        </p>

        <div class="footer">
            Tasty Table · Forest Green Edition
        </div>
    </main>
</body>
</html>
