<!-- PLANTILLA DE DESEMBOLSO CON PESTAÑAS -->
<form name="frmDesembolso" id="frmDesembolso" onSubmit="pedirConfirmacion('mensajes', this, './contenidos/proyectos/pedirConfirmacion.php'); return false;" autocomplete=off >

<!-- CODGIO PARA EL POP UP DE SEGUIMIENTO -->
	{assign var=seqPryEstadoProceso value=$objFormularioProyecto->seqPryEstadoProceso}
	<!-- TAB VIEW DE DOCUMENTOS PARA DESEMBOLSO -->
		<table cellpadding="2" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF">

		</table>

		<table id="tblDocsEncargoFiduciario" border="0" style="display:none">
			<tr><td class="tituloTabla" colspan="3" align="center">DOCUMENTOS SOLICITADOS PARA DESEMBOLSO CON ENCARGO FIDUCIARIO</td></tr>
			<tr class="tituloTabla">
				<th width="5%" align="center">Item</th>
				<th width="70%" align="center">Documento</th>
				<th width="25%" align="center">Observac&oacute;n</th>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFiducia1" name="chkDocFiducia1"></td>
				<td valign="top" align="justify">Certificación de existencia y representación legal de la entidad financiera que constituye el encargo fiduciario expedido por la Superintendencia Financiera de Colombia.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFiducia1" name="txtDocFiducia1"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFiducia2" name="chkDocFiducia2"></td>
				<td valign="top" align="justify">Constancia de constitución del encargo fiduciario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFiducia2" name="txtDocFiducia2"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFiducia3" name="chkDocFiducia3"></td>
				<td valign="top" align="justify">Copia del contrato de encargo fiduciario que incluya las condiciones de giro y de transferencia de los recursos, de acuerdo con los instructivos que para tal fin establezca la SDHT.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFiducia3" name="txtDocFiducia3"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFiducia4" name="chkDocFiducia4"></td>
				<td valign="top" align="justify">Copia del contrato de interventoría, con una persona natural o jurídica de la lista de profesionales inscritos en el Consejo Profesional Nacional de Ingeniería y Arquitectura, y para estos efectos, el contrato de intervento ría poora ser el mismo de los desembolsos de recursos del crédito constructor o hipotecario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFiducia4" name="txtDocFiducia4"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFiducia5" name="chkDocFiducia5"></td>
				<td valign="top" align="justify">Póliza de seguro de cumplimiento a favor de la SDHT, que ampare el cien por ciento (100%) de los recursos a desembolsar anticipadamente, con el fin de cubrir la corrección monetaria de los mismos con base en la variación del índice de Precios al Consumidor (IPC).</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFiducia5" name="txtDocFiducia5"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFiducia6" name="chkDocFiducia6"></td>
				<td valign="top" align="justify">Copia del contrato de encargo fiduciario del proyecto, el cual debe contener como mínimo las siguientes obligaciones:<br>
					<div style="padding-left:10px">
						<b>a.</b> Manifestación expresa de que el contrato es de administración exclusiva para el proyecto para el cual se solicita el desembolso de los subsidios.<br>
						<b>b.</b> La fiduciaria recibirá los recursos de la SDHT, los incluirá en los estados contables del proyecto y los administrará velando siempre por la eficiente y transparente gestión y destino de los mismos y de sus rendimientos financieros, teniendo en cuenta que son recursos públicos.<br>
						<b>c.</b>La fiduciaria y el fideicomitente se subrogarán a toda la normatividad que rige la materia del SDVE.
					</div>
				</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFiducia6" name="txtDocFiducia6"></textarea></td>
			</tr>
		</table>

		<table id="tblDocsFideicomiso" border="0" style="display:none">
			<tr><td class="tituloTabla" colspan="3" align="center">DOCUMENTOS SOLICITADOS PARA FIDEICOMISO DE ADMINISTRACI&Oacute;N INMOBILIARIA</td></tr>
			<tr class="tituloTabla">
				<th width="5%" align="center">Item</th>
				<th width="70%" align="center">Documento</th>
				<th width="25%" align="center">Observac&oacute;n</th>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFide1" name="chkDocFide1"></td>
				<td valign="top" align="justify"><b>1.</b> Certificación de existencia y representación legal expedida por la Superintendencia Financiera de Colombia de la entidad fiduciaria.</td>
				<td valigwn="top"><textarea cols="38" rows="2" id="txtDocFide1" name="txtDocFide1"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFide2" name="chkDocFide2"></td>
				<td valign="top" align="justify"><b>2.</b> Copia del contrato de interventoría, con una persona natural o jurídica de la lista de profesionales inscritos en el Consejo Profesional Nacional de Ingeniería y Arquitectura, para estos efectos, el contrato de interventoría podrá ser el mismo de los desembolsos de recursos del crédito constructor o hipotecario.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFide2" name="txtDocFide2"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFide3" name="chkDocFide3"></td>
				<td valign="top" align="justify"><b>3.</b> Certificado de Tradición y Libertad del terreno en el que se verifique la propiedad y que se encuentra libre de cualquier tipo de gravamen, excepto por la hipoteca a favor de la entidad que financia el proyecto, en caso tal que se cuente con crédito hipotecario constructor.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFide3" name="txtDocFide3"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFide4" name="chkDocFide4"></td>
				<td valign="top" align="justify"><b>4.</b> Los estudios de factibilidad y el presupuesto del proyecto, en el formato que para el efecto disponga la Subsecretaría de Coordinación operativa a través de la Subdirección de Apoyo a la Construcción.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFide4" name="txtDocFide4"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocBanca5" name="chkDocBanca5"></td>
				<td valign="top" align="justify"><b>5.</b> Copia del contrato de fideicomiso de administración inmobiliaria del proyecto, que señale:<br>
					<div style="padding-left:10px">
						<b>a.</b> Constitución de patrimonio autónomo.<br>
						<b>b.</b> Condiciones de giro y de transferencia de los recursos.<br>
						<b>c.</b> Cláusula que señale que todas las instrucciones de desembolso al constructor serán aprobadas previamente por la SDHT.<br>
						<b>d.</b> Ubicación, identificación, cabida, linderos y propiedad del lote.<br>
						<b>e.</b> Obligaciones de la fiduciaria y del fideicomitente.<br>
						<b>f.</b> Obligación del constructor de asumir los costos de administración del fideicomiso.<br>
						<b>g.</b> La transferencia real y material a la fiduciaria del inmueble como cuerpo cierto, incluyendo sus mejoras, anexidades, usos y costumbres.<br>
						<b>h.</b> Los bienes que ingresan al patrimonio autónomo incluyendo los recursos del SDVE de los futuros beneficiarios que harán parte del proyecto.<br>
						<b>i.</b> Tiempo de ejecución del proyecto.<br>
						<b>j.</b> Cronograma del proyecto.
					</div>
				</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFide5" name="txtDocFide5"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFide6" name="chkDocFide6"></td>
				<td valign="top" align="justify"><b>6.</b> Pólizas de cumplimiento constituidas por el constructor que amparen el buen manejo de los recursos del subsidio, el cumplimiento del contrato, la estabilidad de la obra y demás obligaciones que implican la entrega de las viviendas, cuyos montos y vigencias serán definidos por la SDHT.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFide6" name="txtDocFide6"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocFide7" name="chkDocFide7"></td>
				<td valign="top" align="justify"><b>7.</b>	Copia del contrato de obra celebrado con el constructor, salvo que en el contrato de fiducia se encuentren las obligaciones de cada una de las partes respecto de la construcción de las viviendas.</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocFide7" name="txtDocFide7"></textarea></td>
			</tr>
		</table>

		<table id="tblDocsAvalBancario" border="0" style="display:none">
			<tr><td class="tituloTabla" colspan="3" align="center">DOCUMENTOS SOLICITADOS PARA DESEMBOLSO CON AVAL BANCARIO</td></tr>
			<tr class="tituloTabla">
				<th width="5%" align="center">Item</th>
				<th width="70%" align="center">Documento</th>
				<th width="25%" align="center">Observac&oacute;n</th>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocBanca1" name="chkDocBanca1"></td>
				<td valign="top" align="justify">Certificación de existencia y representación legal de la entidad que otorga el aval expedida por la Superintendencia Financiera de Colombia</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocBanca1" name="txtDocBanca1"></textarea></td>
			</tr>
			<tr>
				<td valign="top" align="center"><input type="checkbox" id="chkDocBanca2" name="chkDocBanca2"></td>
				<td valign="top" align="justify">Copia del contrato del aval bancario, que señale:<br>
					<div style="padding-left:10px">
						<b>a.</b> Que el enajenador de vivienda se encuentra inscrito ante la Subsecretaría de Inspección, Vigilancia y Control de Vivienda de la SDHT.<br>
						<b>b.</b> Que el aval se constituye una garantía a favor de la SDHT irrevocable e intransferible.<br>
						<b>c.</b> Que el valor avalado cubre el cien por ciento (100%) de los recursos a desembolsar, incluida la corrección monetaria con base en la variación del índice de Precios al Consumidor (IPC).<br>
						<b>d.</b> La vigencia del aval debe ser acorde con el cronograma de obra y/o la vigencia del SDVE.<br>
						<b>e.</b> Instrucciones para el giro y transferencia de los recursos.
					</div>
				</td>
				<td valign="top"><textarea cols="38" rows="2" id="txtDocBanca2" name="txtDocBanca2"></textarea></td>
			</tr>
		</table>
<input type="hidden" id="seqProyectoEditar" name="seqProyectoEditar" value="{$objFormularioProyecto->seqProyecto}">
<input type="hidden" name="txtArchivo" value="./contenidos/proyectos/salvarDesembolso.php">
<input type="hidden" name="txtCiudadanoAtendido" value="{$txtCiudadanoAtendido}">
<input type="hidden" name="numDocumentoAtendido" value="{$numDocumento}">

</form>

<div id="desembolsoPryTabView"></div>
<div id="objDireccionOculto" style="display:none"></div>
<div id="objDireccionOcultoSolucion" style="display:none"></div>