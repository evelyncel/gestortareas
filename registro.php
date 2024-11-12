<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #333;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrarse</h2>

    <!-- Formulario de registro -->
    <form method="POST" action="registro.php">
        <input type="text" name="nombre_completo" placeholder="Nombre completo" required>
        <input type="email" name="correo_electronico" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <input type="password" name="confirmar_contrasena" placeholder="Confirmar contraseña" required>
        
        <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
        
        <button type="submit">Registrarse</button>
    </form>

    <!-- Enlace para volver a la pantalla de inicio de sesión -->
    <a class="link" href="inicio.php">¿Ya tienes una cuenta? Inicia sesión</a>
</div>

</body>
</html>