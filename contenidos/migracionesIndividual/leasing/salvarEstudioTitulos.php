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
    $arrImpresion = sqlEstudioTitulos($arrArchivo);
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
    $arrPlantilla[0]  = 'ID HOGAR';
    $arrPlantilla[1]  = 'CC POSTULANTE PRINCIPAL';
    $arrPlantilla[2]  = 'TIPO DE DOCUMENTO';
    $arrPlantilla[3]  = 'NOMBRE POSTULANTE PRINCIPAL';
    $arrPlantilla[4]  = 'PROYECTO';
    $arrPlantilla[5]  = 'CONJUNTO';
    $arrPlantilla[6]  = 'DESCRIPCION DE LA UNIDAD';
    $arrPlantilla[7]  = 'PROPIETARIO';
    $arrPlantilla[8]  = 'DIRECCION INMUEBLE';
    $arrPlantilla[9]  = 'NUMERO CONTRATO LEASING';
    $arrPlantilla[10] = 'FECHA CONTRATO LEASING';
    $arrPlantilla[11] = 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD';
    $arrPlantilla[12] = 'VALOR INMUEBLE';
    $arrPlantilla[13] = 'NUMERO DEL ACTO';
    $arrPlantilla[14] = 'FECHA DEL ACTO';
    $arrPlantilla[15] = 'No. ESCRITURA';
    $arrPlantilla[16] = 'FECHA ESCRITURA';
    $arrPlantilla[17] = 'NOTARIA';
    $arrPlantilla[18] = 'CIUDAD NOTARIA';
    $arrPlantilla[19] = 'FOLIO DE MATRICULA';
    $arrPlantilla[20] = 'ZONA OFICINA REGISTRO';
    $arrPlantilla[21] = 'CIUDAD OFICINA REGISTRO';
    $arrPlantilla[22] = 'FECHA FOLIO';
    $arrPlantilla[23] = 'RESOLUCION DE VINCULACION COINCIDENTE';
    $arrPlantilla[24] = 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA';
    $arrPlantilla[25] = 'ANOTACION CTL COMPRAVENTA';
    $arrPlantilla[26] = 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)';
    $arrPlantilla[27] = 'NUMERO Y FECHA DE CONTRATO LEASING';
    $arrPlantilla[28] = 'DETERMINACIÓN DEL APORTE DEL DISTRITO CAPITAL EN LA ESCRITURA';
    $arrPlantilla[29] = 'CLAUSULAS DONDE SE ESPECIFIQUEN RESTRICCIONES Y PROHIBICIONES EN EL CONTRATO';
    $arrPlantilla[30] = 'RELACIÓN DE LOS INTEGRANTES DEL HOGAR EN LA ESCRITURA';
    $arrPlantilla[31] = 'IMPUESTOS CON CARGO AL APORTE DEL DISTRITO CAPITAL';
    $arrPlantilla[32] = 'BENEFICIO DEL APORTE SEA EL LOCATARIO DEL CONTRATO DE LEASING';
    $arrPlantilla[33] = 'PROPIEDAD DE LA ENTIDAD FINANCIERA OTORGANTE DEL LEASING EN CTL';
    $arrPlantilla[34] = 'SE VIABILIZA JURIDICAMENTE';
    $arrPlantilla[35] = 'ELABORO';
    $arrPlantilla[36] = 'APROBO';
    $arrPlantilla[37] = 'OBSERVACION';

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

                // el formulario del archivo
                $seqFormulario = $arrArchivo[$numLinea][0];

                // estado actual del proceso
                $seqEstadoProceso = array_shift(
                    obtenerDatosTabla(
                        "t_frm_formulario",
                        array("seqFormulario","seqEstadoProceso"),
                        "seqFormulario",
                        "seqFormulario = " . $seqFormulario
                    )
                );
                if($seqEstadoProceso != 24){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El estado para el documento " . $arrArchivo[$numLinea][0] . " no es correcto";
                }

                // campos no vacios
                for($numColumna = 15 ; $numColumna < 37; $numColumna++){
                    if(trim($arrArchivo[$numLinea][$numColumna]) == ""){
                        $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La columna '" . $arrPlantilla[$numColumna] . "' no puede estar vacia";
                    }
                }

                // fecha contrato leasing
                if(!esFechaValida(trim($arrArchivo[$numLinea][10]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de '" . $arrPlantilla[10] . "' no es correcto";
                }

                // fecha del acto administrativo
                if(!esFechaValida(trim($arrArchivo[$numLinea][14]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de la columna '" . $arrPlantilla[14] . "' no es correcto";
                }

                // fecha de la escritura
                if(!esFechaValida(trim($arrArchivo[$numLinea][16]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de la columna '" . $arrPlantilla[16] . "' no es correcto";
                }

                // fecha folio
                if(!esFechaValida(trim($arrArchivo[$numLinea][22]))){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": El formato de feha de la columna '" . $arrPlantilla[22] . "' no es correcto";
                }

                // valida todas las solumnas si / no / no aplica
                for($numColumna = 23 ; $numColumna < 35; $numColumna++){
                    if(! in_array(mb_strtolower($arrArchivo[$numLinea][$numColumna]),["si","no","no aplica"])){
                        $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": La columna '" . $arrPlantilla[$numColumna] . "' no tiene un valor valido";
                    }
                }

                // valida que haya desembolso para ese hogar
                $seqDesembolso = array_shift(
                    obtenerDatosTabla(
                        "t_des_desembolso",
                        array("seqFormulario","seqDesembolso"),
                        "seqFormulario",
                        "seqFormulario = " . $arrArchivo[$numLinea][0],
                        "seqDesembolso DESC"
                    )
                );
                if(intval($seqDesembolso) == 0){
                    $arrErrores[] = "Error Linea " . ($numLinea + 1) . ": No hay registro de desembolso para el documento '" . $arrArchivo[$numLinea][1];
                }

            }
        }else{
            unset($arrArchivo[$numLinea]);
        }
    }

    return $arrArchivo;
}

function sqlEstudioTitulos($arrArchivo){
    global $arrErrores, $aptBd;

    unset($arrArchivo[0]);

    // observaciones para los titulos
    $arrObservaciones[] = "DETERMINACIÓN DEL APORTE DEL DISTRITO CAPITAL EN LA ESCRITURA";
    $arrObservaciones[] = "CLAUSULAS DONDE SE ESPECIFIQUEN RESTRICCIONES Y PROHIBICIONES EN LA ESCRITURA";
    $arrObservaciones[] = "RELACIÓN DE LOS INTEGRANTES DEL HOGAR EN LA ESCRITURA";
    $arrObservaciones[] = "IMPUESTOS CON CARGO AL APORTE DEL DISTRITO CAPITAL";
    $arrObservaciones[] = "NUMERO Y FECHA DEL CONTRATO DE LEASING HABITACIONAL";
    $arrObservaciones[] = "BENEFICIO DEL APORTE SEA EL LOCATARIO DEL CONTRATO DE LEASING";
    $arrObservaciones[] = "PROTOCOLIZACIÓN  DE LA RESOLUCIÓN O CARTA DE ASIGNACIÓN";
    $arrObservaciones[] = "PROPIEDAD DE LA ENTIDAD FINANCIERA OTORGANTE DEL LEASING EN CTL";

    // documentos analizados
    $arrDocumentos[] = "ESCRITURA PÚBLICA";
    $arrDocumentos[] = "FOLIO DE MATRICULA INMOBILIARIA";
    $arrDocumentos[] = "CONTRATO DE LEASING HABITACIONAL";

    $arrImpresion = array();

    try{

        $aptBd->BeginTrans();

        foreach($arrArchivo as $numLinea => $arrDatos) {

            $seqDesembolso = array_shift(
                obtenerDatosTabla(
                    "t_des_desembolso",
                    array("seqFormulario", "seqDesembolso"),
                    "seqFormulario",
                    "seqFormulario = " . $arrDatos[0],
                    "seqDesembolso DESC"
                )
            );

            $sql = "
                INSERT INTO t_des_estudio_titulos(
                    seqDesembolso,
                    numEscrituraIdentificacion,
                    fchEscrituraIdentificacion,
                    numNotariaIdentificacion,
                    txtCiudadIdentificacion,
                    numEscrituraTitulo,
                    fchEscrituraTitulo,
                    numNotariaTitulo,
                    txtCiudadTitulo,
                    numFolioMatricula,
                    txtZonaMatricula,
                    txtCiudadMatricula,
                    fchMatricula,
                    bolSubsidioSDHT,
                    bolSubsidioFonvivienda,
                    numResolucionFonvivienda,
                    numAnoResolucionFonvivienda,
                    fchCreacion,
                    fchActualizacion,
                    txtElaboro,
                    txtAprobo
                ) VALUES (
                    " . $seqDesembolso . ",
                    " . $arrDatos[15] . ",
                    '" . $arrDatos[16] . "',
                    " . $arrDatos[17] . ",
                    '" . $arrDatos[18] . "',
                    " . $arrDatos[15] . ",
                    '" . $arrDatos[16] . "',
                    " . $arrDatos[17] . ",
                    '" . $arrDatos[18] . "',
                    '" . $arrDatos[19] . "',
                    '" . $arrDatos[20] . "',
                    '" . $arrDatos[21] . "',
                    '" . $arrDatos[22] . "',
                    0,
                    0,
                    null,
                    null,
                    now(),
                    null,
                    '" . $arrDatos[35] . "',
                    '" . $arrDatos[36] . "'
                )
            ";
            $aptBd->execute($sql);
            $seqEstudioTitulos = $aptBd->Insert_ID();

            // inserta las observaciones genericas
            foreach ($arrObservaciones as $txtObservacion){
                $sql = "
                    INSERT INTO t_des_adjuntos_titulos(
                        seqTipoAdjunto,
                        seqEstudioTitulos,
                        txtAdjunto
                    ) VALUES (
                        4,
                        $seqEstudioTitulos,
                        '$txtObservacion'
                    )
                ";
                $aptBd->execute($sql);
            }

            // inserta los documentos genericos
            foreach ($arrDocumentos as $txtDocumento){
                $sql = "
                    INSERT INTO t_des_adjuntos_titulos(
                        seqTipoAdjunto,
                        seqEstudioTitulos,
                        txtAdjunto
                    ) VALUES (
                        1,
                        $seqEstudioTitulos,
                        '$txtDocumento'
                    )
                ";
                $aptBd->execute($sql);
            }

            // cambio de estado 31 == si || 28 == no
            // columna "se viabiliza juridicamente"
            $seqEstadoProceso = (mb_strtolower($arrDatos[34]) == "no")? 28 : 31;
            $sql = "update t_frm_formulario set seqEstadoProceso = " . $seqEstadoProceso . ", fchUltimaActualizacion = now() where seqFormulario = " . $arrDatos[0];
            $aptBd->execute($sql);

            $txtNombre = array_shift(obtenerDatosTabla(
                "t_ciu_ciudadano",
                array("numDocumento" , "CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) as txtNombre"),
                "numDocumento",
                "numDocumento = " . $arrDatos[1] . " and seqTipoDocumento in (1,2)"
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
                    " . $arrDatos[0] . ",
                    '" . date("Y-m-d H:i:s") . "',
                    " . $_SESSION['seqUsuario'] . ",
                    'CARGUE MASIVO DE ESTUDIO DE TITULOS PARA LEASING HABITACIONAL',
                    '',
                    " . $arrDatos[1] . ",
                    '" . $txtNombre . "',
                    " . 63 . "
                )
            ";
            $aptBd->execute($sql);

            $numDocumento = $arrDatos[1];
            $arrImpresion[$numDocumento] = $_SERVER['HTTP_ORIGIN'] . "/sipive/contenidos/desembolso/formatoEstudioTitulos.php?seqFormulario=" . $arrDatos[0];

        }

        $aptBd->CommitTrans();

    } catch (Exception $objError){
        $arrErrores[] = $objError->getMessage();
        $aptBd->RollbackTrans();
    }

    return $arrImpresion;

}

?>