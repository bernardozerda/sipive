<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "aad.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

// para los mensajes de exito al final
$arrMensajes = array();
$claActo = new aad();
$claTipoActo = new aadTipo();

// carga los tipos de actos a salvar
$arrTipoActo = $claTipoActo->cargarTipoActo();

if ($_SESSION['privilegios']['crear'] != 1) {
    $arrErrores[] = "No tiene privilegios para crear actos administrativos";
}

if (empty($arrErrores)) {

    // limpieza de caracteres
    foreach ($_POST as $txtClave => $txtValor) {
        $_POST[$txtClave] = regularizarCampo($txtClave, $txtValor);
    }

    // carga el tipo de acto a salvar
    $seqTipoActo = $_POST['seqTipoActo'];
    // echo "paso => ".$seqTipoActo;
    $claTipoActo = array_shift($claTipoActo->cargarTipoActo($arrTipoActo[$seqTipoActo]->seqTipoActo));

    // valida los datos del formulario
    $claActo->validarFormulario($_POST);

    if (empty($claActo->arrErrores)) {

        // carga el acto administrativo para
        // saber si existe y proceder si no
        $arrActos = $claActo->listarActos($_POST['seqTipoActo'], $_POST['numActo'], $_POST['fchActo']);

        if (empty($arrActos)) {

            // abre el archivo y lo carga en un arreglo
            if ($seqTipoActo != 12)
                $arrArchivo = $claTipoActo->cargarArchivo();

            // si hay errores
            if (empty($claTipoActo->arrErrores)) {

                if ($seqTipoActo != 12)
                    $claTipoActo->validarTitulos($arrArchivo[0]);

                if (empty($claTipoActo->arrErrores)) {

                    if ($seqTipoActo != 12)
                        $claTipoActo->validarDatos($arrArchivo);

                    if (empty($claTipoActo->arrErrores)) {

                        $claActo->salvar($_POST, $arrArchivo);                       

                        if (empty($claActo->arrErrores)) {
                            $arrMensajes = $claActo->arrMensajes;
                        } else {
                            $arrErrores = $claActo->arrErrores;
                        }
                    } else {
                        $arrErrores = $claTipoActo->arrErrores;
                    }
                } else {
                    $arrErrores = $claTipoActo->arrErrores;
                }
            } else {
                $arrErrores = $claTipoActo->arrErrores;
            }
        } else {
            $arrErrores[] = "Ya existe un acto administrativo con ese numero y fecha";
        }
    } else {
        $arrErrores = $claActo->arrErrores;
    }
}

// si hay errores muestra el formulario con los errores
// de lo contrario muestra el mensaje de ok en el listado de aad
if (!empty($arrErrores)) {

    $claSmarty->assign("arrPost", $_POST);
    $claSmarty->assign("claActo", $claActo);
    $claSmarty->assign("arrTipoActo", $arrTipoActo);
    $claSmarty->assign("arrErrores", $arrErrores);
    $claSmarty->display("aad/informacion.tpl");
} else {

    $claSmarty->assign("arrTipoActo", $arrTipoActo);
    $claSmarty->assign("arrMensajes", $arrMensajes);
    $claSmarty->assign("arrActos", $claActo->listarActos());

    $claSmarty->display("aad/aad.tpl");
}
?>