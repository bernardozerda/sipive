<?php

    // Esta variable de usa para ubicar los archivos a incluir
    $txtPrefijoRuta = "./";
    
    include( "./recursos/archivos/verificarSesion.php" ); // Verifica si hay sesion
    include( "./recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Menu.class.php" );
	
//	$claMenu = new Menu;
//	$txtRuta = "Inicio: " . $claMenu->obtenerRutaMenu( $_POST['menu'] );
//
//	echo "<span class='menuLateral'>" . $txtRuta . "</span>";

    $claMenu = new Menu();

    echo "<ol class='breadcrumb text-info h6' style='padding: 10px; margin: 0px;'>";
    echo $claMenu->obtenerMigaDePan($_SESSION['seqProyecto'], $_POST['menu']);
    echo "</ol>";
    echo "<input type='hidden' id='seqMenuMigaDePan' value='" . $_POST['menu'] . "'>";

?>
