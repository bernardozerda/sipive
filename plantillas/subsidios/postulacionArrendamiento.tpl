
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="220px" height="140px"id="pasos" align="center" valign="top" style="border-right: 1px dotted #999999;">
				<table cellpadding="3" cellspacing="0" border="0" width="100%">
					<tr><td class="tituloVerde" height="20px">Pasos</td></tr>
					<tr><td {if $numPaso == 1} class="menuLateralOver" {else} class="menuLateral" {/if}>Paso 1: PreSelección de Hogares</td></tr>
					<tr><td {if $numPaso == 2} class="menuLateralOver" {else} class="menuLateral" {/if}>Paso 2: Selección</td></tr>
				</table>
				<br>
				<button class="reporteadorExport" 
						id="exportar" 
						onClick="location.href='./recursos/descargas/{$txtNombreArchivo}'">
					Exportar a un Archivo
				</button>
			</td>
			<td id="tabla" style="padding:10px" rowspan="3" valign="top" align="center">

				<!-- navegadores aqui -->
				
				{math equation="x - y" x=$numPaso y=1 assign=numAnterior}
				{math equation="x + y" x=$numPaso y=1 assign=numSiguiente}
				
				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999">
					<tr><td  align="center" valign="bottom" width="100px" height="25px">
						{if $numAnterior == 1} 
							<form onSubmit="someterFormulario( 'contenido' , this , './contenidos/subsidios/postulacionArrendamiento.php' , false , true ); return false;">
								<input type="submit"
									   class="boton"
									   value="<< Paso {$numAnterior}"
								/>
								<input type="hidden"
									   name="paso"
									   value="{$numAnterior}"
								/>
							</form>
						{/if}
					</td><td align="center">&nbsp;
						{if $txtError != ""}
							<span class="msgError">{$txtError}</span><br>
						{/if}
						{if $numPaso == 1}
							Cantidad de subsidios a asignar
							<input type="text"
								   name="numSubsidios"
								   id="numSubsidios"
								   onFocus="this.style.backgroundColor = '#ADD8E6';" 
								   onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros( this ); document.getElementById( 'cantidad' ).value = this.value "
								   value="{$numCantidad}"
							/>
						{/if}
					</td><td align="center" width="100px">&nbsp;
						<form id="frmSiguiente" onSubmit="someterFormulario( 'contenido' , this , './contenidos/subsidios/postulacionArrendamiento.php' , false , true ); return false;">
							{if $numSiguiente <= 2 }
								<input type="submit"
									   class="boton"
									   value="Paso {$numSiguiente} >>"
								/>
							{/if}
							<input type="hidden"
								   name="paso"
								   value="{$numSiguiente}"
							/>
							<input type="hidden"
								   name="cantidad"
								   id="cantidad"
								   value="{$numCantidad}"
							/>
						</form>
					</td></tr>
				</table>				
				
				<!-- fin navegadores aqui -->

				<div id="cantidadRegistros" style="text-align:center; width:100%; display:none" class="msgOk">
					Se han procesado {$numRegistros} registros.
				</div>
				<div id="cargandoTablaArrendamiento" style="text-align:center; width:100%;" class="msgOk">
					Se han procesando {$numRegistros} registros, espere por favor...<br>
					<img src="./recursos/imagenes/cargando.gif">
				</div>
				<center>
				<div id="contenedorhogaresSeleccionadosArrendamiento">
					<table id="hogaresSeleccionadosArrendamiento" style="display:none">
						<thead>
					        <tr>
					        	<th>Item</th>
					        	<th>Ticket</th>
					            <th>Tipo Documento</th>
					            <th>Documento</th>
					            <th>Nombre</th>
					        </tr>
					    </thead>
					    <tbody>
							{foreach name=arriendo from=$arrHogares key=seqFormulario item=arrDatos}
								{math equation="x + y" x=$smarty.foreach.arriendo.index y=1 assign=numItem}
								{if $smarty.foreach.arriendo.index < 1000}
									<tr>
										<td>{$numItem}</td>
										<td>{$arrDatos.Ticket}</td>
										<td>{$arrDatos.TipoDocumento}</td>
										<td>{$arrDatos.Documento}</td>
										<td>{$arrDatos.Nombre}</td>
									</tr>
								{/if}
							{/foreach}
						</tbody>	
					</table>
				</div>
				</center>
			</td>
		</tr>
		<tr>
			<td id="tituloDescripcion" class="tituloVerde">
				Descripción
			</td>
		</tr>
		<tr>
			<td id="descripcion" valign="top" align="justify" style="padding:5px; border-right: 1px dotted #999999;">
				{if $numPaso == 1}
					<p>En este paso usted esta viendo los hogares que se postularon para el subsidio de adquisición de vivienda, pero que
					hasta el momento no han reportado el cierre financiero necesario para ser llamados a avanzar en el proceso de postulacón.</p>
					<p>Los hogares pre-seleccionados en este paso cumplen con los siguientes criterios:</p>
					<ol>
						<li>Hogares que se inscribieron para la modalidad de adquisición de vivienda antes del 30 de Junio de 2010</li>
						<li>Han reportado no tener ahorros</li>
						<li>Los ingresos mensuales reportados por el hogar son menores a 2 SMMLV</li>
						<li>Han reportado no estar afiliados a cajas de compensación familiar</li>
					</ol>
					<p>En el siguiente paso el sistema realizará una seleccion aleatoria de tickets que corresponde a 1.5 veces la cantidad 
					de subsidios a asignar en el presente corte. Los hogares que seran llamados para postularse son aquellos a los que
					el numero de ticket seleccionado por el sistema coincida con el numero de ticket asignado al hogar.</p> 
				{/if}
				{if $numPaso == 2}
					<p>El listado que esta observando es el listado de hogares cuyo ticket fue seleccionado por el sistema
					de manera aleatoria, estos hogares serán convocados a participar en el proceso del subsidio condicionado
					de arrendamiento.</p>
					<p>Aqui concluye el proceso de seleccion de los hogares.</p>
				{/if}
			</td>
		</tr>
	</table>

<div id="listenerhogaresSeleccionadosArrendamiento"></div>
<div id="listenersorteoArrendamiento"></div>
