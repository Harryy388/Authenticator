<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen...</title>

    <meta name="oauth-token" content="{{ $token }}">
</head>
<body>

    <p>Inloggen gelukt...</p>

    <script>
        const token = document
            .querySelector('meta[name="oauth-token"]')
            .getAttribute('content');

        localStorage.setItem('token', token);
        window.location.href = '/dashboard';
    </script>

</body>
</html>