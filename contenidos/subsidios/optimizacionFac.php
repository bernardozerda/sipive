<?php

ini_set("memory_limit", "-1");
ini_set("max_execution_time", "0");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php" );
include( "../../librerias/phpExcel/Classes/PHPExcel/IOFactory.php" );

$arrMensajes = array();


$sql = "
    select distinct
      epr.seqEstadoProceso as seqEstado,
      concat(eta.txtEtapa,' - ',epr.txtEstadoProceso) as txtEstado
    from t_aad_formulario_acto fac
    inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo and hvi.seqTipoActo = 1
    inner join t_frm_estado_proceso epr on fac.seqEstadoProceso = epr.seqEstadoProceso
    inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
    order by concat(eta.txtEtapa,' - ',epr.txtEstadoProceso)
";
$arrEstados = $aptBd->GetAll($sql);

$sql1 = "
    select distinct
     seqEstadoProceso as seqEstado,
     concat(txtEtapa,' - ',txtEstadoProceso) as txtEstado
     FROM t_frm_estado_proceso
    left join t_frm_etapa using(seqEtapa)
    where txtEstadoProceso like '%exclu%' or txtEstadoProceso like '%perdida%' or txtEstadoProceso like '%bloqueado%' 
    order by concat(txtEtapa,' - ',txtEstadoProceso)
";
$arrEstados1 = $aptBd->GetAll($sql1);

$sql2 = "
    select distinct
     seqEstadoProceso as seqEstado,
     concat(txtEtapa,' - ',txtEstadoProceso) as txtEstado
     FROM t_frm_estado_proceso
    left join t_frm_etapa using(seqEtapa)
    where seqEtapa = 2 AND seqEstadoProceso not in (8)
    order by concat(txtEtapa,' - ',txtEstadoProceso)
";
$arrEstados2 = $aptBd->GetAll($sql2);

$claSmarty->assign("arrErrores", $arrArchivo['errores']);
$claSmarty->assign("arrMensajes", $arrMensajes);
$claSmarty->assign("arrEstados", $arrEstados);
$claSmarty->assign("arrEstados1", $arrEstados1);
$claSmarty->assign("arrEstados2", $arrEstados2);
$claSmarty->display("subsidios/optimizacionFac.tpl");
?>