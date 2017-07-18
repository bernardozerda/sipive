<?php
include_once "../lib/mysqli/shared/ez_sql_core.php";
include_once "../lib/mysqli/ez_sql_mysqli.php";

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<link href="../../../librerias/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../../../librerias/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="../../../librerias/bootstrap/css/bootstrap-theme.css" rel="stylesheet">

<?php
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
    $nombreArchivo = $_FILES['archivo']['tmp_name'];

    $lineas = file($nombreArchivo);
//var_dump($lineas);    exit();
    $registros = 0;
//$db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidiosJul17', 'localhost');
    $db = new ezSQL_mysqli('sdht_usuario', 'Ochochar*1', 'sdht_subsidios', 'localhost');
    $intV = 1;
    $intNV = 1;
    $band = 0;
    $cant = count($lineas);
    $title = explode("\t", $lineas[0]);
    $band = true;
    if (count($title) > 3 && in_array("Documento", $title)) {
        unset($lineas[0]);
        $band = true;
    } else {
        $band = false;
        echo "<p class='alert alert-danger'>Verifique los Titulos del archivo</p>";
        exit();
    }
    $msnError = "<p class='alert alert-danger'> Verifique los datos del siguiente documento ";
    $msnExitoso = "<p class='alert alert-success'> Los datos se registrarón con éxito para el(los) documento(s) N° ";
