<?php
	$txtPrefijoRuta = "../../";
	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
	include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "ProyectoVivienda.class.php" );

	// Nombre del Proyecto para colocarlo en el nombre
	if( isset( $_POST['seqProyecto'] ) and intval( $_POST['seqProyecto'] ) > 0 ){
		$sql = "SELECT txtNombreProyecto
				FROM T_PRY_PROYECTO
				WHERE seqProyecto = " . $_POST['seqProyecto'];
		$objRes = $aptBd->execute($sql);
		$nombreProyecto = "";
		if ($objRes->fields) {
			$nombreProyecto = $objRes->fields['txtNombreProyecto'];
		}
    }

    // Header para redireccionar cuando el archivo este listo
    header("Content-disposition: attachment; filename=Unidades_" . $nombreProyecto . "_" . date('Ymd_His') . ".xls");
	header("Content-Type: application/force-download");
	header("Content-Type: text/plain; charset=ISO-8859-1");
	header("Content-Transfer-Encoding: base64");
	header("Pragma: no-cache");
	header("Expires: 1");

    // Arreglos necesarios
    $arrArchivo = array();

    // titulos del archivo
	$arrArchivo[0][] = "Unidad Proyecto";
	$arrArchivo[0][] = "Proyecto";
	$arrArchivo[0][] = "Nombre Unidad";
    $arrArchivo[0][] = "Valor Aprobado";
	$arrArchivo[0][] = "Valor Indexación 1";
	$arrArchivo[0][] = "Res. Indexación 1";
	$arrArchivo[0][] = "Fecha Indexación 1";
	$arrArchivo[0][] = "Valor Indexación 2";
	$arrArchivo[0][] = "Res. Indexación 2";
	$arrArchivo[0][] = "Fecha Indexación 2";
	$arrArchivo[0][] = "Valor Indexación 3";
	$arrArchivo[0][] = "Res. Indexación 3";
	$arrArchivo[0][] = "Fecha Indexación 3";
	//$arrArchivo[0][] = "Valor Actual";

    // Si recibe el codigo del proyecto
    if( isset( $_POST['seqProyecto'] ) and intval( $_POST['seqProyecto'] ) > 0 ){
		$sql = "SELECT
					seqUnidadProyecto,
					seqProyecto,
					txtNombreUnidad,
					valSDVEAprobado,
					if (valSDVEIndexacion1 = 0, '', valSDVEIndexacion1) AS valSDVEIndexacion1,
					if (valResIndexacion1 = 0, '', valResIndexacion1) AS valResIndexacion1,
					if (fchResIndexacion1 = 0, '', fchResIndexacion1) AS fchResIndexacion1,
					if (valSDVEIndexacion2 = 0, '', valSDVEIndexacion2) AS valSDVEIndexacion2,
					if (valResIndexacion2 = 0, '', valResIndexacion2) AS valResIndexacion2,
					if (fchResIndexacion2 = 0, '', fchResIndexacion2) AS fchResIndexacion2,
					if (valSDVEIndexacion3 = 0, '', valSDVEIndexacion3) AS valSDVEIndexacion3,
					if (valResIndexacion3 = 0, '', valResIndexacion3) AS valResIndexacion3,
					if (fchResIndexacion3 = 0, '', fchResIndexacion3) AS fchResIndexacion3
				FROM
					T_PRY_UNIDAD_PROYECTO
				WHERE
					seqProyecto = " . $_POST['seqProyecto'] . "
				ORDER BY
					txtNombreUnidad";
    } else {
        // consulta del listado de hogares seleccionados
		$sql = "SELECT
					seqUnidadProyecto,
					seqProyecto,
					txtNombreUnidad,
					valSDVEAprobado,
					if (valSDVEIndexacion1 = 0, '', valSDVEIndexacion1) AS valSDVEIndexacion1,
					if (valResIndexacion1 = 0, '', valResIndexacion1) AS valResIndexacion1,
					if (fchResIndexacion1 = 0, '', fchResIndexacion1) AS fchResIndexacion1,
					if (valSDVEIndexacion2 = 0, '', valSDVEIndexacion2) AS valSDVEIndexacion2,
					if (valResIndexacion2 = 0, '', valResIndexacion2) AS valResIndexacion2,
					if (fchResIndexacion2 = 0, '', fchResIndexacion2) AS fchResIndexacion2,
					if (valSDVEIndexacion3 = 0, '', valSDVEIndexacion3) AS valSDVEIndexacion3,
					if (valResIndexacion3 = 0, '', valResIndexacion3) AS valResIndexacion3,
					if (fchResIndexacion3 = 0, '', fchResIndexacion3) AS fchResIndexacion3
				FROM
					T_PRY_UNIDAD_PROYECTO";
    }

    $objRes = $aptBd->execute( $sql );
    while( $objRes->fields ){
        $numLinea = count( $arrArchivo );
        $arrArchivo[ $numLinea ] = $objRes->fields;
        $objRes->MoveNext();
    }

    /****************************
     * EXPORTANDO EL RESULTADO
     ****************************/
    $txtArchivo = "<table border=1>";
    if( count( $arrArchivo ) > 1 ){
        foreach( $arrArchivo as $numLinea => $arrLinea ){
            $txtColor = "";
            if( $numLinea == 0 ){
                $txtColor = "background-color:#666666;color:white;text-align:center;";
            }else{
                $txtColor = ( fmod( $numLinea , 2 ) == 0 )? "background-color:#e4e4e4" : "background-color:#ffffff";
            }
            $txtArchivo .= "<tr><td style='$txtColor'>" . implode("</td><td style='$txtColor'>", $arrLinea) . "</td></tr>";
        }
    }
    $txtArchivo .= "</table>";
    echo utf8_decode( $txtArchivo );
?>