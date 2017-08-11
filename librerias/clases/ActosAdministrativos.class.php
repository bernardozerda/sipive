<?php

/**
 * CALSE PARA LOS TIPOS DE ACTOS ADMINISTRATIVOS
 * OBTIENE SUS CARACTERISTICAS Y LOS TIPOS DE DATOS 
 * DE CADA CARACTERISTICA DE ACUERDO AL TIPO DE ACTO
 * @author Bernardo Zerda Rodriguez
 * @version versionstring Febrero de 2010
 * */
 
class TipoActoAdministrativo {

    public $seqTipoActo;
    public $arrTipoActos;
    public $txtNombreTipoActo;
    public $arrFormatoArchivo;
    public $arrCaracteristicas;
    public $arrErrores;

    // constructor de la clase
    public function TipoActoAdministrativo() {
        global $aptBd;
        $this->arrTipoActos = array();
        $sql = "
				SELECT 
				  tac.seqTipoActo,
				  tac.txtNombreTipoActo
				FROM 
				  T_AAD_TIPO_ACTO tac
				ORDER BY
				  tac.seqTipoActo
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $this->arrTipoActos[$objRes->fields['seqTipoActo']] = $objRes->fields['txtNombreTipoActo'];
            $objRes->MoveNext();
        }
    }

