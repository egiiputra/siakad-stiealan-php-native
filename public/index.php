<?php

session_start();

if (isset($_SESSION['username'])) {
    header('Location: /dashboard');
}
?>
<!DOCTYPE html>
<html lang="id" data-theme="mytheme">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD | STIE AL-ANWAR</title>
    <link rel="stylesheet" href="/assets/output.css">
</head>
<body class="flex justify-center items-center h-screen bg-[url(/assets/img/banner.jpg)] bg-cover">
	<div class="card card-border w-[400px] block p-5 bg-base-100">
        <form class="flex flex-col gap-2">
            <h2 class="form-signin-heading">LOGIN SIAKAD STIE AL-ANWAR</h2>
            <div id="error-msg"></div>
            <input type="text" class="input w-full" placeholder="Username" name="username" autofocus required>
            <input id="password" type="password" class="input w-full" placeholder="Password" name="password">
            <div>
                <input id="toggle-password" type="checkbox" onclick="showPass()"><label class="pl-2" for="toggle-password">Show Password</label>
            </div>
            <button class="btn btn-primary" type="submit" id="btnLogin">
                Login
            </button>
        </form>
    </div>

    <script>
        function showPass() {
            let x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        const btnSubmit = document.getElementById('btnLogin');
        const errorMsg = document.getElementById('error-msg');


        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();
            btnSubmit.innerHTML = '<span class="loading loading-spinner"></span>Login'
            const formData = new FormData(this);
            fetch('/api/login.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (response.status === 401) {
                        errorMsg.innerHTML = `<div class="alert alert-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Username atau password tidak valid!
                        </div>`;
                        btnSubmit.innerHTML = 'Login'
                        return;
                    } 
                    if (response.status === 200) {
                        window.location.href = '/dashboard.php';
                    }
                    return response.json()

                })
                .then(json => {
                    console.log(json)
                })
                .catch(e => {
                    console.log(e);
                })
                .finally(() => {
                    btnSubmit.innerHTML = 'Login'
                })
            console.info(formData)
            console.log(this);
        })
    </script>
</body>
</html>
