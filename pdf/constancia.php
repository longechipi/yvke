<?php
//Fecha creacion 14-06-2021//
//Autor: Jean Castillo//
include('../conf/db.php');
include('../conf/valida.php');
include('../conf/funciones.php');
if (!isset($_SESSION['cedula'])) { header('location:../index.html'); }
require ('../vendor/fpdf/fpdf.php');
$cedula = $_SESSION['cedula'];
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
///////////SUELDO BASE////////////
$sql3="SELECT T1.sueper AS sueldo
FROM sno_hpersonalnomina T1 
WHERE REPLACE(ltrim(REPLACE(codper,'0',' ')),' ','0')='$cedula'
ORDER BY codperi DESC  LIMIT 1";
$resultado3 = pg_query($conP,$sql3);
while ($row = pg_fetch_assoc($resultado3)) 
{   
$suel_base=$row['sueldo']; //SUELDO BASE
}
//////////NIVEL ACADEMICO//////////
if ($cedula==17610797){
    $pri_prof =$suel_base *30/100;
}
if ($niaca==3)//TSU
$pri_prof =$suel_base *20/100;
if ($niaca==4)//LCO / ING
$pri_prof =$suel_base *30/100;
if ($niaca==8)//ESPECIALISTA
$pri_prof =$suel_base *40/100;
if ($niaca==5)//MAESTRIA
$pri_prof =$suel_base *50/100;
if ($niaca==7)//DOCTOR
$pri_prof =$suel_base *60/100;
//////////PRIMA ANTIGUEDAD//////////
//SWITCH PARA AÑOS DE SERVICIO + AÑOS EN OTRAS INSTITUCIONES PUBLICAS
$anos= primaantiguedad($fe_ing)+$anos_public;
switch($anos) {
case 0:
$anos*0;
case 1:
$pri_antig=$suel_base*2/100;
break;
case 2:
$pri_antig=$suel_base*4/100;
break;
case 3:
$pri_antig=$suel_base*6/100;
break;
case 4:
$pri_antig=$suel_base*8/100;
break;
case 5:
$pri_antig=$suel_base*10/100;
break;
case 6:
$pri_antig=$suel_base*12/100;
break;
case 7:
$pri_antig=$suel_base*15/100;
break;
case 8:
$pri_antig=$suel_base*17/100;
break;
case 9:
$pri_antig=$suel_base*20/100;
break;
case 10:
$pri_antig=$suel_base*22/100;
break;
case 11:
$pri_antig=$suel_base*25/100;
break;
case 12:
$pri_antig=$suel_base*28/100;
break;
case 13:
$pri_antig=$suel_base*30/100;
break;
case 14:
$pri_antig=$suel_base*33/100;
break;
case 15:
$pri_antig=$suel_base*36/100;
break;
case 16:
$pri_antig=$suel_base*39/100;
break;
case 17:
$pri_antig=$suel_base*42/100;
break;
case 18:
$pri_antig=$suel_base*46/100;
break;
case 19:
$pri_antig=$suel_base*49/100;
break;
case 20:
$pri_antig=$suel_base*52/100;
break;
case 21:
$pri_antig=$suel_base*56/100;
break;
case 22:
$pri_antig=$suel_base*59/100;
break;
default:
$pri_antig=$suel_base*60/100;
}
////////COMPLEMENTO ESTRATEGICO////////
$com_estra = $suel_base *20/100;
////////PRIMA POR HIJO////////
$pri_hijo = $numhijo*1750000;
////////SUELDO INTEGRAL////////
$suel_int = $suel_base + $pri_prof + $pri_antig + $com_estra + $pri_hijo;
$V=new EnLetras();
class PDF extends FPDF{
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
$pdf->SetTitle('Constancia Laboral-'.$_SESSION['cedula']);
$pdf->SetAuthor('Intranet Yvke Mundial');
$pdf->SetCreator('Sistema Integrado de Talento Humano YVKE-MUNDIAL');
$pdf->SetFont('Times','',12);
$pdf->Ln(20);
$pdf->Cell(0, 5, 'RADIO MUNDIAL C.A', 0, 1,'C');
$pdf->Cell(0, 5, 'GERENCIA DE TALENTO HUMANO', 0, 1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Cell(0, 5, 'CONSTANCIA DE TRABAJO', 0, 1,'C');
$pdf->Line(20, 45, 190, 45); // 20mm from each Edge
$pdf->SetFont('Times','',12);
$pdf->Ln(5);
$pdf->MultiCell(0, 7, utf8_decode('Por medio de la presente, el departamento de Talento Humano hace constar que el(la) ciudadano(a):'), 0, 1);
$pdf->Cell(50,7,'Nombre del Trabajador:');
$pdf->Cell(140,7,$nom_tra, 0, 1,'R');
$pdf->Cell(50,7,utf8_decode('Cédula de Identidad:'));
$pdf->Cell(140,7,$cedula, 0, 1,'R');
$pdf->Cell(80,7,utf8_decode('Presta sus servicios en la institución desde:'));
$pdf->Cell(110,7,$fe_ing, 0, 1,'R');
$pdf->Cell(50,7,utf8_decode('Adscrito al departamento de:'));
$pdf->Cell(140,7,$nomGere, 0, 1,'R');
$pdf->Cell(50,7,utf8_decode('Desempeñando el cargo: '));
$pdf->Cell(140,7,$usu_car, 0, 1,'R');
$pdf->Cell(50,7,utf8_decode('Sueldo Básico: '));
$pdf->Cell(140,7,number_format(($suel_base),2,",","."),0,1,'R');
$pdf->Cell(50,7,utf8_decode('Prima Profesional: '));
$pdf->Cell(140,7,number_format(($pri_prof),2,",","."),0,1,'R');
$pdf->Cell(50,7,utf8_decode('Prima Antigüedad: '));
$pdf->Cell(140,7,number_format(($pri_antig),2,",","."),0,1,'R');
$pdf->Cell(50,7,utf8_decode('Complemento Estrategico: '));
$pdf->Cell(140,7,number_format(($com_estra),2,",","."),0,1,'R');
$pdf->Cell(50,7,utf8_decode('Prima por Hijos: '));
$pdf->Cell(140,7,number_format(($pri_hijo),2,",","."),0,1,'R');
$pdf->Cell(120,7,utf8_decode('DEVENGANDO UN SUELDO INTEGRAL DE Bs: '));
$pdf->Cell(70,7,number_format(($suel_int),2,",","."),0,1,'R');
$pdf->Ln(2);
$pdf->MultiCell(0,7, utf8_decode($V->ValorEnLetras($suel_int)));
$pdf->Ln(12);
$pdf->MultiCell(0,6, utf8_decode("Adicionalmente el trabajador recibe el Beneficio de Alimentación por un monto de BsS. 3.000.000,00 Bs"));
$pdf->Ln();
$pdf->Cell(180,7,utf8_decode('Constancia que se expide en la ciudad de Caracas el día '.fechaCastellano(date("d-m-Y")).''),0,1,'C');
$pdf->Image("../img/firma.png",85,180,20,0,'PNG');
$pdf->Image("../img/sello.png",103,180,40,0,'PNG');
$pdf->Ln(27);
$pdf->Cell(180,7,utf8_decode("_____________________"),0,1,'C');
$pdf->Cell(180,5,utf8_decode("Jared Cabezas"),0,1,'C');
$pdf->Cell(180,5,utf8_decode("Gerente de Talento Humano (E)"),0,1,'C');
$pdf->SetFont('Arial','I',9);
$pdf->Ln(15);
$pdf->MultiCell(0,7,utf8_decode("Para la verificación de esta constancia generada electronicamente, por favor entrar a la pagina principal de la institución por medio de este enlace http://radiomundial.com.ve/content/verificacion y colocar el número de verificación: "));	
$pdf->Ln(19);
$pdf->Line(12, 265, 195, 265);
$pdf->MultiCell(0,5,utf8_decode("Dirección: Calle Nueva York, entre calle Madrid y avenida Río de Janeiro, edificio Mundial (Manzanillo), urbanización Las Mercedes."));
$pdf->Cell(180,5,utf8_decode("Gerencia de Talento Humano Teléfono (0212)991-08-08 Ext:3220"),0,1,'C');


$pdf->Output('', 'Constancia-Laboral-'.$_SESSION['cedula'].'.pdf');
?>