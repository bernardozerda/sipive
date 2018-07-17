<?php

class InscripcionFonvivienda
{

    public $arrErrores;
    public $arrMensajes;
    private $arrFormato;
    private $arrEstados;
    private $arrRangoIngresos;
    private $arrSoluciones;
    private $arrModalidad;
    private $arrHogares;
    public $arrCiudadanos;

    public function __construct()
    {
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

        $this->arrRangoIngresos[] = "HASTA 2 SMMLV";
        $this->arrRangoIngresos[] = "DE 2 SMMLV HASTA 3 SMMLV";
        $this->arrRangoIngresos[] = "DE 3 SMMLV HASTA 4 SMMLV";
        $this->arrRangoIngresos[] = "SUPERIORES A 2 SMMLV Y HASTA 4 SMMLV";

        $this->arrSoluciones[] = "VIP";
        $this->arrSoluciones[] = "VIS";

        $this->arrModalidad[] = "LEASING";
        $this->arrModalidad[] = "CRÉDITO";

        $this->arrHogares = array();

//        $this->ciudadanos();


    }
    
    private function cargarArchivo(){

        $arrArchivo = array();

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

        if( empty( $this->arrErrores ) ){
            foreach( file( $_FILES['archivo']['tmp_name'] ) as $numLinea => $txtLinea ){
                if( trim( $txtLinea ) != "" ) {
                    $arrArchivo[$numLinea] = explode("|", trim(utf8_encode($txtLinea)));
                    foreach( $arrArchivo[$numLinea] as $numColumna => $txtCelda ) {
                        preg_match("/(\d{2})\/(\d{2})\/(\d{2,4})/", $txtCelda, $arrMatch);
                        if (!empty($arrMatch)) {
                            $arrMatch[3] = ($arrMatch[3] < 100)? $arrMatch[3] + 2000 : $arrMatch[3];
                            $txtCelda = new DateTime($arrMatch[3] . "-" . $arrMatch[2] . "-" . $arrMatch[1]);
                        } else {
                            $txtCelda = trim($txtCelda);
                        }
                        $arrArchivo[$numLinea][$numColumna] = $txtCelda;
                    }
                }
            }
        }

        if(count($arrArchivo) == 1){
            $this->arrErrores[] = "Un archivo que contiene solo los titulos se considera vacío";
        }

        return $arrArchivo;

    }

    private function titulos($arrTitulos){
        if(empty($this->arrErrores)){
            foreach($this->arrFormato as $numColumna => $txtTitulo){
                if(trim(mb_strtolower($arrTitulos[$numColumna])) != trim(mb_strtolower($txtTitulo))){
                    $this->arrErrores[] = "La columna $txtTitulo no se encuentra o no está en el lugar correcto";
                }
            }
        }
    }

    private function limpieza($arrArchivo){
        if(empty($this->arrErrores)) {
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
        }
        return $arrArchivo;
    }

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

    private function hogares($arrArchivo){
        if(empty($this->arrErrores)){
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

                }
            }else{
                $this->arrErrores[] = "No hay información válida dentro del archivo para procesar";
            }
        }
    }

    public function coincidencias(){

        foreach($this->arrHogares as $numHogar => $arrHogar){

            foreach($arrHogar['hogar'] as $seqTipoDocumento => $arrCiudadanos){

                foreach($arrCiudadanos as $numDocumento => $arrNombre){

                    foreach($this->arrCiudadanos as $seqCiudadano => $txtNombre) {
                        $numDistancia = levenshtein(trim(mb_strtolower($arrNombre['nombres'] . " " . $arrNombre['apellidos'])), $txtNombre);
                        $this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'][$numDistancia][$seqCiudadano] = mb_strtoupper($txtNombre);
                    }
                    ksort($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias']);
                    $i = 0;
                    foreach($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'] as $numDistancia => $arrCoincidencias){
                        if($i > 2){
                            unset($this->arrHogares[$numHogar]['hogar'][$seqTipoDocumento][$numDocumento]['coincidencias'][$numDistancia]);
                        }
                        $i++;
                    }




                }

            }

        }


        pr($this->arrHogares);

    }


    public function ciudadanos(){
        global $aptBd;
        $this->arrCiudadanos = array();
        $sql = "
            select
                ciu.seqCiudadano,
                ciu.txtNombre1,
                ciu.txtNombre2,
                ciu.txtApellido1,
                ciu.txtApellido2
            from t_ciu_ciudadano ciu
        ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $txtNombre = trim($objRes->fields['txtNombre1']);
            $txtNombre .= (trim($objRes->fields['txtNombre2']) != "") ? " " . trim($objRes->fields['txtNombre2']) : "";
            $txtNombre .= " " . trim($objRes->fields['txtApellido1']);
            $txtNombre .= (trim($objRes->fields['txtApellido2']) != "") ? " " . trim($objRes->fields['txtApellido2']) : "";
            $this->arrCiudadanos[$seqCiudadano] = mb_strtolower($txtNombre);
            $objRes->MoveNext();
        }
    }

    public function cargarNovedades(){

        $arrArchivo = $this->cargarArchivo();

        $this->titulos($arrArchivo[0]);

        $arrArchivo = $this->limpieza($arrArchivo);

        $this->hogares($arrArchivo);

        $this->coincidencias();

        pr($this->arrHogares);

    }


}