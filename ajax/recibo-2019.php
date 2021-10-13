<?php
include('../conf/valida.php');
include('../conf/db.php');

$sql1 = "SELECT DISTINCT T1.anocur, REPLACE(ltrim(REPLACE(T1.codperi,'0',' ')),' ','0') AS peri FROM sno_hperiodo T1 WHERE extract (month FROM T1.fecdesper) = '".$_POST['mes']."' and T1.codnom IN ('0001','0002','0003') order by peri asc";
$resul = pg_query($conn2020,$sql1);
 while ($row = pg_fetch_assoc($resul)) {
      $peri=$row['peri'];
      if ($peri%2==0){
    echo '<option value="'.htmlspecialchars($row['peri']).'"> Segunda Quincena </option>';
}else{
   echo '<option value="'.htmlspecialchars($row['peri']).'"> Primera Quincena </option>';
	}           
        }
?>