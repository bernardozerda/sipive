<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$arrErrores = array();

// valida si el archivo fue cargado y si corresponde a las extensiones válidas
switch ($_FILES['documentos']['error']) {
    case UPLOAD_ERR_INI_SIZE:
        $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" Excede el tamaño permitido";
        break;
    case UPLOAD_ERR_FORM_SIZE:
        $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" Excede el tamaño permitido";
        break;
    case UPLOAD_ERR_PARTIAL:
        $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
        break;
    case UPLOAD_ERR_NO_FILE:
        $arrErrores[] = "Debe especificar un archivo para cargar";
        break;
    case UPLOAD_ERR_NO_TMP_DIR:
        $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
        break;
    case UPLOAD_ERR_CANT_WRITE:
        $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
        break;
    case UPLOAD_ERR_EXTENSION:
        $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
        break;
    default:
        $numPunto = strpos($_FILES['documentos']['name'], ".") + 1;
        $numRestar = (strlen($_FILES['documentos']['name']) - $numPunto) * -1;
        $txtExtension = substr($_FILES['documentos']['name'], $numRestar);
        if (!in_array(strtolower($txtExtension), array("txt"))) {
            $arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
        }
        break;
}

if(empty($arrErrores)){
    $arrArchivo = validarArchivo();
}

if(empty($arrErrores)){
    $arrImpresion = sqlEscrituracion($arrArchivo);
}

if(!empty($arrErrores)){
    echo "<div class='alert alert-danger' role='alert' style='text-align: left;'>";
    foreach ($arrErrores as $txtTexto) {
        echo "<li class='$txtClaseLi'>" . $txtTexto . "</li>";
    }
    echo "</div>";
}else{
    echo "<div class='alert alert-success' role='alert' style='text-align: left;'>";
    echo "<table width='100%' border='0' cellpadding='3' cellspacing='0'>";
    echo "<tr><td colspan='2'><h3>Se procesaron " . count($arrImpresion) . " registros, a continuación los links de impresión:</h3></td></tr>";
    foreach($arrImpresion as $numDocumento => $txtLink){
        echo "<tr><td>$numDocumento</td>";
        echo "<td><a href='$txtLink'>$txtLink</a></td></tr>";
    }
    echo "</table>";
    echo "</div>";
}

