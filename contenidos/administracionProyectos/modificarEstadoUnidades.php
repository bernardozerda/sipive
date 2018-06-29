<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$txtPrefijoRuta = "../../";

include( "../../librerias/phpExcel/Classes/PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosUnidades.class.php" );

$claDatosUnidades = new DatosUnidades();

if ($_POST['seqProyectoPadre'] != "" && $_POST['seqProyectoPadre'] != null) {

    $seqProyecto = $_POST['seqProyectoPadre'];
    $infCantUnidades = $claDatosUnidades->ObtenerCantUnidadesProyecto($seqProyecto);
    $unidadesReg = $infCantUnidades['cantidad'];
    $totalUnidades = $infCantUnidades['valNumeroSoluciones'];
    $cantUDisponible = $totalUnidades - $unidadesReg;
    // echo "<p>" . $cantUDisponible . "</p>";
    if ( $_FILES["archivo"] != "" && is_uploaded_file($_FILES["archivo"]['tmp_name'])) {

        $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES["archivo"]['tmp_name']);
        $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
        $objPHPExcel = $objReader->load($_FILES["archivo"]['tmp_name']);
        $objHoja = $objPHPExcel->getSheet(0);
        $arrayNum = array(0); //
        $arrayVal = array(2,3);
// obtiene las dimensiones del archivo para la obtencion del contenido por rangos
        $numFilas = $objHoja->getHighestRow();
        $numColumnas = PHPExcel_Cell::columnIndexFromString($objHoja->getHighestColumn()) - 1;
      //  echo $numColumnas;

// obtiene los datos del rango obtenido
        for ($numFila = 1; $numFila <= $numFilas; $numFila++) {
            if ($numFila != 1) {
                for ($numColumna = 0; $numColumna <= $numColumnas; $numColumna++) {
                    $numFilaArreglo = $numFila - 1;
                    $letra = chr(65 + ($numColumna));
                    if (in_array($numColumna, $arrayNum)) {
                      //  echo "<p>".$objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue()."</p>";
                        if (is_numeric($objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue())) {
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                        } else {
                            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Por favor verifique que  el campo de la <b>Fila " . ($numFilaArreglo + 1) . "</b> en la <b>Columna " . $letra . " </b> Sea de tipo numerico </h5></div>";
                        }
                    }  else if ($objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue() == "") {
                        $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Por favor verifique que  el campo de la <b>Fila " . ($numFilaArreglo + 1) . "</b> en la <b>Columna " . $letra . " </b> se encuentra vacio </h5></div>";
                    } else {
                        $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                    }
                }
            }
        }
        if (empty($arrErrores)) {
      
            $array = $claDatosUnidades->modificarEstadoUnidad($arrArchivo, $seqProyecto);
            if (empty($array)) {
                ?>
                <div class='alert alert-success'><h5><b>Exito!!!</b> Los datos que se almacenaron se listan a continuación: </h5></div>
                <table>
                    <tr>
                        <th>Id Unidad </th>
                         <th>Proyecto </th>
                        <th>Nombre de la unidad </th>
                        <th>Conjunto</th>
                        <th>Estado Anterior</th>
                        <th>Nuevo Estado </th>                        
                    </tr>
                    <?php
                    foreach ($arrArchivo as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value[0] ?></td>
                            <td><?php echo $value[1] ?></td>
                            <td><?php echo $value[2] ?></td>
                            <td><?php echo $value[3] ?></td>
                            <td><?php echo $value[4] ?></td>
                            <td><?php echo $value[5] ?></td>
                          
                        </tr>
                        <?php
                    }
                } else {
                    imprimirMensajes($array, array(), 'mensajes');
                }
                ?>
            </table>
            <?php
            //var_dump($arrArchivo);
        } else {
            imprimirMensajes($arrErrores, array(), 'mensajes');
            //  var_dump($arrErrores);
        }
    }else{
         $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!!  Debe seleccionar un Archivo</h5></div>";
          imprimirMensajes($arrErrores, array(), 'mensajes');
    }
} else {
    $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!!  Debe seleccionar un proyecto</h5></div>";
    imprimirMensajes($arrErrores, array(), 'mensajes');
}