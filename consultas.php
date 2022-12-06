<?php

    session_start();

    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
        $_SESSION['error'] = "Para aceder a la aplicación antes debe autenticarse";
        header("Location: ./login.php");
        die();
    }

    include_once("./bd/claseConexionBD.php");

    $conec = new ConectarBD();

    $query = $conec->getConexion()->prepare("SELECT * FROM usuarios");
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <style>
        table, tr, td, th{
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        thead{
            background-color: blue;
            color: white;
        }

    </style>
</head>
<body>
    <h1>Usuario conectado <?php echo $_SESSION['nombre'] ?> <?php echo $_SESSION['apellidos'] ?></h1>
    <h2>Relación de usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Nombre</th>
                <th>Apellidos</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($user = $query->fetch()){ 
                    echo "<tr>";
                        echo "<td>" . $user['usuario'] . "</td>" . "<td>" . $user['rol'] . "</td>" . "<td>" . $user['nombre'] . "</td>" . "<td>" . $user['apellidos'] . "</td>"; ?>
                        <td><a href="modificar.php?user=<?php echo $user['usuario'] ?>">Modificar</a></td>
                    </tr>
               <?php } 
                   $conec->cerrarConexion(); 
               ?>
        </tbody>
    </table>
    <p><a href="./administrador.php">Regresar al menu anterior</a></p>
    <p><a href="./bd/logout.php">Cerrar session</a></p>
</body>
</html>