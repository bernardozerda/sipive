<?php

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
           $arrErrores[] = "Debe especificar un archivo para cargar";
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
               $arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
            }
            break;
    }

    // si hay archivo continua
    if(empty($arrErrores)){

        // del archivo pasa a un arreglo con limpieza de caracteres y lineas vacias
        $arrArchivo = file($_FILES['documentos']['tmp_name']);
        foreach($arrArchivo as $numLinea => $txtLinea){
            if( trim($txtLinea) != "") {
                $arrArchivo[$numLinea] = mb_split("\t", trim($txtLinea));
            }else{
                unset($arrArchivo[$numLinea]);
            }
        }

        // los titulos vienen en la primera linea
        $arrTitulos = array_shift($arrArchivo);

        try{

            // inicia la transaccion
            $aptBd->BeginTrans();

            // insertando los registros
            foreach($arrArchivo as $numLinea => $arrLinea) {

                $seqEstadoProceso = array_shift(
                    obtenerDatosTabla(
                        "T_FRM_FORMULARIO",
                        array("seqFormulario","seqEstadoProceso"),
                        "seqFormulario",
                        "seqFormulario = " . $arrLinea[0]
                    )
                );

                if( $seqEstadoProceso == 15 ) {

                    // desembolso
                    $sql = sqlDesembolso($arrLinea);
                    $aptBd->execute($sql);
                    $seqDesembolso = $aptBd->Insert_ID();

                    // escrituracion
                    $arrPost = sqlEscrituracion($seqDesembolso, $arrLinea);
                    $aptBd->execute($arrPost['sql']);

                    // seguimiento y su adaptacion para dejar el registro
                    $sql = "
                        SELECT 
                            ciu.numDocumento as cedula,
                            upper( concat( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 ) ) as nombre
                        FROM t_frm_formulario frm
                        INNER JOIN t_frm_hogar hog ON frm.seqFormulario = hog.seqFormulario AND hog.seqParentesco = 1
                        INNER JOIN t_ciu_ciudadano ciu ON hog.seqciudadano = ciu.seqCiudadano
                        WHERE frm.seqFormulario = " . $arrLinea[0] . "
                    ";
                    $arrCiudadano = $aptBd->GetAll($sql);

                    $arrPost['post']['seqGrupoGestion'] = 15;
                    $arrPost['post']['seqGestion'] = 63;
                    $arrPost['post']['txtComentario'] = "Carga masiva de datos de escrituración";
                    $arrPost['post']['cedula'] = $arrCiudadano[0]['cedula'];
                    $arrPost['post']['nombre'] = $arrCiudadano[0]['nombre'];
                    $arrPost['post']['seqEstadoProceso'] = 23;

                    $claSeguimiento = new Seguimiento();
                    $txtCambios = $claSeguimiento->cambiosDesembolso("escrituracion", null, $arrPost['post']);

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
                            " . $arrPost['post']['seqFormulario'] . ",
                            '" . date("Y-m-d H:i:s") . "',
                            " . $_SESSION['seqUsuario'] . ",
                            '" . $arrPost['post']['txtComentario'] . "',
                            '" . $txtCambios . "',
                            " . $arrPost['post']['cedula'] . ",
                            '" . $arrPost['post']['nombre'] . "',
                            " . $arrPost['post']['seqGestion'] . "
                        )
                    ";
                    $aptBd->execute($sql);

                    // vincula el hogar al flujo de desembolso
                    $sql = "insert into t_des_flujo (seqFormulario, txtFlujo) values (" . $arrLinea[0] . ",'postulacionIndividual')";
                    $aptBd->execute($sql);

                    // cambia de estado el formulario
                    $sql = "update t_frm_formulario set fchUltimaActualizacion = now(), seqEstadoProceso = 23 where seqFormulario = " . $arrLinea[0];
                    $aptBd->execute($sql);

                    //throw new Exception("seguimiento");

                }else{
                    throw new Exception("El formulario " . $arrLinea[0] . " no esta en el estado 'Asignación - Asignado'");
                }

            }

            // confirma la transaccion
            $aptBd->CommitTrans();

            // mensaje de ok
            $arrMensajes[] = "Los registros han sido salvados en el sistema";

        }catch( Exception $objError ){
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

    <div class="hero-unit-header" style="background-color: #289bae; color: white; text-align: center">
        Cargue masivo de desembolso<br>para el esquema <strong>Mi casa ya</strong>
    </div>
    <div class="well">
        <form method="post"
              onsubmit="return false;"
              enctype="multipart/form-data"
              id="formcargar"
              class="form-signin"
        >
            <div class="form-group">
                <h4 class="form-signin-heading">Plantilla de datos</h4>
                Ingrese en un archivo de texto los documentos para legalizar<hr>
                <input name="documentos" type="file" id="documentos">
            </div>
            <p align="center">
                <button type="submit"
                        class="btn btn-primary"
                        onClick="someterFormulario(
                            'contenidoLegalizacion',
                            this.form,
                            './contenidos/migracionesIndividual/DesembolsoMiCasaYa/index.php',
                            true,
                            true
                        )"
                >Cargar</button>
                <input type="hidden" name="salvar" value="1">
            </p>
        </form>
    </div>
