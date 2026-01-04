<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nieuw Contactbericht</title>
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
            background-color: #00844A;
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
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-weight: bold;
            color: #00844A;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            background-color: white;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ddd;
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
        <h1 style="margin: 0;">Nieuw Contactbericht</h1>
    </div>
    
    <div class="content">
        <p>Je hebt een nieuw contactbericht ontvangen via de website.</p>
        
        <div class="field">
            <span class="label">Van:</span>
            <div class="value">{{ $contactMessage->name }}</div>
        </div>
        
        <div class="field">
            <span class="label">Email:</span>
            <div class="value">
                <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
            </div>
        </div>
        
        <div class="field">
            <span class="label">Onderwerp:</span>
            <div class="value">{{ $contactMessage->subject }}</div>
        </div>
        
        <div class="field">
            <span class="label">Bericht:</span>
            <div class="value" style="white-space: pre-line;">{{ $contactMessage->message }}</div>
        </div>
        
        <div class="footer">
            <p>Dit bericht is verzonden op {{ $contactMessage->created_at->format('d-m-Y \o\m H:i') }}</p>
        </div>
    </div>
</body>
</html>
