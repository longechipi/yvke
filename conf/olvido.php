<?php
//Fecha creacion 14-10-2021//
//Autor: Jean Castillo//
include('db.php');
include('funciones.php');
session_start();
$email = pg_escape_string($_POST['email']);
$cedula = pg_escape_string($_POST['cedula']);
if (isset($_POST['enviar'])) {
    $sql1 = "SELECT login, correo FROM usuariosint WHERE login='$cedula'";
    $result1 = pg_query($conU, $sql1);
    while ($row = pg_fetch_assoc($result1)) {
        $login = $row['login'];
        $correo = $row['correo'];
    }

    if (pg_num_rows($result1) > 0) {
        //echo "<script type='text/javascript'> alert('SI EXISTEEEEEE'); document.location=('../olvido-pass.php'); </script>";
        if ($cedula != $correo) {
            echo "<script type='text/javascript'> alert('EL CORREO NO CONCUERDA CON EL REGISTRADO'); document.location=('../olvido-pass.php'); </script>";
        } else {
            $nuevaPass = generaPass();
            $mensaje = "Bienvenid@: " . $nombre . "  al sistema integral de Talento Humano Radio Mundial.\r\n";
            $mensaje .= "\r\n";
            $mensaje .= "Usted actualizo con EXITO!! la contraseña del Sistema Integrado de Talento Humano\r\n";
            $mensaje .= "\r\n";
            $mensaje .= "Su clave temporal es: " . $nuevaPass . "\r\n";
            $mensaje .= "\r\n";
            $mensaje .= "Si desea Cambiarla por favor vaya a la opcion de EDITAR PERFIL en la Intranet \r\n";
            $mensaje .= "\r\n";
            $mensaje .= "Mensaje enviado el dia " . date('d/m/Y', time());
            $mensaje .= "\r\n";
            $mensaje .= "\r\n";
            $mensaje .= "Gracias.\r\n";
            $para = $email;
            $asunto = 'Actualizacion de Contraseña Intranet YVKE Mundial';
            mail($para, $asunto, utf8_decode($mensaje));
        }
    } else {
        echo "<script type='text/javascript'> alert('LA CEDULA NO EXISTE EN EL SISTEMA; POR FAVOR REGISTRARSE'); document.location=('../olvido-pass.php'); </script>";
    }
}
