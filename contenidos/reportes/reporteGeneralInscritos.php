<?php

/* * *********************************
 * REPORTE GENERAL INSCRITOS
 * @author Andres Martinez
 * @version 1.0 - Mayo 2016
 * ********************************** */
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

$fechaIni = $_POST['fchInicio'];
$fechaFin = $_POST['fchFin'];

if ($fechaIni) {
    $arrCondiciones[] = "frm.fchInscripcion >= '$fechaIni'";
}
if ($fechaFin) {
    $arrCondiciones[] = "frm.fchInscripcion <= '$fechaFin'";
}

$arrCondiciones[] = "ciu.numDocumento >= 0";

if( empty( $arrSeqFormularios ) ) {
    $arrCondiciones[] = "frm.bolCerrado = 0";
}else{
    $arrCondiciones[] = "frm.seqFormulario IN (" . implode(",",$arrSeqFormularios) . ")";
}

$arrCondiciones[] = "hog.seqParentesco = 1";

$txtCondicion = implode(" and ", $arrCondiciones);

$sql = "
    SELECT 
        frm.seqFormulario,
        frm.txtFormulario,
        upper(concat(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'Nombre',
        ciu.numDocumento AS 'Documento',
        concat(eta.txtEtapa, ' - ', epr.txtEstadoProceso) AS 'Estado del Proceso',
        frm.seqEstadoProceso AS seqEstado,
        IF(
            (
                (frm.fchUltimaActualizacion > '2013-05-11') OR 
                (frm.fchInscripcion         > '2013-05-11')
            ) AND (
                ciu.fchNacimiento <> '0000-00-00' AND 
                frm.seqEstadoProceso <> 5  AND          #Renuncia 
                frm.seqEstadoProceso <> 8  AND          #Inhabilitado 
                frm.seqEstadoProceso <> 13 AND          #Inscrito Inhabilitado 
                frm.seqEstadoProceso <> 14 AND          #Renuncia
                frm.seqEstadoProceso <> 18 AND          #Renuncia 
                frm.seqEstadoProceso <> 35 AND          #Inscrito Inactivo 
                frm.seqEstadoProceso <> 39 AND          #Inscrito Inhabilitado 
                frm.seqEstadoProceso <> 52              #Inhabilitado
            ),               
            'ACTIVO',
            'INACTIVO'
        ) AS 'Activo / Inactivo',
        tvh.txtDesplazado AS 'Hogar Victima',
        moa.txtModalidad AS 'Modalidad',
        frm.seqModalidad AS 'SeqModalidad',
        CASE
            WHEN frm.seqModalidad = 1 THEN 'Adquisición de Vivienda Nueva'
            WHEN frm.seqModalidad = 2 THEN 'Construcción en Sitio Propio'
            WHEN frm.seqModalidad = 3 THEN 'Mejoramiento Habitacional'
            WHEN frm.seqModalidad = 5 THEN 'Adquisición de Vivienda Nueva'
            ELSE moa.txtModalidad
        END AS 'NModalidad',
        frm.valIngresoHogar AS 'Ingreso Total',          
        CASE
            WHEN (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") <= 0  THEN '0 SMMLV'
            WHEN (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") > 0 AND (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") <= 1 THEN '1 - < 1 SMMLV'
            WHEN (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") > 1 AND (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") < 2  THEN '1 - < 2 SMMLV'
            WHEN (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") >= 2 AND (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") < 3 THEN '2 - < 3  SMMLV'
            WHEN (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") >= 3 AND (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") < 4 THEN '3 - >4 SMMLV'          
            WHEN (frm.valIngresoHogar/" . $arrConfiguracion['constantes']['salarioMinimo'] . ") >= 4  THEN '> 4 SMMLV'
        END AS 'Rango Total',
        frm.valTotalRecursos AS 'Total Recursos Hogar',
        CASE
            WHEN frm.valTotalRecursos = 0 THEN '$0'
            WHEN frm.valTotalRecursos BETWEEN 0        AND 2500000  THEN '$1    -< $2.5M'
            WHEN frm.valTotalRecursos BETWEEN 2500000  AND 5000000  THEN '$2.5M -< $5M'
            WHEN frm.valTotalRecursos BETWEEN 5000000  AND 10000000 THEN '$5M   -< $10M' 
            WHEN frm.valTotalRecursos BETWEEN 10000000 AND 15000000 THEN '$10M  -< $15M'
            WHEN frm.valTotalRecursos BETWEEN 15000000 AND 20000000 THEN '$15M  -< $20M'
            WHEN frm.valTotalRecursos BETWEEN 20000000 AND 25000000 THEN '$20M  -< $25M'
            WHEN frm.valTotalRecursos BETWEEN 25000000 AND 25820095 THEN '$25M  -< $25820095'
            WHEN frm.valTotalRecursos >= 25820095 THEN '> $25820095'
        END AS 'Rango Cierre Financiero',
        IF(
            (    
                tvh.txtDesplazado = 'Victima' AND 
                frm.valTotalRecursos >= 25820095 AND 
                (   
                    frm.seqModalidad = 1  OR #Adquisición de Vivienda 
                    frm.seqModalidad = 5  OR #Arrendamiento
                    frm.seqModalidad = 6  OR #Adquisición de Vivienda Nueva
                    frm.seqModalidad = 11 OR #Adquisición de Vivienda Usada
                    frm.seqModalidad = 12 OR #Con cierre financiero (plan3)
                    frm.seqModalidad = 13    #Sin cierre financiero Leasing (plan3)
                )
            ) OR  
            frm.seqModalidad = 10 OR #Mejoramiento en Redensificación
            frm.seqModalidad = 4  OR #Mejoramiento Estructural
            frm.seqModalidad = 8  OR #Mejoramiento Estructural
            frm.seqModalidad = 9  OR #Mejoramiento Habitacional
            frm.seqModalidad = 3  OR #Mejoramiento de Habitabilidad
            frm.seqModalidad = 7  OR #Construcción en Sitio Propio
            frm.seqModalidad = 2  OR #Construcción
            frm.valTotalRecursos >= 25820095 AND (   
                frm.seqModalidad = 1  OR  #Adquisición de Vivienda
                frm.seqModalidad = 5  OR  #Arrendamiento
                frm.seqModalidad = 6  OR  #Adquisición de Vivienda Nueva
                frm.seqModalidad = 11 OR  #Adquisición de Vivienda Usada
                frm.seqModalidad = 12 OR  #Con cierre financiero (plan3)
                frm.seqModalidad = 13     #Leasing (plan3)
            ),    
            'CON CIERRE',
            'SIN CIERRE'
        ) AS 'cierre financiero',
        eta.txtEtapa AS 'Etapa',
        DATE_FORMAT(ciu.fchNacimiento, '%d-%m-%Y') AS 'Fecha de Nacimiento',
        DATE_FORMAT(frm.fchInscripcion, '%d-%m-%Y') AS 'Fecha de Inscripcion',
        DATE_FORMAT(frm.fchUltimaActualizacion, '%d-%m-%Y') AS 'Fecha Ultima Actualizacion',
        loc.txtLocalidad AS 'Localidad',
        frm.numTelefono1 AS 'Telefono Fijo 1',
        frm.numTelefono2 AS 'Telefono Fijo 2',
        frm.numCelular AS 'Telefono Celular',
        frm.txtCorreo AS 'Correo Electronico',
        pun.txtPuntoAtencion AS 'Punto de Atencion',
        IF(frm.bolCerrado = 1, 'SI', 'NO') AS 'Formulario Cerrado',
        pro.txtNombreProyecto AS 'Proyecto',
        upper(frm.txtMatriculaInmobiliaria) AS 'Matricula Inmobiliaria',
        frm.valIngresoHogar AS 'Ingresos del Hogar',
        frm.valSaldoCuentaAhorro AS 'Saldo Cuenta Ahorro 1',
        ba1.txtBanco AS 'Banco Cuenta Ahorro 1',
        upper(frm.txtSoporteCuentaAhorro) AS 'Soporte Cuenta Ahorro 1',
        IF(frm.bolInmovilizadoCuentaAhorro = 1, 'SI', 'NO') AS 'Cuenta Ahorro 1 Inmobilizada',
        DATE_FORMAT(frm.fchAperturaCuentaAhorro, '%d-%m-%Y') AS 'Fecha Apertura Cuenta Ahorro 1',
        frm.valSaldoCuentaAhorro2 AS 'Saldo Cuenta Ahorro 2',
        ba2.txtBanco AS 'Banco Cuenta Ahorro 2',
        upper(frm.txtSoporteCuentaAhorro2) AS 'Soporte Cuenta Ahorro 2',
        IF(frm.bolInmovilizadoCuentaAhorro2 = 1, 'SI', 'NO') AS 'Cuenta Ahorro 2 Inmobilizada',
        DATE_FORMAT(frm.fchAperturaCuentaAhorro2, '%d-%m-%Y') AS 'Fecha Apertura Cuenta Ahorro 2',
        frm.valSubsidioNacional AS 'Valor Subsidio (AVC / FOVIS / SFV)',
        upper(frm.txtSoporteSubsidioNacional) AS 'Soporte Subsidio (AVC / FOVIS / SFV)',
        ccf.txtEntidadSubsidio AS 'Entidad Subsidio (AVC / FOVIS / SFV)',
        frm.valAporteLote AS 'Valor Aporte Lote',
        frm.valSaldoCesantias AS 'Valor Cesantias',
        upper(frm.txtSoporteCesantias) AS 'Soporte Cesantias',
        frm.valAporteAvanceObra AS 'Valor Aporte Avance Obra',
        upper(frm.txtSoporteAvanceObra) AS 'Soporte Avance Obra',
        frm.valCredito AS 'Valor Credito',
        bcr.txtBanco AS 'Banco Credito',
        upper(frm.txtSoporteCredito) AS 'Soporte Credito',
        DATE_FORMAT(frm.fchAprobacionCredito, '%d-%m-%Y') AS 'Fecha Vencimiento del Credito',
        frm.valAporteMateriales AS 'Valor Aporte Materiales',
        upper(frm.txtSoporteAporteMateriales) AS 'Soporte Aporte Materiales',
        frm.valDonacion AS 'Valor Donacion / V.U.R.',
        edo.txtEmpresaDonante AS 'Empresa Donante / V.U.R.',
        upper(frm.txtSoporteDonacion) AS 'Soporte Donacion / V.U.R.',
        upper(frm.txtSoporteSubsidio) AS 'Soporte Cambio Valor Subsidio',
        frm.valTotalRecursos AS 'Total Recursos Hogar'
    FROM T_FRM_FORMULARIO frm
        INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
        INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
        INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
        INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
        INNER JOIN T_FRM_LOCALIDAD loc ON frm.seqLocalidad = loc.seqLocalidad
        INNER JOIN T_FRM_TIPO_VICTIMA_HOGAR tvh ON frm.bolDesplazado = tvh.bolDesplazado
        INNER JOIN T_FRM_PUNTO_ATENCION pun ON frm.seqPuntoAtencion = pun.seqPuntoAtencion
        INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
        LEFT JOIN T_PRY_PROYECTO pro ON frm.seqProyecto = pro.seqProyecto
        INNER JOIN T_FRM_BANCO ba1 ON frm.seqBancoCuentaAhorro = ba1.seqBanco
        INNER JOIN T_FRM_BANCO ba2 ON frm.seqBancoCuentaAhorro2 = ba2.seqBanco
        INNER JOIN T_FRM_ENTIDAD_SUBSIDIO ccf ON frm.seqEntidadSubsidio = ccf.seqEntidadSubsidio
        INNER JOIN T_FRM_BANCO bcr ON frm.seqBancoCredito = bcr.seqBanco
        INNER JOIN T_FRM_EMPRESA_DONANTE edo ON frm.seqEmpresaDonante = edo.seqEmpresaDonante
    WHERE $txtCondicion ";

//echo $sql;die();

$objRes = $aptBd->execute($sql);
$txtNombreArchivo = "reporteGenralInscritos" . date("Ymd_His") . ".xls";

$claReportes = new Reportes;
$claReportes->obtenerReportesGeneral($objRes, $txtNombreArchivo);

?>