<?php
//set_time_limit(0);
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
$n=0;
// IDENTIFICA LOS HOGARES QUE TENGAN INGRESO IGUAL A CERO
$sqlHogaresIngresoCero = "SELECT seqFormulario FROM T_FRM_FORMULARIO WHERE valIngresoHogar = 0";
$exeHogaresIngresoCero = mysql_query($sqlHogaresIngresoCero);
while ($rowHogaresIngresoCero = mysql_fetch_array($exeHogaresIngresoCero)) {
	// CALCULA EL INGRESO DE LOS MIEMBROS DE ESE HOGAR
	$sql = "SELECT SUM(valIngresos) AS ingreso
			FROM T_FRM_HOGAR LEFT JOIN T_CIU_CIUDADANO ON (T_FRM_HOGAR.seqCiudadano = T_CIU_CIUDADANO.seqCiudadano)
			WHERE seqFormulario = '".$rowHogaresIngresoCero[seqFormulario]."';";
	$exe = mysql_query($sql);
	$row = mysql_fetch_array ($exe);
	if ($row[ingreso] > 0) {
		$n = $n + 1;
		// ACTUALIZA EL INGRESO TOTAL DEL HOGAR
		$sqlUpdate = "UPDATE T_FRM_FORMULARIO SET valIngresoHogar = '".$row[ingreso]."' WHERE seqFormulario = '".$rowHogaresIngresoCero[seqFormulario]."'";
		mysql_query ($sqlUpdate);
		//echo $sqlUpdate."<br>";
	}
}
echo "<table width='100%'><tr><th align='center'>SE ACTUALIZARON $n HOGARES</th></tr><table>";
?>