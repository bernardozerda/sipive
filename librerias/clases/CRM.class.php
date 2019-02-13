<?php

class CRM {

    public $arrTutores;
    public $arrTutoresNoAsignados;
    public $arrTutoresXCoordinadores;
    public $arrHogaresSinAsignar;
    public $arrCoordinadores;
    public $arrNombreTutor;
    public $arrNombreTutorNoCuenta;
    public $txtTutoresInformacionJS;
    public $txtHogaresSinAsignarJS;
    public $txtTutoresMasivaJS;

    /*
     * Campos para indicadores Tutores
     */
    public $numDiasPromedio;
    public $numDesembolsoTotal;
    public $numTotalHoy;
    public $numTotalSemana;
    public $numTotalMes;
    public $arrIndicadorCuenta;
    public $txtTipoReporte;
    public $txtIndicadorTutorDesembolsoJS;
    public $objRes;
    public $tiempoVerde;
    public $tiempoAmarillo;
    public $seqUsuario;
    public $arrSeqVSUsuario;
    public $arrPagosMensual = array();
    public $arrPagoPorContrato = array();
    public $arrPagoPorContratoTotal = array();
    public $arrDatosConcepto = array();
    public $arrDatosIndicadorNomina = array();
    public $arrDatosIndicadorNominaFinalizadas = array();
    public $arrVigenciasResoluciones = array();
    public $arrActosAdministrativos = array();
    public $arrGraficaResolucionesTotalHogaresTODO = array();
    public $arrGraficaResolucionesTotalGirosTODO = array();
    public $arrGraficaResolucionesCDPEjecutado = array();
    public $arrResumenDesembolsos = array();
    public $txtOperacionesJS;
    public $txtOperacionePorContratosJS;
    public $txtOperacionePorContratosTotalJS;
    public $txtConcepto644JS;
    public $txtConcepto488JS;
    public $txtNominaJS;
    public $txtNominaFinalizadaJS;
    public $txtVigenciaResolucion488JS;
    public $txtVigenciaResolucion644JS;
    public $txtProyecto644JS;
    public $txtProyecto488JS;
    public $txtResolucionesTotalGirosTODOJS;
    public $txtResolucionesTotalHogaresTODOJS;
    public $txtResolucionesCDPEjecutado644JS;
    public $txtResolucionesCDPEjecutado488JS;
    public $txtResolucionesTotal644;
    public $txtResolucionesTotal488;
    public $txtResumenDesembolsosJS;

    function CRM() {
        
    }

    private function esTutorDesembolso($seqUsuario) {

        global $aptBd;

        $sql = "
                SELECT 
                    count( 1 ) as cuenta
                FROM T_COR_GRUPO gru
                INNER JOIN T_COR_PROYECTO_GRUPO pro ON pro.seqGrupo = gru.seqGrupo
                INNER JOIN T_COR_PERFIL per ON per.seqProyectoGrupo = pro.seqProyectoGrupo
                INNER JOIN T_COR_USUARIO usu ON per.seqUsuario = usu.seqUsuario
                WHERE 
                usu.seqUsuario = $seqUsuario
                    AND gru.seqGrupo IN ( 8 )
                    AND usu.seqUsuario <> 1
                    AND usu.bolActivo = 1
                    AND usu.seqUsuario NOT IN (
                        SELECT 
                            usu1.seqUsuario
                        FROM T_COR_GRUPO gru1
                        INNER JOIN T_COR_PROYECTO_GRUPO pro1 ON pro1.seqGrupo = gru1.seqGrupo
                        INNER JOIN T_COR_PERFIL per1 ON per1.seqProyectoGrupo = pro1.seqProyectoGrupo 
                        INNER JOIN T_COR_USUARIO usu1 ON per1.seqUsuario = usu1.seqUsuario
                        WHERE 
                            gru1.seqGrupo IN ( 18 , 9 , 13 , 14 , 7 )
                            OR usu1.seqUsuario IN ( 135 , 136 , 150 , 139 , 157 , 98 , 160 , 144 )
                    )
                ";

        $objRes = $aptBd->execute($sql);

        return $objRes->fields["cuenta"];
    }

    public function asignarFormularioTutor($seqFormulario) {

        global $aptBd;

        $sql = "
					SELECT
					COUNT( 1 ) AS cuenta
					FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS 
					WHERE seqFormulario = $seqFormulario
			";
        $objRes = $aptBd->execute($sql);

        // NO SE HA ASIGNADO A TUTOR
        if ($objRes->fields["cuenta"] == 0) {

            $seqUsuario = $_SESSION["seqUsuario"];
            $fchHoy = date("Y-m-d");

            if ($this->esTutorDesembolso($seqUsuario)) {

                $sql = "
						INSERT INTO T_IND_FORMULARIO_USUARIOS_ASIGNADOS 
						( seqFormulario , seqUsuario , fchAsignado ) 
						VALUES ( $seqFormulario , $seqUsuario ,  '$fchHoy' )
						";
                $aptBd->execute($sql);
            }
        }
    }

    private function convertirActosIndicadoresSolicitudJSDataTable() {

        global $arrMeses;

        $arrFinal = array();

        foreach ($this->arrActosAdministrativos as $numProyecto => $arrActos) {

            $arrDatos = array();

            foreach ($arrActos as $numFechaActo => $arrDatosActo) {

                $arrTemporal = array();

                $arrNumFechaActo = explode(" - ", $numFechaActo);
                $arrFecha = explode("-", $arrNumFechaActo[1]);

                $txtFecha = $arrMeses[intval($arrFecha[1])] . " " . $arrFecha[2] . " de " . $arrFecha[0];
                $numActo = $arrNumFechaActo[0];

                $valDiferencia = $arrDatosActo["Valor CDP"] - $arrDatosActo["Valor RP"];

                if ($numFechaActo == "TOTAL") {
                    $arrTemporal["Resolucion"] = "Total";
                } else {
                    $arrTemporal["Resolucion"] = "Resolución $numActo del $txtFecha";
                }

                $arrTemporal["CDP"] = number_format($arrDatosActo["CDP"], 0, '.', ',');
                $arrTemporal["RP"] = number_format($arrDatosActo["RP"], 0, '.', ',');
                $arrTemporal["ValorCDP"] = number_format($arrDatosActo["Valor CDP"], 0, '.', ',');
                $arrTemporal["ValorRP"] = number_format($arrDatosActo["Valor RP"], 0, '.', ',');
                $arrTemporal["Diferencia"] = number_format($valDiferencia, 0, '.', ',');
                $arrTemporal["Ejecutado"] = number_format($arrDatosActo["Ejecutado"], 0, '.', ',');
                $arrTemporal["Renuncia"] = number_format($arrDatosActo["Renuncia"], 0, '.', ',');
                $arrTemporal["Saldo"] = number_format($arrDatosActo["Saldo"], 0, '.', ',');
                $arrTemporal["SaldoPorEjecutar"] = number_format($arrDatosActo["Saldo por Ejecutar"], 0, '.', ',');


                $arrDatos[] = $arrTemporal;
            }

            $arrFinal[$numProyecto] = $arrDatos;
        }

        $this->txtProyecto644JS = $this->arrayToJsDataTable($arrFinal[644], "Proyecto644");
        $this->txtProyecto488JS = $this->arrayToJsDataTable($arrFinal[488], "Proyecto488");
    }

    /**
     * Genera los indicadores para la vigencia de nomina discriminado por la nomina vigente y la finalizada
     * @global Object aptBd Objeto ADODB
     * @global array arrMeses
     * @author Diego Gaitan
     * @version 1.0
     * 
     */
    function obtenerIndicadorVigenciaNomina() {

        global $aptBd;
        global $arrMeses;

        $arrDatosIndicadorNomina = &$this->arrDatosIndicadorNomina;
        $arrDatosIndicadorNominaFinalizadas = &$this->arrDatosIndicadorNominaFinalizadas;

        $fchHoy = date("Y-m-d");

        $sql = "
                SELECT 
                        txtNombreContratista as NombreContratista,
                        numDocumento as Documento,
                        fchFinalContrato as FechaFinContrato,
                        fchInicioContrato as FechaInicioContrato ,
                        datediff( fchFinalContrato, '$fchHoy' ) as tiempoRestante 
                FROM T_IND_NOMINA
                ORDER BY tiempoRestante 
        ";

        $objRes = $aptBd->execute($sql);

        while ($objRes->fields) {

            $txtNombreContratista = $objRes->fields["NombreContratista"];
            $numDocumento = $objRes->fields["Documento"];
            $fchFinContrato = $objRes->fields["FechaFinContrato"];
            $fchInicioContrato = $objRes->fields["FechaInicioContrato"];
            $numTiempoRestante = $objRes->fields["tiempoRestante"];

            $arrFecha = explode("-", $fchFinContrato);
            $txtFecha = $arrMeses[intval($arrFecha[1])] . " " . $arrFecha[2] . " de " . $arrFecha[0];

            $arrFechaInicio = explode("-", $fchInicioContrato);
            $txtFechaInicio = $arrMeses[intval($arrFechaInicio[1])] . " " . $arrFechaInicio[2] . " de " . $arrFechaInicio[0];

            if ($numTiempoRestante > 0) {
                $arrTemporal = &$arrDatosIndicadorNomina[];
                $arrTemporal["NombreContratista"] = $txtNombreContratista;
                $arrTemporal["Documento"] = number_format($numDocumento, 0, '.', ',');
                $arrTemporal["FechaFinContrato"] = $txtFecha;
                $arrTemporal["tiempoRestante"] = $numTiempoRestante;
            } else {
                $arrTemporal = &$arrDatosIndicadorNominaFinalizadas[];
                $arrTemporal["NombreContratista"] = $txtNombreContratista;
                $arrTemporal["Documento"] = number_format($numDocumento, 0, '.', ',');
                $arrTemporal["FechaInicioContrato"] = $txtFechaInicio;
                $arrTemporal["FechaFinContrato"] = $txtFecha;
            }
            $objRes->MoveNext();
        }
    }

    /**
     * $arrGraficaResolucionesPorAnnoResolucion => Indicadores de Hogares X Resolucion discriminado X Meses de Pago
     * @global Object aptBd Objeto ADODB
     * @return void 
     * @author Diego Gaitan
     * @version 1.0
     */
    function obtenerSaldosResoluciones() {

        global $aptBd;

        $arrGraficaResolucionesTotalGiros = &$this->arrGraficaResolucionesTotalGiros;
        $arrGraficaResolucionesTotalHogares = &$this->arrGraficaResolucionesTotalHogares;
        $arrGraficaResolucionesTotalHogaresTODO = &$this->arrGraficaResolucionesTotalHogaresTODO;
        $arrGraficaResolucionesTotalGirosTODO = &$this->arrGraficaResolucionesTotalGirosTODO;
        $arrGraficaResolucionesCDPEjecutado = &$this->arrGraficaResolucionesCDPEjecutado;

        $arrPrueba = array();

        foreach ($this->arrActosAdministrativos as $numProyecto => &$arrDatosResolucion) {

            $valTotalEjecutado = 0;
            $valTotalRenuncia = 0;
            $valTotalCDP = 0;
            $valTotalRP = 0;
            $valTotalSaldo = 0;
            $valTotalSaldoEjecuar = 0;

            foreach ($arrDatosResolucion as $numFechaResolucion => &$arrDatos) {

                $arrFechaResolucion = explode(" - ", $numFechaResolucion);
                $numResolucion = $arrFechaResolucion[0];
                $fchResolucion = $arrFechaResolucion[1];
                $annoResulucion = explode("-", $fchResolucion);
                $annoResulucion = $annoResulucion[0];
                $valEjecutado = 0;
                $valRenuncia = 0;
                $valSaldo1 = 0;
                $valSaldo2 = 0;
                $valRP = $arrDatos["Valor RP"];

                $sql = "
						SELECT 
							frm.seqFormulario ,
							frm.seqEstadoProceso ,
							gir.valOrden ,
							gir.valSolicitado ,
							fac.valAspiraSubsidio ,
							gir.fchOrden ,
							gir.fchCreacion 
						FROM T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_ESTADO_PROCESO epr on frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta on epr.seqEtapa = eta.seqEtapa
						INNER JOIN T_AAD_FORMULARIO_ACTO fac on fac.seqFormulario = frm.seqFormulario
						INNER JOIN T_AAD_HOGARES_VINCULADOS hvi on hvi.seqFormularioActo = fac.seqFormularioActo
						LEFT JOIN T_AAD_GIRO gir on gir.seqFormularioActo = hvi.seqFormularioActo
						WHERE 
							hvi.fchActo = '$fchResolucion' AND hvi.numActo = $numResolucion
						-- GROUP BY frm.seqFormulario
						";
                try {

                    $objRes = $aptBd->execute($sql);
                    while ($objRes->fields) {

                        $seqFormulario = $objRes->fields["seqFormulario"];
                        $seqEstadoProceso = $objRes->fields["seqEstadoProceso"];
                        $valOrden = $objRes->fields["valOrden"];
                        $valSolicitado = $objRes->fields["valSolicitado"];
                        $valAspiraSubsidio = $objRes->fields["valAspiraSubsidio"];
                        $fchOrden = $objRes->fields["fchOrden"];
                        $fchCreacion = $objRes->fields["fchCreacion"];
                        $arrOrden = explode("-", $fchOrden);
                        $annoOrden = $arrOrden[0];
                        $mesOrden = $arrOrden[1];
                        if ($annoOrden == "0001") {
                            $arrOrden = explode("-", $fchCreacion);
                            $annoOrden = $arrOrden[0];
                            $mesOrden = $arrOrden[1];
                        }

                        // Cuando la orden del giro se realiza entra
                        if (intVal($mesOrden)) {

                            $arrGraficaResolucionesTotalHogares[$numProyecto][$annoOrden][intval($mesOrden)] ++;
                            $arrGraficaResolucionesTotalGiros[$numProyecto][$annoOrden][intval($mesOrden)] += $valSolicitado;

                            $arrGraficaResolucionesTotalHogaresTODO["TOTAL $annoOrden"][intval($mesOrden)] ++;
                            $arrGraficaResolucionesTotalHogaresTODO["PROYECTO $numProyecto $annoOrden"][intval($mesOrden)] ++;

                            $arrGraficaResolucionesTotalGirosTODO["TOTAL $annoOrden"][intval($mesOrden)] += $valSolicitado;
                            $arrGraficaResolucionesTotalGirosTODO["PROYECTO $numProyecto $annoOrden"][intval($mesOrden)] += $valSolicitado;
                        }

                        switch ($seqEstadoProceso) {

                            case 13: // Hogares que han desistido de la inscripcion
                            case 14: // Hogares que reuncian a la postulacion
                            case 18: // Hogares que renuncian a la asignacion del subsidio
                                $valRenuncia += $valAspiraSubsidio;
                                break;

                            default:
                                $valEjecutado += $valOrden;
                                break;
                        }

                        $objRes->MoveNext();
                    }
                } catch (Exception $objError) {
                    
                }

                $valSaldo1 = $valRP - $valRenuncia;
                $valSaldo2 = $valSaldo1 - $valEjecutado;

                $valTotalEjecutado += $valEjecutado;
                $valTotalRenuncia += $valRenuncia;
                $valTotalCDP += $arrDatos["Valor CDP"];
                $valTotalRP += $arrDatos["Valor RP"];
                $valTotalSaldo += $valSaldo1;
                $valTotalSaldoEjecuar += $valSaldo2;

                $arrDatos["Ejecutado"] = $valEjecutado;
                $arrDatos["Renuncia"] = $valRenuncia;
                $arrDatos["Saldo"] = $valSaldo1;
                $arrDatos["Saldo por Ejecutar"] = $valSaldo2;


                $arrGraficaResolucionesCDPEjecutado[$numProyecto][$numResolucion]["CRP"] = $arrDatos["Valor CDP"];
                $arrGraficaResolucionesCDPEjecutado[$numProyecto][$numResolucion]["Ejecutado"] = $valEjecutado;
            }

            $arrTemporal = &$arrDatosResolucion["TOTAL"];
            $arrTemporal["Valor CDP"] = $valTotalCDP;
            $arrTemporal["Valor RP"] = $valTotalRP;
            $arrTemporal["Ejecutado"] = $valTotalEjecutado;
            $arrTemporal["Renuncia"] = $valTotalRenuncia;
            $arrTemporal["Saldo"] = $valSaldo2;
            $arrTemporal["Saldo por Ejecutar"] = $valTotalSaldoEjecuar;
        }

        foreach ($arrGraficaResolucionesTotalHogares as &$arrDatosValores) {
            foreach ($arrDatosValores as &$arrDatos) {
                completarMesesArreglo($arrDatos);
            }
            ksort($arrDatosValores);
        }
        foreach ($arrGraficaResolucionesTotalGiros as &$arrDatosValores) {
            foreach ($arrDatosValores as &$arrDatos) {
                completarMesesArreglo($arrDatos);
            }
            ksort($arrDatosValores);
        }


        foreach ($arrGraficaResolucionesTotalHogaresTODO as &$arrDatosValores) {
            completarMesesArreglo($arrDatosValores);
            ksort($arrDatosValores);
        }
        foreach ($arrGraficaResolucionesTotalGirosTODO as &$arrDatosValores) {
            completarMesesArreglo($arrDatosValores);
            ksort($arrDatosValores);
        }
        ksort($arrGraficaResolucionesTotalHogaresTODO);
        ksort($arrGraficaResolucionesTotalGirosTODO);
    }

