<?php

class LegalizacionMCY {

    public $arrErrores;
    public $arrMensajes;
    public $arrTitulos;
    public $arrFormatoArchivo;
    public $arrDocumentos;
    public $arrFormularios;
    public $arrDesembolso;
    public $arrEsquema;
    public $arrModalidad;

    public function __construct() {

        $this->arrErrores = array();
        $this->arrMensajes = array();
        $this->arrDocumentos = array();
        $this->arrFormularios = array();
        $this->arrDesembolso = array();
        $this->arrExtensiones = array("txt", "xls", "xlsx");
        $this->arrModalidad = array(12);
        $this->arrEsquema = array(16, 17);

        $this->arrTitulos[] = "N°";
        $this->arrTitulos[] = "ID HOGAR";
        $this->arrTitulos[] = "TIPO DOC PPAL";
        $this->arrTitulos[] = "DOCUMENTO PPAL";
        $this->arrTitulos[] = "NOMBRES";
        $this->arrTitulos[] = "APELLIDOS";
        $this->arrTitulos[] = "TIPO DOC VENDEDOR";
        $this->arrTitulos[] = "N° DOCUMENTO VENDEDOR";
        $this->arrTitulos[] = "NOMBRE VENDEDOR";
        $this->arrTitulos[] = "NOMBRE DEL PROYECTO";
        $this->arrTitulos[] = "DEPARTAMENTO";
        $this->arrTitulos[] = "MUNICIPIO";
        $this->arrTitulos[] = "TITULAR CUENTA";
        $this->arrTitulos[] = "TIPO DOC TITULAR";
        $this->arrTitulos[] = "DOCUMENTO TITULAR";
        $this->arrTitulos[] = "ENTIDAD FINANCIERA";
        $this->arrTitulos[] = "TIPO CUENTA";
        $this->arrTitulos[] = "N° DE CUENTA";
        $this->arrTitulos[] = "No ACTO ADMON";
        $this->arrTitulos[] = "RANGO INGRESOS";
        $this->arrTitulos[] = "FECHA ACTO ADMON";
        $this->arrTitulos[] = "VALOR SUBSIDIO";
        $this->arrTitulos[] = "DENOMINACIÓN UNIDAD";
        $this->arrTitulos[] = "N° DE ESCRITURA";
        $this->arrTitulos[] = "NOTARIA";
        $this->arrTitulos[] = "FECHA ESCRITURA";
        $this->arrTitulos[] = "MATRÍCULA INMOBILIARIA";
        $this->arrTitulos[] = "VALOR INMUEBLE";
        $this->arrTitulos[] = "CERTIFICADO DE TRADICIÓN";
        $this->arrTitulos[] = "ZONA DE MATRICULA";
        $this->arrTitulos[] = "FECHA DE MATRICULA";
        $this->arrTitulos[] = "SUBSIDIO SDHT";
        $this->arrTitulos[] = "SUBSIDIO FONVIVIENDA";
        $this->arrTitulos[] = "APROBO";
        $this->arrTitulos[] = "ELABORO";
    }

