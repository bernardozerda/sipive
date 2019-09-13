<?php

/**
 * CLASE QUE EJECUTA LAS OPERACIONES PARA 
 * LOS CIUDADANOS PARA EL PROGRAMA BOGOTA HUMANA
 * @version 1.0 Enero 2013
 * @version 1.1 Febrero 2014
 * @author Jaison Ospina <jospinap@habitatbogota.gov.co>
 * @author Camilo Bernal <jbernalr@habitatbogota.gov.co>
 * @author Bernardo Zerda <bzerdar@habitatbogota.gov.co>
 */
class Ciudadano {

    public $arrErrores;
    public $bolBeneficiario;
    public $bolCertificadoElectoral;
    public $bolLgtb;
    public $bolSoporteDocumento;
    public $fchNacimiento;
    public $numAfiliacionSalud;
    public $numAnosAprobados;
    public $numDocumento;
    public $seqCajaCompensacion;
    public $seqCiudadano;
    public $seqCondicionEspecial;
    public $seqCondicionEspecial2;
    public $seqCondicionEspecial3;
    public $seqEstadoCivil;
    public $seqEtnia;
    public $seqGrupoLgtbi;
    public $seqNivelEducativo;
    public $seqOcupacion;
    public $seqParentesco;
    public $seqSalud;
    public $seqSexo;
    public $seqTipoDocumento;
    public $seqTipoVictima;
    public $txtApellido1;
    public $txtApellido2;
    public $txtNombre1;
    public $txtNombre2;
    public $valIngresos;

    // informacion del soporte de documento
    public $fchExpedicion;
    public $txtTipoSoporte;
    public $txtEntidadDocumento;
    public $numIndicativoSerial;
    public $numNotariaDocumento;
    public $seqCiudadDocumento;

    // informacion del soporte de estado civil
    public $numConsecutivoCasado;
    public $numNotariaCasado;
    public $seqCiudadCasado;
    public $numConsecutivoCSCDL;
    public $txtEntidadCSCDL;
    public $seqCiudadCSCDL;
    public $numNotariaCSCDL;
    public $numNotariaSoltero;
    public $seqCiudadSoltero;
    public $txtCertificacionUnion;
    public $numConsecutivoUnion;
    public $txtEntidadUnion;
    public $numNotariaUnion;
    public $seqCiudadUnion;
    public $numConsecutivoPartida;
    public $txtParroquiaPartida;
    public $seqCiudadPartida;
//    public $txtTipoVinculacion;

    /**
     * CONSTRUCTOR
     */
    public function Ciudadano() {

        $this->arrErrores = array();
        $this->bolBeneficiario = 0;
        $this->bolCertificadoElectoral = 0;
        $this->bolLgtb = 0;
        $this->bolSoporteDocumento = 0;
        $this->fchNacimiento = null;
        $this->numAfiliacionSalud = 0;
        $this->numAnosAprobados = 0;
        $this->numDocumento = 0;
        $this->seqCajaCompensacion = 1;
        $this->seqCiudadano = 0;
        $this->seqCondicionEspecial = 6;
        $this->seqCondicionEspecial2 = 6;
        $this->seqCondicionEspecial3 = 6;
        $this->seqEstadoCivil = 9;
        $this->seqEtnia = 1;
        $this->seqGrupoLgtbi = 0;
        $this->seqNivelEducativo = 1;
        $this->seqOcupacion = 20;
        $this->seqParentesco = 12;
        $this->seqSalud = 0;
        $this->seqSexo = 2;
        $this->seqTipoDocumento = 8;
        $this->seqTipoVictima = 0;
        $this->txtApellido1 = "";
        $this->txtApellido2 = "";
        $this->txtNombre1 = "";
        $this->txtNombre2 = "";
        $this->valIngresos = 0;

        // informacion del soporte de documento
        $this->fchExpedicion = null;
        $this->txtTipoSoporte = "";
        $this->txtEntidadDocumento = "";
        $this->numIndicativoSerial = 0;
        $this->numNotariaDocumento = 0;
        $this->seqCiudadDocumento = 0;

        // informacion del soporte de estado civil
        $this->numConsecutivoCasado = 0;
        $this->numNotariaCasado = 0;
        $this->seqCiudadCasado = 0;
        $this->numConsecutivoCSCDL = 0;
        $this->txtEntidadCSCDL = 0;
        $this->seqCiudadCSCDL = 0;
        $this->numNotariaCSCDL = 0;
        $this->numNotariaSoltero = 0;
        $this->seqCiudadSoltero = 0;
        $this->txtCertificacionUnion = "";
        $this->numConsecutivoUnion = 0;
        $this->txtEntidadUnion = "";
        $this->numNotariaUnion = 0;
        $this->seqCiudadUnion = 0;
        $this->numConsecutivoPartida = 0;
        $this->txtParroquiaPartida = "";
        $this->seqCiudadPartida = 0;
//        $this->txtTipoVinculacion = "";
        
    }

