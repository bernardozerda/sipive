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
        $this->seqEstadoCivil = 0;
        $this->seqEtnia = 1;
        $this->seqGrupoLgtbi = 0;
        $this->seqNivelEducativo = 1;
        $this->seqOcupacion = 20;
        $this->seqParentesco = 0;
        $this->seqSalud = 0;
        $this->seqSexo = 0;
        $this->seqTipoDocumento = 0;
        $this->seqTipoVictima = 0;
        $this->txtApellido1 = "";
        $this->txtApellido2 = "";
        $this->txtNombre1 = "";
        $this->txtNombre2 = "";
        $this->valIngresos = 0;

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
                valIngresos
            FROM T_CIU_CIUDADANO
            WHERE seqCiudadano = $seqCiudadano		
		";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {

            $this->bolBeneficiario = intval($objRes->fields['bolBeneficiario']);
            $this->bolCertificadoElectoral = intval($objRes->fields['bolCertificadoElectoral']);
            $this->bolLgtb = intval($objRes->fields['bolLgtb']);
            $this->bolSoporteDocumento = intval($objRes->fields['bolSoporteDocumento']);
            $this->fchNacimiento = (esFechaValida($objRes->fields['fchNacimiento']))? $objRes->fields['fchNacimiento'] : null;
            $this->numAfiliacionSalud = intval($objRes->fields['numAfiliacionSalud']);
            $this->numAnosAprobados = intval($objRes->fields['numAnosAprobados']);
            $this->numDocumento = intval($objRes->fields['numDocumento']);
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
            $this->valIngresos = doubleval($objRes->fields['valIngresos']);;

        } else {
            $this->arrErrores[] = "Ciudadano [$seqCiudadano] no encontrado";
        }
    }

    public function guardarCiudadano() {
        global $aptBd;
        try {
            $fchNacimiento = (esFechaValida($this->fchNacimiento))? "'" . $this->fchNacimiento . "'" : "NULL";
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
                    valIngresos
                ) VALUES (
                    " . intval( $this->bolBeneficiario ) . ",
                    " . intval( $this->bolCertificadoElectoral ) . ",
                    " . intval( $this->bolLgtb ) . ",
                    " . $fchNacimiento . ",
                    " . intval( $this->numAfiliacionSalud ) . ",
                    " . intval( $this->numAnosAprobados ) . ",
                    " . doubleval( $this->numDocumento ) . ",
                    " . intval( $this->seqCajaCompensacion ) . ",                    
                    " . intval( $this->seqCondicionEspecial ) . ",
                    " . intval( $this->seqCondicionEspecial2 ) . ",
                    " . intval( $this->seqCondicionEspecial3 ) . ",
                    " . intval( $this->seqEstadoCivil ) . ",
                    " . intval( $this->seqEtnia ) . ",
                    " . intval( $this->seqGrupoLgtbi ) . ",
                    " . intval( $this->seqNivelEducativo ) . ",
                    " . intval( $this->seqOcupacion ) . ",
                    " . intval( $this->seqSalud ) . ",
                    " . intval( $this->seqSexo ) . ",
                    " . intval( $this->seqTipoDocumento ) . ",
                    " . intval( $this->seqTipoVictima ) . ",
                    '" . trim( $this->txtApellido1 ) . "',
                    '" . trim( $this->txtApellido2 ) . "',
                    '" . trim( $this->txtNombre1 ) . "',
                    '" . trim( $this->txtNombre2 ) . "',
                    " . doubleval( $this->valIngresos ) . "
                )
             ";
            $aptBd->execute($sql);
            $this->seqCiudadano = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $this->seqCiudadano = 0;
            $this->arrErrores[] = "El ciudadano identificado con el n&uacute;mero de documento " . number_format($this->numDocumento) . " no se pudo guardar, puede que ya exista en el aplicativo";
            //$this->arrErrores[] = $objError->getMessage();
        }

        return $this->seqCiudadano;
    }

    public function editarCiudadano($seqCiudadano) {
        global $aptBd;
        try {
            $fchNacimiento = (esFechaValida($this->fchNacimiento))? "'" . $this->fchNacimiento . "'" : "NULL";
            $sql = "
                update t_ciu_ciudadano set
                    bolBeneficiario = " . intval( $this->bolBeneficiario ) . ",
                    bolCertificadoElectoral = " . intval( $this->bolCertificadoElectoral ) . ",
                    bolLgtb = " . intval( $this->bolLgtb ) . ",
                    fchNacimiento = " . $fchNacimiento . ",
                    numAfiliacionSalud = " . intval( $this->numAfiliacionSalud ) . ",
                    numAnosAprobados = " . intval( $this->numAnosAprobados ) . ",
                    numDocumento = " . doubleval( $this->numDocumento ) . ",
                    seqCajaCompensacion = " . intval( $this->seqCajaCompensacion ) . ",                    
                    seqCondicionEspecial = " . intval( $this->seqCondicionEspecial ) . ",
                    seqCondicionEspecial2 = " . intval( $this->seqCondicionEspecial2 ) . ",
                    seqCondicionEspecial3 = " . intval( $this->seqCondicionEspecial3 ) . ",
                    seqEstadoCivil = " . intval( $this->seqEstadoCivil ) . ",
                    seqEtnia = " . intval( $this->seqEtnia ) . ",
                    seqGrupoLgtbi = " . intval( $this->seqGrupoLgtbi ) . ",
                    seqNivelEducativo = " . intval( $this->seqNivelEducativo ) . ",
                    seqOcupacion = " . intval( $this->seqOcupacion ) . ",
                    seqSalud = " . intval( $this->seqSalud ) . ",
                    seqSexo = " . intval( $this->seqSexo ) . ",
                    seqTipoDocumento = " . intval( $this->seqTipoDocumento ) . ",
                    seqTipoVictima = " . intval( $this->seqTipoVictima ) . ",
                    txtApellido1 = '" . trim( $this->txtApellido1 ) . "',
                    txtApellido2 = '" . trim( $this->txtApellido2 ) . "',
                    txtNombre1 = '" . trim( $this->txtNombre1 ) . "',
                    txtNombre2 = '" . trim( $this->txtNombre2 ) . "',
                    valIngresos = " . doubleval( $this->valIngresos ) . "
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
        } catch (Exception $objError){
            $this->arrErrores[] = "No se pudo eliminar la relacion entre el ciudadano " . $this->numDocumento . " y los formularios asociados";
        }

        // Si esta bien procede a borrar el ciudadano
        if( empty( $this->arrErrores ) ){
            try{
                $sql = "
                    delete
                    from t_ciu_ciudadano
                    where seqCiudadano = " . $this->seqCiudadano . "
                ";
                $aptBd->execute($sql);
            } catch ( Exception $objError ){
                $this->arrErrores[] = "No se pudo eliminar el ciudadano " . $this->numDocumento;
            }
        }

        return (empty($this->arrErrores))? true : false;
    }

    public function ciudadanoExiste($seqTipoDocumento, $numDocumento) {
        global $aptBd;
        $seqCiudadano = 0;
        $sql = "
				SELECT seqCiudadano
				FROM T_CIU_CIUDADANO
				WHERE numDocumento = " . mb_ereg_replace("[^0-9]","",$numDocumento) . "
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
					WHERE  ciu.seqTipoDocumento in ( 1 , 2 ) AND  
					lower( CONCAT( ciu.txtNombre1 , ' ' , ciu.txtNombre2 , ' ' , ciu.txtApellido1 , ' ' , ciu.txtApellido2 ) ) LIKE '%$txtParametro%' 
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
            }else{
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
            WHERE T_FRM_FORMULARIO.seqFormulario = " . $seqFormulario . " and (T_FRM_ESTADO_PROCESO.seqEtapa = 1 or  T_FRM_ESTADO_PROCESO.seqEtapa = 2) and bolCerrado = 0  ";
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

    public function obtenerNombre($numDocumento){
        global $aptBd;
        $txtNombre = "";
        $sql = " 
            SELECT 
              txtNombre1,
              txtNombre2,
              txtApellido1,
              txtApellido2
            FROM T_CIU_CIUDADANO
            WHERE numDocumento = ".$numDocumento."
        ";
        $objRes = $aptBd->execute($sql);
        if($objRes->fields) {
            $txtNombre = trim($objRes->fields['txtNombre1']) . " ";
            $txtNombre .= ( trim($objRes->fields['txtNombre2']) != "" ) ? trim($objRes->fields['txtNombre2']) . " " : "";
            $txtNombre .= trim($objRes->fields['txtApellido1']) . " ";
            $txtNombre .= trim($objRes->fields['txtApellido2']);
        }
        return $txtNombre;
    }

}

// fin clase
?>