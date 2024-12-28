<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log Pembaruan - Hikmah Learn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            margin: 0;
            color: #4CAF50;
        }
        .content {
            padding: 20px 0;
        }
        .content h2 {
            color: #4CAF50;
        }
        .content p {
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }
        .footer p {
            margin: 0;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Log Pembaruan Hikmah Learn</h1>
        </div>
        <div class="content">
            <h2>Halo, {{$user->nama}}</h2>
            <p>Kami dengan senang hati menginformasikan kepada Anda tentang pembaruan dan peningkatan terbaru pada platform Hikmah Learn API kami. Berikut adalah detail perubahan terbaru:</p>
            <ul>
                <li><strong>Fitur 1:</strong> Deskripsi pembaruan fitur pertama.</li>
                <li><strong>Fitur 2:</strong> Deskripsi pembaruan fitur kedua.</li>
                <li><strong>Perbaikan Bug:</strong> Deskripsi bug yang telah diperbaiki.</li>
                <li><strong>Peningkatan Kinerja:</strong> Deskripsi peningkatan kinerja.</li>
            </ul>
            <p>Kami berharap pembaruan ini meningkatkan pengalaman Anda dengan platform kami. Jika Anda memiliki pertanyaan atau masukan, jangan ragu untuk menghubungi kami.</p>
            <p>Terima kasih telah menggunakan Hikmah Learn!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Hikmah Learn. Hak cipta dilindungi undang-undang.</p>
        </div>
    </div>
</body>
</html>