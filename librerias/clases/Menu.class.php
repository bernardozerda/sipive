<?php

/**
 * CLASE QUE REALIZA TODAS LAS OPERACIONES 
 * DE CREACION Y EDICION DE LAS OPCIONES DE MENU
 * @author Bernardo Zerda
 * @version 1.0 abril 2009
 * @version 1.1 Junio 2018
 */
class Menu {

    public $txtEspanol;     // Etiqueta del menu en espa�ol
    public $txtIngles;      // Etigueta del menu en ingles
    public $txtCodigo;      // nombre del archivo php que atiende esta opcion de menu, no debe llevar la extension php ( nombre sin el .php )
    public $numOrden;       // Orden de aparicion en las opciones de menu
    public $txtAyuda;       // texto de la ayuda en linea
    public $seqPadre;
    public $arrGrupo;       // grupos que estan autorizados para ver el menu [seqProyecto][seqGrupo] = seqProyectoGrupo
    public $arrErrores;
    public $arrMensajes;

    /**
     * CONSTRUCTOR DE LA CLASE
     * @author Bernardo Zerda
     * @param Void
     * @return Void
     * @version 1.0 abril 2009
     */

    public function __construct() {
        $this->txtEspanol = "";
        $this->txtIngles = "";
        $this->txtCodigo = "";
        $this->numOrden = "";
        $this->txtAyuda = "";
        $this->seqPadre = "";
        $this->arrGrupo = array();
        $this->arrErrores = "";
        $this->arrMensajes = "";
    }

    /**
     * ALMACENA LAS OPCIONES DEL MENU
     * @author Bernardo Zerda
     * @param string txtEspanol
     * @param string txtIngles
     * @param string txtCodigo
     * @param arrGrupos
     * @version 1.0 Abril 2009
     */
    public function guardarMenu($txtEspanol, $txtIngles, $txtCodigo, $numOrden, $seqMenuPadre, $seqProyecto, $arrGrupos) {

        global $aptBd;
        $arrErrores = array();

        // Construye el objeto con las opciones que vienen del post
        $objMenu = new Menu;
        $objMenu->txtEspanol = $txtEspanol;
        $objMenu->txtIngles = $txtIngles;
        $objMenu->txtCodigo = $txtCodigo;
        $objMenu->numOrden = $numOrden;
        $objMenu->seqPadre = $seqMenuPadre;
        $objMenu->arrGrupo = $arrGrupos;

        // Obteniendo las opciones del mismo nivel se puede ordenar de nuevo el menu
        $arrHermanos = $this->obtenerHijos($seqProyecto, $seqMenuPadre);

        // Arreglando las opciones para insertar / editar el orden del menu
        $arrMenuOrdenado = array();
        if (!empty($arrHermanos)) {
            foreach ($arrHermanos as $seqHermano => $objHermano) {
                if ($objHermano->numOrden < $objMenu->numOrden) {
                    $arrMenuOrdenado[$seqHermano] = $objHermano;
                } else {
                    $objHermano->numOrden++;
                    $arrMenuOrdenado[$seqHermano] = $objHermano;
                }
            }
        }

        $arrMenuOrdenado[0] = $objMenu; // inserta la nueva opcion

        foreach ($arrMenuOrdenado as $seqMenu => $objMenu) {

            // si el seqMenu es cero es porque es la nueva opcion
            // si no es porque hay que alterar el orden de esa opcion
            if ($seqMenu == 0) {

                $sql = " 
                        INSERT INTO T_COR_MENU (
                            txtMenuEs, 
                            txtMenuEn, 
                            txtCodigo, 
                            seqMenuPadre, 
                            numOrden
                        ) VALUES (
                            \"" . $objMenu->txtEspanol . "\", 
                            \"" . $objMenu->txtIngles . "\", 
                            \"" . $objMenu->txtCodigo . "\", 
                            " . $objMenu->seqPadre . ", 
                            " . $objMenu->numOrden . "
                        ) 
                    ";

                try {
                    $aptBd->execute($sql);
                    $seqMenu = $aptBd->Insert_ID();
                } catch (Exception $objError) {
                    $seqMenu = 0;
                    $arrErrores[] = "No se ha podido insertar la opcion de menu <b>" . $objMenu->txtEspanol . "</b>, reporte este error al administrador";
                }

                // Almacena las relaciones de los menus con los grupos
                if (empty($arrErrores)) {

                    foreach ($objMenu->arrGrupo as $seqProyecto => $arrGrupoProyecto) {
                        foreach ($arrGrupoProyecto as $seqGrupo => $seqProyectoGrupo) {

                            $sql = "
	                                INSERT INTO T_COR_PERMISO (
	                                    seqMenu, 
	                                    seqProyectoGrupo
	                                ) VALUES (
	                                    $seqMenu, 
	                                    $seqProyectoGrupo
	                                )
	                            ";

                            // si algo asle mal retrocede las acciones
                            try {
                                $aptBd->execute($sql);
                            } catch (Exception $objError) {
                                $arrErrores[] = "No se ha podido asociar la opcion de menu <b>" . $objMenu->txtEspanol . "</b> a los grupos seleccionados, reporte este error al administrador";

                                $sql = "
	                                    DELETE 
	                                    FROM T_COR_MENU
	                                    WHERE seqMenu = $seqMenu
	                                ";

                                try {
                                    $aptBd->execute($sql);
                                } catch (Exception $objError) {
                                    $arrErrores[] = "No se ha podido revertir la accion fallida de creacion de opciones de menu, reporte este error al administrador";
                                }
                            }
                        }
                    }
                }
            } else { // actualiza el orden de la opcione de menu
                $sql = "
                        UPDATE T_COR_MENU SET
                            numOrden = " . $objMenu->numOrden . "
                        WHERE seqMenu = $seqMenu
                    ";

                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido actualizar el orden del menu, reporte este error al administrador";
                }
            }
        } // fin foreach opcines de menu ordenadas

