<?php
//Fecha creacion 17-06-2021//
//Autor: Jean Castillo//
include('../conf/db.php');
include('../conf/valida.php');
include('../conf/funciones.php');
if (!isset($_SESSION['cedula'])) { 
header('location:../index.html'); 
}
require ('../vendor/fpdf/fpdf.php');
$cedula = $_SESSION['cedula'];
$sql="SELECT CONCAT (apeper || ',',nomper) as nom_tra,T1.anoservpreper , T1.fecingper, T1.codger, T1.cedper, T2.denger,T1.nivacaper,T1.numhijper FROM sno_personal T1 INNER JOIN srh_gerencia T2 ON T1.codger = T2.codger WHERE cedper='$cedula'";
$resultado = pg_query($conP,$sql);
while ($row = pg_fetch_assoc($resultado)) 
{ 
$nom_tra=$row['nom_tra'];//NOMBRE DE LA PERSONA
$ced_tra=$row['cedper']; //CEDULA DE LA PERSONA
$fe_ing=$row['fecingper'];//FECHA DE INGRESO
$nomGere= $row['denger'];//NOMBRE DE LA GERENCIA
$niaca= $row['nivacaper']; //NIVEL ACADEMICO
$numhijo= $row['numhijper']; //NIVEL ACADEMICO
$anos_public=$row['anoservpreper']; //AÑOS DE SERVICIO EN LA ADMIN PUBLICA
}
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
if(isset($_POST['formSubmit'])) 
	{
		$ano = $_POST['ano'];
		if(!isset($ano)) 
		{
			echo "<script type='text/javascript'> alert('Por Favor Seleccione el Año'); document.location=('../view-arc.php'); </script>";;
		} 
		else 
		{
		foreach ($_POST['ano'] as $vaina=>$ano_cur){}	
		}
	}
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetTitle('Constancia ARC-'.$_SESSION['cedula']);
$pdf->SetAuthor('Intranet Yvke Mundial');
$pdf->SetCreator('Sistema Integrado de Talento Humano YVKE-MUNDIAL');
$pdf->SetFont('Times','',12);
$pdf->Ln(20);
$pdf->Cell(0, 5, 'RADIO MUNDIAL C.A', 0, 1,'C');
$pdf->Cell(0, 5, 'GERENCIA DE TALENTO HUMANO', 0, 1,'C');
$pdf->SetFont('Times','B',12);
$pdf->Cell(0, 5, 'INFORME CORRESPONDIENTE AL EJERCICIO FISCAL '.$ano_cur, 0, 1,'C');
$pdf->SetFont('Times','',11);
$pdf->Ln(8);
$pdf->Cell(40,7,utf8_decode("Cédula:   $ced_tra") ,0,0,'L');
$pdf->Cell(150,7,utf8_decode("Apellidos y Nombres: $nom_tra"),0,0,'R');
$pdf->Ln();
$pdf->Cell(91,7,utf8_decode("Organismo: RADIO MUNDIAL C.A"),0,0,'L');
$pdf->Cell(70,7,utf8_decode("RIF: G-20009525-3"),0,0,'L');
$pdf->Ln();
$pdf->Cell(91,7,utf8_decode("Agente de Retención: RADIO MUNDIAL C.A") ,0,0,'L');
$pdf->Cell(70,7,utf8_decode("RIF: G-20009525-3") ,0,0,'L');
$pdf->Ln();
$pdf->Cell(198,7,utf8_decode("Dirección: Calle Nueva York entre calle Madrid y Av. Río de Janeiro,Edf. YVKE, Las Mercedes, Caracas.") ,0,0,'L');
//$pdf->Line(11, 82, 200, 82); // 20mm from each Edge
$pdf->Ln(10);
$pdf->SetFont('Times','',11);
$pdf->Cell(48,7,utf8_decode("MES") ,'TBR',0,'C',0);
$pdf->Cell(58,7,utf8_decode("DEVENGADO MENSUAL") ,'TB',0,'C',0);
$pdf->Cell(38,7,utf8_decode("%ISLR") ,1,0,'C');
$pdf->Cell(48,7,utf8_decode("RETENCION MENSUAL") ,'TB',0,'C',0);
//QUERY
$sql2 = "SELECT sno_personalisr.codper, sno_personalisr.codisr, sno_personalisr.porisr, sno_hsalida.anocur, 
(SELECT SUM(valsal) 
   FROM sno_hsalida, sno_hconcepto, sno_hperiodo 
  WHERE sno_hsalida.codemp = '0001' 
    AND REPLACE(ltrim(REPLACE(sno_hsalida.codper,'0',' ')),' ','0')='$cedula'
  AND sno_hperiodo.anocur = '".$ano_cur."' 
    AND SUBSTR(cast(sno_hperiodo.fecdesper as char(10)),1,4) = '".$ano_cur."' 
    AND sno_personalisr.codisr = SUBSTR(cast(sno_hperiodo.fecdesper as char(10)),6,2) 
    AND sno_hconcepto.aplarccon = 1 
    AND (sno_hsalida.tipsal = 'A' OR sno_hsalida.tipsal = 'V1' OR sno_hsalida.tipsal = 'W1' 
     OR sno_hsalida.tipsal = 'D' OR sno_hsalida.tipsal = 'V2' OR sno_hsalida.tipsal = 'W2' 
     OR sno_hsalida.tipsal = 'P1' OR sno_hsalida.tipsal = 'V3' OR sno_hsalida.tipsal = 'W3') 
 AND sno_hsalida.codemp = sno_hperiodo.codemp 
    AND sno_hsalida.anocur = sno_hperiodo.anocur 
    AND sno_hsalida.codperi = sno_hperiodo.codperi 
    AND sno_hsalida.codnom = sno_hperiodo.codnom 
    AND sno_hsalida.codemp = sno_hconcepto.codemp 
    AND sno_hsalida.anocur = sno_hconcepto.anocur 
    AND sno_hsalida.codperi = sno_hconcepto.codperi 
    AND sno_hsalida.codnom = sno_hconcepto.codnom 
    AND sno_hsalida.codconc = sno_hconcepto.codconc 
    AND sno_hsalida.codemp = sno_personalisr.codemp 
    AND sno_hsalida.codper = sno_personalisr.codper 
  GROUP BY sno_hsalida.codper, sno_hperiodo.anocur, sno_personalisr.codisr) as arc, 
