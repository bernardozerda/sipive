<?php

/**
 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
 * RELACIONADAS CON EL CONSTRUCTOR
 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
 * @author Jaison Ospina
 * @version 0.1 Agosto 2013
 */
class Constructor {

    public $txtNombreConstructor;     // Nombre de la Constructor
    public $seqTipoDocumentoConstructor;   // Tipo de Documento del Constructor
    public $numDocumentoConstructor;    // Numero de Documento del Constructor
    public $txtDireccionConstructor;    // Direccion del Constructor
    public $numTelefono1Constructor;    // Telefono 1 del Constructor
    public $numTelefono2Constructor;    // Telefono 2 del Constructor
    public $txtCorreoElectronicoConstructor;  // Correo Electronico del Constructor
    public $txtNombreRepresentanteLegal;   // Nombre del Representante Legal del Constructor
    public $numDocumentoRepresentanteLegal;   // Numero de Documento del Representante Legal del Constructor
    public $txtCorreoElectronicoRepresentanteLegal; // Numero de Documento del Representante Legal del Constructor
    public $bolActivo;        // Estado Activo del Constructor

    /**
     * CONSTRUCTOR DE LA CLASE
     * @author Jaison ospina
     * @param Void
     * @return Void
     * @version 1.0 Agosto 2013
     */

    public function Constructor() {
        $this->txtNombreConstructor = "";
        $this->seqTipoDocumentoConstructor = 0;
        $this->numDocumentoConstructor = 0;
        $this->txtDireccionConstructor = "";
        $this->numTelefono1Constructor = 0;
        $this->numTelefono2Constructor = 0;
        $this->txtCorreoElectronicoConstructor = "";
        $this->txtNombreRepresentanteLegal = "";
        $this->numDocumentoRepresentanteLegal = 0;
        $this->txtCorreoElectronicoRepresentanteLegal = "";
        $this->bolActivo = 0;
    }

// Fin Constructor

    /**
     * CARGA UNO O TODOS LOS CONSTRUCTOR QUE
     * HAY EN LA BASE DE DATOS, DEPENDE DEL PARAMETRO
     * QUE SE LE PASE A LA FUNCION
     * @author Jaison Ospina
     * @return array arrConstructor
     * @version 1.0 Noviembre 2013
     */
    public function cargarConstructor($seqConstructor) {

        global $aptBd;

        // Arreglo que se retorna
        $arrConstructor = array();

        // Si viene parametro la consulta es para un solo Constructor
        $txtCondicion = "";
        if ($seqConstructor != 0) {
            $txtCondicion = " AND seqConstructor = $seqConstructor";
        }

        // Consulta de Constructor
        $sql = "
				SELECT
            		seqConstructor,
	    			txtNombreConstructor,
					seqTipoDocumentoConstructor,
					numDocumentoConstructor,
					txtDireccionConstructor,
					numTelefono1Constructor,
					numTelefono2Constructor,
					txtCorreoElectronicoConstructor,
					txtNombreRepresentanteLegal,
					numDocumentoRepresentanteLegal,
					txtCorreoElectronicoRepresentanteLegal,
					bolActivo
	    		FROM 
	    			T_PRY_CONSTRUCTOR
				WHERE seqConstructor > 0
					$txtCondicion
				ORDER BY
					txtNombreConstructor
			";
        //echo $sql;

        $objRes = $aptBd->execute($sql);
        if ($aptBd->ErrorMsg() == "") {
            while ($objRes->fields) {
                $seqConstructor = $objRes->fields['seqConstructor'];
                $objConstructor = new Constructor;
                $objConstructor->txtNombreConstructor = $objRes->fields['txtNombreConstructor'];
                $objConstructor->seqTipoDocumentoConstructor = $objRes->fields['seqTipoDocumentoConstructor'];
                $objConstructor->numDocumentoConstructor = $objRes->fields['numDocumentoConstructor'];
                $objConstructor->txtDireccionConstructor = $objRes->fields['txtDireccionConstructor'];
                $objConstructor->numTelefono1Constructor = $objRes->fields['numTelefono1Constructor'];
                $objConstructor->numTelefono2Constructor = $objRes->fields['numTelefono2Constructor'];
                $objConstructor->txtCorreoElectronicoConstructor = $objRes->fields['txtCorreoElectronicoConstructor'];
                $objConstructor->txtNombreRepresentanteLegal = $objRes->fields['txtNombreRepresentanteLegal'];
                $objConstructor->numDocumentoRepresentanteLegal = $objRes->fields['numDocumentoRepresentanteLegal'];
                $objConstructor->txtCorreoElectronicoRepresentanteLegal = $objRes->fields['txtCorreoElectronicoRepresentanteLegal'];
                $objConstructor->bolActivo = $objRes->fields['bolActivo'];
                $arrConstructor[$seqConstructor] = $objConstructor; // arreglo de objetos
                $objRes->MoveNext();
            }
        }
        return $arrConstructor;
    }

// Fin Cargar Constructor

