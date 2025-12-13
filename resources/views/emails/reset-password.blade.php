<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f4f4f4; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header dengan Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
                                🔐 Reset Password
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="margin: 0 0 20px 0; color: #333333; font-size: 22px; font-weight: 600;">
                                Halo, {{ $userName ?? 'Pengguna' }}!
                            </h2>
                            
                            <p style="margin: 0 0 20px 0; color: #666666; font-size: 16px; line-height: 1.6;">
                                Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah ini untuk membuat password baru:
                            </p>

                            <!-- Button -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 30px 0;">
                                        <a href="{{ $resetLink }}" 
                                           style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 20px 0; color: #666666; font-size: 14px; line-height: 1.6;">
                                Atau salin dan tempel link berikut ke browser Anda:
                            </p>

                            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; border-left: 4px solid #667eea; margin-bottom: 20px;">
                                <a href="{{ $resetLink }}" style="color: #667eea; text-decoration: none; word-break: break-all; font-size: 14px;">
                                    {{ $resetLink }}
                                </a>
                            </div>

                            <!-- Warning Box -->
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top: 30px;">
                                <tr>
                                    <td style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 6px;">
                                        <p style="margin: 0; color: #856404; font-size: 14px; line-height: 1.5;">
                                            <strong>⚠️ Perhatian:</strong><br>
                                            Link ini akan kadaluarsa dalam <strong>60 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0 0 10px 0; color: #999999; font-size: 14px;">
                                Email ini dikirim dari sistem POS & Inventory
                            </p>
                            <p style="margin: 0; color: #999999; font-size: 12px;">
                                © {{ date('Y') }} POS & Inventory. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

                <!-- Additional Info -->
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="margin-top: 20px;">
                    <tr>
                        <td align="center">
                            <p style="margin: 0; color: #999999; font-size: 12px; line-height: 1.5;">
                                Jika Anda mengalami masalah dengan tombol di atas, salin dan tempel URL ke browser web Anda.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>