<?php

require_once('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '../.env');
$dotenv->load();

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);

ob_start();

?>

<img src="/assets/img/flow_siakad_2802.jpg" alt="flow siakad">

<?php
$content = ob_get_clean();

require_once('../layouts/dashboard.php');
?>