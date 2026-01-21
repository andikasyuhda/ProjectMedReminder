<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⏰ Pengingat Minum Obat</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', sans-serif; background: linear-gradient(135deg, #FDF5F5 0%, #F5E6E6 100%);">

    <!-- Email Container -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #FDF5F5 0%, #F5E6E6 100%); padding: 40px 20px;">
        <tr>
            <td align="center">

                <!-- Main Card -->
                <table width="600" cellpadding="0" cellspacing="0" style="background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(123, 0, 0, 0.15); max-width: 100%;">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #7B0000 0%, #5C0000 100%); padding: 48px 40px; text-align: center;">

                            <!-- Logo Icon -->
                            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 50%; margin: 0 auto 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 40px;">
                                💊
                            </div>

                            <h1 style="margin: 0 0 8px 0; font-size: 32px; font-weight: 900; color: white; letter-spacing: -0.5px;">MedReminder</h1>
                            <p style="margin: 0; font-size: 16px; color: rgba(255,255,255,0.9);">Sistem Pengingat Obat Pintar</p>
                        </td>
                    </tr>

                    <!-- Content Area -->
                    <tr>
                        <td style="padding: 48px 40px;">

                            <!-- Greeting -->
                            <p style="margin: 0 0 32px 0; font-size: 20px; font-weight: 600; color: #1E1E1E;">
                                Halo, <span style="color: #7B0000;">{{ $user->name }}</span> 👋
                            </p>

                            <!-- Alert Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border-radius: 20px; border-left: 6px solid #F59E0B; margin-bottom: 32px;">
                                <tr>
                                    <td style="padding: 32px 28px; text-align: center;">
                                        <div style="font-size: 56px; margin-bottom: 16px;">⏰</div>
                                        <h2 style="margin: 0 0 12px 0; font-size: 24px; font-weight: 900; color: #92400E;">SAATNYA MINUM OBAT!</h2>
                                        <div style="font-size: 42px; font-weight: 900; color: #7B0000; margin: 16px 0;">{{ $scheduledTime }}</div>
                                        <p style="margin: 8px 0 0 0; font-size: 15px; color: #92400E;">{{ now()->translatedFormat('l, d F Y') }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info Text -->
                            <p style="margin: 0 0 32px 0; font-size: 16px; line-height: 1.7; color: #5C4545;">
                                Pengingat ini dikirim <strong>30 menit sebelum</strong> jadwal minum obat Anda.
                                Pastikan Anda sudah menyiapkan obat dan meminumnya tepat waktu.
                            </p>

                            <!-- Medicine Card (Modern Design) -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #F5E6E6 0%, #FDF5F5 100%); border-radius: 20px; border: 2px solid #E8D5D5; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 32px 28px;">

                                        <!-- Medicine Name Header -->
                                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                                            <div style="font-size: 36px;">💊</div>
                                            <h3 style="margin: 0; font-size: 24px; font-weight: 900; color: #7B0000;">{{ $schedule->medicine->name }}</h3>
                                        </div>

                                        <!-- Details Grid -->
                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td width="40%" style="font-size: 14px; font-weight: 700; color: #3D0000; padding: 12px 0;">Dosis:</td>
                                                <td style="font-size: 15px; color: #5C4545; padding: 12px 0;">{{ $schedule->dosage }}</td>
                                            </tr>
                                            <tr style="background: rgba(123,0,0,0.03);">
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000; padding: 12px 16px; border-radius: 8px;">Kekuatan:</td>
                                                <td style="font-size: 15px; color: #5C4545; padding: 12px 16px;">{{ $schedule->medicine->strength }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000; padding: 12px 0;">Bentuk:</td>
                                                <td style="font-size: 15px; color: #5C4545; padding: 12px 0;">{{ $schedule->medicine->dosage_form }}</td>
                                            </tr>
                                            <tr style="background: rgba(123,0,0,0.03);">
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000; padding: 12px 16px; border-radius: 8px;">Frekuensi:</td>
                                                <td style="font-size: 15px; color: #5C4545; padding: 12px 16px;">{{ $schedule->frequency_per_day }}x sehari</td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <!-- Instructions Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border-radius: 16px; border-left: 5px solid #3B82F6; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 24px;">
                                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                                            <span style="font-size: 20px;">📋</span>
                                            <strong style="font-size: 14px; color: #1E40AF; text-transform: uppercase; letter-spacing: 0.5px;">Petunjuk Penggunaan</strong>
                                        </div>
                                        <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #1E3A8A;">{{ $schedule->instruction }}</p>
                                    </td>
                                </tr>
                            </table>

                            @if($schedule->notes)
                            <!-- Important Notes Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #FEE2E2 0%, #FEE 100%); border-radius: 16px; border-left: 5px solid #EF4444; margin-bottom: 32px;">
                                <tr>
                                    <td style="padding: 24px;">
                                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                                            <span style="font-size: 20px;">⚠️</span>
                                            <strong style="font-size: 14px; color: #991B1B; text-transform: uppercase; letter-spacing: 0.5px;">Catatan Penting</strong>
                                        </div>
                                        <p style="margin: 0; font-size: 15px; line-height: 1.6; color: #7F1D1D;">{{ $schedule->notes }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/patient/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #7B0000 0%, #5C0000 100%); color: white; text-decoration: none; padding: 18px 48px; border-radius: 14px; font-size: 16px; font-weight: 700; box-shadow: 0 8px 24px rgba(123, 0, 0, 0.3);">
                                            🏥 Buka Dashboard Saya
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Tips Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border-radius: 16px; border: 2px solid #10B981; margin-top: 32px;">
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <div style="display: flex; gap: 12px;">
                                            <span style="font-size: 24px;">💡</span>
                                            <div>
                                                <strong style="font-size: 14px; color: #065F46; margin-bottom: 8px; display: block;">Tips Penting:</strong>
                                                <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #047857;">
                                                    Setelah minum obat, jangan lupa tandai di dashboard agar tenaga kesehatan dapat memantau kepatuhan pengobatan Anda.
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Disclaimer -->
                            <p style="margin: 32px 0 0 0; font-size: 14px; line-height: 1.6; color: #8B7373; text-align: center;">
                                Jika mengalami efek samping atau pertanyaan, segera hubungi tenaga kesehatan Anda.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #FDF5F5 0%, #F5E6E6 100%); padding: 32px 40px; text-align: center; border-top: 2px solid #E8D5D5;">
                            <strong style="font-size: 16px; color: #5C4545; display: block; margin-bottom: 8px;">MedReminder</strong>
                            <p style="margin: 0 0 16px 0; font-size: 13px; color: #8B7373; line-height: 1.6;">
                                Sistem Pengingat Minum Obat Pasien Hipertensi<br>
                                Email otomatis • Resend API
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #B8A0A0;">
                                © {{ date('Y') }} MedReminder. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
