<?php
// Incluir la conexión a la base de datos y empezar la sesión
include 'conexion.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: inicio.php");
    exit();
}

// Obtener el ID del usuario actual
$user_id = $_SESSION['user_id'];

// Consulta para obtener las tareas del usuario
$stmt = $conn->prepare("SELECT titulo, descripcion, fecha_limite, estado_id FROM tareas WHERE usuario_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tareas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f8;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .tarea {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #4CAF50;
        }
        .tarea h3 {
            margin: 0;
            color: #333;
        }
        .tarea p {
            margin: 5px 0;
            color: #555;
        }
        .fecha {
            color: #888;
            font-size: 12px;
        }
        .estado {
            font-size: 12px;
            color: #4CAF50;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Mis Tareas</h2>

    <?php while ($tarea = $result->fetch_assoc()) { ?>
        <div class="tarea">
            <h3><?php echo htmlspecialchars($tarea['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($tarea['descripcion']); ?></p>
            <p class="fecha">Fecha límite: <?php echo htmlspecialchars($tarea['fecha_limite']); ?></p>
            <p class="estado"><?php echo $tarea['estado_id'] == 1 ? 'Pendiente' : ($tarea['estado_id'] == 2 ? 'En progreso' : 'Completada'); ?></p>
        </div>
    <?php } ?>

</div>

</body>
</html>
