<?php
include('../conf/db.php');
include('../conf/valida.php');
include('../conf/funciones.php');
if (!isset($_SESSION['cedula'])) {
    header('location:../index.html');
}
require('../vendor/fpdf/fpdf.php');

$ciudad = $_POST['ciudad'];
$monto = $_POST['txt1'];
$comple = $_POST['rad'];
$cedula = $_SESSION['cedula'];

$sql = "SELECT T1.codper, T1.codcueban, CONCAT (T2.apeper || ',',T2.nomper) AS nom_tra, T2.cedper,T3.descar,T4.denger
FROM sno_personalnomina T1 
INNER JOIN sno_personal T2 ON replace(ltrim(replace(T1.codper,'0',' ')),' ','0') = T2.cedper
INNER JOIN sno_cargo T3 ON T1.codcar = T3.codcar 
INNER JOIN srh_gerencia T4 ON T2.codger = T4.codger
WHERE replace(ltrim(replace(T1.codper,'0',' ')),' ','0')='$cedula' LIMIT 1";
$resul = pg_query($conP, $sql);
while ($row = pg_fetch_assoc($resul)) {
    $per_ctadep = $row['codcueban']; //Cuenta del empleado
    $nom_tra = $row['nom_tra']; //NOMBRE DE LA PERSONA
    $ced_tra = $row['cedper']; //CEDULA DE LA PERSONA
    $usu_car = $row['descar']; //NOMBRE DEL CARGO
}

if (isset($_POST['enviar2'])) {
    if (empty($ciudad)) {
        echo "<script type='text/javascript'> alert('POR FAVOR SELECCIONE LA CIUDAD'); document.location=('../view-fide.php'); </script>";
    }

    //Reviso si la variable esta vacia para que imprima la constancia
    if (empty($monto)) {
        class PDF extends FPDF
        {
        }

        // Creación del objeto de la clase heredada
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage("P", "Letter");
        $pdf->SetFont('Times', '', 12);
        $pdf->Sety((140) / 2);
        $pdf->Setx((35) / 2);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Text(20, 45, utf8_decode("Solicitud de Anticipo de Prestaciones Sociales"));
        $pdf->SetFont('Times', '', 12);
        // Logo del Banco Bicentenario
        $bicen = ('../img/LogoBicentenario.png');
        $pdf->Image("$bicen", 10, 10, 190, 0, 'PNG');
        $pdf->MultiCell(170, 6, utf8_decode('Yo, ' . $nom_tra . ' Venezolano(a), mayor de edad, titular de la cédula de identidad Nro: ' . $ced_tra . ' de profesión ' . $usu_car . ', domiciliado en la ciudad de ' . $ciudad . '

En cumplimiento de la Ley Órganica de Trabajo, de las Trabajadoras y Trabajadores, la cual fue publicada en la Gaceta Oficial de la República Bolivariana de Venezuela N° 6.076 Extraordinario, de fecha de 7 de Mayo de 2012, en su artículo N°144, así como los lineamientos establecidos en el Contrato de Fideicomiso entre mi persona y Banco Bicentenario, Banca Universal, C.A, solicito se realice un anticipo de ' . $comple . ' . Dicha solicitud será destinada para satisfacer obligaciones derivadas de:

  a.- La construcción, adquisición, mejora o reparación de vivienda para él y su familia.
  b.- La liberación de Hipoteca o de cualquier otro gravamen sibre vivienda de su propiedad.
  c.- La inversión de educación para él, ella o su familia.
  d.- Los gastos por atención médica hospitalaria de las personas indicadas en el literal anterior.

Agradezco realizar los depósitos correspondientes en la cuenta número: ' . $per_ctadep . ' del Banco Bicentenario, Banca Universal, C.A'), 0, 'J');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Text(85, 185, utf8_decode("Recibe conforme:"));
        $pdf->SetFont('Times', '', 12);
        $pdf->Sety((376) / 2);
        $pdf->Setx((38) / 2);
        $pdf->Cell(85, 7, utf8_decode("Nombre y Apellido"), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode("Cédula de Identidad"), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode("Firma y Huella"), 1, 0, 'C');
        $pdf->Ln();
        $pdf->Sety((390) / 2);
        $pdf->Setx((38) / 2);
        $pdf->Cell(85, 25, utf8_decode("$nom_tra"), 1, 0, 'C');
        $pdf->Cell(40, 25, utf8_decode("$ced_tra"), 1, 0, 'C');
        $pdf->Cell(40, 25, utf8_decode(""), 1, 0, 'C');
    } else {
        class PDF extends FPDF
        {
        }
        // Creación del objeto de la clase heredada
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage("P", "Letter");
        $pdf->SetFont('Times', '', 12);
        $pdf->Sety((140) / 2);
        $pdf->Setx((35) / 2);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Text(20, 45, utf8_decode("Solicitud de Anticipo de Prestaciones Sociales"));
        $pdf->SetFont('Times', '', 12);
        // Logo del Banco Bicentenario
        $bicen = ('../img/LogoBicentenario.png');
        $pdf->Image("$bicen", 10, 10, 190, 0, 'PNG');

        $pdf->MultiCell(170, 6, utf8_decode('Yo, ' . $nom_tra . ' Venezolano(a), mayor de edad, titular de la cédula de identidad Nro: ' . $ced_tra . ' de profesión ' . $usu_car . ', domiciliado en la ciudad de ' . $ciudad . '

En cumplimiento de la Ley Órganica de Trabajo, de las Trabajadoras y Trabajadores, la cual fue publicada en la Gaceta Oficial de la República Bolivariana de Venezuela N° 6.076 Extraordinario, de fecha de 7 de Mayo de 2012, en su artículo N°144, así como los lineamientos establecidos en el Contrato de Fideicomiso entre mi persona y Banco Bicentenario, Banca Universal, C.A, solicito se realice un anticipo de ' . number_format(($monto), 2, ",", ".") . ' Bs. Dicha solicitud será destinada para satisfacer obligaciones derivadas de:

  a.- La construcción, adquisición, mejora o reparación de vivienda para él y su familia.
  b.- La liberación de Hipoteca o de cualquier otro gravamen sibre vivienda de su propiedad.
  c.- La inversión de educación para él, ella o su familia.
  d.- Los gastos por atención médica hospitalaria de las personas indicadas en el literal anterior.

Agradezco realizar los depósitos correspondientes en la cuenta número: ' . $per_ctadep . ' del Banco Bicentenario, Banca Universal, C.A'), 0, 'J');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Text(85, 185, utf8_decode("Recibe conforme:"));
        $pdf->SetFont('Times', '', 12);
        $pdf->Sety((376) / 2);
        $pdf->Setx((38) / 2);
        $pdf->Cell(85, 7, utf8_decode("Nombre y Apellido"), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode("Cédula de Identidad"), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode("Firma y Huella"), 1, 0, 'C');
        $pdf->Ln();
        $pdf->Sety((390) / 2);
        $pdf->Setx((38) / 2);
        $pdf->Cell(85, 25, utf8_decode("$nom_tra"), 1, 0, 'C');
        $pdf->Cell(40, 25, utf8_decode("$ced_tra"), 1, 0, 'C');
        $pdf->Cell(40, 25, utf8_decode(""), 1, 0, 'C');
    }
    $pdf->Output();
} else {
    echo "<script>alert('ERROR');</script>";
}
