
<!--
	
	MENU DE OPCIONES DEL MENU DEL PANEL DE CONTROL
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Jaison Ospina
	@version 0.1 Enero de 2013
-->

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px" colspan="2">Ir a:</td></tr>
	</table>
	<table cellspacing="2" cellpadding="0" border="0" width="100%">	
		<tr>
			<td style="padding-left:3px; padding-top:5px;">
				
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				
					<!-- Administracion de las OPV -->
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/listadoOpv.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/formularioOpv.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
							OPV
					</td></tr>
					
					<!--<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/listadoOferente.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/formularioOferente.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
							Oferente
					</td></tr>-->
					
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/listadoConstructor.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/formularioConstructor.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
							Constructor
					</td></tr>
					
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/listadoFiduciaria.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracionProyectos/formularioFiduciaria.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
							Fiduciaria
					</td></tr>
				</table>
			</td>
		</tr>
	</table>