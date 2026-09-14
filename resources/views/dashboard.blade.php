<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body>

    <main>
        <h1>Dashboard</h1>

        <p id="welcome">Gebruiker laden...</p>

        <button onclick="logout()">Uitloggen</button>


        <div>
            <h2>MFA</h2>

            <p id="mfa-status">MFA-status laden...</p>


            <button id="enable-mfa-btn" onclick="startMfaSetup()">
                MFA aanzetten
            </button>

            <button id="disable-mfa-btn" onclick="disableMfa()" style="display: none;">
                MFA uitzetten
            </button>
        </div>


    </main>

    <script>
        async function loadUser() {
            const token = localStorage.getItem('token');

            const response = await fetch('/api/user', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                document.getElementById('welcome').textContent =
                    'Welkom ' + data.name;
                document.getElementById('mfa-status').textContent =
                    data.mfa_enabled ? 'MFA staat aan' : 'MFA staat uit';
                if (data.mfa_enabled) {
                    document.getElementById('enable-mfa-btn').style.display = 'none';
                    document.getElementById('disable-mfa-btn').style.display = 'block';
                } else {
                    document.getElementById('enable-mfa-btn').style.display = 'block';
                    document.getElementById('disable-mfa-btn').style.display = 'none';
                }
            } else {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        }

        async function logout() {
            const token = localStorage.getItem('token');

            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            localStorage.removeItem('token');
            window.location.href = '/login';
        }

        loadUser();


        function startMfaSetup() {
            window.location.href = '/mfa-setup';
        }

        async function disableMfa() {
            const token = localStorage.getItem('token');

            const response = await fetch('/api/mfa/disable', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                document.getElementById('mfa-status').textContent = 'MFA staat uit';
                document.getElementById('enable-mfa-btn').style.display = 'block';
                document.getElementById('disable-mfa-btn').style.display = 'none';
            }   

        }
    </script>

</body>

</html>