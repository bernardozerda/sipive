<?php

$txtPrefijoRuta = "../../../";
$txtTipoGiro = "giroConstructor";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
include ( $txtPrefijoRuta . "contenidos/migracionesIndividual/legalizacionVipa/configuracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( $txtPrefijoRuta . "librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( $txtPrefijoRuta . "librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

$arrErrores = array();
$arrMensajes = array();

$arrEstados = estadosProceso();

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
if(empty($arrErrores)) {

    $arrArchivo = array();
    foreach (file($_FILES['archivo']['tmp_name']) as $numLinea => $txtLinea) {
        if (trim($txtLinea) != "") {
            $arrArchivo[$numLinea] = explode("\t", trim(utf8_encode($txtLinea)));
        }
    }

    // validacion de titulos
    $arrFormatoArchivo[] = "Identificador";
    $arrFormatoArchivo[] = "Número de Documento";
    $arrFormatoArchivo[] = "Nombre";
    $arrFormatoArchivo[] = "Valor Disponible";
    $arrFormatoArchivo[] = "Valor Giro";

    foreach ($arrFormatoArchivo as $i => $txtTitulo) {
        if (mb_strtolower($arrArchivo[0][$i]) != mb_strtolower($txtTitulo)) {
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
            $valDisponible = doubleval(mb_ereg_replace("[^0-9]", "", $arrLinea[3]));
            $valGiro       = doubleval(mb_ereg_replace("[^0-9]", "", $arrLinea[4]));

            // saldo en la base de datos
            $sql = "
                select
                  frm.seqFormulario,
                  ciu.numDocumento,
                  frm.seqEstadoProceso,
                  frm.valAspiraSubsidio,
                  upper( concat( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtNombre2 ) ) as txtNombre,
                  sol.valSolicitado,
                  sol.valOrden
                from t_frm_formulario frm
                inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
                inner join t_ciu_ciudadano ciu on ciu.seqCiudadano = hog.seqCiudadano
                inner join (
                    select 
                        seqFormulario, 
                        max(seqDesembolso) as seqDesembolso
                    from t_des_desembolso 
                    where seqFormulario = $seqFormulario
                    group by seqFormulario
                ) des on frm.seqFormulario = des.seqFormulario
                inner join t_des_solicitud sol on des.seqDesembolso = sol.seqDesembolso
                where frm.seqFormulario = $seqFormulario
            ";
            $objRes = $aptBd->execute($sql);
            $valSaldo = 0;
            $valAcumuladoGirosConstructor = 0;
            while($objRes->fields){
                $valSolicitado = $objRes->fields['valSolicitado'];
                $valOrden = $objRes->fields['valOrden'];
                $seqEstadoProceso = $objRes->fields['seqEstadoProceso'];
                $valAspiraSubsidio = $objRes->fields['valAspiraSubsidio'];
                if ($valSolicitado != 0) {
                    $valSaldo += $valSolicitado;
                } else {
                    $valSaldo -= $valOrden;
                    $valAcumuladoGirosConstructor += $valOrden;
                }
                $objRes->MoveNext();
            }

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
                if(! in_array($seqEstadoProceso,$arrVariables['giroConstructor']['estados'])){
                    $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El hogar esta en el estado del proceso correcto";
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

            // valor disponible
            if($valGiro == 0){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor del giro no es válido";
            }

            // saldo del giro
            if($valGiro > $valSaldo){
                $arrErrores[] = "Error linea " . ($numLinea + 1) . ": El valor solicitado supera el valor disponible para girar";
            }

            if(empty($arrErrores)) {

                try {

                    $sql = "select max(seqDesembolso) as seqDesembolso from t_des_desembolso where seqFormulario = $seqFormulario";
                    $objRes = $aptBd->execute($sql);
                    $seqDesembolso = intval($objRes->fields['seqDesembolso']);

                    $sql = "
                        select 
                            esc.txtNombreVendedor,
                            esc.numDocumentoVendedor,
                            if(esc.numTelefonoVendedor <> '', esc.numTelefonoVendedor, esc.numTelefonoVendedor2) as numTelefonoVendedor,
                            esc.txtCorreoVendedor
                        from t_des_escrituracion esc
                        where esc.seqDesembolso = $seqDesembolso
                    ";
                    $objRes = $aptBd->execute($sql);

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
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null,  
                            null,
                            null,  
                            null, 
                            null, 
                            '" . $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido'] . "', 
                            null, 
                            null, 
                            null, 
                            null, 
                            $valGiro, 
                            $seqDesembolso, 
                            null, 
                            null, 
                            '" . $objRes->fields['txtNombreVendedor'] . "', 
                            " . $objRes->fields['numDocumentoVendedor'] . ", 
                            null, 
                            " . $objRes->fields['numTelefonoVendedor'] . ",
                            null, 
                            null,
                            null,
                            now(), 
                            now(), 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            '" . $objRes->fields['txtCorreoVendedor'] . "', 
                            null, 
                            null, 
                            null, 
                            null, 
                            null, 
                            null
                        )             
                    ";
                    $aptBd->execute($sql);

                    $txtCambios = "";
                    if(($valAcumuladoGirosConstructor + $valGiro) == $valAspiraSubsidio){
                        $sql = "update t_frm_formulario set seqEstadoProceso = 40 where seqFormulario = " . $seqFormulario;
                        $aptBd->execute($sql);
                        $txtCambios  = "<b>[ $seqFormulario ] Cambios del Formulario:</b><br>";
                        $txtCambios .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Estado del Proceso, Valor Anterior:" . $arrEstados[$seqEstadoProceso] . ", Valor Nuevo: " . $arrEstados[40] . "</b>";
                    }

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
                            'Se ha radicado el desembolso a la constructora de los recursos de la unidad',
                            '$txtCambios',
                            ". $numDocumento .",
                            '". $txtNombre ."',
                            45
                        )	
                    ";
                    $aptBd->execute($sql);

                } catch (Exception $objError) {
                    $arrErrores[] = "Error linea " . ($numLinea + 1) . ": Problemas al insertar el registro <hr>" . $objError->getMessage() . "<hr>";
                }

            }
        }

        $arrMensajes[] = "Procesados " . count($arrArchivo) . " registros satisfactoriamente";
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
            GIRO DE RECURSOS A CONSTRUCTOR<br>
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
            }else{
                echo "<div class='alert alert-success text-left' role='alert' style='font-size: 12px;'>";
                foreach($arrMensajes as $txtMensaje) {
                    echo "<li>$txtMensaje</li>";
                }
                echo "</div>";
            }
        ?>
    </div>

    <div class="well">
        <button type="submit"
                class="btn btn-default"
                onclick="cambiarOpcionLegalizacion(
                           'contenidoLegalizacion',
                           'contenidos/migracionesIndividual/legalizacionVipa/giroConstructor.php'
                       );"
        >Volver</button>
    </div>

</div>