// fin constructor

    public function cargarTipoActo($seqTipoActo) {
        global $aptBd;
        $this->seqTipoActo = $seqTipoActo;
        $this->txtNombreTipoActo = "";
        $this->arrCaracteristicas = array();
        $sql = "
				SELECT
				  tac.txtNombreTipoActo,
				  cac.seqCaracteristica,
				  cac.txtNombreCaracteristica,
				  cac.txtTipoDato
				FROM 
				  T_AAD_TIPO_ACTO tac
				INNER JOIN T_AAD_CARACTERISTICA_ACTO cac ON cac.seqTipoActo = tac.seqTipoActo
				WHERE tac.seqTipoActo = $seqTipoActo
			";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $this->txtNombreTipoActo = $objRes->fields['txtNombreTipoActo'];
            $this->arrCaracteristicas[$objRes->fields['seqCaracteristica']]['nombre'] = $objRes->fields['txtNombreCaracteristica'];
            $this->arrCaracteristicas[$objRes->fields['seqCaracteristica']]['dato'] = $objRes->fields['txtTipoDato'];
            $objRes->MoveNext();
        }

        // Formato para el archivo de los actos administrativos
        switch ($seqTipoActo) {
            case 1: // Resolucion de asignacion
                $this->arrFormatoArchivo[] = "documento";
                break;
            case 2: // Resolucion Modificatoria
                $this->arrFormatoArchivo[] = "Documento";
                $this->arrFormatoArchivo[] = "Campo";
                $this->arrFormatoArchivo[] = "Incorrecto";
                $this->arrFormatoArchivo[] = "Correcto";
                break;
            case 3: // Resolucion de inhabilitados
                $this->arrFormatoArchivo[] = "secuencia de formulario";
                $this->arrFormatoArchivo[] = "modalidad";
                $this->arrFormatoArchivo[] = "desplazado";
                $this->arrFormatoArchivo[] = "numero de formulario";
                $this->arrFormatoArchivo[] = "cedula Jefe de Hogar";
                $this->arrFormatoArchivo[] = "documento del miembro de hogar";
                $this->arrFormatoArchivo[] = "nombre del miembro de hogar";
                $this->arrFormatoArchivo[] = "parentesco";
                $this->arrFormatoArchivo[] = "texto de la causa";
                $this->arrFormatoArchivo[] = "fuente";
                $this->arrFormatoArchivo[] = "titulo detalle1";
                $this->arrFormatoArchivo[] = "detalle1";
                $this->arrFormatoArchivo[] = "titulo detalle 2";
                $this->arrFormatoArchivo[] = "detalle2";
                $this->arrFormatoArchivo[] = "titulo detalle 3";
                $this->arrFormatoArchivo[] = "detalle3";
                $this->arrFormatoArchivo[] = "titulo detalle 4";
                $this->arrFormatoArchivo[] = "detalle4";
                $this->arrFormatoArchivo[] = "titulo detalle 5";
                $this->arrFormatoArchivo[] = "detalle5";
                break;
            case 4: // Recurso de Reposicion
                $this->arrFormatoArchivo[] = "documento";
                $this->arrFormatoArchivo[] = "resultado";
                break;
            case 5: // Resolucion de No Asignado
            case 6: // Resolucion de Renuncia
            case 7: // Notificacion
                $this->arrFormatoArchivo[] = "Documento"; // Cedulas de los Jefes de Hogares publicados
                break;
            case 8:
               $this->arrFormatoArchivo[] = "documento";
               $this->arrFormatoArchivo[] = "numero";
               $this->arrFormatoArchivo[] = "fecha";
               $this->arrFormatoArchivo[] = "valor";
               break;
            default: // Otros tipos de actos
                $this->arrErrores[] = "Tipo de Acto administrativo no soportado";
                break;
        }
    }

    public function validarDatos($arrCaracteristicas) {

        global $aptBd;

        if (!empty($this->arrCaracteristicas)) {
            foreach ($this->arrCaracteristicas as $seqCaracteristicas => $arrInformacion) {
                if (isset($arrCaracteristicas[$seqCaracteristicas])) {
                    switch ($arrInformacion['dato']) {
                        case "numero":
                            if (!is_numeric($arrCaracteristicas[$seqCaracteristicas])) {
                                $this->arrErrores[] = "El valor para " . $arrInformacion['nombre'] . " debe ser numerico";
                            }
                            break;
                        case "fecha":
                            list( $ano, $mes, $dia ) = split("-", $arrCaracteristicas[$seqCaracteristicas]);
                            if (@checkdate($mes, $dia, $ano) === false) {
                                $this->arrErrores[] = "El valor para " . $arrInformacion['nombre'] . " debe ser una fecha válida";
                            }
                            break;
                        default:
                            if (trim($arrCaracteristicas[$seqCaracteristicas]) == "") {
                                $this->arrErrores[] = "El valor para " . $arrInformacion['nombre'] . " no puede estar vacio";
                            }
                            break;
                    }
                } else {
                    $this->arrErrores[] = "Debe haber un valor para el campo " . $arrInformacion['nombre'];
                }
            }
        } else {
            $this->arrErrores[] = "No hay caracteristicas para analizar";
        }
    }

    public function validarArchivo($txtArchivoTemporal) {

        // donde se guardan los datos del archivo validado
        $arrArchivo = array();

        // Abre el archivo
        $aptArchivo = fopen($txtArchivoTemporal, "r");

        // Obtiene los titulos del archivo
        $arrTitulo = split("\t", fgets($aptArchivo));

        // Valida los titulos
        foreach ($this->arrFormatoArchivo as $numPosicion => $txtTitulo) {
            if (strtolower(trim($arrTitulo[$numPosicion])) != strtolower(trim($txtTitulo))) {
                $this->arrErrores[] = "Error de formato de archivo, falta la columna " . ucwords($txtTitulo);
            }
        }

        // si no hay errores continua
        if (empty($this->arrErrores)) {
            // valida las lineas del archivo
            $numLinea = 1;
            while ($txtLinea = utf8_encode(fgets($aptArchivo))) {
                if (trim($txtLinea) != "") {
                    $arrLinea = split("\t", (string) $txtLinea);
                    switch ($this->seqTipoActo) {
                        case 1: // valida linea resolucion de asignacion
                            $arrLinea = $this->validarLineaResolucionAsignacion($numLinea, $arrLinea);
                            break;
                        case 2: // valida linea resolucion modificatoria
                            $arrLinea = $this->validarLineaResolucionModificatoria($numLinea, $arrLinea);
                            break;
                        case 3: // valida linea resolucion de inhabilitados
                            $arrLinea = $this->validarLineaResolucionInhabilitados($numLinea, $arrLinea);
                            break;
                        case 4: // valida linea de recursos de reposicion
                            $arrLinea = $this->validarLineaRecursoReposicion($numLinea, $arrLinea);
                            break;
                        case 5: // valida linea de Resolucion de no asignado
                        case 6: // valida linea de Resolucion de renuncia
                        case 7: // valida linea de Notificacion
                            // USA EL MISMO DE RESOLUCION DE ASIGNACION
                            $arrLinea = $this->validarLineaResolucionAsignacion($numLinea, $arrLinea);
                            break;
                        case 8:
                           $arrLinea = $this->validarLineaResolucionIndexacion( $numLinea , $arrLinea );
                           break;
                        default:
                            $arrLinea = array();
                            break;
                    }
                    if (empty($this->arrErrores)) {
                        $arrArchivo[$numLinea] = $arrLinea;
                    }
                    $numLinea++;
                }
            }
        }
        return $arrArchivo;
    }

    private function validarLineaRecursoReposicion($numLinea, $arrLinea) {

        // Valida que el numero de documento sea un numero
        if (!is_numeric((int) $arrLinea[0])) {
            $this->arrErrores[] = "Error Linea $numLinea: No es un numero de documento valido";
        }

        if (Ciudadano::formularioVinculado($arrLinea[0], true) == 0) {
            $this->arrErrores[] = "Error Linea $numLinea: El documento " . $arrLinea[0] . " no es el Jefe de Hogar o no esta asignado a un formulario.";
        }

        // Valida que el estado no este vacio
        if (trim($arrLinea[1]) == "") {
            $this->arrErrores[] = "Error Linea $numLinea: El estado no puede estar vacio";
        }

        return $arrLinea;
    }

    private function validarLineaResolucionModificatoria($numLinea, $arrLinea) {

        // Valida que el numero de documento sea un numero
        if (!is_numeric((int) $arrLinea[0])) {
            $this->arrErrores[] = "Error Linea $numLinea: No es un numero de documento valido";
        }

        if (empty($this->arrErrores)) {

            $seqFormulario = Ciudadano::formularioVinculado($arrLinea[0], true);

            if ($seqFormulario == 0) {
                $this->arrErrores[] = "Error Linea $numLinea: El documento " . $arrLinea[0] . " no es el Jefe de Hogar o no esta asignado a un formulario.";
            }

            if (trim($arrLinea[1]) == "") {
                $this->arrErrores[] = "Error Linea $numLinea: La columna Campo no puede estar vacia.";
            }

            if (trim($arrLinea[2]) == trim($arrLinea[3])) {
                $this->arrErrores[] = "Error Linea $numLinea: El valor de las columnas Incorrecto y Correcto no pueden ser vacias o contener el mismo valor.";
            }
        }

        return $arrLinea;
    }

    private function validarLineaResolucionInhabilitados($numLinea, $arrLinea) {

        $seqFormulario = $arrLinea[0];

        // valida que el campo no este vacio
        if ($seqFormulario == "") {
            $this->arrErrores[] = "Error Linea $numLinea: La Columna Secuencia de formulario no puede estar vacia";
        }

        //valida que el numero de formulario exista
        if (!$this->validarSeqformulario($seqFormulario)) {
            $this->arrErrores[] = "Error Linea $numLinea: El formulario " . $arrLinea[0] . " no existe.";
        } else {
            ////valida que el documento principal ingresado sea un documento principal del formulario ingresado
            if ($this->validarDocPpalForm($arrLinea[0], $arrLinea[4]) == "no") {
                $this->arrErrores[] = "Error $aqui Linea $numLinea: El documento " . $arrLinea[4] . " no es el Jefe de Hogar de Este Hogar.";
            } else {
                ////valida que el documento del miembro del hogar pertenezca al hogar
                if (!$this->validarDocMiembroForm($arrLinea[0], $arrLinea[5])) {
                    $this->arrErrores[] = "Error Linea $numLinea: El Documento " . $arrLinea[5] . " no pertenece al Hogar";
                }
            }
        }

        // Valida que el numero de documento sea un numero
        // Jefe de Hogar
        if (!is_numeric((int) $arrLinea[4])) {
            $this->arrErrores[] = "Error Linea $numLinea: No es un numero de documento valido";
        }




        // Valida que el numero de documento sea un numero
        // Miembro
        if (!is_numeric((int) $arrLinea[5])) {
            $this->arrErrores[] = "Error Linea $numLinea: No es un numero de documento valido";
        }


        // Valida que el texto de la causa no este vacio
        if (trim($arrLinea[8]) == "") {
            $this->arrErrores[] = "Error Linea $numLinea: El texto de la causa de inhabilidad no puede estar vacio";
        }

        // Valida que la fuente no este vacia
        if (trim($arrLinea[9]) == "") {
            $this->arrErrores[] = "Error Linea $numLinea: La inhabilidad debe tener una fuente";
        }

        // Obtiene la cadena hecha de los concatenados de todos los detalles
        $txtConcatenar = "";
        for ($i = 10; $i < count($arrLinea); $i++) {
            $txtSeparador = ( fmod($i, 2) == 0 ) ? ":" : ";";
            $txtConcatenar .= trim($arrLinea[$i]) . $txtSeparador;
        }
        $txtConcatenar = ereg_replace(":;", "", $txtConcatenar);

        // Quita las posiciones que no iran dentro del registro
        for ($i = count($arrLinea); $i >= 10; $i--) {
            unset($arrLinea[$i]);
        }

        // Adiciona la cadena de detalles al registro para que vaya dentro del archivo
        $arrLinea[count($arrLinea)] = $txtConcatenar;

        return $arrLinea;
    }

    private function validarLineaResolucionAsignacion($numLinea, &$arrLinea) {

        // Valida que el numero de documento sea un numero
        if (!is_numeric((int) $arrLinea[0])) {
            $this->arrErrores[] = "Error Linea $numLinea: No es un numero de documento valido";
        }

        $seqFormulario = Ciudadano::formularioVinculado($arrLinea[0], true);
        $arrLinea["seqFormulario"] = $seqFormulario;
        if ($seqFormulario == 0) {
            $this->arrErrores[] = "Error Linea $numLinea: El documento " . $arrLinea[0] . " no es el Jefe de Hogar o no esta asignado a un formulario.";
        }

        return $arrLinea;
    }
    
   private function validarLineaResolucionIndexacion( $numLinea, &$arrLinea ){
       
      // Valida que el numero de documento sea un numero
      if (!is_numeric((int) $arrLinea[0])) {
          $this->arrErrores[] = "Error Linea $numLinea: No es un numero de documento valido";
      }
      
      // Valida que el numero de resolucion
      if (!is_numeric((int) $arrLinea[1])) {
          $this->arrErrores[] = "Error Linea $numLinea: No es un numero válido";
      }
      
      // Valida que sea una fecha de resolucion
      if (!esFechaValida( $arrLinea[2] )  ) {
          $this->arrErrores[] = "Error Linea $numLinea: No es una fecha válida";
      }
      
      // Valida que el valor sea un numero
      if (!is_numeric((int) $arrLinea[3])) {
          $this->arrErrores[] = "Error Linea $numLinea: No es un valor válido";
      }
      
      $seqFormulario = Ciudadano::formularioVinculado($arrLinea[0], true);
      $arrLinea["seqFormulario"] = $seqFormulario;
      if ($seqFormulario == 0) {
          $this->arrErrores[] = "Error Linea $numLinea: El documento " . $arrLinea[0] . " no es el Jefe de Hogar o no esta asignado a un formulario.";
      }
      
      return $arrLinea;
       
   }
    
    
    private function validarLineaNotificacion($numLinea, $arrLinea) {
        if (trim($arrLinea[0]) != "") {
            $seqFormulario = Ciudadano::formularioVinculado($arrLinea[0]);
            if ($seqFormulario != 0) {
                $claFormulario = new FormularioSubsidios;
                $claFormulario->cargarFormulario($seqFormulario);
                foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                    if ($objCiudadano->seqParentesco == 1) {
                        if ($objCiudadano->numDocumento != intval($arrLinea[0])) {
                            $this->arrErrores[] = "Error Linea $numLinea: El numero de documento " . $arrLinea[0] . " no es el Jefe del hogar";
                        } else {
                            $arrLinea[1] = $seqFormulario;
                        }
                        break;
                    }
                }
            } else {
                $this->arrErrores[] = "Error Linea $numLinea: No existe un formulario vinculado con el numero de documento " . $arrLinea[0];
            }
        }

        return $arrLinea;
    }

    private function validarLineaEdicto($numLinea, $arrLinea) {
        if (trim($arrLinea[0]) != "") {
            $seqFormulario = Ciudadano::formularioVinculado($arrLinea[0]);
            if ($seqFormulario != 0) {
                $claFormulario = new FormularioSubsidios;
                $claFormulario->cargarFormulario($seqFormulario);
                foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                    if ($objCiudadano->seqParentesco == 1) {
                        if ($objCiudadano->numDocumento != intval($arrLinea[0])) {
                            $this->arrErrores[] = "Error Linea $numLinea: El numero de documento " . $arrLinea[0] . " no es el Jefe del hogar";
                        } else {
                            $arrLinea[1] = $seqFormulario;
                        }
                        break;
                    }
                }
            } else {
                $this->arrErrores[] = "Error Linea $numLinea: No existe un formulario vinculado con el numero de documento " . $arrLinea[0];
            }
        }
        return $arrLinea;
    }

    /*
     * Funciones añadidas al codigo original
     * desarrollador: Camilo Bernal Romero
     */

    /* Función que valida si el numero de formulario (seqFormulario) existe en la DB.
     * Recibe un numero de formulario, si existe en la DB retorna true, si no retorna false 
     */

    public function validarSeqformulario($nseqform) {
        global $aptBd;
        if (is_numeric($nseqform) && $nseqform != "") {
            $query = "
            select count(*) AS existe from T_FRM_FORMULARIO where seqFormulario = $nseqform
			";

            $objRes = $aptBd->execute($query);
            if ($objRes->fields) {
                $resultado = $objRes->fields['existe'];
            }
            if ($resultado == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    //Valida que un documento ingresado pertenezca al formulario
    public function validarDocPpalForm($nseqform, $ndoc) {
        global $aptBd;

        if ((is_numeric($nseqform) && $nseqform != "") && (is_numeric($ndoc) && $ndoc != "")) {
            $query = "
            SELECT T_FRM_HOGAR.seqParentesco AS Parentesco
                FROM T_FRM_HOGAR
                    JOIN T_CIU_CIUDADANO
                    ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
                WHERE (T_FRM_HOGAR.seqFormulario = $nseqform and T_CIU_CIUDADANO.numDocumento = $ndoc)
			";

            $objRes = $aptBd->execute($query);
            if ($objRes->fields) {
                $resultado = $objRes->fields['Parentesco'];
            }
            if ($resultado == 1) {
                return "si";
            } else {
                return "no";
            }
        }
    }

    //Valida que un documento ingresado pertenezca al formulario y 
    public function validarDocMiembroForm($nseqform, $ndoc) {
        global $aptBd;
        if ((is_numeric($nseqform) && $nseqform != "") && (is_numeric($ndoc) && $ndoc != "")) {
            $query = "
            SELECT T_FRM_HOGAR.seqParentesco as Parentesco
                FROM T_FRM_HOGAR
                    JOIN T_CIU_CIUDADANO
                    ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
                WHERE (`T_FRM_HOGAR`.`seqFormulario` = $nseqform and T_CIU_CIUDADANO.numDocumento = $ndoc)
			";

            $objRes = $aptBd->execute($query);
            if ($objRes->fields) {
                $resultado = $objRes->fields['Parentesco'];
            }
            if ($resultado == 1 || $resultado == 2 || $resultado == 3 || $resultado == 4 || $resultado == 5 ||
                    $resultado == 6 || $resultado == 7 || $resultado == 8 || $resultado == 10 ||
                    $resultado == 12 || $resultado == 13) {
                return true;
            } else {
                return false;
            }
        }
    }

}

//Fin funciones añadidas 
// fin clase tipo acto administrativo

/**
 * CALSE PARA LAS OPERACIONES CON LOS ACTOS ADMINISTRATIVOS
 * @author Bernardo Zerda Rodriguez
 * @version versionstring Febrero de 2010
 * */
class ActoAdministrativo {

    public $arrErrores;
    public $seqTipoActo;
    public $numActo;
    public $fchActo;
    public $arrCaracteristicas;

    // constructor de la clase
    function ActoAdministrativo() {
        $this->arrErrores = array();
        $this->seqTipoActo = 0;
        $this->numActo = 0;
        $this->fchActo = null;
        $this->arrCaracteristicas = array();
    }

    public function obtenerActoAdministrativo($seqFormularioActo) {

        global $aptBd;
        $arrDatos = array();
        $sql = "SELECT 
						hog.seqFormularioActo,
						adm.seqActo,
						adm.seqTipoActo,
						tip.txtNombreTipoActo,
						hog.numActo,
						hog.fchActo
					FROM 
						T_AAD_HOGARES_VINCULADOS hog
					INNER JOIN T_AAD_ACTO_ADMINISTRATIVO adm ON ( adm.fchActo = hog.fchActo and adm.numActo = hog.numActo ) 
					INNER JOIN T_AAD_TIPO_ACTO tip ON adm.seqTipoActo = tip.seqTipoActo
					WHERE
						hog.seqFormularioActo = $seqFormularioActo
					-- GROUP BY adm.seqTipoActo, hog.fchActo";
        $objRes = $aptBd->execute($sql); 
        while ($objRes->fields) {
            $arrTemporal = &$arrDatos;
            foreach ($objRes->fields as $txtKey => $txtDato) {
                $arrTemporal[$txtKey] = $txtDato;
            }
            $objRes->MoveNext();
        }
        return $arrDatos;
    }

    public function tipoActo($numActo, $fchActo) {

        global $aptBd;

        $sql = "
					SELECT
						tac.txtNombreTipoActo
					FROM T_AAD_TIPO_ACTO tac 
					INNER JOIN T_AAD_ACTO_ADMINISTRATIVO adm on adm.seqTipoActo = tac.seqTipoActo
					WHERE adm.numActo = $numActo
					AND adm.fchActo = '$fchActo'
					LIMIT 1
					";
        $objRes = $aptBd->execute($sql);
        $txtNombreTipoActo = ( $objRes->fields["txtNombreTipoActo"] ) ? $objRes->fields["txtNombreTipoActo"] : "";
        return $txtNombreTipoActo;
    }

    public function obtenerResolucionModifica($numActo, $fchActo, $seqTipoActo) {

        global $aptBd;
        $arrDatos = array();

        $sql = "SELECT
						car.txtNombreCaracteristica,
						adm.txtValorCaracteristica
					FROM
						T_AAD_ACTO_ADMINISTRATIVO adm
						INNER JOIN T_AAD_CARACTERISTICA_ACTO car ON adm.seqCaracteristica = car.seqCaracteristica
					WHERE 
						adm.numActo = $numActo
						AND adm.fchActo = '" . $fchActo . "'
						AND adm.seqTipoActo = $seqTipoActo";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrDatos[$objRes->fields["txtNombreCaracteristica"]] = $objRes->fields["txtValorCaracteristica"];
            $objRes->MoveNext();
        }
        return $arrDatos;
    }

    public function actoExisteCiudadano($numDocumento) {
        global $aptBd;

		$numDocumentoFormat = str_replace(".","",$numDocumento);
		
        $numDocumento = ereg_replace(",", "", $numDocumento);
        $arrFormularioActo = array();
        $sql = "SELECT
				DISTINCT hog.seqFormularioActo
				FROM T_AAD_CIUDADANO_ACTO ciu
				INNER JOIN T_AAD_HOGAR_ACTO hog ON hog.seqCiudadanoActo = ciu.seqCiudadanoActo
				WHERE ciu.numDocumento = " . $numDocumentoFormat;
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrFormularioActo[] = $objRes->fields['seqFormularioActo'];
            $objRes->MoveNext();
        }
        return $arrFormularioActo;
    }

    public function actoExiste() {
        global $aptBd;
        $bolExiste = false;
        $sql = "
				SELECT count( 1 ) as cuenta
				FROM T_AAD_ACTO_ADMINISTRATIVO
				WHERE numActo = " . $this->numActo . "
				AND fchActo = '" . $this->fchActo . "'
			";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields) {
            if ($objRes->fields['cuenta'] == 0) {
                $bolExiste = false;
            } else {
                $bolExiste = true;
            }
        }
        return $bolExiste;
    }

    public function salvarActo() {
        global $aptBd;

        $claTipoActo = new TipoActoAdministrativo;
        $claTipoActo->cargarTipoActo($this->seqTipoActo);

        // Actos Administrativos de Renuncia.
        // Verificar que el Acto y la Fecha a la 
        // que hacen referencia sea una de Asignacion
        if ($this->seqTipoActo == 6) {

            /**
             *  seqCaracteristica 18 : Resolución Asignacion
             *  seqCaracteristica 19 : Fecha Resolución Asignacion
             */
            $numResolucionAsignacion = $_POST["caracteristica"][18];
            $fchResolucionAsignacion = $_POST["caracteristica"][19];
            $arrActoAdministrativo = ActoAdministrativo::obtenerResolucionModifica($numResolucionAsignacion, $fchResolucionAsignacion, 1);

            if (empty($arrActoAdministrativo)) {
                $this->arrErrores[] = "El Acto Administrativo $numResolucionAsignacion del $fchResolucionAsignacion no corresponde a una Resolución de Asignación.";
            }
        }

        if (empty($this->arrErrores)) {
            foreach ($this->arrCaracteristicas as $seqCaracteristica => $txtValor) {
                $sql = " 
		    			INSERT INTO T_AAD_ACTO_ADMINISTRATIVO (
		    				numActo, 
		    				fchActo, 
		    				seqTipoActo,
		    				seqCaracteristica, 
		    				txtValorCaracteristica
		    			) VALUES ( 
		    				" . $this->numActo . ", 
		    				\"" . $this->fchActo . "\",
							" . $this->seqTipoActo . ", 
							" . $seqCaracteristica . ",
							\"" . $txtValor . "\"
						)
		    		";
                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $this->arrErrores[] = "Error al salvar el valor del campo " . $claTipoActo->arrCaracteristicas[$seqCaracteristica]['nombre'];
                }
            }
        }
    }

    public function editarActo() {
        global $aptBd;
        $claTipoActo = new TipoActoAdministrativo;
        $claTipoActo->cargarTipoActo($this->seqTipoActo);

        $sql = "
				DELETE 
				FROM T_AAD_ACTO_ADMINISTRATIVO
				WHERE numActo = " . $this->numActo . "
	    		  AND fchActo = '" . $this->fchActo . "'
	    	";

        try {
            $aptBd->execute($sql);
            $this->salvarActo();
        } catch (Exception $objError) {
            $this->arrErrores[] = "Error al modificar las caracteristicas del acto administrativo";
        }
    }

    public function validarArchivoNotificacion($numActo, $fchActo, $arrArchivo) {

        global $aptBd;
        $arrErrores = array();

        foreach ($arrArchivo as $arrDatos) {

            $numDocumento = $arrDatos[0];
            $sql = "
						SELECT
							count( 1 ) as cuenta
						FROM T_AAD_FORMULARIO_ACTO fac
						INNER JOIN T_AAD_HOGAR_ACTO hac on hac.seqFormularioActo = fac.seqFormularioActo
						INNER JOIN T_AAD_CIUDADANO_ACTO cac on hac.seqCiudadanoActo = cac.seqCiudadanoActo
						INNER JOIN T_AAD_HOGARES_VINCULADOS hvi on hvi.seqFormularioActo = fac.seqFormularioActo
						WHERE hvi.fchActo = '$fchActo'
						AND hvi.numActo = $numActo
						AND cac.numDocumento = $numDocumento
						";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields["cuenta"] == 0) {
                $arrErrores[] = "El ciudadano con número de documento $numDocumento no pertenece a la " . $this->tipoActo($numActo, $fchActo) . " $numActo del " . formatoFechaTextoFecha($fchActo);
            }
        }

        return $arrErrores;
    }

    public function salvarNotificacion($seqTipoActo, $arrArchivo, $arrTipoActos) {

        global $aptBd;

        $arrUpdates = array();

        $fchVigenciaSubsidio = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y") + 1));
        switch ($seqTipoActo) {

            case 1: // Resolución de Asignación
                foreach ($arrArchivo as $arrLinea) {

                    $claFormulario = new FormularioSubsidios;
                    $claFormulario->cargarFormulario($arrLinea["seqFormulario"]);
                    $arrCiudadano = $claFormulario->arrCiudadano;
                    $txtCiudadanoAtendido = "";
                    $numDocumentoAtendido = 0;
                    foreach ($arrCiudadano as $claciudadano) {
                        $txtCiudadanoAtendido = $claciudadano->txtNombre1 . " "
                                . $claciudadano->txtNombre2 . " "
                                . $claciudadano->txtApellido1 . " "
                                . $claciudadano->txtApellido2 . " ";
                        //$numDocumentoAtendido = $claciudadano->numDocumento;
						$numDocumentoAtendido = str_replace(".","",$claCiudadano->numDocumento);
                        break;
                    }


                    $txtCambios = "Cambios en el formulario " . $arrLinea["seqFormulario"] . "\r\n";
                    $txtCambios .= "fchVigencia, Valor Anterior: " . $claFormulario->fchVigenciaSubsido . ", Valor Nuevo: $fchVigenciaSubsidio\n";
                    $txtCambios .= "bolSancion, Valor Anterior: " . $claFormulario->bolSancion . " , Valor Nuevo: 0\n";

                    $arrUpdates[] = "(
												" . $arrLinea["seqFormulario"] . ",
												now( ),
												" . $_SESSION['seqUsuario'] . ",
												\"Notificacion Hogar para " . $arrTipoActos[$seqTipoActo] . " " . $this->numActoReferencia . " del " . $this->fchActoReferencia . "\",
												\"" . ereg_replace("\"", "", $txtCambios) . "\",
												" . $numDocumentoAtendido . ",
												\"" . $txtCiudadanoAtendido . "\",
												48
											)					
										";

                    $sql = "
								UPDATE T_FRM_FORMULARIO 
								SET fchVigencia = '$fchVigenciaSubsidio' ,
								bolSancion = 0 
								WHERE seqFormulario = " . $arrLinea["seqFormulario"];
                    $aptBd->execute($sql);
                }
                break;

            case 3: // Resolución de Inhabilitados
            case 6: // Resolución de Renuncia
                foreach ($arrArchivo as $arrLinea) {

                    $claFormulario = new FormularioSubsidios;
                    $claFormulario->cargarFormulario($arrLinea["seqFormulario"]);
                    $arrCiudadano = $claFormulario->arrCiudadano;
                    $txtCiudadanoAtendido = "";
                    $numDocumentoAtendido = 0;
                    foreach ($arrCiudadano as $claciudadano) {
                        $txtCiudadanoAtendido = $claciudadano->txtNombre1 . " "
                                . $claciudadano->txtNombre2 . " "
                                . $claciudadano->txtApellido1 . " "
                                . $claciudadano->txtApellido2 . " ";
                        //$numDocumentoAtendido = $claciudadano->numDocumento;
						$numDocumentoAtendido = str_replace(".","",$claCiudadano->numDocumento);
                        break;
                    }
                    $txtCambios = "Cambios en el formulario " . $arrLinea["seqFormulario"] . "\r\n";
                    $txtCambios .= "fchVigencia, Valor Anterior: " . $claFormulario->fchVigenciaSubsido . ", Valor Nuevo: $fchVigenciaSubsidio\n";
                    $txtCambios .= "bolSancion, Valor Anterior: " . $claFormulario->bolSancion . " , Valor Nuevo: 1\n";

                    $txtSqlRenuncia = "";
                    if ($seqTipoActo == 6) {
                        $txtCambios .= "seqEstadoProceso, Valor Anterior: " . $claFormulario->seqEstadoProceso . ", Valor Nuevo: 18\n";
                        $txtSqlRenuncia = " , seqEstadoProceso = 18 ";
                    }

                    $arrUpdates[] = "(
												" . $arrLinea["seqFormulario"] . ",
												now( ),
												" . $_SESSION['seqUsuario'] . ",
												\"Notificacion Hogar para " . $arrTipoActos[$seqTipoActo] . " " . $this->numActoReferencia . " del " . $this->fchActoReferencia . "\",
												\"" . ereg_replace("\"", "", $txtCambios) . "\",
												" . $numDocumentoAtendido . ",
												\"" . $txtCiudadanoAtendido . "\",
												48
											)					
										";


                    $sql = "
							UPDATE T_FRM_FORMULARIO 
							SET fchVigencia = '$fchVigenciaSubsidio' , 
							bolSancion = 1 $txtSqlRenuncia
							WHERE seqFormulario = " . $arrLinea["seqFormulario"];
                    $aptBd->execute($sql);
                }
                break;

            case 5: // Resolucion de No Asignado
            case 2: // Resolución Modificatoria
                break;

            default:
                $this->arrErrores[] = "No se puede hacer notificacion a una " . $arrTipoActos[$seqTipoActo];
                break;
        }

        if (!empty($arrUpdates)) {

            $txtUpdates = implode(" , ", $arrUpdates);

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
						) VALUES $txtUpdates 
					";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se pudo salvar el seguimiento.";
            }
        }
    }

    public function vincularHogarActo($arrArchivo) {

        // Reinicia lo que este vinculado a este hogar
        $this->prepararHogares();

        if (empty($this->arrErrores)) {
            switch ($this->seqTipoActo) {
                case 1: // vincular los hogares a la resolucion de asignacion
                    $this->vincularHogarResolucionAsignacion($arrArchivo);
                    break;
                case 2: // vincular los hogares a la resolucion modificatoria
                    $this->vincularHogarResolucionModificatoria($arrArchivo);
                    break;
                case 3: // vincular los hogares a la resulcion de inhabilitados
                    $this->vincularHogarResolucionInhabilitados($arrArchivo);
                    break;
                case 4: // vincula los hogares a recursos de repocision
                    $this->vincularHogarRecursosReposicion($arrArchivo);
                    break;
                case 5: // vincula los hogares a la resolucion de no asignado		    		
                    $this->vincularHogarResolucionNoAsignacion($arrArchivo);
                    break;
                case 6: // vincula los hogares a la resolucion de renuncia		    		
                    $this->vincularHogarResolucionRenuncia($arrArchivo);
                    break;
                case 7:// vincula los hogares las notificaciones
                    $this->vincularHogarResolucionNotificacion($arrArchivo);
                    break;
                case 8: // vincular los hogares a la resolucion de indexacion
                    $this->vincularHogarResolucionIndexacion($arrArchivo);
                    break;
                default:
                    $this->arrErrores[] = "No es posible vincular los hogare, este tipo de acto no esta soportado";
                    break;
            }
        }
    }

    private function vincularHogarRecursosReposicion($arrArchivo) {
        global $aptBd;

        $numResolucionModifica = $this->arrCaracteristicas[5];
        $fchResolucionModifica = $this->arrCaracteristicas[6];

        $sql = "
	    		SELECT count( 1 ) as cuenta
				FROM T_AAD_ACTO_ADMINISTRATIVO adm
				WHERE adm.numActo = $numResolucionModifica
				  AND adm.fchActo = '$fchResolucionModifica'
				  AND adm.seqTipoActo = 3
				";
        $objRes = $aptBd->execute($sql);
        if ($objRes->fields["cuenta"]) {

            $arrDocumentos = array();
            $arrRevoca = array();
            foreach ($arrArchivo as $numLinea => $arrLinea) {
                $arrDocumentos[] = $arrLinea[0];
                $arrCombinado[$arrLinea[0]] = $arrLinea[1];
            }

            $sql = "
		    		SELECT
					  cac.numDocumento
					FROM
						T_AAD_HOGARES_VINCULADOS hvi
					INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hvi.seqFormularioActo = fac.seqFormularioActo
					INNER JOIN T_AAD_HOGAR_ACTO hac ON hac.seqFormularioActo = fac.seqFormularioActo
					INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
					WHERE hvi.numActo = $numResolucionModifica
					  AND hvi.fchActo = '$fchResolucionModifica'
					  AND cac.numDocumento in (" . implode(",", $arrDocumentos) . ")
					";
            $objRes = $aptBd->execute($sql);
            $arrDocumentosResolucion = array();
            while ($objRes->fields) {
                $arrDocumentosResolucion[] = $objRes->fields['numDocumento'];
                $objRes->MoveNext();
            }

            $arrDocumentosDiferecncia = array_diff($arrDocumentos, $arrDocumentosResolucion);
            if (!empty($arrDocumentosDiferecncia)) {
                foreach ($arrDocumentosDiferecncia as $txtDocumento) {
                    $this->arrErrores[] = "El documento $txtDocumento no existe la Resolucion de Inhabilitados numero $numResolucionModifica de $fchResolucionModifica .";
                }
            }

            if (empty($this->arrErrores)) {

                $sql = "
						SELECT 
						  hog.seqFormulario,
						  hog.seqCiudadano,
						  ciu.numDocumento,
						  hog.seqParentesco
						FROM
						  T_FRM_HOGAR hog,
						INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
						WHERE ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
			    	";
                $objRes = $aptBd->execute($sql);
                $arrHogares = array();
                while ($objRes->fields) {

                    $seqFormulario = $objRes->fields['seqFormulario'];
                    $seqCiudadano = $objRes->fields['seqCiudadano'];
                    $numDocumento = $objRes->fields['numDocumento'];

                    if (strtolower(trim($arrCombinado[$numDocumento])) == "revoca") {
                        $arrRevoca[$seqFormulario] = $numDocumento;
                    }
                    $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] = $objRes->fields['seqParentesco'];
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] = $arrCombinado[$numDocumento];
                    $objRes->MoveNext();
                }

                $this->salvarRegistro($arrHogares, 0, $arrRevoca);
            }
        } else {
            $this->arrErrores[] = "No existe la Resolucion de Inhabilidatos numero $numResolucionModifica de $fchResolucionModifica .";
        }
    }

    private function vincularHogarResolucionModificatoria($arrArchivo) {
        global $aptBd;

        // Organiza el archivo por modificaciones de numero de documento
        $arrDocumentos = array();
        $arrCombinado = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[0];
            $arrTemporal = array();
            $arrTemporal[] = trim($arrLinea[1]);
            $arrTemporal[] = trim($arrLinea[2]);
            $arrTemporal[] = trim($arrLinea[3]);
            $arrCombinado[$arrLinea[0]][] = $arrTemporal;
        }

        // obtiene los datos del ciudadano que se esta modificando
        $sql = "
				SELECT 
				  hog.seqFormulario,
				  hog.seqCiudadano,
				  ciu.numDocumento,
				  hog.seqParentesco
				FROM
				  T_FRM_HOGAR hog
				INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
				WHERE ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
	    	";
        $objRes = $aptBd->execute($sql);

        $arrHogares = array();
        while ($objRes->fields) {

            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $numDocumento = $objRes->fields['numDocumento'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;

            // para varias modificaciones del mismo documento		
            foreach ($arrCombinado[$numDocumento] as $numPosicion => $arrModificacion) {
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['parentesco'] = $objRes->fields['seqParentesco'];
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['causa'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['fuente'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['inhabilidad'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['campo'] = $arrModificacion[0];
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['incorrecto'] = $arrModificacion[1];
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['correcto'] = $arrModificacion[2];
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numPosicion]['estado'] = "";
            }

            $objRes->MoveNext();
        }

        $this->salvarRegistro($arrHogares);
    }

    private function vincularHogarResolucionRenuncia($arrArchivo) {
        global $aptBd;

        $arrDocumentos = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[0];
        }

        $sql = "
				SELECT 
					hog.seqFormulario, 
					hog1.seqCiudadano, 
					hog1.seqParentesco
				FROM T_FRM_HOGAR hog
				INNER JOIN T_FRM_HOGAR hog1 ON hog.seqFormulario = hog1.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
				WHERE ciu.seqTipoDocumento IN ( 1 , 2 , 3 , 4 , 5 , 6 )
				AND ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
	    	";
        $objRes = $aptBd->execute($sql);
        $arrHogares = array();
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] = $objRes->fields['seqParentesco'];
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] = "";
            $objRes->MoveNext();
        }

        $this->salvarRegistro($arrHogares, 18);
    }

    private function vincularHogarResolucionNotificacion($arrArchivo) {
        global $aptBd;

        $arrDocumentos = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[0];
        }

        $sql = "
				SELECT 
					hog.seqFormulario, 
					hog1.seqCiudadano, 
					hog1.seqParentesco
				FROM T_FRM_HOGAR hog
				INNER JOIN T_FRM_HOGAR hog1 ON hog.seqFormulario = hog1.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
				WHERE ciu.seqTipoDocumento IN ( 1 , 2 , 3 , 4 , 5 , 6 )
				AND ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
	    	";
        $objRes = $aptBd->execute($sql);
        $arrHogares = array();
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] = $objRes->fields['seqParentesco'];
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] = "";
            $objRes->MoveNext();
        }

        $this->salvarRegistro($arrHogares);
    }

    private function vincularHogarResolucionAsignacion($arrArchivo) {
        global $aptBd;

        $arrDocumentos = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[0];
        }

        $sql = "
				SELECT 
					hog.seqFormulario, 
					hog1.seqCiudadano, 
					hog1.seqParentesco
				FROM T_FRM_HOGAR hog
				INNER JOIN T_FRM_HOGAR hog1 ON hog.seqFormulario = hog1.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
				WHERE ciu.seqTipoDocumento IN ( 1 , 2 , 3 , 4 , 5 , 6 )
				AND ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
	    	";
        $objRes = $aptBd->execute($sql);
        $arrHogares = array();
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] = $objRes->fields['seqParentesco'];
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] = "";
            $objRes->MoveNext();
        }

        $this->salvarRegistro($arrHogares, 15);
    }
    
    private function vincularHogarResolucionIndexacion( $arrArchivo ){
        global $aptBd;

        $arrDocumentos = array();
        $arrReferencia = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[0];
            if( $this->seqTipoActo == 8 ){
               $arrReferencia[ $arrLinea[0] ]['numActoReferencia'] = $arrLinea[1];
               $arrReferencia[ $arrLinea[0] ]['fchActoReferencia'] = $arrLinea[2];
               $arrReferencia[ $arrLinea[0] ]['valor']             = $arrLinea[3];
            }
        }

        $sql = "
				SELECT 
					hog.seqFormulario, 
					hog1.seqCiudadano, 
					hog1.seqParentesco,
               ciu.numDocumento
				FROM T_FRM_HOGAR hog
				INNER JOIN T_FRM_HOGAR hog1 ON hog.seqFormulario = hog1.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
				WHERE ciu.seqTipoDocumento IN ( 1 , 2 , 3 , 4 , 5 , 6 )
				AND ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " )
	    	";
        $objRes = $aptBd->execute($sql);
        $arrHogares = array();
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] = $objRes->fields['seqParentesco'];
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] = "";
            
            if( $this->seqTipoActo == 8 ){
               if( isset( $objRes->fields['numDocumento'] ) ){
                  $arrHogares[$seqFormulario]['referencia'] = $arrReferencia[ $objRes->fields['numDocumento'] ];
               }
            }
            
            $objRes->MoveNext();
        }

        $this->salvarRegistro($arrHogares); // deben pasar a solicitud de desembolso ???????
       
    }
    
    private function vincularHogarResolucionNoAsignacion($arrArchivo) {
        global $aptBd;

        $arrDocumentos = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[0];
        }

        $sql = "
				SELECT 
					hog.seqFormulario, 
					hog1.seqCiudadano, 
					hog1.seqParentesco
				FROM T_FRM_HOGAR hog
				INNER JOIN T_FRM_HOGAR hog1 ON hog.seqFormulario = hog1.seqFormulario
				INNER JOIN T_CIU_CIUDADANO ciu ON ciu.seqCiudadano = hog.seqCiudadano
				WHERE ciu.seqTipoDocumento IN ( 1 , 2 , 3 , 4 , 5 , 6 )
				AND ciu.numDocumento IN ( " . implode(" , ", $arrDocumentos) . " )
	    	";


        $objRes = $aptBd->execute($sql);
        $arrHogares = array();
        $arrActosAdministrativosHogar = array();
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $arrSeqFormulario[] = $seqFormulario;
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] = $objRes->fields['seqParentesco'];
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] = "";
            $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] = "";
            $objRes->MoveNext();
        }


        $this->salvarRegistro($arrHogares, 9);
    }

    private function vincularHogarNotificacion($arrArchivo) {
        global $aptBd;

        $arrHogares = array();
        foreach ($arrArchivo as $numLinea => $arrInformacion) {

            $seqFormulario = $arrInformacion[1];

            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);

            $arrHogares[$seqFormulario]['modalidad'] = $claFormulario->seqModalidad;
            $arrHogares[$seqFormulario]['solucion'] = $claFormulario->seqSolucion;
            $arrHogares[$seqFormulario]['postulacion'] = $claFormulario->fchPostulacion;
            $arrHogares[$seqFormulario]['inscripcion'] = $claFormulario->fchInscripcion;
            $arrHogares[$seqFormulario]['actualizacion'] = $claFormulario->fchUltimaActualizacion;
            $arrHogares[$seqFormulario]['desplazado'] = $claFormulario->bolDesplazado;

            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['tipoDocumento'] = $objCiudadano->seqTipoDocumento;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['documento'] = $objCiudadano->numDocumento;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['nombre1'] = $objCiudadano->txtNombre1;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['nombre2'] = $objCiudadano->txtNombre2;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['apellido1'] = $objCiudadano->txtApellido1;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['apellido2'] = $objCiudadano->txtApellido2;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['parentesco'] = $objCiudadano->seqParentesco;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['causa'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['fuente'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['inhabilidad'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['campo'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['incorrecto'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['correcto'] = "";
            }

            unset($claFormulario);
        }

        $this->salvarRegistro($arrHogares);
    }

    private function vincularHogarEdicto($arrArchivo) {
        global $aptBd;

        $arrHogares = array();
        foreach ($arrArchivo as $numLinea => $arrInformacion) {

            $seqFormulario = $arrInformacion[1];

            $claFormulario = new FormularioSubsidios();
            $claFormulario->cargarFormulario($seqFormulario);

            $arrHogares[$seqFormulario]['modalidad'] = $claFormulario->seqModalidad;
            $arrHogares[$seqFormulario]['solucion'] = $claFormulario->seqSolucion;
            $arrHogares[$seqFormulario]['postulacion'] = $claFormulario->fchPostulacion;
            $arrHogares[$seqFormulario]['inscripcion'] = $claFormulario->fchInscripcion;
            $arrHogares[$seqFormulario]['actualizacion'] = $claFormulario->fchUltimaActualizacion;
            $arrHogares[$seqFormulario]['desplazado'] = $claFormulario->bolDesplazado;

            foreach ($claFormulario->arrCiudadano as $seqCiudadano => $objCiudadano) {
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['tipoDocumento'] = $objCiudadano->seqTipoDocumento;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['documento'] = $objCiudadano->numDocumento;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['nombre1'] = $objCiudadano->txtNombre1;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['nombre2'] = $objCiudadano->txtNombre2;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['apellido1'] = $objCiudadano->txtApellido1;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['apellido2'] = $objCiudadano->txtApellido2;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['parentesco'] = $objCiudadano->seqParentesco;
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['causa'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['fuente'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['inhabilidad'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['campo'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['incorrecto'] = "";
                $arrHogares[$seqFormulario]['miembro'][$seqCiudadano]['correcto'] = "";
            }

            unset($claFormulario);
        }

        $this->salvarRegistro($arrHogares);
    }

    private function prepararHogares() {
        global $aptBd;

        // obtiene el identificador del acto administrativo que tiene este acto
        $sql = "
	    		SELECT seqFormularioActo
				FROM T_AAD_HOGARES_VINCULADOS
				WHERE numActo = " . $this->numActo . "
				  AND fchActo = '" . $this->fchActo . "'
	    	";
        try {

            $arrFormularioActo = array();
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $arrFormularioActo[] = $objRes->fields['seqFormularioActo'];
                $objRes->MoveNext();
            }

            if (!empty($arrFormularioActo)) {

                // obtiene los ciudadanos vinculados con el acto
                $sql = "
		    			SELECT seqCiudadanoActo
		    			FROM T_AAD_HOGAR_ACTO
		    			WHERE seqFormularioActo IN (
		    				" . implode(",", $arrFormularioActo) . "
		    			)
		    		";

                try {

                    $arrCiudadanoActo = array();
                    $objRes = $aptBd->execute($sql);
                    while ($objRes->fields) {
                        $arrCiudadanoActo[] = $objRes->fields['seqCiudadanoActo'];
                        $objRes->MoveNext();
                    }

                    // CONSERVAR EL ORDEN DE ESTOS 
                    if (!empty($arrFormularioActo)) {
                        $arrConsulta[] = "DELETE FROM T_AAD_HOGAR_ACTO WHERE seqFormularioActo IN ( " . implode(",", $arrFormularioActo) . " )";
                    }

                    if (!empty($arrCiudadanoActo)) {
                        $arrConsulta[] = "DELETE FROM T_AAD_CIUDADANO_ACTO WHERE seqCiudadanoActo IN ( " . implode(",", $arrCiudadanoActo) . " )";
                    }

                    if (!empty($arrFormularioActo)) {
                        $arrConsulta[] = "DELETE FROM T_AAD_HOGARES_VINCULADOS WHERE seqFormularioActo IN ( " . implode(",", $arrFormularioActo) . " )";
                        $arrConsulta[] = "DELETE FROM T_AAD_FORMULARIO_ACTO WHERE seqFormularioActo IN ( " . implode(",", $arrFormularioActo) . " )";
                    }

//	    				pr( $arrConsulta );

                    foreach ($arrConsulta as $sql) {
                        try {
                            $aptBd->execute($sql);
                        } catch (Exception $objError) {
                            $this->arrErrores[] = "Error al intentar preparar las tablas de los actos administrativos";
                            pr($objError->getMessage());
                        }
                    }
                } catch (Exception $objError) {
                    $this->arrErrores[] = "Error al intentar recuperar los ciudadanos vinculados al formulario";
                }
            }
        } catch (Exception $objError) {
            $this->arrErrores[] = "Error al intentar encontrar el acto administrativo " . $this->numActo . " del " . $this->fchActo;
        }
    }

    private function vincularHogarResolucionInhabilitados($arrArchivo) {

        global $aptBd;

        $arrDocumentos = array();
        $arrCombinado = array();
        $arrTemporal = array();
        foreach ($arrArchivo as $numLinea => $arrLinea) {
            $arrDocumentos[] = $arrLinea[4];
            $arrTemporal = array();
            $arrTemporal[] = $arrLinea[8];
            $arrTemporal[] = $arrLinea[9];
            $arrTemporal[] = $arrLinea[10];
            $arrCombinado[$arrLinea[4]][$arrLinea[5]][] = $arrTemporal;
        }

        $arrDocumentos = array_unique($arrDocumentos);

        $sql = "
				SELECT 
					hog.seqFormulario,
					ciu.numDocumento AS DocumentoPPAL,
					hog1.seqCiudadano,
					ciu1.numDocumento AS Documento,
					hog1.seqParentesco
				FROM T_FRM_HOGAR hog
					INNER JOIN T_FRM_HOGAR hog1 ON hog.seqFormulario = hog1.seqFormulario
					INNER JOIN T_CIU_CIUDADANO ciu ON hog.seqCiudadano = ciu.seqCiudadano
					INNER JOIN T_CIU_CIUDADANO ciu1 ON hog1.seqCiudadano = ciu1.seqCiudadano
				WHERE 
					ciu.numDocumento IN ( " . implode(",", $arrDocumentos) . " ) 
					AND ciu.seqTipoDocumento IN ( 1 , 2 )
	    	";
        $objRes = $aptBd->execute($sql);
        $arrHogares = array();
        while ($objRes->fields) {
            $seqFormulario = $objRes->fields['seqFormulario'];
            $seqCiudadano = $objRes->fields['seqCiudadano'];
            $numDocumentoPPAL = $objRes->fields['DocumentoPPAL'];
            $numDocumento = $objRes->fields['Documento'];
            $arrHogares[$seqFormulario]['hogar'][] = $seqCiudadano;
            if (isset($arrCombinado[$numDocumentoPPAL][$numDocumento])) {
                foreach ($arrCombinado[$numDocumentoPPAL][$numDocumento] as $numDato => $arrInhabilidad) {
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['parentesco'] = $objRes->fields['seqParentesco'];
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['campo'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['incorrecto'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['correcto'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['estado'] = "";
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['causa'] = $arrInhabilidad[0];
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['fuente'] = $arrInhabilidad[1];
                    $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['inhabilidad'] = $arrInhabilidad[2];
                }
            } else {
                $numDato = count($arrHogares[$seqFormulario]['datos'][$seqCiudadano]);
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['parentesco'] = $objRes->fields['seqParentesco'];
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['campo'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['incorrecto'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['correcto'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['estado'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['causa'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['fuente'] = "";
                $arrHogares[$seqFormulario]['datos'][$seqCiudadano][$numDato]['inhabilidad'] = "";
            }

            $objRes->MoveNext();
        }

        $this->salvarRegistro($arrHogares, 8);
    }

    private function salvarRegistro($arrHogares, $seqEstadoProceso = 0, $arrRevoca = array()) {

        global $aptBd;

        $fchIngresoRegistro = date("Y-m-d H:i:s");

        $arrFormularios = array_keys($arrHogares);
        $arrCiudadanos = array();

        foreach ($arrHogares as $seqFormulario => $arrDatos) {
            foreach ($arrDatos['hogar'] as $seqCiudadano) {
                $arrCiudadanos[] = $seqCiudadano;
            }
        }

        // Recojo los formularios antes del cambio de estado
        $arrClasesFormulario = array();
        foreach ($arrFormularios as $seqFormulario) {
            $claFormulario = new FormularioSubsidios;
            $claFormulario->cargarFormulario($seqFormulario);
            $arrClasesFormulario[$seqFormulario] = $claFormulario;
        }

        $txtTipoActoAdministrativo = obtenerCampo("T_AAD_TIPO_ACTO", $this->seqTipoActo, "txtNombreTipoActo", "seqTipoActo");

        // Cambia los estados de los formularios cuando sea necesario
        if ( $seqEstadoProceso != 0 or $this->seqTipoActo == 8 ) {
           
            foreach( $arrFormularios as $seqFormulario ){
               
               $txtCampoActualizar = "";
               if( $this->seqTipoActo == 8 ){
                  $txtCampoActualizar = ", valAspiraSubsidio = valAspiraSubsidio + " . $arrHogares[$seqFormulario]['referencia']['valor'];
               }
               
               $txtEstadoActualizar = "";
               if( $seqEstadoProceso != 0 ){
                  $txtEstadoActualizar = "seqEstadoProceso = $seqEstadoProceso";
               }else{
                  $txtEstadoActualizar = "seqEstadoProceso = seqEstadoProceso";
                  $seqEstadoProceso = $arrClasesFormulario[$seqFormulario]->seqEstadoProceso;
               }
               
               $sql = "
                  UPDATE T_FRM_FORMULARIO SET
                     $txtEstadoActualizar
                     $txtCampoActualizar
                  WHERE seqFormulario = $seqFormulario
               ";
               $aptBd->execute($sql);
               
            }
            
            try {
                

                foreach ($arrFormularios as $seqFormulario) {

                    $arrCiudadano = $arrClasesFormulario[$seqFormulario]->arrCiudadano;
                    $txtCiudadanoAtendido = "";
                    $numDocumentoAtendido = 0;
                    foreach ($arrCiudadano as $claciudadano) {
                        $txtCiudadanoAtendido = $claciudadano->txtNombre1 . " "
                                . $claciudadano->txtNombre2 . " "
                                . $claciudadano->txtApellido1 . " "
                                . $claciudadano->txtApellido2 . " ";
								//$numDocumentoAtendido = $claciudadano->numDocumento;
								$numDocumentoAtendido = str_replace(".","",$claciudadano->numDocumento);
                        break;
                    }

                    $txtCiudadanoAtendido = ereg_replace("  +", " ", trim($txtCiudadanoAtendido));

                    $txtCambios = "Cambios en el formulario $seqFormulario\r\n";
                    $txtCambios.= "seqEstadoProceso, Valor Anterior: " . $arrClasesFormulario[$seqFormulario]->seqEstadoProceso . ", Valor Nuevo: " . $seqEstadoProceso . "\n";

                    if( $this->seqTipoActo == 8 ){
                     $txtCambios.= "valAspiraSubsidio, Valor Anterior: " . $arrClasesFormulario[$seqFormulario]->valAspiraSubsidio . ", Valor Nuevo: " . ( $arrClasesFormulario[$seqFormulario]->valAspiraSubsidio + $arrHogares[$seqFormulario]['referencia']['valor'] ) . "\n";
                    }
                    
                    if( $this->seqTipoActo != 8 ){
                       $txtSeguimiento = "\"Actos Administrativos. Cambio de Estado\n$txtTipoActoAdministrativo numero " . $this->numActo . " del " . $this->fchActo . "\"";
                    } else {
                       $txtSeguimiento = "\"Actos Administrativos. Indexación del subsidio\n$txtTipoActoAdministrativo numero " . $this->numActo . " del " . $this->fchActo . "\"";
                    }

                    $arrUpdates[] = "(
								$seqFormulario,
								now(),
								" . $_SESSION['seqUsuario'] . ",
								$txtSeguimiento,
								\"" . ereg_replace("\"", "", $txtCambios) . "\",
								" . $numDocumentoAtendido . ",
								\"" . $txtCiudadanoAtendido . "\",
								46
							)";
                }
            } catch (Exception $objError) {
                $arrErrores[] = "No se pudo hacer el cambio de estados para este Acto Administrativo.";
            }
        }

        // para los actos administrativos de recursos de reposicion
        if (!empty($arrRevoca)) {
            $sql = "
	    			UPDATE T_FRM_FORMULARIO SET
	    				seqEstadoProceso = 7 
	    			WHERE seqFormulario IN ( " . implode(",", array_keys($arrRevoca)) . " )
	    		";

            try {
                $aptBd->execute($sql);

                // Una vez se hace el cambio de estado recojo los nuevos formularios
                foreach ($arrFormularios as $seqFormulario) {

                    $arrCiudadano = $arrClasesFormulario[$seqFormulario]->arrCiudadano;
                    $txtCiudadanoAtendido = "";
                    $numDocumentoAtendido = 0;
                    foreach ($arrCiudadano as $claciudadano) {
                        $txtCiudadanoAtendido = $claciudadano->txtNombre1 . " "
                                . $claciudadano->txtNombre2 . " "
                                . $claciudadano->txtApellido1 . " "
                                . $claciudadano->txtApellido2 . " ";
                        //$numDocumentoAtendido = $claciudadano->numDocumento;
						$numDocumentoAtendido = str_replace(".","",$claCiudadano->numDocumento);
                        break;
                    }

                    $txtCiudadanoAtendido = ereg_replace("  +", " ", trim($txtCiudadanoAtendido));
                    $txtCambios = "Cambios en el formulario $seqFormulario\r\n";
                    $txtCambios.= "seqEstadoProceso, Valor Anterior: " . $arrClasesFormulario[$seqFormulario]->seqEstadoProceso . ", Valor Nuevo: 7\n";

                    $arrUpdates[] = "(
								$seqFormulario,
								now(),
								" . $_SESSION['seqUsuario'] . ",
								\"Actos Administrativos. Cambio de Estado\",
								\"" . ereg_replace("\"", "", $txtCambios) . "\",
								" . $numDocumentoAtendido . ",
								\"" . $txtCiudadanoAtendido . "\",
								46
							)";
                }
            } catch (Exception $objError) {
                // Se genera el seguimiento del cambio de estado
                $arrErrores[] = "No se pudo hacer el cambio de estados para este Acto Administrativo.";
            }
        }


        if (!empty($arrUpdates) and empty($arrErrores)) {
            $txtUpdates = implode(" , ", $arrUpdates);

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
						) VALUES $txtUpdates 
					";
					//echo $sql;
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $this->arrErrores[] = "No se ha podido generar Seguimiento del cambio de estado.";
            }
        }

        if (empty($arrErrores)) {

            // Inserta los datos del ciudadano
            $sql = "
					INSERT INTO T_AAD_CIUDADANO_ACTO(
						seqCiudadano,
						seqTipoDocumento,
						numDocumento,
						fchIngresoRegistro,
						txtNombre1,
						txtNombre2,
						txtApellido1,
						txtApellido2,
						seqEtnia,
						seqCondicionEspecial,
						seqCondicionEspecial2,
						seqCondicionEspecial3,
						seqSexo,
						seqEstadoCivil,
						valIngresos
					) SELECT 
						seqCiudadano,
						seqTipoDocumento,
						numDocumento,
						'$fchIngresoRegistro',
						txtNombre1,
						txtNombre2,
						txtApellido1,
						txtApellido2,
						seqEtnia,
						seqCondicionEspecial,
						seqCondicionEspecial2,
						seqCondicionEspecial3,
						seqSexo,
						seqEstadoCivil,
						valIngresos
					FROM T_CIU_CIUDADANO
					WHERE seqCiudadano IN ( " . implode(",", $arrCiudadanos) . " )	
				";

            try {
                $aptBd->execute($sql);
                
                foreach( $arrFormularios as $seqFormulario ){
                   
                   if( isset( $arrHogares[ $seqFormulario ]['referencia'] ) ){
                      $txtValor = "'" . $arrHogares[ $seqFormulario ]['referencia']['valor'] ."'";
                   } else {
                      $txtValor = "valAspiraSubsidio";
                   }
                   
                  $sql = "
                     INSERT INTO T_AAD_FORMULARIO_ACTO (
                        seqFormulario,
                        seqModalidad,
                        seqSolucion,
                        fchInscripcion,
                        fchPostulacion,
                        fchUltimaActualizacion,
                        fchIngresoRegistro,
                        bolDesplazado,
                        valAspiraSubsidio,
                        valAcumuladoSubsidio
                     ) SELECT
                        seqFormulario,
                        seqModalidad,
                        seqSolucion,
                        fchInscripcion,
                        fchPostulacion,
                        fchUltimaActualizacion,
                        '$fchIngresoRegistro',
                        bolDesplazado,
                        $txtValor,
                        '0'
                     FROM T_FRM_FORMULARIO
                     WHERE seqFormulario = $seqFormulario
                  ";
                  $aptBd->execute($sql);
                
                }

                try {
                    

                    // Equivalencias de los formularios
                    $sql = "
							SELECT 
							  seqFormularioActo,
							  seqFormulario
							FROM T_AAD_FORMULARIO_ACTO
							WHERE seqFormulario IN ( " . implode(",", $arrFormularios) . " )
							AND fchIngresoRegistro = '$fchIngresoRegistro'
						";
                    $objRes = $aptBd->execute($sql);
                    $arrEquivalenciasFormularios = array();
                    while ($objRes->fields) {
                        $arrEquivalenciasFormularios[$objRes->fields['seqFormulario']] = $objRes->fields['seqFormularioActo'];
                        $objRes->MoveNext();
                    }

                    // Equivalencias de los ciudadanos
                    $sql = "
							SELECT 
							  seqCiudadanoActo,
							  seqCiudadano
							FROM T_AAD_CIUDADANO_ACTO
							WHERE seqCiudadano IN ( " . implode(",", $arrCiudadanos) . " )
							AND fchIngresoRegistro = '$fchIngresoRegistro'
						";
                    $objRes = $aptBd->execute($sql);
                    $arrEquivalenciasCiudadanos = array();
                    while ($objRes->fields) {
                        $arrEquivalenciasCiudadanos[$objRes->fields['seqCiudadano']] = $objRes->fields['seqCiudadanoActo'];
                        $objRes->MoveNext();
                    }

                    // Vincular formulario_acto Vs ciudadano_acto
                    $sql = " 
							INSERT INTO T_AAD_HOGAR_ACTO (
								seqFormularioActo,
								seqCiudadanoActo,
								seqParentesco,
								txtInhabilidad,
								txtCausa,
								txtFuente,
								txtCampo,
								txtIncorrecto,
								txtCorrecto,
								txtEstadoReposicion
							) VALUES 
						";
                    foreach ($arrHogares as $seqFormulario => $arrDatos) {
                        $seqFormularioActo = $arrEquivalenciasFormularios[$seqFormulario];
                        foreach ($arrDatos['hogar'] as $seqCiudadano) {
                            $seqCiudadanoActo = $arrEquivalenciasCiudadanos[$seqCiudadano];
                            if (isset($arrHogares[$seqFormulario]['datos'][$seqCiudadano][0])) {
                                foreach ($arrHogares[$seqFormulario]['datos'][$seqCiudadano] as $arrDatosCiudadano) {
                                    $sql .= "( 
						    				$seqFormularioActo,
						    				$seqCiudadanoActo,
						    				" . $arrDatosCiudadano['parentesco'] . ",
											\"" . $arrDatosCiudadano['inhabilidad'] . "\",
											\"" . $arrDatosCiudadano['causa'] . "\",
											\"" . $arrDatosCiudadano['fuente'] . "\", 
											\"" . $arrDatosCiudadano['campo'] . "\",
											\"" . $arrDatosCiudadano['incorrecto'] . "\",
											\"" . $arrDatosCiudadano['correcto'] . "\",	    
											\"" . $arrDatosCiudadano['estado'] . "\"	
						    			),";
                                }
                            } else {
                                $sql .= "( 
					    				$seqFormularioActo,
					    				$seqCiudadanoActo,
					    				" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['parentesco'] . ",
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['inhabilidad'] . "\",
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['causa'] . "\",
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['fuente'] . "\",
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['campo'] . "\",
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['incorrecto'] . "\",
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['correcto'] . "\",	    
										\"" . $arrHogares[$seqFormulario]['datos'][$seqCiudadano]['estado'] . "\"	
					    			),";
                            }
                        }
                    }
                    $sql = trim($sql, ",");

                    try {
                        $aptBd->execute($sql);

                        $sql = "
								INSERT INTO T_AAD_HOGARES_VINCULADOS (
									seqFormularioActo,
									numActo,
									fchActo,
									seqTipoActo,
                           numActoReferencia,
                           fchActoReferencia
								) VALUES 
							";
                        foreach ($arrEquivalenciasFormularios as $seqFormulario => $seqFormularioActo) {
                           
                            $sql .= "(
									$seqFormularioActo,
									" . $this->numActo . ",
									'" . $this->fchActo . "',
									" . $this->seqTipoActo . ",
                           " . intval( $arrHogares[ $seqFormulario ]['referencia']['numActoReferencia'] ) . ",
                           '" . $arrHogares[ $seqFormulario ]['referencia']['fchActoReferencia'] . "'
								),";
                        }
                        $sql = trim($sql, ",");
                        try {
                            $aptBd->execute($sql);
                        } catch (Exception $objError) {
                            $this->arrErrores[] = "Error vinculando los formularios con el numero y fecha del acto administrativo de asignacion";
                        }
                    } catch (Exception $objError) {
                        $this->arrErrores[] = "Error vinculando los formularios con los ciudadanos en el acto administrativo de asignacion";
                    }
                } catch (Exception $objError) {
                    $this->arrErrores[] = "Fallo al vincular los datos del hogar al acto administrativo de asignacion";
                }
            } catch (Exception $objError) {
                $this->arrErrores[] = "Fallo al vincular a los ciudadanos del acto administrativo de asignacion";
            }
        }
    }

    public function listarActosIndicadoresSolicitud() {

        global $aptBd;
        $arrListado = array();

        $sql = "
				SELECT 
					tac.txtNombreTipoActo,
					aad.numActo ,
					aad.fchActo ,
					car.txtNombreCaracteristica ,
					aad.txtValorCaracteristica
				FROM T_AAD_ACTO_ADMINISTRATIVO aad 
					INNER JOIN T_AAD_TIPO_ACTO tac ON aad.seqTipoActo = tac.seqTipoActo
					INNER JOIN T_AAD_CARACTERISTICA_ACTO car ON aad.seqCaracteristica = car.seqCaracteristica
				WHERE 
					aad.seqTipoActo = 1 AND
					aad.seqCaracteristica in (9	, 10 , 11 , 12 , 13 , 14 , 15 , 16 , 17 )
				GROUP BY 2 , 3 , 4 , 5 
				ORDER BY 
					tac.txtNombreTipoActo , aad.fchActo , aad.numActo , car.seqCaracteristica
				";

        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {

            $txtNombreTipoActo = $objRes->fields["txtNombreTipoActo"];
            $numActo = $objRes->fields["numActo"];
            $fchActo = $objRes->fields["fchActo"];
            $txtNombreCaracteristica = $objRes->fields["txtNombreCaracteristica"];
            $txtValorCaracteristica = $objRes->fields["txtValorCaracteristica"];

            $arrTemporal = &$arrListado[$numActo . " - " . $fchActo];
            $arrTemporal[$txtNombreCaracteristica] = $txtValorCaracteristica;
            $objRes->MoveNext();
        }

        $arrListadoProyectos = array();
        foreach ($arrListado as $numFchActo => &$arrDatosActo) {
            $numProyecto = $arrDatosActo["Número de Proyecto"];
            unset($arrDatosActo["Número de Proyecto"]);
            $arrListadoProyectos[$numProyecto][$numFchActo] = $arrDatosActo;
        }

        return $arrListadoProyectos;
    }

    public function listarActos() {
        global $aptBd;
        $arrListado = array();
        $sql = "
				SELECT 
					aad.seqTipoActo,
					tac.txtNombreTipoActo,
					aad.fchActo,
					aad.numActo
				FROM T_AAD_ACTO_ADMINISTRATIVO aad 
					INNER JOIN T_AAD_TIPO_ACTO tac ON aad.seqTipoActo = tac.seqTipoActo
				GROUP BY 
					tac.txtNombreTipoActo, 
					aad.fchActo, 
					aad.numActo
				ORDER BY 
					tac.txtNombreTipoActo	    	
	    	";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $numPosicion = count($arrListado);
            $arrListado[$numPosicion]['seqTipoActo'] = $objRes->fields['seqTipoActo'];
            $arrListado[$numPosicion]['txtTipoActo'] = $objRes->fields['txtNombreTipoActo'];
            $arrListado[$numPosicion]['fchActo'] = $objRes->fields['fchActo'];
            $arrListado[$numPosicion]['numActo'] = $objRes->fields['numActo'];
            $objRes->MoveNext();
        }
        return $arrListado;
    }

    public function listarActosTipo($seqTipoActo) {

        global $aptBd;

        $sql = "
				SELECT
					numActo ,
					fchActo 
				FROM T_AAD_ACTO_ADMINISTRATIVO 
				WHERE seqTipoActo = $seqTipoActo
				GROUP BY numActo , fchActo 
				ORDER BY fchActo
				";

        $arrActosAdministrativos = array();
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $arrActosAdministrativos[] = $objRes->fields;
            $objRes->MoveNext();
        }

        return $arrActosAdministrativos;
    }

    public function listarActosNumeroTipo($numActo = null, $seqTipoActo = null) {
        global $aptBd;
        $arrListado = array();
        $arrCondiciones = array();
        if ($numActo != null) {
            $arrCondiciones[] = "aad.numActo = $numActo or aad.fchActo like '%$numActo%'";
        }
        if ($seqTipoActo != null) {
            $arrCondiciones[] = "aad.seqTipoActo = " . $seqTipoActo;
        }

        if ($seqTipoActo != 7) {
            $arrCondiciones[] = "aad.seqTipoActo != 7";
        } else {
            $arrCondiciones[] = "aad.seqTipoActo = 7";
        }

        $sql = "
				SELECT
					aad.seqActo,
					aad.seqTipoActo,
					tac.txtNombreTipoActo,
					aad.fchActo,
					aad.numActo,
					cac.txtNombreCaracteristica,
					aad.txtValorCaracteristica
				FROM T_AAD_ACTO_ADMINISTRATIVO aad
				INNER JOIN T_AAD_TIPO_ACTO tac ON aad.seqTipoActo = tac.seqTipoActo 
				INNER JOIN T_AAD_CARACTERISTICA_ACTO cac ON aad.seqCaracteristica = cac.seqCaracteristica 
			";
        if (!empty($arrCondiciones)) {
            $sql .= " WHERE " . implode(" AND ", $arrCondiciones);
        }

        $sql .="
				ORDER BY  
				  aad.fchActo   	
	    	";
        $objRes = $aptBd->execute($sql);
        while ($objRes->fields) {
            $txtIdentificador = $objRes->fields['numActo'] . $objRes->fields['fchActo'];
            $arrListado[$txtIdentificador]['seqTipoActo'] = $objRes->fields['seqTipoActo'];
            $arrListado[$txtIdentificador]['txtTipoActo'] = $objRes->fields['txtNombreTipoActo'];
            $arrListado[$txtIdentificador]['fchActo'] = $objRes->fields['fchActo'];
            $arrListado[$txtIdentificador]['numActo'] = $objRes->fields['numActo'];
            $arrListado[$txtIdentificador]['caracteristicas'][$objRes->fields['txtNombreCaracteristica']] = $objRes->fields['txtValorCaracteristica'];

            // Obtiene la cantidad de hogares vinculados
            $sql = "
					SELECT 
						COUNT(*) as Conteo 
					FROM 
						T_AAD_HOGARES_VINCULADOS 
					WHERE numActo = " . $objRes->fields['numActo'] . " 
					  AND fchActo = '" . $objRes->fields['fchActo'] . "'
				";
            try {
                $numHogaresvinculados = 0;
                $objRes1 = $aptBd->execute($sql);
                if ($objRes1->fields) {
                    $numHogaresvinculados = $objRes1->fields['Conteo'];
                }
            } catch (Exception $objError) {
                $numHogaresvinculados = 0;
            }

            $arrListado[$txtIdentificador]['cantidad'] = $numHogaresvinculados;

            $objRes->MoveNext();
        }
        return $arrListado;
    }

    public function cargarActoAdministrativoNumero($seqTipoActo, $numActo, $fchActo, $seqFormularioActo = 0) {
      global $aptBd;
      $arrActo = array();
      if( intval( $numActo ) != 0 ){
         $sql = "
             SELECT
                fac.seqFormularioActo as Identificador,
                moa.txtModalidad as Modalidad,
                CONCAT( sol.txtDescripcion , ' (',sol.txtSolucion,')') as Solucion,
                fac.fchInscripcion as Inscripcion,
                fac.fchPostulacion as Postulacion,
                fac.fchUltimaActualizacion as UltimaActualizacion,
                if( fac.bolDesplazado = 1 , 'Si' , 'No' ) as Desplazado,
                par.txtParentesco,
                tdo.txtTipoDocumento,
                cac.numDocumento,
                UPPER( CONCAT( cac.txtNombre1 , ' ' , cac.txtNombre2 , ' ' , cac.txtApellido1 , ' ' , cac.txtApellido2 ) ) as Nombre,
                cac.seqSexo,
                hac.seqParentesco,
                fac.valAspiraSubsidio as ValorSubsidio,
                hac.txtInhabilidad,
                hac.txtCausa,
                hac.txtFuente,
                hac.txtCampo,
                hac.txtIncorrecto,
                hac.txtCorrecto,
                hac.txtEstadoReposicion, 
				hac.valIndexacion
             FROM
                T_AAD_HOGARES_VINCULADOS hvi
                INNER JOIN T_AAD_FORMULARIO_ACTO fac ON hvi.seqFormularioActo = fac.seqFormularioActo
                INNER JOIN T_AAD_HOGAR_ACTO hac ON hac.seqFormularioActo = fac.seqFormularioActo
                INNER JOIN T_AAD_CIUDADANO_ACTO cac ON hac.seqCiudadanoActo = cac.seqCiudadanoActo
                INNER JOIN T_FRM_MODALIDAD moa ON fac.seqModalidad = moa.seqModalidad
                INNER JOIN T_FRM_SOLUCION sol ON fac.seqSolucion = sol.seqSolucion
                INNER JOIN T_CIU_PARENTESCO par ON hac.seqParentesco = par.seqParentesco
                INNER JOIN T_CIU_TIPO_DOCUMENTO tdo ON  cac.seqTipoDocumento = tdo.seqTipoDocumento
             WHERE hvi.numActo = $numActo
                AND hvi.fchActo = '$fchActo'
         ";

         if ($seqFormularioActo) {
             $sql .= " AND fac.seqFormularioActo = $seqFormularioActo";
         }
         try {
            $objRes = $aptBd->execute($sql);
         } catch ( Exception $objError ){
            //echo $objError->getMessage();
            echo $sql;
            exit(0);
         }
         while ($objRes->fields) {

             switch ($seqTipoActo) {
                 case 1: // Resolucion de asignacion
                     unset($objRes->fields['txtInhabilidad']);
                     unset($objRes->fields['txtCausa']);
                     unset($objRes->fields['txtFuente']);
                     unset($objRes->fields['txtCampo']);
                     unset($objRes->fields['txtIncorrecto']);
                     unset($objRes->fields['txtCorrecto']);
                     unset($objRes->fields['txtEstadoReposicion']);
                     break;
                 case 2: // Resolucion modificatoria
                     unset($objRes->fields['txtInhabilidad']);
                     unset($objRes->fields['txtCausa']);
                     unset($objRes->fields['txtFuente']);
                     unset($objRes->fields['txtEstadoReposicion']);
                     break;
                 case 3: // Resolucion de inhabilitados
                     unset($objRes->fields['txtCampo']);
                     unset($objRes->fields['txtIncorrecto']);
                     unset($objRes->fields['txtCorrecto']);
                     unset($objRes->fields['txtEstadoReposicion']);
                     break;
                 case 4: // Recursos de reposicion
                     unset($objRes->fields['txtInhabilidad']);
                     unset($objRes->fields['txtCausa']);
                     unset($objRes->fields['txtFuente']);
                     unset($objRes->fields['txtCampo']);
                     unset($objRes->fields['txtIncorrecto']);
                     unset($objRes->fields['txtCorrecto']);
                     break;
             }

             $numPosicion = count($arrActo);
             if ($numPosicion == 0) {
                 $arrTitulos = array_keys($objRes->fields);
                 $arrActo[$numPosicion] = $arrTitulos;
                 $numPosicion++;
             }

             foreach ($objRes->fields as $txtValor) {
                 $arrActo[$numPosicion][] = utf8_decode(trim($txtValor));
             }

             $objRes->MoveNext();
         }
      }
        return $arrActo;
    }
    
    /**
     * CON BASE EN EL NUMERO Y LA FECHA DE ACTO
     * ADMINISTRATIVO, OBTIENE EL TIPO DEL ACTO
     * @global type $aptBd
     * @param int $numActo
     * @param dater $fchActo
     * @return int
     */
    
    public function obtenerTipoActo( $numActo , $fchActo ){
       global $aptBd;
       $seqTipoActo = 0;
       try {
          $sql = "
            SELECT DISTINCT
               seqTipoActo
            FROM T_AAD_ACTO_ADMINISTRATIVO
            WHERE numActo = $numActo
            AND fchActo = '$fchActo'
          ";
          $objRes = $aptBd->execute( $sql );
          if( $objRes->RecordCount() > 0 ){
             $seqTipoActo = $objRes->fields['seqTipoActo'];
          }
       } catch( Exception $objError ){
          $seqTipoActo = 0;
       }
       return $seqTipoActo;
    }
    
    public function caracteristicasActo( $numActo , $fchActo ){
      global $aptBd;
      $arrCaracteristicas = array();
      if( intval( $numActo ) != 0 ){
         $sql = "
            SELECT 
              aad.numActo,
              aad.fchActo,
              cac.txtNombreCaracteristica,
              aad.txtValorCaracteristica
            FROM T_AAD_ACTO_ADMINISTRATIVO aad
            INNER JOIN T_AAD_CARACTERISTICA_ACTO cac ON aad.seqCaracteristica = cac.seqCaracteristica
            WHERE aad.numActo = " . $numActo . "
            AND aad.fchActo = '" . $fchActo . "'
         ";
         $objRes = $aptBd->execute( $sql );
         while( $objRes->fields ){
            $arrCaracteristicas['numActo'] = $objRes->fields['numActo'];
            $arrCaracteristicas['fchActo'] = $objRes->fields['fchActo'];
            $arrCaracteristicas[ $objRes->fields['txtNombreCaracteristica'] ] = $objRes->fields['txtValorCaracteristica'];
            $objRes->MoveNext();
         }
      }
      return $arrCaracteristicas;
    }
    
}

// fin clase actos administrativos
?>