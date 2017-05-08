<?php /* Smarty version 2.6.26, created on 2017-05-05 07:31:35
         compiled from subsidios/cambioEstados.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'subsidios/cambioEstados.tpl', 205, false),)), $this); ?>


	<form id="frmCambioEstados">
	
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'subsidios/pedirSeguimiento.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<br>
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
			<tr>
				<td class="tituloTabla" colspan="2">Cambio Masivo de Estados</td>
				<td class="tituloTabla" colspan="2">Instrucciones de carga</td>
			</tr>
			
			<!-- INPUT DE CARGA DEL ARCHIVO -->
			<tr>
				<td width="120px" style="padding-left: 10px; border-left: 1px dotted #999999;">Archivo:</td>
				<td height="30px" align="left" valign="middle"> 
					<input type="file" name="archivo" />
				</td>
				<td rowspan="4" width="300px" align="center" valign="top"
					style="padding-top:5px; border-left: 1px dotted #999999; border-right: 1px dotted #999999; border-bottom: 1px dotted #999999"
				>
					<table cellpadding="0" cellspacing="2" border="0" width="99%" align="justify">
						
						<tr><td><b>Para el cambio de estados masivo</b></td></tr>
						<tr><td style="padding-left: 15px">
							<li>El <b>Formato del Archivo</b> debe ser texto plano separado por tabulaciones.</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>Las <b>Columnas del archivo</b> son "Documento" e "Identificador de estado" y "Comentario" (Opcional).</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>La primera linea del archivo deben ser los titulos de las columnas.</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>Los documentos consignados deben corresponder al postulante principal del hogar.</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>Esta modalidad NO permite retornos en los estados</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>Para ver la lista de estados e identificadores posibles haga click 
								<a href="#" onClick="cambioEstadosPosibles();">AQUI</a>
							</li>
						</td></tr>
						
						<tr><td style="padding-top: 10px"><b>Para el cambio de estados masivo</b></td></tr>
						<tr><td style="padding-left: 15px">
							<li>Puede buscar el hogar por numero de documento o por el nombre</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>El documento debe corresponder con cualquier mayor de edad del hogar.</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>Confirme el numero del documento que digitó.</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>Seleccione el estado en el que desea dejar este hogar.</li>
						</td></tr>
						<tr><td style="padding-left: 15px">
							<li>En esta modalidad NO hay restricciones en el cambio de estados</li>
						</td></tr>
					</table>
					
				</td>
			</tr>
			
			<tr>
				<td colspan="2" class="tituloTabla" height="20px">
					Cambio de estado individual
				</td>
			</tr>
			
			<!-- SOLO PARA UNA CEDULA -->
			<tr>
				<td colspan="2" style="border-bottom: 1px dotted #999999; border-left: 1px dotted #999999;" valign="top">
					<table cellspacing="0" cellpadding="5" border="0" width="100%">
						<tr>
							<td class="tituloCampo" width="150px">
								Buscar por nombre:
							</td>
							<td height="17px" valign="top">
								<div id="buscarNombre">
									<input	id="nombre" 
											type="text" 
											style="width:260px" 
											onFocus="this.style.backgroundColor = '#ADD8E6'; " 
											onBlur="this.style.backgroundColor = '#FFFFFF';" 
									/>
									<div id="contenedor"></div>
								</div>	
							</td>
						</tr>
						<tr>
							<td class="tituloCampo">
								N&uacute;mero del documento
							</td>
							<td>
								<input	type="text" 
										name="buscaCedula" 
										id="buscaCedula" 
										value="" 
										style="width: 150px" 
										onFocus="this.style.backgroundColor = '#ADD8E6';" 
										onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
										onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
								/>
							</td>
						</tr>
						<tr>
							<td class="tituloCampo">
								Confirme n&uacute;mero 
							</td>
							<td>
								<input	type="text" 
										name="buscaCedulaConfirmacion" 
										id="buscaCedulaConfirmacion" 
										value="" 
										style="width: 150px" 
										onFocus="this.style.backgroundColor = '#ADD8E6'; " 
										onBlur="soloNumeros( this ); this.style.backgroundColor = '#FFFFFF';"
										onkeyup="formatoSeparadores(this)" onchange="formatoSeparadores(this)"
								/>
							</td>
						</tr>
						<tr>
							<td class="tituloCampo">
								Tipo Documento
							</td>
							<td>
								<select name="seqTipoDocumento" style="width:310px">
								<?php $_from = $this->_tpl_vars['arrTipoDocumentos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqTipoDocumento'] => $this->_tpl_vars['txtTipoDocumento']):
?>
									<option value="<?php echo $this->_tpl_vars['seqTipoDocumento']; ?>
"><?php echo $this->_tpl_vars['txtTipoDocumento']; ?>
</option>
								<?php endforeach; endif; unset($_from); ?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="tituloCampo">
								Estado del Proceso
							</td>
							<td>
								<select name="seqEstadoProceso" style="width:310px">
                                    <option value="0">Seleccione un estado</option>
                                    <?php $_from = $this->_tpl_vars['arrEstados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEstado'] => $this->_tpl_vars['txtEstado']):
?>
                                        <option value="<?php echo $this->_tpl_vars['seqEstado']; ?>
"><?php echo $this->_tpl_vars['txtEstado']; ?>
</option>
                                    <?php endforeach; endif; unset($_from); ?>
								</select>
							</td>
						</tr>
						
						<tr>
							<td class="tituloCampo" width="200px" style="padding:5px; background-color: #E4E4E4;">
								Cambio Especial de estado<br>
								<strong><i style="font-size:8px;">Cambiará Modalidad, Esquema, Plan de Gobierno y Vinculación a Proyectos</i></strong>
							</td>
							<td style="padding:5px; background-color: #E4E4E4; vertical-align: middle;">
								<input type="radio" name="especial" value="mejoramiento"> Mejoramiento
								<input type="radio" name="especial" value="adquisicion"> Adquisición  
							</td>
						</tr>
						
					</table>
					
				</td>
			</tr>
			
			<!-- BOTON -->
			<tr>
				<td colspan="2" height="25px" align="center" style="padding-right:20px;" bgcolor="#F9F9F9">
						<input type="button" 
								 value="Cambiar Estados" 
								 onClick="someterFormulario( 
										'mensajes', 
										this.form, 
										'./contenidos/subsidios/cambioEstadosSalvar.php', 
										true, 
										true
									); 
								 "
						/>
						
						
						<input type="reset" 
								 value="Reiniciar Formulario"
						/>	
				</td>
			</tr>	
		</table>
		
	</form>

	<div id="buscarCedulaListener"></div>
	<div id="listenerBuscarNombre"></div>
	
	<div id="cambioEstadosPosibles" style="display:none;">
	    <div class="hd">Listado de Estados Validos</div>
	    <div class="bd" style="overflow: auto; height: 500px;">
	    	<center>
		    	<table cellpadding="2" cellspacing="0" border="0" width="90%">
		    		<tr>
		    			<td class="tituloTabla">ID</td>
		    			<td class="tituloTabla">Descripción</td>
		    		</tr>
			    	<?php $_from = $this->_tpl_vars['arrEstados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqEstado'] => $this->_tpl_vars['txtEstado']):
?>
						<tr><td width="30px" bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#FFFFFF,#E4E4E4"), $this);?>
" align="center"><?php echo $this->_tpl_vars['seqEstado']; ?>
</td>
						<td bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#FFFFFF,#E4E4E4"), $this);?>
"><?php echo $this->_tpl_vars['txtEstado']; ?>
</td></tr>
					<?php endforeach; endif; unset($_from); ?>
				</table>
			</center>
	    </div>
	</div>
 
	
	
	
	
	
	
	
	