    /**
     * Se genera las vigencias de los RP y CDP de las resoluciones discriminadas por Numero de Proyecto
     * @return void 
     * @global array arrMeses
     * @version 1.0
     * @author Diego Gaitan
     */
    private function obtenerVigenciasResoluciones() {

        global $arrMeses;
        $arrVigenciasResoluciones = &$this->arrVigenciasResoluciones;

        foreach ($this->arrActosAdministrativos as $numProyecto => $arrResoluciones) {

            foreach ($arrResoluciones as $numFechaActo => $arrActo) {

                $arrNumFechaActo = explode(" - ", $numFechaActo);
                $arrFecha = explode("-", $arrNumFechaActo[1]);

                $txtFecha = $arrMeses[intval($arrFecha[1])] . " " . $arrFecha[2] . " de " . $arrFecha[0];
                $numActo = $arrNumFechaActo[0];

                $txtResolucion = "Resolucion $numActo del $txtFecha";
                $fchCDP = $arrActo["Fecha CDP"];
                $fchRP = $arrActo["Fecha RP"];
                $arrFchCDP = explode("-", $fchCDP);
                $arrFchRP = explode("-", $fchRP);
                $fchVigenciaCDP = $arrFchCDP[0] . "-12-31";
                $fchVigenciaRP = $arrFchRP[0] . "-12-31";
                $fchHoy = date("Y-m-d");

                $numDiasVigenciaCDP = diferenciaFechas($fchHoy, $fchVigenciaCDP);
                $numDiasVigenciaRP = diferenciaFechas($fchHoy, $fchVigenciaRP);

                $arrTemporal = &$arrVigenciasResoluciones[$numProyecto][];
                $arrTemporal["Resolucion"] = $txtResolucion;
                $arrTemporal["CDPRP"] = "CDP";
                $arrTemporal["FechaCDPRP"] = $fchCDP;
                $arrTemporal["FechaVigencia"] = $fchVigenciaCDP;
                $arrTemporal["Falta"] = $numDiasVigenciaCDP;


                $arrTemporal = &$arrVigenciasResoluciones[$numProyecto][];
                $arrTemporal["Resolucion"] = $txtResolucion;
                $arrTemporal["CDPRP"] = "RP";
                $arrTemporal["FechaCDPRP"] = $fchRP;
                $arrTemporal["FechaVigencia"] = $fchVigenciaRP;
                $arrTemporal["Falta"] = $numDiasVigenciaRP;
            }
        }
    }

    private function generarJSIndicadoresSolicitudDesembolso() {

        /*         * *
         * JS de Operaciones
         */
        $this->convertirGraficasResolucionesJSChart($this->arrPagosMensual, $this->txtOperacionesJS, "GraficaOperaciones");
        $this->convertirGraficasColumnasJSChart($this->arrPagoPorContrato, $this->txtOperacionePorContratosJS, "GraficaOperacionesPorContrato");
        $this->convertirGraficasColumnasJSChart($this->arrPagoPorContratoTotal, $this->txtOperacionePorContratosTotalJS, "GraficaOperacionesPorContratoTotal");

        /*         * *
         * JS Conceptos
         */
        $this->txtConcepto644JS = $this->arrayToJsDataTable($this->arrDatosConcepto[644], "Concepto644");
        $this->txtConcepto488JS = $this->arrayToJsDataTable($this->arrDatosConcepto[488], "Concepto488");

        /*         * *
         * JS Nomina Vigencia
         */
        $this->txtNominaJS = $this->arrayToJsDataTable($this->arrDatosIndicadorNomina, "Nomina");
        $this->txtNominaFinalizadaJS = $this->arrayToJsDataTable($this->arrDatosIndicadorNominaFinalizadas, "NominaFinalizada");

        /*         * *
         * JS Vigencia Resoluciones CDP/RP
         */
        $this->txtVigenciaResolucion488JS = $this->arrayToJsDataTable($this->arrVigenciasResoluciones[488], "VigenciaResolucion488");
        $this->txtVigenciaResolucion644JS = $this->arrayToJsDataTable($this->arrVigenciasResoluciones[644], "VigenciaResolucion644");

        /*         * *
         * JS Indicadores Resoluciones por proyecto
         */
        $this->convertirActosIndicadoresSolicitudJSDataTable();

        /*         * *
         * JS Saldos de Resoluciones
         */
        $this->convertirGraficasResolucionesJSChart($this->arrGraficaResolucionesTotalGiros["488"], $this->txtResolucionesTotalGiros488JS, "GraficaTotalGiros488");
        $this->convertirGraficasResolucionesJSChart($this->arrGraficaResolucionesTotalGiros["644"], $this->txtResolucionesTotalGiros644JS, "GraficaTotalGiros644");
        $this->convertirGraficasResolucionesJSChart($this->arrGraficaResolucionesTotalHogares["488"], $this->txtResolucionesTotalHogares488JS, "GraficaTotalHogares488");
        $this->convertirGraficasResolucionesJSChart($this->arrGraficaResolucionesTotalHogares["644"], $this->txtResolucionesTotalHogares644JS, "GraficaTotalHogares644");
        $this->convertirGraficasResolucionesJSChart($this->arrGraficaResolucionesTotalGirosTODO, $this->txtResolucionesTotalGirosTODOJS, "GraficaTotalGirosTODO");
        $this->convertirGraficasResolucionesJSChart($this->arrGraficaResolucionesTotalHogaresTODO, $this->txtResolucionesTotalHogaresTODOJS, "GraficaTotalHogaresTODO");
        $this->convertirGraficasResolucionesJSChart($this->arrResumenDesembolsos, $this->txtResumenDesembolsosJS, "GraficaResumen");

        $this->convertirGraficasResolucionesCDPEjecutadoJSChart($this->arrGraficaResolucionesCDPEjecutado["488"], $this->txtResolucionesCDPEjecutado488JS, "GraficaCDPEjecutado488");
        $this->convertirGraficasResolucionesCDPEjecutadoJSChart($this->arrGraficaResolucionesCDPEjecutado["644"], $this->txtResolucionesCDPEjecutado644JS, "GraficaCDPEjecutado644");

        $arrTotal644 = $this->arrActosAdministrativos[644]["TOTAL"];
        $arrTotal488 = $this->arrActosAdministrativos[488]["TOTAL"];

        $this->convertirGraficasColumnasJSChart($arrTotal644, $this->txtResolucionesTotal644, "GraficaTotal644");
        $this->convertirGraficasColumnasJSChart($arrTotal488, $this->txtResolucionesTotal488, "GraficaTotal488");
    }

    function obtenerResumenDesembolsos() {

        global $aptBd;
        global $arrMeses;

        $sql = "
					SELECT
						moa.seqModalidad ,
						frm.bolDesplazado ,
						sol.fchOrden ,
						sol.fchCreacion
					FROM T_FRM_FORMULARIO frm
					INNER JOIN T_FRM_MODALIDAD moa on frm.seqModalidad = moa.seqModalidad
					INNER JOIN T_DES_DESEMBOLSO des on des.seqFormulario = frm.seqFormulario
					INNER JOIN T_DES_SOLICITUD sol on sol.seqDesembolso = des.seqDesembolso
					INNER JOIN T_AAD_GIRO gir on gir.seqSolicitud = sol.seqSolicitud
				";

        $objRes = $aptBd->execute($sql);

        $arrResumenDesembolsos = &$this->arrResumenDesembolsos;

        while ($objRes->fields) {

            $seqModalidad = $objRes->fields["seqModalidad"];
            $bolDesplazado = $objRes->fields["bolDesplazado"];
            $fchOrden = $objRes->fields["fchOrden"];
            $fchCreacion = $objRes->fields["fchCreacion"];

            $arrOrden = explode("-", $fchOrden);
            $annoOrden = $arrOrden[0];
            $mesOrden = $arrOrden[1];
            if ($annoOrden == "0001" or $annoOrden == "0000") {
                $arrOrden = explode("-", $fchCreacion);
                $annoOrden = $arrOrden[0];
                $mesOrden = $arrOrden[1];
            }

            if ($bolDesplazado == 1) {
                $arrResumenDesembolsos["Desplazados Año $annoOrden"][intval($mesOrden)] ++;
            }

            if ($bolDesplazado == 0) {
                $arrResumenDesembolsos["Independientes Año $annoOrden"][intval($mesOrden)] ++;
            }

            if ($seqModalidad == 1) {
                $arrResumenDesembolsos["Adquisicion Año $annoOrden"][intval($mesOrden)] ++;
            }

            if ($seqModalidad == 3 or $seqModalidad == 4) {
                $arrResumenDesembolsos["Mejoramiento Año $annoOrden"][intval($mesOrden)] ++;
            }

            if ($seqModalidad == 5) {
                $arrResumenDesembolsos["Arrendamiento Año $annoOrden"][intval($mesOrden)] ++;
            }
            $objRes->MoveNext();
        }


        foreach ($arrResumenDesembolsos as &$arrFinalDatos) {
            completarMesesArreglo($arrFinalDatos);
        }
    }

    function obtenerIndicadorControlPresupuestal() {

        global $claActosAdministrativos;

        $this->arrActosAdministrativos = $claActosAdministrativos->listarActosIndicadoresSolicitud();

        $this->obtenerIndicadorOperaciones();
        $this->obtenerIndicadorConceptos();
        $this->obtenerIndicadorVigenciaNomina();

        $this->obtenerVigenciasResoluciones();
        $this->obtenerSaldosResoluciones();

        $this->obtenerResumenDesembolsos();

        $this->generarJSIndicadoresSolicitudDesembolso();

        $arrIndicadorControlPresupuestal = &$this->arrIndicadorControlPresupuestal;
        $arrTemporal = &$arrIndicadorControlPresupuestal["488"];
        $arrTemporal["Resoluciones"] = ""; // $arrActosAdministrativos[ 488 ];
        $arrTemporal["Operaciones"] = ""; // $this->arrDatosOperaciones;
        $arrTemporal["Conceptos"] = ""; // $this->arrConcepto[ 488 ];
        $arrTemporal = &$arrIndicadorControlPresupuestal["644"];
        $arrTemporal["Resoluciones"] = ""; //$arrActosAdministrativos[ 644 ];
        $arrTemporal["Conceptos"] = ""; //$this->arrConcepto[ 644 ];


        $arrIndicadorVigencias = &$this->arrIndicadorVigencias;
        $arrTemporal = &$arrIndicadorVigencias["488"];
        $arrTemporal["Resoluciones"] = ""; // $arrActosAdministrativos[ 488 ];
        $arrTemporal["Operaciones"] = ""; //$this->arrDatosIndicadorNomina;
        $arrTemporal = &$arrIndicadorVigencias["644"];
        $arrTemporal["Resoluciones"] = ""; //$arrActosAdministrativos[ 644 ];
    }

