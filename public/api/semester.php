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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bulanSppKrs = (intval($_POST['tahun-spp-krs']) * 100) + intval($_POST['bulan-spp-krs']);
    $bulanSppUts = (intval($_POST['tahun-spp-uts']) * 100) + intval($_POST['bulan-spp-uts']);
    $bulanSppUas = (intval($_POST['tahun-spp-uas']) * 100) + intval($_POST['bulan-spp-uas']);
    $res = $conn->query("INSERT INTO ms_smt VALUES (" 
        . $_POST['kode'] . ","
        . "'" . $_POST['nama'] . "',"
        . "0,"
        . $_POST['bulan-uts'] . ","
        . $_POST['bulan-uas'] . ","
        . "$bulanSppUts,"
        . "$bulanSppUas,"
        . "0,"
        . "$bulanSppKrs)"
    );

    if ($conn->affected_rows == 0) {
        http_response_code(400);
        echo json_encode([
            'message' => 'semester is already exist'
        ]);
        exit();
    }

    http_response_code(201);
    echo json_encode([
        'message' => 'insert data semester succeed'
    ]);
    exit();
}
?>