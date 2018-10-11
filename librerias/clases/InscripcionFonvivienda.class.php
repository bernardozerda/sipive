<?php

class InscripcionFonvivienda
{

    public $arrErrores;
    public $arrMensajes;
    public $arrHogares;
    public $arrNovedades;
    public $seqCargue;
    public $seqTipo;
    public $txtTipo;
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
    private $txtCarpeta;

    public function __construct()
    {

        $this->arrErrores = array();

        $this->txtCarpeta = "inscripcionFonvivienda";

        // formato de archivo de MCY seqTipo = 1 en t_fnv_tipo
        $this->arrFormato[1][] = 'ID_HOGAR';
        $this->arrFormato[1][] = 'RANGO_INGRESOS';
        $this->arrFormato[1][] = 'VALOR_SUBSIDIO';
        $this->arrFormato[1][] = 'NOMBRE_DEPARTAMENTO';
        $this->arrFormato[1][] = 'NOMBRE_MUNICIPIO';
        $this->arrFormato[1][] = 'FEC_CONSULTA';
        $this->arrFormato[1][] = 'FEC_MARCACION';
        $this->arrFormato[1][] = 'FEC_ACT_ADMIN';
        $this->arrFormato[1][] = 'NUM_ACT_ADMIN';
        $this->arrFormato[1][] = 'SECUENCIA_DESEMBOLSO';
        $this->arrFormato[1][] = 'ESTADO_HOGAR';
        $this->arrFormato[1][] = 'NUM_CELULAR';
        $this->arrFormato[1][] = 'NUM_FIJO';
        $this->arrFormato[1][] = 'CORREO_ELECTRONICO';
        $this->arrFormato[1][] = 'DIRECCION_CORRESPONDENCIA';
        $this->arrFormato[1][] = 'NOMBRE_CORTO';
        $this->arrFormato[1][] = 'NUMERO_IDENTIFICACION';
        $this->arrFormato[1][] = 'NOMBRES';
        $this->arrFormato[1][] = 'APELLIDOS';
        $this->arrFormato[1][] = 'NOMBRE_ENTIDAD';
        $this->arrFormato[1][] = 'ID VENDEDOR';
        $this->arrFormato[1][] = 'VENDEDOR';
        $this->arrFormato[1][] = 'ID PROYECTO';
        $this->arrFormato[1][] = 'PROYECTO';
        $this->arrFormato[1][] = 'TIPO_VIVIENDA';
        $this->arrFormato[1][] = 'TIPO_CONTRATO';
        $this->arrFormato[1][] = 'FEC_SOLICITUD_ASIGNACION';
        $this->arrFormato[1][] = 'COD_DEPTO_VIVIENDA';
        $this->arrFormato[1][] = 'DEPTO_VIVIENDA';
        $this->arrFormato[1][] = 'COD_MPIO_VIVIENDDA';
        $this->arrFormato[1][] = 'MPIO_VIVIENDDA';
        $this->arrFormato[1][] = 'CELULAR';
        $this->arrFormato[1][] = 'TELEFONO FIJO';
        $this->arrFormato[1][] = 'DIRECCION CORRESPONDENCIA';
        $this->arrFormato[1][] = 'ID_CONSTRUCTOR';
        $this->arrFormato[1][] = 'CONSTRUCTOR';
        $this->arrFormato[1][] = 'ID_PROYECTO';
        $this->arrFormato[1][] = 'PROYECTO';

        // formato de archivo de VIPA seqTipo = 1 en t_fnv_tipo
        $this->arrFormato[2][] = 'ID HOGAR';
        $this->arrFormato[2][] = 'NO. DOCUMENTO';
        $this->arrFormato[2][] = 'TIPO DOCUMENTO';
        $this->arrFormato[2][] = 'NOMBRE 1';
        $this->arrFormato[2][] = 'NOMBRE 2';
        $this->arrFormato[2][] = 'APELLIDO 1';
        $this->arrFormato[2][] = 'APELLIDO 2';
        $this->arrFormato[2][] = 'SEXO';
        $this->arrFormato[2][] = 'ESTADO CIVIL';
        $this->arrFormato[2][] = 'FECHA NACIMIENTO';
        $this->arrFormato[2][] = 'PARENTESCO';
        $this->arrFormato[2][] = 'COND. ÉTNICA';
        $this->arrFormato[2][] = 'DISCAPACIDAD';
        $this->arrFormato[2][] = 'MAYOR A 65 AÑOS';
        $this->arrFormato[2][] = 'CABEZA DE HOGAR';
        $this->arrFormato[2][] = 'AFILIACIÓN SALUD';
        $this->arrFormato[2][] = 'NIVEL EDUCATIVO';
        $this->arrFormato[2][] = 'AÑOS APROBADOS';
        $this->arrFormato[2][] = 'HECHO VICTIMIZANTE';
        $this->arrFormato[2][] = 'LGTBI';
        $this->arrFormato[2][] = 'GRUPO LGBTI';
        $this->arrFormato[2][] = 'OCUPACIÓN';
        $this->arrFormato[2][] = 'CORREO ELECTRÓNICO';
        $this->arrFormato[2][] = 'DIRECCIÓN';
        $this->arrFormato[2][] = 'LOCALIDAD';
        $this->arrFormato[2][] = 'BARRIO';
        $this->arrFormato[2][] = 'CIUDAD';
        $this->arrFormato[2][] = 'TELEFONOS1';
        $this->arrFormato[2][] = 'TELEFONO2';
        $this->arrFormato[2][] = 'CELULAR';
        $this->arrFormato[2][] = 'VIVIENDA ACTUAL';
        $this->arrFormato[2][] = 'VAL. ARRIENDO';
        $this->arrFormato[2][] = 'HOGARES EN VIVIENDA';
        $this->arrFormato[2][] = 'DORMITORIOS QUE EMPLEA EL HOGAR';
        $this->arrFormato[2][] = 'ENCUESTA SISBEN';
        $this->arrFormato[2][] = 'INGRESOS';
        $this->arrFormato[2][] = 'VALOR AHORRO';
        $this->arrFormato[2][] = 'ENTIDAD AHORRO';
        $this->arrFormato[2][] = 'VALOR CREDITO';
        $this->arrFormato[2][] = 'ENTIDAD CRÉDITO';
        $this->arrFormato[2][] = 'VALOR SUBSIDIO NACIONAL';
        $this->arrFormato[2][] = 'SOPORTE DEL SFV';
        $this->arrFormato[2][] = 'RANGO DE INGRESOS';
        $this->arrFormato[2][] = 'PROYECTO';
        $this->arrFormato[2][] = 'VALOR DONACIÓN / RECONOCIMIENTO ECONÓMICO';
        $this->arrFormato[2][] = 'ENTIDAD DE DONACIÓN / RECONOCIMIENTO';
        $this->arrFormato[2][] = 'SOPORTE DONACIÓN';
        $this->arrFormato[2][] = 'LINEA VALIDADA';

        // formato para EPI
        $this->arrFormato[3] = $this->arrFormato[2];


        $this->arrEstados[] = "por asignar";

        $this->arrEstadosCoincidencias = array(1,35,36,37,41,43,44,46,53);

        // MCY
        $this->arrRangoIngresos[1][] = "HASTA 2 SMMLV"; // 10 salarios
        $this->arrRangoIngresos[1][] = "DE 2 SMMLV HASTA 3 SMMLV"; // 8 salarios
        $this->arrRangoIngresos[1][] = "DE 3 SMMLV HASTA 4 SMMLV"; // 8 salarios
        $this->arrRangoIngresos[1][] = "SUPERIORES A 2 SMMLV Y HASTA 4 SMMLV"; // 8 salarios

        // VIPA
        $this->arrRangoIngresos[2][] = "HASTA 1.6 SMMLV"; // 5 SMMLV
        $this->arrRangoIngresos[2][] = "DE 1.6 A 2 SMMLV"; // 10 SMMLV

        // EPI
        $this->arrRangoIngresos[3] = $this->arrRangoIngresos[2];

        $this->arrModalidad[12] = "CRÉDITO"; // modalidad de cierre financiero
        $this->arrModalidad[13] = "LEASING"; // modalidad de leasing habitacional

        $this->arrSoluciones[12][19] = "VIP";
        $this->arrSoluciones[12][23] = "VIS";
        $this->arrSoluciones[13][20] = "VIP";
        $this->arrSoluciones[13][24] = "VIS";

        $this->arrHogares = array();

        $this->arrCiudadanos = array();

        $this->seqCargue = 0;
        $this->seqTipo = 0;
        $this->txtTipo = null;
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

        $arrCeroYUno  = array(0,1);
        $arrSiYNo     = array("SI","NO");
        $arrCeroAOnce = array(0,1,2,3,4,5,6,7,8,9,10,11);

        // Datos para la plantilla del exportable
        $this->arrPlantilla[2]['ID HOGAR'] = null;
        $this->arrPlantilla[2]['NO. DOCUMENTO'] = null;
        $this->arrPlantilla[2]['TIPO DOCUMENTO'] = obtenerDatosTabla("t_ciu_tipo_documento",array("seqTipoDocumento","txtTipoDocumento"),"seqTipoDocumento");
        $this->arrPlantilla[2]['NOMBRE 1'] = null;
        $this->arrPlantilla[2]['NOMBRE 2'] = null;
        $this->arrPlantilla[2]['APELLIDO 1'] = null;
        $this->arrPlantilla[2]['APELLIDO 2'] = null;
        $this->arrPlantilla[2]['SEXO'] = obtenerDatosTabla("t_ciu_sexo",array("seqSexo","txtSexo"),"seqSexo");
        $this->arrPlantilla[2]['ESTADO CIVIL'] = obtenerDatosTabla("t_ciu_estado_civil",array("seqEstadoCivil","txtEstadoCivil"),"seqEstadoCivil");
        $this->arrPlantilla[2]['FECHA NACIMIENTO'] = null;
        $this->arrPlantilla[2]['PARENTESCO'] = obtenerDatosTabla("t_ciu_parentesco",array("seqParentesco","txtParentesco"),"seqParentesco");
        $this->arrPlantilla[2]['COND. ÉTNICA'] = obtenerDatosTabla("t_ciu_etnia",array("seqEtnia","txtEtnia"),"seqEtnia");
        $this->arrPlantilla[2]['DISCAPACIDAD'] = $arrCeroYUno;
        $this->arrPlantilla[2]['MAYOR A 65 AÑOS'] = $arrCeroYUno;
        $this->arrPlantilla[2]['CABEZA DE HOGAR'] = $arrCeroYUno;
        $arrSalud = obtenerDatosTabla("t_ciu_salud",array("seqSalud","txtSalud"),"seqSalud");
        foreach($arrSalud as $i => $txtValor){
            $arrSalud[$i] = mb_ereg_replace(",",";",$txtValor);
        }
        $this->arrPlantilla[2]['AFILIACIÓN SALUD'] = $arrSalud;
        $this->arrPlantilla[2]['NIVEL EDUCATIVO'] = obtenerDatosTabla("t_ciu_nivel_educativo",array("seqNivelEducativo","txtNivelEducativo"),"seqNivelEducativo");
        $this->arrPlantilla[2]['AÑOS APROBADOS'] = $arrCeroAOnce;
        $this->arrPlantilla[2]['HECHO VICTIMIZANTE'] = obtenerDatosTabla("t_frm_tipovictima",array("seqTipoVictima","txtTipoVictima"),"seqTipoVictima");
        $this->arrPlantilla[2]['LGTBI'] = $arrCeroYUno;
        $this->arrPlantilla[2]['GRUPO LGBTI'] = obtenerDatosTabla("t_frm_grupo_lgtbi",array("seqGrupoLgtbi","txtGrupoLgtbi"),"seqGrupoLgtbi");
        $arrOcupacion = obtenerDatosTabla("t_ciu_ocupacion",array("seqOcupacion","txtOcupacion"),"seqOcupacion");
        foreach($arrOcupacion as $i => $txtValor){
            $arrOcupacion[$i] = mb_ereg_replace("[/]","-",$txtValor);
        }
        $this->arrPlantilla[2]['OCUPACIÓN'] = $arrOcupacion;
        $this->arrPlantilla[2]['CORREO ELECTRÓNICO'] = null;
        $this->arrPlantilla[2]['DIRECCIÓN'] = null;
        $this->arrPlantilla[2]['LOCALIDAD'] = obtenerDatosTabla("t_frm_localidad",array("seqLocalidad","txtLocalidad"),"seqLocalidad");
        $arrBarrios = obtenerDatosTabla("t_frm_barrio",array("seqBarrio","txtBarrio"),"seqBarrio","","txtBarrio");
        $this->arrPlantilla[2]['BARRIO'] = array();
        foreach($arrBarrios as $txtBarrio){
            $txtBarrio = mb_strtoupper(trim($txtBarrio));
            if(! in_array($txtBarrio,$this->arrPlantilla[2]['BARRIO'])){
                $this->arrPlantilla[2]['BARRIO'][] = $txtBarrio;
            }
        }
        $this->arrPlantilla[2]['CIUDAD'] = obtenerDatosTabla("v_frm_ciudad",array("seqCiudad","txtCiudad"),"seqCiudad","","txtCiudad");
        $this->arrPlantilla[2]['TELEFONOS1'] = null;
        $this->arrPlantilla[2]['TELEFONO2'] = null;
        $this->arrPlantilla[2]['CELULAR'] = null;
        $this->arrPlantilla[2]['VIVIENDA ACTUAL'] = obtenerDatosTabla("t_frm_vivienda",array("seqVivienda","txtVivienda"),"seqVivienda");
        $this->arrPlantilla[2]['VAL. ARRIENDO'] = null;
        $this->arrPlantilla[2]['HOGARES EN VIVIENDA'] = null;
        $this->arrPlantilla[2]['DORMITORIOS QUE EMPLEA EL HOGAR'] = null;
        $this->arrPlantilla[2]['ENCUESTA SISBEN'] = obtenerDatosTabla("t_frm_sisben",array("seqSisben","txtSisben"),"seqSisben","bolActivo = 1");
        $this->arrPlantilla[2]['INGRESOS'] = null;
        $this->arrPlantilla[2]['VALOR AHORRO'] = null;
        $this->arrPlantilla[2]['ENTIDAD AHORRO'] = obtenerDatosTabla("t_frm_banco",array("seqBanco","txtBanco"),"seqBanco");
        $this->arrPlantilla[2]['VALOR CREDITO'] = null;
        $this->arrPlantilla[2]['ENTIDAD CRÉDITO'] = obtenerDatosTabla("t_frm_banco",array("seqBanco","txtBanco"),"seqBanco");
        $this->arrPlantilla[2]['VALOR SUBSIDIO NACIONAL'] = null;
        $this->arrPlantilla[2]['SOPORTE DEL SFV'] = null;
        $this->arrPlantilla[2]['RANGO DE INGRESOS'] = $this->arrRangoIngresos[2];
        $this->arrPlantilla[2]['PROYECTO'] = null;
        $this->arrPlantilla[2]['VALOR DONACIÓN / RECONOCIMIENTO ECONÓMICO'] = null;
        $this->arrPlantilla[2]['ENTIDAD DE DONACIÓN / RECONOCIMIENTO'] = obtenerDatosTabla("t_frm_empresa_donante",array("seqEmpresaDonante","txtEmpresaDonante"),"seqEmpresaDonante");
        $this->arrPlantilla[2]['SOPORTE DONACIÓN'] = null;
        $this->arrPlantilla[2]['LINEA VALIDADA'] = $arrSiYNo;

        $this->arrPlantilla[3] = $this->arrPlantilla[2];

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
     * @param int $seqTipo
     * @version 1.0 Jul 2018
     * @return void
     */

    public function validarTitulos($seqTipo){

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
            $txtTitulo = str_replace(" " , "#" , utf8_encode( fgets( $aptArchivo ) ) );
            $arrTitulos = preg_split("/[\s|]/",$txtTitulo);
            foreach($arrTitulos as $i => $txtTitulo){
                $txtTitulo = trim(str_replace("#" , " " , $txtTitulo));
                if($txtTitulo != ""){
                    $arrTitulos[$i] = $txtTitulo;
                }else{
                    unset($arrTitulos[$i]);
                }
            }
            fclose($aptArchivo);
            foreach($this->arrFormato[$seqTipo] as $numColumna => $txtTitulo){
                if(trim(mb_strtolower($arrTitulos[$numColumna])) != trim(mb_strtolower($txtTitulo))){
                    $this->arrErrores[] = "La columna $txtTitulo no se encuentra o no está en el lugar correcto";
                }
            }
        }

    }

