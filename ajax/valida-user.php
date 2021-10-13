<?php 
require('../conf/db.php');
include('../conf/valida.php');
include('../conf/funciones.php');
sleep(1);
if (isset($_POST)) {
    $username = (string)$_POST['username'];
    $sql = "SELECT * FROM usuariosint WHERE login = '$username'";
    $resul = pg_query($conU,$sql);
    if(pg_num_rows($resul) > 0 ) {
        echo '<div class="alert alert-danger"><strong></strong> Cedula no cargada, comunicarse con el Departamento de Talento Humano</div>';
    }else{
        echo '<div class="alert alert-success"><strong>Felicidades</strong> Puedes registrarte</div>'; 
    }     
}
?>