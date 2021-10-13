<?php
include('../conf/valida.php');
include('../conf/funciones.php');
include('../conf/db.php');
require('../vendor/fpdf/fpdf.php');
if (!isset($_SESSION['cedula'])) {
    header('location:index.html');
}
$cedula = $_SESSION['cedula'];
if (isset($_POST['formSubmit'])) {
    $ano = $_POST['ano'];
    $mes = $_POST['mes'];
    $quincena = $_POST['quincena'];
    if (!isset($ano)) {
        echo ("<p>No ha seleccionado nada</p>\n");
    } else {
        foreach ($_POST['ano'] as $vaina => $ano_ingreso) {
        }
    }
}
//QUERY PARA el Cabecero
$sql = "SELECT emp_codigo, nom_desde, nom_hasta, nom_detalle, nom_asig, sts_codigo, sts_nombre,
cat_nombre, fic_cedula, fic_tnombre, per_ficha, per_ctadep, car_nombre,per_fing, est_codigo, est_nombre, nom_notas
FROM vw_rhnommvd 
WHERE fic_cedula = '$cedula'
AND rub_monto > 0.00
AND rub_tipo ='A'
AND frq_codigo='1' 
AND sts_nombre !='Retirado' 
AND sts_nombre !='Suspendido' 
ORDER BY nom_desde ASC, rub_codigo ASC";
$resul = pg_query($conDy, $sql);
while ($row = pg_fetch_assoc($resul)) {
    $ficha = $row['per_ficha'];
    $codido_sede = $row['emp_codigo']; //Codigo de la Sede del Trabajador
    $cedula = $row['fic_cedula']; //CEDULA DEL EMPLEADO
    $nom_emp = $row['fic_tnombre']; //Nombre del empleado
    $cuenta_emp = $row['per_ctadep']; //Cuenta del Empleado
    $cargo = $row['car_nombre']; //Cargo del Empleado
    $nomina = $row['cat_nombre']; //Condicion de Fijo o Contratado
    $fe_ing = $row['per_fing']; //Fecha de Ingreso
    $unidad_admin = $row['est_codigo']; //Codigo de la Gerencia
    $gerencia = $row['est_nombre']; //Gerencia del Empleado
    //$nom_asig = $row['nom_asig']; //Nomina asignada 
    $fechaExp = date("j/n/Y");
}
//Query para Asignaciones
$sql1 = "SELECT extract (month FROM nom_desde) AS MES, emp_codigo, frq_codigo, per_base, nom_desde, nom_hasta, nom_detalle, nom_asig, sts_codigo, sts_nombre,
cat_nombre, fic_cedula, rub_valor, rub_tipo, rub_monto,rub_nombre, rub_codigo, rub_valor2, rub_monto2, fic_tnombre, per_ficha, per_ctadep, car_nombre,per_fing, est_codigo, est_nombre, nom_notas
FROM vw_rhnommvd 
WHERE fic_cedula = '$cedula'
AND rub_monto > 0.00
AND rub_tipo ='A'
AND per_base = '$ano_ingreso'
AND extract (month FROM nom_desde) = '$mes'
AND extract (day FROM nom_desde) = '$quincena'
AND frq_codigo='1' 
AND sts_nombre !='Retirado' 
AND sts_nombre !='Suspendido' 
ORDER BY nom_desde ASC, rub_codigo ASC";
$resul1 = pg_query($conDy, $sql1);

