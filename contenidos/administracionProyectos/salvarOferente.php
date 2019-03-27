<?php

/**
 * SALVA O EDITA LOS OFERENTES DE LA BASE DE DATOS
 * @author Jaison Ospina
 * @version 0.1 Noviembre 2013
 */
// Posicion relativa de los archivos a incluir
$txtPrefijoRuta = "../../";

// Autenticacion (si esta logueado no no)
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );

// Inclusiones necesarias
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Oferente.class.php" );
//include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']    . "Proyecto.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );

/**
 * Validacion del formulario de oferentes
 */
$arrErrores = array();

// Validacion del nombre del Oferente
if ((!isset($_POST['txtNombreOferente']) ) or trim($_POST['txtNombreOferente']) == "") {
    $arrErrores[] = "Debe diligenciar el nombre del Oferente";
}


// Validacion del Numero de Documento del Oferente
if ((!isset($_POST['numNitOferente']) ) or trim($_POST['numNitOferente']) == "") {
    $arrErrores[] = "Debe diligenciar el N&uacute;mero de Documento del Oferente";
} else {
    if ($_POST['numNitOferente'] <= 0) {
        $arrErrores[] = "El campo N&uacute;mero de Documento del Oferente debe ser mayor que cero";
    }
}

// Validacion del nombre del Representante Legal del Oferente
if ((!isset($_POST['txtRepresentanteLegalOferente']) ) or trim($_POST['txtRepresentanteLegalOferente']) == "") {
    $arrErrores[] = "Debe diligenciar el nombre del  Representante Legal";
}

// Validacion del Numero de Documento del Representante Legal del Oferente
if ((!isset($_POST['numNitRepresentanteLegalOferente']) ) or trim($_POST['numNitRepresentanteLegalOferente']) == "") {
    $arrErrores[] = "Debe diligenciar el N&uacute;mero de Documento del Representante Legal del Oferente";
} else {
    if ($_POST['numNitRepresentanteLegalOferente'] <= 0) {
        $arrErrores[] = "El campo N&uacute;mero de Documento del Representante Legal del Oferente debe ser mayor que cero";
    }
}
/**
 * Salvar o editar Oferentes si no hay errores
 */
if (empty($arrErrores)) {
    $claOferente = new Oferente;
    $claRegistro = new RegistroActividades;
    $claDatosProy = new DatosGeneralesProyectos();

    // Verifica si es para crear o editar la Oferente
    if (isset($_POST['seqOferente']) and is_numeric($_POST['seqOferente']) and $_POST['seqOferente'] > 0) {
        $arrErrores = $claOferente->editarOferente($_POST);
        $arrOferente = $claDatosProy->obtenerDatosOferente($_POST['seqOferente']);
        $txtPlantilla = "proyectos/vistas/inscripcionOferente.tpl";
        //$claRegistro->registrarActividad("Edicion", 0, $_SESSION['seqUsuario'], "Edicion de Oferente: [" . $_POST['seqEditar'] . "] " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    } else {
        $seqOferente = $claOferente->guardarOferente($_POST);
        $arrOferente = $claDatosProy->obtenerDatosOferente($seqOferente);
        $txtPlantilla = "proyectos/vistas/inscripcionOferente.tpl";
        //$claRegistro->registrarActividad("Creacion", 0, $_SESSION['seqUsuario'], "Creacion de Oferente: " . trim($_POST['nombre']) . " Mensaje: " . implode(",", $arrErrores));
    }
}
/**
 * Impresion de resultados
 */
if (empty($arrErrores)) {
    //pr ($arrErrores);
    $arrMensajes[] = "El Oferente <b>" . $_POST['txtNombreOferente'] . "</b> se ha guardado";
    imprimirMensajes(array(), $arrMensajes, "salvarOferente");
    $arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
    $claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
    $claSmarty->assign("arrayOferentes", $arrOferente);
    $claSmarty->assign("page", "datosOferente.php");
    $claSmarty->display($txtPlantilla);
} else {
    imprimirMensajes($arrErrores, array());
}

// Desconecta la base de datos
$aptBd->close();
?>