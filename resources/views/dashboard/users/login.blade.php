<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #21282d 0%, #00f2fe 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-page {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(166, 207, 218, 0.95);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: slideIn 0.5s ease;
            position: relative;
        }

        .login-title {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .login-subtitle {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        input {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
        }

        .input-group i {
            margin-right: 6px;
            color: #007bff;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background: linear-gradient(135deg, #21282d 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: linear-gradient(to right, #62919e, #5d7ea7);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="login-page">
        <div class="login-card">

            {{-- 👇 Error Messages Inside Card --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="login-title">Welcome Back 👋</h2>
            <p class="login-subtitle">Please login to continue</p>

            <form action="{{ route('user.login') }}" method="POST">
                @csrf

                <div class="input-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        value="{{ old('username') }}" placeholder="Enter your username" required>
                </div>

                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn-submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Optional: Auto-hide error message -->
    <script>
        setTimeout(() => {
            const alertBox = document.querySelector('.alert-danger');
            if (alertBox) alertBox.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    </script>
</body>

</html>