    /**
     * GUARDA EN LA BASE DE DATOS LA INFORMACION DEL CONSTRUCTOR
     * @author Jaison Ospina

     * @param String txtNombreConstructor
     * @param integer seqTipoDocumentoConstructor
     * @param integer numDocumentoConstructor
     * @param String txtDireccionConstructor
     * @param integer numTelefono1Constructor
     * @param integer numTelefono2Constructor
     * @param String txtCorreoElectronicoConstructor
     * @param String txtNombreRepresentanteLegal
     * @param integer numDocumentoRepresentanteLegal
     * @param String txtCorreoElectronicoRepresentanteLegal
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0,1 Noviembre 2013
     */
    public function guardarConstructor($post) {

        global $aptBd;
        $bolActivo = 1;
        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "") {
                $valor = 'null';
            }
            $$nombre_campo = $valor;
        }
        $arrErrores = array();

        // Verifica si el Constructor existe
        $sql = mysql_query("SELECT * FROM T_PRY_CONSTRUCTOR WHERE numDocumentoConstructor = $numDocumentoConstructor");
        $cuantos = mysql_num_rows($sql);
        if ($cuantos > 0) {
            $arrErrores[] = "El Documento <b>$numDocumentoConstructor</b> ya está asignado a otro Constructor";
        } else {
            // Instruccion para insertar el Constructor en la base de datos
            $sql = "INSERT INTO T_PRY_CONSTRUCTOR ( 
						txtNombreConstructor,
						seqTipoDocumentoConstructor,
						numDocumentoConstructor,
						txtDireccionConstructor,
						numTelefono1Constructor,
						numTelefono2Constructor,
						txtCorreoElectronicoConstructor,
						txtNombreRepresentanteLegal,
						numDocumentoRepresentanteLegal,
						txtCorreoElectronicoRepresentanteLegal,
						bolActivo
					) VALUES (
						\"" . ereg_replace('\"', "", $txtNombreConstructor) . "\", 
						$seqTipoDocumentoConstructor,
						$numDocumentoConstructor,
						'$txtDireccionConstructor', 
						$numTelefono1Constructor, 
						$numTelefono2Constructor, 
						'$txtCorreoElectronicoConstructor', 
						'$txtNombreRepresentanteLegal', 
						$numDocumentoRepresentanteLegal, 
						'$txtCorreoElectronicoRepresentanteLegal',
						$bolActivo
					) ";

            try {
                $aptBd->execute($sql);
                return $aptBd->Insert_ID();
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido guardar el Constructor <b>$txtNombreConstructor</b>. Reporte este error al administrador del sistema";
                return $arrErrores;
            }
        }
        
    }

// Fin guardar Constructor

    /**
     * MODIFICA LA INFORMACION DEL CONSTRUCTOR SELECCIONADO Y GUARDA LOS NUEVOS DATOS
     * @author Jaison Ospina
     * @param integer seqConstructor
     * @param String txtNombreConstructor
     * @param integer seqTipoDocumentoConstructor
     * @param integer numDocumentoConstructor
     * @param String txtNombreRepresentanteLegal
     * @param integer numDocumentoRepresentanteLegal
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0.1 Agosto 2013
     */
    public function editarConstructor($post) {
        global $aptBd;
        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "") {
                $valor = 'null';
            }
            $$nombre_campo = $valor;
        }
        if (!isset($_POST['bolActivo']) || $_POST['bolActivo'] == NULL) {
            $bolActivo = 0;
        }
        $arrErrores = array();

        // Verifica si el Constructor existe
        $sql = mysql_query("SELECT * FROM T_PRY_CONSTRUCTOR WHERE numDocumentoConstructor = $numDocumentoConstructor AND seqConstructor <> $seqConstructor");
        $cuantos = mysql_num_rows($sql);
        if ($cuantos > 0) {
            $arrErrores[] = "El Documento <b>$numDocumentoConstructor</b> ya está asignado a otro Constructor";
        } else {
            // Consulta para hacer la actualizacion
            $sql = "
                    UPDATE T_PRY_CONSTRUCTOR SET
                            txtNombreConstructor = \"" . ereg_replace('\"', "", $txtNombreConstructor) . "\", 
                            seqTipoDocumentoConstructor = '$seqTipoDocumentoConstructor',
                            numDocumentoConstructor = '$numDocumentoConstructor',
                            txtDireccionConstructor = '$txtDireccionConstructor',
                            numTelefono1Constructor = '$numTelefono1Constructor',
                            numTelefono2Constructor = '$numTelefono2Constructor',
                            txtCorreoElectronicoConstructor = '$txtCorreoElectronicoConstructor',
                            txtNombreRepresentanteLegal = '$txtNombreRepresentanteLegal',
                            numDocumentoRepresentanteLegal = '$numDocumentoRepresentanteLegal',
                            txtCorreoElectronicoRepresentanteLegal = '$txtCorreoElectronicoRepresentanteLegal',
                            bolActivo = $bolActivo
                    WHERE seqConstructor = $seqConstructor
            ";
            //echo $sql;

            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrConstructor = $this->cargarConstructor($seqConstructor);
                $arrErrores[] = "No se ha podido editar el Constructor <b>" . $arrConstructor[$seqConstructor]->txtNombreConstructor . "</b>. Reporte este error al administrador del sistema";
            }
        }
        return $arrErrores;
    }

// Fin editar Constructor

    /**
     * VERIFICA SI SE PUEDE BORRAR EL CONSTRUCTOR Y SI ES POSIBLE LO BORRA DEL SISTEMA
     * @author Jaison Ospina
     * @param integer seqConstructor
     * @return array arrErrores
     * @version 1.0 Noviembre 2013
     */
    public function borrarConstructor($seqConstructor) {

        global $aptBd;
        $arrErrores = array();

        // Valida que se pueda borrar el Constructor
        //$arrErrores = $this->validarBorrarConstructor( $seqConstructor );
        // si no hay errores entra a eliminar
        if (empty($arrErrores)) {

            $sql = "
                    DELETE
                    FROM T_PRY_CONSTRUCTOR
                    WHERE seqConstructor = $seqConstructor
                ";

            // borra el Constructor
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrConstructor = $this->cargarConstructor($seqConstructor);
                $arrErrores[] = "No se ha podido borrar el Constructor <b>" . $arrConstructor[$seqConstructor]->txtNombreConstructor . "</b>";
                //pr( $objError->getMessage() );
            }
        }

        return $arrErrores;
    }

// Fin borrar Constructor
}

// Fin clase
?>