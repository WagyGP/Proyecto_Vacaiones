<?php
session_start();
include 'conexion.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_recuperacion = trim($_POST['correo_recuperacion']);

    
    if (!filter_var($correo_recuperacion, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Correo no válido.";
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo_cuenta = ?");
    $stmt->bind_param("s", $correo_recuperacion);
    $stmt->execute();
    
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $userId = $row['id'];
        
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 3600; 

        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $userId, $token, $expires);
        if (!$stmt->execute()) {
            echo "Error al almacenar el token.";
            exit;
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = getenv('SMTP_USER'); 
            $mail->Password   = getenv('SMTP_PASS'); 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port       = 587;

            $mail->setFrom(getenv('SMTP_USER'), 'Tu Nombre');
            $mail->addAddress($correo_recuperacion); 

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body    = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='https://tusitio.com/reset_password.php?token=$token'>Restablecer contraseña</a>";

            if ($mail->send()) {
                echo "Se ha enviado un correo a {$correo_recuperacion} con instrucciones para restablecer su contraseña.";
            } else {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$e->getMessage()}";
        }
    } else {
        echo "Error: Correo no encontrado";
    }

    $stmt->close();
}
$conn->close();
?>