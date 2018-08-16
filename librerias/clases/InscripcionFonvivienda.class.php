<?php

class InscripcionFonvivienda
{

    public $arrErrores;
    public $arrMensajes;
    public $arrHogares;
    public $arrNovedades;
    
    public $seqCargue;
    public $fchCargue;
    public $txtArchivo;
    public $txtFisico;
    public $fchInicio;
    public $fchFinal;
    public $numProgreso;
    public $seqEstado;
    public $txtEstado;
    public $txtDescripcion;
    public $seqUsuario;
    public $txtUsuario;
    public $arrEstadosCoincidencias;

    private $arrFormato;
    private $arrEstados;
    private $arrRangoIngresos;
    private $arrSoluciones;
    private $arrModalidad;
    private $arrCiudadanos;
    private $numTotalLineas;

    public function __construct()
    {

        $this->arrErrores = array();

        $this->arrFormato[] = 'ID_HOGAR';
        $this->arrFormato[] = 'RANGO_INGRESOS';
        $this->arrFormato[] = 'VALOR_SUBSIDIO';
        $this->arrFormato[] = 'NOMBRE_DEPARTAMENTO';
        $this->arrFormato[] = 'NOMBRE_MUNICIPIO';
        $this->arrFormato[] = 'FEC_CONSULTA';
        $this->arrFormato[] = 'FEC_MARCACION';
        $this->arrFormato[] = 'FEC_ACT_ADMIN';
        $this->arrFormato[] = 'NUM_ACT_ADMIN';
        $this->arrFormato[] = 'SECUENCIA_DESEMBOLSO';
        $this->arrFormato[] = 'ESTADO_HOGAR';
        $this->arrFormato[] = 'NUM_CELULAR';
        $this->arrFormato[] = 'NUM_FIJO';
        $this->arrFormato[] = 'CORREO_ELECTRONICO';
        $this->arrFormato[] = 'DIRECCION_CORRESPONDENCIA';
        $this->arrFormato[] = 'NOMBRE_CORTO';
        $this->arrFormato[] = 'NUMERO_IDENTIFICACION';
        $this->arrFormato[] = 'NOMBRES';
        $this->arrFormato[] = 'APELLIDOS';
        $this->arrFormato[] = 'NOMBRE_ENTIDAD';
        $this->arrFormato[] = 'ID VENDEDOR';
        $this->arrFormato[] = 'VENDEDOR';
        $this->arrFormato[] = 'ID PROYECTO';
        $this->arrFormato[] = 'PROYECTO';
        $this->arrFormato[] = 'TIPO_VIVIENDA';
        $this->arrFormato[] = 'TIPO_CONTRATO';
        $this->arrFormato[] = 'FEC_SOLICITUD_ASIGNACION';
        $this->arrFormato[] = 'COD_DEPTO_VIVIENDA';
        $this->arrFormato[] = 'DEPTO_VIVIENDA';
        $this->arrFormato[] = 'COD_MPIO_VIVIENDDA';
        $this->arrFormato[] = 'MPIO_VIVIENDDA';
        $this->arrFormato[] = 'CELULAR';
        $this->arrFormato[] = 'TELEFONO FIJO';
        $this->arrFormato[] = 'DIRECCION CORRESPONDENCIA';
        $this->arrFormato[] = 'ID_CONSTRUCTOR';
        $this->arrFormato[] = 'CONSTRUCTOR';
        $this->arrFormato[] = 'ID_PROYECTO';
        $this->arrFormato[] = 'PROYECTO';

        $this->arrEstados[] = "por asignar";

        $this->arrEstadosCoincidencias = array(1,35,36,37,41,43,44,46,53);

        $this->arrRangoIngresos[] = "HASTA 2 SMMLV"; // 10 salarios
        $this->arrRangoIngresos[] = "DE 2 SMMLV HASTA 3 SMMLV"; // 8 salarios
        $this->arrRangoIngresos[] = "DE 3 SMMLV HASTA 4 SMMLV"; // 8 salarios
        $this->arrRangoIngresos[] = "SUPERIORES A 2 SMMLV Y HASTA 4 SMMLV"; // 8 salarios

        $this->arrSoluciones[] = "VIP";
        $this->arrSoluciones[] = "VIS";

        $this->arrModalidad[] = "LEASING";
        $this->arrModalidad[] = "CRÉDITO";

        $this->arrHogares = array();

        $this->arrCiudadanos = array();

        $this->seqCargue = 0;
        $this->fchCargue = null;
        $this->txtArchivo = null;
        $this->txtFisico = null;
        $this->fchInicio = null;
        $this->fchFinal = null;
        $this->numProgreso = 0;
        $this->seqEstado = null;
        $this->txtEstado = null;
        $this->txtDescripcion = null;
        $this->seqUsuario = null;
        $this->txtUsuario = null;

        $this->arrNovedades = array();

    }

    /**
     * MIRA SI HAY CARGUES PENDIENTES POR PROCESAR O EN PROCESAMIENTO
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return boolean
     */

    public function hayCarguesPendientes(){
        global $aptBd;
        $sql = "
            select count(seqCargue) as cuenta
            from t_fnv_cargue
            where seqEstado in (1,2)
        ";
        $objRes = $aptBd->execute($sql);
        return ($objRes->fields['cuenta'] == 0)? false : true;
    }

    /**
     * VALIDA LOS TITULOS DEL ARVHIVO CARGADO POR PANTALLA
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return void
     */

