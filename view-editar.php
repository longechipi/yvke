<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
if (!isset($_SESSION['cedula'])) { header('location:index.html'); }
?>
<?php include('marcos/header.php'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#chkRead").change(function () {
                if ($(this).is(":checked")) {
                    $('#email').removeAttr("readonly")
                }
                else {
                    $('#txtFaisalaId').attr('readonly', true);
                }
            });
        });
    </script>
<body id="page-top">

<div id="wrapper">
<!-- Sidebar -->
<?php include('marcos/nav.php'); ?>       
<!-- End of Sidebar -->
<div id="content-wrapper" class="d-flex flex-column">
<div id="content">
<?php include('marcos/topbar.php'); ?>
<!-- End of Topbar -->
<div class="container-fluid">         
<div class="row"> <!-- FILA 1 -->
<div class="col-xl-12 col-md-12 mb-12">
<div class="alert alert-dark " role="alert"><p class="text-center"> <strong> BIENVENIDOS AL SISTEMA INTEGRAL DE TALENTO HUMANO YVKE MUNDIAL</strong></p>
</div>
</div>

</div><!-- FIN FILA 1 -->
<div class="row"> <!-- BLOQUE 1 -->
<div class="col-xl-12 col-lg-12">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Editar Perfil</h6>
</div>
<div class="card-body text-center">
<p class="text-center">Por favor selecciona los campos que quieres editar en el sistema</p>

<!-- PENDIENTEEEEEE AQUIIIIIIIIIIIIIIIIII -->
<form class="user" method="post" action="ajax/editar-user.php">
<input id="chkRead" type="checkbox" name="chkRead" /><label for="chkRead">Test</label>
<input name="email" type="text" readonly="readonly" id="email" value="wwwss"/>
<input class="btn btn-primary btn-user btn-block" type="submit" name="enviar" id="enviar" class="fadeIn fourth" value="Registrar">
</form>

</div>
</div>
</div>

</div>
</div>
<?php include('marcos/footer.php'); ?>

