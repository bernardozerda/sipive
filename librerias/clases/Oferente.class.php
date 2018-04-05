<?php

/**
 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
 * RELACIONADAS CON EL OFERENTE
 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
 * @author Jaison Ospina
 * @version 0.1 Agosto 2013
 */
class Oferente {

//		public $txtNombreOferente;				// Nombre de la Oferente
//		public $seqTipoDocumentoOferente;		// Tipo de Documento del Oferente
//		public $numDocumentoOferente;			// Numero de Documento del Oferente
//		public $txtNombreRepresentanteLegal;	// Nombre del Representante Legal del Oferente
//		public $numDocumentoRepresentanteLegal;	// Numero de Documento del Representante Legal del Oferente
//		public $bolActivo;						// Estado Activo del Oferente

    public $txtNombreOferente;
    public $numNitOferente;
    public $txtNombreContactoOferente;
    public $numTelefonoOferente = 0;
    public $numExtensionOferente = 0;
    public $numCelularOferente = 0;
    public $txtCorreoOferente;
    public $txtRepresentanteLegalOferente;
    public $numNitRepresentanteLegalOferente = 0;
    public $numTelefonoRepresentanteLegalOferente = 0;
    public $numExtensionRepresentanteLegalOferente = 0;
    public $numCelularRepresentanteLegalOferente = 0;
    public $txtDireccionRepresentanteLegalOferente;
    public $txtCorreoRepresentanteLegalOferente;

    //public $bolActivo;

    /**
     * CONSTRUCTOR DE LA CLASE
     * @author Jaison ospina
     * @param Void
     * @return Void
     * @version 1.0 Agosto 2013
     */
    public function Oferente() {
//        $this->txtNombreOferente = "";
//        $this->seqTipoDocumentoOferente = 0;
//        $this->numDocumentoOferente = 0;
//        $this->txtNombreRepresentanteLegal = "";
//        $this->numDocumentoRepresentanteLegal = 0;
        //$this->bolActivo = 0;
        $this->txtNombreOferente = "";
        $this->numNitOferente = 0;
        $this->txtNombreContactoOferente = "";
        $this->numTelefonoOferente = 0;
        $this->numExtensionOferente = 0;
        $this->numCelularOferente = 0;
        $this->txtCorreoOferente = "";
        $this->txtRepresentanteLegalOferente = "";
        $this->numNitRepresentanteLegalOferente = 0;
        $this->numTelefonoRepresentanteLegalOferente = 0;
        $this->numExtensionRepresentanteLegalOferente = 0;
        $this->numCelularRepresentanteLegalOferente = 0;
        $this->txtDireccionRepresentanteLegalOferente = "";
        $this->txtCorreoRepresentanteLegalOferente = "";
    }

// Fin Constructor

    /**
     * CARGA UNO O TODOS LOS OFERENTES QUE
     * HAY EN LA BASE DE DATOS, DEPENDE DEL PARAMETRO
     * QUE SE LE PASE A LA FUNCION
     * @author Jaison Ospina
     * @return array arrOferente
     * @version 1.0 Noviembre 2013
     */
    public function cargarOferente($seqOferente) {

        global $aptBd;

        // Arreglo que se retorna
        $arrOferente = array();

        // Si viene parametro la consulta es para un solo Oferente
        $txtCondicion = "";
        if ($seqOferente != 0) {
            $txtCondicion = " AND seqOferente = $seqOferente";
        }

        // Consulta de Oferente
        $sql = "
				SELECT
            		seqOferente,
	    			txtNombreOferente,
					seqTipoDocumentoOferente,
					numDocumentoOferente,
					txtNombreRepresentanteLegal,
					numDocumentoRepresentanteLegal,
					bolActivo
	    		FROM 
	    			T_PRY_OFERENTE
				WHERE seqOferente > 0
					$txtCondicion
				ORDER BY
					txtNombreOferente
			";
        //echo $sql;

        $objRes = $aptBd->execute($sql);
        if ($aptBd->ErrorMsg() == "") {
            while ($objRes->fields) {
                $seqOferente = $objRes->fields['seqOferente'];
                $objOferente = new Oferente;
                $objOferente->txtNombreOferente = $objRes->fields['txtNombreOferente'];
                $objOferente->seqTipoDocumentoOferente = $objRes->fields['seqTipoDocumentoOferente'];
                $objOferente->numDocumentoOferente = $objRes->fields['numDocumentoOferente'];
                $objOferente->txtNombreRepresentanteLegal = $objRes->fields['txtNombreRepresentanteLegal'];
                $objOferente->numDocumentoRepresentanteLegal = $objRes->fields['numDocumentoRepresentanteLegal'];
                $objOferente->bolActivo = $objRes->fields['bolActivo'];
                $arrOferente[$seqOferente] = $objOferente; // arreglo de objetos
                $objRes->MoveNext();
            }
        }
        return $arrOferente;
    }

// Fin Cargar Oferente

