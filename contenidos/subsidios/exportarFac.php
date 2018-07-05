<?php

ini_set("memory_limit","-1");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']   . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

$txtPrincipal = (isset($_GET['principal']) and $_GET['principal'] == "true")? "and hog.seqParentesco = 1" : "";

$sql = "
select
    ciu.numDocumento,
    upper(concat(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) as txtNombre,
    par.txtParentesco,
    fac.seqFormulario,    
    fac.fchInscripcion,
    fac.txtFormulario,
    fac.fchPostulacion,
    fac.fchUltimaActualizacion,
    if(fac.bolDesplazado = 1, 'SI','NO') as bolDesplazado,
    concat('Res. ',hvi.numActo) as numActo,
    year(hvi.fchActo) as numAnio,
    hvi.fchActo,
    concat(eta.txtEtapa,' - ', epr.txtEstadoProceso) as txtEstado
from t_aad_formulario_acto fac
inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
inner join t_frm_estado_proceso epr on fac.seqEstadoProceso = epr.seqEstadoProceso
inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
left join t_frm_hogar hog on fac.seqFormulario = hog.seqFormulario $txtPrincipal
left join t_ciu_parentesco par on hog.seqParentesco = par.seqParentesco
left join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
where hvi.seqTipoActo = 1
  and ciu.seqTipoDocumento in (1,2)
order by 
  fac.seqFormulario
";

$arrArchivo = $aptBd->GetAll($sql);

$arrTitulos[] = "Documento";
$arrTitulos[] = "Nombre";
$arrTitulos[] = "Parentesco";
$arrTitulos[] = "ID Hogar";
$arrTitulos[] = "Fecha de Inscripción";
$arrTitulos[] = "Carpeta postulación";
$arrTitulos[] = "Fecha Postulación";
$arrTitulos[] = "Fecha Última Actualización";
$arrTitulos[] = "Desplazado";
$arrTitulos[] = "Resolución Asignación";
$arrTitulos[] = "Año";
$arrTitulos[] = "F_Resolucion";
$arrTitulos[] = "Estado";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='FormularioActo_" . date("YmdHis") . ".csv");
header('Cache-Control: max-age=0');

echo utf8_decode(implode(";",$arrTitulos)) . "\r\n";
foreach($arrArchivo as $numLinea => $arrLinea){
    echo utf8_decode(implode(";",$arrLinea)) . "\r\n";
}

?>