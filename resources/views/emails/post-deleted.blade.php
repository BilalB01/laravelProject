<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Je post is verwijderd</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ef4444;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .post-content {
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        .reason {
            background-color: #fee2e2;
            padding: 15px;
            border-left: 4px solid #ef4444;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">Je post is verwijderd</h1>
    </div>
    
    <div class="content">
        <p>Beste {{ $user->name }},</p>
        
        <p>Een admin heeft je post verwijderd van de community pagina.</p>
        
        <div class="post-content">
            <h3 style="margin-top: 0; color: #856404;">Je verwijderde post:</h3>
            <p style="white-space: pre-line; margin: 0;">{{ $postContent }}</p>
        </div>
        
        <div class="reason">
            <h3 style="margin-top: 0; color: #991b1b;">Reden voor verwijdering:</h3>
            <p style="white-space: pre-line; margin: 0;">{{ $deleteReason }}</p>
        </div>
        
        <p>Als je vragen hebt over deze verwijdering, neem dan contact op met de admin via de contactpagina.</p>
        
        <p style="margin-top: 20px;">Met vriendelijke groet,<br>Het Recepten Team</p>
        
        <div class="footer">
            <p>Dit is een geautomatiseerd bericht. Reageer niet op deze email.</p>
        </div>
    </div>
</body>
</html>