    /**
     * CREA EL CARGUE Y COPIA EL ARCHIVO AL SERVIDOR
     * @author Bernardo Zerda
     * @param int $seqTipo
     * @version 1.0 Jul 2018
     * @return void
     */

    public function crearCargue($seqTipo){
        global $aptBd, $arrConfiguracion, $txtPrefijoRuta;

        $txtCarpeta = $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . $this->txtCarpeta;
        $txtFisico = time();

        // crea la carpeta si no existe
        if(! is_dir($txtCarpeta )){
            if(! mkdir($txtCarpeta) ){
                $this->arrErrores[] = "No se pudo crear la carpeta contenedora de los archivos";
            }
        }

        // copia el archivo al servidor
        if(empty($this->arrErrores)){
            if(! copy($_FILES['archivo']['tmp_name'],$txtCarpeta . "/" . $txtFisico)){
                $this->arrErrores[] = "No se pudo copiar el archivo a la carpeta destino";
            }
        }

        // crea el registro en la base de datos
        if(empty($this->arrErrores)){
            try {
                $aptBd->BeginTrans();
                $sql = "
                    insert into t_fnv_cargue (
                        seqTipo,
                        fchCargue, 
                        txtArchivo, 
                        txtFisico, 
                        fchInicio, 
                        fchFinal, 
                        numProgreso, 
                        seqEstado, 
                        seqUsuario
                    ) values (
                        $seqTipo,
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
            select seqCargue, seqTipo
            from t_fnv_cargue
            where seqEstado = 1
        ";
        $objRes = $aptBd->execute($sql);
        return $objRes->fields;
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

    public function cargarArchivo($seqTipo, $seqCargue){
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

            // si el arcivo existe lo procesa
            $arrArchivo = array();
            $txtArchivo = $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . $this->txtCarpeta . "/" .$txtFisico;
            if(file_exists($txtArchivo)){
                try {
                    foreach (file($txtArchivo) as $numLinea => $txtLinea) {
                        if (trim($txtLinea) != "") {
                            $txtLinea = str_replace(" " , "~" , utf8_encode( $txtLinea ) );
                            $arrArchivo[$numLinea] = preg_split("/[\s|]/",$txtLinea);
                            $arrArchivo[$numLinea] = str_replace("~"," ",$arrArchivo[$numLinea]);
                            foreach ($arrArchivo[$numLinea] as $numColumna => $txtCelda) {
                                if(isset($this->arrFormato[$seqTipo][$numColumna])) {
                                    $arrArchivo[$numLinea][$numColumna] = $txtCelda;
                                }else{
                                    unset($arrArchivo[$numLinea][$numColumna]);
                                }
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

    public function limpiezaArchivo($seqTipo, $arrArchivo){
        unset($arrArchivo[0]);
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $bolBorrar = false;

            // para las lineas que no se deben tener en cuenta en MCY
            if($seqTipo == 1) {

                // estados habilitados definidos
                if (!in_array(trim(mb_strtolower($arrLinea[10])), $this->arrEstados)) {
                    $bolBorrar = true;
                }

                // debe pertenecer a bogota por registro
                if (trim(mb_strtolower($arrLinea[4])) != "bogota" or strpos(trim(mb_strtolower($arrLinea[3])), "bogota") === false) {
                    $bolBorrar = true;
                }
            }

            // en caso de cumplirse la regla elimina el registro
            if ($bolBorrar == true) {
                unset($arrArchivo[$numLinea]);
            }
        }
        return $arrArchivo;
    }

    /**
     * ARMA LOS HOGARES QUE SE DEBEN TRABAJAR
     * @author Bernardo Zerda
     * @version 1.0 Jul 2018
     * @param int 4seqTipo
     * @param int $seqTipo
     * @param array $arrArchivo
     * @return void
     */

    public function hogares($seqTipo, $arrArchivo){
        global $arrConfiguracion;
        if(! empty($arrArchivo)){
            $arrHogarVictima = array();
            foreach($arrArchivo as $numLinea => $arrLinea){

                // validacion de las lineas de MCY
                if($seqTipo == 1){

                    $numDocumento = doubleval($arrLinea[16]);

                    // VARIABLES DEL HOGAR
                    $numHogar = $arrLinea[0];
                    $txtRangoIngresos = $this->ingresos($seqTipo, $arrLinea[1],$numLinea,$numDocumento);
                    $seqPlanGobierno = 3;
                    $seqModalidad = $this->modalidad($seqTipo, $arrLinea[25],$numLinea);
                    $seqTipoEsquema = $this->esquema($seqTipo, $txtRangoIngresos);
                    $seqSolucion = $this->solucion($seqTipo, $seqModalidad, $arrLinea[24],$numLinea);
                    $valAspiraSubsidio = $this->valorSubsidio($seqTipo,$seqTipoEsquema);
                    $seqLocalidad = $this->localidad($seqTipo,null,$numLinea);
                    $seqBarrio = $this->barrio($seqTipo,null,null,$numLinea);
                    $seqCiudad = $this->ciudad($seqTipo,null,null,$numLinea);
                    $txtDireccion = trim($arrLinea[14]);
                    $numTelefono1 = trim($arrLinea[12]);
                    $numTelefono2 = null;
                    $numCelular = trim($arrLinea[11]);
                    $txtCorreo = $arrLinea[13];
                    $numHabitaciones = null;
                    $numHacinamiento = null;
                    $seqSisben = $this->sisben($seqTipo,null,$numLinea);
                    $seqVivienda = $this->vivienda($seqTipo,null,null,$numLinea);
                    $valArriendo = null;
                    $txtDireccionSolucion = trim(mb_strtoupper($arrLinea[23]));
                    $valAhorro1 = null;
                    $seqBancoAhorro1 = $this->banco($seqTipo,null,null,$numLinea,37);
                    $valAhorro2 = null;
                    $seqBancoAhorro2 = 1;
                    $valCredito = null;
                    $seqBancoCredito = $this->banco($seqTipo,null,null,$numLinea,39);
                    $seqEntidadSubsidio = $this->subsidio($seqTipo,null,null,$seqTipoEsquema,$numLinea);
                    $valSNal = $arrConfiguracion['constantes']['salarioMinimo'] * 30;
                    $fchResolucion = $this->fechas($seqTipo,$arrLinea[7],$numLinea);
                    $txtSoporteSNal = ($fchResolucion != null)? "Res. " . $arrLinea[8] . " de " . $fchResolucion->format("Y") : null;
                    $seqEmpresaDonante = $this->donacion($seqTipo,null,null, null, $numLinea);
                    $valDonacion = null;
                    $txtSoporteDonacion = null;

                    // VARIABLES DEL CIUDADANO
                    $seqTipoDocumento = $this->tipoDocumento($seqTipo, $arrLinea[15],$numLinea);
                    $seqParentesco = $this->parentesco($seqTipo,null,$numLinea);
                    $txtNombre1 = $this->limpiezaNombres($arrLinea[17]);
                    $txtNombre2 = null;
                    $txtApellido1 = $this->limpiezaNombres($arrLinea[18]);
                    $txtApellido2 = null;
                    $fchNacimiento = $this->fechas($seqTipo,null,$numLinea);
                    $seqSexo = $this->deducirSexo($seqTipo,$txtNombre1,$numLinea);
                    $seqEstadoCivil = $this->estadoCivil($seqTipo, null,$numLinea);
                    $seqNivelEducativo = $this->nivelEducativo($seqTipo,null,null,$numLinea);
                    $numAniosAprobados = 0;
                    $bolLgtbi = 0;
                    $seqGrupoLgtbi = $this->lgtbi($seqTipo,null,null,$numLinea);
                    $seqEtnia = $this->etnia($seqTipo,null,$numLinea);
                    $arrCondicionEspecial = $this->condicionEspecial($seqTipo,null,null,null,$numLinea);
                    $seqOcupacion = $this->ocupacion($seqTipo,null,$numLinea);
                    $seqSalud = $this->salud($seqTipo,null,$numLinea);
                    $seqTipoVictima = $this->tipoVictima($seqTipo,null,$numLinea);
                    $valIngresos = trim($arrLinea[35]);

                }else{

                    $numDocumento = doubleval($arrLinea[1]);

                    $this->lineaValidada($seqTipo,$arrLinea[47],$numLinea);

                    // VARIABLES DEL HOGAR
                    $numHogar = $arrLinea[0];
                    $txtRangoIngresos = $this->ingresos($seqTipo, $arrLinea[42],$numLinea,$numDocumento);
                    $seqPlanGobierno = ($seqTipo == 2)? 3 : 2;
                    $seqModalidad = $this->modalidad($seqTipo,null,$numLinea);
                    $seqTipoEsquema = $this->esquema($seqTipo, $arrLinea[42]);
                    $seqSolucion = $this->solucion($seqTipo, null, null,$numLinea);
                    $valAspiraSubsidio = $this->valorSubsidio($seqTipo,$seqTipoEsquema);
                    $seqLocalidad = $this->localidad($seqTipo,$arrLinea[24],$numLinea);
                    $seqBarrio = $this->barrio($seqTipo,$seqLocalidad,$arrLinea[25],$numLinea);
                    $seqCiudad = $this->ciudad($seqTipo,$seqLocalidad,$arrLinea[26],$numLinea);
                    $txtDireccion = trim($arrLinea[23]);
                    $numTelefono1 = trim($arrLinea[27]);
                    $numTelefono2 = trim($arrLinea[28]);
                    $numCelular = trim($arrLinea[29]);
                    $txtCorreo = trim($arrLinea[22]);
                    $numHabitaciones = trim($arrLinea[32]);
                    $numHacinamiento = trim($arrLinea[33]);
                    $seqSisben = $this->sisben($seqTipo,$arrLinea[34],$numLinea);
                    $seqVivienda = $this->vivienda($seqTipo,$arrLinea[30],$arrLinea[31],$numLinea);
                    $valArriendo = trim($arrLinea[31]);
                    $txtDireccionSolucion = trim($arrLinea[43]);
                    $valAhorro1 = trim($arrLinea[36]);
                    $seqBancoAhorro1 = $this->banco($seqTipo,$arrLinea[37],$valAhorro1,$numLinea,36);
                    $valAhorro2 = null;
                    $seqBancoAhorro2 = 1;
                    $valCredito = trim($arrLinea[38]);
                    $seqBancoCredito = $this->banco($seqTipo,$arrLinea[39],$valCredito,$numLinea,39);
                    $seqEntidadSubsidio = $this->subsidio($seqTipo,trim($arrLinea[40]),trim($arrLinea[41]),$seqTipoEsquema,$numLinea);
                    $valSNal = trim($arrLinea[40]);
                    $txtSoporteSNal = trim($arrLinea[41]);
                    $seqEmpresaDonante = $this->donacion($seqTipo,$arrLinea[45],trim($arrLinea[44]),trim($arrLinea[46]),$numLinea);
                    $valDonacion = trim($arrLinea[44]);
                    $txtSoporteDonacion = trim($arrLinea[46]);

                    // VARIABLES DEL CIUDADANO
                    $seqTipoDocumento = $this->tipoDocumento($seqTipo, $arrLinea[2],$numLinea);
                    $seqParentesco = $this->parentesco($seqTipo,$arrLinea[10],$numLinea);
                    $txtNombre1   = $this->limpiezaNombres($arrLinea[3]);
                    $txtNombre2   = $this->limpiezaNombres($arrLinea[4]);
                    $txtApellido1 = $this->limpiezaNombres($arrLinea[5]);
                    $txtApellido2 = $this->limpiezaNombres($arrLinea[6]);
                    $fchNacimiento = $this->fechas($seqTipo,$arrLinea[9],$numLinea);
                    $seqSexo = $this->deducirSexo($seqTipo, $arrLinea[7],$numLinea);
                    $seqEstadoCivil = $this->estadoCivil($seqTipo, $arrLinea[8],$numLinea);
                    $seqNivelEducativo = $this->nivelEducativo($seqTipo,$arrLinea[16],$arrLinea[17],$numLinea);
                    $numAniosAprobados = trim($arrLinea[17]);
                    $bolLgtbi = trim($arrLinea[19]);
                    $seqGrupoLgtbi = $this->lgtbi($seqTipo,$arrLinea[19],$arrLinea[20],$numLinea);
                    $seqEtnia = $this->etnia($seqTipo,$arrLinea[11],$numLinea);
                    $arrCondicionEspecial = $this->condicionEspecial($seqTipo,$arrLinea[12],$arrLinea[13],$arrLinea[14],$numLinea);
                    $seqOcupacion = $this->ocupacion($seqTipo,$arrLinea[21],$numLinea);
                    $seqSalud = $this->salud($seqTipo,$arrLinea[15],$numLinea);
                    $seqTipoVictima = $this->tipoVictima($seqTipo,$arrLinea[18],$numLinea);
                    $valIngresos = trim($arrLinea[35]);

                }

                // armando el hogar con las variables del archivo
                $this->arrHogares[$numHogar]['txtRangoIngresos'] = $txtRangoIngresos;
                $this->arrHogares[$numHogar]['seqPlanGobierno'] = $seqPlanGobierno;
                $this->arrHogares[$numHogar]['seqModalidad'] = $seqModalidad;
                $this->arrHogares[$numHogar]['seqTipoEsquema'] = $seqTipoEsquema;
                $this->arrHogares[$numHogar]['seqSolucion'] = $seqSolucion;
                $this->arrHogares[$numHogar]['valAspiraSubsidio'] = $valAspiraSubsidio;
                $this->arrHogares[$numHogar]['seqLocalidad'] = $seqLocalidad;
                $this->arrHogares[$numHogar]['seqBarrio'] = $seqBarrio;
                $this->arrHogares[$numHogar]['seqCiudad'] = $seqCiudad;
                $this->arrHogares[$numHogar]['txtDireccion'] = $txtDireccion;
                $this->arrHogares[$numHogar]['numTelefono1'] = $numTelefono1;
                $this->arrHogares[$numHogar]['numTelefono2'] = $numTelefono2;
                $this->arrHogares[$numHogar]['numCelular'] = $numCelular;
                $this->arrHogares[$numHogar]['txtCorreo'] = $txtCorreo;
                $this->arrHogares[$numHogar]['numHabitaciones'] = $numHabitaciones;
                $this->arrHogares[$numHogar]['numHacinamiento'] = $numHacinamiento;
                $this->arrHogares[$numHogar]['seqSisben'] = $seqSisben;
                $this->arrHogares[$numHogar]['seqVivienda'] = $seqVivienda;
                $this->arrHogares[$numHogar]['valArriendo'] = $valArriendo;
                $this->arrHogares[$numHogar]['txtDireccionSolucion'] = $txtDireccionSolucion;
                $this->arrHogares[$numHogar]['valSaldoCuentaAhorro'] = $valAhorro1;
                $this->arrHogares[$numHogar]['seqBancoCuentaAhorro'] = $seqBancoAhorro1;
                $this->arrHogares[$numHogar]['valSaldoCuentaAhorro2'] = $valAhorro2;
                $this->arrHogares[$numHogar]['seqBancoCuentaAhorro2'] = $seqBancoAhorro2;
                $this->arrHogares[$numHogar]['valCredito'] = $valCredito;
                $this->arrHogares[$numHogar]['seqBancoCredito'] = $seqBancoCredito;
                $this->arrHogares[$numHogar]['seqEntidadSubsidio'] = $seqEntidadSubsidio;
                $this->arrHogares[$numHogar]['valSubsidioNacional'] = $valSNal;
                $this->arrHogares[$numHogar]['txtSoporteSubsidioNacional'] = $txtSoporteSNal;
                $this->arrHogares[$numHogar]['seqEmpresaDonante'] = $seqEmpresaDonante;
                $this->arrHogares[$numHogar]['valDonacion'] = $valDonacion;
                $this->arrHogares[$numHogar]['txtSoporteDonacion'] = $txtSoporteDonacion;

                if( ! isset($this->arrHogares[$numHogar]['bolDesplazado']) ){
                    $this->arrHogares[$numHogar]['bolDesplazado'] = 0;
                }

                $arrHogarVictima[$numHogar][] = $seqTipoVictima;
                if(in_array(2,$arrHogarVictima[$numHogar])){
                    $this->arrHogares[$numHogar]['bolDesplazado'] = 1;
                }

                if(! isset($this->arrHogares[$numHogar]['valIngresoHogar'])){
                    $this->arrHogares[$numHogar]['valIngresosHogar'] = $valIngresos;
                }else{
                    $this->arrHogares[$numHogar]['valIngresosHogar'] += $valIngresos;
                }

                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqParentesco'] = $seqParentesco;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['txtNombre1'] = $txtNombre1;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['txtNombre2'] = $txtNombre2;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['txtApellido1'] = $txtApellido1;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['txtApellido2'] = $txtApellido2;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['fchNacimiento'] = $fchNacimiento;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqSexo'] = $seqSexo;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqEstadoCivil'] = $seqEstadoCivil;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqNivelEducativo'] = $seqNivelEducativo;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['numAnosAprobados'] = $numAniosAprobados;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['bolLgtb'] = $bolLgtbi;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqGrupoLgtbi'] = $seqGrupoLgtbi;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqEtnia'] = $seqEtnia;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqCondicionEspecial1'] = $arrCondicionEspecial[1];
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqCondicionEspecial2'] = $arrCondicionEspecial[2];
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqCondicionEspecial3'] = $arrCondicionEspecial[3];
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqOcupacion'] = $seqOcupacion;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqSalud'] = $seqSalud;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['seqTipoVictima'] = $seqTipoVictima;
                $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['valIngresos'] = $valIngresos;

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

                    $txtNombreArchivo  = trim($arrNombre['txtNombre1']);
                    $txtNombreArchivo .= (trim($arrNombre['txtNombre2']) == "")? ""   : " " . trim($arrNombre['txtNombre2'])   ;
                    $txtNombreArchivo .= (trim($arrNombre['txtApellido1']) == "")? "" : " " . trim($arrNombre['txtApellido1']) ;
                    $txtNombreArchivo .= (trim($arrNombre['txtApellido2']) == "")? "" : " " . trim($arrNombre['txtApellido2']) ;
                    $txtNombreArchivo = trim( mb_strtolower( $txtNombreArchivo ) );

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

            $txtErrores = (empty($this->arrErrores))? "null" : "'" . json_encode($this->arrErrores, JSON_UNESCAPED_UNICODE) . "'";

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

                $arrCampos  = array("seqCargue","seqEstadoHogar","numHogar");
                $arrValores = array($seqCargue,1,$numHogar);
                foreach($arrHogar as $txtClave => $txtValor){
                    if(! is_array($txtValor)){
                        $arrCampos[] = $txtClave;
                        $arrValores[] = ($txtValor === null)? "null" : "'$txtValor'";
                    }

                }
                $sql = "insert into t_fnv_hogar (" . implode("," , $arrCampos) . ") values (" . implode(",",$arrValores) . ")";
                $aptBd->execute($sql);
                $seqHogar = $aptBd->Insert_ID();

                foreach($arrHogar['hogar'] as $seqTipoDocumento => $arrCiudadanos){
                    foreach($arrCiudadanos as $numDocumento => $arrCiudadano){

                        $arrCampos = array("seqHogar","seqTipoDocumento","numDocumento","bolPrincipal");
                        $arrValores = array($seqHogar,$seqTipoDocumento,$numDocumento,0);
                        foreach($arrCiudadano as $txtClave => $txtValor){

                            switch(true){
                                case $txtValor === null:
                                    $arrCampos[] = $txtClave;
                                    $arrValores[] = "null";
                                    break;
                                case is_object($txtValor):
                                    $arrCampos[] = $txtClave;
                                    $arrValores[] = "'" . $txtValor->format("Y-m-d") . "'";
                                    break;
                                case is_array($txtValor):
                                    $arrCampos[] = "txtCoincidencias";
                                    $arrValores[] = "'" . json_encode($arrCiudadano['coincidencias'],JSON_UNESCAPED_UNICODE) . "'";
                                    break;
                                default:
                                    $arrCampos[] = $txtClave;
                                    $arrValores[] = "'" . $txtValor . "'";
                            }

                        }

                        $sql = "insert into t_fnv_ciudadano (" . implode("," , $arrCampos) . ") values (" . implode(",",$arrValores) . ")";
                        $aptBd->execute($sql);

                    }
                }


            }
            $aptBd->CommitTrans();
        } catch (Exception $objError){
            $this->arrErrores[] = "Hubo un error al almacenar las novedades";
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
            $this->finalizarCargue($seqCargue,3);
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
                tip.txtTipo,
                car.fchCargue, 
                car.txtArchivo, 
                car.seqEstado,
                est.txtEstado,
                concat(usu.txtNombre,' ',usu.txtApellido) as txtUsuario
            from t_fnv_cargue car
            inner join t_fnv_estado est on car.seqEstado = est.seqEstado
            inner join t_cor_usuario usu on car.seqUsuario = usu.seqUsuario
            inner join t_fnv_tipo tip on car.seqTipo = tip.seqTipo
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
                car.seqTipo,
                tip.txtTipo,
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
            inner join t_fnv_tipo tip on car.seqTipo = tip.seqTipo
            where car.seqCargue = $seqCargue            
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){
            $this->seqCargue = $objRes->fields['seqCargue'];
            $this->seqTipo = $objRes->fields['seqTipo'];
            $this->txtTipo = $objRes->fields['txtTipo'];
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
                hog.seqEstadoHogar,
                eho.txtEstadoHogar,
                hog.seqCargue,
                hog.numHogar,
                hog.seqFormulario,
                hog.txtRangoIngresos,
                hog.seqPlanGobierno,
                pgo.txtPlanGobierno,
                hog.seqModalidad,
                moa.txtModalidad,
                hog.seqTipoEsquema,
                esq.txtTipoEsquema,
                hog.seqSolucion,
                sol.txtSolucion, 
                sol.txtDescripcion,
                hog.bolDesplazado,
                hog.valAspiraSubsidio,
                hog.seqLocalidad,
                loc.txtLocalidad,
                hog.seqBarrio,
                bar.txtBarrio,
                hog.seqCiudad,
                ciu.txtCiudad,
                hog.txtDireccion,
                hog.numTelefono1,
                hog.numTelefono2,
                hog.numCelular,
                hog.txtCorreo,
                hog.numHabitaciones,
                hog.numHacinamiento,
                hog.seqSisben,
                sis.txtSisben,
                hog.seqVivienda,
                viv.txtVivienda,
                hog.valArriendo,
                hog.txtDireccionSolucion,
                hog.valSaldoCuentaAhorro,
                hog.seqBancoCuentaAhorro,
                aho.txtBanco as txtBancoCuentaAhorro,
                hog.valSaldoCuentaAhorro2,
                hog.seqBancoCuentaAhorro2,
                aho2.txtBanco as txtBancoCuentaAhorro2,
                hog.valCredito,
                hog.seqBancoCredito,
                cre.txtBanco as txtBancoCredito,
                hog.seqEntidadSubsidio,
                esu.txtEntidadSubsidio,
                hog.valSubsidioNacional,
                hog.txtSoporteSubsidioNacional,
                hog.seqEmpresaDonante,
                edo.txtEmpresaDonante,
                hog.valDonacion,
                hog.txtSoporteDonacion,
                hog.valIngresosHogar,
                hog.txtErrores,
                hog.txtObservaciones
            from t_fnv_hogar hog
            inner join t_fnv_estado_hogar eho on hog.seqEstadoHogar = eho.seqEstadoHogar
            inner join t_frm_plan_gobierno pgo on hog.seqPlanGobierno = pgo.seqPlanGobierno
            inner join t_frm_modalidad moa on hog.seqModalidad = moa.seqModalidad
            inner join t_pry_tipo_esquema esq on hog.seqTipoEsquema = esq.seqTipoEsquema
            inner join t_frm_solucion sol on hog.seqSolucion = sol.seqSolucion
            inner join t_frm_localidad loc on hog.seqLocalidad = loc.seqLocalidad
            inner join t_frm_barrio bar on hog.seqBarrio = bar.seqBarrio
            inner join v_frm_ciudad ciu on hog.seqCiudad = ciu.seqCiudad
            inner join t_frm_sisben sis on hog.seqSisben = sis.seqSisben
            inner join t_frm_vivienda viv on hog.seqVivienda = viv.seqVivienda
            inner join t_frm_banco aho on hog.seqBancoCuentaAhorro = aho.seqBanco
            inner join t_frm_banco aho2 on hog.seqBancoCuentaAhorro2 = aho2.seqBanco
            inner join t_frm_banco cre on hog.seqBancoCredito = cre.seqBanco
            inner join t_frm_entidad_subsidio esu on hog.seqEntidadSubsidio = esu.seqEntidadSubsidio
            inner join t_frm_empresa_donante edo on hog.seqEmpresaDonante = edo.seqEmpresaDonante
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
                    ciu.seqHogar,
                    ciu.seqTipoDocumento,
                    tdo.txtTipoDocumento,
                    ciu.numDocumento,
                    ciu.txtNombre1,
                    ciu.txtNombre2,
                    ciu.txtApellido1,
                    ciu.txtApellido2,
                    ciu.fchNacimiento,
                    ciu.seqSexo,
                    sex.txtSexo,
                    ciu.seqEstadoCivil,
                    eci.txtEstadoCivil,
                    ciu.seqNivelEducativo,
                    ned.txtNivelEducativo,
                    ciu.numAnosAprobados,
                    ciu.bolLgtb,
                    ciu.seqGrupoLgtbi,
                    glg.txtGrupoLgtbi,
                    ciu.seqEtnia,
                    etn.txtEtnia,
                    ciu.seqCondicionEspecial1,
                    ces1.txtCondicionEspecial as txtCondicionEspecial1,
                    ciu.seqCondicionEspecial2,
                    ces2.txtCondicionEspecial as txtCondicionEspecial2,
                    ciu.seqCondicionEspecial3,
                    ces3.txtCondicionEspecial as txtCondicionEspecial3,
                    ciu.seqOcupacion,
                    ocu.txtOcupacion,
                    ciu.seqSalud,
                    sal.txtSalud,
                    ciu.seqTipoVictima,
                    tvi.txtTipoVictima,
                    ciu.txtCoincidencias,
                    ciu.seqParentesco,
                    par.txtParentesco,
                    ciu.valIngresos,
                    ciu.seqCiudadanoCoincidencia,
                    ciu.bolPrincipal
                from t_fnv_ciudadano ciu
                inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
                inner join t_ciu_sexo sex on ciu.seqSexo = sex.seqSexo
                inner join t_ciu_estado_civil eci on ciu.seqEstadoCivil = eci.seqEstadoCivil
                inner join t_ciu_nivel_educativo ned on ciu.seqNivelEducativo = ned.seqNivelEducativo
                inner join t_frm_grupo_lgtbi glg on ciu.seqGrupoLgtbi = glg.seqGrupoLgtbi
                inner join t_ciu_etnia etn on ciu.seqEtnia = etn.seqEtnia
                inner join t_ciu_condicion_especial ces1 on ciu.seqCondicionEspecial1 = ces1.seqCondicionEspecial
                inner join t_ciu_condicion_especial ces2 on ciu.seqCondicionEspecial2 = ces2.seqCondicionEspecial
                inner join t_ciu_condicion_especial ces3 on ciu.seqCondicionEspecial3 = ces3.seqCondicionEspecial
                inner join t_ciu_ocupacion ocu on ciu.seqOcupacion = ocu.seqOcupacion
                inner join t_ciu_salud sal on ciu.seqSalud = sal.seqSalud
                inner join t_frm_tipovictima tvi on ciu.seqTipoVictima = tvi.seqTipoVictima
                inner join t_ciu_parentesco par on ciu.seqParentesco = par.seqParentesco
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
                if($numDocumentoCoincidencia == $numDocumento and $seqFormulario != 0){
                    $this->arrNovedades[$numDocumentoCoincidencia] = "Marcado para postulante principal";
                }else{
                    if(isset($arrCiudadano['coincidencias']['N/A'])){
                        $claCiudadano = new Ciudadano();
                        $seqFormularioCoincidencia = $claCiudadano->formularioVinculado($arrCiudadano['numDocumento'], false, false);
                        if($seqFormularioCoincidencia != $seqFormulario){
                            $this->arrErrores['ciudadano'][$numDocumentoCoincidencia] = "No se puede fusionar, pertenece al hogar <a href='#' class='text-danger' onclick='verHogar($seqFormularioCoincidencia)'>$seqFormularioCoincidencia</a>";
                        }else{
                            $this->arrNovedades[$numDocumentoCoincidencia] = "Ya pertenece al hogar seleccionado";
                        }
                    }else{
                        if($numDocumento == 0 and $arrCiudadano['bolPrincipal'] == 1){
                            $this->arrNovedades[$numDocumentoCoincidencia] = "Marcado para postulante principal";
                        }else{
                            $this->arrNovedades[$numDocumentoCoincidencia] = "Se unirá al formulario seleccionado";
                        }
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
              and seqFormulario <> 0
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
                    bolPrincipal = 0,
                    seqCiudadanoCoincidencia = null
                where seqHogar = $seqHogar 
            ";
            $aptBd->execute($sql);

            if($arrPost['numDocumento'] == 0){
                $numHogar = $arrPost['numHogar'];
                $arrCiudadano = array_shift($this->arrHogares[$numHogar]['ciudadanos']);
                $arrPost['numDocumento'] = $arrCiudadano['numDocumento'];
            }

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

    private function ingresos($seqTipo, $txtIngresos,$numLinea,$numDocumento){
        $txtRangoIngresos = "";
        $seqColumna = ($seqTipo == 1)? 1 : 42;
        if(! in_array(trim(mb_strtoupper($txtIngresos)), $this->arrRangoIngresos[$seqTipo])){
            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . " ($numDocumento): El valor de la columna " . $this->arrFormato[$seqTipo][$seqColumna] . " es desconocido";
        }else{
            $txtRangoIngresos = trim(mb_strtoupper($txtIngresos));
        }
        return $txtRangoIngresos;
    }

    private function tipoDocumento($seqTipo, $txtTipoDocumento,$numLinea){
        if($seqTipo == 1) {
            switch (trim(mb_strtolower($txtTipoDocumento))) {
                case "c.c.":
                    $seqTipoDocumento = 1;
                    break;
                case "c.e.":
                    $seqTipoDocumento = 2;
                    break;
                default:
                    $seqTipoDocumento = 0;
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][15] . " es desconocido";
                    break;
            }
        }else{
            $arrTipoDocumento = obtenerDatosTabla(
                "t_ciu_tipo_documento",
                array("seqTipoDocumento","txtTipoDocumento"),
                "txtTipoDocumento",
                "lower(txtTipoDocumento) = '" . mb_strtolower($txtTipoDocumento) ."'"
            );
            if(! empty($arrTipoDocumento)) {
                $seqTipoDocumento = $arrTipoDocumento[$txtTipoDocumento];
            }else{
                $seqTipoDocumento = 0;
            }
            if(intval($seqTipoDocumento) == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][2] . " es desconocido";
            }

        }
        return $seqTipoDocumento;
    }

    /**
     * OBTIENE EL TIPO DE SOLUCION EQUIVALENTE EN PIVE
     * @param $seqTipo
     * @param $txtSolucion
     * @param $numLinea
     * @return string
     */
    private function solucion($seqTipo, $seqModalidad, $txtSolucion,$numLinea){
        $seqSolucion = "";
        if($seqTipo == 1){
            if(! in_array(trim(mb_strtoupper($txtSolucion)), $this->arrSoluciones[$seqModalidad])){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][24] . " es desconocido";
            }else{
                $arrSolucion = array_keys($this->arrSoluciones[$seqModalidad],$txtSolucion);
                $seqSolucion = $arrSolucion[0];
            }
        }elseif($seqTipo == 2){
            $seqSolucion = 19;
        }else{
            $seqSolucion = 13;
        }
        return $seqSolucion;
    }

    /**
     * SELECCION DE EQUIVALENCIA DE MODALIDAD
     * @param int $seqTipo
     * @param string $txtModalidad
     * @param int $numLinea
     * @return int $seqModalidad
     */
    private function modalidad($seqTipo,$txtModalidad,$numLinea){
        $seqModalidad = "";
        if($seqTipo == 1){
            if(! in_array(trim(mb_strtoupper($txtModalidad)), $this->arrModalidad)){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][25] . " es desconocido";
            }else{
                $arrModalidad = array_keys($this->arrModalidad,$txtModalidad);
                $seqModalidad = $arrModalidad[0];
            }
        }elseif($seqTipo == 2){
            $seqModalidad = 12;
        }else{
            $seqModalidad = 6;
        }
        return $seqModalidad;
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

                                    $objCiudadano->seqParentesco = ($this->seqTipo == 1)? 1 : $arrCiudadano['seqParentesco'];
                                    $objCiudadano->seqTipoDocumento = $arrCiudadano['seqTipoDocumento'];
                                    $objCiudadano->numDocumento     = $arrCiudadano['numDocumento'];
                                    $objCiudadano->txtNombre1       = $arrCiudadano['txtNombre1'];
                                    $objCiudadano->txtNombre2       = $arrCiudadano['txtNombre2'];
                                    $objCiudadano->txtApellido1     = $arrCiudadano['txtApellido1'];
                                    $objCiudadano->txtApellido2     = $arrCiudadano['txtApellido2'];
                                    $objCiudadano->valIngresos      = $arrCiudadano['valIngresos'];

                                    $objCiudadano = $this->modificarCiudadano($objCiudadano, $arrCiudadano);

                                    $numDocumentoSeguimiento = $arrCiudadano['numDocumento'];
                                    $txtNombreSeguimiento    = $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " . $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'];

                                    $claFormularioModificado->arrCiudadano[$seqCiudadano] = $objCiudadano;
                                    $objCiudadano->editarCiudadano($seqCiudadano);

                                    break;
                                }elseif($arrCiudadano['seqCiudadanoCoincidencia'] === null and $objCiudadano->numDocumento == $arrCiudadano['numDocumento']){

                                    $objCiudadano->seqParentesco = $arrCiudadano['seqParentesco'];
                                    $objCiudadano->txtNombre1    = $arrCiudadano['txtNombre1'];
                                    $objCiudadano->txtNombre2    = $arrCiudadano['txtNombre2'];
                                    $objCiudadano->txtApellido1  = $arrCiudadano['txtApellido1'];
                                    $objCiudadano->txtApellido2  = $arrCiudadano['txtApellido2'];
                                    $objCiudadano->valIngresos   = $arrCiudadano['valIngresos'];

                                    $objCiudadano = $this->modificarCiudadano($objCiudadano, $arrCiudadano);

                                    $claFormularioModificado->arrCiudadano[$seqCiudadano] = $objCiudadano;
                                    $objCiudadano->editarCiudadano($seqCiudadano);

                                    break;
                                }else{
                                    $objCiudadano = null;
                                }

                            }

                            if($objCiudadano === null){

                                $objCiudadano = new Ciudadano();

                                foreach ($arrCiudadano as $txtClave => $txtValor){
                                    $objCiudadano->$txtClave = $txtValor;
                                }

                                $objCiudadano->guardarCiudadano();
                                $claFormularioModificado->arrCiudadano[$objCiudadano->seqCiudadano] = $objCiudadano;
                                $objCiudadano = null;

                                foreach($objCiudadano->arrErrores as $txtError){
                                    $this->arrErrores['general'][] = $txtError;
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
                                $txtNombreSeguimiento    = $arrCiudadano['txtNombre1'] . " " . $arrCiudadano['txtNombre2'] . " " . $arrCiudadano['txtApellido1'] . " " . $arrCiudadano['txtApellido2'];
                            }

                            $claCiudadano = new Ciudadano();

                            foreach ($arrCiudadano as $txtClave => $txtValor){
                                $claCiudadano->$txtClave = $txtValor;
                            }

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
                    $claFormularioModificado = $this->modificarFormulario($claFormularioModificado, $arrHogar,$claFormularioOriginal);

                    // actualiza ingresos del hogar
                    $claFormularioModificado->valIngresoHogar = 0;
                    $claFormularioModificado->bolDesplazado = 0;
                    foreach($claFormularioModificado->arrCiudadano as $seqCiudadano => $objCiudadano){
                        $claFormularioModificado->valIngresoHogar += $objCiudadano->valIngresos;
                        if($objCiudadano->seqTipoVictima == 2){
                            $claFormularioModificado->bolDesplazado = 1;
                        }
                    }

                    // edita o crea el formulario
                    if( $arrHogar['seqFormulario'] != 0 ) {
                        $claFormularioModificado->editarFormulario($arrHogar['seqFormulario']);
                    }else{
                        $claFormularioModificado->guardarFormulario();
                        $arrHogar['seqFormulario'] = $claFormularioModificado->seqFormulario;
                    }

                    // verifica errores
                    foreach($claFormularioModificado->arrErrores as $txtError){
                        $this->arrErrores['general'][] = $txtError;
                    }

                    // relaciona los ciudadanos con el formulario
                    $claFormularioModificado->relacionarCiudadanoFormulario();
                    foreach($claFormularioModificado->arrErrores as $txtError){
                        $this->arrErrores['general'][] = $txtError;
                    }

                    // seguimiento para el hogar
                    $claSeguimiento = new Seguimiento();
                    $txtCambios = $claSeguimiento->cambiosPostulacionActo($arrHogar['seqFormulario'],$claFormularioOriginal,$claFormularioModificado);

                    switch ($this->seqTipo){
                        case 1:
                            $txtPrograma = "MI CASA YA";
                            break;
                        case 2:
                            $txtPrograma = "VIPA";
                            break;
                        case 3:
                            $txtPrograma = "";
                            break;
                        default:
                            $txtPrograma = "";
                            break;
                    }

                    $txtComentario  = "ACTUALIZACIÓN DE INFORMACIÓN EN LA CONFORMACIÓN DE HOGAR. HOGAR PERTENECIENTE AL ";
                    $txtComentario .= "GRUPO BENEFICIARIO SUBSIDIOS $txtPrograma SEGÚN RESOLUCIÓN DEL MINISTERIO DE ";
                    $txtComentario .= "VIVIENDA Y VINCULACION BENEFICIO SDHT";

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
                           '" . $txtComentario . "',
                           '" . mb_ereg_replace("'","\'",$txtCambios) . "',
                           " . $numDocumentoSeguimiento . ",
                           '" . $txtNombreSeguimiento . "',
                           " . 46 . "
                         )
                     ";
                    $aptBd->execute($sql);

                    // pone el hogar como procesado
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

            // actualiza la informacion del cargue
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

    private function deducirSexo($seqTipo, $txtDeduccion, $numLinea){
        global $aptBd;
        $seqSexo = 0;
        if($seqTipo == 1) {
            $numLargo = strlen($txtDeduccion);
            $numPosicion = (intval(strpos($txtDeduccion, " ")) == 0) ? $numLargo : intval(strpos($txtDeduccion, " "));
            $sql = "
              select 
                seqSexo, 
                count(seqCiudadano)
              from t_ciu_ciudadano
              where txtNombre1 like '%" . trim(substr($txtDeduccion, 0, $numPosicion)) . "%' 
              group by seqSexo
              order by count(seqCiudadano) desc
              limit 1
            ";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqSexo = $objRes->fields['seqSexo'];
            } else {
                $seqSexo = 2; // por defecto será mujer
            }
        }else{
            $arrSexo = obtenerDatosTabla(
                "t_ciu_sexo",
                array("seqSexo","txtSexo"),
                "txtSexo",
                "lower(txtSexo) = '" . mb_strtolower($txtDeduccion) . "'"
            );
            $seqSexo = $arrSexo[$txtDeduccion];
            if(intval($seqSexo) == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][7] . " es desconocido";
            }
        }
        return $seqSexo;
    }

    public function obtenerTipos(){
        global $aptBd;
        $sql = "
            select seqTipo, txtTipo
            from t_fnv_tipo
        ";
        $objRes = $aptBd->execute($sql);
        $arrTipo = array();
        while($objRes->fields){
            $seqTipo = $objRes->fields['seqTipo'];
            $txtTipo = $objRes->fields['txtTipo'];
            $arrTipo[$seqTipo] = $txtTipo;
            $objRes->MoveNext();
        }
        return $arrTipo;
    }

    private function estadoCivil($seqTipo,$txtEstadoCivil,$numLinea){
        if($seqTipo == 2 or $seqTipo == 3){
            $arrEstadoCivil = obtenerDatosTabla(
                "t_ciu_estado_civil",
                array("seqEstadoCivil","txtEstadoCivil"),
                "txtEstadoCivil",
                "lower(txtEstadoCivil) = '" . mb_strtolower($txtEstadoCivil) . "'"
            );
            $seqEstadoCivil = $arrEstadoCivil[$txtEstadoCivil];
            if(intval($seqEstadoCivil) == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][8] . " es desconocido";
            }
        }else{
            $seqEstadoCivil = 9; // No reporta
        }
        return $seqEstadoCivil;
    }

    private function fechas($seqTipo,$txtFecha,$numLinea){
        $fchFecha = null;
        $txtFecha = (trim($txtFecha) === "")? null : $txtFecha;
        if($txtFecha != null) {
            $arrDMY = array();
            $arrYMD = array();
            preg_match("/(\d{1,2})[\-\/](\d{1,2})[\-\/](\d{2,4})/", $txtFecha, $arrDMY);
            preg_match("/(\d{4})[\-\/](\d{1,2})[\-\/](\d{1,2})/"  , $txtFecha, $arrYMD);
            if(!empty($arrYMD)){
                $fchFecha = new DateTime($arrYMD[1] . "-" . $arrYMD[2] . "-" . $arrYMD[3]);
            }elseif(! empty($arrDMY)){
                $arrMatch[3] = ($arrDMY[3] < 100) ? $arrDMY[3] + 2000 : $arrDMY[3];
                $fchFecha = new DateTime($arrDMY[3] . "-" . $arrDMY[2] . "-" . $arrDMY[1]);
            }else{
                if($seqTipo == 2) {
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El formato de la columna " . $this->arrFormato[$seqTipo][9] . " es desconocido (d/m/Y o Y/m/d)";
                }
            }
        }
        return $fchFecha;
    }

    private function parentesco($seqTipo,$txtParentesco,$numLinea){
        $seqParentesco = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $txtParentesco = ($txtParentesco == "")? 'Desconocido' : $txtParentesco;
            $arrParentesco = obtenerDatosTabla(
                "t_ciu_parentesco",
                array("seqParentesco","txtParentesco"),
                "txtParentesco",
                "lower(txtParentesco) = '" . mb_strtolower($txtParentesco) . "'"

            );
            if(! empty($arrParentesco)){
                $seqParentesco = $arrParentesco[$txtParentesco];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][10] . " es desconocido";
            }
        }else{
            $seqParentesco = 14;
        }
        return $seqParentesco;
    }

    private function etnia($seqTipo,$txtEtnia,$numLinea){
        $seqEtnia = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrEtnia = obtenerDatosTabla(
                "t_ciu_etnia",
                array("seqEtnia","txtEtnia"),
                "txtEtnia",
                "lower(txtEtnia) = '" . mb_strtolower($txtEtnia) . "'"

            );
            if(! empty($arrEtnia)){
                $seqEtnia = $arrEtnia[$txtEtnia];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][11] . " es desconocido";
            }
        }else{
            $seqEtnia = 1;
        }
        return $seqEtnia;
    }

    private function condicionEspecial($seqTipo,$numDiscapacidad,$numMayor65,$numCabezaHogar,$numLinea){

        $arrCondicionEspecial[1] = 6;
        $arrCondicionEspecial[2] = 6;
        $arrCondicionEspecial[3] = 6;

        if($seqTipo == 2 or $seqTipo == 3){

            if($numDiscapacidad != 0 and $numDiscapacidad != 1 ){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][12] . " es desconocido";
            }else{
                $arrCondicionEspecial[1] = ($numDiscapacidad == 1)? 3 : 6;
            }

            if($numMayor65 != 0 and $numMayor65 != 1 ){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][13] . " es desconocido";
            }else{
                $arrCondicionEspecial[2] = ($numMayor65 == 1)? 2 : 6;
            }

            if($numCabezaHogar != 0 and $numCabezaHogar != 1 ){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][14] . " es desconocido";
            }else{
                $arrCondicionEspecial[3] = ($numCabezaHogar == 1)? 1 : 6;
            }

        }

        return $arrCondicionEspecial;
    }

    private function salud($seqTipo,$txtSalud,$numLinea){
        $seqSalud = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrSalud = obtenerDatosTabla(
                "t_ciu_salud",
                array("seqSalud","txtSalud"),
                "txtSalud",
                "lower(txtSalud) = '" . mb_strtolower($txtSalud) . "'"

            );
            if(! empty($arrSalud)){
                $seqSalud = $arrSalud[$txtSalud];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][15] . " es desconocido";
            }
        }else{
            $seqSalud = 0;
        }
        return $seqSalud;
    }

    private function nivelEducativo($seqTipo,$txtNivelEducativo,$numAniosAprobados,$numLinea){
        $seqNivelEducativo = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrNivelEducativo = obtenerDatosTabla(
                "t_ciu_nivel_educativo",
                array("seqNivelEducativo","txtNivelEducativo"),
                "txtNivelEducativo",
                "lower(txtNivelEducativo) = '" . mb_strtolower($txtNivelEducativo) . "'"

            );

            if(! empty($arrNivelEducativo)){
                $seqNivelEducativo = $arrNivelEducativo[$txtNivelEducativo];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][16] . " es desconocido";
            }

            switch (intval($seqNivelEducativo)){
                case 1:
                    if($numAniosAprobados != 0){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 2:
                    if( ! ($numAniosAprobados >= 1 and $numAniosAprobados <= 4) ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 3:
                    if( $numAniosAprobados != 5 ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 4:
                    if( ! ($numAniosAprobados >= 6 and $numAniosAprobados <= 10) ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 5:
                    if( $numAniosAprobados != 11 ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 6:
                    if( ! ($numAniosAprobados >= 6 and $numAniosAprobados <= 11) ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 7:
                    if( $numAniosAprobados != 11 ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 8:
                    if( $numAniosAprobados != 11 ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 9:
                    if( $numAniosAprobados != 11 ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
                case 12:
                    if( $numAniosAprobados != 11 ){
                        $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][17] . " no es valido";
                    }
                    break;
            }

        }else{
            $seqNivelEducativo = 1;
        }

        return $seqNivelEducativo;
    }

    private function tipoVictima($seqTipo,$txtTipoVictima,$numLinea){
        $seqTipoVictima = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrTipoVictima = obtenerDatosTabla(
                "t_frm_tipovictima",
                array("seqTipoVictima","txtTipoVictima"),
                "txtTipoVictima",
                "lower(txtTipoVictima) = '" . mb_strtolower($txtTipoVictima) . "'"

            );
            if(! empty($arrTipoVictima)){
                $seqTipoVictima = $arrTipoVictima[$txtTipoVictima];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][18] . " es desconocido";
            }
        }else{
            $seqTipoVictima = 0;
        }
        return $seqTipoVictima;
    }
    
    private function lgtbi($seqTipo,$bolLgtbi,$txtLgtbi,$numLinea){
        $seqGrupoLgtbi = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrGrupoLgtbi = obtenerDatosTabla(
                "t_frm_grupo_lgtbi",
                array("seqGrupoLgtbi","txtGrupoLgtbi"),
                "txtGrupoLgtbi",
                "lower(txtGrupoLgtbi) = '" . mb_strtolower($txtLgtbi) . "'"

            );
            if(! empty($arrGrupoLgtbi)){
                $seqGrupoLgtbi = $arrGrupoLgtbi[$txtLgtbi];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][20] . " es desconocido";
            }

            if($bolLgtbi != 0 and $bolLgtbi != 1){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][19] . " no es valido";
            }

            if($seqGrupoLgtbi == 0 and $bolLgtbi == 1){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][19] . " no es valido";
            }elseif($seqGrupoLgtbi != 0 and $bolLgtbi == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][19] . " no es valido";
            }

        }else{
            $seqGrupoLgtbi = 0;
        }

        return $seqGrupoLgtbi;
    }

    private function ocupacion($seqTipo,$txtOcupacion,$numLinea){
        $seqOcupacion = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $txtOcupacion = mb_ereg_replace("-","/",$txtOcupacion);
            $arrOcupacion = obtenerDatosTabla(
                "t_ciu_ocupacion",
                array("seqOcupacion","txtOcupacion"),
                "txtOcupacion",
                "lower(txtOcupacion) = '" . mb_strtolower($txtOcupacion) . "'"

            );
            if(! empty($arrOcupacion)){
                $seqOcupacion = $arrOcupacion[$txtOcupacion];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][21] . " es desconocido";
            }
        }else{
            $seqOcupacion = 20;
        }
        return $seqOcupacion;
    }

    private function localidad($seqTipo,$txtLocalidad,$numLinea){
        $seqLocalidad = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrLocalidad = obtenerDatosTabla(
                "t_frm_localidad",
                array("seqLocalidad","txtLocalidad"),
                "txtLocalidad",
                "lower(txtLocalidad) = '" . mb_strtolower($txtLocalidad) . "'"

            );
            if(! empty($arrLocalidad)){
                $seqLocalidad = $arrLocalidad[$txtLocalidad];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][24] . " es desconocido";
            }
        }else{
            $seqLocalidad = 1;
        }
        return $seqLocalidad;
    }

    private function barrio($seqTipo,$seqLocalidad,$txtBarrio,$numLinea){
        $seqBarrio = 0;
        if($seqTipo == 2 or $seqTipo == 3){

            if(trim($txtBarrio) == ""){
                $txtBarrio = "DESCONOCIDO";
            }else{
                $txtBarrio = mb_strtoupper(trim($txtBarrio));
            }

            $arrBarrio = obtenerDatosTabla(
                "t_frm_barrio",
                array("seqBarrio", "txtBarrio"),
                "txtBarrio",
                "seqLocalidad = $seqLocalidad and lower(txtBarrio) = '" . mb_strtolower(trim($txtBarrio)) . "'"
            );

            foreach($arrBarrio as $txtClave => $seqBarrio){
                $txtClave = mb_strtoupper($txtClave);
                $arrBarrio[$txtClave] = $seqBarrio;
            }

            if (!empty($arrBarrio)) {
                $seqBarrio = $arrBarrio[$txtBarrio];
            } else {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][25] . " es desconocido o no es un barrio que corresponda a la localidad";
            }

        }else{
            $seqBarrio = 1143;
        }
        return $seqBarrio;
    }

    private function ciudad($seqTipo,$seqLocalidad,$txtCiudad,$numLinea){
        $seqCiudad = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrCiudad = obtenerDatosTabla(
                "v_frm_ciudad",
                array("seqCiudad","txtCiudad"),
                "txtCiudad",
                "lower(txtCiudad) = '" . mb_strtolower($txtCiudad) . "'"

            );
            if(! empty($arrCiudad)){
                $seqCiudad = $arrCiudad[$txtCiudad];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][26] . " es desconocido";
            }

            if($seqCiudad != 0) {
                if ($seqLocalidad == 22 and $seqCiudad == 149) {
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][24] . " no coincide con la ciudad";
                }
                if ($seqLocalidad != 22 and $seqCiudad != 149) {
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][24] . " no coincide con la ciudad";
                }
            }

        }else{
            $seqCiudad = 149;
        }
        return $seqCiudad;
    }

    private function vivienda($seqTipo,$txtVivienda,$valArriendo,$numLinea){
        $seqVivienda = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrVivienda = obtenerDatosTabla(
                "t_frm_vivienda",
                array("seqVivienda","txtVivienda"),
                "txtVivienda",
                "lower(txtVivienda) = '" . mb_strtolower($txtVivienda) . "'"

            );
            if(! empty($arrVivienda)){
                $seqVivienda = $arrVivienda[$txtVivienda];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][30] . " es desconocido";
            }

            if($seqVivienda == 1 and $valArriendo == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][31] . " no es válido de acuerdo con el tipo de vivienda";
            }elseif($seqVivienda != 1 and $valArriendo != 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][31] . " no es válido de acuerdo con el tipo de vivienda";
            }

        }else{
            $seqVivienda = 5;
        }
        return $seqVivienda;
    }

    private function sisben($seqTipo,$txtSisben,$numLinea){

        if($seqTipo == 2 or $seqTipo == 3){
            switch(mb_strtolower(trim($txtSisben))){
                case "ninguno":
                    $seqSisben = 1;
                    break;
                case "si":
                    $seqSisben = 9;
                    break;
                default:
                    $seqSisben = 0;
                    $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][34] . " es desconocido, los valores válidos son: Ninguno / Si";
                    break;
            }
        }else{
            $seqSisben = 1;
        }
        return $seqSisben;
    }

    private function banco($seqTipo,$txtAhorro,$valAhorro,$numLinea,$numPosicion){
        $seqAhorro = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrAhorro = obtenerDatosTabla(
                "t_frm_banco",
                array("seqBanco","txtBanco"),
                "txtBanco",
                "lower(txtBanco) = '" . mb_strtolower($txtAhorro) . "'"

            );
            if(! empty($arrAhorro)){
                $seqAhorro = $arrAhorro[$txtAhorro];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][$numPosicion] . " es desconocido";
            }

            if($seqAhorro == 1 and $valAhorro != 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][$numPosicion] . " no es válido para la el banco seleccionado";
            }elseif($seqAhorro != 1 and $valAhorro == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][$numPosicion] . " no es válido para la el banco seleccionado";
            }

        }else{
            $seqAhorro = 1;
        }
        return $seqAhorro;
    }

    private function subsidio($seqTipo,$valSNal,$txtSoporteSNal,$seqTipoEsquema,$numLinea){
        if($seqTipo == 1){
            if ($seqTipoEsquema == 16) { // MVY de 0 a 2 SMMLV
                $seqEntidadSubsidio = 12;
            } else { // MCY de 2 a 4 SMMLV
                $seqEntidadSubsidio = 14;
            }
        }else{
            if($seqTipoEsquema == 12){ // VIPA de 0 a 1.6 SMMLV
                $seqEntidadSubsidio = 11;
            } else { // VIPA de 1.6 a 2 SMMLV
                $seqEntidadSubsidio = 13;
            }
            if ($valSNal == 0 and $txtSoporteSNal != "") {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][41] . " no coincide con el valor del subsidio";
            } elseif ($valSNal != 0 and $txtSoporteSNal == "") {
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][41] . " no coincide con el valor del subsidio";
            }
        }
        return $seqEntidadSubsidio;
    }

    private function donacion($seqTipo,$txtDonacion,$valDonacion,$txtSoporteDonacion,$numLinea){
        $seqDonacion = 0;
        if($seqTipo == 2 or $seqTipo == 3){
            $arrDonacion = obtenerDatosTabla(
                "t_frm_empresa_donante",
                array("seqEmpresaDonante","txtEmpresaDonante"),
                "txtEmpresaDonante",
                "lower(txtEmpresaDonante) = '" . mb_strtolower($txtDonacion) . "'"

            );
            if(! empty($arrDonacion)){
                $seqDonacion = $arrDonacion[$txtDonacion];
            }else{
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][45] . " es desconocido";
            }

            if($seqDonacion == 1 and $valDonacion != 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][44] . " no corresponde con la entidad donante";
            }elseif($seqDonacion != 1 and $valDonacion == 0){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][44] . " no corresponde con la entidad donante";
            }

            if($valDonacion != 0 and $txtSoporteDonacion == ""){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][46] . " no corresponde con el valor de la donación";
            }elseif($valDonacion == 0 and $txtSoporteDonacion != ""){
                $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][46] . " no corresponde con el valor de la donación";
            }

        }else{
            $seqDonacion = 1;
        }
        return $seqDonacion;
    }

    private function esquema($seqTipo,$txtRangoIngresos){
        $seqTipoEsquema = 0;
        if($seqTipo == 1){
            switch($txtRangoIngresos){
                case "HASTA 2 SMMLV": // 10 SMMLV
                    $seqTipoEsquema = 17;
                    break;
                case "DE 2 SMMLV HASTA 3 SMMLV":  //  8 SMMLV
                    $seqTipoEsquema = 16;
                    break;
                case "DE 3 SMMLV HASTA 4 SMMLV": //  8 SMMLV
                    $seqTipoEsquema = 16;
                    break;
                case "SUPERIORES A 2 SMMLV Y HASTA 4 SMMLV": //  8 SMMLV
                    $seqTipoEsquema = 16;
                    break;
            }
        }elseif($seqTipo == 2){
            switch($txtRangoIngresos){
                case "HASTA 1.6 SMMLV": // 5 SMMLV
                    $seqTipoEsquema = 12;
                    break;
                case "DE 1.6 A 2 SMMLV": // 10 SMMLV
                    $seqTipoEsquema = 18;
                    break;
            }
        }else{
            $seqTipoEsquema = 1;
        }
        return $seqTipoEsquema;
    }

    private function valorSubsidio($seqTipo,$seqTipoEsquema){
        global $arrConfiguracion;
        if($seqTipo == 1) {
            if ($seqTipoEsquema == 16) { // MVY de 0 a 2 SMMLV
                $valAspiraSubsidio = $arrConfiguracion['constantes']['salarioMinimo'] * 10;
            } else { // MCY de 2 a 4 SMMLV
                $valAspiraSubsidio = $arrConfiguracion['constantes']['salarioMinimo'] * 8;
            }
        }elseif($seqTipo == 2){
            if($seqTipoEsquema == 12){ // VIPA de 0 a 1.6 SMMLV
                $valAspiraSubsidio = $arrConfiguracion['constantes']['salarioMinimo'] * 5;
            } else { // VIPA de 1.6 a 2 SMMLV
                $valAspiraSubsidio = $arrConfiguracion['constantes']['salarioMinimo'] * 10;
            }
        }else{
            $valAspiraSubsidio = 0;
        }
        return $valAspiraSubsidio;
    }

    private function modificarCiudadano($objCiudadano,$arrCiudadano){

        if($arrCiudadano['fchNacimiento'] !== null){
            $objCiudadano->fchNacimiento = $arrCiudadano['fchNacimiento'];
        }

        if($arrCiudadano['seqSexo'] != null){
            $objCiudadano->seqSexo = $arrCiudadano['seqSexo'];
        }

        if($arrCiudadano['seqEstadoCivil'] != 9){
            $objCiudadano->seqEstadoCivil = $arrCiudadano['seqEstadoCivil'];
        }

        if($arrCiudadano['seqNivelEducativo'] != 1){
            $objCiudadano->seqNivelEducativo = $arrCiudadano['seqNivelEducativo'];
            $objCiudadano->numAnosAprobados = $arrCiudadano['numAnosAprobados'];
        }

        if($arrCiudadano['seqGrupoLgtbi'] != 0){
            $objCiudadano->seqGrupoLgtbi = $arrCiudadano['seqGrupoLgtbi'];
            $objCiudadano->bolLgtb = $arrCiudadano['bolLgtb'];
        }

        if($arrCiudadano['seqEtnia'] != 1){
            $objCiudadano->seqEtnia = $arrCiudadano['seqEtnia'];
        }

        if($arrCiudadano['seqCondicionEspecial1'] != 6){
            $objCiudadano->seqCondicionEspecial = $arrCiudadano['seqCondicionEspecial1'];
        }

        if($arrCiudadano['seqCondicionEspecial2'] != 6){
            $objCiudadano->seqCondicionEspecial2 = $arrCiudadano['seqCondicionEspecial2'];
        }

        if($arrCiudadano['seqCondicionEspecial3'] != 6){
            $objCiudadano->seqCondicionEspecial3 = $arrCiudadano['seqCondicionEspecial3'];
        }

        if($arrCiudadano['seqOcupacion'] != 20){
            $objCiudadano->seqOcupacion = $arrCiudadano['seqOcupacion'];
        }

        if($arrCiudadano['seqSalud'] != 0){
            $objCiudadano->seqSalud = $arrCiudadano['seqSalud'];
        }

        if($arrCiudadano['seqTipoVictima'] != 0){
            $objCiudadano->seqTipoVictima = $arrCiudadano['seqTipoVictima'];
        }

        return $objCiudadano;
    }

    private function modificarFormulario($claFormularioModificado,$arrHogar,$claFormularioOriginal){

        $claFormularioModificado->seqPlanGobierno = $arrHogar['seqPlanGobierno'];
        $claFormularioModificado->seqModalidad = $arrHogar['seqModalidad'];
        $claFormularioModificado->seqTipoEsquema = $arrHogar['seqTipoEsquema'];
        $claFormularioModificado->seqSolucion = $arrHogar['seqSolucion'];
        $claFormularioModificado->txtDireccionSolucion = $arrHogar['txtDireccionSolucion'];
        $claFormularioModificado->fchUltimaActualizacion = date("Y-m-d H:i:s");
//        $claFormularioModificado->bolCerrado = ( $arrHogar['seqFormulario'] == 0 )? 1 : $claFormularioOriginal->bolCerrado;
//        $claFormularioModificado->seqEstadoProceso = ( $arrHogar['seqFormulario'] == 0 )? 16 : $claFormularioOriginal->seqEstadoProceso;
        $claFormularioModificado->bolCerrado = 1;
        $claFormularioModificado->seqEstadoProceso = 56;


        if($arrHogar['txtDireccion'] != ""){
            if($arrHogar['txtDireccion'] != $claFormularioOriginal->txtDireccion){
                $claFormularioModificado->seqCiudad = $arrHogar['seqCiudad'];
                $claFormularioModificado->seqLocalidad = $arrHogar['seqLocalidad'];
                $claFormularioModificado->seqBarrio = $arrHogar['seqBarrio'];
                $claFormularioModificado->txtDireccion = $arrHogar['txtDireccion'];
            }
        }else{

            if($arrHogar['seqLocalidad'] != 1){
                $claFormularioModificado->seqLocalidad = $arrHogar['seqLocalidad'];
            }

            if($arrHogar['seqBarrio'] != 1143){
                $claFormularioModificado->seqBarrio = $arrHogar['seqBarrio'];
            }

            if($arrHogar['seqCiudad'] != 1100){
                $claFormularioModificado->seqCiudad = $arrHogar['seqCiudad'];
            }

        }

        if($arrHogar['numTelefono1'] != ""){
            $claFormularioModificado->numTelefono1 = $arrHogar['numTelefono1'];
        }

        if($arrHogar['numTelefono2'] != ""){
            $claFormularioModificado->numTelefono1 = $arrHogar['numTelefono1'];
        }

        if($arrHogar['numCelular'] != ""){
            $claFormularioModificado->numCelular = $arrHogar['numCelular'];
        }

        if($arrHogar['txtCorreo'] != ""){
            $claFormularioModificado->txtCorreo = $arrHogar['txtCorreo'];
        }

        if($arrHogar['numHabitaciones'] != ""){
            $claFormularioModificado->numHabitaciones = $arrHogar['numHabitaciones'];
        }

        if($arrHogar['numHacinamiento'] != ""){
            $claFormularioModificado->numHacinamiento = $arrHogar['numHacinamiento'];
        }

        if($arrHogar['seqSisben'] != 1){
            $claFormularioModificado->seqSisben = $arrHogar['seqSisben'];
        }

        if($arrHogar['seqVivienda'] != 5){
            $claFormularioModificado->seqVivienda = $arrHogar['seqVivienda'];
            $claFormularioModificado->valArriendo = $arrHogar['valArriendo'];
        }

        if($arrHogar['seqBancoCuentaAhorro'] != 1){
            $claFormularioModificado->seqBancoCuentaAhorro = $arrHogar['seqBancoCuentaAhorro'];
            $claFormularioModificado->valSaldoCuentaAhorro = $arrHogar['valSaldoCuentaAhorro'];
        }

        if($arrHogar['seqBancoCuentaAhorro2'] != 1){
            $claFormularioModificado->seqBancoCuentaAhorro2 = $arrHogar['seqBancoCuentaAhorro2'];
            $claFormularioModificado->valSaldoCuentaAhorro2 = $arrHogar['valSaldoCuentaAhorro2'];
        }

        if($arrHogar['seqBancoCredito'] != 1){
            $claFormularioModificado->seqBancoCredito = $arrHogar['seqBancoCredito'];
            $claFormularioModificado->valCredito = $arrHogar['valCredito'];
        }

        if($arrHogar['seqEntidadSubsidio'] != 1){
            $claFormularioModificado->seqEntidadSubsidio = $arrHogar['seqEntidadSubsidio'];
            $claFormularioModificado->valSubsidioNacional = $arrHogar['valSubsidioNacional'];
            $claFormularioModificado->txtSoporteSubsidioNacional = $arrHogar['txtSoporteSubsidioNacional'];
        }

        if($arrHogar['seqEmpresaDonante'] != 1){
            $claFormularioModificado->seqEmpresaDonante = $arrHogar['seqEmpresaDonante'];
            $claFormularioModificado->valDonacion = $arrHogar['valDonacion'];
            $claFormularioModificado->txtSoporteDonacion = $arrHogar['txtSoporteDonacion'];
        }

        return $claFormularioModificado;
    }

    private function lineaValidada($seqTipo,$txtLineaValidada,$numLinea){
        if(mb_strtolower(trim($txtLineaValidada)) != "si" and mb_strtolower(trim($txtLineaValidada)) != "no"){
            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la columna " . $this->arrFormato[$seqTipo][47] . " es desconocido, los valores validos son: SI o NO";
        }
        if(mb_strtolower(trim($txtLineaValidada)) == "no"){
            $this->arrErrores[] = "Error linea " . ($numLinea + 1) . ": La linea no ha sido validada previamente";
        }
    }

    public function obtenerTitulos($seqTipo){
        return $this->arrFormato[$seqTipo];
    }

    public function exportable(){

        $arrExportable = array();

        foreach($this->arrHogares as $numHogar => $arrHogar){
            foreach($arrHogar['ciudadanos'] as $idCiudadano => $arrCiudadano){

                if($arrCiudadano['seqParentesco'] == 1) {

                    $arrExportable[$numHogar]['ID HOGAR'] = $numHogar;
                    $arrExportable[$numHogar]['NO. DOCUMENTO'] = $arrCiudadano['numDocumento'];
                    $arrExportable[$numHogar]['TIPO DOCUMENTO'] = $arrCiudadano['txtTipoDocumento'];
                    $arrExportable[$numHogar]['NOMBRE 1'] = $arrCiudadano['txtNombre1'];
                    $arrExportable[$numHogar]['NOMBRE 2'] = $arrCiudadano['txtNombre2'];
                    $arrExportable[$numHogar]['APELLIDO 1'] = $arrCiudadano['txtApellido1'];
                    $arrExportable[$numHogar]['APELLIDO 2'] = $arrCiudadano['txtApellido2'];
                    $arrExportable[$numHogar]['SEXO'] = $arrCiudadano['txtSexo'];
                    $arrExportable[$numHogar]['ESTADO CIVIL'] = $arrCiudadano['txtEstadoCivil'];
                    $arrExportable[$numHogar]['FECHA NACIMIENTO'] = $arrCiudadano['fchNacimiento'];
                    $arrExportable[$numHogar]['PARENTESCO'] = $arrCiudadano['txtParentesco'];
                    $arrExportable[$numHogar]['COND. ÉTNICA'] = $arrCiudadano['txtEtnia'];
                    $arrExportable[$numHogar]['DISCAPACIDAD'] = ($arrCiudadano['seqCondicionEspecial1'] == 3 or $arrCiudadano['seqCondicionEspecial2'] == 3 or $arrCiudadano['seqCondicionEspecial3'] == 3) ? 1 : 0;
                    $arrExportable[$numHogar]['MAYOR A 65 AÑOS'] = ($arrCiudadano['seqCondicionEspecial1'] == 2 or $arrCiudadano['seqCondicionEspecial2'] == 2 or $arrCiudadano['seqCondicionEspecial3'] == 2) ? 1 : 0;
                    $arrExportable[$numHogar]['CABEZA DE HOGAR'] = ($arrCiudadano['seqCondicionEspecial1'] == 1 or $arrCiudadano['seqCondicionEspecial2'] == 1 or $arrCiudadano['seqCondicionEspecial3'] == 1) ? 1 : 0;
                    $arrExportable[$numHogar]['AFILIACIÓN SALUD'] = $arrCiudadano['txtSalud'];
                    $arrExportable[$numHogar]['NIVEL EDUCATIVO'] = $arrCiudadano['txtNivelEducativo'];
                    $arrExportable[$numHogar]['AÑOS APROBADOS'] = $arrCiudadano['numAnosAprobados'];
                    $arrExportable[$numHogar]['HECHO VICTIMIZANTE'] = $arrCiudadano['txtTipoVictima'];
                    $arrExportable[$numHogar]['LGTBI'] = $arrCiudadano['bolLgtb'];
                    $arrExportable[$numHogar]['GRUPO LGBTI'] = $arrCiudadano['txtGrupoLgtbi'];
                    $arrExportable[$numHogar]['OCUPACIÓN'] = $arrCiudadano['txtOcupacion'];
                    $arrExportable[$numHogar]['CORREO ELECTRÓNICO'] = $arrHogar['txtCorreo'];
                    $arrExportable[$numHogar]['DIRECCIÓN'] = $arrHogar['txtDireccion'];
                    $arrExportable[$numHogar]['LOCALIDAD'] = $arrHogar['txtLocalidad'];
                    $arrExportable[$numHogar]['BARRIO'] = $arrHogar['txtBarrio'];
                    $arrExportable[$numHogar]['CIUDAD'] = $arrHogar['txtCiudad'];
                    $arrExportable[$numHogar]['TELEFONOS1'] = $arrHogar['numTelefono1'];
                    $arrExportable[$numHogar]['TELEFONO2'] = $arrHogar['numTelefono2'];
                    $arrExportable[$numHogar]['CELULAR'] = $arrHogar['numCelular'];
                    $arrExportable[$numHogar]['VIVIENDA ACTUAL'] = $arrHogar['txtVivienda'];
                    $arrExportable[$numHogar]['VAL. ARRIENDO'] = $arrHogar['valArriendo'];
                    $arrExportable[$numHogar]['HOGARES EN VIVIENDA'] = $arrHogar['numHabitaciones'];
                    $arrExportable[$numHogar]['DORMITORIOS QUE EMPLEA EL HOGAR'] = $arrHogar['numHacinamiento'];
                    $arrExportable[$numHogar]['ENCUESTA SISBEN'] = $arrHogar['txtSisben'];
                    $arrExportable[$numHogar]['INGRESOS'] = $arrHogar['valIngresosHogar'];
                    $arrExportable[$numHogar]['VALOR AHORRO'] = $arrHogar['valSaldoCuentaAhorro'];
                    $arrExportable[$numHogar]['ENTIDAD AHORRO'] = $arrHogar['txtBancoCuentaAhorro'];
                    $arrExportable[$numHogar]['VALOR CREDITO'] = $arrHogar['valCredito'];
                    $arrExportable[$numHogar]['ENTIDAD CRÉDITO'] = $arrHogar['txtBancoCredito'];
                    $arrExportable[$numHogar]['VALOR SUBSIDIO NACIONAL'] = $arrHogar['valSubsidioNacional'];
                    $arrExportable[$numHogar]['SOPORTE DEL SFV'] = $arrHogar['txtSoporteSubsidioNacional'];
                    $arrExportable[$numHogar]['RANGO DE INGRESOS'] = $arrHogar['txtRangoIngresos'];
                    $arrExportable[$numHogar]['PROYECTO'] = $arrHogar['txtDireccionSolucion'];
                    $arrExportable[$numHogar]['VALOR DONACIÓN / RECONOCIMIENTO ECONÓMICO'] = $arrHogar['valDonacion'];
                    $arrExportable[$numHogar]['ENTIDAD DE DONACIÓN / RECONOCIMIENTO'] = $arrHogar['txtEmpresaDonante'];
                    $arrExportable[$numHogar]['SOPORTE DONACIÓN'] = $arrHogar['txtSoporteDonacion'];
                    $arrExportable[$numHogar]['LINEA VALIDADA'] = "SI";
                    $arrExportable[$numHogar]['ESTADO HOGAR'] = $arrHogar['txtEstadoHogar'];
                    $arrExportable[$numHogar]['OBSERVACIONES'] = $arrHogar['txtObservaciones'];

                }

            }
        }


        return $arrExportable;
    }

}