<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
include('apps/calendar.php');
if (!isset($_SESSION['cedula'])) { header('location:../index.html'); }
$cedula = $_SESSION['cedula'];
$calendar = new Calendar(date("d-m-Y"));
$calendar->add_event('YVKE', '2021-06-16', 1, 'green');
$calendar->add_event('Feriado', '2021-06-24', 1, 'red');
?>
<link href="css/calendar.css" rel="stylesheet" type="text/css">
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
<div class="col-xl-12 col-lg-12">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Calendario</h6>
</div>
<div class="card-body text-center">
<div class="content home">
<div class="content home">
<?php echo $calendar; ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include('marcos/footer.php'); ?>

