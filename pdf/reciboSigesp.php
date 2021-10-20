<?php
include('../conf/valida.php');
include('../conf/funciones.php');
include('../conf/db.php');
require('../vendor/fpdf/fancyrow.php');
if (!isset($_SESSION['cedula'])) {
    header('location:index.html');
}
$cedula = $_SESSION['cedula'];
$ano = $_POST['anocur'];
$mes = $_POST['mes'];
$quincena = $_POST['quinc'];
/* QUERY PARA EL CABECERO DE LOS RECIBOS */
$sql = "SELECT T2.cedper as cedula, CONCAT (T2.apeper || ',',T2.nomper) as nom_tra, T1.codcueban as num_cuenta, T1.codper as ID_Pers, 
T3.descar as Cargo, T4.denger as Gerencia, T5.desnom as Tipo_Nomina, T5.anocurnom as ano_nomina, T2.fecingper
from sno_hpersonalnomina T1 
INNER JOIN sno_personal T2 ON replace(ltrim(replace(T1.codper,'0',' ')),' ','0') = T2.cedper
INNER JOIN sno_cargo T3 ON T1.codcar = T3.codcar 
INNER JOIN srh_gerencia T4 ON T2.codger = T4.codger
INNER JOIN sno_hnomina T5 ON T1.codnom = T5.codnom
where replace(ltrim(replace(T1.codper,'0',' ')),' ','0')='$cedula' 
and tippernom ='1'
limit 1";
$resul = pg_query($conP, $sql);
while ($row = pg_fetch_assoc($resul)) {
    $cedula1 = $row['cedula']; //CEDULA DEL EMPLEADO
    $nom_emp = $row['nom_tra']; //Nombre del empleado
    $cuenta_emp = $row['num_cuenta']; //Cuenta del Empleado
    $cargo = $row['cargo']; //Cargo del Empleado
    $fe_ing = $row['fecingper']; //Fecha de Ingreso
    //$unidad_admin = $row['est_codigo']; //Codigo de la Gerencia
    $gerencia = $row['gerencia']; //Gerencia del Empleado
    $nom_asig = $row['tipo_nomina']; //Nomina asignada 
    $fechaExp = date("j/n/Y");
}
/* QUERY PARA LAS ASIGNACIONES DE LA PERSONA */
$sql1 = "SELECT sno_personal.codper,sno_personal.cedper, sno_personal.apeper, sno_personal.nomper, sno_hsalida.tipsal,sno_hsalida.valsal as valor1, 
sno_hsalida.codconc, sno_hconcepto.nomcon as nom,sno_hunidadadmin.desuniadm,
(SELECT distinct sno_hperiodo.fecdesper from sno_hperiodo 
where REPLACE(ltrim(REPLACE(sno_hperiodo.codperi,'0',' ')),' ','0')='$quincena'
and sno_hperiodo.anocur ='$ano'
and extract (month from sno_hperiodo.fecdesper) ='$mes') AS fecha_inicio, 
(SELECT dentippersss FROM sno_tipopersonalsss WHERE codemp=sno_personal.codemp AND codtippersss=sno_personal.codtippersss) AS tipopersonal 
FROM sno_personal, sno_hpersonalnomina, sno_hsalida, sno_hnomina, sno_hconcepto, sno_cestaticunidadadm, sno_cestaticket, 
sno_hunidadadmin 
where REPLACE(ltrim(REPLACE(sno_hpersonalnomina.codper,'0',' ')),' ','0')='$cedula'
AND sno_hpersonalnomina.anocur='$ano'
AND REPLACE(ltrim(REPLACE(sno_hpersonalnomina.codperi,'0',' ')),' ','0')='$quincena'
and tipsal = 'A'
And valsal > 0
and sno_hsalida.codnom !='0004'	  
AND sno_personal.codemp = sno_hpersonalnomina.codemp 
AND sno_personal.codper = sno_hpersonalnomina.codper 
AND sno_hpersonalnomina.codemp = sno_hsalida.codemp 
AND sno_hpersonalnomina.codnom = sno_hsalida.codnom 
AND sno_hpersonalnomina.anocur = sno_hsalida.anocur 
AND sno_hpersonalnomina.codperi = sno_hsalida.codperi 
AND sno_hpersonalnomina.codper = sno_hsalida.codper 
AND sno_hconcepto.codemp = sno_hsalida.codemp 
AND sno_hconcepto.codnom = sno_hsalida.codnom 
AND sno_hconcepto.anocur = sno_hsalida.anocur 
AND sno_hconcepto.codperi = sno_hsalida.codperi 
AND sno_hconcepto.codconc = sno_hsalida.codconc 
AND sno_hpersonalnomina.codemp = sno_cestaticunidadadm.codemp 
AND sno_hpersonalnomina.codemp = sno_hnomina.codemp 
AND sno_hpersonalnomina.codnom = sno_hnomina.codnom 
AND sno_hpersonalnomina.anocur = sno_hnomina.anocurnom 
AND sno_hpersonalnomina.codperi = sno_hnomina.peractnom 
AND sno_hpersonalnomina.codemp = sno_cestaticunidadadm.codemp 
AND sno_hpersonalnomina.minorguniadm = sno_cestaticunidadadm.minorguniadm 
AND sno_hpersonalnomina.ofiuniadm = sno_cestaticunidadadm.ofiuniadm 
AND sno_hpersonalnomina.uniuniadm = sno_cestaticunidadadm.uniuniadm 
AND sno_hpersonalnomina.depuniadm = sno_cestaticunidadadm.depuniadm 
AND sno_hpersonalnomina.prouniadm = sno_cestaticunidadadm.prouniadm 
AND sno_hpersonalnomina.codemp = sno_hunidadadmin.codemp 
AND sno_hpersonalnomina.codnom = sno_hunidadadmin.codnom 
AND sno_hpersonalnomina.anocur = sno_hunidadadmin.anocur 
AND sno_hpersonalnomina.codperi = sno_hunidadadmin.codperi 
AND sno_hpersonalnomina.minorguniadm = sno_hunidadadmin.minorguniadm 
AND sno_hpersonalnomina.ofiuniadm = sno_hunidadadmin.ofiuniadm 
AND sno_hpersonalnomina.uniuniadm = sno_hunidadadmin.uniuniadm 
AND sno_hpersonalnomina.depuniadm = sno_hunidadadmin.depuniadm 
AND sno_hpersonalnomina.prouniadm = sno_hunidadadmin.prouniadm";
$resul1 = pg_query($conP, $sql1);
/* QUERY PARA LAS DEDUCCIONES DE LA PERSONA */
$sql2 = "SELECT sno_personal.codper,sno_personal.cedper, sno_personal.apeper, sno_personal.nomper, sno_hsalida.tipsal,sno_hsalida.valsal as valor, 
sno_hsalida.codconc, sno_hconcepto.nomcon as nom1,sno_hunidadadmin.desuniadm,

