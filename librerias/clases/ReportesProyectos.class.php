<?php

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
          
          $txtCondiciones  = ( $_POST['fchInicio'] != "" )? "AND bor.fchBorrado >= '" . $_POST['fchInicio'] . " 00:00:00'" : "";
          $txtCondiciones .= ( $_POST['fchFin']    != "" )? "AND bor.fchBorrado <= '" . $_POST['fchFin']    . " 23:59:59'" : "";
          
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
          $objRes = $aptBd->execute( $sql );
          $this->obtenerReportesGeneral( $objRes , "ReporteFormsEliminados" );
          
       } catch( Exception $objError ){
          $arrErrores[] = "No se pudo obtener el reporte de formularios eliminados";
          imprimirMensajes( $arrErrores , array() );
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
						frm.numTelefono2
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
						ciu.fchNacimiento AS FechaNacimiento,
						FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365)) AS Edad,
						rangoEdad(FLOOR((DATEDIFF(NOW(), ciu.fchNacimiento) / 365))) AS RangoEdad,
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
                $objRes = $aptBd->execute($sql);

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


                $this->obtenerReportesGeneral($objRes, "ReporteAnalisisPoblacion", $arrTitulosCampos);
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

                $arrNumDocumento = ( empty($arrNumDocumento) ) ? "null" :
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
                    $arrSeqFormularios = ( empty($arrSeqFormularios) ) ? "null" :
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

    public function obtenerReportesGeneral($objRes, $nombreArchivo, $arrTitulosCampos = array()) {

        if ($this) {
            $arrErrores = $this->arrErrores;
        } else {
            $arrErrores = array();
        }

        if (empty($arrErrores)) {

            $txtNombreArchivo = $nombreArchivo . date("Ymd_His") . ".xls";

            header("Content-disposition: attachment; filename=$txtNombreArchivo");
            header("Content-Type: application/force-download");
            header("Content-Type: application/vnd.ms-excel; charset=utf-8;");
            header("Content-Transfer-Encoding: binary");
            header("Pragma: no-cache");
            header("Expires: 1");

            // si es el objeto ResultSet
            if (is_object($objRes)) {
                if (!empty($objRes->fields)) {
                    echo utf8_decode(implode("\t", array_keys($objRes->fields))) . "\r\n";
                } else {
                    foreach ($arrTitulosCampos as $txtTitulo) {
                        echo utf8_decode($txtTitulo) . "\t";
                    }
                    echo "\r\n";
                }
                while ($objRes->fields) {
                    echo ( utf8_decode(implode("\t", preg_replace("/\s+/", " ", $objRes->fields))) ) . "\r\n";
                    $objRes->MoveNext();
                }

                // Si es un arreglo
            } elseif (is_array($objRes)) {

                if (!empty($objRes)) {
                    echo utf8_decode(implode("\t", array_keys($objRes[0]))) . "\r\n";
                } else {
                    foreach ($arrTitulosCampos as $txtTitulo) {
                        echo utf8_decode($txtTitulo) . "\t";
                    }
                    echo "\r\n";
                }

                foreach ($objRes as $arrDatos) {
                    echo utf8_decode(implode("\t", $arrDatos)) . "\r\n";
                }
            }
        } else {
            imprimirMensajes($arrErrores, array());
        }
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
                $arrConsolidadoPrograma["Inscritos"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                $arrConsolidadoPrograma["Inscritos"]["Total"] += $objRes->fields["cuenta"];

                $arrDatosGrafica["Inscritos - $grupo"] += $objRes->fields["cuenta"];

                if (in_array($objRes->fields["seqEstadoProceso"], $arrAsignados)) {
                    $arrConsolidadoPrograma["Asignados"]["estadoProceso"] = "Asignados";
                    $arrConsolidadoPrograma["Asignados"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Asignados"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Asignados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Asignados - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrInscritos)) {
                    $arrConsolidadoPrograma["En Inscripcion"]["estadoProceso"] = "En Inscripcion";
                    $arrConsolidadoPrograma["En Inscripcion"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["En Inscripcion"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["En Inscripcion"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["En Inscripcion - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrPostulados)) {
                    $arrConsolidadoPrograma["Postulados"]["estadoProceso"] = "Postulados";
                    $arrConsolidadoPrograma["Postulados"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Postulados - $grupo"] += $objRes->fields["cuenta"];
                }

                if ($objRes->fields["seqEstadoProceso"] == $valPostuladoCosecha && $objRes->fields["bolCerrado"] == 1) {
                    $arrConsolidadoPrograma["Postulados"]["estadoProceso"] = "Postulados";
                    $arrConsolidadoPrograma["Postulados"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Postulados - $grupo"] += $objRes->fields["cuenta"];
                }

                if ($objRes->fields["seqEstadoProceso"] == $valPostuladoInhabilitado) {
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["estadoProceso"] = "Postulados Inhabilitados";
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Postulados Inhabilitados"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Postulados Inhabilitados - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrDesembolso)) {
                    $arrConsolidadoPrograma["Desembolso"]["estadoProceso"] = "En Desembolso";
                    $arrConsolidadoPrograma["Desembolso"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Desembolso"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Desembolso"]["Total"] += $objRes->fields["cuenta"];

                    $arrDatosGrafica["Desembolso - $grupo"] += $objRes->fields["cuenta"];
                }

                if (in_array($objRes->fields["seqEstadoProceso"], $arrProcesoPostulacion) && $objRes->fields["bolCerrado"] == 0) {
                    $arrConsolidadoPrograma["Proceso Postulacion"]["estadoProceso"] = "Proceso Postulacion";
                    $arrConsolidadoPrograma["Proceso Postulacion"]["Independiente"] += ( $grupo == "Independiente" ) ? $objRes->fields["cuenta"] : 0;
                    $arrConsolidadoPrograma["Proceso Postulacion"]["Desplazado"] += ( $grupo == "Desplazado" ) ? $objRes->fields["cuenta"] : 0;
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
						valorMaximoVivienda( sol.txtSolucion ) as ValorMaximo,
						format( frm.valAspiraSubsidio , 0 )as Subsidio,
						if( tdo.seqTipoDocumento in( 3 , 4) , 'Menor de Edad', tdo.txtTipoDocumento ) as TipoDocumento ,
						if( tdo.seqTipoDocumento in( 3 , 4) , '', format( ciu.numDocumento , 0 ) ) as Documento ,
						upper( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 )) as Nombre
					FROM 
					T_FRM_FORMULARIO frm
					INNER JOIN T_FRM_HOGAR hog ON hog.seqFormulario = frm.seqFormulario
					INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
					INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON ciu.seqTipoDocumento = tdo.seqTipoDocumento
					INNER JOIN T_FRM_MODALIDAD moa ON frm.seqModalidad = moa.seqModalidad
					INNER JOIN T_FRM_SOLUCION sol ON frm.seqSolucion = sol.seqSolucion
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
                    $numValorSerie = ( is_numeric($numValorSerie) ) ? $numValorSerie : "'$numValorSerie'";
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
                            throw new Exception("La linea $numLinea . El documento $txtLinea no tiene asignado un formulario");
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



        if (empty($arrErrores) and $bolExisteFileSecuenciales and !empty($_FILES['fileSecuenciales'])) {
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

                $seqFormularios = ( empty($arrSeqFormularios) ) ? "null" :
                        implode($arrSeqFormularios, ",");
            } catch (Exception $objError) {
                $arrErrores[] = "Se ha producido un error al consultar los datos";
            }
        }
    }

    public function pasivosExigibles($fchDesde, $fchHasta) {
        global $aptBd;

        // Validacion de la fecha de inicio
        list( $ano, $mes, $dia ) = split("-", $fchDesde);
        if (@checkdate($mes, $dia, $ano) === false) {
            $this->arrErrores[] = "La fecha de inicio no es válida";
        }

        // Validacion de la fecha de fin
        list( $ano, $mes, $dia ) = split("-", $fchHasta);
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
                            $valCierreFinanciero = ( 50 * $arrConfiguracion['constantes']['salarioMinimo'] ) - $objRes->fields['valSubsidio'];
                            break;
                        case "> 50 y <= 70 SMMLV":
                            $valCierreFinanciero = ( 50 * $arrConfiguracion['constantes']['salarioMinimo'] ) - $objRes->fields['valSubsidio'];
                            break;
                        case "> 70 y <= 135 SMMLV":
                            $valCierreFinanciero = ( 70 * $arrConfiguracion['constantes']['salarioMinimo'] ) - $objRes->fields['valSubsidio'];
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
    
   public function seguimientoDesembolsos( $arrDocumentos ){
      global $aptBd;
      
      if( ! empty( $arrDocumentos ) ){
      
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
               sol.valOrden as ValorOrdenPago
            FROM T_FRM_FORMULARIO frm
            INNER JOIN T_FRM_HOGAR hog ON frm.seqFormulario = hog.seqFormulario
            INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
            INNER JOIN T_FRM_ESTADO_PROCESO pro ON frm.seqEstadoProceso = pro.seqEstadoProceso
            INNER JOIN T_FRM_ETAPA eta ON pro.seqEtapa = eta.seqEtapa
            LEFT JOIN T_DES_FLUJO flu ON frm.seqFormulario = flu.seqFormulario
            LEFT JOIN T_DES_DESEMBOLSO des ON frm.seqFormulario = des.seqFormulario
            LEFT JOIN T_DES_SOLICITUD sol ON des.seqDesembolso = sol.seqDesembolso
            WHERE hog.seqParentesco = 1
            AND ciu.numDocumento IN ( " . implode( "," , $arrDocumentos ) . " )
         ";
         $objRes = $aptBd->execute( $sql );
         $this->obtenerReportesGeneral($objRes, "seguimientoDesembolsos");
      } else { 
         $this->arrErrores[] = "No hay documentos en el archivo";
         imprimirMensajes($this->arrErrores, array());
      }
      
   }
  
}

// fin clase reportes
?>
