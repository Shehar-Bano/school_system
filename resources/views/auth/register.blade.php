<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Account | EduSuite School Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assesst/css/front-landing.css') }}?v={{ time() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            background-color: var(--light-bg);
            position: relative;
        }
        .standalone-auth-box {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 2;
        }
        .back-to-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: color 0.2s ease;
        }
        .back-to-home:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <div class="mesh-bg">
        <div class="mesh-circle mesh-1"></div>
        <div class="mesh-circle mesh-2"></div>
        <div class="mesh-circle mesh-3"></div>
    </div>

    <div class="standalone-auth-box">
        <a href="{{ url('/') }}" class="back-to-home">
            <i class="fas fa-arrow-left"></i> Return to School Portal Home
        </a>

        <div class="auth-container-card">
            <div class="auth-header-tabs">
                <a href="{{ route('login') }}" class="auth-tab-btn" style="text-decoration: none;">
                    <i class="fas fa-lock"></i> Sign In
                </a>
                <button type="button" class="auth-tab-btn active">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>

            <div class="auth-card-body">
                @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center gap-2 p-2 mb-3" style="font-size: 12.5px; border-radius: 8px;">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" onsubmit="handleRegisterSubmit(event)">
                    @csrf

                    <div class="form-floating-custom">
                        <label for="regName">Full Name</label>
                        <div class="input-icon-wrap">
                            <input type="text" class="form-control-custom" id="regName" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus autocomplete="name">
                            <i class="fas fa-user field-icon"></i>
                        </div>
                    </div>

                    <div class="form-floating-custom">
                        <label for="regEmail">Email Address</label>
                        <div class="input-icon-wrap">
                            <input type="email" class="form-control-custom" id="regEmail" name="email" value="{{ old('email') }}" placeholder="student@school.com" required autocomplete="username">
                            <i class="fas fa-envelope field-icon"></i>
                        </div>
                    </div>

                    <div class="form-floating-custom">
                        <label for="regUserType">Account Role</label>
                        <div class="input-icon-wrap">
                            <select class="form-control-custom" id="regUserType" name="usertype" style="padding-left: 40px; cursor: pointer;">
                                <option value="student">Student / Guardian</option>
                                <option value="employee">Teacher / Faculty Staff</option>
                                <option value="admin">School Administrator</option>
                            </select>
                            <i class="fas fa-id-badge field-icon"></i>
                        </div>
                    </div>

                    <div class="form-floating-custom">
                        <label for="regPassword">Password</label>
                        <div class="input-icon-wrap">
                            <input type="password" class="form-control-custom" id="regPassword" name="password" placeholder="Create strong password" required autocomplete="new-password">
                            <i class="fas fa-lock field-icon"></i>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('regPassword', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-floating-custom">
                        <label for="regPasswordConfirmation">Confirm Password</label>
                        <div class="input-icon-wrap">
                            <input type="password" class="form-control-custom" id="regPasswordConfirmation" name="password_confirmation" placeholder="Repeat password" required autocomplete="new-password">
                            <i class="fas fa-shield-check field-icon"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="custom-checkbox" for="regTerms">
                            <input id="regTerms" type="checkbox" required checked>
                            <span style="font-size: 11.5px;">I agree to the Academic Policies and Terms.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-auth-submit" id="regSubmitBtn">
                        <span class="btn-text"><i class="fas fa-user-plus me-1"></i> Register Account</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>

                <div class="auth-switch-footer">
                    <span>Already registered?</span>
                    <a href="{{ route('login') }}">Sign In to Portal</a>
                </div>
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

        function handleRegisterSubmit(event) {
            const btn = document.getElementById('regSubmitBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;
        }
    </script>
</body>
</html>
