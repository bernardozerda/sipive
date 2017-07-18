<?php

/**
 * REPORTE DE ESCRITURACION Y ESTUDIO DE TITULOS
 * @author Jaison Ospina
 * @version 1.0 Febrero 2016
 */
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

$arrSeqFormularios = array();
if (isset($_FILES['fileSecuenciales']) and ! $_FILES['fileSecuenciales']['error']) {
    try {
        $aptArchivo = fopen($_FILES['fileSecuenciales']['tmp_name'], "r");
        $numLinea = 1;
        while ($txtLinea = fgets($aptArchivo)) {
            try {
                $txtLinea = trim($txtLinea);
                if (is_numeric($txtLinea)) {
                    $seqFormulario = Ciudadano::formularioVinculado($txtLinea);
                    if ($seqFormulario) {
                        $arrSeqFormularios[] = $seqFormulario;
                    }
                }
            } catch (Exception $objError) {
                
            }
            $numLinea++;
        }
    } catch (Exception $objError) {
        
    }
}

if (!empty($arrSeqFormularios)) {
    $arrCondiciones[] = "T_DES_ESCRITURACION.seqFormulario IN ( " . implode($arrSeqFormularios, " , ") . " )";
}

$arrCondiciones[] = "T_FRM_HOGAR.seqParentesco = 1";

$txtCondicion = implode(" AND ", $arrCondiciones);

/* $query = "SET GLOBAL group_concat_max_len=15000";
  $aptBd->execute( $query ); */

