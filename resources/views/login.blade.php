<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4B0082, #006400);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background 0.5s ease;
        }

        .login-card {
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-title {
            font-weight: bold;
            color: #4B0082;
            text-align: center;
            margin-bottom: 20px;
        }

        .goblin-logo {
            width: 60px;
            display: block;
            margin: 0 auto 10px;
            filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
        }

        .form-label {
            font-weight: 600;
            color: #4B0082;
        }

        .form-control:focus {
            border-color: #4B0082;
            box-shadow: 0 0 0 0.2rem rgba(75, 0, 130, 0.25);
        }

        .btn-primary {
            background-color: #006400;
            border: none;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #228B22;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: none;
            border-left: 5px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: none;
            border-left: 5px solid #dc3545;
        }

        a {
            color: #4B0082;
            text-decoration: underline;
        }

        a:hover {
            color: #228B22;
        }

        /* Dark mode */
        body.dark-mode {
            background: #121212;
        }

        body.dark-mode .login-card {
            background-color: #1e1e1e;
            color: #eee;
        }

        body.dark-mode .form-label {
            color: #b0b0ff;
        }

        body.dark-mode a {
            color: #90ee90;
        }

        .dark-toggle {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255,255,255,0.3);
            border: none;
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .dark-toggle:hover {
            background: rgba(255,255,255,0.6);
        }
    </style>
</head>
<body>
    <!-- Dark mode toggle -->
    <button class="dark-toggle" onclick="toggleDarkMode()">🌙</button>

    <div class="login-card">
        <img src="{{ asset('./logopartial.jpg') }}" alt="Goblin Icon" class="goblin-logo">
        <h2 class="login-title">Login</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="mt-4 text-center">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div> 
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>
</body>
</html>
