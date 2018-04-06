<?php

class aadProyectos
{

    public $arrErrores;
    public $arrMensajes;
    public $seqUnidadActo;
    public $seqTipoActoUnidad;
    public $txtTipoActoUnidad;
    public $numActo;
    public $fchActo;
    public $txtDescripcion;
    public $fchCreacion;
    public $seqUsuario;
    public $txtNombre;
    public $arrUnidades;
    public $arrExtensiones;
    public $txtCreador;

    public function __construct(){
        $this->arrErrores        = array();
        $this->arrMensajes       = array();
        $this->seqUnidadActo     = null;
        $this->seqTipoActoUnidad = null;
        $this->txtTipoActoUnidad = null;
        $this->numActo           = null;
        $this->fchActo           = null;
        $this->txtDescripcion    = null;
        $this->fchCreacion       = null;
        $this->seqUsuario        = null;
        $this->txtNombre         = null;
        $this->arrUnidades       = array();
        $this->arrExtensiones = array("txt","xls","xlsx");
        $this->txtCreador = "SiPIVE - SDHT";
    }

    public function listar($seqTipoActo = 0, $numActo = 0, $fchActo = null)
    {
        global $aptBd;

        try {

            $txtCondicion  = (intval($seqTipoActo) != 0) ? "and uac.seqTipoActo = " . $seqTipoActo : "";
            $txtCondicion .= (intval($numActo) != 0) ? "and uac.numActo = " . $numActo : "";
            $txtCondicion .= (esFechaValida($fchActo) != 0) ? "and uac.fchActo = " . $fchActo : "";

            $sql = "
                select 
                    uac.seqUnidadActo,
                    tac.txtTipoActoUnidad,
                    uac.numActo, 
                    uac.fchActo, 
                    uac.fchCreacion, 
                    concat(usu.txtNombre,' ', usu.txtApellido) as txtUsuario,
                    count(uvi.seqUnidadVinculado) as numVinculados
                from t_pry_aad_unidad_acto uac
                inner join t_pry_aad_unidad_tipo_acto tac on uac.seqTipoActoUnidad = tac.seqTipoActoUnidad
                inner join t_pry_aad_unidades_vinculadas uvi on uac.seqUnidadActo = uvi.seqUnidadActo
                inner join t_cor_usuario usu on uac.seqUsuario = usu.seqUsuario
                where 1 = 1 $txtCondicion
                group by 
                    tac.txtTipoActoUnidad,
                    uac.numActo, 
                    uac.fchActo, 
                    uac.fchCreacion, 
                    concat(usu.txtNombre,' ', usu.txtApellido)
                order by                
                    uac.fchCreacion desc
            ";

            return $aptBd->GetAll($sql);

        } catch( Exception $objError ){

            $this->arrErrores[] = $objError->getMessage();
            return array();

        }

    }

