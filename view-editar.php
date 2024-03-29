<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
include('conf/db.php');
include('conf/valida.php');
include('conf/funciones.php');
if (!isset($_SESSION['cedula'])) {
    header('location:index.html');
}
$cedula = $_SESSION['cedula'];
$sql = "SELECT * FROM usuariosint WHERE login ='$cedula'";
$resul = pg_query($conU, $sql);
while ($row = pg_fetch_assoc($resul)) {
    $login = $row['login']; //NOMBRE DE LA PERSONA
    $clave = $row['clave']; //CEDULA DE LA PERSONA
    $email = $row['correo']; //FECHA DE INGRESO
}
?>
<?php include('marcos/header.php'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#chkRead").change(function() {
            if ($(this).is(":checked")) {
                $('#clave').removeAttr("readonly")

            } else {
                $('#clave').attr('readonly', true);
            }
            if ($(this).is(":checked")) {
                $('#confirma').removeAttr("readonly")

            } else {
                $('#confirma').attr('readonly', true);
            }

        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#chkRead2").change(function() {
            if ($(this).is(":checked")) {
                $('#email').removeAttr("readonly")

            } else {
                $('#email').attr('readonly', true);
            }
            if ($(this).is(":checked")) {
                $('#confirma1').removeAttr("readonly")

            } else {
                $('#confirma1').attr('readonly', true);
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
                    <div class="row">
                        <!-- FILA 1 -->
                        <div class="col-xl-12 col-md-12 mb-12">
                            <div class="alert alert-dark " role="alert">
                                <p class="text-center"> <strong> BIENVENIDOS AL SISTEMA INTEGRAL DE TALENTO HUMANO YVKE MUNDIAL</strong></p>
                            </div>
                        </div>
                    </div><!-- FIN FILA 1 -->

                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <!-- BLOQUE 1 -->

                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Editar Perfil</h6>
                                </div>
                                <div class="card-body text-center">
                                    <p class="text-center"> <strong> Hola, <?php nombre(); ?></strong> <br> Por favor selecciona el campo que quieres editar en el sistema </p>

                                    <div class="row">
                                        <!-- COLUMNA PARA ACTUALIZAR LA CLAVE -->
                                        <div class="col-sm">
                                            <form class="user" method="post" action="ajax/editar-user.php">

                                                <div class="text-justify">

                                                    <div class="form-check">
                                                        <input id="chkRead" type="checkbox" class="form-check-input" name="chkRead" />
                                                        <label for="chkRead">Editar Contraseña</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Ingrese Contraseña</label>
                                                        <input id="cedula" type="text" style="display:none;" class="form-control form-control-user" name="cedula" readonly value="<?php echo $login; ?>" />
                                                        <input name="clave" type="text" readonly="readonly" id="clave" class="form-control form-control-user" value="<?php echo $clave; ?>" />
                                                        <small id="emailHelp" class="form-text text-muted">Ingrese una contraseña robusta</small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Confirmar tu contraseña</label>
                                                        <input id="cedula" type="text" style="display:none;" class="form-control form-control-user" name="cedula" readonly value="<?php echo $login; ?>" />
                                                        <input name="confirma" type="text" readonly="readonly" id="confirma" class="form-control form-control-user" />
                                                        <small id="emailHelp" class="form-text text-muted">Por favor confirma tu contraseña</small>
                                                    </div>
                                                </div>
                                                <input class="btn btn-primary btn-user btn-block" type="submit" name="enviar" id="enviar" class="fadeIn fourth" value="Actualizar Contraseña">
                                            </form>
                                        </div>
                                        <!-- COLUMNA PARA ACTUALIZAR EL CORREO -->
                                        <div class="col-sm">
                                            <form class="user" method="post" action="ajax/editar-email.php">

                                                <div class="text-justify">

                                                    <div class="form-check">
                                                        <input id="chkRead2" type="checkbox" class="form-check-input" name="chkRead2" />
                                                        <label for="chkRead2">Editar Correo Electronico</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail2">Ingrese Correo Electronico</label>
                                                        <input id="cedula" type="text" style="display:none;" class="form-control form-control-user" name="cedula" readonly value="<?php echo $login; ?>" />
                                                        <input name="email" type="text" readonly="readonly" id="email" class="form-control form-control-user" value="<?php echo $email; ?>" />
                                                        <small id="emailHelp" class="form-text text-muted">Ingresa tu nuevo correo electronico</small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Confirmar tu Correo Electronico</label>
                                                        <input id="email" type="text" style="display:none;" class="form-control form-control-user" name="login" readonly value="<?php echo $login; ?>" />
                                                        <input name="confirma1" type="text" readonly="readonly" id="confirma1" class="form-control form-control-user" />
                                                        <small id="emailHelp" class="form-text text-muted">Por favor confirma tu correo electronico</small>
                                                    </div>
                                                </div>
                                                <input class="btn btn-primary btn-user btn-block" type="submit" name="enviar2" id="enviar2" class="fadeIn fourth" value="Actualizar Correo">
                                            </form>
                                        </div>
                                    </div>














                                </div>
                            </div>
                        </div><!-- FIN COLUMNA -->

                    </div>
                </div>
                <?php include('marcos/footer.php'); ?>