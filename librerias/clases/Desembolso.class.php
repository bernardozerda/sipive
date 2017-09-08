<?php

/**
 * CLASE PARA MANIPULAR TODAS LAS OPERACIONES DE DESEMBOLSOS
 * @author Bernardo Zerda
 */
class Desembolso {

    public $seqDesembolso;
    public $seqFormulario;
    public $numEscrituraPublica;
    public $numCertificadoTradicion;
    public $numCartaAsignacion;
    public $numAltoRiesgo;
    public $numHabitabilidad;
    public $numBoletinCatastral;
    public $numLicenciaConstruccion;
    public $numUltimoPredial;
    public $numUltimoReciboAgua;
    public $numUltimoReciboEnergia;
    public $numOtros;
    public $txtNombreVendedor;
    public $numDocumentoVendedor;
    public $txtDireccionInmueble;
    public $txtBarrio;
    public $seqLocalidad;
    public $txtEscritura;
    public $numNotaria;
    public $fchEscritura;
    public $numAvaluo;
    public $valInmueble;
    public $txtMatriculaInmobiliaria;
    public $numValorInmueble;
    public $txtEscrituraPublica;
    public $txtCertificadoTradicion;
    public $txtCartaAsignacion;
    public $txtAltoRiesgo;
    public $txtHabitabilidad;
    public $txtBoletinCatastral;
    public $txtLicenciaConstruccion;
    public $txtUltimoPredial;
    public $txtUltimoReciboAgua;
    public $txtUltimoReciboEnergia;
    public $txtOtros;
    public $txtViabilizoJuridico;
    public $txtViabilizoTecnico;
    public $bolViabilizoJuridico;
    public $bolviabilizoTecnico;
    public $bolPoseedor;
    public $seqSeguimiento;
    public $txtChip;
    public $seqTipoDocumento;
    public $numAreaLote;
    public $numAreaConstruida;
    public $txtCedulaCatastral;
    public $numRut;
    public $txtRut;
    public $numRit;
    public $txtRit;
    public $numNit;
    public $txtNit;
    public $arrJuridico;
    public $arrTecnico;
    public $arrTitulos;
    public $arrSolicitud;
    public $txtCiudadMatricula;
    public $txtFlujo;
    public $seqCiudad;

    public function Desembolso() {

        $this->seqDesembolso = null;
        ;
        $this->seqFormulario = null;
        $this->numEscrituraPublica = null;
        $this->numCertificadoTradicion = null;
        $this->numCartaAsignacion = null;
        $this->numAltoRiesgo = null;
        $this->numHabitabilidad = null;
        $this->numBoletinCatastral = null;
        $this->numLicenciaConstruccion = null;
        $this->numUltimoPredial = null;
        $this->numUltimoReciboAgua = null;
        $this->numUltimoReciboEnergia = null;
        $this->numOtros = null;
        $this->txtNombreVendedor = null;
        $this->numDocumentoVendedor = null;
        $this->txtDireccionInmueble = null;
        $this->txtBarrio = null;
        $this->seqLocalidad = null;
        $this->txtEscritura = null;
        $this->numNotaria = null;
        $this->fchEscritura = null;
        $this->numAvaluo = null;
        $this->valInmueble = null;
        $this->txtMatriculaInmobiliaria = null;
        $this->numValorInmueble = null;
        $this->txtEscrituraPublica = null;
        $this->txtCertificadoTradicion = null;
        $this->txtCartaAsignacion = null;
        $this->txtAltoRiesgo = null;
        $this->txtHabitabilidad = null;
        $this->txtBoletinCatastral = null;
        $this->txtLicenciaConstruccion = null;
        $this->txtUltimoPredial = null;
        $this->txtUltimoReciboAgua = null;
        $this->txtUltimoReciboEnergia = null;
        $this->txtOtros = null;
        $this->txtViabilizoJuridico = null;
        $this->txtViabilizoTecnico = null;
        $this->bolViabilizoJuridico = null;
        $this->bolviabilizoTecnico = null;
        $this->bolPoseedor = null;
        $this->seqSeguimiento = null;
        $this->txtChip = null;
        $this->seqTipoDocumento = null;
        $this->numAreaLote = null;
        $this->numAreaConstruida = null;
        $this->txtCedulaCatastral = null;
        $this->numRut = null;
        $this->txtRut = null;
        $this->numRit = null;
        $this->txtRit = null;
        $this->numNit = null;
        $this->txtNit = null;
        $this->arrJuridico = null;
        $this->arrTecnico = null;
        $this->arrTitulos = null;
        $this->arrSolicitud = null;
        $this->txtCiudadMatricula = utf8_encode("Bogot�");
        $this->txtFlujo = null;
        $this->seqCiudad = null;
    }

// Fin constructor

