<?php

	$txtPrefijoRuta = "../../";

	include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
    include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/inclusionSmarty.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "Ciudadano.class.php" );
    include( $txtPrefijoRuta . $arrConfiguracion['librerias']['clases'] . "FormularioSubsidios.class.php" );

	/**
	 * VALIDACIONES DE ERRORES
	 */

	$arrErrores = array();

	switch( $_FILES['fileSecuenciales']['error'] ){
		case UPLOAD_ERR_INI_SIZE:
		  $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
		break;  
		case UPLOAD_ERR_FORM_SIZE:
		    $arrErrores[] = "El archivo Excede el tamaño permitido, contacte al administrador del sistema";
		break; 
		case UPLOAD_ERR_PARTIAL:
		  $arrErrores[] = "El archivo no fue completamente cargado, intente de nuevo, si el error persiste contacte al administrador";
		break; 
		case UPLOAD_ERR_NO_FILE:
		  $arrErrores[] = "Debe especificar un archivo para cargar";
		break; 
	}	
	
	if( empty( $arrErrores ) ){
		try {
			$aptArchivo = fopen( $_FILES['fileSecuenciales']['tmp_name'] , "r" );
			$numLinea = 1;
			while( $txtLinea = fgets( $aptArchivo ) ){
				try {
					$txtLinea = trim( $txtLinea );
					if( is_numeric( trim( $txtLinea ) ) ){
						$arrCedulas[] = trim( $txtLinea );
					}else if ($txtLinea != ""){
						throw new Exception( "La linea $numLinea del archivo no contiene un número de documento válido" );
					}
				}catch( Exception $objError ){
					$arrErrores[] = $objError->getMessage();
				}
				$numLinea++;
			}
		}catch( Exception $objError ){
			$arrErrores[] = "No se ha podido abrir el archivo, puede que no tenga el formato correcto";
		}
	}
	
	/**
	 * PROCESAMIENTO DEL REPORTE
	 */

	if( empty( $arrErrores ) ){
		
		$claCiudadano = new Ciudadano;
		
		$arrFormularios = array();
		foreach( $arrCedulas as $numCedula ){
			$seqFormulario = $claCiudadano->formularioVinculado( $numCedula );
			if( $seqFormulario != 0 ){
				$arrFormularios[] = $seqFormulario;
			}else{
				$arrErrores[] = "El documento " . number_format( $numCedula , 0 , '.',',' ) . " no tiene un formulario vinculado";
			}
		}
		
		if( empty( $arrErrores ) ){
	
			$arrReporte = array();
			$arrTotales = array();
			
			$sql = " 
				SELECT
					etn.txtEtnia as txtEtnia,
					if( ciu.bolLgtb = 1 , 'LGBT' , ucwords( sex.txtSexo ) ) as txtGenero,
					ucwords( cabezaFamilia( ciu.seqCondicionEspecial , ciu.seqCondicionEspecial2 , ciu.seqCondicionEspecial3 ) ) as txtCabezaFamilia,
					ucwords( rangoEdad( FLOOR( ( DATEDIFF( NOW() , ciu.fchNacimiento ) / 365 ) ) ) )as txtRango					 
				FROM 
					T_FRM_FORMULARIO frm,
					T_FRM_HOGAR hog,
					T_CIU_CIUDADANO ciu,
					T_CIU_ETNIA etn,
					T_CIU_SEXO sex
				WHERE hog.seqCiudadano = ciu.seqCiudadano
					and hog.seqFormulario = frm.seqFormulario
				 	and ciu.seqEtnia = etn.seqEtnia
					and ciu.seqSexo = sex.seqSexo
					and frm.seqFormulario in (" . implode( "," , $arrFormularios ) . ")			
			";
			try { 
				$objRes = $aptBd->execute( $sql );
				
				while( $objRes->fields ){
					foreach( $objRes->fields as $txtClave => $txtValor ){
						$$txtClave = $txtValor;
					}/*
					pr($txtEtnia);
					pr($txtGenero);
					pr($txtRango);
					
					pr($txtCabezaFamilia);
					die();*/
						
						$arrReporte[ $txtEtnia ][ $txtGenero ][ $txtRango ][ $txtCabezaFamilia ]++;
						$arrTotales[ 3 ][ $txtEtnia ][ $txtGenero ][ $txtCabezaFamilia ]++;
						$arrTotales[ 6 ][ $txtGenero ][ $txtCabezaFamilia ]++; 
				
					
					$arrTotales[ 1 ][ $txtEtnia ][ $txtGenero ][ $txtRango ]++;
					$arrTotales[ 2 ][ $txtEtnia ][ $txtRango ]++;
					$arrTotales[ 4 ][ $txtEtnia ][ $txtGenero ]++;
					$arrTotales[ 5 ][ $txtEtnia ]++;
					$arrTotales[ 7 ][ $txtGenero ]++;
					$arrTotales[ 8 ]++;
					
					$objRes->MoveNext();
				}
				//pr($arrTotales);
				//die();
			} catch ( Exception $objError ){
				$arrErrores[] = "Se ha producido un error al consultar los datos";
				$arrErrores[] = $objError->getMessagge();
			}
			
		
		}
		
	}
	
	
	if( empty( $arrErrores ) ){
		
		// Rangos de Edades ( NO CAMBIAR EL TEXTO PROQUE ALTERA LAS SUMAS )
		$arrRangos[] = "0 A 5";
		$arrRangos[] = "6 A 13";
		$arrRangos[] = "14 A 17";
		$arrRangos[] = "18 A 26";
		$arrRangos[] = "27 A 59";
		$arrRangos[] = "Mayor De 60";
		
		
		// Genero
		$arrGenero[] = "Masculino";
		$arrGenero[] = "Femenino";
		$arrGenero[] = "LGBT";
		
		// Cabeza de Familia
		$arrCabeza[] = "Si";
		$arrCabeza[] = "No";
		
		// Condicion Etnica
		$sql = "
			SELECT seqEtnia, txtEtnia
			FROM T_CIU_ETNIA
			ORDER BY txtEtnia
		";
		$objRes = $aptBd->execute( $sql );
		while( $objRes->fields ){
			$arrEtnia[ $objRes->fields['seqEtnia'] ] = $objRes->fields['txtEtnia'];
			$objRes->MoveNext();
		} 
		
		// Hoja de Estilos
		$arrEstilos['encabezado'] = "	
			padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:white;
			font-size:8.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			background:black;
			mso-pattern:black none;
			white-space:normal;
		";
		
		$arrEstilos['nombreEtnia'] = "
			padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:windowtext;
			font-size:9.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			background:#D8D8D8;
			mso-pattern:black none;
			white-space:normal;
			border-bottom: 1px solid black;
		";
		
		$arrEstilos['rango'] = "
			padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:white;
			font-size:8.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			background:#538ED5;
			mso-pattern:black none;
			white-space:normal;
		";
		
		$arrEstilos['normal'] = "
			padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:windowtext;
			font-size:8.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			background:#F9F9F9;
			mso-pattern:black none;
			white-space:normal;
		";
		
		$arrEstilos['totalEtnia'] = "
			padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:windowtext;
			font-size:8.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			background:#D8D8D8;
			mso-pattern:black none;
			white-space:normal;
		";
		
		$arrEstilos['totalGenero'] = "
			padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:windowtext;
			font-size:8.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			background:#C5D9F1;
			mso-pattern:black none;
			white-space:normal;
		";
		
		$txtArchivo = "";

		$txtArchivo .= "
		<table border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='150pt' style='" . $arrEstilos['encabezado'] ."'>&nbsp;</td>
				<td width='100pt' style='" . $arrEstilos['encabezado'] ."'>&nbsp;</td>
				<td colspan='3' width='150pt' align='center' style='" . $arrEstilos['encabezado'] . "'>Masculino</td>
				<td colspan='3' width='150pt' align='center' style='" . $arrEstilos['encabezado'] . "'>Femenino</td>
				<td colspan='3' width='150pt' align='center' style='" . $arrEstilos['encabezado'] . "'>LGBT</td>
				<td rowspan='3' align='center' valign='bottom' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Total</td>
			</tr>
			<tr>
				<td style='" . $arrEstilos['encabezado'] . "'>&nbsp;</td>
				<td style='" . $arrEstilos['encabezado'] . "'>&nbsp;</td>
				<td colspan='3' align='center' style='" . $arrEstilos['encabezado'] . "'>Cabeza de Familia</td>
				<td colspan='3' align='center' style='" . $arrEstilos['encabezado'] . "'>Cabeza de Familia</td>
				<td colspan='3' align='center' style='" . $arrEstilos['encabezado'] . "'>Cabeza de Familia</td>
			</tr>
			<tr>
				<td style='" . $arrEstilos['encabezado'] . "'>&nbsp;</td>
				<td style='" . $arrEstilos['encabezado'] . "'>&nbsp;</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Si</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>No</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Total</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Si</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>No</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Total</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Si</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>No</td>
				<td align='center' width='50pt' style='" . $arrEstilos['encabezado'] . "'>Total</td>
			</tr>
		";
		
		foreach( $arrEtnia as $txtEtnia ){
			$txtArchivo .= "<tr><td rowspan='7' style='" . $arrEstilos['nombreEtnia'] . "'>$txtEtnia</td>";
			foreach( $arrRangos as $txtRango ){
				$txtArchivo .= "<td style='" . $arrEstilos['rango'] . "'>$txtRango</td>";
				foreach( $arrGenero as $txtGenero ){
					foreach( $arrCabeza as $txtCabezaFamilia ){
						$txtArchivo .= "<td align='right' style='padding-right:5px; " . $arrEstilos['normal'] . "'>";
						if( isset( $arrReporte[ $txtEtnia ][ $txtGenero ][ $txtRango ][ $txtCabezaFamilia ] ) ){
							$txtArchivo .= number_format( $arrReporte[ $txtEtnia ][ $txtGenero ][ $txtRango ][ $txtCabezaFamilia ] , 0 , '.' , ',' );
						}else{
							//$txtArchivo .= number_format( $arrReporte[ $txtEtnia ][ $txtGenero ][ $txtRango ][ $txtCabezaFamilia ]['NO'] , 0 , '.' , ',' );
							$txtArchivo .= "0";
						}
						$txtArchivo .= "</td>";	
					}
					$txtArchivo .= "<td style='" . $arrEstilos['totalGenero'] . "'>" . number_format( $arrTotales[ 1 ][ $txtEtnia ][ $txtGenero ][ $txtRango ] , 0 , '.' , ',' ) . "</td>";
				}
				$txtArchivo .= "<td style='" . $arrEstilos['totalEtnia'] . "'>" . number_format( intval( $arrTotales[ 2 ][ $txtEtnia ][ $txtRango ] ) , 0 , '.' , ',' ) . "</td>";
				$txtArchivo .= "</tr>";	
			}
			
			$txtArchivo .= "<tr>"; 
			$txtArchivo .= "<td style='" . $arrEstilos['totalEtnia'] . "'>Total Etnia</td>";
			foreach( $arrGenero as $txtGenero ){
				foreach( $arrCabeza as $txtCabezaFamilia ){
					$txtArchivo .= "<td style='" . $arrEstilos['totalEtnia'] . "'>" . number_format( intval( $arrTotales[ 3 ][ $txtEtnia ][ $txtGenero ][ $txtCabezaFamilia ] ) , 0 , '.' , ',' ) . "</td>";
				}
				$txtArchivo .= "<td style='" . $arrEstilos['totalEtnia'] . "'>" . number_format( intval( $arrTotales[ 4 ][ $txtEtnia ][ $txtGenero ] ) , 0 , '.' , ',' ) . "</td>";
			}			
			$txtArchivo .= "<td style='" . $arrEstilos['totalEtnia'] . "'>" . number_format( intval( $arrTotales[ 5 ][ $txtEtnia ] ) , 0 , '.' , ',' ) . "</td>";
			$txtArchivo .= "</tr>";
						
		}
		$txtArchivo .= "<tr>";
		$txtArchivo .= "<td colspan='2' align='center' style='" . $arrEstilos['encabezado'] . "'>Total General</td>";
		foreach( $arrGenero as $txtGenero ){
			foreach( $arrCabeza as $txtCabezaFamilia ){
				$txtArchivo .= "<td align='center' style='" . $arrEstilos['encabezado'] . "'>" . number_format( intval( $arrTotales[ 6 ][ $txtGenero ][ $txtCabezaFamilia ] ) , 0 , '.' , ',' ) . "</td>";		
			}
			$txtArchivo .= "<td align='center' style='" . $arrEstilos['encabezado'] . "'>" . number_format( intval( $arrTotales[ 7 ][ $txtGenero ] ) , 0 , '.' , ',' ) . "</td>";
		}
		$txtArchivo .= "<td align='center' style='" . $arrEstilos['encabezado'] . "'>" . number_format( intval( $arrTotales[ 8 ] ) , 0 , '.' , ',' ) . "</td>";		
		$txtArchivo .= "</tr>";
		$txtArchivo .= "</table>";	
		
		// Nombre del archivo exportable
		$txtNombreArchivo = "Directiva013_" . date( "Ymd_His" ) . ".xls";

		header("Content-disposition: attachment; filename=$txtNombreArchivo");
		header("Content-Type: application/force-download");
		header("Content-Type: application/vnd.ms-excel; charset=ISO-8859-1;");
		header("Content-Transfer-Encoding: binary");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		echo $txtArchivo;
		
	}else{
		imprimirMensajes( $arrErrores , array() );
	}
	
	
	
	
	
	
	
?>
