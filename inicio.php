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
									<h6 class="m-0 font-weight-bold text-primary">Yvke Mundial</h6>
								</div>
								<div class="card-body text-center">
									<img src="img/logo.png" class="img-fluid" alt="Sistema Radio Mundial">
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6">
							<!-- BLOQUE 2 -->
							<div class="card shadow mb-4">
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">Cumpleañeros del mes de <?php mesActual(); ?></h6>
								</div>
								<div class="card-body">
									<?php
									$sql = "SELECT CONCAT (nomper  || ' ',apeper) as nombre_completo, extract(day from fecnacper) as dia FROM sno_personal  WHERE extract(month from fecnacper)=extract(month from now()) and estper ='1' order by extract(day from fecnacper) asc";
									$cumple = pg_query($conP, $sql);
									?>
									<div class="table-responsive">
										<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
											<thead>
												<tr>
													<th>Nombre y Apellido</th>
													<th>Dia</th>
												</tr>
											</thead>
											<tbody>
												<?php
												while ($row = pg_fetch_array($cumple)) {
													echo "<tr>";
													echo "<td>" . $row["nombre_completo"] . "</td>";
													echo "<td>" . $row["dia"] . "</td>";
													echo "</tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div><!-- FIN Bloque 2-->
					</div><!-- FIN BLOQUE 1 -->
					<div class="row">
						<!-- INICIO FILA 2 -->
						<div class="col-lg-6 mb-6">
							<!-- INICIO Bloque 2-->
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary">Sugerencias</h6>
								</div>
								<div class="card-body">
									<p class="text-justify">En pro del buen funcionamiento del sistema de Talento HUmano (Intranet) se habilita un buzón de sugerencias y/o reclamos, las cuales seran atendidas a la brevedad posible. Por el Departamento de Talento Humano</p>
									<?php
									if (!isset($_POST['mensaje'])) {
									?>
										<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
											<table class="table table-hover">
												<tbody>
													<tr>
														<td>Telefono de contacto:</td>
														<td> <input class="form-control" name="telefono" type="number" /></td>
													</tr>
													<tr>
														<td>Correo de contacto:</td>
														<td><input class="form-control" name="mail" type="text" /></td>
													</tr>
												</tbody>
											</table>
											<label for="exampleFormControlTextarea1">Mensaje</label>
											<textarea class="form-control" id="exampleFormControlTextarea1" name="mensaje" rows="3"></textarea>
											<center><input class="btn btn-primary" type="submit" value="Enviar" /></center>
										</form>

									<?php
									} else {
										$nom_tra = $_SESSION['cedula'];
										$sql = "SELECT CONCAT (apeper || ', ',nomper) as nom_tra FROM sno_personal WHERE cedper='$nom_tra'";
										$result1 = pg_query($conP, $sql);
										$row = pg_fetch_array($result1);
										$nombre = $row['nom_tra'];
										$mensaje = "MENSAJE ENVIADO POR EL FORMULARIO DE ASISTENCIA DE LA INTRANET DEL SISTEMA RADIO MUNDIAL";
										$mensaje .= "\r\n";
										$mensaje .= "\r\n";
										$mensaje .= "\nNombre del Trabajador: " . $nombre;
										$mensaje .= "\r\n";
										$mensaje .= "\nCedula: " . $_SESSION['cedula'];
										$mensaje .= "\r\n";
										$mensaje .= "\nEmail: " . $_POST['mail'];
										$mensaje .= "\r\n";
										$mensaje .= "\nTelefono: " . $_POST['telefono'];
										$mensaje .= "\r\n";
										$mensaje .= "\nMensaje: \n" . $_POST['mensaje'];
										$destino = "castilloacostajean@gmail.com";
										$remitente = $correo;
										$asunto = "Mensaje Intranet YVKE MUNDIAL enviado por: " . $nombre;
										mail($destino, $asunto, $mensaje, "FROM: $remitente");
									?>
										<p><strong>Mensaje enviado.</strong></p>
									<?php
									}
									?>
								</div>
							</div>
						</div><!-- FIN Bloque 3-->
						<div class="col-lg-6 mb-6">
							<div class="card shadow mb-4">
								<div class="card-header py-3">
									<h6 class="m-0 font-weight-bold text-primary">Enlaces de Interes</h6>
								</div>
								<div class="card-body">
									<div class="text-center">
										<a class="btn btn-primary" target="_blank" href="http://radiomundial.com.ve" role="button">Pagina Web</a>
										<a class="btn btn-primary" target="_blank" href="https://twitter.com/yvke_mundial" role="button">Twitter</a>
										<a class="btn btn-primary" target="_blank" href="https://www.facebook.com/yvkemundial/" role="button">Facebook</a>
										<a class="btn btn-primary" target="_blank" href="https://www.instagram.com/yvke_mundial/" role="button">Instagram</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include('marcos/footer.php'); ?>