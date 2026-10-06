<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign In | EduSuite School Management Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Landing CSS -->
    <link rel="stylesheet" href="{{ asset('assesst/css/front-landing.css') }}?v={{ time() }}">
    <!-- SweetAlert2 -->
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

    <!-- Background Animated Mesh -->
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
            <!-- Sliding Tabs (Sign In / Register) -->
            <div class="auth-header-tabs">
                <button type="button" class="auth-tab-btn active" id="tabLoginBtn" onclick="switchAuthTab('login')">
                    <i class="fas fa-lock"></i> Sign In
                </button>
                <button type="button" class="auth-tab-btn" id="tabRegisterBtn" onclick="switchAuthTab('register')">
                    <i class="fas fa-user-plus"></i> New here? Register
                </button>
            </div>

            <div class="auth-card-body">
                <!-- Status Messages -->
                @if (session('status'))
                    <div class="alert alert-success d-flex align-items-center gap-2 p-2 mb-3" style="font-size: 12.5px; border-radius: 8px;">
                        <i class="fas fa-check-circle"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center gap-2 p-2 mb-3" style="font-size: 12.5px; border-radius: 8px;">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <!-- 1. LOGIN FORM -->
                <div id="loginFormContainer">
                    <!-- Quick Role Switcher -->
                    <div class="role-pills">
                        <button type="button" class="role-pill-btn active" id="roleBtnAdmin" onclick="quickSelectRole('admin')">
                            <i class="fas fa-shield-halved"></i> Superadmin
                        </button>
                        <button type="button" class="role-pill-btn" id="roleBtnTeacher" onclick="quickSelectRole('teacher')">
                            <i class="fas fa-chalkboard-user"></i> Faculty
                        </button>
                        <button type="button" class="role-pill-btn" id="roleBtnStudent" onclick="quickSelectRole('student')">
                            <i class="fas fa-user-graduate"></i> Student
                        </button>
                    </div>

                    <form method="POST" action="{{ route('login') }}" id="loginForm" onsubmit="handleLoginSubmit(event)">
                        @csrf

                        <!-- Email -->
                        <div class="form-floating-custom">
                            <label for="loginEmail">Email / Username</label>
                            <div class="input-icon-wrap">
                                <input type="email" class="form-control-custom" id="loginEmail" name="email" value="{{ old('email', 'admin@admin.com') }}" placeholder="name@school.com" required autofocus autocomplete="username">
                                <i class="fas fa-envelope field-icon"></i>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-floating-custom">
                            <label for="loginPassword">Password</label>
                            <div class="input-icon-wrap">
                                <input type="password" class="form-control-custom" id="loginPassword" name="password" value="password" placeholder="Enter password" required autocomplete="current-password">
                                <i class="fas fa-lock field-icon"></i>
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('loginPassword', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot -->
                        <div class="form-options-row">
                            <label class="custom-checkbox" for="remember_me">
                                <input id="remember_me" type="checkbox" name="remember" checked>
                                <span>Remember me</span>
                            </label>

                            <a href="javascript:void(0)" class="forgot-link" onclick="openOtpWizardModal()">
                                <i class="fas fa-key me-1"></i> Forgot Password?
                            </a>
                        </div>

                        <button type="submit" class="btn-auth-submit" id="loginSubmitBtn">
                            <span class="btn-text"><i class="fas fa-arrow-right-to-bracket me-1"></i> Secure Sign In</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </form>

                    <div class="auth-switch-footer">
                        <span>New to EduSuite Portal?</span>
                        <a href="javascript:void(0)" onclick="switchAuthTab('register')">Create an Account</a>
                    </div>
                </div>

                <!-- 2. REGISTER FORM -->
                <div id="registerFormContainer" style="display: none;">
                    <form method="POST" action="{{ route('register') }}" id="registerForm" onsubmit="handleRegisterSubmit(event)">
                        @csrf

                        <div class="form-floating-custom">
                            <label for="regName">Full Name</label>
                            <div class="input-icon-wrap">
                                <input type="text" class="form-control-custom" id="regName" name="name" placeholder="John Doe" required autocomplete="name">
                                <i class="fas fa-user field-icon"></i>
                            </div>
                        </div>

                        <div class="form-floating-custom">
                            <label for="regEmail">Email Address</label>
                            <div class="input-icon-wrap">
                                <input type="email" class="form-control-custom" id="regEmail" name="email" placeholder="student@school.com" required autocomplete="email">
                                <i class="fas fa-envelope field-icon"></i>
                            </div>
                        </div>

                        <div class="form-floating-custom">
                            <label for="regUserType">Register As</label>
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
                                <input type="password" class="form-control-custom" id="regPasswordConfirmation" name="password_confirmation" placeholder="Repeat your password" required autocomplete="new-password">
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
                        <span>Already have an account?</span>
                        <a href="javascript:void(0)" onclick="switchAuthTab('login')">Sign In here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OTP WIZARD MODAL -->
    <div class="otp-wizard-modal" id="otpWizardModal">
        <div class="otp-wizard-box">
            <button type="button" class="otp-close-btn" onclick="closeOtpWizardModal()" title="Close">
                <i class="fas fa-xmark"></i>
            </button>

            <!-- Wizard Step Dots -->
            <div class="otp-step-indicator">
                <div class="otp-step-dot active" id="dotStep1">1</div>
                <div class="otp-step-line" id="lineStep1"></div>
                <div class="otp-step-dot" id="dotStep2">2</div>
                <div class="otp-step-line" id="lineStep2"></div>
                <div class="otp-step-dot" id="dotStep3">3</div>
            </div>

            <!-- STEP 1: REQUEST OTP -->
            <div id="otpStep1Container">
                <div class="text-center mb-3">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #eef2ff; color: #4f46e5; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 6px;">Reset Password</h4>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">Enter your registered email address to receive a 6-digit verification code.</p>
                </div>

                <form onsubmit="handleSendOtp(event)">
                    <div class="form-floating-custom">
                        <label for="otpEmailInput">Registered Email</label>
                        <div class="input-icon-wrap">
                            <input type="email" class="form-control-custom" id="otpEmailInput" placeholder="name@school.com" required value="admin@admin.com">
                            <i class="fas fa-envelope field-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth-submit mt-3" id="sendOtpBtn">
                        <span class="btn-text"><i class="fas fa-paper-plane me-1"></i> Send 6-Digit OTP</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>

            <!-- STEP 2: VERIFY 6-DIGIT OTP -->
            <div id="otpStep2Container" style="display: none;">
                <div class="text-center mb-2">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #ecfdf5; color: #059669; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 4px;">Enter Verification OTP</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">Code sent to <b id="otpSentEmailDisplay" class="text-primary">user@example.com</b></p>
                </div>

                <div class="otp-digit-inputs">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp1" oninput="handleOtpInput(this, 'otp2')" onkeydown="handleOtpBackspace(event, this, null)" autofocus>
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp2" oninput="handleOtpInput(this, 'otp3')" onkeydown="handleOtpBackspace(event, this, 'otp1')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp3" oninput="handleOtpInput(this, 'otp4')" onkeydown="handleOtpBackspace(event, this, 'otp2')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp4" oninput="handleOtpInput(this, 'otp5')" onkeydown="handleOtpBackspace(event, this, 'otp3')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp5" oninput="handleOtpInput(this, 'otp6')" onkeydown="handleOtpBackspace(event, this, 'otp4')">
                    <input type="text" maxlength="1" class="otp-digit-box" id="otp6" oninput="handleOtpInput(this, null)" onkeydown="handleOtpBackspace(event, this, 'otp5')">
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3" style="font-size: 12.5px;">
                    <span class="text-muted">Expires in: <strong id="otpTimerText" class="text-danger">05:00</strong></span>
                    <a href="javascript:void(0)" class="forgot-link" id="resendOtpBtn" onclick="resendOtpCode()" style="pointer-events: none; opacity: 0.5;">
                        <i class="fas fa-rotate-right me-1"></i> Resend OTP
                    </a>
                </div>

                <button type="button" class="btn-auth-submit" id="verifyOtpBtn" onclick="handleVerifyOtp()">
                    <span class="btn-text"><i class="fas fa-check-double me-1"></i> Verify OTP Code</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>

                <div class="text-center mt-3">
                    <a href="javascript:void(0)" onclick="goToOtpStep(1)" style="font-size: 12.5px; color: #64748b; text-decoration: none;">
                        <i class="fas fa-arrow-left me-1"></i> Change email address
                    </a>
                </div>
            </div>

            <!-- STEP 3: SET NEW PASSWORD -->
            <div id="otpStep3Container" style="display: none;">
                <div class="text-center mb-3">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 12px;">
                        <i class="fas fa-key"></i>
                    </div>
                    <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 4px;">Set New Password</h4>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">Create a strong new password for your account.</p>
                </div>

                <form onsubmit="handleResetPasswordSubmit(event)">
                    <div class="form-floating-custom">
                        <label for="newPasswordInput">New Password</label>
                        <div class="input-icon-wrap">
                            <input type="password" class="form-control-custom" id="newPasswordInput" placeholder="Min. 8 characters" required oninput="checkPasswordStrength(this.value)">
                            <i class="fas fa-lock field-icon"></i>
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPasswordInput', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="pwStrengthFill"></div>
                        </div>
                    </div>

                    <div class="form-floating-custom">
                        <label for="newPasswordConfirmInput">Confirm New Password</label>
                        <div class="input-icon-wrap">
                            <input type="password" class="form-control-custom" id="newPasswordConfirmInput" placeholder="Repeat new password" required>
                            <i class="fas fa-shield-check field-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth-submit mt-3" id="savePasswordBtn">
                        <span class="btn-text"><i class="fas fa-floppy-disk me-1"></i> Update & Log In</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function switchAuthTab(tab) {
            const loginBtn = document.getElementById('tabLoginBtn');
            const regBtn = document.getElementById('tabRegisterBtn');
            const loginContainer = document.getElementById('loginFormContainer');
            const regContainer = document.getElementById('registerFormContainer');

            if (tab === 'login') {
                loginBtn.classList.add('active');
                regBtn.classList.remove('active');
                loginContainer.style.display = 'block';
                regContainer.style.display = 'none';
            } else {
                regBtn.classList.add('active');
                loginBtn.classList.remove('active');
                regContainer.style.display = 'block';
                loginContainer.style.display = 'none';
            }
        }

        function quickSelectRole(role) {
            document.querySelectorAll('.role-pill-btn').forEach(btn => btn.classList.remove('active'));
            const emailInput = document.getElementById('loginEmail');
            const passwordInput = document.getElementById('loginPassword');

            if (role === 'admin') {
                document.getElementById('roleBtnAdmin').classList.add('active');
                emailInput.value = 'admin@admin.com';
                passwordInput.value = 'password';
            } else if (role === 'teacher') {
                document.getElementById('roleBtnTeacher').classList.add('active');
                emailInput.value = 'teacher@school.com';
                passwordInput.value = 'password';
            } else if (role === 'student') {
                document.getElementById('roleBtnStudent').classList.add('active');
                emailInput.value = 'student@school.com';
                passwordInput.value = 'password';
            }
        }

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

        function handleLoginSubmit(event) {
            const btn = document.getElementById('loginSubmitBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;
        }

        function handleRegisterSubmit(event) {
            const btn = document.getElementById('regSubmitBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;
        }

        // OTP WIZARD JS
        let currentOtpEmail = '';
        let currentResetToken = '';
        let otpCountdownInterval = null;
        let otpSecondsRemaining = 300;

        function openOtpWizardModal() {
            const modal = document.getElementById('otpWizardModal');
            const loginEmail = document.getElementById('loginEmail').value.trim();
            if (loginEmail) {
                document.getElementById('otpEmailInput').value = loginEmail;
            }
            goToOtpStep(1);
            modal.classList.add('active');
        }

        function closeOtpWizardModal() {
            document.getElementById('otpWizardModal').classList.remove('active');
            if (otpCountdownInterval) clearInterval(otpCountdownInterval);
        }

        function goToOtpStep(step) {
            document.getElementById('otpStep1Container').style.display = step === 1 ? 'block' : 'none';
            document.getElementById('otpStep2Container').style.display = step === 2 ? 'block' : 'none';
            document.getElementById('otpStep3Container').style.display = step === 3 ? 'block' : 'none';

            const dot1 = document.getElementById('dotStep1');
            const dot2 = document.getElementById('dotStep2');
            const dot3 = document.getElementById('dotStep3');
            const line1 = document.getElementById('lineStep1');
            const line2 = document.getElementById('lineStep2');

            dot1.className = 'otp-step-dot' + (step >= 1 ? (step > 1 ? ' completed' : ' active') : '');
            line1.className = 'otp-step-line' + (step >= 2 ? ' active' : '');
            dot2.className = 'otp-step-dot' + (step >= 2 ? (step > 2 ? ' completed' : ' active') : '');
            line2.className = 'otp-step-line' + (step >= 3 ? ' active' : '');
            dot3.className = 'otp-step-dot' + (step === 3 ? ' active' : '');
        }

        async function handleSendOtp(event) {
            event.preventDefault();
            const email = document.getElementById('otpEmailInput').value.trim();
            if (!email) return;

            const btn = document.getElementById('sendOtpBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("password.otp.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    currentOtpEmail = email;
                    document.getElementById('otpSentEmailDisplay').innerText = email;

                    if (data.demo_otp) {
                        Swal.fire({
                            icon: 'info',
                            title: 'OTP Code Generated',
                            html: `<p>A 6-digit OTP code has been dispatched:</p><h2 style="letter-spacing: 4px; color: #4f46e5; font-weight: 800;">${data.demo_otp}</h2><p class="text-muted" style="font-size:12px;">(Simulated for instant testing)</p>`,
                            confirmButtonColor: '#4f46e5',
                            confirmButtonText: 'Auto-fill OTP'
                        }).then((result) => {
                            if (result.isConfirmed) fillOtpDigits(data.demo_otp);
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Dispatched!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }

                    goToOtpStep(2);
                    startOtpCountdown();
                    setTimeout(() => document.getElementById('otp1').focus(), 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: data.message || 'Unable to send OTP. Please check your email.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to connect to server. Please try again.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.spinner-border').classList.add('d-none');
                btn.disabled = false;
            }
        }

        function fillOtpDigits(code) {
            const digits = code.toString().split('');
            for (let i = 0; i < 6; i++) {
                const input = document.getElementById(`otp${i+1}`);
                if (input && digits[i]) input.value = digits[i];
            }
        }

        function handleOtpInput(current, nextId) {
            current.value = current.value.replace(/[^0-9]/g, '');
            if (current.value.length === 1 && nextId) {
                document.getElementById(nextId).focus();
            }
        }

        function handleOtpBackspace(event, current, prevId) {
            if (event.key === 'Backspace' && !current.value && prevId) {
                document.getElementById(prevId).focus();
            }
        }

        function startOtpCountdown() {
            if (otpCountdownInterval) clearInterval(otpCountdownInterval);
            otpSecondsRemaining = 300;
            const timerText = document.getElementById('otpTimerText');
            const resendBtn = document.getElementById('resendOtpBtn');
            resendBtn.style.pointerEvents = 'none';
            resendBtn.style.opacity = '0.5';

            otpCountdownInterval = setInterval(() => {
                otpSecondsRemaining--;
                const mins = Math.floor(otpSecondsRemaining / 60);
                const secs = otpSecondsRemaining % 60;
                timerText.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;

                if (otpSecondsRemaining <= 0) {
                    clearInterval(otpCountdownInterval);
                    timerText.innerText = 'Expired';
                    resendBtn.style.pointerEvents = 'auto';
                    resendBtn.style.opacity = '1';
                }
            }, 1000);
        }

        function resendOtpCode() {
            handleSendOtp(new Event('submit'));
        }

        async function handleVerifyOtp() {
            let otp = '';
            for (let i = 1; i <= 6; i++) {
                otp += document.getElementById(`otp${i}`).value.trim();
            }

            if (otp.length !== 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete OTP',
                    text: 'Please enter the complete 6-digit verification code.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            const btn = document.getElementById('verifyOtpBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("password.otp.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: currentOtpEmail, otp: otp })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    currentResetToken = data.reset_token;
                    if (otpCountdownInterval) clearInterval(otpCountdownInterval);

                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Verified!',
                        text: 'Identity confirmed. Please create your new password.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    goToOtpStep(3);
                    setTimeout(() => document.getElementById('newPasswordInput').focus(), 200);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Verification Failed',
                        text: data.message || 'Invalid or expired OTP code.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to verify OTP. Please try again.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.spinner-border').classList.add('d-none');
                btn.disabled = false;
            }
        }

        function checkPasswordStrength(password) {
            const bar = document.getElementById('pwStrengthFill');
            let strength = 0;
            if (password.length >= 6) strength += 25;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9!@#$%^&*]/.test(password)) strength += 25;

            bar.style.width = strength + '%';
            if (strength <= 25) bar.style.backgroundColor = '#ef4444';
            else if (strength <= 50) bar.style.backgroundColor = '#f59e0b';
            else if (strength <= 75) bar.style.backgroundColor = '#06b6d4';
            else bar.style.backgroundColor = '#10b981';
        }

        async function handleResetPasswordSubmit(event) {
            event.preventDefault();
            const password = document.getElementById('newPasswordInput').value;
            const passwordConfirmation = document.getElementById('newPasswordConfirmInput').value;

            if (password.length < 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Short Password',
                    text: 'Password must be at least 6 characters in length.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            if (password !== passwordConfirmation) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match. Please ensure both fields are identical.',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }

            const btn = document.getElementById('savePasswordBtn');
            btn.querySelector('.btn-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("password.otp.reset") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: currentOtpEmail,
                        reset_token: currentResetToken,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    closeOtpWizardModal();

                    Swal.fire({
                        icon: 'success',
                        title: 'Password Reset Successfully!',
                        text: 'Your password has been updated. You can now log in with your new credentials.',
                        confirmButtonColor: '#4f46e5',
                        confirmButtonText: 'Proceed to Sign In'
                    }).then(() => {
                        switchAuthTab('login');
                        document.getElementById('loginEmail').value = currentOtpEmail;
                        document.getElementById('loginPassword').value = password;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Reset Failed',
                        text: data.message || 'Unable to update password. Please try again.',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Failed to update password. Please check your connection.',
                    confirmButtonColor: '#ef4444'
                });
            } finally {
                btn.querySelector('.btn-text').classList.remove('d-none');
                btn.querySelector('.spinner-border').classList.add('d-none');
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
