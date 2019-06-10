<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ActosAdministrativos.class.php" );

// valida el archivo
switch ($_FILES['hogares']['error']) {
    case UPLOAD_ERR_INI_SIZE:
        $arrErrores[] = "El archivo Excede el tamaño permitido";
        break;
    case UPLOAD_ERR_FORM_SIZE:
        $arrErrores[] = "El archivo Excede el tamaño permitido";
        break;
    case UPLOAD_ERR_PARTIAL:
        $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
        break;
    case UPLOAD_ERR_NO_FILE:
        $arrErrores[] = "Debe especificar un archivo para cargar ** ";
        break;
}

// Validaciones del acto administrativo y del formato del archivo	
if (empty($arrErrores)) {

    // validacion del numero del formulario
    if (intval($_POST['numActo']) == 0) {
        $arrErrores[] = "El acto administrativo debe tener un número";
    }

    // Validacion de la fecha del acto administrativo
    if (trim($_POST['fchActo']) != "") {
        list( $ano, $mes, $dia ) = split("-", $_POST['fchActo']);
        if (@checkdate($mes, $dia, $ano) === false) {
            $arrErrores[] = "Debe indicar una fecha valida para el acto administrativo";
        }
    } else {
        $arrErrores[] = "Debe indicar la fecha del acto administrativo";
    }
}

// Valida las caracteristicas del tipo de acto administrativo seleccionado
if (empty($arrErrores)) {

    $claTipoActo = new TipoActoAdministrativo;
    $claActoAdmo = new ActoAdministrativo;
    $claTipoActo->cargarTipoActo($_POST['seqTipoActo']);
    $claTipoActo->validarDatos($_POST['caracteristica']);

    if (!empty($claTipoActo->arrErrores)) {
        $arrErrores = $claTipoActo->arrErrores;
    } else {

        $arrArchivo = $claTipoActo->validarArchivo($_FILES['hogares']['tmp_name']);
        if (!empty($claTipoActo->arrErrores)) {
            $arrErrores = $claTipoActo->arrErrores;
        }
    }

    // Validaciones de Resolucion de Renuncioa
    if ($_POST["seqTipoActo"] == 6 && empty($arrErrores)) {
        $numActo = $_POST['caracteristica'][18];
        $fchActo = $_POST['caracteristica'][19];
        if ($claActoAdmo->tipoActo($numActo, $fchActo) == "Resolución de Asignación") {
            $arrErrores = $claActoAdmo->validarArchivoNotificacion($numActo, $fchActo, $arrArchivo);
        } else {
            $arrErrores[] = "La resolución $numActo del " . formatoFechaTextoFecha($fchActo) . " no es de Asignación";
        }
    }
}

// Salva los datos del acto administrativo
if (empty($arrErrores)) {

    $claActo = new ActoAdministrativo;
    $claActo->seqTipoActo = $_POST['seqTipoActo'];
    $claActo->numActo = $_POST['numActo'];
    $claActo->fchActo = $_POST['fchActo'];
    $claActo->arrCaracteristicas = $_POST['caracteristica'];

    if ($claActo->actoExiste()) {
        $claActo->editarActo();
    } else {
        $claActo->salvarActo();
    }

    // los datos de los hogares vinculados
    $claActo->vincularHogarActo($arrArchivo);

    if (!empty($claActo->arrErrores)) {
        $arrErrores = $claActo->arrErrores;
    } else {
        $arrMensajes[] = "Ha salvado la " . $claTipoActo->txtNombreTipoActo . " " . $claActo->numActo . " del " . $claActo->fchActo;
    }
}

imprimirMensajes($arrErrores, $arrMensajes);
?>
