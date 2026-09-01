<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>MFA Setup</title>
</head>
<body>
    <h1>MFA instellen</h1>

    <p id="status">QR-code laden...</p>

    <div id="qrcode"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        async function loadMfaQr() {
            const token = localStorage.getItem('token');

            const response = await fetch('/api/mfa/setup', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.otpauth_url) {
                document.getElementById('status').textContent = 'Scan deze QR-code met je Authenticator-app';

                new QRCode(document.getElementById("qrcode"), {
                    text: data.otpauth_url,
                    width: 220,
                    height: 220
                });
            } else {
                document.getElementById('status').textContent = 'QR-code laden mislukt';
                console.log(data);
            }
        }

        loadMfaQr();
    </script>
</body>
</html>