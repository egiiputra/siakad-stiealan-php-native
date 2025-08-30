<?php

session_start();

header('Content-Type: application/json');

require_once('../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../../.env');
$dotenv->load();

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);

$username = htmlspecialchars($_POST['username']);

$user = $conn->query("SELECT * FROM ms_akun WHERE username = '$username' AND status=1")->fetch_assoc();


if (is_null($user)) {
    http_response_code(401);
    echo json_encode(['message' => 'Username atau password tidak valid!']);
    die();
}

if (!password_verify($_POST['password'], $user['password'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Username atau password tidak valid!']);
    die();
}

$_SESSION['id'] = $user['id'];
$_SESSION['username'] = $_POST['username'];	
$_SESSION['password'] = $_POST['password'];	
$_SESSION['level'] = $user['level'];

if (in_array($rows['username'], ['akuntasi', 'manajemen'])) {
    $_SESSION['kaprodi'] = 1;
    $_SESSION['jurusan'] = $user['prodi'];
    $_SESSION['dosen_wali'] = 1;
}
// TODO: set session

// TODO: Login for dosen
// TODO: Login for mahasiswa
http_response_code(200);
?>