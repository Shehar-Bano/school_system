<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url({{asset('assesst/images/image.png')}}); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .login-form {
            background: rgba(0, 0, 0, 0.6); /* Transparent background */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            color: #fff;
        }
        .login-form h4 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form input[type="email"],
        .login-form input[type="text"],
        .login-form input[type="password"] {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid #ccc;
        }
        .login-form input::placeholder {
            color: #ccc;
        }
        .btn-primary {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 10px 20px;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #ccc;
        }
        .form-check-label, .forgot-password, .register-link {
            color: #ccc;
        }
        .register-link:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<div class="login-form col-md-4">
    <h4>Student Login</h4>
    <form method="POST" action="{{ route('student.login') }}">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Enter your UserName</label>
            <input type="text" class="form-control" name="username" placeholder="UserName" required>
        </div>
        <div class="mb-3">
            <label for="registration" class="form-label">Enter your registration number</label>
            <input type="text" class="form-control" name="registration" placeholder="Registration No" required>
        </div>

        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
    <div class="text-center mt-3">
        <a href="#" class="register-link">Don't have an account? Register</a>
    </div>
</div>

</body>
</html>