    private function convertirGraficasColumnasJSChart($arrDatosGrafica, &$txtJs, $txtNombreGrafica) {

        $arrDatosGraficaFinal = array();

        $arrTitulos = array_keys($arrDatosGrafica);

        $txtJs = "var objGrafica$txtNombreGrafica = { ";
        $txtJs .= " nombre: '$txtNombreGrafica' , ";
        $txtJs .= " datos: [ ";
        foreach ($arrDatosGrafica as $keyDato => $valDato) {
            $txtJs .= " {ejex: '$keyDato', valor: '$valDato' } ,  ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= "  ] , ";
        $txtJs .= " ejes: [ 'ejex' , 'valor' ] , ";
        $txtJs .= " series: [ ";
        $txtJs .= "{ displayName: 'Valor' , yField : 'valor' } ";
        $txtJs .= " ] ";
        $txtJs .= " }; ";
    }

    private function convertirGraficasResolucionesCDPEjecutadoJSChart($arrDatosGrafica, &$txtJs, $txtNombreGrafica) {


        $txtJs = "var objGrafica$txtNombreGrafica = { ";
        $txtJs .= " nombre: '$txtNombreGrafica' , ";
        $txtJs .= " datos: [ ";

        foreach ($arrDatosGrafica as $numResolucion => $arrDatosResolucion) {
            $txtJs .= "{ resolucion: '$numResolucion' , ";
            foreach ($arrDatosResolucion as $txtKey => $txtValor) {
                $txtJs .= "$txtKey: '$txtValor' , ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= " } , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] , ";
        $txtJs .= " nombreEjeX : 'Resolución',";
        $txtJs .= " ejes: [ ";
        $txtJs .= " 'resolucion' , ";
        foreach ($arrDatosResolucion as $txtKey => $txtValor) {
            $txtJs .= " '$txtKey' , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] , ";
        $txtJs .= " series: [ ";
        foreach ($arrDatosResolucion as $txtKey => $txtValor) {
            $txtJs .= "{ displayName: 'Resolución $txtKey' , yField : '$txtKey' } , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ]  ";
        $txtJs .= " }; ";
    }

    private function convertirGraficasResolucionesJSChart($arrDatosGrafica, &$txtJs, $txtNombreGrafica) {

        global $arrMeses;
        $arrDatosGraficaFinal = array();

        $arrAnnos = array_keys($arrDatosGrafica);
        ksort($arrAnnos);

        foreach ($arrMeses as $seqMes => $txtMes) {
            foreach ($arrAnnos as $numAnno) {
                $arrDatosGraficaFinal[$txtMes][$numAnno] = $arrDatosGrafica[$numAnno][$seqMes];
            }
            if (!empty($arrDatosGraficaFinal[$txtMes])) {
                ksort($arrDatosGraficaFinal[$txtMes]);
            }
        }

        $txtJs = "var objGrafica$txtNombreGrafica = { ";
        $txtJs .= " nombre: '$txtNombreGrafica' , ";
        $txtJs .= " datos: [ ";
        foreach ($arrDatosGraficaFinal as $txtMes => $arrDatoMes) {
            $txtJs .= "{ mes: '$txtMes' , ";
            foreach ($arrDatoMes as $txtAnno => $valAnno) {
                $txtAnno = str_replace(" ", "", $txtAnno);
                $txtJs .= "$txtAnno: '$valAnno' , ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= " } , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] , ";
        $txtJs .= " ejes: [ ";
        $txtJs .= " 'mes' , ";
        if (!empty($arrDatoMes)) {
            foreach ($arrDatoMes as $txtAnno => $valAnno) {
                $txtAnno = str_replace(" ", "", $txtAnno);
                $txtJs .= " '$txtAnno' , ";
            }
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] , ";
        $txtJs .= " series: [ ";
        if (!empty($arrDatoMes)) {
            foreach ($arrDatoMes as $txtAnno => $valAnno) {
                $txtAnnoFieldY = str_replace(" ", "", $txtAnno);
                $txtJs .= "{ displayName: '$txtAnno' , yField : '$txtAnnoFieldY' } , ";
            }
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] ";
        $txtJs .= " }; ";
    }

    function tiempoPromedio($seqUsuario, $faseIndicador) {

        global $aptBd;
        $numDiasPromedio = 0;

        switch ($faseIndicador) {

            case 'revisionOferta': // REVISION DE OFERTA - REVISION JURIDICA

                $txtDiferenciaTiempos = "jur.fchCreacion , des.fchCreacionBusquedaOferta";
                $txtInnerJoin = "
									INNER JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso 
									";
                $txtFechasNull = " des.fchCreacionBusquedaOferta != 'null' AND jur.fchCreacion != 'null'";
                break;
            case 'revisionJuridica':
                $txtDiferenciaTiempos = "tec.fchCreacion , jur.fchCreacion";

                $txtInnerJoin = "
									INNER JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso
									INNER JOIN T_DES_TECNICO tec ON des.seqDesembolso = tec.seqDesembolso 
									";
                $txtFechasNull = " tec.fchCreacion != 'null' AND jur.fchCreacion != 'null'";
                break;
            case 'revisionTecnica':

                $txtDiferenciaTiempos = "des.fchCreacionEscrituracion , tec.fchCreacion";
                $txtInnerJoin = "
									INNER JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso
									INNER JOIN T_DES_TECNICO tec ON des.seqDesembolso = tec.seqDesembolso 
									";
                $txtFechasNull = " des.fchCreacionEscrituracion != 'null' AND tec.fchCreacion != 'null'";
                break;
            case 'escrituracion':

                $txtDiferenciaTiempos = "est.fchCreacion , des.fchCreacionEscrituracion";
                $txtInnerJoin = "
									INNER JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso
									INNER JOIN T_DES_TECNICO tec ON des.seqDesembolso = tec.seqDesembolso 
									INNER JOIN T_DES_ESTUDIO_TITULOS est ON est.seqDesembolso = des.seqDesembolso
									";
                $txtFechasNull = "est.fchCreacion != 'null' and des.fchCreacionEscrituracion != 'null'";
                break;
            case 'estudioTitulos':

                $txtDiferenciaTiempos = "sol.fchCreacion , est.fchCreacion ";
                $txtInnerJoin = "
									INNER JOIN T_DES_JURIDICO jur ON des.seqDesembolso = jur.seqDesembolso
									INNER JOIN T_DES_TECNICO tec ON des.seqDesembolso = tec.seqDesembolso 
									INNER JOIN T_DES_ESTUDIO_TITULOS est ON est.seqDesembolso = des.seqDesembolso
									INNER JOIN T_DES_SOLICITUD sol on sol.seqDesembolso = des.seqDesembolso
									";
                $txtFechasNull = "est.fchCreacion != 'null' and sol.fchCreacion != 'null'";
                break;
        }

        $txtWhereUsuario = "";
        if ($seqUsuario) {
            $txtWhereUsuario = "WHERE fus.seqUsuario = $seqUsuario";
        }

        switch ($faseIndicador) {

            case "asignado":
                $sql = "SELECT '' as DiasPromedioDesembolso";
                break;
            default:
                $sql = "
						SELECT 
						abs( round( avg( datediff( $txtDiferenciaTiempos ) ) ) ) as DiasPromedioDesembolso
						FROM T_DES_DESEMBOLSO des
						$txtInnerJoin
						WHERE 
						  des.seqFormulario IN (
						    SELECT 
						      fus.seqFormulario
						    FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						       $txtWhereUsuario 
						    ) AND $txtFechasNull
						";
                break;
        }

        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $numDiasPromedio = $objRes->fields['DiasPromedioDesembolso'];
        } else {
            $numDiasPromedio = 0;
        }

        $this->numDiasPromedio = $numDiasPromedio;
    }

    /**
     * Se generan los indicadores de los Conceptos discriminados por Numero de Proyecto
     * @author Diego Gaitan
     * @global Object aptBd Objeto ADODB
     * @global Array arrMeses
     * @return Void
     * @version 1.0
     */
    function obtenerIndicadorConceptos() {

        global $aptBd;
        global $arrMeses;

        $arrDatosConcepto = &$this->arrDatosConcepto;

        $sql = "
					SELECT
						txtConcepto as NombreConcepto,
						numProyecto as Proyecto ,
						valConcepto as Valor ,
						fchConcepto as FechaConcepto
					FROM T_IND_CONCEPTO
					ORDER BY numProyecto , fchConcepto
				";

        $objRes = $aptBd->execute($sql);

        while ($objRes->fields) {
            $txtConcepto = $objRes->fields["NombreConcepto"];
            $numProyecto = $objRes->fields["Proyecto"];
            $valConcepto = $objRes->fields["Valor"];
            $fchConcepto = $objRes->fields["FechaConcepto"];

            $arrFecha = explode("-", $fchConcepto);
            $txtFecha = $arrMeses[intval($arrFecha[1])] . " " . $arrFecha[2] . " de " . $arrFecha[0];

            $arrTemporal = &$arrDatosConcepto[$numProyecto][];
            $arrTemporal["NombreConcepto"] = $txtConcepto;
            $arrTemporal["Valor"] = number_format($valConcepto, 0, '.', ',');
            $arrTemporal["FechaConcepto"] = $txtFecha;

            $objRes->MoveNext();
        }
    }

    /**
     * Se generan los indicadores de la Nomima discriminada por Meses de pagos, Pagos por año del contrato y total
     * @author Diego Gaitan
     * @global Object aptBd Objeto ADODB
     * @global Array arrMeses
     * @return Void
     * @version 1.0
     */
    function obtenerIndicadorOperaciones() {

        global $aptBd;
        global $arrMeses;

        $sql = "
					SELECT 
						pno.valPagado , 
						nom.fchInicioContrato , 
						pno.fchPago
					FROM T_IND_NOMINA nom 
					INNER JOIN T_IND_PAGO_NOMINA pno ON pno.seqNomina = nom.seqNomina
				";

        $objRes = $aptBd->execute($sql);

        $arrPagosMensual = &$this->arrPagosMensual;
        $arrPagoPorContrato = &$this->arrPagoPorContrato;
        $arrPagoPorContratoTotal = &$this->arrPagoPorContratoTotal;
        while ($objRes->fields) {

            $valPagado = $objRes->fields["valPagado"];
            $fchPago = $objRes->fields["fchPago"];
            $fchInicioContrato = $objRes->fields["fchInicioContrato"];

            $arrFechaPago = explode("-", $fchPago);
            $arrFechaInicio = explode("-", $fchInicioContrato);

            $arrPagosMensual[$arrFechaPago[0]][intval($arrFechaPago[1])] += $valPagado;
            $arrPagoPorContrato[$arrFechaInicio[0]] += $valPagado;
            $arrPagoPorContratoTotal["TOTAL"] += $valPagado;


            $objRes->MoveNext();
        }
        ksort($arrPagoPorContrato);

        foreach ($arrPagosMensual as &$arrPagos) {
            completarMesesArreglo($arrPagos);
        }
    }

    function ejecutarNomina() {

        global $aptBd;

        $sql = "
					SELECT 
						seqNomina , 
						fchInicioContrato , 
						fchFinalContrato ,
						valMesContrato
					FROM T_IND_NOMINA 
				";

        $objRes = $aptBd->execute($sql);

        while ($objRes->fields) {

            $seqNomina = $objRes->fields["seqNomina"];
            $fchInicioContrato = $objRes->fields["fchInicioContrato"];
            $fchFinalContrato = $objRes->fields["fchFinalContrato"];
            $valMesContrato = $objRes->fields["valMesContrato"];
            $fchMesActual = date("Y-m-01");

            $arrFechaInicio = explode("-", $fchInicioContrato);
            $arrFechaFinal = explode("-", $fchFinalContrato);
            $arrFechaMesActual = explode("-", $fchMesActual);

            for ($i = ( ( $arrFechaInicio[0] * 12 ) + $arrFechaInicio[1] ), $j = 0; $i <= ( ( $arrFechaMesActual[0] * 12 ) + $arrFechaMesActual[1] ); $i++, $j++) {

                $fchMesEjecutar = ( date("Y-m-01", mktime(0, 0, 0, $arrFechaInicio[1] + $j, 1, $arrFechaInicio[0])) );
                $arrMesEjecutar = explode("-", $fchMesEjecutar);

                $sql = "
						SELECT 
							count( 1 ) as cuenta 
						FROM T_IND_PAGO_NOMINA
						WHERE seqNomina = $seqNomina
							AND fchPago = '$fchMesEjecutar'
					";

                $objRes1 = $aptBd->execute($sql);

                // NO SE HA PAGADO ESE MES
                if ($objRes1->fields["cuenta"] == 0) {

                    switch ($i) {

                        // PRIMER MES CONTRATO
                        case ( ( $arrFechaInicio[0] * 12 ) + $arrFechaInicio[1] );

                            // DIAS PAGO
                            switch ($arrFechaFinal[2]) {
                                // Finales de mes
                                case 31:
                                case 30:
                                    $numDiasPago = 1;
                                    break;
                                case ( $arrFechaFinal[1] == 2 ):
                                    $numDiasPago = 28 + esBisiesto($arrFechaFinal[0]) - $arrFechaFinal[2] + 1;
                                    break;
                                default:
                                    $numDiasPago = 30 - $arrFechaFinal[2] + 1;
                                    break;
                            }

                            break;

                        // ULTIMO MES CONTRATO
                        case ( ( $arrFechaFinal[0] * 12 ) + $arrFechaFinal[1] ):

                            // DIAS PAGO
                            switch ($arrFechaFinal[2]) {
                                // Finales de mes con mas de 30 dias
                                case 31:
                                case ( $arrFechaFinal[1] == 2 and $arrFechaFinal[2] == 28 ):
                                case ( $arrFechaFinal[1] == 2 and $arrFechaFinal[2] == 29 ):
                                    $numDiasPago = 30;
                                    break;
                                default:
                                    $numDiasPago = $arrFechaFinal[2];
                                    break;
                            }
                            break;

                        // RESTO DE MESES
                        default:
                            $numDiasPago = 30;
                            break;
                    }

                    $valPagar = ( $valMesContrato / 30 ) * $numDiasPago;
                    $sql = "
							INSERT INTO T_IND_PAGO_NOMINA
								( seqNomina , valPagado, fchPago ) 
							VALUES ( $seqNomina , $valPagar , '$fchMesEjecutar' )
						";
                    try {
                        $objRes2 = $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo ejecutar la nomina para el contratista '$txtNombreContratista' con número de documento $numDocumento con fecha de finalizacion '$fchFinalContrato' para la fecha '$fchMesEjecutar'";
                    }
                }

                // TERMINAR EL PAGO DE NOMINA CUANDO SE ACABA EL CONTRATO
                if (( ( $arrMesEjecutar[0] * 12 ) + $arrMesEjecutar[1] ) == ( ( $arrFechaFinal[0] * 12 ) + $arrFechaFinal[1] )) {
                    break;
                }
            }




            $objRes->MoveNext();
        }
    }

    function obtenerConcepto() {

        global $aptBd;
        $arrConcepto = &$this->arrConcepto;

        $sql = "
					SELECT * FROM T_IND_CONCEPTO
				";

        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrTemporal = &$arrConcepto[];
            foreach ($objRes->fields as $txtClave => $txtValor) {
                $arrTemporal[$txtClave] = $txtValor;
            }
            $objRes->MoveNext();
        }
    }