    public function validarTitulos(){

        // valida si el archivo fue cargado y si corresponde a las extensiones válidas
        switch ($_FILES['archivo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido 1 ";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido 2";
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
                if (!in_array(strtolower($txtExtension), array("txt") )) {
                    $this->arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
                }
                break;
        }

        if(empty($this->arrErrores)){
            $aptArchivo = fopen($_FILES['archivo']['tmp_name'],"r");
            $arrTitulos = mb_split("\|", fgets($aptArchivo));
            fclose($aptArchivo);
            foreach($this->arrFormato as $numColumna => $txtTitulo){
                if(trim(mb_strtolower($arrTitulos[$numColumna])) != trim(mb_strtolower($txtTitulo))){
                    $this->arrErrores[] = "La columna $txtTitulo no se encuentra o no está en el lugar correcto";
                }
            }
        }

    }

    /**
     * CREA EL CARGUE Y COPIA EL ARCHIVO AL SERVIDOR
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return void
     */

    public function crearCargue(){
        global $aptBd, $arrConfiguracion, $txtPrefijoRuta;

        $txtCarpeta = $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "inscripcionFonvivienda/";
        $txtFisico = time();

        // crea la carpeta si no existe
        if(! is_dir($txtCarpeta )){
            if(! mkdir($txtCarpeta) ){
                $this->arrErrores[] = "No se pudo crear la carpeta contenedora de los archivos";
            }
        }

        // copia el archivo al servidor
        if(empty($this->arrErrores)){
            if(! copy($_FILES['archivo']['tmp_name'],$txtCarpeta . $txtFisico)){
                $this->arrErrores[] = "No se pudo copiar el archivo a la carpeta destino";
            }
        }

        // crea el registro en la base de datos
        if(empty($this->arrErrores)){
            try {
                $aptBd->BeginTrans();
                $sql = "
                    insert into t_fnv_cargue (
                        fchCargue, 
                        txtArchivo, 
                        txtFisico, 
                        fchInicio, 
                        fchFinal, 
                        numProgreso, 
                        seqEstado, 
                        seqUsuario
                    ) values (
                        now(),
                        '" . $_FILES['archivo']['name'] . "',
                        '$txtFisico',
                        null,
                        null,
                        0,
                        1,
                        " . $_SESSION['seqUsuario'] . "
                    )
                ";
                $aptBd->execute($sql);
                $aptBd->CommitTrans();

                $claFecha = new DateTime();

                $this->arrMensajes[] = "Se ha creado el cargue satisfactoriamente, debe esperar " . (59 - $claFecha->format("i")) . " minutos para iniciar el procesamiento de novedades";

            } catch (Exception $objError){
                $this->arrErrores[] = "No se pudo crear el registro del cargue en la base de datos";
                $aptBd->RollbackTrans();
                unlink($txtCarpeta . $txtFisico);
            }
        }

    }

    /**
     * OBTIENE EL CARGUE QUE HA SIDO CREADO PARA INICIO DEL PROCESAMIENTO DE NOVEDADES
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return int
     */

    public function carguePorProcesar(){
        global $aptBd;
        $sql = "
            select seqCargue
            from t_fnv_cargue
            where seqEstado = 1
        ";
        $objRes = $aptBd->execute($sql);
        return intval($objRes->fields['seqCargue']);
    }

    /**
     * MODIFICA EL ESTADO DEL CARGUE Y LE DA FECHA AL INICIO DEL PROCESAMIENTO
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return void
     **/

    public function iniciarCargue($seqCargue, $seqEstado){
        global $aptBd;
        try {
            $aptBd->BeginTrans();
            $sql = "
              update t_fnv_cargue set 
                  seqEstado = $seqEstado,
                  numProgreso = 0,
                  fchInicio = now(),
                  fchFinal = null
              where seqCargue = $seqCargue;
            ";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
        }catch (Exception $objError){
            $this->arrErrores[] = "No se ha podido cambiar de estado el cargue";
            $aptBd->RollBackTrans();
        }
    }

    /**
     * CARGA EN UN ARRAY EL ARCHIVO PARA PROCESAR
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @param $seqCargue
     * @return array
     */

    public function cargarArchivo($seqCargue){
        global $aptBd, $txtPrefijoRuta, $arrConfiguracion;

        // obtiene el nombre del archivo que debe procesar
        try{
            $sql = "
                select txtFisico
                from t_fnv_cargue
                where seqCargue = $seqCargue
            ";
            $objRes = $aptBd->execute($sql);
            $txtFisico = $objRes->fields['txtFisico'];
        } catch (Exception $objError){
            $this->arrErrores[] = "No se pudo obtener el nombre fisico del archivo a procesar";
            $txtFisico = "";
        }

        // si hay archivo
        if($txtFisico != ""){
            $arrArchivo = array();

            // si el arcivo existe lo procesa
            $txtArchivo = $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "inscripcionFonvivienda/" . $txtFisico;
            if(file_exists($txtArchivo)){
                try {
                    foreach (file($txtArchivo) as $numLinea => $txtLinea) {
                        if (trim($txtLinea) != "") {
                            $arrArchivo[$numLinea] = explode("|", trim(utf8_encode($txtLinea)));
                            foreach ($arrArchivo[$numLinea] as $numColumna => $txtCelda) {
                                preg_match("/(\d{2})\/(\d{2})\/(\d{2,4})/", $txtCelda, $arrMatch);
                                if (!empty($arrMatch)) {
                                    $arrMatch[3] = ($arrMatch[3] < 100) ? $arrMatch[3] + 2000 : $arrMatch[3];
                                    $txtCelda = new DateTime($arrMatch[3] . "-" . $arrMatch[2] . "-" . $arrMatch[1]);
                                } else {
                                    $txtCelda = trim($txtCelda);
                                }
                                $arrArchivo[$numLinea][$numColumna] = $txtCelda;
                            }
                        }
                    }
                }catch (Exception $objError){
                    $this->arrErrores[] = "Error al procesar el archivo";
                    $arrArchivo = array();
                }
            }else{
                $this->arrErrores[] = "El archivo $txtFisico del cargue $seqCargue no existe";
            }
        }
        return $arrArchivo;
    }

    /**
     * QUITA LOS REGISTROS QUE NO SE DEBEN PROCESAR
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @param array $arrArchivo
     * @return array $arrArchivo
     */

    public function limpiezaArchivo($arrArchivo){
        unset($arrArchivo[0]);
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $bolBorrar = false;
            if (!in_array(trim(mb_strtolower($arrLinea[10])), $this->arrEstados)) {
                $bolBorrar = true;
            }
            if(trim(mb_strtolower($arrLinea[4])) != "bogota" or strpos( trim(mb_strtolower($arrLinea[3])) , "bogota" ) === false){
                $bolBorrar = true;
            }
            if($bolBorrar == true) {
                unset($arrArchivo[$numLinea]);
            }
        }
        return $arrArchivo;
    }

    /**
     * ARMA LOS HOGARES QUE SE DEBEN TRABAJAR
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @param $arrArchivo
     * @return void
     */

