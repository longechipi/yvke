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
<form class="user">
<div class="form-group row">
<div class="col-sm-6 mb-3 mb-sm-0">
<input type="text" class="form-control form-control-user" id="exampleFirstName"
placeholder="Ingresa tu Cédula">
</div>
<div class="col-sm-6">
<input type="text" class="form-control form-control-user" id="exampleLastName"
placeholder="Confirma tu Cédula">
</div>
</div>
<div class="form-group">
<input type="email" class="form-control form-control-user" id="exampleInputEmail"
placeholder="Email Address">
</div>
<div class="form-group row">
<div class="col-sm-6 mb-3 mb-sm-0">
<input type="password" class="form-control form-control-user"
id="exampleInputPassword" placeholder="Password">
</div>
<div class="col-sm-6">
<input type="password" class="form-control form-control-user"
id="exampleRepeatPassword" placeholder="Repeat Password">
</div>
</div>
<a href="login.html" class="btn btn-primary btn-user btn-block">
Registrar Cuenta
</a>
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