    public function cargarArchivo() {

        $arrArchivo = array();
// valida si el archivo fue cargado y si corresponde a las extensiones válidas
        switch ($_FILES['archivo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->arrErrores[] = "Debe especificar un archivo para cargar ***";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
                break;
            default:
                $numPunto = strpos($_FILES['archivo']['name'], ".") + 1;
                $numRestar = ( strlen($_FILES['archivo']['name']) - $numPunto ) * -1;
                $txtExtension = substr($_FILES['archivo']['name'], $numRestar);
                if (!in_array(strtolower($txtExtension), $this->arrExtensiones)) {
                    $this->arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
                }
                break;
        }

        if (empty($this->arrErrores)) {

// si es un archivo de texto obtiene los datos
            if ($_FILES['archivo']['type'] == "text/plain") {
                foreach (file($_FILES['archivo']['tmp_name']) as $numLinea => $txtLinea) {
                    if (trim($txtLinea) != "") {
                        $arrArchivo[$numLinea] = explode("\t", trim($txtLinea));
                        foreach ($arrArchivo[$numLinea] as $numColumna => $txtCelda) {
                            if ($numColumna < count($this->arrFormatoArchivo)) {
                                $arrArchivo[$numLinea][$numColumna] = trim(utf8_encode($txtCelda));
                            } else {
                                unset($arrArchivo[$numLinea][$numColumna]);
                            }
                        }
                    }
                }
            } else {

                try {

// crea las clases para la obtencion de los datos
                    $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES['archivo']['tmp_name']);
                    $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
                    $objPHPExcel = $objReader->load($_FILES['archivo']['tmp_name']);
                    $objHoja = $objPHPExcel->getSheet(0);

// obtiene las dimensiones del archivo para la obtencion del contenido por rangos
                    $numFilas = $objHoja->getHighestRow() + 1;
                    $numColumnas = PHPExcel_Cell::columnIndexFromString($objHoja->getHighestColumn()) - 1;

// obtiene los datos del rango obtenido
                    for ($numFila = 1; $numFila < $numFilas; $numFila++) {
                        if ($objHoja->getCellByColumnAndRow(1, $numFila)->getValue() != "") {
                            for ($numColumna = 0; $numColumna <= $numColumnas; $numColumna++) {
                                $numFilaArreglo = $numFila - 1;
                                $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                                if ($numColumna == 25 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha->format("Y-m-d");
                                }
                                if ($numColumna == 30 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha1 = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha1->format("Y-m-d");
                                }
//llena arreglo de los documentos para la respectiva validacion de formularios
                                if ($numColumna == 3 && $numFila > 1) {
                                    $this->arrDocumentos[] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                                }
                            }
                        }
                    }

// si no tiene la celda de clave llena no carga
// if ($objPHPExcel->getProperties()->getCreator() == $this->txtCreador) {
// limpia las lineas vacias
                    foreach ($arrArchivo as $numLinea => $arrLinea) {
                        $bolLineaVacia = true;
                        foreach ($arrLinea as $numColumna => $txtCelda) {
                            if ($txtCelda != "") {
                                $bolLineaVacia = false;
                                $arrArchivo[$numLinea][$numColumna] = trim($txtCelda);
                            }
                        }
                        if ($bolLineaVacia == true) {
                            unset($arrArchivo[$numLinea]);
                        }
                    }
                    /* } 
                      else {
                      $this->arrErrores[] = "No se va a cargar el archivo porque no corresponde a la plantilla que se obtiene de la aplicación";
                      } */
                } catch (Exception $objError) {
                    $this->arrErrores[] = $objError->getMessage();
                }
            }
        }

        if (count($arrArchivo) == 1) {
            $this->arrErrores[] = "Un archivo que contiene solo los titulos se considera vacío";
        }
        return $arrArchivo;
    }

    public function validarTitulos($arrTitulos) {
        foreach ($this->arrTitulos as $numColumna => $txtColumna) {
            if ($txtColumna != $arrTitulos[$numColumna]) {
                $this->arrErrores[] = "No se encuentra la columna <b>$txtColumna</b> ó no está en el lugar correcto";
            }
        }
    }

    public function validarformularios($arrArchivo) {

        $cantHogares = count($this->arrDocumentos);
        $documents = implode(",", $this->arrDocumentos);
        global $aptBd;
        echo "<br>" . $sql = "SELECT 
                    frm.seqFormulario,
                    numDocumento,
                    frm.seqEstadoProceso,
                    frm.seqTipoEsquema,
                    frm.seqModalidad,
                    frm.valAspiraSubsidio,
                    hva.fchActo,
                    des.seqDesembolso
                FROM
                    t_frm_formulario frm
                        LEFT JOIN
                    t_frm_hogar USING (seqFormulario)
                        LEFT JOIN
                    t_ciu_ciudadano USING (seqCiudadano)
                        LEFT JOIN
                    t_aad_formulario_acto fac USING (seqFormulario)
                        LEFT JOIN
                    t_aad_hogares_vinculados hva USING (seqFormularioActo)
                    LEFT JOIN
                    t_des_desembolso des USING (seqFormulario)
                WHERE
                    numDocumento IN (" . $documents . ")
                        AND hva.seqTipoActo = 1";

        $objRes = $aptBd->execute($sql);
        if ($cantHogares != $objRes->numRows()) {
            $this->arrErrores[] = "La cantidad de hogares no corresponde al ingresado en la plantilla ";
        }
        while ($objRes->fields) {

            $this->arrFormularios[] = $objRes->fields['seqFormulario'];
            $fchActo = strtotime($objRes->fields['fchActo']);


            if ($objRes->fields['seqEstadoProceso'] != 15) {
                $this->arrErrores[] = "El Hogar de el documento " . $objRes->fields['numDocumento'] . ", no se encuentra en el estado Asignacion - Asignado";
            }
            if (!in_array($objRes->fields['seqModalidad'], $this->arrModalidad)) {
                $this->arrErrores[] = "El Hogar de el documento " . $objRes->fields['numDocumento'] . ", no se encuentra en la modalidad de Cierre Financiero";
            }
            if (!in_array($objRes->fields['seqTipoEsquema'], $this->arrEsquema)) {
                $this->arrErrores[] = "El Hogar de el documento " . $objRes->fields['numDocumento'] . ", no se encuentra en el esquema de MCY";
            }
            foreach ($arrArchivo as $numLinea => $arrLinea) {
                foreach ($arrLinea as $key => $value) {
                    if ($key == 25 and $arrLinea[3] == $objRes->fields['numDocumento']) {

                        $fchEscritura = strtotime($value);
                        // echo "<br> ***" . $fchActo . " > " . $fchEscritura;
                        if ($fchEscritura < $fchActo) {
                            // echo "<br>" . $objRes->fields['fchActo'] . " > " . $value;
                            $this->arrErrores[] = "El Hogar con documento: " . $objRes->fields['numDocumento'] . ", tiene una fecha de escrituración menor a la fecha del acto ";
                        }
                    }
                }
            }

//  echo "<br>" . $objRes->fields['seqDesembolso'];
            if ($objRes->fields['seqDesembolso'] != "" && $objRes->fields['seqDesembolso'] > 0 && $objRes->fields['seqDesembolso'] != NULL) {
                $this->arrErrores[] = "El Hogar con número de documento: " . $objRes->fields['numDocumento'] . ", ya se encuentra en proceso de desembolso";
            }

            $objRes->MoveNext();
        }
    }

