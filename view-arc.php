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
<div class="col-xl-6 col-lg-6">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">DETALLE ARC 2021</h6>
</div>
<div class="card-body text-center">
<p class="text-center">ARC correspondiente al Ejercicio fiscal del Año 2021</p>
<form action="pdf/arc.php" id="formulario" method="post" target="_blank">
<select class="form-control"name="ano[]">
<?php
$sql ="SELECT anocur from sno_hpersonalnomina where REPLACE(ltrim(REPLACE(codper,'0',' ')),' ','0')='$cedula'
group by anocur order by anocur asc";
$resultado = pg_query($conP,$sql);
echo '<option disabled selected>Selecciona el Año</option>';        
 while ($row = pg_fetch_assoc($resultado)) {
echo '<option value="'.htmlspecialchars($row['anocur']).'"> '.$row['anocur'].' </option>';
}
?>
</select>
<br>
<center><input class="btn btn-primary"type="submit" name="formSubmit" value="Enviar"></center>
</form>
</div>
</div>
</div>
<div class="col-xl-6 col-lg-6">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">DETALLE ARC 2019-2020</h6>
</div>
<div class="card-body text-center">
<p class="text-center">Arc Correspondiente al Ejercicio Fiscal 2019-2020</strong></p>
<form action="pdf/arc2020.php" id="formulario" method="post" target="_blank">
<select class="form-control"name="ano[]">
<?php
$sql ="SELECT anocur from sno_hpersonalnomina where REPLACE(ltrim(REPLACE(codper,'0',' ')),' ','0')='$cedula'
group by anocur order by anocur asc";
$resultado1 = pg_query($conP2,$sql);
echo '<option disabled selected>Selecciona el Año</option>';        
 while ($row = pg_fetch_assoc($resultado1)) {
echo '<option value="'.htmlspecialchars($row['anocur']).'"> '.$row['anocur'].' </option>';
}
?>
</select>
<br>
<center><input class="btn btn-primary"type="submit" name="formSubmit" value="Enviar"></center>
</form>
</div>
</div>
</div>
</div>
</div>
<?php include('marcos/footer.php'); ?>