function validarArchivo(){
    global $arrErrores;

    // titulos del archivo
    $arrPlantilla[0] = 'Documento';
    $arrPlantilla[1] = 'desembolso';
    $arrPlantilla[2] = 'formulario';
    $arrPlantilla[3] = 'vendedor';
    $arrPlantilla[4] = 'docVendedor';
    $arrPlantilla[5] = 'barrio';
    $arrPlantilla[6] = 'localidad';
    $arrPlantilla[7] = 'vJuridico';
    $arrPlantilla[8] = 'vTecnico';
    $arrPlantilla[9] = 'seqTipoDoc';
    $arrPlantilla[10] = 'compraVivienda';
    $arrPlantilla[11] = 'tipoPredio';
    $arrPlantilla[12] = 'telVendedor';
    $arrPlantilla[13] = 'tipoDoc';
    $arrPlantilla[14] = 'estrato';
    $arrPlantilla[15] = 'ciudad';
    $arrPlantilla[16] = 'fchCreaEsc';
    $arrPlantilla[17] = 'fchActEsc';
    $arrPlantilla[18] = 'telVen2';
    $arrPlantilla[19] = 'propiedad';
    $arrPlantilla[20] = 'correoVen';
    $arrPlantilla[21] = 'seqCiudad';
    $arrPlantilla[22] = 'ciudad2';
    $arrPlantilla[23] = 'seqSubsidio';
    $arrPlantilla[24] = 'seqProySol';
    $arrPlantilla[25] = 'Direccion del inmueble';
    $arrPlantilla[26] = 'Escritura';
    $arrPlantilla[27] = 'Fecha de la escritura';
    $arrPlantilla[28] = 'Notaria';
    $arrPlantilla[29] = 'Matricula Inmobiliaria';
    $arrPlantilla[30] = 'Chip';
    $arrPlantilla[31] = 'Cedula Catastral';
    $arrPlantilla[32] = 'Area(mts) Lote';
    $arrPlantilla[33] = 'Area(mts) Construida';
    $arrPlantilla[34] = 'Avaluo del inmueble';
    $arrPlantilla[35] = 'Valor inmueble';
    $arrPlantilla[36] = 'Tipo de predio';
    $arrPlantilla[37] = 'Estrato';
    $arrPlantilla[38] = 'Folio Escritura publica';
    $arrPlantilla[39] = 'Obs Escritura Publica';
    $arrPlantilla[40] = 'Folio de certificado de tradición';
    $arrPlantilla[41] = 'Obs Certificado de Tradicion';
    $arrPlantilla[42] = 'Folio carta asignación';
    $arrPlantilla[43] = 'Obs Carta de Asignacion';
    $arrPlantilla[44] = 'Folio Alto Riesgo';
    $arrPlantilla[45] = 'Obs Alto Riesgo';
    $arrPlantilla[46] = 'Folio Habitabilidad';
    $arrPlantilla[47] = 'Obs Habitabilidad';
    $arrPlantilla[48] = 'Folio Boletin Catastral.';
    $arrPlantilla[49] = 'Obs Boletin Catastral';
    $arrPlantilla[50] = 'Folio Licencia de Construcción';
    $arrPlantilla[51] = 'Obs Licencia de Construcción';
    $arrPlantilla[52] = 'Folio Ultimo predial';
    $arrPlantilla[53] = 'Obs Ultimo predial';
    $arrPlantilla[54] = 'Folio Ultimo Recibo de Agua';
    $arrPlantilla[55] = 'Obs Ultimo Recibo de Agua';
    $arrPlantilla[56] = 'Folio Ultimo Recibo de Energia';
    $arrPlantilla[57] = 'Obs Ultimo Recibo de Energia';
    $arrPlantilla[58] = 'Folio Acta Entrega';
    $arrPlantilla[59] = 'Obs Acta Entrega';
    $arrPlantilla[60] = 'Folio Certificado Vendedor';
    $arrPlantilla[61] = 'Obs Certificado Vendedor';
    $arrPlantilla[62] = 'Folio Autorizacion Desembolso';
    $arrPlantilla[63] = 'Obs Autorizacion Desembolso';
    $arrPlantilla[64] = 'Folio Fotocopia Vendedor';
    $arrPlantilla[65] = 'Obs Fotocopia Vendedor';
    $arrPlantilla[66] = 'Folio Rit';
    $arrPlantilla[67] = 'Obs Rit';
    $arrPlantilla[68] = 'Folio Rut';
    $arrPlantilla[69] = 'Obs Rut';
    $arrPlantilla[70] = 'Folio Nit';
    $arrPlantilla[71] = 'Obs Nit';
    $arrPlantilla[72] = 'Folio Otros';
    $arrPlantilla[73] = 'Obs Otros';
    $arrPlantilla[74] = 'Número Contrato Leasing';
    $arrPlantilla[75] = 'Fecha Contrato Leasing';
    $arrPlantilla[76] = 'Folios Contrato Leasing';
    $arrPlantilla[77] = 'Obs Contrato Leasing';


    $txtArchivo = utf8_encode(file_get_contents($_FILES['documentos']['tmp_name']));
    $arrArchivo = mb_split("\r\n",$txtArchivo);
    foreach($arrArchivo as $numLinea => $txtLinea){
        if(trim($txtLinea) != "") {
            $arrArchivo[$numLinea] = mb_split("\t", $txtLinea);

            if ($numLinea == 0) {
                foreach ($arrArchivo[$numLinea] as $numColumna => $txtTitulo) {
                    if (mb_strtolower(trim($txtTitulo)) != mb_strtolower(trim($arrPlantilla[$numColumna]))) {
                        $arrErrores[] = "La Columna '" . $arrPlantilla[$numColumna] . "' no está o no se encuentra en el lugar correcto";
                    }
                }
            }else{

                // el desembolso del archivo
                $seqDesembolsoArchivo = $arrArchivo[$numLinea][1];

                // el formulario del archivo
                $seqFormulario = $arrArchivo[$numLinea][2];

                // estado actual del proceso
                $seqEstadoProceso = array_shift(
                    obtenerDatosTabla(
                        "t_frm_formulario",
                        array("seqFormulario","seqEstadoProceso"),
                        "seqFormulario",
                        "seqFormulario = " . $seqFormulario
                    )
                );
                if($seqEstadoProceso != 27){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado para el documento " . $arrArchivo[$numLinea][0] . " no es correcto";
                }

                // desembolso correspondiente
                $seqDesembolso = array_shift(
                    obtenerDatosTabla(
                        "t_des_desembolso",
                        array("seqFormulario","seqDesembolso"),
                        "seqFormulario",
                        "seqFormulario = " . $seqFormulario

                    )
                );
                if($seqDesembolso != $seqDesembolsoArchivo){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El desembolso no corresponde para el documento " . $arrArchivo[$numLinea][0];
                }

                // formato de fecha fchCreaEsc
                if(trim($arrArchivo[$numLinea][16]) != "" and !esFechaValida(trim($arrArchivo[$numLinea][16]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de 'fchCreaEsc' no es correcto";
                }

                // formato de fecha fchActEsc
                if(trim($arrArchivo[$numLinea][17]) != "" and !esFechaValida(trim($arrArchivo[$numLinea][17]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de la columna 'fchActEsc' no es correcto";
                }

                // formato de fecha de escritura
                if(!esFechaValida(trim($arrArchivo[$numLinea][27]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de la columna 'Fecha de la escritura' no es correcto";
                }

                // formato de fecha del contrato de leasing
                if(!esFechaValida(trim($arrArchivo[$numLinea][75]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de la columna 'Fecha Contrato Leasing' no es correcto";
                }

                // validaciones de campos vacios
                for($numColumna = 15; $numColumna < count($arrArchivo[$numLinea]); $numColumna){
                    if(trim($arrArchivo[$numLinea][$numColumna]) == ""){
                        $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La columna '" . $arrPlantilla[$numColumna] . "' no puede estar vacia";
                    }
                }

                // validaciones de fechas
                if(! esFechaValida($arrArchivo[$numLinea][10])){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La columna '" . $arrPlantilla[10] . "' no tiene el formato correcto";
                }

                if(! esFechaValida($arrArchivo[$numLinea][14])){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La columna '" . $arrPlantilla[10] . "' no tiene el formato correcto";
                }

            }
        }else{
            unset($arrArchivo[$numLinea]);
        }
    }

    return $arrArchivo;
}

function sqlEscrituracion($arrArchivo){
    global $arrErrores, $aptBd;

    $arrMapeo['desembolso'] = 'seqDesembolso';
    $arrMapeo['formulario'] = 'seqFormulario';
    $arrMapeo['vendedor'] = 'txtNombreVendedor';
    $arrMapeo['docVendedor'] = 'numDocumentoVendedor';
    $arrMapeo['barrio'] = 'txtBarrio';
    $arrMapeo['localidad'] = 'seqLocalidad';
    $arrMapeo['vJuridico'] = 'bolViabilizoJuridico';
    $arrMapeo['vTecnico'] = 'bolviabilizoTecnico';
    $arrMapeo['seqTipoDoc'] = 'seqTipoDocumento';
    $arrMapeo['compraVivienda'] = 'txtCompraVivienda';
    $arrMapeo['telVendedor'] = 'numTelefonoVendedor';
    $arrMapeo['fchCreaEsc'] = 'fchCreacionEscrituracion';
    $arrMapeo['fchActEsc'] = 'fchActualizacionEscrituracion';
    $arrMapeo['telVen2'] = 'numTelefonoVendedor2';
    $arrMapeo['ciudad'] = 'txtCiudad';
    $arrMapeo['propiedad'] = 'txtPropiedad';
    $arrMapeo['correoVen'] = 'txtCorreoVendedor';
    $arrMapeo['seqCiudad'] = 'seqCiudad';
    $arrMapeo['seqSubsidio'] = 'seqAplicacionSubsidio';
    $arrMapeo['seqProySol'] = 'seqProyectosSoluciones';
    $arrMapeo['Direccion del inmueble'] = 'txtDireccionInmueble';
    $arrMapeo['Escritura'] = 'txtEscritura';
    $arrMapeo['Fecha de la escritura'] = 'fchEscritura';
    $arrMapeo['Notaria'] = 'numNotaria';
    $arrMapeo['Matricula Inmobiliaria'] = 'txtMatriculaInmobiliaria';
    $arrMapeo['Chip'] = 'txtChip';
    $arrMapeo['Cedula Catastral'] = 'txtCedulaCatastral';
    $arrMapeo['Area(mts) Lote'] = 'numAreaLote';
    $arrMapeo['Area(mts) Construida'] = 'numAreaConstruida';
    $arrMapeo['Avaluo del inmueble'] = 'numAvaluo';
    $arrMapeo['Valor inmueble'] = 'numValorInmueble';
    $arrMapeo['Tipo de predio'] = 'txtTipoPredio';
    $arrMapeo['Estrato'] = 'numEstrato';
    $arrMapeo['Folio Escritura publica'] = 'numEscrituraPublica';
    $arrMapeo['Obs Escritura Publica'] = 'txtEscrituraPublica';
    $arrMapeo['Folio de certificado de tradición'] = 'numCertificadoTradicion';
    $arrMapeo['Obs Certificado de Tradicion'] = 'txtCertificadoTradicion';
    $arrMapeo['Folio carta asignación'] = 'numCartaAsignacion';
    $arrMapeo['Obs Carta de Asignacion'] = 'txtCartaAsignacion';
    $arrMapeo['Folio Alto Riesgo'] = 'numAltoRiesgo';
    $arrMapeo['Obs Alto Riesgo'] = 'txtAltoRiesgo';
    $arrMapeo['Folio Habitabilidad'] = 'numHabitabilidad';
    $arrMapeo['Obs Habitabilidad'] = 'txtHabitabilidad';
    $arrMapeo['Folio Boletin Catastral.'] = 'numBoletinCatastral';
    $arrMapeo['Obs Boletin Catastral'] = 'txtBoletinCatastral';
    $arrMapeo['Folio Licencia de Construcción'] = 'numLicenciaConstruccion';
    $arrMapeo['Obs Licencia de Construcción'] = 'txtLicenciaConstruccion';
    $arrMapeo['Folio Ultimo predial'] = 'numUltimoPredial';
    $arrMapeo['Obs Ultimo predial'] = 'txtUltimoPredial';
    $arrMapeo['Folio Ultimo Recibo de Agua'] = 'numUltimoReciboAgua';
    $arrMapeo['Obs Ultimo Recibo de Agua'] = 'txtUltimoReciboAgua';
    $arrMapeo['Folio Ultimo Recibo de Energia'] = 'numUltimoReciboEnergia';
    $arrMapeo['Obs Ultimo Recibo de Energia'] = 'txtUltimoReciboEnergia';
    $arrMapeo['Folio Acta Entrega'] = 'numActaEntrega';
    $arrMapeo['Obs Acta Entrega'] = 'txtActaEntrega';
    $arrMapeo['Folio Certificado Vendedor'] = 'numCertificacionVendedor';
    $arrMapeo['Obs Certificado Vendedor'] = 'txtCertificacionVendedor';
    $arrMapeo['Folio Autorizacion Desembolso'] = 'numAutorizacionDesembolso';
    $arrMapeo['Obs Autorizacion Desembolso'] = 'txtAutorizacionDesembolso';
    $arrMapeo['Folio Fotocopia Vendedor'] = 'numFotocopiaVendedor';
    $arrMapeo['Obs Fotocopia Vendedor'] = 'txtFotocopiaVendedor';
    $arrMapeo['Folio Rit'] = 'numRit';
    $arrMapeo['Obs Rit'] = 'txtRit';
    $arrMapeo['Folio Rut'] = 'numRut';
    $arrMapeo['Obs Rut'] = 'txtRut';
    $arrMapeo['Folio Nit'] = 'numNit';
    $arrMapeo['Obs Nit'] = 'txtNit';
    $arrMapeo['Folio Otros'] = 'numOtros';
    $arrMapeo['Obs Otros'] = 'txtOtro';
    $arrMapeo['Número Contrato Leasing'] = 'numContratoLeasing';
    $arrMapeo['Fecha Contrato Leasing'] = 'fchContratoLeasing';
    $arrMapeo['Folios Contrato Leasing'] = 'numFoliosContratoLeasing';
    $arrMapeo['Obs Contrato Leasing'] = 'txtFoliosContratoLeasing';

    $arrTitulos = $arrArchivo[0];
    unset($arrArchivo[0]);

    foreach($arrArchivo as $numLinea => $arrLinea){

        $txtCampos  = "";
        $txtValores = "";
        foreach($arrTitulos as $numColumna => $txtTitulo){
            $txtTitulo = trim($txtTitulo);
            if($arrMapeo[$txtTitulo] != "") {
                if($arrMapeo[$txtTitulo] == "numEstrato"){
                    $arrLinea[$numColumna] = mb_ereg_replace("[A-Za-z]","",$arrLinea[$numColumna]);
                }
                $txtValores .= "'" . trim($arrLinea[$numColumna]) . "',";
                $txtCampos .= $arrMapeo[$txtTitulo] . ",";
            }
        }

        $sql = "INSERT INTO t_des_escrituracion(";
        $sql .= rtrim($txtCampos, ",");
        $sql .= ")VALUES(";
        $sql .= rtrim($txtValores, ",");
        $sql .= ")";

        $seqFormulario = $arrLinea[2];
        $arrSql[$seqFormulario]['sql'] = $sql;
        $arrSql[$seqFormulario]['doc'] = $arrLinea[0];

        $sql = "update t_frm_formulario set seqEstadoProceso = 23, fchUltimaActualizacion = now() where seqFormulario = $seqFormulario";
        $arrEstados[] = $sql;

        $txtNombre = array_shift(obtenerDatosTabla(
            "t_ciu_ciudadano",
            array("numDocumento" , "CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) as txtNombre"),
            "numDocumento",
            "numDocumento = " . $arrLinea[0] . " and seqTipoDocumento in (1,2)"
        ));

        $sql = "
            INSERT INTO T_SEG_SEGUIMIENTO (
                seqFormulario,
                fchMovimiento,
                seqUsuario,
                txtComentario,
                txtCambios,
                numDocumento,
                txtNombre,
                seqGestion
            ) VALUES (
                " . $arrLinea[2] . ",
                '" . date("Y-m-d H:i:s") . "',
                " . $_SESSION['seqUsuario'] . ",
                'CARGUE MASIVO DE DATOS DE ESCRITURACION PARA LEASING HABITACIONAL',
                '',
                " . $arrLinea[0] . ",
                '" . $txtNombre . "',
                " . 63 . "
            )
        ";
        $arrSqlSeguimiento[] = $sql;

        $sql = "delete from t_des_flujo where seqFormulario = " . $arrLinea[2];
        $arrEliminarFlujo[] = $sql;

        $sql = "insert into t_des_flujo(seqFormulario, txtFlujo) values(".$arrLinea[2].",'postulacionIndividual')";
        $arrFlujo[] = $sql;

    }

    $arrImpresion = array();
    if(empty($arrErrores)){
        try {
            $aptBd->BeginTrans();
            foreach($arrSql as $seqFormulrio => $sql) {
                $aptBd->execute($sql['sql']);
                $txtImpresion = $_SERVER['HTTP_ORIGIN'] . "/sipive/contenidos/desembolso/formatoBusquedaOferta.php?seqFormulario=" . $seqFormulrio . "&seqCasaMano=0&bolEscrituracion=1'";
                $numDocumento = $sql['doc'];
                $arrImpresion[$numDocumento] = $txtImpresion;
            }
            foreach($arrEstados as $sql){
                $aptBd->execute($sql);
            }
            foreach($arrSqlSeguimiento as $sql){
                $aptBd->execute($sql);
            }
            foreach($arrEliminarFlujo as $sql){
                $aptBd->execute($sql);
            }
            foreach($arrFlujo as $sql){
                $aptBd->execute($sql);
            }
            $aptBd->CommitTrans();
        }catch(Exception $objError){
           $aptBd->RollbackTrans();
           $arrErrores[] = $objError->getMessage();
        }
    }

    return $arrImpresion;

}


?>