    public function salvarDatosFaseI($arrArchivo, $claDesembolso) {

        global $aptBd;

        $formularios = implode(",", $this->arrFormularios);
        $aptBd->BeginTrans();

        try {
            $sql = "INSERT INTO t_des_desembolso
                    (seqFormulario, numEscrituraPublica, numCertificadoTradicion, numCartaAsignacion, numAltoRiesgo, numHabitabilidad, numBoletinCatastral, 
                    numLicenciaConstruccion, numUltimoPredial, numUltimoReciboAgua, numUltimoReciboEnergia, numOtros, txtNombreVendedor, numDocumentoVendedor, 
                    txtDireccionInmueble, txtBarrio, seqLocalidad, txtEscritura, numNotaria, fchEscritura, numAvaluo, valInmueble, txtMatriculaInmobiliaria, 
                    numValorInmueble, txtEscrituraPublica, txtCertificadoTradicion, txtCartaAsignacion, txtAltoRiesgo, txtHabitabilidad, txtBoletinCatastral,
                    txtLicenciaConstruccion, txtUltimoPredial, txtUltimoReciboAgua, txtUltimoReciboEnergia, txtOtro, txtViabilizoJuridico, txtViabilizoTecnico, 
                    bolViabilizoJuridico, bolviabilizoTecnico, bolPoseedor, txtChip, numActaEntrega, txtActaEntrega, numCertificacionVendedor, txtCertificacionVendedor, 
                    numAutorizacionDesembolso, txtAutorizacionDesembolso, numFotocopiaVendedor, txtFotocopiaVendedor, seqTipoDocumento, txtCompraVivienda, txtNit, txtRit, 
                    txtRut, numNit, numRit, numRut, txtTipoPredio, numTelefonoVendedor, txtCedulaCatastral, numAreaConstruida, numAreaLote, txtTipoDocumentos, numEstrato, 
                    txtCiudad, fchCreacionBusquedaOferta, fchActualizacionBusquedaOferta, fchCreacionEscrituracion, fchActualizacionEscrituracion, numTelefonoVendedor2, 
                    txtPropiedad, fchSentencia, numJuzgado, txtCiudadSentencia, numResolucion, fchResolucion, txtEntidad, txtCiudadResolucion, numContratoArrendamiento,
                    txtContratoArrendamiento, numAperturaCAP, txtAperturaCAP, numCedulaArrendador, txtCedulaArrendador, numCuentaArrendador, txtCuentaArrendador, 
                    numRetiroRecursos, txtRetiroRecursos, numServiciosPublicos, txtServiciosPublicos, txtCorreoVendedor, seqCiudad, seqAplicacionSubsidio, 
                    seqProyectosSoluciones, seqFrmulario_Des)                  
                    VALUES";

            $datos = $this->obtenerDatos();

            foreach ($arrArchivo as $key => $value) {

                $this->iniciarVariables($claDesembolso);

                $sql .= "(";

                if ($value[3] != null) {
                    foreach ($datos[$value[3]] as $key2 => $value2) {

                        $claDesembolso->$key2 = $value2;
                    }
                    $claDesembolso->txtNombreVendedor = $value[8];
                    $claDesembolso->numDocumentoVendedor = $value[7];
                    $claDesembolso->txtDireccionInmueble = $value[9] . ' ' . $value[22];
                    $claDesembolso->txtEscritura = $value[23];
                    $claDesembolso->numNotaria = $value[24];
                    $claDesembolso->fchEscritura = $value[25];
                    $claDesembolso->txtMatriculaInmobiliaria = $value[26];
                    $claDesembolso->valInmueble = $value[27];
                    $claDesembolso->numValorInmueble = $value[27];
                    $claDesembolso->txtCertificadoTradicion = $value[28];
                    $claDesembolso->txtCedulaCatastral = $value[29];




                    $sql .= "$claDesembolso->seqFormulario, $claDesembolso->numEscrituraPublica, $claDesembolso->numCertificadoTradicion, $claDesembolso->numCartaAsignacion, $claDesembolso->numAltoRiesgo, $claDesembolso->numHabitabilidad, $claDesembolso->numBoletinCatastral,"
                            . "$claDesembolso->numLicenciaConstruccion, $claDesembolso->numUltimoPredial, $claDesembolso->numUltimoReciboAgua, $claDesembolso->numUltimoReciboEnergia, $claDesembolso->numOtros, '$claDesembolso->txtNombreVendedor', $claDesembolso->numDocumentoVendedor, "
                            . "'$claDesembolso->txtDireccionInmueble', $claDesembolso->txtBarrio, $claDesembolso->seqLocalidad, '$claDesembolso->txtEscritura', $claDesembolso->numNotaria, '$claDesembolso->fchEscritura', $claDesembolso->numAvaluo, $claDesembolso->valInmueble, '$claDesembolso->txtMatriculaInmobiliaria',"
                            . "$claDesembolso->numValorInmueble, $claDesembolso->txtEscrituraPublica, '$claDesembolso->txtCertificadoTradicion', $claDesembolso->txtCartaAsignacion, $claDesembolso->txtAltoRiesgo, $claDesembolso->txtHabitabilidad, $claDesembolso->txtBoletinCatastral, "
                            . "$claDesembolso->txtLicenciaConstruccion, $claDesembolso->txtUltimoPredial, $claDesembolso->txtUltimoReciboAgua, $claDesembolso->txtUltimoReciboEnergia, $claDesembolso->txtOtro, $claDesembolso->txtViabilizoJuridico, $claDesembolso->txtViabilizoTecnico, "
                            . "$claDesembolso->bolViabilizoJuridico, $claDesembolso->bolviabilizoTecnico, $claDesembolso->bolPoseedor, $claDesembolso->txtChip, $claDesembolso->numActaEntrega, $claDesembolso->txtActaEntrega, $claDesembolso->numCertificacionVendedor, $claDesembolso->txtCertificacionVendedor, "
                            . "$claDesembolso->numAutorizacionDesembolso, $claDesembolso->txtAutorizacionDesembolso, $claDesembolso->numFotocopiaVendedor, $claDesembolso->txtFotocopiaVendedor, $claDesembolso->seqTipoDocumento, '$claDesembolso->txtCompraVivienda', $claDesembolso->txtNit, $claDesembolso->txtRit, "
                            . "$claDesembolso->txtRut, $claDesembolso->numNit, $claDesembolso->numRit, $claDesembolso->numRut, '$claDesembolso->txtTipoPredio', $claDesembolso->numTelefonoVendedor, '$claDesembolso->txtCedulaCatastral', $claDesembolso->numAreaConstruida, $claDesembolso->numAreaLote, $claDesembolso->txtTipoDocumentos, $claDesembolso->numEstrato, "
                            . "'$claDesembolso->txtCiudad', $claDesembolso->fchCreacionBusquedaOferta, $claDesembolso->fchActualizacionBusquedaOferta, $claDesembolso->fchCreacionEscrituracion, $claDesembolso->fchActualizacionEscrituracion, $claDesembolso->numTelefonoVendedor2, '$claDesembolso->txtPropiedad', "
                            . "$claDesembolso->fchSentencia, $claDesembolso->numJuzgado, $claDesembolso->txtCiudadSentencia, $claDesembolso->numResolucion, $claDesembolso->fchResolucion, $claDesembolso->txtEntidad, $claDesembolso->txtCiudadResolucion, $claDesembolso->numContratoArrendamiento, $claDesembolso->txtContratoArrendamiento, "
                            . "$claDesembolso->numAperturaCAP, $claDesembolso->txtAperturaCAP, $claDesembolso->numCedulaArrendador, $claDesembolso->txtCedulaArrendador, $claDesembolso->numCuentaArrendador, $claDesembolso->txtCuentaArrendador, $claDesembolso->numRetiroRecursos,"
                            . "$claDesembolso->txtRetiroRecursos, $claDesembolso->numServiciosPublicos, '$claDesembolso->txtServiciosPublicos', '$claDesembolso->txtCorreoVendedor', $claDesembolso->seqCiudad, $claDesembolso->seqAplicacionSubsidio, $claDesembolso->seqProyectosSoluciones, $claDesembolso->seqFrmulario_Des";
                }
                $sql .="),";
            }
            $sql = substr_replace($sql, ';', -1, 1);
            echo "<br>" . $sql;
            $aptBd->execute($sql);

            $aptBd->CommitTrans();
            try {
                $sqlEsc = "INSERT INTO t_des_escrituracion(
                    seqDesembolso,seqFormulario, numEscrituraPublica, numCertificadoTradicion, numCartaAsignacion, numAltoRiesgo, numHabitabilidad, 
                    numBoletinCatastral, numLicenciaConstruccion, numUltimoPredial, numUltimoReciboAgua, numUltimoReciboEnergia, numOtros, txtNombreVendedor, 
                    numDocumentoVendedor, txtDireccionInmueble, txtBarrio, seqLocalidad, txtEscritura, numNotaria, fchEscritura, numAvaluo, valInmueble, 
                    txtMatriculaInmobiliaria, numValorInmueble, txtEscrituraPublica, txtCertificadoTradicion, txtCartaAsignacion, txtAltoRiesgo, txtHabitabilidad, 
                    txtBoletinCatastral, txtLicenciaConstruccion, txtUltimoPredial, txtUltimoReciboAgua, txtUltimoReciboEnergia, txtOtro, txtViabilizoJuridico, 
                    txtViabilizoTecnico, bolViabilizoJuridico, bolviabilizoTecnico, bolPoseedor, txtChip, numActaEntrega, txtActaEntrega, numCertificacionVendedor, 
                    txtCertificacionVendedor, numAutorizacionDesembolso, txtAutorizacionDesembolso, numFotocopiaVendedor, txtFotocopiaVendedor, seqTipoDocumento, 
                    txtCompraVivienda, txtNit, txtRit, txtRut, numNit, numRit, numRut, txtTipoPredio, numTelefonoVendedor, txtCedulaCatastral, numAreaConstruida, 
                    numAreaLote, txtTipoDocumentos, numEstrato, txtCiudad, fchCreacionBusquedaOferta, fchActualizacionBusquedaOferta, fchCreacionEscrituracion, 
                    fchActualizacionEscrituracion, numTelefonoVendedor2, txtPropiedad, fchSentencia, numJuzgado, txtCiudadSentencia, numResolucion, fchResolucion, 
                    txtEntidad, txtCiudadResolucion, numContratoArrendamiento, txtContratoArrendamiento, numAperturaCAP, txtAperturaCAP, numCedulaArrendador, 
                    txtCedulaArrendador, numCuentaArrendador, txtCuentaArrendador, numRetiroRecursos, txtRetiroRecursos, numServiciosPublicos, txtServiciosPublicos, 
                    txtCorreoVendedor, seqCiudad, seqAplicacionSubsidio, seqProyectosSoluciones,  numContratoLeasing, fchContratoLeasing, numFoliosContratoLeasing, 
                    txtFoliosContratoLeasing)";

                $sqlEsc .="(select 
                    seqDesembolso, seqFormulario, numEscrituraPublica, numCertificadoTradicion, numCartaAsignacion, numAltoRiesgo, numHabitabilidad,
                    numBoletinCatastral, numLicenciaConstruccion, numUltimoPredial, numUltimoReciboAgua, numUltimoReciboEnergia, numOtros, txtNombreVendedor,
                    numDocumentoVendedor, txtDireccionInmueble, txtBarrio, seqLocalidad, txtEscritura, numNotaria, fchEscritura, numAvaluo, valInmueble, 
                    txtMatriculaInmobiliaria, numValorInmueble, txtEscrituraPublica, txtCertificadoTradicion, txtCartaAsignacion, txtAltoRiesgo, txtHabitabilidad, 
                    txtBoletinCatastral, txtLicenciaConstruccion, txtUltimoPredial, txtUltimoReciboAgua, txtUltimoReciboEnergia, txtOtro, txtViabilizoJuridico, 
                    txtViabilizoTecnico, bolViabilizoJuridico, bolviabilizoTecnico, bolPoseedor, txtChip, numActaEntrega, txtActaEntrega, numCertificacionVendedor, 
                    txtCertificacionVendedor, numAutorizacionDesembolso, txtAutorizacionDesembolso, numFotocopiaVendedor, txtFotocopiaVendedor, seqTipoDocumento, 
                    txtCompraVivienda, txtNit, txtRit, txtRut, numNit, numRit, numRut, txtTipoPredio, numTelefonoVendedor, txtCedulaCatastral, numAreaConstruida, 
                    numAreaLote, txtTipoDocumentos, numEstrato, txtCiudad, fchCreacionBusquedaOferta, fchActualizacionBusquedaOferta, fchCreacionEscrituracion, 
                    fchActualizacionEscrituracion, numTelefonoVendedor2, txtPropiedad, fchSentencia, numJuzgado, txtCiudadSentencia, numResolucion, fchResolucion, 
                    txtEntidad, txtCiudadResolucion, numContratoArrendamiento, txtContratoArrendamiento, numAperturaCAP, txtAperturaCAP, numCedulaArrendador, 
                    txtCedulaArrendador, numCuentaArrendador, txtCuentaArrendador, numRetiroRecursos, txtRetiroRecursos, numServiciosPublicos, txtServiciosPublicos, 
                    txtCorreoVendedor, seqCiudad, seqAplicacionSubsidio, seqProyectosSoluciones, 0 AS numContratoLeasing, 'NULL' AS fchContratoLeasing, 
                    0 AS numFoliosContratoLeasing, '' AS txtFoliosContratoLeasing from t_des_desembolso where seqFormulario in (" . $formularios . "));";

                echo "<br>" . $sqlEsc;
                $aptBd->execute($sqlEsc);
                $aptBd->CommitTrans();
                if (empty($this->arrErrores)) {
                    $this->salvarDatosFaseII($arrArchivo);
                } else {
                    $this->mostrarErrores();
                }
            } catch (Exception $ex) {
                $this->arrErrores[] = $ex->getMessage();
                $aptBd->RollBackTrans();
                $this->mostrarErrores();
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
            $this->mostrarErrores();
        }
    }

    public function salvarDatosFaseII($arrArchivo) {

        global $aptBd;

        $formularios = implode(",", $this->arrFormularios);
        $aptBd->BeginTrans();
        try {
            $sql = "INSERT INTO t_des_estudio_titulos
                    (seqDesembolso,numEscrituraIdentificacion,fchEscrituraIdentificacion,numNotariaIdentificacion,numEscrituraTitulo,fchEscrituraTitulo, numNotariaTitulo,
                    numFolioMatricula,txtZonaMatricula,txtCiudadMatricula,fchMatricula,bolSubsidioSDHT,bolSubsidioFonvivienda,numResolucionFonvivienda,
                    numAnoResolucionFonvivienda,txtAprobo,fchCreacion,fchActualizacion,txtCiudadTitulo,txtCiudadIdentificacion,txtElaboro)
                    VALUES";

            $datos = $this->obtenerDatos();

            foreach ($arrArchivo as $key => $value) {
                $this->arrDesembolso[] = $datos[$value[3]]['seqDesembolso'];
                $fchMatricula = strtotime($value[29]);
                $bolSubsidioSDHT = ($value[30] == 'SI') ? 1 : 0;
                $bolSubsidioFonvivienda = ($value[31] == 'SI') ? 1 : 0;
                $sql .= "(" . $datos[$value[3]]['seqDesembolso'] . ", $value[23],'$value[25]',$value[24], $value[23],'$value[25]',$value[24], 0, '$value[29]', 'Bogotá', '$value[30]', "
                        . "$bolSubsidioSDHT, $bolSubsidioFonvivienda, 0,0, '$value[33]',NOW(), NOW(), 'Bogotá', 'Bogotá', '$value[34]' ),";
            }
            $sql = substr_replace($sql, ';', -1, 1);
            echo "<p>" . $sql . "</p>";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
            if (empty($this->arrErrores)) {
                $this->salvarAdjuntos();
            } else {
                $this->mostrarErrores();
            }
        } catch (Exception $exception) {
            $this->arrErrores[] = $exception->getMessage();
            $aptBd->RollBackTrans();
            $this->mostrarErrores();
        }
    }

    public function salvarAdjuntos() {

        global $aptBd;

        $desembolso = implode(",", $this->arrDesembolso);

        $arrayObs[0]['texto'] = 'ESCRITURA PÚBLICA';
        $arrayObs[0]['tipo'] = 1;
        $arrayObs[1]['texto'] = 'CONSULTA PAGINA VUR FOLIO DE MATRÍCULA INMOBILIARIA';
        $arrayObs[1]['tipo'] = 1;
        $arrayObs[2]['texto'] = 'PROPIETARIOS SON BENEFICIARIOS DEL SDV';
        $arrayObs[2]['tipo'] = 4;
        $arrayObs[3]['texto'] = 'NOMBRE Y CÉDULA DE LOS PROPIETARIOS';
        $arrayObs[3]['tipo'] = 4;
        $arrayObs[4]['texto'] = 'COMPRAVENTA REALIZADA CON SDV';
        $arrayObs[4]['tipo'] = 4;
        $arrayObs[5]['texto'] = 'UNA VEZ VERIFICADA LA INFORMACION REPORTADA POR EL SISTEMA DE INFORMACION DEL PROGRAMA MI CASA YA Y LOS DOCUMENTOS ALLEGADOS'
                . ' POR EL OFERENTE Y/O CONSTRUCTOR Y CONSULTADA LA VENTANILLA UNICA DE REGISTRO VUR SE PUEDE ESTABLECER QUE SE DA CUMPLIMIENTO A LOS REQUISITOS '
                . 'EXIGIDOS POR LA RESOLUCION 654 DE 2018';
        $arrayObs[5]['tipo'] = 2;

        $aptBd->BeginTrans();
        try {
            $seqAdjuntos = "SELECT distinct(seqEstudioTitulos) As seqEstudioTitulos FROM t_des_estudio_titulos where seqDesembolso in(" . $desembolso . ");";
            $objRes = $aptBd->execute($seqAdjuntos);

            $sql = "INSERT INTO t_des_adjuntos_titulos (seqTipoAdjunto, seqEstudioTitulos, txtAdjunto) VALUES";
            while ($objRes->fields) {
                foreach ($arrayObs as $key => $value) {
                    echo "<br>" . $value['texto'];
                    $sql .= "(" . $value['tipo'] . "," . $objRes->fields['seqEstudioTitulos'] . ",'" . $value['texto'] . "' ),";
                }
                $objRes->MoveNext();
            }
            $sql = substr_replace($sql, ';', -1, 1);
            echo "<p>" . $sql . "</p>";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
        } catch (Exception $exception) {
            $this->arrErrores[] = $exception->getMessage();
            $aptBd->RollBackTrans();
            $this->mostrarErrores();
        }
    }

    public function obtenerDatos() {

        $formularios = implode(",", $this->arrFormularios);
        global $aptBd;
        $sql = "SELECT 
                    frm.seqFormulario,
                    numDocumento,
                    frm.seqEstadoProceso,
                    frm.seqTipoEsquema,
                    frm.seqModalidad,
                    frm.valAspiraSubsidio,
                    hva.fchActo,
                    des.seqDesembolso,
                    des.txtEscritura,
                    des.numNotaria,
                    des.fchEscritura
                FROM
                    t_frm_formulario frm
                        LEFT JOIN
                    t_frm_hogar USING (seqFormulario)
                        LEFT JOIN
                    t_ciu_ciudadano USING (seqCiudadano)
                        LEFT JOIN
                    t_aad_formulario_acto fac USING (seqFormulario)
                        LEFT JOIN
                    t_aad_hogares_vinculados hva USING (seqFormularioActo)
                    LEFT JOIN
                    t_des_desembolso des USING (seqFormulario)
                WHERE
                    seqFormulario IN (" . $formularios . ")
                        AND hva.seqTipoActo = 1";
        $datos = Array();
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $datos[$objRes->fields['numDocumento']] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function mostrarErrores() {

        $listError = "<div class='alert alert-danger'><ui>";
        foreach ($this->arrErrores as $keyError => $error) {
            $listError .= "<li>Alerta!! " . $error . "</li>";
        }
        echo $listError .= "</ui></div>";
    }

    public function iniciarVariables($claDesembolso) {

        $claDesembolso->numEscrituraPublica = 1;
        $claDesembolso->numCertificadoTradicion = 1;
        $claDesembolso->numCartaAsignacion = 'NULL';
        $claDesembolso->numAltoRiesgo = 'NULL';
        $claDesembolso->numHabitabilidad = 'NULL';
        $claDesembolso->numBoletinCatastral = 'NULL';
        $claDesembolso->numLicenciaConstruccion = 'NULL';
        $claDesembolso->numUltimoPredial = 'NULL';
        $claDesembolso->numUltimoReciboAgua = 'NULL';
        $claDesembolso->numUltimoReciboEnergia = 'NULL';
        $claDesembolso->numOtros = 'NULL';
        $claDesembolso->txtBarrio = 'NULL';
        $claDesembolso->seqLocalidad = 1;
        $claDesembolso->txtEscritura = 'NULL';
        $claDesembolso->numNotaria = 'NULL';
        $claDesembolso->fchEscritura = 'NULL';
        $claDesembolso->numAvaluo = 'NULL';
        $claDesembolso->valInmueble = 'NULL';
        $claDesembolso->txtMatriculaInmobiliaria = 'NULL';
        $claDesembolso->numValorInmueble = 'NULL';
        $claDesembolso->txtEscrituraPublica = 'NULL';
        $claDesembolso->txtCertificadoTradicion = 'NULL';
        $claDesembolso->txtCartaAsignacion = 'NULL';
        $claDesembolso->txtAltoRiesgo = 'NULL';
        $claDesembolso->txtHabitabilidad = 'NULL';
        $claDesembolso->txtBoletinCatastral = 'NULL';
        $claDesembolso->txtLicenciaConstruccion = 'NULL';
        $claDesembolso->txtUltimoPredial = 'NULL';
        $claDesembolso->txtUltimoReciboAgua = 'NULL';
        $claDesembolso->txtUltimoReciboEnergia = 'NULL';
        $claDesembolso->txtOtro = 'NULL';
        $claDesembolso->txtViabilizoJuridico = 'NULL';
        $claDesembolso->txtViabilizoTecnico = 'NULL';
        $claDesembolso->bolViabilizoJuridico = 1;
        $claDesembolso->bolviabilizoTecnico = 1;
        $claDesembolso->bolPoseedor = 0;
        $claDesembolso->txtChip = 'NULL';
        $claDesembolso->numActaEntrega = 'NULL';
        $claDesembolso->txtActaEntrega = 'NULL';
        $claDesembolso->numCertificacionVendedor = 'NULL';
        $claDesembolso->txtCertificacionVendedor = 'NULL';
        $claDesembolso->numAutorizacionDesembolso = 'NULL';
        $claDesembolso->txtAutorizacionDesembolso = 'NULL';
        $claDesembolso->numFotocopiaVendedor = 'NULL';
        $claDesembolso->txtFotocopiaVendedor = 'NULL';
        $claDesembolso->seqTipoDocumento = 'NULL';
        $claDesembolso->txtCompraVivienda = 'nueva';
        $claDesembolso->txtNit = 'NULL';
        $claDesembolso->txtRit = 'NULL';
        $claDesembolso->txtRut = 'NULL';
        $claDesembolso->numNit = 'NULL';
        $claDesembolso->numRit = 'NULL';
        $claDesembolso->numRut = 'NULL';
        $claDesembolso->txtTipoPredio = 'urbano';
        $claDesembolso->numTelefonoVendedor = 'NULL';
        $claDesembolso->numAreaConstruida = 'NULL';
        $claDesembolso->numAreaLote = 'NULL';
        $claDesembolso->txtTipoDocumentos = 'NULL';
        $claDesembolso->numEstrato = 'NULL';
        $claDesembolso->txtCiudad = "Bogotá";
        $claDesembolso->fchCreacionBusquedaOferta = 'NULL';
        $claDesembolso->fchActualizacionBusquedaOferta = 'NULL';
        $claDesembolso->fchCreacionEscrituracion = 'NULL';
        $claDesembolso->fchActualizacionEscrituracion = 'NULL';
        $claDesembolso->numTelefonoVendedor2 = 'NULL';
        $claDesembolso->txtPropiedad = 'escritura';
        $claDesembolso->fchSentencia = 'NULL';
        $claDesembolso->numJuzgado = 'NULL';
        $claDesembolso->txtCiudadSentencia = 'NULL';
        $claDesembolso->numResolucion = 'NULL';
        $claDesembolso->fchResolucion = 'NULL';
        $claDesembolso->txtEntidad = 'NULL';
        $claDesembolso->txtCiudadResolucion = 'NULL';
        $claDesembolso->numContratoArrendamiento = 'NULL';
        $claDesembolso->txtContratoArrendamiento = 'NULL';
        $claDesembolso->numAperturaCAP = 'NULL';
        $claDesembolso->txtAperturaCAP = 'NULL';
        $claDesembolso->numCedulaArrendador = 'NULL';
        $claDesembolso->txtCedulaArrendador = 'NULL';
        $claDesembolso->numCuentaArrendador = 'NULL';
        $claDesembolso->txtCuentaArrendador = 'NULL';
        $claDesembolso->numRetiroRecursos = 'NULL';
        $claDesembolso->txtRetiroRecursos = 'NULL';
        $claDesembolso->numServiciosPublicos = 'NULL';
        $claDesembolso->txtServiciosPublicos = 'NULL';
        $claDesembolso->txtCorreoVendedor = 'NULL';
        $claDesembolso->seqCiudad = 149;
        $claDesembolso->seqAplicacionSubsidio = 'NULL';
        $claDesembolso->seqProyectosSoluciones = 'NULL';
        $claDesembolso->seqFrmulario_Des = 'NULL';
    }

}

?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      