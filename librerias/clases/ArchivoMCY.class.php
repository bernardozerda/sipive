<?php


class ArchivoMCY
{

    public $arrErrores;
    public $arrMensajes;
    public $arrTitulos;

    public function __construct()
    {
        $this->arrErrores = array();
        $this->arrMensajes = array();

        $this->arrTitulos[]  = "ID";
        $this->arrTitulos[]  = "NIT";
        $this->arrTitulos[]  = "ENTIDAD";
        $this->arrTitulos[]  = "TIPO DOCUMENTO";
        $this->arrTitulos[]  = "DOCUMENTO";
        $this->arrTitulos[]  = "NOMBRE";
        $this->arrTitulos[]  = "FECHA";
        $this->arrTitulos[]  = "VALOR";
        $this->arrTitulos[]  = "JUSTIFICACION";
        $this->arrTitulos[]  = "REPORTAR";
        $this->arrTitulos[]  = "DETALLE";

    }

    public function cargarArchivo(){

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
                if (!in_array(strtolower($txtExtension),array("txt"))) {
                    $this->arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
                }
                break;
        }

        $arrArchivo = array();
        if(empty($this->arrErrores)){
            foreach( file( $_FILES['archivo']['tmp_name'] ) as $numLinea => $txtLinea ){
                if( trim( $txtLinea ) != "" ) {
                    $arrArchivo[$numLinea] = mb_split("\t", rtrim(utf8_encode($txtLinea)));
                    foreach( $arrArchivo[$numLinea] as $numColumna => $txtCelda ){
                        $arrArchivo[$numLinea][$numColumna] = trim($txtCelda);
                    }
                }
            }
        }

