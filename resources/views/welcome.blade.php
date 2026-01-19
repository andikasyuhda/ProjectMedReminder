<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedReminder - Sistem Pengingat Minum Obat Pasien Hipertensi</title>
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
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .bg-animation::before,
        .bg-animation::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            animation: float 20s infinite ease-in-out;
        }

        .bg-animation::before {
            width: 500px;
            height: 500px;
            top: -150px;
            right: -150px;
        }

        .bg-animation::after {
            width: 400px;
            height: 400px;
            bottom: -100px;
            left: -100px;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.05); }
        }

        /* Landing Container */
        .landing-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1000px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Landing Box */
        .landing-box {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 32px;
            padding: 60px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.4);
        }

        /* Header Section */
        .landing-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .landing-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #7B0000, #5C0000);
            border-radius: 24px;
            margin: 0 auto 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 40px rgba(123, 0, 0, 0.3);
        }

        .landing-icon i {
            font-size: 48px;
            color: white;
        }

        .landing-title {
            font-size: 42px;
            font-weight: 900;
            color: #1E1E1E;
            margin-bottom: 12px;
            letter-spacing: -1px;
        }

        .landing-desc {
            color: #5C4545;
            font-size: 17px;
            line-height: 1.7;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Role Grid */
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            margin-top: 48px;
        }

        .role-card {
            padding: 40px;
            border: 3px solid #E8D5D5;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(123, 0, 0, 0.05), rgba(123, 0, 0, 0));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .role-card:hover {
            border-color: #7B0000;
            box-shadow: 0 20px 50px rgba(123, 0, 0, 0.15);
            transform: translateY(-8px);
        }

        .role-card:hover::before {
            opacity: 1;
        }

        .role-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .role-card:first-child .role-icon {
            background: linear-gradient(135deg, #7B0000, #5C0000);
        }

        .role-card:last-child .role-icon {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .role-icon i {
            font-size: 32px;
            color: white;
        }

        .role-title {
            font-size: 24px;
            font-weight: 800;
            color: #1E1E1E;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .role-desc {
            color: #5C4545;
            font-size: 14px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .role-arrow {
            margin-top: 20px;
            color: #7B0000;
            font-size: 20px;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .role-card:hover .role-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        /* Features */
        .features-section {
            margin-top: 48px;
            padding-top: 40px;
            border-top: 2px solid #F0E0E0;
        }

        .features-title {
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: #8B7373;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 24px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .feature-item {
            text-align: center;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, rgba(123, 0, 0, 0.1), rgba(123, 0, 0, 0.05));
            border-radius: 12px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-icon i {
            font-size: 20px;
            color: #7B0000;
        }

        .feature-text {
            font-size: 13px;
            font-weight: 600;
            color: #5C4545;
        }

        /* Footer */
        .landing-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #F0E0E0;
        }

        .landing-footer p {
            font-size: 13px;
            color: #8B7373;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .landing-box {
                padding: 40px 24px;
            }

            .landing-title {
                font-size: 28px;
            }

            .role-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="landing-container">
        <div class="landing-box">
            <div class="landing-header">
                <div class="landing-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h1 class="landing-title">MedReminder</h1>
                <p class="landing-desc">
                    Sistem Pengingat Minum Obat Berbasis Web untuk Pasien Hipertensi<br>
                    dengan Notifikasi Email Otomatis dan Monitoring Real-Time
                </p>
            </div>
            
            <div class="role-grid">
                <a href="{{ route('login') }}" class="role-card">
                    <div class="role-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="role-title">Portal Pasien</div>
                    <div class="role-desc">
                        Lihat jadwal minum obat, checklist kepatuhan, dan pantau riwayat pengobatan Anda
                    </div>
                    <div class="role-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('login') }}" class="role-card">
                    <div class="role-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="role-title">Portal Tenaga Kesehatan</div>
                    <div class="role-desc">
                        Kelola pasien, atur jadwal obat, monitoring kepatuhan, dan konfigurasi reminder
                    </div>
                    <div class="role-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            
            <div class="features-section">
                <div class="features-title">Fitur Unggulan</div>
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="feature-text">Email Reminder Otomatis</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">Monitoring Real-Time</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="feature-text">Penjadwalan Otomatis</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">Data Aman & Terlindungi</div>
                    </div>
                </div>
            </div>
            
            <div class="landing-footer">
                <p>© {{ date('Y') }} MedReminder - Sistem Pengingat Minum Obat Pasien Hipertensi</p>
            </div>
        </div>
    </div>
</body>
</html>
