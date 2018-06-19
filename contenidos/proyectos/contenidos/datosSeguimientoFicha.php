<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );

include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );


$claDatosProy = new DatosGeneralesProyectos();
$claProyecto = new Proyecto();

$arrProyectos = array();
$arrOferentesProy = array();
$arrTipoVivienda = Array();
$arrConjuntoResidencial = Array();
$arraDatosPoliza = Array();
$arrCronogramaFecha = Array();
$arrayFideicomitente = Array();
$arraImagenes = Array();


$txtPlantilla = "proyectos/vistas/listaProyectosFicha.tpl";
$idProyecto = 0;
$seqSeguimientoFicha = 0;
$arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
$arrRegistros = array();
$arrayDocumentos = array();
$id = $_REQUEST['id'];
$arrProyectos[0] = 0;
$arraSegFicha[0] = 0;
$arrayTextos[0] = 0;
$arraImagenes[0] = 0;

$id = str_replace(".php", "", $id);

if ((isset($_REQUEST['seqProyecto']) || isset($_REQUEST['seqSeguimientoFicha'])) && $id != 2) {
   
    $idProyecto = $_REQUEST['seqProyecto'];
    $seqSeguimientoFicha = $_REQUEST['seqSeguimientoFicha'];
    $txtPlantilla = "proyectos/vistas/inscripcionSeguimiento.tpl";
    if (isset($_REQUEST['seqSeguimientoFicha'])) {
        $seqSeguimientoFicha = $_REQUEST['seqSeguimientoFicha'];
        $arrayTextos = $claDatosProy->obtenerlistaTextos($seqSeguimientoFicha);
       
    }
}
 $arraSegFicha = $claDatosProy->obtenerSeguimientosFicha($idProyecto, $seqSeguimientoFicha);
 
if ($id == 2) {
    $idProyecto = $_REQUEST['seqProyecto'];
    $txtPlantilla = "proyectos/vistas/listaImagenes.tpl";
    $directorio = '../../../recursos/proyectos/proyecto-' . $idProyecto . '/imagenes';

    $dir = @dir($directorio);

    $arraImagenes = Array();
    if ($dir) {

        while (($archivo = $dir->read()) !== false) {
            if ($archivo[0] != ".") {
                $arraImagenes[] = 'proyecto-' . $idProyecto . '/imagenes/' . $archivo;
                continue;
            }
        }
    }
}

$arrProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto, $id);


$seqUsuario = $_SESSION['seqUsuario'];
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arrProyectos", $arrProyectos);

$claSmarty->assign("id", $id);
$claSmarty->assign("NombreUsuario", $_SESSION['txtNombre'] . "" . $_SESSION['txtApellido']);
$claSmarty->assign("seqUsuario", $_SESSION['seqUsuario']);
$claSmarty->assign("seqProyecto", $_REQUEST['seqProyecto']);
$claSmarty->assign("arraSegFicha", $arraSegFicha);
$claSmarty->assign("arrayTextos", $arrayTextos);
$claSmarty->assign("arrImagenes", $arraImagenes);
$claSmarty->assign("page", "datosSeguimientoFicha.php?tipo=1&id=" . $id);


if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}
    