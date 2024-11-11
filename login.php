<?php
session_start();

// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "gestor_tareas";
$username = "root";  // Cambia si tienes una contraseña o un usuario diferente
$password = "";

// Conectar a la base de datos
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $correo = $_POST["correo_electronico"];
        $contrasena = $_POST["contrasena"];

        // Preparar la consulta para obtener el usuario
        $sql = "SELECT id, contrasena, intentos_fallidos, bloqueado FROM usuarios WHERE correo_electronico = :correo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Verificar si la cuenta está bloqueada
            if ($usuario['bloqueado'] == 1) {
                echo "Cuenta bloqueada por múltiples intentos fallidos.";
                exit;
            }

            // Verificar la contraseña
            if (password_verify($contrasena, $usuario['contrasena'])) {
                // Restablecer intentos fallidos
                $sql = "UPDATE usuarios SET intentos_fallidos = 0 WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $usuario['id']);
                $stmt->execute();

                // Iniciar sesión y redirigir al panel de tareas
                $_SESSION['usuario_id'] = $usuario['id'];
                header("Location: panel_tareas.php");
                exit;
            } else {
                // Incrementar el contador de intentos fallidos
                $intentos = $usuario['intentos_fallidos'] + 1;
                if ($intentos >= 5) {
                    // Bloquear la cuenta
                    $sql = "UPDATE usuarios SET bloqueado = 1 WHERE id = :id";
                    echo "Has alcanzado el límite de intentos. La cuenta ha sido bloqueada.";
                } else {
                    // Actualizar los intentos fallidos
                    $sql = "UPDATE usuarios SET intentos_fallidos = :intentos WHERE id = :id";
                    echo "Credenciales incorrectas. Intentos restantes: " . (5 - $intentos);
                }
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':intentos', $intentos);
                $stmt->bindParam(':id', $usuario['id']);
                $stmt->execute();
            }
        } else {
            echo "Correo electrónico no encontrado.";
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
