<?php
//////////// FUNCION PARA GENERAR CONTASEÑA PROVISIONAL ////////////
function generaPass()
{
   $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
   $longitudCadena = strlen($cadena);
   $pass = "";
   $longitudPass = 10;
   for ($i = 1; $i <= $longitudPass; $i++) {
      $pos = rand(0, $longitudCadena - 1);
      $pass .= substr($cadena, $pos, 1);
   }
   return $pass;
}
//////////// FUNCION PARA SACAR CONSOLE LOG ////////////
function console_log($output, $with_script_tags = true)
{
   $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
      ');';
   if ($with_script_tags) {
      $js_code = '<script>' . $js_code . '</script>';
   }
   echo $js_code;
}
//////////// FUNCION PARA MOSTRAR NOMBRE DEL TRABAJADOR ////////////
function nombre()
{
   include('db.php');
   $nom_tra = $_SESSION['cedula'];
   $sql = "SELECT CONCAT (apeper || ', ',nomper) as nom_tra FROM sno_personal WHERE cedper='$nom_tra'";
   $result1 = pg_query($conP, $sql);
   $row = pg_fetch_array($result1);
   $nombre = $row['nom_tra'];
   echo $nombre;
}
//////////// FUNCION PARA MOSTRAR FECHA ACTUAL ////////////
function fechaCastellano($fecha)
{
   $fecha = substr($fecha, 0, 10);
   $numeroDia = date('d', strtotime($fecha));
   $dia = date('l', strtotime($fecha));
   $mes = date('F', strtotime($fecha));
   $anio = date('Y', strtotime($fecha));
   $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
   $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
   $nombredia = str_replace($dias_EN, $dias_ES, $dia);
   $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
   $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
   $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
   return $nombredia . " " . $numeroDia . " de " . $nombreMes . " de " . $anio;
}
//////////// FUNCION PARA MOSTRAR MES ACTUAL ////////////
function mesActual()
{
   $date = getDate();
   $Meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
   echo $Meses[$date['mon'] - 1];
}
//////////// FUNCION PRIMA DE ANTIGUEDAD////////////
function primaantiguedad($fechaingreso)
{
   list($ano, $mes, $dia) = explode("-", $fechaingreso);
   $ano_diferencia  = date("Y") - $ano;
   $mes_diferencia = date("m") - $mes;
   $dia_diferencia   = date("d") - $dia;
   if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
   return $ano_diferencia;
}
//////////// FUNCION NUMEROS A LETRAS////////////
class EnLetras
{
   var $Void = "";
   var $SP = " ";
   var $Dot = ".";
   var $Zero = "0";
   var $Neg = "Menos";

