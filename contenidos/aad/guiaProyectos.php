<?php
   /**
    * CONTENIDO DEL POPUP DE AYUDA. OBTIENE CODIGO DE PROYECTO Y UNIDAD HABITACIONAL
    * @author Jaison Ospina
    * @version 1.0 Mayo de 2015
    **/

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
	include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );

    // obtiene las unidades habitacionales del proyecto seleccionado
    $arrUnidades = array();
    if( $_POST['seqProyecto'] != 0 ) {

        $sql = "
            select
                pry.seqProyecto as seqProyectoPadre,
                pry.txtNombreProyecto as txtNombreProyectoPadre,
                '' as seqProyecto,
                '' as txtNombreProyecto,
                upr.seqUnidadProyecto,
                upr.txtNombreUnidad,
                if (ciu.numDocumento is null or ciu.numDocumento = 0,0,1) as bolDisponible,
                upr.seqFormulario,
                ciu.numDocumento,
                concat(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2) as txtNombre
            from t_pry_proyecto pry
            inner join t_pry_unidad_proyecto upr on pry.seqProyecto = upr.seqProyecto
            left join t_frm_hogar hog on upr.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
            left join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
            where (pry.seqProyectoPadre is null or pry.seqProyectoPadre = 0)
            and upr.seqUnidadProyecto is not null
            and pry.seqProyecto = " . $_POST['seqProyecto'] . "
            union
            select distinct
                    (select seqProyecto from t_pry_proyecto where seqProyecto = pry.seqProyectoPadre) as seqProyectoPadre,
            (select txtNombreProyecto from t_pry_proyecto where seqProyecto = pry.seqProyectoPadre) as txtNombreProyectoPadre,
            pry.seqProyecto,
            pry.txtNombreProyecto,
            upr.seqUnidadProyecto,
            upr.txtNombreUnidad,
            if (ciu.numDocumento is null or ciu.numDocumento = 0,0,1) as bolDisponible,
            upr.seqFormulario,
            ciu.numDocumento,
            concat(ciu.txtNombre1,' ',ciu.txtNombre2,' ',ciu.txtApellido1,' ',ciu.txtApellido2) as txtNombre
            from t_pry_proyecto pry
            inner join t_pry_unidad_proyecto upr on pry.seqProyecto = upr.seqProyecto
            left join t_frm_hogar hog on upr.seqFormulario = hog.seqFormulario and hog.seqParentesco = 1
            left join t_ciu_ciudadano ciu on hog.seqCiudadano = ciu.seqCiudadano
            where pry.seqProyectoPadre is not null
            and seqProyectoPadre = " . $_POST['seqProyecto'] . "
            order by txtNombreProyectoPadre, txtNombreProyecto, bolDisponible, txtNombreUnidad
        ";
        $objRes = $aptBd->execute( $sql );

        while( $objRes->fields ){
            $seqProyecto = ( $objRes->fields['seqProyecto'] == 0 )? $objRes->fields['seqProyectoPadre'] : $objRes->fields['seqProyecto'];
            $txtProyecto = ( $objRes->fields['txtNombreProyecto'] == "" )? $objRes->fields['txtNombreProyectoPadre'] : $objRes->fields['txtNombreProyecto'];
            $seqUnidadProyecto = $objRes->fields['seqUnidadProyecto'];
            $arrUnidades['nombre'] = $txtProyecto;
            $arrUnidades['total']++;
            if( $objRes->fields['bolDisponible'] == 0){
                $arrUnidades['disponibles']++;
            }
            $arrUnidades['unidades'][$seqUnidadProyecto]['descripcion'] = trim($txtProyecto) . " / " . $objRes->fields['txtNombreUnidad'];
            $arrUnidades['unidades'][$seqUnidadProyecto]['documento'] = $objRes->fields['numDocumento'];
            $arrUnidades['unidades'][$seqUnidadProyecto]['nombre'] = $objRes->fields['txtNombre'];
            $arrUnidades['unidades'][$seqUnidadProyecto]['disponible'] = $objRes->fields['bolDisponible'];
            $objRes->MoveNext();
        }

    }

    $claSmarty->assign("arrUnidades", $arrUnidades);
    $claSmarty->display("aad/guiaProyectos.tpl");

//    pr( $arrUnidades );

?>