    public function cargar($seqUnidadActo){
        global $aptBd;

        try {

            $sql = "
                select 
                    uac.seqUnidadActo,
                    uac.seqTipoActoUnidad,
                    tac.txtTipoActoUnidad,
                    uac.numActo,
                    uac.fchActo,
                    uac.txtDescripcion,
                    uac.fchCreacion,
                    uac.seqUsuario,
                    concat(usu.txtNombre,' ',usu.txtApellido) as txtNombre
                from t_pry_aad_unidad_acto uac
                inner join t_pry_aad_unidad_tipo_acto tac on uac.seqTipoActoUnidad = tac.seqTipoActoUnidad
                inner join t_cor_usuario usu on uac.seqUsuario = usu.seqUsuario
                where uac.seqUnidadActo = $seqUnidadActo
            ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                foreach($objRes->fields as $txtCampo => $txtValor){
                    $this->$txtCampo = $txtValor;
                }
                $objRes->MoveNext();
            }

            // unidades vinculadas y sus cdp y rp
            $sql = "
                select 
                    upr.seqUnidadProyecto, 
                    if(pry1.seqProyecto is not null,pry1.seqProyecto,pry.seqProyecto) as seqProyecto,
                    if(pry1.seqProyecto is not null,pry1.txtNombreProyecto,pry.txtNombreProyecto) as txtNombreProyecto,
                    if(pry1.seqProyecto is not null,pry.seqProyecto,null) as seqConjunto,
                    if(pry1.seqProyecto is not null,pry.txtNombreProyecto,null) as txtNombreConjunto,
                    upr.txtNombreUnidad,
                    uvi.valIndexado,
                    rpr.seqRegistroPresupuestal, 
                    rpr.numNumeroCDP, 
                    rpr.fchFechaCDP, 
                    rpr.valValorCDP, 
                    rpr.numVigenciaCDP, 
                    rpr.numProyectoInversionCDP, 
                    rpr.numNumeroRP,
                    rpr.fchFechaRP, 
                    rpr.valValorRP, 
                    rpr.numVigenciaRP,
                    uvi.numActoReferencia,
                    uvi.fchActoReferencia,
                    upr.bolActivo as bolActivoUnidad,
                    if(pry1.seqProyecto is not null,pry1.bolActivo,pry.bolActivo) as bolActivoProyecto
                from t_pry_aad_unidades_vinculadas uvi
                left join t_pry_unidad_proyecto upr on uvi.seqUnidadProyecto = upr.seqUnidadProyecto
                left join t_pry_proyecto pry on uvi.seqProyecto = pry.seqProyecto
                left join t_pry_proyecto pry1 on pry.seqProyectoPadre = pry1.seqProyecto
                left join t_pry_aad_registro_presupuestal rpr on uvi.seqRegistroPresupuestal = rpr.seqRegistroPresupuestal
                where uvi.seqUnidadActo = $seqUnidadActo            
            ";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
                $seqProyecto = $objRes->fields['seqProyecto'];
                $numClave = (intval($seqUnidadProyecto) == 0)? $seqProyecto : $seqUnidadProyecto;
                $this->arrUnidades[$numClave]['seqProyecto'] = $objRes->fields['seqProyecto'];
                $this->arrUnidades[$numClave]['txtNombreProyecto'] = $objRes->fields['txtNombreProyecto'];
                $this->arrUnidades[$numClave]['seqConjunto'] = $objRes->fields['seqConjunto'];
                $this->arrUnidades[$numClave]['txtNombreConjunto'] = $objRes->fields['txtNombreConjunto'];
                $this->arrUnidades[$numClave]['txtNombreUnidad'] = $objRes->fields['txtNombreUnidad'];
                $this->arrUnidades[$numClave]['valIndexado'] = $objRes->fields['valIndexado'];
                $this->arrUnidades[$numClave]['seqRegistroPresupuestal'] = $objRes->fields['seqRegistroPresupuestal'];
                $this->arrUnidades[$numClave]['numNumeroCDP'] = $objRes->fields['numNumeroCDP'];
                $this->arrUnidades[$numClave]['fchFechaCDP'] = new DateTime($objRes->fields['fchFechaCDP']);
                $this->arrUnidades[$numClave]['valValorCDP'] = $objRes->fields['valValorCDP'];
                $this->arrUnidades[$numClave]['numVigenciaCDP'] = $objRes->fields['numVigenciaCDP'];
                $this->arrUnidades[$numClave]['numProyectoInversionCDP'] = $objRes->fields['numProyectoInversionCDP'];
                $this->arrUnidades[$numClave]['numNumeroRP'] = $objRes->fields['numNumeroRP'];
                $this->arrUnidades[$numClave]['fchFechaRP'] = new DateTime($objRes->fields['fchFechaRP']);
                $this->arrUnidades[$numClave]['valValorRP'] = $objRes->fields['valValorRP'];
                $this->arrUnidades[$numClave]['numVigenciaRP'] = $objRes->fields['numVigenciaRP'];
                $this->arrUnidades[$numClave]['numActoReferencia'] = $objRes->fields['numActoReferencia'];
                $this->arrUnidades[$numClave]['fchActoReferencia'] = new DateTime($objRes->fields['fchActoReferencia']);
                $this->arrUnidades[$numClave]['bolActivoProyecto'] = $objRes->fields['bolActivoProyecto'];
                $this->arrUnidades[$numClave]['bolActivoUnidad'] = $objRes->fields['bolActivoUnidad'];
                $objRes->MoveNext();
            }

        }catch(Exception $objError){
            $this->arrErrores[] = "No se pudo cargar la información del acto administrativo";
        }

    }

    public function tiposActos($seqTipoActoUnidad = 0){
        global $aptBd;
        $txtCondicion = ($seqTipoActoUnidad == 0)? "" : "where seqTipoActoUnidad = $seqTipoActoUnidad";
        $sql = "
            select 
                seqTipoActoUnidad,
                txtTipoActoUnidad
            from t_pry_aad_unidad_tipo_acto
            $txtCondicion
        ";
        return $aptBd->GetAll($sql);
    }

    public function plantilla($seqTipoActoUnidad){

        $arrTipo = $this->tiposActos($seqTipoActoUnidad);

        $arrFormato = array();
        $arrFormato[0]['nombreActo'] = $arrTipo[0]['txtTipoActoUnidad'];

        switch ($seqTipoActoUnidad){
            case 1: // Aprobacion

                $arrFormato[0]['nombre'] = "Proyecto o conjunto";
                $arrFormato[0]['tipo'] = "texto";
                $arrFormato[0]['rango'] = obtenerDatosTabla(
                    "t_pry_proyecto",
                    array("seqProyecto","lower(txtNombreProyecto) as txtNombreProyecto"),
                    "seqProyecto",
                    "",
                    "txtNombreProyecto"
                );

                $arrFormato[1]['nombre'] = "Descripción de la Unidad";
                $arrFormato[1]['tipo'] = "texto";
                $arrFormato[1]['rango'] = obtenerDatosTabla(
                    "t_pry_unidad_proyecto",
                    array("seqUnidadProyecto","seqProyecto","lower(txtNombreUnidad) as txtNombreUnidad"),
                    "seqUnidadProyecto"
                );

                $arrFormato[2]['nombre'] = "Valor Unidad";
                $arrFormato[2]['tipo'] = "numero";

                $arrFormato[3]['nombre'] = "Valor Complementario";
                $arrFormato[3]['tipo'] = "numero";

                $arrFormato[4]['nombre'] = "Identificador del recurso (SiPIVE)";
                $arrFormato[4]['tipo'] = "numero";

                $arrFormato[5]['nombre'] = "Plan de Gobierno (opconal)";
                $arrFormato[5]['tipo'] = "texto";
                $arrFormato[5]['rango'] = obtenerDatosTabla(
                    "t_frm_plan_gobierno",
                    array("seqPlanGobierno","lower(txtPlanGobierno) as txtPlanGobierno"),
                    "seqPlanGobierno"
                );

                $arrFormato[6]['nombre'] = "Modalidad (opconal)";
                $arrFormato[6]['tipo'] = "texto";
                $arrFormato[6]['rango'] = obtenerDatosTabla(
                    "t_frm_modalidad",
                    array("seqModalidad","seqPlanGobierno","lower(txtModalidad) as txtModalidad"),
                    "seqModalidad"
                );

                foreach($arrFormato[6]['rango'] as $seqModalidad => $arrModalidad) {
                    $arrEsquemas[$seqModalidad] = obtenerTipoEsquema($seqModalidad, $arrModalidad['seqPlanGobierno'], 1);

                }
                $arrFormato[7]['nombre'] = "Esquema (opconal)";
                $arrFormato[7]['tipo'] = "texto";
                $arrFormato[7]['rango'] = $arrEsquemas;



                break;
            case 2: // Indexación

                $arrFormato[0]['nombre'] = "Proyecto o conjunto";
                $arrFormato[0]['tipo'] = "texto";
                $arrFormato[0]['rango'] = obtenerDatosTabla(
                    "t_pry_proyecto",
                    array("seqProyecto","lower(txtNombreProyecto) as txtNombreProyecto"),
                    "seqProyecto",
                    "",
                    "txtNombreProyecto"
                );

                $arrFormato[1]['nombre'] = "Descripción de la Unidad";
                $arrFormato[1]['tipo'] = "texto";
                $arrFormato[1]['rango'] = obtenerDatosTabla(
                    "t_pry_unidad_proyecto",
                    array("seqUnidadProyecto","seqProyecto","lower(txtNombreUnidad) as txtNombreUnidad"),
                    "seqUnidadProyecto"
                );

                $arrFormato[2]['nombre'] = "Valor Indexacion";
                $arrFormato[2]['tipo'] = "numero";

                $arrFormato[3]['nombre'] = "Identificador del recurso (SiPIVE)";
                $arrFormato[3]['tipo'] = "numero";

                $arrFormato[4]['nombre'] = "Número Acto Referencia";
                $arrFormato[4]['tipo'] = "numero";

                $arrFormato[5]['nombre'] = "Fecha Acto Referencia";
                $arrFormato[5]['tipo'] = "fecha";

                break;
            case 3: // Modificacion

                $arrFormato[0]['nombre'] = "Proyecto o conjunto";
                $arrFormato[0]['tipo'] = "texto";
                $arrFormato[0]['rango'] = obtenerDatosTabla(
                    "t_pry_proyecto",
                    array("seqProyecto","lower(txtNombreProyecto) as txtNombreProyecto"),
                    "seqProyecto",
                    "",
                    "txtNombreProyecto"
                );

                $arrFormato[1]['nombre'] = "Descripción de la Unidad";
                $arrFormato[1]['tipo'] = "texto";
                $arrFormato[1]['rango'] = obtenerDatosTabla(
                    "t_pry_unidad_proyecto",
                    array("seqUnidadProyecto","seqProyecto","lower(txtNombreUnidad) as txtNombreUnidad"),
                    "seqUnidadProyecto"
                );

                $arrFormato[2]['nombre'] = "Número Acto Referencia";
                $arrFormato[2]['tipo'] = "numero";

                $arrFormato[3]['nombre'] = "Fecha Acto Referencia";
                $arrFormato[3]['tipo'] = "fecha";

                break;
            default:
                $this->arrErrores[] = "Tipo de acto desconocido";
                break;

        }

        return $arrFormato;

    }

    public function salvar($arrPost){
        global $aptBd;

        $this->validarFormulario($arrPost);

        if(empty($this->arrErrores)){

            $arrArchivo = $this->cargarArchivo($arrPost);

            $this->validarDatos($arrPost, $arrArchivo);

            $this->validarReglas($arrPost,$arrArchivo);

            if(empty($this->arrErrores)) {

                try {

                    $aptBd->BeginTrans();

                    $seqUnidadActo = $this->salvarActo($arrPost);

                    $this->vincularUnidades($seqUnidadActo, $arrPost, $arrArchivo);

                    if (empty($this->arrErrores)) {
                        $this->arrMensajes[] = "Se ha salvado el acto administrativo " . $arrPost['numActo'] . " del " . $arrPost['fchActo'];
                    }

                    $aptBd->CommitTrans();

                } catch (Exception $objError) {
                    $this->arrErrores[] = $objError->getMessage();
                    $aptBd->RollbackTrans();
                }

            }

        }

    }

    private function cargarArchivo($arrPost){
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
                $this->arrErrores[] = "Debe especificar un archivo para cargar";
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

        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        if( empty( $this->arrErrores ) ) {

            // si es un archivo de texto obtiene los datos
            if ($_FILES['archivo']['type'] == "text/plain") {
                foreach (file($_FILES['archivo']['tmp_name']) as $numLinea => $txtLinea) {
                    if (trim($txtLinea) != "") {
                        $arrArchivo[$numLinea] = explode("\t", trim($txtLinea));
                        foreach ($arrArchivo[$numLinea] as $numColumna => $txtCelda) {
                            if ($numColumna < count($arrFormato)) {
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
                    $numFilas = $objHoja->getHighestRow();
                    $numColumnas = PHPExcel_Cell::columnIndexFromString($objHoja->getHighestColumn()) - 1;

                    // obtiene los datos del rango obtenido
                    for ($numFila = 1; $numFila <= $numFilas; $numFila++) {
                        for ($numColumna = 0; $numColumna <= $numColumnas; $numColumna++) {
                            $numFilaArreglo = $numFila - 1;
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna, $numFila)->getValue();
                            if ($arrFormato[$numColumna]['tipo'] == "fecha" and is_numeric($arrArchivo[$numFilaArreglo][$numColumna])) {
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
        return $arrArchivo;
    }

    private function validarFormulario($arrPost){
        global $aptBd;

        if($arrPost['seqTipoActoUnidad'] == 0){
            $this->arrErrores[] = "Seleccione el tipo de acto";
        }

        if($arrPost['numActo'] <= 0){
            $this->arrErrores[] = "El numero de acto no es válido";
        }

        if(! esFechaValida($arrPost['fchActo'])){
            $this->arrErrores[] = "La fecha del acto no es válido";
        }

        if($arrPost['txtDescripcion'] == ""){
            $this->arrErrores[] = "Digite la descripción del acto administrativo";
        }

    }

    private function validarDatos($arrPost, $arrArchivo){

        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);
        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea){
            foreach($arrLinea as $numColumna => $txtValor){
                $bolError = true;
                if(trim($txtValor) != "") {
                    switch ($arrFormato[$numColumna]['tipo']) {
                        case "numero":
                            $bolError = (is_numeric($txtValor)) ? false : true;
                            break;
                        case "fecha":
                            $bolError = (esFechaValida($txtValor)) ? false : true;
                            break;
                        case "texto":
                            $bolError = (trim($txtValor) != "") ? false : true;
                            break;
                    }
                    if ($bolError == true) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": Valor inválido para la columna " . $arrFormato[$numColumna]['nombre'];
                    }
                }
            }
        }
    }

    private function validarReglas($arrPost, $arrArchivo){
        switch($arrPost['seqTipoActoUnidad']){
            case 1:
                $this->validarReglasAprobacion($arrPost,$arrArchivo);
                break;
            case 2:
                $this->validarReglasIndexacion($arrPost,$arrArchivo);
                break;
            case 3:
                $this->validarReglasModificacion($arrPost,$arrArchivo);
                break;
        }
    }

    private function validarReglasModificacion($arrPost,$arrArchivo){
        global $aptBd;

        // obtiene la plantilla
        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        // valida si la resolucion ya existe
        $this->resolucionExiste($arrPost['numActo'],$arrPost['fchActo']);

        $arrUnidades = array();
        $arrProyectos = array();

        foreach($arrArchivo as $numLinea => $arrLinea) {

            if ($numLinea == 0) {
                $this->validarTitulos($arrFormato, $arrArchivo);
            } else {

                // obtener los secuenciales de proyecto y unidad
                $seqProyecto = array_search(mb_strtolower($arrLinea[0]), $arrFormato[0]['rango'],true);
                $seqUnidadProyecto = 0;
                foreach ($arrFormato[1]['rango'] as $seqUnidad => $arrUnidad) {
                    if ($arrUnidad['seqProyecto'] == $seqProyecto and mb_strtolower($arrUnidad['txtNombreUnidad']) == mb_strtolower($arrLinea[1])) {
                        $seqUnidadProyecto = $seqUnidad;
                        break;
                    }
                }

                // proyecto desconocido
                if($seqProyecto == 0){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " es desconocido";
                }else{

                    // verificar proyecto duplicado cuando es de mejoramiento (o no tiene unidades)
                    if(! isset($arrProyectos[$seqProyecto])){
                        $sql = "
                         select count(seqUnidadProyecto) as cuenta
                         from t_pry_unidad_proyecto
                         where seqProyecto = $seqProyecto
                       ";
                        $objRes = $aptBd->execute($sql);
                        $arrProyectos[$seqProyecto] = intval($objRes->fields['cuenta']);
                    }elseif ($arrProyectos[$seqProyecto] == 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " esta duplicado dentro del archivo";
                    }

                    // si el proyecto esta inactivo no puede cargar resoluciones
                    $bolActivo = array_shift(
                        obtenerDatosTabla(
                            "t_pry_proyecto",
                            array("seqProyecto","bolActivo"),
                            "seqProyecto",
                            "seqProyecto = " . $seqProyecto
                        )
                    );

                    if($bolActivo == 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " no está activo";
                    }


                }

                // unidad existe y corresponde al proyecto
                // si el proyecto tiene unidades relacionadas
                if($arrProyectos[$seqProyecto] == 0) {

                    if(trim($arrLinea[1]) != ""){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " no debe tener unidades relacionadas";
                    }

                }else{

                    if ($seqUnidadProyecto == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La descripcion de la unidad " . $arrLinea[1] . " es desconocida o no corresponde al proyecto " . $arrLinea[0];
                    }else{
                        // si el proyecto esta inactivo no puede cargar resoluciones
                        $bolActivo = array_shift(
                            obtenerDatosTabla(
                                "t_pry_unidad_proyecto",
                                array("seqUnidadProyecto","bolActivo"),
                                "seqUnidadProyecto",
                                "seqUnidadProyecto = " . $seqUnidadProyecto
                            )
                        );

                        if($bolActivo == 0){
                            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La unidad " . $arrLinea[1] . " no está activa";
                        }
                    }

                    if (!in_array($seqUnidadProyecto, $arrUnidades)) {
                        $arrUnidades[] = $seqUnidadProyecto;
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La unidad " . $arrLinea[1] . " está duplicada dentro del archivo";
                    }

                }

                // ver si la resolucion relacionada existe y si la unidad esta vinculada con esa resolucion
                // debe ser una resolucion de aprobacion
                $numResolucionReferencia = intval($arrLinea[2]);
                $fchResolucionReferencia = (esFechaValida($arrLinea[3]))? $arrLinea[3] : null;

                $txtCondicion = "";
                if($seqUnidadProyecto == 0){
                    $txtCondicion = "and uvi.seqProyecto = $seqProyecto and uvi.seqUnidadProyecto is null";
                }else{
                    $txtCondicion = "and uvi.seqProyecto = $seqProyecto and uvi.seqUnidadProyecto = $seqUnidadProyecto";
                }

                $sql = "
                    select 
                        uvi.seqProyecto,
                        uvi.seqUnidadProyecto,
                        max(uac.seqUnidadActo) as seqUnidadActo
                    from t_pry_aad_unidades_vinculadas uvi
                    inner join t_pry_aad_unidad_acto uac on uvi.seqUnidadActo = uac.seqUnidadActo
                    where uac.seqTipoActoUnidad = 1
                    $txtCondicion  
                    group by 
                        uvi.seqProyecto,
                        uvi.seqUnidadProyecto                
                ";
                $arrUltimaAprobacion = array_shift($aptBd->GetAll($sql));

                $claActoRelacionado = new aadProyectos();
                $claActoRelacionado->cargar($arrUltimaAprobacion['seqUnidadActo']);

                if($claActoRelacionado->numActo != $numResolucionReferencia or $claActoRelacionado->fchActo != $fchResolucionReferencia){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La resolución de referencia no es la última resolucion de aprobación de la unidad o proyecto";
                }

            }

        }
    }

    private function validarReglasIndexacion($arrPost,$arrArchivo){
        global $aptBd;

        // obtiene la plantilla
        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        // valida si la resolucion ya existe
        $this->resolucionExiste($arrPost['numActo'],$arrPost['fchActo']);

        $arrUnidades = array();
        $arrProyectos = array();
        $arrCDP = array();

        foreach($arrArchivo as $numLinea => $arrLinea) {

            if ($numLinea == 0) {
                $this->validarTitulos($arrFormato, $arrArchivo);
            }else{

                // obtener los secuenciales de proyecto y unidad
                $seqProyecto = array_search(mb_strtolower($arrLinea[0]), $arrFormato[0]['rango'],true);
                $seqUnidadProyecto = 0;
                foreach ($arrFormato[1]['rango'] as $seqUnidad => $arrUnidad) {
                    if ($arrUnidad['seqProyecto'] == $seqProyecto and mb_strtolower($arrUnidad['txtNombreUnidad']) == mb_strtolower($arrLinea[1])) {
                        $seqUnidadProyecto = $seqUnidad;
                        break;
                    }
                }

                // proyecto desconocido
                if($seqProyecto == 0){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " es desconocido";
                }else{

                    // verificar proyecto duplicado cuando es de mejoramiento (o no tiene unidades)
                    if(! isset($arrProyectos[$seqProyecto])){
                        $sql = "
                         select count(seqUnidadProyecto) as cuenta
                         from t_pry_unidad_proyecto
                         where seqProyecto = $seqProyecto
                       ";
                        $objRes = $aptBd->execute($sql);
                        $arrProyectos[$seqProyecto] = intval($objRes->fields['cuenta']);
                    }elseif ($arrProyectos[$seqProyecto] == 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " esta duplicado dentro del archivo";
                    }

                    // si el proyecto esta inactivo no puede cargar resoluciones
                    $bolActivo = array_shift(
                        obtenerDatosTabla(
                            "t_pry_proyecto",
                            array("seqProyecto","bolActivo"),
                            "seqProyecto",
                            "seqProyecto = " . $seqProyecto
                        )
                    );

                    if($bolActivo == 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " no está activo";
                    }

                }

                // unidad existe y corresponde al proyecto
                // si el proyecto tiene unidades relacionadas
                if($arrProyectos[$seqProyecto] == 0) {

                    if(trim($arrLinea[1]) != ""){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " no debe tener unidades relacionadas";
                    }

                }else{

                    if ($seqUnidadProyecto == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La descripcion de la unidad " . $arrLinea[1] . " es desconocida o no corresponde al proyecto " . $arrLinea[0];
                    }else{

                        // si el proyecto esta inactivo no puede cargar resoluciones
                        $bolActivo = array_shift(
                            obtenerDatosTabla(
                                "t_pry_unidad_proyecto",
                                array("seqUnidadProyecto","bolActivo"),
                                "seqUnidadProyecto",
                                "seqUnidadProyecto = " . $seqUnidadProyecto
                            )
                        );

                        if($bolActivo == 0){
                            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La unidad " . $arrLinea[1] . " no está activa";
                        }
                    }

                    if (!in_array($seqUnidadProyecto, $arrUnidades)) {
                        $arrUnidades[] = $seqUnidadProyecto;
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La unidad " . $arrLinea[1] . " está duplicada dentro del archivo";
                    }

                }

                // validacion del valor de la indexacion
                $seqRegistro = intval($arrLinea[3]);
                if(doubleval($arrLinea[2]) >= 0){

                    // validacion del registro presupuesto
                    if($seqRegistro == 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": No tiene identificador del recurso SiPIVE";
                    }else{
                        if(! isset($arrCDP[$seqRegistro])){
                            $sql = "
                            select 
                                rpr.seqRegistroPresupuestal,
                                rpr.valValorRP,
                                count(uvi.seqUnidadProyecto) as cantidad
                            from t_pry_aad_registro_presupuestal rpr
                            left join t_pry_aad_unidades_vinculadas uvi on rpr.seqRegistroPresupuestal = uvi.seqRegistroPresupuestal
                            where rpr.seqRegistroPresupuestal = $seqRegistro
                            group by 
                                rpr.seqRegistroPresupuestal,
                                rpr.valValorRP                        
                        ";
                            $objRes = $aptBd->execute($sql);
                            while($objRes->fields){
                                $arrCDP[$seqRegistro]['cantidad']  = $objRes->fields['cantidad'];
                                $arrCDP[$seqRegistro]['valor']     = $objRes->fields['valValorRP'];
                                $objRes->MoveNext();
                            }
                        }
                        $arrCDP[$seqRegistro]['acumulado'] += doubleval($arrLinea[2]);
                    }

                }else{

                    // si es una indexacion negativa no debe llevar el registro presupuestal
                    if($seqRegistro != 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": Para indexaciones negativas el identificador del recurso SiPIVE debe estar vacío";
                    }

                }

                if($seqUnidadProyecto == 0){
                    $valIndexado = array_shift(
                        obtenerDatosTabla(
                            "t_pry_proyecto",
                            array("seqProyecto","valMaximoSubsidio"),
                            "seqProyecto",
                            "seqProyecto = " . $seqProyecto
                        )
                    );
                }else{
                    $valIndexado = array_shift(
                        obtenerDatosTabla(
                            "t_pry_unidad_proyecto",
                            array("seqUnidadProyecto","valSDVEActual"),
                            "seqUnidadProyecto",
                            "seqUnidadProyecto = " . $seqUnidadProyecto
                        )
                    );
                }

                if($valIndexado + doubleval($arrLinea[2]) <= 0){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": Valor de indexacion incorrecto, no puede ser igual al valor de la unidad o proyecto";
                }

                // ver si la resolucion relacionada existe y si la unidad esta vinculada con esa resolucion
                // debe ser una resolucion de aprobacion
                $numResolucionReferencia = intval($arrLinea[4]);
                $fchResolucionReferencia = (esFechaValida($arrLinea[5]))? $arrLinea[5] : null;

                $txtCondicion = "";
                if($seqUnidadProyecto == 0){
                    $txtCondicion = "and uvi.seqProyecto = $seqProyecto and uvi.seqUnidadProyecto is null";
                }else{
                    $txtCondicion = "and uvi.seqProyecto = $seqProyecto and uvi.seqUnidadProyecto = $seqUnidadProyecto";
                }

                $sql = "
                    select 
                        uvi.seqProyecto,
                        uvi.seqUnidadProyecto,
                        max(uac.seqUnidadActo) as seqUnidadActo
                    from t_pry_aad_unidades_vinculadas uvi
                    inner join t_pry_aad_unidad_acto uac on uvi.seqUnidadActo = uac.seqUnidadActo
                    where uac.seqTipoActoUnidad = 1
                    $txtCondicion  
                    group by 
                        uvi.seqProyecto,
                        uvi.seqUnidadProyecto                
                ";
                $arrUltimaAprobacion = array_shift($aptBd->GetAll($sql));

                $claActoRelacionado = new aadProyectos();
                $claActoRelacionado->cargar($arrUltimaAprobacion['seqUnidadActo']);

                if($claActoRelacionado->numActo != $numResolucionReferencia or $claActoRelacionado->fchActo != $fchResolucionReferencia){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La resolución de referencia no es la última resolucion de aprobación de la unidad o proyecto";
                }

            }

        }

        // verifica que la suma del valor del rp coincida con la suma de vaores de la unidades
        // y valida que el RP no este en uso
        foreach($arrCDP as $seqRegistro => $arrDatos){
            if($arrDatos['cantidad'] != 0){
                $this->arrErrores[] = "El identificado del recurso $seqRegistro ya esta en uso";
            }else{
                if($arrDatos['valor'] != $arrDatos['acumulado']){
                    $this->arrErrores[] = "La suma de valores de unidad no coinciden con el valor del registro presupuestal $seqRegistro";
                }
            }
        }

    }

    private function validarReglasAprobacion($arrPost, $arrArchivo){
        global $arrConfiguracion, $aptBd;

        // obtiene la plantilla
        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        $arrUnidades = array();
        $arrProyectos = array();
        $arrCDP = array();

        // valida si la resolucion ya existe
        $this->resolucionExiste($arrPost['numActo'],$arrPost['fchActo']);

        foreach($arrArchivo as $numLinea => $arrLinea){

            if($numLinea == 0){
                $this->validarTitulos($arrFormato,$arrArchivo);
            }else{

                // obtener los secuenciales de proyecto y unidad
                $seqProyecto = array_search(mb_strtolower($arrLinea[0]), $arrFormato[0]['rango'],true);
                $seqUnidadProyecto = 0;
                foreach ($arrFormato[1]['rango'] as $seqUnidad => $arrUnidad) {
                    if ($arrUnidad['seqProyecto'] == $seqProyecto and mb_strtolower($arrUnidad['txtNombreUnidad']) == mb_strtolower($arrLinea[1])) {
                        $seqUnidadProyecto = $seqUnidad;
                        break;
                    }
                }

                // proyecto desconocido
                if($seqProyecto == 0){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " es desconocido";
                }else{

                    // verificar proyecto duplicado cuando es de mejoramiento (o no tiene unidades)
                    if(! isset($arrProyectos[$seqProyecto])){
                        $sql = "
                         select count(seqUnidadProyecto) as cuenta
                         from t_pry_unidad_proyecto
                         where seqProyecto = $seqProyecto
                       ";
                        $objRes = $aptBd->execute($sql);
                        $arrProyectos[$seqProyecto] = intval($objRes->fields['cuenta']);
                    }elseif ($arrProyectos[$seqProyecto] == 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " esta duplicado dentro del archivo";
                    }

                }

                // unidad existe y corresponde al proyecto
                // si el proyecto tiene unidades relacionadas
                if($arrProyectos[$seqProyecto] == 0) {

                    if(trim($arrLinea[1]) != ""){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " no debe tener unidades relacionadas";
                    }

                    if($this->valorProyecto($seqProyecto) != 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El proyecto " . $arrLinea[0] . " está relacionado con uno o mas actos administrativos";
                    }


                }else{

                    if ($seqUnidadProyecto == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La descripcion de la unidad " . $arrLinea[1] . " es desconocida o no corresponde al proyecto " . $arrLinea[0];
                    }

                    if (!in_array($seqUnidadProyecto, $arrUnidades)) {
                        $arrUnidades[] = $seqUnidadProyecto;
                    } else {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La unidad " . $arrLinea[1] . " está duplicada dentro del archivo";
                    }

                }

                // validacion del valor de la unidad
                if(doubleval($arrLinea[2]) < $arrConfiguracion['constantes']['salarioMinimo']){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor debe ser mayor a 1 SMMLV";
                }

                // validacion del valor complementario
                if(doubleval($arrLinea[3]) != 0 and doubleval($arrLinea[3]) < $arrConfiguracion['constantes']['salarioMinimo']){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor complementario debe ser mayor a 1 SMMLV";
                }

                // plan de gobierno
                $seqPlanGobierno = 0;
                if(mb_strtolower($arrLinea[5]) != "" or mb_strtolower($arrLinea[6]) != "" or mb_strtolower($arrLinea[7]) != "") {
                    $seqPlanGobierno = array_search(mb_strtolower($arrLinea[5]), $arrFormato[5]['rango'], true);
                    if (intval($seqPlanGobierno) == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El Plan de Gobierno es desconocido";
                    }
                }

                // modalidad
                $seqModalidadUnidad = 0;
                if(mb_strtolower($arrLinea[5]) != "" or mb_strtolower($arrLinea[6]) != "" or mb_strtolower($arrLinea[7]) != "") {
                    foreach ($arrFormato[6]['rango'] as $seqModalidad => $arrModalidad) {
                        if ($seqPlanGobierno == $arrModalidad['seqPlanGobierno'] and mb_strtolower($arrLinea[6]) == mb_strtolower($arrModalidad['txtModalidad'])) {
                            $seqModalidadUnidad = $seqModalidad;
                            break;
                        }
                    }
                    if($seqModalidadUnidad == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La modalidad " . $arrLinea[6] . " es desconocida o no corresponde al plan de gobierno";
                    }
                }

                // esquema
                $seqEsquemaUnidad = 0;
                if(mb_strtolower($arrLinea[5]) != "" or mb_strtolower($arrLinea[6]) != "" or mb_strtolower($arrLinea[7]) != "") {
                    foreach ($arrFormato[7]['rango'][$seqModalidad] as $seqTipoEsquema => $txtTipoEsquema) {
                        if (mb_strtolower($arrLinea[7]) == mb_strtolower($txtTipoEsquema)) {
                            $seqEsquemaUnidad = $seqTipoEsquema;
                            break;
                        }
                    }
                    if($seqEsquemaUnidad == 0) {
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El esquema " . $arrLinea[7] . " es desconocida o no corresponde a la modalidad";
                    }
                }

                // validar que la unidad no este con otra aprobacion o que el saldo este en cero
                if($this->valorUnidad($seqUnidadProyecto) != 0){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La unidad " . $arrLinea[1] . " está relacionada con uno o mas actos administrativos";
                }

                // validacion del registro presupuesto
                $seqRegistro = intval($arrLinea[4]);
                if($seqRegistro == 0){
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": No tiene identificador del recurso SiPIVE";
                }else{
                    if(! isset($arrCDP[$seqRegistro])){
                        $sql = "
                            select 
                                rpr.seqRegistroPresupuestal,
                                rpr.valValorRP,
                                count(uvi.seqUnidadProyecto) as cantidad
                            from t_pry_aad_registro_presupuestal rpr
                            left join t_pry_aad_unidades_vinculadas uvi on rpr.seqRegistroPresupuestal = uvi.seqRegistroPresupuestal
                            where rpr.seqRegistroPresupuestal = $seqRegistro
                            group by 
                                rpr.seqRegistroPresupuestal,
                                rpr.valValorRP                        
                        ";
                        $objRes = $aptBd->execute($sql);
                        while($objRes->fields){
                            $arrCDP[$seqRegistro]['cantidad']  = $objRes->fields['cantidad'];
                            $arrCDP[$seqRegistro]['valor']     = $objRes->fields['valValorRP'];
                            $objRes->MoveNext();
                        }
                    }
                    $arrCDP[$seqRegistro]['acumulado'] += doubleval($arrLinea[2]);
                }
            }
        }

        // verifica que la suma del valor del rp coincida con la suma de vaores de la unidades
        // y valida que el RP no este en uso
        foreach($arrCDP as $seqRegistro => $arrDatos){
            if($arrDatos['cantidad'] != 0){
                $this->arrErrores[] = "El identificado del recurso $seqRegistro ya esta en uso";
            }else{
                if($arrDatos['valor'] != $arrDatos['acumulado']){
                    $this->arrErrores[] = "La suma de valores de unidad no coinciden con el valor del registro presupuestal $seqRegistro";
                }
            }
        }

    }

    private function valorUnidad($seqUnidad){
        global $aptBd;
        $sql = "
            select 
                uvi.seqUnidadProyecto, 
                sum(uvi.valIndexado) as valIndexado
            from t_pry_aad_unidades_vinculadas uvi
            where uvi.seqUnidadProyecto = $seqUnidad
            group by uvi.seqUnidadProyecto       
        ";
        $objRes = $aptBd->execute($sql);
        $valIndexado = 0;
        while($objRes->fields){
            $valIndexado = $objRes->fields['valIndexado'];
            $objRes->MoveNext();
        }
        return $valIndexado;
    }

    private function valorProyecto($seqProyecto){
        global $aptBd;
        $sql = "
            select 
                uvi.seqProyecto, 
                sum(uvi.valIndexado) as valIndexado
            from t_pry_aad_unidades_vinculadas uvi
            where uvi.seqProyecto = $seqProyecto
            group by uvi.seqProyecto        
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $valIndexado = $objRes->fields['valIndexado'];
            $objRes->MoveNext();
        }
        return $valIndexado;
    }

    private function salvarActo($arrPost){
        global $aptBd;

        $sql = "
            insert into t_pry_aad_unidad_acto (
                numActo,
                fchActo,
                seqTipoActoUnidad,
                txtDescripcion,
                fchCreacion,
                seqUsuario
            ) values (
                " . $arrPost['numActo'] . ",
                '" . $arrPost['fchActo'] . "',
                " . $arrPost['seqTipoActoUnidad'] . ",
                '" . $arrPost['txtDescripcion'] . "',
                now(),
                " . $_SESSION['seqUsuario'] . "
            )
        ";
        $aptBd->execute($sql);
        return $aptBd->Insert_ID();
    }

    private function vincularUnidades($seqUnidadActo, $arrPost, $arrArchivo){
        switch($arrPost['seqTipoActoUnidad']){
            case 1:
                $this->vincularUnidadesAprobacion($seqUnidadActo, $arrPost, $arrArchivo);
                break;
            case 2:
                $this->vincularUnidadesIndexacion($seqUnidadActo, $arrPost, $arrArchivo);
                break;
            case 3:
                $this->vincularUnidadesModificacion($seqUnidadActo, $arrPost, $arrArchivo);
                break;
        }
    }



    private function vincularUnidadesAprobacion($seqUnidadActo, $arrPost, $arrArchivo){
        global $aptBd;

        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea){

            $seqProyecto = array_search(mb_strtolower($arrLinea[0]), $arrFormato[0]['rango'],true);
            $seqUnidadProyecto = 'null';
            foreach ($arrFormato[1]['rango'] as $seqUnidad => $arrUnidad) {
                if ($arrUnidad['seqProyecto'] == $seqProyecto and mb_strtolower($arrUnidad['txtNombreUnidad']) == mb_strtolower($arrLinea[1])) {
                    $seqUnidadProyecto = $seqUnidad;
                    break;
                }
            }

            $sql = "
                INSERT INTO t_pry_aad_unidades_vinculadas (
                    seqUnidadActo,
                    seqProyecto,
                    seqUnidadProyecto,
                    valIndexado,
                    seqRegistroPresupuestal,
                    numActoReferencia,
                    fchActoReferencia
                ) VALUES (
                    " . $seqUnidadActo . ",
                    " . $seqProyecto . ",
                    " . $seqUnidadProyecto . ",
                    " . doubleval($arrLinea[2]) . ",
                    " . intval($arrLinea[4]) . ",
                    null,
                    null
                )
            ";
            $aptBd->execute($sql);

            // plan de gobierno
            $seqPlanGobierno = 0;
            if(mb_strtolower($arrLinea[5]) != "" or mb_strtolower($arrLinea[6]) != "" or mb_strtolower($arrLinea[7]) != "") {
                $seqPlanGobierno = array_search(mb_strtolower($arrLinea[5]), $arrFormato[5]['rango'], true);
            }

            // modalidad
            $seqModalidadUnidad = 0;
            if(mb_strtolower($arrLinea[5]) != "" or mb_strtolower($arrLinea[6]) != "" or mb_strtolower($arrLinea[7]) != "") {
                foreach ($arrFormato[6]['rango'] as $seqModalidad => $arrModalidad) {
                    if ($seqPlanGobierno == $arrModalidad['seqPlanGobierno'] and mb_strtolower($arrLinea[6]) == mb_strtolower($arrModalidad['txtModalidad'])) {
                        $seqModalidadUnidad = $seqModalidad;
                        break;
                    }
                }
            }

            // esquema
            $seqEsquemaUnidad = 0;
            if(mb_strtolower($arrLinea[5]) != "" or mb_strtolower($arrLinea[6]) != "" or mb_strtolower($arrLinea[7]) != "") {
                foreach ($arrFormato[7]['rango'][$seqModalidad] as $seqTipoEsquema => $txtTipoEsquema) {
                    if (mb_strtolower($arrLinea[7]) == mb_strtolower($txtTipoEsquema)) {
                        $seqEsquemaUnidad = $seqTipoEsquema;
                        break;
                    }
                }
            }

            if($seqUnidadProyecto != 'null'){

                $txtPlanGobierno = ($seqPlanGobierno    != 0)? "seqPlanGobierno = $seqPlanGobierno," : "seqPlanGobierno = seqPlanGobierno,";
                $txtModalidad    = ($seqModalidadUnidad != 0)? "seqModalidad = $seqModalidadUnidad," : "seqModalidad = seqModalidad,";
                $txtTipoEsquema  = ($seqEsquemaUnidad   != 0)? "seqTipoEsquema = $seqEsquemaUnidad"  : "seqTipoEsquema = seqTipoEsquema";

                $sql = "
                    update t_pry_unidad_proyecto set
                        valSDVEActual = " . intval($arrLinea[2]) . ",
                        valSDVEComplementario = " . intval($arrLinea[3]) . ",
                        bolActivo = 1,
                        $txtPlanGobierno
                        $txtModalidad
                        $txtTipoEsquema
                    where seqUnidadProyecto = $seqUnidadProyecto
                ";
                $aptBd->execute($sql);

            }else{

                $txtPlanGobierno = ($seqPlanGobierno    != 0)? "seqPlanGobierno = $seqPlanGobierno" : "seqPlanGobierno = seqPlanGobierno";

                $sql = "
                    update t_pry_proyecto set
                        valMaximoSubsidio = " . intval($arrLinea[2]) . ",
                        bolActivo = 1,
                        $txtPlanGobierno
                    where seqProyecto = $seqProyecto
                ";
                $aptBd->execute($sql);

            }

        }

    }

    private function vincularUnidadesIndexacion($seqUnidadActo, $arrPost, $arrArchivo){
        global $aptBd;

        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea){

            $seqProyecto = array_search(mb_strtolower($arrLinea[0]), $arrFormato[0]['rango'],true);
            $seqUnidadProyecto = 'null';
            foreach ($arrFormato[1]['rango'] as $seqUnidad => $arrUnidad) {
                if ($arrUnidad['seqProyecto'] == $seqProyecto and mb_strtolower($arrUnidad['txtNombreUnidad']) == mb_strtolower($arrLinea[1])) {
                    $seqUnidadProyecto = $seqUnidad;
                    break;
                }
            }

            $seqRegistro = (intval($arrLinea[3]) != 0)? intval($arrLinea[3]) : 'null';

            $sql = "
                INSERT INTO t_pry_aad_unidades_vinculadas (
                    seqUnidadActo,
                    seqProyecto,
                    seqUnidadProyecto,
                    valIndexado,
                    seqRegistroPresupuestal,
                    numActoReferencia,
                    fchActoReferencia
                ) VALUES (
                    " . $seqUnidadActo . ",
                    " . $seqProyecto . ",
                    " . $seqUnidadProyecto . ",
                    " . doubleval($arrLinea[2]) . ",
                    " . $seqRegistro . ",
                    " . intval($arrLinea[4]) . ",
                    '" . $arrLinea[5] . "'
                )
            ";
            $aptBd->execute($sql);

            if($seqUnidadProyecto != 'null'){

                $valSDVEActual = array_shift(
                    obtenerDatosTabla(
                        "t_pry_unidad_proyecto",
                        array("seqUnidadProyecto","valSDVEActual"),
                        "seqUnidadProyecto",
                        "seqUnidadProyecto = " . $seqUnidadProyecto
                    )
                );

                $sql = "
                    update t_pry_unidad_proyecto set
                        valSDVEActual = " . ($valSDVEActual + doubleval($arrLinea[2])) . "
                    where seqUnidadProyecto = $seqUnidadProyecto
                ";
                $aptBd->execute($sql);

                $seqFormulario = array_shift(
                    obtenerDatosTabla(
                        "t_pry_unidad_proyecto",
                        array("seqUnidadProyecto","seqFormulario"),
                        "seqUnidadProyecto",
                        "seqUnidadProyecto = " . $seqUnidadProyecto
                    )
                );
                if(intval($seqFormulario) != 0){
                    $sql = "
                        update t_frm_formulario set
                          valAspiraSubsidio = " . ($valSDVEActual + doubleval($arrLinea[2])) . "
                        where seqFormulario = $seqFormulario
                    ";
                    $aptBd->execute($sql);
                }

            }else{

                $valMaximoSubsidio = array_shift(
                    obtenerDatosTabla(
                        "t_pry_proyecto",
                        array("seqProyecto","valMaximoSubsidio"),
                        "seqProyecto",
                        "seqProyecto = " . $seqProyecto
                    )
                );

                $sql = "
                    update t_pry_proyecto set
                        valMaximoSubsidio = " . ($valMaximoSubsidio + doubleval($arrLinea[2])) . "
                    where seqProyecto = $seqProyecto
                ";
                $aptBd->execute($sql);

            }

        }
    }

    private function vincularUnidadesModificacion($seqUnidadActo, $arrPost, $arrArchivo){
        global $aptBd;

        $arrFormato = $this->plantilla($arrPost['seqTipoActoUnidad']);

        unset($arrArchivo[0]);
        foreach($arrArchivo as $numLinea => $arrLinea){

            $seqProyecto = array_search(mb_strtolower($arrLinea[0]), $arrFormato[0]['rango'],true);
            $seqUnidadProyecto = 'null';
            foreach ($arrFormato[1]['rango'] as $seqUnidad => $arrUnidad) {
                if ($arrUnidad['seqProyecto'] == $seqProyecto and mb_strtolower($arrUnidad['txtNombreUnidad']) == mb_strtolower($arrLinea[1])) {
                    $seqUnidadProyecto = $seqUnidad;
                    break;
                }
            }

            if($seqUnidadProyecto == 'null'){
                $valIndexado = array_shift(
                    obtenerDatosTabla(
                        "t_pry_proyecto",
                        array("seqProyecto","valMaximoSubsidio"),
                        "seqProyecto",
                        "seqProyecto = " . $seqProyecto
                    )
                );
            }else{
                $valIndexado = array_shift(
                    obtenerDatosTabla(
                        "t_pry_unidad_proyecto",
                        array("seqUnidadProyecto","valSDVEActual"),
                        "seqUnidadProyecto",
                        "seqUnidadProyecto = " . $seqUnidadProyecto
                    )
                );
            }

            $sql = "
                INSERT INTO t_pry_aad_unidades_vinculadas (
                    seqUnidadActo,
                    seqProyecto,
                    seqUnidadProyecto,
                    valIndexado,
                    seqRegistroPresupuestal,
                    numActoReferencia,
                    fchActoReferencia
                ) VALUES (
                    " . $seqUnidadActo . ",
                    " . $seqProyecto . ",
                    " . $seqUnidadProyecto . ",
                    " . ($valIndexado * -1). ",
                    null,
                    " . intval($arrLinea[2]) . ",
                    '" . $arrLinea[3] . "'
                )
            ";
            $aptBd->execute($sql);

            if($seqUnidadProyecto != 'null'){

                $sql = "
                    update t_pry_unidad_proyecto set
                        valSDVEActual = 0,
                        bolActivo = 0 
                    where seqUnidadProyecto = $seqUnidadProyecto
                ";
                $aptBd->execute($sql);

            }else{

                $sql = "
                    update t_pry_proyecto set
                        valMaximoSubsidio = 0,
                        bolActivo = 0
                    where seqProyecto = $seqProyecto
                ";
                $aptBd->execute($sql);

            }

        }
    }

    public function listarCDP($seqRegistroPresupuestal = null,$numNumeroCDP = null,$fchFechaCDP = null,$valValorCDP = null,$numVigenciaCDP = null,$numProyectoInversionCDP = null,$numNumeroRP = null,$fchFechaRP = null,$valValorRP = null,$numVigenciaRP = null){
        global $aptBd;

        $txtCondicion  = ($seqRegistroPresupuestal == null)? "" : "and seqRegistroPresupuestal = $seqRegistroPresupuestal ";
        $txtCondicion .= ($numNumeroCDP == null           )? "" : "and numNumeroCDP = $numNumeroCDP ";
        $txtCondicion .= ($fchFechaCDP == null            )? "" : "and fchFechaCDP = '$fchFechaCDP' ";
        $txtCondicion .= ($valValorCDP == null            )? "" : "and valValorCDP = $valValorCDP ";
        $txtCondicion .= ($numVigenciaCDP == null         )? "" : "and numVigenciaCDP = $numVigenciaCDP ";
        $txtCondicion .= ($numProyectoInversionCDP == null)? "" : "and numProyectoInversionCDP = $numProyectoInversionCDP ";
        $txtCondicion .= ($numNumeroRP == null            )? "" : "and numNumeroRP = $numNumeroRP ";
        $txtCondicion .= ($fchFechaRP == null             )? "" : "and fchFechaRP = '$fchFechaRP' ";
        $txtCondicion .= ($valValorRP == null             )? "" : "and valValorRP = $valValorRP ";
        $txtCondicion .= ($numVigenciaRP == null          )? "" : "and numVigenciaRP = $numVigenciaRP ";

        $sql = "
            SELECT 
              seqRegistroPresupuestal,
              numNumeroCDP,
              fchFechaCDP,
              valValorCDP,
              numVigenciaCDP,
              numProyectoInversionCDP,
              numNumeroRP,
              fchFechaRP,
              valValorRP,
              numVigenciaRP
            FROM t_pry_aad_registro_presupuestal   
            WHERE 1 = 1
            $txtCondicion   
        ";
        return $aptBd->GetAll($sql);
    }

    public function salvarCDP($arrPost){
        global $aptBd;
        try{
            $aptBd->BeginTrans();
            $sql = "
                insert into t_pry_aad_registro_presupuestal (
                  numNumeroCDP, 
                  fchFechaCDP, 
                  valValorCDP, 
                  numVigenciaCDP, 
                  numProyectoInversionCDP, 
                  numNumeroRP, 
                  fchFechaRP, 
                  valValorRP, 
                  numVigenciaRP
                ) values (
                  " . $arrPost['numNumeroCDP'] . ",  
                  '" . $arrPost['fchFechaCDP'] . "',  
                  " . $arrPost['valValorCDP'] . ",  
                  " . $arrPost['numVigenciaCDP'] . ",  
                  " . $arrPost['numProyectoInversionCDP'] . ",  
                  " . $arrPost['numNumeroRP'] . ",  
                  '" . $arrPost['fchFechaRP'] . "',  
                  " . $arrPost['valValorRP'] . ",  
                  " . $arrPost['numVigenciaRP'] . "                  
                ) 
            ";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
        }catch(Exception $objError){
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
        }
    }

    public function eliminarCDP($seqRegistroPresupuestal){
        global $aptBd;
        try{
            $aptBd->BeginTrans();
            $sql = "
                select count(*) as cuenta
                from t_pry_aad_unidades_vinculadas 
                where seqRegistroPresupuestal = $seqRegistroPresupuestal
            ";
            $objRes = $aptBd->execute($sql);
            if($objRes->fields['cuenta'] == 0){
                $sql = "
                    delete 
                    from t_pry_aad_registro_presupuestal 
                    where seqRegistroPresupuestal = $seqRegistroPresupuestal
                ";
                $aptBd->execute($sql);
            }else{
                throw new Exception("El registro presupuestal está asociado a por lo menos una unidad");
            }
            $aptBd->CommitTrans();
        }catch (Exception $objError){
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
        }
    }

    private function resolucionExiste($numActo, $fchActo){
        global $aptBd;
        $sql = "
            select count(*) cuenta
            from t_pry_aad_unidad_acto 
            where numActo = " . $numActo . "
              and fchActo = '" . $fchActo . "' 
        ";
        $arrExisteActo = $aptBd->GetAll($sql);
        if($arrExisteActo[0]['cuenta']){
            $this->arrErrores[] = "La resolución " . $numActo . " del " . $fchActo . " ya existe";
        }
    }

    private function validarTitulos($arrFormato,$arrArchivo){
        foreach($arrFormato as $numColumna => $arrColumna) {
            if (mb_strtolower($arrColumna['nombre']) != mb_strtolower($arrArchivo[0][$numColumna])) {
                $this->arrErrores[] = "La columna " . $arrColumna['nombre'] . " no se encuentra o no esta en el lugar correcto";
            }
        }
    }

}


?>