    public function cargarDesembolso($seqFormulario) {

        global $aptBd;

        $sql = "
				SELECT
					des.bolPoseedor,
					des.bolViabilizoJuridico,
					des.bolViabilizoTecnico,
					des.fchEscritura,
					des.numActaEntrega,
					des.numAltoRiesgo,
					des.numAutorizacionDesembolso,
					des.numAvaluo,
					des.numBoletinCatastral,
					des.numCartaAsignacion,
					des.numCertificacionVendedor,
					des.numCertificadoTradicion,
					des.numDocumentoVendedor,
					des.numEscrituraPublica,
					des.numFotocopiaVendedor,
					des.numHabitabilidad,
					des.numLicenciaConstruccion,
					des.numNotaria,
					des.numOtros,
					des.numUltimoPredial,
					des.numUltimoReciboAgua,
					des.numUltimoReciboEnergia,
					des.numValorInmueble,
					des.seqDesembolso,
					des.seqFormulario,
					des.seqLocalidad,
					ucwords(des.txtActaEntrega) as txtActaEntrega,
					ucwords(des.txtAltoRiesgo) as txtAltoRiesgo,
					ucwords(des.txtAutorizacionDesembolso) as txtAutorizacionDesembolso,
					ucwords(des.txtBarrio) as txtBarrio,
					ucwords(des.txtBoletinCatastral) as txtBoletinCatastral,
					ucwords(des.txtCartaAsignacion) as txtCartaAsignacion,
					ucwords(des.txtCertificacionVendedor) as txtCertificacionVendedor,
					ucwords(des.txtCertificadoTradicion) as txtCertificadoTradicion,
					UPPER( ucwords(des.txtChip) )as txtChip,
					ucwords(des.txtDireccionInmueble) as txtDireccionInmueble,
					ucwords(des.txtEscritura) as txtEscritura,
					ucwords(des.txtEscrituraPublica) as txtEscrituraPublica,
					ucwords(des.txtFotocopiaVendedor) as txtFotocopiaVendedor,
					ucwords(des.txtHabitabilidad) as txtHabitabilidad,
					ucwords(des.txtLicenciaConstruccion) as txtLicenciaConstruccion,
					UPPER( ucwords(des.txtMatriculaInmobiliaria) )as txtMatriculaInmobiliaria,
					ucwords(des.txtNombreVendedor) as txtNombreVendedor,
					ucwords(des.txtOtro) as txtOtro,
					ucwords(des.txtUltimoPredial) as txtUltimoPredial,
					ucwords(des.txtUltimoReciboAgua) as txtUltimoReciboAgua,
					ucwords(des.txtUltimoReciboEnergia) as txtUltimoReciboEnergia,
					ucwords(des.txtViabilizoJuridico) as txtViabilizoJuridico,
					ucwords(des.txtViabilizoTecnico) as txtViabilizoTecnico,
					ucwords(des.valInmueble) as valInmueble,
			 		des.seqTipoDocumento,
					des.numAreaLote,
					des.numAreaConstruida,
					des.txtCedulaCatastral,
					des.numTelefonoVendedor,
					des.numTelefonoVendedor2,
					des.txtTipoPredio,
					des.numRut,
					des.txtRut,
					des.numRit,
					des.txtRit,
					des.numNit,
					des.txtNit,
					des.txtCompraVivienda,
					des.numEstrato,
					des.txtTipoDocumentos,
					ucwords(des.txtCiudad) as txtCiudad,
					des.fchCreacionBusquedaOferta,
					des.fchActualizacionBusquedaOferta,
					des.fchCreacionEscrituracion,
					des.fchActualizacionEscrituracion,
					des.txtPropiedad,
					des.fchSentencia,
					des.numJuzgado,
					des.txtCiudadSentencia,
					des.numResolucion,
					des.fchResolucion,
					des.txtEntidad,
					des.txtCiudadResolucion,
					des.numContratoArrendamiento,
					des.numAperturaCAP,
					des.txtAperturaCAP,
					des.numCedulaArrendador,
					des.numCuentaArrendador,
					des.txtCuentaArrendador,
					des.numRetiroRecursos,
					des.txtRetiroRecursos,
					des.numServiciosPublicos,
					des.txtServiciosPublicos,
					des.txtCorreoVendedor,
					flu.txtFlujo,
					des.seqCiudad
				FROM T_DES_DESEMBOLSO des
				LEFT JOIN T_DES_FLUJO flu ON des.seqFormulario = flu.seqFormulario
				WHERE
					des.seqFormulario = " . $seqFormulario . "
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            foreach ($objRes->fields as $txtClave => $txtValor) {
                $this->$txtClave = $txtValor;
            }

            // si no ha determinado el flujo se toma como escritura publica
            $this->txtFlujo = ( $this->txtFlujo != "" ) ? $this->txtFlujo : "escritura";

            $this->cargarConceptoJuridico();
            $this->cargarConceptoTecnico();
            $this->cargarEscrituracion($seqFormulario);
            $this->cargarEstudioTitulos();
            $this->cargarSolicitud();
            $this->cargarConsignaciones($seqFormulario);
        }
    }

    public function cargarEscrituracion($seqFormulario) {
        global $aptBd;

         $sql = "
				SELECT
					esc.seqEscrituracion,
					esc.bolPoseedor,
					esc.bolViabilizoJuridico,
					esc.bolViabilizoTecnico,
					esc.fchEscritura,
					esc.numActaEntrega,
					esc.numAltoRiesgo,
					esc.numAutorizacionDesembolso,
					esc.numAvaluo,
					esc.numBoletinCatastral,
					esc.numCartaAsignacion,
					esc.numCertificacionVendedor,
					esc.numCertificadoTradicion,
					esc.numDocumentoVendedor,
					esc.numEscrituraPublica,
					esc.numFotocopiaVendedor,
					esc.numHabitabilidad,
					esc.numLicenciaConstruccion,
					esc.numNotaria,
					esc.numOtros,
					esc.numUltimoPredial,
					esc.numUltimoReciboAgua,
					esc.numUltimoReciboEnergia,
					esc.numValorInmueble,
					esc.seqDesembolso,
					esc.seqFormulario,
					esc.seqLocalidad,
					ucwords(esc.txtActaEntrega) as txtActaEntrega,
					ucwords(esc.txtAltoRiesgo) as txtAltoRiesgo,
					ucwords(esc.txtAutorizacionDesembolso) as txtAutorizacionDesembolso,
					ucwords(esc.txtBarrio) as txtBarrio,
					ucwords(esc.txtBoletinCatastral) as txtBoletinCatastral,
					ucwords(esc.txtCartaAsignacion) as txtCartaAsignacion,
					ucwords(esc.txtCertificacionVendedor) as txtCertificacionVendedor,
					ucwords(esc.txtCertificadoTradicion) as txtCertificadoTradicion,
					UPPER( ucwords(esc.txtChip) )as txtChip,
					ucwords(esc.txtDireccionInmueble) as txtDireccionInmueble,
					ucwords(esc.txtEscritura) as txtEscritura,
					ucwords(esc.txtEscrituraPublica) as txtEscrituraPublica,
					ucwords(esc.txtFotocopiaVendedor) as txtFotocopiaVendedor,
					ucwords(esc.txtHabitabilidad) as txtHabitabilidad,
					ucwords(esc.txtLicenciaConstruccion) as txtLicenciaConstruccion,
					UPPER( ucwords(esc.txtMatriculaInmobiliaria) )as txtMatriculaInmobiliaria,
					ucwords(esc.txtNombreVendedor) as txtNombreVendedor,
					ucwords(esc.txtOtro) as txtOtro,
					ucwords(esc.txtUltimoPredial) as txtUltimoPredial,
					ucwords(esc.txtUltimoReciboAgua) as txtUltimoReciboAgua,
					ucwords(esc.txtUltimoReciboEnergia) as txtUltimoReciboEnergia,
					ucwords(esc.txtViabilizoJuridico) as txtViabilizoJuridico,
					ucwords(esc.txtViabilizoTecnico) as txtViabilizoTecnico,
					ucwords(esc.valInmueble) as valInmueble,
			 		esc.seqTipoDocumento,
					esc.numAreaLote,
					esc.numAreaConstruida,
					esc.txtCedulaCatastral,
					esc.numTelefonoVendedor,
					esc.numTelefonoVendedor2,
					esc.txtTipoPredio,
					esc.numRut,
					esc.txtRut,
					esc.numRit,
					esc.txtRit,
					esc.numNit,
					esc.txtNit,
					esc.txtCompraVivienda,
					esc.numEstrato,
					esc.txtTipoDocumentos,
					ucwords(esc.txtCiudad) as txtCiudad,
					esc.fchCreacionBusquedaOferta,
					esc.fchActualizacionBusquedaOferta,
					esc.fchCreacionEscrituracion,
					esc.fchActualizacionEscrituracion,
					esc.txtPropiedad,
					esc.fchSentencia,
					esc.numJuzgado,
					esc.txtCiudadSentencia,
					esc.numResolucion,
					esc.fchResolucion,
					esc.txtEntidad,
					esc.txtCiudadResolucion,
					esc.numContratoArrendamiento,
					esc.numAperturaCAP,
					esc.txtAperturaCAP,
					esc.numCedulaArrendador,
					esc.numCuentaArrendador,
					esc.txtCuentaArrendador,
					esc.numRetiroRecursos,
					esc.txtRetiroRecursos,
					esc.numServiciosPublicos,
					esc.txtServiciosPublicos,
					esc.txtCorreoVendedor,
					flu.txtFlujo,
					esc.seqCiudad
				FROM T_DES_ESCRITURACION esc
				LEFT JOIN T_DES_FLUJO flu ON esc.seqFormulario = flu.seqFormulario
				WHERE
					esc.seqFormulario = " . $seqFormulario . " order by seqEscrituracion desc
			";

        $objRes = $aptBd->execute($sql);
        //pr($objRes);
        if ($objRes->fields) {

            foreach ($objRes->fields as $txtClave => $txtValor) {
                $this->arrEscrituracion[$txtClave] = $txtValor;
            }

            // si no ha determinado el flujo se toma como escritura publica
            $this->txtFlujo = ( $this->txtFlujo != "" ) ? $this->txtFlujo : "escritura";
        }
    }

    public function salvarBusquedaOferta($arrPost, $txtFase) {
        global $aptBd;

        $seqUsuario = ( $_SESSION['seqUsuario'] ) ? $_SESSION['seqUsuario'] : $arrPost['seqUsuario'];
        $arrErrores = array();

        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        $sql = "
				INSERT INTO T_SEG_SEGUIMIENTO (
					seqFormulario,
					fchMovimiento,
					seqUsuario,
					txtComentario,
					txtCambios,
					numDocumento,
					txtNombre,
					seqGestion
				) VALUES (
					" . $arrPost['seqFormulario'] . ",
					'" . date("Y-m-d H:i:s") . "',
					" . $seqUsuario . ",
					'" . $arrPost['txtComentario'] . "',
					'" . $arrPost['txtCambios'] . "',
					" . $cedulaFormat . ",
					'" . $arrPost['nombre'] . "',
					" . $arrPost['seqGestion'] . "
				)
	 		";

        $this->seqSeguimiento = 0;
        try {
            $aptBd->execute($sql);
            $this->seqSeguimiento = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = $objError->msg;
        }

        $sql = "
	 			SELECT
					seqDesembolso,
					fchCreacionEscrituracion,
					fchActualizacionEscrituracion
				FROM T_DES_DESEMBOLSO
				WHERE seqFormulario = " . $arrPost['seqFormulario'] . "
	 		";
        try {
            $seqDesembolso = 0;
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqDesembolso = $objRes->fields['seqDesembolso'];
                $fchCreacionEscrituracion = $objRes->fields['fchCreacionEscrituracion'];
                $fchActualziacionEscrituracion = $objRes->fields['fchActualizacionEscrituracion'];
            }
        } catch (Exception $objError) {
            $arrErrores[] = $objError->msg;
        }

        if ($seqDesembolso == 0) {

            $txtCampos = "fchCreacionBusquedaOferta,";
            $txtCampos .= "fchActualizacionBusquedaOferta,";
            $txtCampos .= "fchCreacionEscrituracion,";
            $txtCampos .= "fchActualizacionEscrituracion";

            $txtValores = "'" . date("Y-m-d H:i:s") . "',";     // fchCrecionBusquedaOferta
            $txtValores .= "'" . date("Y-m-d H:i:s") . "',";    // fchActualizacionBusquedaOferta
            $txtValores .= "NULL,";                                    // fchCrecionEscrituracion
            $txtValores .= "NULL";                                     // fchActualizacionEscrituracion

            $arrPost['fchEscritura']  = ( esFechaValida($arrPost['fchEscritura']) )? "'" . $arrPost['fchEscritura'] ."'" : 'NULL' ;
            $arrPost['fchSentencia']  = ( esFechaValida($arrPost['fchSentencia']) )? "'" . $arrPost['fchSentencia'] ."'" : 'NULL' ;
            $arrPost['fchResolucion'] = ( esFechaValida($arrPost['fchResolucion']) )? "'" . $arrPost['fchResolucion'] ."'" : 'NULL' ;


            $sql = "
					INSERT INTO T_DES_DESEMBOLSO (
						seqFormulario,
						txtEscrituraPublica,
						numEscrituraPublica,
						txtCertificadoTradicion,
						numCertificadoTradicion,
						txtCartaAsignacion,
						numCartaAsignacion,
						txtAltoRiesgo,
						numAltoRiesgo,
						txtHabitabilidad,
						numHabitabilidad,
						txtBoletinCatastral,
						numBoletinCatastral,
						txtLicenciaConstruccion,
						numLicenciaConstruccion,
						txtUltimoPredial,
						numUltimoPredial,
						txtUltimoReciboAgua,
						numUltimoReciboAgua,
						txtUltimoReciboEnergia,
						numUltimoReciboEnergia,
						txtOtro,
						numOtros,
						txtViabilizoJuridico,
						txtViabilizoTecnico,
						bolViabilizoJuridico,
						bolViabilizoTecnico,
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
						numAreaLote,
						numAreaConstruida,
						txtCedulaCatastral,
						numTelefonoVendedor,
						numTelefonoVendedor2,
						txtTipoPredio,
						numRut,
						txtRut,
						numRit,
						txtRit,
						numNit,
						txtNit,
						txtCompraVivienda,
						numEstrato,
						txtTipoDocumentos,
						txtCiudad,
						txtPropiedad,
						fchSentencia,
						numJuzgado,
						txtCiudadSentencia,
						numResolucion,
						fchResolucion,
						txtEntidad,
						txtCiudadResolucion,
						numContratoArrendamiento,
						numAperturaCAP,
						txtAperturaCAP,
						numCedulaArrendador,
						numCuentaArrendador,
						txtCuentaArrendador,
						numRetiroRecursos,
						txtRetiroRecursos,
						numServiciosPublicos,
						txtServiciosPublicos,
						txtCorreoVendedor,
						seqCiudad,
						seqAplicacionSubsidio,
						seqProyectosSoluciones,
						$txtCampos
					) VALUES (
						'" . $arrPost['seqFormulario'] . "',
						'" . $arrPost['txtEscrituraPublica'] . "',
						'" . doubleval($arrPost['numEscrituraPublica'] ). "',
						'" . $arrPost['txtCertificadoTradicion'] . "',
						'" . doubleval($arrPost['numCertificadoTradicion'] ). "',
						'" . $arrPost['txtCartaAsignacion'] . "',
						'" . doubleval($arrPost['numCartaAsignacion']) . "',
						'" . $arrPost['txtAltoRiesgo'] . "',
						'" . doubleval($arrPost['numAltoRiesgo']) . "',
						'" . $arrPost['txtHabitabilidad'] . "',
						'" . doubleval($arrPost['numHabitabilidad']) . "',
						'" . $arrPost['txtBoletinCatastral'] . "',
						'" . doubleval($arrPost['numBoletinCatastral']) . "',
						'" . $arrPost['txtLicenciaConstruccion'] . "',
						'" . doubleval($arrPost['numLicenciaConstruccion']) . "',
						'" . $arrPost['txtUltimoPredial'] . "',
						'" . doubleval($arrPost['numUltimoPredial'] ). "',
						'" . $arrPost['txtUltimoReciboAgua'] . "',
						'" . doubleval($arrPost['numUltimoReciboAgua'] ). "',
						'" . $arrPost['txtUltimoReciboEnergia'] . "',
						'" . doubleval($arrPost['numUltimoReciboEnergia'] ). "',
						'" . $arrPost['txtOtro'] . "',
						'" . doubleval($arrPost['numOtros'] ). "',
						'" . $arrPost['txtViabilizoJuridico'] . "',
						'" . $arrPost['txtViabilizoTecnico'] . "',
						'" . intval($arrPost['bolViabilizoJuridico'] ). "',
						'" . intval($arrPost['bolViabilizoTecnico']) . "',
						'" . $arrPost['txtNombreVendedor'] . "',
						'" . doubleval($arrPost['numDocumentoVendedor'] ). "',
						'" . $arrPost['txtDireccionInmueble'] . "',
						'" . $arrPost['txtBarrio'] . "',
						'" . $arrPost['seqLocalidad'] . "',
						'" . $arrPost['txtEscritura'] . "',
						'" . doubleval($arrPost['numNotaria'] ). "',
						" . $arrPost['fchEscritura'] . ",
						'" . doubleval($arrPost['numAvaluo'] ). "',
						'" . doubleval($arrPost['valInmueble'] ) . "',
						'" . $arrPost['txtMatriculaInmobiliaria'] . "',
						'" . doubleval($arrPost['numValorInmueble'] ). "',
						'" . intval($arrPost['bolPoseedor'] ) . "',
						'" . strtoupper($arrPost['txtChip']) . "',
						'" . strtoupper($arrPost['numActaEntrega']) . "',
						'" . $arrPost['txtActaEntrega'] . "',
						'" . doubleval($arrPost['numCertificacionVendedor'] ). "',
						'" . $arrPost['txtCertificacionVendedor'] . "',
						'" . doubleval($arrPost['numAutorizacionDesembolso'] ). "',
						'" . $arrPost['txtAutorizacionDesembolso'] . "',
						'" . doubleval($arrPost['numFotocopiaVendedor'] ). "',
						'" . $arrPost['txtFotocopiaVendedor'] . "',
						'" . $arrPost['seqTipoDocumento'] . "',
						'" . doubleval($arrPost['numAreaLote'] ). "',
						'" . doubleval($arrPost['numAreaConstruida'] ). "',
						'" . $arrPost['txtCedulaCatastral'] . "',
						'" . doubleval($arrPost['numTelefonoVendedor'] ) . "',
						'" . doubleval($arrPost['numTelefonoVendedor2'] ) . "',
						'" . $arrPost['txtTipoPredio'] . "',
						'" . doubleval($arrPost['numRut'] ) . "',
						'" . $arrPost['txtRut'] . "',
						'" . doubleval($arrPost['numRit'] ). "',
						'" . $arrPost['txtRit'] . "',
						'" . doubleval( $arrPost['numNit'] ). "',
						'" . $arrPost['txtNit'] . "',
						'" . $arrPost['txtCompraVivienda'] . "',
						'" . intval($arrPost['numEstrato'] ) . "',
						'" . doubleval($arrPost['documentos'] ). "',
						'" . $arrPost['txtCiudad'] . "',
						'" . $arrPost['txtPropiedad'] . "',
						" . $arrPost['fchSentencia'] . ",
						'" . doubleval($arrPost['numJuzgado'] ). "',
						'" . $arrPost['txtCiudadSentencia'] . "',
						'" . intval($arrPost['numResolucion'] ). "',
						" . $arrPost['fchResolucion'] . ",
						'" . $arrPost['txtEntidad'] . "',
						'" . $arrPost['txtCiudadResolucion'] . "',
						'" . intval($arrPost['numContratoArrendamiento'] ). "',
						'" . doubleval($arrPost['numAperturaCAP'] ). "',
						'" . $arrPost['txtAperturaCAP'] . "',
						'" . doubleval($arrPost['numCedulaArrendador'] ). "',
						'" . doubleVal($arrPost['numCuentaArrendador'] ). "',
						'" . $arrPost['txtCuentaArrendador'] . "',
						'" . doubleval($arrPost['numRetiroRecursos'] ). "',
						'" . $arrPost['txtRetiroRecursos'] . "',
						'" . doubleval($arrPost['numServiciosPublicos'] ). "',
						'" . $arrPost['txtServiciosPublicos'] . "',
						'" . $arrPost['txtCorreoVendedor'] . "',
						'" . $arrPost['seqCiudad'] . "',
						0,
						0,
						$txtValores
					)
	 			";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = $objError->getMessage();
                echo $sql;
            }
        } else {

            if ($txtFase == "busquedaOferta") {
                $txtCampos = "fchActualizacionBusquedaOferta = '" . date("Y-m-d H:i:s") . "'";
            } else {
                if (strtotime($fchCreacionEscrituracion) == false) {
                    $txtCampos = "fchCreacionEscrituracion = '" . date("Y-m-d H:i:s") . "',";
                    $txtCampos .= "fchActualizacionEscrituracion = '" . date("Y-m-d H:i:s") . "'";
                } else {
                    $txtCampos = "fchActualizacionEscrituracion = '" . date("Y-m-d H:i:s") . "'";
                }
            }

            $arrPost['fchEscritura']  = ( esFechaValida($arrPost['fchEscritura']) )? "'" . $arrPost['fchEscritura'] ."'" : 'NULL' ;
            $arrPost['fchSentencia']  = ( esFechaValida($arrPost['fchSentencia']) )? "'" . $arrPost['fchSentencia'] ."'" : 'NULL' ;
            $arrPost['fchResolucion'] = ( esFechaValida($arrPost['fchResolucion']) )? "'" . $arrPost['fchResolucion'] ."'" : 'NULL' ;

            $sql = "
                UPDATE T_DES_DESEMBOLSO SET
                    seqFormulario	=	'" . $arrPost['seqFormulario'] . "',
                    txtEscrituraPublica	=	'" . $arrPost['txtEscrituraPublica'] . "',
                    numEscrituraPublica	=	'" . doubleval($arrPost['numEscrituraPublica']) . "',
                    txtCertificadoTradicion	=	'" . $arrPost['txtCertificadoTradicion'] . "',
                    numCertificadoTradicion	=	'" . doubleval($arrPost['numCertificadoTradicion']) . "',
                    txtCartaAsignacion	=	'" . $arrPost['txtCartaAsignacion'] . "',
                    numCartaAsignacion	=	'" . doubleval($arrPost['numCartaAsignacion']) . "',
                    txtAltoRiesgo	=	'" . $arrPost['txtAltoRiesgo'] . "',
                    numAltoRiesgo	=	'" . doubleval($arrPost['numAltoRiesgo']) . "',
                    txtHabitabilidad	=	'" . $arrPost['txtHabitabilidad'] . "',
                    numHabitabilidad	=	'" . doubleval($arrPost['numHabitabilidad']) . "',
                    txtBoletinCatastral	=	'" . $arrPost['txtBoletinCatastral'] . "',
                    numBoletinCatastral	=	'" . doubleval($arrPost['numBoletinCatastral']) . "',
                    txtLicenciaConstruccion	=	'" . $arrPost['txtLicenciaConstruccion'] . "',
                    numLicenciaConstruccion	=	'" . doubleval($arrPost['numLicenciaConstruccion']) . "',
                    txtUltimoPredial	=	'" . $arrPost['txtUltimoPredial'] . "',
                    numUltimoPredial	=	'" . doubleval($arrPost['numUltimoPredial']) . "',
                    txtUltimoReciboAgua	=	'" . $arrPost['txtUltimoReciboAgua'] . "',
                    numUltimoReciboAgua	=	'" . doubleval($arrPost['numUltimoReciboAgua']) . "',
                    txtUltimoReciboEnergia	=	'" . $arrPost['txtUltimoReciboEnergia'] . "',
                    numUltimoReciboEnergia	=	'" . doubleval($arrPost['numUltimoReciboEnergia']) . "',
                    txtOtro	=	'" . $arrPost['txtOtro'] . "',
                    numOtros	=	'" . doubleval($arrPost['numOtros']) . "',
                    txtViabilizoJuridico	=	'" . $arrPost['txtViabilizoJuridico'] . "',
                    txtViabilizoTecnico	=	'" . $arrPost['txtViabilizoTecnico'] . "',
                    bolViabilizoJuridico	=	'" . intval($arrPost['bolViabilizoJuridico']) . "',
                    bolViabilizoTecnico	=	'" . intval($arrPost['bolViabilizoTecnico']) . "',
                    txtNombreVendedor	=	'" . $arrPost['txtNombreVendedor'] . "',
                    numDocumentoVendedor	=	'" . doubleval($arrPost['numDocumentoVendedor']) . "',
                    txtDireccionInmueble	=	'" . $arrPost['txtDireccionInmueble'] . "',
                    txtBarrio	=	'" . $arrPost['txtBarrio'] . "',
                    seqLocalidad	=	'" . $arrPost['seqLocalidad'] . "',
                    txtEscritura	=	'" . $arrPost['txtEscritura'] . "',
                    numNotaria	=	'" . doubleval($arrPost['numNotaria']) . "',
                    fchEscritura	=	" . $arrPost['fchEscritura'] . ",
                    numAvaluo	=	'" . doubleval($arrPost['numAvaluo']) . "',
                    valInmueble	=	'" . doubleval($arrPost['valInmueble']) . "',
                    txtMatriculaInmobiliaria	=	'" . strtoupper($arrPost['txtMatriculaInmobiliaria']) . "',
                    numValorInmueble	=	'" . doubleval($arrPost['numValorInmueble']) . "',
                    bolPoseedor	=	'" . intval($arrPost['bolPoseedor']) . "',
                    txtChip	=	'" . strtoupper($arrPost['txtChip']) . "',
                    numActaEntrega = '" . doubleval($arrPost['numActaEntrega']) . "',
                    txtActaEntrega = '" . $arrPost['txtActaEntrega'] . "',
                    numCertificacionVendedor = '" . doubleval($arrPost['numCertificacionVendedor']) . "',
                    txtCertificacionVendedor = '" . $arrPost['txtCertificacionVendedor'] . "',
                    numAutorizacionDesembolso = '" . doubleval($arrPost['numAutorizacionDesembolso']) . "',
                    txtAutorizacionDesembolso = '" . $arrPost['txtAutorizacionDesembolso'] . "',
                    numFotocopiaVendedor = '" . doubleval($arrPost['numFotocopiaVendedor']) . "',
                    txtFotocopiaVendedor = '" . $arrPost['txtFotocopiaVendedor'] . "',
                    seqTipoDocumento = '" . $arrPost['seqTipoDocumento'] . "',
                    numAreaLote = '" . doubleval($arrPost['numAreaLote']) . "',
                    numAreaConstruida = '" . doubleval($arrPost['numAreaConstruida']) . "',
                    txtCedulaCatastral = '" . $arrPost['txtCedulaCatastral'] . "',
                    numTelefonoVendedor = '" . doubleval($arrPost['numTelefonoVendedor']) . "',
                    numTelefonoVendedor2 = '" . doubleval($arrPost['numTelefonoVendedor2']) . "',
                    txtTipoPredio = '" . $arrPost['txtTipoPredio'] . "',
                    numRut = '" . doubleval($arrPost['numRut']) . "',
                    txtRut = '" . $arrPost['txtRut'] . "',
                    numRit = '" . doubleval($arrPost['numRit']) . "',
                    txtRit = '" . $arrPost['txtRit'] . "',
                    numNit = '" . doubleval($arrPost['numNit']) . "',
                    txtNit = '" . doubleval($arrPost['txtNit'] ). "',
                    txtCompraVivienda = '" . $arrPost['txtCompraVivienda'] . "',
                    numEstrato = '" . doubleval($arrPost['numEstrato']) . "',
                    txtTipoDocumentos = '" . $arrPost['documentos'] . "',
                    txtCiudad = '" . $arrPost['txtCiudad'] . "',
                    txtPropiedad = '" . $arrPost['txtPropiedad'] . "',
                    fchSentencia = " . $arrPost['fchSentencia'] . ",
                    numJuzgado = '" . doubleval($arrPost['numJuzgado']) . "',
                    txtCiudadSentencia = '" . $arrPost['txtCiudadSentencia'] . "',
                    numResolucion = '" . doubleval($arrPost['numResolucion']) . "',
                    fchResolucion = " . $arrPost['fchResolucion'] . ",
                    txtEntidad = '" . $arrPost['txtEntidad'] . "',
                    txtCiudadResolucion = '" . $arrPost['txtCiudadResolucion'] . "',
                    numContratoArrendamiento = '" . doubleval($arrPost['numContratoArrendamiento']) . "',
                    numAperturaCAP = '" . doubleval($arrPost['numAperturaCAP']) . "',
                    txtAperturaCAP = '" . $arrPost['txtAperturaCAP'] . "',
                    numCedulaArrendador = '" . doubleval($arrPost['numCedulaArrendador']) . "',
                    numCuentaArrendador = '" . doubleval($arrPost['numCuentaArrendador']) . "',
                    txtCuentaArrendador = '" . $arrPost['txtCuentaArrendador'] . "',
                    numRetiroRecursos = '" . doubleval($arrPost['numRetiroRecursos']) . "',
                    txtRetiroRecursos = '" . $arrPost['txtRetiroRecursos'] . "',
                    numServiciosPublicos = '" . doubleval($arrPost['numServiciosPublicos']) . "',
                    txtServiciosPublicos = '" . $arrPost['txtServiciosPublicos'] . "',
                    txtCorreoVendedor = '" . $arrPost['txtCorreoVendedor'] . "',
                    seqCiudad = '" . $arrPost['seqCiudad'] . "',
                    $txtCampos
                WHERE
                    seqFormulario = " . $arrPost['seqFormulario'] . "
            ";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = $objError->getMessage();
            }
        }

        if( empty( $arrErrores )){
            $arrErrores = $this->fechaUltimaActualizacion($arrPost['seqFormulario']);
        }

        return $arrErrores;
    }

