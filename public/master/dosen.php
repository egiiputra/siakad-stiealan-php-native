<?php

// TODO: make sure user have permission
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

$querySmt = $conn->query(
    "SELECT pe.id AS id, pe.status AS status, pe.nipy AS nipy, pe.nidn AS nidn, pe.nuptk AS nuptk, pe.nama AS nama, pe.alamat AS alamat, pr.nama AS prodi, pe.kaprodi AS kaprodi, pe.dosen_wali AS dosen_wali, pe.username AS username "
        . "FROM ms_pegawai pe LEFT JOIN ms_prodi pr ON pe.id_prodi=pr.id ORDER BY pe.id ASC LIMIT " . (($page - 1) * 10) . ", 10"
);
$prodi = $conn->query("SELECT id, nama FROM ms_prodi");

ob_start();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=edit_square,folder_managed" />
<link rel="stylesheet" href="/assets/css/croppie.css" />
<?php
$head = ob_get_clean();

ob_start();
?>
<button class="btn btn-primary" onclick="my_modal_1.showModal()">
    Tambah Dosen
</button>
<!-- Modal tambah data -->
<dialog id="my_modal_1" class="modal">
    <div class="modal-box w-6/12 max-w-5xl">
        <form id="form-add">
            <h3 id="judul-form" class="text-lg font-bold">Form tambah pegawai</h3>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">NIPY</legend>
                <input name="nipy" type="text" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">NIDN</legend>
                <input name="nidn" type="text" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">NUPTK</legend>
                <input name="nuptk" type="text" class="input w-full">
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Nama</legend>
                <input name="nama" type="text" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">alamat</legend>
                <input name="alamat" type="text" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Foto</legend>
                <input id="uploadFoto" name="foto" type="file" class="file-input" accept="image/jpeg,.jpg,.jpeg,.png" />
                <div class="w-[336px] h-[415px] pb-[50px]">
                    <div id="foto-preview"></div>
                </div>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Scan ttd</legend>
                <input id="uploadScan" name="scan" type="file" class="file-input" accept="image/jpeg,.jpg,.jpeg,.png" />
                <div class="w-[415px] h-[336px] pb-[50px]">
                    <div id="scan-preview"></div>
                </div>
            </fieldset>

            <h3 class="text-lg font-bold pt-4">Akun siakad blog</h3>

            <fieldset class="fieldset">
                <legend class="fieldset-legend">Dosen prodi</legend>
                <select class="input w-full" name="id-prodi" id="id-prodi">
                    <option value="">-- Pilih prodi</option>
                </select>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Username</legend>
                <input name="username" type="text" class="input w-full">
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Password</legend>
                <input name="password" type="password" class="input w-full">
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

<table class="table table-xs text-center w-full">
    <!-- head -->
    <thead>
        <tr>
            <th class="w-[10px]">No.</th>
            <th class="w-[10px]"></th>
            <th class="w-[10px]"></th>
            <th class="w-[10px]"></th>
            <th>NIPY</th>
            <th>NIDN</th>
            <th>NUPTK</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Prodi</th>
            <th>Kaprodi</th>
            <th>Dosen Wali</th>
            <th>Blog</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = (($page - 1) * 10) + 1;
        while ($row = $querySmt->fetch_assoc()):
        ?>
            <tr>
                <td><?= $no ?></td>
                <td>
                    <!-- TODO: edit feature -->
                    <button class="btn p-0" data-id="<?= $row['id'] ?>">
                        <span class="material-symbols-outlined">
                            edit_square
                        </span>
                    </button>
                </td>
                <td>
                    <input
                        name="dosen-aktif"
                        type="checkbox"
                        class="checkbox checkbox-success"
                        <?= ($row['status'] == 1) ? 'checked' : '' ?>
                        value="<?= $row['id'] ?>" />
                </td>
                <td>
                    <!-- TODO: manage module -->
                    <button class="btn p-0" data-id="<?= $row['id'] ?>">
                        <span class="material-symbols-outlined">
                            folder_managed
                        </span>
                    </button>
                </td>
                <td><?= $row['nipy'] ?></td>
                <td><?= $row['nidn'] ?></td>
                <td><?= $row['nuptk'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['prodi'] ?></td>
                <td><?= $row['kaprodi'] ?></td>
                <td><?= $row['dosen_wali'] ?></td>
                <td><?= $row['username'] ?></td>
            </tr>
        <?php
            $no++;
        endwhile;
        ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();

ob_start();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/croppie.js"></script>
<script>
    let fotoPreview = new Croppie(document.getElementById('foto-preview'), {
        viewport: {
            width: 236,
            height: 315
        }
    });

    let scanPreview = new Croppie(document.getElementById('scan-preview'), {
        viewport: {
            width: 315,
            height: 236
        }
    });

    function updatePreview(input, preview) {
        const tmpUrl = URL.createObjectURL(input.files[0])

        preview.bind({
            url: tmpUrl,
        });
    }

    document.querySelector('#uploadFoto').addEventListener('change', function() {
        updatePreview(this, fotoPreview)
    })

    document.querySelector('#uploadScan').addEventListener('change', function() {
        updatePreview(this, scanPreview)
    })

    document.querySelector('#form-add').addEventListener('submit', async function(event) {
        event.preventDefault()

        const formData = new FormData(this)

        console.log(formData.get('foto').name);
        if (formData.get('foto').name !== '') {
            formData.delete("foto")

            const blob = await fotoPreview.result({
                type: 'blob',
                size: {
                    width: 236,
                    height: 315
                },
                format: 'jpeg',
                quality: 1,
            })
            formData.append('foto', blob, 'foto.jpg');
        }

        if (formData.get('scan').name !== '') {
            formData.delete("scan")

            const blob = await scanPreview.result({
                type: 'blob',
                size: {
                    width: 315,
                    height: 236
                },
                format: 'png',
                quality: 1,
            })
            formData.append('scan', blob, 'scan.jpg');
        }

        const response = await fetch("/api/dosen", {
            method: 'POST',
            body: formData,
        })
        const body = await response.json()
        if (response.status === 400) {
            Swal.fire({
                icon: "error",
                title: body['message']
            })
        } else if (response.status === 201) {
            Swal.fire({
                icon: "successs",
                title: "Data berhasil ditambahkan"
            })
        }
        my_modal_1.close()
    })
</script>
<?php
$script = ob_get_clean();

require_once('../../layouts/dashboard.php');
?>