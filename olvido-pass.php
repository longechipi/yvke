<?php include('marcos/header.php'); ?>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistema Integrado de Talento Humano </h1>
                                        <h1 class="h4 text-gray-900 mb-2">¿Olvido su contraseña?</h1>
                                        <p class="mb-4">Lo entendemos, pasan cosas. Simplemente ingrese su dirección de correo electrónico y cédula a continuación y le enviaremos un enlace para restablecer su contraseña.</p>
                                    </div>
                                    <form class="user" method="post" action="conf/olvido.php">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Ingrese Email">
                                            <br>
                                            <input type="number" class="form-control form-control-user" id="cedula" name="cedula" aria-describedby="cedula" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" placeholder="Ingrese Cédula">
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" type="submit" name="enviar" id="enviar" class="fadeIn fourth" value="Reiniciar Contraseña">
                                    </form>
                                    <hr>
                                    <hr>
                                    <div class="text-center">
                                        <a class="medium" href="register.php">¿Quieres Registrarte?</a>
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