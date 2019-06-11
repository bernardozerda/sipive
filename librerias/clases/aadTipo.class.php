<?php

/**
 * CLASE PARA LOS TIPOS DE ACTOS ADMINISTRATIVOS
 * OBTIENE SUS CARACTERISTICAS Y LOS TIPOS DE DATOS
 * DE CADA CARACTERISTICA DE ACUERDO AL TIPO DE ACTO
 * @author Bernardo Zerda Rodriguez
 * @modified Jaison Josue Ospina
 * @modified Bernardo Zerda Rodriguez
 * @version 2.0 Mayo de 2016
 * @version 2.1 Desconocido
 * @version 2.2 Septiembre de 2017
 * */
class aadTipo {

    public $seqTipoActo;
    public $txtTipoActo;
    public $arrCaracteristicas;
    public $arrFormatoArchivo;
    public $arrErrores;
    public $arrExtensiones;
    public $txtCreador;

    public function __construct() {
        $this->seqTipoActo = 0;
        $this->txtTipoActo = "";
        $this->arrCaracteristicas = array();
        $this->arrFormatoArchivo = array();
        $this->arrErrores = array();
        $this->arrExtensiones = array("txt", "xls", "xlsx");
        $this->txtCreador = "SiPIVE - SDHT";
    }

    /**
     * CARGA TODAS LAS CARACTERISTICAS DE UN ACTO ADMINSITRATIVO
     * @global type $aptBd
     * @param type $seqTipoActo
     * @return \TipoActoAdministrativo
     */
    public function cargarTipoActo($seqTipoActo = 0) {
        global $aptBd;
        $arrTipoActo = array();
        try {

            // CARGANDO LAS CARACTERISTICAS DE LA BASES DE DATOS
            $txtCondicion = ($seqTipoActo != 0) ? "WHERE tac.seqTipoActo = " . $seqTipoActo : "";
            $sql = "
                SELECT 
                   tac.seqTipoActo,
                   tac.txtNombreTipoActo,
                   cac.seqCaracteristica,
                   cac.txtNombreCaracteristica,
                   cac.txtTipoDato
                FROM T_AAD_TIPO_ACTO tac
                INNER JOIN T_AAD_CARACTERISTICA_ACTO cac ON cac.seqTipoActo = tac.seqTipoActo
                $txtCondicion
                -- ORDER BY tac.txtNombreTipoActo
            ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $seqTipoActo = $objRes->fields['seqTipoActo'];
                $seqCaracteristica = $objRes->fields['seqCaracteristica'];

                if (!isset($arrTipoActo[$seqTipoActo])) {
                    $objTipoActo = new aadTipo();
                }

                $objTipoActo->seqTipoActo = $seqTipoActo;
                $objTipoActo->txtTipoActo = $objRes->fields['txtNombreTipoActo'];

                $objTipoActo->arrCaracteristicas[$seqCaracteristica]['txtNombre'] = $objRes->fields['txtNombreCaracteristica'];
                $objTipoActo->arrCaracteristicas[$seqCaracteristica]['txtTipo'] = $objRes->fields['txtTipoDato'];

                // CARGANDO LOS FORMATOS DE LOS ARCHIVOS
                if (empty($objTipoActo->arrFormatoArchivo)) {

                    switch ($seqTipoActo) {
                        case 1: // Resolucion de asignacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Fecha de Vigencia";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "Fecha en la cual vencerá el subsidio de no ser aplicado (aaaa/mm/dd)";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Resolución Relacionada";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "Número de la resolución de referencia\nSi la resolución es de vinculación, use este campo para colocar la resolución de asignacion a la que se refiere";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Fecha de Resolución Relacionada";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[3]['ayuda'] = "Fecha de la resolución asociada.\nFormato aaaa-mm-dd\nSi la resolución es de vinculación, use este campo para colocar la resolución de asignacion a la que se refiere";
                            break;
                        case 2: // Resolucion Modificatoria
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Campo";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Primer Nombre";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Segundo Nombre";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Primer Apellido";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Segundo Apellido";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Documento";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Tipo de Solucion";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Valor del Subsidio";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Matricula Inmobiliaria";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "CHIP";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Fecha de Vigencia";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Proyecto";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Unidad Habitacional";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Valor Donacion";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Valor Complementario";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Soporte Donacion";
                            $objTipoActo->arrFormatoArchivo[1]['rango'][] = "Entidad Donacion";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Incorrecto";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "Éste es el valor actual de la base de datos, es el valor que se quiere corregir";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Correcto";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[3]['ayuda'] = "Éste es el valor que quiere que quede en la base de datos";
                            $objTipoActo->arrFormatoArchivo[4]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[4]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[4]['ayuda'] = "El numero de la resolución que va a ser modificada con éste acto adminsitrativo";
                            $objTipoActo->arrFormatoArchivo[5]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[5]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[5]['ayuda'] = "La fecha de la resolución que va a ser modificada con éste acto adminsitrativo.\nFormato aaaa-mm-dd";
                            break;
                        case 3: // Resolucion de inhabilitados
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Formulario";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Número de identificación en la base de datos del formulario";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "Número del documento del miembro del hogar (tenga o no inhabilidad), cargue todo el hogar";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Nombre";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "Nombre que corresponde al miembro de hogar de la columna número";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Fuente";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[3]['ayuda'] = "Nombre de la fuente, Fonvivienda, SDHT, etc.";
                            $objTipoActo->arrFormatoArchivo[4]['nombre'] = "Causa";
                            $objTipoActo->arrFormatoArchivo[4]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[4]['ayuda'] = "Texto claro que emite la fuente, ejemplo: propietario de inmueble en el territorio nacional";
                            $objTipoActo->arrFormatoArchivo[5]['nombre'] = "Detalle";
                            $objTipoActo->arrFormatoArchivo[5]['tipo'] = "texto";
                            $objTipoActo->arrFormatoArchivo[5]['ayuda'] = "Detalle de la fuente, por ejemplo: Matrícula inmobiliaria XXXXYYY8987";
                            break;
                        case 4: // Recurso de Reposicion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "El número de la resolución sobre la cual se ha puesto un recurso de reposición";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "La fecha de la resolución sobre la cual se ha puesto un recurso de reposición.\nFormato aaaa-mm-dd";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Estado";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "texto";

                            $arrEstados = array(52, 41, 46, 8, 54, 7, 21);
                            foreach (array_keys(estadosProceso(0, 5)) as $seqEstadoProceso) {
                                $arrEstados[] = $seqEstadoProceso;
                            }

                            foreach ($arrEstados as $seqEstadoProceso) {
                                $objTipoActo->arrFormatoArchivo[3]['rango'][] = array_shift(estadosProceso($seqEstadoProceso));
                            }

                            break;
                        case 5: // Resolucion de No Asignado
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            break;
                        case 6: // Resolucion de Renuncia
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "El número de la resolución a la que renuncia";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "La fecha de la resolución a la que renuncia.\nFormato aaaa-mm-dd";
                            break;
                        case 7: // Notificacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Fecha de notificacion";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "Fecha en la que se notificó el hogar.\nFormato aaaa-mm-dd";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "El número de la resolución que esta notificando";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[3]['ayuda'] = "La fecha de la resolución que esta notificando.\nFormato aaaa-mm-dd";
                            break;
                        case 8: // Resolucion de Indexacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "El número de la resolución que indexa.\nNo indexa hogares asociados a unidades habitacionales.\nFormato aaaa-mm-dd";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "La fecha de la resolución que tiene el valor original";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Indexacion";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[3]['ayuda'] = "Valor de la indexación sin decimales";
                            break;
                        case 9: // Resolucion de Perdida
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "El número de la resolución de asignación que otorgó el beneficio";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "La fecha de la resolución de asignación que otorgó el beneficio.\nFormato aaaa-mm-dd";
                            break;
                        case 10: // Resolucion de Revocatoria
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "El número de la resolución de asignación que otorgó el beneficio";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "El fecha de la resolución de asignación que otorgó el beneficio.\nFormato aaaa-mm-dd";
                            break;
                        case 11: // Resolucion de Exclusion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Resolución";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "El número de la resolución de asignación que otorgó el beneficio";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Fecha";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "El fecha de la resolución de asignación que otorgó el beneficio.\nFormato aaaa-mm-dd";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Estado";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "texto";
                            $arrEstados = array(63);
                            foreach ($arrEstados as $seqEstadoProceso) {
                                $objTipoActo->arrFormatoArchivo[3]['rango'][] = array_shift(estadosProceso($seqEstadoProceso));
                            }
                            $objTipoActo->arrFormatoArchivo[4]['nombre'] = "Comentario";
                            $objTipoActo->arrFormatoArchivo[4]['tipo'] = "texto";
                            break;
                        case 12: // Resolucion de asignacion
                            $objTipoActo->arrFormatoArchivo[0]['nombre'] = "Documento";
                            $objTipoActo->arrFormatoArchivo[0]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[0]['ayuda'] = "Documento del postulante principal";
                            $objTipoActo->arrFormatoArchivo[1]['nombre'] = "Fecha de Vigencia";
                            $objTipoActo->arrFormatoArchivo[1]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[1]['ayuda'] = "Fecha en la cual vencerá el subsidio de no ser aplicado (aaaa/mm/dd)";
                            $objTipoActo->arrFormatoArchivo[2]['nombre'] = "Resolución Relacionada";
                            $objTipoActo->arrFormatoArchivo[2]['tipo'] = "numero";
                            $objTipoActo->arrFormatoArchivo[2]['ayuda'] = "Número de la resolución de referencia\nSi la resolución es de vinculación, use este campo para colocar la resolución de asignacion a la que se refiere";
                            $objTipoActo->arrFormatoArchivo[3]['nombre'] = "Fecha de Resolución Relacionada";
                            $objTipoActo->arrFormatoArchivo[3]['tipo'] = "fecha";
                            $objTipoActo->arrFormatoArchivo[3]['ayuda'] = "Fecha de la resolución asociada.\nFormato aaaa-mm-dd\nSi la resolución es de vinculación, use este campo para colocar la resolución de asignacion a la que se refiere";
                            break;
                        default: // Otros tipos de actos
                            $this->arrErrores[] = "Tipo de acto administrativo inexistente " . $seqTipoActo;
                            break;
                    }
                }

                $arrTipoActo[$seqTipoActo] = $objTipoActo;

                $objRes->MoveNext();
            }
        } catch (Exeption $objError) {
            $this->arrErrores[] = "No se pudo cargar los tipos de actos administrativos";
        }