    function obtenerNomina() {

        global $aptBd;
        global $arrMeses;
        $arrNomina = &$this->arrNomina;
        $arrMesesEjecutados = &$this->arrMesesEjecutados;
        $arrMesesEjecutadosTXT = &$this->arrMesesEjecutadosTXT;
        $bolCuentaRegistros = false;

        // OBTENGO TODOS LOS PAGOS DE TODOS LOS CONTRATISTAS
        $sql = "
					SELECT 
						nom.seqNomina,
						nom.txtNombreContratista,
						nom.numDocumento,
						date_format( nom.fchInicioContrato , '%Y-%m-%d') AS fchInicioContrato,
						date_format( nom.fchFinalContrato , '%Y-%m-%d') AS fchFinalContrato,
						nom.valTotalContrato,
						nom.valMesContrato,
						date_format( pno.fchPago , '%Y-%m') AS fchPago,
						pno.valPagado
					FROM T_IND_NOMINA nom
					LEFT JOIN T_IND_PAGO_NOMINA pno ON pno.seqNomina = nom.seqNomina
					ORDER BY nom.fchFinalContrato, pno.fchPago
				";

        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $bolCuentaRegistros = true;
            $seqNomina = $objRes->fields["seqNomina"];
            $txtNombreContratista = $objRes->fields["txtNombreContratista"];
            $numDocumento = $objRes->fields["numDocumento"];
            $fchInicioContrato = $objRes->fields["fchInicioContrato"];
            $fchFinalContrato = $objRes->fields["fchFinalContrato"];
            $valTotalContrato = $objRes->fields["valTotalContrato"];
            $valMesContrato = $objRes->fields["valMesContrato"];
            $fchPago = $objRes->fields["fchPago"];
            $valPagado = $objRes->fields["valPagado"];

            $arrTemporal = $arrNomina[$seqNomina];
            $arrTemporal["seqNomina"] = $seqNomina;
            $arrTemporal["txtNombreContratista"] = $txtNombreContratista;
            $arrTemporal["numDocumento"] = number_format($numDocumento, 0, '.', ',');
            $arrTemporal["fchInicioContrato"] = $fchInicioContrato;
            $arrTemporal["fchFinalContrato"] = $fchFinalContrato;
            $arrTemporal["valTotalContrato"] = "\$ " . number_format($valTotalContrato, 0, '.', ',');
            $arrTemporal["valMesContrato"] = "\$ " . number_format($valMesContrato, 0, '.', ',');
            if ($valPagado) {
                $arrTemporal["valPagado"][$fchPago] = "\$ " . number_format($valPagado, 0, '.', ',');
            } else {
                $arrTemporal["valPagado"] = array();
            }

            $arrNomina[$seqNomina] = $arrTemporal;

            $objRes->MoveNext();
        }

