<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 30px;
        }
        .email-container {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h2 {
            color: #007bff;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.6;
        }
        .verify-btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 5px;
            margin: 20px 0;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Welcome, {{ $user->name }}!</h2>
        </div>

        <div class="email-body">
            <p>Thank you for registering with us. We're excited to have you on board!</p>

            <p>Please verify your email address to activate your account:</p>

            <p style="text-align:center;">
                <a href="{{ $verificationUrl }}" class="verify-btn">Verify Email Address</a>
            </p>

            <p>If the button doesn’t work, copy and paste this link into your browser:</p>
            <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>

            <p>Thank you,<br>The Support Team</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>
</html>
