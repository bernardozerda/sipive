<?php

include "../../contenidos/desembolso/plantillaEstudioTitulos.php";
include "../../contenidos/reportes/reporteEscrituracion.php";
include "../../contenidos/reportes/informeProyectoActo.php";
include "../../contenidos/reportes/reporteInformacionCvp.php";
ini_set('memory_limit', '1024M');

class Reportes {

    public $arrTablas;
    public $arrGraficas;
    public $arrErrores;
    public $arrSoluciones;
    public $arrDesembolsosEstudioOferta;
    public $arrDesembolsoEstudioTitulos;
    public $arrDesembolsoTramite;
    public $arrAsignado;
    public $arrPostuladosInhabilitados;
    public $arrPostulados;
    public $arrEnProcesoPostulacion;
    public $arrInscritos;
    public $arrGrupos;
    public $arrSeqFormularios;
    public $seqFormularios;

    public function Reportes() {
        $this->arrTablas = array();
        $this->arrGraficas = array();
        $this->arrErrores = array();
        $this->arrSoluciones = array();
        $this->arrDesembolsosEstudioOferta = array();
        $this->arrDesembolsoEstudioTitulos = array();
        $this->arrDesembolsoTramite = array();
        $this->arrAsignado = array();
        $this->arrPostuladosInhabilitados = array();
        $this->arrPostulados = array();
        $this->arrEnProcesoPostulacion = array();
        $this->arrInscritos = array();
        $this->arrGrupos = array();
        $this->arrSeqFormularios = array();
    }

// fin constructor de la clase

    public function crearListadoReportes() {


        $this->arrTablas['titulos'][] = "Listado Exportables";
        $this->arrTablas['titulos'][] = "";

        $textoForm = "";

        $datos = &$this->arrTablas['datos'];

        $datosFila = &$datos[];
        $datosFila[] = "Numero Id Repetido";
        $datosFila[] = $this->textoFormLinks("ReporteIdRepetido");

        $datosFila = &$datos[];
        $datosFila[] = "Cruzar Edad Tipo Documento vs Fecha Postulacion";
        $datosFila[] = $this->textoFormLinks("ReporteCruzarEdadTodFchPos");

        $datosFila = &$datos[];
        $datosFila[] = "Tipo Documento Pasaporte o Extranjeria";
        $datosFila[] = $this->textoFormLinks("ReporteTipoDocPasExt");

        $datosFila = &$datos[];
        $datosFila[] = "Verificar Condicion Mayor de Edad";
        $datosFila[] = $this->textoFormLinks("ReporteCondicionMayorEdad");

        $datosFila = &$datos[];
        $datosFila[] = "Verificar Ingresos vs Reglamento";
        $datosFila[] = $this->textoFormLinks("ReporteIngresosVsReglamento");

        $datosFila = &$datos[];
        $datosFila[] = "Verificar Direccion o Barrio en Soacha";
        $datosFila[] = $this->textoFormLinks("ReporteSoacha");

        $datosFila = &$datos[];
        $datosFila[] = "Verificar si son realmente Beneficiarios del Subsidio";
        $datosFila[] = $this->textoFormLinks("ReporteBeneficiariosSubsidio");

        $datosFila = &$datos[];
        $datosFila[] = "Verificar si son realmente Beneficiarios de Caja de Compensacion";
        $datosFila[] = $this->textoFormLinks("ReporteBeneficiariosCajaCompensacion");

        $datosFila = &$datos[];
        $datosFila[] = "Cruce tipo Solucion con Cierre Financiero (Verifica Hogares con Promesa CompraVenta)";
        $datosFila[] = $this->textoFormLinks("ReporteCierreFinancieroConPromesa");

        $datosFila = &$datos[];
        $datosFila[] = "VR Subsidio Mejoramiento";
        $datosFila[] = $this->textoFormLinks("ReporteVRSubsidioMejoramiento");

        $datosFila = &$datos[];
        $datosFila[] = "Verificar Modalidad, Solucion vs Subsidio";
        $datosFila[] = $this->textoFormLinks("ReporteVerificaModalidadSolucion");

        $datosFila = &$datos[];
        $datosFila[] = "Ahorro, Credito y/o Subsidio Nacional sin Soporte";
        $datosFila[] = $this->textoFormLinks("ReporteAhorroCreditoSoporte");

        $datosFila = &$datos[];
        $datosFila[] = "Nombres Miembros de Hogar";
        $datosFila[] = $this->textoFormLinks("ReporteMiembrosHogar");

        $datosFila = &$datos[];
        $datosFila[] = "Datos de Contacto";
        $datosFila[] = $this->textoFormLinks("ReporteDatosDeContacto");

        $datosFila = &$datos[];
        $datosFila[] = "Todos con Estado";
        $datosFila[] = $this->textoFormLinks("ReporteTodosConEstado");

        $datosFila = &$datos[];
        $datosFila[] = "Reporte General";
        $datosFila[] = $this->textoFormLinks("ReporteGeneral");

        $datosFila = &$datos[];
        $datosFila[] = "Reporte Analisis Poblacion";
        $datosFila[] = $this->textoFormLinks("ReporteAnalisisPoblacion");

        $datosFila = &$datos[];
        $datosFila[] = "Resumen SDV. Metrovivienda y SDHT";
        $datosFila[] = $this->textoFormLinks("ReporteResumenMetroSDHT", "./descargas/RESUMEN SUBSIDIOS JUL.xlsx");

        $datosFila = &$datos[];
        $datosFila[] = "Analisis programa SDV Marzo 2009-2010";
        $datosFila[] = $this->textoFormLinks("ReporteAnalisisPrograma", "./descargas/Resumen SUBSIDIOS DE SDV.xlsx");

        $arrFiltros = &$this->arrFiltros;

        $arrFiltros = array();

        $datosFila = &$arrFiltros[];
        $datosFila[] = "Cedulas";
        $datosFila[] = $this->formArchivo("fileSecuenciales");
    }

