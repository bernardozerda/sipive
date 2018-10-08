<?php

$txtPrefijoRuta = "../../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );


include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosGeneralesProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "DatosUnidades.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "SeguimientoProyectos.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Proyecto.class.php" );


$claDatosProy = new DatosGeneralesProyectos();
$claProyecto = new Proyecto();
$claUnidades = new DatosUnidades();
$txtPlantilla = "proyectos/vistas/liquidacionProyecto.tpl";
$id = $_REQUEST['id'];
$tipo = $_REQUEST['tipo'];
$page = $_REQUEST['page'];
$idProyecto = 0;
$destino = "";
$arraArchivos = Array();
$arrGrupoGestion = Array();
$arraTipoArchivos = Array();  
$arraTipoInformes = Array();
$cantArchivosValid = 0;
$validar = false;
if (isset($_REQUEST['seqProyecto'])) {
    $idProyecto = $_REQUEST['seqProyecto'];
    $arrProyectos = $claDatosProy->obtenerlistaProyectos($idProyecto, $id);
    $cantUnidadesLegalizadas = $claUnidades->ObtenerCantUnidadesLegalizadasProyecto($idProyecto);
    $cantUnidadesExistencia = $claProyecto->datosTecnicosExistencia($idProyecto);
    $cantUnidadesPermiso = $claUnidades->datosTecnicosPermisoOcup($idProyecto);
    $cantUnidadesLegalizadasXUnd = $claUnidades->ObtenerCantUnidadesLegalizadasUnd($idProyecto);
    $arrGrupoGestion = $claDatosProy->obtenerDatosGestion();
    $arraTipoInformes = $claUnidades->datosTiposInformes();    
    $cantSoluciones = $arrProyectos[0]['valNumeroSoluciones'];
    if ($cantSoluciones == $cantUnidadesLegalizadas && $cantSoluciones == $cantUnidadesExistencia && $cantSoluciones == $cantUnidadesPermiso && $cantSoluciones == $cantUnidadesLegalizadasXUnd) {
        $validar = true;
    }

    $destino = '../../../recursos/proyectos/proyecto-' . $idProyecto . '/liquidacion/';
    $dir = @dir($destino);
  
    if ($dir) {
        while (($archivo = $dir->read()) !== false) {
            if ($archivo[0] != ".") {
                $tipo = explode("_", $archivo);
                $type =str_replace('-', ' ', $tipo[0]);
                $arraTipoArchivos[] = $type;
                $arraArchivos[] = array(
                    "destino" => 'recursos/proyectos/proyecto-' . $idProyecto . '/liquidacion/',
                    "nombre" => $archivo,
                    "size" => round(filesize($destino . '' . $archivo) / 1024, 2),
                    "type" => $type,
                );
                continue;
            }
        }
    }
}
//var_dump($arraTipoArchivos);
if (in_array("Informe de Interventoria", $arraTipoArchivos)) {
    $cantArchivosValid++;
}
if (in_array("Informe Fiducia", $arraTipoArchivos)) {
    $cantArchivosValid++;
}
if (in_array("Revision Oferente", $arraTipoArchivos)) {
    $cantArchivosValid++;
}
if (in_array("Informe", $arraTipoArchivos)) {
    $cantArchivosValid++;
}

if($cantArchivosValid > 3 && $validar == true){
    $validar = true;
}else if($cantArchivosValid < 4){
    $validar = false;
}
//echo "<br>cantidad ".$cantArchivosValid;
//echo "<p> ttt".$idProyecto." -> legalizadas ".$cantUnidadesLegalizadas."</p>";
$claSmarty->assign("idProyecto", $idProyecto);
$claSmarty->assign("arrProyectos", $arrProyectos);
$claSmarty->assign("cantUnidadesLegalizadas", $cantUnidadesLegalizadas);
$claSmarty->assign("cantUnidadesLegalizadasXUnd", $cantUnidadesLegalizadasXUnd);
$claSmarty->assign("cantUnidadesPermiso", $cantUnidadesPermiso);
$claSmarty->assign("cantUnidadesExistencia", $cantUnidadesExistencia);
$claSmarty->assign("arraArchivos", $arraArchivos);
$claSmarty->assign("arrGrupoGestion", $arrGrupoGestion);
$claSmarty->assign("arraTipoInformes", $arraTipoInformes);
$claSmarty->assign("id", $id);
$claSmarty->assign("tipo", $tipo);
$claSmarty->assign("page", $page);
$claSmarty->assign("validar", $validar);

if ($txtPlantilla != "") {
    $claSmarty->display($txtPlantilla);
}