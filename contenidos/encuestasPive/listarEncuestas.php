<?php

	$txtPrefijoRuta = "../../";
	include ($txtPrefijoRuta . "recursos/archivos/verificarSesion.php");
	include ($txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['funciones'] . "funciones.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/inclusionSmarty.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['carpetas'] ['recursos'] . "archivos/coneccionBaseDatos.php");
	include ($txtPrefijoRuta . $arrConfiguracion ['librerias'] ['clases'] . "Encuestas.class.php");

	$arrErrores = array();
	$arrMensajes = array();

    if( empty($_FILES) ) {

        if ($_POST['buscaCedulaConfirmacion'] != $_POST['buscaCedula']) {
            $arrErrores[] = "La cédula digitada y su confirmación no coinciden";
        }

        if (empty($arrErrores) and intval($_POST['buscaCedula']) != 0) {
            $numDocumento = mb_ereg_replace("[^0-9]", "", $_POST['buscaCedula']);
            $claEncuestas = new Encuestas();
            $arrAplicaciones = $claEncuestas->listarAplicaciones($numDocumento);

            if (empty($arrAplicaciones)) {
                $arrErrores[] = "El hogar no tiene aplicaciones de encuestas realizadas";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, $arrMensajes);
            } else {

                $seqProyecto = $_SESSION['seqProyecto'];
                if (isset($_SESSION['arrGrupos'][$seqProyecto][20])) {
                    $bolEliminar = true;
                } else {
                    $bolEliminar = false;
                }

                $claSmarty->assign("bolEliminar", $bolEliminar);
                $claSmarty->assign("arrAplicaciones", $arrAplicaciones);
                $claSmarty->display("encuestasPive/listarEncuestas.tpl");
            }
        }

    }else {

        if( $_POST['diseno'] == 0 ){
            $arrErrores[] = "Seleccione un diseño para exportar los resultados";
        }

        switch ($_FILES['documentos']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
                break;
            case UPLOAD_ERR_PARTIAL:
                $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
                break;
            case UPLOAD_ERR_NO_FILE:
                $arrErrores[] = "Debe cargar un archivo para obtener el reporte";
                break;
        }

        if( empty( $arrErrores ) ){

            $arrErrores = array();

            $arrDocumentos = file( $_FILES['documentos']['tmp_name'] );
            foreach($arrDocumentos as $i => $numDocumento){
                $arrDocumentos[$i] = doubleval($numDocumento);
            }

            if( ! empty($arrDocumentos) ){
                $claEncuestas = new Encuestas();
                foreach ($arrDocumentos as $numDocumento){
                    if( doubleval($numDocumento) != 0) {
                        $arrAplicaciones[$numDocumento] = array_shift($claEncuestas->listarAplicaciones($numDocumento, $_POST['diseno']));
                        if( empty($arrAplicaciones[$numDocumento]) ) {
                            $numPosicion = count($arrErrores);
                            $arrErrores[$numPosicion]['documento'] = $numDocumento;
                            $txtDiseno = array_shift(
                               obtenerDatosTabla(
                                  "T_ENC_DISENO",
                                    array("seqDiseno","txtdiseno"),
                                  "seqDiseno",
                                  "seqDiseno = " . $_POST['diseno']
                               )
                            );
                            $arrErrores[$numPosicion]['mensaje'] = "No se encontraron aplicaciones para " . $txtDiseno;
                        }
                    }
                }

                if( ! empty($arrAplicaciones) ){

                    $arrHojaFormulario = array();
                    $arrHojaCiudadano = array();

                    foreach($arrAplicaciones as $numDocumento => $arrAplicacion){
                        if( ! empty( $arrAplicacion ) ) {
                            $seqAplicacion = $arrAplicacion['seqAplicacion'];
                            $claEncuestas->obtenerEncuesta($seqAplicacion);

                            $arrHojaFormulario[0]['FORMULARIO'] = "FORMULARIO";
                            $arrHojaFormulario[$seqAplicacion]['FORMULARIO'] = $arrAplicacion['txtFormulario'];

                            $arrHojaCiudadano[0]['FORMULARIO'] = "FORMULARIO";

                            $arrLineas = array();
                            foreach ($claEncuestas->arrPlantilla as $txtSeccion => $arrSubsecciones) {
                                foreach ($arrSubsecciones as $txtSubseccion => $arrPreguntas) {
                                    foreach ($arrPreguntas as $idPregunta => $arrPregunta) {
                                        if (strtoupper($arrPregunta['destino']) == "T_ENC_APLICACION_FORMULARIO") {
                                            foreach ($arrPregunta['respuesta'] as $seqRespuesta => $arrRespuesta) {
                                                $txtIdentificador = $arrRespuesta['identificador'];
                                                $arrHojaFormulario[0][$txtIdentificador] = $txtIdentificador;
                                                if (isset($claEncuestas->arrAplicacion['formulario'][$seqRespuesta])) {
                                                    if ( trim($arrHojaFormulario[$seqAplicacion][$txtIdentificador]) == "") {
                                                        $arrHojaFormulario[$seqAplicacion][$txtIdentificador] = utf8_encode($claEncuestas->arrAplicacion['formulario'][$seqRespuesta]);
                                                    }
                                                }
                                                if( ! ( isset( $arrHojaFormulario[$seqAplicacion][$txtIdentificador] ) and $arrHojaFormulario[$seqAplicacion][$txtIdentificador] != "" ) ){
                                                    $arrHojaFormulario[$seqAplicacion][$txtIdentificador] = "";
                                                }
                                            }
                                        } else {
                                            foreach ($arrPregunta['respuesta'] as $seqRespuesta => $arrRespuesta) {
                                                $txtIdentificador = $arrRespuesta['identificador'];
                                                $arrHojaCiudadano[0][$txtIdentificador] = $txtIdentificador;
                                                foreach ($claEncuestas->arrAplicacion['ciudadano'] as $i => $arrCiudadano) {
                                                    if (!isset($arrLineas[$i])) {
                                                        $arrLineas[$i] = count($arrHojaCiudadano);
                                                    }
                                                    $numPosicion = $arrLineas[$i];
                                                    $arrHojaCiudadano[$numPosicion]['FORMULARIO'] = $arrAplicacion['txtFormulario'];
                                                    if (isset($arrCiudadano[$seqRespuesta])) {
                                                        if ( trim($arrHojaCiudadano[$numPosicion][$txtIdentificador]) == "") {
                                                            $arrHojaCiudadano[$numPosicion][$txtIdentificador] = utf8_encode($arrCiudadano[$seqRespuesta]);
                                                        }
                                                    }
                                                    if( ! ( isset( $arrHojaCiudadano[$numPosicion][$txtIdentificador] ) and $arrHojaCiudadano[$numPosicion][$txtIdentificador] != "" ) ){
                                                        $arrHojaCiudadano[$numPosicion][$txtIdentificador] = "";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

//            pr($arrHojaFormulario);
//            pr($arrHojaCiudadano);
//            pr($arrErrores);


            $xmlArchivo  = "<?xml version='1.0' encoding='UTF-8'?>";
            $xmlArchivo .= "<ss:Workbook xmlns:ss='urn:schemas-microsoft-com:office:spreadsheet'>";

            // hoja de errores
            $xmlArchivo .= "<ss:Worksheet ss:Name='Mensajes'>";
            $xmlArchivo .= "<ss:Table>";
            $xmlArchivo .= "<ss:Row>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>";
            $xmlArchivo .= "Documento";
            $xmlArchivo .= "</ss:Data></ss:Cell>";
            $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>";
            $xmlArchivo .= "Mensaje";
            $xmlArchivo .= "</ss:Data></ss:Cell>";
            $xmlArchivo .= "</ss:Row>";
            foreach( $arrErrores as $arrMensaje ){
                $xmlArchivo .= "<ss:Row>";
                $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='Number'>";
                $xmlArchivo .= $arrMensaje['documento'];
                $xmlArchivo .= "</ss:Data></ss:Cell>";
                $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='String'>";
                $xmlArchivo .= $arrMensaje['mensaje'];
                $xmlArchivo .= "</ss:Data></ss:Cell>";
                $xmlArchivo .= "</ss:Row>";
            }
            $xmlArchivo .= "</ss:Table>";
            $xmlArchivo .= "</ss:Worksheet>";

            // hoja de formulario
            $xmlArchivo .= "<ss:Worksheet ss:Name='Formulario'>";
            $xmlArchivo .= "<ss:Table>";
            foreach( $arrHojaFormulario as $seqAplicacion => $arrLinea){
                $xmlArchivo .= "<ss:Row>";
                foreach($arrLinea as $i => $txtValor) {
                    $txtTipo = ( is_numeric( $txtValor ) )? "Number" : "String";
                    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='$txtTipo'>";
                    $xmlArchivo .= $txtValor;
                    $xmlArchivo .= "</ss:Data></ss:Cell>";
                }
                $xmlArchivo .= "</ss:Row>";
            }
            $xmlArchivo .= "</ss:Table>";
            $xmlArchivo .= "</ss:Worksheet>";

            // hoja de ciudadano
            $xmlArchivo .= "<ss:Worksheet ss:Name='Ciudadano'>";
            $xmlArchivo .= "<ss:Table>";
            foreach( $arrHojaCiudadano as $i => $arrLinea){
                $xmlArchivo .= "<ss:Row>";
                foreach($arrLinea as $txtValor) {
                    //$txtTipo = ( is_numeric( trim($txtValor) ) )? "Number" : "String";

                    switch(true){
                        case (esFechaValida($txtValor)) and (strlen($txtValor) <= 10) and (strtotime( $txtValor ) !== false):
                            $txtTipo = "DateTime";
                            break;
                        case is_numeric($txtValor):
                            $txtTipo = "Number";
                            break;
                        default:
                            $txtTipo = "String";
                            break;
                    }


                    $xmlArchivo .= "<ss:Cell><ss:Data ss:Type='$txtTipo'>";
                    $xmlArchivo .= $txtValor;
                    $xmlArchivo .= "</ss:Data></ss:Cell>";
                }
                $xmlArchivo .= "</ss:Row>";
            }
            $xmlArchivo .= "</ss:Table>";
            $xmlArchivo .= "</ss:Worksheet>";

            $xmlArchivo .= "</ss:Workbook>";

            $txtNombre = "PlanoEncuestas" . date("YmdHis") . ".xls";
            header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
            header("Content-Disposition: inline; filename=\"" . $txtNombre . "\"");

            echo $xmlArchivo;


        }else{
            imprimirMensajes($arrErrores, array() );
        }

    }

?>