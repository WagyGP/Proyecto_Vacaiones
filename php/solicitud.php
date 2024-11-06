<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vacaciones</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Estilos generales -->
    <link rel="stylesheet" href="../assets/css/solicitud.css"> <!-- Estilos específicos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>

<div class="container">
    <div class="header-icons">
        <a href="historial.html" title="Historial de Solicitudes"><i class="fas fa-history"></i></a>
        <a href="configuracion.html" title="Configuración"><i class="fas fa-cog"></i></a>
    </div>
    <h1>Solicitud de Vacaciones</h1>
    <form id="vacationForm" action="php/enviar_solicitud.php" method="POST">
        <label for="days">Seleccione los días de vacaciones (1-28):</label>
        <select id="days" name="days" required>
            <option value="" disabled selected>Seleccione días</option>
            <script>
                for (let i = 1; i <= 28; i++) {
                    document.write('<option value="' + i + '">' + i + '</option>');
                }
            </script>
        </select>

        <label for="startDate">Fecha de inicio:</label>
        <input type="date" id="startDate" name="startDate" required>

        <label for="endDate">Fecha de fin:</label>
        <input type="date" id="endDate" name="endDate" required>

        <button type="submit"><i class="fas fa-paper-plane"></i> Enviar Solicitud</button>
    </form>

    <div id="confirmationMessage" style="display:none; margin-top:20px;">
        <p>Su solicitud de vacaciones ha sido enviada con éxito.</p>
    </div>

    <button onclick="window.location.href='index.html';">Volver a Inicio</button>
</div>

<script src="../assets/js/script.js"></script> 

</body>
</html>