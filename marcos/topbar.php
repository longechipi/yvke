<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
<i class="fa fa-bars"></i>
</button>
<!-- Topbar Nombre -->
 <span class="font-weight-bold"> Bienvenido: </span>
 <?php nombre();?>
 <!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">
<span class="centrado"> <?php $fecha1 = date("d-m-Y"); echo fechaCastellano($fecha1);?></span>   
<div class="topbar-divider d-none d-sm-block"></div>
<li class="nav-item dropdown no-arrow">
<a class="dropdown-item" href="#" id="userDropdown" role="button"data-toggle="modal" data-target="#logoutModal" aria-haspopup="true" aria-expanded="false">
<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
<span class="mr-2 d-none d-lg-inline text-gray-600 small">SALIR</span></a>
</li>
</ul>
</nav>