    public function hogares($arrArchivo){
        if(! empty($arrArchivo)){
            foreach($arrArchivo as $numLinea => $arrLinea){

                $numHogar = $arrLinea[0];
                $txtIngresos = $this->ingresos($arrLinea[1],$numLinea);
                $numCelular = $arrLinea[11];
                $numFijo = $arrLinea[12];
                $txtCorreo = $arrLinea[13];
                $txtDireccion = $arrLinea[14];
                $numTipoDocumento = $this->tipoDocumento($arrLinea[15],$numLinea);
                $numDocumento = doubleval($arrLinea[16]);
                $txtNombres = $this->limpiezaNombres($arrLinea[17]);
                $txtApellidos = $this->limpiezaNombres($arrLinea[18]);
                $txtDireccionSolucion = trim(mb_strtoupper($arrLinea[23]));
                $txtSolucion = $this->solucion($arrLinea[24],$numLinea);
                $txtModalidad = $this->modalidad($arrLinea[25],$numLinea);

                $this->arrHogares[$numHogar]['ingresos'] = $txtIngresos;
                $this->arrHogares[$numHogar]['celular'] = $numCelular;
                $this->arrHogares[$numHogar]['fijo'] = $numFijo;
                $this->arrHogares[$numHogar]['correo'] = $txtCorreo;
                $this->arrHogares[$numHogar]['direccion'] = $txtDireccion;
                $this->arrHogares[$numHogar]['direccionSolucion'] = $txtDireccionSolucion;
                $this->arrHogares[$numHogar]['solucion'] = $txtSolucion;
                $this->arrHogares[$numHogar]['modalidad'] = $txtModalidad;
                $this->arrHogares[$numHogar]['hogar'][$numTipoDocumento][$numDocumento]['nombres'] = $txtNombres;
                $this->arrHogares[$numHogar]['hogar'][$numTipoDocumento][$numDocumento]['apellidos'] = $txtApellidos;

                $this->numTotalLineas++;

            }
        }else{
            $this->arrErrores[] = "No hay informacion valida dentro del archivo para procesar";
        }
    }

    /**
     * BUSCA LAS COINCIDENCIAS ENTRE LOS CIUDADANOS
     * QUE VIENEN EN EL ARCHIVO DE FONVIVIENDA
     * Y LOS CIUDADANOS DE LA BASE DE DATOS
     * POR CEDULA Y POR NOMBRES
     * @param $seqCargue
     */

