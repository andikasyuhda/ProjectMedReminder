<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #FDF5F5;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background: #FDF5F5; padding: 40px 20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(123, 0, 0, 0.15);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #7B0000, #5C0000); padding: 40px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 12px;">{{ $action === 'created' ? '📋' : '🔔' }}</div>
                            <h1 style="margin: 0; font-size: 28px; font-weight: 900; color: white;">
                                {{ $action === 'created' ? 'Jadwal Obat Baru' : 'Perubahan Jadwal Obat' }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">

                            <p style="margin: 0 0 24px 0; font-size: 18px; color: #1E1E1E;">
                                Halo, <strong style="color: #7B0000;">{{ $user->name }}</strong> 👋
                            </p>

                            @if($action === 'created')
                            <p style="margin: 0 0 32px 0; font-size: 16px; line-height: 1.7; color: #5C4545;">
                                Tenaga kesehatan telah membuat <strong>jadwal obat baru</strong> untuk Anda. Berikut detailnya:
                            </p>
                            @else
                            <p style="margin: 0 0 32px 0; font-size: 16px; line-height: 1.7; color: #5C4545;">
                                Ada <strong>perubahan jadwal obat</strong> Anda. Harap perhatikan detail terbaru di bawah:
                            </p>
                            @endif

                            <!-- Medicine Info Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #F5E6E6, #FDF5F5); border-radius: 16px; border: 2px solid #E8D5D5; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 28px;">
                                        <h3 style="margin: 0 0 20px 0; font-size: 22px; font-weight: 900; color: #7B0000;">
                                            💊 {{ $schedule->medicine->name }} {{ $schedule->medicine->strength }}
                                        </h3>

                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td width="35%" style="font-size: 14px; font-weight: 700; color: #3D0000;">Dosis:</td>
                                                <td style="font-size: 15px; color: #5C4545;">{{ $schedule->dosage }}</td>
                                            </tr>
                                            <tr style="background: rgba(123,0,0,0.03);">
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000; padding: 8px 12px; border-radius: 6px;">Frekuensi:</td>
                                                <td style="font-size: 15px; color: #5C4545; padding: 8px;">{{ $schedule->frequency_per_day }}x sehari</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000;">Waktu:</td>
                                                <td style="font-size: 15px; color: #5C4545;">{{ $schedule->formatted_time_slots }}</td>
                                            </tr>
                                            <tr style="background: rgba(123,0,0,0.03);">
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000; padding: 8px 12px; border-radius: 6px;">Aturan Pakai:</td>
                                                <td style="font-size: 15px; color: #5C4545; padding: 8px;">{{ $schedule->instruction }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 14px; font-weight: 700; color: #3D0000;">Periode:</td>
                                                <td style="font-size: 15px; color: #5C4545;">{{ $schedule->start_date->format('d M Y') }} - {{ $schedule->end_date->format('d M Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            @if($schedule->notes)
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #FEE2E2; border-radius: 12px; border-left: 4px solid #EF4444; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <strong style="font-size: 13px; color: #991B1B; text-transform: uppercase;">⚠️ Catatan Penting:</strong>
                                        <p style="margin: 8px 0 0 0; font-size: 14px; color: #7F1D1D;">{{ $schedule->notes }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border-radius: 12px; border: 2px solid #3B82F6; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 24px; margin-bottom: 8px;">📧</div>
                                        <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #1E3A8A;">
                                            <strong>Email Pengingat Otomatis:</strong> Anda akan menerima email pengingat <strong>30 menit sebelum</strong> setiap waktu minum obat.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 24px 0;">
                                        <a href="{{ url('/patient/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #7B0000, #5C0000); color: white; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-size: 15px; font-weight: 700;">
                                            🏥 Lihat Jadwal Lengkap
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 24px 0 0 0; font-size: 13px; line-height: 1.6; color: #8B7373; text-align: center;">
                                Jika ada pertanyaan, silakan hubungi tenaga kesehatan Anda.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #FDF5F5; padding: 24px; text-align: center; border-top: 2px solid #E8D5D5;">
                            <p style="margin: 0; font-size: 13px; color: #8B7373;">
                                <strong>MedReminder</strong><br>
                                Sistem Pengingat Minum Obat
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
