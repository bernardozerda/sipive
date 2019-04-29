<?php

// Archivos necesarios
include("./recursos/archivos/lecturaConfiguracion.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Encuestas.class.php" );
include($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

// mira las variables de calificacion de una encuesta
$documento = 44156343;

$encuesta = new Encuestas();
$variables = $encuesta->obtenerVariablesCalificacion($documento);

pr($variables);

// segun los documentos entregados obtiene archivo comparando encuesta y base de datos
//$arrDocumentos = file("./doc.txt");
//foreach($arrDocumentos as $numLinea => $numDocumento){
//    //if( $numLinea < 10 ) {
//        $arrDocumentos[$numLinea] = trim($numDocumento);
//    //}else{
//    //    unset($arrDocumentos[$numLinea]);
//    //}
//}
//
//$numPosicion = count($arrArchivo);
//$arrArchivo = array();
//$arrArchivo[$numPosicion]['seqFormulario'] = "seqFormulario";
//$arrArchivo[$numPosicion]['numDocumento'] = "documento ppal";
//$arrArchivo[$numPosicion]['numMiembrosEncuesta'] = "miembros encuesta";
//$arrArchivo[$numPosicion]['numMiembrosFormulario'] = "miembros formulario";
//$arrArchivo[$numPosicion]['numDocumentosEncuesta'] = "documentos encuesta";
//$arrArchivo[$numPosicion]['numDocumentosFormulario'] = "documentos formulario";
//$arrArchivo[$numPosicion]['numEtniasEncuesta'] = "etnias encuesta";
//$arrArchivo[$numPosicion]['numEtniasFormulario'] = "etnias formulario";
//$arrArchivo[$numPosicion]['numCondicionesEncuesta'] = "condiciones encuesta";
//$arrArchivo[$numPosicion]['numCondicionesFormulario'] = "condiciones formulario";
//$arrArchivo[$numPosicion]['numSaludEncuesta'] = "salud encuesta";
//$arrArchivo[$numPosicion]['numSaludFormulario'] = "salud formulario";
//$arrArchivo[$numPosicion]['numCohabitacionEncuesta'] = "cohabitacion encuesta";
//$arrArchivo[$numPosicion]['numCohabitacionFormulario'] = "cohabitacion formulario";
//$arrArchivo[$numPosicion]['numDormitoriosEncuesta'] = "dormitorio encuesta";
//$arrArchivo[$numPosicion]['numDormitoriosFormulario'] = "dormitorio formulario";
//$arrArchivo[$numPosicion]['numIngresosEncuesta'] = "ingresos encuesta";
//$arrArchivo[$numPosicion]['numIngresosFormulario'] = "ingresos formulario";
//$arrArchivo[$numPosicion]['numIntegracionEncuesta'] = "Int.Social encuesta";
//$arrArchivo[$numPosicion]['numIntegracionFormulario'] = "Int.Social formulario";
//$arrArchivo[$numPosicion]['numEducacionEncuesta'] = "Sec.Educacion encuesta";
//$arrArchivo[$numPosicion]['numEducacionFormulario'] = "Sec.Educacion formulario";
//$arrArchivo[$numPosicion]['numMujerEncuesta'] = "Sec.Mujer encuesta";
//$arrArchivo[$numPosicion]['numMujerFormulario'] = "Sec.Mujer formulario";
//$arrArchivo[$numPosicion]['numSaludEncuesta'] = "Sec.Salud encuesta";
//$arrArchivo[$numPosicion]['numSaludFormulario'] = "Sec.Salud formulario";
//$arrArchivo[$numPosicion]['numAltaEncuesta'] = "AltaCon encuesta";
//$arrArchivo[$numPosicion]['numAltaFormulario'] = "AltaCon formulario";
//$arrArchivo[$numPosicion]['numIpesEncuesta'] = "Ipes encuesta";
//$arrArchivo[$numPosicion]['numIpesFormulario'] = "Ipes formulario";
//
//foreach($arrDocumentos as $numDocumento){
//
//    $claEncuesta = new Encuestas();
//    $claFormulario = new FormularioSubsidios();
//
//    $seqFormulario = Ciudadano::formularioVinculado($numDocumento);
//    if($seqFormulario != 0) {
//        $claFormulario->cargarFormulario($seqFormulario);
//        $arrVariables = $claEncuesta->obtenerVariablesCalificacion($numDocumento);
//
//        $numPosicion = count($arrArchivo);
//
//        if(empty($arrVariables['errores'])){
//
//            // suma los documentos dela base de datos
//            // y cuenta otras variables para cruces
//            $numMiembrosFormulario = count($claFormulario->arrCiudadano);
//            $numDocumentosFormulario = 0;
//            $numEtnias = 0;
//            $numCondiciones = 0;
//            $numSalud = 0;
//            $objPrincipal = null;
//            foreach( $claFormulario->arrCiudadano as $objCiudadano ){
//                $objPrincipal = ($objCiudadano->seqParentesco == 1)? $objCiudadano : $objPrincipal;
//                $numDocumentosFormulario += $objCiudadano->numDocumento;
//                if( intval($objCiudadano->seqEtnia) > 1 ){
//                    $numEtnias++;
//                }
//                if( intval($objCiudadano->seqCondicionEspecial)  == 3 or
//                    intval($objCiudadano->seqCondicionEspecial2) == 3 or
//                    intval($objCiudadano->seqCondicionEspecial3) == 3
//                ){
//                    $numCondiciones++;
//                }
//                if( intval($objCiudadano->seqSalud) == 1 or
//                    intval($objCiudadano->seqSalud) == 2
//                ){
//                    $numSalud++;
//                }
//            }
//
//            // suma los documentos de las encuestas
//            $numDocumentosEncuesta = 0;
//            foreach( $arrVariables['variables']['edades'] as $cedula => $edad ){
//                $numDocumentosEncuesta += $cedula;
//            }
//
//
//
//            // inhabilidad para cantidad de miembros de hogar
//            $arrArchivo[$numPosicion]['seqFormulario'] = $seqFormulario;
//            $arrArchivo[$numPosicion]['numDocumento'] = $objPrincipal->numDocumento;
//            $arrArchivo[$numPosicion]['numMiembrosEncuesta'] = $arrVariables['variables']['cant'];
//            $arrArchivo[$numPosicion]['numMiembrosFormulario'] = $numMiembrosFormulario;
//
//            $arrArchivo[$numPosicion]['numDocumentosEncuesta'] = $numDocumentosEncuesta;
//            $arrArchivo[$numPosicion]['numDocumentosFormulario'] = $numDocumentosFormulario;
//
//            $arrArchivo[$numPosicion]['numEtniasEncuesta'] = $arrVariables['variables']['condicionEtnica'];
//            $arrArchivo[$numPosicion]['numEtniasFormulario'] = $numEtnias;
//
//            $arrArchivo[$numPosicion]['numCondicionesEncuesta'] = $arrVariables['variables']['cantCondEspecial'];
//            $arrArchivo[$numPosicion]['numCondicionesFormulario'] = $numCondiciones;
//
//            $arrArchivo[$numPosicion]['numSaludEncuesta'] = $arrVariables['variables']['afiliacion'];
//            $arrArchivo[$numPosicion]['numSaludFormulario'] = $numSalud;
//
//            $arrArchivo[$numPosicion]['numCohabitacionEncuesta'] = $arrVariables['variables']['cohabitacion'];
//            $arrArchivo[$numPosicion]['numCohabitacionFormulario'] = $claFormulario->numHabitaciones;
//
//            $arrArchivo[$numPosicion]['numDormitoriosEncuesta'] = $arrVariables['variables']['dormitorios'];
//            $arrArchivo[$numPosicion]['numDormitoriosFormulario'] = $claFormulario->numHacinamiento;
//
//            $arrArchivo[$numPosicion]['numIngresosEncuesta'] = $arrVariables['variables']['ingresos'];
//            $arrArchivo[$numPosicion]['numIngresosFormulario'] = $claFormulario->valIngresoHogar;
//
//            $arrArchivo[$numPosicion]['numIntegracionEncuesta'] = $arrVariables['variables']['bolIntegracionSocial'];
//            $arrArchivo[$numPosicion]['numIntegracionFormulario'] = $claFormulario->bolIntegracionSocial;
//
//            $arrArchivo[$numPosicion]['numEducacionEncuesta'] = $arrVariables['variables']['bolSecEducacion'];
//            $arrArchivo[$numPosicion]['numEducacionFormulario'] = $claFormulario->bolSecEducacion;
//
//            $arrArchivo[$numPosicion]['numMujerEncuesta'] = $arrVariables['variables']['bolSecMujer'];
//            $arrArchivo[$numPosicion]['numMujerFormulario'] = $claFormulario->bolSecMujer;
//
//            $arrArchivo[$numPosicion]['numSaludEncuesta'] = $arrVariables['variables']['bolSecSalud'];
//            $arrArchivo[$numPosicion]['numSaludFormulario'] = $claFormulario->bolSecSalud;
//
//            $arrArchivo[$numPosicion]['numAltaEncuesta'] = $arrVariables['variables']['bolAltaCon'];
//            $arrArchivo[$numPosicion]['numAltaFormulario'] = $claFormulario->bolAltaCon;
//
//            $arrArchivo[$numPosicion]['numIpesEncuesta'] = $arrVariables['variables']['bolIpes'];
//            $arrArchivo[$numPosicion]['numIpesFormulario'] = $claFormulario->bolIpes;
//
//        }else{
//            $arrArchivo[$numPosicion]['seqFormulario'] = "";
//            $arrArchivo[$numPosicion]['numDocumento'] =  $numDocumento;
//            $arrArchivo[$numPosicion]['numMiembrosEncuesta'] = $arrVariables['errores'][0];
//        }
//
//    }else{
//        $arrArchivo[] = $numDocumento . "\tNo se encuentra\r\n";
//    }
//
//}
//
//$archivo = fopen("./comparativo.txt","a");
//foreach( $arrArchivo as $linea => $array ){
//    fwrite($archivo,implode("\t",$array)."\r\n");
//}
//fclose($archivo);
//echo time() . " ==> listo";



?>