    public function coincidencias($seqCargue){

        mensaje("Cargando ciudadanos");

        $this->ciudadanos();

        mensaje("Encontrando coincidencias para " . $this->numTotalLineas . " personas");

        $numProcesados = 1;
        foreach($this->arrHogares as $numHogar => $arrHogar){
            foreach($arrHogar['hogar'] as $seqTipoDocumento => $arrCiudadanos){
                foreach($arrCiudadanos as $numDocumento => $arrNombre){

                    $txtNombreArchivo = trim(mb_strtolower($arrNombre['nombres'] . " " . $arrNombre['apellidos']));
                    $numProgreso = ($numProcesados / $this->numTotalLineas) * 100;
                    mensaje("(" . $numProcesados . " de " . $this->numTotalLineas . ") Buscando coincidencias para [$numDocumento] $txtNombreArchivo");
                    $this->actualizarProgreso($seqCargue,$numProgreso);

                    // Busqueda por cedula
                    if(isset($this->arrCiudadanos[$numDocumento])){
                        $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias']["N/A"][$numDocumento] = mb_strtoupper($this->arrCiudadanos[$numDocumento]);
                    }else {
                        // Busqueda por nombres
                        foreach ($this->arrCiudadanos as $numDocumentoCiudadano => $txtNombre) {
                            $numDistancia = levenshtein($txtNombreArchivo, $txtNombre);
                            $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'][$numDistancia][$numDocumentoCiudadano] = mb_strtoupper($txtNombre);
                        }
                        ksort($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias']);
                        $i = 0;
                        foreach ($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'] as $numDistancia => $arrCoincidencias) {
                            if ($i > 2) {
                                unset($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'][$numDistancia]);
                            }else{
                                asort($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'][$numDistancia]);
                            }
                            $i++;
                        }
                    }

                    $numProcesados++;
                }
            }
        }

    }

    /**
     * MODIFICA EL ESTADO DEL CARGUE Y LE DA FECHA AL FINAL DEL PROCESAMIENTO
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return void
     **/

    public function finalizarCargue($seqCargue, $seqEstado){
        global $aptBd;
        try {
            $aptBd->BeginTrans();

            $txtErrores = (empty($this->arrErrores))? "null" : "'" . json_encode($this->arrErrores) . "'";

            $sql = "
              update t_fnv_cargue set 
                  seqEstado = $seqEstado,                  
                  fchFinal = now(),
                  txtErrores = $txtErrores
              where seqCargue = $seqCargue;
            ";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
        }catch (Exception $objError){
            $this->arrErrores[] = "No se ha podido cambiar de estado el cargue";
            $aptBd->RollBackTrans();
        }
    }

    /**
     * ALMACENA LOS REGISTROS DE COINCIDENCIAS
     * PROCESADAS EN LA BASE DE DATOS
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @param int seqCargue
     */

    public function salvarNovedades($seqCargue){
        global $aptBd;
        try {
            $aptBd->BeginTrans();
            foreach ($this->arrHogares as $numHogar => $arrHogar) {

                $sql = "
                    insert into t_fnv_hogar (
                        seqCargue,
                        numHogar, 
                        txtIngresos, 
                        numCelular, 
                        numFijo, 
                        txtCorreo, 
                        txtDireccion, 
                        txtDireccionSolucion, 
                        txtSolucion, 
                        txtModalidad,
                        seqEstadoHogar,
                        txtErrores,
                        seqFormulario
                    ) values (
                        $seqCargue,
                        $numHogar,
                        '" . $arrHogar['ingresos'] . "',
                        " . doubleval($arrHogar['celular']) . ",
                        " . doubleval($arrHogar['fijo']) . ",
                        '" . $arrHogar['correo'] . "',
                        '" . $arrHogar['direccion'] . "',
                        '" . $arrHogar['direccionSolucion'] . "',
                        '" . $arrHogar['solucion'] . "',
                        '" . $arrHogar['modalidad'] . "',
                        1,
                        null,
                        null
                    )
                ";
                $aptBd->execute($sql);
                $seqHogar = $aptBd->Insert_ID();

                foreach($arrHogar['hogar'] as $seqTipoDocumento => $arrCiudadanos){
                    foreach($arrCiudadanos as $numDocumento => $arrCiudadano){
                        $sql = "
                            insert into t_fnv_ciudadano( 
                                seqHogar, 
                                seqTipoDocumento, 
                                numDocumento, 
                                txtNombres, 
                                txtApellidos, 
                                txtCoincidencias, 
                                bolPrincipal
                            ) values (
                                $seqHogar,
                                $seqTipoDocumento,
                                $numDocumento,
                                '" . $arrCiudadano['nombres'] . "',
                                '" . $arrCiudadano['apellidos'] . "',
                                '" . json_encode($arrCiudadano['coincidencias']) . "',
                                0
                            )
                        ";
                        $aptBd->execute($sql);
                    }
                }


            }
            $aptBd->CommitTrans();
        } catch (Exception $objError){
            $this->arrErrores[] = "Hubo un error al almacenar las novedades";
            $aptBd->RollBackTrans();
        }
    }

    /**
     * OBTIENE EL LISTADO DE CARGUES
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return array
     */

    public function listadoCargues(){
        global $aptBd;
        $sql = "
            select 
                car.seqCargue, 
                car.fchCargue, 
                car.txtArchivo, 
                car.seqEstado,
                est.txtEstado,
                concat(usu.txtNombre,' ',usu.txtApellido) as txtUsuario
            from t_fnv_cargue car
            inner join t_fnv_estado est on car.seqEstado = est.seqEstado
            inner join t_cor_usuario usu on car.seqUsuario = usu.seqUsuario
            order by car.seqCargue desc        
        ";
        return $aptBd->GetAll($sql);
    }

    /**
     * OBTIENE LOS DATOS DEL ARCHIVO DE CARGADO
     * @param $seqCargue
     * @return array
     */

    public function obtenerArchivo($seqCargue){
        global $aptBd;
        $arrArchivo = array();
        $sql = "
            select 
                car.txtArchivo,
                car.txtFisico
            from t_fnv_cargue car
            where car.seqCargue = $seqCargue
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $arrArchivo['nombre'] = $objRes->fields['txtArchivo'];
            $arrArchivo['fisico'] = $objRes->fields['txtFisico'];
            $objRes->MoveNext();
        }
        return $arrArchivo;
    }

    /**
     * ELIMINA EL CARGUE
     * @param $seqCargue
     * @param $seqEstado
     * @return boolean
     */

    public function eliminarCargue($seqCargue){
        global $aptBd, $txtPrefijoRuta, $arrConfiguracion;

        $sql = "
            select  
                car.seqEstado,
                car.txtFisico,
                est.txtEstado
            from t_fnv_cargue car
            inner join t_fnv_estado est on car.seqEstado = est.seqEstado
            where car.seqCargue = $seqCargue            
        ";
        $objRes = $aptBd->execute($sql);
        if($objRes->fields){

            if(
                $objRes->fields['seqEstado'] == 2 or
                $objRes->fields['seqEstado'] == 5 or
                $objRes->fields['seqEstado'] == 6
            ){
                $this->arrErrores[] = "No se puede eliminar el cargue, se encuentra en el estado " . $objRes->fields['txtEstado'];
            }else{
                try {
                    $aptBd->BeginTrans();

                    $sql = "
                        delete from t_fnv_ciudadano
                        where seqHogar in (
                          select seqHogar
                          from t_fnv_hogar
                          where seqCargue = $seqCargue
                        )
                    ";
                    $aptBd->execute($sql);

                    $sql = "
                        delete from t_fnv_hogar
                        where seqCargue = $seqCargue                    
                    ";
                    $aptBd->execute($sql);

                    $sql = "
                        delete from t_fnv_cargue
                        where seqCargue = $seqCargue
                    ";
                    $aptBd->execute($sql);

                    unlink($txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "inscripcionFonvivienda/" . $objRes->fields['txtFisico']);

                    $this->arrMensajes[] = "Ha eliminado el cargue $seqCargue satisfactoriamente";

                    $aptBd->CommitTrans();

                } catch (Exception $objError){
                    $this->arrErrores[] = "Hubo problemas al eliminar el cargue " . $seqCargue;
                    $this->arrErrores[] = $objError->getMessage();
                    $aptBd->RollBackTrans();
                }

            }
        }

    }

    /**
     * OBTIENE LOS ERRORES DEL CARGUE
     * @param $txtIngresos
     * @param $numLinea
     * @return string
     */

    public function verErrores($seqCargue){
        global $aptBd;
        $sql = "
            select txtErrores
            from t_fnv_cargue
            where seqCargue = $seqCargue
        ";
        $objRes = $aptBd->execute($sql);
        return json_decode($objRes->fields['txtErrores'],true);
    }

    /**
     * OBTIENE LA INFORMACION DEL CARGUE
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @param $seqCargue
     */

    public function cargar($seqCargue, $numHogar = null){
        global $aptBd;

        $sql = "
            select 
                car.seqCargue, 
                car.fchCargue, 
                car.txtArchivo, 
                car.txtFisico, 
                car.fchInicio, 
                car.fchFinal, 
                car.numProgreso, 
                car.seqEstado, 
                est.txtEstado,
                est.txtDescripcion,
                car.seqUsuario, 
                concat(usu.txtNombre,' ',usu.txtApellido) as txtUsuario,
                car.txtErrores
            from t_fnv_cargue car
            inner join t_fnv_estado est on car.seqEstado = est.seqEstado
            inner join t_cor_usuario usu on car.seqUsuario = usu.seqUsuario
            where car.seqCargue = $seqCargue            
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $this->seqCargue = $objRes->fields['seqCargue'];
            $this->fchCargue = new DateTime($objRes->fields['fchCargue']);
            $this->txtArchivo = $objRes->fields['txtArchivo'];
            $this->txtFisico = $objRes->fields['txtFisico'];
            $this->fchInicio = new DateTime($objRes->fields['fchInicio']);
            $this->fchFinal = new DateTime($objRes->fields['fchFinal']);
            $this->numProgreso = doubleval($objRes->fields['numProgreso']);
            $this->seqEstado = $objRes->fields['seqEstado'];
            $this->txtEstado = $objRes->fields['txtEstado'];
            $this->txtDescripcion = $objRes->fields['txtDescripcion'];
            $this->seqUsuario = $objRes->fields['seqUsuario'];
            $this->txtUsuario = $objRes->fields['txtUsuario'];
            if($objRes->fields['txtErrores'] != "") {
                $this->arrErrores = json_decode($objRes->fields['txtErrores'], true);
            }

            $objRes->MoveNext();
        }

        $txtCondicion = ($numHogar == null)? "" : "and hog.numHogar = $numHogar";

        $sql = "
            select
                hog.seqHogar, 
                hog.numHogar, 
                hog.txtIngresos, 
                hog.numCelular, 
                hog.numFijo, 
                hog.txtCorreo, 
                hog.txtDireccion, 
                hog.txtDireccionSolucion, 
                hog.txtSolucion, 
                hog.txtModalidad,
                hog.seqEstadoHogar,
                eho.txtEstadoHogar,
                eho.txtDescripcion,
                hog.txtErrores,
                hog.seqFormulario,
                hog.txtObservaciones
            from t_fnv_hogar hog
            inner join t_fnv_estado_hogar eho on hog.seqEstadoHogar = eho.seqEstadoHogar
            where hog.seqCargue = $seqCargue
            $txtCondicion
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $numHogar = $objRes->fields['numHogar'];
            if($objRes->fields['txtErrores'] != "") {
                $this->arrErrores += json_decode($objRes->fields['txtErrores'], true);
            }
            unset($objRes->fields['txtErrores']);
            unset($objRes->fields['numHogar']);
            foreach($objRes->fields as $txtClave => $txtValor){
                $this->arrHogares[$numHogar][$txtClave] = $txtValor;
            }
            $objRes->MoveNext();
        }

        foreach($this->arrHogares as $numHogar => $arrHogar){

            $sql = "
                select 
                    ciu.seqCiudadano,
                    ciu.seqTipoDocumento, 
                    tdo.txtTipoDocumento,
                    ciu.numDocumento, 
                    ciu.txtNombres, 
                    ciu.txtApellidos, 
                    ciu.txtCoincidencias, 
                    ciu.bolPrincipal,
                    ciu.seqCiudadanoCoincidencia
                from t_fnv_ciudadano ciu
                inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
                where ciu.seqHogar = " . $arrHogar['seqHogar'] . "            
            ";
            $objRes = $aptBd->execute($sql);
            while($objRes->fields){
                $seqCiudadano = $objRes->fields['seqCiudadano'];
                $arrCoincidencias = json_decode($objRes->fields['txtCoincidencias'],true);
                unset($objRes->fields['txtCoincidencias']);
                foreach($objRes->fields as $txtClave => $txtValor) {
                    $this->arrHogares[$numHogar]['ciudadanos'][$seqCiudadano][$txtClave] = $txtValor;
                }
                $this->arrHogares[$numHogar]['ciudadanos'][$seqCiudadano]['coincidencias'] = $arrCoincidencias;
                $objRes->MoveNext();
            }
        }

    }

