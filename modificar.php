<?php

    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
        $_SESSION['error'] = "Para aceder a la aplicación antes debe autenticarse";
        header("Location: ./login.php");
        die();
    }

    if(isset($_POST['enviar'])){
        $errors = [];
        empty($_POST['nombre']) ? array_push($errors, "Debe introducir su nombre") : $user = $_POST['nombre'];
        empty($_POST['apellidos']) ? array_push($errors, "Debe introducir sus apellidos") : $pass = $_POST['apellidos'];
        empty($_POST['user']) ? array_push($errors, "Debe introducir el usuario") : $user = $_POST['user'];
        empty($_POST['pass']) ? array_push($errors, "Debe introducir la contraseña") : $pass = $_POST['pass'];

        if(count($errors) == 0){
            include_once("./bd/claseConexionBD.php");
            $conect = new ConectarBD();

            $query = $conect->getConexion()->prepare("UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, password=:pass WHERE usuario=:user");
            $query->execute([':user' => $user, ':nombre' => $nombre, ':apellidos' => $apellidos, ':pass' => $pass]);

            if($query->rowCount() > 0){
                echo "usuario modificado correctamente";
            }
            $conect->cerrarConexion();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
</head>
<body>
    <h1>Modificar</h1>
    <form action="" method="POST">
        <label>Nombre</label>
        <input type="text" value="<?php if(isset($_GET['user'])) echo $_GET['user'] ?>" hidden name="user">
        <input type="text" name="nombre"><br>
        <label>Apellidos</label>
        <input type="text" name="apellidos"><br>
        <label>Contraseña</label>
        <input type="password" name="pass">
        <input type="submit" name="enviar" value="Modificar">
    </form>
    <?php
        if(isset($errors) && count($errors) > 0){

            foreach($errors as $er){
                echo "<p style='color: red'>$er</p>";
            }

        }
    ?>
</body>
</html>