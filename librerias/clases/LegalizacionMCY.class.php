<?php

class LegalizacionMCY {

    public $arrErrores;
    public $arrMensajes;
    public $arrTitulos;
    public $arrFormatoArchivo;
    public $arrDocumentos;
    public $arrFormularios;
    public $arrDesembolso;
    public $arrayLeasing;
    public $arrEsquema;
    public $arrModalidad;
    public $objSegNuevo;
    public $fecha;

    public function __construct() {

        $this->arrErrores = array();
        $this->arrMensajes = array();
        $this->arrDocumentos = array();
        $this->arrFormularios = array();
        $this->arrDesembolso = array();
        $this->arrayLeasing = array();
        $this->objSegNuevo = array();

        $this->arrExtensiones = array("txt", "xls", "xlsx");
        $this->arrModalidad = array(12);
        $this->arrEsquema = array(16, 17);
        $this->fecha = date("Y-m-d h:i:s");

        $this->arrTitulos[] = "No";
        $this->arrTitulos[] = "ID HOGAR";
        $this->arrTitulos[] = "TIPO DOC PPAL";
        $this->arrTitulos[] = "DOCUMENTO PPAL";
        $this->arrTitulos[] = "NOMBRES";
        $this->arrTitulos[] = "APELLIDOS";
        $this->arrTitulos[] = "TIPO DOC VENDEDOR";
        $this->arrTitulos[] = "No DOCUMENTO VENDEDOR";
        $this->arrTitulos[] = "NOMBRE VENDEDOR";
        $this->arrTitulos[] = "NOMBRE DEL PROYECTO";
        $this->arrTitulos[] = "DEPARTAMENTO";
        $this->arrTitulos[] = "MUNICIPIO";
        $this->arrTitulos[] = "TITULAR CUENTA";
        $this->arrTitulos[] = "TIPO DOC TITULAR";
        $this->arrTitulos[] = "DOCUMENTO TITULAR";
        $this->arrTitulos[] = "ENTIDAD FINANCIERA";
        $this->arrTitulos[] = "TIPO CUENTA";
        $this->arrTitulos[] = "No DE CUENTA";
        $this->arrTitulos[] = "No ACTO ADMON";
        $this->arrTitulos[] = "RANGO INGRESOS";
        $this->arrTitulos[] = "FECHA ACTO ADMON";
        $this->arrTitulos[] = "VALOR SUBSIDIO";
        $this->arrTitulos[] = "CONSECUTIVO";
        $this->arrTitulos[] = "FECHA AUTORIZACION";
        $this->arrTitulos[] = "DIRECCION VENDEDOR";
        $this->arrTitulos[] = "TELEFONO1 VENDEDOR";
        $this->arrTitulos[] = "TELEFONO2 VENDEDOR";
        $this->arrTitulos[] = "CORREO VENDEDOR";
        $this->arrTitulos[] = "DIRECCION INMUEBLE";
        $this->arrTitulos[] = "BARRIO INMUEBLE";
        $this->arrTitulos[] = "LOCALIDAD INMUEBLE";
        $this->arrTitulos[] = "OPCION LEASING";
        $this->arrTitulos[] = "No DE ESCRITURA";
        $this->arrTitulos[] = "FECHA ESCRITURA";
        $this->arrTitulos[] = "NOTARIA";
        $this->arrTitulos[] = "VALOR INMUEBLE";
        $this->arrTitulos[] = "MATRICULA INMOBILIARIA";
        $this->arrTitulos[] = "ZONA DE MATRICULA";
        $this->arrTitulos[] = "FECHA CTL";
        $this->arrTitulos[] = "No CONTRATO LEASING";
        $this->arrTitulos[] = "FECHA CONTRATO LEASING";
        $this->arrTitulos[] = "ELABORO";
        $this->arrTitulos[] = "REVISO";
        $this->arrTitulos[] = "APROBO";
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

                                if ($numColumna == 20 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha->format("Y-m-d");
                                }
                                if ($numColumna == 23 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha1 = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha1->format("Y-m-d");
                                }
                                if ($numColumna == 33 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha3 = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha3->format("Y-m-d");
                                }
                                if ($numColumna == 38 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha4 = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha4->format("Y-m-d");
                                }

                                if ($numColumna == 40 and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                    $claFecha5 = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                    $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha5->format("Y-m-d");
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
        $sql = "SELECT 
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
                        AND hva.seqTipoActo = 1 order by hva.fchActo desc ";

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
                    if ($key < 44) {
                        if ($arrLinea[3] == $objRes->fields['numDocumento']) {
                            $fchEscritura = "";
                            if ($key == 20) {
                                $fechaActo = strtotime($value);
                                if ($fechaActo != $fchActo) {
                                    $this->arrErrores[] = "El Hogar con documento: " . $objRes->fields['numDocumento'] . ", no tiene fecha coincidente del acto administrativo en el sistema ";
                                }
                            }
                            if ($key == 33) {
                                $fchEscritura = strtotime($value);
                                // echo "<br> ***" . $fchActo . " > " . $fchEscritura;
                                if ($fchEscritura < $fchActo) {
                                    // echo "<br>" . $objRes->fields['fchActo'] . " > " . $value;
                                    $this->arrErrores[] = "El Hogar con documento: " . $objRes->fields['numDocumento'] . ", tiene una fecha de escrituración menor a la fecha del acto ";
                                }
                            }
                            if ($key == 38) {
                                $fchCtl = strtotime($value);
                                if ($fchEscritura > $fchCtl) {
                                    $this->arrErrores[] = "El Hogar con documento: " . $objRes->fields['numDocumento'] . ", tiene una fecha consulta CTL menor a la fecha de escrituración";
                                }
                            }

                            if ($key != 39 and $key != 40 and $key != 29 and $value == "") {
                                echo "<br>" . $key . " = > " . $value;
                                $this->arrErrores[] = "El Hogar con documento: " . $objRes->fields['numDocumento'] . ", no contiene informacion en la columna: " . $this->arrTitulos[$key];
                            }
                            if ($key == 21 and $objRes->fields['valAspiraSubsidio'] != $value) {
                                $this->arrErrores[] = "El valor del subsidio del Hogar con documento: " . $objRes->fields['numDocumento'] . " no coincide con el reportado en el sistema";
                            }
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
        $arraContratoLeasing = Array();
        $arraFechaLeasing = Array();

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

            $datos = $this->obtenerDatos(null);

            foreach ($arrArchivo as $key => $value) {

                $this->iniciarVariables($claDesembolso);

                $sql .= "(";

                if ($value[3] != null) {
                    foreach ($datos[$value[3]] as $key2 => $value2) {

                        $claDesembolso->$key2 = $value2;
                    }
                    $sqlLocalidad = "SELECT seqLocalidad FROM t_frm_localidad where txtLocalidad like '%" . explode("-", trim($value[30]))[1] . "%'";
                    $regLocalidad = $aptBd->execute($sqlLocalidad);
                    $claDesembolso->txtNombreVendedor = $value[8];
                    $claDesembolso->numDocumentoVendedor = $value[7];
                    $claDesembolso->txtDireccionInmueble = $value[9] . ' ' . $value[28];
                    $claDesembolso->txtBarrio = ($value[29] != "") ? $value[29] : "Desconocido";
                    $claDesembolso->seqLocalidad = ($value[30] != "") ? $regLocalidad->fields['seqLocalidad'] : "1";
                    //$claDesembolso->txtLocalidad = ($value[30] != "") ? : "Desconocido";
                    $claDesembolso->txtEscritura = $value[32];
                    $claDesembolso->numNotaria = $value[34];
                    $claDesembolso->fchEscritura = $value[33];
                    $claDesembolso->numAvaluo = $value[35];
                    $claDesembolso->valInmueble = $value[35];
                    $claDesembolso->txtMatriculaInmobiliaria = $value[36];
                    $claDesembolso->numValorInmueble = $value[35];
                    $claDesembolso->txtCertificadoTradicion = $value[38];
                    // $claDesembolso->txtCedulaCatastral = $value[37];
                    $claDesembolso->seqTipoDocumento = (strtoupper($value[6]) == 'NIT' ) ? 6 : 1;
                    $claDesembolso->numTelefonoVendedor = $value[25];
                    $claDesembolso->numTelefonoVendedor2 = $value[26];
                    $claDesembolso->txtCorreoVendedor = $value[27];
                    $arraContratoLeasing[$claDesembolso->seqFormulario] = $value[39];
                    $arraFechaLeasing[$claDesembolso->seqFormulario] = $value[40];

                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtEstadoProceso'] = "Desembolso - Legalizado";
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtDireccionInmueble'] = $value[9] . ' ' . $value[28];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtEscrituraPublica'] = "Escrituta publica " . $value[32] . " del " . $value[33] . " Notaria " . $value[34];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numContratoLeasing'] = "Contrato Leasing  " . $value[39] . " del " . $value[40];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtNombreVendedor'] = $value[8];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numDocumentoVendedor'] = $value[7];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtLocalidad'] = ($value[30] != "") ? explode("-", $value[30])[1] : "Desconocido";
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtMatriculaInmobiliaria'] = $value[36];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['valInmueble'] = $value[35];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtElaboro'] = $value[41];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numEscrituraTitulo'] = $value[32];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['fchEscrituraTitulo'] = $value[33];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numNotariaTitulo'] = $value[34];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtCiudadMatricula'] = 'Bogotá';
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numFolioMatricula'] = $value[36];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtZonaMatricula'] = $value[37];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['fchMatricula'] = $value[39];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numOrden'] = $value[22];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtNombreBeneficiarioGiro'] = $value[8];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numDocumentoBeneficiarioGiro'] = $value[7];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtDireccionBeneficiarioGiro'] = $value[24];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numTelefonoGiro'] = $value[25];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['numCuentaGiro'] = $value[17];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtTipoCuentaGiro'] = $value[16];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['seqBancoGiro'] = $value[15];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['valSolicitado'] = $value[21];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtSubdireccion'] = $value[43];
                    $this->objSegNuevo[$claDesembolso->seqFormulario]['txtRevisoSubsecretaria'] = $value[42];

                    $sql .= "$claDesembolso->seqFormulario, $claDesembolso->numEscrituraPublica, $claDesembolso->numCertificadoTradicion, $claDesembolso->numCartaAsignacion, $claDesembolso->numAltoRiesgo, $claDesembolso->numHabitabilidad, $claDesembolso->numBoletinCatastral,"
                            . "$claDesembolso->numLicenciaConstruccion, $claDesembolso->numUltimoPredial, $claDesembolso->numUltimoReciboAgua, $claDesembolso->numUltimoReciboEnergia, $claDesembolso->numOtros, '$claDesembolso->txtNombreVendedor', $claDesembolso->numDocumentoVendedor, "
                            . "'$claDesembolso->txtDireccionInmueble', '$claDesembolso->txtBarrio', $claDesembolso->seqLocalidad, '$claDesembolso->txtEscritura', $claDesembolso->numNotaria, '$claDesembolso->fchEscritura', $claDesembolso->numAvaluo, $claDesembolso->valInmueble, '$claDesembolso->txtMatriculaInmobiliaria',"
                            . "$claDesembolso->numValorInmueble, $claDesembolso->txtEscrituraPublica, '$claDesembolso->txtCertificadoTradicion', $claDesembolso->txtCartaAsignacion, $claDesembolso->txtAltoRiesgo, $claDesembolso->txtHabitabilidad, $claDesembolso->txtBoletinCatastral, "
                            . "$claDesembolso->txtLicenciaConstruccion, $claDesembolso->txtUltimoPredial, $claDesembolso->txtUltimoReciboAgua, $claDesembolso->txtUltimoReciboEnergia, $claDesembolso->txtOtro, $claDesembolso->txtViabilizoJuridico, $claDesembolso->txtViabilizoTecnico, "
                            . "$claDesembolso->bolViabilizoJuridico, $claDesembolso->bolviabilizoTecnico, $claDesembolso->bolPoseedor, $claDesembolso->txtChip, $claDesembolso->numActaEntrega, $claDesembolso->txtActaEntrega, $claDesembolso->numCertificacionVendedor, $claDesembolso->txtCertificacionVendedor, "
                            . "$claDesembolso->numAutorizacionDesembolso, $claDesembolso->txtAutorizacionDesembolso, $claDesembolso->numFotocopiaVendedor, $claDesembolso->txtFotocopiaVendedor, $claDesembolso->seqTipoDocumento, '$claDesembolso->txtCompraVivienda', $claDesembolso->txtNit, $claDesembolso->txtRit, "
                            . "$claDesembolso->txtRut, $claDesembolso->numNit, $claDesembolso->numRit, $claDesembolso->numRut, '$claDesembolso->txtTipoPredio', $claDesembolso->numTelefonoVendedor, '$claDesembolso->txtCedulaCatastral', $claDesembolso->numAreaConstruida, $claDesembolso->numAreaLote, '$claDesembolso->txtTipoDocumentos', $claDesembolso->numEstrato, "
                            . "'$claDesembolso->txtCiudad', $claDesembolso->fchCreacionBusquedaOferta, $claDesembolso->fchActualizacionBusquedaOferta, $claDesembolso->fchCreacionEscrituracion, $claDesembolso->fchActualizacionEscrituracion, $claDesembolso->numTelefonoVendedor2, '$claDesembolso->txtPropiedad', "
                            . "$claDesembolso->fchSentencia, $claDesembolso->numJuzgado, $claDesembolso->txtCiudadSentencia, $claDesembolso->numResolucion, $claDesembolso->fchResolucion, $claDesembolso->txtEntidad, $claDesembolso->txtCiudadResolucion, $claDesembolso->numContratoArrendamiento, $claDesembolso->txtContratoArrendamiento, "
                            . "$claDesembolso->numAperturaCAP, $claDesembolso->txtAperturaCAP, $claDesembolso->numCedulaArrendador, $claDesembolso->txtCedulaArrendador, $claDesembolso->numCuentaArrendador, $claDesembolso->txtCuentaArrendador, $claDesembolso->numRetiroRecursos,"
                            . "$claDesembolso->txtRetiroRecursos, $claDesembolso->numServiciosPublicos, '$claDesembolso->txtServiciosPublicos', '$claDesembolso->txtCorreoVendedor', $claDesembolso->seqCiudad, $claDesembolso->seqAplicacionSubsidio, $claDesembolso->seqProyectosSoluciones, $claDesembolso->seqFrmulario_Des";
                }
                $sql .= "),";
            }
            $sql = substr_replace($sql, ';', -1, 1);
            // echo "<br>" . $sql; die();
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

                $sqlEsc .= "(select 
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

                //echo "<br>" . $sqlEsc;
                $aptBd->execute($sqlEsc);

                $aptBd->CommitTrans();
                if (empty($this->arrErrores)) {
                    foreach ($arraContratoLeasing as $key => $value) {
                        try {
                            if ($value != "") {
                                $fchLeg = ($arraFechaLeasing[$key] == '') ? 'NULL' : $arraFechaLeasing[$key];
                                $updateEsc = "update t_des_escrituracion set  numContratoLeasing= '" . $value . "', fchContratoLeasing = '" . $fchLeg . "' WHERE seqFormulario = " . $key . ";";
                                $aptBd->execute($updateEsc);
                            }
                        } catch (Exception $exEsc) {
                            $this->arrErrores[] = $exEsc->getMessage();
                            $aptBd->RollBackTrans();
                            $this->mostrarErrores();
                        }
                    }
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

            $sqlSolicitud = "INSERT INTO t_des_solicitud(
                numRegistroPresupuestal1, fchRegistroPresupuestal1, numRegistroPresupuestal2, fchRegistroPresupuestal2, valSolicitado, 
                bolDocumentoBeneficiario, txtDocumentoBeneficiario, bolDocumentoVendedor, txtDocumentoVendedor, bolCertificacionBancaria, 
                txtCertificacionBancaria, bolCartaAsignacion, txtCartaAsignacion, bolAutorizacion, txtAutorizacion, txtSubsecretaria, 
                bolSubsecretariaEncargado, txtSubdireccion, bolSubdireccionEncargado, txtRevisoSubsecretaria, txtElaboroSubsecretaria, numRadiacion, 
                fchRadicacion, numOrden,fchOrden,valOrden, seqDesembolso, txtConsecutivo, numProyectoInversion, txtNombreBeneficiarioGiro,
                numDocumentoBeneficiarioGiro, txtDireccionBeneficiarioGiro, numTelefonoGiro, numCuentaGiro, txtTipoCuentaGiro, seqBancoGiro, 
                fchCreacion, fchActualizacion, bolRut, txtRut, bolNit, txtNit, bolCedulaRepresentante, txtCedulaRepresentante, bolCamaraComercio,
                txtCamaraComercio, bolGiroTercero, txtGiroTercero, bolBancoArrendador, txtBancoArrendador, bolActaEntregaFisica, txtActaEntregaFisica, 
                bolActaLiquidacion, txtActaLiquidacion, txtCorreoGiro, bolCertificacionManejoRecursos, txtCertificacionManejoRecursos, bolSuperintendencia,  txtSuperIntendencia, bolRutBanco, txtRutBanco)
                VALUES";

            $datos = $this->obtenerDatos(null);
            //  var_dump($arrArchivo);
            foreach ($arrArchivo as $key => $value) {
                if ($value[3] != "") {
                    $this->arrDesembolso[] = $datos[$value[3]]['seqDesembolso'];
                    $this->arrayLeasing[$datos[$value[3]]['seqDesembolso']] = $value[31];
                    $fchMatricula = strtotime($value[38]);
                    $bolSubsidioSDHT = 1;
                    $bolSubsidioFonvivienda = 1;
                    $banco = str_replace("DE ", "", strtoupper($value[15]));
                    $banco = str_replace("S.A.", "", strtoupper($banco));
                    $banco = str_replace("BANCO BBVA COLOMBIA", "BANCO BBVA", strtoupper($banco));
                    $sqlBanco = "SELECT seqBanco FROM t_frm_banco where upper(txtbanco) like '%" . trim($banco) . "%'";
                    $objRes = $aptBd->execute($sqlBanco);
                    $txtValor = 1;

                    while ($objRes->fields) {
                        $txtValor = $objRes->fields['seqBanco'];
                        $objRes->MoveNext();
                    }
                    $sql .= "(" . $datos[$value[3]]['seqDesembolso'] . ", $value[32],'$value[33]',$value[34], $value[32],'$value[33]',$value[34], 0, '$value[37]', 'Bogotá', '$value[38]', "
                            . "$bolSubsidioSDHT, $bolSubsidioFonvivienda, 0,0, '$value[43]',NOW(), NOW(), 'Bogotá', 'Bogotá', '$value[41]' ),";

                    $sqlSolicitud .= "(NULL, NULL, NULL, NULL, $value[21], 0, NULL, NULL, NULL, NULL,NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$value[43]', "
                            . "NULL, '$value[42]', '$value[41]', NULL, 'NULL', '$value[22]', '$value[23]', $value[21], " . $datos[$value[3]]['seqDesembolso'] . ", "
                            . "'$value[22]', NULL, '$value[12]', $value[14], '$value[24]', $value[25], '$value[17]', '$value[16]', " . $txtValor . ", '$this->fecha', NOW(), NULL,
                             NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,'$value[27]', NULL, NULL, NULL,  NULL, NULL, NULL),";
                }
            }
            $sql = substr_replace($sql, ';', -1, 1);
            $sqlSolicitud = substr_replace($sqlSolicitud, ';', -1, 1);
            // echo "<p>" . $sql . "</p>";
            $aptBd->execute($sql);
            // echo "<p>" . $sqlSolicitud . "</p>";
            $aptBd->execute($sqlSolicitud);
            $aptBd->CommitTrans();
            if (empty($this->arrErrores)) {
                $this->salvarAdjuntos($arrArchivo);
            } else {
                $this->mostrarErrores();
            }
        } catch (Exception $exception) {
            $this->arrErrores[] = $exception->getMessage();
            $aptBd->RollBackTrans();
            $this->mostrarErrores();
        }
    }

    public function salvarAdjuntos($arrArchivo) {

        global $aptBd;

        $desembolso = implode(",", $this->arrDesembolso);
        /*         * *************************  COMPRAVENTA **************************************** */
        $arrayObs[0]['texto'] = 'PROPIETARIOS SON BENEFICIARIOS DEL SDV.';
        $arrayObs[0]['tipo'] = 4;
        $arrayObs[1]['texto'] = 'NOMBRE Y C&Eacute;DULA DE LOS PROPIETARIOS';
        $arrayObs[1]['tipo'] = 4;
        $arrayObs[2]['texto'] = 'COMPRAVENTA REALIZADA CON SDV';
        $arrayObs[2]['tipo'] = 4;
        $arrayObs[3]['texto'] = 'SUBSIDIO SDHT VIGENTE Y ESTADO MARCADO PARA PAGO EN SISTEMA DE INFORMACION DEL PROGRAMA MI CASA YA.';
        $arrayObs[3]['tipo'] = 4;
        $arrayObs[4]['texto'] = 'HOGAR REACIONADO EN REPORTE PARA PAGO GENERADO POR SISTEMA DE INFORMACION DEL PROGRAMA MI CASA YA . ';
        $arrayObs[4]['tipo'] = 4;
        $arrayObs[5]['texto'] = 'ESCRITURA P&Uacute;BLICA';
        $arrayObs[5]['tipo'] = 1;
        $arrayObs[6]['texto'] = 'CONSULTA PAGINA VUR FOLIO DE MATRÍCULA INMOBILIARIA.';
        $arrayObs[6]['tipo'] = 1;
        $arrayObs[7]['texto'] = 'UNA VEZ VERIFICADA LA INFORMACION REPORTADA POR EL SISTEMA DE INFORMACION DEL PROGRAMA '
                . 'MI CASA YA Y LOS DOCUMENTOS ALLEGADOS POR EL OFERENTE Y/O CONSTRUCTOR Y CONSULTADA LA VENTANILLA UNICA DE REGISTRO'
                . 'VUR SE PUEDE ESTABLECER QUE SE DA CUMPLIMIENTO A LOS REQUISITOS EXIGIDOS POR LA RESOLUCION 654 DE 2018. ';
        $arrayObs[7]['tipo'] = 2;

        /*         * ************************* FIN COMPRAVENTA **************************************** */

        /*         * *************************  LEASING **************************************** */

        $arrayObsLea[0]['texto'] = 'RELACIÓN DE LOS INTEGRANTES DEL HOGAR EN LA ESCRITURA.';
        $arrayObsLea[0]['tipo'] = 4;
        $arrayObsLea[1]['texto'] = 'NUMERO Y FECHA DEL CONTRATO DE LEASING HABITACIONAL';
        $arrayObsLea[1]['tipo'] = 4;
        $arrayObsLea[2]['texto'] = 'BENEFICIRIO DEL APORTE SEA EL LOCATARIO DEL CONTRATO DE LEASING';
        $arrayObsLea[2]['tipo'] = 4;
        $arrayObsLea[3]['texto'] = 'PROPIEDAD DE LA ENTIDAD FINANCIERA OTORGANTE DEL LEASING EN CTL.';
        $arrayObsLea[3]['tipo'] = 4;
        $arrayObsLea[4]['texto'] = 'SUBSIDIO SDHT VIGENTE Y ESTADO MARCADO PARA PAGO EN SISTEMA DE INFORMACION DEL PROGRAMA MI CASA YA. ';
        $arrayObsLea[4]['tipo'] = 4;
        $arrayObsLea[5]['texto'] = 'HOGAR REACIONADO EN REPORTE PARA PAGO GENERADO POR SISTEMA DE INFORMACION DEL PROGRAMA MI CASA YA';
        $arrayObsLea[5]['tipo'] = 4;
        $arrayObsLea[6]['texto'] = 'ESCRITURA P&Uacute;BLICA.';
        $arrayObsLea[6]['tipo'] = 1;
        $arrayObsLea[7]['texto'] = 'CONSULTA PAGINA VUR FOLIO DE MATRÍCULA INMOBILIARIA';
        $arrayObsLea[7]['tipo'] = 1;
        $arrayObsLea[8]['texto'] = 'CONTRATO DE LEASING HABITACIONAL';
        $arrayObsLea[8]['tipo'] = 1;
        $arrayObsLea[9]['texto'] = 'UNA VEZ VERIFICADA LA INFORMACION REPORTADA POR EL SISTEMA DE INFORMACION DEL PROGRAMA MI CASA YA Y LOS DOCUMENTOS '
                . 'ALLEGADOS POR EL OFERENTE Y/O CONSTRUCTOR Y CONSULTADA LA VENTANILLA UNICA DE REGISTRO VUR SE PUEDE ESTABLECER QUE SE DA CUMPLIMIENTO'
                . ' A LOS REQUISITOS EXIGIDOS POR LA RESOLUCION 654 DE 2018. ';
        $arrayObsLea[9]['tipo'] = 2;

        /*         * ************************* FIN LEASING **************************************** */
        $aptBd->BeginTrans();
        try {
            $seqAdjuntos = "SELECT distinct(seqEstudioTitulos) As seqEstudioTitulos, seqDesembolso FROM t_des_estudio_titulos where seqDesembolso in(" . $desembolso . ");";
            $objRes = $aptBd->execute($seqAdjuntos);

            $sql = "INSERT INTO t_des_adjuntos_titulos (seqTipoAdjunto, seqEstudioTitulos, txtAdjunto) VALUES";
            $array = Array();
            while ($objRes->fields) {
                $array = ($this->arrayLeasing[$objRes->fields['seqDesembolso']] == 'NO') ? $arrayObs : $arrayObsLea;
                foreach ($array as $key => $value) {
                    // echo "<br>" . $value['texto'];
                    $sql .= "(" . $value['tipo'] . "," . $objRes->fields['seqEstudioTitulos'] . ",'" . $value['texto'] . "' ),";
                }
                $objRes->MoveNext();
            }
            $sql = substr_replace($sql, ';', -1, 1);

            $aptBd->execute($sql);
            $aptBd->CommitTrans();
            $this->modificarEstado($arrArchivo);
        } catch (Exception $exception) {
            $this->arrErrores[] = $exception->getMessage();
            $aptBd->RollBackTrans();
            $this->mostrarErrores();
        }
    }

    public function modificarEstado($arrArchivo) {
        global $aptBd;
        $formularios = implode(",", $this->arrFormularios);
        $aptBd->BeginTrans();
        try {
            $sql = "update t_frm_formulario set seqEstadoProceso = 40 where seqFormulario in (" . $formularios . ")";
            $objRes = $aptBd->execute($sql);
            $sqlDelFlujo = "delete FROM  t_des_flujo where seqFormulario in(" . $formularios . ")";
            $aptBd->execute($sqlDelFlujo);
            $sqlFlujo = "INSERT INTO t_des_flujo (seqFormulario,txtFlujo) VALUES";
            foreach ($this->arrFormularios as $key => $value) {
                $sqlFlujo .= "(" . $value . ", 'postulacionIndividual'),";
            }
            $sqlFlujo = substr_replace($sqlFlujo, ';', -1, 1);
            $aptBd->execute($sqlFlujo);
            $aptBd->CommitTrans();
        } catch (Exception $exception) {
            $this->arrErrores[] = $exception->getMessage();
            $aptBd->RollBackTrans();
            $this->mostrarErrores();
        }
    }

    public function obtenerDatos($formularios) {

        if ($formularios == null) {
            $formularios = implode(",", $this->arrFormularios);
        }

        global $aptBd;
        $sql = "SELECT 
                    frm.seqFormulario,
                    numDocumento,
                    CONCAT_WS(' ', txtNombre1, txtNombre2,  txtApellido1, txtApellido2) AS nombre,
                    frm.seqEstadoProceso,
                    frm.seqTipoEsquema,
                    frm.seqModalidad,
                    frm.valAspiraSubsidio,
                    hva.fchActo,
                    des.seqDesembolso,
                    des.txtEscritura,
                    des.numNotaria,
                    des.fchEscritura,
                    esc.seqEscrituracion,
                    sol.seqSolicitud,
                    est.seqEstudioTitulos, 
                    hog.seqParentesco
                FROM
                    t_frm_formulario frm
                        LEFT JOIN
                    t_frm_hogar hog USING (seqFormulario)
                        LEFT JOIN
                    t_ciu_ciudadano USING (seqCiudadano)
                        LEFT JOIN
                    t_aad_formulario_acto fac USING (seqFormulario)
                        LEFT JOIN
                    t_aad_hogares_vinculados hva USING (seqFormularioActo)
                    LEFT JOIN
                    t_des_desembolso des USING (seqFormulario)
                    LEFT JOIN 
                    t_des_escrituracion esc USING(seqDesembolso)
                    LEFT JOIN
                t_des_solicitud sol USING (seqDesembolso)
                    LEFT JOIN 
                    t_des_estudio_titulos est USING(seqDesembolso)
                WHERE
                    frm.seqFormulario IN(" . $formularios . ")
                        AND hva.seqTipoActo = 1 ";
        $datos = Array();
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $datos[$objRes->fields['numDocumento']] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function listaInformes() {

        if ($formularios == null) {
            $formularios = implode(",", $this->arrFormularios);
        }

        global $aptBd;
        $sql = "SELECT 
                    count(numDocumento) as Cantidad,    
                    group_concat(seqFormulario separator ',') as formularios ,
                     sol.fchCreacion, 
                     sol.txtConsecutivo,
                     sol.fchOrden, 
                     SUM(frm.valAspiraSubsidio) as valor
                 FROM
                     t_frm_formulario frm
                         LEFT JOIN
                     t_frm_hogar hog  USING (seqFormulario)
                         LEFT JOIN
                     t_ciu_ciudadano USING (seqCiudadano)
                         LEFT JOIN
                     t_aad_formulario_acto fac USING (seqFormulario)
                         LEFT JOIN
                     t_aad_hogares_vinculados hva USING (seqFormularioActo)
                         LEFT JOIN
                     t_des_desembolso des USING (seqFormulario)
                     inner JOIN
                     t_des_solicitud sol USING (seqDesembolso)
                 WHERE
                   frm.seqModalidad in(12) and frm.seqTipoEsquema in(16, 17) and hog.seqParentesco = 1 and hva.seqTipoActo = 1
                   group by  sol.fchCreacion, sol.txtConsecutivo ORDER BY sol.fchCreacion desc, sol.txtConsecutivo asc";
        $datos = Array();
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function salvarSeguimiento($seqFormulario, $txtCambios, $texto) {
        global $aptBd;
        $datos = $this->obtenerDatos($seqFormulario);
        $nombre = "";
        $documento = 0;
        foreach ($datos as $key => $value) {
            if ($datos[$key]['seqParentesco'] == 1) {
                $nombre = $datos[$key]['nombre'];
                $documento = $datos[$key]['numDocumento'];
            }
        }
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
                   " . $seqFormulario . ",
                   '" . date("Y-m-d H:i:s") . "',
                   " . $_SESSION['seqUsuario'] . ",
                   '" . $texto . "',
                   '" . utf8_encode($txtCambios) . "',
                   " . $documento . ",
                   '" . $nombre . "',
                  109
                 )
             ";
        try {
            $aptBd->execute($sql);
            return true;
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido registrar el seguimiento, contacte al administrador del sistema";
            $this->arrErrores[] = $objError->getMessage();
//                $this->arrErrores[] = $sql;
            return false;
        }
    }

    public function datosDetalles($fecha, $txtConsecutivo) {

        global $aptBd;
        $sql = "SELECT 
                frm.seqFormulario as 'ID HOGAR',
               # des.seqDesembolso,
                numDocumento as 'DOCUMENTO PPAL',
                CONCAT_WS(' ',txtNombre1, txtNombre2) AS NOMBRES,
                CONCAT_WS(' ', txtApellido1, txtApellido2) AS APELLIDOS,
                esc.numDocumentoVendedor as 'N° DOCUMENTO VENDEDOR',
                esc.txtNombreVendedor as 'NOMBRE VENDEDOR',
                sol.txtNombreBeneficiarioGiro as 'TITULAR CUENTA',	
                sBan.txtBanco as 'ENTIDAD FINANCIERA',    
                concat('N° ', sol.numCuentaGiro ) AS 'N° DE CUENTA',
                hva.numActo as 'No ACTO ADMON',
                hva.fchActo as 'FECHA ACTO ADMON',
                sol.valSolicitado as 'VALOR SUBSIDIO', 
                esc.txtDireccionInmueble as 'DIRECCIÓN INMUEBLE',
                loc.txtLocalidad As LOCALIDAD,
                esc.txtEscritura as 'N° DE ESCRITURA',
                esc.fchEscritura as 'FECHA ESCRITURA',
                esc.numNotaria as 'NOTARIA',
                esc.txtMatriculaInmobiliaria as 'MATRÍCULA INMOBILIARIA',
                sol.txtElaboroSubsecretaria as 'ELABORO', 
                sol.txtRevisoSubsecretaria as 'REVISO',
                sol.txtSubdireccion as 'APROBO'
            FROM
                t_frm_formulario frm
                        LEFT JOIN
                t_frm_hogar hog USING (seqFormulario)
                        LEFT JOIN
                t_ciu_ciudadano USING (seqCiudadano)
                        LEFT JOIN
                t_aad_formulario_acto fac USING (seqFormulario)
                        LEFT JOIN
                t_aad_hogares_vinculados hva USING (seqFormularioActo)
                LEFT JOIN
                t_des_desembolso des USING (seqFormulario)
                LEFT JOIN
                t_des_escrituracion esc USING (seqDesembolso)
                LEFT JOIN
                t_des_solicitud sol USING (seqDesembolso)
                left join 
                t_ciu_tipo_documento tdo on(des.seqTipoDocumento = tdo.seqTipoDocumento)
                left join 
                t_frm_banco sBan on(sol.seqBancoGiro = sBan.seqBanco)
                left join t_frm_localidad loc ON(esc.seqLocalidad = loc.seqLocalidad)
                WHERE
                 frm.seqModalidad in(12) and frm.seqTipoEsquema in(16, 17) and hog.seqParentesco = 1 and hva.seqTipoActo = 1
                 AND sol.fchCreacion like '" . $fecha . "' and sol.txtConsecutivo = '$txtConsecutivo' ";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
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

    public function eliminarCargue($seqFormulario) {

        $datos = $this->obtenerDatos(implode(",", $seqFormulario));
        $arrDesembolso = Array();
        $arrEscrituracion = Array();
        $arrSolucion = Array();
        $arrEstudios = Array();

        foreach ($datos as $key => $value) {

            $arrDesembolso[] = $datos[$key]['seqDesembolso'];
            $arrEscrituracion[] = $datos[$key]['seqEscrituracion'];
            $arrSolucion[] = $datos[$key]['seqSolicitud'];
            $arrEstudios[] = $datos[$key]['seqEstudioTitulos'];
        }
        $sqlSol = "DELETE FROM t_des_solicitud WHERE seqSolicitud IN(" . implode(",", $arrSolucion) . ")";
        $sqlAdj = "DELETE FROM t_des_adjuntos_titulos WHERE seqEstudioTitulos IN(" . implode(",", $arrEstudios) . ")";
        $sqlEst = "DELETE FROM t_des_estudio_titulos WHERE seqEstudioTitulos IN(" . implode(",", $arrEstudios) . ")";
        $sqlEsc = "DELETE FROM t_des_escrituracion WHERE seqEscrituracion IN(" . implode(",", $arrEscrituracion) . ")";
        $sqlDes = "DELETE FROM t_des_desembolso WHERE seqDesembolso IN(" . implode(",", $arrDesembolso) . ")";
        $sqlForms = "UPDATE t_frm_formulario SET seqEstadoProceso = 15 WHERE seqFormulario IN(" . implode(",", $seqFormulario) . ") ";
        $solicitud = $this->ejecutarConsulta($sqlSol);
        if ($solicitud) {
            $adjuntos = $this->ejecutarConsulta($sqlAdj);
            if ($adjuntos) {
                $estudios = $this->ejecutarConsulta($sqlEst);
                if ($estudios) {
                    $escritura = $this->ejecutarConsulta($sqlEsc);
                    if ($escritura) {
                        $desembolso = $this->ejecutarConsulta($sqlDes);
                        if ($desembolso) {
                            $Formulario = $this->ejecutarConsulta($sqlForms);
                            if ($Formulario) {

                                foreach ($seqFormulario as $key => $value) {
                                    $texto = "POR SOL. PARA ADELANTAR CORRECCION CARGUE MASIVO LEGALIZACION SUBSIDIOS MCY. MENSAJE SDRPL RESP. LEGALIZACION MCY";
                                    $this->salvarSeguimiento($value, '', $texto);
                                }
                                if (empty($this->arrErrores)) {
                                    echo " <div class='alert alert-success'>Reporte Eliminado con éxito!!!</div>";
                                } else {
                                    $this->mostrarErrores();
                                }
                            } else {
                                $this->mostrarErrores();
                            }
                        } else {
                            $this->mostrarErrores();
                        }
                    } else {
                        $this->mostrarErrores();
                    }
                } else {
                    $this->mostrarErrores();
                }
            } else {
                $this->mostrarErrores();
            }
        } else {
            $this->mostrarErrores
            ();
        }
    }

    public function ejecutarConsulta($sql) {
        global $aptBd;
        try {
            $aptBd->execute($sql);
            return true;
        } catch (Exception $objError) {
            $this->arrErrores[] = "Error al eliminar registro";
            $this->arrErrores[] = $objError->getMessage();
//                $this->arrErrores[] = $sql;
            return false;
        }
    }

    public function iniciarVariables(
    $claDesembolso) {

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
        $claDesembolso->txtTipoDocumentos = 'empresa';
        $claDesembolso->numEstrato = 2;
        $claDesembolso->txtCiudad = "Bogotá";
        $claDesembolso->fchCreacionBusquedaOferta = 'NOW()';
        $claDesembolso->fchActualizacionBusquedaOferta = 'NOW()';
        $claDesembolso->fchCreacionEscrituracion = 'NOW()';
        $claDesembolso->fchActualizacionEscrituracion = 'NOW()';
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
        $claDesembolso->seqAplicacionSubsidio = 1;
        $claDesembolso->seqProyectosSoluciones = 37;
        $claDesembolso->seqFrmulario_Des = 'NULL';
    }

}

?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      