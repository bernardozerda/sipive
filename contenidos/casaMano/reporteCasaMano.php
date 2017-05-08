<?php

	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "CasaMano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );
    
    $arrErrores = array();
    
    // para que las fechas las entregue en español
    //$aptBd->execute( "SET lc_time_names = 'es_CO'" );
    
    $sql = "
        SELECT
          cem.txtGrupo as Grupo,
          cem.seqCasaMano as CasaMano,
          cem.seqFormulario as Formulario,
          CONCAT( 
            eta.txtEtapa , 
            ' - ', 
            pro.txtEstadoProceso 
          ) as EstadoProceso,
		  CONCAT('\'',txtFormulario,'\'') AS txtFormulario,
		  bolCerrado,
          moa.txtModalidad as Modalidad,
          tdo.txtTipoDocumento as TipoDocumento,  
          ciu.numDocumento as Documento,
          UCWORDS( 
            CONCAT( 
              TRIM( ciu.txtNombre1 ),
              ' ',
              IF( 
                TRIM( ciu.txtNombre2 ) <> '', 
                CONCAT( TRIM( ciu.txtNombre2 ) , ' ' ) , 
                '' 
              ),
              TRIM( ciu.txtApellido1 ),
              ' ',
              TRIM( ciu.txtApellido2 )
            )
          ) as NombrePPal,
          CONCAT( cid2.txtCiudad , ', ', cid2.txtDepartamento ) as CiudadResidencia,
          loc.txtLocalidad as LocalidadResidencia,
          frm.txtBarrio as BarrioResidencia,
          frm.txtDireccion as DireccionResidencia,
          frm.valTotalRecursos as TotalRecursos,
          frm.valAspiraSubsidio as ValorSubsidio,
          cem.fchRegistroVivienda as FechaRegistroVivienda,
          UCWORDS( MONTHNAME( cem.fchRegistroVivienda ) ) as MesRegistroVivienda,
          rvi.txtNombreVendedor as NombreVendedor,
          tdo2.txtTipoDocumento as txtTipoDocumentoVendedor,
          rvi.numDocumentoVendedor as DocumentoVendedor,
          rvi.numTelefonoVendedor as TelefonoVendedor1,
          rvi.numTelefonoVendedor2 as TelefonoVendedor2,
          rvi.txtCorreoVendedor as CorreoVendedor,
          UPPER( rvi.txtCompraVivienda ) as TipoVivienda,
          UPPER( rvi.txtTipoPredio ) as TipoPredio,
          rvi.txtDireccionInmueble as DireccionSolucion,
          CONCAT( cid.txtCiudad , ', ', cid.txtDepartamento ) as CiudadSolucion,
          loc2.txtLocalidad as LocalidadSolucion,
          rvi.txtBarrio as BarrioSolucion,
          rvi.txtMatriculaInmobiliaria as MatriculaInmobiliaria,
          rvi.txtChip as CHIP,
          rvi.txtCedulaCatastral as CedulaCatastral,
          rvi.numAvaluo as ValorAvaluo,
          rvi.numValorInmueble as ValorInmueble,
          CASE cem.bolRevisionJuridica
            WHEN 0 THEN 'En Proceso'
            WHEN 1 THEN 'Viabilizado'
            WHEN 2 THEN 'No Viabilizado'
            ELSE 'No Realizado'
          END as EstadoRevisionJuridica,
          cem.fchRevisionJuridica as FechaRevisionJuridica,
          UCWORDS( MONTHNAME( cem.fchRevisionJuridica ) ) as MesRevisionJuridica,
          cem.txtRevisionJuridica as ConceptoJuridico,
          CASE cem.bolRevisionTecnica
            WHEN 0 THEN 'En Proceso'
            WHEN 1 THEN 'Viabilizado'
            WHEN 2 THEN 'No Viabilizado'
            ELSE 'No Realizado'
          END as EstadoRevisionTecnica,
          cem.fchRevisionTecnica as FechaRevisionTecnica,
          UCWORDS( MONTHNAME( cem.fchRevisionTecnica ) ) as MesRevisionTecnica,
          cem.txtRevisionTecnica as ConceptoTecnico,
          cem.fchPostulacion as FechaPostulacion,
          UCWORDS( MONTHNAME( cem.fchPostulacion ) ) as MesPostulacion,
          CASE cem.bolPrimeraVerificacion
            WHEN 0 THEN 'En Proceso'
            WHEN 1 THEN 'Sin Cruces'
            WHEN 2 THEN 'Con Cruces'
            ELSE 'No Realizado'
          END as EstadoPrimeraVerificacion,
          cem.fchPrimeraVerificacion as FechaPrimeraVerificacion,
          UCWORDS( MONTHNAME( cem.fchPrimeraVerificacion ) ) as MesPrimeraVerificacion,
          CASE cem.bolSegundaVerificacion
            WHEN 0 THEN 'En Proceso'
            WHEN 1 THEN 'Sin Cruces'
            WHEN 2 THEN 'Con Cruces'
            ELSE 'No Realizado'
          END as EstadoSegundaVerificacion,
          cem.fchSegundaVerificacion as FechaSegundaVerificacion,
          UCWORDS( MONTHNAME( cem.fchSegundaVerificacion ) ) as MesSegundaVerificacion
        FROM T_CEM_CASA_MANO cem
        INNER JOIN T_FRM_FORMULARIO        frm  ON cem.seqFormulario = frm.seqFormulario
        INNER JOIN T_FRM_HOGAR             hog  ON frm.seqFormulario = hog.seqFormulario
        INNER JOIN T_CIU_CIUDADANO         ciu  ON hog.seqCiudadano = ciu.seqCiudadano
        INNER JOIN T_CIU_TIPO_DOCUMENTO    tdo  ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
        INNER JOIN T_FRM_MODALIDAD         moa  ON frm.seqModalidad = moa.seqModalidad
        INNER JOIN T_FRM_ESTADO_PROCESO    pro  ON frm.seqEstadoProceso = pro.seqEstadoProceso
        INNER JOIN T_FRM_ETAPA             eta  ON eta.seqEtapa = pro.seqEtapa
        INNER JOIN T_CEM_REGISTRO_VIVIENDA rvi  ON cem.seqCasaMano = rvi.seqCasaMano
        LEFT JOIN T_CIU_TIPO_DOCUMENTO    tdo2 ON tdo2.seqTipoDocumento = rvi.seqTipoDocumento
        INNER JOIN T_FRM_CIUDAD            cid  ON rvi.seqCiudad = cid.seqCiudad
        LEFT JOIN T_FRM_CIUDAD            cid2 ON frm.seqCiudad = cid2.seqCiudad
        INNER JOIN T_FRM_LOCALIDAD         loc  ON frm.seqLocalidad = loc.seqLocalidad
        INNER JOIN T_FRM_LOCALIDAD         loc2 ON rvi.seqLocalidad = loc2.seqLocalidad
        WHERE hog.seqParentesco = 1
        ORDER BY ciu.numDocumento
    ";
    
    $objRes = $aptBd->execute( $sql );
	$nombreArchivo = "ReporteCasaEnMano";
	$txtNombreArchivo = $nombreArchivo . date( "Ymd_His" ) . ".xls";
	
	$claReportes = new Reportes;
	$claReportes->obtenerReportesGeneral( $objRes, $txtNombreArchivo );
    
?>
