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
$pdf->SetTitle('Constancia Laboral-'.$_SESSION['cedula']);
$pdf->SetAuthor('Intranet Yvke Mundial');
$pdf->SetCreator('Sistema Integrado de Talento Humano YVKE-MUNDIAL');
$pdf->SetFont('Times','',12);
$pdf->Ln(30);
$pdf->Cell(0, 5, 'RADIO MUNDIAL C.A', 0, 1,'C');
$pdf->Cell(0, 5, 'GERENCIA DE TALENTO HUMANO', 0, 1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Cell(0, 5, 'CONSTANCIA DE TRABAJO', 0, 1,'C');
$pdf->Line(20, 57, 190, 57);
$pdf->SetFont('Times','',12);
$pdf->Ln(15);
$pdf->MultiCell(0, 7, utf8_decode('Quien suscribe, Gerente de Talento Humano Lic. Jared Cabezas de Radio Mundial, C.A, por medio de la presente hace constar que el(la) ciudadano(a): '.$nom_tra.' Titular de la Cédula de Identidad N° '.$ced_tra.' presta sus servicios en esta Intitución y desempeña actualmente el cargo de '.$usu_car.', adscrito a la '.$nomGere.' agradecemos a las autoridades civiles y militares permitir el libre tránsito para que desempeñe sus labores en esta institución debido a que pertenecemos a un sector PRIORIZADO por ser un Medio de Comunicación de Estado. '), 0,'FJ');


$pdf->Ln(15);
$pdf->Cell(180,7,utf8_decode('Constancia que se expide en la ciudad de Caracas el día '.fechaCastellano(date("d-m-Y")).''),0,1,'C');
$pdf->Image("../img/firma.png",85,147,20,0,'PNG');
$pdf->Image("../img/sello.png",103,150,40,0,'PNG');
$pdf->Ln(35);
$pdf->Cell(180,7,utf8_decode("_____________________"),0,1,'C');
$pdf->Cell(180,5,utf8_decode("Lic. Jared Cabezas"),0,1,'C');
$pdf->Cell(180,5,utf8_decode("Gerente de Talento Humano (E)"),0,1,'C');
$pdf->SetFont('Arial','I',9);
$pdf->Ln(55);
$pdf->MultiCell(0,7,utf8_decode("Para la verificación de esta constancia generada electronicamente, por favor entrar a la pagina principal de la institución por medio de este enlace http://radiomundial.com.ve/content/verificacion y colocar el número de verificación: "));	
$pdf->Ln(10);
$pdf->Line(12, 265, 195, 265);
$pdf->MultiCell(0,5,utf8_decode("Dirección: Calle Nueva York, entre calle Madrid y avenida Río de Janeiro, edificio Mundial (Manzanillo), urbanización Las Mercedes."));
$pdf->Cell(180,5,utf8_decode("Gerencia de Talento Humano Teléfono (0212)991-08-08 Ext:3220"),0,1,'C');


$pdf->Output('', 'Constancia-Laboral-'.$_SESSION['cedula'].'.pdf');
?>