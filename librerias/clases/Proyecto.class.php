<?php

/**
 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
 * RELACIONADAS CON LOS PROYECTOS
 * 
 * REQUIERE QUE ESTE CONECTADO A LA BASE DE DATOS
 * 
 * @author Bernardo Zerda
 * @version 0.1 Marzo 2009
 */
class Proyecto {

    public $txtProyecto;      // Nombre de la Proyecto
    public $numLimiteActivos; // Cantidad de activos que se pueden manejar
    public $fchVencimiento;   // Fecha en la que termina el proyecto
    public $bolActivo;        // si la Proyecto esta activa o no
    public $arrProyectoGrupo; // Grupos que estan asociados a la Proyecto

    /**
     * CONSTRUCTOR DE LA CLASE
     * @author Bernardo Zerda
     * @param Void
     * @return Void
     * @version 1.0 Marzo 2009
     */

    public function Proyecto() {
        $this->txtProyecto = "";
        $this->fchVencimiento = NULL;
        $this->bolActivo = false;
        $this->arrProyectoGrupo = array();
    }

// Fin Constructor

    /**
     * CARGA UNA O TODAS LOS PROYECTOS QUE HAY EN
     * LA BASE DE DATOS, DEPENDE DEL PARAMETRO QUE
     * SE LE PASE A LA FUNCION
     * @author Bernardo Zerda
     * @param integer seqProyecto = 0
     * @return array arrProyectos
     * @version 1.0 Marzo de 2009
     */
    public function cargarProyecto($seqProyecto = 0) {

        global $aptBd;

        // Arreglo que se retorna
        $arrProyectos = array();

        // Si viene parametro la consulta es para una sola Proyecto
        $txtCondicion = "";
        if ($seqProyecto != 0) {
            $txtCondicion = " AND seqProyecto = $seqProyecto";
        }

        // Consulta de Proyectos
        $sql = "
	    		SELECT
            		seqProyecto, 
	    			ucwords(txtProyecto) as txtProyecto,
	    			fchVencimiento,
	    			bolActivo,
					seqMenu
	    		FROM 
	    			T_COR_PROYECTO
				WHERE seqProyecto > 1
	    		$txtCondicion
	          ORDER BY  
	            txtProyecto
	    	";
        $objRes = $aptBd->execute($sql);
        if ($aptBd->ErrorMsg() == "") {

            while ($objRes->fields) {

                $seqProyecto = $objRes->fields['seqProyecto'];

                $objProyecto = new Proyecto;
                $objProyecto->txtProyecto = $objRes->fields['txtProyecto'];
                $objProyecto->fchVencimiento = $objRes->fields['fchVencimiento'];
                $objProyecto->bolActivo = $objRes->fields['bolActivo'];
                $objProyecto->seqMenu = $objRes->fields['seqMenu'];

                $arrProyectos[$seqProyecto] = $objProyecto; // arreglo de objetos

                $objRes->MoveNext();
            }

            // Obtiene la informacion de las empesas
            // y su relacion con los grupos
            if (!empty($arrProyectos)) {
                $sql = "
                SELECT
                    seqProyectoGrupo,
                    seqProyecto,
                    seqGrupo
                FROM 
                    T_COR_PROYECTO_GRUPO
				WHERE seqProyecto > 1 
                $txtCondicion
            ";

                $objRes = $aptBd->execute($sql);
                while ($objRes->fields) {

                    $seqProyectoGrupo = $objRes->fields['seqProyectoGrupo'];
                    $seqProyecto = $objRes->fields['seqProyecto'];
                    $seqGrupo = $objRes->fields['seqGrupo'];

                    // Grupos asociados a la Proyecto
                    if (isset($arrProyectos[$seqProyecto])) {
                        $arrProyectos[$seqProyecto]->arrProyectoGrupo[$seqGrupo] = $seqProyectoGrupo;
                    }

                    $objRes->MoveNext();
                }
            }
        }

        return $arrProyectos;
    }

// Fin Cargar Proyecto

    public function listarProyectos() {

        global $aptBd;

        $sql = " SELECT seqProyecto, txtNombreProyecto FROM T_PRY_PROYECTO ORDER BY txtNombreProyecto";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {

            $datos[$objRes->fields['seqProyecto']] = $objRes->fields['txtNombreProyecto'];
            $objRes->MoveNext();
        }
        return $datos;
    }