</div> <!-- /container -->


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

<?php

function sqlDesembolso($arrLinea){

    $arrPlantilla['Formulario']['campo'] = 'seqFormulario';
    $arrPlantilla['Formulario']['orden'] = 0;
    $arrPlantilla['Nombre Vendedor']['campo'] = 'txtNombreVendedor';
    $arrPlantilla['Nombre Vendedor']['orden'] = 1;
    $arrPlantilla['Tipo Documento']['campo'] = 'seqTipoDocumento';
    $arrPlantilla['Tipo Documento']['orden'] = 2;
    $arrPlantilla['Documento Vendedor']['campo'] = 'numDocumentoVendedor';
    $arrPlantilla['Documento Vendedor']['orden'] = 3;
    $arrPlantilla['Teléfono Vendedor']['campo'] = 'numTelefonoVendedor';
    $arrPlantilla['Teléfono Vendedor']['orden'] = 4;
    $arrPlantilla['Teléfono Vendedor 2']['campo'] = 'numTelefonoVendedor2';
    $arrPlantilla['Teléfono Vendedor 2']['orden'] = 5;
    $arrPlantilla['Correo Vendedor']['campo'] = 'txtCorreoVendedor';
    $arrPlantilla['Correo Vendedor']['orden'] = 6;
    $arrPlantilla['Ciudad']['campo'] = 'seqCiudad';
    $arrPlantilla['Ciudad']['orden'] = 8;
    $arrPlantilla['Localidad']['campo'] = 'seqLocalidad';
    $arrPlantilla['Localidad']['orden'] = 9;
    $arrPlantilla['Escritura Antecedente']['campo'] = 'txtEscritura';
    $arrPlantilla['Escritura Antecedente']['orden'] = 11;
    $arrPlantilla['Fecha Escritura Antecedente']['campo'] = 'fchEscritura';
    $arrPlantilla['Fecha Escritura Antecedente']['orden'] = 12;
    $arrPlantilla['Notaria Escritura Antecedente']['campo'] = 'numNotaria';
    $arrPlantilla['Notaria Escritura Antecedente']['orden'] = 13;
    $arrPlantilla['Ciudad Escritura Antecedente']['campo'] = 'txtCiudad';
    $arrPlantilla['Ciudad Escritura Antecedente']['orden'] = 14;
    $arrPlantilla['Matrícula Antecedente']['campo'] = 'txtMatriculaInmobiliaria';
    $arrPlantilla['Matrícula Antecedente']['orden'] = 15;
    $arrPlantilla['CHIP Antecedente']['campo'] = 'txtChip';
    $arrPlantilla['CHIP Antecedente']['orden'] = 16;
    $arrPlantilla['CC Catastral Antecedente']['campo'] = 'txtCedulaCatastral';
    $arrPlantilla['CC Catastral Antecedente']['orden'] = 17;
    $arrPlantilla['Area Lote']['campo'] = 'numAreaLote';
    $arrPlantilla['Area Lote']['orden'] = 24;
    $arrPlantilla['Area Contruida']['campo'] = 'numAreaConstruida';
    $arrPlantilla['Area Contruida']['orden'] = 25;
    $arrPlantilla['Avalúo']['campo'] = 'numAvaluo';
    $arrPlantilla['Avalúo']['orden'] = 26;
    $arrPlantilla['Valor Comercial']['campo'] = 'numValorInmueble';
    $arrPlantilla['Valor Comercial']['orden'] = 27;
    $arrPlantilla['Estrato']['campo'] = 'numEstrato';
    $arrPlantilla['Estrato']['orden'] = 28;

    $arrCampos['bolPoseedor'] = 0;
    $arrCampos['bolViabilizoJuridico'] = 1;
    $arrCampos['bolviabilizoTecnico'] = 1;
    $arrCampos['fchActualizacionBusquedaOferta'] = null;
    $arrCampos['fchActualizacionEscrituracion'] = null;
    $arrCampos['fchCreacionBusquedaOferta'] = date("Y-m-d H:i:s");
    $arrCampos['fchCreacionEscrituracion'] = null;
    $arrCampos['fchResolucion'] = null;
    $arrCampos['fchSentencia'] = null;
    $arrCampos['numActaEntrega'] = null;
    $arrCampos['numAltoRiesgo'] = null;
    $arrCampos['numAperturaCAP'] = null;
    $arrCampos['numAutorizacionDesembolso'] = null;
    $arrCampos['numBoletinCatastral'] = null;
    $arrCampos['numCartaAsignacion'] = null;
    $arrCampos['numCedulaArrendador'] = null;
    $arrCampos['numCertificacionVendedor'] = null;
    $arrCampos['numCertificadoTradicion'] = null;
    $arrCampos['numContratoArrendamiento'] = null;
    $arrCampos['numCuentaArrendador'] = null;
    $arrCampos['numEscrituraPublica'] = null;
    $arrCampos['numFotocopiaVendedor'] = null;
    $arrCampos['numHabitabilidad'] = null;
    $arrCampos['numJuzgado'] = null;
    $arrCampos['numLicenciaConstruccion'] = null;
    $arrCampos['numNit'] = null;
    $arrCampos['numOtros'] = null;
    $arrCampos['numResolucion'] = null;
    $arrCampos['numRetiroRecursos'] = null;
    $arrCampos['numRit'] = null;
    $arrCampos['numRut'] = null;
    $arrCampos['numServiciosPublicos'] = null;
    $arrCampos['numUltimoPredial'] = null;
    $arrCampos['numUltimoReciboAgua'] = null;
    $arrCampos['numUltimoReciboEnergia'] = null;
    $arrCampos['seqAplicacionSubsidio'] = 1;
    $arrCampos['seqFrmulario_Des'] = null;
    $arrCampos['seqProyectosSoluciones'] = 37;
    $arrCampos['txtActaEntrega'] = null;
    $arrCampos['txtAltoRiesgo'] = null;
    $arrCampos['txtAperturaCAP'] = null;
    $arrCampos['txtAutorizacionDesembolso'] = null;
    $arrCampos['txtBoletinCatastral'] = null;
    $arrCampos['txtCartaAsignacion'] = null;
    $arrCampos['txtCedulaArrendador'] = null;
    $arrCampos['txtCertificacionVendedor'] = null;
    $arrCampos['txtCertificadoTradicion'] = null;
    $arrCampos['txtCiudadResolucion'] = null;
    $arrCampos['txtCiudadSentencia'] = null;
    $arrCampos['txtCompraVivienda'] = "nueva";
    $arrCampos['txtContratoArrendamiento'] = null;
    $arrCampos['txtCuentaArrendador'] = null;
    $arrCampos['txtEntidad'] = null;
    $arrCampos['txtEscrituraPublica'] = null;
    $arrCampos['txtFotocopiaVendedor'] = null;
    $arrCampos['txtHabitabilidad'] = null;
    $arrCampos['txtLicenciaConstruccion'] = null;
    $arrCampos['txtNit'] = null;
    $arrCampos['txtOtro'] = null;
    $arrCampos['txtPropiedad'] = null;
    $arrCampos['txtRetiroRecursos'] = null;
    $arrCampos['txtRit'] = null;
    $arrCampos['txtRut'] = null;
    $arrCampos['txtServiciosPublicos'] = null;
    $arrCampos['txtTipoDocumentos'] = null;
    $arrCampos['txtTipoPredio'] = "urbano";
    $arrCampos['txtUltimoPredial'] = null;
    $arrCampos['txtUltimoReciboAgua'] = null;
    $arrCampos['txtUltimoReciboEnergia'] = null;
    $arrCampos['txtViabilizoJuridico'] = null;
    $arrCampos['txtViabilizoTecnico'] = null;
    $arrCampos['valInmueble'] = null;

    $txtDireccion = $arrLinea[7] . " " . $arrLinea[18];
    $txtBarrio = array_shift(
        obtenerDatosTabla(
            "T_FRM_BARRIO",
            array("seqBarrio","txtBarrio"),
            "seqBarrio",
            "seqLocalidad = " . $arrLinea[9] . " and seqBarrio = " . $arrLinea[10]
        )
    );

    $txtCampos = "";
    $txtValores = "";
    foreach($arrPlantilla as $arrCampo) {
        $numColumna = $arrCampo['orden'];
        $txtCampos  .= $arrCampo['campo'] . ",";
        if($arrLinea[$numColumna] == null){
            $txtValores .= "null,";
        }else{
            $txtValores .= "'" . $arrLinea[$numColumna] . "',";
        }
    }

    foreach($arrCampos as $txtCampo => $txtValor) {
        $txtCampos  .= $txtCampo . ",";
        if($txtValor == null){
            $txtValores .= "null,";
        }else{
            $txtValores .= "'" . $txtValor . "',";
        }
    }

    $sql  = "insert into t_des_desembolso (" . $txtCampos . "txtDireccionInmueble,txtBarrio) ";
    $sql .= "values (" . $txtValores . "'" . $txtDireccion . "','" . $txtBarrio . "')";

    return $sql;
}

