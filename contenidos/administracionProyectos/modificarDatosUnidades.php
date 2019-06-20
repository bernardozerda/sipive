<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$txtPrefijoRuta = "../../";
//var_dump($_FILES);
include( "../../librerias/phpExcel/Classes/PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosUnidades.class.php" );

$claDatosUnidades = new DatosUnidades();
$claSeguimiento = new SeguimientoProyectos();

function isHomogenous($arr) {
    $firstValue = current($arr);
    foreach ($arr as $val) {
        if ($firstValue !== $val) {

            return false;
        }
    }
    return true;
}

if ($_POST['seqProyectoPadre'] != "" && $_POST['seqProyectoPadre'] != null) {

    $seqProyecto = $_POST['seqProyectoPadre'];
    $infCantUnidades = $claDatosUnidades->ObtenerCantUnidadesProyecto($seqProyecto);
    $unidadesReg = $infCantUnidades['cantidad'];
    $totalUnidades = $infCantUnidades['valNumeroSoluciones'];
    $cantUDisponible = $totalUnidades - $unidadesReg;
    // echo "<p>" . $cantUDisponible . "</p>";    
    if ($_FILES["archivo"] != "" && is_uploaded_file($_FILES["archivo"]['tmp_name'])) {

        $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES["archivo"]['tmp_name']);
        $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
        $objPHPExcel = $objReader->load($_FILES["archivo"]['tmp_name']);
        $name = basename($_FILES['archivo']['name']);
        $objHoja = $objPHPExcel->getSheet(0);
        $arrayNum = array(0); //
        $arrayVal = array(2, 3);
// obtiene las dimensiones del archivo para la obtencion del contenido por rangos
        $numFilas = $objHoja->getHighestRow();
        $numColumnas = PHPExcel_Cell::columnIndexFromString($objHoja->getHighestColumn()) - 1;

        //  echo $numColumnas;
// obtiene los datos del rango obtenido
        $arrayDatosProyNew = Array();
        $arrayDatosProyOld = Array();
        $arrayMod = Array();
        $arrayEsqu = Array();
        $arrayPlanGob = Array();
        $arraSeqUnidades = Array();
        $arrArchivo = Array();
        $arrayTitle = Array();
        $encabezado = array('ID Unidad', 'Proyecto', 'Conjunto', 'Nombre de la unidad', 'Estado Actual', 'Nuevo Estado', 'Activo', 'Modalidad', 'Esquema', 'Plan de Gobierno');

        for ($numFila = 1; $numFila <= $numFilas; $numFila++) {
            for ($numColumna = 0; $numColumna <= $numColumnas; $numColumna++) {
                if ($numFila != 1) {
                    if ($objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue() != "") {
                        $numFilaArreglo = $numFila - 1;
                        $letra = chr(65 + ($numColumna));
                        if (in_array($numColumna, $arrayNum)) {
                            if (is_numeric($objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue())) {
                                $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                                $arraSeqUnidades[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            } else {
                                $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Por favor verifique que  el campo de la <b>Fila " . ($numFilaArreglo + 1) . "</b> en la <b>Columna " . $letra . " </b> Sea de tipo numerico </h5></div>";
                            }
                        } else if ($objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue() == "") {
                            // echo "<p> numFila " . $numFila . " - <b>" . $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue() . "</b>  numColumna -> " . $numColumna . " letra -> " . $letra . "</p>";
                            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Por favor verifique que  el campo de la <b>Fila " . ($numFilaArreglo + 1) . "</b> en la <b>Columna " . $letra . " </b> se encuentra vacio </h5></div>";
                        } else {
                            if (($numColumna == 5))
                                $arrayEstado[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            if (($numColumna == 7))
                                $arrayMod[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            if (($numColumna == 8))
                                $arrayEsqu[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            if (($numColumna == 9))
                                $arrayPlanGob[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                        }
                    }
                }else {
                    if ($numColumnas != 10) {
                        $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Verifique la plantilla el numero de columnas no corresponde!</h5></div>";
                    } else {
                        if ($objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue() != null)
                            $arrayTitle[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                    }

                    // echo "<br>" . 
                }
            }
        }
        $resultTitle = array_diff($encabezado, $arrayTitle);
      
        if (!empty($resultTitle)) {
            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Existe diferencias entre los titulos de la plantilla por favor verifica los titulos de las $numColumnas Columnas desde $resultTitle[1]!</h5></div>";
            $arrErrores[] = "<div class='alert alert-danger'><h5> El orden de los titulos son: <br><br>$encabezado[0] - $encabezado[1] - $encabezado[2] - $encabezado[3] - $encabezado[4] - $encabezado[5] - $encabezado[6] - $encabezado[7] - $encabezado[8] - $encabezado[9] !</h5></div>";
        }



        $band = (isHomogenous($arrayEstado));
        if (!$band)
            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Verifique que el <b>Estado de las unidades</b> sea el mismo para todas las filas!</h5></div>";
        $band = (isHomogenous($arrayMod));
        if (!$band)
            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Verifique que la <b>Modalidad</b> sea la misma para todas las filas!</h5></div>";
        $band = (isHomogenous($arrayEsqu));
        if (!$band)
            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Verifique que el <b>Tipo Esquema</b> sea el mismo para todas las filas!</h5></div>";
        $band = (isHomogenous($arrayPlanGob));
        if (!$band)
            $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Verifique que el <b>Plan de Gobierno</b> sea el mismo para todas las filas!</h5></div>";

        // var_dump($arrErrores);

        if (empty($arrErrores)) {

            $band = true;
            //var_dump($arrArchivo); exit();
            foreach ($arrArchivo as $key => $value) {
                // $arrayDatosProyOld[$seqProyecto][] = $value[6];
                $arrayDatosProyNew[$seqProyecto]['seqEstadoUnidad'] = explode("-", $value[5])[0];
                $arrayDatosProyNew[$seqProyecto]['txtNombreUnidad'] .= "<br>" . $value[3];
                $arrayDatosProyNew[$seqProyecto]['seqModalidad'] = explode("-", $value[7])[0];
                $arrayDatosProyNew[$seqProyecto]['seqTipoEsquema'] = explode("-", $value[8])[0];
                $arrayDatosProyNew[$seqProyecto]['seqPlanGobierno'] = explode("-", $value[9])[0];
                $arrayDatosProyNew[$seqProyecto]['bolActivo'] = $value[6];

                if ($value[7] != "Seleccione" && $value[6] != $value[7]) {

                    $bandUnidades = $claDatosUnidades->ValidarUnidadesProyecto($seqProyecto, $value[0]);
                    if (!$bandUnidades) {
                        $band = false;
                    }
                }
            }
            if ($band) {
                $seqUnidades = implode(",", $arraSeqUnidades);

                $arrayDatosUnd = $claDatosUnidades->obtenerDatosUnidades($seqProyecto, $seqUnidades);
                foreach ($arrayDatosUnd as $key => $value) {
                    $arrayDatosProyOld[$seqProyecto]['seqEstadoUnidad'] = explode("-", $value['estado'])[0];
                    $arrayDatosProyOld[$seqProyecto]['seqModalidad'] = $value['seqModalidad'];
                    $arrayDatosProyOld[$seqProyecto]['seqTipoEsquema'] = $value['seqTipoEsquema'];
                    $arrayDatosProyOld[$seqProyecto]['seqPlanGobierno'] = $value['seqPlanGobierno'];
                    $arrayDatosProyOld[$seqProyecto]['bolActivo'] = $value[6];
                }
//                pr($arrayDatosProyOld);
//                pr($arrayDatosProyNew);

                $array = $claDatosUnidades->modificarDatosUnidad($arrArchivo, $seqProyecto);

                if ($array) {
//                 

                    $txtComentarios = $_POST['txtComentario'];
                    $seqGestion = $_POST['seqGestion'];

                    $claSeguimiento->almacenarSeguimiento($seqProyecto, $txtComentarios, $seqGestion, $arrayDatosProyOld, $arrayDatosProyNew);
                    ?>
                    <div class='alert alert-success'><h5><b>Exito!!!</b> Los datos que se almacenaron se listan a continuación: </h5></div>
                    <table>
                        <tr>
                            <th>Id Unidad </th>
                            <th>Proyecto </th>
                            <th>Conjunto</th>
                            <th>Nombre de la unidad </th>                                                   
                            <th>Estado Anterior</th>
                            <th>Nuevo Estado </th>                            
                            <th>Activo </th>
                            <th>Modalidad</th>
                            <th>Esquema</th>   
                            <th>Plan de Gobierno</th>                            
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
                                <td><?php echo $value[6] ?></td>
                                <td><?php echo $value[7] ?></td>
                                <td><?php echo $value[8] ?></td>
                                <td><?php echo $value[9] ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        imprimirMensajes($array, array(), 'mensajes');
                    }
                } else {
                    $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!! Por favor verifique que las unidades correspondan al proyecto seleccionado</b></h5></div>";
                    imprimirMensajes($arrErrores, array(), 'mensajes');
                }
                ?>
            </table>
            <?php
            //var_dump($arrArchivo);
        } else {
            imprimirMensajes($arrErrores, array(), 'mensajes');
            //  var_dump($arrErrores);
        }
    } else {
        $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!!  Debe seleccionar un Archivo</h5></div>";
        imprimirMensajes($arrErrores, array(), 'mensajes');
    }
} else {
    $arrErrores[] = "<div class='alert alert-danger'><h5>Alerta!!  Debe seleccionar un proyecto</h5></div>";
    imprimirMensajes($arrErrores, array(), 'mensajes');
}