    /**
     * GUARDA EN LA BASE DE DATOS LA INFORMACION DEL OFERENTE
     * @author Jaison Ospina

     * @param String txtNombreOferente
     * @param integer seqTipoDocumentoOferente
     * @param integer numDocumentoOferente
     * @param String txtNombreRepresentanteLegal
     * @param integer numDocumentoRepresentanteLegal
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0,1 Noviembre 2013
     */
    public function guardarOferente($post) {

        global $aptBd;

        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "") {
                $valor = 'null';
            }
            $$nombre_campo = $valor;
        }
        $arrErrores = array();

        // Instruccion para insertar el Oferente en la base de datos
        $sql = "INSERT INTO t_pry_entidad_oferente
                (   txtNombreOferente,
                    numNitOferente,
                    txtNombreContactoOferente,
                    numTelefonoOferente,
                    numExtensionOferente,
                    numCelularOferente,
                    txtCorreoOferente,
                    txtRepresentanteLegalOferente,
                    numNitRepresentanteLegalOferente,
                    numTelefonoRepresentanteLegalOferente,
                    numExtensionRepresentanteLegalOferente,
                    numCelularRepresentanteLegalOferente,
                    txtDireccionRepresentanteLegalOferente,
                    txtCorreoRepresentanteLegalOferente,
                    seqUsuario)
                    VALUES (
                     \"" . ereg_replace('\"', "", $txtNombreOferente) . "\", 
                    $numNitOferente,
                    '$txtNombreContactoOferente',
                    $numTelefonoOferente,
                    $numExtensionOferente,
                    $numCelularOferente,
                    '$txtCorreoOferente',
                    '$txtRepresentanteLegalOferente',
                    $numNitRepresentanteLegalOferente,
                    $numTelefonoRepresentanteLegalOferente,
                    $numExtensionRepresentanteLegalOferente,
                    $numCelularRepresentanteLegalOferente,
                    '$txtDireccionRepresentanteLegalOferente',
                    '$txtCorreoRepresentanteLegalOferente',
                     $seqUsuario
                    ) ";

        // echo $sql; 

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido guardar el Oferente <b>$txtNombreOferente</b>. Reporte este error al administrador del sistema";
        }
        return $arrErrores;
    }

// Fin guardar Oferente

    /**
     * MODIFICA LA INFORMACION DEL OFERENTE SELECCIONADO Y GUARDA LOS NUEVOS DATOS
     * @author Jaison Ospina
     * @param integer seqOferente
     * @param String txtNombreOferente
     * @param integer seqTipoDocumentoOferente
     * @param integer numDocumentoOferente
     * @param String txtNombreRepresentanteLegal
     * @param integer numDocumentoRepresentanteLegal
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0.1 Agosto 2013
     */
    public function editarOferente($post) {
        global $aptBd;

        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "") {
                $valor = 'null';
            }
            $$nombre_campo = $valor;
        }
        $arrErrores = array();

        // Consulta para hacer la actualizacion
        $sql = "
                UPDATE t_pry_entidad_oferente
                    SET
                            txtNombreOferente = \"" . ereg_replace('\"', "", $txtNombreOferente) . "\", 
                            numNitOferente = $numNitOferente,
                            txtNombreContactoOferente = '$txtNombreContactoOferente',
                            numTelefonoOferente = $numTelefonoOferente,
                            numExtensionOferente = $numExtensionOferente,
                            numCelularOferente = $numCelularOferente,
                            txtCorreoOferente = '$txtCorreoOferente',
                            txtRepresentanteLegalOferente = '$txtRepresentanteLegalOferente',
                            numNitRepresentanteLegalOferente = $numNitRepresentanteLegalOferente,
                            numTelefonoRepresentanteLegalOferente = $numTelefonoRepresentanteLegalOferente,
                            numExtensionRepresentanteLegalOferente = $numExtensionRepresentanteLegalOferente,
                            numCelularRepresentanteLegalOferente = $numCelularRepresentanteLegalOferente,
                            txtDireccionRepresentanteLegalOferente ='$txtDireccionRepresentanteLegalOferente',
                            txtCorreoRepresentanteLegalOferente = '$txtCorreoRepresentanteLegalOferente'            
                     WHERE seqOferente = $seqOferente
            ";
        //echo $sql;

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            //$arrOferente = $this->cargarOferente($seqOferente);
            $arrErrores[] = "No se ha podido editar el Oferente <b>" . $arrOferente[$seqOferente]->txtNombreOferente . "</b>. Reporte este error al administrador del sistema";
        }

        return $arrErrores;
    }

// Fin editar Oferente

    /**
     * VERIFICA SI SE PUEDE BORRAR EL OFERENTE Y SI ES POSIBLE LO BORRA DEL SISTEMA
     * @author Jaison Ospina
     * @param integer seqOferente
     * @return array arrErrores
     * @version 1.0 Noviembre 2013
     */
    public function borrarOferente($seqOferente) {

        global $aptBd;
        $arrErrores = array();

        // Valida que se pueda borrar el Oferente
        //$arrErrores = $this->validarBorrarOferente( $seqOferente );
        // si no hay errores entra a eliminar
        if (empty($arrErrores)) {

            $sql = "
                    DELETE
                    FROM T_PRY_OFERENTE
                    WHERE seqOferente = $seqOferente
                ";

            // borra el Oferente
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrOferente = $this->cargarOferente($seqOferente);
                $arrErrores[] = "No se ha podido borrar el Oferente <b>" . $arrOferente[$seqOferente]->txtNombreOferente . "</b>";
                //pr( $objError->getMessage() );
            }
        }

        return $arrErrores;
    }

// Fin borrar Oferente
}

// Fin clase
?>