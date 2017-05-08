<?php

/**
 * REPORTE DE DESEMBOLSO TRAMITE
 * @author Diego Gaitan
 * @version 1.0 Julio 2010
 */
$txtPrefijoRuta = "../../";

include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Reportes.class.php" );

// Nombre del archivo exportable
//	$txtNombreArchivo = "reporteSeguimiento_" . date( "Ymd_His" ) . ".csv"; 

$fechaIni = $_POST['fchInicio'];
$fechaFin = $_POST['fchFin'];
$gestion = $_POST['seqGestion'];
$seqGrupoGestion = $_POST['seqGrupo'];
$arrSeqSeguimiento = array();
$arrCondicionSeqSeguimiento = array();

if ($fechaIni) {
    $arrCondicionSeqSeguimiento[] = "seg.fchMovimiento >= '$fechaIni'";
}
if ($fechaFin) {
    $arrCondicionSeqSeguimiento[] = "seg.fchMovimiento <= '$fechaFin'";
}
if ($gestion) {
    $arrCondicionSeqSeguimiento[] = "seg.seqGestion = $gestion";
}
if ($seqGrupoGestion) {
    $arrCondicionSeqSeguimiento[] = "gge.seqGrupoGestion = $seqGrupoGestion";
}

if (!empty($arrCondicionSeqSeguimiento)) {
    $txtCondicionSeqGeguimiento = implode(" and ", $arrCondicionSeqSeguimiento);
    $sql = "select 
				distinct seg.seqFormulario
				from T_SEG_SEGUIMIENTO seg ";
    if ($seqGrupoGestion) {
        $sql .= "INNER JOIN T_SEG_GESTION ges ON seg.seqGestion = ges.seqGestion
					INNER JOIN T_SEG_GRUPO_GESTION gge ON ges.seqGrupoGestion = gge.seqGrupoGestion";
    }
    $sql .= " where $txtCondicionSeqGeguimiento";
    $objRes = $aptBd->execute($sql);
    while ($objRes->fields) {
        $arrSeqSeguimiento[] = $objRes->fields['seqFormulario'];
        $objRes->MoveNext();
    }
    $txtSeqSeguimiento = ( empty($arrSeqSeguimiento) ) ? "null" : implode(',', $arrSeqSeguimiento);
    $arrCondiciones[] = "frm.seqFormulario in ($txtSeqSeguimiento)";
}

$arrCondiciones[] = "hog.seqParentesco = 1";

$txtCondicion = implode(" and ", $arrCondiciones);

$sql = "
        SELECT
                ciu.numDocumento as Documento,
                des.seqFormulario,
                des.seqDesembolso,
                upper(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
                des.numDocumentoVendedor as DocumentoVendedor,
                des.txtNombreVendedor as NombreVendedor,
                des.numTelefonoVendedor as TelefonoVendedor,
                des.txtCorreoVendedor as CorreoVendedor,
                dsol.numDocumentoBeneficiarioGiro as DocumentoBeneficiarioDelGiro,
                dsol.txtNombreBeneficiarioGiro as NombreBeneficiarioDelGiro,
                dsol.numTelefonoGiro as NumeroTelefonoGiro,
                dsol.txtCorreoGiro as CorreoElectronicoGiro,
                dsol.txtDireccionBeneficiarioGiro as DireccionBeneficiarioDelGiro,
                dsol.numCuentaGiro as CuentaGiro,
                ban.txtBanco as BancoGiro,
                dsol.txtTipoCuentaGiro as TipoCuentaGiro,
                dsol.valSolicitado as ValorDesembolso,
                dsol.numRadiacion,
                dsol.fchRadicacion, 
                dsol.valOrden,
                dsol.numOrden,
                dsol.fchOrden,           
                moa.txtModalidad as Modalidad
        FROM T_FRM_FORMULARIO frm
        INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario
        INNER JOIN T_CIU_CIUDADANO ciu on hog.seqCiudadano = ciu.seqCiudadano
        INNER JOIN T_DES_DESEMBOLSO des on des.seqFormulario = frm.seqFormulario
        INNER JOIN T_DES_SOLICITUD dsol on dsol.seqDesembolso = des.seqDesembolso
        INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
        INNER JOIN T_FRM_BANCO ban ON dsol.seqBancoGiro = ban.seqBanco
        WHERE $txtCondicion 
	";

$objRes = $aptBd->execute($sql);
$nombreArchivo = "ReporteDesembolsoTraslado";
$txtNombreArchivo = $nombreArchivo . date("Ymd_His") . ".xls";

$claReportes = new Reportes;
$claReportes->obtenerReportesGeneral($objRes, $txtNombreArchivo);
?>
