<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto - Radio Stereo Umachiri</title>
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
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8fafc;
            padding: 20px;
            border-radius: 0 0 10px 10px;
        }
        .message-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #dc2626;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎵 Radio Stereo Umachiri</h1>
        <p>Nuevo Mensaje de Contacto</p>
    </div>
    
    <div class="content">
        <h2>Hola Administrador,</h2>
        <p>Has recibido un nuevo mensaje de contacto en el sitio web de Radio Stereo Umachiri.</p>
        
        <div class="message-box">
            <h3>📝 Detalles del Mensaje:</h3>
            <p><strong>Nombre:</strong> {{ $name }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Asunto:</strong> {{ $subject }}</p>
            <p><strong>Mensaje:</strong></p>
            <div style="background: #f1f5f9; padding: 10px; border-radius: 5px; margin-top: 10px;">
                {{ $message }}
            </div>
        </div>
        
        <p><strong>Fecha y Hora:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        
        <div style="margin-top: 20px; padding: 15px; background: #e0f2fe; border-radius: 8px;">
            <h4>📧 Responder al Mensaje:</h4>
            <p>Para responder a este mensaje, puedes usar el email: <strong>{{ $email }}</strong></p>
        </div>
    </div>
    
    <div class="footer">
        <p>Este es un mensaje automático del sistema de Radio Stereo Umachiri</p>
        <p>© 2024 Radio Stereo Umachiri - 98.5 FM - Melgar, Puno</p>
    </div>
</body>
</html> 