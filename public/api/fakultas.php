<?php


// TODO: Authorize (Ensure that user have permission)
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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $data = $conn->query("SELECT * FROM ms_fakultas WHERE id=$id")->fetch_assoc();


    http_response_code(200);
    echo json_encode($data);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $conn->query("INSERT INTO ms_fakultas (status, nama) VALUES (0, '" . $nama . "')");

    http_response_code(201);
    echo json_encode([
        'message' => 'insert data fakultas succeed'
    ]);
    exit();
}

// Ubah status fakultas
if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $input = trim(file_get_contents("php://input"));
    $body = json_decode($input, true);

    $conn->query("UPDATE ms_fakultas SET status=NOT status WHERE id=" . $body['id']);

    http_response_code(201);
    echo json_encode([
        'message' => 'insert data fakultas succeed'
    ]);
    exit();
}

// edit fakultas
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = trim(file_get_contents("php://input"));
    $body = json_decode($input, true);

    $nama = htmlspecialchars($body['nama']);

    $conn->query("UPDATE ms_fakultas SET nama='$nama' WHERE id=" . $body['id']);

    http_response_code(201);
    echo json_encode([
        'message' => 'update data fakultas succeed'
    ]);
    exit();
}

?>