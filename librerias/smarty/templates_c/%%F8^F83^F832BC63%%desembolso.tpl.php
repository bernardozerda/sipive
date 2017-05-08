<?php /* Smarty version 2.6.26, created on 2017-05-05 09:03:05
         compiled from desembolso/desembolso.tpl */ ?>
	
	<!-- 
		PLANTILLA PRINCIPAL DE TODAS LAS FASES DE DESEMBOLSO
		@author Bernardo Zerda
		@version 1.0 Dic 2009
		@version 2.0 Jun 2013
	-->
	
	<form id="frmBusquedaOferta" 
		  onSubmit="someterFormulario( 'mensajes', this, './contenidos/desembolso/pedirConfirmacion.php', false, true ); return false;"
	> 
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
			
			<!-- TIPOS DE DESEMBOLSO -->
			<tr>
				<td align="center" bgcolor="#cccccc" style="padding:3px;">
					<b>Tipo de Desembolso</b>
				</td>
				<td bgcolor="#cccccc" style="padding:3px;">
					<select name="txtFlujo" 
                            onChange="
                                document.getElementById('contenidoFases').innerHTML = ''; 
                                cargarContenido(
                                        'fasesDesembolso',
                                        './contenidos/desembolso/cambiarFlujo.php', 
                                        'seqFormulario=<?php echo $this->_tpl_vars['seqFormulario']; ?>
&cedula=<?php echo $this->_tpl_vars['cedula']; ?>
&flujo=' + this.options[ this.selectedIndex ].value, 
                                        false
                                );
                            "
                    >
						<?php $_from = $this->_tpl_vars['claFlujoDesembolsos']->arrFlujos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtFlujo'] => $this->_tpl_vars['txtNombre']):
?>
							<option value="<?php echo $this->_tpl_vars['txtFlujo']; ?>
"
                                    <?php if ($this->_tpl_vars['txtFlujo'] == $this->_tpl_vars['claDesembolso']->txtFlujo): ?> selected <?php endif; ?>
                            >
                                <?php echo $this->_tpl_vars['txtNombre']; ?>

                            </option>	
						<?php endforeach; endif; unset($_from); ?>
					</select>
				</td>
			</tr>
		
			<tr>
				
				<!-- LISTADO DE FASES DEL PROCESO -->			
				<td width="180px" valign="top" style="padding-bottom:5px;" id="fasesDesembolso">
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "desembolso/fasesDesembolso.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</td>
				
				<!-- PLANTILLAS DEL PROCESO -->			
				<td align="center" valign="top" style="padding-bottom:5px; padding-top: 5px;">
	
					<!-- OBSERVACIONES DEL TUTOR -->	
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subsidios/pedirSeguimiento.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						
	
					<!-- BOTON SALVAR FASE Y LINK DE IMPRESION DE FORMULARIO -->		
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td style="padding-left:10px;" id="imprimirFase">
								<?php if ($this->_tpl_vars['txtImprimir'] != ""): ?>
									<a href="#" onClick="<?php echo $this->_tpl_vars['txtImprimir']; ?>
" targuet="new">
										Imprimir el Formulario
									</a>
								<?php endif; ?>
							</td>
							<td align="right" colspan="3" style="padding-right:10px;">
								<input type="submit" name="btnSalvar" value="Salvar Gesti&oacute;n">
								<input type="hidden" name="seqFormulario" id="seqFormulario" value="<?php echo $this->_tpl_vars['seqFormulario']; ?>
">
								<input type="hidden" name="cedula" id="cedula" value="<?php echo $this->_tpl_vars['cedula']; ?>
">
                                <input type="hidden" name="fase" id="fase" value="<?php echo $this->_tpl_vars['arrFlujoHogar']['fase']; ?>
">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
			
				<!-- PLANTILLA SEGUN EL ESTADO DEL PROCESO DENTRO DE DESEMBOLSOS -->
				<td colspan="2" align="center" valign="top" id="contenidoFases">
					<?php if ($this->_tpl_vars['txtPlantilla'] != ""): ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['txtPlantilla'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>
				</td>
			</tr>		
		</table>
	</form>


	<!--
		DESPLIEGA UN CUADRO DE DIALOGO PARA CARGAR IMAGENES DE DESEMBOLSO 
		EN LA ETAPA DE REVISION TECNICA, CUANDO SE HA SELECCIONADO
		VIVIENDA USADA
	-->
		
	<div id="cargaArchivosDesembolso" style="visibility:hidden">
		<div class="hd">Seleccione el archivo de imágen</div>
		<div class="bd">
		<form method="POST" id="frmCargaArchivosDesembolso">
			<table cellpadding="0" cellspacing="5" border="0" width="90%">
				<tr>
					<td id="mensajesCargandoArchivos" colspan="2" class="tituloTabla" valign="top">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>Seleccione el archivo</td>
					<td><input type="file" name="archivo" /></td>
				</tr>			
				<tr>
					<td>Nombre del Archivo</td>
					<td><input type="text" name="nombre" value="" style="width:100%" class="inputLogin" maxlength="17"/></td>
				</tr>
			</table>
			<input type="hidden" name="seqFormulario" id="seqFormulario" value="<?php echo $this->_tpl_vars['seqFormulario']; ?>
">
		</form>
		</div>
	</div>
	