<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
if (!isset($_SESSION['cedula'])) { header('location:index.html'); }
?>
<?php include('marcos/header.php'); ?>
<script language="JavaScript">
    function habilita(){
        elementos=document.getElementsByClassName("inputText");
        for(var i = 0; i < elementos.length; i++)
        {
            elementos[i].disabled = false;
        }
    }
    function deshabilita(){
        elementos=document.getElementsByClassName("inputText");
        for(var i = 0; i < elementos.length; i++)
        {
            elementos[i].disabled = true;
        }
    }
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
<h6 class="m-0 font-weight-bold text-primary">Solicitud de Fideicomiso</h6>
</div>
<div class="card-body text-center">
<p class="text-justify">Aquí puedes generar tu constancia de Fideicomiso</p>


<table class="table table-hover table-inverse table-responsive" >
  <tbody>
    <tr>
      <td>Desea usted el retiro del 75%</td>
      <td><input class="form-check-input"type="radio" name="rad" id="comple" value="75%" onclick="deshabilita()"> SI, retirare el 75% de mis Haberes<br>       
        <input class="form-check-input"type="radio" name="rad" id="parcial" value="" onclick="habilita()"> No (Ingrese el monto):
        <input type='text' name='txt1' id="monto" disabled class='inputText'></td>
    </tr>
    <tr>
      <td>Seleccione la Ciudad donde esta generando la solicitud</td>
      <td><select class="form-control" name="ciudad">
        <option value="Caracas">Caracas</option>
        <option value="Merida">Merida</option>
        <option value="Tachira">San Cristobal</option>
        <option value="Valencia">Valencia</option>
        <option value="Maracaibo">Maracaibo</option>
        <option value="Margarita">Margarita</option>
</select></td>
    </tr>
  </tbody>
</table>




<a class="btn btn-primary" target="_blank" href="pdf/conscovid-19.php" role="button">Generar</a>
</div>
</div>
</div>
</div>
</div>
<?php include('marcos/footer.php'); ?>

