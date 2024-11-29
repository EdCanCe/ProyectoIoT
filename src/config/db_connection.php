<?php
$connection = mysqli_connect('localhost', 'root', '', 'Airalyze');
mysqli_set_charset($connection, 'utf8mb4');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>