<?php
//Fecha creacion 15-10-2021//
//Autor: Jean Castillo//
include('../conf/db.php');
session_start();
$clave = pg_escape_string($_POST['clave']);
$login = pg_escape_string($_POST['cedula']);
$confirma = pg_escape_string($_POST['confirma']);

if (isset($_POST['enviar'])) {
    if ($clave != $confirma){
        echo "<script type='text/javascript'> alert('LAS CONTRASEÑAS NO SON IGUALES'); document.location=('../view-editar.php'); </script>";
    }else{
        $sql = "UPDATE usuariosint SET clave='$confirma' WHERE login='$login'";
        $result = pg_query($conU, $sql);
        echo "<script type='text/javascript'> alert('USTED ACTUALIZO CON EXITO LA CONTRASEÑA'); document.location=('../view-editar.php'); </script>";
    }
}