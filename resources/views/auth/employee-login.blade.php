<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher & Staff Portal Login | EduSuite</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #10b981;
            --bg-dark: #0f172a;
            --card-bg: rgba(255, 255, 255, 0.96);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #0f172a 60%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient glowing background circles */
        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.25;
            pointer-events: none;
            z-index: 0;
        }
        .glow-1 {
            width: 420px;
            height: 420px;
            background: #10b981;
            top: -100px;
            left: -100px;
        }
        .glow-2 {
            width: 380px;
            height: 380px;
            background: #06b6d4;
            bottom: -80px;
            right: -80px;
        }

        .auth-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.2);
            padding: 40px 34px;
            backdrop-filter: blur(16px);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(5, 150, 105, 0.08);
            border: 1px solid rgba(5, 150, 105, 0.15);
            padding: 6px 14px;
            border-radius: 9999px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .auth-desc {
            font-size: 13.5px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom .field-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
            z-index: 4;
            transition: color 0.2s;
        }

        .form-control-custom {
            width: 100%;
            height: 48px;
            padding: 10px 42px 10px 42px;
            font-size: 14px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background-color: #f8fafc;
            color: #0f172a;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control-custom:focus {
            outline: none;
            background-color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }

        .form-control-custom:focus + .field-icon,
        .input-group-custom:focus-within .field-icon {
            color: var(--primary);
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #94a3b8;
            padding: 6px;
            cursor: pointer;
            z-index: 5;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: #334155;
        }

        .btn-portal-submit {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 14.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.4);
            transition: all 0.25s ease;
            cursor: pointer;
            margin-top: 24px;
        }

        .btn-portal-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px -5px rgba(5, 150, 105, 0.5);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }

        .portal-switch-links {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .portal-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .portal-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="brand-badge">
                <i class="fas fa-chalkboard-user"></i>
                <span>Faculty & Staff Portal</span>
            </div>

            <h1 class="auth-title">Faculty Portal Sign In</h1>
            <p class="auth-desc">Access class schedules, attendance marking, student assignments, grading and staff payroll.</p>

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mb-3" style="font-size: 13px; border-radius: 10px;">
                    <i class="fas fa-circle-exclamation text-danger"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3" style="font-size: 13px; border-radius: 10px;">
                    <i class="fas fa-circle-check text-success"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('employee.login') }}">
                @csrf

                <!-- Email or Phone -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address or Phone</label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="text" class="form-control-custom @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="staff@school.edu or +92 300 1234567" required autofocus autocomplete="username">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                    </div>
                    <div class="input-group-custom">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" class="form-control-custom @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password', this)" title="Show/Hide Password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                        <label class="form-check-label text-muted" for="remember" style="font-size: 12.5px;">
                            Remember my login
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-portal-submit">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Log In to Faculty Portal</span>
                </button>
            </form>

            <!-- Footer Switch Navigation -->
            <div class="portal-switch-links">
                <a href="{{ url('/') }}" class="portal-link">
                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                </a>
                <a href="{{ route('student.login') }}" class="portal-link">
                    <i class="fas fa-user-graduate me-1"></i> Student Portal
                </a>
            </div>

        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