    public function cargarCiudadano($seqCiudadano) {
        global $aptBd;
        $sql = "	
            SELECT
                bolBeneficiario,
                bolCertificadoElectoral,
                bolLgtb,
                fchNacimiento,
                numAfiliacionSalud,
                numAnosAprobados,
                numDocumento,
                seqCajaCompensacion,
                seqCiudadano,
                seqCondicionEspecial,
                seqCondicionEspecial2,
                seqCondicionEspecial3,
                seqEstadoCivil,
                seqEtnia,
                seqGrupoLgtbi,
                seqNivelEducativo,
                seqOcupacion,
                seqSalud,
                seqSexo,
                seqTipoDocumento,
                seqTipoVictima,
                txtApellido1,
                txtApellido2,
                txtNombre1,
                txtNombre2,
                valIngresos,
                fchExpedicion,
                txtEntidadDocumento,
                numIndicativoSerial,
                numNotariaDocumento,
                seqCiudadDocumento,
                numConsecutivoCasado,
                numNotariaCasado,
                seqCiudadCasado,
                numConsecutivoCSCDL,
                txtEntidadCSCDL,
                seqCiudadCSCDL,
                numNotariaCSCDL,
                numNotariaSoltero,
                seqCiudadSoltero,
                txtCertificacionUnion,
                numConsecutivoUnion,
                txtEntidadUnion,
                numNotariaUnion,
                seqCiudadUnion,
                numConsecutivoPartida,
                txtParroquiaPartida,
                seqCiudadPartida,
                txtTipoSoporte
                -- txtTipoVinculacion
            FROM T_CIU_CIUDADANO
            WHERE seqCiudadano = $seqCiudadano		
		";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            $this->bolBeneficiario = intval($objRes->fields['bolBeneficiario']);
            $this->bolCertificadoElectoral = intval($objRes->fields['bolCertificadoElectoral']);
            $this->bolLgtb = intval($objRes->fields['bolLgtb']);
            $this->bolSoporteDocumento = intval($objRes->fields['bolSoporteDocumento']);
            $this->fchNacimiento = (esFechaValida($objRes->fields['fchNacimiento'])) ? $objRes->fields['fchNacimiento'] : null;
            $this->numAfiliacionSalud = intval($objRes->fields['numAfiliacionSalud']);
            $this->numAnosAprobados = intval($objRes->fields['numAnosAprobados']);
            $this->numDocumento = doubleval($objRes->fields['numDocumento']);
            $this->seqCajaCompensacion = intval($objRes->fields['seqCajaCompensacion']);
            $this->seqCiudadano = intval($objRes->fields['seqCiudadano']);
            $this->seqCondicionEspecial = intval($objRes->fields['seqCondicionEspecial']);
            $this->seqCondicionEspecial2 = intval($objRes->fields['seqCondicionEspecial2']);
            $this->seqCondicionEspecial3 = intval($objRes->fields['seqCondicionEspecial3']);
            $this->seqEstadoCivil = intval($objRes->fields['seqEstadoCivil']);
            $this->seqEtnia = intval($objRes->fields['seqEtnia']);
            $this->seqGrupoLgtbi = intval($objRes->fields['seqGrupoLgtbi']);
            $this->seqNivelEducativo = intval($objRes->fields['seqNivelEducativo']);
            $this->seqOcupacion = intval($objRes->fields['seqOcupacion']);
            $this->seqParentesco = intval($objRes->fields['seqParentesco']);
            $this->seqSalud = intval($objRes->fields['seqSalud']);
            $this->seqSexo = intval($objRes->fields['seqSexo']);
            $this->seqTipoDocumento = intval($objRes->fields['seqTipoDocumento']);
            $this->seqTipoVictima = intval($objRes->fields['seqTipoVictima']);
            $this->txtApellido1 = trim($objRes->fields['txtApellido1']);
            $this->txtApellido2 = trim($objRes->fields['txtApellido2']);
            $this->txtNombre1 = trim($objRes->fields['txtNombre1']);
            $this->txtNombre2 = trim($objRes->fields['txtNombre2']);
            $this->valIngresos = doubleval($objRes->fields['valIngresos']);
            $this->fchExpedicion = (esFechaValida($objRes->fields['fchExpedicion'])) ? $objRes->fields['fchExpedicion'] : null;
            $this->txtEntidadDocumento =  trim($objRes->fields['txtEntidadDocumento']);
            $this->numIndicativoSerial = doubleval($objRes->fields['numIndicativoSerial']);
            $this->numNotariaDocumento = intval($objRes->fields['numNotariaDocumento']);
            $this->seqCiudadDocumento = intval($objRes->fields['seqCiudadDocumento']);
            $this->numConsecutivoCasado = doubleval($objRes->fields['numConsecutivoCasado']);
            $this->numNotariaCasado = intval($objRes->fields['numNotariaCasado']);
            $this->seqCiudadCasado = intval($objRes->fields['seqCiudadCasado']);
            $this->numConsecutivoCSCDL = doubleval($objRes->fields['numConsecutivoCSCDL']);
            $this->txtEntidadCSCDL = trim($objRes->fields['txtEntidadCSCDL']);
            $this->seqCiudadCSCDL = intval($objRes->fields['seqCiudadCSCDL']);
            $this->numNotariaCSCDL = intval($objRes->fields['numNotariaCSCDL']);
            $this->numNotariaSoltero = intval($objRes->fields['numNotariaSoltero']);
            $this->seqCiudadSoltero = intval($objRes->fields['seqCiudadSoltero']);
            $this->txtCertificacionUnion = trim($objRes->fields['txtCertificacionUnion']);
            $this->numConsecutivoUnion = doubleval($objRes->fields['numConsecutivoUnion']);
            $this->txtEntidadUnion = trim($objRes->fields['txtEntidadUnion']);
            $this->numNotariaUnion = intval($objRes->fields['numNotariaUnion']);
            $this->seqCiudadUnion = intval($objRes->fields['seqCiudadUnion']);
            $this->numConsecutivoPartida = doubleval($objRes->fields['numConsecutivoPartida']);
            $this->txtParroquiaPartida = trim($objRes->fields['txtParroquiaPartida']);
            $this->seqCiudadPartida = intval($objRes->fields['seqCiudadPartida']);
            $this->txtTipoSoporte = trim($objRes->fields['txtTipoSoporte']);
//            $this->txtTipoVinculacion = trim($objRes->fields['txtTipoVinculacion']);

        } else {
            $this->arrErrores[] = "Ciudadano [$seqCiudadano] no encontrado";
        }
    }

    public function guardarCiudadano() {
        global $aptBd;
        try {
            $fchNacimiento = (esFechaValida($this->fchNacimiento)) ? "'" . $this->fchNacimiento . "'" : "NULL";
            $fchExpedicion = (esFechaValida($this->fchExpedicion)) ? "'" . $this->fchExpedicion . "'" : "NULL";
            $sql = "	    	
                INSERT INTO T_CIU_CIUDADANO (
                    bolBeneficiario,
                    bolCertificadoElectoral,
                    bolLgtb,
                    fchNacimiento,
                    numAfiliacionSalud,
                    numAnosAprobados,
                    numDocumento,
                    seqCajaCompensacion,
                    seqCondicionEspecial,
                    seqCondicionEspecial2,
                    seqCondicionEspecial3,
                    seqEstadoCivil,
                    seqEtnia,
                    seqGrupoLgtbi,
                    seqNivelEducativo,
                    seqOcupacion,
                    seqSalud,
                    seqSexo,
                    seqTipoDocumento,
                    seqTipoVictima,
                    txtApellido1,
                    txtApellido2,
                    txtNombre1,
                    txtNombre2,
                    valIngresos,
                    fchExpedicion,
                    txtEntidadDocumento,
                    numIndicativoSerial,
                    numNotariaDocumento,
                    seqCiudadDocumento,
                    numConsecutivoCasado,
                    numNotariaCasado,
                    seqCiudadCasado,
                    numConsecutivoCSCDL,
                    txtEntidadCSCDL,
                    seqCiudadCSCDL,
                    numNotariaCSCDL,
                    numNotariaSoltero,
                    seqCiudadSoltero,
                    txtCertificacionUnion,
                    numConsecutivoUnion,
                    txtEntidadUnion,
                    numNotariaUnion,
                    seqCiudadUnion,
                    numConsecutivoPartida,
                    txtParroquiaPartida,
                    seqCiudadPartida,
                    txtTipoSoporte                    
                ) VALUES (
                    " . intval($this->bolBeneficiario) . ",
                    " . intval($this->bolCertificadoElectoral) . ",
                    " . intval($this->bolLgtb) . ",
                    " . $fchNacimiento . ",
                    " . intval($this->numAfiliacionSalud) . ",
                    " . intval($this->numAnosAprobados) . ",
                    " . doubleval($this->numDocumento) . ",
                    " . intval($this->seqCajaCompensacion) . ",                    
                    " . intval($this->seqCondicionEspecial) . ",
                    " . intval($this->seqCondicionEspecial2) . ",
                    " . intval($this->seqCondicionEspecial3) . ",
                    " . intval($this->seqEstadoCivil) . ",
                    " . intval($this->seqEtnia) . ",
                    " . intval($this->seqGrupoLgtbi) . ",
                    " . intval($this->seqNivelEducativo) . ",
                    " . intval($this->seqOcupacion) . ",
                    " . intval($this->seqSalud) . ",
                    " . intval($this->seqSexo) . ",
                    " . intval($this->seqTipoDocumento) . ",
                    " . intval($this->seqTipoVictima) . ",
                    '" . trim($this->txtApellido1) . "',
                    '" . trim($this->txtApellido2) . "',
                    '" . trim($this->txtNombre1) . "',
                    '" . trim($this->txtNombre2) . "',
                    " . doubleval($this->valIngresos) . ",
                    " . $fchExpedicion . ",
                    '" . trim($this->txtEntidadDocumento) . "',
                    " . doubleval($this->numIndicativoSerial) . ",
                    " . intval($this->numNotariaDocumento) . ",
                    " . intval($this->seqCiudadDocumento) . ",
                    " . intval($this->numConsecutivoCasado) . ",
                    " . intval($this->numNotariaCasado) . ",
                    " . intval($this->seqCiudadCasado) . ",
                    " . doubleval($this->numConsecutivoCSCDL) . ",
                    '" . trim($this->txtEntidadCSCDL) . "',
                    " . intval($this->seqCiudadCSCDL) . ",
                    " . intval($this->numNotariaCSCDL) . ",
                    " . intval($this->numNotariaSoltero) . ",
                    " . intval($this->seqCiudadSoltero) . ",
                    '" . trim($this->txtCertificacionUnion) . "',
                    " . doubleval($this->numConsecutivoUnion) . ",
                    '" . trim($this->txtEntidadUnion) . "',
                    " . intval($this->numNotariaUnion) . ",
                    " . intval($this->seqCiudadUnion) . ",
                    " . doubleval($this->numConsecutivoPartida) . ",
                    '" . trim($this->txtParroquiaPartida) . "',
                    " . intval($this->seqCiudadPartida) . ",
                    '" . trim($this->txtTipoSoporte) . "'
                )
             ";
            $aptBd->execute($sql);
            $this->seqCiudadano = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $this->seqCiudadano = 0;
            $this->arrErrores[] = "El ciudadano identificado con el n&uacute;mero de documento " . number_format($this->numDocumento) . " no se pudo guardar, puede que ya exista en el aplicativo";
//            $this->arrErrores[] = $objError->getMessage();
        }

        return $this->seqCiudadano;
    }

    public function editarCiudadano($seqCiudadano) {
        global $aptBd;
        try {
            $fchNacimiento = (esFechaValida($this->fchNacimiento)) ? "'" . $this->fchNacimiento . "'" : "NULL";
            $fchExpedicion = (esFechaValida($this->fchExpedicion)) ? "'" . $this->fchExpedicion . "'" : "NULL";
            $sql = "
                update t_ciu_ciudadano set
                    bolBeneficiario = " . intval($this->bolBeneficiario) . ",
                    bolCertificadoElectoral = " . intval($this->bolCertificadoElectoral) . ",
                    bolLgtb = " . intval($this->bolLgtb) . ",
                    fchNacimiento = " . $fchNacimiento . ",
                    numAfiliacionSalud = " . intval($this->numAfiliacionSalud) . ",
                    numAnosAprobados = " . intval($this->numAnosAprobados) . ",
                    numDocumento = " . doubleval($this->numDocumento) . ",
                    seqCajaCompensacion = " . intval($this->seqCajaCompensacion) . ",                    
                    seqCondicionEspecial = " . intval($this->seqCondicionEspecial) . ",
                    seqCondicionEspecial2 = " . intval($this->seqCondicionEspecial2) . ",
                    seqCondicionEspecial3 = " . intval($this->seqCondicionEspecial3) . ",
                    seqEstadoCivil = " . intval($this->seqEstadoCivil) . ",
                    seqEtnia = " . intval($this->seqEtnia) . ",
                    seqGrupoLgtbi = " . intval($this->seqGrupoLgtbi) . ",
                    seqNivelEducativo = " . intval($this->seqNivelEducativo) . ",
                    seqOcupacion = " . intval($this->seqOcupacion) . ",
                    seqSalud = " . intval($this->seqSalud) . ",
                    seqSexo = " . intval($this->seqSexo) . ",
                    seqTipoDocumento = " . intval($this->seqTipoDocumento) . ",
                    seqTipoVictima = " . intval($this->seqTipoVictima) . ",
                    txtApellido1 = '" . trim($this->txtApellido1) . "',
                    txtApellido2 = '" . trim($this->txtApellido2) . "',
                    txtNombre1 = '" . trim($this->txtNombre1) . "',
                    txtNombre2 = '" . trim($this->txtNombre2) . "',
                    valIngresos = " . doubleval($this->valIngresos) . ",
                    fchExpedicion = " . $fchExpedicion . ",
                    txtEntidadDocumento = '" . trim($this->txtEntidadDocumento) . "',
                    numIndicativoSerial = " . doubleval($this->numIndicativoSerial) . ",
                    numNotariaDocumento = " . intval($this->numNotariaDocumento) . ",
                    seqCiudadDocumento = " . intval($this->seqCiudadDocumento) . ",
                    numConsecutivoCasado = " . doubleval($this->numConsecutivoCasado) . ",
                    numNotariaCasado = " . intval($this->numNotariaCasado) . ",
                    seqCiudadCasado = " . intval($this->seqCiudadCasado) . ",
                    numConsecutivoCSCDL = " . doubleval($this->numConsecutivoCSCDL) . ",
                    txtEntidadCSCDL = '" . trim($this->txtEntidadCSCDL) . "',
                    seqCiudadCSCDL = " . intval($this->seqCiudadCSCDL) . ",
                    numNotariaCSCDL = " . intval($this->numNotariaCSCDL) . ",
                    numNotariaSoltero = " . intval($this->numNotariaSoltero) . ",
                    seqCiudadSoltero = " . intval($this->seqCiudadSoltero) . ",
                    txtCertificacionUnion = '" . trim($this->txtCertificacionUnion) . "',
                    numConsecutivoUnion = " . doubleval($this->numConsecutivoUnion) . ",
                    txtEntidadUnion = '" . trim($this->txtEntidadUnion) . "',
                    numNotariaUnion = " . intval($this->numNotariaUnion) . ",
                    seqCiudadUnion = " . intval($this->seqCiudadUnion) . ",
                    numConsecutivoPartida = " . doubleval($this->numConsecutivoPartida) . ",
                    txtParroquiaPartida = '" . trim($this->txtParroquiaPartida) . "',
                    seqCiudadPartida = " . intval($this->seqCiudadPartida) . ",
                    txtTipoSoporte = '" . trim($this->txtTipoSoporte) . "'
                where seqCiudadano = $seqCiudadano		
            ";
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo actualizar los datos del ciudadano [" . $this->txtNombre1 . " " . $this->txtApellido1 . " " . $this->txtApellido2 . "]";
            //$this->arrErrores[] = $objError->getMessage();
        }
    }

    public function borrarCiudadano() {
        global $aptBd;

        // Primero elimina la relacion de este ciudadano con el hogar vinculado
        try {
            $sql = "
                delete
                from t_frm_hogar
                where seqCiudadano = " . $this->seqCiudadano . "
            ";
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo eliminar la relacion entre el ciudadano " . $this->numDocumento . " y los formularios asociados";
        }

        // Si esta bien procede a borrar el ciudadano
        if (empty($this->arrErrores)) {
            try {
                $sql = "
                    delete
                    from t_ciu_ciudadano
                    where seqCiudadano = " . $this->seqCiudadano . "
                ";
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se pudo eliminar el ciudadano " . $this->numDocumento;
            }
        }

        return (empty($this->arrErrores)) ? true : false;
    }

    public function ciudadanoExiste($seqTipoDocumento, $numDocumento) {
        global $aptBd;
        $seqCiudadano = 0;
        $sql = "
				SELECT seqCiudadano
				FROM T_CIU_CIUDADANO
				WHERE numDocumento = " . mb_ereg_replace("[^0-9]", "", $numDocumento) . "
				AND seqTipoDocumento = $seqTipoDocumento
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $seqCiudadano = $objRes->fields['seqCiudadano'];
        }
        return $seqCiudadano;
    }

    public function buscarNombre($txtParametro, $numLimiteRegistros = 20) {

        global $aptBd;

        $arrResultados = array();
        $txtParametro = strtolower($txtParametro);


        $sql = " 
					SELECT 
						CONCAT( ucwords( ciu.txtNombre1 ) , ' ' , 
						        ucwords( ciu.txtNombre2 ) , ' ' ,
						        ucwords( ciu.txtApellido1 ) , ' ' , 
						        ucwords( ciu.txtApellido2 ) ) as nombre , 
								ciu.numDocumento 
						
					FROM  T_CIU_CIUDADANO ciu 
					WHERE lower( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) LIKE '%$txtParametro%' 
					LIMIT $numLimiteRegistros
				";


        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $arrResultados[] = $objRes->fields;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            return $objError->msg;
        }

        return $arrResultados;
    }

    public function documentoVinculado($seqFormulario) {
        global $aptBd;
        $numDocumento = 0;
        $sql = "
				SELECT 
					ciu.numDocumento
				FROM 
					T_FRM_HOGAR hog,
					T_CIU_CIUDADANO ciu
				WHERE hog.seqCiudadano = ciu.seqCiudadano
				and hog.seqFormulario = $seqFormulario			
			";

        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $numDocumento = $objRes->fields['numDocumento'];
            }
        } catch (Exception $objError) {
            
        }
        return $numDocumento;
    }

    public function formularioVinculado($numCedula, $bolPostualtePrincipal = false, $bolSoloMayorEdad = true) {
        global $aptBd;
        $seqFormulario = 0;
        $sql = "
				SELECT 
					hog.seqFormulario
				FROM 
					T_FRM_HOGAR hog,
					T_CIU_CIUDADANO ciu
				WHERE hog.seqCiudadano = ciu.seqCiudadano ";
        if ($bolSoloMayorEdad) {
            $sql .= " and ciu.seqTipoDocumento in (1,2) ";
        }
        $sql .= " and ciu.numDocumento = $numCedula ";

        if ($bolPostualtePrincipal) {
            $sql .= "and hog.seqParentesco = 1 ";
        }
        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqFormulario = $objRes->fields['seqFormulario'];
            } else {
                $this->arrErrores[] = "El numero de cedula $numCedula no se encuentra relacionado con ningún formulario";
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo consultar la información del ciudadano $numCedula";
            $this->arrErrores[] = $objError->getMessage();
        }
        return $seqFormulario;
    }

    public function formularioVinculado2($numCedula, $tipoDocumento, $bolPostualtePrincipal = false, $bolSoloMayorEdad = true) {
        global $aptBd;
        $seqFormulario = 0;
        $sql = "
				SELECT 
					hog.seqFormulario
				FROM 
					T_FRM_HOGAR hog,
					T_CIU_CIUDADANO ciu
				WHERE hog.seqCiudadano = ciu.seqCiudadano ";

        if ($bolSoloMayorEdad) {
            $sql .= " AND ciu.seqTipoDocumento in (1,2) ";
        }
        $sql .= " AND ciu.numDocumento = $numCedula ";
        $sql .= " AND ciu.seqTipoDocumento = $tipoDocumento ";

        if ($bolPostualtePrincipal) {
            $sql .= " AND hog.seqParentesco = 1 ";
        }
        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $seqFormulario = $objRes->fields['seqFormulario'];
            }
        } catch (Exception $objError) {
            
        }
        return $seqFormulario;
    }

    public function obtenerCodigo($codigo) {

        global $aptBd;

        $sql = "SELECT * FROM t_ciu_carta where txtCodigo = '" . $codigo . "'";
        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $arrResultados[] = $objRes->fields;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            return $objError->msg;
        }

        return $arrResultados;
    }

    public function ValidarMovilizacion($seqFormulario) {

        global $aptBd;

        $sql = "
            SELECT 
                    count(*) as cantidad
            FROM 
                    T_FRM_FORMULARIO
                    INNER JOIN T_FRM_ESTADO_PROCESO ON(T_FRM_ESTADO_PROCESO.seqEstadoProceso =  T_FRM_FORMULARIO.seqEstadoProceso )
            WHERE T_FRM_FORMULARIO.seqFormulario = " . $seqFormulario . " and T_FRM_ESTADO_PROCESO.seqEstadoProceso in(1,5,8,10,11,12,13,14,18,21,35,36,39,52) ";
        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $validar = $objRes->fields['cantidad'];
            }
        } catch (Exception $objError) {
            
        }
        return $validar;
    }

    public function obtenerUsuarioCarta($usuario) {

        global $aptBd;

        $sql = "SELECT CONCAT( ucwords( txtNombre ) , ' ' ,  ucwords( txtApellido)  ) as nombre FROM t_cor_usuario where seqUsuario = '" . $usuario . "'";
        try {
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $arrResultados = $objRes->fields;
                $objRes->MoveNext();
            }
        } catch (Exception $objError) {
            return $objError->msg;
        }

        return $arrResultados;
    }

    public function obtenerNombre($numDocumento) {
        global $aptBd;
        $txtNombre = "";
        $sql = " 
            SELECT 
              txtNombre1,
              txtNombre2,
              txtApellido1,
              txtApellido2
            FROM T_CIU_CIUDADANO
            WHERE numDocumento = " . $numDocumento . "
        ";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $txtNombre = trim($objRes->fields['txtNombre1']) . " ";
            $txtNombre .= ( trim($objRes->fields['txtNombre2']) != "" ) ? trim($objRes->fields['txtNombre2']) . " " : "";
            $txtNombre .= trim($objRes->fields['txtApellido1']) . " ";
            $txtNombre .= trim($objRes->fields['txtApellido2']);
        }
        return $txtNombre;
    }

     public function obtenerIp($ip) {
        global $aptBd;
        setlocale(LC_TIME,"es_ES");
       $today = date("Y-m-d");  
        //echo $day;
        $numIp = 0;
        $sql = " 
            SELECT count(txtDirIp) as contador FROM t_ciu_carta where fchCarta like '".$today."' and txtDirIp like '".$ip."'";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {         
            $numIp = trim($objRes->fields['contador']);           
}
        return $numIp;
    }

}

// fin clase
?>