//var_dump($lineas);
    foreach ($lineas as $linea_num => $linea) {
        $datos = explode("\t", $linea);
        $documento = $datos[0];
        $seqFormulario = $datos[1];
        $seqDesembolso = $datos[2];
        $numActo = $datos[3];

        $sql = "SELECT seqCiudadano, seqFormularioActo, numActo from t_ciu_ciudadano 
                INNER JOIN t_frm_hogar USING(seqCiudadano)
                INNER JOIN t_frm_formulario USING(seqFormulario)
                INNER JOIN t_des_escrituracion ON(t_frm_formulario.seqFormulario = t_des_escrituracion.seqFormulario)
                INNER JOIN t_aad_formulario_acto ON(t_frm_formulario.seqFormulario = t_aad_formulario_acto.seqFormulario)
                INNER JOIN t_aad_hogares_vinculados  USING(seqFormularioActo)
                WHERE numDocumento = " . $documento . " AND t_frm_formulario.seqFormulario = " . $seqFormulario . " AND numActo = " . $numActo . " AND seqDesembolso = " . $seqDesembolso;

        $resultado = $db->get_results($sql);
        if ($resultado) {
            $sql = "SELECT * FROM t_des_primera_escrituracion WHERE seqDesembolso =" . $seqDesembolso . " AND seqFormulario = " . $seqFormulario . " AND numActo = " . $numActo;
            $resulT = $db->get_results($sql);
            if ($resulT) {
                $msnError .= "<p class='alert alert-danger'>El documento  " . $documento . " ya se encuentra registrado!!!</p>";
            } else {
                $query = "INSERT INTO t_des_primera_escrituracion(seqEscrituracion,
                                seqDesembolso,
                                seqFormulario,
                                numEscrituraPublica,
                                numCertificadoTradicion,
                                numCartaAsignacion,
                                numAltoRiesgo,
                                numHabitabilidad,
                                numBoletinCatastral,
                                numLicenciaConstruccion,
                                numUltimoPredial,
                                numUltimoReciboAgua,
                                numUltimoReciboEnergia,
                                numOtros,
                                txtNombreVendedor,
                                numDocumentoVendedor,
                                txtDireccionInmueble,
                                txtBarrio,
                                seqLocalidad,
                                txtEscritura,
                                numNotaria,
                                fchEscritura,
                                numAvaluo,
                                valInmueble,
                                txtMatriculaInmobiliaria,
                                numValorInmueble,
                                txtEscrituraPublica,
                                txtCertificadoTradicion,
                                txtCartaAsignacion,
                                txtAltoRiesgo,
                                txtHabitabilidad,
                                txtBoletinCatastral,
                                txtLicenciaConstruccion,
                                txtUltimoPredial,
                                txtUltimoReciboAgua,
                                txtUltimoReciboEnergia,
                                txtOtro,
                                txtViabilizoJuridico,
                                txtViabilizoTecnico,
                                bolViabilizoJuridico,
                                bolviabilizoTecnico,
                                bolPoseedor,
                                txtChip,
                                numActaEntrega,
                                txtActaEntrega,
                                numCertificacionVendedor,
                                txtCertificacionVendedor,
                                numAutorizacionDesembolso,
                                txtAutorizacionDesembolso,
                                numFotocopiaVendedor,
                                txtFotocopiaVendedor,
                                seqTipoDocumento,
                                txtCompraVivienda,
                                txtNit,
                                txtRit,
                                txtRut,
                                numNit,
                                numRit,
                                numRut,
                                txtTipoPredio,
                                numTelefonoVendedor,
                                txtCedulaCatastral,
                                numAreaConstruida,
                                numAreaLote,
                                txtTipoDocumentos,
                                numEstrato,
                                txtCiudad,
                                fchCreacionBusquedaOferta,
                                fchActualizacionBusquedaOferta,
                                fchCreacionEscrituracion,
                                fchActualizacionEscrituracion,
                                numTelefonoVendedor2,
                                txtPropiedad,
                                fchSentencia,
                                numJuzgado,
                                txtCiudadSentencia,
                                numResolucion,
                                fchResolucion,
                                txtEntidad,
                                txtCiudadResolucion,
                                numContratoArrendamiento,
                                txtContratoArrendamiento,
                                numAperturaCAP,
                                txtAperturaCAP,
                                numCedulaArrendador,
                                txtCedulaArrendador,
                                numCuentaArrendador,
                                txtCuentaArrendador,
                                numRetiroRecursos,
                                txtRetiroRecursos,
                                numServiciosPublicos,
                                txtServiciosPublicos,
                                txtCorreoVendedor,
                                seqCiudad,
                                seqAplicacionSubsidio,
                                seqProyectosSoluciones
                                ) 
                                SELECT seqEscrituracion,
                                seqDesembolso,
                                seqFormulario,
                                numEscrituraPublica,
                                numCertificadoTradicion,
                                numCartaAsignacion,
                                numAltoRiesgo,
                                numHabitabilidad,
                                numBoletinCatastral,
                                numLicenciaConstruccion,
                                numUltimoPredial,
                                numUltimoReciboAgua,
                                numUltimoReciboEnergia,
                                numOtros,
                                txtNombreVendedor,
                                numDocumentoVendedor,
                                txtDireccionInmueble,
                                txtBarrio,
                                seqLocalidad,
                                txtEscritura,
                                numNotaria,
                                fchEscritura,
                                numAvaluo,
                                valInmueble,
                                txtMatriculaInmobiliaria,
                                numValorInmueble,
                                txtEscrituraPublica,
                                txtCertificadoTradicion,
                                txtCartaAsignacion,
                                txtAltoRiesgo,
                                txtHabitabilidad,
                                txtBoletinCatastral,
                                txtLicenciaConstruccion,
                                txtUltimoPredial,
                                txtUltimoReciboAgua,
                                txtUltimoReciboEnergia,
                                txtOtro,
                                txtViabilizoJuridico,
                                txtViabilizoTecnico,
                                bolViabilizoJuridico,
                                bolviabilizoTecnico,
                                bolPoseedor,
                                txtChip,
                                numActaEntrega,
                                txtActaEntrega,
                                numCertificacionVendedor,
                                txtCertificacionVendedor,
                                numAutorizacionDesembolso,
                                txtAutorizacionDesembolso,
                                numFotocopiaVendedor,
                                txtFotocopiaVendedor,
                                seqTipoDocumento,
                                txtCompraVivienda,
                                txtNit,
                                txtRit,
                                txtRut,
                                numNit,
                                numRit,
                                numRut,
                                txtTipoPredio,
                                numTelefonoVendedor,
                                txtCedulaCatastral,
                                numAreaConstruida,
                                numAreaLote,
                                txtTipoDocumentos,
                                numEstrato,
                                txtCiudad,
                                fchCreacionBusquedaOferta,
                                fchActualizacionBusquedaOferta,
                                fchCreacionEscrituracion,
                                fchActualizacionEscrituracion,
                                numTelefonoVendedor2,
                                txtPropiedad,
                                fchSentencia,
                                numJuzgado,
                                txtCiudadSentencia,
                                numResolucion,
                                fchResolucion,
                                txtEntidad,
                                txtCiudadResolucion,
                                numContratoArrendamiento,
                                txtContratoArrendamiento,
                                numAperturaCAP,
                                txtAperturaCAP,
                                numCedulaArrendador,
                                txtCedulaArrendador,
                                numCuentaArrendador,
                                txtCuentaArrendador,
                                numRetiroRecursos,
                                txtRetiroRecursos,
                                numServiciosPublicos,
                                txtServiciosPublicos,
                                txtCorreoVendedor,
                                seqCiudad,
                                seqAplicacionSubsidio,
                                seqProyectosSoluciones
                                FROM t_des_escrituracion where seqDesembolso = " . $seqDesembolso . " and seqFormulario = " . $seqFormulario;
                $resultset = $db->query($query);
                $insert_id = $db->insert_id;
                $update = "UPDATE t_des_primera_escrituracion SET numActo = " . $numActo . " WHERE seqPrimeraEscrituracion = " . $insert_id;
                $result = $db->query($update);
                $msnExitoso .= $documento ."<br>";
                
            }
        } else {
            $msnError .=  $documento . "<br>";
//exit();
        }
    }
    if (!empty($msnError)) {
        echo $msnError."</p>";
    }
    if (!empty($msnExitoso)) {
        echo $msnExitoso ."</p>";
    }
}
