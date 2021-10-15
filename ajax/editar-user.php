<?php
//Fecha creacion 14-10-2021//
//Autor: Jean Castillo//
include('db.php');
include('funciones.php');
session_start();
if (isset($_POST['enviar'])) {
    $email = pg_escape_string($_POST['email']);
    echo $email; 
}