<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
if (!isset($_SESSION['cedula'])) {
  header('location:index.html');
}
?>
<?php include('marcos/header.php'); ?>
<script language="JavaScript">
  function habilita() {
    elementos = document.getElementsByClassName("inputText");
    for (var i = 0; i < elementos.length; i++) {
      elementos[i].disabled = false;
    }
  }

  function deshabilita() {
    elementos = document.getElementsByClassName("inputText");
    for (var i = 0; i < elementos.length; i++) {
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
          <div class="row">
            <!-- FILA 1 -->
            <div class="col-xl-12 col-md-12 mb-12">
              <div class="alert alert-dark " role="alert">
                <p class="text-center"> <strong> BIENVENIDOS AL SISTEMA INTEGRAL DE TALENTO HUMANO YVKE MUNDIAL</strong></p>
              </div>
            </div>
          </div><!-- FIN FILA 1 -->
          <div class="row">
            <!-- BLOQUE 1 -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Solicitud de Fideicomiso</h6>
                </div>
                <div class="card-body text-center">
                  <form name='frm' method="post" action="pdf/presta.php">
                    <p class="text-center">Aquí puedes generar tu constancia de Fideicomiso</p>
                    <p class="text-center">Por favor selecciona la opción para que puedas generar tu constancia de Fidecomiso</p>
                    <div class="row">
                      <div class="col-xl-4 col-lg-4">
                      </div>
                      <div class="col-xl-4 col-lg-4">
                        <div class="form-check text-justify">
                          <input class="form-check-input" type="radio" name="rad" id="comple" required value="75%" onclick="deshabilita()">
                          <label class=" form-check-label" for="flexRadioDefault1">
                            Si, deseo retirar el 75% de mis haberes
                          </label>
                        </div>
                        <div class="form-check text-justify">
                          <input class="form-check-input" type="radio" name="rad" id="parcial" value="" required onclick="habilita()">
                          <label class="form-check-label" for="flexRadioDefault1">
                            No, voy a ingresar un monto diferente
                          </label>
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">

                            <label class="input-group-text" for="inputGroupSelect01">Ingrese el Monto</label>
                          </div>
                          <input type='text' name='txt1' id="monto" disabled class='inputText'></td>
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Selecciona la Ciudad</label>
                          </div>
                          <select class="custom-select" id="inputGroupSelect01" name="ciudad">
                            <option selected disabled="disabled">Ciudad</option>
                            <option value="Caracas">Caracas</option>
                            <option value="Merida">Merida</option>
                            <option value="Tachira">San Cristobal</option>
                            <option value="Valencia">Valencia</option>
                            <option value="Maracaibo">Maracaibo</option>
                            <option value="Margarita">Margarita</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-xl-4 col-lg-4">
                      </div>
                    </div>
                    <button class="btn btn-primary" type="submit" id="enviar2" name="enviar2" value="Cambiar"> Generar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include('marcos/footer.php'); ?>