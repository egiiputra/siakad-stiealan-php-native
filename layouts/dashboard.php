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
    <style>
        summary::after {
            margin-left: auto;
        }
    </style>
</head>
<body>
	<div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col items-center justify-center">
            <!-- Page content here -->
            <!-- <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">
            Open drawer
            </label> -->
            <?= $content ?>
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
                    <a href="/dashboard.php">Dashboard</a>
                    <!-- <details>
                        <summary class="flex items-center justify-between">
                            <span class="flex items-center gap-2">
                            <i data-lucide="folder" class="w-5 h-5"></i>
                                Dashboard
                            </span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
                        </summary>
                    </details> -->
                </li>
                <li>
                    <details>
                        <summary class="flex items-center justify-between">
                            <span class="flex items-center gap-2">
                            <!-- <i data-lucide="folder" class="w-5 h-5"></i> -->
                                Settings
                            </span>
                            <!-- <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i> -->
                        </summary>
                        <ul>
                            <li>
                                <a href="/settings/semester.php" class="flex items-center gap-2"><i data-lucide="file-text" class="w-4 h-4"></i>Semester</a></li>
                            <li>
                            <details>
                                <summary class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i data-lucide="archive" class="w-5 h-5"></i>
                                    Archived
                                </span>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform"></i>
                                </summary>
                                <ul>
                                <li><a href="/2023.php">2023</a></li>
                                <li><a href="/2024.php">2024</a></li>
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
            const currentPath = window.location.pathname; // e.g. "/about.php"
            const navLinks = document.querySelectorAll(".drawer-side ul li a");

            navLinks.forEach(link => {
                if (link.getAttribute("href") === currentPath) {
                    console.log(link)
                    link.classList.add('bg-[#061553]')
                    // link.classList.add('text-base-content'); // add to <li>
                    // or link.classList.add("active"); // add to <a> if you prefer
                    let parent = link.closest("details");
                    while (parent) {
                        parent.setAttribute("open", "");
                        // rotate the chevron icon if exists
                        // const icon = parent.querySelector(":scope > summary [data-lucide='chevron-down']");
                        // if (icon) icon.classList.add("rotate-180");
                        parent = parent.parentElement.closest("details");
                    }
                }
            });
        });
    </script>

</body>
</html>