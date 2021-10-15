<?php
//Fecha creacion 14-06-2021//
//Autor: Jean Castillo//
include('../conf/db.php');
include('../conf/valida.php');
include('../conf/funciones.php');
if (!isset($_SESSION['cedula'])) { header('location:../index.html'); }
require ('../vendor/fpdf/fpdf.php');
$cedula = $_SESSION['cedula'];
$feinivac = $_POST['fecini'];
$fefinvac = $_POST['fecfin'];
$perido = $_POST['chkPassPort'];
$dis = $_POST['chkPassPort'];
$dias = $_POST['dias'];

$venci = $_POST['venci'];
if ($dis == date("Y")){
    $disfru = $dis;
} else{
    $disfru = $venci;
}
if ($perido == date("Y")){
    $perido = '0';
}else {
    $perido = date("Y") - $venci;
}
////////////QUERYS DEL SISTEMA////////////
///////////CABECERA PRINCIPAL////////////
$sql1="SELECT CONCAT (apeper || ', ',nomper) as nom_tra,T1.anoservpreper , T1.fecingper, T1.codger, T1.cedper, T2.denger,T1.nivacaper,T1.numhijper    
FROM sno_personal T1 INNER JOIN srh_gerencia T2 ON T1.codger = T2.codger WHERE cedper='$cedula'";
$resultado1 = pg_query($conP,$sql1);
while ($row = pg_fetch_assoc($resultado1)) 
{ 
$nom_tra=$row['nom_tra'];//NOMBRE DE LA PERSONA
$ced_tra=$row['cedper']; //CEDULA DE LA PERSONA
$fe_ing=$row['fecingper'];//FECHA DE INGRESO
$nomGere= $row['denger'];//NOMBRE DE LA GERENCIA
$niaca= $row['nivacaper']; //NIVEL ACADEMICO
$numhijo= $row['numhijper']; //NIVEL ACADEMICO
$anos_public=$row['anoservpreper']; //AÑOS DE SERVICIO EN LA ADMIN PUBLICA
}

