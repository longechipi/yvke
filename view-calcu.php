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
<div class="col-xl-6 col-lg-6 col-md6">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Calendario</h6>
</div>
<div class="card-body text-center">

<link rel="stylesheet" href="css/calcu.css">
<script>
 function calcNumbers(result){
 form.displayResult.value=form.displayResult.value+result;
 
 }
 </script>
  <div class="container2">
<form name="form">
 <div class="display2">
 <input type="text" placeholder="0" name="displayResult" />
 </div>
 <div class="buttons2">
   <div class="row2">
 <input type="button" name="b7" value="7" onClick="calcNumbers(b7.value)">
   <input type="button" name="b8" value="8" onClick="calcNumbers(b8.value)">
   <input type="button" name="b9" value="9" onClick="calcNumbers(b9.value)">
   <input type="button" name="addb" value="+" onClick="calcNumbers(addb.value)">
 </div>
 
 <div class="row2">
 <input type="button" name="b4" value="4" onClick="calcNumbers(b4.value)">
   <input type="button" name="b5" value="5" onClick="calcNumbers(b5.value)">
   <input type="button" name="b6" value="6" onClick="calcNumbers(b6.value)">
   <input type="button" name="subb" value="-" onClick="calcNumbers(subb.value)">
 </div>
 
 <div class="row2">
 <input type="button" name="b1" value="1" onClick="calcNumbers(b1.value)">
   <input type="button" name="b2" value="2" onClick="calcNumbers(b2.value)">
   <input type="button" name="b3" value="3" onClick="calcNumbers(b3.value)">
   <input type="button" name="mulb" value="*" onClick="calcNumbers(mulb.value)">
 </div>
 
 <div class="row2">
 <input type="button" name="b0" value="0" onClick="calcNumbers(b0.value)">
   <input type="button" name="potb" value="." onClick="calcNumbers(potb.value)">
   <input type="button" name="divb" value="/" onClick="calcNumbers(divb.value)">
   <input type="button" class="red" value="=" onClick="displayResult.value=eval(displayResult.value)">
 </div>
 </div>
 
 </form>










 </div>
</div>
</div>
</div>
</div>
</div>
<?php include('marcos/footer.php'); ?>

