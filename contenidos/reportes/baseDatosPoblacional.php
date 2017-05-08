	<?php

/***********************************
* REPORTE BASE DE DATOS POBLACIONAL
* @author Andres Martinez
* @version 1.0 - Mayo 2016
************************************/
	
	$txtPrefijoRuta = "../../";
	
    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );	
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases']  . "Reportes.class.php" );
        
    $arrSeqFormularios = array( );
    if( isset( $_FILES['fileSecuenciales'] ) and !$_FILES['fileSecuenciales']['error']  ){
    	try {
			$aptArchivo = fopen( $_FILES['fileSecuenciales']['tmp_name'] , "r" );
			$numLinea = 1;
			while( $txtLinea = fgets( $aptArchivo ) ){
				try {
					$txtLinea = trim( $txtLinea );
					if( is_numeric( $txtLinea ) ){
						
						$seqFormulario = Ciudadano::formularioVinculado($txtLinea);
						if( $seqFormulario ){
							$arrSeqFormularios[] = $seqFormulario;
						}
						
					}
				}catch( Exception $objError ){ }
				$numLinea++;
			}
		}catch( Exception $objError ){ }
    }
    
	$fechaIni 			= $_POST['fchInicio'];
	$fechaFin 			= $_POST['fchFin'];
		
	if( $fechaIni ){
		$arrCondiciones[] = "(frm.fchInscripcion >= '$fechaIni') or (frm.fchUltimaActualizacion >= '$fechaIni') ";
	}
	else{
		$arrCondiciones[] = "ciu.numDocumento > '0'";
	}
	if( $fechaFin ){
		$arrCondiciones[] = "(frm.fchInscripcion <= '$fechaFin') or (frm.fchUltimaActualizacion <= '$fechaFin')";
	}
	else{
		$arrCondiciones[] = "ciu.numDocumento > '0'";
	}
		
	$txtCondicion = implode( " and ", $arrCondiciones );
	
	$sql = "SELECT ciu.seqCiudadano AS id,
       frm.seqFormulario AS idhogar,
	   frm.fchInscripcion AS fechaInscripcion,
       frm.fchUltimaActualizacion AS ultimaactualizacion,
       upper(ciu.txtNombre1) AS nombre_1,
       upper(ciu.txtNombre2) AS nombre_2,
       upper(ciu.txtApellido1) AS apellido_1,
       upper(ciu.txtApellido2) AS apellido_2,
       CASE
          WHEN ciu.seqTipoDocumento = 1 THEN 'CC'
          WHEN ciu.seqTipoDocumento = 2 THEN 'CE'
          WHEN ciu.seqTipoDocumento = 3 THEN 'TI'
          WHEN ciu.seqTipoDocumento = 4 THEN 'RC'
          WHEN ciu.seqTipoDocumento = 5 THEN 'PA'
          WHEN ciu.seqTipoDocumento = 6 THEN 'NIT'
          WHEN ciu.seqTipoDocumento = 7 THEN 'NUIP'
          ELSE 'SI'
       END
          AS tip_id,
       ciu.numDocumento AS num_id,
       '' AS mun_nac,
       '' AS pais_nac,
       '' AS fec_id,
       CASE WHEN sex.txtSexo = 'Masculino' THEN 'H' ELSE 'M' END AS sexo,
       DATE_FORMAT(ciu.fchNacimiento, '%Y-%m-%d') AS fec_nac,
       '' AS gru_sang,
       '' AS fact_rh,
       CASE
          WHEN ciu.seqEtnia = 1 THEN '9'
          WHEN ciu.seqEtnia = 2 THEN '1'
          WHEN ciu.seqEtnia = 3 THEN '2'
          WHEN ciu.seqEtnia = 4 THEN '3'
          WHEN ciu.seqEtnia = 5 THEN '4'
          WHEN ciu.seqEtnia = 6 THEN '5'
       END
          AS etnia,
       '' AS cual_etnia,
       '' AS genero,
       '' AS cual_genero,
       '' AS nom_identitario,
       CASE
          WHEN osex.seqGrupoLgtbi = 1 THEN '1'
          WHEN osex.seqGrupoLgtbi = 2 THEN '1'
          WHEN osex.seqGrupoLgtbi = 0 THEN '2'
          WHEN osex.seqGrupoLgtbi = 4 THEN '3'
          WHEN osex.seqGrupoLgtbi = 3 THEN '8'
          WHEN osex.seqGrupoLgtbi = 5 THEN '8'
          ELSE '9'
       END
          AS orient_sex,
       IF((osex.seqGrupoLgtbi = 3 OR osex.seqGrupoLgtbi = 5),
          osex.txtGrupoLgtbi,
          '')
          AS cual_orient_sex,
       '' AS ocupacion,
       '' AS cual_ocupacion,
       '' AS cond_habitacion,
       '' AS tipo_aten_pob_infantil,
       '' AS ocup_especial,
       IF(frm.bolDesplazado = 1, 'D-04', '') AS cond_especial,
       '' AS cara_espe_padres,
       IF(ciu.seqCondicionEspecial = 3, 'F-02', '') AS cond_espe_salud,
       '' AS traba_sexual,
       '' AS persona_talento,
       '' AS est_afi_sgsss,
       CASE
          WHEN frm.seqLocalidad = 2 THEN '15'
          WHEN frm.seqLocalidad = 3 THEN '12'
          WHEN frm.seqLocalidad = 4 THEN '07'
          WHEN frm.seqLocalidad = 5 THEN '02'
          WHEN frm.seqLocalidad = 6 THEN '19'
          WHEN frm.seqLocalidad = 7 THEN '10'
          WHEN frm.seqLocalidad = 8 THEN '09'
          WHEN frm.seqLocalidad = 9 THEN '08'
          WHEN frm.seqLocalidad = 10 THEN '17'
          WHEN frm.seqLocalidad = 11 THEN '14'
          WHEN frm.seqLocalidad = 12 THEN '16'
          WHEN frm.seqLocalidad = 13 THEN '18'
          WHEN frm.seqLocalidad = 14 THEN '04'
          WHEN frm.seqLocalidad = 15 THEN '03'
          WHEN frm.seqLocalidad = 16 THEN '11'
          WHEN frm.seqLocalidad = 17 THEN '20'
          WHEN frm.seqLocalidad = 18 THEN '13'
          WHEN frm.seqLocalidad = 19 THEN '06'
          WHEN frm.seqLocalidad = 20 THEN '01'
          WHEN frm.seqLocalidad = 21 THEN '05'
          ELSE ''
       END
          AS localidad,
       '' AS tipo_zona,
       '' AS tip_via_prin,
       '' AS num_via_prin,
       '' AS nom_via_prin,
       '' AS nom_sin_via_prin,
       '' AS letra_via_prin,
       '' AS bis,
       '' AS letra_Bis,
       '' AS cuad_via_prin,
       '' AS num_via_gen,
       '' AS letra_via_gen,
       '' AS num_placa,
       '' AS cuad_via_gen,
       '' AS complemento,
       IF(frm.bolDesplazado = 1, '', upper(frm.txtDireccion))
          AS direccion_rural,
       '' AS estrato,
       #frm.bolDesplazado AS VICTIMA,
       IF(frm.bolDesplazado = 1, '', frm.numTelefono1) AS tel_fijo_contacto, #NO SE IMPRIME INFO SI ES VICTIMA BOLDESPLAZADO=1
       IF(frm.bolDesplazado = 1, '', frm.numCelular) AS tel_celular_contacto, #NO SE IMPRIME INFO SI ES VICTIMA BOLDESPLAZADO=1
       IF(frm.bolDesplazado = 1, '', frm.txtCorreo) AS correo_electr, #NO SE IMPRIME INFO SI ES VICTIMA BOLDESPLAZADO=1
       '' AS localidad_contacto,
       '' AS tipo_zona_contacto,
       '' AS tip_via_prin_contacto,
       '' AS num_via_prin_contacto,
       '' AS nom_via_prin_contacto,
       '' AS nom_sin_via_prin_contacto,
       '' AS letra_via_prin_contacto,
       '' AS bis_contacto,
       '' AS letra_bis_contacto,
       '' AS cuad_via_prin_contacto,
       '' AS num_via_gen_contacto,
       '' AS letra_via_gen_contacto,
       '' AS num_placa_contacto,
       '' AS cuad_via_gen_contacto,
       '' AS complemento_contacto,
       '' AS direccion_rural_contacto,
       '' AS estrato_contacto,
       '' AS tel_fijo_contacto_contacto,
       '' AS tel_celular_contacto_contacto,
       '' AS correo_electr_contacto,
       '' AS nombre_contacto
  FROM T_FRM_FORMULARIO frm
       INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
       INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
       INNER JOIN T_CIU_SALUD sal ON ciu.seqSalud = sal.seqSalud
       INNER JOIN T_CIU_SEXO sex ON ciu.seqSexo = sex.seqSexo
       INNER JOIN T_FRM_GRUPO_LGTBI osex
          ON ciu.seqGrupolgtbi = osex.seqGrupolgtbi
       LEFT JOIN T_CIU_ETNIA etn ON ciu.seqEtnia = etn.seqEtnia
	   WHERE $txtCondicion";
	//echo $sql;die();
	
	$objRes = $aptBd->execute( $sql );
	
	$txtNombreArchivo = "baseDatosPoblacional" . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral($objRes, $txtNombreArchivo);
	
?>
