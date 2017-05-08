<?php /* Smarty version 2.6.26, created on 2017-05-05 09:03:06
         compiled from desembolso/estudioTitulos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucwords', 'desembolso/estudioTitulos.tpl', 46, false),array('modifier', 'upper', 'desembolso/estudioTitulos.tpl', 107, false),array('modifier', 'number_format', 'desembolso/estudioTitulos.tpl', 113, false),array('modifier', 'date_format', 'desembolso/estudioTitulos.tpl', 120, false),array('modifier', 'strlen', 'desembolso/estudioTitulos.tpl', 335, false),array('modifier', 'substr', 'desembolso/estudioTitulos.tpl', 336, false),array('function', 'cycle', 'desembolso/estudioTitulos.tpl', 51, false),array('function', 'math', 'desembolso/estudioTitulos.tpl', 326, false),)), $this); ?>

	<!--
		PLANTILLA PARA LA ETAPA DE REVSION DE OFERTA Y ESCRITURACION 
		@author Bernardo Zerda
		@version 1.0 Dic 2009
	-->
	
	<!-- DECLARACION DE VARIABLES PARA USAR EN LA PLANTILLA -->
	<?php $this->assign('seqModalidad', $this->_tpl_vars['claFormulario']->seqModalidad); ?>
	<?php $this->assign('seqSolucion', $this->_tpl_vars['claFormulario']->seqSolucion); ?>		
	<?php $this->assign('seqLocalidad', $this->_tpl_vars['claFormulario']->seqLocalidad); ?>
	<?php $this->assign('seqBancoAhorro', $this->_tpl_vars['claFormulario']->seqBancoCuentaAhorro); ?>
	<?php $this->assign('seqBancoAhorro2', $this->_tpl_vars['claFormulario']->seqBancoCuentaAhorro2); ?>
	<?php $this->assign('seqBancoCredito', $this->_tpl_vars['claFormulario']->seqBancoCredito); ?>
	<?php $this->assign('seqEstadoProceso', $this->_tpl_vars['claFormulario']->seqEstadoProceso); ?>
	<?php $this->assign('seqBancoCuentaAhorro', $this->_tpl_vars['claFormulario']->seqBancoCuentaAhorro); ?>
	<?php $this->assign('seqBancoCuentaAhorro2', $this->_tpl_vars['claFormulario']->seqBancoCuentaAhorro2); ?>
	<?php $this->assign('seqBancoCredito', $this->_tpl_vars['claFormulario']->seqBancoCredito); ?>
	<?php $this->assign('seqEntidadDonante', $this->_tpl_vars['claFormulario']->seqEmpresaDonante); ?>
	<?php $this->assign('seqTipoDocumento', $this->_tpl_vars['objCiudadano']->seqTipoDocumento); ?>
    
    <?php $this->assign('numAltura', 500); ?>
	<div id="demo" class="yui-navset" style="width:98%; height:<?php echo $this->_tpl_vars['numAltura']; ?>
; text-align:left;">
	    <ul class="yui-nav">
	    	<li class="selected"><a href="#dho"><em>Datos del Hogar</em></a></li>
	        <li><a href="#dho"><em>Estudio de Titulos</em></a></li>
	        <li><a href="#seg"><em>Seguimiento</em></a></li>
	        <li><a href="#aad"><em>Actos Administrativos</em></a></li>
	    </ul>  
	    <div class="yui-content">
<!-- PESTANA DE DATOS DEL HOGAR -->
			<div id="dho" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "desembolso/pestanaDatosHogar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>				
			</div>
<!-- ESTUDIO DE TITULOS -->
			<div id="eti" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
; overflow:auto;">
				
				<table cellpadding="3" cellspacing="0" border="0" width="100%">
					<tr bgcolor="#FFFFFF"><td colspan="2" align="center">
						<b>Secretaría Distrital del Hábitat<br>
						<?php if ($this->_tpl_vars['seqModalidad'] == '5'): ?>
							Concepto Jurídico Contrato<br /> 
							Subsidio Condicionado de Arrendamiento
						<?php else: ?>
							Estudio de Títulos<br />
							Vivienda <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->txtCompraVivienda)) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</b>
						<?php endif; ?>
					</td></tr>
				
					<!-- PREPARO -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td><b>Preparó</b></td>
						<td><?php echo $this->_tpl_vars['txtUsuarioSesion']; ?>
</td>
					</tr>
					
					<!-- APROBO -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td><b>Aprobó</b></td>
						<td colspan="2" height="17px" valign="top">
							<div id="buscarUsuario">
								<input	id="aprobo" 
										name="aprobo"
										type="text" 
										style="width:250px" 
										onFocus="this.style.backgroundColor = '#ADD8E6'; " 
										onBlur="this.style.backgroundColor = '#FFFFFF';" 
										value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtAprobo']; ?>
"
								/>
								<div id="contUsuario" style="width:250px"></div>
							</div>	
						</td>
					</tr>
					
					<!-- FECHA -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td><b>Fecha:</b></td>
						<td><?php echo $this->_tpl_vars['txtHoy']; ?>
</td>
					</tr>
					
					<!-- PROPERTARIO -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td><b><?php if ($this->_tpl_vars['seqModalidad'] == '5'): ?>Arrendador<?php else: ?>Propietario<?php endif; ?></b></td>
						<td>
							<?php if ($this->_tpl_vars['claDesembolso']->arrEscrituracion['txtNombreVendedor'] != ""): ?>
								<?php echo $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtNombreVendedor']; ?>

							<?php else: ?>
								<?php echo $this->_tpl_vars['claDesembolso']->txtNombreVendedor; ?>

							<?php endif; ?>
						</td>
					</tr>
					
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td><b>Postulante Principal:</b></td> 
						<td><?php echo $this->_tpl_vars['objCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->txtNombre2; ?>

							<?php echo $this->_tpl_vars['objCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->txtApellido2; ?>

							<?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['seqTipoDocumento']]; ?>
 <?php echo $this->_tpl_vars['objCiudadano']->numDocumento; ?>

						</td>
					</tr>
					
					<!-- IDENTIFICACION DEL INMUEBLE -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top">
							<b>Identificación Actual del Inmueble:</b>
						</td>
						<td align="justify">
							<?php if ($this->_tpl_vars['claDesembolso']->arrEscrituracion['txtDireccionInmueble'] != ""): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrEscrituracion['txtDireccionInmueble'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
 
							<?php else: ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->txtDireccionInmueble)) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>

							<?php endif; ?>; predio cuya descripcion, cabida y linderos se encuentran estipulados en la escritura pública 
							<u><i><a href="#" id="escritura1" onClick="recogerValor( ['escritura1','escritura2'] , 'numero' ,'variables' )">
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numEscrituraIdentificacion'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numEscrituraIdentificacion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

								<?php else: ?>
									Número Escritura
								<?php endif; ?>
							</a></i></u> del 
							<u><i><a href="#" id="fecha1" onClick="calendarioDesembolso( ['fecha1','fecha2'] , 'variables' );" >
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['fchEscrituraIdentificacion'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['fchEscrituraIdentificacion'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d de %B del %Y") : smarty_modifier_date_format($_tmp, "%d de %B del %Y")); ?>

								<?php else: ?>
									Fecha Escritura
								<?php endif; ?>
							</a></i></u> elevada ante la notaría 
							<u><i><a href="#" id="notaria1" onClick="recogerValor( ['notaria1','notaria2'] , 'numero' ,'variables' )">
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numNotariaIdentificacion'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numNotariaIdentificacion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

								<?php else: ?>
									Número Notaría
								<?php endif; ?>
							</a></i></u> de 
							<u><i><a href="#" id="ciudadIdentificacion" onClick="recogerValor( ['ciudadAdquisicion','ciudadIdentificacion'] , 'texto' , 'variables' ); ">
								 <?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadIdentificacion'] != ""): ?>
									<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadIdentificacion']; ?>

								<?php else: ?>
									Ciudad
								<?php endif; ?>
							</a></i></u>
						</td>
					</tr>
					
					<?php if ($this->_tpl_vars['seqModalidad'] != '5'): ?>
					<!-- TITULO DE ADQUISICION -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top">
							<b>Título de Adquisición:</b>
						</td>
						<td align="justify">
							Escritura pública 
							<u><i><a href="#" id="escritura2" onClick="recogerValor( ['escritura1','escritura2'] , 'numero' ,'variables' )">
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numEscrituraTitulo'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numEscrituraTitulo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

								<?php else: ?>
									Número Escritura
								<?php endif; ?>
							</a></i></u> del 
							<u><i><a href="#" id="fecha2" onClick="calendarioDesembolso( ['fecha1','fecha2'] , 'variables' );" >
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['fchEscrituraTitulo'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['fchEscrituraTituloTexto'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d de %B del %Y") : smarty_modifier_date_format($_tmp, "%d de %B del %Y")); ?>

								<?php else: ?>
									Fecha Escritura
								<?php endif; ?>
							</a></i></u> elevada ante la notaría 
							<u><i><a href="#" id="notaria2" onClick="recogerValor( ['notaria1','notaria2'] , 'numero' ,'variables' )">
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numNotariaTitulo'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numNotariaTitulo'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

								<?php else: ?>
									Número Notaría
								<?php endif; ?>
							</a></i></u> de 
								
							<u><i><a href="#" id="ciudadAdquisicion" onClick="recogerValor( ['ciudadAdquisicion','ciudadIdentificacion'] , 'texto' , 'variables' ); ">
								 <?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadTitulo'] != ""): ?>
									<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadTitulo']; ?>

								<?php else: ?>
									Ciudad
								<?php endif; ?>
							</a></i></u> Registrada en la anotacion 
								
							<a href="#" id="numerofolio" onClick="recogerValor( ['numerofolio','numerofolio'] , 'numero' ,'variables' )">
							<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numFolioMatricula'] != 0): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numFolioMatricula'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

							<?php else: ?>
								Folio
							<?php endif; ?> </a>
							del Folio de Matricula Inmobilaria.
							
						</td>
					</tr>
					<?php endif; ?>
					
					<!-- MATRICULA INMOBILIARIA -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top">
							<b>Matricula Inmobiliaria:</b>
						</td>
						<td align="justify">
							<?php if ($this->_tpl_vars['claDesembolso']->arrEscrituracion['txtMatriculaInmobiliaria'] != ""): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrEscrituracion['txtMatriculaInmobiliaria'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>

							<?php else: ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->txtMatriculaInmobiliaria)) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>

							<?php endif; ?>; de la oficina de registro de instrumentos públicos zona <u><i><a href="#" id="zona" onClick="recogerValor( ['zona'] , 'select' ,'variables' )">
							<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['txtZonaMatricula'] != ""): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['txtZonaMatricula'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>

							<?php else: ?>
								Zona
							<?php endif; ?>
							</a></i></u> 
							de 
							<u><i><a href="#" id="ciudadMatricula" onClick="recogerValor( ['ciudadMatricula'] , 'texto' ,'variables' )">
							<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadMatricula'] != ""): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadMatricula'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>

							<?php else: ?>
								Bogot&aacute;
							<?php endif; ?>
							</a></i></u> 
							 cuya fecha de expedicion data del 
							<u><i><a href="#" id="fechaMatricula" onClick="calendarioDesembolso( ['fechaMatricula'] , 'variables' );">
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['fchMatricula'] != ""): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['fchMatricula'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d de %B del %Y") : smarty_modifier_date_format($_tmp, "%d de %B del %Y")); ?>

								<?php else: ?>
									Fecha Matricula
								<?php endif; ?>
							</a></i></u> 
						</td>
					</tr>
					
					<?php if ($this->_tpl_vars['seqModalidad'] != '5'): ?>
					<!-- MODO DE ADQUISICION -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top">
							<b>Modo de Adquisición:</b>
						</td>
						<td align="justify">
							<div style="float:left">Compraventa <?php echo $this->_tpl_vars['arrSolucionDescripcion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]; ?>
, adquirida con el producto otorgado por la SDHT&nbsp;</div>
							<div style="float:left;" id="subsidioFonvivienda">
								<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['bolSubsidioFonvivienda'] == 1): ?>
									y Fonvivienda
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['seqModalidad'] != '5'): ?>
						<!-- AVALUO -->
						<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
							<td valign="top">
								<b>Valor Inmueble:</b>
							</td>
							<td align="justify">
								<div style="float:left"></div>
								<div style="float:left;" id="subsidioFonvivienda">
									<?php if ($this->_tpl_vars['claDesembolso']->arrEscrituracion['numValorInmueble'] != ""): ?>
										$<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrEscrituracion['numValorInmueble'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

									<?php else: ?>
										$<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->numValorInmueble)) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ".") : number_format($_tmp, 0, ",", ".")); ?>

									<?php endif; ?>
								</div>
							</td>
						</tr>
					<?php endif; ?>
					
					<!-- SUBSIDIOS ASIGNADOS -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top">
							<b>Subsidios Asignados:</b>
						</td>
						<td align="justify">
							<input type="checkbox" 
								   name="subsidioSdht" 
								   value="1"
								   onClick="this.checked=true"
								   checked
							/> SDHT: Resolución <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrJuridico['numResolucion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
 del <?php echo $this->_tpl_vars['claDesembolso']->arrJuridico['fchResolucion']; ?>
<br>
							<input type="checkbox" 
								   name="subsidioFonvivienda" 
								   value="1"
								   onClick="checkSubsidioFonvivienda( this );" 
								   <?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['bolSubsidioFonvivienda'] == 1): ?> checked <?php endif; ?> 
							/> Fonvivienda: Resolución <u><i><a href="#" id="resolucion" onClick="recogerValor( ['resolucion'] , 'numero' ,'variables' )">
							<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numResolucionFonvivienda'] != "" && $this->_tpl_vars['claDesembolso']->arrTitulos['numResolucionFonvivienda'] != 0): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numResolucionFonvivienda'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

							<?php else: ?>
								Número Resolución
							<?php endif; ?>
							</a></i></u> del 
							<u><i><a href="#" id="ano" onClick="recogerValor( ['ano'] , 'numero' ,'variables' )">
							<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['numAnoResolucionFonvivienda'] != "" && $this->_tpl_vars['claDesembolso']->arrTitulos['numAnoResolucionFonvivienda'] != 0): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTitulos['numAnoResolucionFonvivienda'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>

							<?php else: ?>
								Año Resolución
							<?php endif; ?>
							</a></i></u> 
						</td>
					</tr>
					
					<!-- OBSERVACIONES -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top"><b>Observaciones:</b></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
								<td>
									<textarea  id="observacion"
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
											   style="width:98%"
											   class="inputLogin"
									></textarea>
								</td>
								<td width="50px"> 
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarDocumentoAnalizado( document.getElementById('observacion') , 'resultadoObservaciones' , 'observacion' , 97 , 100 );"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
"><td id="resultadoObservaciones" colspan="2">
						<?php $_from = $this->_tpl_vars['claDesembolso']->arrTitulos['observacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['observacion'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['observacion']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['txtObservacion']):
        $this->_foreach['observacion']['iteration']++;
?>
							<?php echo smarty_function_math(array('equation' => "x + y",'x' => ($this->_foreach['observacion']['iteration']-1),'y' => 1,'assign' => 'numSecuencia'), $this);?>
							
							<div id="observacion<?php echo $this->_tpl_vars['numSecuencia']; ?>
">							
								<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
									 onMouseOver="this.style.backgroundColor='#FFA4A4';"
									 onMouseOut="this.style.backgroundColor='#F9F9F9'"
									 onClick="eliminarObjeto('observacion<?php echo $this->_tpl_vars['numSecuencia']; ?>
')"
								>X</div>
								<div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
								onMouseOver="mostrarHint( '<?php echo $this->_tpl_vars['txtObservacion']; ?>
')" onMouseOut="ocultarHint();">
									<?php if (((is_array($_tmp=$this->_tpl_vars['txtObservacion'])) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) > 100): ?>
										<?php echo $this->_tpl_vars['numSecuencia']; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['txtObservacion'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 100) : substr($_tmp, 0, 100)); ?>
...
									<?php else: ?>
										<?php echo $this->_tpl_vars['numSecuencia']; ?>
 - <?php echo $this->_tpl_vars['txtObservacion']; ?>

									<?php endif; ?>
								</div>
								<input type="hidden" name="observacion[]" value="<?php echo $this->_tpl_vars['txtObservacion']; ?>
">
							</div>	
						<?php endforeach; endif; unset($_from); ?>
					</td></tr>
					
					<!-- DOCUMENTOS ANALIZADOS -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top"><b>Documentos Analizados:</b></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
								<td>
									<textarea  id="documento"
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
											   style="width:98%"
											   class="inputLogin"
									></textarea>
								</td>
								<td width="50px"> 
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarDocumentoAnalizado( document.getElementById('documento') , 'resultadoDocumentos' , 'documento' , 97 , 100 );"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
"><td id="resultadoDocumentos" colspan="2">
						<?php $_from = $this->_tpl_vars['claDesembolso']->arrTitulos['documentos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['documentos'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['documentos']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['txtDocumentos']):
        $this->_foreach['documentos']['iteration']++;
?>
							<?php echo smarty_function_math(array('equation' => "x + y",'x' => ($this->_foreach['documentos']['iteration']-1),'y' => 1,'assign' => 'numSecuencia'), $this);?>
							
							<div id="documento<?php echo $this->_tpl_vars['numSecuencia']; ?>
">							
								<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
									 onMouseOver="this.style.backgroundColor='#FFA4A4';"
									 onMouseOut="this.style.backgroundColor='#F9F9F9'"
									 onClick="eliminarObjeto('documento<?php echo $this->_tpl_vars['numSecuencia']; ?>
')"
								>X</div>
								<div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
								onMouseOver="mostrarHint( '<?php echo $this->_tpl_vars['txtDocumentos']; ?>
')" onMouseOut="ocultarHint();">
									<?php if (((is_array($_tmp=$this->_tpl_vars['txtDocumentos'])) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) > 100): ?>
										<?php echo $this->_tpl_vars['numSecuencia']; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['txtDocumentos'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 100) : substr($_tmp, 0, 100)); ?>
...
									<?php else: ?>
										<?php echo $this->_tpl_vars['numSecuencia']; ?>
 - <?php echo $this->_tpl_vars['txtDocumentos']; ?>

									<?php endif; ?>
								</div>
								<input type="hidden" name="documento[]" value="<?php echo $this->_tpl_vars['txtDocumentos']; ?>
">
							</div>	
						<?php endforeach; endif; unset($_from); ?>
					</td></tr>
					
					<!-- RECOMENDACIONES -->
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
">
						<td valign="top"><b>Recomendaciones:</b></td>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
								<td>
									<textarea  id="recomendaciones"
											   onFocus="this.style.backgroundColor = '#ADD8E6';" 
											   onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales( this );"
											   style="width:98%"
											   class="inputLogin"
									></textarea> 
								</td>
								<td width="50px">
									<button type="button" 
											id="adicionar" 
											title="adicionar" 
											class="reporteador"
											onClick="adicionarDocumentoAnalizado( document.getElementById('recomendaciones') , 'resultadoRecomendaciones' , 'recomendaciones' , 97 , 100 );"
									>
										<img src="./recursos/imagenes/plus_icon.gif" width="14" height="15" alt="Adicionar" align="center">
									</button>
								</td>
							</tr></table>
						</td>
					</tr>
					<tr bgcolor="<?php echo smarty_function_cycle(array('values' => "#F9F9F9,#F0F0F0"), $this);?>
"><td id="resultadoRecomendaciones" colspan="2">
						<?php $_from = $this->_tpl_vars['claDesembolso']->arrTitulos['recomendaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['recomendaciones'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['recomendaciones']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['txtRecomendacion']):
        $this->_foreach['recomendaciones']['iteration']++;
?>
							<?php echo smarty_function_math(array('equation' => "x + y",'x' => ($this->_foreach['documentos']['iteration']-1),'y' => 1,'assign' => 'numSecuencia'), $this);?>
							
							<div id="recomendaciones<?php echo $this->_tpl_vars['numSecuencia']; ?>
">							
								<div style="width:12px; height:14px; cursor:pointer; border: 1px solid #999999; float:left"
									 onMouseOver="this.style.backgroundColor='#FFA4A4';"
									 onMouseOut="this.style.backgroundColor='#F9F9F9'"
									 onClick="eliminarObjeto('recomendaciones<?php echo $this->_tpl_vars['numSecuencia']; ?>
')"
								>X</div>
								<div style="cursor:pointer; float:right; width:97%; height:14px; border:1px solid #F9F9F9;"
								onMouseOver="mostrarHint( '<?php echo $this->_tpl_vars['txtRecomendacion']; ?>
')" onMouseOut="ocultarHint();">
									<?php if (((is_array($_tmp=$this->_tpl_vars['txtDocumentos'])) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) > 100): ?>
										<?php echo $this->_tpl_vars['numSecuencia']; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['txtRecomendacion'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 100) : substr($_tmp, 0, 100)); ?>
...
									<?php else: ?>
										<?php echo $this->_tpl_vars['numSecuencia']; ?>
 - <?php echo $this->_tpl_vars['txtRecomendacion']; ?>

									<?php endif; ?>
								</div>
								<input type="hidden" name="recomendaciones[]" value="<?php echo $this->_tpl_vars['txtRecomendacion']; ?>
">
							</div>	
						<?php endforeach; endif; unset($_from); ?>
					</td></tr>
				</table>
				
				<!-- VARIABLES PARA EL FORMULARIO -->
				<div id="variables">
					<input type="hidden" 
						   id="varescritura1" 
						   name="escritura1" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numEscrituraIdentificacion']; ?>
"
					/>
					<input type="hidden" 
						   id="varfecha1"
						   name="fecha1" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['fchEscrituraIdentificacion']; ?>
"
					/>
					<input type="hidden" 
						   id="varnotaria1"
						   name="notaria1" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numNotariaIdentificacion']; ?>
"
					/>
					<input type="hidden" 
						   id="varescritura2" 
						   name="escritura2" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numEscrituraTitulo']; ?>
"
					/>
					<input type="hidden" 
						   id="varfecha2"
						   name="fecha2" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['fchEscrituraTitulo']; ?>
"
					/>
					<input type="hidden" 
						   id="varnotaria2"
						   name="notaria2" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numNotariaTitulo']; ?>
"
					/>
					<input type="hidden" 
						   id="varciudadAdquisicion"
						   name="ciudadAdquisicion" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadTitulo']; ?>
"
					/>
					<input type="hidden" 
						   id="varciudadIdentificacion"
						   name="ciudadIdentificacion" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadIdentificacion']; ?>
"
					/>
					<input type="hidden" 
						   id="varnumerofolio"
						   name="numerofolio" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numFolioMatricula']; ?>
"
					/>
					<input type="hidden" 
						   id="varzona"
						   name="zona" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtZonaMatricula']; ?>
"
					/>

					<input type="hidden" 
						   id="varciudadMatricula"
						   name="ciudadMatricula" 
						   value="<?php if ($this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadMatricula'] != ''): ?><?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['txtCiudadMatricula']; ?>
<?php else: ?>Bogot&aacute;<?php endif; ?>"
					/>


					<input type="hidden" 
						   id="varfechaMatricula"
						   name="fechaMatricula" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['fchMatricula']; ?>
"
					/>
					<input type="hidden" 
						   id="varresolucion"
						   name="resolucion" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numResolucionFonvivienda']; ?>
"
					/>
					<input type="hidden" 
						   id="varano"
						   name="ano" 
						   value="<?php echo $this->_tpl_vars['claDesembolso']->arrTitulos['numAnoResolucionFonvivienda']; ?>
"
					/>
				</div>
								
			</div>
<!-- PESTANA DE SEGUIMIENTO -->			
			<div id="seg" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
; overflow:auto;"><p>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/seguimientoFormulario.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        	<p><div id="contenidoBusqueda">
	        		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "seguimiento/buscarSeguimiento.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        	</div></p>
	        	<input type="hidden" id="seqFormularioEditar" value="<?php echo $this->_tpl_vars['seqFormulario']; ?>
">
			</p></div>	
			
			<!-- PESTAÑA ACTOS ADMINISTRATIVOS -->	        
	        <div id="aad" style="height:<?php echo $this->_tpl_vars['numAltura']; ?>
;"><p>
	        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subsidios/actosAdministrativos.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        </p></div>
					
	    </div>
	</div>
	
	<div id="seguimiento"></div>
	<div id="listenerBuscarUsuario" style="visibility: hidden;">juridica</div>	
	
	