    /**
     * OBTIENE LOS ESTADOS DEL HOGAR
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @return array
     */

    public function estadosHogar(){
        global $aptBd;

        $sql = "
            select 
                seqEstadoHogar, 
                txtEstadoHogar, 
                txtDescripcion
            from t_fnv_estado_hogar
        ";
        return $aptBd->GetAll($sql);
    }

    /**
     * DETERMINA LA ACCION A REALIZAR
     * PARA CADA CIUDADANO DEL HOGAR DE FONVIVIENDA
     * @param $seqFormulario
     * @param $numHogar
     * @param $numDocumento
     */

    public function procesarNovedades($seqFormulario, $numHogar, $numDocumento){
        if(isset($this->arrHogares[$numHogar]['ciudadanos'])){
            foreach($this->arrHogares[$numHogar]['ciudadanos'] as $idCiudadano => $arrCiudadano){
                $numDocumentoCoincidencia = $arrCiudadano['numDocumento'];
                if($numDocumentoCoincidencia == $numDocumento){
                    $this->arrNovedades[$numDocumentoCoincidencia] = "Marcado para postulante principal";
                }else{
                    if(isset($arrCiudadano['coincidencias']['N/A'])){
                        $claCiudadano = new Ciudadano();
                        $seqFormularioCoincidencia = $claCiudadano->formularioVinculado($arrCiudadano['numDocumento']);
                        if($seqFormularioCoincidencia != $seqFormulario){
                            $this->arrErrores['ciudadano'][$numDocumentoCoincidencia] = "No se puede fusionar, pertenece al hogar $seqFormularioCoincidencia";
                        }else{
                            $this->arrNovedades[$numDocumentoCoincidencia] = "Ya pertenece al hogar seleccionado";
                        }
                    }else{
                        $this->arrNovedades[$numDocumentoCoincidencia] = "Se unirá al formulario seleccionado";
                    }
                }
            }
            $this->arrHogares[$numHogar]['seqFormulario'] = $seqFormulario;
        }else{
            $this->arrErrores['general'] = "Obtenga primero la informacion del cargue";
        }
    }

    /**
     * VALIDA EL FORMULARIO DE NOVEDADES
     * @param $arrPost
     */
    public function validarFormulario($arrPost){
        global $aptBd;

        switch ($arrPost['seqEstadoHogar']){
            case 3: // No procesar
                if(trim($arrPost['txtObservaciones']) == ""){
                    $this->arrErrores['general'][] = "Indique una observación para marcar al hogar como 'no procesar'";
                }
                break;
            case 4: // procesado
                $this->arrErrores['general'][] = "No se puede realizar ninguna accion en un hogar ya procesado";
                break;
        }

        $sql = "
            select numHogar
            from t_fnv_hogar
            where seqFormulario = " . $arrPost['seqFormulario'] . "
              and numHogar <> " . $arrPost['numHogar'] . "
        ";
        $objRes = $aptBd->execute($sql);
        if($objRes->RecordCount() != 0){
            $this->arrErrores['general'][] = "El formulario está siendo usado por el hogar " . $objRes->fields['numHogar'];
        }

    }

    public function salvarSolucionNovedades($arrPost){
        global $aptBd;
        try {
            $aptBd->BeginTrans();

            $txtObservaciones = (trim($arrPost['txtObservaciones']) == "")? "null" : "'" . $arrPost['txtObservaciones'] . "'";

            $sql = "
                update t_fnv_hogar set
                  seqEstadoHogar = " . $arrPost['seqEstadoHogar'] . ", 
                  seqFormulario = " . $arrPost['seqFormulario'] . ",
                  txtObservaciones = $txtObservaciones
                where seqCargue = " . $arrPost['seqCargue'] . " 
                  and numHogar = " . $arrPost['numHogar'] . "
            ";
            $aptBd->execute($sql);

            $seqHogar = array_shift(obtenerDatosTabla(
                "t_fnv_hogar",
                array("seqHogar","numHogar"),
                "numHogar",
                "numHogar = " . $arrPost['numHogar'] . " and seqCargue = " . $arrPost['seqCargue']
            ));

            $sql = "
                update t_fnv_ciudadano set
                    bolPrincipal = 1,
                    seqCiudadanoCoincidencia = " . $arrPost['seqCiudadano'] . "
                where seqHogar = $seqHogar
                  and numDocumento = " . $arrPost['numDocumento'] . "
            ";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Se han salvado la solución de las novedades";

            $aptBd->Committrans();
        }catch (Exception $objError){
            $this->arrErrores['general'][] = "No se pudo salvar la información del hogar";
            $this->arrErrores['general'][] = $objError->getMessage();
            $aptBd->RollBackTrans();
        }

    }

    /*****************************************************************************************************************/

    private function ingresos($txtIngresos,$numLinea){
        $txtRangoIngresos = "";
        if(! in_array(trim(mb_strtoupper($txtIngresos)), $this->arrRangoIngresos)){
            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[1] . " es desconocido";
        }else{
            $txtRangoIngresos = trim(mb_strtoupper($txtIngresos));
        }
        return $txtRangoIngresos;
    }

