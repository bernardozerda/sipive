<?php
//header("Content-Type: application/vnd.ms-excel");
//header("content-disposition: attachment;filename=imagenes.xls");
//$directorio = opendir("recursos/imagenes/desembolsos"); //ruta actual
//echo "<table>";
//while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
//{
//    if (is_dir($archivo))//verificamos si es o no un directorio
//    {
//        echo "<tr><td>[".$archivo . "]</td></tr>"; //de ser un directorio lo envolvemos entre corchetes
//    } else {
//        echo "<tr><td>" . $archivo . "</td></tr>";
//    }
//}
//echo "</table>";

 include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
        include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
       
           $cont =0;
            $sqlForm = mysql_query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'sipive' AND engine = 'MyIsam'");
            while($rowForm = mysql_fetch_array($sqlForm)){
               // var_dump($rowForm);
               echo "<br>".("ALTER TABLE ".$rowForm['TABLE_NAME']." ENGINE = INNOD;");
               mysql_query("ALTER TABLE `".$rowForm['TABLE_NAME']."` ENGINE = INNODB;"); 
                $cont++;
            }
           echo "<br> contador = ".$cont;
?>