$sql = "
	SELECT 
		T_DES_ESCRITURACION.seqFormulario,
		T_CIU_CIUDADANO.numDocumento,
		CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2) AS Nombre,
		T_DES_ESCRITURACION.seqEscrituracion,
		T_DES_ESCRITURACION.seqDesembolso,
		T_FRM_ESTADO_PROCESO.txtEstadoProceso AS 'Estado Proceso',               
		pry.txtNombreProyecto AS 'Proyecto',
		con.txtNombreProyecto AS 'Conjunto Residencial',
		T_DES_ESCRITURACION.txtDireccionInmueble AS 'Dirección Inmueble',
		T_DES_ESCRITURACION.txtBarrio AS 'Barrio',
		T_FRM_LOCALIDAD.txtLocalidad AS 'Localidad',
		IF (T_FRM_FORMULARIO.seqTipoEsquema = 1, T_PRY_UNIDAD_PROYECTO.valSDVEActual, T_FRM_FORMULARIO.valAspiraSubsidio) AS 'Valor Subsidio',
		T_DES_ESCRITURACION.txtEscritura AS 'Escritura',
		T_DES_ESCRITURACION.numNotaria AS 'Notaría',
		T_DES_ESCRITURACION.fchEscritura AS 'Fecha Escritura',
		T_DES_ESCRITURACION.numAvaluo AS 'No. Avalúo',
		T_DES_ESCRITURACION.valInmueble AS 'Valor Inmueble',
		T_DES_ESCRITURACION.txtChip AS 'Chip',
		T_DES_ESCRITURACION.txtMatriculaInmobiliaria AS 'Matrícula Inmobiliaria',
		T_DES_ESCRITURACION.numValorInmueble AS 'Valor Inmueble',
		T_DES_ESCRITURACION.bolViabilizoJuridico AS 'Viabilizó Jurídico',
		T_DES_ESCRITURACION.bolviabilizoTecnico AS 'Viabilizó Técnico',
		#T_DES_ESCRITURACION.txtCompraVivienda AS 'Compra Vivienda',
		#T_DES_ESCRITURACION.txtTipoPredio AS 'Tipo Predio',
		T_DES_ESCRITURACION.txtCedulaCatastral AS 'Cédula Catastral',
		T_DES_ESCRITURACION.numAreaConstruida AS 'Area Construída',
		T_DES_ESCRITURACION.numAreaLote AS 'Area Lote',
		#T_DES_ESCRITURACION.txtTipoDocumentos AS 'Tipo Documentos',
		#T_DES_ESCRITURACION.numEstrato AS 'Estrato',
		#T_DES_ESCRITURACION.txtCiudad AS 'Ciudad',
		T_FRM_CIUDAD.txtCiudad AS 'Ciudad',
		T_DES_ESCRITURACION.txtNombreVendedor AS 'Nombre Vendedor',
		T_DES_ESCRITURACION.numDocumentoVendedor AS 'Documento Vendedor',
		#T_DES_ESCRITURACION.numTelefonoVendedor AS 'Telefono Vendedor',
		#T_DES_ESCRITURACION.numTelefonoVendedor2 AS 'Teléfono 2 Vendedor',
		#T_DES_ESCRITURACION.txtCorreoVendedor AS 'Correo Vendedor',
		T_DES_ESTUDIO_TITULOS.seqEstudioTitulos,
		T_DES_ESTUDIO_TITULOS.numEscrituraIdentificacion AS 'No. Escritura Identificación',
		T_DES_ESTUDIO_TITULOS.fchEscrituraIdentificacion AS 'Fecha Escritura Identificación',
		T_DES_ESTUDIO_TITULOS.numNotariaIdentificacion AS 'Notaría Identificación',
		T_DES_ESTUDIO_TITULOS.numEscrituraTitulo AS 'No. Escritura Título',
		T_DES_ESTUDIO_TITULOS.fchEscrituraTitulo AS 'Fecha Escritura Título',
		T_DES_ESTUDIO_TITULOS.numNotariaTitulo AS 'Notaría Título',
		T_DES_ESTUDIO_TITULOS.txtZonaMatricula AS 'Zona Matrícula',
		T_DES_ESTUDIO_TITULOS.txtCiudadMatricula AS 'Ciudad Matrícula',
		T_DES_ESTUDIO_TITULOS.fchMatricula AS 'Fecha Matrícula',
		T_DES_ESTUDIO_TITULOS.txtAprobo AS 'Aprobó',
		GROUP_CONCAT(txtAdjunto SEPARATOR ' (*) ') AS 'Adjuntos Estudio Títulos',
                IF(T_DES_ESCRITURACION.txtChip != '', 'NO', 'OK') AS 'Validar Chip',
                IF(T_DES_ESCRITURACION.numValorInmueble > 0, 'OK', 'NO')
                   AS 'Validar Valor Inmueble',
                IF(T_DES_ESCRITURACION.numAvaluo > 0, 'OK', 'NO')
                   AS 'Validar Avaluo',
                IF(T_DES_ESCRITURACION.bolViabilizoJuridico != 1, 'NO', 'OK')
                   AS 'Validar Viabilizó Jurídico',
                IF(T_DES_ESCRITURACION.bolviabilizoTecnico != 1, 'NO', 'OK')
                   AS 'Validar Viabilizó Técnico',
                IF(T_DES_ESCRITURACION.txtCedulaCatastral != '', 'NO', 'OK')
                   AS 'Validar Cedula Catastral',
                IF(T_DES_ESCRITURACION.numAreaConstruida != '', 'OK', 'NO')
                   AS 'Validar Area Construída',
                IF(T_DES_ESCRITURACION.numAreaLote != '', 'OK', 'NO')
                   AS 'Validar Area Lote',
                IF(T_DES_ESTUDIO_TITULOS.txtZonaMatricula != '', 'OK', 'NO')
              AS 'Validar Zona MAtricula',
                IF(T_DES_ESTUDIO_TITULOS.txtCiudadMatricula != '', 'OK', 'NO')
              AS 'Validar Ciudad Matrícula',
                IF(T_DES_ESTUDIO_TITULOS.fchMatricula != '', 'OK', 'NO')
              AS 'Validar Fecha Matrícula',
                IF(T_DES_ESTUDIO_TITULOS.txtAprobo != '', 'OK', 'NO')
              AS 'Validar Apobo',         
              IF(
                   T_DES_ESTUDIO_TITULOS.numEscrituraTitulo = T_DES_ESCRITURACION.txtEscritura AND T_DES_ESTUDIO_TITULOS.numEscrituraTitulo =
                 T_DES_ESTUDIO_TITULOS.numEscrituraIdentificacion,
                   'OK',
                   'NO')
                   AS 'Validar Escritura',
                   IF(
                   T_DES_ESCRITURACION.numNotaria = T_DES_ESTUDIO_TITULOS.numNotariaIdentificacion AND T_DES_ESCRITURACION.numNotaria =
                 T_DES_ESTUDIO_TITULOS.numNotariaTitulo,
                   'OK',
                   'NO')
                   AS 'Validar Notaria',
            IF(
                T_DES_ESCRITURACION.fchEscritura = T_DES_ESTUDIO_TITULOS.fchEscrituraIdentificacion AND T_DES_ESTUDIO_TITULOS.fchEscrituraTitulo =
              T_DES_ESCRITURACION.fchEscritura,
                'OK',
                'NO')
                AS 'Validar Fecha Escritura',
                IF( T_FRM_ESTADO_PROCESO.seqEstadoProceso = 29, 'OK', 'NO') AS 'Validar Estado Proceso '
	FROM 
		T_DES_ESCRITURACION
		LEFT JOIN T_DES_DESEMBOLSO ON (T_DES_ESCRITURACION.seqDesembolso = T_DES_DESEMBOLSO.seqDesembolso)
		LEFT JOIN T_DES_ESTUDIO_TITULOS ON (T_DES_DESEMBOLSO.seqDesembolso = T_DES_ESTUDIO_TITULOS.seqDesembolso)
		LEFT JOIN T_DES_ADJUNTOS_TITULOS ON (T_DES_ESTUDIO_TITULOS.seqEstudioTitulos = T_DES_ADJUNTOS_TITULOS.seqEstudioTitulos)
		INNER JOIN T_FRM_FORMULARIO ON (T_DES_ESCRITURACION.seqFormulario = T_FRM_FORMULARIO.seqFormulario)
		INNER JOIN T_FRM_HOGAR ON (T_FRM_FORMULARIO.seqFormulario = T_FRM_HOGAR.seqFormulario)
		INNER JOIN T_CIU_CIUDADANO ON (T_CIU_CIUDADANO.seqCiudadano = T_FRM_HOGAR.seqCiudadano)
		INNER JOIN T_FRM_ESTADO_PROCESO ON (T_FRM_FORMULARIO.seqEstadoProceso = T_FRM_ESTADO_PROCESO.seqEstadoProceso)
		LEFT JOIN T_FRM_LOCALIDAD ON (T_DES_ESCRITURACION.seqLocalidad = T_FRM_LOCALIDAD.seqLocalidad)
		LEFT JOIN T_FRM_CIUDAD ON (T_DES_ESCRITURACION.seqCiudad = T_FRM_CIUDAD.seqCiudad)
		LEFT JOIN T_PRY_PROYECTO pry ON (T_FRM_FORMULARIO.seqProyecto = pry.seqProyecto)
		LEFT JOIN T_PRY_PROYECTO con ON (T_FRM_FORMULARIO.seqProyectoHijo = con.seqProyecto)
		LEFT JOIN T_PRY_UNIDAD_PROYECTO ON (T_FRM_FORMULARIO.seqUnidadProyecto = T_PRY_UNIDAD_PROYECTO.seqUnidadProyecto)
	WHERE
		$txtCondicion and t_des_estudio_titulos.seqEstudioTitulos is not null
	GROUP BY 
		T_DES_ESCRITURACION.seqFormulario
";
//echo $sql;die();
$objRes = $aptBd->execute($sql);
$txtNombreArchivo = "ReporteEscrituracion" . date("Ymd_His") . ".xls";

$claReportes = new Reportes;
$claReportes->obtenerReportesGeneral($objRes, $txtNombreArchivo);
?>