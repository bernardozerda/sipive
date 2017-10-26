<?php

ini_set("upload_max_filesize" , "10M");

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

$arrErrores = array();
$arrMensajes = array();
$arrEstados = estadosProceso();

// inicia el procesamiento
if(isset($_POST['salvar']) and $_POST['salvar'] == 1){

    // valida si el archivo fue cargado y si corresponde a las extensiones válidas
    switch ($_FILES['documentos']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" Excede el tamaño permitido";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" Excede el tamaño permitido";
            break;
        case UPLOAD_ERR_PARTIAL:
            $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
            break;
        case UPLOAD_ERR_NO_FILE:
            $arrErrores[] = "Debe especificar un archivo para cargar (documentos)";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
            break;
        case UPLOAD_ERR_EXTENSION:
            $arrErrores[] = "El archivo \"" . $_FILES['documentos']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
            break;
        default:
            $numPunto = strpos($_FILES['documentos']['name'], ".") + 1;
            $numRestar = ( strlen($_FILES['documentos']['name']) - $numPunto ) * -1;
            $txtExtension = substr($_FILES['documentos']['name'], $numRestar);
            if (!in_array(strtolower($txtExtension), array("txt"))) {
                $arrErrores[] = "Tipo de Archivo no permitido $txtExtension para los documentos ";
            }
            break;
    }

    // valida si el archivo fue cargado y si corresponde a las extensiones válidas
    switch ($_FILES['fotos']['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $arrErrores[] = "El archivo \"" . $_FILES['fotos']['name'] . "\" Excede el tamaño permitido";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $arrErrores[] = "El archivo \"" . $_FILES['fotos']['name'] . "\" Excede el tamaño permitido";
            break;
        case UPLOAD_ERR_PARTIAL:
            $arrErrores[] = "El archivo \"" . $_FILES['fotos']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
            break;
        case UPLOAD_ERR_NO_FILE:
            $arrErrores[] = "Debe especificar un archivo para cargar (fotos)";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $arrErrores[] = "El archivo \"" . $_FILES['fotos']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $arrErrores[] = "El archivo \"" . $_FILES['fotos']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
            break;
        case UPLOAD_ERR_EXTENSION:
            $arrErrores[] = "El archivo \"" . $_FILES['fotos']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
            break;
        default:
            $numPunto = strpos($_FILES['fotos']['name'], ".") + 1;
            $numRestar = ( strlen($_FILES['fotos']['name']) - $numPunto ) * -1;
            $txtExtension = substr($_FILES['fotos']['name'], $numRestar);
            if (!in_array(strtolower($txtExtension), array("zip"))) {
                $arrErrores[] = "Tipo de Archivo no permitido $txtExtension para las fotos";
            }
            break;
    }

    if(empty($arrErrores)){

        // carga la plantilla en un arreglo y limpia la informacion
        $arrArchivo = file($_FILES['documentos']['tmp_name']);
        foreach($arrArchivo as $numLinea => $txtLinea){
            if(trim($txtLinea) != ""){
                $arrArchivo[$numLinea] = mb_split("\t" , mb_strtolower(utf8_encode($txtLinea)));
                if($numLinea == 0){
                    $arrTitulos = $arrArchivo[$numLinea];
                }
            }else{
                unset($arrArchivo[$numLinea]);
            }
        }

        // quita la fila de titulos
        unset($arrArchivo[0]);

        try {

            // inicia la trnasaccion
            $aptBd->BeginTrans();

            // prepara la informacion para la base de datos
            foreach ($arrArchivo as $numLinea => $arrLinea) {

                // estado del proceso
                $seqEstadoProceso = array_shift(
                    obtenerDatosTabla(
                        "T_FRM_FORMULARIO",
                        array("seqFormulario", "seqEstadoProceso"),
                        "seqFormulario",
                        "seqFormulario = " . $arrLinea[2]
                    )
                );

                // buscar desembolso
                $seqDesembolso = array_shift(
                    obtenerDatosTabla(
                        "T_DES_DESEMBOLSO",
                        array("seqFormulario" , "seqDesembolso"),
                        "seqFormulario",
                        "seqFormulario = " . $arrLinea[2]
                    )
                );

                // buscar tecnico
                $seqTecnico = array_shift(
                    obtenerDatosTabla(
                        "T_DES_TECNICO",
                        array("seqDesembolso" , "seqTecnico"),
                        "seqDesembolso",
                        "seqDesembolso = " . $seqDesembolso
                    )
                );

                // si no esta en el estado correcto no inicia
                if(intval($seqEstadoProceso) != 23){
                    $arrErrores[] = "Linea " . ( $numLinea + 1 ) . ": El estado del formulario " . $arrLinea[2] . " es " . $arrEstados[$seqEstadoProceso] . ", que no es permitido";
                }

                // verifica que tenga registro de desembolso para asociar
                if(intval($seqDesembolso) == 0){
                    $arrErrores[] = "Linea " . ( $numLinea + 1 ) . ": El formulario " . $arrLinea[2] . " no tiene registro de desembolso";
                }

                // no debe tener registro de estudio tecnico
                // pero si lo tiene solo se ignora el registro, no es un error
                if(intval($seqTecnico) == 0){

                    // verificar la cantidad de fotos
                    $numFotos = $arrLinea[118];
                    $seqFormulario = $arrLinea[2];

                    // posiciones que no se requieren
                    unset($arrLinea[0]);
                    unset($arrLinea[1]);
                    unset($arrLinea[2]);
                    unset($arrLinea[118]);

                    // posiciones que no se requieren de los campos
                    unset($arrTitulos[0]);
                    unset($arrTitulos[1]);
                    unset($arrTitulos[2]);
                    unset($arrTitulos[118]);

                    $arrTecnicos[$seqFormulario]['seguimiento']['seqFormulario'] = $seqFormulario;
                    foreach($arrTitulos as $numColumna => $txtCampo){
                        if(substr($txtCampo,0,3) == "num" and $txtCampo != "numcontadoragua"){
                            $arrLinea[$numColumna] = number_format(floatval(mb_ereg_replace(",",".", $arrLinea[$numColumna])),2,".","");
                        }else{
                            $arrLinea[$numColumna] = regularizarCampo($txtCampo , $arrLinea[$numColumna]);
                        }
                        $arrTecnicos[$seqFormulario]['seguimiento'][$txtCampo] = $arrLinea[$numColumna];
                    }

                    // insertando el registro en tecnicos
                    $sql = "insert into t_des_tecnico (seqDesembolso," . implode(",",$arrTitulos) . ") values ('" . $seqDesembolso . "','" . implode("','",$arrLinea) . "')";
                    $aptBd->execute($sql);

                    // arreglo para el tema de las fotos
                    $arrTecnicos[$seqFormulario]['seqTecnico'] = $aptBd->Insert_ID();
                    $arrTecnicos[$seqFormulario]['numFotos'] = $numFotos;



                }else{
                    $arrMensajes[] = "Linea " . ( $numLinea + 1 ) . ": Ya ha sido cargado con anterioridad, formulario " . $arrLinea[2];
                }

            }

            // procesamiento de las fotos
            if(empty($arrErrores)){

                $claZip = new ZipArchive();
                $claZip->open($_FILES['fotos']['tmp_name']);

                // validaciones de las fotos
                for($i = 0; $i < $claZip->numFiles; $i++) {
                    $arrFoto = $claZip->statIndex($i);
                    if($arrFoto['size'] > 205000){
                        $arrErrores[] = "La foto " . $arrFoto['name'] . " excede el tamaño permitido de 200K";
                    }else {
                        $seqFormulario = substr($arrFoto['name'], 0, strpos($arrFoto['name'], "/"));
                        $arrTecnicos[$seqFormulario]['fotos'][] = $arrFoto['name'];
                    }
                }

                foreach($arrTecnicos as $seqFormulario => $arrDatos){
                    if(intval($arrDatos['seqTecnico']) == 0){
                        $arrErrores[] = "No se reconoce al numero de formulario " . $seqFormulario . " dentro de la plantilla de datos";
                    }else{
                        if(intval($arrDatos['numFotos']) != 0) {
                            if (intval($arrDatos['numFotos']) != count($arrDatos['fotos'])) {
                                $arrErrores[] = "La plantilla indica que el formulario " . $seqFormulario . " debe tener " . intval($arrDatos['numFotos']) . " y dentro del zip hay " . count($arrDatos['fotos']);
                            }
                        }else{
                            $arrErrores[] = "Debe especificar una cantidad de fotos diferente de cero para el formulario " . $seqFormulario;
                        }
                    }
                }

                if(empty($arrErrores)){
                    if($claZip->extractTo($txtPrefijoRuta . $arrConfiguracion['carpetas']['imagenes'] . "/desembolsos" )){
                        foreach($arrTecnicos as $seqFormulario => $arrDatos){
                            $seqTecnico = $arrDatos['seqTecnico'];
                            foreach($arrDatos['fotos'] as $txtArhivo){
                                $sql = "insert into t_des_adjuntos_tecnicos(seqTecnico, seqTipoAdjunto, txtNombreAdjunto, txtNombreArchivo) values ($seqTecnico,3,'$txtArhivo','$txtArhivo')";
                                $aptBd->execute($sql);
                            }
                        }
                    }else{
                        $arrErrores[] = "Hubo problemas al intentar extraer las fotos y colocarlas en el servidor";
                    }
                }

                if(empty($arrErrores)){

                    foreach($arrTecnicos as $seqFormulario => $arrDatos) {

                        // seguimiento y su adaptacion para dejar el registro
                        $sql = "
                            SELECT 
                                ciu.numDocumento as cedula,
                                upper( concat( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 ) ) as nombre
                            FROM t_frm_formulario frm
                            INNER JOIN t_frm_hogar hog ON frm.seqFormulario = hog.seqFormulario AND hog.seqParentesco = 1
                            INNER JOIN t_ciu_ciudadano ciu ON hog.seqciudadano = ciu.seqCiudadano
                            WHERE frm.seqFormulario = " . $seqFormulario . "
                        ";
                        $arrCiudadano = $aptBd->GetAll($sql);

                        $arrDatos['seguimiento']['seqGrupoGestion'] = 15;
                        $arrDatos['seguimiento']['seqGestion'] = 63;
                        $arrDatos['seguimiento']['txtComentario'] = "Carga masiva de datos de estudios técnicos";
                        $arrDatos['seguimiento']['cedula'] = $arrCiudadano[0]['cedula'];
                        $arrDatos['seguimiento']['nombre'] = $arrCiudadano[0]['nombre'];
                        $arrDatos['seguimiento']['seqEstadoProceso'] = 26;
                        $arrDatos['seguimiento']['nombreArchivoCargado'] = $arrDatos['fotos'];

                        $claSeguimiento = null;
                        $claSeguimiento = new Seguimiento();
                        $txtCambios = $claSeguimiento->cambiosDesembolso("revisionTecnica" , null , $arrDatos['seguimiento']);

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
                                '" . $arrDatos['seguimiento']['txtComentario'] . "',
                                '" . $txtCambios . "',
                                " . $arrDatos['seguimiento']['cedula'] . ",
                                '" . $arrDatos['seguimiento']['nombre']. "',
                                " . $arrDatos['seguimiento']['seqGestion'] . "
                            )
                        ";
                        $aptBd->execute($sql);

                        $sql = "update t_frm_formulario set seqEstadoProceso = 26, fchUltimaActualizacion = now() where seqFormulario = " . $seqFormulario;
                        $aptBd->execute($sql);

                        $arrMensajes[] = "Formulario " . $seqFormulario . " salvado";

                    }
                }

            }

//            throw new Exception("hola");

            // confirma la transaccion
            if(empty($arrErrores)) {
                $aptBd->CommitTrans();
            }else{
                $numUltimo = count($arrErrores) - 1;
                $txtError = $arrErrores[$numUltimo];
                unset($arrErrores[$numUltimo]);
                throw new Exception($txtError);
            }

        }catch (Exception $objError){
            $arrErrores[] = $objError->getMessage();
            $aptBd->RollBackTrans();
        }

    }

}

