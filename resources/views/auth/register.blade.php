
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Tasty Table</title>

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

        .register-card {
            width: 100%;
            max-width: 440px;
            padding: 36px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 20px 60px #102b1d55;
        }

        .brand {
            margin-bottom: 26px;
            text-align: center;
        }

        .brand-icon {
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 13px;
            border-radius: 17px;
            background: #e7efe5;
            font-size: 30px;
        }

        .brand h1 {
            margin: 0 0 7px;
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
            margin: 0 0 23px;
            color: #718075;
            font-size: 14px;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: #26372c;
            font-size: 13px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            margin-bottom: 17px;
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

        .error-box {
            margin-bottom: 18px;
            padding: 12px;
            border: 1px solid #f1caca;
            border-radius: 9px;
            background: #fff3f3;
            color: #a52d2d;
            font-size: 13px;
            line-height: 1.6;
        }

        .register-button {
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

        .register-button:hover {
            background: #183d2b;
        }

        .login-link {
            margin: 22px 0 0;
            color: #718075;
            font-size: 13px;
            text-align: center;
        }

        .login-link a {
            color: #24543a;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 25px;
            color: #9aa69b;
            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 27px 22px;
            }
        }
    </style>
</head>

<body>
    <main class="register-card">
        <div class="brand">
            <h1>Tasty Table</h1>
            <p>Inventory Management System</p>
        </div>

        <h2>Create an account</h2>
        <p class="intro">
            Join Tasty Table to manage your products and inventory.
        </p>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <label for="name">Full name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter your full name"
                required
            >

            <label for="email">Email address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                required
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Create a password"
                required
            >

            <label for="password_confirmation">Confirm password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="Enter your password again"
                required
            >

            <button class="register-button" type="submit">
                Create Account
            </button>
        </form>

        <p class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Log in</a>
        </p>

        <div class="footer">
            Tasty Table · Forest Green Edition
        </div>
    </main>
</body>
</html>
