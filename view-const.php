<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
if (!isset($_SESSION['cedula'])) { header('location:index.html'); }
?>
<?php include('marcos/header.php'); ?>
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
<div class="col-xl-6 col-lg-6">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Constancia Laboral detallada</h6>
</div>
<div class="card-body text-center">
<p class="text-justify">Aquí puedes generar tu constancia laboral detallada donde se expresan todos los conceptos que devenga el trabajador</p>
<a class="btn btn-primary" target="_blank" href="pdf/constancia.php" role="button">Generar</a>
</div>
</div>
</div>
<div class="col-xl-6 col-lg-6">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Constancia Laboral Integral</h6>
</div>
<div class="card-body text-center">
<p class="text-justify">Aquí puedes generar tu constancia laboral Integral donde se resumen todos los conceptos<strong> (Se utiliza para tramites legales)</strong></p>
<a class="btn btn-primary" target="_blank" href="pdf/constanciaintg.php" role="button">Generar</a>
</div>
</div>
</div>
</div>
</div>
<?php include('marcos/footer.php'); ?>

