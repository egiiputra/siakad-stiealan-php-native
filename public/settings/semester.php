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

$formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
$formatter->setPattern('MMMM'); // Full month name

$months = [];

for ($i = 1; $i <= 12; $i++) {
    $date = DateTime::createFromFormat('!m', $i);
    $months[$i] = $formatter->format($date);
};

$page = $_GET['page'] ?? 1;

$count = $conn->query("SELECT COUNT(*) FROM ms_smt")->fetch_array()[0];

$querySmt = $conn->query("SELECT * FROM ms_smt ORDER BY smt DESC LIMIT " . (($page - 1) * 5) . ", 5");
$rowsSmt = $querySmt->fetch_all(MYSQLI_ASSOC);

$inputKode = $rowsSmt[0]['smt'] + (($rowsSmt[0]['smt'] % 10 == 1) ? 1:9);
$thn = round($inputKode / 10);
$inputNama = (($inputKode % 2 == 1) ? 'Ganjil':'Genap') . " $thn/" . ($thn+1);
ob_start();

?>
<button class="btn btn-primary" onclick="my_modal_1.showModal()">Tambah semester</button>
<dialog id="my_modal_1" class="modal">
  <div class="modal-box w-6/12 max-w-5xl">
    <h3 class="text-lg font-bold">Form tambah semester</h3>
    
    <form action="post" id="form-add">
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kode</legend>
            <input name="kode" type="text" value="<?= $inputKode ?>" class="input w-full" readonly>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama</legend>
            <input name="nama" type="text" value="<?= $inputNama ?>" class="input w-full" readonly>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Bulan UTS</legend>
            <select name="bulan-uts" id="" class="input">
                <option value="">-- Pilih bulan UTS</option>
                <?php 
                for ($i = 1; $i <= 12; $i++) {
                ?>
                <option value="<?= $i ?>"><?= $months[$i] ?></option>
                <?php
                }
                ?>
            </select>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Bulan UAS</legend>
            <select name="bulan-uas" id="" class="input">
                <option value="">-- Pilih bulan UAS</option>
                <?php 
                for ($i = 1; $i <= 12; $i++) {
                ?>
                <option value="<?= $i ?>"><?= $months[$i] ?></option>
                <?php
                }
                ?>
            </select>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">SPP UTS</legend>
            <div class="flex gap-2">
                <select name="tahun-spp-uts" id="" class="input">
                    <?php 
                    $currYear = intval(date("Y"));
                    for ($i = ($currYear - 5); $i <= ($currYear + 5); $i++) {
                    ?>
                    <option value="<?= $i ?>" <?= ($i == $currYear) ? 'selected':'' ?>><?= $i?></option>
                    <?php
                    }
                    ?>
                </select>
                <select name="bulan-spp-uts" id="" class="input">
                    <option value="">-- Pilih bulan SPP UTS</option>
                    <?php 
                    for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <option value="<?= $i ?>"><?= $months[$i] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">SPP UAS</legend>
            <div class="flex gap-2">
                <select name="tahun-spp-uts" id="" class="input">
                    <?php 
                    for ($i = $thn; $i <= ($currYear + 5); $i++) {
                    ?>
                    <option value="<?= $i ?>" <?= ($i == $currYear) ? 'selected':'' ?>><?= $i?></option>
                    <?php
                    }
                    ?>
                </select>
                <select name="bulan-spp-uts" id="" class="input">
                    <option value="">-- Pilih bulan SPP UTS</option>
                    <?php 
                    for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <option value="<?= $i ?>"><?= $months[$i] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
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
<table class="table text-center">
    <!-- head -->
    <thead>
        <tr>
            <th>Kode</th>
            <th></th>
            <th></th>
            <th>Nama</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>KRS</th>
            <th>SPP UTS</th>
            <th>SPP UAS</th>
            <th>SPP KRS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rowsSmt as $row):
        ?>
        <tr>
            <td><?= $row['smt'] ?></td>
            <td></td>
            <td></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['blnuts'] ?></td>
            <td><?= $row['blnuas'] ?></td>
            <td></td>
            <td><?= $row['spp_uts'] ?></td>
            <td><?= $row['spp_uas'] ?></td>
            <td><?= $row['blnspp'] ?></td>
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


    <!-- <button class="join-item btn border border-neutral-300 btn-active">2</button>
    <button class="join-item btn border border-neutral-300">3</button>
    <button class="join-item btn border border-neutral-300">4</button> -->
    <?php endfor; ?>
</div>

<?php
$content = ob_get_clean();

ob_start();
?>
<script>
    const formAdd = document.getElementById('form-add');

    formAdd.addEventListener('submit', function (event) {
        event.preventDefault();
        const data = new FormData(this);

        console.log(data);

        fetch('/api/semester.php', {
            method: 'POST',
            body: data
        })
            .then(response => console.log(response.body))
            .then(body => console.log(body))
    });


</script>
<?php
$script = ob_get_clean();

require_once('../../layouts/dashboard.php');
?>