<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Antwoord op je bericht</title>
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
        .original-message {
            background-color: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #00844A;
            margin-top: 20px;
        }
        .reply-message {
            background-color: white;
            padding: 15px;
            border-radius: 3px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
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
        <h1 style="margin: 0;">Antwoord op je bericht</h1>
    </div>
    
    <div class="content">
        <p>Beste {{ $contactMessage->name }},</p>
        
        <p>Bedankt voor je bericht. Hieronder vind je ons antwoord:</p>
        
        <div class="reply-message">
            <p style="white-space: pre-line; margin: 0;">{{ $replyMessage }}</p>
        </div>
        
        <div class="original-message">
            <h3 style="margin-top: 0; color: #00844A;">Je oorspronkelijke bericht:</h3>
            <p><strong>Onderwerp:</strong> {{ $contactMessage->subject }}</p>
            <p style="white-space: pre-line;">{{ $contactMessage->message }}</p>
        </div>
        
        <p style="margin-top: 20px;">Met vriendelijke groet,<br>Het Recepten Team</p>
        
        <div class="footer">
            <p>Dit is een antwoord op je contactbericht van {{ $contactMessage->created_at->format('d-m-Y') }}</p>
        </div>
    </div>
</body>
</html>
