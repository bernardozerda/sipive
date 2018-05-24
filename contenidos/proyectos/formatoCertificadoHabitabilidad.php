<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["funciones"] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/coneccionBaseDatos.php" );

$objTecnico = new stdClass();

$sql = "select * from t_pry_tecnico where seqUnidadProyecto = " . intval($_GET['seqUnidadProyecto']);
$objRes = $aptBd->execute($sql);
while($objRes->fields){
    foreach($objRes->fields as $txtTitulo => $txtValor){
        $objTecnico->$txtTitulo = $txtValor;
    }
    $objRes->MoveNext();
}

$sql = "
    select 
        if(pry.seqProyecto is null, con.txtNombreProyecto, pry.txtNombreProyecto) as txtProyecto,
        if(pry.seqProyecto is null, null, con.txtNombreProyecto) as txtConjunto,
        upr.txtNombreUnidad,
        con.txtDireccion,
        loc.txtLocalidad,
        bar.txtBarrio,
        con.txtLicenciaConstruccion,
        con.fchEjecutoriaLicConstruccion,
        '' as txtEntidadLicenciaConstruccion
    from t_pry_unidad_proyecto upr
    inner join t_pry_proyecto con on upr.seqProyecto = con.seqProyecto
    left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
    left join t_frm_localidad loc on con.seqLocalidad = loc.seqLocalidad
    left join t_frm_barrio bar on con.seqBarrio = bar.seqBarrio
    where upr.seqUnidadProyecto = " . intval($_GET['seqUnidadProyecto']) . "
";
$objRes = $aptBd->execute($sql);
while($objRes->fields){
    foreach($objRes->fields as $txtTitulo => $txtValor){
        $objTecnico->$txtTitulo = mb_strtoupper($txtValor);
    }
    $objRes->MoveNext();
}

$sql = "select * from t_pry_adjuntos_tecnicos where seqTecnicoUnidad = " . intval($objTecnico->seqTecnicoUnidad);
$objRes = $aptBd->execute($sql);
while ($objRes->fields) {
    switch ($objRes->fields['seqAdjuntoTecnicoProyecto']) {
        case 2:
            $numContador = count($objTecnico->observaciones);
            $objTecnico->observaciones[$numContador] = $objRes->fields['txtNombreAdjunto'];
            break;
        default: // Imagenes
            $numContador = count($objTecnico->imagenes);
            $objTecnico->imagenes[$numContador]['nombre'] = $objRes->fields['txtNombreAdjunto'];
            $objTecnico->imagenes[$numContador]['ruta'] = $objRes->fields['txtNombreArchivo'];
            if (!file_exists($txtPrefijoRuta . "recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'])) {
                $objTecnico->imagenes[$numContador]['nombre'] = "No Disponible";
                $objTecnico->imagenes[$numContador]['ruta'] = "no_disponible.jpg";
            }
            break;
    }
    $objRes->MoveNext();
}

$txtFecha = utf8_encode(ucwords(strftime("%A %#d de %B del %Y"))) . " " . date("H:i:s");
$txtFechaVisita = utf8_encode(ucwords(strftime("%A %#d de %B del %Y", strtotime($objTecnico->fchVisita))));
$numDiaActual = date("d");
$txtMesActual = utf8_encode(ucwords(strftime("%B")));
$numAnoActual = date("Y");

$claSmarty->assign("objTecnico"  , $objTecnico );
$claSmarty->assign("txtFuente12" , "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 12px;");
$claSmarty->assign("txtFuente10" , "font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;");
$claSmarty->assign("txtFecha"    , $txtFecha );
$claSmarty->assign("numDiaActual", $numDiaActual);
$claSmarty->assign("txtMesActual", $txtMesActual);
$claSmarty->assign("numAnoActual", $numAnoActual);
$claSmarty->assign("txtMatriculaProfesional", obtenerMatriculaProfesional() );
$claSmarty->assign("txtUsuarioSesion", $_SESSION['txtNombre'] . " " . $_SESSION['txtApellido']);

$claSmarty->assign("txtFechaVisita"    , $txtFechaVisita );

$claSmarty->display("proyectos/formatoCertificadoHabitabilidad.tpl");

?>