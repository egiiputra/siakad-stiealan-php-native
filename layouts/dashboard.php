<?php
	session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: /');
    }


?>
<!DOCTYPE html>
<html data-theme="mytheme">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD | STIE AL-ANWAR</title>
    <link rel="stylesheet" href="/assets/output.css">
    <link rel="shortcut icon" href="/assets/img/icon.webp" type="image/x-icon">
    <style>
        summary::after {
            margin-left: auto;
        }
        details ul::before {
            background-color: white;
        }
    </style>
    <?= $head ?? '' ?>
</head>
<body class="bg-base-300">
	<div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col items-center justify-center p-5">
            <div class="bg-base-100 size-full p-5 rounded-md">
                <div class="breadcrumbs text-sm">
                    <ul>
                        <li>Home</li>
                    </ul>
                </div>
                <?= $content ?>
            </div>
        </div>
        <div class="drawer-side bg-primary text-primary-content p-2">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <img src="/assets/img/logo-stie_dark.png" alt="logo siakad" class="mx-auto"/>
            <div class="dropdown z-99 w-full mt-5">
                <div class="btn bg-[#061553] border-none w-full justify-start text-primary-content rounded-full py-8" tabindex="0" role="button" >
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img
                            alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                        </div>
                    </div>
                    <div class="flex flex-col items-start">
                        <b><?= $_SESSION['username'] ?></b>
                        <span><?= $_SESSION['level'] ?></span>
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content text-base-content bg-base-100 rounded-box z-1 mt-3 w-52  shadow">
                    <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                    </li>
                    <li><a>Settings</a></li>
                    <li><a>Logout</a></li>
                </ul>
            </div>
            <ul class="menu w-80 p-4">
                <li>
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li>
                    <details>
                        <summary class="flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                Settings
                            </span>
                        </summary>
                        <ul>
                            <li>
                                <a href="/settings/semester" class="flex items-center gap-2">Semester</a></li>
                            <li>
                            <details>
                                <summary class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    Kampus
                                </span>
                                </summary>
                                <ul>
                                    <li><a href="/settings/fakultas">Fakultas</a></li>
                                    <li><a href="/settings/prodi">Prodi</a></li>
                                </ul>
                            </details>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const breadcrumbs = document.querySelector('.breadcrumbs ul')
            const currentPath = window.location.pathname; // e.g. "/about.php"
            const navLinks = document.querySelectorAll(".drawer-side ul li a");

            let breadcrumbsInner = ""

            navLinks.forEach(link => {
                if (link.getAttribute("href") === currentPath) {
                    link.classList.add('bg-[#061553]')

                    breadcrumbsInner = `<li>${link.innerHTML}</li>` + breadcrumbsInner
                    let parent = link.closest("details");
                    while (parent) {
                        parent.setAttribute("open", "");

                        breadcrumbsInner = `<li>${parent.querySelector('summary > span').innerHTML}</li>` + breadcrumbsInner
                        parent = parent.parentElement.closest("details");
                    }
                }
            });

            breadcrumbs.innerHTML += breadcrumbsInner;
        });
    </script>
    <?= $script ?? '' ?>
</body>
</html>