        if ($bolCuentaRegistros) {

            // OBTENGO LA FECHA MENOR Y MAYOR DE LOS PAGOS REALIZADOS
            $sql = "
					SELECT 
						date_format( min( fchPago ), '%Y-%m' ) as fchPagoMinima, 
						date_format( max( fchPago ), '%Y-%m' ) as fchPagoMaxima
					FROM T_IND_PAGO_NOMINA
				";
            $objRes = $aptBd->execute($sql);
            $arrMesesEjecutadosTXT = array();
            $arrMesesEjecutados = array();

            if ($objRes->fields["fchPagoMinima"] != "" and $objRes->fields["fchPagoMaxima"] != "") {
                $arrfchMinima = explode("-", $objRes->fields["fchPagoMinima"]);
                $arrfchMaxima = explode("-", $objRes->fields["fchPagoMaxima"]);
                // GENERO UN ARREGLO CON LAS FECHAS CON INTERVALOS DE UN MES DESDE LAS FECHAS QUE SE SACARON EN EL QUERY ANTERIOR
                for ($i = ( ( $arrfchMinima[0] * 12 ) + $arrfchMinima[1] ), $j = 0; $i <= ( ( $arrfchMaxima[0] * 12 ) + $arrfchMaxima[1] ); $i++, $j++) {
                    $fecha = ( date("Y-m", mktime(0, 0, 0, $arrfchMinima[1] + $j, 1, $arrfchMinima[0])) );

                    $arrFecha = explode("-", $fecha);
                    $txtFecha = $arrMeses[intval($arrFecha[1])] . " del " . $arrFecha[0];
                    $arrMesesEjecutadosTXT[$txtFecha] = $fecha;
                    $arrMesesEjecutados[] = $j + 1;
                }
            }

            foreach ($arrNomina as $seqNomina => &$arrDatoNomina) {
                $arrTemporal = &$arrDatoNomina;
                foreach ($arrMesesEjecutadosTXT as $fchMes) {
                    if (!$arrTemporal["valPagado"][$fchMes]) {
                        $arrTemporal["valPagado"][$fchMes] = "---";
                    }
                }
                ksort($arrTemporal["valPagado"]);
            }
        }
    }

    function salvarNomina($arrDatosNomina) {

        global $aptBd;
        $arrErrores = array();

        foreach ($arrDatosNomina as $arrNomina) {

            $sql = "
					INSERT INTO T_IND_NOMINA
					( txtNombreContratista , numDocumento , fchInicioContrato , fchFinalContrato , valTotalContrato , valMesContrato ) 
					VALUES ( '" . $arrNomina["txtNombreContratista"] . "' ,
							" . $arrNomina["numDocumento"] . " ,
							'" . $arrNomina["fchInicioContrato"] . "' ,   
							'" . $arrNomina["fchFinalContrato"] . "' , 
							" . $arrNomina["valTotalContrato"] . " , 
							" . $arrNomina["valMesContrato"] . "  );	
					";
            try {
                $objRes = $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se pudo ingresar el contratista '" . $arrNomina["txtNombreContratista"] . "' con el documento " . $arrNomina["numDocumento"];
            }
        }

        return $arrErrores;
    }

    function borrarConcepto() {

        global $aptBd;
        $arrErrores = array();

        $sql = "
					DELETE FROM T_IND_CONCEPTO
					WHERE seqConcepto = " . $_POST["seqConcepto"];
        ;
        try {
            $objRes = $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se pudo borrar el concepto";
        }
        return $arrErrores;
    }

    function salvarConcepto($arrDatosConcepto) {

        global $aptBd;
        $arrErrores = array();

        foreach ($arrDatosConcepto as $arrConcepto) {
            $sql = "
					INSERT INTO T_IND_CONCEPTO
					(txtConcepto, numProyecto, valConcepto, fchConcepto) 
					VALUES ('" . $arrConcepto["txtConcepto"] . "', 
							" . $arrConcepto["numProyecto"] . ", 
							" . $arrConcepto["valConcepto"] . ", 
							'" . $arrConcepto["fchConcepto"] . "' );
					";
            try {
                $objRes = $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se pudo ingresar el concepto '" . $arrConcepto["txtConcepto"];
            }
        }

        return $arrErrores;
    }

    function obtenerIdUsuarioIndicador() {

        $seqUsuario = &$this->seqUsuario;
        if (isset($_POST["seqUsuario"])) {
            $seqUsuario = $_POST["seqUsuario"];
        } else {
            if (empty($this->arrCoordinadores)) {
                $this->obtenerCoordinadores();
            }
            $arrCoordinadores = array_keys($this->arrCoordinadores);
            if (in_array($_SESSION["seqUsuario"], $arrCoordinadores)) {
                $seqUsuario = 0;
            } else {
                $seqUsuario = $_SESSION["seqUsuario"];
            }
        }
    }

    function obtenerSecuencialesNombreTutor($arrSecuenciales) {
        global $aptBd;

        $arrTutores = $this->arrNombreTutorNoCuenta;
        $arrSeqVSUsuario = &$this->arrSeqVSUsuario;

        $sql = "
					SELECT 
				      seqFormulario,
						seqUsuario
				    FROM 
				      T_IND_FORMULARIO_USUARIOS_ASIGNADOS 
				";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {

            if (in_array($objRes->fields['seqFormulario'], $arrSecuenciales)) {
                $arrSeqVSUsuario[$objRes->fields['seqFormulario']] = $arrTutores[$objRes->fields['seqUsuario']];
            }
            $objRes->MoveNext();
        }
    }

    function reporteIndicadoresDiaSemanaMes($txtTipoReporte, $txtEstado) {

        global $aptBd;
        $seqUsuario = $this->seqUsuario;
        $this->obtenerTutores();


        $txtWhereUsuario = "";
        if ($seqUsuario) {
            $txtWhereUsuario = "WHERE fus.seqUsuario = $seqUsuario";
        }

        $arrQueries = $this->obtenerQueriesRangosFecha($txtEstado);

        $txtInnerJoin = ( is_array($arrQueries["innerJoin"]) ) ? implode(" ", $arrQueries["innerJoin"]) : $arrQueries["innerJoin"];
        trim($arrQueries["innerJoin"]);
        $txtRangos = ( is_array($arrQueries["rangos"]) ) ? implode(" OR ", $arrQueries["rangos"]) : $arrQueries["rangos"];
        trim($arrQueries["rangos"]);

        $fchHoy = date("Y-m-d");
        switch ($txtTipoReporte) {

            case "hoy":
                $fchRango = date("Y-m-d");
                break;

            case "semana":
                $fchRango = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 7, date("Y")));
                break;

            case "mes":
                $fchRango = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
                break;

            default:
                $fchRango = date("Y-m-d");
                break;
        }

        $txtRangos = str_replace("%fechaRango%", $fchRango, $txtRangos);
        $txtRangos = str_replace("%fechaHoy%", $fchHoy, $txtRangos);

        $sql = "
					SELECT distinct des.seqFormulario
					FROM T_DES_DESEMBOLSO des
						$txtInnerJoin
					WHERE
					( 
						$txtRangos
					)
					AND des.seqFormulario IN
					( 
						SELECT
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						$txtWhereUsuario
					)
				";

        $objRes = $aptBd->execute($sql);
        $arrSecuenciales = array();
        while ($objRes->fields) {
            $arrSecuenciales[] = $objRes->fields['seqFormulario'];
            $objRes->MoveNext();
        }

        if (!$seqUsuario) {
            $this->obtenerSecuencialesNombreTutor($arrSecuenciales);
        }

        $txtSecuenciales = ( empty($arrSecuenciales) ) ? "NULL" : implode(" , ", $arrSecuenciales);

        $this->consultaIndicador($seqUsuario, $txtSecuenciales);
    }

    function reporteIndicadores($seqUsuario, $faseIndicador, $txtColor = "", $arrQueries = array(), $txtConsultaReporte = "") {

        global $aptBd;
        global $arrFasesDesembolsoIndicadores;

        $this->obtenerTutores();

        $txtInnerJoin = "";
        $txtRangos = "1";
        $txtWhereUsuario = "";

        // Reporte con Rangos de Fecha
        if (!empty($arrQueries)) {

            $txtInnerJoin = ( is_array($arrQueries["innerJoin"]) ) ? implode(" ", $arrQueries["innerJoin"]) : $arrQueries["innerJoin"];
            trim($arrQueries["innerJoin"]);
            $txtRangos = $arrQueries["rangos"];

            if ($seqUsuario) {
                $txtWhereUsuario = "WHERE fus.seqUsuario = $seqUsuario";
            }

            $sql = "
					SELECT distinct des.seqFormulario
					FROM T_DES_DESEMBOLSO des
					$txtInnerJoin
					WHERE
					( 
					$txtRangos
					)
					AND des.seqFormulario IN
					( 
						SELECT
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						 $txtWhereUsuario
					)
				";
            $objRes = $aptBd->execute($sql);
            $arrSecuenciales = array();
            while ($objRes->fields) {
                $arrSecuenciales[] = $objRes->fields['seqFormulario'];
                $objRes->MoveNext();
            }
        } else {

            if ($seqUsuario) {
                $txtWhereUsuario = "WHERE fus.seqUsuario = $seqUsuario";
            }

            switch ($faseIndicador) {

                case "asignado":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Asignados']['estados']) . " ) ";
                    break;

                case "revisionOferta":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Busqueda de la Oferta']['estados']) . " ) ";
                    break;

                case "revisionJuridica":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Revisión Jurídica']['estados']) . " ) ";
                    break;

                case "revisionTecnica":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Revisión Técnica']['estados']) . " ) ";
                    break;

                case "escrituracion":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Escrituración']['estados']) . " ) ";
                    break;

                case "radicadotitulos":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Radicado Titulos']['estados']) . " ) ";
                    break;

                case "estudioTitulos":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Estudio de Titulos']['estados']) . " ) ";
                    break;

                case "solicitudDesembolso":
                    $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Solicitud de Desembolso']['estados']) . " ) ";
                    break;
            }

            $arrInnerJoin["revisionOferta"] = "";
            $arrInnerJoin["revisionJuridica"] = "LEFT JOIN T_DES_JURIDICO jur ON jur.seqDesembolso = des.seqDesembolso";
            $arrInnerJoin["revisionTecnica"] = $arrInnerJoin["revisionJuridica"] . " LEFT JOIN T_DES_TECNICO tec ON tec.seqDesembolso = des.seqDesembolso";
            $arrInnerJoin["escrituracion"] = "";
            $arrInnerJoin["estudioTitulos"] = $arrInnerJoin["revisionTecnica"] . " LEFT JOIN T_DES_ESTUDIO_TITULOS est ON est.seqDesembolso = des.seqDesembolso";
            $arrInnerJoin["solicitudDesembolso"] = $arrInnerJoin["estudioTitulos"] . " LEFT JOIN T_DES_SOLICITUD sol ON sol.seqDesembolso = des.seqDesembolso";
            $txtInnerJoin = $arrInnerJoin[$faseIndicador];

            $arrTiempoTranscurrido["asignado"] = "des.fchCreacionBusquedaOferta";
            $arrTiempoTranscurrido["revisionOferta"] = "des.fchActualizacionBusquedaOferta";
            $arrTiempoTranscurrido["revisionJuridica"] = "jur.fchActualizacion";
            $arrTiempoTranscurrido["revisionTecnica"] = "tec.fchActualizacion";
            $arrTiempoTranscurrido["escrituracion"] = "des.fchActualizacionEscrituracion";
            $arrTiempoTranscurrido["estudioTitulos"] = "est.fchActualizacion";
            $arrTiempoTranscurrido["solicitudDesembolso"] = "sol.fchActualizacion";

            $txtTiempoTranscurrido = $arrTiempoTranscurrido[$faseIndicador];

            $arrTiempoTranscurridoAnterior["revisionJuridica"] = "des.fchActualizacionBusquedaOferta";
            $arrTiempoTranscurridoAnterior["revisionTecnica"] = "jur.fchActualizacion";
            $arrTiempoTranscurridoAnterior["estudioTitulos"] = "des.fchActualizacionEscrituracion";
            $arrTiempoTranscurridoAnterior["solicitudDesembolso"] = "est.fchActualizacion";

            $txtTiempoTranscurridoAnterior = $arrTiempoTranscurridoAnterior[$faseIndicador];

            $sql = "
						SELECT 
							frm.seqFormulario
						FROM 
						T_FRM_FORMULARIO frm
						WHERE 
						  frm.seqFormulario IN (
						    SELECT 
						      fus.seqFormulario
						    FROM 
						      T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						    $txtWhereUsuario
						    )
							AND frm.seqEstadoProceso in $txtSeqEstadoProceso
					";

            $objRes = $aptBd->execute($sql);
            $arrSecuenciales = array();
            while ($objRes->fields) {
                $arrSecuenciales[] = $objRes->fields['seqFormulario'];
                $objRes->MoveNext();
            }
        }

        if (!$seqUsuario) {
            $this->obtenerSecuencialesNombreTutor($arrSecuenciales);
        }

        $txtSecuenciales = ( empty($arrSecuenciales) ) ? "NULL" : implode(" , ", $arrSecuenciales);

        $filtros = "";

        $this->tiemposVerdeAmarilloRojo($faseIndicador);
        $tiempoVerde = $this->tiempoVerde;
        $tiempoAmarillo = $this->tiempoAmarillo;

        $fchHoySeguimiento = date("Y-m-d G:i:s");

        switch ($faseIndicador) {

            case "asignado":
            case "escrituracion":
                $sql = "
						SELECT
							seg.seqFormulario ,
							TIMESTAMPDIFF( day , max( seg.fchMovimiento ) , '$fchHoySeguimiento'  ) AS tiempoTranscurrido
						FROM T_SEG_SEGUIMIENTO seg 
						WHERE seg.seqFormulario in ( $txtSecuenciales )
						GROUP BY seg.seqFormulario
					";
                break;

            case "radicadotitulos":

                // Se verifica con los seguimientos que tengan la Gestion "Radicacion de Titulos" del Grupo de Gestion "Recibo de Documento"
                $sql = "
						SELECT
							seg.seqFormulario ,
							TIMESTAMPDIFF( day ,
									max( (
										SELECT seg.fchMovimiento
										FROM T_DES_DESEMBOLSO des
										WHERE seg.fchMovimiento >= des.fchActualizacionEscrituracion 
										AND seg.seqGestion = 35
										AND des.seqFormulario = seg.seqFormulario
										AND des.fchActualizacionEscrituracion > '2000-01-01 00:00:00'
									 ) ) ,
									'$fchHoySeguimiento' 
							) AS tiempoTranscurrido
						FROM T_SEG_SEGUIMIENTO seg 
						WHERE seg.seqFormulario in ( $txtSecuenciales )
						and seg.seqSeguimiento in (
							SELECT seg.seqSeguimiento
							FROM T_DES_DESEMBOLSO des
							WHERE seg.fchMovimiento >= des.fchActualizacionEscrituracion 
							AND seg.seqGestion = 35
							AND des.seqFormulario = seg.seqFormulario
							AND des.fchActualizacionEscrituracion > '2000-01-01 00:00:00'
						)
						GROUP BY seg.seqFormulario
					";

                break;

            case "revisionOferta":
                $sql = "
							SELECT 
								frm.seqFormulario,
								TIMESTAMPDIFF( day , max( $txtTiempoTranscurrido ) , '$fchHoySeguimiento' ) AS tiempoTranscurrido
							FROM T_FRM_FORMULARIO frm
								LEFT JOIN T_DES_DESEMBOLSO des on des.seqFormulario = frm.seqFormulario
							WHERE 
								frm.seqFormulario IN ( $txtSecuenciales )
							GROUP BY 1
						";
                break;

            default:
                $sql = "
					SELECT 
							des.seqFormulario,
							IF( TIMESTAMPDIFF( day , max( $txtTiempoTranscurrido ) , '$fchHoySeguimiento' ) >= 0 , 
								TIMESTAMPDIFF( day , max( $txtTiempoTranscurrido ) , '$fchHoySeguimiento' ) ,
								TIMESTAMPDIFF( day , max( $txtTiempoTranscurridoAnterior ) , '$fchHoySeguimiento' ) ) AS tiempoTranscurrido
						FROM T_DES_DESEMBOLSO des 
							$txtInnerJoin
						WHERE 
							des.seqFormulario IN ( $txtSecuenciales )
						GROUP BY 1
					";
                break;
        }

        $objRes = $aptBd->execute($sql);
        $arrSecuenciales = array();
        if ($txtColor != "") {
            while ($objRes->fields) {
                $tiempoTranscurrido = $objRes->fields['tiempoTranscurrido'];
                switch ($tiempoTranscurrido) {
                    case "0":
                        $arrSecuenciales["verde"][] = $objRes->fields['seqFormulario'];
                        break;
                    case ( $tiempoTranscurrido <= $tiempoVerde ):
                        $arrSecuenciales["verde"][] = $objRes->fields['seqFormulario'];
                        break;
                    case ( $tiempoTranscurrido <= $tiempoAmarillo ):
                        $arrSecuenciales["amarillo"][] = $objRes->fields['seqFormulario'];
                        break;
                    default:
                        $arrSecuenciales["rojo"][] = $objRes->fields['seqFormulario'];
                        break;
                }
                $objRes->MoveNext();
            }
        } else {
            $txtColor = "verde";
            while ($objRes->fields) {
                $arrSecuenciales["verde"][] = $objRes->fields['seqFormulario'];
                $objRes->MoveNext();
            }
        }

        $arrSecuenciales = $arrSecuenciales[$txtColor];
        if (!empty($arrSecuenciales) and $txtConsultaReporte == "consulta") {
            $arrSecuenciales = array_slice($arrSecuenciales, 0, 100);
        }

        $txtSecuenciales = ( empty($arrSecuenciales) ) ? "NULL" : implode(" , ", $arrSecuenciales);
        $this->consultaIndicador($seqUsuario, $txtSecuenciales);
    }

    function consultaIndicador($seqUsuario, $txtSecuenciales) {

        global $aptBd;
        $objRes = &$this->objRes;

        $sql = "
					SELECT 
					  max(seg.seqSeguimiento) AS seqSeguimiento
					FROM 
					  T_SEG_SEGUIMIENTO seg
					WHERE seg.seqFormulario IN ( $txtSecuenciales ) 
					GROUP BY seg.seqFormulario
				";
        $objRes = $aptBd->execute($sql);
        $arrSecuencialesSeguimiento = array();
        while ($objRes->fields) {
            $arrSecuencialesSeguimiento[] = $objRes->fields['seqSeguimiento'];
            $objRes->MoveNext();
        }
        $txtSecuencialesSeguimiento = ( empty($arrSecuencialesSeguimiento) ) ? "NULL" : implode(" , ", $arrSecuencialesSeguimiento);
        $fchHoy = date("Y-m-d");

        $sql = "
				SELECT
					frm.seqFormulario,
					frm.txtFormulario ,
					concat(ucwords(ciu.txtNombre1), ' ', ucwords(ciu.txtNombre2), ' ', ucwords(ciu.txtApellido1), ' ', ucwords(ciu.txtApellido2)) AS Nombre,
					format( ciu.numDocumento , 0 ) as numDocumento ,
					frm.numTelefono1,
					frm.numTelefono2,
					frm.numCelular,
					frm.txtDireccion,
					des.txtNombreVendedor,
					des.numTelefonoVendedor,
					des.numTelefonoVendedor2,
					epr.txtEstadoProceso,
					seg.fchMovimiento,
					seg.txtComentario ,
					datediff( '$fchHoy' , fus.fchAsignado ) as  diasDesdeRadicado,
					datediff( '$fchHoy' , vin.fchActo ) as diasDesdeAgisnado
				FROM T_FRM_FORMULARIO frm
					INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario 
					INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
					LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
					INNER JOIN T_SEG_SEGUIMIENTO seg ON seg.seqFormulario = frm.seqFormulario
					INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
					INNER JOIN T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus on fus.seqFormulario = frm.seqFormulario
					INNER JOIN T_AAD_FORMULARIO_ACTO fac on fac.seqFormulario = frm.seqFormulario
					INNER JOIN T_AAD_HOGARES_VINCULADOS vin on vin.seqFormularioActo = fac.seqFormularioActo
					INNER JOIN T_AAD_ACTO_ADMINISTRATIVO adm on ( adm.fchActo = vin.fchActo and adm.numActo = vin.numActo ) 
				WHERE 
					frm.seqFormulario IN ( $txtSecuenciales )
					AND seg.seqSeguimiento IN ( $txtSecuencialesSeguimiento )
					AND hog.seqParentesco = 1
					AND adm.seqTipoActo = 1
					GROUP BY 1
			";
//			pr( $sql ); exit(0);
        $objRes = $aptBd->execute($sql);
        $arrTablaConsulta = &$this->arrTablaConsulta;
        while ($objRes->fields) {
            $arrTemporal = &$arrTablaConsulta[];
            $arrTemporal['Nombre'] = $objRes->fields['Nombre'];
            $arrTemporal['txtFormulario'] = $objRes->fields['txtFormulario'];
            $arrTemporal['numDocumento'] = $objRes->fields['numDocumento'];
            $arrTemporal['numTelefono1'] = $objRes->fields['numTelefono1'];
            $arrTemporal['numTelefono2'] = $objRes->fields['numTelefono2'];
            $arrTemporal['numCelular'] = $objRes->fields['numCelular'];
            $arrTemporal['txtDireccion'] = $objRes->fields['txtDireccion'];
            $arrTemporal['txtNombreVendedor'] = $objRes->fields['txtNombreVendedor'];
            $arrTemporal['numTelefonoVendedor'] = $objRes->fields['numTelefonoVendedor'];
            $arrTemporal['numTelefonoVendedor2'] = $objRes->fields['numTelefonoVendedor2'];
            $arrTemporal['txtEstadoProceso'] = $objRes->fields['txtEstadoProceso'];
            $arrTemporal['fchMovimiento'] = $objRes->fields['fchMovimiento'];
            if (!$seqUsuario) {
                $arrTemporal['Tutor'] = $this->arrSeqVSUsuario[$objRes->fields['seqFormulario']];
            }
            $arrTemporal['txtComentario'] = str_replace("\\", " ", $objRes->fields['txtComentario']);
            $arrTemporal['txtComentario'] = preg_replace("/\s+/", " ", $arrTemporal['txtComentario']);
            $arrTemporal['diasDesdeRadicado'] = $objRes->fields['diasDesdeRadicado'];
            $arrTemporal['diasDesdeAgisnado'] = $objRes->fields['diasDesdeAgisnado'];
            $objRes->MoveNext();
        }

        $objRes->MoveFirst();

        if (empty($arrTablaConsulta)) {
            $arrTemporal = &$arrTablaConsulta[];
            $arrTemporal['Nombre'] = "";
            $arrTemporal['txtFormulario'] = "";
            $arrTemporal['numTelefono1'] = "";
            $arrTemporal['numTelefono2'] = "";
            $arrTemporal['numCelular'] = "";
            $arrTemporal['txtDireccion'] = "";
            $arrTemporal['txtNombreVendedor'] = "";
            $arrTemporal['numTelefonoVendedor'] = "";
            $arrTemporal['numTelefonoVendedor2'] = "";
            $arrTemporal['txtEstadoProceso'] = "";
            $arrTemporal['fchMovimiento'] = "";
            if (!$seqUsuario) {
                $arrTemporal['Tutor'] = "";
            }
            $arrTemporal['txtComentario'] = "";
            $arrTemporal['diasDesdeRadicado'] = "";
            $arrTemporal['diasDesdeRadicado'] = "";
        }

        $this->txtIndicadorTutorDesembolsoJS = $this->arrayToJsDataTable($arrTablaConsulta, "ReporteIndicadores");
    }

    function tiemposVerdeAmarilloRojo($faseIndicador) {

        $tiempoVerde = &$this->tiempoVerde;
        $tiempoAmarillo = &$this->tiempoAmarillo;


        switch ($faseIndicador) {

            case "asignado":
                $tiempoVerde = 30;
                $tiempoAmarillo = 50;
                break;

            case "revisionOferta":
                $tiempoVerde = 2;
                $tiempoAmarillo = 5;
                break;

            case "revisionJuridica":
                $tiempoVerde = 2;
                $tiempoAmarillo = 5;
                break;
            case "estudioTitulos":
                $tiempoVerde = 2;
                $tiempoAmarillo = 5;
                break;

            case "revisionTecnica":
                $tiempoVerde = 4;
                $tiempoAmarillo = 8;
                break;

            case "escrituracion":
                $tiempoVerde = 20;
                $tiempoAmarillo = 30;
                break;

            case "radicadotitulos":
                $tiempoVerde = 1;
                $tiempoAmarillo = 2;
                break;

            case "solicitudDesembolso":
                $tiempoVerde = 4;
                $tiempoAmarillo = 6;
                break;

            default:
                $tiempoVerde = 10;
                $tiempoAmarillo = 30;
                break;
        }
    }

    function cargarIndicador($seqUsuario, $faseIndicador) {

        global $aptBd;
        global $arrFasesDesembolsoIndicadores;

        $this->tiemposVerdeAmarilloRojo($faseIndicador);
        $tiempoVerde = $this->tiempoVerde;
        $tiempoAmarillo = $this->tiempoAmarillo;


        $arrIndicadorCuenta = &$this->arrIndicadorCuenta;
        $this->txtTipoReporte = $faseIndicador;

        $arrInnerJoin["revisionOferta"] = "";
        $arrInnerJoin["revisionJuridica"] = "LEFT JOIN T_DES_JURIDICO jur ON jur.seqDesembolso = des.seqDesembolso";
        $arrInnerJoin["revisionTecnica"] = $arrInnerJoin["revisionJuridica"] . " LEFT JOIN T_DES_TECNICO tec ON tec.seqDesembolso = des.seqDesembolso";
        $arrInnerJoin["escrituracion"] = "";
        $arrInnerJoin["estudioTitulos"] = $arrInnerJoin["revisionTecnica"] . " LEFT JOIN T_DES_ESTUDIO_TITULOS est ON est.seqDesembolso = des.seqDesembolso";
        $arrInnerJoin["solicitudDesembolso"] = $arrInnerJoin["estudioTitulos"] . " LEFT JOIN T_DES_SOLICITUD sol ON sol.seqDesembolso = des.seqDesembolso";
        $txtInnerJoin = $arrInnerJoin[$faseIndicador];

        $arrTiempoTranscurrido["asignado"] = "des.fchCreacionBusquedaOferta";
        $arrTiempoTranscurrido["revisionOferta"] = "des.fchActualizacionBusquedaOferta";
        $arrTiempoTranscurrido["revisionJuridica"] = "jur.fchActualizacion";
        $arrTiempoTranscurrido["revisionTecnica"] = "tec.fchActualizacion";
        $arrTiempoTranscurrido["escrituracion"] = "des.fchActualizacionEscrituracion";
        $arrTiempoTranscurrido["estudioTitulos"] = "est.fchActualizacion";
        $arrTiempoTranscurrido["solicitudDesembolso"] = "sol.fchActualizacion";

        $txtTiempoTranscurrido = $arrTiempoTranscurrido[$faseIndicador];

        $arrTiempoTranscurridoAnterior["revisionJuridica"] = "des.fchActualizacionBusquedaOferta";
        $arrTiempoTranscurridoAnterior["revisionTecnica"] = "jur.fchActualizacion";
        $arrTiempoTranscurridoAnterior["estudioTitulos"] = "des.fchActualizacionEscrituracion";
        $arrTiempoTranscurridoAnterior["solicitudDesembolso"] = "est.fchActualizacion";

        $txtTiempoTranscurridoAnterior = $arrTiempoTranscurridoAnterior[$faseIndicador];

        switch ($faseIndicador) {

            case "asignado":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Asignados']['estados']) . " ) ";
                break;

            case "revisionOferta":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Busqueda de la Oferta']['estados']) . " ) ";
                break;

            case "revisionJuridica":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Revisión Jurídica']['estados']) . " ) ";
                break;

            case "revisionTecnica":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Revisión Técnica']['estados']) . " ) ";
                break;

            case "escrituracion":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Escrituración']['estados']) . " ) ";
                break;

            case "radicadotitulos":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Radicado Titulos']['estados']) . " ) ";
                break;

            case "estudioTitulos":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Estudio de Titulos']['estados']) . " ) ";
                break;

            case "solicitudDesembolso":
                $txtSeqEstadoProceso = " ( " . implode(",", $arrFasesDesembolsoIndicadores['Solicitud de Desembolso']['estados']) . " ) ";
                break;
        }

        $txtWhereUsuario = "";
        if ($seqUsuario) {
            $txtWhereUsuario = "WHERE fus.seqUsuario = $seqUsuario";
        }

        $sql = "
					SELECT 
						frm.seqFormulario
					FROM 
					T_FRM_FORMULARIO frm
					WHERE 
					  frm.seqFormulario IN (
					    SELECT 
					      fus.seqFormulario
					    FROM 
					      T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
					    	$txtWhereUsuario
					    )
						AND frm.seqEstadoProceso in $txtSeqEstadoProceso
				";

        $objRes = $aptBd->execute($sql);
        $arrSecuenciales = array();
        while ($objRes->fields) {
            $arrSecuenciales[] = $objRes->fields['seqFormulario'];
            $objRes->MoveNext();
        }
        $txtSecuenciales = ( empty($arrSecuenciales) ) ? "NULL" : implode(" , ", $arrSecuenciales);

        $fchHoySeguimiento = date("Y-m-d G:i:s");
        // $fchHoySeguimiento = "2011-2-7 15:59:00";

        switch ($faseIndicador) {

            case "asignado":
            case "escrituracion":
                $sql = "
						SELECT
							seg.seqFormulario ,
							TIMESTAMPDIFF( day , max( seg.fchMovimiento ) , '$fchHoySeguimiento'  ) AS tiempoTranscurrido
						FROM T_SEG_SEGUIMIENTO seg 
						WHERE seg.seqFormulario in ( $txtSecuenciales  )
						GROUP BY seg.seqFormulario
						";

//						pr( "escrituracion" ); pr( $sql );

                break;

            case "radicadotitulos":
                // Se verifica con los seguimientos que tengan la Gestion "Radicacion de Titulos" del Grupo de Gestion "Recibo de Documento"
                $sql = "
						SELECT
							seg.seqFormulario ,
							TIMESTAMPDIFF( day ,
									max( (
										SELECT seg.fchMovimiento
										FROM T_DES_DESEMBOLSO des
										WHERE seg.fchMovimiento >= des.fchActualizacionEscrituracion 
										AND seg.seqGestion = 35
										AND des.seqFormulario = seg.seqFormulario
										AND des.fchActualizacionEscrituracion > '2000-01-01 00:00:00'
									 ) ) ,
									'$fchHoySeguimiento' 
							) AS tiempoTranscurrido
						FROM T_SEG_SEGUIMIENTO seg 
						WHERE seg.seqFormulario in ( $txtSecuenciales )
						and seg.seqSeguimiento in (
							SELECT seg.seqSeguimiento
							FROM T_DES_DESEMBOLSO des
							WHERE seg.fchMovimiento >= des.fchActualizacionEscrituracion 
							AND seg.seqGestion = 35
							AND des.seqFormulario = seg.seqFormulario
							AND des.fchActualizacionEscrituracion > '2000-01-01 00:00:00'
						)
						GROUP BY seg.seqFormulario
						";

//						pr( "radicado" ); pr( $sql );

                break;

            case "revisionOferta":
                $sql = "
						SELECT 
							frm.seqFormulario,
							TIMESTAMPDIFF( day , max( $txtTiempoTranscurrido ) , '$fchHoySeguimiento' ) AS tiempoTranscurrido
						FROM T_FRM_FORMULARIO frm
						LEFT JOIN T_DES_DESEMBOLSO des ON frm.seqFormulario = des.seqFormulario
							$txtInnerJoin
						WHERE 
							frm.seqFormulario IN ( $txtSecuenciales )
						GROUP BY 1
					";
                break;
            default:
                $sql = "
						SELECT 
							des.seqFormulario,
							IF( TIMESTAMPDIFF( day , max( $txtTiempoTranscurrido ) , '$fchHoySeguimiento' ) >= 0 , 
								TIMESTAMPDIFF( day , max( $txtTiempoTranscurrido ) , '$fchHoySeguimiento' ) ,
								TIMESTAMPDIFF( day , max( $txtTiempoTranscurridoAnterior ) , '$fchHoySeguimiento' ) ) AS tiempoTranscurrido
						FROM T_DES_DESEMBOLSO des 
							$txtInnerJoin
						WHERE 
							des.seqFormulario IN ( $txtSecuenciales )
						GROUP BY 1
					";
                break;
        }

        $objRes = $aptBd->execute($sql);
        $numVerde = 0;
        $numAmarillo = 0;
        $numRojo = 0;
        while ($objRes->fields) {

            $seqFormulario = $objRes->fields['seqFormulario'];
            $tiempoTranscurrido = $objRes->fields['tiempoTranscurrido'];

            switch ($tiempoTranscurrido) {

                case "0";
                    $numVerde++;
                    break;

                case( intval($tiempoTranscurrido) <= $tiempoVerde ):
                    $numVerde++;
                    break;

                case ( intval($tiempoTranscurrido) <= $tiempoAmarillo ):
                    $numAmarillo++;
                    break;

                default:
                    $numRojo++;
                    break;
            }

            $objRes->MoveNext();
        }


        $arrIndicadorCuenta['verde'] = $numVerde;
        $arrIndicadorCuenta['amarillo'] = $numAmarillo;
        $arrIndicadorCuenta['rojo'] = $numRojo;
    }

    function obtenerHogaresPromedioTutorDesembolso() {

        global $aptBd;

        $seqUsuario = $this->seqUsuario;
        $numDiasPromedio = 0;

        $txtWhereUsuario = "";
        if ($seqUsuario) {
            $txtWhereUsuario = "fus.seqUsuario = $seqUsuario AND";
        }

        $sql = "
					SELECT 
					  round( avg( TIMESTAMPDIFF( day , des.fchCreacionBusquedaOferta  , dso.fchCreacion ) ) ) as DiasPromedioDesembolso
					FROM T_FRM_FORMULARIO frm
					INNER JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
					INNER JOIN T_DES_SOLICITUD dso ON dso.seqDesembolso = des.seqDesembolso
					WHERE 
					  frm.seqFormulario IN (
					    SELECT 
					      fus.seqFormulario
					    FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
					    WHERE 
					       $txtWhereUsuario 1
					    ) AND frm.seqModalidad != 5
					";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $numDiasPromedio = $objRes->fields['DiasPromedioDesembolso'];
        } else {
            $numDiasPromedio = 0;
        }
        $this->numDiasPromedio = $numDiasPromedio;
    }

    function obtenerCuentaDesembolsoTotal() {

        global $aptBd;
        global $seqDesembolsoTotal;

        $seqUsuario = $this->seqUsuario;
        $numDesembolsoTotal = 0;

        $txtWhereUsuario = "";
        if ($seqUsuario) {
            $txtWhereUsuario = "fus.seqUsuario = $seqUsuario AND";
        }

        $sql = "
					SELECT 
					  count( 1 ) as DesembolsoTotal
					FROM T_FRM_FORMULARIO frm
					WHERE 
					  frm.seqFormulario IN (
					    SELECT 
					      fus.seqFormulario
					    FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
					    WHERE 
					       $txtWhereUsuario 1
					    )
						AND frm.seqEstadoProceso = $seqDesembolsoTotal
					";

        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $numDesembolsoTotal = $objRes->fields['DesembolsoTotal'];
        } else {
            $numDesembolsoTotal = 0;
        }
        $this->numDesembolsoTotal = $numDesembolsoTotal;
    }

    function obtenerQueriesRangosFecha($txtEstado) {

        global $aptBd;

        $arrInnerJoin["revisionOferta"] = "";
        $arrInnerJoin["revisionJuridica"] = "LEFT JOIN T_DES_JURIDICO jur ON jur.seqDesembolso = des.seqDesembolso";
        $arrInnerJoin["revisionTecnica"] = "LEFT JOIN T_DES_TECNICO tec ON tec.seqDesembolso = des.seqDesembolso";
        $arrInnerJoin["escrituracion"] = "";
        $arrInnerJoin["estudioTitulos"] = "LEFT JOIN T_DES_ESTUDIO_TITULOS est ON est.seqDesembolso = des.seqDesembolso";
        $arrInnerJoin["solicitudDesembolso"] = "LEFT JOIN T_DES_SOLICITUD sol ON sol.seqDesembolso = des.seqDesembolso";


        $arrRangoFecha["revisionOferta"] = " (
													des.fchCreacionBusquedaOferta >= '%fechaRango% 00:00:00' AND
    												des.fchCreacionBusquedaOferta <= '%fechaHoy% 23:59:59'
													)
												";
        $arrRangoFecha["revisionJuridica"] = "
													(
													jur.fchCreacion >= '%fechaRango% 00:00:00' AND 
    												jur.fchCreacion <= '%fechaHoy% 23:59:59'
													)
												";
        $arrRangoFecha["revisionTecnica"] = "
													(
													tec.fchCreacion >= '%fechaRango% 00:00:00' AND 
      												tec.fchCreacion <= '%fechaHoy% 23:59:59'
													)
												";
        $arrRangoFecha["escrituracion"] = "
													(
													des.fchCreacionEscrituracion >= '%fechaRango% 00:00:00' AND 
      												des.fchCreacionEscrituracion <= '%fechaHoy% 23:59:59'
													)
												";
        $arrRangoFecha["estudioTitulos"] = "
													(
													est.fchCreacion >= '%fechaRango% 00:00:00' AND 
      												est.fchCreacion <= '%fechaHoy% 23:59:59'
													)
												";
        $arrRangoFecha["solicitudDesembolso"] = "
													(
													sol.fchCreacion >= '%fechaRango% 00:00:00' AND 
      												sol.fchCreacion <= '%fechaHoy% 23:59:59'
													)
												";

        $arrDevolver = array();

        switch ($txtEstado) {

            case "todos":
            case "":
                $arrDevolver["innerJoin"] = $arrInnerJoin;
                $arrDevolver["rangos"] = $arrRangoFecha;
                break;

            default:
                $arrDevolver["innerJoin"] = $arrInnerJoin[$txtEstado];
                $arrDevolver["rangos"] = $arrRangoFecha[$txtEstado];
                break;
        }

        return $arrDevolver;
    }

    function obtenerHogaresPorEstadoTutorDesembolso($txtEstado = "todos") {

        global $aptBd;
        $seqUsuario = $this->seqUsuario;
        $txtWhereUsuario = "";
        if ($this->seqUsuario) {
            $txtWhereUsuario = "WHERE fus.seqUsuario = $seqUsuario ";
        }

        $arrQueries = $this->obtenerQueriesRangosFecha($txtEstado);

        $txtInnerJoin = ( is_array($arrQueries["innerJoin"]) ) ? implode(" ", $arrQueries["innerJoin"]) : $arrQueries["innerJoin"];
        $txtRangos = ( is_array($arrQueries["rangos"]) ) ? implode(" OR ", $arrQueries["rangos"]) : $arrQueries["rangos"];

        $numTotalHoy = 0;
        $numTotalSemana = 0;
        $numTotalMes = 0;

        $fchHoy = date("Y-m-d");
        $fchHaceUnaSemana = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 7, date("Y")));
        $fchHaceUnMes = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));

        $txtRangosHoy = str_replace("%fechaRango%", $fchHoy, $txtRangos);
        $txtRangosHoy = str_replace("%fechaHoy%", $fchHoy, $txtRangosHoy);

        $txtRangosSemana = str_replace("%fechaRango%", $fchHaceUnaSemana, $txtRangos);
        $txtRangosSemana = str_replace("%fechaHoy%", $fchHoy, $txtRangosSemana);

        $txtRangosMes = str_replace("%fechaRango%", $fchHaceUnMes, $txtRangos);
        $txtRangosMes = str_replace("%fechaHoy%", $fchHoy, $txtRangosMes);

        $sql = "
					SELECT 1
					FROM T_DES_DESEMBOLSO des
					$txtInnerJoin
					WHERE
					( 
					$txtRangosHoy
					)
					AND des.seqFormulario IN
					( 
						SELECT
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						$txtWhereUsuario
					)
					GROUP BY des.seqFormulario
				";

        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $numTotalHoy++;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            
        }



        $sql = "
					SELECT 1
					FROM T_DES_DESEMBOLSO des
					$txtInnerJoin
					WHERE
					( 
					$txtRangosSemana
					)
					AND des.seqFormulario IN
					( 
						SELECT
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						$txtWhereUsuario 
					)
					GROUP BY des.seqFormulario
				";
        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $numTotalSemana++;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            
        }


        $sql = "
					SELECT 1
					FROM T_DES_DESEMBOLSO des
					$txtInnerJoin
					WHERE
					( 
					$txtRangosMes
					)
					AND des.seqFormulario IN
					( 
						SELECT
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
						$txtWhereUsuario 
					)
					GROUP BY des.seqFormulario
				";
        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $numTotalMes++;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            
        }

        $this->numTotalSemana = $numTotalSemana;
        $this->numTotalMes = $numTotalMes;
        $this->numTotalHoy = $numTotalHoy;
    }

    function crearCRMCoordinador() {

        $this->obtenerTutoresAsignados();
        $this->obtenerHogaresSinAsignar();

        $this->txtTutoresInformacionJS = $this->arrayToJsTree($this->arrTutores, "Tutores", true);
        if (count($this->arrHogaresSinAsignar) > 0) {
            $this->txtHogaresSinAsignarJS = $this->arrayToJsDataTable($this->arrHogaresSinAsignar, "NoAsignados");
        }


        $arrTutoresMasiva = array_merge($this->arrTutoresXCoordinadores, $this->arrTutoresNoAsignados);
        $this->txtTutoresMasivaJS = $this->arrayToJsTree($arrTutoresMasiva, "TutoresMasiva", false, true);
    }

    private function obtenerTutoresAsignados() {

        global $aptBd;
        $arrTutores = $this->arrTutores;
        $arrTutoresNoAsignados = array();
        $arrSeqTutores = array();
        $arrNombreTutor = $this->arrNombreTutor;
        $arrNombreTutoresAsignados = array();
        $arrCoodrinadores = $this->arrCoordinadores;
        $txtTutorDesembolso = "Tutores Desembolso";
        $txtTutorPostulacion = "Tutores Postulacion";

        foreach ($arrTutores as $arrGrupoTutores) {
            foreach ($arrGrupoTutores as $seqUsuario => $txtNombre) {
                $arrSeqTutores[] = $seqUsuario;
            }
        }

        $sql = "
				SELECT 
					seqUsuario ,
					seqUsuarioCoordinador
				FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS
				GROUP BY 1
				ORDER BY 1
			";
        $objRes = $aptBd->execute($sql);
        $arrTutoresXCoordinadores = array();
        $arrTutoresAsignados = array();
        while ($objRes->fields) {

            $txtGrupoTutor = "";
            $seqUsuario = $objRes->fields["seqUsuario"];
            $seqUsuarioCoordinador = $objRes->fields["seqUsuarioCoordinador"];

            // Se determina cual es el grupo al que pertenece el tutor
            switch (true) {

                // Tutor Desembolso
                case( array_key_exists($seqUsuario, $arrTutores[$txtTutorDesembolso]) ):
                    $txtGrupoTutor = $txtTutorDesembolso;
                    break;

                // Tutor Postulacion
                case ( is_array($arrTutores[$txtTutorPostulacion]) and
                array_key_exists($seqUsuario, $arrTutores[$txtTutorPostulacion]) ):
                    $txtGrupoTutor = $txtTutorPostulacion;
                    break;
            }


            $arrTutoresAsignados[] = $seqUsuario;
            $arrTemporal = &$arrTutoresXCoordinadores[$arrCoodrinadores[$seqUsuarioCoordinador]][$txtGrupoTutor];
            $arrTemporal[$seqUsuario] = $arrNombreTutor[$seqUsuario];
            $objRes->MoveNext();
        }

        $this->arrTutoresXCoordinadores = $arrTutoresXCoordinadores;

        $arrTutoresNoAsignados = array_diff($arrSeqTutores, $arrTutoresAsignados);
        $arrNombreTutoresNoAsignados = array();

        foreach ($arrTutoresNoAsignados as $seqTutor) {
            $arrNombreTutoresNoAsignados[$seqTutor] = $arrNombreTutor[$seqTutor];
        }

        $this->arrTutoresNoAsignados["NoAsignados"] = $arrNombreTutoresNoAsignados;
    }

    private function obtenerHogaresSinAsignar() {

        global $aptBd;
        global $claActos;

        $sql = "
				SELECT 
					ciu.numDocumento, 
					ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS nombre
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				INNER JOIN T_FRM_ESTADO_PROCESO epr ON epr.seqEstadoProceso = frm.seqEstadoProceso
				INNER JOIN T_FRM_ETAPA eta ON eta.seqEtapa = epr.seqEtapa
				WHERE 
					frm.seqFormulario NOT IN
					(
						SELECT 
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
					)
					AND ( frm.seqEstadoProceso = 15 
							OR eta.seqEtapa = 5 
						)
					AND hog.seqParentesco = 1
				LIMIT 100
			";

        $objRes = $aptBd->execute($sql);
        $arrNoAsignados = array();
        while ($objRes->fields) {
            $arrTemporal = &$arrNoAsignados[];

            $numDocumento = $objRes->fields['numDocumento'];
            $arrSecuencialFormularioActo = $claActos->actoExisteCiudadano($numDocumento);

            $fchActo = "";
            $numActo = "";
            foreach ($arrSecuencialFormularioActo as $seqFormularioActo) {
                $arrActo = $claActos->obtenerActoAdministrativo($seqFormularioActo);
                if ($arrActo["seqTipoActo"] == 1) {
                    $fchActo = $arrActo["fchActo"];
                    $numActo = $arrActo["numActo"];
                    break;
                }
            }

            $arrTemporal["Documento"] = $objRes->fields['numDocumento'];
            $arrTemporal["NombreCiudadano"] = $objRes->fields['nombre'];
            $arrTemporal["FechaActo"] = $fchActo;
            $arrTemporal["NumeroActo"] = $numActo;
            $arrTemporal["Asignado"] = "Sin Tutor";
            $objRes->MoveNext();
        }
        $this->arrHogaresSinAsignar = $arrNoAsignados;
    }

    function obtenerTutores() {

        global $aptBd;

        /**
         * Obtengo todos los tutores de postulacion que esten activos y que tampoco
         * pertenezcan a los grupos de.
         * 
         * - Tutor Postulacion
         * - Juridica
         * - Tecnica
         * - Coordinador Grupo
         * - Directivos
         */
        $sql = "
					SELECT 
						ucwords(concat(usu.txtNombre, ' ', usu.txtApellido)) AS usuario,
						ucwords(gru.txtGrupo) AS Grupo,
						usu.seqUsuario
					FROM T_COR_GRUPO gru
						INNER JOIN T_COR_PROYECTO_GRUPO pro ON pro.seqGrupo = gru.seqGrupo
						INNER JOIN T_COR_PERFIL per ON per.seqProyectoGrupo = pro.seqProyectoGrupo
						INNER JOIN T_COR_USUARIO usu ON per.seqUsuario = usu.seqUsuario
					WHERE gru.seqGrupo IN ( 8 )
					AND usu.seqUsuario <> 1
					AND usu.bolActivo = 1
					AND usu.seqUsuario NOT IN (
						SELECT 
							usu1.seqUsuario
						FROM T_COR_GRUPO gru1
							INNER JOIN T_COR_PROYECTO_GRUPO pro1 ON pro1.seqGrupo = gru1.seqGrupo
							INNER JOIN T_COR_PERFIL per1 ON per1.seqProyectoGrupo = pro1.seqProyectoGrupo 
							INNER JOIN T_COR_USUARIO usu1 ON per1.seqUsuario = usu1.seqUsuario
						WHERE gru1.seqGrupo IN ( 18 , 9 , 13 , 14 , 7 )
							OR usu1.seqUsuario IN ( 135 , 136 , 150 , 139 , 157 , 98 , 160 , 144 )
					)
					ORDER BY 2, 1
				";
        $objRes = $aptBd->execute($sql);
        $arrTutores = &$this->arrTutores;
        $arrNombreTutor = &$this->arrNombreTutor;
        $arrNombreTutorNoCuenta = &$this->arrNombreTutorNoCuenta;

        while ($objRes->fields) {
            $seqUsuario = $objRes->fields['seqUsuario'];
            /**
             * Saco la cuenta de cuantos hogares tiene asignado el tutor
             */
            $sql = "
						SELECT count( 1 ) AS cuenta
						FROM T_FRM_FORMULARIO frm
						INNER JOIN T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus on fus.seqFormulario = frm.seqFormulario
						WHERE fus.seqUsuario = $seqUsuario and frm.seqEstadoProceso <> 33
						";
            $objResUsuario = $aptBd->execute($sql);
            $arrTutores[$objRes->fields['Grupo']][$seqUsuario] = $objRes->fields['usuario'] . "( " . $objResUsuario->fields['cuenta'] . " )";
            $arrNombreTutor[$seqUsuario] = $objRes->fields['usuario'] . "( " . $objResUsuario->fields['cuenta'] . " )";
            $arrNombreTutorNoCuenta[$seqUsuario] = $objRes->fields['usuario'];
            $objRes->MoveNext();
        }
    }

    function obtenerCoordinadores() {

        global $aptBd;

        $sql = "
					SELECT 
						ucwords( concat( usu.txtNombre , ' ' , usu.txtApellido ) ) AS usuario,
						usu.seqUsuario
					FROM T_COR_GRUPO gru
						INNER JOIN T_COR_PROYECTO_GRUPO pro ON pro.seqGrupo = gru.seqGrupo
						INNER JOIN T_COR_PERFIL per ON per.seqProyectoGrupo = pro.seqProyectoGrupo
						INNER JOIN T_COR_USUARIO usu ON per.seqUsuario = usu.seqUsuario
					WHERE gru.seqGrupo IN ( 7 ) 
						AND usu.seqUsuario <> 1
						AND usu.bolActivo = 1
					ORDER BY 1
				";

        $objRes = $aptBd->execute($sql);
        $arrCoordinadores = &$this->arrCoordinadores;
        while ($objRes->fields) {
            $arrCoordinadores[$objRes->fields['seqUsuario']] = $objRes->fields['usuario'];
            $objRes->MoveNext();
        }
    }

    function obtenerTutorHogar($seqFormulario) {

        global $aptBd;
        $sql = "
				SELECT
					concat( usu.txtNombre , ' ' , usu.txtApellido ) as nombre
				FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fas
				INNER JOIN T_COR_USUARIO usu ON fas.seqUsuario = usu.seqUsuario
				WHERE seqFormulario = $seqFormulario
				";
        $objRes = $aptBd->execute($sql);

        $txtUsuario = ( $objRes->fields["nombre"] ) ? $objRes->fields["nombre"] : "";
        return $txtUsuario;
    }

    function generarReporteTotalHogar() {

        global $aptBd;
        global $claActos;

        $sql = "
				SELECT 
					frm.seqFormulario,
					ciu.numDocumento, 
					ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS nombre
				FROM T_FRM_FORMULARIO frm
				INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				INNER JOIN T_FRM_ESTADO_PROCESO epr ON epr.seqEstadoProceso = frm.seqEstadoProceso
				INNER JOIN T_FRM_ETAPA eta ON eta.seqEtapa = epr.seqEtapa
				WHERE 
					frm.seqFormulario NOT IN
					(
						SELECT 
							fus.seqFormulario
						FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS fus
					)
					AND ( frm.seqEstadoProceso = 15 
							OR eta.seqEtapa = 5 
						)
					AND hog.seqParentesco = 1
			";
        $objRes = $aptBd->execute($sql);
        $arrDatosTabla = array();

        while ($objRes->fields) {

            $numDocumento = $objRes->fields["numDocumento"];
            $arrSecuencialFormularioActo = $claActos->actoExisteCiudadano($numDocumento);

            $fchActo = "";
            $numActo = "";
            foreach ($arrSecuencialFormularioActo as $seqFormularioActo) {
                $arrActo = $claActos->obtenerActoAdministrativo($seqFormularioActo);
                if ($arrActo["seqTipoActo"] == 1) {
                    $fchActo = $arrActo["fchActo"];
                    $numActo = $arrActo["numActo"];
                    break;
                }
            }
            $arrTemporal = &$arrDatosTabla[];
            $arrTemporal["seqFormulario"] = $objRes->fields["seqFormulario"];
            $arrTemporal["numDocumento"] = $objRes->fields["numDocumento"];
            $arrTemporal["nombre"] = $objRes->fields["nombre"];
            $arrTemporal["FechaActo"] = $fchActo;
            $arrTemporal["NumActo"] = $numActo;
            $objRes->MoveNext();
        }

        if (!empty($arrDatosTabla)) {

            $txtNombreArchivo = "ReporteTotalAsignados_" . date("Y-m-d") . ".xls";
            header("Content-disposition: attachment; filename=$txtNombreArchivo");
            header("Content-Type: application/force-download");
            header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 1");

            echo utf8_decode(implode("\t", array_keys($arrDatosTabla[0]))) . "\r\n";
            foreach ($arrDatosTabla as $arrDatos) {
                echo utf8_decode(implode("\t", $arrDatos)) . "\r\n";
            }
        } else {
            $arrErrores[] = "El tutor no tiene Hogares Asignados";
        }

        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    function generarReporteTutorHogar($seqTutor) {

        global $aptBd;
        global $claActos;

        // Obtengo los secuenciales de formulario que tiene el tutor y su coordinador respectivo
        $sql = "
				SELECT 
					seqFormulario, 
					seqUsuarioCoordinador
				FROM T_IND_FORMULARIO_USUARIOS_ASIGNADOS 
				WHERE 
					seqUsuario = $seqTutor
			";

        $objRes = $aptBd->execute($sql);
        $arrSecuenciales = array();
        $arrUsuarios = array();
        $arrTotal = array();
        while ($objRes->fields) {
            $arrTotal[$objRes->fields['seqFormulario']] = $objRes->fields['seqUsuarioCoordinador'];
            $arrSecuenciales[] = $objRes->fields['seqFormulario'];
            $arrUsuarios[] = $objRes->fields['seqUsuarioCoordinador'];
            $objRes->MoveNext();
        }

        $arrUsuarios = array_unique($arrUsuarios);
        $arrUsuarios[] = $seqTutor;

        // Obtener el nombre del Usuario y los Coordinadores que tiene
        $sql = "
				SELECT 
					seqUsuario,
					concat(txtNombre, ' ', txtApellido) as Nombre
				FROM T_COR_USUARIO
				WHERE 
					seqUsuario in ( " . implode(", ", $arrUsuarios) . " )
			";
        $objRes = $aptBd->execute($sql);
        $txtNombreUsuario = "";
        $arrCoordinadores = array();
        while ($objRes->fields) {

            if ($objRes->fields['seqUsuario'] == $seqTutor) {
                $txtNombreUsuario = $objRes->fields['Nombre'];
            } else {
                $arrCoordinadores[$objRes->fields['seqUsuario']] = $objRes->fields['Nombre'];
            }
            $objRes->MoveNext();
        }

        $sql = "
				SELECT 
					frm.seqFormulario, 
					ciu.numDocumento, 
					ucwords(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre
				FROM T_FRM_FORMULARIO frm
					INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
					INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				WHERE 
					hog.seqParentesco = 1 AND 
					frm.seqFormulario IN ( " . implode(" , ", $arrSecuenciales) . " )
			";

        $objRes = $aptBd->execute($sql);
        $arrDatosTabla = array();
        while ($objRes->fields) {
            $arrTemporal = &$arrDatosTabla[];

            $seqFormulario = $objRes->fields["seqFormulario"];
            $numDocumento = $objRes->fields["numDocumento"];
            $txtNombre = $objRes->fields["Nombre"];

            $arrSecuencialFormularioActo = $claActos->actoExisteCiudadano($numDocumento);

            $fchActo = "";
            $numActo = "";
            foreach ($arrSecuencialFormularioActo as $seqFormularioActo) {
                $arrActo = $claActos->obtenerActoAdministrativo($seqFormularioActo);
                if ($arrActo["seqTipoActo"] == 1) {
                    $fchActo = $arrActo["fchActo"];
                    $numActo = $arrActo["numActo"];
                    break;
                }
            }

            $arrTemporal["Usuario"] = $txtNombreUsuario;
            $arrTemporal["Coordinador"] = $arrCoordinadores[$arrTotal[$seqFormulario]];
            $arrTemporal["Documento"] = $numDocumento;
            $arrTemporal["Nombre"] = $txtNombre;
            $arrTemporal["FechaActo"] = $fchActo;
            $arrTemporal["NumActo"] = $numActo;

            $objRes->MoveNext();
        }

        if (!empty($arrDatosTabla)) {

            $txtNombreArchivo = "ReporteHogaresAsignados_" . str_replace(" ", "", $txtNombre) . "_" . date("Y-m-d") . ".xls";
            header("Content-disposition: attachment; filename=$txtNombreArchivo");
            header("Content-Type: application/force-download");
            header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 1");

            echo utf8_decode(implode("\t", array_keys($arrDatosTabla[0]))) . "\r\n";
            foreach ($arrDatosTabla as $arrDatosFila) {
                echo utf8_decode(implode("\t", $arrDatosFila)) . "\r\n";
            }
        } else {
            $arrErrores[] = "El tutor no tiene Hogares Asignados";
        }

        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    function arrayToJsDataTable($arrDataTable, $txtDataTable) {
        $txtJs = "var objDataTable$txtDataTable = {";
        if ($arrDataTable) {
            $txtJs .= "titulos: [";
            foreach ($arrDataTable[0] as $txtTitulo => $txtDato) {
                $txtJs .= "'" . $txtTitulo . "',";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= "], ";
            $txtJs .= "datos: [";
            foreach ($arrDataTable as $arrDatos) {
                $txtJs .= "{";
                foreach ($arrDatos as $txtTitulo => $txtDato) {
                    $txtDato = trim(ereg_replace("\n", "", $txtDato));
                    $txtJs .= ereg_replace(" ", "", $txtTitulo) . ": '$txtDato' , ";
                }
                $txtJs = trim($txtJs, ", ");
                $txtJs .= "}, ";
            }

            $txtJs = trim($txtJs, ", ");
            $txtJs .= "]";
        }
        $txtJs .= "};";
        return $txtJs;
    }

    private function arrayToJsTree($arrArbol, $txtArbol, $bolInformacion = false, $bolDoble = false) {

        $txtInformacion = "";
        if ($bolInformacion === true) {
            $txtInformacion = "Informacion";
        }

        $txtJs = "var objArbol$txtArbol$txtInformacion = new YAHOO.widget.TreeView('treeDivArbolMostrar$txtArbol$txtInformacion', [";

        foreach ($arrArbol as $txtGrupo => $arrUsuarios) {
            $txtJs .= "{";
            $txtJs .= "type: 'text',";
            $txtJs .= "label: '$txtGrupo',";
            $txtJs .= "children: [";
            if ($bolDoble === false) {
                foreach ($arrUsuarios as $idUsuario => $txtNombreUsuario) {
                    $txtJs .= "{";
                    $txtJs .= "type: 'text',";
                    $txtJs .= "label: '$txtNombreUsuario',";
                    $txtJs .= "idUsuario: '$idUsuario'";
                    $txtJs .= "},";
                }
            } else {

                foreach ($arrUsuarios as $txtUsuario => $arrDatosUsuario) {
                    $txtJs .= "{";
                    $txtJs .= "type: 'text',";
                    if (is_array($arrDatosUsuario)) {
                        $txtJs .= "label: '$txtUsuario',";
                        $txtJs .= "children: [";
                        foreach ($arrDatosUsuario as $seqUsuario => $txtNombre) {
                            $txtJs .= "{";
                            $txtJs .= "type: 'text',";
                            $txtJs .= "label: '$txtNombre',";
                            $txtJs .= "idUsuario: '$seqUsuario'";
                            $txtJs .= "},";
                        }
                        $txtJs = trim($txtJs, ", ");
                        $txtJs .= "],";
                    } else {
                        $txtJs .= "label: '$arrDatosUsuario',";
                        $txtJs .= "idUsuario: '$txtUsuario',";
                    }
                    $txtJs = trim($txtJs, ", ");
                    $txtJs .= "},";
                }
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= "]},";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= "]);";
        return $txtJs;
    }

    function arrayToJsTreeIndicadoresSolicitudDesembolso($arrActosAdministrativos) {

        global $arrMeses;
        $arrDatosOperaciones = $this->arrDatosOperaciones;
        $arrDatosConcepto = $this->arrDatosConcepto;

        $arrActosAdministrativosFinal = array();
        $arrOperacionesFinal = array();
        $arrConceptoFinal = array();
        foreach ($arrActosAdministrativos as $arrDatosActo) {
            $arrTemporal = &$arrActosAdministrativosFinal[$arrDatosActo["txtTipoActo"]][];

            $arrFecha = explode("-", $arrDatosActo["fchActo"]);
            $txtFecha = $arrFecha[2] . " de " . $arrMeses[intval($arrFecha[1])] . " del " . $arrFecha[0];

            $arrTemporal["Fecha Acto"] = $txtFecha;
            $arrTemporal["Número Acto"] = $arrDatosActo["numActo"];
        }

        foreach ($arrDatosOperaciones as $arrOperacion) {
            $arrTemporal = &$arrOperacionesFinal[$arrOperacion["Año"]][$arrOperacion["Mes"]];
            $arrTemporal = $arrOperacion["Total Operacion"];
        }

        $txtJs = "var objArbolIndicador = new YAHOO.widget.TreeView( 'divArbolIndicadorSolicitudMostrar', [";

        //ARBOL PARA LOS ACTOS ADMINISTRATIVOS
        $txtJs .= " { ";
        $txtJs .= "type: 'text' , ";
        $txtJs .= "label: 'ActosAdministrativos' , ";
        $txtJs .= "children: [ ";
        foreach ($arrActosAdministrativosFinal as $txtTipoActo => $arrActo) {
            $txtJs .= " { ";
            $txtJs .= "type: 'text' , ";
            $txtJs .= "label: '$txtTipoActo' , ";
            $txtJs .= "children: [ ";
            foreach ($arrActo as $arrDatosActo) {
                $txtDatoResolucion = "Resolución #" . $arrDatosActo["Número Acto"] . " del " . $arrDatosActo["Fecha Acto"];
                $txtJs .= " { ";
                $txtJs .= "type: 'text' , ";
                $txtJs .= "label: '$txtDatoResolucion'  ";
                $txtJs .= " } , ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= " ] } , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] } , ";

        //ARBOL PARA LAS OPERACIONES
        $txtJs .= " { ";
        $txtJs .= "type: 'text' , ";
        $txtJs .= "label: 'Operaciones' , ";
        $txtJs .= "children: [ ";
        foreach ($arrOperacionesFinal as $txtAnno => $arrOperacionAnno) {
            $txtJs .= " { ";
            $txtJs .= "type: 'text' , ";
            $txtJs .= "label: 'Año: $txtAnno' ,  ";
            $txtJs .= "children: [ ";
            foreach ($arrOperacionAnno as $txtMes => $valTotalOperacion) {
                $txtJs .= " { ";
                $txtJs .= "type: 'text' , ";
                $txtJs .= "label: '$txtMes: \$ " . number_format($valTotalOperacion, 0, '.', ',') . "' ";
                $txtJs .= " } , ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= " ] } , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] } , ";

        //ARBOL PARA LOS CONCEPTOS
        $txtJs .= " { ";
        $txtJs .= "type: 'text',";
        $txtJs .= "label: 'Conceptos' , ";
        $txtJs .= "children: [ ";
        foreach ($arrDatosConcepto as $numProyecto => $arrConcepto) {
            $txtJs .= " { ";
            $txtJs .= "type: 'text' , ";
            $txtJs .= "label: 'Proyecto #$numProyecto' ,  ";
            $txtJs .= "children: [ ";
            foreach ($arrConcepto as $arrDatosDelConcepto) {
                $arrFecha = explode("-", $arrDatosDelConcepto["FechaConcepto"]);
                $txtFecha = $arrFecha[2] . " de " . $arrMeses[intval($arrFecha[1])] . " del " . $arrFecha[0];
                $txtNombreConcepto = $arrDatosDelConcepto["NombreConcepto"];
                $valConcepto = "\$ " . number_format($arrDatosDelConcepto["Valor"], 0, '.', ',');

                $txtJs .= " { ";
                $txtJs .= "type: 'text' , ";
                $txtJs .= "label: 'Concepto: $txtNombreConcepto' ,  ";
                $txtJs .= "children: [ ";
                $txtJs .= " { ";
                $txtJs .= "type: 'text',";
                $txtJs .= "label: 'Fecha: $txtFecha' ";
                $txtJs .= " } , {";
                $txtJs .= "type: 'text' , ";
                $txtJs .= "label: 'Valor: $valConcepto'  ";
                $txtJs .= " } ";
                $txtJs .= " ] } , ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= " ] } , ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ] } , ";
        $txtJs .= "] );";

        return $txtJs;
    }

}

?>