    private function tipoDocumento($txtTipoDocumento,$numLinea){
        switch (trim(mb_strtolower($txtTipoDocumento))){
            case "c.c.":
                $numTipoDocumento = 1;
                break;
            case "c.e.":
                $numTipoDocumento = 2;
                break;
            default:
                $numTipoDocumento = 0;
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[15] . " es desconocido";
                break;
        }
        return $numTipoDocumento;
    }

    private function solucion($txtSolucion,$numLinea){
        $txtTipoSolucion = "";
        if(! in_array(trim(mb_strtoupper($txtSolucion)), $this->arrSoluciones)){
            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[24] . " es desconocido";
        }else{
            $txtTipoSolucion = trim(mb_strtoupper($txtSolucion));
        }
        return $txtTipoSolucion;
    }

    private function modalidad($txtModalidad,$numLinea){
        $txtTipoModalidad = "";
        if(! in_array(trim(mb_strtoupper($txtModalidad)), $this->arrModalidad)){
            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[25] . " es desconocido";
        }else{
            $txtTipoModalidad = trim(mb_strtoupper($txtModalidad));
        }
        return $txtTipoModalidad;
    }

    private function limpiezaNombres($txtNombres){
        $txtNombres = trim(mb_strtoupper($txtNombres));
        while(strpos($txtNombres,"  ") !== false){
            $txtNombres = str_replace("  "," ",$txtNombres);
        }
        return $txtNombres;
    }

