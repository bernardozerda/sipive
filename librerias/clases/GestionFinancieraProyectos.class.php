<?php

class GestionFinancieraProyectos
{

    public $arrProyectos;
    public $arrFiducia;
    public $arrResoluciones;
    public $arrGiroConstructor;
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
        $this->arrGiroConstructor = array();
        $this->arrErrores = array();
        $this->arrMensajes = array();
        $this->arrExtensiones = array("txt","xls","xlsx");
        $this->txtCreador = "SiPIVE - SDHT";

        $this->arrTitulos['giroFiducia'][] = "Identificador del Proyecto";
        $this->arrTitulos['giroFiducia'][] = "Nombre del Proyecto";
        $this->arrTitulos['giroFiducia'][] = "Identificador de la Unidad";
        $this->arrTitulos['giroFiducia'][] = "Descripcion de la Unidad";
        $this->arrTitulos['giroFiducia'][] = "Valor a Girar";
        $this->arrTitulos['giroConstructor'][] = "Identificador del Proyecto";
        $this->arrTitulos['giroConstructor'][] = "Nombre del Proyecto";
        $this->arrTitulos['giroConstructor'][] = "Identificador de la Unidad";
        $this->arrTitulos['giroConstructor'][] = "Descripcion de la Unidad";
        $this->arrTitulos['giroConstructor'][] = "Disponible";
        $this->arrTitulos['giroConstructor'][] = "Valor a Girar";

    }

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

        // calcula saldos
        foreach($this->arrResoluciones as $seqUnidadActo => $arrResolucion){

            // saldo por resolucion
            $this->arrResoluciones[$seqUnidadActo]['saldo'] =
                doubleval( $this->arrResoluciones[$seqUnidadActo]['total'] ) -
                doubleval( $this->arrResoluciones[$seqUnidadActo]['liberaciones'] ) -
                doubleval( $this->arrResoluciones[$seqUnidadActo]['giros'] );

            // saldo por RP
            if(is_array($arrResolucion['cdp'])) {
                foreach ($arrResolucion['cdp'] as $seqRegistroPresupuestal => $arrCDP) {
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['saldo'] =
                        doubleval($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['valorRP']) +
                        doubleval($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['liberaciones']) -
                        doubleval($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['giros']);
                }
            }
        }

    }

    private function datosBasicos($seqProyecto){
        global $aptBd;

        $sql = "
            select
                uac.seqUnidadActo,
                uac.seqTipoActoUnidad,
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
                uvi.valIndexado,
                if(upr.seqUnidadProyecto is null,if(pry.seqProyecto is null,con.bolActivo,pry.bolActivo),upr.bolActivo) as bolActivo
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
            $this->arrResoluciones[$seqUnidadActo]['idTipo'] = $objRes->fields['seqTipoActoUnidad'];
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
                $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['activo'] = $objRes->fields['bolActivo'];
            }

            $objRes->MoveNext();
        }

    }

    private function liberaciones($seqProyecto){
        global $aptBd;

        $arrRegistrosPresupuestales = $this->obtenerRegistrosPresupuestales();

        if(! empty($arrRegistrosPresupuestales) ) {
            $sql = "
                select distinct
                    lib.seqLiberacion,
                    lib.seqUnidadActo,
                    if(con.seqProyectoPadre is null,con.seqProyecto,con.seqProyectoPadre) as seqProyecto,
                    lib.seqRegistroPresupuestal,
                    lib.valLiberado,
                    lib.fchLiberacion,
                    concat(usu.txtNombre,' ',usu.txtApellido) as txtUsuario
                from t_pry_aad_liberacion lib
                inner join t_pry_aad_unidades_vinculadas uvi on lib.seqUnidadActo = uvi.seqUnidadActo
                inner join t_pry_proyecto con on uvi.seqProyecto = con.seqProyecto
                inner join t_cor_usuario usu on lib.seqUsuario = usu.seqUsuario
                where lib.seqRegistroPresupuestal in (" . implode(",", array_keys($arrRegistrosPresupuestales)) . ");        
            ";
            $objRes = $aptBd->execute($sql);
            $arrDetalle = array();
            while ($objRes->fields) {

                $seqLiberacion = $objRes->fields['seqLiberacion'];
                $seqUnidadActo = $objRes->fields['seqUnidadActo'];
                $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];

                // acumulado para la resolucion de liberacion
                if (isset($this->arrResoluciones[$seqUnidadActo])) {
                    $this->arrResoluciones[$seqUnidadActo]['liberaciones'] += $objRes->fields['valLiberado'];
                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal] = $arrRegistrosPresupuestales[$seqRegistroPresupuestal];

                    if(isset($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal])) {
                        $arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['valor'] = $objRes->fields['valLiberado'];
                        $arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['fecha'] = new DateTime($objRes->fields['fchLiberacion']);
                        $arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'][$seqLiberacion]['usuario'] = $objRes->fields['txtUsuario'];
                    }

                }

                // acumulado de liberciones por RP
                $arrRegistrosPresupuestales[$seqRegistroPresupuestal]['liberaciones'] += $objRes->fields['valLiberado'];

                $objRes->MoveNext();
            }

            foreach($this->arrResoluciones as $seqUnidadActo => $arrResolucion){
                if(is_array($arrResolucion['cdp'])) {
                    foreach ($arrResolucion['cdp'] as $seqRegistroPresupuestal => $arrCDP) {
                        if (isset($arrRegistrosPresupuestales[$seqRegistroPresupuestal])) {
                            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal] = $arrRegistrosPresupuestales[$seqRegistroPresupuestal];
                        }
                        if (isset($arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal])) {
                            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'] = $arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['detalle'];
                        }
                    }
                }
            }


        }
    }

    private function giros($seqProyecto){
        global $aptBd;

        $arrRegistrosPresupuestales = $this->obtenerRegistrosPresupuestales();

        if(! empty($arrRegistrosPresupuestales) ) {

            $sql = "
                select
                    gfi.seqGiroFiducia,
                    gfd.seqUnidadActo,
                    if(pry.seqProyectoPadre is null,gfd.seqProyecto,pry.seqProyectoPadre) as seqProyecto,
                    gfd.seqUnidadProyecto,
                    gfd.seqRegistroPresupuestal,
                    gfd.valGiro
                from t_pry_aad_giro_fiducia gfi
                inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
                inner join t_pry_proyecto pry on gfd.seqProyecto = pry.seqProyecto
                where gfd.seqRegistroPresupuestal in (" . implode("," , array_keys($arrRegistrosPresupuestales)) . ")            
            ";

            $objRes = $aptBd->execute($sql);
            $arrDetalle = array();
            while($objRes->fields){

                $seqGiroFiducia = $objRes->fields['seqGiroFiducia'];
                $seqUnidadActo = $objRes->fields['seqUnidadActo'];
                $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];
                $seqUnidadProyecto = intval($objRes->fields['seqUnidadProyecto']);

                // acumula el saldo por resolucion
                if(isset($this->arrResoluciones[$seqUnidadActo])){
                    $this->arrResoluciones[$seqUnidadActo]['giros'] += $objRes->fields['valGiro'];

                    $arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['detalle'][$seqGiroFiducia] = $objRes->fields['valGiro'];

                }

                // acumulado de giros por RP
                $arrRegistrosPresupuestales[$seqRegistroPresupuestal]['giros'] += $objRes->fields['valGiro'];

                $objRes->MoveNext();
            }

            // acumulado de giros por RP
            if(is_array($this->arrResoluciones)) {
                foreach ($this->arrResoluciones as $seqUnidadActo => $arrResolucion) {
                    foreach ($arrResolucion['cdp'] as $seqRegistroPresupuestal => $arrCDP) {
                        if (isset($arrRegistrosPresupuestales[$seqRegistroPresupuestal])) {
                            $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['giros'] = $arrRegistrosPresupuestales[$seqRegistroPresupuestal]['giros'];
                        }
                        if (isset($arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal])) {
                            foreach ($arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'] as $seqUnidadProyecto => $arrDetalleGiro) {
                                if (isset($this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto])) {
                                    $this->arrResoluciones[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['detalle'] =
                                        $arrDetalle[$seqUnidadActo]['cdp'][$seqRegistroPresupuestal]['unidades'][$seqUnidadProyecto]['detalle'];
                                }
                            }
                        }
                    }
                }
            }

        }
    }

    private function obtenerRegistrosPresupuestales(){
        $arrRegistrosPresupuestales = array();
        foreach($this->arrResoluciones as $seqUnidadActo => $arrResolucion){
            if(isset($arrResolucion['cdp'])){
                foreach ($arrResolucion['cdp'] as $seqRegistroPresupuestal => $arrCDP){
                    $arrRegistrosPresupuestales[$seqRegistroPresupuestal] = $arrCDP;
                }
            }
        }
        return $arrRegistrosPresupuestales;
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

    public function validarArchivo($arrPost, $arrArchivo, $txtFormato){

        $this->validarTitulos($arrArchivo[0], $txtFormato);

        $arrRetorno = array();

        for($i = 1; $i < count($arrArchivo); $i++){

            $seqProyecto       = intval($arrArchivo[$i][0]);
            $txtNombreProyecto = trim(mb_strtolower($arrArchivo[$i][1]));
            $seqUnidadProyecto = intval($arrArchivo[$i][2]);
            $txtUnidadProyecto = trim(mb_strtolower($arrArchivo[$i][3]));
            if($txtFormato == "giroConstructor") {
                $valDisponible = doubleval($arrArchivo[$i][4]);
                $valGiro       = $arrArchivo[$i][5];
            }else{
                $valDisponible = null;
                $valGiro       = $arrArchivo[$i][4];
            }

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
            $numUnidades = $this->cantidadUnidades($seqProyecto);

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
                $arrUnidad = $this->proyectoUnidad($seqUnidadProyecto);

                // la unidad debe coincidir en nombre e identificador
                if($arrUnidad[$seqUnidadProyecto]['txtNombreUnidad'] != $txtUnidadProyecto){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": El nombre de la unidad no coincide con el identificador";
                }

                // la unidad debe pertenecer al proyecto
                if($arrUnidad[$seqUnidadProyecto]['seqProyecto'] != $seqProyecto){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": La unidad no pertenece al proyecto";
                }

            }

            if($txtFormato == "giroConstructor"){
                if(doubleval($valGiro) > $valDisponible){
                    $this->arrErrores[] = "Error linea " . ($i + 1) . ": No puede girar un monto mayor al disponible";
                }
            }

            // validacion del monto agirar
            if(! is_numeric($valGiro)){
                $this->arrErrores[] = "Error linea " . ($i + 1) . ": El valor de la columna " . $this->arrTitulos[5] . " no es válido";
            }

            if(empty($this->arrErrores)){
                if(doubleval($valGiro) != 0) {

                    $seqProyecto = $arrPost['seqProyecto'];

                    if($txtFormato == "giroConstructor"){
                        $arrRetorno[$seqProyecto][$seqUnidadProyecto] = $valGiro;
                    }else {
                        $seqUnidadActo = $arrPost['seqUnidadActo'];
                        $seqRegistroPresupuestal = $arrPost['seqRegistroPresupuestal'];
                        $arrRetorno[$seqProyecto][$seqUnidadActo][$seqRegistroPresupuestal][$seqUnidadProyecto] = $valGiro;
                    }
                }
            }

        }

        return $arrRetorno;
    }

    private function validarTitulos($arrTitulos, $txtFormato){
        $arrValidar = $this->arrTitulos[$txtFormato];
        if(! empty($arrValidar)) {
            foreach ($arrValidar as $i => $txtTitulo) {
                if (mb_strtolower(trim($txtTitulo)) != mb_strtolower(trim($arrTitulos[$i]))) {
                    $this->arrErrores[] = "La columna del archivo " . $txtTitulo . " no se encuentra o no está en el lugar correcto";
                }
            }
        }else{
            $this->arrErrores[] = "Formato de archivo desconocido o no esta definido ($txtFormato)";
        }
    }

    public function salvarGiroFiducia($arrPost){
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

        $arrPost['txtSubsecretario'] = (trim($arrPost['txtSubsecretario']) == "")? "null" :  trim($arrPost['txtSubsecretario']);
        $arrPost['txtSubdirector']   = (trim($arrPost['txtSubdirector']) == "")? "null"   :  trim($arrPost['txtSubdirector']);
        $arrPost['txtReviso']        = (trim($arrPost['txtReviso']) == "")? "null"        :  trim($arrPost['txtReviso']);

        /**
         * SALVA EL REGISTRO
         */

        if(empty($this->arrErrores)){

            try{
                $aptBd->BeginTrans();

                $sql = "
                    insert into t_pry_aad_giro_fiducia (
                      numSecuencia,
                      txtCertificacion,
                      bolCedulaOferente,
                      bolRitOferente,
                      bolRutOferente,
                      bolExistenciaOferente,
                      bolConstitucionFiducia,
                      bolCedulaFiducia,
                      bolBancariaFiducia,
                      bolSuperintendenciaFiducia,
                      bolCamaraFiducia,
                      bolRutFiducia,
                      bolResolucionProyecto,
                      bolMemorandoProyecto,
                      txtSubsecretario,
                      bolEncargoSubsecretario,
                      txtSubdirector,
                      bolEncargoSubdirector,
                      txtReviso,
                      fchCreacion,
                      seqUsuario
                  ) values (
                      " . $this->obtenerSecuencia($arrPost['seqProyecto']) . ",
                      '" . mb_strtoupper($arrPost['txtCertificacion']) . "',
                      " . intval($arrPost['documentos']['bolCedulaOferente']) . ",  
                      " . intval($arrPost['documentos']['bolRitOferente']) . ",  
                      " . intval($arrPost['documentos']['bolRutOferente']) . ",  
                      " . intval($arrPost['documentos']['bolExistenciaOferente']) . ",  
                      " . intval($arrPost['documentos']['bolConstitucionFiducia']) . ",  
                      " . intval($arrPost['documentos']['bolCedulaFiducia']) . ",  
                      " . intval($arrPost['documentos']['bolBancariaFiducia']) . ",  
                      " . intval($arrPost['documentos']['bolSuperintendenciaFiducia']) . ",  
                      " . intval($arrPost['documentos']['bolCamaraFiducia']) . ",  
                      " . intval($arrPost['documentos']['bolRutFiducia']) . ",  
                      " . intval($arrPost['documentos']['bolResolucionProyecto']) . ",  
                      " . intval($arrPost['documentos']['bolMemorandoProyecto']) . ",  
                      '" . $arrPost['txtSubsecretario'] . "',
                      " . intval($arrPost['bolEncargoSubsecretario']) . ",
                      '" . $arrPost['txtSubdirector'] . "',
                      " . intval($arrPost['bolEncargoSubdirector']) . ",
                      '" . $arrPost['txtReviso'] . "',
                      now(),
                      " . $_SESSION['seqUsuario'] . "
                  )
                ";
                $aptBd->execute($sql);

                $seqGiroFiducia = $aptBd->Insert_ID();

                $seqProyecto = $arrPost['seqProyecto'];
                $seqUnidadActo = $arrPost['seqUnidadActo'];
                $seqRegistroPresupuestal = $arrPost['seqRegistroPresupuestal'];

                foreach ($arrPost['unidades'][$seqProyecto][$seqUnidadActo][$seqRegistroPresupuestal] as $seqUnidadProyecto => $valGiro){

                    if(intval($seqUnidadProyecto) != 0) {
                        $seqProyectoInsertar = array_shift(
                            obtenerDatosTabla(
                                "t_pry_unidad_proyecto",
                                array("seqUnidadProyecto", "seqProyecto"),
                                "seqUnidadProyecto",
                                "seqUnidadProyecto = " . $seqUnidadProyecto
                            )
                        );
                    }else{
                        $seqProyectoInsertar = $seqProyecto;
                        $seqUnidadProyecto = "null";
                    }
                    $sql = "
                        insert into t_pry_aad_giro_fiducia_detalle(
                            seqGiroFiducia, 
                            seqProyecto, 
                            seqUnidadActo, 
                            seqRegistroPresupuestal, 
                            seqUnidadProyecto, 
                            valGiro
                        ) values (
                            $seqGiroFiducia,
                            $seqProyectoInsertar,
                            $seqUnidadActo,
                            $seqRegistroPresupuestal,
                            $seqUnidadProyecto,
                            $valGiro
                        ) 
                    ";
                    $aptBd->execute($sql);
                }

                $this->arrMensajes[] = "Registro salvado satisfactoriamente";

                $aptBd->CommitTrans();

                return $seqGiroFiducia;

            } catch ( Exception $objError ){
                $aptBd->RollbackTrans();
                $this->arrMensajes = array();
                $this->arrErrores[] = $objError->getMessage();

                return 0;
            }

        }

    }

    private function obtenerSecuencia($seqProyecto){
        global $aptBd;

        $sql = "
            select 
              if(max(gfi.numSecuencia) is null, 0 ,max(gfi.numSecuencia)) + 1 as numSecuencia
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            where gfd.seqProyecto in (
                select seqProyecto
                from t_pry_proyecto pry
                where pry.seqProyecto = $seqProyecto
                   or pry.seqProyectoPadre = $seqProyecto
            ) and year(gfi.fchCreacion) = year(now())
        ";
        return array_shift($aptBd->GetAll($sql))['numSecuencia'];
    }

    public function pdfGiroFiducia($seqProyecto, $seqGiroFiducia){
        global $aptBd;

        $arrDatosFormato = array();

        $sql = "
            select 
                upper(pry.txtNombreProyecto) as txtNombreProyecto,
                upper(pry.txtNombreVendedor) as txtNombreVendedor,
                pry.numNitVendedor,
                pry.seqDatoFiducia,
                ban.txtBanco, 
                ban.numNit,
                dfi.numContrato, 
                dfi.fchContrato, 
                dfi.numCuenta, 
                dfi.txtTipoCuenta
            from t_pry_proyecto pry
            left join t_pry_datos_fiducia dfi on pry.seqDatoFiducia = dfi.seqDatoFiducia
            left join t_frm_banco ban on dfi.seqBanco = ban.seqBanco
            where seqProyecto = $seqProyecto          
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $arrDatosFormato['secciones']['Beneficiario del giro'][0][0] = "Nombre del Vendedor";
            $arrDatosFormato['secciones']['Beneficiario del giro'][0][1] = $objRes->fields['txtNombreVendedor'];;

            $arrDatosFormato['secciones']['Beneficiario del giro'][1][0] = "NIT del Vendedor";
            $arrDatosFormato['secciones']['Beneficiario del giro'][1][1] = $objRes->fields['numNitVendedor'];

            $arrDatosFormato['secciones']['Beneficiario del giro'][2][0] = "Nombre del Proyecto";
            $arrDatosFormato['secciones']['Beneficiario del giro'][2][1] = $objRes->fields['txtNombreProyecto'];

            $arrDatosFormato['secciones']['Información para el giro'][0][0] = "Número del contrato suscrito";
            $arrDatosFormato['secciones']['Información para el giro'][0][1] = (intval($objRes->fields['numContrato']) == 0)? "No disponible" : number_format(intval($objRes->fields['numContrato']),0,',','.');

            $arrDatosFormato['secciones']['Información para el giro'][1][0] = "Fecha del contrato suscrito";
            $arrDatosFormato['secciones']['Información para el giro'][1][1] = (!esFechaValida($objRes->fields['fchContrato']))? "No disponible" : strftime("%d de %B de %Y" , strtotime( $objRes->fields['fchContrato'] ) );

            $arrDatosFormato['secciones']['Información para el giro'][3][0] = "Nombre de la entidad financiera";
            $arrDatosFormato['secciones']['Información para el giro'][3][1] = $objRes->fields['txtBanco'];

            $arrDatosFormato['secciones']['Información para el giro'][4][0] = "NIT de la entidad financiera";
            $arrDatosFormato['secciones']['Información para el giro'][4][1] = $objRes->fields['numNit'];

            $arrDatosFormato['secciones']['Información para el giro'][5][0] = "Número de cuenta";
            $arrDatosFormato['secciones']['Información para el giro'][5][1] = $objRes->fields['numCuenta'];

            $arrDatosFormato['secciones']['Información para el giro'][5][0] = "Tipo de cuenta";
            $arrDatosFormato['secciones']['Información para el giro'][5][1] = $objRes->fields['txtTipoCuenta'];

            $objRes->MoveNext();
        }

        $sql = "
            SELECT
                gfi.numSecuencia,
                gfi.txtCertificacion,
                gfi.bolCedulaOferente,
                gfi.bolRitOferente,
                gfi.bolRutOferente,
                gfi.bolExistenciaOferente,
                gfi.bolConstitucionFiducia,
                gfi.bolCedulaFiducia,
                gfi.bolBancariaFiducia,
                gfi.bolSuperintendenciaFiducia,
                gfi.bolCamaraFiducia,
                gfi.bolRutFiducia,
                gfi.bolResolucionProyecto,
                gfi.bolMemorandoProyecto,
                gfi.txtSubsecretario,
                gfi.bolEncargoSubsecretario,
                gfi.txtSubdirector,
                gfi.bolEncargoSubdirector,
                gfi.txtReviso,
                gfi.fchCreacion,
                gfi.seqUsuario,
                concat(usu.txtNombre, ' ', usu.txtApellido) as txtUsuario,
                gfd.seqUnidadActo,
                gfd.seqRegistroPresupuestal,
                count(gfd.seqUnidadProyecto) as numUnidades,
                sum(gfd.valGiro) as valGiros
            FROM t_pry_aad_giro_fiducia gfi
            INNER JOIN t_pry_aad_giro_fiducia_detalle gfd ON gfi.seqGiroFiducia = gfd.seqGiroFiducia
            INNER JOIN t_cor_usuario usu on gfi.seqUsuario = usu.seqUsuario
            WHERE gfi.seqGiroFiducia = $seqGiroFiducia
              AND gfd.seqProyecto IN (
                SELECT pry.seqProyecto
                FROM t_pry_proyecto pry
                WHERE pry.seqProyecto = $seqProyecto 
                   OR pry.seqProyectoPadre = $seqProyecto
              )
            GROUP BY 
                gfi.numSecuencia,
                gfi.txtCertificacion,
                gfi.bolCedulaOferente,
                gfi.bolRitOferente,
                gfi.bolRutOferente,
                gfi.bolExistenciaOferente,
                gfi.bolConstitucionFiducia,
                gfi.bolCedulaFiducia,
                gfi.bolBancariaFiducia,
                gfi.bolSuperintendenciaFiducia,
                gfi.bolCamaraFiducia,
                gfi.bolRutFiducia,
                gfi.bolResolucionProyecto,
                gfi.bolMemorandoProyecto,
                gfi.txtSubsecretario,
                gfi.bolEncargoSubsecretario,
                gfi.txtSubdirector,
                gfi.bolEncargoSubdirector,
                gfi.txtReviso,
                gfi.fchCreacion,
                gfi.seqUsuario,
                concat(usu.txtNombre, ' ', usu.txtApellido),
                gfd.seqUnidadActo,
                gfd.seqRegistroPresupuestal      
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $fchCreacion = new DateTime($objRes->fields['fchCreacion']);

            $arrDatosFormato['secuencia'] = "SDHT-SGF-SDRPL-" . $seqProyecto . "-" . $objRes->fields['numSecuencia'] . "-" . $fchCreacion->format(y);

            $arrDatosFormato['secciones']['Beneficiario del giro'][3][0] = "Valor del giro";
            $arrDatosFormato['secciones']['Beneficiario del giro'][3][1] = "$ " . number_format($objRes->fields['valGiros'],0,',','.');

            $arrDatosFormato['secciones']['Beneficiario del giro'][4][0] = "Cantidad de unidades";
            $arrDatosFormato['secciones']['Beneficiario del giro'][4][1] = number_format($objRes->fields['numUnidades'],0,',','.');


            $arrDatosFormato['certificacion'] = $objRes->fields['txtCertificacion'];

            $arrDatosFormato['documentos']['Del Oferente'][0][0] = "Copia cedula de ciudadanía";
            $arrDatosFormato['documentos']['Del Oferente'][0][1] = (intval($objRes->fields['bolCedulaOferente']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['Del Oferente'][1][0] = "Copia del Registro de Información Tributaria / RIT";
            $arrDatosFormato['documentos']['Del Oferente'][1][1] = (intval($objRes->fields['bolRitOferente']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['Del Oferente'][2][0] = "Copia del Registro Único Tributario / RUT";
            $arrDatosFormato['documentos']['Del Oferente'][2][1] = (intval($objRes->fields['bolRutOferente']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['Del Oferente'][3][0] = "Copia del Certificado de existencia y representación legal";
            $arrDatosFormato['documentos']['Del Oferente'][3][1] = (intval($objRes->fields['bolExistenciaOferente']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][0][0] = "Copia constitución Encargo Fiduciario";
            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][0][1] = (intval($objRes->fields['bolConstitucionFiducia']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][1][0] = "Copia cedula de ciudadanía";
            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][1][1] = (intval($objRes->fields['bolCedulaFiducia']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][2][0] = "Certificación Bancaria de la cuenta en la cual se va a realizar el giro";
            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][2][1] = (intval($objRes->fields['bolBancariaFiducia']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][3][0] = "Copia del Certificado de existencia y representación legal expedido por la Superintendencia Financiera";
            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][3][1] = (intval($objRes->fields['bolSuperintendenciaFiducia']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][4][0] = "Copia del Certificado de existencia y representación legal expedido por la Cámara de Comercio";
            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][4][1] = (intval($objRes->fields['bolCamaraFiducia']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][5][0] = "Copia del Registro Único Tributario – RUT de la entidad financiera";
            $arrDatosFormato['documentos']['De la Entidad Financiera con la cual se constituyó el  Encargo Fiduciario'][5][1] = (intval($objRes->fields['bolRutFiducia']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['Del Proyecto'][0][0] = "Copia Resolución 488 de 2016 y 541 de 2016";
            $arrDatosFormato['documentos']['Del Proyecto'][0][1] = (intval($objRes->fields['bolResolucionProyecto']) == 1)? "SI" : "NO";

            $arrDatosFormato['documentos']['Del Proyecto'][1][0] = "Copia memorando de solicitud de aprobación póliza de cumplimiento mediante radicado No. 3-2015-35230- con fecha del 05 junio de 2015";
            $arrDatosFormato['documentos']['Del Proyecto'][1][1] = (intval($objRes->fields['bolMemorandoProyecto']) == 1)? "SI" : "NO";


            switch(true){

                // ambas firmas
                case $objRes->fields['txtSubdirector'] != "" and $objRes->fields['txtSubsecretario'] != "":

                    $txtEncargoSubdirector = ($objRes->fields['bolEncargoSubdirector'] == 1) ? "(E)" : "";
                    $txtEncargoSubsecretario = ($objRes->fields['bolEncargoSubsecretario'] == 1) ? "(E)" : "";

                    $arrDatosFormato['firmas'][0][0] = utf8_decode("Subdirector(a) de Recursos Públicos " . $txtEncargoSubdirector);
                    $arrDatosFormato['firmas'][1][0] = utf8_decode(mb_strtoupper($objRes->fields['txtSubdirector']) );
                    $arrDatosFormato['firmas'][0][1] = utf8_decode("Subsecretario(a) de Gestión Financiera " . $txtEncargoSubsecretario);
                    $arrDatosFormato['firmas'][1][1] = utf8_decode(mb_strtoupper($objRes->fields['txtSubsecretario']));

                    break;

                // solo firma el secretario
                case $objRes->fields['txtSubdirector'] == "" and $objRes->fields['txtSubsecretario'] != "":

                    $txtEncargoSubsecretario = ($objRes->fields['bolEncargoSubsecretario'] == 1) ? "(E)" : "";

                    $arrDatosFormato['firmas'][0][0] = utf8_decode("Subsecretario(a) de Gestión Financiera " . $txtEncargoSubsecretario);
                    $arrDatosFormato['firmas'][1][0] = utf8_decode(mb_strtoupper($objRes->fields['txtSubsecretario']));
                    $arrDatosFormato['firmas'][0][1] = "";
                    $arrDatosFormato['firmas'][1][1] = "";

                    break;

                // solo firma el subdirector
                case $objRes->fields['txtSubdirector'] != "" and $objRes->fields['txtSubsecretario'] == "":

                    $txtEncargoSubdirector = ($objRes->fields['bolEncargoSubdirector'] == 1) ? "(E)" : "";

                    $arrDatosFormato['firmas'][0][0] = utf8_decode("Subdirector(a) de Recursos Públicos " . $txtEncargoSubdirector);
                    $arrDatosFormato['firmas'][1][0] = utf8_decode(mb_strtoupper($objRes->fields['txtSubdirector']));
                    $arrDatosFormato['firmas'][0][1] = "";
                    $arrDatosFormato['firmas'][1][1] = "";

                    break;

            }

            $arrDatosFormato['subfirmas'][0][0] = utf8_decode("Revisó");
            $arrDatosFormato['subfirmas'][0][1] = utf8_decode($objRes->fields['txtReviso']) . " - Contratista";

            $arrDatosFormato['subfirmas'][1][0] = utf8_decode("Elaboró");
            $arrDatosFormato['subfirmas'][1][1] = utf8_decode($objRes->fields['txtUsuario']);

            $objRes->MoveNext();
        }


        return $arrDatosFormato;
    }

    public function listadoGirosFiducia(){
        global $aptBd;
        $arrListado = array();
        $sql = "
            select 
              if(pry1.seqProyecto is null,pry.seqProyecto,pry1.seqProyecto) as seqProyecto,
              if(pry1.seqProyecto is null,pry.txtNombreProyecto,pry1.txtNombreProyecto) as txtNombreProyecto,
              gfi.seqGiroFiducia,
              gfi.numSecuencia,
              gfi.fchCreacion,
              count(gfd.seqProyecto) numUnidades,
              sum(gfd.valGiro) valGiro
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            inner join t_pry_proyecto pry on gfd.seqProyecto = pry.seqProyecto
            left join t_pry_proyecto pry1 on pry.seqProyectoPadre = pry1.seqProyecto
            group by 
              gfi.seqGiroFiducia,
              gfi.numSecuencia,
              gfi.fchCreacion,
              if(pry1.seqProyecto is null,pry.txtNombreProyecto,pry1.txtNombreProyecto)        
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqGiroFiducia = $objRes->fields['seqGiroFiducia'];
            $fchCreacion = new DateTime($objRes->fields['fchCreacion']);

            $arrListado[$seqGiroFiducia]['proyecto']  = $objRes->fields['txtNombreProyecto'];
            $arrListado[$seqGiroFiducia]['secuencia'] = "SDHT-SGF-SDRPL-" . $objRes->fields['seqProyecto'] . "-" . $objRes->fields['numSecuencia'] . "-" . $fchCreacion->format(y);
            $arrListado[$seqGiroFiducia]['unidades']  = $objRes->fields['numUnidades'];
            $arrListado[$seqGiroFiducia]['giro']      = $objRes->fields['valGiro'];

            $objRes->MoveNext();
        }

        return $arrListado;
    }

    public function listadoGirosConstructor($seqProyecto = 0){
        global $aptBd;

        $txtCondicion = ($seqProyecto == 0)? "" : "where if(pry1.seqProyecto is null,pry.seqProyecto,pry1.seqProyecto) = $seqProyecto";

        $arrListado = array();
        $sql = "
            select 
                if(pry1.seqProyecto is null,pry.seqProyecto,pry1.seqProyecto) as seqProyecto,
                if(pry1.seqProyecto is null,pry.txtNombreProyecto,pry1.txtNombreProyecto) as txtNombreProyecto,
                gcon.seqGiroConstructor,
                gcon.fchCreacion,
                count(gcd.seqProyecto) numUnidades,
                sum(gcd.valGiro) valGiro
            from t_pry_aad_giro_constructor gcon
            inner join t_pry_aad_giro_constructor_detalle gcd on gcon.seqGiroConstructor = gcd.seqGiroConstructor
            inner join t_pry_proyecto pry on gcd.seqProyecto = pry.seqProyecto
            left join t_pry_proyecto pry1 on pry.seqProyectoPadre = pry1.seqProyecto
            $txtCondicion
            group by 
                if(pry1.seqProyecto is null,pry.seqProyecto,pry1.seqProyecto),
                if(pry1.seqProyecto is null,pry.txtNombreProyecto,pry1.txtNombreProyecto),
                gcon.seqGiroConstructor,
                gcon.fchCreacion
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqGiroConstructor = $objRes->fields['seqGiroConstructor'];
            $arrListado[$seqGiroConstructor]['idProyecto'] = $objRes->fields['seqProyecto'];
            $arrListado[$seqGiroConstructor]['proyecto']   = $objRes->fields['txtNombreProyecto'];
            $arrListado[$seqGiroConstructor]['unidades']   = $objRes->fields['numUnidades'];
            $arrListado[$seqGiroConstructor]['giro']       = $objRes->fields['valGiro'];
            $arrListado[$seqGiroConstructor]['fecha']      = new DateTime($objRes->fields['fchCreacion']);
            $objRes->MoveNext();
        }

        return $arrListado;



    }

    public function eliminarGiroFiducia($seqGiroFiducia){
        global $aptBd;

        try {
            $aptBd->BeginTrans();

            $sql = "delete from t_pry_aad_giro_fiducia_detalle where seqGiroFiducia = $seqGiroFiducia";
            $aptBd->execute($sql);

            $sql = "delete from t_pry_aad_giro_fiducia where seqGiroFiducia = $seqGiroFiducia";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Ha eliminado el giro con identificador " . $seqGiroFiducia . " de manera satisfactoria";
            $aptBd->CommitTrans();
        }catch(Exception $objError){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
        }

    }

    public function verGiroFiducia($seqGiroFiducia){
        global $aptBd;
        $arrRetorno = array();
        $sql = "
            select 
                gfi.seqGiroFiducia,  
                if(pry1.seqProyecto is null,pry.seqProyecto,pry1.seqProyecto) as seqProyecto,
                gfd.seqUnidadActo,
                gfd.seqRegistroPresupuestal,
                gfd.seqUnidadProyecto,
                gfd.valGiro,
                gfi.txtCertificacion,
                gfi.bolCedulaOferente,
                gfi.bolRitOferente,
                gfi.bolRutOferente,
                gfi.bolExistenciaOferente,
                gfi.bolConstitucionFiducia,
                gfi.bolCedulaFiducia,
                gfi.bolBancariaFiducia,
                gfi.bolSuperintendenciaFiducia,
                gfi.bolCamaraFiducia,
                gfi.bolRutFiducia,
                gfi.bolResolucionProyecto,
                gfi.bolMemorandoProyecto,
                gfi.txtSubsecretario,
                gfi.bolEncargoSubsecretario,
                gfi.txtSubdirector,
                gfi.bolEncargoSubdirector,
                gfi.txtReviso
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            inner join t_pry_proyecto pry on gfd.seqProyecto = pry.seqProyecto
            left join t_pry_proyecto pry1 on pry.seqProyectoPadre = pry1.seqProyecto
            where gfi.seqGiroFiducia = $seqGiroFiducia
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqProyecto = $objRes->fields['seqProyecto'];
            $seqUnidadActo = $objRes->fields['seqUnidadActo'];
            $seqRegistroPresupuestal = $objRes->fields['seqRegistroPresupuestal'];
            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];

            $arrRetorno['seqProyecto'] = $seqProyecto;
            $arrRetorno['seqUnidadActo'] = $seqUnidadActo;
            $arrRetorno['seqRegistroPresupuestal'] = $seqRegistroPresupuestal;
            $arrRetorno['unidades'][$seqProyecto][$seqUnidadActo][$seqRegistroPresupuestal][$seqUnidadProyecto] = $objRes->fields['valGiro'];
            $arrRetorno['txtCertificacion'] = $objRes->fields['txtCertificacion'];
            $arrRetorno['documentos']['bolCedulaOferente'] = $objRes->fields['bolCedulaOferente'];
            $arrRetorno['documentos']['bolRitOferente'] = $objRes->fields['bolRitOferente'];
            $arrRetorno['documentos']['bolRutOferente'] = $objRes->fields['bolRutOferente'];
            $arrRetorno['documentos']['bolExistenciaOferente'] = $objRes->fields['bolExistenciaOferente'];
            $arrRetorno['documentos']['bolConstitucionFiducia'] = $objRes->fields['bolConstitucionFiducia'];
            $arrRetorno['documentos']['bolCedulaFiducia'] = $objRes->fields['bolCedulaFiducia'];
            $arrRetorno['documentos']['bolBancariaFiducia'] = $objRes->fields['bolBancariaFiducia'];
            $arrRetorno['documentos']['bolSuperintendenciaFiducia'] = $objRes->fields['bolSuperintendenciaFiducia'];
            $arrRetorno['documentos']['bolCamaraFiducia'] = $objRes->fields['bolCamaraFiducia'];
            $arrRetorno['documentos']['bolRutFiducia'] = $objRes->fields['bolRutFiducia'];
            $arrRetorno['documentos']['bolResolucionProyecto'] = $objRes->fields['bolResolucionProyecto'];
            $arrRetorno['documentos']['bolMemorandoProyecto'] = $objRes->fields['bolMemorandoProyecto'];
            $arrRetorno['txtSubsecretario'] = $objRes->fields['txtSubsecretario'];
            $arrRetorno['bolEncargoSubsecretario'] = $objRes->fields['bolEncargoSubsecretario'];
            $arrRetorno['txtSubdirector'] = $objRes->fields['txtSubdirector'];
            $arrRetorno['bolEncargoSubdirector'] = $objRes->fields['bolEncargoSubdirector'];
            $arrRetorno['txtReviso'] = $objRes->fields['txtReviso'];

            $objRes->MoveNext();
        }

        $arrRetorno['seqGiroFiducia'] = $seqGiroFiducia;

        return $arrRetorno;

    }

    public function proyectosDisponibles(){
        global $aptBd;

        $sql = "
            select
                if(pry.seqProyecto is null, con.seqProyecto, pry.seqProyecto) as seqProyecto,
                if(pry.seqProyecto is null, con.txtNombreProyecto, pry.txtNombreProyecto) as txtNombreProyecto
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            inner join t_pry_proyecto con on gfd.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
            group by seqProyecto,txtNombreProyecto
            order by txtNombreProyecto
        ";
        $objRes = $aptBd->execute($sql);
        $arrProyectos = array();
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $txtNombreProyecto = $objRes->fields['txtNombreProyecto'];
            $arrProyectos[$seqProyecto] = $txtNombreProyecto;
            $objRes->MoveNext();
        }

        return $arrProyectos;
    }

    public function plantillaGiroConstructor($seqProyecto){
        global $aptBd;

        $this->informacionGiroConstructor($seqProyecto);

        $sql = "
            select
                con.seqProyecto as 'Identificador del Proyecto',
                con.txtNombreProyecto as 'Nombre del Proyecto',
                upr.seqUnidadProyecto as 'Identificador de la Unidad',
                upper(upr.txtNombreUnidad) as 'Descripcion de la Unidad',
                sum(gfd.valGiro) as 'Disponible',
                0 as 'Valor a Girar'
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            inner join t_pry_proyecto con on gfd.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
            left join t_pry_unidad_proyecto upr on gfd.seqUnidadProyecto = upr.seqUnidadProyecto
            where (con.seqProyecto = $seqProyecto or pry.seqProyecto = $seqProyecto)
            group by 
                if(pry.seqProyecto is null, con.seqProyecto, pry.seqProyecto), 
                if(pry.seqProyecto is null, con.txtNombreProyecto, pry.txtNombreProyecto), 
                upr.seqUnidadProyecto, 
                upper(upr.txtNombreUnidad)      
        ";
        $objRes = $aptBd->execute($sql);
        $arrRetorno = array();
        while($objRes->fields){
            $seqUnidadProyecto = intval($objRes->fields['Identificador de la Unidad']);
            $numPosicion = count($arrRetorno);
            $objRes->fields['Disponible'] -= $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['giro'];
            $arrRetorno[$numPosicion] = $objRes->fields;
            $objRes->MoveNext();
        }

        return $arrRetorno;

    }

    private function cantidadUnidades($seqProyecto){
        global $aptBd;
        $sql = "
            select count(seqUnidadProyecto) as cantidad
            from t_pry_unidad_proyecto
            where seqProyecto in (
            select seqProyecto
            from t_pry_proyecto
            where seqProyecto = $seqProyecto
               or seqProyectoPadre = $seqProyecto
            )        
        ";
        $objRes = $aptBd->execute($sql);
        return $objRes->fields['cantidad'];
    }

    private function proyectoUnidad($seqUnidadProyecto){
        global $aptBd;

        $sql = "
            select 
                upr.seqUnidadProyecto,
                lower(upr.txtNombreUnidad) as txtNombreUnidad,
                pry.seqProyecto
            from t_pry_unidad_proyecto upr
            inner join t_pry_proyecto pry on upr.seqProyecto = pry.seqProyecto
            where seqUnidadProyecto = $seqUnidadProyecto        
        ";
        $objRes = $aptBd->execute($sql);
        $arrUnidad = array();
        while($objRes->fields){
            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            $arrUnidad[$seqUnidadProyecto]['txtNombreUnidad'] = $objRes->fields['txtNombreUnidad'];
            $arrUnidad[$seqUnidadProyecto]['seqProyecto'] = $objRes->fields['seqProyecto'];
            $objRes->MoveNext();
        }
        return $arrUnidad;

    }

    public function informacionGiroConstructor($seqProyecto){
        global $aptBd;

        // giros realizados a la fiducia
        $sql = "
            select
                if(pry.seqProyecto is null,con.seqProyecto,pry.seqProyecto) as seqProyecto,
                if(pry.seqProyecto is null,con.txtNombreProyecto,pry.txtNombreProyecto) as txtNombreProyecto,
                if(pry.seqProyecto is null,null,con.seqProyecto) as seqConjunto,
                if(pry.seqProyecto is null,null,con.txtNombreProyecto) as txtNombreConjunto,
                if(upr.seqUnidadProyecto is null, 0,upr.seqUnidadProyecto) as seqUnidadProyecto,
                upper(upr.txtNombreUnidad) as txtNombreUnidad,
                sum(gfd.valGiro) as valGiro
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            inner join t_pry_proyecto con on gfd.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
            left join t_pry_unidad_proyecto upr on gfd.seqUnidadProyecto = upr.seqUnidadProyecto
            where (con.seqProyecto = $seqProyecto or pry.seqProyecto = $seqProyecto)
            group by
                if(pry.seqProyecto is null,con.seqProyecto,pry.seqProyecto),
                if(pry.seqProyecto is null,con.txtNombreProyecto,pry.txtNombreProyecto),
                if(pry.seqProyecto is null,null,con.seqProyecto),
                if(pry.seqProyecto is null,null,con.txtNombreProyecto),
                if(upr.seqUnidadProyecto is null, 0,upr.seqUnidadProyecto),
                upper(upr.txtNombreUnidad)
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            $this->arrGiroConstructor['total'] += $objRes->fields['valGiro'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['total'] = $objRes->fields['valGiro'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['seqProyecto'] = $objRes->fields['seqProyecto'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['txtNombreProyecto'] = $objRes->fields['txtNombreProyecto'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['seqConjunto'] = $objRes->fields['seqConjunto'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['txtNombreConjunto'] = $objRes->fields['txtNombreConjunto'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['txtNombreUnidad'] = $objRes->fields['txtNombreUnidad'];
            $objRes->MoveNext();
        }

        // giros realizados a constructor
        $sql = "
            select
                if(upr.seqUnidadProyecto is null, 0,upr.seqUnidadProyecto) seqUnidadProyecto,
                upper(upr.txtNombreUnidad) as txtNombreUnidad,
                sum(gcd.valGiro) as valGiro
            from t_pry_aad_giro_constructor gco
            inner join t_pry_aad_giro_constructor_detalle gcd on gco.seqGiroConstructor = gcd.seqGiroConstructor
            inner join t_pry_proyecto con on gcd.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
            left join t_pry_unidad_proyecto upr on gcd.seqUnidadProyecto = upr.seqUnidadProyecto
            where (con.seqProyecto = $seqProyecto or pry.seqProyecto = $seqProyecto)
            group by
                upr.seqUnidadProyecto,
                upper(upr.txtNombreUnidad)          
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            $this->arrGiroConstructor['giro'] += $objRes->fields['valGiro'];
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['giro'] = $objRes->fields['valGiro'];
            $objRes->MoveNext();
        }

        $this->arrGiroConstructor['saldo'] = $this->arrGiroConstructor['total'] - $this->arrGiroConstructor['giro'];
        foreach($this->arrGiroConstructor['detalle'] as $seqUnidadProyecto => $arrGiro){
            $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['saldo'] =
                $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['total'] -
                $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['giro'];
        }



    }

    public function salvarGiroConstuctor($arrPost){
        global $aptBd;

        /**
         * VALIDACIONES DE LOS CAMPOS
         */

        if($arrPost['seqProyecto'] == 0){
            $this->arrErrores[] = "Seleccione el proyecto para el que desea hacer el giro";
        }

        if((! isset($arrPost['unidades'])) or empty($arrPost['unidades'])){
            $this->arrErrores[] = "No ha seleccionado las unidades para el giro";
        }else{
            foreach ($arrPost['unidades'] as $seqProyecto => $arrUnidades){
                foreach($arrUnidades as $seqUnidadProyecto => $valGiro) {
                    if($valGiro > $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['saldo']){
                        $txtTexto = ($seqUnidadProyecto != 0)?
                            "a la uidad " . $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['txtNombreUnidad'] :
                            "al proyecto " . $this->arrGiroConstructor['detalle'][$seqUnidadProyecto]['txtNombreProyecto'];
                        $this->arrErrores[] = "No tiene saldo suficiente para girar " . $txtTexto;
                    }

                }
            }
        }

        /**
         * SALVA EL REGISTRO
         */

        if(empty($this->arrErrores)){

            try{
                $aptBd->BeginTrans();

                $sql = "
                    insert into t_pry_aad_giro_constructor (
                      fchCreacion, 
                      seqUsuario, 
                      txtComentario
                  ) values (                      
                      now(),
                      " . $_SESSION['seqUsuario'] . ",
                      '" . trim($arrPost['txtComentario']) . "'
                  )
                ";
                $aptBd->execute($sql);

                $seqGiroConstructor = $aptBd->Insert_ID();

                foreach ($arrPost['unidades'] as $seqProyecto => $arrDato) {
                    foreach ($arrDato as $seqUnidadProyecto => $valGiro) {
                        if (intval($seqUnidadProyecto) != 0) {
                            $seqProyectoInsertar = array_shift(
                                obtenerDatosTabla(
                                    "t_pry_unidad_proyecto",
                                    array("seqUnidadProyecto", "seqProyecto"),
                                    "seqUnidadProyecto",
                                    "seqUnidadProyecto = " . $seqUnidadProyecto
                                )
                            );
                        } else {
                            $seqProyectoInsertar = $seqProyecto;
                            $seqUnidadProyecto = "null";
                        }
                        $sql = "
                            insert into t_pry_aad_giro_constructor_detalle(
                                seqGiroConstructor, 
                                seqProyecto, 
                                seqUnidadProyecto, 
                                valGiro
                            ) values (
                                $seqGiroConstructor,
                                $seqProyectoInsertar,
                                $seqUnidadProyecto,
                                $valGiro
                            ) 
                        ";
                        $aptBd->execute($sql);
                    }
                }

                $this->arrMensajes[] = "Registro salvado satisfactoriamente";

                $aptBd->CommitTrans();

                return $seqGiroConstructor;

            } catch ( Exception $objError ){
                $aptBd->RollbackTrans();
                $this->arrMensajes = array();
                $this->arrErrores[] = $objError->getMessage();

                return 0;
            }

        }




    }

    public function eliminarGiroConstructor($seqGiroConstructor){
        global $aptBd;

        try {
            $aptBd->BeginTrans();

            $sql = "delete from t_pry_aad_giro_constructor_detalle where seqGiroConstructor = $seqGiroConstructor";
            $aptBd->execute($sql);

            $sql = "delete from t_pry_aad_giro_constructor where seqGiroConstructor = $seqGiroConstructor";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Ha eliminado el giro con identificador " . $seqGiroConstructor . " de manera satisfactoria";
            $aptBd->CommitTrans();
        }catch(Exception $objError){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
        }

    }

    public function verGiroConstructor($seqGiroConstructor){
        global $aptBd;
        $arrRetorno = array();
        $sql = "
            select 
                gcon.seqGiroConstructor,  
                if(pry.seqProyectoPadre is null,gcd.seqProyecto,pry.seqProyectoPadre) as seqProyecto,
                gcd.seqUnidadProyecto,
                gcd.valGiro,
                gcon.txtComentario
            from t_pry_aad_giro_constructor gcon
            inner join t_pry_aad_giro_constructor_detalle gcd on gcon.seqGiroConstructor = gcd.seqGiroConstructor
            inner join t_pry_proyecto pry on gcd.seqProyecto = pry.seqProyecto
            where gcon.seqGiroConstructor = $seqGiroConstructor
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $seqUnidadProyecto = intval($objRes->fields['seqUnidadProyecto']);
            $arrRetorno['seqProyecto'] = $objRes->fields['seqProyecto'];
            $arrRetorno['unidades'][$seqProyecto][$seqUnidadProyecto] = $objRes->fields['valGiro'];
            $arrRetorno['txtComentario'] = $objRes->fields['txtComentario'];
            $arrRetorno['fchCreacion'] = new DateTime($objRes->fields['fchCreacion']);
            $objRes->MoveNext();
        }

        $arrRetorno['seqGiroConstructor'] = $seqGiroConstructor;

        return $arrRetorno;

    }

    public function validarFormularioReintegros($arrPost){
        global $aptBd;

        if($arrPost['salvar'] != "salvar"){

            $txtValidar = $arrPost['salvar'];
            $arrValidar = $arrPost[$txtValidar];

            if($arrValidar['seqBanco'] == 0){
                $this->arrErrores[] = "Seleccione el banco para el " . $txtValidar;
            }

            if(trim($arrValidar['numCuenta']) == ""){
                $this->arrErrores[] = "Digite el numero de cuenta para el " . $txtValidar;
            }

            if(! esFechaValida($arrValidar['fchConsignacion'])){
                $this->arrErrores[] = "Digite una fecha valida para el " . $txtValidar;
            }

            if(doubleval($arrValidar['valConsignacion']) == 0){
                $this->arrErrores[] = "Digite el valor del " . $txtValidar;
            }

        }

    }

    public function salvarReintegros($arrPost){
        global $aptBd;

        if(
            intval($arrPost['reintegro']['seqBanco']) != 0 or
            doubleval($arrPost['reintegro']['numCuenta']) != 0 or
            esFechaValida($arrPost['reintegro']['fchConsignacion']) == true or
            doubleval($arrPost['reintegro']['valConsignacion']) != 0
        ){
            $this->arrErrores[] = "Falta por adicionar el registro de reintegro para salvar el registro";
        }

        if(
            intval($arrPost['rendimiento']['seqBanco']) != 0 or
            doubleval($arrPost['rendimiento']['numCuenta']) != 0 or
            esFechaValida($arrPost['rendimiento']['fchConsignacion']) == true or
            doubleval($arrPost['rendimiento']['valConsignacion']) != 0
        ){
            $this->arrErrores[] = "Falta por adicionar el registro de rendimiento para salvar el registro";
        }

        if(empty($this->arrErrores)) {

            if (intval($arrPost['seqProyecto']) == 0) {
                $this->arrErrores[] = "Seleccione el proyecto";
            }

            if (intval($arrPost['numActa']) == 0) {
                $this->arrErrores[] = "Digite el número del acta de legalizacion";
            }

            if (!esFechaValida($arrPost['fchActa'])) {
                $this->arrErrores[] = "Seleccione la fecha del acta de legalizacion";
            }

            if (empty($arrPost['registros'])) {
                $this->arrErrores[] = "Adicione al menos un registro de reintegro o rendimientos segun corresponda";
            }

            $seqReintegro = array_shift(
                obtenerDatosTabla(
                    "t_pry_aad_reintegros",
                    array("seqReintegro","count(seqProyecto) as cuenta"),
                    "seqReintegro",
                    "numActa = " . intval($arrPost['numActa']) . " and fchActa = '" . $arrPost['fchActa'] . "'"
                )
            );

            if(intval($seqReintegro) != 0){
                $this->arrErrores[] = "Ya existe un acta " . intval($arrPost['numActa']) . " de " . $arrPost['fchActa'];
            }

        }

        if(empty($this->arrErrores)) {

            try{
                $aptBd->BeginTrans();

                $sql = "
                    insert into t_pry_aad_reintegros (
                      seqProyecto, 
                      numActa, 
                      fchActa, 
                      fchCreacion, 
                      seqUsuario
                  ) values (                      
                      " . intval($arrPost['seqProyecto']) . ",
                      " . intval($arrPost['numActa']) . ",
                      '" . $arrPost['fchActa'] . "',
                      now(),
                      " . $_SESSION['seqUsuario'] . "
                  )
                ";
                $aptBd->execute($sql);

                $seqReintegro = $aptBd->Insert_ID();

                foreach ($arrPost['registros'] as $arrDato) {

                    $sql = "
                        insert into t_pry_aad_reintegros_detalle (
                            seqReintegro, 
                            txtTipo, 
                            seqBanco, 
                            numCuenta, 
                            fchConsignacion, 
                            valConsignacion
                        ) values (
                            $seqReintegro,
                            '" . $arrDato['txtTipo'] . "',
                            " . $arrDato['seqBanco'] . ",
                            " . $arrDato['numCuenta'] .  ",
                            '" . $arrDato['fchConsignacion'] . "',
                            " . $arrDato['valConsignacion'] . "
                        ) 
                    ";
                    $aptBd->execute($sql);

                }

                $this->arrMensajes[] = "Registro salvado satisfactoriamente";

                $aptBd->CommitTrans();

                return $seqReintegro;

            } catch ( Exception $objError ){
                $aptBd->RollbackTrans();
                $this->arrMensajes = array();
                $this->arrErrores[] = $objError->getMessage();

                return 0;
            }

        }




    }

    public function listadoReintegros(){
        global $aptBd;

        $sql = "
            select 
                rei.seqReintegro,
                pry.txtNombreProyecto,
                rei.numActa, 
                rei.fchActa,
                red.txtTipo, 
                sum(red.valConsignacion) as valConsignacion
            from t_pry_aad_reintegros rei
            inner join t_pry_aad_reintegros_detalle red on rei.seqReintegro = red.seqReintegro
            inner join t_pry_proyecto pry on rei.seqProyecto = pry.seqProyecto
            group by 
              rei.seqReintegro, 
              rei.seqProyecto, 
              pry.txtNombreProyecto, 
              rei.numActa, 
              rei.fchActa, 
              red.txtTipo
        ";
        $objRes = $aptBd->execute($sql);
        $arrListado = array();
        while($objRes->fields){

            $seqReintegro = $objRes->fields['seqReintegro'];
            $txtTipo = mb_strtolower($objRes->fields['txtTipo']);

            $arrListado[$seqReintegro]['proyecto'] = $objRes->fields['txtNombreProyecto'];
            $arrListado[$seqReintegro]['acta'] = $objRes->fields['numActa'];
            $arrListado[$seqReintegro]['fecha'] = $objRes->fields['fchActa'];
            $arrListado[$seqReintegro]['tipo'] = $objRes->fields['txtTipo'];
            $arrListado[$seqReintegro][$txtTipo] += doubleval($objRes->fields['valConsignacion']);

            $objRes->MoveNext();
        }

        return $arrListado;
    }

    public function eliminarReintegro($seqReintegro){
        global $aptBd;

        try {
            $aptBd->BeginTrans();

            $sql = "delete from t_pry_aad_reintegros_detalle where seqReintegro = $seqReintegro";
            $aptBd->execute($sql);

            $sql = "delete from t_pry_aad_reintegros where seqReintegro = $seqReintegro";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Ha eliminado el registro con identificador " . $seqReintegro . " de manera satisfactoria";
            $aptBd->CommitTrans();
        }catch(Exception $objError){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = $objError->getMessage();
        }

    }

    public function verReintegro($seqReintegro){
        global $aptBd;
        $arrRetorno = array();
        $sql = "
            select  
                rei.seqProyecto,
                rei.numActa, 
                rei.fchActa,
                red.txtTipo, 
                red.seqBanco, 
                red.numCuenta, 
                red.fchConsignacion, 
                red.valConsignacion
            from t_pry_aad_reintegros rei
            inner join t_pry_aad_reintegros_detalle red on rei.seqReintegro = red.seqReintegro
            where rei.seqReintegro = $seqReintegro
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $arrRetorno['seqProyecto'] = $objRes->fields['seqProyecto'];
            $arrRetorno['numActa'] = $objRes->fields['numActa'];
            $arrRetorno['fchActa'] = $objRes->fields['fchActa'];

            $numPosicion = count($arrRetorno['registros']);

            $arrRetorno['registros'][$numPosicion]['txtTipo'] = $objRes->fields['txtTipo'];
            $arrRetorno['registros'][$numPosicion]['seqBanco'] = $objRes->fields['seqBanco'];
            $arrRetorno['registros'][$numPosicion]['numActa'] = $objRes->fields['numActa'];
            $arrRetorno['registros'][$numPosicion]['fchActa'] = $objRes->fields['fchActa'];
            $arrRetorno['registros'][$numPosicion]['numCuenta'] = $objRes->fields['numCuenta'];
            $arrRetorno['registros'][$numPosicion]['fchConsignacion'] = $objRes->fields['fchConsignacion'];
            $arrRetorno['registros'][$numPosicion]['valConsignacion'] = $objRes->fields['valConsignacion'];

            $objRes->MoveNext();
        }

        return $arrRetorno;

    }

    public function reporteGeneral($bolRetornarDatos = false){
        global $aptBd;

        $arrReporte = array();

        $sql = "
            select
              if(con.seqProyectoPadre is null,con.seqProyecto,con.seqProyectoPadre) as seqProyecto,
              if(con.seqProyectoPadre is null,con.txtNombreProyecto,pry.txtNombreProyecto) as txtNombreProyecto,
              -- if(con.seqProyectoPadre is null,con.seqDatoFiducia,pry.seqDatoFiducia) as seqDatoFiducia,
              uac.seqTipoActoUnidad,
              uac.numActo,
              uac.fchActo,
              sum(uvi.valIndexado) as valIndexado
            from t_pry_aad_unidad_acto uac
            inner join t_pry_aad_unidades_vinculadas uvi on uac.seqUnidadActo = uvi.seqUnidadActo
            inner join t_pry_proyecto con on uvi.seqProyecto = con.seqProyecto
            left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
            group by
              if(con.seqProyectoPadre is null, con.seqProyecto, con.seqProyectoPadre),
              if(con.seqProyectoPadre is null, con.txtNombreProyecto, pry.txtNombreProyecto),
              uac.seqTipoActoUnidad,
              uac.numActo,
              uac.fchActo
            order by
              if(con.seqProyectoPadre is null, con.txtNombreProyecto, pry.txtNombreProyecto),
              uac.seqTipoActoUnidad
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqProyecto = $objRes->fields['seqProyecto'];

            $arrReporte[$seqProyecto]['nombre'] = $objRes->fields['txtNombreProyecto'];

            $arrReporte[$seqProyecto]['entidad'] = "";

//            $arrReporte[$seqProyecto]['entidad'] = array_shift(
//                obtenerDatosTabla(
//                    "t_pry_datos_fiducia",
//                    array("seqDatoFiducia","txtEntidadFiducia"),
//                    "seqDatoFiducia",
//                    "seqDatoFiducia = " . $objRes->fields['seqDatoFiducia']
//                )
//            );

            $arrReporte[$seqProyecto]['aprobado'] = doubleval(
                ($objRes->fields['seqTipoActoUnidad'] == 1)?
                    $arrReporte[$seqProyecto]['aprobado'] + $objRes->fields['valIndexado'] :
                    $arrReporte[$seqProyecto]['aprobado']
            );

            $arrReporte[$seqProyecto]['indexado'] = doubleval(
                ($objRes->fields['seqTipoActoUnidad'] == 2 and $objRes->fields['valIndexado'] > 0)?
                    $arrReporte[$seqProyecto]['indexado'] + $objRes->fields['valIndexado'] :
                    $arrReporte[$seqProyecto]['indexado']
            );

            $arrReporte[$seqProyecto]['menor'] = doubleval(
                ($objRes->fields['seqTipoActoUnidad'] == 3 or ($objRes->fields['seqTipoActoUnidad'] == 2 and $objRes->fields['valIndexado'] < 0))?
                    $arrReporte[$seqProyecto]['menor'] + abs($objRes->fields['valIndexado']) :
                    $arrReporte[$seqProyecto]['menor']
            );

            $arrReporte[$seqProyecto]['actual'] =
                $arrReporte[$seqProyecto]['aprobado'] +
                $arrReporte[$seqProyecto]['indexado'] -
                $arrReporte[$seqProyecto]['menor'];

            $arrReporte[$seqProyecto]['fiducia'] = 0;
            $arrReporte[$seqProyecto]['reintegro'] = 0;
            $arrReporte[$seqProyecto]['totalFiducia'] = 0;
            $arrReporte[$seqProyecto]['porcentajeTotalFiducia'] = 0;
            $arrReporte[$seqProyecto]['constructor'] = 0;
            $arrReporte[$seqProyecto]['porcentajeTotalConstructor'] = 0;
            $arrReporte[$seqProyecto]['actualFiducia'] = 0;
            $arrReporte[$seqProyecto]['porcentajeActualFiducia'] = 0;
            $arrReporte[$seqProyecto]['rendimiento'] = 0;
            $arrReporte[$seqProyecto]['observaciones'] = "";

            $objRes->MoveNext();
        }

        // datos fiducia
        $sql = "
            select 
                if(pry.seqProyectoPadre is null,pry.seqProyecto,pry.seqProyectoPadre) as seqProyecto,
                sum(gfd.valGiro) as valGiroFiducia
            from t_pry_aad_giro_fiducia gfi
            inner join t_pry_aad_giro_fiducia_detalle gfd on gfi.seqGiroFiducia = gfd.seqGiroFiducia
            inner join t_pry_proyecto pry on gfd.seqProyecto = pry.seqProyecto
            group by 
                if(pry.seqProyectoPadre is null, pry.seqProyecto, pry.seqProyectoPadre)        
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $arrReporte[$seqProyecto]['fiducia'] = doubleval($objRes->fields['valGiroFiducia']);
            $objRes->MoveNext();
        }

        // reintegros
        $sql = "
            select 
                rei.seqProyecto,
                lower(red.txtTipo) as txtTipo,
                sum(red.valConsignacion) as valConsignacion
            from t_pry_aad_reintegros rei
            inner join t_pry_aad_reintegros_detalle red on rei.seqReintegro = red.seqReintegro 
            group by 
                rei.seqProyecto,
                lower(red.txtTipo)     
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $txtTipo = $objRes->fields['txtTipo'];
            $arrReporte[$seqProyecto][$txtTipo] = doubleval($objRes->fields['valConsignacion']);
            $objRes->MoveNext();
        }

        // giros a constructor
        $sql = "
            select 
                if(pry.seqProyectoPadre is null, pry.seqProyecto, pry.seqProyectoPadre) as seqProyecto,
                sum(gcd.valGiro) as valGiroConstructor
            from t_pry_aad_giro_constructor gco
            inner join t_pry_aad_giro_constructor_detalle gcd on gcd.seqGiroConstructor = gco.seqGiroConstructor
            inner join t_pry_proyecto pry on gcd.seqProyecto = pry.seqProyecto
            group by 
              if(pry.seqProyectoPadre is null, pry.seqProyecto, pry.seqProyectoPadre)
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $seqProyecto = $objRes->fields['seqProyecto'];
            $arrReporte[$seqProyecto]['constructor'] = doubleval($objRes->fields['valGiroConstructor']);
            $objRes->MoveNext();
        }

        // porcentajes
        foreach($arrReporte as $seqProyecto => $arrDatos){

            // valor total fiducia
            $arrReporte[$seqProyecto]['totalFiducia'] = doubleval($arrReporte[$seqProyecto]['fiducia']) - doubleval($arrReporte[$seqProyecto]['reintegro']);

            // fiducia
            if($arrReporte[$seqProyecto]['totalFiducia'] == 0){
                $arrReporte[$seqProyecto]['porcentajeTotalFiducia'] = 0;
            }else {
                $arrReporte[$seqProyecto]['porcentajeTotalFiducia'] = round($arrReporte[$seqProyecto]['totalFiducia'] / $arrReporte[$seqProyecto]['actual'] ,2);
            }

            // constructor
            if($arrReporte[$seqProyecto]['constructor'] == 0){
                $arrReporte[$seqProyecto]['porcentajeTotalConstructor'] = 0;
            }else {
                $arrReporte[$seqProyecto]['porcentajeTotalConstructor'] = round($arrReporte[$seqProyecto]['constructor'] / $arrReporte[$seqProyecto]['actual'] ,2);
            }

            // actual fiducia
            $arrReporte[$seqProyecto]['actualFiducia'] = doubleval($arrReporte[$seqProyecto]['totalFiducia']) - doubleval($arrReporte[$seqProyecto]['constructor']);

            // actual fiducia
            if($arrReporte[$seqProyecto]['actualFiducia'] == 0){
                $arrReporte[$seqProyecto]['porcentajeActualFiducia'] = 0;
            }else {
                $arrReporte[$seqProyecto]['porcentajeActualFiducia'] = round($arrReporte[$seqProyecto]['actualFiducia'] / $arrReporte[$seqProyecto]['actual'] ,2);
            }

        }

        $arrTitulos[0]['nombre'] = "NOMBRE DEL PROYECTO";
        $arrTitulos[1]['nombre'] = "ENTIDAD FINANCIERA";
        $arrTitulos[2]['nombre'] = "VALOR PROYECTO APROBADO";
        $arrTitulos[3]['nombre'] = "VALOR INDEXACIONES APROBADAOS";
        $arrTitulos[4]['nombre'] = "VALOR TOTAL MENOR VALOR DEL PROYECTO SDHT";
        $arrTitulos[5]['nombre'] = "ACTUAL VALOR TOTAL DEL PROYECTO";
        $arrTitulos[6]['nombre'] = "VALOR GIRADO A FIDUCIA";
        $arrTitulos[7]['nombre'] = "VALOR TOTAL REINTEGROS";
        $arrTitulos[8]['nombre'] = "VALOR TOTAL GIRADO A FIDUCIA";
        $arrTitulos[9]['nombre'] = "% VALOR TOTAL GIRADO A FIDUCIA";
        $arrTitulos[10]['nombre'] = "TOTAL VALOR AUTORIZACION GIROS A CONSTRUCTORAS APROBADOS";
        $arrTitulos[11]['nombre'] = "% TOTAL VALOR AUTORIZACION GIROS A CONSTRUCTORAS APROBADOS";
        $arrTitulos[12]['nombre'] = "ACTUAL VALOR TOTAL  DISPONIBLE EN FIDUCIA";
        $arrTitulos[13]['nombre'] = "% ACTUAL VALOR TOTAL  DISPONIBLE EN FIDUCIA";
        $arrTitulos[14]['nombre'] = "TOTAL RENDIMIENTOS REGISTRADOS";
        $arrTitulos[15]['nombre'] = "OBSERVACIONES";

        $arrTitulos[0]['formato'] = "texto";
        $arrTitulos[1]['formato'] = "texto";
        $arrTitulos[2]['formato'] = "moneda";
        $arrTitulos[3]['formato'] = "moneda";
        $arrTitulos[4]['formato'] = "moneda";
        $arrTitulos[5]['formato'] = "moneda";
        $arrTitulos[6]['formato'] = "moneda";
        $arrTitulos[7]['formato'] = "moneda";
        $arrTitulos[8]['formato'] = "moneda";
        $arrTitulos[9]['formato'] = "porcentaje";
        $arrTitulos[10]['formato'] = "moneda";
        $arrTitulos[11]['formato'] = "porcentaje";
        $arrTitulos[12]['formato'] = "moneda";
        $arrTitulos[13]['formato'] = "porcentaje";
        $arrTitulos[14]['formato'] = "moneda";
        $arrTitulos[15]['formato'] = "texto";

        if($bolRetornarDatos == false) {
            $this->exportarArchivo("Reporte General", $arrTitulos, $arrReporte);
        }else{
            return $arrReporte;
        }

    }

    public function exportarArchivo($txtNombre, $arrTitulos, $arrReporte){


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getProperties()->setCreator($this->txtCreador);
        $objHoja = $objPHPExcel->getActiveSheet();
        $objHoja->setTitle($txtNombre);

        $numColumnas = count($arrTitulos);
        $numFilas = count($arrReporte);

        // titulos
        for ($i = 0; $i < count($arrTitulos); $i++) {
            $objHoja->setCellValueByColumnAndRow($i, 1, $arrTitulos[$i]['nombre'], false);
        }

        $numFila = 2;
        foreach ($arrReporte as $seqProyecto => $arrDatos){
            $numColumna = 0;
            foreach($arrDatos as $txtValor) {

                $objHoja->setCellValueByColumnAndRow($numColumna, $numFila, $txtValor, false);

                switch($arrTitulos[$numColumna]['formato']){
                    case "texto":
                        $objHoja->getStyleByColumnAndRow($numColumna, $numFila)
                            ->getNumberFormat()
                            ->setFormatCode(
                                PHPExcel_Style_NumberFormat::FORMAT_GENERAL
                            );
                        break;
                    case "moneda":
                        $objHoja->getStyleByColumnAndRow($numColumna, $numFila)
                            ->getNumberFormat()
                            ->setFormatCode(
                                PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                            );
                        break;
                    case "porcentaje":
                        $objHoja->getStyleByColumnAndRow($numColumna, $numFila)
                            ->getNumberFormat()
                            ->setFormatCode(
                                PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                            );
                        break;
                }

                $numColumna++;
            }
            $numFila++;
        }

        // *************************** ESTILOS POR DEFECTO DEL ARCHIVO DE EXCEL ********************************************* //

        // fuentes para el archivo
        $arrFuentes['default']['font']['name'] = "Calibri";
        $arrFuentes['default']['font']['size'] = 8;

        $arrFuentes['titulo']['fill']['type'] = PHPExcel_Style_Fill::FILL_SOLID;
        $arrFuentes['titulo']['fill']['color'] = array('rgb' => 'E4E4E4');
        $arrFuentes['titulo']['font']['bold'] = true;
        $arrFuentes['titulo']['font']['color'] = array('rgb' => '000000');

        // da formato a todas las columnas del libro
        $objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas) . ($numFilas + 1))->applyFromArray($arrFuentes['default']);

        // da formato al titulo
        $objHoja->getStyle(PHPExcel_Cell::stringFromColumnIndex(0) . "1:" . PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")->applyFromArray($arrFuentes['titulo']);

        for ($i = 0; $i < $numColumnas; $i++) {
            $objHoja->getColumnDimensionByColumn($i)->setAutoSize(true);
            for ($j = 1; $j < ($numFilas + 2); $j++) {
                $objHoja->getRowDimension($j)->setRowHeight(12);
            }
        }

        // *************************** EXPORTA LOS RESULTADOS *************************************************************** //

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename='" . mb_ereg_replace("[^0-9A-Za-z]","", $txtNombre) . "_" . date("YmdHis") . ".xlsx");
        header('Cache-Control: max-age=0');
        ob_end_clean();

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }



}


?>