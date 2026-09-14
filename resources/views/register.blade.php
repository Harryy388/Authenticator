<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Registreren</title>

    @vite('resources/css/app.css')
</head>

<body>

    <main>
        <h1>Registreren</h1>

        <div>
            <label for="name">Naam</label>
            <input type="text" id="name" placeholder="Naam">
        </div>

        <div>
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="E-mail">
        </div>

        <div>
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" placeholder="Wachtwoord">
        </div>

        <button onclick="register()">Registreren</button>

        <p id="message"></p>

        <p>
            Al een account?
            <a href="/login">Inloggen</a>
        </p>
    </main>

    <script>
        async function register() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password
                })
            });

            const data = await response.json();

            if (response.ok) {
                document.getElementById('message').textContent = 'Registratie gelukt';

                setTimeout(() => {
                    window.location.href = '/login';
                }, 1000);
            } else {
                document.getElementById('message').textContent =
                    data.message ?? 'Registratie mislukt';
            }
        }
    </script>

</body>

</html>