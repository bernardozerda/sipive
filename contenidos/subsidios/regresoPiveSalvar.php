<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );

//    pr( $_POST );
//    pr( $_FILES );

/**
 * VALIDACIONES 
 * */
$arrErrores = array();
$arrMensajes = array();
$claSeguimiento = new Seguimiento();

// Validar Campos
// Grupo de Gestion 
if ($_POST['seqGrupoGestion'] == 0) {
    $arrErrores[] = "Seleccione el grupo de la gestión realizada";
}

// Gestion
if ($_POST['seqGestion'] == 0) {
    $arrErrores[] = "Seleccione la gestión realizada";
}
// Comentarios
if ($_POST['txtComentario'] == "") {
    $arrErrores[] = "Por favor diligencie el campo de comentarios";
}
if ($_POST['buscaCedula'] == "") {
    $arrErrores[] = "Por favor digite una cedula";
}
if ($_POST['buscaCedulaConfirmacion'] == "") {
    $arrErrores[] = "Por favor Confirme el numero de cedula";
}

if ($_POST['buscaCedulaConfirmacion'] != $_POST['buscaCedula']) {
    $arrErrores[] = "Por favor Confirme que el numero de cedula conincidad en el campo de confirmacion";
}


// construccion del arreglo a procesar
$arrArchivo = array();


if (empty($arrErrores)) {
    // fin validacion de lineas
    $claFormulario = new FormularioSubsidios();

    $numDocumento = str_replace(".", "", $_POST['buscaCedula']);
    $seqFormulario = $claFormulario->obtenerFormulario($numDocumento);
    $claFormularioActual = new FormularioSubsidios();
    $claFormularioActual->cargarFormulario($seqFormulario);
    $claFormulario->cargarFormulario($seqFormulario);
    $texto = str_replace(" ", "", $claSeguimiento->validarSeguimientoPive($seqFormulario));
    $characters = array("[", "]", "<b>", "</b>");
    $arrayTexto = explode("<br>", $texto);

    if ($texto != '' && $claFormularioActual->bolCerrado != 1) {
        $arrTextoForm = str_replace("Cambiosenelformulario", "", $arrayTexto[0]);
        //$seqFormulario = str_replace($characters, '', trim($arrTextoForm));

        $validarPlanGobierno = $claFormularioActual->seqPlanGobierno;

        if ($validarPlanGobierno != 3) {
            $arrEstadoProceso = str_replace("seqEstadoProceso,", "", $arrayTexto[1]);
            $arrSeqPlanGobierno = str_replace("seqPlanGobierno,", "", $arrayTexto[2]);
            $arrSeqModalidad = str_replace("seqModalidad,", "", $arrayTexto[3]);
            $arrSeqTipoEsquema = str_replace("seqTipoEsquema,", "", $arrayTexto[4]);

            $seqEstadoProcesoAnt = str_replace("ValorAnterior:", "", explode(",", $arrEstadoProceso)[0]);
            $seqEstadoProcesoNew = str_replace("ValorNuevo:", "", explode(",", $arrEstadoProceso)[1]);

            $seqPlanGobiernoAnt = str_replace("ValorAnterior:", "", explode(",", $arrSeqPlanGobierno)[0]);
            $seqPlanGobiernoNew = str_replace("ValorNuevo:", "", explode(",", $arrSeqPlanGobierno)[1]);

            $seqModalidadAnt = str_replace("ValorAnterior:", "", explode(",", $arrSeqModalidad)[0]);
            $seqoModalidadNew = str_replace("ValorNuevo:", "", explode(",", $arrSeqModalidad)[1]);

            $seqTipoEsquemaAnt = str_replace("ValorAnterior:", "", explode(",", $arrSeqTipoEsquema)[0]);
            $seqTipoEsquemaNew = str_replace("ValorNuevo:", "", explode(",", $arrSeqTipoEsquema)[1]);

            $claFormulario->seqEstadoProceso = $seqEstadoProcesoAnt;
            $claFormulario->seqPlanGobierno = $seqPlanGobiernoAnt;
            $claFormulario->seqModalidad = $seqModalidadAnt;
            $claFormulario->seqTipoEsquema = $seqTipoEsquemaAnt;
            $claFormulario->editarFormulario($seqFormulario);
            if (empty($claFormulario->arrErrores)) {


                $txtNombre = "";
                foreach ($claFormulario->arrCiudadano as $seqCiudadano => $claCiudadano) {
                    if ($claCiudadano->numDocumento == $numDocumento) {
                        $txtNombre = $claCiudadano->txtNombre1 . " " . $claCiudadano->txtNombre2 .
                                $claCiudadano->txtApellido1 . " " . $claCiudadano->txtApellido2;
                    }
                }
                $claSeguimiento = new Seguimiento();
                $txtCambios = $claSeguimiento->cambiosCambioEstados($seqFormulario, $claFormularioActual, $claFormulario);
                global $aptBd;
                $sql = "INSERT INTO T_SEG_SEGUIMIENTO (
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
                            '" . date("Y-m-d H:i:s") . "',
                            " . $_SESSION['seqUsuario'] . ",
                            \"Cambio desde el menu Formulario -> Regreso a Pive:<br>" . $_POST['txtComentario'] . "\",
                            \"" . ereg_replace("\"", "", $txtCambios) . "\",
                            " . intval($buscaCedulaFormat) . ",
                            \"$txtNombre\",
                            " . $_POST['seqGestion'] . "
                    )";

                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido registrar el seguimiento del formulario";
                }

                $numModificados++;
            }
        } else {
            $arrErrores[] = "El Documento registrado se encuentra actualmente en plan de gobierno Bogota Mejor Para Todos, para las modalidades de PIVE";
        }
    } else {

        $arrErrores[] = "El Documento Consultado no fue objeto de aplicacion de la Resolucion 182 del 2018, por tanto no aplica regreso de estado a modalidades de PIVE. O se encuentra Cerrado";
        //imprimirMensajes($arrErrores, $arrMensajes, $txtDivListener);
    }
}
if (empty($arrErrores)) {
    $arrMensajes[] = "Se realizo los cambios correctamente";
    $txtDivListener = "salvarProyecto";
}

imprimirMensajes($arrErrores, $arrMensajes, $txtDivListener);
//$claSmarty->display("subsidios/cambioPive.tpl");
?>