    /**
     * GUARDA EN LA BASE DE DATOS LA INFORMACION DE 
     * LOS ProyectoOS
     * @author Bernardo Zerda
     * @param String txtNombre
     * @param Date fchVencimiento
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0,1 Marzo 2009
     */
    public function guardarProyecto($txtNombre, $fchVencimiento, $bolActivo, $seqMenu) {

        global $aptBd;
        $arrErrores = array();

        // Instruccion para insertar la emrpesa en la base de datos
        $sql = "
                INSERT INTO T_COR_PROYECTO ( 
                    txtProyecto, 
                    bolActivo,
                    fchVencimiento,
					seqMenu
                ) VALUES (
                    \"" . ereg_replace('\"', "", $txtNombre) . "\", 
                    $bolActivo, 
                    '$fchVencimiento',
					$seqMenu
                )
            ";

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido guardar la Proyecto <b>$txtNombre</b> reporte este error al administrador del sistema";
        }

        return $arrErrores;
    }

// Fin guardar Proyecto

    /**
     * MODIFICA LA INFORMACION DE LA Proyecto
     * SELECCIONADA Y GUARDA LOS NUEVOS DATOS
     * @author Bernardo Zerda
     * @param integer seqProyecto
     * @param String txtNombre
     * @param Date fchVencimiento
     * @param Boolean bolActivo
     * @return Array arrErrores
     * @version 0,1 Marzo 2009
     */
    public function editarProyecto($seqProyecto, $txtNombre, $fchVencimiento, $bolActivo, $seqMenu) {

        global $aptBd;
        $arrErrores = array();

        // Consulta para hacer la actualizacion
        $sql = "
                UPDATE T_COR_PROYECTO SET
                    txtProyecto = \"" . ereg_replace('\"', "", $txtNombre) . "\", 
                    bolActivo = $bolActivo,
                    fchVencimiento = '$fchVencimiento',
					seqMenu = $seqMenu
                WHERE seqProyecto = $seqProyecto
            ";

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrProyecto = $this->cargarProyecto($seqProyecto);
            $arrErrores[] = "No se ha podido editar la Proyecto <b>" . $arrProyecto[$seqProyecto]->txtProyecto . "</b> reporte este error al administrador del sistema";
        }

        return $arrErrores;
    }

// Fin editar Proyecto

    /**
     * VERIFICA SI SE PUEDE BORRAR LA Proyecto
     * Y SI ES POSIBLE LA BORRA DEL SISTEMA
     * @author Bernardo Zerda
     * @param integer seqProyecto
     * @return array arrErrores
     * @version 1.0 Marzo 2009
     */
    public function borrarProyecto($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        // Valida que se pueda borrar la Proyecto
        $arrErrores = $this->validarBorrarProyecto($seqProyecto);

        // si no hay errores entra a eliminar
        if (empty($arrErrores)) {

            $sql = "
                    DELETE
                    FROM T_COR_PROYECTO
                    WHERE seqProyecto = $seqProyecto
                ";

            // borra la Proyecto
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrProyecto = $this->cargarProyecto($seqProyecto);
                $arrErrores[] = "No se ha podido borrar la Proyecto <b>" . $arrProyecto[$seqProyecto]->txtProyecto . "</b>";
                //pr( $objError->getMessage() );
            }
        }

        return $arrErrores;
    }

