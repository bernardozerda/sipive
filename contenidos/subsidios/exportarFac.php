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
        '8999990619' as NIT_ENTID,
        ciu.numDocumento as DOC_BENEF,
        upper(concat(ciu.txtApellido1,if(ciu.txtApellido2 <> '',concat(' ',ciu.txtApellido2),''))) as APE_BENEF, 
        upper(concat(ciu.txtNombre1  ,if(ciu.txtNombre2   <> '',concat(' ',ciu.txtNombre2  ),''))) as NOM_BENEF,
        'SECRETARÍA DISTRITAL DE HÁBITAT' as NOM_ENTID,
        hvi.fchActo as FEC_ASIGN,
        (
          if(fac.valAspiraSubsidio is null, 0, fac.valAspiraSubsidio) + 
          if(fac.valComplementario is null, 0, fac.valComplementario) +
          if(fac.valCartaLeasing is null, 0, fac.valCartaLeasing)
        ) as VAL_ASIGN_2,
        case upper(sol.txtDescripcion)
          when 'VIP' then 1
          when 'VIP TIPO 1' then 2
          when 'VIP TIPO 2' then 3
          when 'VIS' then 6
          else 0
        end as TIP_VIVIE,
        hvi.numActo as NUM_RESOL,
        '' as CIC_CARGUE,
        '' as PRE_SELEC,
        '' as FEC_INFORMACION,
        '' as FEC_RECIBO,
        '' as FEC_CARGUE,
        0 as MARCA_CCF,
        case ciu.seqTipoDocumento
          when 1 then 1
          when 2 then 2
          when 3 then 7
          when 4 then 6
          when 5 then 5
          when 6 then 4
          when 7 then 0
          when 8 then 0
        end as TIP_DOC,
        '' as observaciones
    from t_aad_formulario_acto fac
    inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
    inner join t_frm_estado_proceso epr on fac.seqEstadoProceso = epr.seqEstadoProceso
    inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
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
//$arrTitulos = array_keys($arrArchivo[0]);

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename='FormularioActo_" . date("YmdHis") . ".csv");
header('Cache-Control: max-age=0');
ob_clean();

echo date("Y/m/d") . "|" . count($arrArchivo) . "\r\n";
foreach($arrArchivo as $numLinea => $arrLinea){
    echo utf8_decode(implode("|",$arrLinea)) . "\r\n";
}

?>