    public function exportableReporteFormsEliminados() {
        global $aptBd;

        try {

            $txtCondiciones = ($_POST['fchInicio'] != "") ? "AND bor.fchBorrado >= '" . $_POST['fchInicio'] . " 00:00:00'" : "";
            $txtCondiciones .= ($_POST['fchFin'] != "") ? "AND bor.fchBorrado <= '" . $_POST['fchFin'] . " 23:59:59'" : "";

            $sql = "
            SELECT
              bor.seqFormulario as Formulario,
              tdo.txtTipoDocumento as TipoDocumento,
              bor.numDocumento as Documento,
              UPPER( bor.txtNombre ) as Nombre,
              bor.fchBorrado as Fecha,
              bor.txtComentario as Comentario
            FROM T_FRM_BORRADO bor
            INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON bor.seqTipoDocumento = tdo.seqTipoDocumento
            WHERE 1 = 1
            $txtCondiciones
          ";
            $objRes = $aptBd->execute($sql);
            $this->obtenerReportesGeneral($objRes, "ReporteFormsEliminados");
        } catch (Exception $objError) {
            $arrErrores[] = "No se pudo obtener el reporte de formularios eliminados";
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteDatosDeContacto() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {

            $sql = "SELECT
                        frm.seqFormulario,
                        frm.txtFormulario,
                        ciu.numDocumento,
                        UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
                        if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
                        moa.txtModalidad,
                        sol.txtSolucion,
                        frm.txtDireccion,
                        frm.numCelular,
                        frm.numTelefono1,
                        frm.numTelefono2,
                        frm.txtCorreo
                        FROM 
                        T_FRM_FORMULARIO frm
                        INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
                        INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                        INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
                        INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
                        WHERE hog.seqParentesco = 1
                        AND frm.seqFormulario in (" . $this->seqFormularios . ")";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'txtModalidad';
                $arrTitulosCampos[] = 'txtSolucion';
                $arrTitulosCampos[] = 'txtDireccion';
                $arrTitulosCampos[] = 'numCelular';
                $arrTitulosCampos[] = 'numTelefono1';
                $arrTitulosCampos[] = 'numTelefono2';
                $arrTitulosCampos[] = 'CorreoElectronico';

                $this->obtenerReportesGeneral($objRes, "ReporteDatosDeContacto", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteAnalisisPoblacion() {
        global $aptBd;
        $arrErrores = &$this->arrErrores;
        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						tpv.txtTipoVictima AS TipoVictima,
						moa.txtModalidad AS Modalidad,
						CONCAT(sol.txtDescripcion, ' (',  sol.txtSolucion, ')') AS Solucion,
						locfrm.txtLocalidad AS Localidad,
						if(trim(frm.txtBarrio) = '', 'Desconocido', frm.txtBarrio) AS Barrio,
						locdes.txtLocalidad AS LocalidadDesembolso,
						if(trim(des.txtBarrio) = '', 'Desconocido', des.txtBarrio) AS BarrioDesembolso,
						if((trim(des.txtCompraVivienda) = '' or des.txtCompraVivienda is null), 'Ninguna', des.txtCompraVivienda) as TipoViviendaComprar,
						(
						  SELECT 
						  tdo1.txtTipoDocumento
						  FROM 
						  T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
						  INNER JOIN T_CIU_TIPO_DOCUMENTO tdo1 on ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS TipoDocumentoPPAL,
						(
						  SELECT 
						  ciu1.numDocumento
						  FROM 
						  T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS NumeroDocumentoPPAL,
						(
						  SELECT 
						  UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
						  FROM 
						  T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS NombrePPAL,
						(
						  SELECT 
						  tdo1.txtTipoDocumento
						  FROM  T_CIU_TIPO_DOCUMENTO tdo1
						  WHERE ciu.seqTipoDocumento = tdo1.seqTipoDocumento
						)AS TipoDocumento,
						ciu.numDocumento AS Documento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						sex.txtSexo AS Sexo,
						if(ciu.bolLgtb = 1, 'Si', 'No') AS LGBT,
						ces1.txtCondicionEspecial as CondicionEspecial1,
						ces2.txtCondicionEspecial as CondicionEspecial2,
						ces3.txtCondicionEspecial as CondicionEspecial3,
						ucwords( cabezaFamilia( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtCabezaFamilia,
						ucwords( mayor65anos( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtMayor65Anos,
						ucwords( discapacitado( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtDiscapacitado,
						ucwords( ningunaCondicionEspecial( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtNingunaCondicionEspecial,
						par.txtParentesco AS Parentesco,
						if( ciu.fchNacimiento is null or ciu.fchNacimiento <= '1900-01-01',null,ciu.fchNacimiento) AS FechaNacimiento,
						if( ciu.fchNacimiento is null or ciu.fchNacimiento <= '1900-01-01',null,FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365.2))) AS Edad,
						if( ciu.fchNacimiento is null or ciu.fchNacimiento <= '1900-01-01','Sin Clasificar',rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365.2)))) AS RangoEdad,
						etn.txtEtnia AS Etnia,
						(
							SELECT
								sum(dsol.valSolicitado)
							FROM T_DES_SOLICITUD dsol 
							WHERE
								frm.seqFormulario = des.seqFormulario AND 
								dsol.seqDesembolso = des.seqDesembolso
						) as ValorSolicitado
						FROM T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						LEFT JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
						LEFT JOIN T_CIU_SEXO sex ON ciu.seqSexo = sex.seqSexo
						LEFT JOIN T_FRM_TIPOVICTIMA tpv ON ciu.seqTipoVictima = tpv.seqTipoVictima
						LEFT JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
						LEFT JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
						LEFT JOIN T_CIU_ETNIA etn ON ciu.seqEtnia = etn.seqEtnia
						LEFT JOIN T_CIU_CONDICION_ESPECIAL ces1 ON ciu.seqCondicionEspecial = ces1.seqCondicionEspecial
						LEFT JOIN T_CIU_CONDICION_ESPECIAL ces2 ON ciu.seqCondicionEspecial2 = ces2.seqCondicionEspecial
						LEFT JOIN T_CIU_CONDICION_ESPECIAL ces3 ON ciu.seqCondicionEspecial3 = ces3.seqCondicionEspecial
						LEFT JOIN T_FRM_LOCALIDAD locfrm ON frm.seqLocalidad = locfrm.seqLocalidad
						LEFT JOIN T_DES_DESEMBOLSO des ON des.seqFormulario = frm.seqFormulario
						LEFT JOIN T_FRM_LOCALIDAD locdes ON des.seqLocalidad = locdes.seqLocalidad
						WHERE  frm.seqFormulario in (" . $this->seqFormularios . ")
					";
            try {
                //pr( $sql ); die( );
                $objRes = $aptBd->execute($sql);
                $arrReporte = array();

                // el calculo de fechas de mysql es impreciso
                // se ajusta el calculo con objetos php
                $fchHoy = new DateTime();
                while ($objRes->fields) {
                    $fchNacimiento = new DateTime($objRes->fields['FechaNacimiento']);
                    $fchDiferencia = date_diff($fchHoy, $fchNacimiento);
                    $objRes->fields['Edad'] = $fchDiferencia->y;
//                    $objRes->fields['RangoEdad'] = rangoEdad($objRes->fields['Edad']);
                    $arrReporte[] = $objRes->fields;
                    $objRes->MoveNext();
                }

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Tipo Victima';
                $arrTitulosCampos[] = 'Modalidad';
                $arrTitulosCampos[] = 'Solucion';
                $arrTitulosCampos[] = 'Localidad';
                $arrTitulosCampos[] = 'Barrio';
                $arrTitulosCampos[] = 'LocalidadDesembolso';
                $arrTitulosCampos[] = 'BarrioDesembolso';
                $arrTitulosCampos[] = 'TipoViviendaComprar';
                $arrTitulosCampos[] = 'TipoDocumentoPPAL';
                $arrTitulosCampos[] = 'NumeroDocumentoPPAL';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'Sexo';
                $arrTitulosCampos[] = 'LGBT';
                $arrTitulosCampos[] = 'CondicionEspecial1';
                $arrTitulosCampos[] = 'CondicionEspecial2';
                $arrTitulosCampos[] = 'CondicionEspecial3';
                $arrTitulosCampos[] = 'txtCabezaFamilia';
                $arrTitulosCampos[] = 'txtMayor65Anos';
                $arrTitulosCampos[] = 'txtDiscapacitado';
                $arrTitulosCampos[] = 'txtNingunaCondicionEspecial';
                $arrTitulosCampos[] = 'Parentesco';
                $arrTitulosCampos[] = 'FechaNacimiento';
                $arrTitulosCampos[] = 'Edad';
                $arrTitulosCampos[] = 'RangoEdad';
                $arrTitulosCampos[] = 'Etnia';

                $this->obtenerReportesGeneral($arrReporte, "ReporteAnalisisPoblacion", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteGeneral() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {

            $sql = "SELECT
						frm.seqFormulario,
						frm.txtFormulario,
                                                frm.fchVigencia as Vigencia_SDV,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						moa.txtModalidad,
						sol.txtDescripcion as DescripcionSolucion,
						sol.txtSolucion,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado,
						(
						  SELECT 
						   tdo.txtTipoDocumento
						   FROM T_FRM_HOGAR hog1
						   INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						   INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu1.seqTipoDocumento = tdo.seqTipoDocumento
						   WHERE hog1.seqFormulario = hog.seqFormulario AND hog1.seqParentesco = 1
						) AS TipoDocumentoPPAL,
						(
						  SELECT 
						    ciu1.numDocumento
						   FROM T_FRM_HOGAR hog1
						   INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						   WHERE hog1.seqFormulario = hog.seqFormulario AND hog1.seqParentesco = 1
						) AS DocumentoPPAL,
						(
						  SELECT 
						    UPPER( CONCAT( ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2 ) )
						    FROM T_FRM_HOGAR hog1 
						    INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						    WHERE hog1.seqFormulario = hog.seqFormulario AND hog1.seqParentesco = 1
						) AS NombrePPAL,
						(
						  SELECT 
						    tdo.txtTipoDocumento
						    FROM T_CIU_TIPO_DOCUMENTO tdo
						    WHERE tdo.seqTipoDocumento = ciu.seqTipoDocumento
						) as TipoDocumento,
						ciu.numDocumento,
						UPPER( CONCAT( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 ) ) as Nombre,
						par.txtParentesco,
						sex.txtSexo,
						etn.txtEtnia,
						(
						  SELECT
						  ces.txtCondicionEspecial
						  FROM 
						  T_CIU_CONDICION_ESPECIAL ces 
						  WHERE ciu.seqCondicionEspecial = ces.seqCondicionEspecial
						) as CondicionEspecial1,
						(
						  SELECT
						  ces.txtCondicionEspecial
						  FROM 
						  T_CIU_CONDICION_ESPECIAL ces 
						  WHERE ciu.seqCondicionEspecial2 = ces.seqCondicionEspecial
						) as CondicionEspecial2,
						(
						  SELECT
						  ces.txtCondicionEspecial
						  FROM 
						  T_CIU_CONDICION_ESPECIAL ces 
						  WHERE ciu.seqCondicionEspecial3 = ces.seqCondicionEspecial
						) as CondicionEspecial3,
						ned.txtNivelEducativo,
						sis.txtSisben,
						frm.numAdultosNucleo,
						frm.numNinosNucleo,
						(frm.numAdultosNucleo + frm.numNinosNucleo) as numMiembrosHogar,
						if(ciu.bolLgtb = 1, 'Si', 'No') AS LGBT,
						ocu.txtOcupacion,
						eci.txtEstadoCivil,
						frm.fchInscripcion,
						frm.fchPostulacion,
						frm.fchUltimaActualizacion,
						frm.valAspiraSubsidio,
						pat.txtPuntoAtencion,
						viv.txtVivienda,
						frm.valIngresoHogar,
						frm.valSaldoCuentaAhorro,
						(
						  SELECT ban.txtBanco
						  FROM T_FRM_BANCO ban
						  WHERE ban.seqBanco = frm.seqBancoCuentaAhorro
						) AS EntidadAhorro1,
						frm.valSaldoCuentaAhorro2,
						(
						  SELECT ban.txtBanco
						  FROM T_FRM_BANCO ban
						  WHERE ban.seqBanco = frm.seqBancoCuentaAhorro2
						) AS EntidadAhorro2,
						frm.valCredito,
						(
						  SELECT ban.txtBanco
						  FROM T_FRM_BANCO ban
						  WHERE ban.seqBanco = frm.seqBancoCredito
						) AS EntidadCredito,
						frm.valDonacion,
						(
						  SELECT edo.txtEmpresaDonante
						  FROM T_FRM_EMPRESA_DONANTE edo
						  WHERE edo.seqEmpresaDonante = frm.seqEmpresaDonante
						) as entidadDonante,
						(frm.valSaldoCuentaAhorro + frm.valSaldoCuentaAhorro2) as SumaAhorro,
						(frm.valSaldoCuentaAhorro + frm.valSaldoCuentaAhorro2 + frm.valSubsidioNacional + frm.valAporteLote + frm.valSaldoCesantias + frm.valAporteAvanceObra + frm.valAporteMateriales + frm.valCredito + frm.valDonacion) as SumaCierreFinanciero,
						frm.valArriendo,
						(
						  SELECT loc.txtLocalidad
						  FROM T_FRM_LOCALIDAD loc
						  WHERE loc.seqLocalidad = frm.seqLocalidad
						) as localidad,
						frm.txtBarrio,
						if(frm.bolIdentificada = 1, 'Si', 'No') AS IdetificadaSolSDHT,
						if(frm.bolViabilizada = 1, 'Si', 'No') AS PerteneceViaSDHT,
						des.txtNombreVendedor,
						(
						  SELECT loc.txtLocalidad
						  FROM T_FRM_LOCALIDAD loc
						  WHERE loc.seqLocalidad = des.seqLocalidad
						) as localidadSolucion,
						des.txtBarrio,
						if((trim(des.txtCompraVivienda) = '' or des.txtCompraVivienda is null), 'Ninguna', des.txtCompraVivienda) as TipoViviendaComprar,
						(
							SELECT
								sum(dsol.valSolicitado)
							FROM T_DES_SOLICITUD dsol 
							WHERE
								frm.seqFormulario = des.seqFormulario AND 
								dsol.seqDesembolso = des.seqDesembolso
						) as ValorSolicitado
						FROM T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu on hog.seqCiudadano = ciu.seqCiudadano
						left join T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
						left join T_CIU_SEXO sex on ciu.seqSexo = sex.seqSexo
						left join T_CIU_ETNIA etn on ciu.seqEtnia = etn.seqEtnia
						left join T_CIU_NIVEL_EDUCATIVO ned ON ciu.seqNivelEducativo = ned.seqNivelEducativo
						left join T_FRM_SISBEN sis on frm.seqSisben = sis.seqSisben
						left join T_CIU_OCUPACION ocu ON ciu.seqOcupacion = ocu.seqOcupacion
						left join T_CIU_ESTADO_CIVIL eci ON ciu.seqEstadoCivil = eci.seqEstadoCivil
						left JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						left join T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
						left join T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
						left join T_FRM_PUNTO_ATENCION pat ON frm.seqPuntoAtencion = pat.seqPuntoAtencion
						left join T_FRM_VIVIENDA viv on frm.seqVivienda = viv.seqVivienda
						left join T_DES_DESEMBOLSO des on des.seqFormulario = frm.seqFormulario
						WHERE  frm.seqFormulario in (" . $this->seqFormularios . ")
				";
            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'Vigencia SDV';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'txtModalidad';
                $arrTitulosCampos[] = 'DescripcionSolucion';
                $arrTitulosCampos[] = 'txtSolucion';
                $arrTitulosCampos[] = 'Cerrado';
                $arrTitulosCampos[] = 'TipoDocumentoPPAL';
                $arrTitulosCampos[] = 'DocumentoPPAL';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'txtParentesco';
                $arrTitulosCampos[] = 'txtSexo';
                $arrTitulosCampos[] = 'txtEtnia';
                $arrTitulosCampos[] = 'CondicionEspecial1';
                $arrTitulosCampos[] = 'CondicionEspecial2';
                $arrTitulosCampos[] = 'CondicionEspecial3';
                $arrTitulosCampos[] = 'txtNivelEducativo';
                $arrTitulosCampos[] = 'txtSisben';
                $arrTitulosCampos[] = 'numAdultosNucleo';
                $arrTitulosCampos[] = 'numNinosNucleo';
                $arrTitulosCampos[] = 'numMiembrosHogar';
                $arrTitulosCampos[] = 'LGBT';
                $arrTitulosCampos[] = 'txtOcupacion';
                $arrTitulosCampos[] = 'txtEstadoCivil';
                $arrTitulosCampos[] = 'fchInscripcion';
                $arrTitulosCampos[] = 'fchPostulacion';
                $arrTitulosCampos[] = 'fchUltimaActualizacion';
                $arrTitulosCampos[] = 'valAspiraSubsidio';
                $arrTitulosCampos[] = 'txtPuntoAtencion';
                $arrTitulosCampos[] = 'txtVivienda';
                $arrTitulosCampos[] = 'valIngresoHogar';
                $arrTitulosCampos[] = 'valSaldoCuentaAhorro';
                $arrTitulosCampos[] = 'EntidadAhorro1';
                $arrTitulosCampos[] = 'valSaldoCuentaAhorro2';
                $arrTitulosCampos[] = 'EntidadAhorro2';
                $arrTitulosCampos[] = 'valCredito';
                $arrTitulosCampos[] = 'EntidadCredito';
                $arrTitulosCampos[] = 'valDonacion';
                $arrTitulosCampos[] = 'entidadDonante';
                $arrTitulosCampos[] = 'SumaAhorro';
                $arrTitulosCampos[] = 'SumaCierreFinanciero';
                $arrTitulosCampos[] = 'valArriendo';
                $arrTitulosCampos[] = 'localidad';
                $arrTitulosCampos[] = 'txtBarrio';
                $arrTitulosCampos[] = 'IdetificadaSolSDHT';
                $arrTitulosCampos[] = 'PerteneceViaSDHT';
                $arrTitulosCampos[] = 'txtNombreVendedor';
                $arrTitulosCampos[] = 'localidadSolucion';
                $arrTitulosCampos[] = 'txtCompraVivienda';

                $this->obtenerReportesGeneral($objRes, "ReporteGeneral", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteMiembrosHogar() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {

            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						(
						 SELECT 
						   tdo1.txtTipoDocumento
						 FROM T_CIU_TIPO_DOCUMENTO tdo1
						 WHERE tdo1.seqTipoDocumento = ciu.seqTipoDocumento
						) AS tipoDocumento,
						ciu.numDocumento AS Documento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
						FROM T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						WHERE  frm.seqFormulario in (" . $this->seqFormularios . ")
				";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'tipoDocumento';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteMiembrosHogar", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteInscritosNoCC() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {

            $sql = "
						SELECT
							frm.seqFormulario,
							frm.txtFormulario,
							UPPER( CONCAT( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 ) ) as Nombre,
							ciu.numDocumento,
							tdo.txtTipoDocumento,
							moa.txtModalidad,
							CONCAT( eta.txtEtapa, ' - ', epr.txtEstadoProceso ) as EstadoProceso,
							frm.fchInscripcion,
							(
								SELECT
									seg.txtComentario
								FROM T_SEG_SEGUIMIENTO seg
								WHERE seg.seqFormulario = frm.seqFormulario
								ORDER BY seg.seqSeguimiento asc
							LIMIT 1
							) as UltimoSeguimiento,
							(
								SELECT
									seg.fchMovimiento
								FROM T_SEG_SEGUIMIENTO seg
								WHERE seg.seqFormulario = frm.seqFormulario
								ORDER BY seg.seqSeguimiento asc
								LIMIT 1
							) as FechaUltimoSeguimiento,
							UPPER( CONCAT( usu.txtNombre, ' ', usu.txtApellido ) ) as Usuario
						FROM T_FRM_FORMULARIO frm
							INNER JOIN T_FRM_HOGAR hog on hog.seqFormulario = frm.seqFormulario
							INNER JOIN T_CIU_CIUDADANO ciu on hog.seqCiudadano = ciu.seqCiudadano
							INNER JOIN T_FRM_MODALIDAD moa on frm.seqModalidad = moa.seqModalidad
							INNER JOIN T_FRM_ESTADO_PROCESO epr on frm.seqEstadoProceso = epr.seqEstadoProceso
							INNER JOIN T_FRM_ETAPA eta on epr.seqEtapa = eta.seqEtapa
							INNER JOIN T_COR_USUARIO usu on usu.seqUsuario = frm.seqUsuario
							INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
						WHERE hog.seqParentesco = 1
							AND ciu.seqTipoDocumento NOT IN (1,2)
					";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'txtTipoDocumento';
                $arrTitulosCampos[] = 'txtModalidad';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'fchInscripcion';
                $arrTitulosCampos[] = 'UltimoSeguimiento';
                $arrTitulosCampos[] = 'FechaUltimoSeguimiento';
                $arrTitulosCampos[] = 'Usuario';

                $this->obtenerReportesGeneral($objRes, "ReporteInscritosNoCC", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteAhorroCreditoSoporte() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
                    frm.seqFormulario,
                    frm.txtFormulario,
                    ciu.numDocumento,
                    moa.txtModalidad,
                    sol.txtSolucion,
                    UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
                    (
                      SELECT 
                      ban.txtBanco
                      FROM T_FRM_BANCO ban
                      WHERE ban.seqBanco = frm.seqBancoCuentaAhorro
                    ) AS Ahorro1,
                    frm.txtSoporteCuentaAhorro,
                    (
                      SELECT 
                      ban.txtBanco
                      FROM T_FRM_BANCO ban
                      WHERE ban.seqBanco = frm.seqBancoCuentaAhorro2
                    ) AS Ahorro2,
                    frm.txtSoporteCuentaAhorro2,
                    (
                      SELECT 
                      ban.txtBanco
                      FROM T_FRM_BANCO ban
                      WHERE ban.seqBanco = frm.seqBancoCredito
                    ) AS Credito,
                    frm.txtSoporteCredito,
                    frm.valSubsidioNacional,
                    frm.txtSoporteSubsidioNacional,
                    (
                      SELECT 
                      CONCAT(eta.txtEtapa, ' - ', epr.txtEstadoProceso)
                      FROM T_FRM_ETAPA eta 
                      INNER JOIN T_FRM_ESTADO_PROCESO epr ON epr.seqEtapa = eta.seqEtapa
                      WHERE frm.seqEstadoProceso = epr.seqEstadoProceso
                    ) AS EstadoProceso,
                    if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
                    if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
                    FROM T_FRM_FORMULARIO frm
                    INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
                    INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                    INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
    INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
             WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND
                            hog.seqParentesco = 1
                   AND((frm.seqBancoCuentaAhorro <> 1 AND ( frm.txtSoporteCuentaAhorro = '' or frm.txtSoporteCuentaAhorro is null) )
                            OR(frm.seqBancoCuentaAhorro2 <> 1 AND ( frm.txtSoporteCuentaAhorro2 = '' or frm.txtSoporteCuentaAhorro2 is null ) )
                            OR(frm.seqBancoCredito <> 1 AND ( frm.txtSoporteCredito = '' or frm.txtSoporteCredito is null ))
                            OR(frm.valSubsidioNacional > 0 and ( frm.txtSoporteSubsidioNacional = '' or frm.txtSoporteSubsidioNacional is null ))) 
            ";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'Ahorro1';
                $arrTitulosCampos[] = 'txtSoporteCuentaAhorro';
                $arrTitulosCampos[] = 'Ahorro2';
                $arrTitulosCampos[] = 'txtSoporteCuentaAhorro2';
                $arrTitulosCampos[] = 'Credito';
                $arrTitulosCampos[] = 'txtSoporteCredito';
                $arrTitulosCampos[] = 'valSubsidioNacional';
                $arrTitulosCampos[] = 'txtSoporteSubsidioNacional';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteAhorroCreditoSoporte", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteVerificaModalidadSolucion() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {

            $sql = "SELECT 
                    frm.seqFormulario,
                    frm.txtFormulario,
                    (
                      SELECT 
                      UPPER( CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2) )
                      FROM T_CIU_CIUDADANO ciu
                      WHERE hog.seqCiudadano = ciu.seqCiudadano
                    ) AS NombrePPAL,
                    (
                      SELECT 
                      ciu.numDocumento 
                      FROM T_CIU_CIUDADANO ciu
                      WHERE hog.seqCiudadano = ciu.seqCiudadano
                    ) AS Documento,
                    (
                      SELECT 
                      CONCAT(eta.txtEtapa, ' - ', epr.txtEstadoProceso) 
                      FROM T_FRM_ETAPA eta 
                      INNER JOIN T_FRM_ESTADO_PROCESO epr ON epr.seqEtapa = eta.seqEtapa
                      WHERE frm.seqEstadoProceso = epr.seqEstadoProceso
                    ) AS EstadoProceso,
                    if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
                    moa.txtModalidad,
                    sol.txtDescripcion,
                    frm.valAspiraSubsidio,
                    vsu.valSubsidio,
                    frm.txtSoporteSubsidio
                    FROM
                    T_FRM_FORMULARIO frm
                    INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
                    INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
                    INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
                    INNER JOIN T_FRM_VALOR_SUBSIDIO vsu ON ( vsu.seqModalidad = frm.seqModalidad AND vsu.seqSolucion = frm.seqSolucion )
                    WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND 
                    frm.valAspiraSubsidio <= vsu.valSubsidio AND hog.seqParentesco = 1
                 ";


            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Modalidad';
                $arrTitulosCampos[] = 'Solucion';
                $arrTitulosCampos[] = 'valAspiraSubsidio';
                $arrTitulosCampos[] = 'valSubsidio';
                $arrTitulosCampos[] = 'txtSoporteSubsidio';

                $this->obtenerReportesGeneral($objRes, "ReporteVerificaModalidadSolucion", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteTodosConEstado() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {

            $sql = "SELECT 
                                            frm.seqFormulario,
                                            frm.txtFormulario,
                                            ciu.numDocumento,
                                            UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
                                            par.txtParentesco AS Parentesco,
                                            if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
                                            moa.txtModalidad,
                                            sol.txtSolucion,
                                            CONCAT(eta.txtEtapa, ' - ', epr.txtEstadoProceso) AS EstadoProceso,
                                            if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
                                            FROM 
                                            T_FRM_FORMULARIO frm
                                            INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
                                            INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                                            INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
                                            INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
                                            INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
                                            INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
                                            INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
                                            WHERE frm.seqFormulario in (" . $this->seqFormularios . ")
                            ";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'Parentesco';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Modalidad';
                $arrTitulosCampos[] = 'Solucion';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteTodosConEstado", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteVRSubsidioMejoramiento() {

        global $aptBd;
        global $arrConfiguracion;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						ciu.numDocumento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						moa.txtModalidad,
						CONCAT(sol.txtDescripcion, '( ', sol.txtSolucion, ' )') AS Solucion,
						frm.valAvaluo,
						frm.valPresupuesto,
						frm.valTotal,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
						INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
					 	WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND  
							hog.seqParentesco = 1
					       AND frm.seqModalidad IN (3, 4)
					       AND frm.valTotal > (" . $arrConfiguracion['constantes']['salarioMinimo'] . " * 70)
						";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'txtModalidad';
                $arrTitulosCampos[] = 'Solucion';
                $arrTitulosCampos[] = 'valAvaluo';
                $arrTitulosCampos[] = 'valPresupuesto';
                $arrTitulosCampos[] = 'valTotal';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteVRSubsidioMejoramiento", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    /*
     * 
     *  TOCA CUADRAR BIEN EL QUERY
     * 
     */

    public function exportableReporteCierreFinancieroConPromesa() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						ciu.numDocumento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						moa.txtModalidad,
						CONCAT(sol.txtDescripcion, ' ( ', sol.txtSolucion, ' )') AS Solucion,
						if(frm.bolPromesaFirmada = 1, 'Si', 'No') AS PromesaFirmada,
						CONCAT(eta.txtEtapa, ' - ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado,
						frm.valTotalRecursos,
						frm.seqModalidad as modalidad, 
						frm.seqSolucion as solucion,
						frm.txtSoporteSubsidio
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
						INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND hog.seqParentesco = 1
					";
//				pr( $sql );die( );

            try {

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'Modalidad';
                $arrTitulosCampos[] = 'Solucion';
                $arrTitulosCampos[] = 'PromesaFirmada';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';
                $arrTitulosCampos[] = 'valTotalRecursos';
                $arrTitulosCampos[] = 'ValCierreFinanciero';
                $arrTitulosCampos[] = 'txtSoporteSubsidio';

                $objRes = $aptBd->execute($sql);
                $arrResultado = array();
                while ($objRes->fields) {
                    $valCierreFinanciero = $this->valorCierreFinanciero($objRes->fields['modalidad'], $objRes->fields['solucion']);
                    unset($objRes->fields['modalidad']);
                    unset($objRes->fields['solucion']);
                    if ($objRes->fields['modalidad'] != 5) {
                        if ($objRes->fields['valTotalRecursos'] < $valCierreFinanciero) {
                            $arrResultado[] = $objRes->fields;
                        }
                    } else {
                        if ($objRes->fields['valTotalRecursos'] > $valCierreFinanciero) {
                            $arrResultado[] = $objRes->fields;
                        }
                    }
                    $objRes->MoveNext();
                }

                $this->obtenerReportesGeneral($arrResultado, "ReporteCierreFinancieroConPromesa", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteBeneficiariosCajaCompensacion() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						moa.txtModalidad,
						(
						  SELECT 
						  tdo1.txtTipoDocumento
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  INNER JOIN T_CIU_TIPO_DOCUMENTO tdo1 ON ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS TipoDocumentoPPAL,
						(
						  SELECT 
						  ciu1.numDocumento
						  FROM T_FRM_HOGAR hog1 
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario 
						  AND hog1.seqParentesco = 1
						) AS DocumentoPPAL,
						(
						  SELECT 
						  UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
						  FROM T_FRM_HOGAR hog1 
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS NombrePPAL,
						(
						  SELECT 
						  tdo1.txtTipoDocumento
						  FROM T_CIU_TIPO_DOCUMENTO tdo1
						  WHERE tdo1.seqTipoDocumento = ciu.seqTipoDocumento
						) AS TipoDocumento,
						ciu.numDocumento AS Documento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						par.txtParentesco,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
						INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
					 	WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND
							 ciu.seqCajaCompensacion <> 1
					";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'txtModalidad';
                $arrTitulosCampos[] = 'TipoDocumentoPPAL';
                $arrTitulosCampos[] = 'DocumentoPPAL';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'txtParentesco';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteBeneficiariosCajaCompensacion", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteBeneficiariosSubsidio() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						moa.txtModalidad,
						(
						  SELECT 
						  tdo1.txtTipoDocumento
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  INNER JOIN T_CIU_TIPO_DOCUMENTO tdo1 ON ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS TipoDocumentoPPAL,
						(
						  SELECT 
						  ciu1.numDocumento
						  FROM T_FRM_HOGAR hog1 
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS DocumentoPPAL,
						(
						  SELECT 
						  UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
						  FROM T_FRM_HOGAR hog1 
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS NombrePPAL,
						(
						  SELECT 
						  tdo1.txtTipoDocumento
						  FROM T_CIU_TIPO_DOCUMENTO tdo1 
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON ciu1.seqTipoDocumento = tdo1.seqTipoDocumento
						  WHERE ciu1.seqCiudadano = ciu.seqCiudadano 
						) AS TipoDocumento,
						ciu.numDocumento AS Documento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						par.txtParentesco,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
						INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
						WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND 
							ciu.bolBeneficiario = 1
							AND frm.bolCerrado = 1
					";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'txtModalidad';
                $arrTitulosCampos[] = 'TipoDocumentoPPAL';
                $arrTitulosCampos[] = 'DocumentoPPAL';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'txtParentesco';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteBeneficiariosSubsidio", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteIngresosVsReglamento() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						ciu.numDocumento,
						frm.valIngresoHogar,
						frm.valAspiraSubsidio,
						moa.txtModalidad,
						CONCAT(sol.txtDescripcion, '( ', sol.txtSolucion, ' )') AS Solucion,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
						INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
						WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND
						hog.seqParentesco = 1 
						AND frm.valIngresoHogar > salarioReglamento(frm.seqSolucion)
					";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'valIngresoHogar';
                $arrTitulosCampos[] = 'valSubsidio';
                $arrTitulosCampos[] = 'Modalidad';
                $arrTitulosCampos[] = 'Solucion';
                $arrTitulosCampos[] = 'Desplazado';

                $this->obtenerReportesGeneral($objRes, "ReporteIngresosVsReglamento", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteCondicionMayorEdad() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						(
						  SELECT 
						  tdo.txtTipoDocumento
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu1.seqTipoDocumento = tdo.seqTipoDocumento
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS TipoDocumentoPPAL,
						(
						  SELECT 
						  ciu1.numDocumento
						  FROM 
						  T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS DocumentoPPAL,
						(
						  SELECT 
						  UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 on hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						) AS NombrePPAL,
						(
						  SELECT 
						  tod.txtTipoDocumento
						  FROM T_CIU_CIUDADANO ciu1 
						  INNER JOIN T_CIU_TIPO_DOCUMENTO tod ON ciu1.seqTipoDocumento = tod.seqTipoDocumento
						  WHERE ciu1.seqCiudadano = ciu.seqCiudadano 
						) AS TipoDocumento,
						ciu.numDocumento AS Documento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						ce1.txtCondicionEspecial AS CondicionEspecial1,
						ce2.txtCondicionEspecial AS CondicionEspecial2,
						ce3.txtCondicionEspecial AS CondicionEspecial3,
						frm.fchPostulacion,
						ADDDATE(ciu.fchNacimiento, INTERVAL 65 YEAR) AS fchTerceraEdad,
						ciu.fchNacimiento,
						if(SUBDATE(frm.fchPostulacion, INTERVAL 65 YEAR) >= ciu.fchNacimiento, 'Si', 'No') AS TerceraEdad,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						INNER JOIN T_CIU_CONDICION_ESPECIAL ce1 ON ciu.seqCondicionEspecial = ce1.seqCondicionEspecial
						INNER JOIN T_CIU_CONDICION_ESPECIAL ce2 ON ciu.seqCondicionEspecial2 = ce2.seqCondicionEspecial
						INNER JOIN T_CIU_CONDICION_ESPECIAL ce3 ON ciu.seqCondicionEspecial3 = ce3.seqCondicionEspecial
						WHERE frm.seqFormulario in (" . $this->seqFormularios . ")
						AND (
						(  
			              (
			                ciu.seqCondicionEspecial = 2
			                OR ciu.seqCondicionEspecial2 = 2
			                OR ciu.seqCondicionEspecial3 = 2
			              ) AND ADDDATE(ciu.fchNacimiento, INTERVAL 65 YEAR) > frm.fchPostulacion
			            ) OR 
			            (
			              (
			                ciu.seqCondicionEspecial <> 2
			                AND ciu.seqCondicionEspecial2 <> 2
			                AND ciu.seqCondicionEspecial3 <> 2
			              ) AND ADDDATE(ciu.fchNacimiento, INTERVAL 65 YEAR) <= frm.fchPostulacion
			            )
						)
					";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'TipoDocumentoPPAL';
                $arrTitulosCampos[] = 'DocumentoPPAL';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'CondicionEspecial1';
                $arrTitulosCampos[] = 'CondicionEspecial2';
                $arrTitulosCampos[] = 'CondicionEspecial3';
                $arrTitulosCampos[] = 'fchPostulacion';
                $arrTitulosCampos[] = 'fchTerceraEdad';
                $arrTitulosCampos[] = 'fchNacimiento';
                $arrTitulosCampos[] = 'TerceraEdad';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $this->obtenerReportesGeneral($objRes, "ReporteCondicionMayorEdad", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteIdRepetido() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;
        $arrNumDocumento = array();

        if (empty($arrErrores)) {

            $sql = "SELECT 
						ciu.numDocumento
						FROM 
						T_FRM_HOGAR hog
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						WHERE hog.seqFormulario in (" . $this->seqFormularios . ") 
						GROUP BY ciu.numDocumento
						HAVING count(ciu.numDocumento) > 1
					";
            try {
                $objRes = $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (empty($arrErrores)) {

                while ($objRes->fields) {
                    $arrNumDocumento[] = $objRes->fields['numDocumento'];
                    $objRes->MoveNext();
                }

                $arrNumDocumento = (empty($arrNumDocumento)) ? "null" :
                        implode($arrNumDocumento, ",");

                $sql = "SELECT 
							DISTINCT hog.seqFormulario
							FROM 
							T_FRM_HOGAR hog 
							INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
							WHERE ciu.numDocumento IN (" . $arrNumDocumento . ")
						";

                try {
                    $objRes = $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "Se ha producido un error al consultar los datos";
                }

                if (empty($arrErrores)) {

                    $arrSeqFormularios = array();
                    while ($objRes->fields) {
                        $arrSeqFormularios[] = $objRes->fields['seqFormulario'];
                        $objRes->MoveNext();
                    }
                    $arrSeqFormularios = (empty($arrSeqFormularios)) ? "null" :
                            implode($arrSeqFormularios, ",");


                    $sql = "SELECT 
								frm.seqFormulario,
								frm.txtFormulario,
								(
								  SELECT 
								  ciu1.numDocumento
								  FROM T_FRM_HOGAR hog1 
								  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
								  WHERE hog1.seqFormulario = frm.seqFormulario
								  AND hog1.seqParentesco = 1
								) AS DocumentoPPAL,
								(
								  SELECT 
								  UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
								  FROM 
								  T_FRM_HOGAR hog1 
								  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
								  WHERE hog1.seqFormulario = frm.seqFormulario
								  AND hog1.seqParentesco = 1
								) AS NombrePPAL,
								(
								  SELECT 
								  tod.txtTipoDocumento
								  FROM T_CIU_TIPO_DOCUMENTO tod
								  WHERE ciu.seqTipoDocumento = tod.seqTipoDocumento
								) AS TipoDocumento,
								ciu.numDocumento AS Documento,
								UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
								CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
								if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado
								FROM 
								T_FRM_FORMULARIO frm
								INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
								INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
								INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
								INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
								WHERE frm.seqFormulario IN (" . $arrSeqFormularios . ") 
								AND ciu.numDocumento in (" . $arrNumDocumento . ")
							";

                    try {
                        $objRes = $aptBd->execute($sql);
                        $arrTitulosCampos[] = 'seqFormulario';
                        $arrTitulosCampos[] = 'txtFormulario';
                        $arrTitulosCampos[] = 'DocumentoPPAL';
                        $arrTitulosCampos[] = 'NombrePPAL';
                        $arrTitulosCampos[] = 'TipoDocumento';
                        $arrTitulosCampos[] = 'Documento';
                        $arrTitulosCampos[] = 'Nombre';
                        $arrTitulosCampos[] = 'EstadoProceso';
                        $arrTitulosCampos[] = 'Desplazado';

                        $this->obtenerReportesGeneral($objRes, "ReporteIdRepetido", $arrTitulosCampos);
                    } catch (Exception $objError) {
                        $arrErrores[] = "Se ha producido un error al consultar los datos";
                    }
                    if (!empty($arrErrores)) {
                        imprimirMensajes($arrErrores, array());
                    }
                } else { //ERROR SQL PARA OBTENER seqFormulario DE LOS DOCUMENTOS
                    imprimirMensajes($arrErrores, array());
                }
            } else { // ERROR SQL PARA OBTENER DOCUMENTOS REPETIDAS
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteSoacha() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						frm.txtFormulario,
						ciu.numDocumento,
						UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						frm.txtDireccion,
						frm.txtBarrio,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						WHERE frm.seqFormulario in (" . $this->seqFormularios . ") AND 
						hog.seqParentesco = 1 
						AND frm.bolCerrado = 1
						AND( frm.txtDireccion LIKE '%soacha%' OR frm.txtBarrio LIKE '%soacha%' )
					";

            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'txtDireccion';
                $arrTitulosCampos[] = 'txtBarrio';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';


                $this->obtenerReportesGeneral($objRes, "ReporteSoacha", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteTipoDocPasExt() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT 
						frm.seqFormulario,
						(
						  SELECT 
						  tdo.txtTipoDocumento
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu1.seqTipoDocumento = tdo.seqTipoDocumento
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1
						)AS TipoDocumentoPPAL,
						(
						  SELECT 
						  ciu1.numDocumento
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1 
						) AS DocumentoPPAL,
						(
						  SELECT 
						  UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
						  FROM T_FRM_HOGAR hog1
						  INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
						  WHERE hog1.seqFormulario = hog.seqFormulario
						  AND hog1.seqParentesco = 1 
						) AS NombrePPAL,
						(
						  SELECT 
						  tod.txtTipoDocumento
						  FROM T_CIU_TIPO_DOCUMENTO tod
						  WHERE ciu.seqTipoDocumento = tod.seqTipoDocumento 
						) AS TipoDocumento,
						ciu.numDocumento AS Documento,
						UPPER(CONCAT(ciu.txtNombre1, ' - ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS Nombre,
						CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS EstadoProceso,
						if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado
						FROM 
						T_FRM_FORMULARIO frm
						INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
						INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
						WHERE frm.seqFormulario in (" . $this->seqFormularios . ")
						AND ciu.seqTipoDocumento IN (2, 5)
					";
            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'TipoDocumentoPPAL';
                $arrTitulosCampos[] = 'DocumentoPPAL';
                $arrTitulosCampos[] = 'NombrePPAL';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'Documento';
                $arrTitulosCampos[] = 'Nombre';
                $arrTitulosCampos[] = 'EstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';


                $this->obtenerReportesGeneral($objRes, "ReporteTipoDocPasExt", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function obtenerJsReporteador($objRes, $arrTitulosCampos) {

        $txtJs = "var objReporteador = { ";
        $txtJs .= "datos: [";
        while ($objRes->fields) {
            $txtJs .= "{";
            foreach ($objRes->fields as $txtTitulo => $txtDato) {
                $txtDato = $txtDato;
                $txtTitulo = ereg_replace(" +", "", $txtTitulo);
                $txtJs .= "$txtTitulo:'$txtDato', ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= "}, ";
            $objRes->MoveNext();
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " ], ";
        $txtJs .= "titulos: [";
        foreach ($arrTitulosCampos as $txtTitulo) {
            $txtTitulo = ereg_replace(" +", "", $txtTitulo);
            $txtTitulo = utf8_decode($txtTitulo);
            $txtJs .= "'$txtTitulo', ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= "] ";
        $txtJs .= " }; ";
        return $txtJs;
    }

    public function obtenerReportesGeneralReporteador($objRes, $nombreArchivo) {
        $this->arrErrores = array();
        $this->obtenerReportesGeneral($objRes, $nombreArchivo);
        return;
    }

    /**
     * FUNCION GENERICA PARA LA IMPRESION DE REPORTES POR ARCHIVO
     * @param $objRes ==> PUEDE SER UN RESULSET DE ADODB O ARRAY
     * @param $nombreArchivo
     * @param array $arrTitulosCampos
     * @param bool $bolTitulos
     * @param string $txtSeparador
     * @return bool
     */
    public function obtenerReportesGeneral($objRes, $nombreArchivo, $arrTitulosCampos = array(), $bolTitulos = true, $txtSeparador = "\t") {

        // asegura que la variable de titulos quede boolean
        $bolTitulos = ($bolTitulos !== false) ? true : false;

        // separador por defecto tabulador
        $txtSeparador = ($txtSeparador == null) ? "\t" : $txtSeparador;

        // si no hay errores continual
        if (empty($this->arrErrores)) {

            // nombre del archivo
            $txtNombreArchivo = $nombreArchivo . date("Ymd_His") . ".xls";

            // cambiando headers
            header("Content-disposition: attachment; filename=$txtNombreArchivo");
            header("Content-Type: application/force-download");
            header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 1");

            // si es un resultset (else array)
            if (is_object($objRes)) {

                // debe ir con titulos
                if ($bolTitulos == true) {

                    // si no hay arreglo de titulos
                    if (empty($arrTitulosCampos)) {
                        $arrTitulosCampos = array_keys($objRes->fields);
                    }

                    // echo de titulos
                    echo utf8_decode(implode($txtSeparador, $arrTitulosCampos)) . "\r\n";
                }

                // echo contenidos
                while ($objRes->fields) {
                    $dato = (utf8_decode(implode($txtSeparador, preg_replace("/\s+/", " ", $objRes->fields))));
                    $dato = str_replace('&nbsp;', ' ', $dato); // Reemplaza caracter por espacios
                    $dato = str_replace('<b>', '', $dato); // Reemplaza caracter por espacios
                    $dato = str_replace('</b>', '', $dato); // Reemplaza caracter por espacios
                    $dato = str_replace('<br>', ';', $dato); // Reemplaza caracter por espacios
                    $dato = str_replace('<br />', ';', $dato); // Reemplaza caracter por espacios
                    echo $dato . "\r\n";
                    $objRes->MoveNext();
                }
            } else {

                // debe ir con titulos
                if ($bolTitulos == true) {

                    // si no hay arreglo de titulos
                    if (empty($arrTitulosCampos)) {
                        foreach ($objRes as $i => $arrPrimero) {
                            $arrTitulosCampos = array_keys($arrPrimero);
                            break;
                        }
                    }

                    // echo de titulos
                    echo utf8_decode(implode($txtSeparador, $arrTitulosCampos)) . "\r\n";
                }

                // contenido del archivo
                foreach ($objRes as $arrDatos) {
                    echo utf8_decode(implode($txtSeparador, $arrDatos)) . "\r\n";
                }
            }
        } else {
            imprimirMensajes($this->arrErrores);
        }

//        if ($this) {
//            $arrErrores = $this->arrErrores;
//        } else {
//            $arrErrores = array();
//        }
//
//        if (empty($arrErrores)) {
//
//            $txtNombreArchivo = $nombreArchivo . date("Ymd_His") . ".xls";
//
//            header("Content-disposition: attachment; filename=$txtNombreArchivo");
//            header("Content-Type: application/force-download");
//            header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
//            header("Content-Transfer-Encoding: binary");
//            header("Pragma: no-cache");
//            header("Expires: 1");
//
//            // si es el objeto ResultSet
//            if (is_object($objRes)) {
//                if (!empty($objRes->fields)) {
//                    echo utf8_decode(implode("\t", array_keys($objRes->fields))) . "\r\n";
//                } else {
//                    foreach ($arrTitulosCampos as $txtTitulo) {
//                        echo utf8_decode($txtTitulo) . "\t";
//                    }
//                    echo "\r\n";
//                }
//
//
//                while ($objRes->fields) {
//                    $dato = (utf8_decode(implode($txtSeparador, preg_replace("/\s+/", " ", $objRes->fields))));
//                    $dato = str_replace('&nbsp;', ' ', $dato); // Reemplaza caracter por espacios
//                    $dato = str_replace('<b>', '', $dato); // Reemplaza caracter por espacios
//                    $dato = str_replace('</b>', '', $dato); // Reemplaza caracter por espacios
//                    $dato = str_replace('<br>', ';', $dato); // Reemplaza caracter por espacios
//                    echo $dato . "\r\n";
//                    $objRes->MoveNext();
//                }
//
//                // Si es un arreglo
//            } elseif (is_array($objRes)) {
//
//                if (!empty($objRes)) {
//                    if (!empty($arrTitulosCampos)) {
//                        echo utf8_decode(implode($txtSeparador, array_keys($objRes[0]))) . "\r\n";
//                    }
//                } else {
//                    if (!empty($arrTitulosCampos)) {
//                        foreach ($arrTitulosCampos as $txtTitulo) {
//                            echo utf8_decode($txtTitulo) . $txtSeparador;
//                        }
//                        echo "\r\n";
//                    }
//                }
//
//                foreach ($objRes as $arrDatos) {
//                    echo utf8_decode(implode($txtSeparador, $arrDatos)) . "\r\n";
//                }
//            }
//        } else {
//            imprimirMensajes($arrErrores, array());
//        }
    }

    private function textoFormLinks($idForm, $txtNombreArchivo = "") {

        if ($txtNombreArchivo == "") {
            $txtForm = "<a onclick = \"someterFormulario( 'mensajes', document.formFiltros , 
								'./contenidos/reportes/ReportesExportables.php?reporte=$idForm', true, false );\" 
								href='#'>Exportable</a>
						";
        } else {
            $txtForm = "<a id='$idForm' href='$txtNombreArchivo'>Exportable</a>";
        }


        return $txtForm;
    }

    public function consolidadoPrograma() {

        global $aptBd;
        $arrErrores = array();

        $sql = "SELECT 
                    est.seqEstadoProceso,
                    if(frm.bolDesplazado = 1, 'Desplazado', 'Independiente') AS Grupo,
                    frm.bolCerrado,
                    -- CONCAT(eta.txtEtapa, ' - ', est.txtEstadoProceso) AS estadoProceso,
                    count(1) AS cuenta
                    FROM 
                    T_FRM_FORMULARIO frm
                    INNER JOIN T_FRM_ESTADO_PROCESO est ON frm.seqEstadoProceso = est.seqEstadoProceso
                    INNER JOIN T_FRM_ETAPA eta ON est.seqEtapa = eta.seqEtapa
                    GROUP BY 1, 2, 3
                    ORDER BY 1, 2 desc";

        try {

            $objRes = $aptBd->execute($sql);

            $valPostuladoCosecha = 7;
            $valPostuladoInhabilitado = 8;
            $arrConsolidadoPrograma = &$this->arrTablas["datos"];

            $this->arrTablas['titulos'][] = "Consolidado Historico";
            $this->arrTablas['titulos'][] = "Independiente";
            $this->arrTablas['titulos'][] = "Desplazado";
            $this->arrTablas['titulos'][] = "Total Hogares";

            $arrDesembolso = array(
                32, //Desembolso - Parcial
                33  //Desembolso - Total
            );

            $arrAsignados = array(
                15,
                16,
                17,
                18,
                20,
                21,
                19,
                22,
                24,
                26,
                27,
                28,
                29,
                30,
                32,
                33
            );

            $arrPostulados = array(8,
                14,
                9,
                15,
                16,
                17,
                18,
                20,
                21,
                19,
                22,
                24,
                26,
                27,
                28,
                29,
                30,
                32,
                33
            );

            $arrProcesoPostulacion = array(5,
                6,
                7
            );

            $arrInscritos = array(
                10, //Inscripcion - Call Center (Opción Cierre)
                11, //Inscripcion - Call Center (Sin Cierre)
                12, //Inscripcion - Call Center (Recursos Cero)
                1, //Inscripcion - Inscrito
                13  //Inscripcion - Renuncia
            );

            $arrConsolidadoPrograma = array();
            $arrConsolidadoPrograma["Inscritos"] = array();
            $arrConsolidadoPrograma["Asignados"] = array();
            $arrConsolidadoPrograma["En Inscripcion"] = array();
            $arrConsolidadoPrograma["Proceso Postulacion"] = array();
            $arrConsolidadoPrograma["Postulados"] = array();
            $arrConsolidadoPrograma["Postulados Inhabilitados"] = array();
            $arrConsolidadoPrograma["Desembolso"] = array();

            $arrDatosGrafica = array();

            while ($objRes->fields) {

                $grupo = $objRes->fields["Grupo"];

                $arrConsolidadoPrograma["Inscritos"]["estadoProceso"] = "Inscritos";
                $arrConsolidadoPrograma["Inscritos"]["Independiente"] += $grupo ? $objRes->fields["cuenta"] : 0;
                $arrConsolidadoPrograma["Inscritos"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                $arrConsolidadoPrograma["Inscritos"]["Total"] += $objRes->fields["cuenta"];

                $arrDatosGrafica["Inscritos - $grupo"] += $objRes->fields["cuenta"];

                if (in_array($objRes->fields["seqEstadoProceso"], $arrAsignados)) {
                    $arrConsolidadoPrograma["Asignados"]["estadoProceso"] = "Asignados";
                    $arrConsolidadoPrograma["Asignados"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Asignados"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Asignados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Asignados - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrInscritos)) {
                    $arrConsolidadoPrograma["En Inscripcion"]["estadoProceso"] = "En Inscripcion";
                    $arrConsolidadoPrograma["En Inscripcion"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["En Inscripcion"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["En Inscripcion"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["En Inscripcion - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrPostulados)) {
                    $arrConsolidadoPrograma["Postulados"]["estadoProceso"] = "Postulados";
                    $arrConsolidadoPrograma["Postulados"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Postulados - $grupo"] += $objRes->fields["cuenta"];
                }

                if ($objRes->fields["seqEstadoProceso"] == $valPostuladoCosecha && $objRes->fields["bolCerrado"] == 1) {
                    $arrConsolidadoPrograma["Postulados"]["estadoProceso"] = "Postulados";
                    $arrConsolidadoPrograma["Postulados"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Postulados - $grupo"] += $objRes->fields["cuenta"];
                }

                if ($objRes->fields["seqEstadoProceso"] == $valPostuladoInhabilitado) {
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["estadoProceso"] = "Postulados Inhabilitados";
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Postulados Inhabilitados - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrDesembolso)) {
                    $arrConsolidadoPrograma["Desembolso"]["estadoProceso"] = "En Desembolso";
                    $arrConsolidadoPrograma["Desembolso"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Desembolso"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Desembolso"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Desembolso - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrProcesoPostulacion) && $objRes->fields["bolCerrado"] == 0) {
                    $arrConsolidadoPrograma["Proceso Postulacion"]["estadoProceso"] = "Proceso Postulacion";
                    $arrConsolidadoPrograma["Proceso Postulacion"]["Independiente"] += ($grupo == "Independiente") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Proceso Postulacion"]["Desplazado"] += ($grupo == "Desplazado") ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Proceso Postulacion"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Proceso Postulacion - $grupo"] += $objRes->fields["cuenta"];
                }


                $objRes->MoveNext();
            }
            arsort($arrDatosGrafica);
            pr($arrDatosGrafica);

            $arrGraficas = &$this->arrGraficas; // apoyemos la pereza de Diego
            // Configuracion de la grafica
            $arrGraficas['configuracion']['ConsolidadoPrograma']['tipo'] = "columna";

            $arrGraficas['configuracion']['ConsolidadoPrograma']['ejes'][] = "ejeX";
            $arrGraficas['configuracion']['ConsolidadoPrograma']['ejes'][] = "conteo";

//	    		$arrGraficas['configuracion'][ 'ConsolidadoProgramaPie' ]['tipo'] = "pie";
//	    		
//	    		$arrGraficas['configuracion'][ 'ConsolidadoProgramaPie' ]['ejes'][] = "ejeX";
//	    		$arrGraficas['configuracion'][ 'ConsolidadoProgramaPie' ]['ejes'][] = "conteo";

            $arrConsolidadoPrograma = &$arrGraficas['datos']['ConsolidadoPrograma'];
//				$arrConsolidadoProgramaPie	= &$arrGraficas['datos']['ConsolidadoProgramaPie'];
            foreach ($arrDatosGrafica as $txtEjeY => $conteo) {
                $arrConsolidadoPrograma[$txtEjeY]['conteo'] = $conteo;
//	    			$arrConsolidadoProgramaPie[$txtEjeY]['conteo'] = $conteo;
            }
        } catch (Exception $objError) {
            $arrErrores = "Hubo un problema al intentar obtener los datos";
        }

        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function resumenPrograma() {

        global $aptBd;

        $sql = "
				SELECT est.seqEstadoProceso,
			         if(frm.bolDesplazado = 1, 'Desplazado', 'Independiente') AS Grupo,
			         CONCAT(eta.txtEtapa, ' - ', est.txtEstadoProceso) AS estadoProceso,
			         count(1) AS cuenta
			    FROM T_FRM_FORMULARIO frm
			         INNER JOIN T_FRM_ESTADO_PROCESO est
			            ON frm.seqEstadoProceso = est.seqEstadoProceso
			         INNER JOIN T_FRM_ETAPA eta
			            ON est.seqEtapa = eta.seqEtapa
				GROUP BY 2, 3
				ORDER BY 1, 2 desc
			";

        try {

            $objRes = $aptBd->execute($sql);

            $arrDesembolsosEstudioOferta = &$this->arrDesembolsosEstudioOferta;
            $arrDesembolsoEstudioTitulos = &$this->arrDesembolsoEstudioTitulos;
            $arrDesembolsoTramite = &$this->arrDesembolsoTramite;
            $arrAsignado = &$this->arrAsignado;
            $arrPostuladosInhabilitados = &$this->arrPostuladosInhabilitados;
            $arrPostulados = &$this->arrPostulados;
            $arrEnProcesoPostulacion = &$this->arrEnProcesoPostulacion;
            $arrInscritos = &$this->arrInscritos;

            $arrDesembolsosEstudioOferta = array(
                19, //Desembolso - Revisión Oferta
                24, //Desembolso - Revisión Jurídica Aprobada
                26  //Desembolso - Revisión Técnica Aprobada
            );

            $arrDesembolsoEstudioTitulos = array(
                27, //Desembolso - Escrituracion
                28, //Desembolso - Estudio de Titulos
                29  //Desembolso - Estudio de Titulos Aprobado
            );

            $arrDesembolsoTramite = array(
                30, //Desembolso - Solicitud de desembolso
                32, //Desembolso - Parcial
                33  //Desembolso - Total
            );

            $arrAsignado = array(
                15, //Asignacion - Asignado
                20, //Asignacion - Bloqueado
                18  //Asignacion - Renuncia
            );

            $arrPostuladosInhabilitados = array(
                8 //Postulacion - Inhabilitado
            );

            $arrPostulados = array(
                7 //Postulacion - Cosecha
            );

            $arrEnProcesoPostulacion = array(
                6, //Postulacion - Riego
                5  //Postulacion - Siembra
            );

            $arrInscritos = array(
                10, //Inscripcion - Call Center (Opción Cierre)
                11, //Inscripcion - Call Center (Sin Cierre)
                12, //Inscripcion - Call Center (Recursos Cero)
                1, //Inscripcion - Inscrito
                13  //Inscripcion - Renuncia
            );

            $this->arrTablas['titulos'][] = "Grupo";
            $this->arrTablas['titulos'][] = "Estado Proceso";
            // $this->arrTablas['titulos'][] = "Desplazado/Independiente";
            $this->arrTablas['titulos'][] = "Conteo de Hogares";

            $filas = &$this->arrTablas['filas'];
            $total = &$this->arrTablas['total'];

            $totalFinal = 0;
            while ($objRes->fields) {
                $estadoProceso = $objRes->fields['estadoProceso'];

                $grupo = ucwords(strtolower($objRes->fields['Grupo']));
                if (!in_array($grupo, $this->arrGrupos)) {
                    $grupo = ucwords(strtolower($objRes->fields['Grupo']));
                    $this->arrGrupos[] = $grupo;
                }

                switch (true) {

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrDesembolsosEstudioOferta)):

                        $filas['Desembolsos Estudio de Oferta'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        $total['Desembolsos Estudio de Oferta'] += $objRes->fields['cuenta'];

                        break;

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrDesembolsoEstudioTitulos)):

                        $filas['Desembolsos Estudio de Títulos'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        // $total['Desembolsos Estudio de Títulos'] += $objRes->fields['cuenta'];
                        break;

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrDesembolsoTramite)):

                        $filas['Desembolsos en tramite'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        // $total['Desembolsos en tramite'] += $objRes->fields['cuenta'];
                        break;


                    case (in_array($objRes->fields['seqEstadoProceso'], $arrAsignado)):

                        $filas['Asignados'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        //$total['Asignados'] += $objRes->fields['cuenta'];
                        break;

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrPostuladosInhabilitados)):

                        $filas['Postulados Inhabilitados'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        $total['Postulados Inhabilitados'] += $objRes->fields['cuenta'];
                        break;

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrPostulados)):

                        $filas['Postulados'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        $total['Postulados'] += $objRes->fields['cuenta'];
                        break;

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrEnProcesoPostulacion)):

                        $filas['En proceso de postulación'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        $total['En proceso de postulación'] += $objRes->fields['cuenta'];
                        break;

                    case (in_array($objRes->fields['seqEstadoProceso'], $arrInscritos)):

                        $filas['Inscritos'][$estadoProceso][$grupo] = $objRes->fields['cuenta'];
                        $total['Inscritos'] += $objRes->fields['cuenta'];
                        break;
                }

                $totalFinal += $objRes->fields['cuenta'];

                $objRes->MoveNext();
            }
            //$total = array();
            $datos = &$this->arrTablas['datos'];

            $i = 0;
            foreach ($filas as $grupoResumen => $datosGrupoResumen) {


                if ($grupoResumen == "Asignados" || strstr($grupoResumen, 'Desembolsos')) {

                    $datosAsignados = array();

                    foreach ($datosGrupoResumen as $estadoProceso => $datosEstadoProceso) {
                        foreach ($this->arrGrupos as $grupo) {

                            $valTotal = $datosEstadoProceso[$grupo];
                            if ($grupo == "Desplazado") {
                                $datosAsignados["$grupoResumen Desplazados"][$estadoProceso] = $valTotal;
                                $total["$grupoResumen Desplazados"] += $valTotal;
                            } else {
                                $datosAsignados["$grupoResumen Independientes"][$estadoProceso] = $valTotal;
                                $total["$grupoResumen Independientes"] += $valTotal;
                            }
                        }
                    }

                    foreach ($datosAsignados as $grupoResumenAsignados => $datosResumenAsignados) {
                        $datos[$i][0] = $grupoResumenAsignados;
                        $datos[$i][1] = '';
                        // $datos[$i][2] = '';
                        $datos[$i][2] = $total[$grupoResumenAsignados];
                        $i++;

                        foreach ($datosResumenAsignados as $estadoProceso => $valorTotal) {
                            if ($valorTotal) {
                                $datos[$i][0] = '';
                                $datos[$i][1] = $estadoProceso;
                                $datos[$i][2] = $valorTotal;
                                $i++;
                            }
                        }
                    }
                } else {

                    $datos[$i][0] = $grupoResumen;
                    $datos[$i][1] = '';
                    $datos[$i][2] = $total[$grupoResumen];
                    $i++;

                    foreach ($datosGrupoResumen as $estadoProceso => $datosEstadoProceso) {

                        $datos[$i][0] = '';
                        $datos[$i][1] = $estadoProceso;
                        foreach ($this->arrGrupos as $grupo) {
                            $datos[$i][2] += $datosEstadoProceso[$grupo];
                        }
                        $i++;
                    }
                }
            }
            $datos[$i][0] = "TOTAL";
            $datos[$i][1] = '';
            $datos[$i][2] = $totalFinal;

            /**
             * CONSTRUYENDO EL ARREGLO DE GRAFICAS
             */
            $arrGraficas = &$this->arrGraficas; // apoyemos la pereza de Diego
            // Configuracion de la grafica
            $arrGraficas['configuracion']['ResumenPrograma']['tipo'] = "bar";

            $arrGraficas['configuracion']['ResumenPrograma']['ejes'][] = "ejeX";
            $arrGraficas['configuracion']['ResumenPrograma']['ejes'][] = "conteo";

            $arrGraficas['configuracion']['ResumenProgramaPie']['tipo'] = "pie";

            $arrGraficas['configuracion']['ResumenProgramaPie']['ejes'][] = "ejeX";
            $arrGraficas['configuracion']['ResumenProgramaPie']['ejes'][] = "conteo";

            // Datos de las graficas	    		
            $arrRegumenPrograma = &$arrGraficas['datos']['ResumenPrograma'];
            $arrRegumenProgramaPie = &$arrGraficas['datos']['ResumenProgramaPie'];
            foreach ($total as $txtEjeY => $conteo) {
                $arrRegumenPrograma[$txtEjeY]['conteo'] = $conteo;
                $arrRegumenProgramaPie[$txtEjeY]['conteo'] = $conteo;
            }
        } catch (Exception $objError) {
            $arrErrores = "Hubo un problema al intentar obtener los datos";
        }

        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableReporteCruzarEdadTodFchPos() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        if (empty($arrErrores)) {
            $sql = "SELECT frm.seqFormulario,
					       frm.txtFormulario,
					       (
					       SELECT 
					        tdo.txtTipoDocumento
					       FROM T_CIU_TIPO_DOCUMENTO tdo WHERE tdo.seqTipoDocumento = ciu.seqTipoDocumento
					       )
					       AS TipoDocumento,
					       ciu.numDocumento,
					       UPPER(CONCAT(ciu.txtNombre1,
					                    ' ',
					                    ciu.txtNombre2,
					                    ' ',
					                    ciu.txtApellido1,
					                    ' ',
					                    ciu.txtApellido2))
					          AS txtNombre,
					       frm.fchPostulacion,
					       ADDDATE(ciu.fchNacimiento, INTERVAL 18 YEAR) AS fchMayorEdad,
					       ciu.fchNacimiento,
					       if(SUBDATE(frm.fchPostulacion, INTERVAL 18 YEAR) >= ciu.fchNacimiento,
					          'Si',
					          'No')
					          AS MayorEdad,
					       CONCAT(eta.txtEtapa, ' ', epr.txtEstadoProceso) AS txtEstadoProceso,
					       if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
					       if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado
					  FROM T_FRM_FORMULARIO frm
					       INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
					       INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
					       INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
					       INNER JOIN T_FRM_ETAPA eta  ON epr.seqEtapa = eta.seqEtapa
					 WHERE frm.seqFormulario in (" . $this->seqFormularios . ")
					 AND ( 
						( ADDDATE(ciu.fchNacimiento, INTERVAL 18 YEAR) <= frm.fchPostulacion AND ciu.seqTipoDocumento NOT IN (1, 2) )
  					 OR  ( ADDDATE(ciu.fchNacimiento, INTERVAL 18 YEAR) >  frm.fchPostulacion AND ciu.seqTipoDocumento NOT IN (4, 3) )
						)	
					";
            try {
                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtFormulario';
                $arrTitulosCampos[] = 'TipoDocumento';
                $arrTitulosCampos[] = 'numDocumento';
                $arrTitulosCampos[] = 'txtNombre';
                $arrTitulosCampos[] = 'fchPostulacion';
                $arrTitulosCampos[] = 'fchMayorEdad';
                $arrTitulosCampos[] = 'fchNacimiento';
                $arrTitulosCampos[] = 'MayorEdad';
                $arrTitulosCampos[] = 'txtEstadoProceso';
                $arrTitulosCampos[] = 'Desplazado';
                $arrTitulosCampos[] = 'Cerrado';

                $objRes = $aptBd->execute($sql);
                $this->obtenerReportesGeneral($objRes, "ReporteCruzarEdadTodFchPos", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableResumenPrograma() {

        global $aptBd;

        $sql = "
				SELECT est.seqEstadoProceso,
			         if(frm.bolDesplazado = 1, 'Desplazado', 'Independiente') AS Grupo,
			         CONCAT(eta.txtEtapa, ' - ', est.txtEstadoProceso) AS estadoProceso,
			         count(1) AS cuenta
			    FROM T_FRM_FORMULARIO frm
			         INNER JOIN T_FRM_ESTADO_PROCESO est
			            ON frm.seqEstadoProceso = est.seqEstadoProceso
			         INNER JOIN T_FRM_ETAPA eta
			            ON est.seqEtapa = eta.seqEtapa
				GROUP BY 2, 3
				ORDER BY 1, 2 desc
			";

        try {
            $objRes = $aptBd->execute($sql);

            $arrTitulosCampos[] = 'seqEstadoProceso';
            $arrTitulosCampos[] = 'Grupo';
            $arrTitulosCampos[] = 'estadoProceso';
            $arrTitulosCampos[] = 'cuenta';

            $this->obtenerReportesGeneral($objRes, "ReporteResumenPrograma", $arrTitulosCampos);
        } catch (Exception $objError) {
            $arrErrores[] = "Se ha producido un error al consultar los datos";
        }
        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableEstadoCorte() {

        global $aptBd;

        $sql = "
				  SELECT frm.seqFormulario,
				       frm.txtFormulario,
				       (
						SELECT 
							ciu1.numDocumento
						FROM T_CIU_CIUDADANO ciu1, 
							T_FRM_HOGAR hog1
						WHERE 
							hog1.seqCiudadano = ciu1.seqCiudadano
							AND hog1.seqFormulario = hog.seqFormulario
							AND hog1.seqParentesco = 1
						) AS DocumentoPPAL,
				       (
						SELECT 
							UPPER(CONCAT(ciu1.txtNombre1, ' ', ciu1.txtNombre2, ' ', ciu1.txtApellido1, ' ', ciu1.txtApellido2))
						FROM T_CIU_CIUDADANO ciu1,
							T_FRM_HOGAR hog1
						WHERE
							hog1.seqFormulario = hog.seqFormulario
							AND hog1.seqCiudadano = ciu1.seqCiudadano
							AND hog1.seqParentesco = 1
						) AS NombrePPAL,
				       ciu.numDocumento,
				       UPPER(CONCAT(ciu.txtNombre1,
				                    ' ',
				                    ciu.txtNombre2,
				                    ' ',
				                    ciu.txtApellido1,
				                    ' ',
				                    ciu.txtApellido2))
				          AS Nombre,
				       par.txtParentesco,
				       if(frm.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
				       est.txtEstadoProceso,
						if(frm.bolCerrado = 1, 'Si', 'No') AS Cerrado,
				       moa.txtModalidad,
				       sol.txtSolucion,
				       frm.numTelefono1,
				       frm.numTelefono2,
				       frm.numCelular,
				       sol.txtDescripcion,
				       frm.fchPostulacion
				  FROM T_FRM_FORMULARIO frm
				       INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
				       INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				       INNER JOIN T_CIU_PARENTESCO par ON hog.seqParentesco = par.seqParentesco
				       INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
				       INNER JOIN T_FRM_ESTADO_PROCESO est ON est.seqEstadoProceso = frm.seqEstadoProceso
				       INNER JOIN T_FRM_SOLUCION sol ON sol.seqSolucion = frm.seqSolucion
				 WHERE frm.seqFormulario in (" . $this->seqFormularios . ")	
	    	";

        try {
            $objRes = $aptBd->execute($sql);
            $arrTitulosCampos[] = 'seqFormulario';
            $arrTitulosCampos[] = 'txtFormulario';
            $arrTitulosCampos[] = 'DocumentoPPAL';
            $arrTitulosCampos[] = 'NombrePPAL';
            $arrTitulosCampos[] = 'numDocumento';
            $arrTitulosCampos[] = 'Nombre';
            $arrTitulosCampos[] = 'txtParentesco';
            $arrTitulosCampos[] = 'Desplazado';
            $arrTitulosCampos[] = 'txtEstadoProceso';
            $arrTitulosCampos[] = 'Derrado';
            $arrTitulosCampos[] = 'txtModalidad';
            $arrTitulosCampos[] = 'txtSolucion';
            $arrTitulosCampos[] = 'numTelefono1';
            $arrTitulosCampos[] = 'numTelefono2';
            $arrTitulosCampos[] = 'numCelular';
            $arrTitulosCampos[] = 'txtDescripcion';
            $arrTitulosCampos[] = 'fchPostulacion';

            $this->obtenerReportesGeneral($objRes, "ReporteEstadoCorte", $arrTitulosCampos);
        } catch (Exception $objError) {
            $arrErrores[] = "Se ha producido un error al consultar los datos";
            $arrErrores[] = $objError->getMessagge();
        }
        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableCartasAsignacion() {

        global $aptBd;

        $sql = "
					SELECT 
						frm.seqFormulario as Formulario,
						upper(frm.txtDireccion) as Direccion,
						if( frm.numTelefono1 != 0 , frm.numTelefono1 , ( if( frm.numTelefono2 != 0 , frm.numTelefono2 , frm.numCelular ) ) ) as Telefono ,
						moa.txtModalidad as Modalidad,
						sol.txtDescripcion as Solucion, 
						REPLACE (valorMaximoVivienda( sol.txtSolucion ), '?', 'í') as ValorMaximo,
						format( frm.valAspiraSubsidio , 0 )as Subsidio,
						if( tdo.seqTipoDocumento in( 3 , 4 , 7) , 'Menor de Edad', tdo.txtTipoDocumento ) as TipoDocumento ,
						if( tdo.seqTipoDocumento in( 3 , 4 , 7) , '', format( ciu.numDocumento , 0 ) ) as Documento ,
						upper( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 )) as Nombre,
						civ.txtEstadoCivil as Estado_Civil
						
					FROM 
					T_FRM_FORMULARIO frm
					INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
					INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
					INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
					INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
					INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
					INNER JOIN t_ciu_estado_civil civ on civ.seqEstadoCivil = ciu.seqEstadoCivil
					WHERE  
					frm.seqFormulario in (" . $this->seqFormularios . ")
					ORDER BY frm.seqFormulario, hog.seqParentesco
				";

        try {
            $objRes = $aptBd->execute($sql);
            $arrTitulosCampos[] = 'Formulario';
            $arrTitulosCampos[] = 'Direccion';
            $arrTitulosCampos[] = 'Telefono';
            $arrTitulosCampos[] = 'Modalidad';
            $arrTitulosCampos[] = 'Solucion';
            $arrTitulosCampos[] = 'ValorMaximo';
            $arrTitulosCampos[] = 'Subsidio';
            $arrTitulosCampos[] = 'TipoDocumento';
            $arrTitulosCampos[] = 'Documento';
            $arrTitulosCampos[] = 'Nombre';
            $arrTitulosCampos[] = 'EstadoCivil';

            $this->obtenerReportesGeneral($objRes, "ReporteCartasAsignacion", $arrTitulosCampos);
        } catch (Exception $objError) {
            $arrErrores[] = "Se ha producido un error al consultar los datos";
            $arrErrores[] = $objError->getMessagge();
        }
        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function inscritosostuladosConsulta() {

        global $aptBd;

        $arrPostulados[] = 6;
        $arrPostulados[] = 7;
        $arrPostulados[] = 8;
        $arrPostulados[] = 14;

        $arrInscritos[] = 1;
        $arrInscritos[] = 10;
        $arrInscritos[] = 11;
        $arrInscritos[] = 12;
        $arrInscritos[] = 13;

        if ($_POST['filtroEstadoProceso'] == "postulados") {
            $txtEstadoProceso = implode(",", $arrPostulados);
        }

        if ($_POST['filtroEstadoProceso'] == "inscritos") {
            $txtEstadoProceso = implode(",", $arrInscritos);
        }

        if ($_POST['filtroUsuarioPunto'] == "punto") {
            $txtSelect = " pun.txtPuntoAtencion as PuntoAtencion, ";
            $txtInnerJoin = " INNER JOIN T_FRM_PUNTO_ATENCION pun ON frm.seqPuntoAtencion = pun.seqPuntoAtencion ";
            $txtTitulo = "PuntoAtencion";
        }

        if ($_POST['filtroUsuarioPunto'] == "usuario") {
            $txtSelect = " CONCAT(usu.txtNombre, ' ', usu.txtApellido) as Usuario, ";
            $txtInnerJoin = " INNER JOIN T_COR_USUARIO usu on usu.seqUsuario = frm.seqUsuario ";
            $txtTitulo = "Usuario";
        }


        $sql = "
				SELECT 
					$txtSelect
					CONCAT(eta.txtEtapa, ' - ', epr.txtEstadoProceso) AS EstadoProceso,
					count(1) as Cuenta
				FROM T_FRM_FORMULARIO frm
				$txtInnerJoin
				INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
				INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
				WHERE frm.seqEstadoProceso IN ( $txtEstadoProceso )
				GROUP BY 1, 2
				";

        try {

            $objRes = $aptBd->execute($sql);

            $this->arrTablas['titulos'][] = $txtTitulo;
            $this->arrTablas['titulos'][] = "Estado Proceso";
            $this->arrTablas['titulos'][] = "Total";

            while ($objRes->fields) {


                $txtPuntoAtencion = $objRes->fields[$txtTitulo];
                $txtEstadoProceso = $objRes->fields['EstadoProceso'];
                $txtCuenta = $objRes->fields['Cuenta'];

                $this->arrTablas['filas'][$txtPuntoAtencion][$txtEstadoProceso] = $txtCuenta;
                $this->arrTablas['total'][$txtTitulo][$txtPuntoAtencion] += $txtCuenta;
                $this->arrTablas['total']['EstadoProceso'][$txtEstadoProceso] += $txtCuenta;
                $this->arrTablas['total']['total'] += $txtCuenta;

                $objRes->MoveNext();
            }

            $arrDatos = &$this->arrTablas['datos'];
            foreach ($this->arrTablas['filas'] as $txtPuntoAtencion => $arrPuntoAtencion) {
                $arrDatosFila = &$arrDatos[];
                $arrDatosFila[] = "<b>" . $txtPuntoAtencion . "</b>";
                $arrDatosFila[] = "";
                $arrDatosFila[] = "<b>" . $this->arrTablas['total'][$txtTitulo][$txtPuntoAtencion] . "</b>";
                foreach ($arrPuntoAtencion as $txtEstadoProceso => $numTotal) {
                    $arrDatosFila = &$arrDatos[];
                    $arrDatosFila[] = "";
                    $arrDatosFila[] = $txtEstadoProceso;
                    $arrDatosFila[] = $numTotal;
                }
            }

            $arrDatosFila = &$arrDatos[];
            $arrDatosFila[] = "<td colspan='2' align='center'><b>TOTAL ESTADOS PROCESO</b></td>";

            foreach ($this->arrTablas['total']['EstadoProceso'] as $txtEstadoProceso => $numTotal) {
                $arrDatosFila = &$arrDatos[];
                $arrDatosFila[] = "";
                $arrDatosFila[] = "<b>" . $txtEstadoProceso . "</b>";
                $arrDatosFila[] = "<b>" . $numTotal . "</b>";
            }

            $arrDatosFila = &$arrDatos[];
            $arrDatosFila[] = "<td colspan='2' align='center'><b>TOTAL</b></td>";

            $arrDatosFila = &$arrDatos[];
            $arrDatosFila[] = "";
            $arrDatosFila[] = "";
            $arrDatosFila[] = "<b>" . $this->arrTablas['total']['total'] . "</b>";

            $arrGraficasTabs = array();
            $arrGraficasTabs[] = $txtTitulo;
            $arrGraficasTabs[] = "EstadoProceso";

            $arrGraficas = &$this->arrGraficas;
            foreach ($arrGraficasTabs as $txtTab) {

                $arrTab = &$arrGraficas['configuracion'][$txtTab];
                $arrTab['tipo'] = "bar";
                $arrTab['ejes'][] = "ejeX";
                $arrTab['ejes'][] = "conteo";

                $arrEjes = array();
                switch ($txtTab) {
                    case $txtTitulo:
                        $arrEjes = $this->arrTablas['total'][$txtTitulo];
                        break;
                    case "EstadoProceso":
                        $arrEjes = $this->arrTablas['total']['EstadoProceso'];
                        break;
                    default:
                        $arrEjes = array();
                        break;
                }

                foreach ($arrEjes as $txtEje => $txt) {
                    $arrGraficas['datos'][$txtTab][$txtEje]["conteo"] = $arrEjes[$txtEje];
                }
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "Hubo un problema al intentar obtener los datos";
        }
        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
//			pr( $this );
    }

    public function estadoCorte() {

        global $aptBd;

        $sql = "
				 SELECT if(frm.bolDesplazado = 1, 'Desplazado', 'Independiente') AS Grupo,
			         moa.txtModalidad AS Modalidad,
			         if(frm.seqModalidad = 3 OR frm.seqModalidad = 4 OR frm.seqModalidad = 5 ,
			            avaluo2Tipo(frm.valTotal),
			            sol.txtDescripcion)
			            AS Solucion,
			         count(1) AS cuenta
			    FROM T_FRM_FORMULARIO frm
			         INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
			         INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
			         INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
			   WHERE frm.seqEstadoProceso = 7 
					AND frm.bolCerrado = 1
					 AND hog.seqParentesco = 1
			         AND frm.fchPostulacion <=
			               (SELECT fchFinal
			                  FROM T_FRM_PERIODO
			                 WHERE seqPeriodo = (SELECT max(seqPeriodo) FROM T_FRM_PERIODO))
				GROUP BY 1, 2, 3
				ORDER BY 1, 2, 3		
	    	";

        try {

            $this->arrTablas['titulos'][] = "Grupo";
            $this->arrTablas['titulos'][] = "Modalidad";

            $objRes = $aptBd->execute($sql);

            $prueba = array();

            while ($objRes->fields) {
                if (!in_array(ucwords(strtolower($objRes->fields['Solucion'])), $this->arrTablas['titulos'])) {
                    $solucion = ucwords(strtolower($objRes->fields['Solucion']));
                    $this->arrTablas['titulos'][] = $solucion;
                    $this->arrSoluciones[] = $solucion;
                }

                $txtGrupo = $objRes->fields['Grupo'];
                $txtModalidad = $objRes->fields['Modalidad'];
                $txtSolucion = ucwords(strtolower($objRes->fields['Solucion']));
                $txtCuenta = $objRes->fields['cuenta'];

                $this->arrTablas['filas'][$txtGrupo][$txtModalidad][$txtSolucion] = $txtCuenta;

                $this->arrTablas['total']['TotalModalidad'][$txtModalidad][$txtSolucion] += $txtCuenta;
                $this->arrTablas['total']['TotalPoblacion'][$txtSolucion] += $txtCuenta;
                $this->arrTablas['total']['total'] += $txtCuenta;

                $objRes->MoveNext();
            }
            $this->arrTablas['titulos'][] = "Total";

            $j = 0;
            $datos = &$this->arrTablas['datos'];

            foreach ($this->arrTablas['filas'] as $grupo => $datoGrupo) {

                foreach ($datoGrupo as $modalidad => $datosModalidad) {

                    $datos[$j][0] = $grupo;
                    $datos[$j][1] = $modalidad;

                    $i = 2;
                    $total = 0;

                    foreach ($this->arrSoluciones as $solucion) {

                        if ($datosModalidad[$solucion]) {
                            $datos[$j][$i] = $datosModalidad[$solucion];
                            $total += $datosModalidad[$solucion];
                        } else {
                            $datos[$j][$i] = 0;
                        }

                        $i++;
                    }

                    $datos[$j][5] = $total;
                    $j++;
                }
            }


            foreach ($this->arrTablas['total']['TotalModalidad'] as $modalidad => $datosModalidad) {

                $datos[$j][0] = "<b>TODOS</b>";
                $datos[$j][1] = "<b>$modalidad</b>";

                $i = 2;
                $total = 0;

                foreach ($this->arrSoluciones as $solucion) {

                    if ($datosModalidad[$solucion]) {
                        $datos[$j][$i] = "<b>" . $datosModalidad[$solucion] . "</b>";
                        $total += $datosModalidad[$solucion];
                    } else {
                        $datos[$j][$i] = "<b>" . 0 . "</b>";
                    }

                    $i++;
                }

                $datos[$j][5] = "<b>" . $total . "</b>";
                $j++;
            }

            $totalPoblacion = $this->arrTablas['total']['TotalPoblacion'];

            $datos[$j][0] = "<b>TODOS</b>";
            $datos[$j][1] = "<b>TOTAL POBLACION</b>";

            $i = 2;
            $total = 0;
            foreach ($this->arrSoluciones as $solucion) {

                if ($totalPoblacion[$solucion]) {
                    $datos[$j][$i] = "<b>" . $totalPoblacion[$solucion] . "</b>";
                    $total += $totalPoblacion[$solucion];
                } else {
                    $datos[$j][$i] = "<b>" . 0 . "</b>";
                }

                $i++;
            }
            $datos[$j][5] = "<b>" . $total . "</b>";


            /**
             * ARREGLO DE GRAFICAS
             */
            $arrGraficas = &$this->arrGraficas; // apoyemos la pereza de Diego
            // Configuracion de la grafica
            //$arrGraficas['configuracion'][ 'TotalCorte' ]['tipo'] = "pie";

            foreach ($this->arrTablas['filas'] as $txtGrupo => $arrInfo) {
                $arrGraficas['configuracion'][$txtGrupo]['tipo'] = "columna";
                $arrGraficas['configuracion'][$txtGrupo]['ejes'][] = "ejeX";
                $arrGraficas['configuracion'][$txtGrupo]['ejes'][] = "VipTipo1";
                $arrGraficas['configuracion'][$txtGrupo]['ejes'][] = "VipTipo2";
                $arrGraficas['configuracion'][$txtGrupo]['ejes'][] = "Vis";
            }

            // Datos de las graficas
            $arrGraficas['datos'] = $this->arrTablas['filas'];
            $arrGraficas['datos']['TotalCorte'] = array();
            foreach ($this->arrTablas['total']['TotalModalidad'] as $txtModalidad => $arrSolucion) {
                foreach ($arrSolucion as $txtSolucion => $numValor) {
                    $arrGraficas['datos']['TotalCorte'][$txtModalidad]['conteo'] += $numValor;
                }
            }

            $arrGraficas['configuracion']['TotalCorte']['tipo'] = "pie";
            $arrGraficas['configuracion']['TotalCorte']['ejes'][] = "ejeX";
            $arrGraficas['configuracion']['TotalCorte']['ejes'][] = "conteo";
        } catch (Exception $objError) {
            $this->arrErrores[] = "Hubo un problema al intentar obtener los datos";
        }
        if (!empty($arrErrores)) {
            imprimirMensajes($arrErrores, array());
        }
    }

    /**
     * TOMA UN ARREGLO DE PHP Y RETORNA UN
     * STRING CON SINTAXIS JAVASCRITPT
     * @author Diego Felipe Gaitan
     * @author Bernardo Zerda
     * @param Array Void
     * @return String txtJs
     * @version 0.1 Marzo 2010
     */
    public function php2js() {

        $arrGraficas = $this->arrGraficas;
        $txtJs = "var objGraficas = { ";

        // Iteracion de graficas
        foreach ($this->arrGraficas['datos'] as $txtNombreGrafica => $arrEjeX) {
            $txtJs .= $txtNombreGrafica . ": { ";
            $txtJs .= "tipo: '" . $this->arrGraficas['configuracion'][$txtNombreGrafica]['tipo'] . "',";
            $txtJs .= "nombre: '$txtNombreGrafica' , ";
            $txtJs .= "ejes: [";
            foreach ($this->arrGraficas['configuracion'][$txtNombreGrafica]['ejes'] as $txtEje) {
                $txtJs .= "'" . $txtEje . "',";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= "], ";
            $txtJs .= "datos: [";
            foreach ($arrEjeX as $txtNombreEjeX => $arrSeries) {
                $txtJs .= "{ ejeX: '$txtNombreEjeX' , ";
                foreach ($arrSeries as $txtNombreSerie => $numValorSerie) {
                    $numValorSerie = (is_numeric($numValorSerie)) ? $numValorSerie : "'$numValorSerie'";
                    $txtJs .= ereg_replace(" ", "", $txtNombreSerie) . ": $numValorSerie , ";
                }
                $txtJs = trim($txtJs, ", ");
                $txtJs .= "}, ";
            }
            $txtJs = trim($txtJs, ", ");
            $txtJs .= "]}, ";
        }
        $txtJs = trim($txtJs, ", ");
        $txtJs .= " }; ";

        return $txtJs;
    }

    private function formArchivo($nomVariable) {

        $txtFile = "<input 
						type='file'
						id='$nomVariable'
						name = '$nomVariable' >";

        return $txtFile;
    }

    private function leerArchivoSecuenciales() {

        global $aptBd;

        $arrSeqFormularios = &$this->arrSeqFormularios;
        $arrErrores = &$this->arrErrores;

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
                        } else {
                            //throw new Exception("La linea $numLinea . El documento $txtLinea no tiene asignado un formulario");
                        }
                    } else if ($txtLinea != "") {
                        throw new Exception("La linea $numLinea del archivo no contiene un número de documento válido");
                    }
                } catch (Exception $objError) {
                    $arrErrores[] = $objError->getMessage();
                }
                $numLinea++;
            }
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido abrir el archivo, puede que no tenga el formato correcto";
        }
    }

    public function cargarSecuencialesFormulario() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;
        $bolExisteFileSecuenciales = true;

        switch ($_FILES['fileSecuenciales']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
                break;
            case UPLOAD_ERR_PARTIAL:
                $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
                break;
            case UPLOAD_ERR_NO_FILE:
                $bolExisteFileSecuenciales = false;
                break;
        }


        if (empty($arrErrores) and $bolExisteFileSecuenciales and ! empty($_FILES['fileSecuenciales'])) {
            $this->leerArchivoSecuenciales();
        }

        $seqFormularios = &$this->seqFormularios;
        $arrSeqFormularios = &$this->arrSeqFormularios;

        if (!empty($arrSeqFormularios)) {
            $seqFormularios = implode($arrSeqFormularios, ",");
        } else {

            $sql = "SELECT frm.seqFormulario
                    FROM T_FRM_FORMULARIO frm
                    WHERE 
                          frm.seqEstadoProceso = 7  AND -- frm.bolCerrado = 1 AND 
                          frm.fchPostulacion <=
                            (SELECT fchFinal
                                FROM T_FRM_PERIODO
                                WHERE seqPeriodo = (SELECT max(seqPeriodo) FROM T_FRM_PERIODO)) 
                  ";

            try {

                $objRes = $aptBd->execute($sql);

                while ($objRes->fields) {
                    $arrSeqFormularios[] = $objRes->fields['seqFormulario'];
                    $objRes->MoveNext();
                }

                $seqFormularios = (empty($arrSeqFormularios)) ? "null" :
                        implode($arrSeqFormularios, ",");
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
        }
    }

    public function pasivosExigibles($fchDesde, $fchHasta) {
        global $aptBd;

        // Validacion de la fecha de inicio
        list($ano, $mes, $dia) = split("-", $fchDesde);
        if (@checkdate($mes, $dia, $ano) === false) {
            $this->arrErrores[] = "La fecha de inicio no es válida";
        }

        // Validacion de la fecha de fin
        list($ano, $mes, $dia) = split("-", $fchHasta);
        if (@checkdate($mes, $dia, $ano) === false) {
            $this->arrErrores[] = "La fecha de fin no es válida";
        }

        if (empty($this->arrErrores)) {
            try {
                $sql = "
                        SELECT 
                          hvi.numActo as Numero,
                          hvi.fchActo as Fecha,
                          ciu.numDocumento as Documento,
                          UPPER( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) as Nombre,
                          moa.txtModalidad as Modalidad,
                          UPPER( CONCAT( sol.txtDescripcion , ' ( ' , sol.txtSolucion , ' )' ) ) as Solucion,
                          frm.valAspiraSubsidio as ValorSubsidio,
                          CONCAT( eta.txtEtapa , ' - ' , epr.txtEstadoProceso ) as EstadoProceso,
                          des.fchActualizacionEscrituracion as FechaActualizacionEscrituracion
                        FROM T_FRM_FORMULARIO frm
                        INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
                        INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                        INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
                        INNER JOIN T_FRM_SOLUCION sol ON sol.seqSolucion = frm.seqSolucion
                        INNER JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso
                        INNER JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
                        INNER JOIN T_DES_DESEMBOLSO des ON frm.seqFormulario = des.seqFormulario
                        INNER JOIN T_AAD_FORMULARIO_ACTO fac ON  frm.seqFormulario = fac.seqFormulario
                        INNER JOIN T_AAD_HOGARES_VINCULADOS hvi ON fac.seqFormularioActo = hvi.seqFormularioActo
                        INNER JOIN T_AAD_ACTO_ADMINISTRATIVO aad ON ( hvi.numActo = aad.numActo AND hvi.fchActo = aad.fchActo )
                        WHERE hog.seqParentesco = 1	
                          AND aad.seqTipoActo = 1
                          AND des.fchActualizacionEscrituracion >= '$fchDesde 00:00:00'
                          AND des.fchActualizacionEscrituracion <= '$fchHasta 23:59:59'
                          AND frm.seqEstadoProceso IN (26,27,28,29,30)
                        GROUP BY frm.seqFormulario, hvi.numActo, hvi.fchActo	    		
		    ";
                $arrResultado = array();
                $objRes = $aptBd->execute($sql);
                $this->obtenerReportesGeneral($objRes, "PasivosExigibles_$fchDesde\_$fchHasta\_");
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se pudo realizar la consulta de pasivos exigibles";
            }
        } else {
            imprimirMensajes($this->arrErrores, array());
        }
    }

    /**
     * OBTENCION DEL VALOR DEL CIERRE FINANCIERO
     * @author bzerdar
     * @param Integer seqModalidad
     * @param Integer seqSolucion
     * @return Integer valCierreFinanciero
     * @version 1.0 Ene 2011
     */
    public function valorCierreFinanciero($seqModalidad, $seqSolucion) {
        global $aptBd;
        global $arrConfiguracion;

        try {
            $sql = "
                    SELECT
                      vsu.valSubsidio,
                      sol.txtSolucion
                    FROM
                      T_FRM_VALOR_SUBSIDIO vsu,
                      T_FRM_SOLUCION sol
                    WHERE vsu.seqModalidad = $seqModalidad
                    AND vsu.seqSolucion = $seqSolucion
                    AND sol.seqSolucion = vsu.seqSolucion;	    		
		    	";

            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                if ($seqModalidad != 5) {
                    switch ($objRes->fields['txtSolucion']) {
                        case "<= 50 SMMLV":
                            $valCierreFinanciero = (50 * $arrConfiguracion['constantes']['salarioMinimo']) - $objRes->fields['valSubsidio'];
                            break;
                        case "> 50 y <= 70 SMMLV":
                            $valCierreFinanciero = (50 * $arrConfiguracion['constantes']['salarioMinimo']) - $objRes->fields['valSubsidio'];
                            break;
                        case "> 70 y <= 135 SMMLV":
                            $valCierreFinanciero = (70 * $arrConfiguracion['constantes']['salarioMinimo']) - $objRes->fields['valSubsidio'];
                            break;
                        default:
                            $valCierreFinanciero = 0;
                            break;
                    }
                } else {
                    $valCierreFinanciero = 0;
                }
            } else {
                $valCierreFinanciero = 0;
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se ha podido verificar el valor del cierre financiero";
            $valCierreFinanciero = 0;
        }

        return $valCierreFinanciero;
    }

    public function seguimientoDesembolsos($arrDocumentos) {
        global $aptBd;

        if (!empty($arrDocumentos)) {

            $sql = "
            SELECT 
               frm.seqFormulario as Formulario,
               CONCAT( eta.txtEtapa , ' - ' , pro.txtEstadoProceso ) as Estado, 
               ciu.numDocumento as Documento,
               CONCAT( TRIM( ciu.txtNombre1 ) , ' ' ,  if( ciu.txtNombre2 <> '' , CONCAT( TRIM( ciu.txtNombre2 ) , ' ' ), '' ), ciu.txtApellido1, ' ', ciu.txtApellido2 ) as Nombre,
               UPPER( flu.txtFlujo ) as Esquema,
               sol.numRegistroPresupuestal1 as NumeroRegistroPresupuestal1,
               sol.fchRegistroPresupuestal1 as FechaRegistroPresupuestal1,
               sol.numRegistroPresupuestal2 as NumeroRegistroPresupuestal2,
               sol.fchRegistroPresupuestal2 as FechaRegistroPresupuestal2,
               sol.valSolicitado as ValorSolicitado,
               sol.numRadiacion as NumeroRadicado,
               sol.fchRadicacion as FechaRadicacion,
               sol.numOrden as NumeroOrdenPago,
               sol.fchOrden as FechaOrdenPago,
               sol.valOrden as ValorOrdenPago,
			   des.txtNombreVendedor AS NombreVendedor,
			   sol.txtNombreBeneficiarioGiro AS NombreBeneficiarioGiro
            FROM T_FRM_FORMULARIO frm
            INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
            INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
            INNER JOIN T_FRM_ESTADO_PROCESO pro ON frm.seqEstadoProceso = pro.seqEstadoProceso
            INNER JOIN T_FRM_ETAPA eta ON pro.seqEtapa = eta.seqEtapa
            LEFT JOIN T_DES_FLUJO flu ON frm.seqFormulario = flu.seqFormulario
            LEFT JOIN T_DES_DESEMBOLSO des ON frm.seqFormulario = des.seqFormulario
            LEFT JOIN T_DES_SOLICITUD sol ON des.seqDesembolso = sol.seqDesembolso
            WHERE hog.seqParentesco = 1
            AND ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
         ";
            $objRes = $aptBd->execute($sql);
            $this->obtenerReportesGeneral($objRes, "seguimientoDesembolsos");
        } else {
            $this->arrErrores[] = "No hay documentos en el archivo";
            imprimirMensajes($this->arrErrores, array());
        }
    }

    public function obtenerEscrituracion($arrDocumentos) {

        obtenerReporteEscrituracion($arrDocumentos);
    }

    public function exportableCartasMovilizacion() {
        global $aptBd;

        $sql = "
         SELECT
            numDocumento,
            txtTipoCarta,
            fchCarta,
            txtCodigo
         FROM T_CIU_CARTA
      ";
        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "cartasMovilizacion");
    }

    /* public function exportableHogaresCalificados(){
      global $aptBd;

      $sql = "
      SELECT
      numDocumento,
      txtTipoCarta,
      fchCarta,
      txtCodigo
      FROM T_CIU_CARTA
      ";
      $objRes = $aptBd->execute( $sql );
      $this->obtenerReportesGeneral($objRes, "hogaresCalificados");

      } */

    public function exportableHogaresCalificados() {

        global $aptBd;

        $arrErrores = &$this->arrErrores;

        $txtCondiciones = '';

        if (empty($arrErrores)) {

            $txtCondiciones = ($_POST['fchInicio'] != "") ? "AND fchCalificacion >= '" . $_POST['fchInicio'] . " 00:00:00'" : "";
            $txtCondiciones .= ($_POST['fchFin'] != "") ? "AND fchCalificacion <= '" . $_POST['fchFin'] . " 23:59:59'" : "";

            $sql = "SELECT 
						T_FRM_CALIFICACION_PLAN2.seqFormulario,
						numDocumento AS DocumentoPPal,
						UPPER(CONCAT(txtNombre1,' ',txtNombre2,' ',txtApellido1,' ',txtApellido2)) AS NombrePPal,
						DATE_FORMAT(fchCalificacion,'%d-%m-%Y') AS FechaCalificacion,
						FORMAT(valTransformado, 3) AS Puntaje
					FROM T_FRM_CALIFICACION_PLAN2 LEFT JOIN T_FRM_HOGAR ON (T_FRM_CALIFICACION_PLAN2.seqFormulario = T_FRM_HOGAR.seqFormulario)
					LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
					WHERE 
						seqParentesco = 1 
					$txtCondiciones";
            //echo $sql;
            try {
                $objRes = $aptBd->execute($sql);

                $arrTitulosCampos[] = 'SeqFormulario';
                $arrTitulosCampos[] = 'Documento PPal';
                $arrTitulosCampos[] = 'Nombre PPal';
                $arrTitulosCampos[] = 'Fecha Calificación';
                $arrTitulosCampos[] = 'Puntaje';

                $this->obtenerReportesGeneral($objRes, "ReporteHogaresCalificados", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function exportableActosAdministrativosAsignacion() {
        global $aptBd;

        // Se ocultan los campos:
        // par.txtParentesco AS Parentesco, tac.txtNombreTipoActo AS Tipo_Acto, fac.valCredito
        // Se ocultan las relaciones:
        // LEFT JOIN T_CIU_PARENTESCO par ON hac.seqParentesco = par.seqParentesco
        // LEFT JOIN T_AAD_TIPO_ACTO tac ON aad.seqTipoActo = tac.seqTipoActo
        $sql = "
            SELECT DISTINCT 
                fac.seqFormulario AS seqFormulario,
                fac.seqFormularioActo AS seqFormularioActo,
                cac.numDocumento AS Documento,
                concat(cac.txtNombre1,' ',cac.txtNombre2,' ',cac.txtApellido1,' ',cac.txtApellido2) AS Nombre,
                if(fac.bolDesplazado = 1, 'Si', 'No') AS Desplazado,
                concat('Res. ', aad.numActo) AS Resolucion,
                year(aad.fchActo) AS Año,
                aad.fchActo AS Fecha_Resolucion,
                frm.fchVigencia AS Fecha_Vigencia,
                moda.txtModalidad,
                sol.txtDescripcion AS Tipo,
                sol.txtSolucion AS Rango,
                fac.valAspiraSubsidio AS Vr_SDV,
                fac.valCartaLeasing AS Vr_CartaLeasing,
                fac.valComplementario as Vr_Complementario,
                CONCAT(txtEtapa ,' - ', txtEstadoProceso ) AS Estado_Proceso,
                esq.txtTipoEsquema AS Esquema,
                pry.txtNombreProyecto AS Proyecto,
                prh.txtNombreProyecto AS Conjunto_Residencial,
                und.txtNombreUnidad AS Unidad_Residencial,
                fac.txtMatriculaInmobiliaria AS Matricula_Inmobiliaria,
                fac.txtDireccionSolucion AS Direccion,
                bh1.txtBanco AS Banco_Ahorro_1,
                bh2.txtBanco AS Banco_Ahorro_2,
                bcr.txtBanco AS Banco_Credito,
                ets.txtEntidadSubsidio AS Entidad_Subsidio,
                edn.txtEmpresaDonante AS Entidad_Donante,
                fac.fchUltimaActualizacion AS Fecha_Actualizacion
            FROM T_AAD_ACTO_ADMINISTRATIVO aad
            LEFT JOIN T_AAD_HOGARES_VINCULADOS hvi ON aad.fchActo = hvi.fchActo AND aad.numActo = hvi.numActo
            LEFT JOIN T_AAD_FORMULARIO_ACTO fac ON hvi.seqFormularioActo = fac.seqFormularioActo
            LEFT JOIN T_FRM_BANCO bh1 ON fac.seqBancoCuentaAhorro = bh1.seqBanco
            LEFT JOIN T_FRM_BANCO bh2 ON fac.seqBancoCuentaAhorro = bh2.seqBanco
            LEFT JOIN T_FRM_BANCO bcr ON fac.seqBancoCredito = bcr.seqBanco
            LEFT JOIN T_FRM_ENTIDAD_SUBSIDIO ets ON fac.seqEntidadSubsidio = ets.seqEntidadSubsidio
            LEFT JOIN T_FRM_EMPRESA_DONANTE edn ON fac.seqEmpresaDonante = edn.seqEmpresaDonante
            LEFT JOIN T_FRM_ESTADO_PROCESO est ON fac.seqEstadoProceso = est.seqEstadoProceso
            LEFT JOIN T_FRM_ETAPA etp ON est.seqEtapa = etp.seqEtapa
            LEFT JOIN T_AAD_HOGAR_ACTO hac ON fac.seqFormularioActo = hac.seqFormularioActo
            LEFT JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
            LEFT JOIN T_FRM_MODALIDAD moda ON fac.seqModalidad = moda.seqModalidad
            LEFT JOIN T_FRM_SOLUCION sol ON fac.seqSolucion = sol.seqSolucion
            LEFT JOIN T_PRY_PROYECTO pry ON fac.seqProyecto = pry.seqProyecto
            LEFT JOIN T_PRY_PROYECTO prh ON fac.seqProyectoHijo = prh.seqProyecto
            LEFT JOIN T_FRM_FORMULARIO frm ON fac.seqFormulario = frm.seqFormulario
            LEFT JOIN T_PRY_UNIDAD_PROYECTO und ON fac.seqUnidadProyecto = und.seqUnidadProyecto
            LEFT JOIN T_PRY_TIPO_ESQUEMA AS esq ON fac.seqTipoEsquema = esq.seqTipoEsquema
            WHERE (hac.seqParentesco = 1 OR hac.seqParentesco IS NULL)
              AND aad.seqCaracteristica = 1
            ORDER BY aad.fchActo DESC
        ";
        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "reporteAsignadosAAD");
    }

    public function exportableAsignacionUnidades() {
        global $aptBd;

        $sql = "(
				SELECT
				  pro.txtNombreProyecto AS 'Proyecto',
				  prh.txtNombreProyecto AS 'Conjunto Residencial',
				  und.txtNombreUnidad AS 'Unidad Proyecto',
				  frm.seqFormulario,
				  frm.txtFormulario,
				  UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'Nombre',
				  ciu.numDocumento AS 'Documento',
				  CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'Estado del Proceso'
				FROM T_PRY_UNIDAD_PROYECTO und
				  LEFT JOIN T_FRM_FORMULARIO frm ON (frm.seqUnidadProyecto = und.seqUnidadProyecto)
				  LEFT JOIN T_FRM_HOGAR hog ON (frm.seqFormulario = hog.seqFormulario)
				  LEFT JOIN T_CIU_CIUDADANO ciu ON (hog.seqCiudadano = ciu.seqCiudadano)
				  LEFT JOIN T_FRM_ESTADO_PROCESO epr ON (frm.seqEstadoProceso = epr.seqEstadoProceso)
				  LEFT JOIN T_FRM_ETAPA eta ON (epr.seqEtapa = eta.seqEtapa)
				  LEFT JOIN T_PRY_PROYECTO pro ON (frm.seqProyecto = pro.seqProyecto)
				  LEFT JOIN T_PRY_PROYECTO prh ON (frm.seqProyectoHijo = prh.seqProyecto)
				WHERE hog.seqParentesco = 1
				AND pro.seqTipoEsquema in (1, 2)
				AND pro.seqProyectoPadre is null
				) UNION (
				SELECT
				  pro.txtNombreProyecto AS 'Proyecto',
				  prh.txtNombreProyecto AS 'Conjunto Residencial',
				  und.txtNombreUnidad AS 'Unidad Proyecto',
				  '' as 'seqFormulario',
				  '' as 'txtFormulario',
				  '' as 'Nombre',
				  '' as 'Documento',
				  '' as 'Estado del Proceso'
				FROM T_PRY_UNIDAD_PROYECTO und
				LEFT JOIN T_PRY_PROYECTO pro ON (und.seqProyecto = pro.seqProyecto)
				LEFT JOIN T_PRY_PROYECTO prh ON (pro.seqProyectoPadre = prh.seqProyecto)
				WHERE (und.seqFormulario = 0 OR und.seqFormulario is null)
				AND pro.seqTipoEsquema in (1, 2)
				AND pro.seqProyectoPadre is null
				)
				ORDER BY 1,2,3
      ";
        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "reporteAsignacionUnidades");
    }

    public function exportableAsignacionUnidadesMejoramiento() {
        global $aptBd;

        $sql = "SELECT
				  pro.txtNombreProyecto AS 'Proyecto',
				  frm.txtDireccionSolucion AS 'Direccion Solucion',
				  frm.seqFormulario,
				  frm.txtFormulario,
				  UPPER(CONCAT(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2)) AS 'Nombre',
				  ciu.numDocumento AS 'Documento',
				  CONCAT(eta.txtEtapa,' - ',epr.txtEstadoProceso) AS 'Estado del Proceso',
				  ahv.numActo AS acto,
					ahv.fchActo AS fecha
				FROM T_PRY_UNIDAD_PROYECTO und
				  LEFT JOIN T_FRM_FORMULARIO frm ON (frm.seqUnidadProyecto = und.seqUnidadProyecto)
				  LEFT JOIN T_FRM_HOGAR hog ON (frm.seqFormulario = hog.seqFormulario)
				  LEFT JOIN T_CIU_CIUDADANO ciu ON (hog.seqCiudadano = ciu.seqCiudadano)
				  LEFT JOIN T_FRM_ESTADO_PROCESO epr ON (frm.seqEstadoProceso = epr.seqEstadoProceso)
				  LEFT JOIN T_FRM_ETAPA eta ON (epr.seqEtapa = eta.seqEtapa)
				  LEFT JOIN T_AAD_FORMULARIO_ACTO aac ON (frm.seqFormulario = aac.seqFormulario)
				  LEFT JOIN T_PRY_PROYECTO pro ON (aac.seqProyecto = pro.seqProyecto)
				  LEFT JOIN T_AAD_HOGARES_VINCULADOS ahv ON (aac.seqFormularioActo = ahv.seqFormularioActo)
				  LEFT JOIN T_AAD_TIPO_ACTO ata ON ( ahv.seqTipoActo = ata.seqTipoActo )
				WHERE hog.seqParentesco = 1
				AND pro.seqTipoEsquema = 4
				AND ahv.seqTipoActo = 1
				ORDER BY 1,2,3
      ";
        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "reporteAsignacionUnidadesMejoramiento");
    }

    public function exportableActosAdministrativosEpigrafe() {
        global $aptBd;

        $sql = "
               SELECT 
               aad.numActo as 'Número Resolución',
       aad.fchActo as 'Fecha Resolución',
       year(aad.fchActo) AS Año,
       tad.txtNombreTipoActo as 'Tipo Acto',
       trim(aad.txtValorCaracteristica) as 'Epígrafe '
  FROM    (   sipive.T_AAD_CARACTERISTICA_ACTO tac
           INNER JOIN
              sipive.t_aad_tipo_acto tad
           ON (tac.seqTipoActo = tad.seqTipoActo))
       INNER JOIN
          sipive.T_AAD_ACTO_ADMINISTRATIVO aad
       ON     (aad.seqTipoActo = tad.seqTipoActo)
          AND (aad.seqCaracteristica = tac.seqCaracteristica)
 WHERE aad.seqCaracteristica IN (1, 2, 3, 8, 31)
ORDER BY aad.fchActo DESC;
      ";
        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "reporteEpigrafeAAD");
    }

    public function Caracterizacion() {


        global $aptBd;

        $arrErrores = &$this->arrErrores;


        if (empty($arrErrores)) {

            $sql = "SELECT frm.seqFormulario,
       pry.txtNombreProyecto,
       IF(COUNT(
             IF(cabezaFamilia(ciu.seqCondicionEspecial,
                              ciu.seqCondicionEspecial2,
                              ciu.seqCondicionEspecial3) = 'Si',
                1,
                NULL)) >= 1,
          'Si',
          'No')
          AS CabezaFamilia,
       COUNT(
          IF(cabezaFamilia(ciu.seqCondicionEspecial,
                           ciu.seqCondicionEspecial2,
                           ciu.seqCondicionEspecial3) = 'Si',
             1,
             NULL))
          AS NumCabezaFamilia,
       COUNT(
          IF(
                 cabezaFamilia(ciu.seqCondicionEspecial,
                               ciu.seqCondicionEspecial2,
                               ciu.seqCondicionEspecial3) = 'Si'
             AND (seqSexo = 1),
             1,
             NULL))
          AS Masculino,
       COUNT(
          IF(
                 cabezaFamilia(ciu.seqCondicionEspecial,
                               ciu.seqCondicionEspecial2,
                               ciu.seqCondicionEspecial3) = 'Si'
             AND (seqSexo = 2),
             1,
             NULL))
          AS Femenino,
       IF(COUNT(
             IF(mayor65anos(ciu.seqCondicionEspecial,
                            ciu.seqCondicionEspecial2,
                            ciu.seqCondicionEspecial3) = 'Si',
                1,
                NULL)) >= 1,
          'Si',
          'No')
          AS Mayor65Anos,
       COUNT(
          IF(
                 mayor65anos(ciu.seqCondicionEspecial,
                             ciu.seqCondicionEspecial2,
                             ciu.seqCondicionEspecial3) = 'Si'
             AND (seqSexo = 1),
             1,
             NULL))
          AS '>65-Masculino',
       COUNT(
          IF(
                 mayor65anos(ciu.seqCondicionEspecial,
                             ciu.seqCondicionEspecial2,
                             ciu.seqCondicionEspecial3) = 'Si'
             AND (seqSexo = 2),
             1,
             NULL))
          AS '>65-Femenino',
       IF(COUNT(
             IF(discapacitado(ciu.seqCondicionEspecial,
                              ciu.seqCondicionEspecial2,
                              ciu.seqCondicionEspecial3) = 'Si',
                1,
                NULL)) >= 1,
          'Si',
          'No')
          AS Discapacitado,
       COUNT(
          IF(
                 discapacitado(ciu.seqCondicionEspecial,
                               ciu.seqCondicionEspecial2,
                               ciu.seqCondicionEspecial3) = 'Si'
             AND (seqSexo = 1),
             1,
             NULL))
          AS 'Disc-Masculino',
       COUNT(
          IF(
                 discapacitado(ciu.seqCondicionEspecial,
                               ciu.seqCondicionEspecial2,
                               ciu.seqCondicionEspecial3) = 'Si'
             AND (seqSexo = 2),
             1,
             NULL))
          AS 'Disc-Femenino',
       COUNT(frm.seqformulario) AS TotalMiembros,
       COUNT(IF(seqSexo = 1, 1, NULL)) AS MiembrosMasculino,
       COUNT(IF(seqSexo = 2, 1, NULL)) AS MiembrosFemenino,
       COUNT(
          IF(
             rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)))   = '0 a 5',
             1,
             NULL))
          AS '0 a 5',
       COUNT(
          IF(
             rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)))   = '6 a 13',
             1,
             NULL))
          AS '6 a 13',
       COUNT(
          IF(
             rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)))   = '14 a 17',
             1,
             NULL))
          AS '14 a 17',
       COUNT(
          IF(
             rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)))   = '18 a 26',
             1,
             NULL))
          AS '18 a 26',
       COUNT(
          IF(
             rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)))   = '27 a 59',
             1,
             NULL))
          AS '27 a 59',
       COUNT(
          IF(
             rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)))   = 'Mayor de 60',
             1,
             NULL))
          AS 'Mayor de 60',
       IF(COUNT(IF(ciu.seqEtnia <> 1, 1, NULL) >= 1), 'Si', 'No') AS Etnia,
       #COUNT(IF(ciu.seqEtnia = 1, 1, NULL)) AS Ninguna,               #Ninguna
       COUNT(IF(ciu.seqEtnia = 2, 1, NULL)) AS Indigena,             #Indigena
       COUNT(IF(ciu.seqEtnia = 3, 1, NULL)) AS ROM,                       #ROM
       COUNT(IF(ciu.seqEtnia = 4, 1, NULL)) AS Raizal,                 #Raizal
       COUNT(IF(ciu.seqEtnia = 5, 1, NULL)) AS Palenquero,         #Palenquero
       COUNT(IF(ciu.seqEtnia = 6, 1, NULL)) AS Afrocolombiano, #Afrocolombiano
       COUNT(
          IF(
                 ((FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365))) >= 14) # mayor o igual a 14 años
             AND (ciu.seqNivelEducativo <= 3), # menor o igual a primaria completa
             1,
             NULL))
          AS Analfabetismo
  FROM T_FRM_FORMULARIO frm
       INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
       INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
       LEFT JOIN T_CIU_ETNIA etn ON ciu.seqEtnia = etn.seqEtnia
       INNER JOIN t_ciu_nivel_educativo edu
          ON ciu.seqNivelEducativo = edu.seqNivelEducativo
       LEFT JOIN T_PRY_PROYECTO pry ON pry.seqProyecto = frm.seqProyecto
 WHERE frm.seqFormulario in (" . $this->seqFormularios . ")
     GROUP BY frm.seqFormulario
				";

            try {
                //pr ($sql); die();
                //echo'hasta aca entro';
                $objRes = $aptBd->execute($sql);
                //pr($objRes);
                //die();
                $arrTitulosCampos[] = 'seqFormulario';
                $arrTitulosCampos[] = 'txtNombreProyecto';
                $arrTitulosCampos[] = 'CabezaFamilia';
                $arrTitulosCampos[] = 'NumCabezaFamilia';
                $arrTitulosCampos[] = 'Masculino';
                $arrTitulosCampos[] = 'Femenino';
                $arrTitulosCampos[] = 'Mayor65Anos';
                $arrTitulosCampos[] = '>65-Masculino';
                $arrTitulosCampos[] = '>65-Femenino';
                $arrTitulosCampos[] = 'Discapacitado';
                $arrTitulosCampos[] = 'Disc-Masculino';
                $arrTitulosCampos[] = 'Disc-Femenino';
                $arrTitulosCampos[] = 'TotalMiembros';
                $arrTitulosCampos[] = 'MiembrosMasculino';
                $arrTitulosCampos[] = 'MiembrosFemenino';
                $arrTitulosCampos[] = '0 a 5';
                $arrTitulosCampos[] = '6 a 13';
                $arrTitulosCampos[] = '14 a 17';
                $arrTitulosCampos[] = '18 a 26';
                $arrTitulosCampos[] = '27 a 59';
                $arrTitulosCampos[] = 'Mayor de 60';
                $arrTitulosCampos[] = 'Etnia';
                $arrTitulosCampos[] = 'Indigena';
                $arrTitulosCampos[] = 'ROM';
                $arrTitulosCampos[] = 'Raizal';
                $arrTitulosCampos[] = 'Palenquero';
                $arrTitulosCampos[] = 'Afrocolombiano';
                $arrTitulosCampos[] = 'Analfabetismo';


                $this->obtenerReportesGeneral($objRes, "Caracterizacion", $arrTitulosCampos);
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {

                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    public function reporteBasedeDatosPoblacional() {

        global $aptBd;

        $fechaIni = $_POST['fchInicio'];
        $fechaFin = $_POST['fchFin'];

        $arrCondiciones[] = "ciu.fchNacimiento > 0000-00-00";

        if ($fechaIni) {
            $arrCondiciones[] = "fchUltimaActualizacion >= '$fechaIni.00:00:00'";
        } else {
            $arrCondiciones[] = "ciu.numDocumento > '0'";
        }
        if ($fechaFin) {
            $arrCondiciones[] = "fchUltimaActualizacion <= '$fechaFin.23:59:59'";
        } else {
            $arrCondiciones[] = "ciu.numDocumento > '0'";
        }

        $txtCondicion = implode(" and ", $arrCondiciones);


        $sql = "SELECT ciu.seqCiudadano AS id,
		frm.seqFormulario AS idhogar,
		DATE_FORMAT(frm.fchUltimaActualizacion, '%d-%m-%Y')
          AS  ultimaactualizacion,
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

        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "reporteBasedeDatosPoblacional");
    }

    public function InformacionSolucion() {
        global $aptBd;

        $arrErrores = &$this->arrErrores;
        if (empty($arrErrores)) {
            $sql = "
                SELECT 
                    frm.seqFormulario AS 'id Hogar',
                    ciu.numDocumento 'CC Postulante Principal',
                    tdo.txtTipoDocumento AS 'Tipo Documento',
                    UPPER(CONCAT(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) AS 'Nombre',
                    frm.txtFormulario AS 'Formulario', 
                    frm.seqProyecto AS 'Proyecto Padre', 
                    frm.seqProyectoHijo AS 'Proyecto Hijo',
                    pry.txtNombreProyecto AS 'Proyecto',
                    frm.seqUnidadproyecto, und.txtNombreunidad AS 'Unidad Proyecto',
                    und.valSDVEAprobado AS 'Valor Aprobado', 
                    und.valSDVEActual AS 'Valor Actual',
                    tec.txtexistencia AS 'Viabilidad Tecnica', 
                    CONCAT('Res. ', aad.numActo) AS 'Resolucion Vinculacion',
                    YEAR(aad.fchActo) AS 'Año', 
                    aad.fchActo AS 'Fecha Resolucion', 
                    CONCAT(eta.txtEtapa, ' - ', epr.txtEstadoProceso) AS 'Estado del Proceso', 
                    frm.valAspiraSubsidio AS 'Valor Subsidio',
                    frm.valCartaLeasing AS 'Valor Carta Leasing',
                    con.txtBanco as 'Banco Convenio Leasing',
                    IF(frm.SeqProyectoHijo = '', UPPER(pry.txtNombreComercial), UPPER(prh.txtNombreComercial)) AS 'Nombre Comercial', 
                    und.txtNombreunidad AS 'Descripcion de la Unidad',
                    (
                      SELECT GROUP_CONCAT(DISTINCT (UPPER(CONCAT(CONVERT(ciu1.txtNombre1 USING utf8), ' ', CONVERT(ciu1.txtNombre2 USING utf8), ' ', CONVERT(ciu1.txtApellido1 USING utf8), ' ', 
                              CONVERT(ciu1.txtApellido2 USING utf8)))), ' ', CONVERT(tdo.txtTipoDocumento USING utf8),' ', ciu1.numDocumento, ' ',  civ.txtEstadocivil, ' ' SEPARATOR' -- ')
                      FROM T_FRM_HOGAR hog1
                      INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
                      WHERE hog1.seqFormulario =  hog.seqFormulario 
                        and ( ciu1.seqTipoDocumento =1 OR ciu1.seqTipoDocumento =2 OR ciu1.seqTipoDocumento =5 )
                    ) AS 'Miembros Mayores de Edad'
                FROM T_FRM_FORMULARIO frm 
                INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
                INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
                INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON tdo.seqTipoDocumento  = ciu.seqTipoDocumento
                INNER JOIN T_CIU_PARENTESCO par ON par.seqParentesco = hog.seqParentesco 
                INNER JOIN T_CIU_ESTADO_CIVIL civ ON civ.seqEstadoCivil = ciu.seqEstadoCivil 
                LEFT JOIN V_FRM_CONVENIO con ON frm.seqConvenio = con.seqConvenio
                LEFT JOIN T_PRY_PROYECTO pry ON frm.seqProyecto = pry.seqProyecto
                LEFT JOIN T_PRY_PROYECTO prh ON frm.seqProyectoHijo = prh.seqProyecto 
                LEFT JOIN T_PRY_UNIDAD_PROYECTO und ON frm.seqFormulario = und.seqFormulario 
                LEFT JOIN T_PRY_TECNICO tec ON und.seqUnidadProyecto = tec.seqUnidadProyecto
                LEFT JOIN T_FRM_ESTADO_PROCESO epr ON frm.seqEstadoProceso = epr.seqEstadoProceso 
                LEFT JOIN T_FRM_ETAPA eta ON epr.seqEtapa = eta.seqEtapa
                LEFT JOIN T_AAD_FORMULARIO_ACTO fac ON frm.seqFormulario = fac.seqFormulario 
                LEFT JOIN T_AAD_HOGARES_VINCULADOS hvi ON fac.seqFormularioActo = hvi.seqFormularioActo 
                INNER JOIN (SELECT * FROM T_AAD_ACTO_ADMINISTRATIVO ORDER BY T_AAD_ACTO_ADMINISTRATIVO.fchActo DESC) AS aad ON ( hvi.numActo = aad.numActo AND hvi.fchActo = aad.fchActo)
                WHERE ( tdo.seqTipoDocumento = 1 OR tdo.seqTipoDocumento = 2 OR tdo.seqTipoDocumento = 5 ) 
                  AND hog.seqParentesco = 1  
                  AND frm.seqFormulario IN (" . $this->seqFormularios . ")
                GROUP BY frm.seqFormulario 
                ORDER BY frm.seqFormulario
            ";
            try {
//                echo $sql; die();
                $objRes = $aptBd->execute($sql);
                $this->obtenerReportesGeneral($objRes, "InformacionSolucion");
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }

            if (!empty($arrErrores)) {
                imprimirMensajes($arrErrores, array());
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
    }

    //Plantilla Estudio Titulos 
    public function plantillaestudiotitulos() {
        plantillaestudiotitulos($this->seqFormularios);
    }

    public function informeProyectos() {
        informeProyectosActo();
    }

    public function registrosCiudadano($arrDocumentos) {

        obtenerRegistroCiudadano($arrDocumentos);
    }

//    public function encuestasPive(){
//
//        global $aptBd;
//
//        $this->arrErrores = array();
//
//        $arrTitulos['formulario'][1] = "seqFormulario";
//        $arrTitulos['formulario'][2] = "NombreEncuesta";
//        $arrTitulos['formulario'][3] = "NombreCargue";
//        $arrTitulos['formulario'][4] = "FechaAplicacion";
//        $arrTitulos['formulario'][5] = "FechaCarga";
//        $arrTitulos['formulario'][6] = "TipoDocumentoPostulantePrincipal";
//        $arrTitulos['formulario'][7] = "DocumentoPostulantePrincipal";
//        $arrTitulos['formulario'][8] = "NombrePostulantePrincipal";
//        $arrTitulos['formulario'][9] = "FormularioEncuesta";
//        $arrTitulos['formulario'][10] = "txtUsuarioSistema";
//        $arrTitulos['formulario'][11] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] CÉDULA DE CIUDADANÍA";
//        $arrTitulos['formulario'][12] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] TARJETA DE IDENTIDAD";
//        $arrTitulos['formulario'][13] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] REGISTRO CIVIL";
//        $arrTitulos['formulario'][14] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] NO TIENE";
//        $arrTitulos['formulario'][15] = "[ NUMERO_DOC ] NUMERO DE DOCUMENTO";
//        $arrTitulos['formulario'][16] = "[ P13_1 ] PRIMER NOMBRE";
//        $arrTitulos['formulario'][17] = "[ P13_2 ] SEGUNDO NOMBRE";
//        $arrTitulos['formulario'][18] = "[ P13_3 ] PRIMER APELLIDO";
//        $arrTitulos['formulario'][19] = "[ P13_4 ] SEGUNDO APELLIDO";
//        $arrTitulos['formulario'][20] = "[ P26 ] ¿CUÁNTOS HOGARES CONVIVEN EN ESTA VIVIENDA?";
//        $arrTitulos['formulario'][21] = "[ P29 ] ¿EN CUÁNTOS DE ESTOS CUARTOS DUERMEN LAS PERSONAS DE ESTE HOGAR?";
//        $arrTitulos['ciudadano'][22] = "[ N_ORDEN ] ORDEN DEL CIUDADANO";
//        $arrTitulos['ciudadano'][23] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] CÉDULA DE CIUDADANÍA";
//        $arrTitulos['ciudadano'][24] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] TARJETA DE IDENTIDAD";
//        $arrTitulos['ciudadano'][25] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] REGISTRO CIVIL";
//        $arrTitulos['ciudadano'][26] = "[ TIPO_DOCUMENTO ] TIPO DE DOCUMENTO / [ TIPO_DOCUMENTO ] NO TIENE";
//        $arrTitulos['ciudadano'][27] = "[ P31_1 ] PRIMER NOMBRE";
//        $arrTitulos['ciudadano'][28] = "[ P31_2 ] SEGUNDO NOMBRE";
//        $arrTitulos['ciudadano'][29] = "[ P31_3 ] PRIMER APELLIDO";
//        $arrTitulos['ciudadano'][30] = "[ P31_4 ] SEGUNDO APELLIDO";
//        $arrTitulos['ciudadano'][31] = "[ NUM_DOCUM ] NUMERO DE DOCUMENTO";
//        $arrTitulos['ciudadano'][32] = "[ P340A ] CUÁNTO RECIBE MENSUALMENTE EN PROMEDIO POR LOS SIGUIENTES CONCEPTOS / [ P340A ] TRABAJO ASALARIADO";
//        $arrTitulos['ciudadano'][33] = "[ P340B ] CUÁNTO RECIBE MENSUALMENTE EN PROMEDIO POR LOS SIGUIENTES CONCEPTOS / [ P340B ] TRABAJO INDEPENDIENTE";
//        $arrTitulos['ciudadano'][34] = "[ P340C ] CUÁNTO RECIBE MENSUALMENTE EN PROMEDIO POR LOS SIGUIENTES CONCEPTOS / [ P340C ] PENSIONES (JUBILACIÓN, INVALIDEZ, VEJEZ, ETC.)";
//        $arrTitulos['ciudadano'][35] = "SUMA INGRESO CIUDADANO";
//        $arrTitulos['ciudadano'][36] = "SUMA INGRESO HOGAR";
//
//        if($_FILES['fileSecuenciales']['error'] != 4) {
//            switch ($_FILES['fileSecuenciales']['error']) {
//                case UPLOAD_ERR_INI_SIZE:
//                    $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
//                    break;
//                case UPLOAD_ERR_FORM_SIZE:
//                    $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" Excede el tamaño permitido";
//                    break;
//                case UPLOAD_ERR_PARTIAL:
//                    $this->arrErrores[] = "El archivo \"" . $_FILES['archivo']['name'] . "\" no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
//                    break;
//                default:
//                    $arrExtensiones = array("txt", "csv");
//                    $numPunto = strpos($_FILES['fileSecuenciales']['name'], ".") + 1;
//                    $numRestar = (strlen($_FILES['fileSecuenciales']['name']) - $numPunto) * -1;
//                    $txtExtension = substr($_FILES['fileSecuenciales']['name'], $numRestar);
//                    if (!in_array(strtolower($txtExtension), $arrExtensiones)) {
//                        $this->arrErrores[] = "Tipo de Archivo no permitido $txtExtension ";
//                    }
//                    break;
//            }
//        }
//
//        if( empty( $this->arrErrores )){
//
//            $arrDocumentos = array();
//            if( $_FILES['fileSecuenciales']['error'] != UPLOAD_ERR_NO_FILE ){
//                $arrDocumentos = mb_split("\n", file_get_contents($_FILES['fileSecuenciales']['tmp_name']));
//                foreach ($arrDocumentos as $numLinea => $numDocumento) {
//                    if (doubleval($numDocumento) != 0) {
//                        $arrFormularios[] = Ciudadano::formularioVinculado( doubleval($numDocumento) );
//                    }
//                }
//            }else{
////                $arrDocumentos[] = 26344065;
////                foreach ($arrDocumentos as $numLinea => $numDocumento) {
////                    if (doubleval($numDocumento) != 0) {
////                        $arrFormularios[] = Ciudadano::formularioVinculado( doubleval($numDocumento) );
////                    }
////                }
//            }
//
//            // Titulos
//            $arrDatos[0][0]  = $arrTitulos['formulario'];
//            $arrDatos[0][0] += $arrTitulos['ciudadano'];
//
//            $txtCondicion = "";
//            if( ! empty( $arrDocumentos ) ) {
//                $txtCondicion = "and apl.seqFormulario IN (" . implode(",", $arrFormularios) . ")";
//            }
//
//            // Variables del ciudadano a extraer
//            $sql = "
//                select
//                  apl.seqFormulario,
//                  aci.numOrden,
//                  IF(
//                    pre.txtPregunta = res.txtRespuesta,
//                    CONCAT( '[ ', pre.txtIdentificador , ' ] ', pre.txtPregunta ),
//                    CONCAT( '[ ', pre.txtIdentificador , ' ] ', pre.txtPregunta , ' / [ ', res.txtIdentificador , ' ] ', res.txtRespuesta  )
//                  ) as txtPregunta,
//                  aci.valRespuesta
//                from t_enc_aplicacion apl
//                inner join t_enc_diseno dis on apl.seqDiseno = dis.seqDiseno
//                inner join t_cor_usuario usu on apl.seqUsuarioCarga = usu.seqUsuario
//                inner join t_frm_hogar hog on apl.seqFormulario = hog.seqFormulario
//                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
//                inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
//                left join t_enc_aplicacion_ciudadano aci on apl.seqAplicacion = aci.seqAplicacion
//                left join t_enc_respuesta res on aci.seqRespuesta = res.seqRespuesta
//                left join t_enc_pregunta pre on res.seqPregunta = pre.seqPregunta
//                where apl.bolActiva = 1
//                  and dis.bolActivo = 1
//                  and apl.seqDiseno = 1
//                  and hog.seqParentesco = 1
//                  and res.txtIdentificador in ('N_ORDEN','P31_1','P31_2','P31_3','P31_4','TIPO_DOCUMENTO','NUM_DOCUM','P340A','P340B','P340C')
//                  $txtCondicion
//                order by
//                  apl.seqFormulario, aci.numOrden, aci.seqAplicacionCiudadano
//            ";
//            $objRes = $aptBd->execute($sql);
//            while( $objRes->fields ){
//                $seqFormulario = $objRes->fields['seqFormulario'];
//                $numOrden = $objRes->fields['numOrden'];
//                unset($objRes->fields['seqFormulario']);
//                unset($objRes->fields['numOrden']);
//                $numColumna = intval(array_shift(array_keys($arrTitulos['ciudadano'],$objRes->fields['txtPregunta'])));
//                $arrDatos[$seqFormulario][$numOrden][$numColumna] = $objRes->fields['valRespuesta'];
//                $objRes->MoveNext();
//            }
//
//            $sql = "
//                select
//                  apl.seqFormulario,
//                  dis.txtDiseno as NombreEncuesta,
//                  apl.txtNombreCargue as NombreCargue,
//                  apl.fchAplicacion as FechaAplicacion,
//                  apl.fchCarga as FechaCarga,
//                  tdo.txtTipoDocumento as TipoDocumentoPostulantePrincipal,
//                  ciu.numDocumento as DocumentoPostulantePrincipal,
//                  CONCAT( TRIM(ciu.txtNombre1), ' ' ,TRIM(ciu.txtNombre2), ' ' ,TRIM(ciu.txtApellido1), ' ' ,TRIM(ciu.txtApellido2) ) as NombrePostulantePrincipal,
//                  apl.txtFormulario as FormularioEncuesta,
//                  CONCAT( usu.txtNombre, ' ' , usu.txtApellido ) as txtUsuarioSistema,
//                  IF(
//                    pre.txtPregunta = res.txtRespuesta,
//                    CONCAT( '[ ', pre.txtIdentificador , ' ] ', pre.txtPregunta ),
//                    CONCAT( '[ ', pre.txtIdentificador , ' ] ', pre.txtPregunta , ' / [ ', res.txtIdentificador , ' ] ', res.txtRespuesta  )
//                  ) as txtPregunta,
//                  afo.valRespuesta
//                from t_enc_aplicacion apl
//                inner join t_enc_diseno dis on apl.seqDiseno = dis.seqDiseno
//                inner join t_cor_usuario usu on apl.seqUsuarioCarga = usu.seqUsuario
//                inner join t_frm_hogar hog on apl.seqFormulario = hog.seqFormulario
//                inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
//                inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
//                left join t_enc_aplicacion_formulario afo on apl.seqAplicacion = afo.seqAplicacion
//                left join t_enc_respuesta res on afo.seqRespuesta = res.seqRespuesta
//                left join t_enc_pregunta pre on res.seqPregunta = pre.seqPregunta
//                where apl.bolActiva = 1
//                  and dis.bolActivo = 1
//                  and apl.seqDiseno = 1
//                  and hog.seqParentesco = 1
//                  and res.txtIdentificador in ('P13_1','P13_2','P13_3','P13_4','TIPO_DOCUMENTO','NUMERO_DOC','P26','P29')
//                  $txtCondicion
//                order by
//                  apl.seqFormulario,afo.seqAplicacionFormulario
//            ";
//            $objRes = $aptBd->execute($sql);
//            while( $objRes->fields ){
//                $seqFormulario = $objRes->fields['seqFormulario'];
//                foreach($objRes->fields as $txtCampo => $txtValor){
//                    $numColumna = intval(array_shift(array_keys($arrTitulos['formulario'],$txtCampo)));
//                    if($numColumna == 0){
//                        $numColumna = intval(array_shift(array_keys($arrTitulos['formulario'],$objRes->fields['txtPregunta'])));
//                    }
//                    foreach($arrDatos[$seqFormulario] as $numOrden => $arrColumnas ){
//                        $arrDatos[$seqFormulario][$numOrden][$numColumna] = $txtValor;
//                        ksort($arrDatos[$seqFormulario][$numOrden]);
//                    }
//                }
//                $objRes->MoveNext();
//            }
//
//            foreach($arrDatos as $seqFormulario => $arrOrden){
//                if($seqFormulario != 0) {
//                    $arrSuma[$seqFormulario] = 0;
//                    foreach ($arrOrden as $numOrden => $arrColumnas) {
//                        $arrDatos[$seqFormulario][$numOrden][35] = doubleval($arrColumnas[32]) + doubleval($arrColumnas[33]) + doubleval($arrColumnas[34]);
//                        $arrSuma[$seqFormulario] += doubleval($arrDatos[$seqFormulario][$numOrden][35]);
//                    }
//                }
//            }
//
//            foreach($arrDatos as $seqFormulario => $arrOrden){
//                if($seqFormulario != 0) {
//                    foreach ($arrOrden as $numOrden => $arrColumnas) {
//                        $arrDatos[$seqFormulario][$numOrden][36] = $arrSuma[$seqFormulario];
//                    }
//                }
//            }
//
//        }
//
//        $txtNombreArchivo = "encuestasPive_" . date("Ymd_His") . ".xls";
//
//        header("Content-disposition: attachment; filename=$txtNombreArchivo");
//        header("Content-Type: application/force-download");
//        header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
//        header("Content-Transfer-Encoding: binary");
//        header("Pragma: no-cache");
//        header("Expires: 1");
//
//        foreach($arrDatos as $seqFormulario => $arrOrden){
//            foreach($arrOrden as $numOrden => $arrColumnas){
//                foreach($arrDatos[0][0] as $numColumna => $txtTitulo){
//                    if($arrColumnas[$numColumna] != ""){
//                        echo utf8_decode($arrColumnas[$numColumna]);
//                    }
//                    echo "\t";
//                }
//                echo "\r\n";
//            }
//        }
//
//        //return true;
//
//    }

    public function encuestasPiveCruces() {
        global $aptBd;

        $arrCalificados = array();
        $arrEncuestas = array();

        switch ($_FILES['fileSecuenciales']['error']) {
            case UPLOAD_ERR_NO_FILE:
                $this->arrErrores[] = "Para este reporte debe proporcionar un archivo de documentos de postulante principal";
                break;
        }

        if (empty($this->arrErrores)) {
            $sql = "
                select 
                  frm.seqFormulario as 'FORMULARIO',
                  moa.txtModalidad as 'MODALIDAD',
                  CONCAT( eta.txtEtapa, ' - ', epr.txtEstadoProceso ) as 'ESTADO',
                  tdo.txtTipoDocumento as 'TIPO DOCUMENTO',
                  ciu.numDocumento as 'DOCUMENTO',
                  CONCAT( ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2 )  as 'NOMBRE',
                  par.txtParentesco as 'PARENTESCO',
                  '' as 'ENTIDAD',
                  '' as 'CAUSA',
                  '' as 'DETALLE',
                  '' as 'INHABILITAR',
                  '' as 'OBSERVACIONES'
                from t_frm_formulario frm
                inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario
                inner join t_ciu_ciudadano ciu on ciu.seqCiudadano = hog.seqCiudadano and hog.seqParentesco = 1
                inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
                inner join t_ciu_parentesco par on hog.seqParentesco = par.seqParentesco
                inner join t_frm_modalidad moa on frm.seqModalidad = moa.seqModalidad
                inner join t_frm_estado_proceso epr on frm.seqEstadoProceso = epr.seqEstadoProceso
                inner join t_frm_etapa eta on epr.seqEtapa = eta.seqEtapa
                where frm.seqFormulario in (" . implode($this->arrSeqFormularios, ",") . ")
            ";
            $arrCalificados = $aptBd->GetAll($sql);
            foreach ($arrCalificados as $numLinea => $arrDatos) {

                $claFormulario = new FormularioSubsidios();
                $claFormulario->cargarFormulario($arrDatos["FORMULARIO"]);

                $claEncuesta = new Encuestas();
                $arrVariables = $claEncuesta->obtenerVariablesCalificacion($arrDatos['DOCUMENTO']);

                if (empty($arrVariables['errores'])) {

                    $bolSinErrores = true;

                    // suma los documentos dela base de datos
                    // y cuenta otras variables para cruces
                    $numMiembrosFormulario = count($claFormulario->arrCiudadano);
                    $numDocumentosFormulario = 0;
                    $numEtnias = 0;
                    $numCondiciones = 0;
                    $numSalud = 0;
                    foreach ($claFormulario->arrCiudadano as $objCiudadano) {
                        $numDocumentosFormulario += $objCiudadano->numDocumento;
                        if (intval($objCiudadano->seqEtnia) > 1) {
                            $numEtnias++;
                        }
                        if (intval($objCiudadano->seqCondicionEspecial) == 3 or
                                intval($objCiudadano->seqCondicionEspecial2) == 3 or
                                intval($objCiudadano->seqCondicionEspecial3) == 3
                        ) {
                            $numCondiciones++;
                        }
                        if (intval($objCiudadano->seqSalud) == 1 or
                                intval($objCiudadano->seqSalud) == 2
                        ) {
                            $numSalud++;
                        }
                    }

                    // suma los documentos de las encuestas
                    $numDocumentosEncuesta = 0;
                    foreach ($arrVariables['variables']['edades'] as $cedula => $edad) {
                        $numDocumentosEncuesta += $cedula;
                    }

                    // inhabilidad para cantidad de miembros de hogar
                    if ($numMiembrosFormulario != $arrVariables['variables']['cant']) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Conformación del hogar";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Miembros Inscritos SiPIVE: " . $numMiembrosFormulario . "; Miembros Encuesta: " . $arrVariables['variables']['cant'];
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad de sumas de documentos
                    if ($numDocumentosFormulario != $numDocumentosEncuesta) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Conformación del hogar";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Diferiere Número de Documento de al menos un miembro del hogar";
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad por etnia
                    if ($numEtnias != $arrVariables['variables']['condicionEtnica']) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Condición étnica";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Condiciones étnicas en SiPIVE: " . $numEtnias . "; Condiciones étnicas en Encuesta: " . $arrVariables['variables']['condicionEtnica'];
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad por condiciones especiales
                    if ($numCondiciones != $arrVariables['variables']['cantCondEspecial']) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Discapacidad";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Discapacidades en SiPIVE: " . $numCondiciones . "; Discapacidades en Encuesta: " . $arrVariables['variables']['cantCondEspecial'];
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad por afiliacion a salud
                    if ($numSalud != $arrVariables['variables']['afiliacion']) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Afiliación a salud";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Afiliación a salud en SiPIVE: " . $numSalud . "; Afiliación a salud en Encuesta: " . $arrVariables['variables']['afiliacion'];
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad cohabitacion
                    if ($arrVariables['variables']['cohabitacion'] != $claFormulario->numHabitaciones) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Cohabitación";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Hogares en SiPIVE: " . $claFormulario->numHabitaciones . "; Hogares en Encuesta: " . $arrVariables['variables']['cohabitacion'];
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad dormitorios
                    if ($arrVariables['variables']['dormitorios'] != $claFormulario->numHacinamiento) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Hacinamiento";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Dormitorios en SiPIVE: " . $claFormulario->numHacinamiento . "; Dormitorios en Encuesta: " . $arrVariables['variables']['dormitorios'];
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad ingresos
                    if ($arrVariables['variables']['ingresos'] != $claFormulario->valIngresoHogar) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Ingresos del Hogar";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Ingresos en SiPIVE: " . number_format($claFormulario->valIngresoHogar, "0", ".", ",") . ";  Ingresos en Encuesta: " . number_format($arrVariables['variables']['ingresos'], "0", ".", ",");
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad integracion social
                    if ($claFormulario->bolIntegracionSocial != $arrVariables['variables']['bolIntegracionSocial']) {
                        $txtIntegracionFormulario = ($claFormulario->bolIntegracionSocial == 1) ? "SI" : "NO";
                        $txtIntegracionEncuesta = ($arrVariables['variables']['bolIntegracionSocial'] == 1) ? "SI" : "NO";
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Programas Distrito";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Integración social en SiPIVE: " . $txtIntegracionFormulario . ";  Integración social en Encuesta: " . $txtIntegracionEncuesta;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad educacion
                    if ($claFormulario->bolSecEducacion != $arrVariables['variables']['bolSecEducacion']) {
                        $txtEducacionFormulario = ($claFormulario->bolSecEducacion == 1) ? "SI" : "NO";
                        $txtEducacionEncuesta = ($arrVariables['variables']['bolSecEducacion'] == 1) ? "SI" : "NO";
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Programas Distrito";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Secretaría de educación en SiPIVE: " . $txtEducacionFormulario . ";  Secretaría de educación en Encuesta: " . $txtEducacionEncuesta;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad secretaria de la mujer
                    if ($claFormulario->bolSecMujer != $arrVariables['variables']['bolSecMujer']) {
                        $txtMujerFormulario = ($claFormulario->bolSecMujer == 1) ? "SI" : "NO";
                        $txtMujerEncuesta = ($arrVariables['variables']['bolSecMujer'] == 1) ? "SI" : "NO";
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Programas Distrito";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Secretaría de la mujer en SiPIVE: " . $txtMujerFormulario . ";  Secretaría de la mujer en Encuesta: " . $txtMujerEncuesta;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad secretaria de salud
                    if ($claFormulario->bolSecSalud != $arrVariables['variables']['bolSecSalud']) {
                        $txtSaludFormulario = ($claFormulario->bolSecSalud == 1) ? "SI" : "NO";
                        $txtSaludEncuesta = ($arrVariables['variables']['bolSecSalud'] == 1) ? "SI" : "NO";
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Programas Distrito";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Secretaría de salud en SiPIVE: " . $txtSaludFormulario . ";  Secretaría de salud en Encuesta: " . $txtSaludEncuesta;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad alta consejeria
                    if ($claFormulario->bolAltaCon != $arrVariables['variables']['bolAltaCon']) {
                        $txtAltaFormulario = ($claFormulario->bolAltaCon == 1) ? "SI" : "NO";
                        $txtAltaEncuesta = ($arrVariables['variables']['bolAltaCon'] == 1) ? "SI" : "NO";
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Programas Distrito";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Secretaría de salud en SiPIVE: " . $txtAltaFormulario . ";  Secretaría de salud en Encuesta: " . $txtAltaEncuesta;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }

                    // inhabilidad IPES
                    if ($claFormulario->bolIpes != $arrVariables['variables']['bolIpes']) {
                        $txtIpesFormulario = ($claFormulario->bolIpes == 1) ? "SI" : "NO";
                        $txtIpesEncuesta = ($arrVariables['variables']['bolIpes'] == 1) ? "SI" : "NO";
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Programas Distrito";
                        $arrEncuestas[$numPosicion]['DETALLE'] = "Secretaría de salud en SiPIVE: " . $txtIpesFormulario . ";  Secretaría de salud en Encuesta: " . $txtIpesEncuesta;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }
                } else {
                    foreach ($arrVariables['errores'] as $txtError) {
                        $numPosicion = count($arrEncuestas);
                        $arrEncuestas[$numPosicion] = $arrDatos;
                        $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                        $arrEncuestas[$numPosicion]['CAUSA'] = "Diligenciamiento del formato";
                        $arrEncuestas[$numPosicion]['DETALLE'] = $txtError;
                        $arrEncuestas[$numPosicion]['INHABILITAR'] = "SI";
                        $bolSinErrores = false;
                    }
                }

                if ($bolSinErrores == true) {
                    $numPosicion = count($arrEncuestas);
                    $arrEncuestas[$numPosicion] = $arrDatos;
                    $arrEncuestas[$numPosicion]['ENTIDAD'] = "Encuesta";
                    $arrEncuestas[$numPosicion]['CAUSA'] = "";
                    $arrEncuestas[$numPosicion]['DETALLE'] = "";
                    $arrEncuestas[$numPosicion]['INHABILITAR'] = "NO";
                }

                $claEncuesta = null;
                $claFormulario = null;
            }

            $this->obtenerReportesGeneral($arrEncuestas, "encuestasCrucesPive");
        } else {
            imprimirMensajes($this->arrErrores, array());
        }
    }

    public function estudioTitulosLeasing() {
        global $txtPrefijoRuta, $arrConfiguracion, $aptBd;

        // consulta de los datos
        $sql = "
            select
                frm.seqFormulario as 'ID HOGAR',
                ciu.numDocumento as 'CC POSTULANTE PRINCIPAL',
                tdo.txtTipoDocumento as 'TIPO DE DOCUMENTO',
                upper(concat(ciu.txtNombre1, ' ', ciu.txtNombre2, ' ', ciu.txtApellido1, ' ', ciu.txtApellido2)) as 'NOMBRE POSTULANTE PRINCIPAL',
                pry1.txtNombreProyecto as 'PROYECTO',
                pry2.txtNombreProyecto as 'CONJUNTO',  
                upr.txtNombreUnidad as 'DESCRIPCION DE LA UNIDAD',
                esc.txtNombreVendedor 'PROPIETARIO',
                esc.txtDireccionInmueble as 'DIRECCION INMUEBLE', 
                esc.numContratoLeasing as 'NUMERO CONTRATO LEASING',
                esc.fchContratoLeasing as 'FECHA CONTRATO LEASING',
                pte.txtExistencia as 'CERTIFICADO DE EXISTENCIA Y HABITABILIDAD',
                esc.numValorInmueble  as 'VALOR INMUEBLE',
                aad.numActo as 'NUMERO DEL ACTO',
                date_format(aad.fchActo,'%Y-%m-%d') as 'FECHA DEL ACTO',
                '' as 'No. ESCRITURA', 
                '' as 'FECHA ESCRITURA', 
                '' as 'NOTARIA', 
                '' as 'CIUDAD NOTARIA', 
                '' as 'FOLIO DE MATRICULA', 
                '' as 'ZONA OFICINA REGISTRO', 
                '' as 'CIUDAD OFICINA REGISTRO', 
                '' as 'FECHA FOLIO', 
                '' as 'RESOLUCION DE VINCULACION COINCIDENTE', 
                '' as 'CARTA DE VINCULACION Y/O RESOLUCION PROTOCOLIZADA', 
                '' as 'ANOTACION CTL COMPRAVENTA', 
                '' as 'SE CANCELA HIPOTECA MAYOR EXTENSION (SI LA HUBIERE)', 
                '' as 'NUMERO Y FECHA DE CONTRATO LEASING',
                '' as 'DETERMINACIÓN DEL APORTE DEL DISTRITO CAPITAL EN LA ESCRITURA',
                '' as 'CLAUSULAS DONDE SE ESPECIFIQUEN RESTRICCIONES Y PROHIBICIONES EN EL CONTRATO',
                '' as 'RELACIÓN DE LOS INTEGRANTES DEL HOGAR EN LA ESCRITURA',
                '' as 'IMPUESTOS CON CARGO AL APORTE DEL DISTRITO CAPITAL',                
                '' as 'BENEFICIO DEL APORTE SEA EL LOCATARIO DEL CONTRATO DE LEASING',
                '' as 'PROPIEDAD DE LA ENTIDAD FINANCIERA OTORGANTE DEL LEASING EN CTL',
                '' as 'SE VIABILIZA JURIDICAMENTE',
                '' as 'ELABORO', 
                '' as 'APROBO',
                '' as 'OBSERVACION'  
            from t_frm_formulario frm
            inner join t_frm_hogar hog on frm.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
            inner join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
            inner join t_ciu_tipo_documento tdo on ciu.seqTipoDocumento = tdo.seqTipoDocumento
            inner join t_des_escrituracion esc on frm.seqFormulario = esc.seqFormulario
            inner join t_pry_proyecto pry1 on pry1.seqProyecto = frm.seqProyecto
            left  join t_pry_proyecto pry2 on pry2.seqProyecto = frm.seqProyectoHijo
            inner join t_pry_unidad_proyecto upr on frm.seqUnidadProyecto = upr.seqUnidadProyecto
            inner join t_pry_tecnico pte on upr.seqUnidadProyecto = pte.seqUnidadProyecto
            inner join (
              select
                fac.seqFormulario, 
                hvi.numActo, 
                MAX(hvi.fchActo) as fchActo
              from t_aad_hogares_vinculados hvi
              inner join t_aad_formulario_acto fac on hvi.seqFormularioActo = fac.seqFormularioActo
              where hvi.seqTipoActo = 1
              group by 
                hvi.seqFormularioActo, 
                hvi.numActo
            ) aad on frm.seqFormulario = aad.seqFormulario
            where frm.seqFormulario in (" . $this->seqFormularios . ")
              and frm.seqModalidad = 13        
        ";
        $arrReporte = $aptBd->GetAll($sql);

        if (!empty($arrReporte)) {

            // exporta los resultados
            include($txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "PHPExcel.php");
            include("../../librerias/phpExcel/Classes/PHPExcel/Writer/Excel2007.php");

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $objHoja = $objPHPExcel->getActiveSheet();
            $objHoja->setTitle('Estudio Titulos Leasing');
            $objHoja->getDefaultColumnDimension()->setWidth(15);

            // titulos
            $arrTitulos = array_keys($arrReporte[0]);
            for ($i = 0; $i < count($arrTitulos); $i++) {
                $objHoja->setCellValueByColumnAndRow($i, 1, $arrTitulos[$i], false);
                $objHoja->getRowDimension(1)->setRowHeight(80);
                $objHoja->getStyleByColumnAndRow($i, 1)->getAlignment()->setWrapText(true);
                $objHoja->getStyleByColumnAndRow($i, 1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objHoja->getStyleByColumnAndRow($i, 1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }

            // contenido
            foreach ($arrReporte as $numLinea => $arrDatos) {
                $numColumna = 0;
                foreach ($arrDatos as $txtCelda) {
                    $objHoja->setCellValueByColumnAndRow($numColumna, ($numLinea + 2), $txtCelda, false);
                    if ($numColumna < 9) {
                        $objHoja->getColumnDimensionByColumn($numColumna)->setAutoSize(true);
                    }
                    $numColumna++;
                }
            }

            // estilo por defecto
            $arrEstilos = array(
                'font' => array(
                    'bold' => false,
                    'size' => 8,
                    'name' => 'Calibri'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
            );

            // dimnsiones de la hoja
            $numColumnas = count($arrTitulos);
            $numFilas = count($arrReporte);

            // formato por defecto dela hoja
            $objHoja->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(0) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . ($numFilas + 1))
                    ->applyFromArray($arrEstilos);

            // colores en los titulos
            $objHoja->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(0) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")
                    ->getFont()
                    ->setBold(true);

            $objHoja->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(15) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $objHoja->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(15) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex($numColumnas - 1) . "1")
                    ->getFill()
                    ->getStartColor()
                    ->setARGB('A9A9A9');

            $objHoja->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(23) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex(34) . "1")
                    ->getFill()
                    ->getStartColor()
                    ->setARGB('FF0000');

            // formatos de fecha
            $objPHPExcel->getActiveSheet()->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(16) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex(16) . ($numFilas + 1))
                    ->getNumberFormat()
                    ->setFormatCode("yyyy-mm-dd");

            $objPHPExcel->getActiveSheet()->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(22) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex(22) . ($numFilas + 1))
                    ->getNumberFormat()
                    ->setFormatCode("yyyy-mm-dd");

            $objHoja->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(12) . "1:" .
                            PHPExcel_Cell::stringFromColumnIndex(12) . ($numFilas + 1))
                    ->getNumberFormat()
                    ->setFormatCode('#,##');


            // listas
            for ($numColumna = 23; $numColumna < 35; $numColumna++) {
                for ($numFila = 2; $numFila < $numFilas; $numFila++) {
                    $objValidacion = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($numColumna, $numFila)->getDataValidation();
                    $objValidacion->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $objValidacion->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                    $objValidacion->setAllowBlank(false);
                    $objValidacion->setShowInputMessage(true);
                    $objValidacion->setShowErrorMessage(true);
                    $objValidacion->setShowDropDown(true);
                    $objValidacion->setErrorTitle("Error de datos");
                    $objValidacion->setError("El valor digitado no es válido");
                    $objValidacion->setPromptTitle("Los valores válidos son:");
                    $objValidacion->setFormula1('"' . implode(",", ["SI", "NO", "NO APLICA"]) . '"');
                }
            }

            // proteccion
            $objPHPExcel->getSecurity()->setLockWindows(false);
            $objPHPExcel->getSecurity()->setLockStructure(false);
            $objPHPExcel->getSheet(0)->getProtection()->setSheet(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setPassword('SDHT');

            //desprotege las celdas editables
            $objPHPExcel->getActiveSheet()->getStyle(
                            PHPExcel_Cell::stringFromColumnIndex(15) . "2:" .
                            PHPExcel_Cell::stringFromColumnIndex($numColumnas) . ($numFilas + 1))
                    ->getProtection()
                    ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment;filename='Platilla_Estudio_Titulos_Leasing.xlsx");
            header('Cache-Control: max-age=0');
            ob_end_clean();

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } else {
            imprimirErrores(array("No hay datos para mostrar, verifique que haya cargado el arhivo de documentos y que todos sean postulantes principales en la modalidad de leasing habitacional"));
        }
    }

    public function soporteResVinculacion($arrDocumentos) {
        global $aptBd;

        if (!empty($arrDocumentos)) {

            $sql = "
           SELECT 
    seqFormulario,
    numDocumento,
    CONCAT(txtEtapa, '-', txtEstadoProceso) AS estado,
    txtNombreProyecto,
    txtDesplazado,
    t_frm_formulario.fchInscripcion,
    (SELECT 
            SUM(total)
        FROM
            t_frm_calificacion_plan3
                LEFT JOIN
            t_frm_calificacion_operaciones USING (seqCalificacion)
        WHERE
            t_frm_calificacion_plan3.seqFormulario = t_frm_formulario.seqFormulario
        ORDER BY fchCalificacion DESC
        LIMIT 1) AS calificacion,
    (SELECT 
            fchCalificacion
        FROM
            t_frm_calificacion_plan3
                LEFT JOIN
            t_frm_calificacion_operaciones USING (seqCalificacion)
        WHERE
            t_frm_calificacion_plan3.seqFormulario = t_frm_formulario.seqFormulario
        ORDER BY fchCalificacion DESC
        LIMIT 1) AS fchCalificacion,
    txtSoporteDonacion,
    fchPostulacion,
    (SELECT 
            t_cru_cruces.txtNombre
        FROM
            t_cru_cruces
                LEFT JOIN
            t_cru_resultado USING (seqCruce)
        WHERE
            t_cru_resultado.seqFormulario = t_frm_formulario.seqFormulario
        ORDER BY seqCruce DESC
        LIMIT 1) AS 'Verificación - Cruce'
FROM
    t_frm_formulario
        LEFT JOIN
    t_frm_hogar USING (seqFormulario)
        LEFT JOIN
    t_ciu_ciudadano USING (seqCiudadano)
        LEFT JOIN
    t_frm_estado_proceso USING (seqEstadoProceso)
        LEFT JOIN
    t_frm_etapa USING (seqEtapa)
        LEFT JOIN
    t_pry_unidad_proyecto USING (seqFormulario)
        LEFT JOIN
    t_pry_proyecto ON (t_pry_proyecto.seqProyecto = t_frm_formulario.seqProyecto)
        LEFT JOIN
    t_frm_tipo_victima_hogar USING (bolDesplazado)
WHERE
    numDocumento IN ( " . implode(",", $arrDocumentos) . " )
         ";
            $objRes = $aptBd->execute($sql);
            $this->obtenerReportesGeneral($objRes, "soporteResVinculacion");
        } else {
            $this->arrErrores[] = "No hay documentos en el archivo";
            imprimirMensajes($this->arrErrores, array());
        }
    }

    public function girosVIPA() {
        global $aptBd;

        $sql = "
            select 
                fac.seqFormulario, 
                fac.seqFormularioActo,
                tdo.txtTipoDocumento,    
                cac.numDocumento,
                upper(concat(cac.txtNombre1,' ',cac.txtNombre2,' ',cac.txtApellido1,' ',cac.txtApellido2)) as txtNombre,
                est.txtEstado,
                hvi.numActo, 
                hvi.fchActo,
                fac.valAspiraSubsidio,
                if(gir.valSolicitado is null, 0, gir.valSolicitado) as valSolicitado,
                if(concat(gir.numRegistroPresupuestal1, ' de ', year(gir.fchRegistroPresupuestal1)) is null, 'No aplica',concat(gir.numRegistroPresupuestal1, ' de ', year(gir.fchRegistroPresupuestal1)))  as rp1,
                if(concat(gir.numRegistroPresupuestal2, ' de ', year(gir.numRegistroPresupuestal2)) is null, 'No aplica',concat(gir.numRegistroPresupuestal2, ' de ', year(gir.numRegistroPresupuestal2)))  as rp2
            from t_aad_formulario_acto fac
            inner join t_aad_hogar_acto hac on fac.seqFormularioActo = hac.seqFormularioActo and hac.seqParentesco = 1
            inner join t_aad_ciudadano_acto cac on hac.seqCiudadanoActo = cac.seqCiudadanoActo
            inner join t_ciu_tipo_documento tdo on cac.seqTipoDocumento = tdo.seqTipoDocumento
            inner join t_aad_hogares_vinculados hvi on fac.seqFormularioActo = hvi.seqFormularioActo
            inner join v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
            left join t_aad_giro gir on fac.seqFormularioActo = gir.seqFormularioActo
            where fac.seqPlanGobierno = 3
            and fac.seqModalidad = 12
            and fac.seqTipoEsquema = 12
            and hvi.seqTipoActo = 1     
            order by 
                fac.seqFormulario, 
                fac.seqFormularioActo   
        ";
        $objRes = $aptBd->execute($sql);
        $arrDatos = array();
        while ($objRes->fields) {

            $seqFormulario = $objRes->fields['seqFormulario'];
            $fchResolucion = date("Y", strtotime($objRes->fields['fchActo']));
            $txtResolucion = "Res. " . $objRes->fields['numActo'] . " de " . $fchResolucion;

            $arrDatos[$seqFormulario]['hogar']['tipo'] = $objRes->fields['txtTipoDocumento'];
            $arrDatos[$seqFormulario]['hogar']['documento'] = $objRes->fields['numDocumento'];
            $arrDatos[$seqFormulario]['hogar']['nombre'] = $objRes->fields['txtNombre'];
            $arrDatos[$seqFormulario]['hogar']['subsidio'] = $objRes->fields['valAspiraSubsidio'];
            $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['fac'] = $objRes->fields['seqFormularioActo'];
            $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['rp1'] = $objRes->fields['rp1'];
            $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['rp2'] = $objRes->fields['rp2'];
            $arrDatos[$seqFormulario]['hogar'][$txtResolucion]['estado'] = $objRes->fields['txtEstado'];
            $arrDatos[$seqFormulario]['detalle'][$txtResolucion] += $objRes->fields['valSolicitado'];
            $arrDatos[$seqFormulario]['acumulado'] += $objRes->fields['valSolicitado'];

            $objRes->MoveNext();
        }

        $arrReporte = array();
        foreach ($arrDatos as $seqFormulario => $arrInformacion) {
            foreach ($arrInformacion['detalle'] as $txtResolucion => $valGiro) {

                $numPosicion = count($arrReporte);

                $arrReporte[$numPosicion]['Formulario'] = $seqFormulario;
                $arrReporte[$numPosicion]['Formulario Acto'] = $arrInformacion['hogar'][$txtResolucion]['fac'];
                $arrReporte[$numPosicion]['Tipo de documento'] = $arrInformacion['hogar']['tipo'];
                $arrReporte[$numPosicion]['Documento'] = $arrInformacion['hogar']['documento'];
                $arrReporte[$numPosicion]['Nombre'] = $arrInformacion['hogar']['nombre'];
                $arrReporte[$numPosicion]['Estado'] = $arrInformacion['hogar'][$txtResolucion]['estado'];
                $arrReporte[$numPosicion]['Resolucion'] = $txtResolucion;
                $arrReporte[$numPosicion]['Registro Presupuestal 1'] = $arrInformacion['hogar'][$txtResolucion]['rp1'];
                $arrReporte[$numPosicion]['Registro Presupuestal 2'] = $arrInformacion['hogar'][$txtResolucion]['rp2'];
                $arrReporte[$numPosicion]['Subsidio'] = number_format($arrInformacion['hogar']['subsidio'], 0, ',', '.');
                $arrReporte[$numPosicion]['Acumulado'] = number_format($arrInformacion['acumulado'], 0, ',', '.');
                $arrReporte[$numPosicion]['Giro'] = number_format($valGiro, 0, ',', '.');
            }
        }

        $this->obtenerReportesGeneral($arrReporte, "GirosVIPA");
    }

    public function crucesFnv($bolExepciones = false) {
        global $aptBd;

        $arrEstadosAAD[] = 15;
        $arrEstadosAAD[] = 33;
        $arrEstadosAAD[] = 40;
        $arrEstadosAAD[] = 59;

        $sql = "
            select
              '8999990619' as nitSDHT,
              'SECRETARÍA DISTRITAL DE HÁBITAT' as txtSDHT,
              if(cac.seqTipoDocumento = 7,1,cac.seqTipoDocumento) as seqTipoDocumento, 
              cac.numDocumento as numDocumento,
              upper(concat(cac.txtNombre1,' ',cac.txtNombre2,' ',cac.txtApellido1,' ',cac.txtApellido2)) as txtNombre,
              hvi.fchActo as fchAsignacion, 
              0 as valAsignado,
              fac.seqEstadoProceso
            from t_aad_hogares_vinculados hvi
            inner join t_aad_formulario_acto fac on hvi.seqFormularioActo = fac.seqFormularioActo
            inner join t_aad_hogar_acto hac on hac.seqFormularioActo = fac.seqFormularioActo
            inner join t_aad_ciudadano_acto cac on hac.seqCiudadanoActo = cac.seqCiudadanoActo
            inner join v_frm_estado est on fac.seqEstadoProceso = est.seqEstadoProceso
            where hvi.seqTipoActo = 1              
              -- and fac.seqEstadoProceso in (15,33,40,59)
              and cac.seqTipoDocumento in (1,2)
              or (
                    cac.seqTipoDocumento = 7 
                and YEAR(CURDATE()) - YEAR(cac.fchNacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(cac.fchNacimiento,'%m-%d'), 0, -1) >= 18
              )
            order by
              hvi.fchActo        
        ";
        $objRes = $aptBd->execute($sql);
        $arrReporte = array();
        while ($objRes->fields) {
            $numDocumento = $objRes->fields['numDocumento'];
            if (!isset($arrReporte[$numDocumento])) {
                $arrReporte[$numDocumento] = $objRes->fields;
                $txtEntidad = (in_array($objRes->fields['seqEstadoProceso'], $arrEstadosAAD)) ? "SDHT" : "";
                $arrReporte[$numDocumento]['txtEntidad'] = $txtEntidad;
                $arrReporte[$numDocumento]['txtObservaciones'] = "";
            }
            $objRes->MoveNext();
        }


        $sql = "
            select 
                '8999990619' as nitSDHT,
                'SECRETARÍA DISTRITAL DE HÁBITAT' as txtSDHT,
                doc.seqTipoDocumento as seqTipoDocumento, 
                doc.numDocumento as numDocumento,
                doc.txtNombre as txtNombre,
                null as fchAsignacion,
                0 as valAsignado,
                fue.txtEntidad,
                if(fue.txtEntidad is null,doc.txtObservaciones,'') as txtObservaciones
            from (
              select
                res.seqTipoDocumento,
                res.numDocumento,
                upper(res.txtNombre) as txtNombre,
                group_concat(res.txtObservaciones) as txtObservaciones
              from t_cru_resultado res
              where /* res.seqFormulario = 0 and */ 
                res.seqTipoDocumento in (1,2)
              group by 
                res.seqTipoDocumento,
                res.numDocumento
            ) doc
            left join (
              select
                res.numDocumento,
                group_concat(res.txtEntidad) as txtEntidad
              from t_cru_resultado res
              where  /* res.seqFormulario = 0 and  */
                res.bolInhabilitar = 1 and
                res.seqTipoDocumento in (1,2)
              group by res.numDocumento
            ) fue on doc.numDocumento = fue.numDocumento    
        ";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $numDocumento = $objRes->fields['numDocumento'];
            if (!isset($arrReporte[$numDocumento])) {
                $arrReporte[$numDocumento] = $objRes->fields;
            } else {
                if ($objRes->fields['txtEntidad'] != "") {
                    $arrReporte[$numDocumento]['txtEntidad'] .= "," . $objRes->fields['txtEntidad'];
                }
                if ($objRes->fields['txtObservaciones'] != "") {
                    $arrReporte[$numDocumento]['txtObservaciones'] .= "," . $objRes->fields['txtObservaciones'];
                }
            }
            $objRes->MoveNext();
        }

        foreach ($arrReporte as $numDocumento => $arrDatos) {
            if ($bolExepciones == false) {
                if ($arrDatos['txtEntidad'] == "") {
                    unset($arrReporte[$numDocumento]);
                }
                unset($arrReporte[$numDocumento]['txtObservaciones']);
            } else {
                if ($arrDatos['txtEntidad'] != "") {
                    unset($arrReporte[$numDocumento]);
                }
                unset($arrReporte[$numDocumento]['nitSDHT']);
                unset($arrReporte[$numDocumento]['txtSDHT']);
                unset($arrReporte[$numDocumento]['txtNombre']);
                unset($arrReporte[$numDocumento]['fchAsignacion']);
                unset($arrReporte[$numDocumento]['valAsignado']);
                unset($arrReporte[$numDocumento]['txtEntidad']);
                unset($arrReporte[$numDocumento]['seqEstadoProceso']);
            }
        }

        $txtReporte = ($bolExepciones == false) ? "ReporteCruces" : "ReporteExcepciones";
        $this->obtenerReportesGeneral($arrReporte, $txtReporte, null, false, "|");
    }

    public function excepcionesFnv() {
        $this->crucesFnv(true);
    }

    public function reporteGralHogar($arrDocumentos) {
        global $aptBd;

        // if (!empty($arrDocumentos)) {

        $sql = "SELECT
            frm.seqFormulario AS 'Id Hogar',
                ppal.numDocumento AS 'Documento Ppal',
                seqCiudadano AS 'id Ciudadano',
                txtTipoDocumento AS 'Tipo Documento',
                ciud.numDocumento AS 'Documento Ciudadano',
                UPPER(txtNombre1) AS Nombre1,
                UPPER(txtNombre2) AS Nombre2,
                UPPER(txtApellido1) AS txtApellido1,
                UPPER(txtApellido2) AS txtApellido2,
                txtParentesco AS Parentesco,
                txtSexo AS Genero,
                txtEstadoCivil AS 'Estado Civil',
                fchNacimiento AS 'Fecha de Nacimiento',
                TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) AS Edad,
                CASE
               WHEN
               TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) <= 5
               THEN
               '0 a 5'
               WHEN
               TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) > 5
               AND TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) <= 13
               THEN
               '6 a 13'
               WHEN
               TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) > 13
               AND TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) <= 17
               THEN
               '14 a 17'
               WHEN
               TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) > 17
               AND TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) <= 26
               THEN
               '18 a 26'
               WHEN
               TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) > 26
               AND TIMESTAMPDIFF(YEAR,
                fchNacimiento,
                CURDATE()) <= 59
               THEN
               '27 a 59' ELSE 'Mayor de 60'
               END AS RangoEdad,
                txtNivelEducativo AS 'Nivel Educativo',
                numAnosAprobados AS 'Anos Aprobados',
                txtEtnia AS Etnia,
                valIngresos AS 'Ingresos del Ciudadano',
                txtOcupacion AS Ocupacion,
                IF(seqCondicionEspecial = 1
               OR seqCondicionEspecial2 = 1
               OR seqCondicionEspecial3 = 1,
                'SI',
                'NO') AS 'Cabeza de Familia',
                IF(seqCondicionEspecial = 2
               OR seqCondicionEspecial2 = 2
               OR seqCondicionEspecial3 = 2,
                'SI',
                'NO') AS 'Mayor 65 Anos',
                IF(seqCondicionEspecial = 3
               OR seqCondicionEspecial2 = 3
               OR seqCondicionEspecial3 = 3,
                'SI',
                'NO') AS Discapacitado,
                IF(seqCondicionEspecial = 6
               and seqCondicionEspecial2 = 6
               and seqCondicionEspecial3 = 6,
                'SI',
                'NO') AS 'Ninguna Condicion Especial',
                txtSalud AS Salud,
                UPPER(txtTipoVictima) AS 'Tipo Victima',
                IF(bolLgtb = 1, 'SI', 'NO') AS 'Lgtbi',
                UPPER(txtGrupoLgtbi) AS 'Movimiento LGTBI',
                IF(bolDesplazado = 1, 'SI', 'NO') AS Desplazado,
                txtCiudad AS 'Ciudad',
                txtLocalidad AS 'Localidad',
                upz.txtUpz,
                bar.txtBarrio AS Barrio,
                seqTipoDireccion,
                txtVivienda AS Vivienda,
                valArriendo AS 'Valor Arriendo',
                fchArriendoDesde AS 'Fecha Arriendo Desde',
                numHabitaciones AS 'Numero Habitaciones',
                numHacinamiento AS 'Hacinamiento',
                frm.fchInscripcion AS 'Fecha Inscripcion',
                fchPostulacion AS 'Fecha Postulacion',
                txtEstadoProceso AS 'Estado Proceso',
                IF(bolCerrado = 1, 'SI', 'NO') AS Cerrado,
                txtCajaCompensacion AS 'Caja de Compensacion',
                IF(bolIntegracionSocial = 1, 'SI', 'NO') AS IntegracionSocial,
                IF(bolSecSalud = 1, 'SI', 'NO') AS 'Sec. Salud',
                IF(bolSecEducacion = 1, 'SI', 'NO') AS 'Sec. Educacion',
                IF(bolSecMujer = 1, 'SI', 'NO') AS 'Sec. Mujer',
                IF(bolAltaCon = 1, 'SI', 'NO') AS 'Sec. Alta Consejeria',
                IF(bolIpes = 1, 'SI', 'NO') AS 'secbolIpes',
                txtOtro,
                txtSisben AS 'Sisben',
                valIngresoHogar AS 'Ingresos del Hogar',
                (valSaldoCuentaAhorro+valSaldoCuentaAhorro2) AS 'Suma Ahorro',
                valSaldoCuentaAhorro AS 'Saldo Cta de Ahorro 1',
                ban.txtBanco AS 'Banco Cta Ahorro 1',
                valSaldoCuentaAhorro2 AS 'Saldo Cta Ahorro 2',
                ban2.txtBanco AS 'Banco Cta Ahorro 2',
                valSubsidioNacional AS 'Subsidio Nacional',
                txtEntidadSubsidio AS 'Entidad Subsidio',
                txtSoporteSubsidioNacional AS 'Soporte Subsidio Nacional',
                valAporteLote AS 'Aporte Lote',
                valSaldoCesantias AS 'Valor Cesantias',
                txtCesantias AS Cesantias,
                valCredito AS 'Valor Credito',
                cred.txtBanco AS 'Banco Credito',
                valDonacion AS 'Valor Donacion',
                txtEmpresaDonante AS 'Empresa Donante',
                txtSoporteDonacion AS 'Soporte Donacion',
                valPresupuesto AS 'Valor Presupuesto',
                valAvaluo AS 'Valor Avaluo',
                valTotal AS 'Valor Total',
                txtModalidad AS 'Modalidad',
                txtSolucion AS Solucion,
                txtPlanGobierno AS 'Plan de Gobierno',
                txtTipoEsquema AS 'Tipo Esquema',
                valAspiraSubsidio AS 'Aspira Subsidio',
                txtSoporteSubsidio AS 'Soporte Subsidio',
                fchVigencia AS 'Fecha Vigencia',
                valCartaLeasing AS 'Carta Leasing',
                valComplementario AS 'Valor Complementario',
                txtNombreProyecto AS 'Nombre Proyecto',
                seqProyectoHijo,
                IF(afro.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Afro ',
                IF(ind.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Indigena',
                IF(pal.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Palenquero',
                IF(raiz.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Raizal',
                IF(cabF.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Cabeza Fam',
                IF(disc.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Discapacitado',
                IF(lgtbi.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar LGTBI ',
                IF(rom.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Hogar Rom ',                
                IF(mayor.seqFormulario IS NOT NULL,
                'SI',
                'NO') AS 'Mayor 65 Años'
              FROM
                  t_ciu_ciudadano ciud
                      INNER JOIN
                  t_frm_hogar hog USING (seqCiudadano)
                      INNER JOIN
                  t_frm_formulario frm USING (seqFormulario)
                      LEFT JOIN
                  t_ciu_tipo_documento USING (seqTipoDocumento)
                      LEFT JOIN
                  t_ciu_sexo USING (seqSexo)
                      LEFT JOIN
                  t_ciu_parentesco USING (seqParentesco)
                      LEFT JOIN
                  t_ciu_estado_civil USING (seqEstadoCivil)
                      LEFT JOIN
                  t_frm_tipoVictima USING (seqTipoVictima)
                      LEFT JOIN
                  t_frm_grupo_lgtbi USING (seqGrupoLgtbi)
                      LEFT JOIN
                  t_ciu_nivel_educativo USING (seqNivelEducativo)
                      LEFT JOIN
                  t_ciu_salud USING (seqSalud)
                      LEFT JOIN
                  t_ciu_etnia USING (seqEtnia)
                      LEFT JOIN
                  t_frm_estado_proceso USING (seqEstadoProceso)
                      LEFT JOIN
                  t_ciu_caja_compensacion USING (seqCajaCompensacion)
                      LEFT JOIN
                  t_ciu_ocupacion USING (seqOcupacion)
                      LEFT JOIN
                  t_frm_solucion USING (seqSolucion)
                      LEFT JOIN
                  t_frm_modalidad mo ON (mo.seqModalidad = frm.seqModalidad)
                      LEFT JOIN
                  t_frm_banco ban ON (ban.seqBanco = frm.seqBancoCuentaAhorro)
                      LEFT JOIN
                  t_frm_banco ban2 ON (ban2.seqBanco = frm.seqBancoCuentaAhorro2)
                      LEFT JOIN
                  t_frm_banco cred ON (cred.seqBanco = frm.seqBancoCredito)
                      LEFT JOIN
                  t_frm_localidad USING (seqLocalidad)
                      LEFT JOIN
                  t_pry_proyecto USING (seqProyecto)
                      LEFT JOIN
                  t_frm_ciudad USING (seqCiudad)
                      LEFT JOIN
                  t_frm_plan_gobierno pg ON (frm.seqPlanGobierno = pg.seqPlanGobierno)
                      LEFT JOIN
                  t_frm_barrio bar ON (frm.seqBarrio = bar.seqBarrio)
                      LEFT JOIN
                  t_pry_tipo_esquema esq ON (frm.seqTipoEsquema = esq.seqTipoEsquema)
                      LEFT JOIN
                  t_frm_empresa_donante USING (seqEmpresaDonante)
                      LEFT JOIN
                  t_frm_entidad_subsidio USING (seqEntidadSubsidio)
                      LEFT JOIN
                  t_frm_cesantia USING (seqCesantias)
                      LEFT JOIN
                  t_frm_vivienda USING (seqVivienda)
                       LEFT JOIN
                      t_frm_sisben USING(seqSisben)
                              LEFT JOIN 
                      t_frm_upz upz ON(upz.seqUpz = frm.seqUpz)
                      LEFT JOIN
                  (SELECT DISTINCT
                      hoget.seqFormulario
                  FROM
                      t_ciu_ciudadano ciuet
                  INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                  WHERE
                      ciuet.seqEtnia = 6) afro ON frm.seqFormulario = afro.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      hoget.seqFormulario
                  FROM
                      t_ciu_ciudadano ciuet
                  INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                  WHERE
                      ciuet.seqEtnia = 2) ind ON frm.seqFormulario = ind.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      hoget.seqFormulario
                  FROM
                      t_ciu_ciudadano ciuet
                  INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                  WHERE
                      ciuet.seqEtnia = 3) rom ON frm.seqFormulario = rom.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      hoget.seqFormulario
                  FROM
                      t_ciu_ciudadano ciuet
                  INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                  WHERE
                      ciuet.seqEtnia = 4) raiz ON frm.seqFormulario = raiz.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      hoget.seqFormulario
                  FROM
                      t_ciu_ciudadano ciuet
                  INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                  WHERE
                      ciuet.seqEtnia = 5) pal ON frm.seqFormulario = pal.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      ciuet.numDocumento, hoget.seqFormulario
                  FROM
                      t_ciu_ciudadano ciuet
                  INNER JOIN t_frm_hogar hoget ON hoget.seqCiudadano = ciuet.seqCiudadano
                  WHERE
                      seqParentesco = 1) ppal ON frm.seqFormulario = ppal.seqFormulario        
                      LEFT JOIN
                  (SELECT DISTINCT
                      (seqFormulario)
                  FROM
                      t_ciu_ciudadano
                  LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                  WHERE
                      seqCondicionEspecial = 1
                          OR seqCondicionEspecial2 = 1
                          OR seqCondicionEspecial3 = 1) cabF ON frm.seqFormulario = cabF.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      (seqFormulario)
                  FROM
                      t_ciu_ciudadano
                  LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                  WHERE
                      seqCondicionEspecial = 3
                          OR seqCondicionEspecial2 = 3
                          OR seqCondicionEspecial3 = 3) disc ON frm.seqFormulario = disc.seqFormulario
                      LEFT JOIN
                  (SELECT DISTINCT
                      (seqFormulario)
                  FROM
                      t_ciu_ciudadano
                  LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                  WHERE
                      seqCondicionEspecial = 2
                          OR seqCondicionEspecial2 = 2
                          OR seqCondicionEspecial3 = 2) mayor ON frm.seqFormulario = mayor.seqFormulario
                LEFT JOIN
              (SELECT DISTINCT
                    (seqFormulario)
                FROM
                    t_ciu_ciudadano
                LEFT JOIN t_frm_hogar hog1 USING (seqCiudadano)
                WHERE
                    seqGrupoLgtbi > 0)
                        lgtbi ON frm.seqFormulario = lgtbi.seqFormulario";
        if (!empty($arrDocumentos)) {
            $sql .= " WHERE numDocumento IN ( " . implode(",", $arrDocumentos) . " )";
        }
        $sql .= " ORDER BY frm.seqFormulario";
//        echo $sql;
//        die();
        $objRes = $aptBd->execute($sql);
        $this->obtenerReportesGeneral($objRes, "reporteGralHogar");
    }

}

// fin clase reportes
?>
