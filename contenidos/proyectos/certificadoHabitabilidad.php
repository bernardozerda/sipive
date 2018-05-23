<?php

$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion["librerias"]["funciones"] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion["carpetas"]["recursos"] . "archivos/coneccionBaseDatos.php" );

$sql = "
select 
    if(pry.seqProyecto is null,con.seqProyecto,pry.seqProyecto) as seqProyecto,
    if(pry.seqProyecto is null,con.txtNombreProyecto,pry.txtNombreProyecto) as txtNombreProyecto,
    if(pry.seqProyecto is null,null,con.seqProyecto) as seqConjunto,
    if(pry.seqProyecto is null,null,con.txtNombreProyecto) as txtNombreConjunto,
    upr.seqUnidadProyecto,
    upr.txtNombreUnidad 
from t_pry_unidad_proyecto upr
inner join t_pry_tecnico tec on upr.seqUnidadProyecto = tec.seqUnidadProyecto
inner join t_pry_proyecto con on upr.seqProyecto = con.seqProyecto
left join t_pry_proyecto pry on con.seqProyectoPadre = pry.seqProyecto
order by txtNombreProyecto, txtNombreUnidad
";
$objRes = $aptBd->execute($sql);
while($objRes->fields){
    $seqConjunto  = ($objRes->fields['seqConjunto'] !== null)? $objRes->fields['seqConjunto'] : $objRes->fields['seqProyecto'];
    $txtProyecto  = $objRes->fields['txtNombreProyecto'];
    $txtProyecto .= ($objRes->fields['txtNombreConjunto'] !== null)? " - " . $objRes->fields['txtNombreConjunto'] : "";
    $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
    $arrProyectos[$seqConjunto] = $txtProyecto;
    $arrListado[$seqConjunto][$seqUnidadProyecto]['proyecto'] = $txtProyecto;
    $arrListado[$seqConjunto][$seqUnidadProyecto]['nombre'] = $objRes->fields['txtNombreUnidad'];
    $objRes->MoveNext();
}

$claSmarty->assign( "arrProyectos" , $arrProyectos );
$claSmarty->assign( "arrListado" , $arrListado );
$claSmarty->assign( "seqProyecto" , $_POST['seqProyecto'] );
$claSmarty->display( "proyectos/certificadoHabitabilidad.tpl" );

?>