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
class CiudadanoActo {

    public $seqCiudadano;
    public $txtNombre1;
    public $txtNombre2;
    public $txtApellido1;
    public $txtApellido2;
    public $fchNacimiento;
    public $seqTipoDocumento;
    public $numDocumento;
    public $valIngresos;
    public $seqNivelEducativo;
    public $seqEtnia;
    public $seqEstadoCivil;
    public $seqOcupacion;
    public $seqCondicionEspecial;
    public $seqCondicionEspecial2;
    public $seqCondicionEspecial3;
    public $seqSexo;
    public $bolLgtb;
    public $seqGrupoLgtbi;
    public $seqTipoVictima;
    public $seqParentesco;
    public $seqCajaCompensacion;     // Obsoleto
    public $bolBeneficiario;         // Obsoleto
    public $seqSalud;                // Obsoleto
    public $bolCertificadoElectoral; // Obsoleto
    public $bolSoporteDocumento;     // Obsoleto
    public $arrErrores;

    /**
     * CONSTRUCTOR
     */
    public function Ciudadano() {

        $this->seqCiudadano = 0;
        $this->txtNombre1 = "";
        $this->txtNombre2 = "";
        $this->txtApellido1 = "";
        $this->txtApellido2 = "";
        $this->fchNacimiento = "";
        $this->seqTipoDocumento = "";
        $this->numDocumento = "";
        $this->valIngresos = "";
        $this->seqNivelEducativo = "";
        $this->seqEtnia = "";
        $this->seqEstadoCivil = "";
        $this->seqOcupacion = "";
        $this->seqCondicionEspecial = "";
        $this->seqCondicionEspecial2 = "";
        $this->seqCondicionEspecial3 = "";
        $this->seqSexo = "";
        $this->bolLgtb = "";
        $this->seqTipoVictima = 0;
        $this->seqGrupoLgtbi = 0;
        $this->seqParentesco = 0;
        $this->seqCajaCompensacion = 1; // Obsoleto
        $this->bolBeneficiario = 0; // Obsoleto
        $this->seqSalud = 1; // Obsoleto
        $this->bolCertificadoElectoral = 0; // Obsoleto
        $this->bolSoporteDocumento = 0; // Obsoleto

        $this->arrErrores = array();
    }

// Fin constructor

    /**
     * GUARDA LOS DATOS DEL CIUDADANO EN LA BASE DE DATOS 
     * @global type $aptBd
     * @return int $seqCiudadano
     */
    public function guardarCiudadano() {
        global $aptBd;

        $sql = "	    	
            INSERT INTO t_aad_ciudadano_acto (
               txtNombre1,
               txtNombre2,
               txtApellido1,
               txtApellido2,
               fchNacimiento,
               seqTipoDocumento,
               numDocumento,
               valIngresos,
               seqCajaCompensacion,
               seqNivelEducativo,
               seqEtnia,
               seqEstadoCivil,
               seqOcupacion,
               seqCondicionEspecial,
               seqCondicionEspecial2,
               seqCondicionEspecial3,
               seqSexo,
               bolLgtb,
               bolBeneficiario,
               seqSalud,
               bolCertificadoElectoral,
               seqTipoVictima,
               seqGrupoLgtbi
            ) VALUES (
               \"" . $this->txtNombre1 . "\",
               \"" . $this->txtNombre2 . "\",
               \"" . $this->txtApellido1 . "\", 
               \"" . $this->txtApellido2 . "\",
               \"" . $this->fchNacimiento . "\",
               " . $this->seqTipoDocumento . ", 
               " . mb_ereg_replace("[^0-9]", "", $this->numDocumento) . ",
               " . mb_ereg_replace("[^0-9]", "", $this->valIngresos) . ",
               " . $this->seqCajaCompensacion . ",
               " . $this->seqNivelEducativo . ",
               " . $this->seqEtnia . ",
               " . $this->seqEstadoCivil . ", 
               " . $this->seqOcupacion . ",
               " . $this->seqCondicionEspecial . ",
               " . $this->seqCondicionEspecial2 . ",
               " . $this->seqCondicionEspecial3 . ",
               " . $this->seqSexo . ",
               " . $this->bolLgtb . ",
               " . $this->bolBeneficiario . ",
               " . $this->seqSalud . ",
               " . $this->bolCertificadoElectoral . ",
               " . $this->seqTipoVictima . ",
               " . $this->seqGrupoLgtbi . "
            )
         ";

        try {
            $aptBd->execute($sql);
            $this->seqCiudadano = $aptBd->Insert_ID();
        } catch (Exception $objError) {
            $this->seqCiudadano = 0;
            $this->arrErrores[] = "El ciudadano identificado con el n&uacute;mero de documento " . number_format($this->numDocumento) . " no se pudo guardar, puede que ya exista en el aplicativo";
            $this->arrErrores[] = $objError->getMessage();
        }

        return $this->seqCiudadano;
    }

// fin guardar ciudadano

