<?php

function generateSecureRandomString($length = 32) {
    // Generate random bytes
    $bytes = random_bytes(ceil($length / 2));
    // Convert bytes to a hexadecimal string
    $hexString = bin2hex($bytes);
    // Return the desired length
    return substr($hexString, 0, $length);
}
?>