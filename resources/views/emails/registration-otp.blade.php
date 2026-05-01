<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration OTP</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>Hello {{ $name }},</h2>

    <p>Your OTP for account registration is:</p>

    <p style="font-size: 24px; font-weight: bold; letter-spacing: 3px; margin: 16px 0;">
        {{ $otp }}
    </p>

    <p>This OTP is valid for {{ $validMinutes }} minutes.</p>
    <p>If you did not request this, please ignore this email.</p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>