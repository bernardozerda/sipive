<?php

class GestionFinancieraProyectos
{

    public $arrProyectos;
    public $arrFiducia;
    public $arrResoluciones;
    public $arrErrores;
    public $arrMensajes;
    public $txtCreador;
    public $arrTitulos;
    private $arrExtensiones;


    public function __construct()
    {
        $this->arrProyectos = array();
        $this->arrFiducia = array();
        $this->arrResoluciones = array();
        $this->arrErrores = array();
        $this->arrMensajes = array();
        $this->arrExtensiones = array("txt","xls","xlsx");
        $this->txtCreador = "SiPIVE - SDHT";
        $this->arrTitulos[] = "Identificador del Proyecto";
        $this->arrTitulos[] = "Nombre del Proyecto";
        $this->arrTitulos[] = "Identificador de la Unidad";
        $this->arrTitulos[] = "Descripcion de la Unidad";
        $this->arrTitulos[] = "Valor por resolución";
        $this->arrTitulos[] = "Valor a Girar";

    }

    /**
     * obtiene el listado de proyectos
     * @author Bernardo Zerda
     * @version 1.0 Abril 2018
     */
    public function proyectos(){
        global $aptBd;

        $sql = "
            select 
                seqProyecto, 
                txtNombreProyecto
            from t_pry_proyecto
            where bolActivo = 1 
              and seqProyectoPadre is null
            order by txtNombreProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $this->arrProyectos[$seqProyecto] = $objRes->fields['txtNombreProyecto'];
            $objRes->MoveNext();
        }

    }

    public function informacionResoluciones($seqProyecto){

        $this->arrResoluciones = array();

        $this->datosBasicos($seqProyecto);

        $this->liberaciones($seqProyecto);

        $this->giros($seqProyecto);

    }

    private function datosBasicos($seqProyecto){
        global $aptBd;

        $sql = "
            select
                uac.seqUnidadActo,
                tac.txtTipoActoUnidad,
                uac.numActo,
                uac.fchActo,
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
                if(pry.seqProyecto is null, con.seqProyecto, pry.seqProyecto) as seqProyecto,
                if(pry.seqProyecto is null, con.txtNombreProyecto, pry.txtNombreProyecto) as txtNombreProyecto,
                if(pry.seqProyecto is null, null, con.seqProyecto) as seqConjunto,
                if(pry.seqProyecto is null, null, con.txtNombreProyecto) as txtNombreConjunto,
                upr.seqUnidadProyecto,
                upr.txtNombreUnidad,
                upr.valSDVEActual,
                uvi.valIndexado
            from t_pry_aad_unidades_vinculadas uvi 
            left join t_pry_unidad_proyecto upr on upr.seqUnidadProyecto = uvi.seqUnidadProyecto
            left join t_pry_proyecto con on uvi.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on pry.seqProyecto = con.seqProyectoPadre
            inner join t_pry_aad_unidad_acto uac on uac.seqUnidadActo = uvi.seqUnidadActo
            inner join t_pry_aad_unidad_tipo_acto tac on uac.seqTipoActoUnidad = tac.seqTipoActoUnidad
            left join t_pry_aad_registro_presupuestal rpr on uvi.seqRegistroPresupuestal = rpr.seqRegistroPresupuestal
            where uvi.seqProyecto in (
                select seqProyecto
                from t_pry_proyecto
                where seqProyecto = $seqProyecto
                or seqProyectoPadre = $seqProyecto
            ) and (pry.bolActivo = 1 or pry.bolActivo is null)
            and (con.bolActivo = 1 or con.bolActivo is null)
            order by 
                uac.fchActo,
                upr.seqUnidadProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {

            $seqUnidadActo = $objRes->fields['seqUnidadActo'];
            $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];
            $seqUnidadProyecto = intval($objRes->fields['seqUnidadProyecto']);

            $this->arrResoluciones[$seqUnidadActo]['tipo'] = $objRes->fields['txtTipoActoUnidad'];
            $this->arrResoluciones[$seqUnidadActo]['numero'] = $objRes->fields['numActo'];
            $this->arrResoluciones[$seqUnidadActo]['fecha'] = new DateTime($objRes->fields['fchActo']);
            $this->arrResoluciones[$seqUnidadActo]['total'] += doubleval($objRes->fields['valIndexado']);
            if(intval($seqRegistroPresupuestal)) {
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['proyectoInversion'] = $objRes->fields['numProyectoInversionCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroCDP'] = $objRes->fields['numNumeroCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaCDP'] = new DateTime($objRes->fields['fchFechaCDP']);
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorCDP'] = $objRes->fields['numValorCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorCDP'] = $objRes->fields['valValorCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['vigenciaCDP'] = $objRes->fields['numVigenciaCDP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'] = $objRes->fields['numNumeroRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP'] = new DateTime($objRes->fields['fchFechaRP']);
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP'] = $objRes->fields['numValorRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP'] = $objRes->fields['valValorRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['vigenciaRP'] = $objRes->fields['numVigenciaRP'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['seqProyecto'] = $objRes->fields['seqProyecto'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['proyecto'] = $objRes->fields['txtNombreProyecto'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['seqConjunto'] = $objRes->fields['seqConjunto'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['conjunto'] = $objRes->fields['txtNombreConjunto'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['unidad'] = $objRes->fields['txtNombreUnidad'];
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['valor'] = $objRes->fields['valIndexado'];
            }

            $objRes->MoveNext();
        }

    }

    private function liberaciones($seqProyecto){
        global $aptBd;

        $sql = "
            select distinct
                lib.seqLiberacion, 
                uvi.seqProyecto,
                lib.seqUnidadActo,
                lib.seqRegistroPresupuestal,
                lib.valLiberado,
                lib.fchLiberacion,
                concat(usu.txtNombre, ' ',usu.txtApellido) as txtUsuario
            from t_pry_aad_liberacion lib
            inner join t_cor_usuario usu on lib.seqUsuario = usu.seqUsuario
            inner join t_pry_aad_unidades_vinculadas uvi on lib.seqRegistroPresupuestal = uvi.seqRegistroPresupuestal
            where uvi.seqProyecto = $seqProyecto
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqLiberacion = $objRes->fields['seqLiberacion'];
            $seqUnidadActo = $objRes->fields['seqUnidadActo'];
            $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];

            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['total'] += $objRes->fields['valLiberado'];
            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['valor'] = $objRes->fields['valLiberado'];
            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['fecha'] = new DateTime($objRes->fields['fchLiberacion']);
            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['usuario'] = $objRes->fields['txtUsuario'];

            foreach($this->arrResoluciones as $seqUnidadActoResolucion => $arrResoluciones){
                foreach($arrResoluciones['cdp'] as $seqRegistroPresupuestalResolucion => $arrCDP){
                    if($seqRegistroPresupuestalResolucion == $seqRegistroPresupuestal and $seqUnidadActo != $seqUnidadActoResolucion){

                        $this->arrResoluciones[$seqUnidadActoResolucion]['liberaciones'] += $objRes->fields['valLiberado'];
                        $this->arrResoluciones[$seqUnidadActoResolucion]['saldo'] =
                            $this->arrResoluciones[$seqUnidadActoResolucion]['total'] +
                            $this->arrResoluciones[$seqUnidadActoResolucion]['liberaciones'];

                        $this->arrResoluciones[$seqUnidadActo]['liberaciones'] += $objRes->fields['valLiberado'];
                        $this->arrResoluciones[$seqUnidadActo]['saldo'] =
                            $this->arrResoluciones[$seqUnidadActo]['total'] -
                            $this->arrResoluciones[$seqUnidadActo]['liberaciones'];

                        $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['liberaciones'] += $objRes->fields['valLiberado'];
                        $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['saldo'] =
                            $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['valorRP'] +
                            $this->arrResoluciones[$seqUnidadActoResolucion]['cdp'][$seqRegistroPresupuestalResolucion]['liberaciones'];
                    }
                }
            }

            $objRes->MoveNext();
        }

    }

    private function giros($seqProyecto){

    }

    public function salvarLiberacion($arrPost){
        global $aptBd;

        // carga la infomacion previa para hacer las validaciones
        $this->informacionResoluciones($arrPost['seqProyecto']);

        // datos necesarios
        $valLiberado = doubleval(mb_ereg_replace("[^0-9]","", $arrPost['valor']));
        $seqUnidadActoPrimario = $arrPost['seqUnidadActoPrimario'];
        $seqUnidadActo = $arrPost['seqUnidadActo'];
        $seqRegistroPresupuestal = $arrPost['seqRegistroPresupuestal'];

        // validacion del valor
        if($valLiberado == 0){
            $this->arrErrores[] = "No debe dejar vacío el valor a liberar";
        }

        // validacion para liberacion del CDP
        if(isset($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo'])){
            if($valLiberado > $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo']){
                $this->arrErrores[] = "No hay suficientes recursos para liberar del RP " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'] . " del " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP']->format("Y");
            }
        }else{
            if($valLiberado > $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP']){
                $this->arrErrores[] = "No hay suficientes recursos para liberar del RP " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['numeroRP'] . " del " .
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['fechaRP']->format("Y");
            }
        }

        // validacion contra la resolucion de liberacion
        if(isset($this->arrResoluciones[$seqUnidadActoPrimario]['saldo'])){
            if($valLiberado > abs($this->arrResoluciones[$seqUnidadActoPrimario]['saldo'])){
                $this->arrErrores[] = "No hay suficientes recursos para liberar de la resolución " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['numero'] . " del " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['fecha']->format("Y");
            }
        }else{
            if($valLiberado > abs($this->arrResoluciones[$seqUnidadActoPrimario]['total'])){
                $this->arrErrores[] = "No hay suficientes recursos para liberar de la resolución " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['numero'] . " del " .
                    $this->arrResoluciones[$seqUnidadActoPrimario]['fecha']->format("Y");
            }
        }

        // salva registro
        if(empty($this->arrErrores)){

            try{
                $aptBd->BeginTrans();

                $sql = "
                    insert into t_pry_aad_liberacion(
                        seqUnidadActo,
                        seqRegistroPresupuestal,
                        valLiberado,
                        fchLiberacion,
                        seqUsuario
                    ) values (
                        $seqUnidadActoPrimario,
                        $seqRegistroPresupuestal,
                        " . ($valLiberado * -1) . ",
                        now(),
                        " . $_SESSION['seqUsuario'] . "  
                    )
                ";
                $aptBd->execute($sql);

                $this->arrMensajes[] = "Registro de liberación de recursos ha sido salvado";

                // carga la informacion posterior a la salvada del registro
                $this->informacionResoluciones($arrPost['seqProyecto']);

                $aptBd->CommitTrans();
            } catch ( Exception $objError ){
                $aptBd->RollbackTrans();
                $this->arrErrores[] = $objError->getMessage();
                $this->Mensajes[] = array();
            }

        }

    }

    public function eliminarLiberacion($arrPost){
        global $aptBd;

        try{
            $aptBd->BeginTrans();

            $sql = "
                delete 
                from t_pry_aad_liberacion
                where seqLiberacion = " . $arrPost['seqLiberacion'] . "
            ";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Registro de liberación de recursos eliminado";

            // carga la informacion posterior a la salvada del registro
            $this->informacionResoluciones($arrPost['seqProyecto']);

            $aptBd->CommitTrans();
        } catch ( Exception $objError ){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
            $this->Mensajes[] = array();
        }

    }

    /**
     * OBTIENE LOS DATOS CARGADOS EN EL ARCHIVO
     * SEA UN EXCEL O UN ARCHIVO PLANO
     * @return array
     */
    public function cargarArchivo(){

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

        if( empty( $this->arrErrores ) ){

            // si es un archivo de texto obtiene los datos
            if( $_FILES['archivo']['type'] == "text/plain" ){
                foreach( file( $_FILES['archivo']['tmp_name'] ) as $numLinea => $txtLinea ){
                    if( trim( $txtLinea ) != "" ) {
                        $arrArchivo[$numLinea] = explode("\t", trim($txtLinea));
                        foreach( $arrArchivo[$numLinea] as $numColumna => $txtCelda ){
                            if( $numColumna < count( $this->arrFormatoArchivo ) ) {
                                $arrArchivo[$numLinea][$numColumna] = trim($txtCelda);
                            }else{
                                unset( $arrArchivo[$numLinea][$numColumna] );
                            }
                        }
                    }
                }
            }else{

                try{

                    // crea las clases para la obtencion de los datos
                    $txtTipoArchivo = PHPExcel_IOFactory::identify($_FILES['archivo']['tmp_name']);
                    $objReader = PHPExcel_IOFactory::createReader($txtTipoArchivo);
                    $objPHPExcel = $objReader->load($_FILES['archivo']['tmp_name']);
                    $objHoja = $objPHPExcel->getSheet(0);

                    // obtiene las dimensiones del archivo para la obtencion del contenido por rangos
                    $numFilas = $objHoja->getHighestRow();
                    $numColumnas = PHPExcel_Cell::columnIndexFromString( $objHoja->getHighestColumn() ) - 1;

                    // obtiene los datos del rango obtenido
                    for( $numFila = 1; $numFila <= $numFilas; $numFila++ ){
                        for( $numColumna = 0; $numColumna < $numColumnas; $numColumna++ ){
                            $numFilaArreglo = $numFila - 1;
                            $arrArchivo[$numFilaArreglo][$numColumna] = $objHoja->getCellByColumnAndRow($numColumna,$numFila)->getValue();
                            if( $this->arrFormatoArchivo[$numColumna]['tipo'] == "fecha" and is_numeric( $arrArchivo[$numFilaArreglo][$numColumna] ) ) {
                                $claFecha = PHPExcel_Shared_Date::ExcelToPHPObject($arrArchivo[$numFilaArreglo][$numColumna]);
                                $arrArchivo[$numFilaArreglo][$numColumna] = $claFecha->format("Y-m-d");

                            }
                        }
                    }

                    // si no tiene la celda de clave llena no carga
                    if( $objPHPExcel->getProperties()->getCreator() == $this->txtCreador ) {

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

                    }else{
                        $this->arrErrores[] = "No se va a cargar el archivo porque no corresponde a la plantilla que se obtiene de la aplicación";
                    }

                } catch ( Exception $objError ){
                    $this->arrErrores[] = $objError->getMessage();
                }


            }

        }

        if(count($arrArchivo) == 1){
            $this->arrErrores[] = "Un archivo que contiene solo los titulos se considera vacío";
        }

        return $arrArchivo;
    }

    public function validarArchivo($arrPost, $arrArchivo){

        $this->validarTitulos($arrArchivo[0]);

        $arrRetorno = array();

        for($i = 1; $i < count($arrArchivo); $i++){

            $seqProyecto       = intval($arrArchivo[$i][0]);
            $txtNombreProyecto = trim(mb_strtolower($arrArchivo[$i][1]));
            $seqUnidadProyecto = intval($arrArchivo[$i][2]);
            $txtUnidadProyecto = trim(mb_strtolower($arrArchivo[$i][3]));
            $valGiro           = doubleval($arrArchivo[$i][5]);

            // valida el identificador del proyecto
            if($seqProyecto == 0){
                $this->arrErrores[] = "Error linea " . ($i + 1) . ": El valor de la columna " . $this->arrTitulos[0] . " no es válido";
            }else{

                // debe coincidir el identificador del proyecto con el identificador en el archivo
                $arrProyecto = obtenerDatosTabla(
                    "t_pry_proyecto",
                    array("0", "seqProyecto","seqProyectoPadre"),
                    "0",
                    "seqProyecto = '" . $seqProyecto . "'"
                );

                // debe coincidir el proyecto en el arcivo con el del formulario
                if($arrPost['seqProyecto'] != $arrProyecto[0]['seqProyecto'] and $arrPost['seqProyecto'] != $arrProyecto[0]['seqProyectoPadre']){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El proyecto no coincide con el seleccionado en el formulario";
                }

                // debe coincidir el nombre del proyecto con el identificador en el archivo
                $arrProyecto = obtenerDatosTabla(
                    "t_pry_proyecto",
                    array("lower(txtNombreProyecto)","seqProyecto","seqProyectoPadre"),
                    "lower(txtNombreProyecto)",
                    "lower(txtNombreProyecto) = '" . $txtNombreProyecto . "'"
                );

                if($arrProyecto[$txtNombreProyecto]['seqProyecto'] != $seqProyecto and $arrProyecto[$txtNombreProyecto]['seqProyectoPadre'] != $seqProyecto){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El identificador del proyecto no coincide con el nombre consignado en el archivo";
                }

            }

            // cantidad de unidades del proyecto
            $numUnidades = array_shift(
                obtenerDatosTabla(
                    "t_pry_unidad_proyecto",
                    array("seqProyecto","count(seqUnidadProyecto) as cantidad"),
                    "seqProyecto",
                    "seqProyecto = " . $seqProyecto
                )
            );

            // validacion de los campos de las unidades
            if($numUnidades == 0){
                if($seqUnidadProyecto != 0){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El proyecto no tiene unidades relacionadas, no debe tener identificador de unidad";
                }
                if($txtUnidadProyecto != ""){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El proyecto no tiene unidades relacionadas, no debe tener nombre de unidad";
                }
            }else{

                // validacion del dato de la unidad
                if($seqUnidadProyecto == 0){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El valor de la columna " . $this->arrTitulos[2] . " no es válido";
                }
                if($txtUnidadProyecto == ""){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El valor de la columna " . $this->arrTitulos[3] . " no es válido";
                }

                // datos de la unidad
                $arrUnidad = obtenerDatosTabla(
                    "t_pry_unidad_proyecto",
                    array("seqUnidadProyecto","lower(txtNombreUnidad) as txtNombreUnidad","seqProyecto"),
                    "seqUnidadProyecto",
                    "seqUnidadProyecto = " . $seqUnidadProyecto
                );

                // la unidad debe coincidir en nombre e identificador
                if($arrUnidad[$seqUnidadProyecto]['txtNombreUnidad'] != $txtUnidadProyecto){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El nombre de la unidad no coincide con el identificador";
                }

                // la unidad debe pertenecer al proyecto
                if($arrUnidad[$seqUnidadProyecto]['seqProyecto'] != $seqProyecto){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": La unidad no pertenece al proyecto";
                }

            }

            // validacion del monto agirar
            if(! is_numeric($arrArchivo[$i][5])){
                $this->arrErrores[] = "Error linea " . ($i + 1) . ": El valor de la columna " . $this->arrTitulos[5] . " no es válido";
            }

            if(empty($this->arrErrores)){
                if($valGiro != 0) {
                    $seqProyecto = $arrPost['seqProyecto'];
                    $seqUnidadActo = $arrPost['seqUnidadActo'];
                    $seqRegistroPresupuestal = $arrPost['seqRegistroPresupuestal'];
                    $arrRetorno[$seqProyecto][$seqUnidadActo][$seqRegistroPresupuestal][$seqUnidadProyecto] = $valGiro;
                }
            }

        }

        return $arrRetorno;
    }

    private function validarTitulos($arrTitulos){
        foreach($this->arrTitulos as $i => $txtTitulo){
            if(mb_strtolower(trim($txtTitulo)) != mb_strtolower(trim($arrTitulos[$i]))){
                $this->arrErrores[] = "La columna del archivo " . $txtTitulo . " no se encuentra o no está en el lugar correcto";
            }
        }
    }

    public function salvarGiro($arrPost){
        global $aptBd;

        /**
         * VALIDACIONES DE LOS CAMPOS
         */

        if($arrPost['seqProyecto'] == 0){
            $this->arrErrores[] = "Seleccione el proyecto para el que desea hacer el giro";
        }

        if($arrPost['seqUnidadActo'] == 0){
            $this->arrErrores[] = "Seleccione el acto administrativo para el que desea hacer el giro";
        }

        if($arrPost['seqRegistroPresupuestal'] == 0){
            $this->arrErrores[] = "Seleccione el registro presupuestal para el que desea hacer el giro";
        }

        if((! isset($arrPost['unidades'])) or empty($arrPost['unidades'])){
            $this->arrErrores[] = "No ha seleccionado las unidades para el giro";
        }

        if(trim($arrPost['txtCertificacion']) == ""){
            $this->arrErrores[] = "No puede dejar el campo Certificacion vacío";
        }

        if((! isset($arrPost['documentos'])) or empty($arrPost['documentos'])){
            $this->arrErrores[] = "Seleccione al menos un documento para salvar el giro";
        }

        if(trim($arrPost['txtSubsecretario']) == "" and trim($arrPost['txtSubdirector']) == ""){
            $this->arrErrores[] = "Debe estar al menos el nombre del Subsecretario o el del Subdirector";
        }

        if(trim($arrPost['txtReviso']) == ""){
            $this->arrErrores[] = "Debe dar el nombre de quien revisa el documento";
        }

        /**
         * SALVA EL REGISTRO
         */

        if(empty($this->arrErrores)){

            try{
                $aptBd->BeginTrans();



//                $sql = "
//                    insert into t_pry_giro_fiducia (
//                      seqGiroFiducia,
//                      numSecuencia,
//                      txtCertificacion,
//                      bolCedulaOferente,
//                      bolRitOferente,
//                      bolRutOferente,
//                      bolExistenciaOferente,
//                      bolConstitucionFiducia,
//                      bolCedulaFiducia,
//                      bolBancariaFiducia,
//                      bolSuperintendenciaFiducia,
//                      bolCamaraFiducia,
//                      bolRutFiducia,
//                      bolResolucionProyecto,
//                      bolMemorandoProyecto,
//                      fchCreacion,
//                      seqUsuario
//                  )
//                "


                $aptBd->CommitTrans();
            } catch ( Exception $objError ){
                $aptBd->RollbackTrans();
                $this->arrErrores[] = $objError->getMessage();
            }

        }

    }


}


?>