    private function ciudadanos(){
        global $aptBd;
        $this->arrCiudadanos = array();
        $sql = "
            select
                ciu.numDocumento,
                ciu.txtNombre1,
                ciu.txtNombre2,
                ciu.txtApellido1,
                ciu.txtApellido2
            from t_ciu_ciudadano ciu
        ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $numDocumento = $objRes->fields['numDocumento'];
            $txtNombre = trim($objRes->fields['txtNombre1']);
            $txtNombre .= (trim($objRes->fields['txtNombre2']) != "") ? " " . trim($objRes->fields['txtNombre2']) : "";
            $txtNombre .= " " . trim($objRes->fields['txtApellido1']);
            $txtNombre .= (trim($objRes->fields['txtApellido2']) != "") ? " " . trim($objRes->fields['txtApellido2']) : "";
            $this->arrCiudadanos[$numDocumento] = mb_strtolower($txtNombre);
            $objRes->MoveNext();
        }
    }

    private function actualizarProgreso($seqCargue, $numProgreso){
        global $aptBd;
        try {
            $aptBd->BeginTrans();
            $sql = "
                update t_fnv_cargue set
                    numProgreso = '$numProgreso'
                where seqCargue = $seqCargue
            ";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
        }catch (Exception $objError){
            $this->arrErrores[] = "No se pudo actualizar el progreso";
            $aptBd->RollBackTrans();
        }
    }

    public function procesarCargue($seqCargue){
        global $aptBd, $arrConfiguracion;

        // obtiene la informacion del cargue
        $this->cargar($seqCargue);

        // iteracion de cada hogar
        try{

            $aptBd->BeginTrans();

            foreach($this->arrHogares as $numHogar => $arrHogar){

                // verifica el estado de cada hogar
                if($arrHogar['seqEstadoHogar'] == 2){

                    // se usara para el seguimiento
                    $claFormularioOriginal = new FormularioSubsidios();
                    $claFormularioOriginal->cargarFormulario($arrHogar['seqFormulario']);

                    // para las modificaciones que se van a realizar
                    $claFormularioModificado = new FormularioSubsidios();
                    $claFormularioModificado->cargarFormulario($arrHogar['seqFormulario']);

                    // verifica si se solicita fusionar el formulario con uno existente
                    if( $arrHogar['seqFormulario'] != 0 ){

                        // recorre los ciudadanos
                        $numDocumentoSeguimiento = 0;
                        $txtNombreSeguimiento = "";
                        foreach($arrHogar['ciudadanos'] as $idCiudadano => $arrCiudadano){
                            foreach($claFormularioOriginal->arrCiudadano as $seqCiudadano => $objCiudadano){

                                if($arrCiudadano['seqCiudadanoCoincidencia'] == $seqCiudadano) {

                                    $objCiudadano->seqParentesco = 1;
                                    $objCiudadano->txtNombre1    = $arrCiudadano['txtNombres'];
                                    $objCiudadano->txtNombre2    = null;
                                    $objCiudadano->txtApellido1  = $arrCiudadano['txtApellidos'];
                                    $objCiudadano->txtApellido2  = null;

                                    $numDocumentoSeguimiento = $arrCiudadano['numDocumento'];
                                    $txtNombreSeguimiento    = $arrCiudadano['txtNombres'] . " " . $arrCiudadano['txtApellidos'];

                                    $claFormularioModificado->arrCiudadano[$seqCiudadano] = $objCiudadano;
                                    $objCiudadano->editarCiudadano($seqCiudadano);

                                }elseif($objCiudadano->numDocumento == $arrCiudadano['numDocumento']){

                                    $objCiudadano->txtNombre1    = $arrCiudadano['txtNombres'];
                                    $objCiudadano->txtNombre2    = null;
                                    $objCiudadano->txtApellido1  = $arrCiudadano['txtApellidos'];
                                    $objCiudadano->txtApellido2  = null;

                                    $claFormularioModificado->arrCiudadano[$seqCiudadano] = $objCiudadano;
                                    $objCiudadano->editarCiudadano($seqCiudadano);

                                }else{

                                    $claCiudadano = new Ciudadano();
                                    $claCiudadano->bolBeneficiario = 0;
                                    $claCiudadano->bolCertificadoElectoral = 0;
                                    $claCiudadano->bolLgtb = 0;
                                    $claCiudadano->bolSoporteDocumento = 0;
                                    $claCiudadano->fchNacimiento = null;
                                    $claCiudadano->numAfiliacionSalud = 0;
                                    $claCiudadano->numAnosAprobados = 0;
                                    $claCiudadano->numDocumento = $arrCiudadano['numDocumento'];
                                    $claCiudadano->seqCajaCompensacion = 1;
                                    $claCiudadano->seqCondicionEspecial = 6;
                                    $claCiudadano->seqCondicionEspecial2 = 6;
                                    $claCiudadano->seqCondicionEspecial3 = 6;
                                    $claCiudadano->seqEstadoCivil = 9;
                                    $claCiudadano->seqEtnia = 1;
                                    $claCiudadano->seqGrupoLgtbi = 0;
                                    $claCiudadano->seqNivelEducativo = 1;
                                    $claCiudadano->seqOcupacion = 20;
                                    $claCiudadano->seqParentesco = 12;
                                    $claCiudadano->seqSalud = 0;
                                    $claCiudadano->seqSexo = $this->deducirSexo($arrCiudadano['txtNombres']);
                                    $claCiudadano->seqTipoDocumento = $arrCiudadano['seqTipoDocumento'];
                                    $claCiudadano->seqTipoVictima = 0;
                                    $claCiudadano->txtApellido1 = $arrCiudadano['txtApellidos'];
                                    $claCiudadano->txtApellido2 = null;
                                    $claCiudadano->txtNombre1 = $arrCiudadano['txtNombres'];
                                    $claCiudadano->txtNombre2 = null;
                                    $claCiudadano->valIngresos = 0;
                                    $claCiudadano->fchExpedicion = null;
                                    $claCiudadano->txtTipoSoporte = null;
                                    $claCiudadano->txtEntidadDocumento = null;
                                    $claCiudadano->numIndicativoSerial = null;
                                    $claCiudadano->numNotariaDocumento = null;
                                    $claCiudadano->seqCiudadDocumento = null;
                                    $claCiudadano->numConsecutivoCasado = null;
                                    $claCiudadano->numNotariaCasado = null;
                                    $claCiudadano->seqCiudadCasado = null;
                                    $claCiudadano->numConsecutivoCSCDL = null;
                                    $claCiudadano->txtEntidadCSCDL = null;
                                    $claCiudadano->seqCiudadCSCDL = null;
                                    $claCiudadano->numNotariaCSCDL = null;
                                    $claCiudadano->numNotariaSoltero = null;
                                    $claCiudadano->seqCiudadSoltero = null;
                                    $claCiudadano->txtCertificacionUnion = null;
                                    $claCiudadano->numConsecutivoUnion = null;
                                    $claCiudadano->txtEntidadUnion = null;
                                    $claCiudadano->numNotariaUnion = null;
                                    $claCiudadano->seqCiudadUnion = null;
                                    $claCiudadano->numConsecutivoPartida = null;
                                    $claCiudadano->txtParroquiaPartida = null;
                                    $claCiudadano->seqCiudadPartida = null;

                                    $claCiudadano->guardarCiudadano();
                                    $claFormularioModificado->arrCiudadano[$claCiudadano->seqCiudadano] = $claCiudadano;
                                    $claCiudadano = null;

                                    foreach($claCiudadano->arrErrores as $txtError){
                                        $this->arrErrores['general'][] = $txtError;
                                    }

                                }

                            }
                        }

                    }else{

                        $bolPrincipal = false;
                        $numDocumentoSeguimiento = 0;
                        $txtNombreSeguimiento = "";
                        foreach($arrHogar['ciudadanos'] as $idCiudadano => $arrCiudadano){

                            if($bolPrincipal == false){
                                $numDocumentoSeguimiento = $arrCiudadano['numDocumento'];
                                $txtNombreSeguimiento = $arrCiudadano['txtNombres'] . " " . $arrCiudadano['txtApellidos'];
                            }

                            $claCiudadano = new Ciudadano();
                            $claCiudadano->bolBeneficiario = 0;
                            $claCiudadano->bolCertificadoElectoral = 0;
                            $claCiudadano->bolLgtb = 0;
                            $claCiudadano->bolSoporteDocumento = 0;
                            $claCiudadano->fchNacimiento = null;
                            $claCiudadano->numAfiliacionSalud = 0;
                            $claCiudadano->numAnosAprobados = 0;
                            $claCiudadano->numDocumento = $arrCiudadano['numDocumento'];
                            $claCiudadano->seqCajaCompensacion = 1;
                            $claCiudadano->seqCondicionEspecial = 6;
                            $claCiudadano->seqCondicionEspecial2 = 6;
                            $claCiudadano->seqCondicionEspecial3 = 6;
                            $claCiudadano->seqEstadoCivil = 9;
                            $claCiudadano->seqEtnia = 1;
                            $claCiudadano->seqGrupoLgtbi = 0;
                            $claCiudadano->seqNivelEducativo = 1;
                            $claCiudadano->seqOcupacion = 20;
                            $claCiudadano->seqParentesco = ($bolPrincipal == false)? 1 : 12;
                            $claCiudadano->seqSalud = 0;
                            $claCiudadano->seqSexo = $this->deducirSexo($arrCiudadano['txtNombres']);
                            $claCiudadano->seqTipoDocumento = $arrCiudadano['seqTipoDocumento'];
                            $claCiudadano->seqTipoVictima = 0;
                            $claCiudadano->txtApellido1 = $arrCiudadano['txtApellidos'];
                            $claCiudadano->txtApellido2 = null;
                            $claCiudadano->txtNombre1 = $arrCiudadano['txtNombres'];
                            $claCiudadano->txtNombre2 = null;
                            $claCiudadano->valIngresos = 0;
                            $claCiudadano->fchExpedicion = null;
                            $claCiudadano->txtTipoSoporte = null;
                            $claCiudadano->txtEntidadDocumento = null;
                            $claCiudadano->numIndicativoSerial = null;
                            $claCiudadano->numNotariaDocumento = null;
                            $claCiudadano->seqCiudadDocumento = null;
                            $claCiudadano->numConsecutivoCasado = null;
                            $claCiudadano->numNotariaCasado = null;
                            $claCiudadano->seqCiudadCasado = null;
                            $claCiudadano->numConsecutivoCSCDL = null;
                            $claCiudadano->txtEntidadCSCDL = null;
                            $claCiudadano->seqCiudadCSCDL = null;
                            $claCiudadano->numNotariaCSCDL = null;
                            $claCiudadano->numNotariaSoltero = null;
                            $claCiudadano->seqCiudadSoltero = null;
                            $claCiudadano->txtCertificacionUnion = null;
                            $claCiudadano->numConsecutivoUnion = null;
                            $claCiudadano->txtEntidadUnion = null;
                            $claCiudadano->numNotariaUnion = null;
                            $claCiudadano->seqCiudadUnion = null;
                            $claCiudadano->numConsecutivoPartida = null;
                            $claCiudadano->txtParroquiaPartida = null;
                            $claCiudadano->seqCiudadPartida = null;

                            $claCiudadano->guardarCiudadano();
                            $claFormularioModificado->arrCiudadano[$claCiudadano->seqCiudadano] = $claCiudadano;
                            $claCiudadano = null;

                            foreach($claCiudadano->arrErrores as $txtError){
                                $this->arrErrores['general'][] = $txtError;
                            }

                            $bolPrincipal = true;
                        }

                    }

                    // ajusta los datos del formulario
                    $claFormularioModificado->txtRangoIngresosHogar = $arrHogar['txtIngresos'];
                    $claFormularioModificado->numCelular = $arrHogar['numCelular'];
                    $claFormularioModificado->numTelefono1 = $arrHogar['numFijo'];
                    $claFormularioModificado->txtCorreo = $arrHogar['txtCorreo'];
                    $claFormularioModificado->txtDireccionSolucion = (trim($arrHogar['txtDireccionSolucion']) != "")? trim($arrHogar['txtDireccionSolucion']) : trim($arrHogar['txtDireccion']);
                    $claFormularioModificado->seqModalidad = ($arrHogar['txtModalidad'] == "LEASING")? 13 : 12;

                    switch($arrHogar['txtIngresos']){
                        case "HASTA 2 SMMLV":                        $claFormularioModificado->seqTipoEsquema = 17; break; // 10 SMMLV
                        case "DE 2 SMMLV HASTA 3 SMMLV":             $claFormularioModificado->seqTipoEsquema = 16; break; //  8 SMMLV
                        case "DE 3 SMMLV HASTA 4 SMMLV":             $claFormularioModificado->seqTipoEsquema = 16; break; //  8 SMMLV
                        case "SUPERIORES A 2 SMMLV Y HASTA 4 SMMLV": $claFormularioModificado->seqTipoEsquema = 16; break; //  8 SMMLV
                    }

                    if($claFormularioModificado->seqTipoEsquema == 17){
                        $claFormularioModificado->valAspiraSubsidio = $arrConfiguracion['constantes']['salarioMinimo'] * 10;
                    }else{
                        $claFormularioModificado->valAspiraSubsidio = $arrConfiguracion['constantes']['salarioMinimo'] * 8;
                    }

                    switch(true){
                        case $arrHogar['txtSolucion'] = "VIP" and $claFormularioModificado->seqModalidad == 12:
                            $claFormularioModificado->seqSolucion= 19;
                            break;
                        case $arrHogar['txtSolucion'] = "VIS" and $claFormularioModificado->seqModalidad == 12:
                            $claFormularioModificado->seqSolucion = 23;
                            break;
                        case $arrHogar['txtSolucion'] = "VIP" and $claFormularioModificado->seqModalidad == 13:
                            $claFormularioModificado->seqSolucion = 20;
                            break;
                        case $arrHogar['txtSolucion'] = "VIS" and $claFormularioModificado->seqModalidad == 13:
                            $claFormularioModificado->seqSolucion = 24;
                            break;
                    }

                    $claFormularioModificado->fchUltimaActualizacion = date("Y-m-d H:i:s");
                    $claFormularioModificado->seqEstadoProceso = 16;

                    if( $arrHogar['seqFormulario'] != 0 ) {
                        $claFormularioModificado->editarFormulario($arrHogar['seqFormulario']);
                    }else{
                        $claFormularioModificado->guardarFormulario();
                        $arrHogar['seqFormulario'] = $claFormularioModificado->seqFormulario;
                    }
                    foreach($claFormularioModificado->arrErrores as $txtError){
                        $this->arrErrores['general'][] = $txtError;
                    }

                    $claFormularioModificado->relacionarCiudadanoFormulario();
                    foreach($claFormularioModificado->arrErrores as $txtError){
                        $this->arrErrores['general'][] = $txtError;
                    }

                    $claSeguimiento = new Seguimiento();
                    $txtCambios = $claSeguimiento->cambiosPostulacionActo($arrHogar['seqFormulario'],$claFormularioOriginal,$claFormularioModificado);

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
                           " . $arrHogar['seqFormulario'] . ",
                           '" . date("Y-m-d H:i:s") . "',
                           " . $_SESSION['seqUsuario'] . ",
                           'ACTUALIZACION DE INFORMACION EN LA CONFORMACION DE HOGAR. HOGAR PERTENECIENTE AL GRUPO BENEFICIARIO SUBSIDIOS MI CASA YA SEGUN RESOLUCION DEL MINISTERIO DE VIVIENDA Y APORTE COMPLEMENTARIO PROGRAMA PIVE',
                           '" . mb_ereg_replace("'","\'",$txtCambios) . "',
                           " . $numDocumentoSeguimiento . ",
                           '" . $txtNombreSeguimiento . "',
                           " . 46 . "
                         )
                     ";
                    $aptBd->execute($sql);

                    $this->arrHogares[$numHogar]['seqEstadoHogar'] = 4;
                    $sql = "
                        update t_fnv_hogar set 
                            seqEstadoHogar = " . $this->arrHogares[$numHogar]['seqEstadoHogar'] . "
                        where seqCargue = $seqCargue
                          and numHogar = $numHogar  
                    ";
                    $aptBd->execute($sql);

                }

            }

            $numPendientes = 0;
            $numProcesados = 0;
            foreach($this->arrHogares as $numHogar => $arrHogar){
                if($arrHogar['seqEstadoHogar'] == 1 or $arrHogar['seqEstadoHogar'] == 3){
                    $numPendientes++;
                }
                if($arrHogar['seqEstadoHogar'] == 4){
                    $numProcesados++;
                }
            }

            $this->seqEstado = (count($this->arrHogares) == $numProcesados)? 6 : 5;
            $sql = "
                update t_fnv_cargue set 
                    seqEstado = " . $this->seqEstado . "
                where seqCargue = $seqCargue                        
            ";
            $aptBd->execute($sql);

            $this->arrMensajes[] = "Los hogares marcados han sido procesados satisfactoriamente";

            $aptBd->CommitTrans();

        } catch (Exception $objError){

            $aptBd->RollBackTrans();
            $this->arrErrores['general'][] = "Hubo errores al procesar el hogar " . $numHogar;
            $this->arrErrores['general'][] = $objError->getMessage();

        }


    }

    private function deducirSexo($txtNombres){
        global $aptBd;
        $numLargo    = strlen($txtNombres);
        $numPosicion = ( intval(strpos($txtNombres," ")) == 0 )? $numLargo : intval(strpos($txtNombres," "));
        $sql = "
          select 
            seqSexo, 
            count(seqCiudadano)
          from t_ciu_ciudadano
          where txtNombre1 like '%" . trim(substr($txtNombres, 0, $numPosicion )) . "%' 
          group by seqSexo
          order by count(seqCiudadano) desc
          limit 1
        ";
        $objRes = $aptBd->execute($sql);
        if($objRes->fields){
            return $objRes->fields['seqSexo'];
        }else{
            return 2; // por defecto será mujer
        }
    }



}