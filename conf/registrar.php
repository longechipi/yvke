<?php
//Fecha creacion 14-10-2021//
//Autor: Jean Castillo//
include('db.php');
include('funciones.php');
session_start();
$cedula = pg_escape_string($_POST['cedula1']);
$cedula2 = pg_escape_string($_POST['cedula2']);
$email = pg_escape_string($_POST['email']);
$telf = pg_escape_string($_POST['telf']);
$telf1 = pg_escape_string($_POST['telf1']);

if (isset($_POST['enviar'])) {
    if ($telf != $telf1) {
        echo "<script type='text/javascript'> alert('LOS TELEFONOS NO SON IGUALES'); document.location=('../register.php'); </script>";
    }
    if ($cedula != $cedula2) {
        echo "<script type='text/javascript'> alert('LAS CEDULAS SON DIFERENTES'); document.location=('../register.php'); </script>";
    } else {
        $sql = "SELECT * FROM usuariosint WHERE login='$cedula2'";
        $sql1 = "SELECT cedper, CONCAT (apeper || ',',nomper) AS nom_tra FROM sno_personal WHERE cedper ='$cedula2'";
        $result = pg_query($conU, $sql);
        $result1 = pg_query($conP, $sql1);
        while ($row = pg_fetch_assoc($result1)) {
            $cedula = $row['cedper'];
            $nombre = $row['nom_tra'];
        }
        if (pg_num_rows($result) > 0) {
            echo "<script type='text/javascript'> alert('LA CEDULA YA SE ENCUENTRA REGISTRADA EN EL SISTEMA'); document.location=('../register.php'); </script>";
        } elseif (pg_num_rows($result1) > 0) {
            $nuevaPass = generaPass();
            $mensaje = "Bienvenid@: " . $nombre . "  al sistema integral de Talento Humano Radio Mundial.\r\n";
            $mensaje .= "\r\n";
            $mensaje .= "Usted se registro con EXITO!! al sistema integral, de no poder entrar comunicarse con Gerencia de Tecnología e Informática o con el departamento de Talento Humano\r\n";
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
            $asunto = 'Registro Nuevo Ingreso a la Intranet YVKE';
            mail($para, $asunto, utf8_decode($mensaje));
            $sql3 = "INSERT into usuariosint (login, clave, correo, telefono) values  ('$cedula2','$nuevaPass','$email','$telf1')";
            $result2 = pg_query($conU, $sql3);
            echo "<script type='text/javascript'> alert('USTED SE REGISTRO CON EXITO!! CLAVE ENVIADA AL CORREO SUMINISTRADO!!'); document.location=('../index.html'); </script>";
        } else {
            echo "<script type='text/javascript'> alert('DISCULPE LA CEDULA NO ESTA REGISTRADA EN LA INSTITUCION, POR FAVOR COMUNICARSE CON TALENTO HUMANO'); document.location=('../register.php'); </script>";
        }
    }
}
