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
                            <div style="font-size: 48px; margin-bottom: 12px;">📧</div>
                            <h1 style="margin: 0; font-size: 28px; font-weight: 900; color: white;">
                                {{ $subject }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">

                            <p style="margin: 0 0 24px 0; font-size: 18px; color: #1E1E1E;">
                                Halo, <strong style="color: #7B0000;">{{ $user->name }}</strong> 👋
                            </p>

                            <!-- Message Content Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #F5E6E6, #FDF5F5); border-radius: 16px; border: 2px solid #E8D5D5; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 32px;">
                                        <div style="font-size: 16px; line-height: 1.8; color: #5C4545; white-space: pre-wrap;">{{ $messageContent }}</div>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 24px 0;">
                                        <a href="{{ url('/patient/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #7B0000, #5C0000); color: white; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-size: 15px; font-weight: 700;">
                                            🏥 Buka Dashboard
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
