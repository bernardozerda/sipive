
	{if isset( $arrGruposSesion.$seqProyectoPost.5 )}
		<button type="button" id="inscripcion" title="inscripcion" onClick="cargarContenido('contenido','./contenidos/subsidios/buscarCedulaInscripcion.php','',true);">
			<img src="./recursos/imagenes/play-icon.jpg" width="21" height="21" alt="Inscripcion" align="center"> Inscripción
		</button><br><br>
	{/if}
	
	{if isset( $arrGruposSesion.$seqProyectoPost.6 )}
		<button type="button" id="postulacion" title="postulacion" onClick="cargarContenido('contenido','./contenidos/subsidios/buscarCedulaPostulacion.php','',true);">
			<img src="./recursos/imagenes/play-icon.jpg" width="21" height="21" alt="Postualcion" align="center"> Postulacion
		</button>
	{/if}

	