   function ValorEnLetras($x)
   {
      $s = "";
      $Ent = "";
      $Frc = "";
      $Signo = "";

      if (floatVal($x) < 0)
         $Signo = $this->Neg . " ";
      else
         $Signo = "";

      if (intval(number_format($x, 2, '.', '')) != $x) //<- averiguar si tiene decimales
         $s = number_format($x, 2, '.', '');
      else
         $s = number_format($x, 0, '.', '');

      $Pto = strpos($s, $this->Dot);

      if ($Pto === false) {
         $Ent = $s;
         $Frc = $this->Void;
      } else {
         $Ent = substr($s, 0, $Pto);
         $Frc =  substr($s, $Pto + 1);
      }

      if ($Ent == $this->Zero || $Ent == $this->Void)
         $s = "Cero ";
      elseif (strlen($Ent) > 7) {
         $s = $this->SubValLetra(intval(substr($Ent, 0,  strlen($Ent) - 6))) .
            "Millones " . $this->SubValLetra(intval(substr($Ent, -6, 6)));
      } else {
         $s = $this->SubValLetra(intval($Ent));
      }

      if (substr($s, -9, 9) == "Millones " || substr($s, -7, 7) == "Millón ")
         $s = $s . "de ";

      //$s = $s . $Moneda;

      if ($Frc != $this->Void) {
         $s = $s . " Con " . $this->SubValLetra(intval($Frc)) . "Céntimos";
         //$s = $s . " " . $Frc . "/100";
      }
      return ($Signo . $s . "");
   }
   function SubValLetra($numero)
   {
      $Ptr = "";
      $n = 0;
      $i = 0;
      $x = "";
      $Rtn = "";
      $Tem = "";
      $x = trim("$numero");
      $n = strlen($x);
      $Tem = $this->Void;
      $i = $n;
      while ($i > 0) {
         $Tem = $this->Parte(intval(substr($x, $n - $i, 1) .
            str_repeat($this->Zero, $i - 1)));
         if ($Tem != "Cero")
            $Rtn .= $Tem . $this->SP;
         $i = $i - 1;
      }
      //--------------------- GoSub FiltroMil ------------------------------
      $Rtn = str_replace(" Mil Mil", " Un Mil", $Rtn);
      while (1) {
         $Ptr = strpos($Rtn, "Mil ");
         if (!($Ptr === false)) {
            if (!(strpos($Rtn, "Mil ", $Ptr + 1) === false))
               $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr);
            else
               break;
         } else break;
      }
      //--------------------- GoSub FiltroCiento ------------------------------
      $Ptr = -1;
      do {
         $Ptr = strpos($Rtn, "Cien ", $Ptr + 1);
         if (!($Ptr === false)) {
            $Tem = substr($Rtn, $Ptr + 5, 1);
            if ($Tem == "M" || $Tem == $this->Void);
            else
               $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr);
         }
      } while (!($Ptr === false));
      //--------------------- FiltroEspeciales ------------------------------
      $Rtn = str_replace("Diez Un", "Once", $Rtn);
      $Rtn = str_replace("Diez Dos", "Doce", $Rtn);
      $Rtn = str_replace("Diez Tres", "Trece", $Rtn);
      $Rtn = str_replace("Diez Cuatro", "Catorce", $Rtn);
      $Rtn = str_replace("Diez Cinco", "Quince", $Rtn);
      $Rtn = str_replace("Diez Seis", "Dieciseis", $Rtn);
      $Rtn = str_replace("Diez Siete", "Diecisiete", $Rtn);
      $Rtn = str_replace("Diez Ocho", "Dieciocho", $Rtn);
      $Rtn = str_replace("Diez Nueve", "Diecinueve", $Rtn);
      $Rtn = str_replace("Veinte Un", "Veintiun", $Rtn);
      $Rtn = str_replace("Veinte Dos", "Veintidos", $Rtn);
      $Rtn = str_replace("Veinte Tres", "Veintitres", $Rtn);
      $Rtn = str_replace("Veinte Cuatro", "Veinticuatro", $Rtn);
      $Rtn = str_replace("Veinte Cinco", "Veinticinco", $Rtn);
      $Rtn = str_replace("Veinte Seis", "Veintiseís", $Rtn);
      $Rtn = str_replace("Veinte Siete", "Veintisiete", $Rtn);
      $Rtn = str_replace("Veinte Ocho", "Veintiocho", $Rtn);
      $Rtn = str_replace("Veinte Nueve", "Veintinueve", $Rtn);
      //--------------------- FiltroUn ------------------------------
      if (substr($Rtn, 0, 1) == "M") $Rtn = "Un " . $Rtn;
      //--------------------- Adicionar Y ------------------------------
      for ($i = 65; $i <= 88; $i++) {
         if ($i != 77)
            $Rtn = str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
      }
      $Rtn = str_replace("*", "a", $Rtn);
      return ($Rtn);
   }
   function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr)
   {
      $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
   }
   function Parte($x)
   {
      $Rtn = '';
      $t = '';
      $i = '';
      do {
         switch ($x) {
            case 0:
               $t = "Cero";
               break;
            case 1:
               $t = "Un";
               break;
            case 2:
               $t = "Dos";
               break;
            case 3:
               $t = "Tres";
               break;
            case 4:
               $t = "Cuatro";
               break;
            case 5:
               $t = "Cinco";
               break;
            case 6:
               $t = "Seis";
               break;
            case 7:
               $t = "Siete";
               break;
            case 8:
               $t = "Ocho";
               break;
            case 9:
               $t = "Nueve";
               break;
            case 10:
               $t = "Diez";
               break;
            case 20:
               $t = "Veinte";
               break;
            case 30:
               $t = "Treinta";
               break;
            case 40:
               $t = "Cuarenta";
               break;
            case 50:
               $t = "Cincuenta";
               break;
            case 60:
               $t = "Sesenta";
               break;
            case 70:
               $t = "Setenta";
               break;
            case 80:
               $t = "Ochenta";
               break;
            case 90:
               $t = "Noventa";
               break;
            case 100:
               $t = "Cien";
               break;
            case 200:
               $t = "Doscientos";
               break;
            case 300:
               $t = "Trescientos";
               break;
            case 400:
               $t = "Cuatrocientos";
               break;
            case 500:
               $t = "Quinientos";
               break;
            case 600:
               $t = "Seiscientos";
               break;
            case 700:
               $t = "Setecientos";
               break;
            case 800:
               $t = "Ochocientos";
               break;
            case 900:
               $t = "Novecientos";
               break;
            case 1000:
               $t = "Mil";
               break;
            case 1000000:
               $t = "Millón";
               break;
         }
         if ($t == $this->Void) {
            $i = $i + 1;
            $x = $x / 1000;
            if ($x == 0) $i = 0;
         } else
            break;
      } while ($i != 0);
      $Rtn = $t;
      switch ($i) {
         case 0:
            $t = $this->Void;
            break;
         case 1:
            $t = " Mil";
            break;
         case 2:
            $t = " Millones";
            break;
         case 3:
            $t = " Billones";
            break;
      }
      return ($Rtn . $t);
   }
}
