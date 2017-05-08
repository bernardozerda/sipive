<?php

    /**
     * OBTIENE LOS DATOS DEL PROYECTOS SELECCIONADO PARA OBTENER
     * LA DIRECCION, MATRICULA INMOBILIARIA Y CHIP
     * @author Bernardo Zerda
     * @version 1.0 Febrero 2014
     */
    $txtPrefijoRuta = "../../";

    include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );    
    
    $claProyecto = new ProyectoVivienda();
    $arrProyectos = array();
    if( intval( $_POST['seqProyecto'] ) != 0 ){
        $arrProyectos = $claProyecto->cargarProyectoVivienda($_POST['seqProyecto']);
    }
    
    $txtDireccion = "";
    $txtMatriculaInmobiliaria = "";
    $txChip = "";
	$seqTipoEsquema = "";
    if( ! empty( $arrProyectos ) ){
        $objProyecto = $arrProyectos[ $_POST['seqProyecto'] ];
        $txtDireccion = $objProyecto->txtDireccion;
        $txtMatriculaInmobiliaria = $objProyecto->txtMatriculaInmobiliariaLote;
        $txtChip = $objProyecto->txtChipLote;
		$seqTipoEsquema = $objProyecto->seqTipoEsquema;
    }
    
    echo "var txtDireccion = '$txtDireccion';";
    echo "var txtMatriculaInmobiliaria = '$txtMatriculaInmobiliaria';";
    echo "var txtChip = '$txtChip';";
	echo "var seqTipoEsquema = '$seqTipoEsquema';";
    
?>