        return $arrErrores;
    }

    /**
     * OBTIENE LA INFORMACION DE UNA OPCION DE 
     * MENU, SI EL PARAMETRO NO ES FACILITADO
     * OBTIENE TODAS LAS OPCIONES DE UNA Proyecto
     * @author Bernardo Zerda
     * @param integer seqProyecto
     * @param integer seqMenu
     * @return array arrMenu
     * @version 1,0 abril 2009
     */
    public function cargarMenu($seqProyecto, $seqMenu = 0) {

        global $aptBd;
        $arrMenu = array();

        // si se pasa el parametro se restringe la consulta
        $txtCondicion = "";
        if ($seqMenu != 0) {
            $txtCondicion = " AND men.seqMenu = $seqMenu ";
        }

        if (is_numeric($seqProyecto) and $seqProyecto > 1) {

            // consulta las opciones de menu 
            $sql = "
	                SELECT 
	                    men.seqMenu,
	                    men.seqMenuPadre,
	                    ucwords(men.txtMenuEs) as txtMenuEs,
	                    ucwords(men.txtMenuEn) as txtMenuEn,
	                    men.txtCodigo,
	                    men.numOrden,
	                    men.txtAyuda,
	                    men.bolPublicar
	                FROM 
	                    T_COR_PERMISO per,
	                    T_COR_PROYECTO_GRUPO egr,
	                    T_COR_MENU men
	                WHERE   men.seqMenu > 1
                            AND per.seqProyectoGrupo = egr.seqProyectoGrupo
	                    AND per.seqMenu = men.seqMenu
	                    AND egr.seqProyecto = $seqProyecto
	                    $txtCondicion
	                GROUP BY 
	                    men.seqMenu,
	                    men.seqMenuPadre,
	                    men.txtMenuEs,
	                    men.txtMenuEn,
	                    men.txtCodigo
	                ORDER BY 
	                    men.seqMenuPadre,
	                    men.numOrden
	            ";
        //   echo "<br>".$sql;
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {

                $seqMenu     = $objRes->fields['seqMenu'];
                $seqPadre    = $objRes->fields['seqMenuPadre'];
                $txtEspanol  = $objRes->fields['txtMenuEs'];
                $txtIngles   = $objRes->fields['txtMenuEn'];
                $txtCodigo   = $objRes->fields['txtCodigo'];
                $numOrden    = $objRes->fields['numOrden'];
                $txtAyuda    = $objRes->fields['txtAyuda'];
                $bolPublicar = $objRes->fields['bolPublicar'];

                $objMenu = new Menu;
                $objMenu->txtEspanol  = $txtEspanol;
                $objMenu->txtIngles   = $txtIngles;
                $objMenu->txtCodigo   = $txtCodigo;
                $objMenu->numOrden    = $numOrden;
                $objMenu->seqPadre    = $seqPadre;
                $objMenu->txtAyuda    = $txtAyuda;
                $objMenu->bolPublicar = $bolPublicar;

                $arrMenu[$seqMenu] = $objMenu;

                $objRes->MoveNext();
            }
           // var_dump($arrMenu);
            // Se obtienen los permisos para las opciones de menu      
            if (!empty($arrMenu)) {

                $sql = "
                    SELECT
                        per.seqMenu,
                        egr.seqProyecto,
                        egr.seqGrupo,
                        egr.seqProyectoGrupo
                    FROM
                        T_COR_PERMISO per,
                        T_COR_PROYECTO_GRUPO egr
                    WHERE
                          per.seqProyectoGrupo = egr.seqProyectoGrupo
                    AND egr.seqProyecto = $seqProyecto
                    AND per.seqMenu IN ( " . implode(",", array_keys($arrMenu)) . " )
                ";

                $objRes = $aptBd->execute($sql);
                while ($objRes->fields) {
                    $seqMenu = $objRes->fields['seqMenu'];
                    $seqProyecto = $objRes->fields['seqProyecto'];
                    $seqGrupo = $objRes->fields['seqGrupo'];
                    $seqProyectoGrupo = $objRes->fields['seqProyectoGrupo'];
                    $arrMenu[$seqMenu]->arrGrupo[$seqProyecto][$seqGrupo] = $seqProyectoGrupo;
                    $objRes->MoveNext();
                }
            }
        }


        return $arrMenu;
    }

    /**
     * DADOS UNA Proyecto Y UN PADRE SON RETORMADOS
     * LOS HIJOS DE ESA OPCION DE MENU.
     * @author Bernardo Zerda
     * @param integer seqProyecto
     * @param integer seqPadre
     * @return array arrMenuhijos
     * @version 1.0 abril 2009
     */
    public function obtenerHijos($seqProyecto, $seqPadre) {

        global $aptBd;
        $arrMenuHijos = array();

        if (is_numeric($seqProyecto) and $seqProyecto > 1) {

            $sql = "
	                SELECT
	                    men.seqMenu
	                FROM
	                    T_COR_PERMISO per,
	                    T_COR_MENU men,
	                    T_COR_PROYECTO_GRUPO egr
	                WHERE
	                    per.seqProyectoGrupo = egr.seqProyectoGrupo
	                AND per.seqMenu = men.seqMenu
	                AND egr.seqProyecto = $seqProyecto
	                AND men.seqMenuPadre = $seqPadre
	                ORDER BY
	                    men.numOrden
	            ";
	           // pr($sql);
            $objRes = $aptBd->execute($sql);
            while ($objRes->fields) {
                $seqMenu = $objRes->fields['seqMenu'];
                $objMenuHijo = $this->cargarMenu($seqProyecto, $seqMenu);
                $arrMenuHijos[$seqMenu] = $objMenuHijo[$seqMenu];
                $objRes->MoveNext();
            }
        }

        return $arrMenuHijos;
    }

    /**
     * MODIFICA UNA OPCION DE MENU
     * @author Bernardo Zerda
     * @param integer seqMenu
     * @param string txtEspanol
     * @param string txtIngles
     * @param string txtCodigo
     * @param arrGrupos
     * @version 1.0 Abril 2009
     */
    public function editarMenu($seqMenu, $txtEspanol, $txtIngles, $txtCodigo, $numOrden, $seqPadre, $seqProyecto, $arrGrupo) {

        global $aptBd;
        $arrErrores = array();

        // carga las opciones actuales del menu
        $arrMenu = $this->cargarMenu($seqProyecto, $seqMenu);

        // Si tiene hijos no se puede cambiar de padre
        if ($arrMenu[$seqMenu]->seqPadre != $seqPadre) {
            $arrHijos = $this->obtenerHijos($seqProyecto, $seqMenu);
            if (!empty($arrHijos)) {
                $arrErrores[] = "No puede cambiar el padre de este menu porque tiene opciones asociadas";
            }
        }

        // si no hay errores procede
        if (empty($arrErrores)) {

            // carga las opciones nuevas en el objeto
            $objMenu = new Menu;
            $objMenu->txtEspanol = $txtEspanol;
            $objMenu->txtIngles = $txtIngles;
            $objMenu->txtCodigo = $txtCodigo;
            $objMenu->numOrden = $numOrden;
            $objMenu->seqPadre = $seqPadre;
            $objMenu->arrGrupo = $arrGrupo;

            // obtiene los hermanos nuevos para re-ordenar las opciones
            $arrHermanos = $this->obtenerHijos($seqProyecto, $seqPadre);

            // si la opcion existe dentro de los hermanos
            // debe eliminarla para que no se duplique
            unset($arrHermanos[$seqMenu]);


            // Ordena  las nuevas opciones de menu 
            // con respecto a el numero de orden deseado 
            // para la nueva opcion de menu
            // Inserta el Menu a modificar en la pocision correspondiente
            $arrMenuOrdenado = array();
            $i = 1;
            foreach ($arrHermanos as $seqHermano => $objHermano) {
                if ($i == $objMenu->numOrden) {
                    $arrMenuOrdenado[$seqMenu] = $objMenu;
                }
                $arrMenuOrdenado[$seqHermano] = $objHermano;
                $i++;
            }

            // Si el menu no se agrego, se inserta al final del arreglo
            if (!in_array($objMenu, $arrMenuOrdenado)) {
                $arrMenuOrdenado[$seqMenu] = $objMenu;
            }


            // Renumera las opciones
            $i = 1;
            foreach ($arrMenuOrdenado as $seqMenuOrdenado => $objMenuOrdenado) {
                $arrMenuOrdenado[$seqMenuOrdenado]->numOrden = $i;
                $i++;
            }

            // Actualiza las opciones ya organizadas
            foreach ($arrMenuOrdenado as $seqMenuOrdenado => $objMenuOrdenado) {

                if ($seqMenuOrdenado == $seqMenu) {
                    $sql = "
                            UPDATE T_COR_MENU SET 
                                txtMenuEs = \"" . $objMenu->txtEspanol . "\" , 
                                txtMenuEn = \"" . $objMenu->txtIngles . "\", 
                                txtCodigo = \"" . $objMenu->txtCodigo . "\", 
                                seqMenuPadre = " . $objMenu->seqPadre . ", 
                                numOrden = " . $objMenu->numOrden . " 
                            WHERE seqMenu = $seqMenu
                        ";
                } else {
                    $sql = "
                            UPDATE T_COR_MENU SET 
                                numOrden = " . $objMenuOrdenado->numOrden . " 
                            WHERE seqMenu = $seqMenuOrdenado
                        ";
                }

                try {
                    $aptBd->execute($sql);
                } catch (Exception $objError) {
                    $arrErrores[] = "No se ha podido actualizar el menu <b>" . $objMenuOrdenado->txtEspanol . "</b>, reporte este error al administrador";
//                        echo $objError->getMessage();
                }
            }
        }

        if (empty($arrErrores)) {

            // deja solo las opciones que hay que agregar o eliminar
            foreach ($arrMenu[$seqMenu]->arrGrupo as $seqProyecto => $arrProyectoGrupo) {
                foreach ($arrProyectoGrupo as $seqGrupo => $seqProyectoGrupo) {
                    if (isset($arrGrupo[$seqProyecto][$seqGrupo])) {
                        unset($arrGrupo[$seqProyecto][$seqGrupo]);
                        unset($arrMenu[$seqMenu]->arrGrupo[$seqProyecto][$seqGrupo]);
                    }
                }
            }

            // Agregar lo que viene en el post
            foreach ($arrGrupo as $seqProyecto => $arrProyectoGrupo) {
                foreach ($arrProyectoGrupo as $seqGrupo => $seqProyectoGrupo) {
                    $sql = "
                            INSERT INTO T_COR_PERMISO (
                                seqMenu, 
                                seqProyectoGrupo
                            ) VALUES (
                                $seqMenu, 
                                $seqProyectoGrupo
                            )
                        ";

                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo asociar el menu <b>" . $arrMenu[$seqMenu]->txtEspanol . "</b> a los grupos seleccionados, reporte este error al administrador";
//                            echo $objError->getMessage();
                    }
                }
            }

            // Quitar de los grupos
            foreach ($arrMenu[$seqMenu]->arrGrupo as $seqProyecto => $arrProyectoGrupo) {
                foreach ($arrProyectoGrupo as $seqGrupo => $seqProyectoGrupo) {

                    $sql = "
                            DELETE 
                            FROM T_COR_PERMISO
                            WHERE seqProyectoGrupo = $seqProyectoGrupo
                            AND seqMenu = $seqMenu
                        ";

                    try {
                        $aptBd->execute($sql);
                    } catch (Exception $objError) {
                        $arrErrores[] = "No se pudo eliminar la asociacion del menu <b>" . $arrMenu[$seqMenu]->txtEspanol . "</b> a los grupos seleccionados, reporte este error al administrador";
//                            echo $objError->getMessage();
                    }
                }
            }
        }



        return $arrErrores;
    }

    /**
     * ELIMINA LAS OPCIONES DE MENU 
     * @author Bernardo Zerda
     * @param integer seqProyecto
     * @param integer seqMenu
     * @param array arrGrupo
     * @return array arrErrores
     */
    public function borrarMenu($seqProyecto, $seqMenu, $arrGrupo) {

        global $aptBd;

        $arrErrores = array();

        // mira si el menu tiene hijos
        $arrHijos = $this->obtenerHijos($seqProyecto, $seqMenu);

        if (empty($arrHijos)) {

            // elimina de los permisos la opcion
            foreach ($arrGrupo as $seqProyectoGrupo) {
                $sql = "
                        DELETE
                        FROM T_COR_PERMISO
                        WHERE seqProyectoGrupo = $seqProyectoGrupo
                          AND seqMenu = $seqMenu
                    ";
                $aptBd->execute($sql);
            }

            // consulta si esa opcion de emnu tiene mas Proyectos asociadas
            $sql = "
                    SELECT seqMenu
                    FROM T_COR_PERMISO
                    WHERE seqMenu = $seqMenu
                ";
            $objRes = $aptBd->execute($sql);
            if ($objRes->RecordCount() == 0) {

                // si no tiene mas asociaciones con Proyectos la opcion de menu se elimina
                $sql = "
                        DELETE 
                        FROM T_COR_MENU
                        WHERE seqMenu = $seqMenu
                    ";
                $aptBd->execute($sql);
            }
        } else {

            // error si tiene submenu
            $objMenu = new Menu;
            $arrMenu = $objMenu->cargarMenu($seqProyecto, $seqMenu);
            $arrErrores[] = "No fue posible eliminar el menu <b>" . $arrMenu[$seqMenu]->txtEspanol . "</b> porque tiene opciones de menu asociadas";
        }

        return $arrErrores;
    }

    /**
     * OBTIENE LA RUTA ACTUAL DEL MENU PARA LA MIGA DE PAN
     * @param $seqMenu
     * @param string $txtRuta
     * @return string $txtRuta
     */
    public function obtenerRutaMenu($seqMenu, $txtRuta = "") {
        global $aptBd;

        if ($seqMenu != 0) {
            $sql = "
					SELECT 
						seqMenuPadre, 
						txtMenuES 
					FROM
						T_COR_MENU
					WHERE 
						seqMenu = $seqMenu			
				";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $txtRuta = $objRes->fields['txtMenuES'] . " / " . $txtRuta;
                $txtRuta = $this->obtenerRutaMenu($objRes->fields['seqMenuPadre'], $txtRuta);
            }
        }

        return trim($txtRuta, " / ");
    }

    public function obtenerMigaDePan($seqProyecto, $seqMenu, $numNivel = 0, $txtRuta = ""){
        global $aptBd;

        if ($seqMenu != 0) {
            $sql = "
                SELECT seqMenuPadre, txtMenuES 
                FROM T_COR_MENU
                WHERE seqMenu = $seqMenu			
			";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $txtRuta = "<li>" . $objRes->fields['txtMenuES'] . "</li>" . $txtRuta;
                $txtRuta = $this->obtenerMigaDePan($seqProyecto, $objRes->fields['seqMenuPadre'], $numNivel + 1, $txtRuta);
            }
        }

        if($numNivel == 0){
            $sql = "select txtProyecto from t_cor_proyecto where seqProyecto = $seqProyecto";
            $objRes = $aptBd->execute($sql);
            if ($objRes->fields) {
                $txtRuta = "<li><strong>" . $objRes->fields['txtProyecto'] . "</strong></li>". $txtRuta;
            }
        }

        return $txtRuta;
    }




    /**
     * OBTIENE EL ARBOL DE MENU COMPLETO
     * PARA UN PROYECTO EN GENERAL
     * @param $seqProyecto
     * @return $arrArbolMenu
     */
    public function arbolMenu($seqProyecto, $seqPadre = 0){
        global $aptBd;

        $arrArbolMenu = array();

        $sql = "
            select distinct
              men.seqMenu, 
              men.txtMenuEs, 
              men.txtCodigo,
              men.seqMenuPadre
            from t_cor_menu men
            inner join t_cor_permiso per on men.seqMenu = per.seqMenu
            inner join t_cor_proyecto_grupo pgr on per.seqProyectoGrupo = pgr.seqProyectoGrupo
            inner join t_cor_proyecto pro on pgr.seqProyecto = pro.seqProyecto
            where pro.seqProyecto = $seqProyecto
              and men.seqMenuPadre = $seqPadre
            order by 
              men.numOrden
        ";
        $objRes = $aptBd->execute($sql);
        while($objRes->fields){

            $seqMenu   = $objRes->fields['seqMenu'];
            $txtMenu   = $objRes->fields['txtMenuEs'];
            $txtCodigo = $objRes->fields['txtCodigo'];
            $txtSufijo = ( strpos($txtCodigo,".php") !== false )? "" : ".php";

            $arrArbolMenu[$seqMenu]['nombre'] = $txtMenu;
            $arrArbolMenu[$seqMenu]['codigo'] = $txtCodigo . $txtSufijo;
            $arrArbolMenu[$seqMenu]['hijos']  = $this->arbolMenu($seqProyecto, $seqMenu);

            $objRes->MoveNext();
        }

        return $arrArbolMenu;

    }

    public function imprimirSelectMenu($seqProyecto){

        $arrArbolMenu = $this->arbolMenu($seqProyecto);
        $txtSelect  = "<select name='padre' id='padre' style='width:200px;' ";
        $txtSelect .= "onChange=\"cargarContenido( 'selectOrden' , './contenidos/administracion/recalcularOrden.php' , 'proyecto=" . $seqProyecto . "&padre='+this.options[ this.selectedIndex ].value , true );\"> ";
        $txtSelect .= "<option value='0'>Es Menu Principal</option>";
        $txtSelect .= $this->imprimirOptionsSelectMenu($arrArbolMenu, 0);
        $txtSelect .= "</select>";
        return $txtSelect;

    }

    private function imprimirOptionsSelectMenu($arrArbolMenu, $numNivel){
        $txtRetorno = "";
        foreach($arrArbolMenu as $seqMenu => $arrMenu){
            $txtSelected = ($seqMenu == $this->seqPadre)? "selected" : "";
            $txtRetorno .= "<option value='$seqMenu' $txtSelected>" . str_repeat("&nbsp;" , ( $numNivel * 4 ) ) . " - " . $arrMenu['nombre'] . "</option>";
            if(! empty($arrMenu['hijos'])){
                $txtRetorno .= $this->imprimirOptionsSelectMenu($arrMenu['hijos'], ($numNivel + 1) );
            }
        }
        return $txtRetorno;
    }

    public function obtenerCantidadOpciones($arrArbolMenu, $seqPadre){
        $numOpciones = 0;
        if($seqPadre != 0) {
            if (isset($arrArbolMenu[$seqPadre])) {
                $numOpciones = count($arrArbolMenu[$seqPadre]['hijos']);
            } else {
                foreach ($arrArbolMenu as $seqMenu => $arrMenu) {
                    if($numOpciones == 0) {
                        $numOpciones = $this->obtenerCantidadOpciones($arrMenu['hijos'], $seqPadre);
                    }
                }
            }
        }else{
            $numOpciones = count($arrArbolMenu);
        }
        return $numOpciones;
    }

    public function depuracionPermisos($arrMenu){
        $seqProyecto = $_SESSION['seqProyecto'];
        foreach($arrMenu as $seqMenu => $arrSubmenu){
            if(! empty($arrSubmenu['hijos'])){
                $arrMenu[$seqMenu]['hijos'] = $this->depuracionPermisos($arrSubmenu['hijos']);
            }else{
                if (!in_array($seqMenu, $_SESSION['arrPermisos'][$seqProyecto])) {
                    unset($arrMenu[$seqMenu]);
                }
            }

        }
        return $arrMenu;
    }

    public function imprimirMenuPrincipal($arrMenu , $numNivel = 0){
        $txtMenu = "";
        foreach($arrMenu as $seqMenu => $arrSubmenu){

            $txtClaseLi = ( ( ! empty( $arrSubmenu['hijos'] ) ) and $numNivel > 0 )? "class=\"dropdown-submenu\"" : "" ;
            $txtClaseA  = ( ! empty( $arrSubmenu['hijos'] ) )? "class=\"dropdown-toggle\" data-toggle=\"dropdown\"" : "";
            $txtClaseUl = ( ( ! empty( $arrSubmenu['hijos'] ) ) and $numNivel == 0 )? "multi-level" : "";

            $txtMenu .= "<li $txtClaseLi>";
            $txtMenu .= "<a href=\"#\" $txtClaseA ";

            if(mb_strtolower($arrSubmenu["nombre"]) == "inicio") {
                $txtMenu .= "onClick=\"location.reload(true)\"";
            }elseif($txtClaseA == ""){
                $txtMenu .= "onClick=\"cargarContenido('contenido', './contenidos/" . $arrSubmenu["codigo"] . "', '', true); ";
                $txtMenu .= "cargarContenido('rutaMenu', './rutaMenu.php', 'menu=$seqMenu', false);\"";
            }

            $txtMenu .= ">" . $arrSubmenu["nombre"];

            if($txtClaseA != "" and $numNivel == 0){
                $txtMenu .= " <b class=\"caret\"></b>";
            }

            $txtMenu .= "</a>";

            if(! empty($arrSubmenu['hijos']) ){
                $txtMenu .= "<ul class=\"dropdown-menu $txtClaseUl\">";
                $txtMenu .= $this->imprimirMenuPrincipal($arrSubmenu['hijos'], $numNivel + 1);
                $txtMenu .= "</ul>";
            }

            $txtMenu .= "</li>";

        }
        return $txtMenu;
    }

    public function imprimirArbolMenuAyuda($arrMenu, $seqProyecto, $txtOrigen = "sipive", $numNivel = 0){

        if($numNivel == 0){
            echo "<ul id='arbol' class='h6'>";
        }else{
            echo "<ul>";
        }

        foreach($arrMenu as $seqMenu => $arrOpcion){
            $txtPadding = (empty($arrOpcion['hijos']))? "style='padding-left: 30px;'" : "";
            if( $txtOrigen == "sipive" ){
                $txtAccion = "cargarContenido('formularioAyuda','./contenidos/ayuda/formulario.php','seqProyecto=$seqProyecto&seqMenu=$seqMenu','true')";
            }else{
                $txtAccion = "location.href='./verAyuda.php?menu=$seqMenu'";
            }
            echo "<li $txtPadding><a href='#' onclick=\"$txtAccion\">" . $arrOpcion['nombre'] . "</a>";
            if(! empty($arrOpcion['hijos'])){
                $this->imprimirArbolMenuAyuda($arrOpcion['hijos'], $seqProyecto, $txtOrigen, $numNivel + 1);
            }
            echo "</li>";
        }

        echo "</ul>";

    }

    public function salvarTextoAyuda($seqMenu,$txtAyuda,$bolPublicar){
        global $aptBd;
        try{
            $aptBd->BeginTrans();
            $txtVacio = "<!DOCTYPE html>\n<html>\n<head>\n</head>\n<body>\n\n</body>\n</html>";
            $txtAyuda = (trim($txtAyuda) == "" or $txtAyuda == $txtVacio)? "null" : "'" . trim(htmlspecialchars(addslashes($txtAyuda))) . "'";
            $bolPublicar = ($txtAyuda == "null")? 0 : $bolPublicar;
            $sql = "
                update t_cor_menu set
                  txtAyuda = $txtAyuda,
                  bolPublicar = " . intval($bolPublicar) . "
                where seqMenu = $seqMenu
            ";
            $aptBd->execute($sql);
            $aptBd->CommitTrans();
            $this->arrMensajes[] = "Texto de ayuda salvado";
        }catch (Exception $objError){
            $aptBd->RollbackTrans();
            $this->arrErrores[] = "Problemas al intentar salvar el registro de ayuda";
            $this->arrErrores[] = $objError->getMessage();
        }
    }

}

?>