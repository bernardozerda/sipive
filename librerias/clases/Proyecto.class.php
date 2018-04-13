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
    public $seqUsuario;
    public $txtArchivo;
    public $seqPryEstadoProceso;
    public $txtNombreProyecto;
    public $numNitProyecto;
    public $txtNombrePlanParcial;
    public $txtNombreComercial;
    public $seqTipoEsquema;
    public $seqPryTipoModalidad;
    public $seqOpv;
    public $txtNombreOperador;
    public $txtObjetoProyecto;
    public $seqTipoProyecto;
    public $seqTipoUrbanizacion;
    public $seqTipoSolucion;
    public $txtDescripcionProyecto;
    public $seqLocalidad;
    public $seqBarrio;
    public $txtOtrosBarrios;
    public $bolDireccion;
    public $txtDireccion;
    public $valNumeroSoluciones;
    public $valSalarioMinimo;
    public $numSubsidios;
    public $valTorres;
    public $valAreaLote;
    public $valAreaConstruida;
    public $txtChipLote;
    public $txtMatriculaInmobiliariaLote;
    public $txtRegistroEnajenacion;
    public $fchRegistroEnajenacion;
    public $bolEquipamientoComunal;
    public $txtDescEquipamientoComunal;
    public $seqTutorProyecto;
    public $seqProyectoOferente;

    /**
     * CONSTRUCTOR DE LA CLASE
     * @author Liliana Basto
     * @param Void
     * @return Void
     * @version 2.0 Junio 2017
     */
    public function Proyecto() {
        $this->txtProyecto = "";
        $this->fchVencimiento = NULL;
        $this->bolActivo = false;
        $this->arrProyectoGrupo = array();
        $this->seqUsuario = 0;
        $this->txtArchivo = "";
        $this->seqPryEstadoProceso = 0;
        $this->txtNombreProyecto = "";
        $this->numNitProyecto = 0;
        $this->txtNombrePlanParcial = "";
        $this->txtNombreComercial = "";
        $this->seqTipoEsquema = 0;
        $this->seqPryTipoModalidad = 0;
        $this->seqOpv = 0;
        $this->txtNombreOperador = "";
        $this->txtObjetoProyecto = "";
        $this->seqTipoProyecto = 0;
        $this->seqTipoUrbanizacion = 0;
        $this->seqTipoSolucion = 0;
        $this->txtDescripcionProyecto = "";
        $this->seqLocalidad = 0;
        $this->seqBarrio = 0;
        $this->txtOtrosBarrios = "";
        $this->bolDireccion = false;
        $this->txtDireccion = "";
        $this->valNumeroSoluciones = 0;
        $this->valSalarioMinimo = 0;
        $this->numSubsidios = 0;
        $this->valTorres = 0;
        $this->valAreaLote = 0;
        $this->valAreaConstruida = 0;
        $this->txtChipLote = "";
        $this->txtMatriculaInmobiliariaLote = "";
        $this->txtRegistroEnajenacion = "";
        $this->fchRegistroEnajenacion = NULL;
        $this->bolEquipamientoComunal = FALSE;
        $this->txtDescEquipamientoComunal = "";
        $this->seqTutorProyecto = 0;
        $this->seqProyectoOferente = 0;
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
    /* public function editarProyecto($seqProyecto, $txtNombre, $fchVencimiento, $bolActivo, $seqMenu) {

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
      } */

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
                GROUP BY seqTipoActoUnidad) AS resolucion,   txtNombreProyecto, txtBarrio, TxtNombrePlanParcial, txtDireccion, txtLocalidad,  seqProyectoPadre,
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

    public function almacenarProyecto($post) {

        global $aptBd;

        foreach ($post as $nombre_campo => $valor) {
            //   echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "" && $valor == " " && trim($valor) == "") {
                if (count(explode('val', $valor)) > 0 || count(explode('NaN', $valor)) > 0 || count(explode('num', $valor)) > 0) {
                    $valor = 0;
                } else {
                    $valor = 'NULL';
                }
            } else if ($valor == null) {
                if (count(explode('val', $valor)) > 0 || count(explode('NaN', $valor)) > 0 || count(explode('num', $valor)) > 0) {
                    $valor = 0;
                } else {
                    $valor = 'NULL';
                }
                //echo "<br>" . $nombre_campo . " -> " . $valor;
            }
            $$nombre_campo = $valor;
        }
        $arrErrores = array();
        // Instruccion para insertar el Oferente en la base de datos
        $sql = "INSERT INTO t_pry_proyecto
                (   seqPryEstadoProceso,
                    txtNombreProyecto,
                    numNitProyecto,
                    txtNombrePlanParcial,
                    txtNombreComercial,
                    seqPlanGobierno,
                    seqPryTipoModalidad,
                    seqOpv,
                    txtNombreOperador,
                    txtObjetoProyecto,
                    seqTipoProyecto,
                    seqTipoUrbanizacion,
                    seqTipoSolucion,
                    txtDescripcionProyecto,
                    seqLocalidad,
                    seqBarrio,
                    txtOtrosBarrios,
                    bolDireccion,
                    txtDireccion,
                    valNumeroSoluciones, 
                    valTorres,
                    valAreaLote,
                    valAreaConstruida,
                    txtChipLote,
                    txtMatriculaInmobiliariaLote,
                    txtRegistroEnajenacion,
                    fchRegistroEnajenacion,
                    bolEquipamientoComunal,
                    txtDescEquipamientoComunal,
                    seqTutorProyecto,
                    seqConstructor,
                    txtNombreInterventor,
                    txtDireccionInterventor,
                    txtCorreoInterventor,
                    bolTipoPersonaInterventor,
                    numCedulaInterventor,
                    numTProfesionalInterventor,
                    numNitInterventor,
                    txtNombreRepLegalInterventor,
                    numTelefonoRepLegalInterventor,
                    txtDireccionRepLegalInterventor,
                    txtCorreoRepLegalInterventor,
                    valCostosDirectos,
                    valCostosIndirectos,
                    valTerreno,
                    valGastosFinancieros,
                    valGastosVentas,
                    valTotalCostos,
                    valTotalVentas,
                    valUtilidadProyecto,
                    valRecursosPropios,
                    valCreditoEntidadFinanciera,
                    valCreditoParticulares,
                    valVentasProyecto,
                    valSDVE,
                    valOtros,
                    valDevolucionIVA,
                    valTotalRecursos,                   
                    txtNombreVendedor,
                    txtCedulaCatastral,
                    txtEscritura,
                    fchEscritura,
                    numNotaria,
                    seqUsuario)
                    VALUES (
                    $seqPryEstadoProceso,
                    '$txtNombreProyecto',
                    $numNitProyecto,
                    '$txtNombrePlanParcial',
                    '$txtNombreComercial',
                    $seqPlanGobierno,
                    $seqPryTipoModalidad,
                    $seqOpv,
                    '$txtNombreOperador',
                    '$txtObjetoProyecto',
                    $seqTipoProyecto,
                    $seqTipoUrbanizacion,
                    $seqTipoSolucion,
                    '$txtDescripcionProyecto',
                    $seqLocalidad,
                    $seqBarrio,
                    '$txtOtrosBarrios',
                    $bolDireccion,
                    '$txtDireccion',
                    $valNumeroSoluciones,                   
                    $valTorres,
                    $valAreaLote,
                    $valAreaConstruida,
                    '$txtChipLote',
                    '$txtMatriculaInmobiliariaLote',
                    '$txtRegistroEnajenacion',
                    '$fchRegistroEnajenacion',
                    $bolEquipamientoComunal,
                    '$txtDescEquipamientoComunal',
                    $seqTutorProyecto,
                    $seqConstructor,
                    '$txtNombreInterventor',
                    '$txtDireccionInterventor' ,                       
                    '$txtCorreoInterventor',
                    $bolTipoPersonaInterventor,
                    $numCedulaInterventor,
                    $numTProfesionalInterventor,
                    $numNitInterventor,
                    '$txtNombreRepLegalInterventor',
                    $numTelefonoRepLegalInterventor,
                    '$txtDireccionRepLegalInterventor',
                    '$txtCorreoRepLegalInterventor',
                    $valCostosDirectos,
                    $valCostosIndirectos,
                    $valTerreno,
                    $valGastosFinancieros,
                    $valGastosVentas,
                    $valTotalCostos,
                    $valTotalVentas,
                    $valUtilidadProyecto,
                    $valRecursosPropios,
                    $valCreditoEntidadFinanciera,
                    $valCreditoParticulares,
                    $valVentasProyecto,
                    $valSDVE,
                    $valOtros,
                    $valDevolucionIVA,
                    $valTotalRecursos,                    
                    '$txtNombreVendedor',
                    '$txtCedulaCatastral',
                    '$txtEscritura',
                    '$fchEscritura',
                    $numNotaria,
                    $seqUsuario
                    ) ";
        try {
            $aptBd->execute($sql);
            //  echo "<br>" . $sql;
            $seqProyecto = $aptBd->Insert_ID();

            $band = false;
            $sqlInsOfe = "INSERT INTO t_pry_proyecto_oferente
                        (
                        seqProyecto,
                        seqOferente,
                        txtNombreContactoOferente,
                        txtCorreoOferente,
                        numTelContactoOferente,
                        bolTipoOferente)
                        VALUES";
            foreach ($seqOferente as $key => $value) {
                if ($seqProyectoOferente[$key] == 0 || $seqProyectoOferente[$key] == '' || $seqProyectoOferente[$key] == '0') {
                    $sqlInsOfe .= "(" . $seqProyecto . ", " . $value . " , '" . $txtNombreContactoOferente[$key] . "', '" . $txtCorreoOferente[$key] . "'," . $numTelContactoOferente[$key] . " , 1),";
                    $band = true;
                }
            }
            try {
                if ($band) {
                    $sqlInsOfe = substr_replace($sqlInsOfe, ';', -1, 1);
                    $aptBd->execute($sqlInsOfe);
                }
            } catch (Exception $ex) {
                pr($ex->getMessage());
            }
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido guardar el Proyecto <b>$txtNombreProyecto</b>. Reporte este error al administrador del sistema";
            pr($objError->getMessage());
        }

        return $seqProyecto;
    }

    public function obtenerDatosProyectos($seqProyecto) {

        global $aptBd;
        $sql = "SELECT * FROM  t_pry_proyecto  ";
        if ($seqProyecto > 0) {
            $sql .= " where seqProyecto = " . $seqProyecto;
        }
        $sql . " ORDER BY seqProyecto";

        $objRes = $aptBd->execute($sql);
        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function editarProyecto($post) {
        global $aptBd;

        foreach ($post as $nombre_campo => $valor) {
            //echo $asignacion = "\$" . $nombre_campo . "='" . $valor . "';<br>";
            if ($valor == "" && $valor == " " && trim($valor) == "") {
                if (count(explode('var', $valor)) > 0 || count(explode('NaN', $valor)) > 0 || count(explode('num', $valor)) > 0) {
                    $valor = 0;
                } else {
                    $valor = 'null';
                }
            } else if ($valor == null) {
                if (count(explode('var', $valor)) > 0 || count(explode('NaN', $valor)) > 0 || count(explode('num', $valor)) > 0) {
                    $valor = 0;
                } else {
                    $valor = 'null';
                }
                //  echo "<br>" . $nombre_campo . " -> " . $valor;
            }
            $$nombre_campo = $valor;
        }
        $arrErrores = array();

        // Consulta para hacer la actualizacion
        $sql = "
                UPDATE t_pry_proyecto
                    SET                    
                        txtNombreProyecto = \"" . ereg_replace('\"', "", $txtNombreProyecto) . "\", 
                        numNitProyecto = " . $numNitProyecto . ",
                        txtNombrePlanParcial = '" . $txtNombrePlanParcial . "',
                        txtNombreComercial = '" . $txtNombreComercial . "',  
                        seqPlanGobierno = " . $seqPlanGobierno . ",
                        seqPryTipoModalidad = " . $seqPryTipoModalidad . ",
                        seqOpv = " . $seqOpv . ",
                        txtNombreOperador = '" . $txtNombreOperador . "',
                        txtObjetoProyecto  = '" . $txtObjetoProyecto . "',
                        seqTipoProyecto = " . $seqTipoProyecto . ",
                        seqTipoUrbanizacion = " . $seqTipoUrbanizacion . ",
                        seqTipoSolucion = " . $seqTipoSolucion . ",
                        txtDescripcionProyecto = '" . $txtDescripcionProyecto . "',
                        seqLocalidad = " . $seqLocalidad . ",
                        seqBarrio = " . $seqBarrio . ",
                        txtOtrosBarrios  = '" . $txtOtrosBarrios . "',
                        bolDireccion = " . $bolDireccion . ",
                        txtDireccion  = '" . $txtDireccion . "',
                        valNumeroSoluciones = " . $valNumeroSoluciones . ", 
                        valTorres = " . $valTorres . ",
                        valAreaLote = " . $valAreaLote . ",
                        valAreaConstruida = " . $valAreaConstruida . ",
                        txtChipLote  = '" . $txtChipLote . "',
                        txtMatriculaInmobiliariaLote  = '" . $txtMatriculaInmobiliariaLote . "',
                        txtRegistroEnajenacion  = '" . $txtRegistroEnajenacion . "',
                        fchRegistroEnajenacion  = '" . $fchRegistroEnajenacion . "',
                        bolEquipamientoComunal = " . $bolEquipamientoComunal . ",
                        txtDescEquipamientoComunal  = '" . $txtDescEquipamientoComunal . "',
                        seqTutorProyecto = " . $seqTutorProyecto . " ,
                        seqConstructor = " . $seqConstructor . ",
                        txtNombreInterventor = '" . $txtNombreInterventor . "',                                
                        txtDireccionInterventor = '" . $txtDireccionInterventor . "' ,   
                        txtCorreoInterventor = 	'" . $txtCorreoInterventor . "' , 
                        bolTipoPersonaInterventor = " . $bolTipoPersonaInterventor . ",
                        numCedulaInterventor = 	" . $numCedulaInterventor . ",
                        numTProfesionalInterventor =" . $numTProfesionalInterventor . ",
                        numNitInterventor =" . $numNitInterventor . ",
                        txtNombreRepLegalInterventor = '" . $txtNombreRepLegalInterventor . "' , 
                        numTelefonoRepLegalInterventor =" . $numTelefonoRepLegalInterventor . ",
                        txtDireccionRepLegalInterventor = '" . $txtDireccionRepLegalInterventor . "' , 
                        txtCorreoRepLegalInterventor = '" . $txtCorreoRepLegalInterventor . "', 
                        valCostosDirectos = " . $valCostosDirectos . ",
                        valCostosIndirectos = " . $valCostosIndirectos . ",
                        valTerreno = " . $valTerreno . ",
                        valGastosFinancieros = " . $valGastosFinancieros . ",
                        valGastosVentas = " . $valGastosVentas . ",
                        valTotalCostos = " . $valTotalCostos . ",
                        valTotalVentas = " . $valTotalVentas . ",
                        valUtilidadProyecto = " . $valUtilidadProyecto . ",
                        valRecursosPropios = " . $valRecursosPropios . ",
                        valCreditoEntidadFinanciera = " . $valCreditoEntidadFinanciera . ",
                        valCreditoParticulares = " . $valCreditoParticulares . ",
                        valVentasProyecto = " . $valVentasProyecto . ",
                        valSDVE = " . $valSDVE . ",
                        valOtros = " . $valOtros . ",
                        valDevolucionIVA = " . $valDevolucionIVA . ",
                        valTotalRecursos = " . $valTotalRecursos . ",                      
                        txtNombreVendedor = '$txtNombreVendedor',
                        txtCedulaCatastral = '$txtCedulaCatastral',
                        txtEscritura = '$txtEscritura',
                        fchEscritura = '$fchEscritura',
                        numNotaria = $numNotaria
                        WHERE seqProyecto = $seqProyecto
            ";
        //echo  $sql; //die();

        try {
            $band = false;
            $aptBd->execute($sql);
            $sqlOf = "select * from t_pry_proyecto_oferente where seqProyecto = " . $seqProyecto;
            $rs = $aptBd->execute($sqlOf);
            $rows = $rs->RecordCount();
            $sqlInsOfe = "INSERT INTO t_pry_proyecto_oferente
                        (
                        seqProyecto,
                        seqOferente,
                        txtNombreContactoOferente,
                        txtCorreoOferente,
                        numTelContactoOferente,
                        bolTipoOferente)
                        VALUES";
            $arrayOferentes = count($seqOferente);
            $cont = $rows - $arrayOferentes;
            $arraDelete = "";

            foreach ($seqOferente as $key => $value) {
                if ($seqProyectoOferente[$key] == 0 || $seqProyectoOferente[$key] == '' || $seqProyectoOferente[$key] == '0') {
                    $sqlInsOfe .= "(" . $seqProyecto . ", " . $value . ", '" . $txtNombreContactoOferente[$key] . "','" . $txtCorreoOferente[$key] . "','" . $numTelContactoOferente[$key] . "', 1),";
                    $band = true;
                } else {
                    if ($seqProyectoOferente[$key] != "") {
                        $sqlOfUpd = "UPDATE t_pry_proyecto_oferente SET
                                seqProyecto = $seqProyecto,
                                seqOferente = $value,
                                txtNombreContactoOferente = '$txtNombreContactoOferente[$key]',
                                txtCorreoOferente = '$txtCorreoOferente[$key]',
                                numTelContactoOferente = $numTelContactoOferente[$key],
                                bolTipoOferente = 1
                                WHERE seqProyectoOferente = $seqProyectoOferente[$key];";
                        $aptBd->execute($sqlOfUpd);
                        $arraDelete .= $seqProyectoOferente[$key] . ",";
                    }
                }
            }
            if ($cont > 0) {
                $arraDelete = substr_replace($arraDelete, '', -1, 1);
                $sqlDel = "DELETE FROM t_pry_proyecto_oferente WHERE seqProyecto = " . $seqProyecto . " AND seqProyectoOferente NOT IN (" . $arraDelete . ");";
                $aptBd->execute($sqlDel);
            }
            if ($band) {
                $sqlInsOfe = substr_replace($sqlInsOfe, ';', -1, 1);
                $aptBd->execute($sqlInsOfe);
            }
        } catch (Exception $objError) {
            pr($objError->getMessage());
            //$arrOferente = $this->cargarOferente($seqOferente);
            $arrErrores[] = "No se ha podido editar el Oferente <b>" . $arrOferente[$seqOferente]->txtNombreOferente . "</b>. Reporte este error al administrador del sistema";
        }

        return $arrErrores;
    }

    public function obtenerListaDocumentos($seqProyecto, $cant) {
        global $aptBd;

        $sql = "select * from t_pry_documentos";

        if ($seqProyecto > 0 && $cant > 0) {
            $sql .= " left join t_pry_proyecto_documentos using(seqDocumento) where seqProyecto = " . $seqProyecto;
        }
        $sql . " ORDER BY seqDocumento";

        $objRes = $aptBd->execute($sql);

        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function almacenarDocumentos($seqProyecto, $arraydoc, $arraDocAdd) {

        global $aptBd;

        $arrErrores = array();
        $sql = "INSERT INTO t_pry_proyecto_documentos
                (txtNombreArchivo, bolEstado, seqProyecto, seqDocumento) VALUES";
        foreach ($arraydoc as $key => $value) {
            $val = 0;
            if ($arraDocAdd[$key] != "") {
                $val = 1;
            }
            $sql .= "  ('NULL', " . $val . ", " . $seqProyecto . ", " . $value . "),";
        }
        $sql = substr_replace($sql, ';', -1, 1);

        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar los archivos<b></b>";
            pr($objError->getMessage());
        }
        return $arrErrores;
    }

    public function modificarDocumentos($seqProyecto, $arraydoc, $arraDocAdd, $cant) {
        global $aptBd;

        $arrErrores = array();
        $documentos = $this->obtenerListaDocumentos($seqProyecto, $cant);
        $sqlUp = "UPDATE t_pry_proyecto_documentos SET bolEstado = CASE";
        $seqDocs;
        foreach ($documentos as $key => $value) {
            $val = 0;
            if ($value['seqDocumento'] == $arraydoc[$key + 1]) {
                if ($arraDocAdd[$key + 1] != "") {
                    $val = 1;
                }
                $seqDocs .= $value['seqDocumento'] . ",";
                $sqlUp .= " WHEN seqDocumento = " . $value['seqDocumento'] . " THEN " . $val;
            }
            //  echo "<br>*** valor " . $value['seqDocumento'] . " key -> " . $key . " valueDoc -> " . $arraydoc[$key + 1] . " arraDocAdd -> " . $arraDocAdd[$key + 1];
        }
        $seqDocs = substr_replace($seqDocs, '', -1, 1);
        $sqlUp .= " ELSE bolEstado END WHERE seqDocumento IN (" . $seqDocs . ")";

        try {
            $aptBd->execute($sqlUp);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar los archivos<b></b>";
            pr($objError->getMessage());
        }
        return $arrErrores;
    }

    public function almacenarLicencias($seqProyecto, $txtLicencia, $txtExpideLicencia, $seqTipoLicencia, $fchLicencia, $fchVigenciaLicencia, $fchEjecutoriaLicencia, $txtResEjecutoria, $fchLicenciaProrroga, $fchLicenciaProrroga1, $fchLicenciaProrroga2) {
        global $aptBd;
        $arrErrores = array();
        $sql = "INSERT INTO t_pry_proyecto_licencias (txtLicencia, txtExpideLicencia, fchLicencia, fchVigenciaLicencia, fchEjecutoriaLicencia, txtResEjecutoria, seqTipoLicencia,  fchLicenciaProrroga, fchLicenciaProrroga1, fchLicenciaProrroga2, seqProyecto) VALUES";
        foreach ($seqTipoLicencia as $key => $value) {
            $sqlLicencia .= "('" . $txtLicencia[$key] . "', '" . $txtExpideLicencia[$key] . "', '" . $fchLicencia[$key] . "', '" . $fchVigenciaLicencia[$key] . "', '" . $fchEjecutoriaLicencia[$key] . "', '" . $txtResEjecutoria[$key] . "', " . $value . ", '" . $fchLicenciaProrroga[$key] . "', '" . $fchLicenciaProrroga1[$key] . "', '" . $fchLicenciaProrroga2[$key] . "'," . $seqProyecto . "),";
        }
        $sqlLicencia = substr_replace($sqlLicencia, ';', -1, 1);
        $sql .= $sqlLicencia;
        //echo $sql;
        try {
            $aptBd->execute($sql);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar las Licencias<b></b>";
            pr($objError->getMessage());
        }
        return $arrErrores;
    }

    public function obtenerListaLicencias($seqProyecto) {
        global $aptBd;
        $sql = "select * from t_pry_proyecto_licencias where seqProyecto = " . $seqProyecto . " ORDER BY seqTipoLicencia";
        $objRes = $aptBd->execute($sql);

        $datos = Array();
        while ($objRes->fields) {
            $datos[] = $objRes->fields;
            $objRes->MoveNext();
        }
        return $datos;
    }

    public function modificarLicencias($seqProyecto, $seqProyectoLicencia, $txtLicencia, $txtExpideLicencia, $seqTipoLicencia, $fchLicencia, $fchVigenciaLicencia, $fchEjecutoriaLicencia, $txtResEjecutoria, $fchLicenciaProrroga, $fchLicenciaProrroga1, $fchLicenciaProrroga2) {
        global $aptBd;
        $arrErrores = array();
        foreach ($seqProyectoLicencia as $key => $value) {
            $sql = 'UPDATE t_pry_proyecto_licencias
            SET            
            txtLicencia = "' . $txtLicencia[$key] . '",
            txtExpideLicencia = "' . $txtExpideLicencia[$key] . '",
            fchLicencia ="' . $fchLicencia[$key] . '",
            fchVigenciaLicencia = "' . $fchVigenciaLicencia[$key] . '",
            fchLicenciaProrroga = "' . $fchLicenciaProrroga[$key] . '",
            fchLicenciaProrroga1 = "' . $fchLicenciaProrroga1[$key] . '",
            fchLicenciaProrroga2 = "' . $fchLicenciaProrroga2[$key] . '",
            fchEjecutoriaLicencia ="' . $fchEjecutoriaLicencia[$key] . '",
            txtResEjecutoria = "' . $txtResEjecutoria[$key] . '"  
            WHERE seqProyectoLicencia = ' . $value . ' and seqProyecto = "' . $seqProyecto . '" and seqTipoLicencia = "' . $seqTipoLicencia[$key] . '";';
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido cargar las licencias<b></b>";
                pr($objError->getMessage());
            }
        }
        return $arrErrores;
    }

    function almacenarConjuntos($seqProyecto, $arrayConjuntos, $cant) {

        global $aptBd;
        $arrErrores = array();
        $query = "INSERT INTO T_PRY_PROYECTO (
                txtNombreProyecto,
                txtNombreComercial,
                seqProyectoPadre,
                txtDireccion,
                valNumeroSoluciones,
                txtMatriculaInmobiliariaLote,
                txtChipLote,
                txtLicenciaUrbanismo,
                fchLicenciaUrbanismo1,
                fchVigenciaLicenciaUrbanismo,
                txtExpideLicenciaUrbanismo,
                txtLicenciaConstruccion,
                fchLicenciaConstruccion1,
                fchVigenciaLicenciaConstruccion,
                txtNombreVendedor,
                numNitVendedor,
                txtCedulaCatastral,
                txtEscritura,
                fchEscritura,
                numNotaria,
                seqTutorProyecto,
                seqPryEstadoProceso,
                fchInscripcion,
                fchUltimaActualizacion,
                seqUsuario) 
            VALUES";
        for ($index = 0; $index < $cant; $index++) {
            $txtNombreProyectoHijo = '';
            foreach ($arrayConjuntos[$seqProyecto] as $key => $value) {
                $$key = $value[($index)];
            }
            //if ($txtNombreProyectoHijo != "") {
            $query .= "(
                        '$txtNombreProyectoHijo', 
                        '$txtNombreComercialHijo',
                        '$seqProyecto',
                        '$txtDireccionHijo',
                        '$valNumeroSolucionesHijo',
                        '$txtMatriculaInmobiliariaLoteHijo',
                        '$txtChipLoteHijo',
                        '$txtLicenciaUrbanismoHijo',
                        '$fchLicenciaUrbanismo1Hijo',
                        '$fchVigenciaLicenciaUrbanismoHijo',
                        '$txtExpideLicenciaUrbanismoHijo',
                        '$txtLicenciaConstruccionHijo',
                        '$fchLicenciaConstruccion1Hijo',
                        '$fchVigenciaLicenciaConstruccionHijo',
                        '$txtNombreVendedorHijo',
                        '$numNitVendedorHijo',
                        '$txtCedulaCatastralHijo',
                        '$txtEscrituraHijo',
                        '$fchEscrituraHijo',
                        $numNotariaHijo,
                        '$seqTutorProyecto',
                        '2',
                        '$fchGestion',
                        '$fchGestion',
                        " . $_SESSION['seqUsuario'] . "),";
            // }
        }
        $query = substr_replace($query, ';', -1, 1);
        // echo "<br>" . $query . "<br>";
        try {
            $aptBd->execute($query);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar las licencias<b></b>";
            pr($objError->getMessage());
        }
    }

    function modificarConjuntos($seqProyecto, $arrayConjuntos, $cant) {

        global $aptBd;
        $arrErrores = array();
        $sqlExistentes = "SELECT seqProyecto FROM T_PRY_PROYECTO WHERE seqProyectoPadre = $seqProyecto";
        $exeExistentes = $aptBd->execute($sqlExistentes);
        //$exeExistentes->numRows() . "->" . $cant;
        $datos = Array();
        $datosDiff = Array();
        while ($exeExistentes->fields) {
            $datos[] = $exeExistentes->fields['seqProyecto'];
            $exeExistentes->MoveNext();
        }
        for ($index = 0; $index < $cant; $index++) {
            $txtNombreProyectoHijo = '';
            foreach ($arrayConjuntos[$seqProyecto] as $key => $value) {
                $$key = $value[($index)];
            }
            $datosDiff[] = $seqProyectoHijo;

            if (in_array($seqProyectoHijo, $datos)) {
                $query = "UPDATE T_PRY_PROYECTO 
                    SET txtNombreProyecto = '$txtNombreProyectoHijo',
                        txtNombreComercial = '$txtNombreComercialHijo',
                        seqProyectoPadre = '$seqProyecto',
                        txtDireccion = '$txtDireccionHijo',
                        valNumeroSoluciones = '$valNumeroSolucionesHijo',
                        txtChipLote = '$txtChipLoteHijo',
                        txtMatriculaInmobiliariaLote = '$txtMatriculaInmobiliariaLoteHijo',
                        txtLicenciaUrbanismo = '$txtLicenciaUrbanismoHijo',
                        fchLicenciaUrbanismo1 = '$fchLicenciaUrbanismo1Hijo',
                        fchVigenciaLicenciaUrbanismo = '$fchVigenciaLicenciaUrbanismoHijo',
                        txtExpideLicenciaUrbanismo = '$txtExpideLicenciaUrbanismoHijo',
                        txtLicenciaConstruccion = '$txtLicenciaConstruccionHijo',
                        fchLicenciaConstruccion1 = '$fchLicenciaConstruccion1Hijo',
                        fchVigenciaLicenciaConstruccion = '$fchVigenciaLicenciaConstruccionHijo',
                        txtNombreVendedor = '$txtNombreVendedorHijo',
                        numNitVendedor = '$numNitVendedorHijo',
                        txtCedulaCatastral = '$txtCedulaCatastralHijo',
                        txtEscritura = '$txtEscrituraHijo',
                        fchEscritura = '$fchEscrituraHijo',
                        numNotaria = '$numNotariaHijo',
                        seqTutorProyecto = '$seqTutorProyecto', 
                        fchUltimaActualizacion = '$fchGestion', 
                        seqUsuario = " . $_SESSION['seqUsuario'] . " 
                    WHERE seqProyecto = $seqProyectoHijo;";
            } else if ($cant >= $exeExistentes->numRows()) {
                $query = "INSERT INTO T_PRY_PROYECTO (
                            txtNombreProyecto,
                            txtNombreComercial,
                            seqProyectoPadre,
                            txtDireccion,
                            valNumeroSoluciones,
                            txtMatriculaInmobiliariaLote,
                            txtChipLote,
                            txtLicenciaUrbanismo,
                            fchLicenciaUrbanismo1,
                            fchVigenciaLicenciaUrbanismo,
                            txtExpideLicenciaUrbanismo,
                            txtLicenciaConstruccion,
                            fchLicenciaConstruccion1,
                            fchVigenciaLicenciaConstruccion,
                            txtNombreVendedor,
                            numNitVendedor,
                            txtCedulaCatastral,
                            txtEscritura,
                            fchEscritura,
                            numNotaria,
                            seqTutorProyecto,
                            seqPryEstadoProceso,
                            fchInscripcion,
                            fchUltimaActualizacion,
                            seqUsuario) 
            VALUES (
                        '$txtNombreProyectoHijo', 
                        '$txtNombreComercialHijo',
                        '$seqProyecto',
                        '$txtDireccionHijo',
                        $valNumeroSolucionesHijo,
                        '$txtMatriculaInmobiliariaLoteHijo',
                        '$txtChipLoteHijo',
                        '$txtLicenciaUrbanismoHijo',
                        '$fchLicenciaUrbanismo1Hijo',
                        '$fchVigenciaLicenciaUrbanismoHijo',
                        '$txtExpideLicenciaUrbanismoHijo',
                        '$txtLicenciaConstruccionHijo',
                        '$fchLicenciaConstruccion1Hijo',
                        '$fchVigenciaLicenciaConstruccionHijo',
                        '$txtNombreVendedorHijo',
                        '$numNitVendedorHijo',
                        '$txtCedulaCatastralHijo',
                        '$txtEscrituraHijo',
                        '$fchEscrituraHijo',
                        $numNotariaHijo,
                        '$seqTutorProyecto',
                        '2',
                        '$fchGestion',
                        '$fchGestion',
                        " . $_SESSION['seqUsuario'] . ")";
            }
            // echo "<br><br>" . $query;
            try {
                $aptBd->execute($query);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido cargar las licencias<b></b>";
                pr($objError->getMessage());
            }
        }
        if ($cant < $exeExistentes->numRows()) {
            $resultado = array_diff($datos, $datosDiff);
            $delete = "";
            foreach ($resultado as $value) {
                $delete .= $value . ",";
            }
            //  print_r($resultado);
            $delete = substr_replace($delete, '', -1, 1);
            $sql = "DELETE FROM T_PRY_PROYECTO WHERE seqProyecto in (" . $delete . ")";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido eliminar conjunto<b></b>";
                pr($objError->getMessage());
            }
        }
    }

