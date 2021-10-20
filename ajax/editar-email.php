<?php
//Fecha creacion 20-10-2021//
//Autor: Jean Castillo//
include('../conf/db.php');
session_start();
$email = pg_escape_string($_POST['email']);
$confirma1 = pg_escape_string($_POST['confirma1']);
$login = pg_escape_string($_POST['cedula']);

if (isset($_POST['enviar2'])) {
    if ($email != $confirma1) {
        echo "<script type='text/javascript'> alert('LOS CORREOS NO SON IGUALES'); document.location=('../view-editar.php'); </script>";
    } else {
        $sql = "UPDATE usuariosint SET correo='$confirma1' WHERE login='$login'";
        $result = pg_query($conU, $sql);
        echo "<script type='text/javascript'> alert('USTED ACTUALIZO SU CORREO CON EXITO'); document.location=('../view-editar.php'); </script>";
    }
}