function sqlEscrituracion($seqDesembolso , $arrLinea){

    $arrRetorno = array(); // adaptacion para hacer los seguimientos desde la clase Seguimiento

    $arrPlantilla['Formulario']['campo'] = 'seqFormulario';
    $arrPlantilla['Formulario']['orden'] = 0;
    $arrPlantilla['Nombre Vendedor']['campo'] = 'txtNombreVendedor';
    $arrPlantilla['Nombre Vendedor']['orden'] = 1;
    $arrPlantilla['Tipo Documento']['campo'] = 'seqTipoDocumento';
    $arrPlantilla['Tipo Documento']['orden'] = 2;
    $arrPlantilla['Documento Vendedor']['campo'] = 'numDocumentoVendedor';
    $arrPlantilla['Documento Vendedor']['orden'] = 3;
    $arrPlantilla['Teléfono Vendedor']['campo'] = 'numTelefonoVendedor';
    $arrPlantilla['Teléfono Vendedor']['orden'] = 4;
    $arrPlantilla['Teléfono Vendedor 2']['campo'] = 'numTelefonoVendedor2';
    $arrPlantilla['Teléfono Vendedor 2']['orden'] = 5;
    $arrPlantilla['Correo Vendedor']['campo'] = 'txtCorreoVendedor';
    $arrPlantilla['Correo Vendedor']['orden'] = 6;
    $arrPlantilla['Ciudad']['campo'] = 'seqCiudad';
    $arrPlantilla['Ciudad']['orden'] = 8;
    $arrPlantilla['Localidad']['campo'] = 'seqLocalidad';
    $arrPlantilla['Localidad']['orden'] = 9;
    $arrPlantilla['Escritura Escrituracion']['campo'] = 'txtEscritura';
    $arrPlantilla['Escritura Escrituracion']['orden'] = 19;
    $arrPlantilla['Fecha Escritura Escrituracion']['campo'] = 'fchEscritura';
    $arrPlantilla['Fecha Escritura Escrituracion']['orden'] = 20;
    $arrPlantilla['Notaria Escritura Escrituracion']['campo'] = 'numNotaria';
    $arrPlantilla['Notaria Escritura Escrituracion']['orden'] = 21;
    $arrPlantilla['Ciudad Escritura Escrituracion']['campo'] = 'txtCiudad';
    $arrPlantilla['Ciudad Escritura Escrituracion']['orden'] = 22;
    $arrPlantilla['Matrícula Escrituración']['campo'] = 'txtMatriculaInmobiliaria';
    $arrPlantilla['Matrícula Escrituración']['orden'] = 23;
    $arrPlantilla['Area Lote']['campo'] = 'numAreaLote';
    $arrPlantilla['Area Lote']['orden'] = 24;
    $arrPlantilla['Area Contruida']['campo'] = 'numAreaConstruida';
    $arrPlantilla['Area Contruida']['orden'] = 25;
    $arrPlantilla['Avalúo']['campo'] = 'numAvaluo';
    $arrPlantilla['Avalúo']['orden'] = 26;
    $arrPlantilla['Valor Comercial']['campo'] = 'numValorInmueble';
    $arrPlantilla['Valor Comercial']['orden'] = 27;
    $arrPlantilla['Estrato']['campo'] = 'numEstrato';
    $arrPlantilla['Estrato']['orden'] = 28;
    $arrPlantilla['Estrato']['campo'] = 'numCartaAsignacion';
    $arrPlantilla['Estrato']['orden'] = 29;

    $arrCampos['seqDesembolso'] = $seqDesembolso;
    $arrCampos['bolPoseedor'] = 0;
    $arrCampos['bolViabilizoJuridico'] = 1;
    $arrCampos['bolviabilizoTecnico'] = 1;
    $arrCampos['fchActualizacionBusquedaOferta'] = null;
    $arrCampos['fchActualizacionEscrituracion'] = null;
    $arrCampos['fchCreacionBusquedaOferta'] = date('Y-m-d H:i:s');
    $arrCampos['fchCreacionEscrituracion'] = date('Y-m-d H:i:s');
    $arrCampos['fchResolucion'] = null;
    $arrCampos['fchSentencia'] = null;
    $arrCampos['numActaEntrega'] = 1;
    $arrCampos['numAltoRiesgo'] = 1;
    $arrCampos['numAperturaCAP'] = null;
    $arrCampos['numAutorizacionDesembolso'] = 1;
    $arrCampos['numBoletinCatastral'] = null;
    $arrCampos['numCedulaArrendador'] = null;
    $arrCampos['numCertificacionVendedor'] = null;
    $arrCampos['numCertificadoTradicion'] = null;
    $arrCampos['numContratoArrendamiento'] = null;
    $arrCampos['numCuentaArrendador'] = null;
    $arrCampos['numEscrituraPublica'] = 1;
    $arrCampos['numFotocopiaVendedor'] = null;
    $arrCampos['numHabitabilidad'] = 1;
    $arrCampos['numJuzgado'] = null;
    $arrCampos['numLicenciaConstruccion'] = 1;
    $arrCampos['numNit'] = null;
    $arrCampos['numOtros'] = null;
    $arrCampos['numResolucion'] = null;
    $arrCampos['numRetiroRecursos'] = null;
    $arrCampos['numRit'] = null;
    $arrCampos['numRut'] = null;
    $arrCampos['numServiciosPublicos'] = null;
    $arrCampos['numUltimoPredial'] = null;
    $arrCampos['numUltimoReciboAgua'] = null;
    $arrCampos['numUltimoReciboEnergia'] = null;
    $arrCampos['seqAplicacionSubsidio'] = 1;
    $arrCampos['seqProyectosSoluciones'] = 37;
    $arrCampos['txtActaEntrega'] = "En la carpeta";
    $arrCampos['txtAltoRiesgo'] = "En la carpeta";
    $arrCampos['txtAperturaCAP'] = null;
    $arrCampos['txtAutorizacionDesembolso'] = "En la carpeta";
    $arrCampos['txtBoletinCatastral'] = null;
    $arrCampos['txtCartaAsignacion'] = "En la carpeta";
    $arrCampos['txtCedulaArrendador'] = null;
    $arrCampos['txtCedulaCatastral'] = null;
    $arrCampos['txtCertificacionVendedor'] = null;
    $arrCampos['txtCertificadoTradicion'] = null;
    $arrCampos['txtChip'] = null;
    $arrCampos['txtCiudadResolucion'] = null;
    $arrCampos['txtCiudadSentencia'] = null;
    $arrCampos['txtCompraVivienda'] = "nueva";
    $arrCampos['txtContratoArrendamiento'] = null;
    $arrCampos['txtCuentaArrendador'] = null;
    $arrCampos['txtEntidad'] = null;
    $arrCampos['txtEscrituraPublica'] = "En la carpeta";
    $arrCampos['txtFotocopiaVendedor'] = null;
    $arrCampos['txtHabitabilidad'] = "En la carpeta";
    $arrCampos['txtLicenciaConstruccion'] = "En la carpeta";
    $arrCampos['txtNit'] = null;
    $arrCampos['txtOtro'] = null;
    $arrCampos['txtPropiedad'] = null;
    $arrCampos['txtRetiroRecursos'] = null;
    $arrCampos['txtRit'] = null;
    $arrCampos['txtRut'] = null;
    $arrCampos['txtServiciosPublicos'] = null;
    $arrCampos['txtTipoDocumentos'] = null;
    $arrCampos['txtTipoPredio'] = "urbano";
    $arrCampos['txtUltimoPredial'] = null;
    $arrCampos['txtUltimoReciboAgua'] = null;
    $arrCampos['txtUltimoReciboEnergia'] = null;
    $arrCampos['txtViabilizoJuridico'] = "En la carpeta";
    $arrCampos['txtViabilizoTecnico'] = "En la carpeta";
    $arrCampos['valInmueble'] = null;

    $txtDireccion = $arrLinea[7] . " " . $arrLinea[18];
    $txtBarrio = array_shift(
        obtenerDatosTabla(
            "T_FRM_BARRIO",
            array("seqBarrio","txtBarrio"),
            "seqBarrio",
            "seqLocalidad = " . $arrLinea[9] . " and seqBarrio = " . $arrLinea[10]
        )
    );

    $txtCampos = "";
    $txtValores = "";
    foreach($arrPlantilla as $arrCampo) {
        $numColumna = $arrCampo['orden'];
        $txtCampos  .= $arrCampo['campo'] . ",";
        if($arrLinea[$numColumna] == null){
            $txtValores .= "null,";
        }else{
            $txtValores .= "'" . $arrLinea[$numColumna] . "',";
        }
        $txtCampo = $arrCampo['campo'];
        $arrRetorno['post'][$txtCampo] = $arrLinea[$numColumna];
    }

    foreach($arrCampos as $txtCampo => $txtValor) {
        $txtCampos  .= $txtCampo . ",";
        if($txtValor == null){
            $txtValores .= "null,";
        }else{
            $txtValores .= "'" . $txtValor . "',";
        }
        $arrRetorno['post'][$txtCampo] = $txtValor;
    }

    $arrRetorno['post']['txtDireccionInmueble'] = $txtDireccion;
    $arrRetorno['post']['txtBarrio'] = $txtBarrio;

    $arrRetorno['sql']  = "insert into t_des_escrituracion (" . $txtCampos . "txtDireccionInmueble,txtBarrio) ";
    $arrRetorno['sql'] .= "values (" . $txtValores . "'" . $txtDireccion . "','" . $txtBarrio . "')";

    return $arrRetorno;
}

?>