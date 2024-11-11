<?php
// Incluir conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verificar que las contraseñas coincidan
    if ($contrasena != $confirmar_contrasena) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Validar si el correo ya existe en la base de datos
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo_electronico = ?");
        $stmt->bind_param("s", $correo_electronico);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "El correo ya está registrado. Intente iniciar sesión.";
        } else {
            // Encriptar la contraseña
            $hashed_password = password_hash($contrasena, PASSWORD_BCRYPT);
            
            // Insertar el nuevo usuario en la base de datos
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo_electronico, contrasena) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre_completo, $correo_electronico, $hashed_password);
            
            if ($stmt->execute()) {
                // Redirigir al inicio de sesión después del registro exitoso
                header("Location: login.php?registro=exito");
                exit();
            } else {
                $error = "Error al registrar. Intente de nuevo.";
            }
        }
    }
}
?>
