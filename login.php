<?php
    session_start();
    if(isset($_POST['enviar'])){
        $errors = [];

        empty($_POST['user']) ? array_push($errors, "Debe introducir el usuario") : $user = $_POST['user'];
        empty($_POST['pass']) ? array_push($errors, "Debe introducir la contraseña") : $pass = $_POST['pass'];

        if(count($errors) == 0){
            include_once("./bd/claseConexionBD.php");
            $conect = new ConectarBD();

            $query = $conect->getConexion()->prepare("SELECT * FROM usuarios WHERE usuario=:user AND password=:pass");
            $query->execute([':user' => $user, ':pass' => $pass]);
            $rows = $query->fetch();
            $conect->cerrarConexion();

            if($query->rowCount() > 0){
                $_SESSION['rol'] = $rows['rol'];
                $_SESSION['nombre'] = $rows['nombre'];
                $_SESSION['apellidos'] = $rows['apellidos'];
                
                if($_SESSION['rol'] == 'admin'){
                    header("Location: ./administrador.php");
                    die();
                }
                else if($_SESSION['rol'] == 'rrhh'){
                    header("Location: ./rrhh.php");
                    die();
                }
                else{
                    header("Location: ./fin.php");
                    die();
                }
            }
            else{
                $errorUserPass = "Usuario/Contraseña no validos";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de acessos</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="post">
        <label>Usuario:</label>
        <input type="text" name="user"><br/>
        <label>Contraseña:</label>
        <input type="password" name="pass">
        <input type="submit" name="enviar" value="Entrar">
    </form>

    <?php

        if(isset($errors) && count($errors) > 0){

            foreach($errors as $er){
                echo "<p style='color: red'>$er</p>";
            }

        }


        if(isset($errorUserPass)){
            echo "<p style='color: red'>$errorUserPass</p>";
        }

        if(isset($_SESSION['error'])){
            echo "<p style='color: red'>". $_SESSION['error'] . "</p>";
        }
    ?>
</body>
</html>