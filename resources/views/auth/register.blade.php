<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MedReminder</title>
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
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        .bg-circle:nth-child(1) {
            width: 500px;
            height: 500px;
            top: -150px;
            left: -150px;
            animation: pulse-slow 8s infinite;
        }

        .bg-circle:nth-child(2) {
            width: 300px;
            height: 300px;
            bottom: 10%;
            right: 45%;
            animation: pulse-slow 10s infinite reverse;
        }

        .bg-circle:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 40%;
            left: 30%;
            animation: pulse-slow 12s infinite;
        }

        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }

        /* Layout */
        .register-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Left Side - Info Panel */
        .info-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            color: white;
            position: relative;
        }

        .info-panel-content {
            max-width: 500px;
            animation: fadeInLeft 0.8s ease-out;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 48px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .brand-icon i {
            font-size: 28px;
            color: white;
        }

        .brand-text h1 {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }

        .brand-text p {
            font-size: 13px;
            opacity: 0.8;
        }

        .info-panel h2 {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .info-panel .subtitle {
            font-size: 17px;
            opacity: 0.9;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .features-list {
            list-style: none;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            font-size: 15px;
            opacity: 0.95;
        }

        .features-list li i {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* Right Side - Form Panel */
        .form-panel {
            width: 580px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            animation: fadeInRight 0.8s ease-out;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-content {
            width: 100%;
            max-width: 440px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: #1E1E1E;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #5C4545;
            font-size: 14px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3D0000;
            margin-bottom: 8px;
        }

        .form-label span {
            color: #EF4444;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8B7373;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #E8D5D5;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #7B0000;
            box-shadow: 0 0 0 3px rgba(123, 0, 0, 0.1);
        }

        .form-input:focus ~ .input-icon {
            color: #7B0000;
        }

        .form-input::placeholder {
            color: #B8A0A0;
        }

        .form-select {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #E8D5D5;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%238B7373' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 20px;
        }

        .form-select:focus {
            outline: none;
            border-color: #7B0000;
            box-shadow: 0 0 0 3px rgba(123, 0, 0, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-error {
            color: #EF4444;
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 8px;
        }

        .strength-bar {
            height: 4px;
            background: #E8D5D5;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 11px;
            margin-top: 4px;
            color: #8B7373;
        }

        /* Terms Checkbox */
        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 24px 0;
        }

        .terms-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #7B0000;
            cursor: pointer;
            margin-top: 2px;
        }

        .terms-checkbox label {
            font-size: 13px;
            color: #5C4545;
            line-height: 1.5;
        }

        .terms-checkbox a {
            color: #7B0000;
            font-weight: 600;
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-register {
            width: 100%;
            padding: 16px 32px;
            background: linear-gradient(135deg, #7B0000 0%, #5C0000 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #9B0000 0%, #7B0000 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(123, 0, 0, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #E8D5D5;
        }

        .login-link p {
            color: #5C4545;
            font-size: 14px;
        }

        .login-link a {
            color: #7B0000;
            font-weight: 700;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Error Alert */
        .error-alert {
            background: #FEE2E2;
            color: #991B1B;
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .error-alert i {
            font-size: 18px;
            margin-top: 1px;
        }

        .error-alert ul {
            margin: 0;
            padding-left: 16px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .info-panel {
                display: none;
            }

            .form-panel {
                width: 100%;
                padding: 40px 20px;
            }

            .register-container {
                background: linear-gradient(135deg, #3D0000 0%, #7B0000 50%, #5C0000 100%);
            }

            .form-panel {
                background: transparent;
            }

            .form-content {
                background: white;
                padding: 40px 30px;
                border-radius: 24px;
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            }
        }

        @media (max-width: 520px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-content {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-decoration">
        <div class="bg-circle"></div>
        <div class="bg-circle"></div>
        <div class="bg-circle"></div>
    </div>

    <div class="register-container">
        <!-- Left Info Panel -->
        <div class="info-panel">
            <div class="info-panel-content">
                <div class="brand-logo">
                    <div class="brand-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="brand-text">
                        <h1>MedReminder</h1>
                        <p>Pengingat Obat Hipertensi</p>
                    </div>
                </div>
                
                <h2>Jaga Kesehatan Anda dengan Disiplin Minum Obat</h2>
                <p class="subtitle">
                    Bergabunglah dengan ribuan pasien hipertensi yang telah meningkatkan 
                    kepatuhan minum obat mereka dengan sistem pengingat otomatis kami.
                </p>
                
                <ul class="features-list">
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Pengingat otomatis via email sebelum jadwal minum obat</span>
                    </li>
                    <li>
                        <i class="fas fa-chart-line"></i>
                        <span>Pantau kepatuhan dan riwayat pengobatan Anda</span>
                    </li>
                    <li>
                        <i class="fas fa-user-md"></i>
                        <span>Terhubung dengan tenaga kesehatan untuk monitoring</span>
                    </li>
                    <li>
                        <i class="fas fa-shield-alt"></i>
                        <span>Data kesehatan Anda aman dan terlindungi</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Right Form Panel -->
        <div class="form-panel">
            <div class="form-content">
                <div class="form-header">
                    <h2>Buat Akun Baru ✨</h2>
                    <p>Isi form berikut untuk mendaftar sebagai pasien</p>
                </div>
                
                @if ($errors->any())
                    <div class="error-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span>*</span></label>
                        <div class="input-wrapper">
                            <input type="text" 
                                   name="name" 
                                   class="form-input" 
                                   placeholder="Masukkan nama lengkap"
                                   value="{{ old('name') }}"
                                   required>
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email <span>*</span></label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   name="email" 
                                   class="form-input" 
                                   placeholder="contoh@email.com"
                                   value="{{ old('email') }}"
                                   required>
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <div class="input-wrapper">
                            <input type="tel" 
                                   name="phone" 
                                   class="form-input" 
                                   placeholder="08xxxxxxxxxx"
                                   value="{{ old('phone') }}">
                            <i class="fas fa-phone input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <div class="input-wrapper">
                                <input type="date" 
                                       name="birth_date" 
                                       class="form-input" 
                                       style="padding-left: 16px;"
                                       value="{{ old('birth_date') }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="input-wrapper">
                                <select name="gender" class="form-select" style="padding-left: 16px;">
                                    <option value="">Pilih</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <div class="input-wrapper">
                            <input type="text" 
                                   name="address" 
                                   class="form-input" 
                                   placeholder="Alamat lengkap"
                                   value="{{ old('address') }}"
                                   style="padding-left: 46px;">
                            <i class="fas fa-map-marker-alt input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password <span>*</span></label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       name="password" 
                                       class="form-input" 
                                       id="password"
                                       placeholder="Min. 8 karakter"
                                       required>
                                <i class="fas fa-lock input-icon"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Konfirmasi <span>*</span></label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="form-input" 
                                       placeholder="Ulangi password"
                                       required>
                                <i class="fas fa-lock input-icon"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="terms-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan 
                            <a href="#">Kebijakan Privasi</a> MedReminder
                        </label>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        Daftar Sekarang
                    </button>
                </form>
                
                <div class="login-link">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
