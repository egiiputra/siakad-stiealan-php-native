<?php

// TODO: Authorize (Ensure that user have permission)
require_once('../../utils.php');

require_once('../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../../.env');
$dotenv->load();

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nipy = htmlspecialchars($_POST['nipy']);
    $nidn = htmlspecialchars($_POST['nidn']);
    $nuptk = htmlspecialchars($_POST['nuptk']);
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // TODO: ensure nipy, nidn, nuptk, and username are uniqe

    // Handle image upload
    $directory = '../user-uploads/profil/dosen/';

    if (!empty($_FILES['foto']['tmp_name'])) {
        $filenameFoto = $username . '_foto_' . generateSecureRandomString(16) . '.jpg';

        $upload = move_uploaded_file($_FILES['foto']['tmp_name'], $directory . $filenameFoto);
    }
    if (!empty($_FILES['scan']['tmp_name'])) {
        $filenameScan = $username . '_scan_ttd_' . generateSecureRandomString(16) . '.jpg';
        var_dump($_FILES['scan']);
        $upload = move_uploaded_file($_FILES['scan']['tmp_name'], $directory . $filenameScan);
    }

    $conn->query("INSERT INTO ms_pegawai ("
        . "nipy, nidn, nuptk, nama, alamat, id_prodi, username, password, "
        . (isset($filenameFoto) ? 'foto, ':'')
        . (isset($filenameScan) ? 'foto_ttd, ':'')
        . " validator) VALUES ("
        . "'$nipy', '$nidn', " 
        . ( ($nuptk == '') ? "null":"'$nuptk'" ) . ", " 
        . "'$nama', '$alamat', " 
        . ($_POST['id-prodi'] == '' ? 'null':$_POST['id-prodi']) . ","
        . "'$username', '$password',"
        . (isset($filenameFoto) ? "'$filenameFoto',":"")
        . (isset($filenameScan) ? "'$filenameScan',":"")
        . "0)");

    http_response_code(201);
    echo json_encode([
        'message' => 'Data pegawai berhasil ditambahkan'
    ]);

}
?>