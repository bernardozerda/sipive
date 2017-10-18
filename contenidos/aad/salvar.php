<?php

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "RegistroActividades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Seguimiento.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "FormularioSubsidios.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aadTipo.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "aad.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

// para los mensajes de exito al final
$arrMensajes = array();

if( $_SESSION['privilegios']['crear'] != 1 ){
    $arrErrores[] = "No tiene privilegios para crear actos administrativos";
}

if( empty($arrErrores) ) {

    // limpieza de caracteres
    foreach ($_POST as $txtClave => $txtValor) {
        $_POST[$txtClave] = regularizarCampo($txtClave, $txtValor);
    }

    // carga el tipo de acto a salvar
    $claTipoActo = new aadTipo();
    $claTipoActo = array_shift($claTipoActo->cargarTipoActo($_POST['seqTipoActo']));

    // carga el acto administrativo para
    // saber si existe y proceder si no
    $claActoAdministrativo = new aad();
    $arrActos = $claActoAdministrativo->listarActos($_POST['seqTipoActo'],$_POST['numActo'],$_POST['fchActo']);

    if( empty( $arrActos ) ) {

        // abre el archivo y lo carga en un arreglo
        $arrArchivo = $claTipoActo->cargarArchivo();

        // si hay errores
        if (empty($claTipoActo->arrErrores)) {

            $claTipoActo->validarTitulos($arrArchivo[0]);

            if (empty($claTipoActo->arrErrores)) {

                $claTipoActo->validarDatos($arrArchivo);

                if (empty($claTipoActo->arrErrores)) {

                    $claActoAdministrativo = null;
                    $claActoAdministrativo = new aad();
                    $claActoAdministrativo->salvar($_POST, $arrArchivo);

                    if (empty($claActoAdministrativo->arrErrores)) {

                        $arrMensajes = $claActoAdministrativo->arrMensajes;

                    } else {
                        $arrErrores = $claActoAdministrativo->arrErrores;
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
    }else{
        $arrErrores[] = "Ya existe un acto administrativo con ese numero y fecha";
    }
}

imprimirMensajes( $arrErrores , $arrMensajes );

?>