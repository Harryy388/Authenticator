<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    @vite('resources/css/app.css')


</head>

<body>

    <main>
        <h1>Inloggen</h1>

        <div>
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="E-mail">
        </div>

        <div>
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" placeholder="Wachtwoord">
        </div>

        <div id="mfa-box" style="display: none;">
            <label for="code">Authenticator-code</label>
            <input type="text" id="code" placeholder="6-cijferige code">
        </div>

        <button onclick="login()">Inloggen</button>

        <p id="message"></p>

        <hr>
        
        <a href="/auth/github" class="github-login">
            Inloggen met GitHub
        </a>

        <p>
            Nog geen account?
            <a href="/register">Registreren</a>
        </p>
    </main>

    <script>
        async function login() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const code = document.getElementById('code').value;

            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                    code: code
                })
            });

            const data = await response.json();

            if (data.token) {
                localStorage.setItem('token', data.token);
                window.location.href = '/dashboard';
                document.getElementById('message').textContent = 'Login gelukt';
            } else if (data.mfa_required) {
                document.getElementById('mfa-box').style.display = 'block';
                document.getElementById('message').textContent = 'Vul je MFA-code in';
            }
        }
    </script>

</body>

</html>