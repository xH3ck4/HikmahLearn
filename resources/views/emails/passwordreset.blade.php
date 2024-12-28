<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #6B46C1 0%, #9F7AEA 100%);
            padding: 30px;
            text-align: center;
        }
        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }
        .content {
            padding: 40px;
            color: #444444;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #3c3c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            transition: background 0.3s ease;
        }
        .button:hover {
            background: #553C9A;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666666;
            font-size: 12px;
        }
        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://i.ibb.co.com/HGKFb4F/header-Title.webp" alt="Logo Hikmah-Learn" class="logo">
            <h1 style="color: white; margin: 0;">Reset Password</h1>
        </div>
        
        <div class="content">
            <h2>Halo, {{ $user->nama }}!</h2>
            
            <p>Kami menerima permintaan untuk mengatur ulang password akun Hikmah-Learn Anda. Klik tombol di bawah ini untuk melanjutkan proses reset password:</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Reset Password</a>
            </div>
            
            <div class="divider"></div>
            
            <p>Jika Anda mengalami kesulitan mengklik tombol tersebut, salin dan tempel URL di bawah ini ke browser web Anda:</p>
            <p style="word-break: break-all; color: #6B46C1;">{{ $url }}</p>
            
            <p>Tautan reset password ini akan kedaluwarsa dalam 60 menit.</p>
            
            <div class="divider"></div>
            
            <p style="font-size: 14px;">Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini. Password Anda tidak akan berubah.</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Hikmah-Learn.</p>
            <p>Ini adalah pesan otomatis, mohon jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>