/* DETALLES DE LA NOMINA */
$sql2 = "SELECT extract (month FROM nom_desde) AS MES, emp_codigo, frq_codigo, per_base, nom_desde, nom_hasta, nom_detalle, nom_asig, sts_codigo, sts_nombre,
cat_nombre, fic_cedula, rub_valor, rub_tipo, rub_monto,rub_nombre, rub_codigo, rub_valor2, rub_monto2, fic_tnombre, per_ficha, per_ctadep, car_nombre,per_fing, est_codigo, est_nombre, nom_notas
FROM vw_rhnommvd 
WHERE fic_cedula = '$cedula'
AND rub_monto > 0.00
AND rub_tipo ='A'
AND per_base = '$ano_ingreso'
AND extract (month FROM nom_desde) = '$mes'
AND extract (day FROM nom_desde) = '$quincena'
AND frq_codigo='1' 
AND sts_nombre !='Retirado' 
AND sts_nombre !='Suspendido' 
ORDER BY nom_desde ASC, rub_codigo ASC";
$resul2 = pg_query($conDy, $sql2);
while ($row = pg_fetch_assoc($resul2)) {
    $nom_detalle = $row['nom_detalle']; //Detalle de la Nomina
    $nom_desde = $row['nom_desde']; //Nomina desde 
    $nom_hasta = $row['nom_hasta']; //nomina hasta
    $nom_notas = $row['nom_notas']; //nomina Observaciones
}
/* QUERY PARA DEDUCCIONES */
$sql3 = "SELECT extract (month FROM nom_desde) AS MES, frq_codigo, per_base, nom_desde, nom_hasta, nom_detalle, nom_asig, sts_codigo, sts_nombre, cat_nombre, fic_cedula, rub_valor, rub_tipo, rub_monto,rub_nombre, rub_codigo, rub_valor2, rub_monto2, fic_tnombre, per_ficha, per_ctadep, car_nombre,per_fing, est_codigo, est_nombre
FROM vw_rhnommvd WHERE fic_cedula = '$cedula'
AND rub_monto > 0.00
AND rub_tipo ='D' 
AND per_base = '$ano_ingreso'
AND extract (month FROM nom_desde) = '$mes'
AND extract (day FROM nom_desde) = '$quincena'
AND frq_codigo='1' 
AND sts_nombre !='Retirado' 
AND sts_nombre !='Suspendido' 
ORDER BY nom_desde ASC, rub_codigo ASC";
$resul3 = pg_query($conDy, $sql3);
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../img/banner.png', 10, 10, 190, 0);
        $this->SetFont('Arial', 'B', 12);
    }
    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/1', 0, 0, 'C');
    }
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");
$pdf->SetFont('Times', '', 12);
$pdf->Sety((80) / 2);
$pdf->Setx((20) / 2);
$pdf->SetFont('Times', '', 12);
if ($nomina = 'EMPLEADO FIJO') {
    $deta_nom = "NOMINA EMPLEADOS FIJOS";
} else {
    $deta_nom = "NOMINA EMPLEADOS CONTRATADOS";
}
$pdf->Cell(125, 7, utf8_decode("RECIBO PAGO NOMINA"), 0, 0, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(70, 7, utf8_decode(fechaCastellano(date("d-m-Y"))), 0, 0, 'R');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(22, 7, utf8_decode("ID:    $ficha"), 1, 0, 'L');
$pdf->Cell(40, 7, utf8_decode("Cédula:    $cedula"), 1, 0, 'L');
$pdf->Cell(135, 7, utf8_decode("Apellidos y Nombres:   $nom_emp"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(80, 7, utf8_decode("Cuenta N°:   $cuenta_emp"), 1, 0, 'L');
$pdf->Cell(117, 7, utf8_decode("$deta_nom Desde $nom_desde Hasta $nom_hasta"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(145, 7, utf8_decode("Cargo: $cargo"), 1, 0, 'L');
$pdf->Cell(52, 7, utf8_decode("Fecha de Ingreso:   $fe_ing"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(197, 7, utf8_decode("Unidad Administrativa:  $unidad_admin     $gerencia"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(197, 2, utf8_decode(""), 'TB', 0, 'L');
$pdf->Ln();
$pdf->Cell(15, 7, utf8_decode("RUBRO"), 0, 0, 'L');
$pdf->Cell(83, 7, utf8_decode("ASIGNACION"), 0, 0, 'R');
$pdf->Cell(15, 7, utf8_decode("RUBRO"), 0, 0, 'L');
$pdf->Cell(84, 7, utf8_decode("DEDUCCIÓN"), 0, 0, 'R');
$pdf->Ln();
/////ASIGNACION//////
$pdf->SetFont('Arial', 'B', 8);
while ($row = pg_fetch_array($resul1)) {
    $rub_nom = $row['rub_nombre'];
    $rub_monto = $row['rub_monto'];
    $widths = array(70, 27);
    $border = array('', '');
    $align = array('L', 'R');
    $empty = array(utf8_decode($rub_nom), utf8_decode($rub_monto));
    $pdf->SetWidths($widths);
    $pdf->FancyRow($empty, $border, $align);
}
/////DEDUCCION///////
$pdf->SetY(91);
$pdf->SetX(110);
while ($row = pg_fetch_array($resul3)) {
    $pdf->SetX(108);
    $rub_nom2 = $row['rub_nombre'];
    $rub_monto2 = $row['rub_monto'];
    $pdf->Cell(70, 7, utf8_decode($rub_nom2), 0, 0, 'L');
    $pdf->Cell(27, 7, utf8_decode($rub_monto2), 0, 1, 'R');
}
$sql4 = "SELECT SUM(rub_monto) AS total FROM vw_rhnommvd  WHERE fic_cedula = '$cedula'
AND rub_monto > 0.00
AND rub_tipo ='D' 
AND per_base = '$ano_ingreso'
AND extract (month from nom_desde) = '$mes'
AND extract (day from nom_desde) = '$quincena'
AND frq_codigo='1' 
AND sts_nombre !='Retirado' 
AND sts_nombre !='Suspendido'";
$resul4 = pg_query($conDy, $sql4);
while ($row = pg_fetch_assoc($resul4)) {
    $total_deduc = $row['total'];
}
$sql5 = "SELECT SUM(rub_monto) AS asignada
FROM vw_rhnommvd 
WHERE fic_cedula = '$cedula'
AND rub_monto > 0.00
AND rub_tipo ='A' 
AND per_base = '$ano_ingreso'
AND extract (month from nom_desde) = '$mes'
AND extract (day from nom_desde) = '$quincena'
AND frq_codigo='1' 
AND sts_nombre !='Retirado' 
AND sts_nombre !='Suspendido'";
$resul5 = pg_query($conDy, $sql5);
while ($row = pg_fetch_assoc($resul5)) {
    $total_asig = $row['asignada'];
}
$pdf->Ln(15);
$pdf->Cell(67, 7, utf8_decode("TOTAL DE ASIGNACIONES: "), 'TLB', 0, 'R');
$pdf->Cell(30, 7, number_format(($total_asig), 2, ",", "."), 'TB', 0, 'R');
$pdf->Cell(67, 7, utf8_decode("TOTAL DEDUCIONES: "), 'TB', 0, 'R');
$pdf->Cell(30, 7, number_format(($total_deduc), 2, ",", "."), 'TRB', 0, 'R');
$total_quin = $total_asig - $total_deduc;
$pdf->Ln(9);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(194, 7, utf8_decode("Monto total: ") . number_format(($total_quin), 2, ",", "."), 0, 0, 'R');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(197, 7, utf8_decode("Observaciones: $nom_notas"), 0, 0, 'L');
$pdf->Ln(10);
$pdf->Cell(194, 4, utf8_decode("Recibi Conforme: "), 0, 0, '');
$pdf->Ln(10);
$pdf->Cell(194, 4, utf8_decode("________________________"), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(194, 4, utf8_decode("$nom_emp"), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(194, 4, utf8_decode("$cedula"), 0, 0, 'C');
$pdf->Output();
