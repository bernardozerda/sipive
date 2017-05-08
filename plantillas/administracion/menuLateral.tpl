
<!--
	
	MENU DE OPCIONES DEL MENU DEL PANEL DE CONTROL
	
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr><td class="tituloTabla" height="20px" colspan="2">Ir a:</td></tr>
	</table>
	<table cellspacing="2" cellpadding="0" border="0" width="100%">	
		<tr>
			<td style="padding-left:3px; padding-top:5px;">
				
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				
					<!-- Administracion de las proyectos -->
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracion/listadoProyectos.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracion/formularioProyectos.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
						Proyectos
					</td></tr>				

					<!-- Administracion de grupos de usuarios -->
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracion/listadoGrupos.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracion/formularioGrupos.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
						Grupos
					</td></tr>

					<!-- Administracion de los usuarios -->
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracion/listadoUsuarios.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracion/formularioUsuarios.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
						Usuarios
					</td></tr>

					<!-- Administracion de las opciones de menu -->
					<tr><td onClick="cargarContenido( 'listado' , './{$arrConfiguracion.carpetas.contenidos}/administracion/listadoMenu.php' , '' , true ); 
									 cargarContenido( 'formulario' , './{$arrConfiguracion.carpetas.contenidos}/administracion/formularioMenu.php' , '' , false );
									 document.getElementById('mensajes').innerHTML = '';" 
							  style="cursor:pointer;"
							  class="menuLateral"
							  onMouseOver="this.className='menuLateralOver';"
							  onMouseOut="this.className='menuLateral'"
						>
						Menu
					</td></tr>
				
				</table>
			
			</td>
		</tr>

	</table>