// Fin guardar desembolso

    public function salvarEscrituracion($arrPost, $txtFase) {
        global $aptBd;

        $seqUsuario = ( $_SESSION['seqUsuario'] ) ? $_SESSION['seqUsuario'] : $arrPost['seqUsuario'];
        $arrErrores = array();

        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        $sql = "
				INSERT INTO T_SEG_SEGUIMIENTO (
					seqFormulario,
					fchMovimiento,
					seqUsuario,
					txtComentario,
					txtCambios,
					numDocumento,
					txtNombre,
					seqGestion
				) VALUES (
					" . $arrPost['seqFormulario'] . ",
					'" . date("Y-m-d H:i:s") . "',
					" . $seqUsuario . ",
					'" . $arrPost['txtComentario'] . "',
					'" . $arrPost['txtCambios'] . "',
					" . $cedulaFormat . ",
					'" . $arrPost['nombre'] . "',
					" . $arrPost['seqGestion'] . "
				)
	 		";

        $this->seqSeguimiento = 0;
        try {
            $aptBd->execute($sql);
            $this->seqSeguimiento = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = $objError->msg;
        }

        $sql = "
	 			SELECT
					seqDesembolso,
					fchCreacionEscrituracion,
					fchActualizacionEscrituracion
				FROM T_DES_DESEMBOLSO
				WHERE seqFormulario = " . $arrPost['seqFormulario'] . "
	 		";
        try {
            $seqDesembolso = 0;
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqDesembolso = $objRes->fields['seqDesembolso'];
                $fchCreacionEscrituracion = $objRes->fields['fchCreacionEscrituracion'];
                $fchActualziacionEscrituracion = $objRes->fields['fchActualizacionEscrituracion'];
            }
        } catch (Exception $objError) {
            $arrErrores[] = $objError->msg;
        }

        $sql = "
	 			SELECT
					seqEscrituracion,
					fchCreacionEscrituracion,
					fchActualizacionEscrituracion
				FROM T_DES_ESCRITURACION
				WHERE seqDesembolso = " . $seqDesembolso . "
	 		";
        try {
            $seqEscrituracion = 0;
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqEscrituracion = $objRes->fields['seqEscrituracion'];
                $fchCreacionEscrituracion = $objRes->fields['fchCreacionEscrituracion'];
                $fchActualziacionEscrituracion = $objRes->fields['fchActualizacionEscrituracion'];
            }
        } catch (Exception $objError) {
            $arrErrores[] = $objError->msg;
        }

        if ($seqEscrituracion == 0) {

            $txtCampos = "fchCreacionBusquedaOferta,";
            $txtCampos .= "fchActualizacionBusquedaOferta,";
            $txtCampos .= "fchCreacionEscrituracion,";
            $txtCampos .= "fchActualizacionEscrituracion";

            $txtValores = "'" . date("Y-m-d H:i:s") . "',"; // fchCrecionBusquedaOferta
            $txtValores .= "'" . date("Y-m-d H:i:s") . "',"; // fchActualizacionBusquedaOferta
            $txtValores .= "'',";        // fchCrecionEscrituracion
            $txtValores .= "''";        // fchActualizacionEscrituracion

            $sql = "
					INSERT INTO T_DES_ESCRITURACION (
						seqDesembolso,
						seqFormulario,
						txtEscrituraPublica,
						numEscrituraPublica,
						txtCertificadoTradicion,
						numCertificadoTradicion,
						txtCartaAsignacion,
						numCartaAsignacion,
						txtAltoRiesgo,
						numAltoRiesgo,
						txtHabitabilidad,
						numHabitabilidad,
						txtBoletinCatastral,
						numBoletinCatastral,
						txtLicenciaConstruccion,
						numLicenciaConstruccion,
						txtUltimoPredial,
						numUltimoPredial,
						txtUltimoReciboAgua,
						numUltimoReciboAgua,
						txtUltimoReciboEnergia,
						numUltimoReciboEnergia,
						txtOtro,
						numOtros,
						txtViabilizoJuridico,
						txtViabilizoTecnico,
						bolViabilizoJuridico,
						bolViabilizoTecnico,
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
						numAreaLote,
						numAreaConstruida,
						txtCedulaCatastral,
						numTelefonoVendedor,
						numTelefonoVendedor2,
						txtTipoPredio,
						numRut,
						txtRut,
						numRit,
						txtRit,
						numNit,
						txtNit,
						txtCompraVivienda,
						numEstrato,
						txtTipoDocumentos,
						txtCiudad,
						txtPropiedad,
						fchSentencia,
						numJuzgado,
						txtCiudadSentencia,
						numResolucion,
						fchResolucion,
						txtEntidad,
						txtCiudadResolucion,
						numContratoArrendamiento,
						numAperturaCAP,
						txtAperturaCAP,
						numCedulaArrendador,
						numCuentaArrendador,
						txtCuentaArrendador,
						numRetiroRecursos,
						txtRetiroRecursos,
						numServiciosPublicos,
						txtServiciosPublicos,
						txtCorreoVendedor,
						seqCiudad,
						$txtCampos
					) VALUES (
						'" . $seqDesembolso . "',
						'" . $arrPost['seqFormulario'] . "',
						'" . $arrPost['txtEscrituraPublica'] . "',
						'" . $arrPost['numEscrituraPublica'] . "',
						'" . $arrPost['txtCertificadoTradicion'] . "',
						'" . $arrPost['numCertificadoTradicion'] . "',
						'" . $arrPost['txtCartaAsignacion'] . "',
						'" . $arrPost['numCartaAsignacion'] . "',
						'" . $arrPost['txtAltoRiesgo'] . "',
						'" . $arrPost['numAltoRiesgo'] . "',
						'" . $arrPost['txtHabitabilidad'] . "',
						'" . $arrPost['numHabitabilidad'] . "',
						'" . $arrPost['txtBoletinCatastral'] . "',
						'" . $arrPost['numBoletinCatastral'] . "',
						'" . $arrPost['txtLicenciaConstruccion'] . "',
						'" . $arrPost['numLicenciaConstruccion'] . "',
						'" . $arrPost['txtUltimoPredial'] . "',
						'" . $arrPost['numUltimoPredial'] . "',
						'" . $arrPost['txtUltimoReciboAgua'] . "',
						'" . $arrPost['numUltimoReciboAgua'] . "',
						'" . $arrPost['txtUltimoReciboEnergia'] . "',
						'" . $arrPost['numUltimoReciboEnergia'] . "',
						'" . $arrPost['txtOtro'] . "',
						'" . $arrPost['numOtros'] . "',
						'" . $arrPost['txtViabilizoJuridico'] . "',
						'" . $arrPost['txtViabilizoTecnico'] . "',
						'" . intval($arrPost['bolViabilizoJuridico']) . "',
						'" . intval($arrPost['bolViabilizoTecnico']) . "',
						'" . $arrPost['txtNombreVendedor'] . "',
						'" . $arrPost['numDocumentoVendedor'] . "',
						'" . $arrPost['txtDireccionInmueble'] . "',
						'" . $arrPost['txtBarrio'] . "',
						'" . $arrPost['seqLocalidad'] . "',
						'" . $arrPost['txtEscritura'] . "',
						'" . $arrPost['numNotaria'] . "',
						'" . $arrPost['fchEscritura'] . "',
						'" . $arrPost['numAvaluo'] . "',
						'" . $arrPost['valInmueble'] . "',
						'" . $arrPost['txtMatriculaInmobiliaria'] . "',
						'" . $arrPost['numValorInmueble'] . "',
						'" . $arrPost['bolPoseedor'] . "',
						'" . strtoupper($arrPost['txtChip']) . "',
						'" . strtoupper($arrPost['numActaEntrega']) . "',
						'" . $arrPost['txtActaEntrega'] . "',
						'" . $arrPost['numCertificacionVendedor'] . "',
						'" . $arrPost['txtCertificacionVendedor'] . "',
						'" . $arrPost['numAutorizacionDesembolso'] . "',
						'" . $arrPost['txtAutorizacionDesembolso'] . "',
						'" . $arrPost['numFotocopiaVendedor'] . "',
						'" . $arrPost['txtFotocopiaVendedor'] . "',
						'" . $arrPost['seqTipoDocumento'] . "',
						'" . $arrPost['numAreaLote'] . "',
						'" . $arrPost['numAreaConstruida'] . "',
						'" . $arrPost['txtCedulaCatastral'] . "',
						'" . $arrPost['numTelefonoVendedor'] . "',
						'" . $arrPost['numTelefonoVendedor2'] . "',
						'" . $arrPost['txtTipoPredio'] . "',
						'" . $arrPost['numRut'] . "',
						'" . $arrPost['txtRut'] . "',
						'" . $arrPost['numRit'] . "',
						'" . $arrPost['txtRit'] . "',
						'" . $arrPost['numNit'] . "',
						'" . $arrPost['txtNit'] . "',
						'" . $arrPost['txtCompraVivienda'] . "',
						'" . $arrPost['numEstrato'] . "',
						'" . $arrPost['documentos'] . "',
						'" . $arrPost['txtCiudad'] . "',
						'" . $arrPost['txtPropiedad'] . "',
						'" . $arrPost['fchSentencia'] . "',
						'" . $arrPost['numJuzgado'] . "',
						'" . $arrPost['txtCiudadSentencia'] . "',
						'" . $arrPost['numResolucion'] . "',
						'" . $arrPost['fchResolucion'] . "',
						'" . $arrPost['txtEntidad'] . "',
						'" . $arrPost['txtCiudadResolucion'] . "',
						'" . $arrPost['numContratoArrendamiento'] . "',
						'" . $arrPost['numAperturaCAP'] . "',
						'" . $arrPost['txtAperturaCAP'] . "',
						'" . $arrPost['numCedulaArrendador'] . "',
						'" . $arrPost['numCuentaArrendador'] . "',
						'" . $arrPost['txtCuentaArrendador'] . "',
						'" . $arrPost['numRetiroRecursos'] . "',
						'" . $arrPost['txtRetiroRecursos'] . "',
						'" . $arrPost['numServiciosPublicos'] . "',
						'" . $arrPost['txtServiciosPublicos'] . "',
						'" . $arrPost['txtCorreoVendedor'] . "',
						'" . $arrPost['seqCiudad'] . "',
						$txtValores
					)
	 			";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = $objError->getMessage();
            }
        } else {

            if ($txtFase == "busquedaOferta") {
                $txtCampos = "fchActualizacionBusquedaOferta = '" . date("Y-m-d H:i:s") . "'";
            } else {
                if (strtotime($fchCreacionEscrituracion) == false) {
                    $txtCampos = "fchCreacionEscrituracion = '" . date("Y-m-d H:i:s") . "',";
                    $txtCampos .= "fchActualizacionEscrituracion = '" . date("Y-m-d H:i:s") . "'";
                } else {
                    $txtCampos = "fchActualizacionEscrituracion = '" . date("Y-m-d H:i:s") . "'";
                }
            }

            $fchSentencia = ( esFechaValida( $arrPost['fchSentencia'] ))? "'" . $arrPost['fchSentencia'] . "'" : "NULL";
            $fchResolucion = ( esFechaValida( $arrPost['fchResolucion'] ))? "'" . $arrPost['fchResolucion'] . "'" : "NULL";

            $sql = "
					UPDATE T_DES_ESCRITURACION SET
						seqFormulario	=	'" . $arrPost['seqFormulario'] . "',
						txtEscrituraPublica	=	'" . $arrPost['txtEscrituraPublica'] . "',
						numEscrituraPublica	=	'" . $arrPost['numEscrituraPublica'] . "',
						txtCertificadoTradicion	=	'" . $arrPost['txtCertificadoTradicion'] . "',
						numCertificadoTradicion	=	'" . $arrPost['numCertificadoTradicion'] . "',
						txtCartaAsignacion	=	'" . $arrPost['txtCartaAsignacion'] . "',
						numCartaAsignacion	=	'" . $arrPost['numCartaAsignacion'] . "',
						txtAltoRiesgo	=	'" . $arrPost['txtAltoRiesgo'] . "',
						numAltoRiesgo	=	'" . $arrPost['numAltoRiesgo'] . "',
						txtHabitabilidad	=	'" . $arrPost['txtHabitabilidad'] . "',
						numHabitabilidad	=	'" . $arrPost['numHabitabilidad'] . "',
						txtBoletinCatastral	=	'" . $arrPost['txtBoletinCatastral'] . "',
						numBoletinCatastral	=	'" . $arrPost['numBoletinCatastral'] . "',
						txtLicenciaConstruccion	=	'" . $arrPost['txtLicenciaConstruccion'] . "',
						numLicenciaConstruccion	=	'" . $arrPost['numLicenciaConstruccion'] . "',
						txtUltimoPredial	=	'" . $arrPost['txtUltimoPredial'] . "',
						numUltimoPredial	=	'" . $arrPost['numUltimoPredial'] . "',
						txtUltimoReciboAgua	=	'" . $arrPost['txtUltimoReciboAgua'] . "',
						numUltimoReciboAgua	=	'" . $arrPost['numUltimoReciboAgua'] . "',
						txtUltimoReciboEnergia	=	'" . $arrPost['txtUltimoReciboEnergia'] . "',
						numUltimoReciboEnergia	=	'" . $arrPost['numUltimoReciboEnergia'] . "',
						txtOtro	=	'" . $arrPost['txtOtro'] . "',
						numOtros	=	'" . $arrPost['numOtros'] . "',
						txtViabilizoJuridico	=	'" . $arrPost['txtViabilizoJuridico'] . "',
						txtViabilizoTecnico	=	'" . $arrPost['txtViabilizoTecnico'] . "',
						bolViabilizoJuridico	=	'" . intval($arrPost['bolViabilizoJuridico'] ). "',
						bolViabilizoTecnico	=	'" . intval($arrPost['bolViabilizoTecnico'] ). "',
						txtNombreVendedor	=	'" . $arrPost['txtNombreVendedor'] . "',
						numDocumentoVendedor	=	'" . $arrPost['numDocumentoVendedor'] . "',
						txtDireccionInmueble	=	'" . $arrPost['txtDireccionInmueble'] . "',
						txtBarrio	=	'" . $arrPost['txtBarrio'] . "',
						seqLocalidad	=	'" . $arrPost['seqLocalidad'] . "',
						txtEscritura	=	'" . $arrPost['txtEscritura'] . "',
						numNotaria	=	'" . $arrPost['numNotaria'] . "',
						fchEscritura	=	'" . $arrPost['fchEscritura'] . "',
						numAvaluo	=	'" . $arrPost['numAvaluo'] . "',
						valInmueble	=	'" . intval($arrPost['valInmueble']) . "',
						txtMatriculaInmobiliaria	=	'" . strtoupper($arrPost['txtMatriculaInmobiliaria']) . "',
						numValorInmueble	=	'" . $arrPost['numValorInmueble'] . "',
						bolPoseedor	=	'" . intval($arrPost['bolPoseedor']) . "',
						txtChip	=	'" . strtoupper($arrPost['txtChip']) . "',
						numActaEntrega = '" . $arrPost['numActaEntrega'] . "',
						txtActaEntrega = '" . $arrPost['txtActaEntrega'] . "',
						numCertificacionVendedor = '" . $arrPost['numCertificacionVendedor'] . "',
						txtCertificacionVendedor = '" . $arrPost['txtCertificacionVendedor'] . "',
						numAutorizacionDesembolso = '" . $arrPost['numAutorizacionDesembolso'] . "',
						txtAutorizacionDesembolso = '" . $arrPost['txtAutorizacionDesembolso'] . "',
						numFotocopiaVendedor = '" . $arrPost['numFotocopiaVendedor'] . "',
						txtFotocopiaVendedor = '" . $arrPost['txtFotocopiaVendedor'] . "',
						seqTipoDocumento = '" . $arrPost['seqTipoDocumento'] . "',
						numAreaLote = '" . $arrPost['numAreaLote'] . "',
						numAreaConstruida = '" . $arrPost['numAreaConstruida'] . "',
						txtCedulaCatastral = '" . $arrPost['txtCedulaCatastral'] . "',
						numTelefonoVendedor = '" . $arrPost['numTelefonoVendedor'] . "',
						numTelefonoVendedor2 = '" . $arrPost['numTelefonoVendedor2'] . "',
						txtTipoPredio = '" . $arrPost['txtTipoPredio'] . "',
						numRut = '" . $arrPost['numRut'] . "',
						txtRut = '" . $arrPost['txtRut'] . "',
						numRit = '" . $arrPost['numRit'] . "',
						txtRit = '" . $arrPost['txtRit'] . "',
						numNit = '" . $arrPost['numNit'] . "',
						txtNit = '" . $arrPost['txtNit'] . "',
						txtCompraVivienda = '" . $arrPost['txtCompraVivienda'] . "',
						numEstrato = '" . $arrPost['numEstrato'] . "',
						txtTipoDocumentos = '" . $arrPost['documentos'] . "',
						txtCiudad = '" . $arrPost['txtCiudad'] . "',
						txtPropiedad = '" . $arrPost['txtPropiedad'] . "',
						fchSentencia = " . $fchSentencia .",
						numJuzgado = '" . intval($arrPost['numJuzgado']) . "',
						txtCiudadSentencia = '" . $arrPost['txtCiudadSentencia'] . "',
						numResolucion = '" . intval($arrPost['numResolucion']) . "',
						fchResolucion = " . $fchResolucion . ",
						txtEntidad = '" . $arrPost['txtEntidad'] . "',
						txtCiudadResolucion = '" . $arrPost['txtCiudadResolucion'] . "',
						numContratoArrendamiento = '" . intval($arrPost['numContratoArrendamiento'] ). "',
						numAperturaCAP = '" . intval($arrPost['numAperturaCAP']) . "',
						txtAperturaCAP = '" . $arrPost['txtAperturaCAP'] . "',
						numCedulaArrendador = '" . intval($arrPost['numCedulaArrendador'] ). "',
						numCuentaArrendador = '" . intval($arrPost['numCuentaArrendador']) . "',
						txtCuentaArrendador = '" . $arrPost['txtCuentaArrendador'] . "',
						numRetiroRecursos = '" . intval($arrPost['numRetiroRecursos']) . "',
						txtRetiroRecursos = '" . $arrPost['txtRetiroRecursos'] . "',
						numServiciosPublicos = '" . intval($arrPost['numServiciosPublicos']) . "',
						txtServiciosPublicos = '" . $arrPost['txtServiciosPublicos'] . "',
						txtCorreoVendedor = '" . $arrPost['txtCorreoVendedor'] . "',
						seqCiudad = '" . $arrPost['seqCiudad'] . "',
						$txtCampos
					WHERE
						seqFormulario = " . $arrPost['seqFormulario'] . "
				";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = $objError->msg;
            }
        }

        if( empty( $arrErrores )){
            $arrErrores = $this->fechaUltimaActualizacion($arrPost['seqFormulario']);
        }

        return $arrErrores;
    }

