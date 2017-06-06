
	<!-- HOJAS DE ESTILO -->
	{assign var=cssEncabezado        value="background-color:#000000; color:white; font-family:calibri; font-size:12pt; font-weight: normal; "}
	{assign var=cssSeccion           value="background-color:#b8bfc9; color:white; font-family:calibri; font-size:10pt; font-weight: normal; padding-left:13px;"}
	{assign var=cssSubseccion        value="background-color:#f0f0f0; color:black; font-family:calibri; font-size:10pt; font-weight: normal; padding-left:13px;"}
	{assign var=cssPreguntaNormal    value="background-color:#ffffff; color:blue; font-family:calibri; font-size:8pt;  font-weight: normal; padding-left:13px;"}
	{assign var=cssPreguntaNegrilla  value="background-color:#ffffff; color:blue; font-family:calibri; font-size:8pt;  font-weight: bold;   "}
	{assign var=cssRespuestaNormal   value="background-color:#ffffff; color:black; font-family:calibri; font-size:8pt;  font-weight: normal; padding-left:26px;"}
	{assign var=cssRespuestaNegrilla value="background-color:#ffffff; color:black; font-family:calibri; font-size:8pt;  font-weight: bold;   "}
	
	<table border=0 style='width: 100%;' cellpadding=3 cellspacing=0>
	
		<!-- ENCABEZADO -->
		<tr>
			<td style='padding:5px; {$cssEncabezado}' align="center">
				{$claEncuesta->txtDiseno}
			</td>
		</tr>
		<tr>
			<td style="padding:10px;  {$cssPreguntaNormal}">
				<table border=0 style='width: 100%;' cellpadding=3 cellspacing=0>
					<tr>
						<td style='width: 40%; {$cssPreguntaNegrilla}'>NOMBRE DEL CARGUE:</td>
						<td style='{$cssRespuestaNormal}'>{$claEncuesta->arrAplicacion.encabezado.nombre|strtoupper}</td>
					</tr><tr>
						<td style='width: 40%; {$cssPreguntaNegrilla}'>IDENTIFICADOR DEL FORMULARIO:</td>
						<td style='{$cssRespuestaNormal}'>{$claEncuesta->arrAplicacion.encabezado.formulario|strtoupper}</td>
					</tr><tr>
						<td style='width: 40%; {$cssPreguntaNegrilla}'>FECHA DE APLICACI&Oacute;N DE LA ENCUESTA:</td>
						<td style='{$cssRespuestaNormal}'>{$claEncuesta->arrAplicacion.encabezado.fchAplicacion|strtoupper}</td>
					</tr><tr>
						<td style='width: 40%; {$cssPreguntaNegrilla}'>FECHA DE CARGA DE LA ENCUESTA:</td>
						<td style='{$cssRespuestaNormal}'>{$claEncuesta->arrAplicacion.encabezado.fchCarga|strtoupper}</td>
					</tr>
					</tr><tr>
						<td style='width: 40%;  {$cssPreguntaNegrilla}'>USUARIO QUE CARG&Oacute; LA ENCUESTA:</td>
						<td style='{$cssRespuestaNormal}'>{$claEncuesta->arrAplicacion.encabezado.txtUsuario|strtoupper}</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<!-- IMPRESION DE LA PLANTILLA Y DE LOS RESULTADOS -->
		
		{foreach from=$claEncuesta->arrPlantilla key=txtSeccion item=arrSubsecciones}
			<tr><td style='padding:5px; {$cssSeccion}'>{$txtSeccion}</td></tr>
			{foreach from=$arrSubsecciones key=txtSubseccion item=arrPreguntas}
				<tr><td style='padding:5px; {$cssSubseccion}'>{$txtSubseccion}</td></tr>
				{foreach from=$arrPreguntas key=txtIdentificador item=arrPregunta}
							
					{if $arrPregunta.destino == "T_ENC_APLICACION_FORMULARIO"}
					 	
					 	<!-- IMPRIME LA PREGUNTA -->
						{if $arrPregunta.padre == ""}
							<tr><td style='width: 25%; {$cssPreguntaNormal}'>
								<span style="{$cssPreguntaNegrilla}">{$txtIdentificador}</span> {$arrPregunta.pregunta}
							</td></tr>
						{/if}
					 	
					 	<tr><td>
					 	
							<!-- PREGUNTAS DE TIPO TEXTO, NUMERO Y FECHA -->
							{if $arrPregunta.tipo != 3 && $arrPregunta.tipo != 5}
								
								<table  style='border-bottom: 1px dotted #b8bfc9; width: 100%;' cellpadding=3 cellspacing=0>
									<tr>
										{if $arrPregunta.padre != ""}
											<td style='width: 40%; {$cssRespuestaNormal}'>
												{foreach from=$arrPregunta.respuesta key=seqRespuesta item=arrRespuesta}
													<span style='{$cssRespuestaNegrilla}'>{$arrRespuesta.identificador}</span> {$arrRespuesta.texto}
												{/foreach}
											</td>
										{/if}
										<td style='{$cssRespuestaNormal}'>
											{foreach from=$arrPregunta.respuesta key=seqRespuesta item=arrRespuesta}
												{$claEncuesta->arrAplicacion.formulario.$seqRespuesta}
											{/foreach}
										</td>
									</tr>
								</table>
							
							<!-- UNICAS	-->
							{elseif $arrPregunta.tipo == 3}
							 
								<table border=0 style='width: 100%;' cellpadding=3 cellspacing=0>
									{foreach from=$arrPregunta.respuesta key=seqRespuesta item=arrRespuesta}
										<tr>
											<td style='border-bottom: 1px dotted #b8bfc9; width: 40%; {$cssRespuestaNormal}'>
												{$arrRespuesta.texto}
											</td>
											<td style="border-bottom: 1px dotted #b8bfc9; {$cssRespuestaNormal}">
												{if isset( $claEncuesta->arrAplicacion.formulario.$seqRespuesta )}
													1
												{else}
													&nbsp;
												{/if}
											</td>
										</tr>
									{/foreach}
								</table>
							
							<!-- MULTIPLES -->
							{elseif $arrPregunta.tipo == 5}
								
								<table border=0 style='width: 100%;' cellpadding=3 cellspacing=0>
									{if ! empty($arrPregunta.respuesta)}
										{foreach from=$arrPregunta.respuesta key=seqRespuesta item=arrRespuesta}
											<tr>
												<td style='width: 40%; border-bottom: 1px dotted #b8bfc9; {$cssRespuestaNegrilla}'>
													{$arrRespuesta.texto}
												</td>
												<td style="border-bottom: 1px dotted #b8bfc9; {$cssRespuestaNormal}">
													{$claEncuesta->arrAplicacion.formulario.$seqRespuesta}
												</td>
											</tr>
										{/foreach}
									{/if}
								</table>
								
							{/if}
						
						</td></tr>
					
					{else}	<!-- preguntas de ciudadano -->
						
						<tr><td>
							
							<table border=0 style='width: 100%;' cellpadding=0 cellspacing=1><tr>
							
							{if $arrPregunta.padre == ""}
								<td style='width: 25%; {$cssPreguntaNormal}'>
									<span style="{$cssPreguntaNegrilla}">{$txtIdentificador}</span> {$arrPregunta.pregunta}
								</td>
							{/if}
							
							<!-- PREGUNTAS DE TIPO TEXTO, NUMERO Y FECHA -->
							{if $arrPregunta.tipo != 3 && $arrPregunta.tipo != 5}
								
								{foreach from=$arrPregunta.respuesta key=seqRespuesta item=arrRespuesta}
								
									{if $arrPregunta.padre != ""}
										<td style='width: 25%; {$cssRespuestaNormal}'>
											<span style="{$cssRespuestaNegrilla}">{$arrRespuesta.identificador}</span> {$arrRespuesta.texto}
										</td>
									{/if}
								
									{math equation=x/y x=75 y=$claEncuesta->arrAplicacion.ciudadano|@count assign=numAncho}

									{foreach from=$claEncuesta->arrAplicacion.ciudadano key=numOrden item=arrRespuesta}
										<td style="width:{$numAncho|@intval}%; border-bottom: 1px dotted #b8bfc9; border-right: 1px dotted #b8bfc9;  {$cssRespuestaNormal}" align="center">
											{$arrRespuesta.$seqRespuesta}
										</td>
									{/foreach}

								{/foreach}
								
							<!-- UNICAS	 -->		
							{elseif $arrPregunta.tipo == 3}
								
								{foreach from=$arrPregunta.respuesta key=seqRespuesta item=arrRespuesta}
								
									</tr><tr><td style='width: 25%; {$cssRespuestaNormal}'>{$arrRespuesta.texto}</td>
								
									{math equation=x/y x=70 y=$claEncuesta->arrAplicacion.ciudadano|@count assign=numAncho}

                                    {foreach from=$claEncuesta->arrAplicacion.ciudadano key=numOrden item=arrRespuesta}
										<td style="border-bottom: 1px dotted #b8bfc9; border-right: 1px dotted #b8bfc9; {$cssRespuestaNormal}" align="center">
                                            {assign var=numOrden value=$smarty.section.numCiudadanos.index}
                                            {if isset( $arrRespuesta.$seqRespuesta )}
												1
                                            {else}
												&nbsp;
                                            {/if}
										</td>
									{/foreach}

								{/foreach}
								</tr>
							
							{/if}
							
							</tr></table>
							
						</td></tr>
									
					{/if}

				{/foreach}
			{/foreach}
		{/foreach}
		
	</table>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	