// fin validacion de borrar Proyecto

    function almacenarTipoVivienda($seqProyecto, $arrayConjuntos, $cant) {

        global $aptBd;
        $arrErrores = array();
        $query = "INSERT INTO t_pry_tipo_vivienda
                  (
                    txtNombreTipoVivienda,
                    numCantidad,
                    numArea,
                    numAnoVenta,
                    valPrecioVenta,
                    txtDescripcion,
                    valCierre,
                    seqProyecto,
                    fchGestion)
                    VALUES";
        for ($index = 0; $index < $cant; $index++) {
            $txtNombreProyectoHijo = '';
            foreach ($arrayConjuntos[$seqProyecto] as $key => $value) {
                if (count($value) > 1) {
                    $$key = $value[($index)];
                } else {
                    $$key = $value;
                }

                // echo "<br>***".$value[($index)]."***<br>";
            }
            //if ($txtNombreProyectoHijo != "") {
            $query .= "(
                        '$txtNombreTipoVivienda',
                        $numCantidad,
                        $numArea,
                        $numAnoVenta,
                        $valPrecioVenta,
                        '$txtDescripcion',
                        $valCierre,
                        $seqProyecto,
                        '$fchGestion'),";
            // }
        }
        $query = substr_replace($query, ';', -1, 1);
        // echo "<br>" . $query . "<br>";
        try {
            $aptBd->execute($query);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar las los tipo de vivienda<b></b>";
            pr($objError->getMessage());
        }
    }

    function modificarTipoVivienda($seqProyecto, $array, $cant) {

        global $aptBd;
        $arrErrores = array();
        $sqlExistentes = "SELECT seqTipoVivienda FROM T_PRY_TIPO_VIVIENDA WHERE seqProyecto = $seqProyecto";
        $exeExistentes = $aptBd->execute($sqlExistentes);
        //$cant = $exeExistentes->numRows();
        $datos = Array();
        $datosDiff = Array();
        while ($exeExistentes->fields) {
            $datos[] = $exeExistentes->fields['seqTipoVivienda'];
            $exeExistentes->MoveNext();
        }
        for ($index = 0; $index < $cant; $index++) {
            $txtNombreProyectoHijo = '';
            foreach ($array[$seqProyecto] as $key => $value) {
                $$key = $value[($index)];
            }
            $datosDiff[] = $seqTipoVivienda;

            if (in_array($seqTipoVivienda, $datos)) {
                $query = "UPDATE T_PRY_TIPO_VIVIENDA 
                    SET 
                    txtNombreTipoVivienda = '$txtNombreTipoVivienda',
                       numCantidad = '$numCantidad', "
                        . "numArea = '$numArea', "
                        . "numAnoVenta = '$numAnoVenta', "
                        . "valPrecioVenta = '$valPrecioVenta', "
                        . "txtDescripcion = '$txtDescripcion', "
                        . "valCierre = '$valCierre', "
                        . "fchGestion = '$fchGestion' "
                        . "WHERE seqTipoVivienda = $seqTipoVivienda "
                        . "AND seqProyecto = $seqProyecto; ";
            } else if ($cant >= $exeExistentes->numRows()) {
                $arrayTipoVivienda = Array();
                $arrayTipoVivienda[$seqProyecto]['seqTipoVivienda'] = $seqTipoVivienda;
                $arrayTipoVivienda[$seqProyecto]['txtNombreTipoVivienda'] = $txtNombreTipoVivienda;
                $arrayTipoVivienda[$seqProyecto]['numCantidad'] = $numCantidad;
                $arrayTipoVivienda[$seqProyecto]['numArea'] = $numArea;
                $arrayTipoVivienda[$seqProyecto]['numAnoVenta'] = $numAnoVenta;
                $arrayTipoVivienda[$seqProyecto]['valPrecioVenta'] = $valPrecioVenta;
                $arrayTipoVivienda[$seqProyecto]['valCierre'] = $valCierre;
                $arrayTipoVivienda[$seqProyecto]['txtDescripcion'] = $txtDescripcion;
                $this->almacenarTipoVivienda($seqProyecto, $arrayTipoVivienda, count($arrayTipoVivienda));
            }
            // echo "<br><br>" . $query;
            try {
                $aptBd->execute($query);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido cargar las licencias<b></b>";
                pr($objError->getMessage());
            }
        }
        if ($cant < $exeExistentes->numRows()) {
            $resultado = array_diff($datos, $datosDiff);
            $delete = "";
            foreach ($resultado as $value) {
                $delete .= $value . ",";
            }
            //  print_r($resultado);
            $delete = substr_replace($delete, '', -1, 1);
            $sql = "DELETE FROM T_PRY_TIPO_VIVIENDA WHERE seqTipoVivienda in (" . $delete . ")";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido eliminar conjunto<b></b>";
                pr($objError->getMessage());
            }
        }
    }

    function almacenarCronograma($seqProyecto, $arrayCronograma, $cant) {
        // var_dump($arrayCronograma);
        global $aptBd;
        $arrErrores = array();
        $query = "INSERT INTO t_pry_cronograma_fechas
                (
                    numActaDescriptiva,
                    numAnoActaDescriptiva,
                    fchInicialProyecto,
                    fchFinalProyecto,
                    valPlazoEjecucion,
                    fchInicialEntrega,
                    fchFinalEntrega,
                    fchInicialEscrituracion,
                    fchFinalEscrituracion,
                    seqProyecto,
                    fchGestion)
                    VALUES";
        for ($index = 0; $index < $cant; $index++) {

            foreach ($arrayCronograma[$seqProyecto] as $key => $value) {
                //echo "<p>".count($value)."</p>";
                if (count($value) > 1) {
                    $$key = $value[($index)];
                } else {
                    $$key = $value;
                }

                //echo "<br>***".$value[($index)]."***<br>";
            }

            $query .= "(
                            $numActaDescriptiva,
                            $numAnoActaDescriptiva,
                            '$fchInicialProyecto',
                            '$fchFinalProyecto',
                            $valPlazoEjecucion,
                            '$fchInicialEntrega',
                            '$fchFinalEntrega',
                            '$fchInicialEscrituracion',
                            '$fchFinalEscrituracion',
                            $seqProyecto,
                            '$fchGestion'),";
            // }
        }
        $query = substr_replace($query, ';', -1, 1);
        // echo "<br>" . $query . "<br>";
        try {
            $aptBd->execute($query);
        } catch (Exception $objError) {
            $arrErrores[] = "No se ha podido cargar el cronograma<b></b>";
            pr($objError->getMessage());
        }
    }

    function modificarCronograma($seqProyecto, $array, $cant) {

        global $aptBd;
        $arrErrores = array();
        $sqlExistentes = "SELECT seqCronogramaFecha FROM t_pry_cronograma_fechas WHERE seqProyecto = $seqProyecto";
        $exeExistentes = $aptBd->execute($sqlExistentes);
        //$cant = $exeExistentes->numRows();
        //echo "<p>".$exeExistentes->numRows()."</p>";
        $datos = Array();
        $datosDiff = Array();
        while ($exeExistentes->fields) {
            $datos[] = $exeExistentes->fields['seqCronogramaFecha'];
            $exeExistentes->MoveNext();
        }
        for ($index = 0; $index < $cant; $index++) {

            foreach ($array[$seqProyecto] as $key => $value) {
               $$key = $value[($index)];
                //echo "<br>".$key;
            }
          //  echo "<br> seqCronogramaFecha -> ".$seqCronogramaFecha;
            $datosDiff[] = $seqCronogramaFecha;

            if (in_array($seqCronogramaFecha, $datos)) {
                $query = "UPDATE t_pry_cronograma_fechas
                        SET
                        numActaDescriptiva = $numActaDescriptiva,
                        numAnoActaDescriptiva = $numAnoActaDescriptiva,
                        fchInicialProyecto = '$fchInicialProyecto',
                        fchFinalProyecto = '$fchFinalProyecto',
                        valPlazoEjecucion = $valPlazoEjecucion,
                        fchInicialEntrega = '$fchInicialEntrega',
                        fchFinalEntrega = '$fchFinalEntrega',
                        fchInicialEscrituracion = '$fchInicialEscrituracion',
                        fchFinalEscrituracion = '$fchFinalEscrituracion',                        
                        fchGestion = '$fchGestion'
                        WHERE seqCronogramaFecha = $seqCronogramaFecha "
                        . "AND seqProyecto = $seqProyecto;";
            } else if ($cant >=  $exeExistentes->numRows()) {
                $arraycronograma = Array();
                $arraycronograma[$seqProyecto]['seqCronogramaFecha'] = $seqCronogramaFecha;
                $arraycronograma[$seqProyecto]['numActaDescriptiva'] = $numActaDescriptiva;
                $arraycronograma[$seqProyecto]['numAnoActaDescriptiva'] = $numAnoActaDescriptiva;
                $arraycronograma[$seqProyecto]['fchInicialProyecto'] = $fchInicialProyecto;
                $arraycronograma[$seqProyecto]['fchFinalProyecto'] = $fchFinalProyecto;
                $arraycronograma[$seqProyecto]['valPlazoEjecucion'] = $valPlazoEjecucion;
                $arraycronograma[$seqProyecto]['fchInicialEntrega'] = $fchInicialEntrega;
                $arraycronograma[$seqProyecto]['fchFinalEntrega'] = $fchFinalEntrega;
                $arraycronograma[$seqProyecto]['fchInicialEscrituracion'] = $fchInicialEscrituracion;
                $arraycronograma[$seqProyecto]['fchFinalEscrituracion'] = $fchFinalEscrituracion;
                $this->almacenarCronograma($seqProyecto, $arraycronograma, count($arraycronograma));
            }
            //echo "<br><br>" . $query;
            try {
                $aptBd->execute($query);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido cargar las licencias<b></b>";
                pr($objError->getMessage());
            }
        }
        if ($cant < $exeExistentes->numRows()) {
            $resultado = array_diff($datos, $datosDiff);
            $delete = "";
            foreach ($resultado as $value) {
                $delete .= $value . ",";
            }
            //  print_r($resultado);
            $delete = substr_replace($delete, '', -1, 1);
            $sql = "DELETE FROM t_pry_cronograma_fechas WHERE seqCronogramaFecha in (" . $delete . ")";
            try {
                $aptBd->execute($sql);
            } catch (Exception $objError) {
                $arrErrores[] = "No se ha podido eliminar Cronograma<b></b>";
                pr($objError->getMessage());
            }
        }
    }

}

// Fin clase
?>