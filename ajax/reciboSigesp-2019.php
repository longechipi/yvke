<?php
include('../conf/valida.php');
include('../conf/db.php');
if (!isset($_SESSION['cedula'])) { header('location:index.html'); }
$cedula = $_SESSION['cedula'];

if(isset($_POST['anocur']) && !empty($_POST['anocur'])){
$sql = "SELECT DISTINCT extract (month FROM T2.fecdesper) AS mes FROM sno_hpersonalnomina T1 INNER JOIN sno_hperiodo T2 ON T2.anocur = T1.anocur WHERE replace(ltrim(replace(T1.codper,'0',' ')),' ','0')='$cedula' AND T1.anocur='".$_POST['anocur']."' order by mes asc";
$resul = pg_query($conn2020,$sql);
function nombremes($Nom){
    setlocale(LC_TIME, 'es_VE.utf8');
    $nombre=strftime("%B",mktime(0, 0, 0, $Nom, 1, 2000)); 
    return $nombre;
    } 
 echo '<option value="">Seleccione Mes</option>';        
    while ($row = pg_fetch_assoc($resul)) {
      $Nom=nombremes($row['mes']);
            echo '<option value="'.htmlspecialchars($row['mes']).'"> '.$Nom.' </option>';
        }
}
?>