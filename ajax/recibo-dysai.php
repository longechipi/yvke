<?php
include('../conf/valida.php');
include('../conf/db.php');
if (!isset($_SESSION['cedula'])) { header('location:index.html'); }
$cedula = $_SESSION['cedula'];
$sql = "SELECT extract (month from nom_desde) as mes FROM vw_rhnommvd WHERE fic_cedula = '$cedula' and per_base='".$_GET['id']."' group by per_base, mes order by mes asc";
$resul = pg_query($conDy,$sql);
function nombremes($Nom){
    setlocale(LC_TIME, 'es_VE.utf8');
    $nombre=strftime("%B",mktime(0, 0, 0, $Nom, 1, 2000)); 
    return $nombre;
    } 
echo '<option value="">Seleccione el Mes</option>';        
    while ($row = pg_fetch_assoc($resul)) {
        $Nom=nombremes($row['mes']);
        echo '<option value="'.htmlspecialchars($row['mes']).'"> '.$Nom.' </option>';
    }
?>