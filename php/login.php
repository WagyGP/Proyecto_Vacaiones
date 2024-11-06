<?php
session_start();
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña_login'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        
        if (password_verify($contraseña, $row['contraseña'])) {
            $_SESSION['usuario'] = $usuario; 
            
            header("Location: solicitud.php"); 
            exit();
        } else {
            echo "Error: Contraseña incorrecta"; 
        }
    } else {
        echo "Error: Usuario no encontrado"; 
    }

    $stmt->close();
}
$conn->close();
?>