    /**
     * ELIMINA UN CIUDADANO CONEL SECUENCIAL DE CIUDADANO
     * @global type $aptBd
     * @param type $seqCiudadano
     */
    public function borrarCiudadano($seqCiudadanoActo) {
        global $aptBd;
        $sql = "
            DELETE
            FROM  t_aad_ciudadano_acto
            WHERE seqCiudadanoActo = $seqCiudadanoActo
         ";
        $aptBd->execute($sql);
    }

    public function cargarCiudadano($seqCiudadano) {
        global $aptBd;
        $sql = "	
				SELECT 
               seqCiudadanoActo,
               ucwords(trim(txtNombre1)) as txtNombre1,
               ucwords(trim(txtNombre2)) as txtNombre2,
               ucwords(trim(txtApellido1)) as txtApellido1,
               ucwords(trim(txtApellido2)) as txtApellido2,
               fchNacimiento,
               seqTipoDocumento,
               numDocumento,
               valIngresos,
               seqCajaCompensacion,
               seqNivelEducativo,
               seqEtnia,
               seqEstadoCivil,
               seqOcupacion,
               seqCondicionEspecial,
               seqCondicionEspecial2,
               seqCondicionEspecial3,
               seqSexo,
               bolLgtb,
               bolBeneficiario,
               seqSalud,
               bolCertificadoElectoral,
               seqTipoVictima,
               seqGrupoLgtbi
            FROM T_AAD_CIUDADANO_ACTO
            WHERE seqCiudadanoActo = $seqCiudadano		
			";
       // echo "<br>*****" .$sql." *****<br>";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $this->seqCiudadano = $objRes->fields['seqCiudadano'];
            $this->txtNombre1 = $objRes->fields['txtNombre1'];
            $this->txtNombre2 = $objRes->fields['txtNombre2'];
            $this->txtApellido1 = $objRes->fields['txtApellido1'];
            $this->txtApellido2 = $objRes->fields['txtApellido2'];
            $this->fchNacimiento = $objRes->fields['fchNacimiento'];
            $this->seqTipoDocumento = $objRes->fields['seqTipoDocumento'];
            $this->numDocumento = $objRes->fields['numDocumento'];
            $this->valIngresos = $objRes->fields['valIngresos'];
            $this->seqCajaCompensacion = $objRes->fields['seqCajaCompensacion'];
            $this->seqNivelEducativo = $objRes->fields['seqNivelEducativo'];
            $this->seqEtnia = $objRes->fields['seqEtnia'];
            $this->seqEstadoCivil = $objRes->fields['seqEstadoCivil'];
            $this->seqOcupacion = $objRes->fields['seqOcupacion'];
            $this->seqCondicionEspecial = $objRes->fields['seqCondicionEspecial'];
            $this->seqCondicionEspecial2 = $objRes->fields['seqCondicionEspecial2'];
            $this->seqCondicionEspecial3 = $objRes->fields['seqCondicionEspecial3'];
            $this->seqSexo = $objRes->fields['seqSexo'];
            $this->bolLgtb = $objRes->fields['bolLgtb'];
            $this->bolBeneficiario = $objRes->fields['bolBeneficiario'];
            $this->seqSalud = $objRes->fields['seqSalud'];
            $this->bolCertificadoElectoral = $objRes->fields['bolCertificadoElectoral'];
            $this->seqTipoVictima = $objRes->fields['seqTipoVictima'];
            $this->seqGrupoLgtbi = $objRes->fields['seqGrupoLgtbi'];
        } else {
            $this->arrErrores[] = "Ciudadano [$seqCiudadano] no encontrado";
        }
    }

