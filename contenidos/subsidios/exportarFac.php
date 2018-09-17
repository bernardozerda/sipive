<?php

ini_set("memory_limit","-1");

$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

$txtEstados = "";
if(! empty($_POST['estados'])) {
    $txtEstados = "and fac.seqEstadoProceso in (" . implode(",",$_POST['estados']) . ")";
}

$sql = "
    select
        fac.seqFormularioActo as 'Formulario Acto',
        fac.seqFormulario as 'Formulario',
        ciu.seqTipoDocumento as 'Tipo de Documento',
        ciu.numDocumento as 'Documento',
        upper(concat(ciu.txtNombre1  ,if(ciu.txtNombre2   <> '',concat(' ',ciu.txtNombre2  ),''))) as 'Nombres',
        upper(concat(ciu.txtApellido1,if(ciu.txtApellido2 <> '',concat(' ',ciu.txtApellido2),''))) as 'Apellidos', 
        hvi.numActo as 'Número de Resolución',
        hvi.fchActo as 'Fecha de Resolución',
        (
          if(fac.valAspiraSubsidio is null, 0, fac.valAspiraSubsidio) + 
          if(fac.valComplementario is null, 0, fac.valComplementario) +
          if(fac.valCartaLeasing is null, 0, fac.valCartaLeasing)
        ) as 'Valor Asignado',
        case upper(sol.txtDescripcion)
          when 'VIP' then 1
          when 'VIP TIPO 1' then 2
          when 'VIP TIPO 2' then 3
          when 'VIS' then 6
          else 0
        end as 'Tipo Vivienda',
        fac.fchUltimaActualizacion as 'Última Actualización',
        moa.txtModalidad as 'Modalidad',
        concat(eta.txtEtapa,' - ',epr.txtEstadoProceso) as 'Estado',
        concat(fac.seqFormulario,'Res. ',hvi.numActo,'de',year(hvi.fchActo)) as 'Clave',
        case 
          when fac.seqEstadoProceso = 33 then 'DESEMBOLSADO' 
          when fac.seqEstadoProceso = 59 then 'DESEMBOLSADO - PENDIENTE REINTEGRO' 
          when fac.seqEstadoProceso = 60 then 'DESEMBOLSADO - REINTEGRADO' 
          when fac.seqEstadoProceso = 40 then 'DESEMBOLSO - LEGALIZADO|VINCULACION - LEGALIZADO' 
          when fac.seqEstadoProceso = 57 then 'DESVINCULACION|EXCLUIDO. VINCULACION' 
          when fac.seqEstadoProceso = 63 then 'EXCLUIDO. VIVIENDA GRATUITA'
          when fac.seqEstadoProceso = 21 then 'PERDIDA'
          when fac.seqEstadoProceso = 15 then 'PROCESO DESEMBOLSO|PROCESO LEGALIZACION|VINCULACION'
          when fac.seqEstadoProceso = 18 then 'RENUNCIA'
          when fac.seqEstadoProceso = 58 then 'REVOCADO'
          when fac.seqEstadoProceso = 34 then 'VENCIDO'
          else 'NO HAY ESTADO EQUIVALENTE'
        end as 'Estado Equivalente 1',
        '' as 'Estado Equivalente 2',
        '' as 'Estado Equivalente 3'
    from t_aad_formulario_acto fac
    inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
    inner join t_frm_estado_proceso epr on fac.seqEstadoProceso = epr.seqEstadoProceso
    inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
    left join t_frm_modalidad moa on fac.seqModalidad = moa.seqModalidad
    left join t_frm_solucion sol on fac.seqSolucion = sol.seqSolucion
    left join t_frm_hogar hog on fac.seqFormulario = hog.seqFormulario
    left join t_ciu_parentesco par on hog.seqParentesco = par.seqParentesco
    left join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
    left join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
    where hvi.seqTipoActo = 1
      $txtEstados
      and (
        ciu.seqTipoDocumento in (1,2)
        or (
          ciu.seqTipoDocumento = 7 and 
          YEAR(CURDATE())-YEAR(ciu.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(ciu.fchNacimiento,'%m-%d'), 0, -1) >= 18
        )
        or (
          ciu.seqTipoDocumento = 8 and 
          YEAR(CURDATE())-YEAR(ciu.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(ciu.fchNacimiento,'%m-%d'), 0, -1) >= 18
        )
      )
";
$arrArchivo = $aptBd->GetAll($sql);

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='FormularioActo_" . date("YmdHis") . ".csv");
header('Cache-Control: max-age=0');
ob_clean();

echo utf8_decode(implode("\t",array_keys($arrArchivo[0]))) . "\r\n";
foreach($arrArchivo as $numLinea => $arrLinea){
    echo mb_ereg_replace("[\|]","\t",utf8_decode(implode("\t",$arrLinea))) . "\r\n";
}

?>