// Fin guardar desembolso

    public function salvarConceptoJuridico($arrPost) {
        global $aptBd;

        $arrErrores = array();

        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        $sql = "
				INSERT INTO T_SEG_SEGUIMIENTO (
					seqFormulario,
					fchMovimiento,
					seqUsuario,
					txtComentario,
					txtCambios,
					numDocumento,
					txtNombre,
					seqGestion
				) VALUES (
					" . $arrPost['seqFormulario'] . ",
					'" . date("Y-m-d H:i:s") . "',
					" . $_SESSION['seqUsuario'] . ",
					'" . $arrPost['txtComentario'] . "',
					'" . $arrPost['txtCambios'] . "',
					" . $cedulaFormat . ",
					'" . $arrPost['nombre'] . "',
					" . $arrPost['seqGestion'] . "
				)
	 		";

        $this->seqSeguimiento = 0;
        try {
            $aptBd->execute($sql);
            $this->seqSeguimiento = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
            $arrErrores[] = $objError->msg;
        }

        if (empty($arrErrores)) {

            /*
             * VERIFICA SI YA HAY UN REGISTRO EN LA TABLA DE
             * DESEMBOLSO EN REVISION JURIDICA
             * EN CASO DE QUE EXISTA EL REGISTRO MANDA UPDATE
             * SINO MANDA EL INSERT
             */

            if (isset($this->arrJuridico['seqJuridico']) and intval($this->arrJuridico['seqJuridico']) != 0) {
                $sql = "
						UPDATE T_DES_JURIDICO SET
							numResolucion = \"" . $arrPost['numResolucion'] . "\",
							fchResolucion = \"" . $arrPost['resolucion'] . "\",
							txtObservaciones = \"" . $arrPost['observaciones'] . "\",
							txtLibertad = \"" . $arrPost['libertad'] . "\",
							txtConcepto = \"" . $arrPost['concepto'] . "\",
							txtAprobo = \"" . $arrPost['aprobo'] . "\",
							fchActualizacion = \"" . date("Y-m-d H:i:s") . "\"
						WHERE seqJuridico = " . $this->arrJuridico['seqJuridico'] . "
					";
                try {
                    $aptBd->execute($sql);
                    $seqJuridico = $this->arrJuridico['seqJuridico'];
                } catch (Exception $objError) {
                    $arrErrores[] = $objError->msg;
                }
            } else {
                $sql = "
						INSERT INTO T_DES_JURIDICO (
							seqDesembolso,
							numResolucion,
							fchResolucion,
							txtObservaciones,
							txtLibertad,
							txtConcepto,
							txtAprobo,
							fchCreacion,
							fchActualizacion
						) VALUES (
							\"" . $this->seqDesembolso . "\",
							\"" . $arrPost['numResolucion'] . "\",
							\"" . $arrPost['resolucion'] . "\",
							\"" . $arrPost['observaciones'] . "\",
							\"" . $arrPost['libertad'] . "\",
							\"" . $arrPost['concepto'] . "\",
							\"" . $arrPost['aprobo'] . "\",
							\"" . date("Y-m-d H:i:s") . "\",
							\"" . date("Y-m-d H:i:s") . "\"
						)
					";
                try {
                    $aptBd->execute($sql);
                    $seqJuridico = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $arrErrores[] = $objError->msg;
                }
            }

            /**
             * ELIMINA LOS REGISTROS DE LOS
             * DOCUMENTOS ANALIZADOS
             */
            $sql = "
					DELETE
					FROM T_DES_ADJUNTOS_JURIDICOS
					WHERE seqJuridico = $seqJuridico
				";
            $aptBd->execute($sql);

            /**
             * INSERTA LOS REGISTROS DE
             * LOS DOCUMENOS ANALIZADOS
             */
            if (!empty($arrPost['documento'])) {
                foreach ($arrPost['documento'] as $txtDocumento) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_JURIDICOS (
								seqJuridico,
								seqTipoAdjunto,
								txtAdjunto
							) VALUES (
								$seqJuridico,
								1,
								\"$txtDocumento\"
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = $objError->msg;
                    }
                }
            }

            if (!empty($arrPost['recomendacion'])) {
                foreach ($arrPost['recomendacion'] as $txtRecomendacion) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_JURIDICOS (
								seqJuridico,
								seqTipoAdjunto,
								txtAdjunto
							) VALUES (
								$seqJuridico,
								2,
								\"$txtRecomendacion\"
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = $objError->msg;
                    }
                }
            }
        }

        if( empty( $arrErrores )){
            $arrErrores = $this->fechaUltimaActualizacion($arrPost['seqFormulario']);
        }

        return $arrErrores;
    }

    private function cargarConceptoJuridico() {

        global $aptBd;

        $this->arrJuridico = array();

        $sql = "
				SELECT seqJuridico,
						numResolucion,
						fchResolucion,
						txtObservaciones,
						txtLibertad,
						txtConcepto,
						txtAprobo,
						fchCreacion,
						fchActualizacion
				FROM T_DES_JURIDICO
				WHERE seqDesembolso = " . $this->seqDesembolso . "
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            $seqJuridico = $objRes->fields['seqJuridico'];
            foreach ($objRes->fields as $txtCampo => $txtValor) {
                $this->arrJuridico[$txtCampo] = $txtValor;
            }

            $sql = "
					SELECT txtAdjunto
					FROM T_DES_ADJUNTOS_JURIDICOS
					WHERE seqJuridico = $seqJuridico
					and seqTipoAdjunto = 1
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $this->arrJuridico['documento'][] = $objRes->fields['txtAdjunto'];
                $objRes->MoveNext();
            }

            $sql = "
					SELECT txtAdjunto
					FROM T_DES_ADJUNTOS_JURIDICOS
					WHERE seqJuridico = $seqJuridico
					and seqTipoAdjunto = 2
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $this->arrJuridico['recomendacion'][] = $objRes->fields['txtAdjunto'];
                $objRes->MoveNext();
            }
        }
    }

    public function salvarConceptoTecnico($arrPost) {

        global $aptBd;
        global $txtPrefijoRuta;
        $arrErrores = array();

        unset($arrPost['bolBorrar']);
        $seqUsuario = ($_SESSION['seqUsuario']) ? $_SESSION['seqUsuario'] : $arrPost['seqUsuario'];
        unset($arrPost['seqUsuario']);
        $txtPrefijoRuta = ($txtPrefijoRuta) ? $txtPrefijoRuta : $arrPost['txtPrefijoRuta'];
        unset($arrPost['txtPrefijoRuta']);
        unset($arrPost['fase']);

        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        $sql = "
				INSERT INTO T_SEG_SEGUIMIENTO (
					seqFormulario,
					fchMovimiento,
					seqUsuario,
					txtComentario,
					txtCambios,
					numDocumento,
					txtNombre,
					seqGestion
				) VALUES (
					" . $arrPost['seqFormulario'] . ",
					'" . date("Y-m-d H:i:s") . "',
					" . $seqUsuario . ",
					'" . $arrPost['txtComentario'] . "',
					'" . $arrPost['txtCambios'] . "',
					" . $cedulaFormat . ",
					'" . $arrPost['nombre'] . "',
					" . $arrPost['seqGestion'] . "
				)
	 		";
        $this->seqSeguimiento = 0;
        try {
            $aptBd->execute($sql);
            $this->seqSeguimiento = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
            $arrErrores[] = $objError->msg;
        }

        if (empty($arrErrores)) {

            $sql = "
					SELECT seqTecnico
					FROM T_DES_TECNICO
					WHERE seqDesembolso = " . $this->seqDesembolso . "
				";
            $objRes = $aptBd->execute($sql);
            $seqTecnico = 0;
            if ($objRes->fields) {
                $seqTecnico = $objRes->fields['seqTecnico'];
            }

            $seqFormulario = $arrPost['seqFormulario'];

            unset($arrPost['txtFase']);
            unset($arrPost['seqFormulario']);
            unset($arrPost['txtComentario']);
            unset($arrPost['cedula']);
            unset($arrPost['nombre']);
            unset($arrPost['seqGestion']);
            unset($arrPost['seqGrupoGestion']);
            unset($arrPost['btnSalvar']);
            unset($arrPost['seqModalidad']);
            unset($arrPost['seqEstadoProceso']);
            unset($arrPost['txtCambios']);
            unset($arrPost['txtFlujo']);
            unset($arrPost['documentos']);
            unset($arrPost['bolPoseedor']);
            unset($arrPost['txtPropiedad']);

            $arrNombreArchivoCargado = $arrPost['nombreArchivoCargado'];
            $arrTextoArchivoCargado = $arrPost['textoArchivoCargado'];
            $arrObservaciones = $arrPost['observacion'];

            unset($arrPost['nombreArchivoCargado']);
            unset($arrPost['textoArchivoCargado']);
            unset($arrPost['observacion']);

            if ($seqTecnico != 0) {

                $sql = "UPDATE T_DES_TECNICO SET ";
                foreach ($arrPost as $txtClave => $txtValor) {
                    $sql .= $txtClave . " = '$txtValor',";
                }
                $sql .= "fchActualizacion = '" . date("Y-m-d H:i:s") . "' ";
                $sql .= "WHERE seqDesembolso = " . $this->seqDesembolso;
                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido salvar el registro tecnico";
                    $arrErrores[] = $objError->msg;
                }
            } else {

                $sql = "INSERT INTO T_DES_TECNICO ( seqDesembolso , ";
                $sql .= implode(",", array_keys($arrPost)) . ",fchCreacion,fchActualizacion) ";
                $sql .= "VALUES ( '$this->seqDesembolso','" . implode("','", $arrPost) . "','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "' )";

                try {
                    $aptBd->execute($sql);
                    $seqTecnico = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido salvar el registro tecnico";
                    $arrErrores[] = $objError->msg;
                }
            }
        }

        /**
         * SALVAR LAS IMAGENES
         */
        $arrNombreArchivoCargado = ( is_array($arrNombreArchivoCargado) ) ? $arrNombreArchivoCargado : array();
        if (is_dir($txtPrefijoRuta . "recursos/imagenes/desembolsos")) {
            if ($aptDir = opendir($txtPrefijoRuta . "recursos/imagenes/desembolsos")) {

                // Elimina de la carpeta los archivos que no esten en el arreglo que viene del formulario
                while (( $txtArchivo = readdir($aptDir) ) !== false) {
                    if ($txtArchivo != "." and $txtArchivo != "..") {
                        $numFormulario = intval(substr($txtArchivo, 0, strpos($txtArchivo, "_")));
                        $seqFormulario = ( intval($seqFormulario) == 0 )? $this->seqFormulario : $seqFormulario;
                        if ($numFormulario == $seqFormulario) {
                            if (!in_array($txtArchivo, $arrNombreArchivoCargado)) {
                                echo "<br> elimina archivo".$txtArchivo;
                                unlink($txtPrefijoRuta . "recursos/imagenes/desembolsos/" . $txtArchivo);
                            }
                        }
                    }
                }
                closedir($aptDir);

                // Elimina los registros de las imagenes que haya
                // para insertar las que vienen en el formulario
                // las imagenes ya estan fisicamente en la carpeta desde
                // que se cargan en el formulario
                $sql = "
						DELETE
						FROM T_DES_ADJUNTOS_TECNICOS
						WHERE seqTecnico = $seqTecnico
					";
                $aptBd->execute($sql);

                // Para cada imagen se inserta el registro en la base de datos
                foreach ($arrNombreArchivoCargado as $numIndice => $txtNombreArchivo) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_TECNICOS (
								seqTecnico,
								seqTipoAdjunto,
								txtNombreAdjunto,
								txtNombreArchivo
							) VALUES (
								$seqTecnico,
								3,
								'" . $arrTextoArchivoCargado[$numIndice] . "',
								'$txtNombreArchivo'
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo almacenar los datos de la imagen $txtNombreArchivo";
                        $arrErrores[] = $objError->msg;
                    }
                }

                $arrObservaciones = ( is_array($arrObservaciones) ) ? $arrObservaciones : array();
                foreach ($arrObservaciones as $numIndice => $txtTexto) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_TECNICOS (
								seqTecnico,
								seqTipoAdjunto,
								txtNombreAdjunto,
								txtNombreArchivo
							) VALUES (
								$seqTecnico,
								2,
								'" . $txtTexto . "',
								''
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo almacenar una de las observaciones ( $numIndice )";
                    }
                }
            } else {
                $arrErrores[] = "La informacion del registro se salvo pero las imágenes no pudieron salvarse, no se pudo abrir el directorio de imagenes";
            }
        } else {
            $arrErrores[] = "La informacion del registro se salvo pero las imágenes no pudieron salvarse, falta la carpeta de imagenes";
        }

        if( empty( $arrErrores )){
            $arrErrores = $this->fechaUltimaActualizacion($arrPost['seqFormulario']);
        }

        return $arrErrores;
    }

    private function cargarConceptoTecnico() {

        global $aptBd;
        global $txtPrefijoRuta;

        $sql = "
			SELECT seqTecnico,
				seqDesembolso,
				numLargoMultiple,
				numAnchoMultiple,
				numAreaMultiple,
				txtMultiple,
				numLargoAlcoba1,
				numAnchoAlcoba1,
				numAreaAlcoba1,
				txtAlcoba1,
				numLargoAlcoba2,
				numAnchoAlcoba2,
				numAreaAlcoba2,
				txtAlcoba2,
				numLargoAlcoba3,
				numAnchoAlcoba3,
				numAreaAlcoba3,
				txtAlcoba3,
				numLargoCocina,
				numAnchoCocina,
				numAreaCocina,
				txtCocina,
				numLargoBano1,
				numAnchoBano1,
				numAreaBano1,
				txtBano1,
				numLargoBano2,
				numAnchoBano2,
				numAreaBano2,
				txtBano2,
				numLargoLavanderia,
				numAnchoLavanderia,
				numAreaLavanderia,
				txtLavanderia,
				numLargoCirculaciones,
				numAnchoCirculaciones,
				numAreaCirculaciones,
				txtCirculaciones,
				numLargoPatio,
				numAnchoPatio,
				numAreaPatio,
				txtPatio,
				numAreaTotal,
				txtEstadoCimentacion,
				txtCimentacion,
				txtEstadoPlacaEntrepiso,
				txtPlacaEntrepiso,
				txtEstadoMamposteria,
				txtMamposteria,
				txtEstadoCubierta,
				txtCubierta,
				txtEstadoVigas,
				txtVigas,
				txtEstadoColumnas,
				txtColumnas,
				txtEstadoPanetes,
				txtPanetes,
				txtEstadoEnchapes,
				txtEnchapes,
				txtEstadoAcabados,
				txtAcabados,
				txtEstadoHidraulicas,
				txtHidraulicas,
				txtEstadoElectricas,
				txtElectricas,
				txtEstadoSanitarias,
				txtSanitarias,
				txtEstadoGas,
				txtGas,
				txtEstadoMadera,
				txtMadera,
				txtEstadoMetalica,
				txtMetalica,
				numLavadero,
				txtLavadero,
				numLavaplatos,
				txtLavaplatos,
				numLavamanos,
				txtLavamanos,
				numSanitario,
				txtSanitario,
				numDucha,
				txtDucha,
				txtEstadoVidrios,
				txtVidrios,
				txtEstadoPintura,
				txtPintura,
				txtOtros,
				txtObservacionOtros,
				numContadorAgua,
				txtEstadoConexionAgua,
				txtDescripcionAgua,
				numContadorEnergia,
				txtEstadoConexionEnergia,
				txtDescripcionEnergia,
				numContadorAlcantarillado,
				txtEstadoConexionAlcantarillado,
				txtDescripcionAlcantarillado,
				numContadorGas,
				txtEstadoConexionGas,
				txtDescripcionGas,
				numContadorTelefono,
				txtEstadoConexionTelefono,
				txtDescripcionTelefono,
				txtEstadoAndenes,
				txtDescripcionAndenes,
				txtEstadoVias,
				txtDescripcionVias,
				txtEstadoServiciosComunales,
				txtDescripcionServiciosComunales,
				txtDescripcionVivienda,
				txtNormaNSR98,
				txtRequisitos,
				txtExistencia,
				txtDescipcionNormaNSR98,
				txtDescripcionRequisitos,
				txtDescripcionExistencia,
				fchVisita,
				txtAprobo,
				fchCreacion,
				fchActualizacion
			FROM T_DES_TECNICO
			WHERE seqDesembolso = " . $this->seqDesembolso . "
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            $seqTecnico = $objRes->fields['seqTecnico'];
            foreach ($objRes->fields as $txtClave => $txtValor) {
                $this->arrTecnico[$txtClave] = $txtValor;
            }

            $sql = "
					SELECT txtNombreAdjunto,
						txtNombreArchivo,
						seqTipoAdjunto
					FROM T_DES_ADJUNTOS_TECNICOS
					WHERE seqTecnico = $seqTecnico
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                switch ($objRes->fields['seqTipoAdjunto']) {
                    case 2:
                        $numContador = count($this->arrTecnico['observacion']);
                        $this->arrTecnico['observacion'][$numContador] = $objRes->fields['txtNombreAdjunto'];
                        break;
                    default: // Imagenes
                        $numContador = count($this->arrTecnico['imagenes']);
                        $this->arrTecnico['imagenes'][$numContador]['nombre'] = $objRes->fields['txtNombreAdjunto'];
                        $this->arrTecnico['imagenes'][$numContador]['ruta'] = $objRes->fields['txtNombreArchivo'];
                        if (!file_exists($txtPrefijoRuta . "recursos/imagenes/desembolsos/" . $objRes->fields['txtNombreArchivo'])) {
                            $this->arrTecnico['imagenes'][$numContador]['nombre'] = "No Disponible";
                            $this->arrTecnico['imagenes'][$numContador]['ruta'] = "no_disponible.jpg";
                        }
                        break;
                }

                $objRes->MoveNext();
            }
        }
    }

    public function salvarEstudioTitulos($arrPost) {

        global $aptBd;

        $seqUsuario = ( $_SESSION['seqUsuario'] ) ? $_SESSION['seqUsuario'] : $arrPost['seqUsuario'];
        unset($arrPost['seqUsuario']);

        $arrErrores = array();

        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        $sql = "
				INSERT INTO T_SEG_SEGUIMIENTO (
					seqFormulario,
					fchMovimiento,
					seqUsuario,
					txtComentario,
					txtCambios,
					numDocumento,
					txtNombre,
					seqGestion
				) VALUES (
					" . $arrPost['seqFormulario'] . ",
					'" . date("Y-m-d H:i:s") . "',
					" . $seqUsuario . ",
					'" . $arrPost['txtComentario'] . "',
					'" . $arrPost['txtCambios'] . "',
					" . $cedulaFormat . ",
					'" . $arrPost['nombre'] . "',
					" . $arrPost['seqGestion'] . "
				)
	 		";

        $this->seqSeguimiento = 0;
        try {
            $aptBd->execute($sql);
            $this->seqSeguimiento = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
        }

        if (empty($arrErrores)) {

            $sql = "
					SELECT seqEstudioTitulos
					FROM T_DES_ESTUDIO_TITULOS
					WHERE seqDesembolso = " . $this->seqDesembolso . "
				";
            $objRes = $aptBd->execute($sql);
            $seqTitulos = 0;
            if ($objRes->fields) {
                $seqTitulos = $objRes->fields['seqEstudioTitulos'];
            }

            $bolSubsidioSDHT = ( isset($arrPost['subsidioSdht']) and $arrPost['subsidioSdht'] == 1 ) ? 1 : 0;
            $bolSubsidioFonvivienda = ( isset($arrPost['subsidioFonvivienda']) and $arrPost['subsidioFonvivienda'] == 1 ) ? 1 : 0;

            if ($seqTitulos == 0) {

                $sql = "
                        INSERT INTO T_DES_ESTUDIO_TITULOS (
                                seqDesembolso,
                                numEscrituraIdentificacion,
                                fchEscrituraIdentificacion,
                                numNotariaIdentificacion,
                                numEscrituraTitulo,
                                fchEscrituraTitulo,
                                numNotariaTitulo,
                                numFolioMatricula,
                                txtZonaMatricula,
                                fchMatricula,
                                bolSubsidioSDHT,
                                bolSubsidioFonvivienda,
                                numResolucionFonvivienda,
                                numAnoResolucionFonvivienda,
                                txtAprobo,
                                fchCreacion,
                                fchActualizacion,
                                txtCiudadTitulo,
                                txtCiudadIdentificacion,
                                txtCiudadMatricula
                        ) VALUES (
                                '" . $this->seqDesembolso . "',
                                '" . $arrPost['escritura1'] . "',
                                '" . $arrPost['fecha1'] . "',
                                '" . $arrPost['notaria1'] . "',
                                '" . $arrPost['escritura2'] . "',
                                '" . $arrPost['fecha2'] . "',
                                '" . $arrPost['notaria2'] . "',
                                '" . $arrPost['numerofolio'] . "',
                                '" . $arrPost['zona'] . "',
                                '" . $arrPost['fechaMatricula'] . "',
                                '" . $bolSubsidioSDHT . "',
                                '" . $bolSubsidioFonvivienda . "',
                                '" . $arrPost['resolucion'] . "',
                                '" . $arrPost['ano'] . "',
                                '" . $arrPost['aprobo'] . "',
                                '" . date("Y-m-d H:i:s") . "',
                                '" . date("Y-m-d H:i:s") . "',
                                '" . $arrPost['ciudadAdquisicion'] . "',
                                '" . $arrPost['ciudadIdentificacion'] . "',
                                '" . $arrPost['ciudadMatricula'] . "'
                        )
                ";
                try {
                    $aptBd->execute($sql);
                    $seqTitulos = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $arrErrores[] = "No se pudo guardar el registro de estudio de titulos";
                    $arrErrores[] = $objError->msg;
                }
            } else {

                $sql = "
						UPDATE T_DES_ESTUDIO_TITULOS SET
							seqDesembolso				= '" . $this->seqDesembolso . "',
							numEscrituraIdentificacion	= '" . $arrPost['escritura1'] . "',
							fchEscrituraIdentificacion	= '" . $arrPost['fecha1'] . "',
							numNotariaIdentificacion	= '" . $arrPost['notaria1'] . "',
							numEscrituraTitulo			= '" . $arrPost['escritura2'] . "',
							fchEscrituraTitulo			= '" . $arrPost['fecha2'] . "',
							numNotariaTitulo			= '" . $arrPost['notaria2'] . "',
							numFolioMatricula 			= '" . $arrPost['numerofolio'] . "',
							txtZonaMatricula			= '" . $arrPost['zona'] . "',
							fchMatricula				= '" . $arrPost['fechaMatricula'] . "',
							bolSubsidioSDHT				= '" . $bolSubsidioSDHT . "',
							bolSubsidioFonvivienda		= '" . $bolSubsidioFonvivienda . "',
							numResolucionFonvivienda	= '" . $arrPost['resolucion'] . "',
							numAnoResolucionFonvivienda	= '" . $arrPost['ano'] . "',
							txtAprobo					= '" . $arrPost['aprobo'] . "',
							fchActualizacion			= '" . date("Y-m-d H:i:s") . "',
							txtCiudadTitulo				= '" . $arrPost['ciudadAdquisicion'] . "',
							txtCiudadIdentificacion		= '" . $arrPost['ciudadIdentificacion'] . "',
							txtCiudadMatricula			= '" . $arrPost['ciudadMatricula'] . "'
						WHERE seqEstudioTitulos = $seqTitulos
					";

                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "No se pudo actualizar el registro de estudio de titulos";
                    $arrErrores[] = $objError->msg;
                }
            }

            $sql = "
					DELETE
					FROM T_DES_ADJUNTOS_TITULOS
					WHERE seqEstudioTitulos = $seqTitulos
				";
            $aptBd->execute($sql);

            if (is_array($arrPost['observacion'])) {
                foreach ($arrPost['observacion'] as $numIndice => $txtObservacion) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_TITULOS (
								seqEstudioTitulos,
								seqTipoAdjunto,
								txtAdjunto
							) VALUES (
								$seqTitulos,
								4,
								'" . $txtObservacion . "'
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo almacenar los datos de la observacion '$txtObservacion' ";
                        $arrErrores[] = $objError->msg;
                    }
                }
            }

            if (is_array($arrPost['documento'])) {
                foreach ($arrPost['documento'] as $numIndice => $txtDocumento) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_TITULOS (
								seqEstudioTitulos,
								seqTipoAdjunto,
								txtAdjunto
							) VALUES (
								$seqTitulos,
								1,
								'" . $txtDocumento . "'
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo almacenar los datos del documento analizado '$txtDocumento' ";
                        $arrErrores[] = $objError->msg;
                    }
                }
            }

            if (is_array($arrPost['recomendaciones'])) {
                foreach ($arrPost['recomendaciones'] as $numIndice => $txtRecomendacion) {
                    $sql = "
							INSERT INTO T_DES_ADJUNTOS_TITULOS (
								seqEstudioTitulos,
								seqTipoAdjunto,
								txtAdjunto
							) VALUES (
								$seqTitulos,
								2,
								'" . $txtRecomendacion . "'
							)
						";
                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo almacenar los datos de la recomendacion '$txtRecomendacion' ";
                        $arrErrores[] = $objError->msg;
                    }
                }
            }
        }

        if( empty( $arrErrores )){
            $arrErrores = $this->fechaUltimaActualizacion($arrPost['seqFormulario']);
        }

        return $arrErrores;
    }

    private function cargarEstudioTitulos() {

        global $aptBd;

        $arrErrores = array();

         $sql = "
				SELECT seqEstudioTitulos,
						seqDesembolso,
						numEscrituraIdentificacion,
						fchEscrituraIdentificacion,
						numNotariaIdentificacion,
						numEscrituraTitulo,
						fchEscrituraTitulo,
						numNotariaTitulo,
						numFolioMatricula,
						txtZonaMatricula,
						fchMatricula,
						bolSubsidioSDHT,
						bolSubsidioFonvivienda,
						numResolucionFonvivienda,
						numAnoResolucionFonvivienda,
						txtAprobo,
						fchCreacion,
						fchActualizacion,
						txtCiudadTitulo,
						txtCiudadIdentificacion,
						txtCiudadMatricula,
					   txtElaboro
					FROM T_DES_ESTUDIO_TITULOS
					WHERE seqDesembolso = " . $this->seqDesembolso . " order by seqEstudioTitulos desc
			";

        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            $seqTitulos = $objRes->fields['seqEstudioTitulos'];
            foreach ($objRes->fields as $txtClave => $txtValor) {
                $this->arrTitulos[$txtClave] = $txtValor;
            }

            $sql = "
					SELECT seqAdjuntoTitulos,
						txtAdjunto
					FROM T_DES_ADJUNTOS_TITULOS
					WHERE seqEstudioTitulos = $seqTitulos
					AND seqTipoAdjunto = 4
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $this->arrTitulos['observacion'][] = $objRes->fields['txtAdjunto'];
                $objRes->MoveNext();
            }

            $sql = "
						SELECT seqAdjuntoTitulos,
							txtAdjunto
						FROM T_DES_ADJUNTOS_TITULOS
						WHERE seqEstudioTitulos = $seqTitulos
						AND seqTipoAdjunto = 1
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $this->arrTitulos['documentos'][] = $objRes->fields['txtAdjunto'];
                $objRes->MoveNext();
            }

            $sql = "
				SELECT seqAdjuntoTitulos,
					txtAdjunto
				FROM T_DES_ADJUNTOS_TITULOS
				WHERE seqEstudioTitulos = $seqTitulos
				AND seqTipoAdjunto = 2
				";
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $this->arrTitulos['recomendaciones'][] = $objRes->fields['txtAdjunto'];
                $objRes->MoveNext();
            }
        }
        return $arrErrores;
    }

    public function salvarSolicitud($arrPost) {
        global $aptBd, $claActosAdministrativos;
        //pr($arrPost);exit();
        // limpiando caracteres
        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        // obtiene el identificador del formulario del modulo de actos administrativos
        $seqFormularioActo = $claActosAdministrativos->obtenerSecuencial($arrPost['numResolucion'], $arrPost['fchResolucion'], $cedulaFormat);

        $seqUsuario = ( $_SESSION['seqUsuario'] ) ? $_SESSION['seqUsuario'] : $arrPost['seqUsuario'];
        unset($arrPost['seqUsuario']);

        $arrErrores = array();

        $numAno2Digitos = date("y");

        // Fecha de creacion
        list( $ano, $mes, $dia ) = split("-", $arrPost['creacion']);
        $fchCreacion = ( @checkdate($mes, $dia, $ano) !== false ) ? $arrPost['creacion'] : date("Y-m-d H:i:s");

        // solo para obtener el numero del formulario
        $claFormulario = new FormularioSubsidios;
        $claFormulario->cargarFormulario($arrPost['seqFormulario']);
        $txtFormulario = $claFormulario->txtFormulario;

        ////////////////////////////// INICIO VALIDA QUE EL VALOR DE LA SOLICITUD NO SEA NEGATIVO DIC 14 2015 ////////////////////////////////////
        $idFormulario = $arrPost['seqFormulario'];
        $seqDesembolsoActual = $this->seqDesembolso;
        $valorTotal = 0;
        $valorSolicitud = $arrPost['valor'];
        // Recorre las solicitudes almacenadas para el desembolso
        $valAcumulado = 0;
        $sqlAcumulado = "SELECT SUM(valSolicitado) AS acumulado FROM T_DES_SOLICITUD WHERE seqDesembolso = $seqDesembolsoActual";
        $objRes = $aptBd->execute($sqlAcumulado);
        if ($objRes->fields) {
            $valAcumulado = $objRes->fields['acumulado'];
        }
        $valorTotal = $valAcumulado + $valorSolicitud; // Suma las solicitudes almacenadas con el valor solicitado
        // Consulta el valor del subsidio para el hogar actual
        $sqlSubsidio = "SELECT valAspiraSubsidio FROM T_FRM_FORMULARIO WHERE seqFormulario = $idFormulario";
        $objRes = $aptBd->execute($sqlSubsidio);
        if ($objRes->fields) {
            $valSubsidio = $objRes->fields['valAspiraSubsidio'];
        }

        // Verifica que el acumulado de las solicitudes no supere el valor del subsidio asignado al hogar
        //echo "valorTotal:" . $valorTotal . "<br>valSubsidio:" . $valSubsidio;
        if (intval($arrPost['seqSolicitudEditar']) == 0) {
            if ($valorTotal > $valSubsidio) {
                $arrErrores[] = "El valor acumulado de las solicitudes no debe superar el valor del subsidio";
            }
        }

        ////////////////////////////// FIN VALIDA QUE EL VALOR DE LA SOLICITUD NO SEA NEGATIVO ///////////////////////////////////////

        if (empty($arrErrores)) {
            $sql = "
					INSERT INTO T_SEG_SEGUIMIENTO (
						seqFormulario,
						fchMovimiento,
						seqUsuario,
						txtComentario,
						txtCambios,
						numDocumento,
						txtNombre,
						seqGestion
					) VALUES (
						" . $arrPost['seqFormulario'] . ",
						'" . date("Y-m-d H:i:s") . "',
						" . $seqUsuario . ",
						'" . $arrPost['txtComentario'] . "',
						'" . $arrPost['txtCambios'] . "',
						" . $cedulaFormat . ",
						'" . $arrPost['nombre'] . "',
						" . $arrPost['seqGestion'] . "
					)
				";
            $this->seqSeguimiento = 0;
            try { //echo $sql . "<hr>";
                $aptBd->execute($sql);
                $this->seqSeguimiento = $aptBd->Insert_ID();
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
            }
        }

        $fchRegistroPresupuestal1   = ( esFechaValida( $arrPost['fecha1'] ) )? "'" . $arrPost['fecha1'] . "'" : "null";
        $fchRegistroPresupuestal2   = ( esFechaValida( $arrPost['fecha2'] ) )? "'" . $arrPost['fecha2'] . "'" : "null";
        $fchRadicacion              = ( esFechaValida( $arrPost['fechaRadicado'] ) )? "'" . $arrPost['fechaRadicado'] . "'" : "null";
        $fchOrden                   = ( esFechaValida( $arrPost['fechaOrden'] ) )? "'" . $arrPost['fechaOrden'] . "'" : "null";

        if (empty($arrErrores)) {
            $seqDesembolso = $this->seqDesembolso;
            if (intval($arrPost['seqSolicitudEditar']) == 0) {

                $sql = "
						INSERT INTO T_DES_SOLICITUD (
							numRegistroPresupuestal1,
							fchRegistroPresupuestal1,
							numRegistroPresupuestal2,
							fchRegistroPresupuestal2,
							valSolicitado,
							bolDocumentoBeneficiario,
							txtDocumentoBeneficiario,
							bolDocumentoVendedor,
							txtDocumentoVendedor,
							bolCertificacionBancaria,
							txtCertificacionBancaria,
							bolCartaAsignacion,
							txtCartaAsignacion,
							bolAutorizacion,
							txtAutorizacion,
							txtSubsecretaria,
							bolSubsecretariaEncargado,
							txtSubdireccion,
							bolSubdireccionEncargado,
							txtRevisoSubsecretaria,
							txtElaboroSubsecretaria,
							numRadiacion,
							fchRadicacion,
							numOrden,
							fchOrden,
							valOrden,
							seqDesembolso,
							txtConsecutivo,
							numProyectoInversion,
							txtNombreBeneficiarioGiro,
							numDocumentoBeneficiarioGiro,
							txtDireccionBeneficiarioGiro,
							numTelefonoGiro,
							numCuentaGiro,
							txtTipoCuentaGiro,
							seqBancoGiro,
							fchCreacion,
							fchActualizacion,
							bolRut,
							txtRut,
							bolNit,
							txtNit,
							bolCedulaRepresentante,
							txtCedulaRepresentante,
							bolCamaraComercio,
							txtCamaraComercio,
							bolGiroTercero,
							txtGiroTercero,
							bolBancoArrendador,
							txtBancoArrendador,
							bolActaEntregaFisica,
							txtActaEntregaFisica,
							bolActaLiquidacion,
							txtActaLiquidacion,
							txtCorreoGiro
						) VALUES (
							'" . doubleval($arrPost['registro1']) . "',
							" . $fchRegistroPresupuestal1 . ",
							'" . doubleval($arrPost['registro2']) . "',
							" . $fchRegistroPresupuestal2 . ",
							'" . doubleval($arrPost['valor']) . "',
							'" . intval($arrPost['bolCedulaBeneficiario'] ). "',
							'" . $arrPost['txtCedulaBeneficiario'] . "',
							'" . intval($arrPost['bolCedulaVendedor'])  . "',
							'" . $arrPost['txtCedulaVendedor'] . "',
							'" . intval($arrPost['bolCertificacionBancaria'] ) . "',
							'" . $arrPost['txtCertificacionBancaria'] . "',
							'" . intval($arrPost['bolCartaAsignacion'])  . "',
							'" . $arrPost['txtCartaAsignacion'] . "',
							'" . intval($arrPost['bolAutorizacion'])  . "',
							'" . $arrPost['txtAutorizacion'] . "',
							'" . $arrPost['txtSubsecretaria'] . "',
							'" . intval($arrPost['bolSubsecretariaEncargado'])  . "',
							'" . $arrPost['txtSubdireccion'] . "',
							'" . intval($arrPost['bolSubdireccionEncargado'])  . "',
							'" . $arrPost['txtRevisoSubsecretaria'] . "',
							'" . $arrPost['usuario'] . "',
							'" . doubleval($arrPost['numeroRadicado']) . "',
							" . $fchRadicacion . ",
							'" . doubleval($arrPost['numeroOrden']) . "',
							" . $fchOrden . ",
							'" . doubleval($arrPost['monto']) . "',
							'$seqDesembolso',
							'SDHT-SGF-SDRPL-$txtFormulario-$numAno2Digitos',
							'" . doubleval($arrPost['numProyectoInversion']) . "',
							'" . $arrPost['txtNombreBeneficiarioGiro'] . "',
							'" . $arrPost['numDocumentoBeneficiarioGiro'] . "',
							'" . $arrPost['txtDireccionBeneficiarioGiro'] . "',
							'" . doubleval($arrPost['numTelefonoGiro']) . "',
							'" . trim($arrPost['numCuentaGiro']) . "',
							'" . $arrPost['txtTipoCuentaGiro'] . "',
							'" . $arrPost['seqBancoGiro'] . "',
							'" . $fchCreacion . "',
							'" . date("Y-m-d H:i:s") . "',
							'" . intval($arrPost['bolRut'])  . "',
							'" . $arrPost['txtRut'] . "',
							'" . intval($arrPost['bolNit'])  . "',
							'" . $arrPost['txtNit'] . "',
							'" . intval($arrPost['bolCedulaRepresentante'])  . "',
							'" . $arrPost['txtCedulaRepresentante'] . "',
							'" . intval($arrPost['bolCamaraComercio'])  . "',
							'" . $arrPost['txtCamaraComercio'] . "',
							'" . intval($arrPost['bolGiroTercero'])  . "',
							'" . $arrPost['txtGiroTercero'] . "',
							'" . intval($arrPost['bolBancoArrendador'] ) . "',
							'" . $arrPost['txtBancoArrendador'] . "',
							'" . intval($arrPost['bolActaEntregaFisica'] ) . "',
							'" . $arrPost['txtActaEntregaFisica'] . "',
							'" . intval($arrPost['bolActaLiquidacion'] ) . "',
							'" . $arrPost['txtActaLiquidacion'] . "',
							'" . $arrPost['txtCorreoGiro'] . "'
						)
					";
                try {
                    //echo $sql . "<hr>";
                    $aptBd->execute($sql);
                    $seqSolicitud = $aptBd->Insert_ID();

                    $sql = "
							INSERT INTO T_AAD_GIRO (
								seqSolicitud,
								seqFormularioActo,
								numRegistroPresupuestal1,
								fchRegistroPresupuestal1,
								numRegistroPresupuestal2,
								fchRegistroPresupuestal2,
								valSolicitado,
								numRadiacion,
								fchRadicacion,
								numOrden,
								fchOrden,
								valOrden,
								numProyectoInversion,
								txtNombreBeneficiarioGiro,
								numDocumentoBeneficiarioGiro,
								txtDireccionBeneficiarioGiro,
								numTelefonoGiro,
								numCuentaGiro,
								txtTipoCuentaGiro,
								seqBancoGiro,
								fchCreacion,
								fchActualizacion,
								bolGiroTercero,
								txtGiroTercero,
								txtCorreoGiro
							) VALUES (
								$seqSolicitud,
								$seqFormularioActo,
								'" . doubleval( $arrPost['registro1'] ). "',
								" . $fchRegistroPresupuestal1 . ",
								'" . doubleval( $arrPost['registro2']) . "',
								" . $fchRegistroPresupuestal2 . ",
								'" . doubleval($arrPost['valor']) . "',
								'" . doubleval($arrPost['numeroRadicado']) . "',
								" . $fchRadicacion . ",
								'" . doubleval($arrPost['numeroOrden']) . "',
								" . $fchOrden . ",
								'" . doubleval($arrPost['monto']) . "',
								'" . doubleval($arrPost['numProyectoInversion']) . "',
								'" . trim( $arrPost['txtNombreBeneficiarioGiro']) . "',
								'" . $arrPost['numDocumentoBeneficiarioGiro'] . "',
								'" . trim( $arrPost['txtDireccionBeneficiarioGiro'] ). "',
								'" . doubleval( $arrPost['numTelefonoGiro']) . "',
								'" . trim( $arrPost['numCuentaGiro']) . "',
								'" . trim( $arrPost['txtTipoCuentaGiro']) . "',
								'" . doubleval( $arrPost['seqBancoGiro']) . "',
								'" . $fchCreacion . "',
								'" . date("Y-m-d H:i:s") . "',
								'" . intval($arrPost['bolGiroTercero'] ) . "',
								'" . trim($arrPost['txtGiroTercero'] ). "',
								'" . trim( $arrPost['txtCorreoGiro'] ). "'
							)
						";

                    try {
                        //echo $sql . "<hr>";
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se ha podido salvar el historico del giro";
                        $arrErrores[] = $objError->getMessage();
                    }
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido salvar el registro de solicitud de desembolso";
                    $arrErrores[] = $objError->getMessage();
                }
            } else {

                $sql = "
						UPDATE T_DES_SOLICITUD SET
							numRegistroPresupuestal1		=	'" . doubleval( $arrPost['registro1']) . "',
							fchRegistroPresupuestal1		=	" . $fchRegistroPresupuestal1 . ",
							numRegistroPresupuestal2		=	'" . doubleval( $arrPost['registro2']) . "',
							fchRegistroPresupuestal2		=	" . $fchRegistroPresupuestal2 . ",
							valSolicitado					=	'" .doubleval(  $arrPost['valor']) . "',
							bolDocumentoBeneficiario		=	'" . intval($arrPost['bolCedulaBeneficiario']) . "',
							txtDocumentoBeneficiario		=	'" . trim( $arrPost['txtCedulaBeneficiario']) . "',
							bolDocumentoVendedor			=	'" . intval($arrPost['bolCedulaVendedor']) . "',
							txtDocumentoVendedor			=	'" . trim( $arrPost['txtCedulaVendedor'] ). "',
							bolCertificacionBancaria		=	'" . intval($arrPost['bolCertificacionBancaria']) . "',
							txtCertificacionBancaria		=	'" . trim( $arrPost['txtCertificacionBancaria']) . "',
							bolCartaAsignacion				=	'" . intval($arrPost['bolCartaAsignacion']) . "',
							txtCartaAsignacion				=	'" . trim( $arrPost['txtCartaAsignacion']) . "',
							bolAutorizacion					=	'" . intval($arrPost['bolAutorizacion']) . "',
							txtAutorizacion					=	'" . trim( $arrPost['txtAutorizacion']) . "',
							txtSubsecretaria				=	'" . trim( $arrPost['txtSubsecretaria'] ). "',
							bolSubsecretariaEncargado		=	'" . intval($arrPost['bolSubsecretariaEncargado']) . "',
							txtSubdireccion					=	'" . trim( $arrPost['txtSubdireccion']) . "',
							bolSubdireccionEncargado		=	'" . intval($arrPost['bolSubdireccionEncargado']) . "',
							txtRevisoSubsecretaria			=	'" . trim($arrPost['txtRevisoSubsecretaria']) . "',
							txtElaboroSubsecretaria			=	'" . trim( $arrPost['usuario']) . "',
							numRadiacion					=	'" . doubleval( $arrPost['numeroRadicado']) . "',
							fchRadicacion					=	" . $fchRadicacion . ",
							numOrden						=	'" . doubleval( $arrPost['numeroOrden']) . "',
							fchOrden						=	" . $fchOrden . ",
							valOrden						=	'" . doubleval( $arrPost['monto']) . "',
							seqDesembolso					=	'$seqDesembolso',
							numProyectoInversion			=	'" . doubleval( $arrPost['numProyectoInversion'] ). "',
							txtNombreBeneficiarioGiro		=	'" . trim( $arrPost['txtNombreBeneficiarioGiro']) . "',
							numDocumentoBeneficiarioGiro	=	'" . $arrPost['numDocumentoBeneficiarioGiro'] . "',
							txtDireccionBeneficiarioGiro	=	'" . trim( $arrPost['txtDireccionBeneficiarioGiro']) . "',
							numTelefonoGiro					=	'" . doubleval( $arrPost['numTelefonoGiro']) . "',
							numCuentaGiro					=	'" . trim( $arrPost['numCuentaGiro']) . "',
							txtTipoCuentaGiro				=	'" . trim( $arrPost['txtTipoCuentaGiro']) . "',
							seqBancoGiro					=	'" . doubleval( $arrPost['seqBancoGiro'] ). "',
							fchActualizacion				=	'" . date("Y-m-d H:i:s") . "',
							bolRut							=	'" . intval($arrPost['bolRut']) . "',
							txtRut							=	'" . trim( $arrPost['txtRut']) . "',
							bolNit							=	'" . intval($arrPost['bolNit']) . "',
							txtNit							=	'" . trim( $arrPost['txtNit'] ). "',
							bolCedulaRepresentante			=	'" . intval($arrPost['bolCedulaRepresentante']) . "',
							txtCedulaRepresentante			=	'" . trim( $arrPost['txtCedulaRepresentante'] ). "',
							bolCamaraComercio				=	'" . intval($arrPost['bolCamaraComercio']) . "',
							txtCamaraComercio				=	'" . trim( $arrPost['txtCamaraComercio'] ). "',
							bolGiroTercero					=	'" . intval($arrPost['bolGiroTercero']) . "',
							txtGiroTercero					=	'" . trim( $arrPost['txtGiroTercero'] ). "',
							bolBancoArrendador				=	'" . intval($arrPost['bolBancoArrendador']) . "',
							txtBancoArrendador				=	'" . trim( $arrPost['txtBancoArrendador'] ). "',
							bolActaEntregaFisica			=	'" . intval($arrPost['bolActaEntregaFisica']) . "',
							txtActaEntregaFisica			=	'" . trim( $arrPost['txtActaEntregaFisica'] ). "',
							bolActaLiquidacion				=	'" . intval($arrPost['bolActaLiquidacion']) . "',
							txtActaLiquidacion				=	'" . trim( $arrPost['txtActaLiquidacion'] ). "',
							txtConsecutivo					=	'SDHT-SGF-SDRPL-$txtFormulario-$numAno2Digitos',
							txtCorreoGiro					=	'" . trim( $arrPost['txtCorreoGiro'] ). "'
						WHERE seqSolicitud = " . $arrPost['seqSolicitudEditar'];

                try {
                    echo $sql . "<hr>";
                    $aptBd->execute($sql);

                    $sql = "
							UPDATE T_AAD_GIRO SET
								seqFormularioActo = $seqFormularioActo,
								numRegistroPresupuestal1 = '" . doubleval( $arrPost['registro1']) . "',
								fchRegistroPresupuestal1 = " . $fchRegistroPresupuestal1 . ",
								numRegistroPresupuestal2 = '" . doubleval( $arrPost['registro2']) . "',
								fchRegistroPresupuestal2 = " . $fchRegistroPresupuestal2 . ",
								valSolicitado = '" . doubleval( $arrPost['valor']) . "',
								numRadiacion = '" . doubleval( $arrPost['numeroRadicado'] ). "',
								fchRadicacion = " . $fchRadicacion . ",
								numOrden = '" .doubleval(  $arrPost['numeroOrden']) . "',
								fchOrden = " . $fchOrden . ",
								valOrden = '" . doubleval( $arrPost['monto']) . "',
								numProyectoInversion = '" . doubleval( $arrPost['numProyectoInversion']) . "',
								txtNombreBeneficiarioGiro = '" . trim( $arrPost['txtNombreBeneficiarioGiro']) . "',
								numDocumentoBeneficiarioGiro = '" . doubleval( $arrPost['numDocumentoBeneficiarioGiro']) . "',
								txtDireccionBeneficiarioGiro = '" . trim( $arrPost['txtDireccionBeneficiarioGiro']) . "',
								numTelefonoGiro = '" . doubleval( $arrPost['numTelefonoGiro'] ). "',
								numCuentaGiro = '" . trim( $arrPost['numCuentaGiro']) . "',
								txtTipoCuentaGiro = '" . trim( $arrPost['txtTipoCuentaGiro'] ). "',
								seqBancoGiro = '" . doubleval( $arrPost['seqBancoGiro']) . "',
								fchActualizacion = '" . date("Y-m-d H:i:s") . "',
								bolGiroTercero = '" . intval($arrPost['bolGiroTercero']) . "',
								txtGiroTercero = '" . trim( $arrPost['txtGiroTercero'] ). "',
								txtCorreoGiro = '" . trim( $arrPost['txtCorreoGiro']) . "'
							WHERE seqSolicitud = " . doubleval( $arrPost['seqSolicitudEditar']) . ";
						";
                    try {
                        //echo $sql . "<hr>";
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se ha podido actualizar el registro historico de giros";
                    }
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido actualizar el registro de solicitud de desembolso <br>" . $objError;
                }
            } // END IF seqSolicitudEditar = 0
        } // END IF EMPTY ERRORES

        if( empty( $arrErrores )){
            $arrErrores = $this->fechaUltimaActualizacion($arrPost['seqFormulario']);
        }

        return $arrErrores;
    }

    private function cargarSolicitud() {

        global $aptBd;

        $arrErrores = array();

        $sql = "
				SELECT
					seqSolicitud,
					numRegistroPresupuestal1,
					fchRegistroPresupuestal1,
					numRegistroPresupuestal2,
					fchRegistroPresupuestal2,
					valSolicitado,
					bolDocumentoBeneficiario,
					txtDocumentoBeneficiario,
					bolDocumentoVendedor,
					txtDocumentoVendedor,
					bolCertificacionBancaria,
					txtCertificacionBancaria,
					bolCartaAsignacion,
					txtCartaAsignacion,
					bolAutorizacion,
					txtAutorizacion,
					txtSubsecretaria,
					bolSubsecretariaEncargado,
					txtSubdireccion,
					bolSubdireccionEncargado,
					txtRevisoSubsecretaria,
					txtElaboroSubsecretaria,
					numRadiacion,
					fchRadicacion,
					numOrden,
					fchOrden,
					valOrden,
					txtConsecutivo,
					numProyectoInversion,
					txtNombreBeneficiarioGiro,
					numDocumentoBeneficiarioGiro,
					txtDireccionBeneficiarioGiro,
					numTelefonoGiro,
					numCuentaGiro,
					txtTipoCuentaGiro,
					seqBancoGiro,
					fchCreacion,
					fchActualizacion,
					bolRut,
					txtRut,
					bolNit,
					txtNit,
					bolCedulaRepresentante,
					txtCedulaRepresentante,
					bolCamaraComercio,
					txtCamaraComercio,
					bolGiroTercero,
					txtGiroTercero,
					bolBancoArrendador,
					txtBancoArrendador,
					bolActaEntregaFisica,
					txtActaEntregaFisica,
					bolActaLiquidacion,
					txtActaLiquidacion,
					txtCorreoGiro
				FROM T_DES_SOLICITUD
				WHERE seqDesembolso = " . $this->seqDesembolso . "
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $this->arrSolicitud['resumen']['valSolicitudes'] += $objRes->fields['valSolicitado'];
            $this->arrSolicitud['resumen']['valOrdenes'] += $objRes->fields['valOrden'];
            $this->arrSolicitud['resumen']['fechas'][$objRes->fields['seqSolicitud']] = date("Y-m-d", strtotime($objRes->fields['fchCreacion']));

            foreach ($objRes->fields as $txtClave => $txtValor) {
                $this->arrSolicitud['detalles'][$objRes->fields['seqSolicitud']][$txtClave] = $txtValor;
            }

            $objRes->MoveNext();
        }

        return $arrErrores;
    }

    public function borrarSolicitud($seqFormulario, $seqSolicitud, $arrSeguimiento, $bolBorrar = 0) {
        global $aptBd;

        $arrErrores = array();

        $sql = "
				SELECT
					des.seqFormulario
				FROM
					T_DES_SOLICITUD sol,
					T_DES_DESEMBOLSO des
				WHERE sol.seqDesembolso = des.seqDesembolso
				AND sol.seqSolicitud = $seqSolicitud
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $seqFormularioBaseDatos = $objRes->fields['seqFormulario'];
            if ($seqFormularioBaseDatos == $seqFormulario) {

                $cedulaSegFormat = str_replace(".", "", $arrSeguimiento['cedula']);

                $sql = "
						INSERT INTO T_SEG_SEGUIMIENTO (
							seqFormulario,
							fchMovimiento,
							seqUsuario,
							txtComentario,
							txtCambios,
							numDocumento,
							txtNombre,
							seqGestion
						) VALUES (
							" . $seqFormulario . ",
							\"" . date("Y-m-d H:i:s") . "\",
							" . $_SESSION["seqUsuario"] . ",
							\"" . $arrSeguimiento["txtComentario"] . "\",
							\"" . $arrSeguimiento['txtCambios'] . "\",
							" . $cedulaSegFormat . ",
							\"" . $arrSeguimiento['nombre'] . "\",
							" . $arrSeguimiento['seqGestion'] . "
						)
			 		";
                $this->seqSeguimiento = 0;
                try {
                    $aptBd->execute($sql);
                    $this->seqSeguimiento = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
                    $arrErrores[] = $objError->msg;
                    //	 			$arrErrores[] = $sql;
                }

                $sql = "
						DELETE
						FROM T_DES_SOLICITUD
						WHERE seqSolicitud = $seqSolicitud
					";
                $aptBd->execute($sql);

                if ($bolBorrar == 1) {
                    $sql = "
						DELETE
						FROM T_AAD_GIRO
						WHERE seqSolicitud = $seqSolicitud
					";
                    $aptBd->execute($sql);
                }
            } else {
                $arrErrores[] = "El codigo de la solicitud no corresponde a este hogar";
            }
        } else {
            $arrErrores[] = "No se encuentra el registro para borrar [ $seqSolicitud ]";
        }
        return $arrErrores;
    }

    /**
     * SALVA LAS CONSIGNACIONES DEL SCA
     * @author Bernardo Zerda
     * @param Integer seqFormulario
     * @param Array arrPost
     * @return Array arrErrores
     * @version 1.0 Oct 2010
     */
    public function salvarConsignacion($seqFormulario, $arrPost) {
        global $aptBd;

        $seqUsuario = $_SESSION['seqUsuario'];

        $arrErrores = array();

        $cedulaFormat = str_replace(".", "", $arrPost['cedula']);

        $sql = "
				INSERT INTO T_SEG_SEGUIMIENTO (
					seqFormulario,
					fchMovimiento,
					seqUsuario,
					txtComentario,
					txtCambios,
					numDocumento,
					txtNombre,
					seqGestion
				) VALUES (
					" . $seqFormulario . ",
					'" . date("Y-m-d H:i:s") . "',
					" . $seqUsuario . ",
					'" . $arrPost['txtComentario'] . "',
					'" . $arrPost['txtCambios'] . "',
					" . $cedulaFormat . ",
					'" . $arrPost['nombre'] . "',
					" . $arrPost['seqGestion'] . "
				)
	 		";
        $this->seqSeguimiento = 0;
        try {
            $aptBd->execute($sql);
            $this->seqSeguimiento = $aptBd->Insert_ID();

            $sql = "
	 				INSERT INTO T_DES_CONSIGNACIONES (
						seqFormulario,
						txtNombreConsignacion,
						fchConsignacion,
						valConsignacion,
						numCuenta,
						seqBancoConsignacion
	 				) VALUES (
						$seqFormulario,
						'" . $arrPost['txtNombreConsignacion'] . "',
						'" . $arrPost['fchConsignacion'] . "',
						'" . $arrPost['valConsignacion'] . "',
						'" . doubleval($arrPost['numCuenta']) . "',
						'" . $arrPost['seqBancoConsignacion'] . "'
	 				)
				";

            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido salvar los datos de la consignacion, consulta al administrador";
            }
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido registrar el evento, contacte al administrador del sistema";
        }
    }

    private function cargarConsignaciones($seqFormulario) {
        global $aptBd;

        $this->arrConsignaciones = array();
        $sql = "
				SELECT
					seqConsignacion,
					txtNombreConsignacion,
					fchConsignacion,
					valConsignacion,
					numCuenta,
					seqBancoConsignacion
				FROM T_DES_CONSIGNACIONES
				WHERE seqFormulario = $seqFormulario
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $seqConsignacion = $objRes->fields['seqConsignacion'];
            unset($objRes->fields['seqConsignacion']);
            foreach ($objRes->fields as $txtClave => $txtValor) {
                $this->arrConsignaciones[$seqConsignacion][$txtClave] = $txtValor;
            }
            $objRes->MoveNext();
        }
    }

    public function borrarConsignacion($seqFormulario, $seqConsignacion, $arrSeguimiento) {
        global $aptBd;

        $arrErrores = array();

        $sql = "
				SELECT
					con.seqFormulario
				FROM
					T_DES_CONSIGNACIONES con
				WHERE con.seqConsignacion = $seqConsignacion
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            $cedulaSegFormat = str_replace(".", "", $arrSeguimiento['cedula']);

            $sql = "
					INSERT INTO T_SEG_SEGUIMIENTO (
						seqFormulario,
						fchMovimiento,
						seqUsuario,
						txtComentario,
						txtCambios,
						numDocumento,
						txtNombre,
						seqGestion
					) VALUES (
						" . $seqFormulario . ",
						\"" . date("Y-m-d H:i:s") . "\",
						" . $_SESSION["seqUsuario"] . ",
						\"" . $arrSeguimiento["txtComentario"] . "\",
						\"" . $arrSeguimiento['txtCambios'] . "\",
						" . $cedulaSegFormat . ",
						\"" . $arrSeguimiento['nombre'] . "\",
						" . $arrSeguimiento['seqGestion'] . "
					)
		 		";
            $this->seqSeguimiento = 0;
            try {
                $aptBd->execute($sql);
                $this->seqSeguimiento = $aptBd->Insert_ID();

                $sql = "
						DELETE
						FROM T_DES_CONSIGNACIONES
						WHERE seqConsignacion = $seqConsignacion
					";
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido borrar la consignacion, contacte al administrador del sistema";
            }
        } else {
            $arrErrores[] = "No se encuentra el registro para borrar [ $seqConsignacion ]";
        }
        return $arrErrores;
    }

    /**
     * DETERMINA SI HAY CAMBIOS ENTRE EL
     * FORMULARIO EN PANTALLA Y LA BASE DE DATOS
     */
    public function hayCambios($arrPost, $txtFase = "") {
        $txtFase = ( $txtFase == "" ) ? "escritura" : $txtFase;
        $bolCambios = false;
        switch (true) {
            case $txtFase == "busquedaOferta":
                foreach ($arrPost as $txtClave => $txtValor) {
                    switch (substr($txtClave, 0, 3)) {
                        case "num":
                            //echo "<b>num --> " . $txtClave . " this->txtClave:</b> " . $this->$txtClave . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( floatval($txtValor) != floatval($this->$txtClave) ) ? true : $bolCambios;
                            break;
                        case "seq":
                            //echo "<b>seq --> " . $txtClave . " this->txtClave:</b> " . $this->$txtClave . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( intval($txtValor) != intval($this->$txtClave) ) ? true : $bolCambios;
                            break;
                        case "fch":
                            //echo "<b>fch --> " . $txtClave . " this->txtClave:</b> " . $this->$txtClave . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $txtValor = ( trim($txtValor) == "" ) ? "0000-00-00" : $txtValor;
                            $this->$txtClave = ( trim($this->$txtClave) == "" ) ? "0000-00-00" : $this->$txtClave;
                            $bolCambios = ( strtotime($txtValor) != strtotime($this->$txtClave) ) ? true : $bolCambios;
                            break;
                        case "txt":
                            //echo "<b>txt --> " . $txtClave . " this->txtClave:</b> " . $this->$txtClave . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( trim(strtoupper($txtValor)) != trim(strtoupper($this->$txtClave)) ) ? true : $bolCambios;
                            break;
                        default:
                            //echo "<b>Otros --> " . $txtClave . " this->txtClave:</b> " . $this->$txtClave . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( trim($txtValor) != trim($this->$txtClave) ) ? true : $bolCambios;
                            break;
                    }
                }
                break;
            case $txtFase == "escrituracion":
                foreach ($arrPost as $txtClave => $txtValor) {
                    switch (substr($txtClave, 0, 3)) {
                        case "num":
                            //echo "<b>num --> " . $txtClave . " this->txtClave:</b> " . $this->arrEscrituracion[$txtClave] . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( floatval($txtValor) != floatval($this->arrEscrituracion[$txtClave]) ) ? true : $bolCambios;
                            break;
                        case "seq":
                            //echo "<b>seq --> " . $txtClave . " this->txtClave:</b> " . $this->arrEscrituracion[$txtClave] . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( intval($txtValor) != intval($this->arrEscrituracion[$txtClave]) ) ? true : $bolCambios;
                            break;
                        case "fch":
                            //echo "<b>fch --> " . $txtClave . " this->txtClave:</b> " . $this->arrEscrituracion[$txtClave] . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $txtValor = ( trim($txtValor) == "" ) ? "0000-00-00" : $txtValor;
                            $this->arrEscrituracion[$txtClave] = ( trim($this->arrEscrituracion[$txtClave]) == "" ) ? "0000-00-00" : $this->arrEscrituracion[$txtClave];
                            $bolCambios = ( strtotime($txtValor) != strtotime($this->arrEscrituracion[$txtClave]) ) ? true : $bolCambios;
                            break;
                        case "txt":
                            //echo "<b>txt --> " . $txtClave . " this->txtClave:</b> " . $this->arrEscrituracion[$txtClave] . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( trim(strtoupper($txtValor)) != trim(strtoupper($this->arrEscrituracion[$txtClave])) ) ? true : $bolCambios;
                            break;
                        default:
                            //echo "<b>Otros --> " . $txtClave . " this->txtClave:</b> " . $this->arrEscrituracion[$txtClave] . " --> <b>txtValor: </b>" . $txtValor . "<br>";
                            $bolCambios = ( trim($txtValor) != trim($this->arrEscrituracion[$txtClave]) ) ? true : $bolCambios;
                            break;
                    }
                }
                break;
            case $txtFase == "revisionJuridica":

                // verificando que los datos sean iguales
                if (trim($this->arrJuridico["txtAprobo"]) != trim($arrPost["aprobo"])) {
                    $bolCambios = true;
                }

                if ($this->arrJuridico["numResolucion"] != intval($arrPost["numResolucion"])) {
                    $bolCambios = true;
                }

                if (strtotime($this->arrJuridico["fchResolucion"]) != strtotime($arrPost["resolucion"])) {
                    $bolCambios = true;
                }

                if (trim($this->arrJuridico["txtObservaciones"]) != trim($arrPost["observaciones"])) {
                    $bolCambios = true;
                }

                if (trim($this->arrJuridico["txtLibertad"]) != trim($arrPost["libertad"])) {
                    $bolCambios = true;
                }

                if (trim($this->arrJuridico["txtConcepto"]) != trim($arrPost["concepto"])) {
                    $bolCambios = true;
                }

                // verificando que no cambien los documentos
                $arrPost["documento"] = (!isset($arrPost["documento"]) ) ? array() : $arrPost["documento"];
                if (count($this->arrJuridico["documento"]) != count($arrPost["documento"])) {
                    $bolCambios = true;
                } else {
                    $this->arrJuridico["documento"] = (!empty($this->arrJuridico["documento"]) ) ? $this->arrJuridico["documento"] : array();
                    foreach ($this->arrJuridico["documento"] as $txtDocumento) {
                        if (!in_array($txtDocumento, $arrPost["documento"])) {
                            $bolCambios = true;
                        }
                    }
                }

                // verificando que no cambien las recomendaciones
                $arrPost["recomendacion"] = (!isset($arrPost["recomendacion"]) ) ? array() : $arrPost["recomendacion"];
                if (count($this->arrJuridico["recomendacion"]) != count($arrPost["recomendacion"])) {
                    $bolCambios = true;
                } else {
                    $this->arrJuridico["recomendacion"] = (!empty($this->arrJuridico["recomendacion"]) ) ? $this->arrJuridico["recomendacion"] : array();
                    foreach ($this->arrJuridico["recomendacion"] as $txtDocumento) {
                        if (!in_array($txtDocumento, $arrPost["recomendacion"])) {
                            $bolCambios = true;
                        }
                    }
                }

                break;
            case $txtFase == "revisionTecnica":

                // Verifica cambios en las variables del formulario
                // se llaman igual en el post y en la clase
                foreach ($arrPost as $txtClave => $txtValor) {
                    if (isset($this->arrTecnico[$txtClave])) {
                        if (trim($this->arrTecnico[$txtClave]) != trim($txtValor)) {
                            $bolCambios = true;
                        }
                    } else {
                        if (trim($txtValor) != "" and $txtClave != "txtFlujo") {
                            $bolCambios = true;
                        }
                    }
                }

                // varifica cambios en las imagenes
                // no esta igual en el post y en la clase
                if (count($this->arrTecnico["imagenes"]) != count($arrPost["nombreArchivoCargado"])) {
                    $bolCambios = true;
                } else {
                    // monta los nombres de los archivos en un arreglo
                    $arrArchivos = array();
                    $this->arrTecnico["imagenes"] = ( is_array($this->arrTecnico["imagenes"]) ) ? $this->arrTecnico["imagenes"] : array();
                    foreach ($this->arrTecnico["imagenes"] as $arrImagen) {
                        $arrArchivos[] = $arrImagen["ruta"];
                    }

                    // compara los nombres de los archivos (esta no es la etiqueta de la foto es el nombre del archivo)
                    $arrPost["nombreArchivoCargado"] = ( is_array($arrPost["nombreArchivoCargado"]) ) ? $arrPost["nombreArchivoCargado"] : array();
                    foreach ($arrPost["nombreArchivoCargado"] as $txtArchivo) {
                        if (!in_array($txtArchivo, $arrArchivos)) {
                            $bolCambios = true;
                        }
                    }
                }

                // verifica cambios en vivienda nueva
                if (count($this->arrTecnico["observacion"]) != count($arrPost["observacion"])) {
                    $bolCambios = true;
                } else {
                    $arrPost["observacion"] = ( is_array($arrPost["observacion"]) ) ? $arrPost["observacion"] : array();
                    foreach ($arrPost["observacion"] as $txtObservacion) {
                        if (!in_array($txtObservacion, $this->arrTecnico["observacion"])) {
                            $bolCambios = true;
                        }
                    }
                }
                break;

            case $txtFase == "estudioTitulos":

                $arrDato['aprobo'] = "txt";
                $arrDato['fecha1'] = "fch";
                $arrDato['notaria1'] = "num";
                $arrDato['fecha2'] = "fch";
                $arrDato['notaria2'] = "num";
                $arrDato['ciudadAdquisicion'] = "txt";
                $arrDato['ciudadIdentificacion'] = "txt";
                $arrDato['numerofolio'] = "num";
                $arrDato['zona'] = "txt";
                $arrDato['ciudadMatricula'] = "txt";
                $arrDato['fechaMatricula'] = "fch";
                $arrDato['resolucion'] = "num";
                $arrDato['ano'] = "num";
                $arrDato['escritura1'] = "num";
                $arrDato['escritura2'] = "num";
                $arrDato['txtPropiedad'] = "txt";

                // reemplaza todos los caracteres que son de presentacion
                // y que no deben ir a la base de datos
                foreach ($arrPost as $txtClave => $txtValor) {
                    if (!is_array($arrPost[$txtClave])) {
                        switch ($arrDato[$txtClave]) {
                            case "txt":
                                $arrPost[$txtClave] = preg_replace("/[^áéíóúñÁÉÍÓÚÑA-Za-z0-9\ \.\-\/]/", "", $txtValor);
                                break;
                            case "fch":
                                $arrPost[$txtClave] = preg_replace("/[^0-9\-\/]/", "", $txtValor);
                                break;
                            case "num":
                                $arrPost[$txtClave] = preg_replace("/[^0-9]/", "", $txtValor);
                                break;
                            default:
                                $arrPost[$txtClave] = preg_replace("/[^áéíóúñÁÉÍÓÚÑA-Za-z0-9\ \.\-\/]/", "", $txtValor);
                                break;
                        }
                    }
                }

                // si no esta marcado el check de subsidio de fonvivienda
                // los valores de resulucion y anio desaparecen
                if (!isset($arrPost['subsidioFonvivienda'])) {
                    unset($arrPost['resolucion']);
                    unset($arrPost['ano']);
                }

                // verificando cambios de las variables
                if (trim($this->arrTitulos["txtAprobo"]) != trim($arrPost["aprobo"])) {
                    $bolCambios = true; // echo "txtAprobo";
                }if (intval($this->arrTitulos["numEscrituraIdentificacion"]) != intval($arrPost["escritura1"])) {
                    $bolCambios = true; // echo "numEscrituraIdentificacion";
                }if (strtotime($this->arrTitulos["fchEscrituraIdentificacion"]) != strtotime($arrPost["fecha1"])) {
                    $bolCambios = true; // echo "fchEscrituraIdentificacion";
                }if (intval($this->arrTitulos["numNotariaIdentificacion"]) != intval($arrPost["notaria1"])) {
                    $bolCambios = true; // echo "numNotariaIdentificacion";
                }if (intval($this->arrTitulos["numEscrituraTitulo"]) != intval($arrPost["escritura2"])) {
                    $bolCambios = true; // echo "numEscrituraTitulo";
                }if (strtotime($this->arrTitulos["fchEscrituraTitulo"]) != strtotime($arrPost["fecha2"])) {
                    $bolCambios = true; // echo "fchEscrituraTitulo";
                }if (intval($this->arrTitulos["numNotariaTitulo"]) != intval($arrPost["notaria2"])) {
                    $bolCambios = true; // echo "numNotariaTitulo";
                }if (intval($this->arrTitulos["numFolioMatricula"]) != intval($arrPost["numerofolio"])) {
                    $bolCambios = true; // echo "numFolioMatricula";
                }if (trim($this->arrTitulos["txtZonaMatricula"]) != trim($arrPost["zona"])) {
                    $bolCambios = true; // echo "txtZonaMatricula";
                }if (strtotime($this->arrTitulos["fchMatricula"]) != strtotime($arrPost["fechaMatricula"])) {
                    $bolCambios = true; // echo "fchMatricula";
                }if (intval($this->arrTitulos["numResolucionFonvivienda"]) != intval($arrPost['resolucion'])) {
                    $bolCambios = true; // echo "numResolucionFonvivienda";
                }if (intval($this->arrTitulos["numAnoResolucionFonvivienda"]) != intval($arrPost['ano'])) {
                    $bolCambios = true; // echo "numAnoResolucionFonvivienda";
                }if (trim($this->arrTitulos["txtCiudadTitulo"]) != trim($arrPost['ciudadAdquisicion'])) {
                    $bolCambios = true; // echo "txtCiudadTitulo";
                }if (trim($this->arrTitulos["txtCiudadIdentificacion"]) != trim($arrPost['ciudadIdentificacion'])) {
                    $bolCambios = true;
                }

                // verificando cambios en las observaciones
                if (count($this->arrTitulos["observacion"]) != count($arrPost["observacion"])) {
                    $bolCambios = true; // echo "observacion";
                } else {
                    $arrPost["observacion"] = ( is_array($arrPost["observacion"]) ) ? $arrPost["observacion"] : array();
                    foreach ($arrPost["observacion"] as $txtObservacion) {
                        if (!in_array($txtObservacion, $this->arrTitulos["observacion"])) {
                            $bolCambios = true;
                        }
                    }
                }

                // verificando cambios en los documentos
                if (count($this->arrTitulos["documentos"]) != count($arrPost["documento"])) {
                    $bolCambios = true; // echo "documentos";
                } else {
                    $arrPost["documento"] = ( is_array($arrPost["documento"]) ) ? $arrPost["documento"] : array();
                    foreach ($arrPost["documento"] as $txtDocumento) {
                        if (!in_array($txtDocumento, $this->arrTitulos["documentos"])) {
                            $bolCambios = true;
                        }
                    }
                }

                // verificando cambios en las recomendaciones
                if (count($this->arrTitulos["recomendaciones"]) != count($arrPost["recomendaciones"])) {
                    $bolCambios = true; // echo "recomendaciones";
                } else {
                    $arrPost["recomendaciones"] = ( is_array($arrPost["recomendaciones"]) ) ? $arrPost["recomendaciones"] : array();
                    foreach ($arrPost["recomendaciones"] as $txtRecomendaciones) {
                        if (!in_array($txtRecomendaciones, $this->arrTitulos["recomendaciones"])) {
                            $bolCambios = true;
                        }
                    }
                }
                break;

            case $txtFase == "solicitudDesembolso" or $txtFase == "legalizacion":

                // Si no hay un proyecto de inversion se toma como
                // que esta haciendo un comentario sin cambios
                // cuando es solo comentarios tambien vienen los post
                // lo que hace que no se pueda saber cuando se cera un
                // registro nuevo y cuando es solo comentario
                if (intval($arrPost["numProyectoInversion"]) == 0) {
                    $bolCambios = false;
                } else {
                    // Lo paso a un arreglo para simplificar escritura
                    $arrSolicitud = $this->arrSolicitud["detalles"][$arrPost["seqSolicitudEditar"]];

                    // cuando el registro no es para edicion pero esta diligenciado
                    // se toma como insert, es un nuevo registro
                    if (empty($arrSolicitud)) {
                        $bolCambios = true;
                    } else {
                        // verificacion de los checkbox
                        $arrPost['bolSubsecretariaEncargado'] = (!isset($arrPost['bolSubsecretariaEncargado']) ) ? 0 : $arrPost['bolSubsecretariaEncargado'];
                        $arrPost['bolSubdireccionEncargado'] = (!isset($arrPost['bolSubdireccionEncargado']) ) ? 0 : $arrPost['bolSubdireccionEncargado'];

                        // comparando las claves que son iguales en la clase y en el post
                        foreach ($arrPost as $txtClave => $txtValor) {
                            if (isset($arrSolicitud[$txtClave])) {
                                if ($arrSolicitud[$txtClave] != $txtValor) {
                                    $bolCambios = true;
                                }
                                if ($txtClave == "numCuentaGiro") {
                                    if (strcmp($arrSolicitud[$txtClave], $txtValor)) {
                                        $bolCambios = true;
                                    }
                                }
                            }
                        }

                        // cuadro de chequeo de documento de beneficiario
                        $arrPost["bolCedulaBeneficiario"] = ( isset($arrPost["bolCedulaBeneficiario"]) ) ? $arrPost["bolCedulaBeneficiario"] : 0;
                        if ($arrSolicitud["bolDocumentoBeneficiario"] != $arrPost["bolCedulaBeneficiario"]) {
                            $bolCambios = true;
                        }

                        // texto del documento de beneficiario
                        if (trim($arrSolicitud["txtDocumentoBeneficiario"]) != trim($arrPost["txtCedulaBeneficiario"])) {
                            $bolCambios = true;
                        }

                        // cuadro de chequeo de documento de vendedor
                        $arrPost["bolCedulaVendedor"] = ( isset($arrPost["bolCedulaVendedor"]) ) ? $arrPost["bolCedulaVendedor"] : 0;
                        if ($arrSolicitud["bolDocumentoVendedor"] != $arrPost["bolCedulaVendedor"]) {
                            $bolCambios = true;
                        }

                        // texto del documento de vendedor
                        if (trim($arrSolicitud["txtDocumentoVendedor"]) != trim($arrPost["txtCedulaVendedor"])) {
                            $bolCambios = true;
                        }

                        // numero de registro presupuestal 1
                        if (intval($arrSolicitud["numRegistroPresupuestal1"]) != intval($arrPost["registro1"])) {
                            $bolCambios = true;
                        }

                        // fecha de registro presupuestal 1
                        if (strtotime($arrSolicitud["fchRegistroPresupuestal1"]) != strtotime(textoFecha2Fecha($arrPost["fecha1"]))) {
                            $bolCambios = true;
                        }

                        // numero de regisro presupuestal 2
                        if (intval($arrSolicitud["numRegistroPresupuestal2"]) != intval($arrPost["registro2"])) {
                            $bolCambios = true;
                        }

                        // fecha de registro presupuestal 2
                        if (strtotime($arrSolicitud["fchRegistroPresupuestal2"]) != strtotime(textoFecha2Fecha($arrPost["fecha2"]))) {
                            $bolCambios = true;
                        }

                        // Valor solicitado
                        if ($arrSolicitud["valSolicitado"] != $arrPost["valor"]) {
                            $bolCambios = true;
                        }

                        // numero de radicacion
                        if (intval($arrSolicitud["numRadiacion"]) != intval($arrPost["numeroRadicado"])) {
                            $bolCambios = true;
                        }

                        // fecha de radicado
                        if (strtotime($arrSolicitud["fchRadicacion"]) != strtotime(textoFecha2Fecha($arrPost["fechaRadicado"]))) {
                            $bolCambios = true;
                        }

                        // numero de orden de pago
                        if (intval($arrSolicitud["numOrden"]) != intval($arrPost["numeroOrden"])) {
                            $bolCambios = true;
                        }

                        // fecha de orden
                        if (strtotime($arrSolicitud["fchOrden"]) != strtotime(textoFecha2Fecha($arrPost["fechaOrden"]))) {
                            $bolCambios = true;
                        }

                        // Valor de la orden de pago
                        $arrPost["monto"] = str_replace(",", "", $arrPost["monto"]);
                        $arrPost["monto"] = ( is_numeric($arrPost["monto"]) ) ? $arrPost["monto"] : 0;
                        if ($arrSolicitud["valOrden"] != $arrPost["monto"]) {
                            $bolCambios = true;
                        }
                    } // cuando tiene numero de inversion pero no hay un registro para editar se toma como insert
                } // si no viene el numero del proyecto de inversion ignora el registro
                break;
        }
        //var_dump( $bolCambios );

        return $bolCambios;
    }

    /**
     * ACTUALIZA LA ULTIMA FECHA DE ACTUALIZACION DEL FORMULARIO
     * @param $seqFormulario
     */
    private function fechaUltimaActualizacion( $seqFormulario ){
        global $aptBd;
        $arrErrores = array();
        try {
            $sql = "
              UPDATE T_FRM_FORMULARIO SET 
                fchUltimaActualizacion = NOW()
              WHERE seqFormulario = $seqFormulario
          ";
            $aptBd->execute($sql);
        } catch ( Exception $objError ){
            $arrErrores[] = "Hubo problemas al intentar modificr la fecha de última actualización del formulario";
            //$arrErrores[] = $objError->getMessage();
        }
    }

}

// Fin clase
?>