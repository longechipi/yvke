<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
if (!isset($_SESSION['cedula'])) { header('location:index.html'); }
$cedula = $_SESSION['cedula'];
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
<div class="col-xl-12 col-lg-12">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Solicitud de Vacaciones</h6>
</div>
<div class="card-body text-center">
<p class="text-center">Por favor llena el formulario para solicitar el disfrute de tus Vacaciones</p>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/formstep.css">
<script src="js/formstep.js"></script>
<div class="container">
<div class="stepwizard">
<div class="stepwizard-row setup-panel">
<div class="stepwizard-step col-xs-3"> 
<a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
<p><small>Periodos</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
<p><small>Dias</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
<p><small>Generar</small></p>
</div>
</div>
</div>
<form action="pdf/for-vaca.php" method="post" target="_blank">

<div class="panel panel-primary setup-content" id="step-1">
<div class="panel-heading">
 <h3 class="panel-title">Periodo Actual o Vencido</h3>
</div>
<div class="panel-body">
<script type="text/javascript">
function EnableDisableTextBox() {
var chkYes = document.getElementById("chkYes");
var txtPassportNumber = document.getElementById("txtPassportNumber");
txtPassportNumber.disabled = chkYes.checked ? false : true;
if (!txtPassportNumber.disabled) {
txtPassportNumber.focus();
}
}
</script>
<table class="table table-light">
<tbody>
<tr>
<td><label for="chkYes">
<input type="radio" id="chkNo" checked name="chkPassPort" value="<?php echo date("Y"); ?>" onclick="EnableDisableTextBox()" />
Si, El periodo del disfrute es del Presente Año <?php echo date("Y"); ?>
</label></td>
<td><label for="chkNo">
<input type="radio" id="chkYes" name="chkPassPort" onclick="EnableDisableTextBox()" />
No, el Periodo del disfrute esta vencido (Por favor seleccione el Año)
</label></td>
</tr>
</tbody>
</table>
<hr />
Seleccione el Año
<select class= "form-control" name="venci" id="txtPassportNumber" disabled="disabled" />>
<?php 
echo "<option disabled selected>Selecciona una opción</option>";
for($i = 2017 ; $i < date('Y'); $i++){
echo "<option value= ".$i.">$i</option>";
}
?>
</select>
<br>
<hr />
<button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
</div>
</div>
<div class="panel panel-primary setup-content" id="step-2">
<div class="panel-heading">
 <h3 class="panel-title">Dias a Disfrutar</h3>
</div>
<div class="panel-body">
<div class="table-responsive-lg">
<table class="table table-light ">
<tbody>
<tr>
<td><p>Seleccione el dia de inicio</p></td>
<td><input type="date" name="fecini" id="fecini"></td>
<td><p>Seleccione el dia de Finalizacion</p></td>
<td><input type="date" name="fecfin" id="fecfin"></td>
</tr>
</tbody>
</table>
</div>
<label for="">
<p>Ingrese los dias a disfrutar (No cuentan los fines de semana)</p>
<input class="form-control" type="number" name="dias" id="dias"></label>

<hr>
<button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
</div>
</div>
<div class="panel panel-primary setup-content" id="step-3">
<div class="panel-heading">
 <h3 class="panel-title">Generar</h3>
</div>
<div class="panel-body">

<p class="text-center"> Haga click en el boton Generar para descargar el Formato de Vacaciones</p>
<button type="submit">Enviar</button>
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

