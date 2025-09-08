<?php

require_once('../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../../.env');
$dotenv->load();

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);

$page = $_GET['page'] ?? 1;

$count = $conn->query("SELECT COUNT(*) FROM ms_fakultas")->fetch_array()[0];

$querySmt = $conn->query("SELECT * FROM ms_fakultas ORDER BY id ASC");
$rowsSmt = $querySmt->fetch_all(MYSQLI_ASSOC);

ob_start();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=edit_square" />
<?php
$head = ob_get_clean();

ob_start();
?>
<button class="btn btn-primary" onclick="my_modal_1.showModal()">Tambah fakultas</button>
<!-- Modal tambah data -->
<dialog id="my_modal_1" class="modal">
    <div class="modal-box w-6/12 max-w-5xl">
        <h3 class="text-lg font-bold">Form tambah fakultas</h3>
        
        <form hx-post="/api/semester.php" id="form-add">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <input name="nama" type="text" value="" class="input w-full">
            </fieldset>
            <button class="btn btn-primary" type="submit">Simpan</button>
        </form>
        <form method="dialog">
            <div class="modal-action justify-start">
                <button class="btn btn-error">Batal</button>
            </div>
        </form>
    </div>
</dialog>
<!-- modal edit data -->
<dialog id="my_modal_2" class="modal">
    <div class="modal-box w-6/12 max-w-5xl">
        <h3 class="text-lg font-bold">Form edit fakultas</h3>
        
        <form id="form-edit">
            <input name="id" type="hidden" value="">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <input name="nama" type="text" value="" class="input w-full">
            </fieldset>
            <button class="btn btn-primary" type="submit">Simpan</button>
        </form>
        <form method="dialog">
            <div class="modal-action justify-start">
                <button class="btn btn-error">Batal</button>
            </div>
        </form>
    </div>
</dialog>
<table class="table text-center w-[600px]">
    <!-- head -->
    <thead>
        <tr>
            <th class="w-[30px]"></th>
            <th class="w-[30px]">Aktif</th>
            <th class="text-left">Nama Fakultas</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rowsSmt as $row):
        ?>
        <tr>
            <td>
                <button class="btn" onclick="showEditModal(this)" data-id="<?= $row['id'] ?>">
                    <span class="material-symbols-outlined">
                        edit_square
                    </span>
                </button>
            </td>
            <td>
                <input
                    name="fakultas-aktif"
                    type="checkbox"
                    class="checkbox checkbox-primary"
                    <?= ($row['status'] == 1) ? 'checked':'' ?>
                    onclick="toggleFakultas(this)"
                    value="<?= $row['id'] ?>"
                    data-nama="<?= $row['nama'] ?>"
                />
            </td>
            <td class="text-left"><?= $row['nama'] ?></td>
        </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>

<div class="join">
    <?php
    $pageCount = ceil($count / 5);
    for ($i = 1; $i <= $pageCount; $i++):
        if ($i == $page):
    ?>
    <a href="/settings/semester.php?page=<?= $i ?>" class="join-item btn border border-neutral-300 btn-active"><?= $i ?></a>
    <?php
        else:
    ?>
    <a href="/settings/semester.php?page=<?= $i ?>" class="join-item btn border border-neutral-300"><?= $i ?></a>
    <?php
        endif;
    ?>
    <?php endfor; ?>
</div>
<?php
$content = ob_get_clean();

ob_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    document.getElementById('form-edit').addEventListener('submit', function (event) {
        console.log('LOL')
        event.preventDefault()
        const data = new FormData(this)
        const body = JSON.stringify(Object.fromEntries(data.entries()))

        fetch('/api/fakultas', {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
            },
            body: body
        }).then(response => {
            my_modal_2.close()
            if (response.status == 201) {
                Swal.fire({
                    icon: "success",
                    title: "Data berhasil ditambahkan",
                });
            }
            setTimeout(() => {
                window.location.href = '/settings/fakultas'
            }, 2000);
        })
    })

    function showEditModal(button) {
        my_modal_2.showModal()

        fetch(`/api/fakultas?id=${button.dataset.id}`, {
            method: "GET"
        })
            .then(response => response.json() )
            .then(data => {
                my_modal_2.querySelector('input[name="nama"]').value = data.nama;
            })
        my_modal_2.querySelector('input[name="id"]').value = button.dataset.id
    }

    function toggleFakultas(checkBox) {
        Swal.fire({
            title: "Apakah yakin mengubah status fakultas?",
            text: `Mengubah status ${checkBox.dataset.nama}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
        }).then(async (result) => {
            if (!result.isConfirmed) {
                checkBox.checked = false
                return
            }

            try {
                fetch("/api/fakultas", {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id: checkBox.value,
                    }),
                }).then(response => {
                    if (response.status == 400) {
                        Swal.fire("Gagal!", "Mengubah status fakultas gagal", "error");
                    } else {
                        Swal.fire("Berhasil!", "Berhasil mengubah statu fakultas", "success");
                    }
                })
            } catch (err) {
                Swal.fire("Error!", "Gagal mengupdate status fakulats", "error");
                if (prevChecked) prevChecked.checked = true;
            }
        });
    }
    const formAdd = document.getElementById('form-add');

    formAdd.addEventListener('submit', function (event) {
        event.preventDefault();
        const data = new FormData(this);

        fetch('/api/fakultas', {
            method: 'POST',
            body: data
        }).then(response => {
            my_modal_1.close()
            if (response.status == 201) {
                Swal.fire({
                    icon: "success",
                    title: "Data berhasil ditambahkan",
                });
            }
            setTimeout(() => {
                window.location.href = '/settings/fakultas'
            }, 2000);
        })
    });
</script>
<?php
$script = ob_get_clean();

require_once('../../layouts/dashboard.php');
?>