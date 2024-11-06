<?php
session_start();
include 'conexion.php'; // Incluir la conexión a la base de datos

$error_message = ""; // Variable para almacenar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $apellido_completo = $_POST['apellido_completo'];
    $correo_cuenta = $_POST['correo_cuenta'];
    $contraseña_cuenta = $_POST['contraseña_cuenta'];

    // Formar el campo usuario
    $usuario = strtolower(str_replace(' ', '', $nombre_completo)) . strtolower(str_replace(' ', '', $apellido_completo)) . "1234";

    // Verificar si el correo ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo_cuenta = ?");
    $stmt->bind_param("s", $correo_cuenta);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // El correo ya está registrado
        $error_message = "Error: El correo electrónico ya está en uso.";
    } else {
        // Preparar y ejecutar la consulta para insertar el nuevo usuario
        try {
            // Hashear la contraseña antes de almacenarla
            $hashed_password = password_hash($contraseña_cuenta, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, apellido_completo, correo_cuenta, usuario, contraseña) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nombre_completo, $apellido_completo, $correo_cuenta, $usuario, $hashed_password);

            if ($stmt->execute()) {
                // Registro exitoso, redirigir a index.html
                $_SESSION['usuario'] = $usuario; // Guardar el usuario en la sesión
                header("Location: ../index.html"); // Cambia esto a la ruta correcta de tu archivo HTML
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) { // Código de error para entrada duplicada
                $error_message = "Error: El correo electrónico ya está en uso.";
            } else {
                throw $e; // Re-lanzar la excepción si no es un error duplicado
            }
        }
    }

    $stmt->close();
}
$conn->close();
?>