(SELECT distinct sno_hperiodo.fecdesper from sno_hperiodo 
where REPLACE(ltrim(REPLACE(sno_hperiodo.codperi,'0',' ')),' ','0')='$quincena'
and sno_hperiodo.anocur ='$ano'
and extract (month from sno_hperiodo.fecdesper) ='$mes') AS fecha_inicio, 
(SELECT dentippersss FROM sno_tipopersonalsss WHERE codemp=sno_personal.codemp AND codtippersss=sno_personal.codtippersss) AS tipopersonal 
FROM sno_personal, sno_hpersonalnomina, sno_hsalida, sno_hnomina, sno_hconcepto, sno_cestaticunidadadm, sno_cestaticket, 
sno_hunidadadmin 
where REPLACE(ltrim(REPLACE(sno_hpersonalnomina.codper,'0',' ')),' ','0')='$cedula'
AND sno_hpersonalnomina.anocur='$ano'
AND REPLACE(ltrim(REPLACE(sno_hpersonalnomina.codperi,'0',' ')),' ','0')='$quincena'
and tipsal IN ('D','P1')				 
and sno_hsalida.codnom !='0004'	  
AND sno_personal.codemp = sno_hpersonalnomina.codemp 
AND sno_personal.codper = sno_hpersonalnomina.codper 
AND sno_hpersonalnomina.codemp = sno_hsalida.codemp 
AND sno_hpersonalnomina.codnom = sno_hsalida.codnom 
AND sno_hpersonalnomina.anocur = sno_hsalida.anocur 
AND sno_hpersonalnomina.codperi = sno_hsalida.codperi 
AND sno_hpersonalnomina.codper = sno_hsalida.codper 
AND sno_hconcepto.codemp = sno_hsalida.codemp 
AND sno_hconcepto.codnom = sno_hsalida.codnom 
AND sno_hconcepto.anocur = sno_hsalida.anocur 
AND sno_hconcepto.codperi = sno_hsalida.codperi 
AND sno_hconcepto.codconc = sno_hsalida.codconc 
AND sno_hpersonalnomina.codemp = sno_cestaticunidadadm.codemp 
AND sno_hpersonalnomina.codemp = sno_hnomina.codemp 
AND sno_hpersonalnomina.codnom = sno_hnomina.codnom 
AND sno_hpersonalnomina.anocur = sno_hnomina.anocurnom 
AND sno_hpersonalnomina.codperi = sno_hnomina.peractnom 
AND sno_hpersonalnomina.codemp = sno_cestaticunidadadm.codemp 
AND sno_hpersonalnomina.minorguniadm = sno_cestaticunidadadm.minorguniadm 
AND sno_hpersonalnomina.ofiuniadm = sno_cestaticunidadadm.ofiuniadm 
AND sno_hpersonalnomina.uniuniadm = sno_cestaticunidadadm.uniuniadm 
AND sno_hpersonalnomina.depuniadm = sno_cestaticunidadadm.depuniadm 
AND sno_hpersonalnomina.prouniadm = sno_cestaticunidadadm.prouniadm 
AND sno_hpersonalnomina.codemp = sno_hunidadadmin.codemp 
AND sno_hpersonalnomina.codnom = sno_hunidadadmin.codnom 
AND sno_hpersonalnomina.anocur = sno_hunidadadmin.anocur 
AND sno_hpersonalnomina.codperi = sno_hunidadadmin.codperi 
AND sno_hpersonalnomina.minorguniadm = sno_hunidadadmin.minorguniadm 
AND sno_hpersonalnomina.ofiuniadm = sno_hunidadadmin.ofiuniadm 
AND sno_hpersonalnomina.uniuniadm = sno_hunidadadmin.uniuniadm 
AND sno_hpersonalnomina.depuniadm = sno_hunidadadmin.depuniadm 
AND sno_hpersonalnomina.prouniadm = sno_hunidadadmin.prouniadm";
$resul5 = pg_query($conP, $sql2);
//Query para la Mostrar la Nomina Seleccionada
$sql3 = "select  distinct fecdesper, fechasper from sno_hperiodo 
where REPLACE(ltrim(REPLACE(sno_hperiodo.codperi,'0',' ')),' ','0')='$quincena'
order by fecdesper asc
limit 1";
$resul2 = pg_query($conP, $sql3);
while ($row = pg_fetch_assoc($resul2)) {
    $nom_desde = $row['fecdesper']; //NOMINA DESDE
    $nom_hasta = $row['fechasper']; //NOMINA HASTA
}