        return $arrTipoActo;
    }

    /**
     * OBTIENE LOS DATOS CARGADOS EN EL ARCHIVO
     * SEA UN EXCEL O UN ARCHIVO PLANO
     * @return array
     */
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
                    $numColumnas = count($this->arrFormatoArchivo) - 1;

                    // obtiene los datos del rango obtenido
                    for ($numFila = 1; $numFila < $numFilas; $numFila++) {
                        for ($numColumna = 0; $numColumna <= $numColumnas; $numColumna++) {
                            $numFilaArreglo = $numFila - 1;
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            if ($this->arrFormatoArchivo[$numColumna]['tipo'] == "fecha" and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
                                $claFecha = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha->format("Y-m-d");
                            }
                        }
                    }

                    // si no tiene la celda de clave llena no carga
                    if ($objPHPExcel->getProperties()->getCreator() == $this->txtCreador) {

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
                    } else {
                        $this->arrErrores[] = "No se va a cargar el archivo porque no corresponde a la plantilla que se obtiene de la aplicación";
                    }
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

    /**
     * Valida que los titulos del archivo
     * esten completos y en el orden correcto
     * de acuerdo con lo parametrizado en la
     * clase en $this->arrFormatoArchivo
     * @param $arrTitulos
     * @return void
     */
    public function validarTitulos($arrTitulos) {
        foreach ($this->arrFormatoArchivo as $numColumna => $arrCelda) {
            if (mb_strtolower($arrTitulos[$numColumna]) != mb_strtolower($arrCelda['nombre'])) {
                $this->arrErrores[] = "La columna " . $arrCelda['nombre'] . " no se encuentra o no esta en el lugar correcto";
            }
        }
    }

    /**
     * Valida las lineas del archivo
     * para que no tenga letras en donde
     * deben haber numeros.
     * No valida las reglas de negocio
     * @param $arrArchivo
     * @return void
     */
    public function validarDatos($arrArchivo) {
        foreach ($this->arrFormatoArchivo as $numColumna => $arrCelda) {
            for ($numFila = 1; $numFila < count($arrArchivo); $numFila++) {
                if ($arrArchivo[$numFila][$numColumna] != "") {
                    $bolError = false;
                    switch ($arrCelda['tipo']) {
                        case "numero":
                            $bolError = ( is_numeric($arrArchivo[$numFila][$numColumna]) ) ? false : true;
                            break;
                        case "fecha":
                            $bolError = ( esFechaValida($arrArchivo[$numFila][$numColumna]) ) ? false : true;
                            break;
                    }
                    if ($bolError) {
                        $this->arrErrores[] = "Error Linea " . ($numFila + 1) . " columna " . $arrCelda['nombre'] . " el valor debe ser " . $arrCelda['tipo'];
                    }
                    if (isset($arrCelda['rango'])) {
                        if (!in_array($arrArchivo[$numFila][$numColumna], $arrCelda['rango'])) {
                            $this->arrErrores[] = "Error Linea " . ($numFila + 1) . " columna " . $arrCelda['nombre'] . " " . $arrArchivo[$numFila][$numColumna] . " no es un valor válido";
                        }
                    }
                }
            }
        }
    }

}

?>