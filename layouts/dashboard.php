<?php
	session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: /');
    }


?>
<!DOCTYPE html>
<html data-theme="mytheme" lang="id">
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
        .drawer-content svg {
            fill: var(--color-base-content);
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
            <!-- TODO: Add SMT aktif -->
            <ul class="menu w-80 p-4">
                <li>
                    <a href="/dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z"/></svg>    
                        Dashboard
                    </a>
                </li>
                <li>
                    <details>
                        <summary class="flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M627-520h133v-160H627v160Zm-214 0h133v-160H413v160Zm-213 0h133v-160H200v160Zm0 240h133v-160H200v160Zm213 0h133v-160H413v160Zm214 0h133v-160H627v160Zm-507 0v-400q0-33 23.5-56.5T200-760h560q33 0 56.5 23.5T840-680v400q0 33-23.5 56.5T760-200H200q-33 0-56.5-23.5T120-280Z"/></svg>Master
                            </span>
                        </summary>
                        <ul>
                            <li>
                                <a href="/master/mata_kuliah" class="flex items-center gap-2">Mata Kuliah</a>
                            </li>
                            <li>
                                <a href="/master/mahasiwa" class="flex items-center gap-2">Mahasiswa</a>
                            </li>
                            <li>
                                <a href="/master/mahasiswa_tambahan" class="flex items-center gap-2">Mahasiswa Tambahan</a>
                            </li>
                            <li>
                                <a href="/master/dosen" class="flex items-center gap-2">Dosen</a>
                            </li>
                            <li>
                                <a href="/master/tenaga_kependidikan" class="flex items-center gap-2">Tenaga Kependidikan</a>
                            </li>
                        </ul>
                    </details>
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