        return $arrArchivo;
    }

    public function validarTitulos($arrTitulos){
        foreach($this->arrTitulos as $numColumna => $txtColumna){
            if($txtColumna != $arrTitulos[$numColumna]){
                $this->arrErrores[] = "La columna $txtColumna no está o no está en el lugar correcto";
            }
        }
    }

    public function salvar($arrArchivo){
        global $aptBd;

        $aptBd->BeginTrans();

        try{

            foreach($arrArchivo as $numLinea => $arrLinea){

                $seqArchivoMcy = intval($arrLinea[0]);
                $numNit = doubleval($arrLinea[1]);
                $txtEntidad = trim($arrLinea[2]);
                $seqTipoDocumento = intval($arrLinea[3]);
                $numDocumento = doubleval($arrLinea[4]);
                $txtNombre = trim($arrLinea[5]);
                $fchAsignacion = trim($arrLinea[6]);
                $valAsignado = doubleval($arrLinea[7]);
                $txtJustificacion = trim($arrLinea[8]);
                $bolExclusion = intval($arrLinea[9]);
                $txtExclusion = trim($arrLinea[10]);

                if($seqArchivoMcy == 0){
                    $sql  = "
                        insert into t_fnv_archivo_mcy (
                            numNIT,
                            txtEntidad,
                            seqTipoDocumento,
                            numDocumento,
                            txtNombre,
                            fchAsignacion,
                            valAsignado,
                            txtJustificacion,
                            bolReportarLinea,
                            txtExclusion
                        ) values (
                            $numNit,
                            '$txtEntidad',
                            $seqTipoDocumento,
                            $numDocumento,
                            '$txtNombre',
                            '$fchAsignacion',
                            $valAsignado,
                            '$txtJustificacion',
                            $bolExclusion,
                            '$txtExclusion'
                        )
                    ";
                    $aptBd->execute($sql);

                    $seqArchivoMcy = $aptBd->Insert_ID();

                }else{
                    $sql = "
                      update t_fnv_archivo_mcy set
                          numNIT = $numNit,
                          txtEntidad = '$txtEntidad',
                          seqTipoDocumento = $seqTipoDocumento,
                          numDocumento = $numDocumento,
                          txtNombre = '$txtNombre',
                          fchAsignacion = '$fchAsignacion',
                          valAsignado = $valAsignado,
                          txtJustificacion = '$txtJustificacion',
                          bolReportarLinea = $bolExclusion,
                          txtExclusion = '$txtExclusion'
                      where seqArchivoMcy = $seqArchivoMcy
                    ";
                    $aptBd->execute($sql);
                }

                $sql = "
                    insert into t_fnv_archivo_mcy_auditoria (
                        seqArchivoMcy,
                        seqUsuario,
                        bolReportarLinea,
                        txtExclusion,
                        fchMovimiento
                    ) values (
                        " . $seqArchivoMcy . ",
                        " . $_SESSION['seqUsuario'] . ",
                        $bolExclusion,
                        '$txtExclusion',
                        now()
                    )
                ";
                $aptBd->execute($sql);

            }

            $aptBd->CommitTrans();
            $this->arrMensajes[] = "Carga de datos satisfactoria";

        }catch(Exception $objError){
            $this->arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
        }

    }
    
    public function listado($seqTipoDocumento, $numDocumento){
        global $aptBd;

        $txtCondicionTipo   = ($seqTipoDocumento == 0)? "" : "and a.seqTipoDocumento = $seqTipoDocumento";
        $txtCondicionNumero = ($numDocumento == 0)?     "" : "and a.numDocumento = $numDocumento";

        $sql = "
            select 
                a.seqTipoDocumento,
                t.txtTipoDocumento,
                a.numDocumento,
                a.txtNombre,
                if(sum(a.bolReportarLinea) > 0,'SI','NO') as bolReportarLinea 
            from t_fnv_archivo_mcy a
            inner join t_ciu_tipo_documento t on a.seqTipoDocumento = t.seqTipoDocumento
            where 1 = 1
              $txtCondicionTipo
              $txtCondicionNumero
            group by 
                a.seqTipoDocumento, 
                a.numDocumento, 
                a.txtNombre
            order by 
                a.numDocumento
        ";
        return $aptBd->GetAll($sql);
    }

    public function cargarLineas($seqTipoDocumento,$numDocumento){
        global $aptBd;
        $sql = "
            SELECT 
                a.seqArchivoMcy,
                a.numNIT,
                a.txtEntidad,
                a.seqTipoDocumento,
                t.txtTipoDocumento,
                a.numDocumento,
                a.txtNombre,
                a.fchAsignacion,
                a.valAsignado,
                a.txtJustificacion,
                a.bolReportarLinea,
                a.txtExclusion
            FROM t_fnv_archivo_mcy a
            INNER JOIN t_ciu_tipo_documento t on a.seqTipoDocumento = t.seqTipoDocumento
            WHERE a.seqTipoDocumento = $seqTipoDocumento
              AND a.numDocumento = $numDocumento
        ";
        return $aptBd->GetAll($sql);
    }

    public function editar($arrPost){
        global $aptBd;

        foreach($arrPost as $seqArchivoMcy => $arrDatos){
            if($arrDatos['bolReportarLinea'] == 0 and $arrDatos['txtExclusion'] == ""){
                $this->arrErrores['input'][$seqArchivoMcy] = "Debe digitar la justificacion";
            }
        }

        if(empty($this->arrErrores)){
            try {
                $aptBd->BeginTrans();
                foreach ($arrPost as $seqArchivoMcy => $arrDatos) {

                    $sql = "
                        update t_fnv_archivo_mcy set 
                            bolReportarLinea = " . $arrDatos['bolReportarLinea'] . ",
                            txtExclusion = '" . $arrDatos['txtExclusion'] . "'
                        where seqArchivoMcy = $seqArchivoMcy
                    ";
                    $aptBd->execute($sql);

                    $sql = "
                        insert into t_fnv_archivo_mcy_auditoria (
                            seqArchivoMcy, 
                            seqUsuario, 
                            bolReportarLinea, 
                            txtExclusion, 
                            fchMovimiento
                        ) values (
                            $seqArchivoMcy,
                            " . $_SESSION['seqUsuario'] . ",
                            " . $arrDatos['bolReportarLinea'] . ",
                            '" . $arrDatos['txtExclusion'] . "',
                            now()
                        ) 
                    ";
                    $aptBd->execute($sql);

                }
                $aptBd->CommitTrans();
                $this->arrMensajes[] = "Cambios salvados satisfactoriamente";
            }catch (Exception $objError){
                $aptBd->RollBackTrans();
                $this->arrErrores['general'][] = $objError->getMessage();
            }
        }

    }

}


?>