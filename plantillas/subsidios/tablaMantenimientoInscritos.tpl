
	<div>
		<form id="exportarMantenimientoIscritos" onSubmit="return false;">
		<button onClick="someterFormulario( 'mensajes' , 'exportarMantenimientoIscritos' , './contenidos/subsidios/exportarMantenimientoInscritos.php' , true , false );">
			Exportar Mantenimiento
		</button>
		
		<input type="hidden"
			   name="fchHoy"
			   value="{$fchHoy}"
		/>
		</form>
	</div>
	