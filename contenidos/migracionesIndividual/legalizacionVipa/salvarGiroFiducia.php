<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( $txtPrefijoRuta . "librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( $txtPrefijoRuta . "librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

$arrErrores = array();
$arrMensajes = array();

/******************************************************************************************************************
 * validaciones del formulario
 ******************************************************************************************************************/

if($_POST['proyecto'] == 0){
    $arrErrores[] = "Seleccione el proyecto de inversión";
}

if($_POST['nombre'] == ""){
    $arrErrores[] = "Digite el nombre del beneficiario del giro";
}

if(doubleval($_POST['documento']) == 0){
    $arrErrores[] = "Digite el documento del beneficiario del giro";
}

if($_POST['direccion'] == ""){
    $arrErrores[] = "Digite la dirección del beneficiario del giro";
}

if($_POST['telefono'] == ""){
    $arrErrores[] = "Digite el telefono del beneficiario del giro";
}

if($_POST['correo'] == ""){
    $arrErrores[] = "Digite el correo del beneficiario del giro";
}

if($_POST['cuenta'] == ""){
    $arrErrores[] = "Digite el numero de cuenta del beneficiario del gro";
}

if($_POST['tipo'] == ""){
    $arrErrores[] = "Seleccione el tipo de cuenta del beneficiario del giro";
}

if($_POST['banco'] == 0){
    $arrErrores[] = "Seleccione el banco del beneficiario del giro";
}

//if(intval($_POST['radicado']) == 0){
//    $arrErrores[] = "Indique el número de radicado de la solicitud";
//}
//
//if(! esFechaValida($_POST['fechaRadicado'])){
//    $arrErrores[] = "Indique la fecha de radicado de la solicitud";
//}
//
//if(intval($_POST['orden']) == 0){
//    $arrErrores[] = "Indique el número de orden de la solicitud";
//}
//
//if(! esFechaValida($_POST['fechaOrden'])){
//    $arrErrores[] = "Indique la fecha de orden de la solicitud";
//}

if(trim($_POST['txtSubsecretaria']) == "" and trim($_POST['txtSubdireccion']) == ""){
    $arrErrores[] = "Indique el nombre del Subsecretario(a) o Subdirector(a)";
}

if(trim($_POST['txtRevisoSubsecretaria']) == ""){
    $arrErrores[] = "Indique el nombre de quien revisó";
}

$_POST['documentos']['bolCedulaBeneficiario']     = intval($_POST['documentos']['bolCedulaBeneficiario']);
$_POST['documentos']['bolRut']                    = intval($_POST['documentos']['bolRut']);
$_POST['documentos']['bolCedulaRepresentante']    = intval($_POST['documentos']['bolCedulaRepresentante']);
$_POST['documentos']['bolCamaraComercio']         = intval($_POST['documentos']['bolCamaraComercio']);
$_POST['documentos']['bolCartaAsignacion']        = intval($_POST['documentos']['bolCartaAsignacion']);
$_POST['documentos']['bolGiroTercero']            = intval($_POST['documentos']['bolGiroTercero']);
$_POST['documentos']['bolCertificacionBancaria']  = intval($_POST['documentos']['bolCertificacionBancaria']);
$_POST['documentos']['bolAutorizacion']           = intval($_POST['documentos']['bolAutorizacion']);
$_POST['bolSubsecretariaEncargado']               = intval($_POST['bolSubsecretariaEncargado']);
$_POST['bolSubdireccionEncargado']                = intval($_POST['bolSubdireccionEncargado']);

$numDocumentos =
    $_POST['documentos']['bolCedulaBeneficiario']    +
    $_POST['documentos']['bolRut']                   +
    $_POST['documentos']['bolCedulaRepresentante']   +
    $_POST['documentos']['bolCamaraComercio']        +
    $_POST['documentos']['bolCartaAsignacion']       +
    $_POST['documentos']['bolGiroTercero']           +
    $_POST['documentos']['bolCertificacionBancaria'] +
    $_POST['documentos']['bolAutorizacion'];

if($numDocumentos == 0){
    $arrErrores[] = "Seleccione los documentos que se han recibido para la solicitud";
}

/******************************************************************************************************************
 * validaciones del archivo
 ******************************************************************************************************************/

switch ($_FILES['archivo']['error']) {
    case UPLOAD_ERR_INI_SIZE:
        $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
        break;
    case UPLOAD_ERR_FORM_SIZE:
        $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
        break;
    case UPLOAD_ERR_PARTIAL:
        $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
        break;
    case UPLOAD_ERR_NO_FILE:
        $arrErrores[] = "Debe especificar un archivo para cargar";
        break;
    case UPLOAD_ERR_NO_TMP_DIR:
        $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo cargar por falta de carpeta temporal, contacte al administrador";
        break;
    case UPLOAD_ERR_CANT_WRITE:
        $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor, contacte al administrador";
        break;
    case UPLOAD_ERR_EXTENSION:
        $arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no se pudo guardar en el servidor por un problema de extensiones, contacte al administrador";
        break;
    default:
        $numPunto = strpos($_FILES['archivo']['name'], ".") + 1;
        $numRestar = ( strlen($_FILES['archivo']['name']) - $numPunto ) * -1;
        $txtExtension = substr($_FILES['archivo']['name'], $numRestar);
        if (!in_array(strtolower($txtExtension),array("txt"))) {
            $arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
        }
        break;
}

$aptBd->BeginTrans();

// recoger el archivo
if(empty($arrErrores)){

    $arrArchivo = array();
    foreach( file( $_FILES['archivo']['tmp_name'] ) as $numLinea => $txtLinea ){
        if( trim( $txtLinea ) != "" ) {
            $arrArchivo[$numLinea] = explode("\t", trim(utf8_encode($txtLinea)));
        }
    }

    // validacion de titulos
    $arrFormatoArchivo[] = "Identificador";
    $arrFormatoArchivo[] = "Documento";
    $arrFormatoArchivo[] = "Nombre";
    $arrFormatoArchivo[] = "Proyecto";
    $arrFormatoArchivo[] = "Valor Disponible";
    $arrFormatoArchivo[] = "Valor solicitado";
    $arrFormatoArchivo[] = "Valor de orden de pago";
    $arrFormatoArchivo[] = "Numero RP";
    $arrFormatoArchivo[] = "Fecha RP";

    foreach($arrFormatoArchivo as $i => $txtTitulo){
        if(mb_strtolower($arrArchivo[0][$i]) != mb_strtolower($txtTitulo) ){
            $arrErrores[] = "La columna " . $txtTitulo . " no se encuentra o no está en el lugar correcto";
        }
    }

    // validacion del contenido
    if(empty($arrErrores)) {
        unset($arrArchivo[0]);
        foreach ($arrArchivo as $numLinea => $arrLinea) {

            $seqFormulario = intval($arrLinea[0]);
            $numDocumento  = doubleval($arrLinea[1]);
            $txtNombre     = trim($arrLinea[2]);
            $valDisponible = doubleval(mb_ereg_replace("[^0-9]","", $arrLinea[4]));
            $valSolicitado = doubleval(mb_ereg_replace("[^0-9]","", $arrLinea[5]));
            $valOrden      = doubleval(mb_ereg_replace("[^0-9]","", $arrLinea[6]));
            $numRegistro   = intval($arrLinea[7]);
            $fchRegistro   = (esFechaValida($arrLinea[8])) ? $arrLinea[8] : null;

            // saldo segun la base de datos
            $sql = "
                select 
                  frm.seqFormulario,
                  (frm.valAspiraSubsidio - if(sol.valSolicitado is null,0,sol.valSolicitado) ) as valSaldo
                from t_frm_formulario frm
                left join (
                    select
                        seqFormulario,
                        max(seqDesembolso) as seqDesembolso
                    from t_des_desembolso
                    where seqFormulario = $seqFormulario
                    group by seqFormulario
                ) des on frm.seqFormulario = des.seqFormulario
                left join (
                    select 
                        sol.seqDesembolso,
                        sum(sol.valSolicitado) as valSolicitado
                    from t_des_solicitud sol
                    inner join(
                        select
                            seqFormulario,
                            max(seqDesembolso) as seqDesembolso
                        from t_des_desembolso
                        where seqFormulario = $seqFormulario
                        group by seqFormulario
                    ) des on sol.seqDesembolso = des.seqDesembolso
                    group by des.seqDesembolso
                ) sol on des.seqDesembolso = sol.seqDesembolso
                where frm.seqFormulario = $seqFormulario
            ";
            $objRes = $aptBd->execute($sql);
            $valSaldo = doubleval($objRes->fields['valSaldo']);

            // validacion del formulario
            if ($seqFormulario == 0) {
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El identificador no es válido";
            } else {
                $arrEsquema = obtenerDatosTabla(
                    "t_frm_formulario",
                    array("seqFormulario", "seqModalidad", "seqPlanGobierno", "seqTipoEsquema"),
                    "seqFormulario",
                    "seqFormulario = " . $seqFormulario
                );
                if(
                    $arrEsquema[$seqFormulario]['seqModalidad']    != 12 or
                    $arrEsquema[$seqFormulario]['seqPlanGobierno'] != 3  or
                    $arrEsquema[$seqFormulario]['seqTipoEsquema']  != 12
                ){
                    $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El hogar no pertenece al esquema VIPA, plan de gobierno o modalidad de cierre financiero";
                }
            }

            // validacion de documento
            if($numDocumento == 0){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El documento no es válido";
            }else{
                $claCiudadano = new Ciudadano();
                $seqFormularioVinculado = $claCiudadano->formularioVinculado($numDocumento);
                if($seqFormulario != $seqFormularioVinculado){
                    $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El documento no pertenece al hogar del formulario $seqFormulario";
                }
            }

            // validacion del nombre
            if($txtNombre == ""){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El nombre no es válido";
            }else{
                $txtNombreCiudadano = array_shift(
                        obtenerDatosTabla(
                        "t_ciu_ciudadano",
                        array("numDocumento","concat(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) as txtNombre"),
                        "numDocumento",
                        "numDocumento = $numDocumento and seqTipoDocumento in (1,2)"
                    )
                );
                if(mb_strtolower($txtNombre) != mb_strtolower(trim($txtNombreCiudadano))){
                    $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El nombre no coincide con el numero del documento";
                }
            }

            // valor disponible
            if($valDisponible == 0){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": No puede modificar el valor disponible";
            }

            // valor solicitado
            if($valSolicitado == 0){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor solicitado no puede ser cero";
            }elseif($valDisponible < $valSolicitado){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor solicitado no puede ser superior al valor disponible";
            }

            // valor orden de pago
            if($valOrden == 0){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la orden no puede ser cero";
            }elseif($valSolicitado < $valOrden){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor de la orden no puede ser superior al valor solicitado";
            }

            // saldo del giro
            if($valSolicitado > $valSaldo){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor solicitado supera el valor disponible para girar";
            }

            // numero de rp
            if($numRegistro == 0){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": Debe dar el numero del RP";
            }

            // fecha del RP
            if($fchRegistro == null){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": Debe dar la fecha del RP";
            }


            if(empty($arrErrores)){

                try{

                    $sql = "select max(seqDesembolso) as seqDesembolso from t_des_desembolso where seqFormulario = $seqFormulario";
                    $objRes = $aptBd->execute($sql);
                    $seqDesembolso = intval($objRes->fields['seqDesembolso']);

                    $numAno2Digitos = date("y");

                    $sql = "
                        insert into t_des_solicitud (
                            numRegistroPresupuestal1, 
                            fchRegistroPresupuestal1, 
                            numRegistroPresupuestal2, 
                            fchRegistroPresupuestal2, 
                            valSolicitado, 
                            bolDocumentoBeneficiario, 
                            txtDocumentoBeneficiario, 
                            bolDocumentoVendedor, 
                            txtDocumentoVendedor, 
                            bolCertificacionBancaria, 
                            txtCertificacionBancaria, 
                            bolCartaAsignacion, 
                            txtCartaAsignacion, 
                            bolAutorizacion, 
                            txtAutorizacion, 
                            txtSubsecretaria, 
                            bolSubsecretariaEncargado, 
                            txtSubdireccion, 
                            bolSubdireccionEncargado, 
                            txtRevisoSubsecretaria, 
                            txtElaboroSubsecretaria, 
                            numRadiacion, 
                            fchRadicacion, 
                            numOrden, 
                            fchOrden, 
                            valOrden, 
                            seqDesembolso, 
                            txtConsecutivo, 
                            numProyectoInversion, 
                            txtNombreBeneficiarioGiro, 
                            numDocumentoBeneficiarioGiro, 
                            txtDireccionBeneficiarioGiro, 
                            numTelefonoGiro, 
                            numCuentaGiro, 
                            txtTipoCuentaGiro, 
                            seqBancoGiro, 
                            fchCreacion, 
                            fchActualizacion, 
                            bolRut, 
                            txtRut, 
                            bolNit, 
                            txtNit, 
                            bolCedulaRepresentante, 
                            txtCedulaRepresentante, 
                            bolCamaraComercio, 
                            txtCamaraComercio, 
                            bolGiroTercero, 
                            txtGiroTercero, 
                            bolBancoArrendador, 
                            txtBancoArrendador, 
                            bolActaEntregaFisica, 
                            txtActaEntregaFisica, 
                            bolActaLiquidacion, 
                            txtActaLiquidacion, 
                            txtCorreoGiro, 
                            bolCertificacionManejoRecursos, 
                            txtCertificacionManejoRecursos, 
                            bolSuperintendencia, 
                            txtSuperIntendencia, 
                            bolRutBanco, 
                            txtRutBanco
                        ) values (    
                            $numRegistro, 
                            '$fchRegistro', 
                            null, 
                            null, 
                            $valSolicitado, 
                            " . $_POST['documentos']['bolCedulaBeneficiario'] . ", 
                            '" . $_POST['documentos']['txtCedulaBeneficiario'] . "', 
                            null, 
                            null, 
                            " . $_POST['documentos']['bolCertificacionBancaria'] . ", 
                            '" . $_POST['documentos']['txtCertificacionBancaria'] . "', 
                            " . $_POST['documentos']['bolCartaAsignacion'] . ", 
                            '" . $_POST['documentos']['txtCartaAsignacion'] . "', 
                            " . $_POST['documentos']['bolAutorizacion'] . ", 
                            '" . $_POST['documentos']['txtAutorizacion'] . "', 
                            '" . $_POST['txtSubsecretaria'] . "',  
                            " . $_POST['bolSubsecretariaEncargado'] . ",
                            '" . $_POST['txtSubdireccion'] . "',  
                            " . $_POST['bolSubdireccionEncargado'] . ", 
                            '" . $_POST['txtRevisoSubsecretaria'] . "', 
                            '" . $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] . "', 
                            " . $_POST['radicado'] . ", 
                            '" . $_POST['fechaRadicado'] . "', 
                            " . $_POST['orden'] . ", 
                            '" . $_POST['fechaOrden'] . "', 
                            $valOrden, 
                            $seqDesembolso, 
                            'SDHT-SGF-SDRPL-$seqFormulario-$numAno2Digitos', 
                            " . $_POST['proyecto'] . ", 
                            '" . $_POST['nombre'] . "', 
                            " . $_POST['documento'] . ", 
                            '" . $_POST['direccion'] . "', 
                            " . $_POST['telefono'] . ",
                            " . $_POST['cuenta'] . ", 
                            '" . $_POST['tipo'] . "',
                            " . $_POST['banco'] . ",
                            now(), 
                            now(), 
                            " . $_POST['documentos']['bolRut'] . ", 
                            '" . $_POST['documentos']['txtRut'] . "', 
                            null, 
                            null, 
                            " . $_POST['documentos']['bolCedulaRepresentante'] . ", 
                            '" . $_POST['documentos']['txtCedulaRepresentante'] . "', 
                            " . $_POST['documentos']['bolCamaraComercio'] . ", 
                            '" . $_POST['documentos']['txtCamaraComercio'] . "', 
                            " . $_POST['documentos']['bolGiroTercero'] . ", 
                            '" . $_POST['documentos']['txtGiroTercero'] . "', 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            '" . $_POST['correo'] . "', 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null
                        )             
                    ";
                    $aptBd->execute($sql);
                    $seqSolicitud = $aptBd->Insert_ID();

                    $sql = "
                        select max(fac.seqFormularioActo) as seqFormularioActo
                        from t_aad_formulario_acto fac
                        inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
                        where fac.seqFormulario = $seqFormulario
                          and hvi.seqTipoActo = 1            
                    ";
                    $objRes = $aptBd->execute($sql);
                    $seqFormularioActo = $objRes->fields['seqFormularioActo'];

                    $sql = "
                        insert into t_aad_giro (
                            seqFormularioActo, 
                            seqSolicitud, 
                            numRegistroPresupuestal1, 
                            fchRegistroPresupuestal1, 
                            numRegistroPresupuestal2, 
                            fchRegistroPresupuestal2, 
                            valSolicitado, 
                            numRadiacion, 
                            fchRadicacion, 
                            numOrden, 
                            fchOrden, 
                            valOrden, 
                            numProyectoInversion, 
                            txtNombreBeneficiarioGiro, 
                            numDocumentoBeneficiarioGiro, 
                            txtDireccionBeneficiarioGiro, 
                            numTelefonoGiro, 
                            numCuentaGiro, 
                            txtTipoCuentaGiro, 
                            seqBancoGiro, 
                            fchCreacion, 
                            fchActualizacion, 
                            bolGiroTercero, 
                            txtGiroTercero, 
                            txtCorreoGiro
                        ) values (
                            $seqFormularioActo,
                            $seqSolicitud,
                            $numRegistro, 
                            '$fchRegistro', 
                            null, 
                            null,
                            $valSolicitado, 
                            " . $_POST['radicado'] . ", 
                            '" . $_POST['fechaRadicado'] . "', 
                            " . $_POST['orden'] . ", 
                            '" . $_POST['fechaOrden'] . "', 
                            $valOrden, 
                            " . $_POST['proyecto'] . ", 
                            '" . $_POST['nombre'] . "', 
                            " . $_POST['documento'] . ", 
                            '" . $_POST['direccion'] . "', 
                            " . $_POST['telefono'] . ",
                            " . $_POST['cuenta'] . ", 
                            '" . $_POST['tipo'] . "',
                            " . $_POST['banco'] . ",
                            now(), 
                            now(),  
                            " . $_POST['documentos']['bolGiroTercero'] . ", 
                            '" . $_POST['documentos']['txtGiroTercero'] . "', 
                            '" . $_POST['correo'] . "'
                        )            
                    ";
                    $aptBd->execute($sql);

                    $sql = "
                        insert into t_seg_seguimiento (
                            seqFormulario,
                            fchMovimiento,
                            seqUsuario,
                            txtComentario,
                            txtCambios,
                            numDocumento,
                            txtNombre,
                            seqGestion
                        ) VALUES (
                            $seqFormulario,
                            now(),
                            ". $_SESSION['seqUsuario'] .",
                            'Se ha radicado el desembolso a la fiducia de los recursos de la unidad',
                            '',
                            ". $numDocumento .",
                            '". $txtNombre ."',
                            45
                        )	
                    ";
                    $aptBd->execute($sql);

                    $arrLinks[$seqFormulario]['documento'] = $numDocumento;
                    $arrLinks[$seqFormulario]['link']      = $_SERVER['HTTP_ORIGIN'] . "/sipive/contenidos/desembolso/formatoSolicitudDesembolso.php?seqFormulario=$seqFormulario&seqSolicitud=$seqSolicitud";

                }catch (Exception $objError){
                    $arrErrores[] = "Error linea " . ($numLinea + 1) . ": Problemas al insertar el registro <hr>" . $objError->getMessage() . "<hr>";
                }
            }
        }
    }

}

if(empty($arrErrores)){
    $aptBd->CommitTrans();
}else{
    $aptBd->RollBackTrans();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<div id="contenidos" class="container-fluid" style="width: 650px;">

    <div class="alert" style="background-color: #289bae; color: white; text-align: center">
        <h4>
            GIRO DE RECURSOS A FIDUCIARIA<br>
            <strong>Complementariedad VIPA</strong>
        </h4>
    </div>

    <div class="well">
        <?php

        if(! empty($arrErrores)){
            echo "<div class='alert alert-danger text-left' role='alert'>";
            foreach($arrErrores as $txtError) {
                echo "<li>$txtError</li>";
            }
            echo "</div>";
        }elseif(! empty($arrLinks)){ ?>

            <table class="table table-bordered" width="200px">
                <thead>
                    <tr>
                        <th>Formulario</th>
                        <th>Documento</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($arrLinks as $seqFormulario => $arrEnlace){
                            echo "<tr>";
                            echo "<td>$seqFormulario</td>";
                            echo "<td>" . $arrEnlace['documento'] . "</td>";
                            echo "<td><a href='" . $arrEnlace['link'] . "'>" . $arrEnlace['link'] . "</a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        <?php
        } ?>

    </div>

    <div class="well">
        <button type="submit"
                class="btn btn-default"
                onclick="cambiarOpcionLegalizacion(
                           'contenidoLegalizacion',
                           'contenidos/migracionesIndividual/legalizacionVipa/giroFiducia.php'
                       );"
        >Volver</button>
    </div>

</div>