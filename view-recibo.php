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
<?php include('marcos/header.php');
$cedula = $_SESSION['cedula']; ?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<!-- AJAX PARA LOS RECIBOS DEL DYSAI -->
<script language="JavaScript" type="text/JavaScript">
  $(document).ready(function(){
    $("#select1").change(function(event){
      var id = $("#select1").find(':selected').val();
        $("#select2").load('ajax/recibo-dysai.php?id='+id);
          });
      });
</script>
<!-- AJAX PARA LOS RECIBOS DEL SIGESP -->
<script language="javascript">
  $(document).ready(function() {
    $("#anocur").change(function() {
      $('#quinc').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
      $("#anocur option:selected").each(function() {
        anocur = $(this).val();
        $.post("ajax/reciboSigesp-2019.php", {
          anocur: anocur
        }, function(data) {
          $("#mes").html(data);
        });
      });
    })
  });
  $(document).ready(function() {
    $("#mes").change(function() {
      $("#mes option:selected").each(function() {
        mes = $(this).val();
        $.post("ajax/recibo-2019.php", {
          mes: mes
        }, function(data) {
          $("#quinc").html(data);
        });
      });
    })
  });
</script>
<!-- AJAX PARA LOS RECIBOS DEL SIGESP 2021 -->
<script language="javascript">
  $(document).ready(function() {
    $("#anocur").change(function() {
      $('#quinc').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
      $("#anocur option:selected").each(function() {
        anocur = $(this).val();
        $.post("ajax/reciboSigesp-2021.php", {
          anocur: anocur
        }, function(data) {
          $("#mes").html(data);
        });
      });
    })
  });
  $(document).ready(function() {
    $("#mes").change(function() {
      $("#mes option:selected").each(function() {
        mes = $(this).val();
        $.post("ajax/recibo-2021.php", {
          mes: mes
        }, function(data) {
          $("#quinc").html(data);
        });
      });
    })
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
            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Recibos del año <?= date('Y') ?> (Bs Digital)</h6>
                </div>
                <div class="card-body text-center">
                  <form target="_blank" action="pdf/reciboSigesp.php" method="post">
                    <strong>Seleccione Año</strong>
                    <select name="anocur" id="anocur" class="form-control">
                      <?php
                      $sql2 = "SELECT anocur FROM sno_hpersonalnomina WHERE REPLACE(ltrim(REPLACE(codper,'0',' ')),' ','0')='$cedula' GROUP BY anocur ORDER BY anocur ASC";
                      echo '<option selected>Selecciona el Año</option>';
                      $resul2 = pg_query($conP, $sql2);
                      while ($row = pg_fetch_assoc($resul2)) {
                        echo '<option value="' . htmlspecialchars($row['anocur']) . '"> ' . $row['anocur'] . ' </option>';
                      }
                      ?>
                    </select>
                    <strong>Seleccione Mes:</strong>
                    <select name="mes" id="mes" class="form-control">Seleccione Mes</select>
                    <strong>Selccione Quincena:</strong>
                    <select name="quinc" id="quinc" class="form-control">
                      <option value="">Seleccione Quincena</option>
                    </select>
                    <br />
                    <div class="col text-center">
                      <button class="btn btn-success" type="submit" name="formSubmit"> Ver Recibo </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Recibos del año 2019 al 2020</h6>
                </div>
                <div class="card-body text-center">
                  <form target="_blank" action="pdf/reciboSigesp.php" method="post">
                    <strong>Seleccione Año</strong>
                    <select name="anocur" id="anocur" class="form-control">
                      <?php
                      $sql1 = "SELECT anocur FROM sno_hpersonalnomina WHERE REPLACE(ltrim(REPLACE(codper,'0',' ')),' ','0')='$cedula' GROUP BY anocur ORDER BY anocur ASC";
                      echo '<option selected>Selecciona el Año</option>';
                      $resul1 = pg_query($conn2020, $sql1);
                      while ($row = pg_fetch_assoc($resul1)) {
                        echo '<option value="' . htmlspecialchars($row['anocur']) . '"> ' . $row['anocur'] . ' </option>';
                      }
                      ?>
                    </select>
                    <strong>Seleccione Mes:</strong>
                    <select name="mes" id="mes" class="form-control">Seleccione Mes</select>
                    <strong>Selccione Quincena:</strong>
                    <select name="quinc" id="quinc" class="form-control">
                      <option value="">Seleccione Quincena</option>
                    </select>
                    <br />
                    <div class="col text-center">
                      <button class="btn btn-success" type="submit" name="formSubmit"> Ver Recibo </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div> <!-- FIN BLOQUE 1 -->

          <div class="row">
            <!-- BLOQUE 2 -->

            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Recibos hasta el Año 2018</h6>
                </div>
                <div class="card-body text-center">
                  <form target="_blank" action="pdf/reciboDysai.php" method="post">
                    <p><strong> Seleccione año</strong></p>
                    <select name="ano[]" id="select1" class="form-control">
                      <?php

                      $sql = "SELECT per_base FROM vw_rhnommvd WHERE fic_cedula = '$cedula' group by per_base  order by per_base asc";
                      $resul = pg_query($conDy, $sql);
                      echo '<option selected>Selecciona el Año</option>';
                      while ($row = pg_fetch_assoc($resul)) {
                        echo '<option value="' . htmlspecialchars($row['per_base']) . '"> ' . $row['per_base'] . ' </option>';
                      }
                      ?>
                    </select>
                    <p><strong> Seleccione Mes</strong></p>
                    <select name="mes" id="select2" class="form-control">Seleccione Mes</select>
                    <p><strong> Seleccione Quincena</strong></p>
                    <select name="quincena" class="form-control">
                      <option value="01" class="form-control form-control-sm">Primera Quincena</option>
                      <option value="16" class="form-control form-control-sm">Segunda Quincena</option>
                    </select>
                    <br />
                    <div class="col text-center">
                      <button class="btn btn-success" type="submit" name="formSubmit"> Ver Recibo </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include('marcos/footer.php'); ?>