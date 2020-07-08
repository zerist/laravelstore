<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirm Email</title>
</head>
<body>
<h1>Thanks for Registe!</h1>

<p>
    Click the link to finish register:
    <a href="{{ route('confirm_email', $user->activation_token) }}">
        {{ route('confirm_email', $user->activation_token) }}
    </a>
</p>

</body>
</html>
