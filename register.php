<?php include('marcos/header.php'); ?>

<body class="bg-gradient-primary">
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Sistema Integrado de Talento Humano </h1>
                                <h1 class="h4 text-gray-900 mb-4">Crear Cuenta </h1>
                            </div>
                            <form class="user" method="post" action="conf/registrar.php">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" class="form-control form-control-user" id="cedula1" name="cedula1" placeholder="Ingresa tu Cédula" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control form-control-user" id="cedula2" name="cedula2" placeholder="Confirma tu Cédula" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Direccion de Correo" required>
                                </div>
                                <input class="btn btn-primary btn-user btn-block" type="submit" name="enviar" id="enviar" class="fadeIn fourth" value="Registrar">
                                <hr>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="medium" href="olvido-pass.php">¿Olvido Contraseña?</a>
                            </div>
                            <div class="text-center">
                                <a class="medium" href="index.html">Inicio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>