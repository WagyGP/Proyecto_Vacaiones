<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['usuario'])) {
        die("Error: Usuario no autenticado.");
    }

    $usuario = $_SESSION['usuario'];
    $dias = $_POST['days'];
    $fecha_inicio = $_POST['startDate'];
    $fecha_fin = $_POST['endDate'];

    $stmt = $conn->prepare("INSERT INTO solicitudes (usuario, dias, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Error en la preparación: " . $conn->error);
    }

    $stmt->bind_param("siss", $usuario, $dias, $fecha_inicio, $fecha_fin);

    if ($stmt->execute()) {
        header("Location: ../solicitud.html?success=1");
        exit();
    } else {
        echo "Error al enviar la solicitud: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>