<?php
$nombre_servidor = "localhost";
$username = "root";
$contraseña = "";
$nombre_bd = "login_register";

$conn = new mysqli($nombre_servidor, $username, $contraseña, $nombre_bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>