///////////CARGO Y GERENCIA////////////
$sql2 = "SELECT T2.descar, T1.codcar FROM calculo_personal T1 
INNER JOIN sno_cargo T2 ON T1.codcar = T2.codcar
WHERE cedper='$cedula'";
$resultado2 = pg_query($conP,$sql2);
while ($row = pg_fetch_assoc($resultado2)) 
{   
$usu_car=$row['descar']; //NOMBRE DEL CARGO
$codcar=$row['codcar'];
}
class PDF extends FPDF
{
function Header(){
$this->Image('../img/banner.png',10,10,190,0);
$this->SetFont('Arial','B',12);
}
function Footer(){
    $this->SetY(-10);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/1',0,0,'C');
}
}
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetTitle('Formato Vacaciones-'.$_SESSION['cedula']);
$pdf->SetAuthor('Intranet Yvke Mundial');
$pdf->SetCreator('Sistema Integrado de Talento Humano YVKE-MUNDIAL');
$pdf->SetFont('Times','',12);
$pdf->Ln(20);
$pdf->Cell(0, 5, 'RADIO MUNDIAL C.A', 0, 1,'C');
$pdf->Cell(0, 5, 'GERENCIA DE TALENTO HUMANO', 0, 1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Cell(0, 5, 'TRAMITACION DE VACACIONES', 0, 1,'C');
//$pdf->Line(20, 48, 190, 48); // 20mm from each Edge

$pdf->Ln(5);
$pdf->Cell(190, 5, fechaCastellano(date("d-m-Y")), 0, 1,'R');
$pdf->SetFont('Times','B',12);
$pdf->Cell(190, 5, 'DATOS DEL TRABAJADOR', 1, 1,'C');
$pdf->SetFont('Times','B',9);
$pdf->Cell(150, 4, 'Nombre y Apellido', 1, 0,'L');
$pdf->Cell(40, 4, 'Cedula de Identidad', 1, 1,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(150, 7, $nom_tra, 1, 0,'L');
$pdf->Cell(40, 7, $ced_tra, 1, 1,'R');
$pdf->SetFont('Times','B',9);
$pdf->Cell(40, 4, 'Fecha de Ingreso', 1, 0,'L');
$pdf->Cell(150, 4, 'Cargo', 1, 1,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(40, 7, $fe_ing, 1, 0,'L');
$pdf->Cell(150, 7, $usu_car, 1, 1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(150, 4, 'Adscrito a la Gerencia', 1, 0,'L');
$pdf->Cell(40, 4, 'Telefono', 1, 1,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(150, 7, $nomGere, 1, 0,'L');
$pdf->Cell(40, 7, '2323123123', 1, 1,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','B',12);
$pdf->Cell(190, 5, 'DETALLES DEL PERIODO', 1, 1,'C');
$pdf->SetFont('Times','B',9);
$pdf->Cell(36, 4, 'Fecha Inicio Periodo', 1, 0,'L');
$pdf->Cell(46, 4, 'Fecha Culminacion Periodo', 1, 0,'L');
$pdf->Cell(36, 4, 'Periodos Vencidos', 1, 0,'L');
$pdf->Cell(36, 4, 'Periodo a Disfrutar', 1, 0,'L');
$pdf->Cell(36, 4, 'Dias Disfrute', 1, 1,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(36, 7, $feinivac, 1, 0,'L');
$pdf->Cell(46, 7, $fefinvac, 1, 0,'L');
$pdf->Cell(36, 7, $perido, 1, 0,'L');
$pdf->Cell(36, 7, $disfru, 1, 0,'L');
$pdf->Cell(36, 7, $dias, 1, 0,'L');
$pdf->Ln(12);
$pdf->SetFont('Times','B',9);
$pdf->Cell(95, 4, 'FIRMA TRABAJADOR', 1, 0,'C');
$pdf->Cell(95, 4, 'FIRMA DEL SUPERVISOR', 1, 1,'C');
$pdf->SetFont('Times','',12);
$pdf->Cell(95, 25, '', 1, 0,'L');
$pdf->Cell(95, 25, '', 1, 1,'C');
$pdf->SetFont('Times','B',9);
$pdf->Cell(95, 4, $nom_tra, 1, 0,'C');
$pdf->Cell(95, 4, 'NOMBRE: GERENTE DE AREA', 1, 1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Ln(10);
$pdf->Cell(190, 5, 'PARA USO DE LA GERENCIA DE TALENTO HUMANO', 1, 1,'C');
$pdf->SetFont('Times','',8);
$pdf->Cell(36, 4, 'FECHA DE INICIO', 1, 0,'C');
$pdf->Cell(45, 4, 'FECHA DE CULMINACION', 1, 0,'C');
$pdf->Cell(40, 4, 'FECHA DE REINTEGRO', 1, 0,'C');
$pdf->Cell(30, 4, 'DIAS A DISFRUTRAR', 1, 0,'C');
$pdf->Cell(39, 4, 'PERIODO A DISFRUTRAR', 1, 1,'C');
$pdf->Cell(12, 8, '', 1, 0,'L');
$pdf->Cell(12, 8, '', 1, 0,'L');
$pdf->Cell(12, 8, '', 1, 0,'L');
//
$pdf->Cell(15, 8, '', 1, 0,'L');
$pdf->Cell(15, 8, '', 1, 0,'L');
$pdf->Cell(15, 8, '', 1, 0,'L');
//
$pdf->Cell(13, 8, '', 1, 0,'L');
$pdf->Cell(13, 8, '', 1, 0,'L');
$pdf->Cell(14, 8, '', 1, 0,'L');
//
$pdf->Cell(30, 8, '', 1, 0,'L');
//
$pdf->Cell(39, 8, '', 1, 1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(190, 4, 'Observaciones:', 1, 1,'L');
$pdf->Cell(190, 25, '', 1, 1,'L');
$pdf->Cell(95, 25, '', 1, 0,'L');
$pdf->Cell(95, 25, '', 1, 1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(95, 5, 'FIRMA AUTORIZADA', 1, 0,'C');
$pdf->Cell(95, 5, 'SELLO', 1, 0,'C');
$pdf->Ln(20);
$pdf->Cell(190, 5, 'ORIGINAL: TALENTO HUMANO', 0, 1,'L');
$pdf->Cell(190, 5, 'DUPLICADO: SUPERVISOR', 0, 1,'L');
$pdf->Cell(190, 5, 'TRIPLICADO: TRABAJADOR', 0, 1,'L');



$pdf->Output('', 'Constancia-Laboral-'.$_SESSION['cedula'].'.pdf');
?>