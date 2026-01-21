<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MedReminder</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #3D0000 0%, #7B0000 50%, #5C0000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Animated Background Elements */
        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-shapes::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            animation: float 20s infinite ease-in-out;
        }

        .bg-shapes::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            animation: float 15s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(30px, -30px) rotate(10deg); }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo Section */
        .login-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .login-logo-icon i {
            font-size: 36px;
            color: white;
        }

        .login-logo h1 {
            font-size: 32px;
            font-weight: 900;
            color: white;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .login-logo p {
            color: rgba(255,255,255,0.8);
            font-size: 15px;
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
        }

        .login-card h2 {
            font-size: 24px;
            font-weight: 800;
            color: #1E1E1E;
            margin-bottom: 8px;
            text-align: center;
        }

        .login-card .subtitle {
            color: #5C4545;
            font-size: 14px;
            text-align: center;
            margin-bottom: 32px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3D0000;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8B7373;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: 2px solid #E8D5D5;
            border-radius: 12px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #7B0000;
            box-shadow: 0 0 0 4px rgba(123, 0, 0, 0.1);
        }

        .form-input:focus + i,
        .input-wrapper:focus-within i {
            color: #7B0000;
        }

        .form-input::placeholder {
            color: #B8A0A0;
        }

        /* Password Input - extra right padding for toggle button */
        .password-input {
            padding-right: 52px !important;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.8);
            border: none;
            color: #8B7373;
            cursor: pointer;
            padding: 8px;
            transition: all 0.3s ease;
            z-index: 10;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .password-toggle:hover {
            color: #7B0000;
            background: rgba(123, 0, 0, 0.05);
        }

        .password-toggle:active {
            transform: translateY(-50%) scale(0.95);
        }

        .password-toggle i {
            font-size: 16px;
            pointer-events: none;
        }

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #7B0000;
            cursor: pointer;
        }

        .remember-me span {
            font-size: 14px;
            color: #5C4545;
        }

        .forgot-password {
            color: #7B0000;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #5C0000;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 18px 32px;
            background: linear-gradient(135deg, #7B0000 0%, #5C0000 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #9B0000 0%, #7B0000 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(123, 0, 0, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Error Messages */
        .error-message {
            background: #FEE2E2;
            color: #991B1B;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-message i {
            font-size: 18px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E8D5D5;
        }

        .divider span {
            padding: 0 16px;
            color: #8B7373;
            font-size: 13px;
            font-weight: 500;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            padding-top: 8px;
        }

        .register-link p {
            color: #5C4545;
            font-size: 14px;
        }

        .register-link a {
            color: #7B0000;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #5C0000;
            text-decoration: underline;
        }

        /* Demo Credentials Box */
        .demo-box {
            background: linear-gradient(135deg, rgba(123, 0, 0, 0.08), rgba(123, 0, 0, 0.04));
            border: 1px solid rgba(123, 0, 0, 0.15);
            border-radius: 12px;
            padding: 16px;
            margin-top: 24px;
        }

        .demo-box h4 {
            font-size: 12px;
            font-weight: 700;
            color: #7B0000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-box p {
            font-size: 13px;
            color: #5C4545;
            margin-bottom: 4px;
        }

        .demo-box code {
            background: rgba(123, 0, 0, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            color: #7B0000;
        }

        /* Responsive */
        @media (max-width: 520px) {
            .login-card {
                padding: 32px 24px;
            }

            .login-logo h1 {
                font-size: 26px;
            }

            .form-options {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="bg-shapes"></div>
    
    <div class="login-container">
        <div class="login-logo">
            <div class="login-logo-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <h1>MedReminder</h1>
            <p>Sistem Pengingat Minum Obat Pasien Hipertensi</p>
        </div>
        
        <div class="login-card">
            <h2>Selamat Datang! 👋</h2>
            <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>
            
            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="error-message" style="background: #ECFDF5; color: #065F46;">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" 
                               name="email" 
                               class="form-input" 
                               placeholder="contoh@email.com"
                               value="{{ old('email') }}"
                               required 
                               autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" 
                               name="password" 
                               class="form-input password-input" 
                               id="password"
                               placeholder="Masukkan password Anda"
                               required>
                        <i class="fas fa-lock"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk
                </button>
            </form>
            
            <div class="divider">
                <span>atau</span>
            </div>
            
            <div class="register-link">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
            </div>
            
            <div class="demo-box">
                <h4><i class="fas fa-info-circle"></i> Demo Account</h4>
                <p><strong>Admin:</strong> <code>admin@medreminder.com</code></p>
                <p><strong>Pasien:</strong> <code>budi.santoso@email.com</code></p>
                <p><strong>Password:</strong> <code>password</code></p>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
