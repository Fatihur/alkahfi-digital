<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f7;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 12px 12px 0 0;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700;">ALKAHFI DIGITAL</h1>
                            <p style="margin: 8px 0 0; color: rgba(255,255,255,0.9); font-size: 14px;">Sistem Pembayaran SPP Santri</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 20px; color: #1f2937; font-size: 20px; font-weight: 600;">Reset Password</h2>
                            
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Halo,
                            </p>
                            
                            <p style="margin: 0 0 20px; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah ini untuk membuat password baru:
                            </p>
                            
                            <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td align="center" style="padding: 20px 0;">
                                        <a href="{{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}" 
                                           style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="margin: 20px 0; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Link ini akan kadaluarsa dalam <strong>60 menit</strong>.
                            </p>
                            
                            <p style="margin: 20px 0; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Jika Anda tidak meminta reset password, abaikan email ini. Password Anda tidak akan berubah.
                            </p>
                            
                            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
                            
                            <p style="margin: 0; color: #9ca3af; font-size: 13px; line-height: 1.6;">
                                Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke browser Anda:
                            </p>
                            <p style="margin: 10px 0 0; color: #4f46e5; font-size: 13px; word-break: break-all;">
                                {{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 40px; background-color: #f9fafb; border-radius: 0 0 12px 12px; text-align: center;">
                            <p style="margin: 0; color: #9ca3af; font-size: 13px;">
                                &copy; {{ date('Y') }} ALKAHFI DIGITAL. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