// Fin borrar Proyecto

    /**
     * VERIFICA SI LA Proyecto TIENE GRUPOS
     * ASOCIADOS Y SI ES ASI LA Proyecto NO
     * SE PUEDE ELIMINAR DEL SISTEMA
     * @author Bernardo Zerda
     * @param integer seqProyecto
     * @return array arrErrores
     * @version 1.0 Marzo 2009
     */
    private function validarBorrarProyecto($seqProyecto) {

        global $aptBd;
        $arrErrores = array();

        // obtiene los datos de la emrpesa para efectos de mensajes al usuario
        $arrProyecto = $this->cargarProyecto($seqProyecto);

        // consulta para ver si hay grupos asociados
        $sql = "
                SELECT seqProyectoGrupo
                FROM T_COR_PROYECTO_GRUPO
                WHERE seqProyecto = $seqProyecto
            ";

        try {
            $objRes = $aptBd->execute($sql);
            if ($objRes->RecordCount() > 0) {
                $arrErrores[] = "No se puede eliminar la Proyecto <b>" . $arrProyecto[$seqProyecto]->txtProyecto . "</b> porque tiene grupos de usuarios asociados";
            }
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido consultar si la Proyecto <b>" . $arrProyecto[$seqProyecto]->txtProyecto . "</b> tiene grupos asociados, reporte este error al administrador del sistema";
            //pr( $objError->getMessage() );
        }

        return $arrErrores;
    }

    public function obtenerDatosProyecto($seqProyecto) {

        global $aptBd;

        $sql = "SELECT pry.seqProyecto,(SELECT CONCAT(numActo, ' - ', DATE_FORMAT(fchActo,'%d %b %y'))
                FROM T_PRY_AAD_UNIDAD_ACTO
                LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON ( T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo ) 
                LEFT JOIN T_PRY_UNIDAD_PROYECTO uni ON ( T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = uni.seqUnidadProyecto )            
                WHERE seqTipoActoUnidad =1 and uni.seqProyecto=" . $seqProyecto . "
                GROUP BY  numActo) AS elegibilidad, 
                (SELECT CONCAT(numActo, ' - ', DATE_FORMAT(fchActo,'%d %b %y') ) AS elegibilidad
                FROM T_PRY_AAD_UNIDAD_ACTO
                LEFT JOIN T_PRY_AAD_UNIDADES_VINCULADAS ON ( T_PRY_AAD_UNIDAD_ACTO.seqUnidadActo = T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadActo ) 
                LEFT JOIN T_PRY_UNIDAD_PROYECTO uni ON ( T_PRY_AAD_UNIDADES_VINCULADAS.seqUnidadProyecto = uni.seqUnidadProyecto )            
                WHERE  seqTipoActoUnidad = 2 and uni.seqProyecto=" . $seqProyecto . "
                GROUP BY seqTipoActoUnidad) AS resolucion,   txtNombreProyecto, txtBarrio, TxtNombrePlanParcial, txtDireccion, txtLocalidad, txtNombreOferente, seqProyectoPadre,
                CASE seqProyectoPadre='' WHEN seqProyectoPadre='' THEN (SELECT txtNombreInterventor FROM T_PRY_PROYECTO WHERE seqProyecto = pry.seqProyectoPadre) 
                ELSE txtNombreInterventor END AS interventor, txtNombreConstructor,
                CASE seqProyectoPadre='' WHEN seqProyectoPadre='' THEN (SELECT valTotalCostos FROM T_PRY_PROYECTO WHERE seqProyecto = pry.seqProyectoPadre) 
                ELSE valTotalCostos END AS Costos,
                valNumeroSoluciones AS soluciones,
                CASE seqProyectoPadre='' WHEN seqProyectoPadre='' THEN (SELECT valSDVE FROM T_PRY_PROYECTO WHERE seqProyecto = pry.seqProyectoPadre) 
                ELSE valSDVE END AS valSDVE, 
                CASE seqProyectoPadre='' WHEN seqProyectoPadre='' THEN (SELECT txtTipoModalidadDesembolso FROM t_pry_tipo_modalidad_desembolso LEFT JOIN T_PRY_PROYECTO pry1 
                USING(seqTipoModalidadDesembolso) WHERE pry1.seqProyecto = pry.seqProyectoPadre) 
                ELSE (SELECT txtTipoModalidadDesembolso FROM t_pry_tipo_modalidad_desembolso LEFT JOIN T_PRY_PROYECTO pry1 
                USING(seqTipoModalidadDesembolso) WHERE pry1.seqProyecto = pry.seqProyecto)  END AS ModalidadDesembolso, txtNombreVendedor AS fiduciaria, valTorres,
                (SELECT GROUP_CONCAT(txtNombreTipoVivienda, ' - ', numArea  ) FROM t_pry_tipo_vivienda WHERE seqProyecto = " . $seqProyecto . " OR seqProyecto = pry.seqProyectoPadre) AS area, 
                (SELECT COUNT(pru.seqProyecto) as cant 
                FROM t_pry_unidad_proyecto pru
                LEFT JOIN T_FRM_FORMULARIO USING(seqFormulario) 
                LEFT JOIN t_frm_estado_proceso USING(seqEstadoProceso)
                WHERE seqFormulario != '' and seqFormulario > 0 and seqEtapa >=4 AND pru.seqProyecto = " . $seqProyecto . ") AS cuposvinculados, txtTipoEsquema
                FROM T_PRY_PROYECTO pry
                LEFT JOIN T_FRM_BARRIO br ON(pry.seqBarrio = br.seqBarrio)
                LEFT JOIN T_FRM_LOCALIDAD lc ON(pry.seqLocalidad = lc.seqLocalidad)
                LEFT JOIN T_PRY_ENTIDAD_OFERENTE ofr ON(seqProyectoPadre =ofr.seqProyecto OR pry.seqProyecto =ofr.seqProyecto)
                LEFT JOIN T_PRY_CONSTRUCTOR con ON(pry.seqConstructor =con.seqConstructor)
                LEFT JOIN T_PRY_TIPO_ESQUEMA esq ON(pry.seqTipoEsquema =esq.seqTipoEsquema )
                WHERE pry.seqProyecto = " . $seqProyecto;
        $objRes = $aptBd->getAssoc($sql);

        return $objRes;
    }

    public function obtenerEntidades($seqProyecto) {
        global $aptBd;
        $sql = "SELECT * FROM `t_pry_proyecto_entidad` pre "
                . "LEFT JOIN T_PRY_ENTIDAD_DISTRITAL ent USING(seqEntidadDistrital) "
                . "WHERE pre.seqProyecto = 205";
        $objRes = $aptBd->getAssoc($sql);
        return $objRes;
    }

// fin validacion de borrar Proyecto
}

// Fin clase
?>