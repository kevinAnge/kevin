<?php

    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
        $_SESSION['error'] = "Para aceder a la aplicación antes debe autenticarse";
        header("Location: ./login.php");
        die();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
</head>
<body>
    <h1>Usuario Conectado: <?php echo $_SESSION['nombre'] ?> <?php echo $_SESSION['apellidos'] ?></h1>
    <h2>Acceso solo para Administradores</h2>
    <p><a href="./rrhh.php">Ir a RRHH</a></p>
    <p><a href="./fin.php">Ir a Finanzas</a></p>
    <p><a href="./consultas.php">Ir a consultas</a></p><br>
    <p><a href="./bd/logout.php">Cerrar session</a></p>
</body>
</html>