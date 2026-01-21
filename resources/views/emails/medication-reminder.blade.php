<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⏰ Pengingat Minum Obat - MedReminder</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #FDF5F5;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #FDF5F5;
            padding: 40px 20px;
        }
        .email-container {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(123, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #7B0000 0%, #5C0000 100%);
            padding: 40px 32px;
            text-align: center;
        }
        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 16px;
        }
        .header-title {
            color: white;
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 8px 0;
        }
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 0;
        }
        .email-body {
            padding: 40px 32px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1E1E1E;
            margin: 0 0 24px 0;
        }
        .reminder-box {
            background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
            border-left: 4px solid #F59E0B;
            border-radius: 16px;
            padding: 24px;
            margin: 24px 0;
        }
        .reminder-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 16px;
        }
        .reminder-title {
            font-size: 20px;
            font-weight: 800;
            color: #92400E;
            text-align: center;
            margin: 0 0 8px 0;
        }
        .reminder-time {
            font-size: 36px;
            font-weight: 900;
            color: #7B0000;
            text-align: center;
            margin: 8px 0;
        }
        .medicine-card {
            background: #F5E6E6;
            border-radius: 16px;
            padding: 24px;
            margin: 24px 0;
        }
        .medicine-name {
            font-size: 22px;
            font-weight: 800;
            color: #7B0000;
            margin: 0 0 16px 0;
        }
        .medicine-detail {
            display: flex;
            align-items: flex-start;
            margin: 12px 0;
            font-size: 15px;
            color: #5C4545;
        }
        .medicine-detail strong {
            min-width: 120px;
            font-weight: 700;
            color: #3D0000;
        }
        .instructions-box {
            background: #EFF6FF;
            border-left: 4px solid #3B82F6;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
        }
        .instructions-title {
            font-size: 14px;
            font-weight: 700;
            color: #1E40AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 12px 0;
        }
        .instructions-text {
            font-size: 15px;
            color: #1E3A8A;
            margin: 0;
            line-height: 1.6;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #7B0000 0%, #5C0000 100%);
            color: white;
            text-decoration: none;
            padding: 18px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            margin: 24px 0;
            text-align: center;
        }
        .footer-note {
            background: #ECFDF5;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
            font-size: 14px;
            color: #065F46;
            line-height: 1.6;
        }
        .email-footer {
            background: #FDF5F5;
            padding: 32px;
            text-align: center;
            font-size: 13px;
            color: #8B7373;
            line-height: 1.6;
        }
        .divider {
            height: 2px;
            background: #E8D5D5;
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <div class="logo-icon">💊</div>
                <h1 class="header-title">MedReminder</h1>
                <p class="header-subtitle">Pengingat Minum Obat</p>
            </div>

            <!-- Body -->
            <div class="email-body">
                <p class="greeting">Halo, {{ $user->name }} 👋</p>

                <!-- Reminder Box -->
                <div class="reminder-box">
                    <div class="reminder-icon">⏰</div>
                    <h2 class="reminder-title">SAATNYA MINUM OBAT!</h2>
                    <div class="reminder-time">{{ $scheduledTime }}</div>
                    <p style="text-align: center; color: #92400E; margin: 8px 0 0 0; font-size: 14px;">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                <p style="font-size: 15px; color: #5C4545; line-height: 1.6; margin: 24px 0;">
                    Ini adalah pengingat bahwa Anda memiliki jadwal minum obat dalam <strong>30 menit</strong>.
                    Pastikan Anda meminum obat tepat waktu untuk hasil pengobatan yang optimal.
                </p>

                <!-- Medicine Card -->
                <div class="medicine-card">
                    <h3 class="medicine-name">💊 {{ $schedule->medicine->name }}</h3>

                    <div class="medicine-detail">
                        <strong>Dosis:</strong>
                        <span>{{ $schedule->dosage }}</span>
                    </div>

                    <div class="medicine-detail">
                        <strong>Kekuatan:</strong>
                        <span>{{ $schedule->medicine->strength }}</span>
                    </div>

                    <div class="medicine-detail">
                        <strong>Bentuk:</strong>
                        <span>{{ $schedule->medicine->dosage_form }}</span>
                    </div>

                    <div class="medicine-detail">
                        <strong>Frekuensi:</strong>
                        <span>{{ $schedule->frequency_per_day }}x sehari</span>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="instructions-box">
                    <h4 class="instructions-title">📋 Petunjuk Penggunaan</h4>
                    <p class="instructions-text">{{ $schedule->instruction }}</p>
                </div>

                @if($schedule->notes)
                    <div style="background: #FEE2E2; border-left: 4px solid #EF4444; border-radius: 12px; padding: 20px; margin: 24px 0;">
                        <h4 style="font-size: 14px; font-weight: 700; color: #991B1B; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0;">
                            ⚠️ CATATAN PENTING
                        </h4>
                        <p style="font-size: 15px; color: #7F1D1D; margin: 0; line-height: 1.6;">
                            {{ $schedule->notes }}
                        </p>
                    </div>
                @endif

                <div class="divider"></div>

                <!-- CTA Button -->
                <div style="text-align: center;">
                    <a href="{{ url('/patient/dashboard') }}" class="cta-button">
                        Buka Dashboard Saya
                    </a>
                </div>

                <!-- Footer Note -->
                <div class="footer-note">
                    <strong>💡 Tips:</strong> Tandai obat sebagai sudah diminum di dashboard setelah Anda mengonsumsinya.
                    Ini membantu tenaga kesehatan memantau kepatuhan pengobatan Anda.
                </div>

                <p style="font-size: 14px; color: #8B7373; line-height: 1.6; margin: 24px 0 0 0;">
                    Jika Anda memiliki pertanyaan atau mengalami efek samping, segera hubungi tenaga kesehatan Anda.
                </p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <strong style="color: #5C4545;">MedReminder</strong><br>
                Sistem Pengingat Minum Obat Pasien Hipertensi<br>
                <br>
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.<br>
                <br>
                <small>© {{ date('Y') }} MedReminder. All rights reserved.</small>
            </div>
        </div>
    </div>
</body>
</html>
