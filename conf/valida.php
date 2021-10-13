<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include ('db.php');
session_start();
if(isset($_POST['enviar'])){
    $usuario = pg_escape_string($_POST['login']);
    $pass = pg_escape_string($_POST['pass']);
    if($usuario == "" || $pass == null){
        echo "<script>alert('Error: usuario y/o clave vacios!!');</script>";
    }else{
        $sql = "select count(*) as control 
        from usuariosint where login='$usuario' and clave='$pass' limit 1";
        $result = pg_query($conU,$sql);
        $row = pg_fetch_array($result);
        $count = $row['control'];
        if($count > 0){
            $_SESSION['cedula'] = $usuario;
            header('Location: ../inicio.php');
        }else{
            echo "<script type='text/javascript'> alert('USUARIO O CLAVE INVALIDAS'); document.location=('../index.html'); </script>";
        }
    }
}
?> 