////////////////////CABECERA DEL RECIBO/////////////////////
$pdf = new PDF_FancyRow();
$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");
$pdf->SetFont('Times', '', 12);
$pdf->Sety((80) / 2);
$pdf->Setx((20) / 2);
$pdf->SetFont('Times', '', 12);
$lo_ccs = ('../img/banner.png');
$pdf->Image("$lo_ccs", 10, 10, 190, 0, 'PNG');
$pdf->Cell(125, 7, utf8_decode("RECIBO PAGO NOMINA"), 0, 0, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(70, 7, utf8_decode(fechaCastellano(date('Ymd'))), 0, 0, 'R');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(22, 7, utf8_decode("ID:    "), 1, 0, 'L');
$pdf->Cell(40, 7, utf8_decode("Cédula:    $cedula1"), 1, 0, 'L');
$pdf->Cell(135, 7, utf8_decode("Apellidos y Nombres:   $nom_emp"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(80, 7, utf8_decode("Cuenta N°:   $cuenta_emp"), 1, 0, 'L');
$pdf->Cell(117, 7, utf8_decode("$nom_asig    Desde $nom_desde    Hasta $nom_hasta"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(145, 7, utf8_decode("Cargo: $cargo"), 1, 0, 'L');
$pdf->Cell(52, 7, utf8_decode("Fecha de Ingreso:   $fe_ing"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(197, 7, utf8_decode("Unidad Administrativa:  $gerencia"), 1, 0, 'L');
$pdf->Ln();
$pdf->Cell(197, 2, utf8_decode(""), TB, 0, 'L');
$pdf->Ln();
$pdf->Cell(15, 7, utf8_decode("RUBRO"), 0, 0, 'L');
$pdf->Cell(83, 7, utf8_decode("ASIGNACION"), 0, 0, 'R');
$pdf->Cell(15, 7, utf8_decode("RUBRO"), 0, 0, 'L');
$pdf->Cell(84, 7, utf8_decode("DEDUCCIÓN"), 0, 0, 'R');
$pdf->Ln();
/////////FIN CABECERA //////////////////////////////
/////ASIGNACION//////
$pdf->SetFont('Arial', 'B', 8);
while ($row = pg_fetch_array($resul1)) {
    $rub_nom = $row['nom'];
    $rub_monto1 = $row['valor1'];
    $widths = array(70, 27);
    $border = array('', '');
    $align = array('L', 'R');
    $empty = array(utf8_decode($rub_nom), number_format(($rub_monto1), 2, ",", "."));
    $pdf->SetWidths($widths);
    $pdf->FancyRow($empty, $border, $align);
}

/////DEDUCCION///////
//MUESTRA EL MONTO DEL COCEPTO DE LA DEDUCCION
$pdf->SetY(91);
$pdf->SetX(110);
while ($row = pg_fetch_array($resul5)) {
    $pdf->SetX(108);
    $rub_nom2 = $row['nom1'];
    $rub_monto2 = $row['valor'];
    $pdf->Cell(70, 5, utf8_decode($rub_nom2), 0, 0, 'L');
    $pdf->Cell(27, 5, number_format((abs($rub_monto2)), 2, ",", "."), 0, 1, 'R');
}

/// //////////SUMA DE DEDUCCION ////////////////////
$sql4 = "SELECT SUM(T1.valsal) as total_deduc from sno_hsalida T1
where REPLACE(ltrim(REPLACE(T1.codper,'0',' ')),' ','0')='$cedula1'
and T1.anocur ='$ano'
and REPLACE(ltrim(REPLACE(T1.codperi,'0',' ')),' ','0')='$quincena'
and T1.codnom !='0004'
 and tipsal IN ('D','P1')";
$resul7 = pg_query($conP, $sql4);
while ($row = pg_fetch_assoc($resul7)) {
    $total_deduc = $row['total_deduc'];
}
/////////////SUMA DE ASIGNACION ////////////////////		
$sql5 = "SELECT SUM(T1.valsal) as total_asig from sno_hsalida T1
where REPLACE(ltrim(REPLACE(T1.codper,'0',' ')),' ','0')='$cedula1'
and T1.anocur ='$ano'
and REPLACE(ltrim(REPLACE(T1.codperi,'0',' ')),' ','0')='$quincena'
and T1.codnom !='0004'
and tipsal = 'A'
and valsal > 0";
$resul4 = pg_query($conP, $sql5);
while ($row = pg_fetch_array($resul4)) {
    $suma_asig = $row['total_asig'];
}
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(67, 7, utf8_decode("TOTAL DE ASIGNACIONES: "), TLB, 0, 'R');
$pdf->Cell(30, 7, number_format(($suma_asig), 2, ",", "."), TB, 0, 'R');
$pdf->Cell(67, 7, utf8_decode("TOTAL DEDUCIONES: "), TB, 0, 'R');
$pdf->Cell(30, 7, number_format(abs(($total_deduc)), 2, ",", "."), TRB, 0, 'R');
$total_quin = $suma_asig - abs($total_deduc);
$pdf->Ln();
$pdf->Cell(67, 7, utf8_decode(""), TLB, 0, 'R');
$pdf->Cell(30, 7, number_format(), TB, 0, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(67, 7, utf8_decode("TOTAL NETO A COBRAR: "), TB, 0, 'R');
$pdf->Cell(30, 7, number_format(($total_quin), 2, ",", "."), TRB, 0, 'R');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(194, 4, utf8_decode("Recibi Conforme: "), 0, 0, '');
$pdf->Ln();
$pdf->Cell(194, 4, utf8_decode("________________________"), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(194, 4, utf8_decode("$nom_emp"), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(194, 4, utf8_decode("$cedula"), 0, 0, 'C');
$pdf->Output();
