<?php
$txtPrefijoRuta = "../../";
include( $txtPrefijoRuta . "recursos/archivos/verificarSesion.php" );
include( $txtPrefijoRuta . "recursos/archivos/lecturaConfiguracion.php" );
include( $txtPrefijoRuta . $arrConfiguracion['librerias']['funciones'] . "funciones.php" );
include( $txtPrefijoRuta . $arrConfiguracion['carpetas']['recursos'] . "archivos/coneccionBaseDatos.php" );
?>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr><!-- MENU LATERAL -->
		<td valign="top" width="25%">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#003399'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosInformacionSolucion/index.php');" ><li>Cargue Informaci&oacute;n Soluci&oacute;n</li></td></tr>
				<!--<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#E4E4E4'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosLegalizacion/index.php');" >Estudios T&eacute;cnicos - Plantilla Unidades</td></tr>-->
				<!--<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#003399'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/migracionEstudiosTecnicosPryDes/index.php');" >Estudios T&eacute;cnicos - Carga Unidades</td></tr>-->
				<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#003399'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/migracionEstudiosTecnicosPryDes/index.php');" ><li>Migraci&oacute;n Estudios T&eacute;cnicos Proyectos a Desembolsos</li></td></tr>
				<!--<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#E4E4E4'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/PlantillaEstudioTitulos/index.php');" >Estudios T&iacute;tulos - Plantilla</td></tr>-->
				<!--<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#E4E4E4'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosEstudioTitulos/index.php');" >*Estudios T&iacute;tulos - Cargue Masivo</td></tr>-->
				<tr><td class="msgOk" style="cursor:pointer" onMouseOver="this.style.background='#003399'" onMouseOut="this.style.background='#F9F9F9'" onClick="javascript: cambiarOpcionLegalizacion('contenidoLegalizacion', 'contenidos/migracionesIndividual/CargaMasivosLegalizacion/index.php');" ><li>Cargue Unidades Legalizadas</li></td></tr>
			</table>
		</td>
		<!-- PANEL CONTENIDOLEGALIZACION -->
		<td valign="top">
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
				<td colspan="2" align="center" valign="top" id="contenidoLegalizacion" class="tituloLogin">Seleccione el m&oacute;dulo de legalizaci&oacute;n</td>
				</tr>
			</table>
		</td>
	</tr>
</table>