(SELECT SUM(valsal) 
   FROM sno_hsalida, sno_hconcepto, sno_hperiodo 
  WHERE sno_hsalida.codemp = '0001' 
    AND REPLACE(ltrim(REPLACE(sno_hsalida.codper,'0',' ')),' ','0')='$cedula'
    AND sno_hperiodo.anocur = '".$ano_cur."'
   AND SUBSTR(cast(sno_hperiodo.fecdesper as char(10)),1,4) = '".$ano_cur."' 
    AND sno_personalisr.codisr = SUBSTR(cast(sno_hperiodo.fecdesper as char(10)),6,2) 
    AND sno_hconcepto.aplisrcon = 1 
    AND (sno_hsalida.tipsal = 'A' OR sno_hsalida.tipsal = 'V1' OR sno_hsalida.tipsal = 'W1' 
     OR sno_hsalida.tipsal = 'D' OR sno_hsalida.tipsal = 'V2' OR sno_hsalida.tipsal = 'W2' 
     OR sno_hsalida.tipsal = 'P1' OR sno_hsalida.tipsal = 'V3' OR sno_hsalida.tipsal = 'W3')
     AND sno_hsalida.codemp = sno_hperiodo.codemp 
    AND sno_hsalida.anocur = sno_hperiodo.anocur 
    AND sno_hsalida.codperi = sno_hperiodo.codperi 
    AND sno_hsalida.codnom = sno_hperiodo.codnom 
    AND sno_hsalida.codemp = sno_hconcepto.codemp 
    AND sno_hsalida.anocur = sno_hconcepto.anocur 
    AND sno_hsalida.codperi = sno_hconcepto.codperi 
    AND sno_hsalida.codnom = sno_hconcepto.codnom 
    AND sno_hsalida.codconc = sno_hconcepto.codconc 
    AND sno_hsalida.codemp = sno_personalisr.codemp 
    AND sno_hsalida.codper = sno_personalisr.codper 
  GROUP BY sno_hsalida.codper, sno_hperiodo.anocur, sno_personalisr.codisr) as islr 
FROM sno_hsalida, sno_personalisr  
WHERE REPLACE(ltrim(REPLACE(sno_hsalida.codper,'0',' ')),' ','0')='$cedula'
AND sno_hsalida.codemp = '0001' 
AND sno_hsalida.anocur = '".$ano_cur."' 
AND sno_hsalida.codemp = sno_personalisr.codemp 
AND sno_hsalida.codper = sno_personalisr.codper 
GROUP BY sno_hsalida.codper, sno_hsalida.anocur, sno_personalisr.codisr, sno_personalisr.porisr, 
      sno_personalisr.codemp, sno_personalisr.codper 
ORDER BY sno_personalisr.codisr asc";
$resultado2 = pg_query($conP2,$sql2);
while ($row = pg_fetch_array($resultado2)) 
{
	$mesletra = $row['codisr'];
	$fecha = DateTime::createFromFormat('!m', $mesletra);
	setlocale(LC_ALL,"es_VE.utf8");
	$mes = strftime("%B", $fecha->getTimestamp()); 
	$arc = $row['arc']; 
	$isrl = $row['porisr'];
	$reten = $row['anocur']; 
$widths = array(35,52,43,45);
$border = array('','','','');
$align = array('R','R','R','R');
$empty = array(utf8_decode($mes),number_format(($arc),2,",","."), '0,00', '0,00');
$pdf->SetWidths($widths);
$pdf->Ln();
$pdf->FancyRow($empty,$border,$align);	
$suma_total_asig += $arc;
}
$pdf->SetFont('times','B',10);
$pdf->Cell(58,7,utf8_decode("Totales:") ,'TB',0,'C',0);
$pdf->Cell(29,7,number_format(($suma_total_asig),2,",","."),'TB',0,'R',0);
$pdf->Cell(80,7,utf8_decode("Total Deducciones: 0,00") ,'TB',0,'C',0);
$pdf->Cell(23,7,'0,00','TB',0,'C',0);
$pdf->Ln(25);
$pdf->SetFont('times','B',11);
$pdf->Cell(185,7,utf8_decode("_________________________") ,0,1,'C');
$pdf->Cell(185,5,utf8_decode("Lic. Jared Cabezas"),0,1,'C');
$pdf->Cell(185,7,utf8_decode("Gerencia General de Administración y Finanzas") ,0,1,'C');
$pdf->Ln(11);
$pdf->SetFont('times','',10);
$pdf->Line(10, 260, 200, 260);
$pdf->MultiCell(0,5,utf8_decode("Dirección: Calle Nueva York, entre calle Madrid y avenida Río de Janeiro, edificio Mundial (Manzanillo), urbanización Las Mercedes."));
$pdf->Cell(180,5,utf8_decode("Gerencia de Talento Humano Teléfono (0212)991-08-08 Ext:3220"),0,1,'C');
$pdf->Output('', 'ARC-'.$_SESSION['cedula'].'.pdf');
?>