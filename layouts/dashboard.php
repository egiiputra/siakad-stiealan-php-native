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
        .collapse-title {
            width: 100%;
        }
        .collapse-content {
            width: 100%;
        }
    </style>
</head>
<body>
	<?php
	//  require_once("../components/header.php");
	?>
	<div class="navbar bg-base-100 shadow-sm">
        <div class="flex-none">
            <label for="my-drawer-2" class="btn drawer-button lg:hidden">
                <!-- <button class="btn btn-square btn-ghost"> -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-5 w-5 stroke-current"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path> </svg>
                </button>
            </label>
        </div>
		<div class="flex-1">
			<a class="btn btn-ghost text-xl">
			<img src="/assets/img/logo-stie.png"/>
			</a>
		</div>
		<div class="flex-none">
			<div class="dropdown dropdown-end">
			<div class="btn" tabindex="0" role="button" >
				<?= $_SESSION['username'] ?>
				<div class="avatar">
                    <div class="w-10 rounded-full">
                        <img
                        alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
				</div>
			</div>
			<ul
				tabindex="0"
				class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
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
		</div>
	</div>
    <div class="drawer lg:drawer-open">
        <ul class="menu p-4 w-80 min-h-full bg-base-200">
  <li><a class="flex items-center gap-2"><i data-lucide="home" class="w-5 h-5"></i> Dashboard</a></li>

  <li>
    <details>
      <summary class="flex items-center gap-2">
        <i data-lucide="folder" class="w-5 h-5"></i>
        Projects
      </summary>
      <ul>
        <li><a class="flex items-center gap-2"><i data-lucide="file-text" class="w-4 h-4"></i> Active</a></li>
        <li><a class="flex items-center gap-2"><i data-lucide="archive" class="w-4 h-4"></i> Archived</a></li>
      </ul>
    </details>
  </li>

  <li>
    <details>
      <summary class="flex items-center gap-2">
        <i data-lucide="settings" class="w-5 h-5"></i>
        Settings
      </summary>
      <ul>
        <li><a class="flex items-center gap-2"><i data-lucide="user" class="w-4 h-4"></i> Profile</a></li>
        <li><a class="flex items-center gap-2"><i data-lucide="shield" class="w-4 h-4"></i> Security</a></li>
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
                link.parentElement.classList.add("active"); // add to <li>
                // or link.classList.add("active"); // add to <a> if you prefer
            }
            });
        });
    </script>

</body>
</html>