<?php
$servername = "localhost:3309";  // Servidor local en XAMPP
$username = "root";         // Usuario por defecto en XAMPP
$password = "";             // La contraseña por defecto suele estar vacía
$dbname = "gestor_tareas"; // Cambia por el nombre de tu base de datos

// Intentar la conexión con MySQL usando PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conexión exitosa
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