echo "&nbsp;";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Estilos CSS -->
    <link href="./librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="./librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
    <div id="contenidos" class="container" style="width: 650px">

        <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
            Cargue masivo de estudios técnicos<br>para el esquema <strong>Mi casa ya</strong>
        </div>
        <div class="well">

            <?php

                $arrTextos = array();
                if(! empty($arrMensajes)){
                    $txtClase = "alert-success";
                    $txtClaseLi = "msgVerde";
                    $arrTextos = $arrMensajes;
                }elseif( ! empty($arrErrores)){
                    $txtClase = "alert-danger";
                    $txtClaseLi = "msgError";
                    $arrTextos = $arrErrores;
                }

                if(!empty($arrTextos)) {
                    echo "<div class='alert $txtClase' role='alert' style='text-align: left'>";
                    foreach ($arrTextos as $txtTexto) {
                        echo "<li class='$txtClaseLi'>" . $txtTexto . "</li>";
                    }
                    echo "</div>";
                }

            ?>

        </div>
    </div>

    <!-- INCLUSIONES JAVASCRIPT [NO MOVER DEL FINAL] -->
    <script type="text/javascript" src="../../../librerias/bootstrap/js/jquery-1.10.1.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-collapse.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-transition.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-alert.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-dropdown.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-scrollspy.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-tab.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-popover.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-tooltip.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-button.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-carousel.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-typeahead.js"></script>
    <script type="text/javascript" src="../../../librerias/bootstrap/js/bootstrap-affix.js"></script>

</body>
</html>