// fin cargar Ciudadano

    public function editarCiudadano($seqCiudadanoActo) {
        global $aptBd;

        $sql = "
                UPDATE t_aad_ciudadano_acto SET 
                        txtNombre1              = \"" . $this->txtNombre1 . "\", 
                        txtNombre2              = \"" . $this->txtNombre2 . "\",
                        txtApellido1            = \"" . $this->txtApellido1 . "\",
                        txtApellido2            = \"" . $this->txtApellido2 . "\",
                        fchNacimiento           = \"" . $this->fchNacimiento . "\",
                        seqTipoDocumento        = " . $this->seqTipoDocumento . ", 
                        numDocumento            = " . mb_ereg_replace("[^0-9]", "", $this->numDocumento) . ",
                        valIngresos             = " . mb_ereg_replace("[^0-9]", "", $this->valIngresos) . ",
                        seqNivelEducativo       = " . $this->seqNivelEducativo . ",
                        seqEtnia                = " . $this->seqEtnia . ",
                        seqEstadoCivil          = " . $this->seqEstadoCivil . ", 
                        seqOcupacion            = " . $this->seqOcupacion . ",
                        seqCondicionEspecial    = " . $this->seqCondicionEspecial . ",
                        seqCondicionEspecial2   = " . $this->seqCondicionEspecial2 . ",
                        seqCondicionEspecial3   = " . $this->seqCondicionEspecial3 . ", 
                        seqSexo                 = " . $this->seqSexo . ",
                        bolLgtb                 = " . $this->bolLgtb . ",
                        seqSalud                = " . $this->seqSalud . ",
                        bolCertificadoElectoral = " . $this->bolCertificadoElectoral . ",
                        seqTipoVictima          = " . $this->seqTipoVictima . ",
                        seqGrupoLgtbi           = " . $this->seqGrupoLgtbi . ",
seqCajaCompensacion     = " . $this->seqCajaCompensacion . ",
bolBeneficiario         = " . $this->bolBeneficiario . "
                WHERE
                        seqCiudadano = $seqCiudadanoActo		
        ";

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $this->arrErrores[] = "No se pudo actualizar los datos del ciudadano [" . $this->txtNombre1 . " " . $this->txtApellido1 . " " . $this->txtApellido2 . "]";
        }
    }

    public function ciudadanoExiste($seqTipoDocumento, $numDocumento) {

        global $aptBd;

        $seqCiudadano = 0;

        $numDocumentoFormat = str_replace(".", "", $numDocumento);

        $sql = "
				SELECT seqCiudadanoActo
				FROM t_aad_ciudadano_acto
				WHERE numDocumento = $numDocumentoFormat
				AND seqTipoDocumento = $seqTipoDocumento
			";

        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            $seqCiudadano = $objRes->fields['seqCiudadanoActo'];
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
						
					FROM   t_aad_ciudadano_acto ciu 
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

    /**
     * RETORNA EL IDENTIFICADOR DEL FIRMUALRIO AL QUE
     * ESTA VINCULADO UN CIUDADANO
     * @author Bernardo Zerda
     * @author Diego Gaitan
     * @param Integer nmCedula
     * @param Boolean bolPostulantePrincipal ==> TRUE: para que varifique que la cedula es de un posultante principal
     * 												   si la cedua no corresponde a un postulante principal retorna cero (0)
     * 											 FALSE: Cualquier miembro de hogar funciona, solo retorna cero si el ciudadano no existe o 
     * 													no esta vinculado a ningun formulario
     * @param Boolean bolSoloMayorEdad      ==> TRUE: Consulta solo ciudadanos con cedula de ciudadania o cedula de extranjeria
     * 											FALSE: Consulta cualquier tipo de documento
     * @version 1.0 Dic 2009
     * @version 1.1 Sep 2010
     */
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
            }
        } catch (Exception $objError) {
            
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

    //Cambios Liliana Basto Verificación de los usuarios que permiten generar carta de Movilización
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

}

// fin clase
?>