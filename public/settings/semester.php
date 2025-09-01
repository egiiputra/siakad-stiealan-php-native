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

ob_start();

?>

<!-- Open the modal using ID.showModal() method -->
<button class="btn btn-primary" onclick="my_modal_1.showModal()">Tambah semester</button>
<!-- You can open the modal using ID.showModal() method -->
<dialog id="my_modal_1" class="modal">
  <div class="modal-box w-6/12 max-w-5xl">
    <h3 class="text-lg font-bold">Form tambah semester</h3>
    
    <form action="">
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Kode</legend>
            <input name="kode" type="text" value="20161" class="input w-full" disabled>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nama</legend>
            <input name="nama" type="text" value="Gasal 2016/2017" class="input border border-neutral-950 w-full" disabled>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Bulan UTS</legend>
            <select name="bulan-uts" id="" class="input">
                <?php 
                for ($i = 1; $i <= 12; $i++) {
                ?>
                <option value="<?= $i ?>"><?= $i?></option>
                <?php
                }
                ?>
            </select>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Bulan UAS</legend>
            <select name="bulan-uas" id="" class="input">
                <?php 
                for ($i = 1; $i <= 12; $i++) {
                ?>
                <option value="<?= $i ?>"><?= $i?></option>
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
                    <?php 
                    for ($i = 1; $i <= 12; $i++) {
                    ?>
                    <option value="<?= $i ?>"><?= $i?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </fieldset>
        <fieldset class="fieldset">
            <legend class="fieldset-legend">SPP UAS</legend>
            <input type="text" value="20252" class="input border w-full" disabled>
        </fieldset>
    </form>

    <div class="modal-action">
      <form method="dialog">
        <!-- if there is a button, it will close the modal -->
        <button class="btn btn-error">Close</button>
      </form>
    </div>
  </div>
</dialog>
<table class="table bg-white">
    <!-- head -->
    <thead>
        <tr>
            <th>No.</th>
            <th></th>
            <th></th>
            <th>Kode</th>
            <th>Nama</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>KRS</th>
            <th>SPP UTS</th>
            <th>SPP UAS</th>
        </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
        
    </tbody>
</table>


<?php
$content = ob_get_clean();

require_once('../../layouts/dashboard.php');
?>