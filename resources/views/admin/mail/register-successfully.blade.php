<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Succesfully</title>
</head>
<body>
    <p>Hello {{$user->name}},</p>

    <p>Thank You For Signing Up!</p>

    <p>We look forward to communicating more with you. For more information visit our Site.</p>

    <a href="{{ env('APP_URL') }}" target="_blank">Visit Website</a>

    <p>© {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
</body>
</html>
