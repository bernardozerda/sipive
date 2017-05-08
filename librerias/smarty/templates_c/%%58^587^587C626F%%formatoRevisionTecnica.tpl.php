<?php /* Smarty version 2.6.26, created on 2017-05-05 09:32:02
         compiled from desembolso/formatoRevisionTecnica.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', 'desembolso/formatoRevisionTecnica.tpl', 30, false),array('modifier', 'number_format', 'desembolso/formatoRevisionTecnica.tpl', 75, false),array('modifier', 'ucwords', 'desembolso/formatoRevisionTecnica.tpl', 99, false),array('modifier', 'count', 'desembolso/formatoRevisionTecnica.tpl', 737, false),array('modifier', 'ceil', 'desembolso/formatoRevisionTecnica.tpl', 741, false),array('function', 'cycle', 'desembolso/formatoRevisionTecnica.tpl', 212, false),array('function', 'math', 'desembolso/formatoRevisionTecnica.tpl', 738, false),)), $this); ?>
<?php if ($this->_tpl_vars['claDesembolso']->txtFlujo == 'giroAnticipado' || $this->_tpl_vars['claDesembolso']->txtFlujo == 'postulacionIndividual'): ?>
    <?php $this->assign('tipoDocVendedor', $this->_tpl_vars['claDesembolso']->arrEscrituracion['seqTipoDocumento']); ?>
    <?php $this->assign('seqLocalidad', $this->_tpl_vars['claDesembolso']->arrEscrituracion['seqLocalidad']); ?>
    <?php $this->assign('txtDireccionInmueble', $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtDireccionInmueble']); ?>
	<?php $this->assign('txtNombreVendedor', $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtNombreVendedor']); ?>
	<?php $this->assign('numDocumentoVendedor', $this->_tpl_vars['claDesembolso']->arrEscrituracion['numDocumentoVendedor']); ?>
	<?php $this->assign('numTelefonoVendedor', $this->_tpl_vars['claDesembolso']->arrEscrituracion['numTelefonoVendedor']); ?>
	<?php $this->assign('txtBarrio', $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtBarrio']); ?>
	<?php $this->assign('txtTipoPredio', $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtTipoPredio']); ?>
	<?php $this->assign('txtMatriculaInmobiliaria', $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtMatriculaInmobiliaria']); ?>
	<?php $this->assign('txtChip', $this->_tpl_vars['claDesembolso']->arrEscrituracion['txtChip']); ?>
	
<?php else: ?>
    <?php $this->assign('tipoDocVendedor', $this->_tpl_vars['claDesembolso']->seqTipoDocumento); ?>
    <?php $this->assign('seqLocalidad', $this->_tpl_vars['claDesembolso']->seqLocalidad); ?>
    <?php $this->assign('txtDireccionInmueble', $this->_tpl_vars['claDesembolso']->txtDireccionInmueble); ?>
	<?php $this->assign('txtNombreVendedor', $this->_tpl_vars['claDesembolso']->txtNombreVendedor); ?>
	<?php $this->assign('numDocumentoVendedor', $this->_tpl_vars['claDesembolso']->numDocumentoVendedor); ?>
	<?php $this->assign('numTelefonoVendedor', $this->_tpl_vars['claDesembolso']->numTelefonoVendedor); ?>
	<?php $this->assign('txtBarrio', $this->_tpl_vars['claDesembolso']->txtBarrio); ?>
	<?php $this->assign('txtTipoPredio', $this->_tpl_vars['claDesembolso']->txtTipoPredio); ?>
	<?php $this->assign('txtMatriculaInmobiliaria', $this->_tpl_vars['claDesembolso']->txtMatriculaInmobiliaria); ?>
	<?php $this->assign('txtChip', $this->_tpl_vars['claDesembolso']->txtChip); ?>
    <?php endif; ?>

<?php $this->assign('tipoDocCiudadano', $this->_tpl_vars['claCiudadano']->seqTipoDocumento); ?>
<?php $this->assign('seqModalidad', $this->_tpl_vars['claFormulario']->seqModalidad); ?>
<?php $this->assign('seqProyecto', $this->_tpl_vars['claFormulario']->seqProyecto); ?>
<?php $this->assign('seqSolucion', $this->_tpl_vars['claFormulario']->seqSolucion); ?>
<?php $this->assign('txtRequisitos', ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtRequisitos'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp))); ?>
<?php $this->assign('txtExistencia', ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtExistencia'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp))); ?>
<?php $this->assign('txtNoCumple', ""); ?>




<?php if ($this->_tpl_vars['txtExistencia'] == 'no' || $this->_tpl_vars['txtRequisitos'] == 'no'): ?>
	<?php $this->assign('txtNoCumple', 'NO'); ?>
<?php endif; ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="title" content="Subsidios de Vivienda">
		<meta name="keywords" content="subsidio,vivienda,social,prioritaria,bogota,habitat,asignacion,credito" />
		<meta name="description" content="Sistema de informacion de subsidios de vivienda">
		<meta http-equiv="Content-Language" content="es">
		<meta name="robots" content="index,  nofollow" />
		<title>SDV - SDHT</title>
		
<?php echo '		
<style type="text/css">
	p.salto {
		page-break-after: always;
	}
</style>
'; ?>

		
	</head>
	<body onLoad="window.print();">
		<!-- TITULO DE LA CARTA DE IMPRESION -->
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
			<tr>
				<td width="150px" height="80px" align="center" valign="middle">
               <?php if (in_array ( 31 , $_SESSION['arrGrupos']['3'] ) || in_array ( 32 , $_SESSION['arrGrupos']['3'] ) || in_array ( 33 , $_SESSION['arrGrupos']['3'] )): ?>
                  <img src="../../recursos/imagenes/cvp.png">
               <?php else: ?>
                  <img src="../../recursos/imagenes/escudo.png">
               <?php endif; ?>
            </td>
				<td align="center" valign="middle" style="padding:20px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
">
					<b>Certificado de Existencia y Habitabilidad</b><br>
					<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">Fecha de Emisión: <?php echo $this->_tpl_vars['txtFecha']; ?>
</span><br>
					<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">Fecha de visita: <?php echo $this->_tpl_vars['txtFechaVisita']; ?>
</span><br>
					<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">No. Registro: <?php echo ((is_array($_tmp=$this->_tpl_vars['numRegistro'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, '.', ',') : number_format($_tmp, 0, '.', ',')); ?>
</span>
				</td>
				<td width="150px" align="center" valign="middle">
					<img src="../../recursos/imagenes/bta_positiva_carta.jpg">
				</td>
			</tr>
		</table><br>
		
		<!-- PLANTILLA VIVIENDA NUEVA -->
		<?php if (! empty ( $this->_tpl_vars['claDesembolso']->arrTecnico['observacion'] )): ?>
			
			<center>			
			<table cellpadding="2" cellspacing="0" border="0" width="100%" style="border: 1px solid #999999; <?php echo $this->_tpl_vars['txtFuente12']; ?>
">
				<tr><td colspan="2" align="center" style="padding-left:30px; padding-right:30px; font-weight:bold;"><br><br>
					REVISION CERTIFICADO DE EXISTENCIA Y HABITABILIDAD VIVIENDA DE
					INTERES SOCIAL Y RSULTADO DE LA CONSULTA PARA EFECTOS DE LO
					ORDENADO EN EL ARTICULO 34 DE LA RESOLUCION 966 DE 2004 DEL 
					MINISTERIO DE AMBIENTE, VIVIENDA Y DESARROLLO TERRITORIAL 
				</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" style="padding-left:50px; padding-right:50px;" align="justify">					
					El día de hoy <?php echo $this->_tpl_vars['txtHoy']; ?>
 se realizó la revision de los documentos radicados por el hogar
					de <b><?php echo $this->_tpl_vars['claCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtNombre2; ?>
 
					<?php echo $this->_tpl_vars['claCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido2; ?>
</b>
					identificado con <b> <?php echo ((is_array($_tmp=$this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['seqTipoDocumento']])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
 <?php echo $this->_tpl_vars['claCiudadano']->numDocumento; ?>
</b> 
					beneficiario(s) del Subsidio Distrital de Vivienda de la vivienda ubicada en la 
					<b><?php echo $this->_tpl_vars['txtDireccionInmueble']; ?>
</b> arrojando como resultado lo siguiente:
					
				</td></tr>
				<tr><td colspan="2" ><br>&nbsp;</td></tr>
				<tr><td colspan="2" style="padding-left:30px; padding-right:30px;">
					<ol>
					<?php $_from = $this->_tpl_vars['claDesembolso']->arrTecnico['observacion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['observacion'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['observacion']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['txtObservacion']):
        $this->_foreach['observacion']['iteration']++;
?>
						<li style="padding-bottom:10px; text-align:justify; padding-right: 23px;"><?php echo $this->_tpl_vars['txtObservacion']; ?>
</li>
					<?php endforeach; endif; unset($_from); ?>
					</ol>
				</td></tr>
				<tr><td colspan="2" >&nbsp;</td></tr>
				<tr><td colspan="2" style="padding-left:30px; padding-right:30px;">
					De acuerdo con la revisión anteriormente descrita es viable continuar desde el punto
					de vista técnico con los trámites que permitan el desembolso del subsidio.<br><br>
					Para constacia se firma por parte del responsable en el área técnica.<br><br><br><br>
					
						<p>Firma: ___________________________________________________</p>
						<p>Matricula Profesional:<?php echo $this->_tpl_vars['txtMatriculaProfesional']; ?>
 </p>
						<p><?php echo $this->_tpl_vars['txtUsuarioSesion']; ?>
</p><br><br><br>
					
				</td></tr>
			</table>	
			</center>
			
		<?php else: ?>

<!-- INICIO PAGINA 1 -->
	
		<!-- INFORMACION GENERAL -->
		<table cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
			<tr><td colspan="3" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4"><b>Información General</b></td></tr>
			
			<!-- NOMBRE DEL BENEFICIARIO -->
			<tr>
				<td><b>Nombre del Beneficiario:</b></td>
				<td><b>Documento</b></td>
				<td><b>Teléfono</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['claCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtNombre2; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido2; ?>
</td>
				<td><?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocCiudadano']]; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->numDocumento; ?>
</td>
				<td><?php echo $this->_tpl_vars['claFormulario']->numTelefono1; ?>
 ó <?php echo $this->_tpl_vars['claFormulario']->numTelefono2; ?>
 Celular <?php echo $this->_tpl_vars['claFormulario']->numCelular; ?>
</td>
			</tr>
			
			<!-- NOMBRE DEL VENDEDOR -->
			<tr>
				<td><b>Vendedor, Oferente y/o Constructor:</b></td>
				<td><b>Documento</b></td>
				<td><b>Teléfono</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['txtNombreVendedor']; ?>
</td>
				<td><?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocVendedor']]; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['numDocumentoVendedor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['numTelefonoVendedor']; ?>
</td>
			</tr>
			
			<!-- DIRECCION DEL PREDIO -->
			<tr>
				<td><b>Nombre del Proyecto:</b></td>
				<td><b>Dirección</b></td>
				<td><b>Tipo de Oferta</b></td>
			</tr>
			
			<!-- PROYECTO, MODALIDAD -->
			<tr>
				<td>
				<?php if ($this->_tpl_vars['arrProyectos'][$this->_tpl_vars['seqProyecto']] == '' || $this->_tpl_vars['arrProyectos'][$this->_tpl_vars['seqProyecto']] == ' '): ?>
						<?php echo $this->_tpl_vars['nombreComercial']; ?>

					<?php else: ?>
						<?php echo $this->_tpl_vars['arrProyectos'][$this->_tpl_vars['seqProyecto']]; ?>

					<?php endif; ?>
				</td>
				<td><?php echo $this->_tpl_vars['txtDireccionInmueble']; ?>
</td>
				<td><?php echo $this->_tpl_vars['arrModalidad'][$this->_tpl_vars['seqModalidad']]; ?>
 - <?php echo $this->_tpl_vars['arrSolucionDescripcion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]; ?>
</td>
			</tr>			
			
			<!-- LOCALIDAD / BARRIO O VEREDA -->
			<tr>
				<td><b>Localidad:</b></td>
				<td><b>Barrio o Vereda</b></td>
				<td><b>Tipo de Predio</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['arrLocalidad'][$this->_tpl_vars['seqLocalidad']]; ?>
</td>
				<td><?php echo $this->_tpl_vars['txtBarrio']; ?>
</td>
				<td><?php echo $this->_tpl_vars['txtTipoPredio']; ?>
</td>
			</tr>

			<tr> 
				<td><b>Matricula:</b><br/><?php echo $this->_tpl_vars['txtMatriculaInmobiliaria']; ?>
</td>
				<td><b>Chip:</b><br/><?php echo $this->_tpl_vars['txtChip']; ?>
</td>
				<td></td>
			</tr>

			
		</table><br>

		<!-- CONDICIONES ESPACIALES DE LA VIVIENDA -->
		<table cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
			<tr><td colspan="5" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4"><b>Condiciones Espaciales de la Vivienda</b></td></tr>
			
			<tr>
				<td style="border-bottom: 1px solid #999999" height="23px" width="150px"><b>Descripción</b></td>
				<td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Largo (m)</b></td>
				<td style="border-bottom: 1px solid #999999" width="70px" align="right"><b>Ancho (m)</b></td>
				<td style="border-bottom: 1px solid #999999" width="70px" align="right" valign="top"><b>Área (m<sup>2</sup>)</b></td>
				<td style="border-bottom: 1px solid #999999; padding-left:10px"><b>Observaciones</b></td>
			</tr>
			
			<!-- ESPACIO MULTIPLE -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Espacio Múltiple</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoMultiple'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoMultiple'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaMultiple'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtMultiple']; ?>
</td>
			</tr>
			
			<!-- ALCOBA1 -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Alcoba 1</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoAlcoba1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoAlcoba1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaAlcoba1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtAlcoba1']; ?>
</td>
			</tr>
			
			<!-- ALCOBA2 -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Alcoba 2</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoAlcoba2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoAlcoba2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaAlcoba2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtAlcoba2']; ?>
</td>
			</tr>
			
			<!-- ALCOBA3 -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Alcoba 3</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoAlcoba3'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoAlcoba3'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaAlcoba3'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtAlcoba3']; ?>
</td>
			</tr>
			
			<!-- COCINA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Cocina</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoCocina'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoCocina'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaCocina'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtCocina']; ?>
</td>
			</tr>
			
			<!-- BANO1 -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Baño 1</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoBano1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoBano1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaBano1'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtBano1']; ?>
</td>
			</tr>
			
			<!-- BANO2 -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Baño 2</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoBano2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoBano2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaBano2'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtBano2']; ?>
</td>
			</tr>
			
			<!-- LAVANDERIA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Area de Lavanderia</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoLavanderia'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoLavanderia'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaLavanderia'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtLavanderia']; ?>
</td>
			</tr>
			
			<!-- CIRCULACIONES -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Circulaciones</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoCiculaciones'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoCirculaciones'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaCirculaciones'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtCirculaciones']; ?>
</td>
			</tr>
			
			<!-- PATIO -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c1','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Patio</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLargoPatio'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAnchoPatio'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaPatio'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</td>
				<td style="padding-left:10px"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtPatio']; ?>
</td>
			</tr>
			
			<!-- TOTAL AREA CONSTRUIDA-->
			<tr>
				<td>&nbsp;</td>
				<td align="right" colspan="2" style="padding-right:10px"><b>Área Total Construida</b></td>
				<td align="right"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numAreaTotal'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ',', '.') : number_format($_tmp, 2, ',', '.')); ?>
</b></td>
				<td>&nbsp;</td>
			</tr>
			
		</table><br>
		
		<!-- CONDICIONES FISICAS Y ESTRUCTURALES -->
		<table cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
			<tr><td colspan="5" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4"><b>Condiciones Físicas y Estructurales de la Vivienda</b></td></tr>	
			
			<tr>
				<td style="border-bottom: 1px solid #999999" height="20px" width="150px"><b>Descripción</b></td>
				<td style="border-bottom: 1px solid #999999" width="150px"><b>Estado</b></td>
				<td style="border-bottom: 1px solid #999999;"><b>Observaciones</b></td>
			</tr>
			
			<!-- CIMENTACION -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Cimentación</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoCimentacion'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtCimentacion']; ?>
</td>
			</tr>
			
			<!-- PLACA DE ENTREPISO	-->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Placas de Entrepiso</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoPlacaEntrepiso'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtPlacaEntrepiso']; ?>
</td>
			</tr>
			
			<!-- MAMPOSTERIA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Mampostería</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoMamposteria'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtMamposteria']; ?>
</td>
			</tr>
			
			<!-- CUBIERTA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Cubierta</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoCubierta'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtCubierta']; ?>
</td>
			</tr>
			
			<!-- VIGAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Vigas</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoVigas'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtVigas']; ?>
</td>
			</tr>
			
			<!-- COLUMNAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Columnas</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoColumnas'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtColumnas']; ?>
</td>
			</tr>
			
			<!-- PANETES -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Pañetes</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoPanetes'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtPanetes']; ?>
</td>
			</tr>
			
			<!-- ENCHAPES Y ACCESORIOS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Enchapes y Accesorios</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoEnchapes'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtEnchapes']; ?>
</td>
			</tr>
			
			<!-- ACABADOS PISOS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Acabados Pisos</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoAcabados'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtAcabados']; ?>
</td>
			</tr>
			
			<!-- INSTALACIONES HIDRAULICAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Instalaciones Hidráulicas</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoHidraulicas'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtHidraulicas']; ?>
</td>
			</tr>
			
			<!-- INSTALACIONES HIDRAULICAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Instalaciones Eléctricas</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoElectricas'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtElectricas']; ?>
</td>
			</tr>
			
			<!-- INSTALACIONES SANITARIAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Instalaciones Sanitarias</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoSanitarias'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtSanitarias']; ?>
</td>
			</tr>
			
			<!-- INSTALACIONES HIDRAULICAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Instalaciones Gas</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoGas'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtGas']; ?>
</td>
			</tr>
			
			<!-- CARPINTERIA MADERA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Carpintería Madera</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoMadera'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtMadera']; ?>
</td>
			</tr>
			
			<!-- CARPINTERIA METALICA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Carpinteria Metalica</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoMetalica'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtMetalica']; ?>
</td>
			</tr>
			
			<!-- LAVADERO -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Lavadero</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLavadero'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtLavadero']; ?>
</td>
			</tr>
			
			<!-- LAVAPLATOS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Lavaplatos</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLavaplatos'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtLavaplatos']; ?>
</td>
			</tr>
			
			<!-- LAVAMANOS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Lavamanos</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numLavamanos'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtLavamanos']; ?>
</td>
			</tr>
			
			<!-- SANITARIO -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Sanitario</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numSanitario'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtSanitario']; ?>
</td>
			</tr>
			
			<!-- DUCHA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Ducha</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numDucha'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDucha']; ?>
</td>
			</tr>
			
			<!-- VIDRIOS-->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Vidrios</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoVidrios'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtVidrios']; ?>
</td>
			</tr>
			
			<!-- PINTURA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Pintura</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoPintura'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtPintura']; ?>
</td>
			</tr>
			
			<!-- OTROS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c2','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Otros</b></td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtOtros'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtObservacionOtros']; ?>
</td>
			</tr>
		</table>

<!-- FIN PAGINA 1 -->
		
		<p class="salto">&nbsp;</p>

<!-- INICIO PAGINA 2 -->

		<!-- TITULO DE LA CARTA DE IMPRESION -->
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
			<tr>
				<td width="150px" height="80px" align="center" valign="middle">
               <?php if (in_array ( 31 , $_SESSION['arrGrupos']['3'] ) || in_array ( 32 , $_SESSION['arrGrupos']['3'] ) || in_array ( 33 , $_SESSION['arrGrupos']['3'] )): ?>
                  <img src="../../recursos/imagenes/cvp.png">
               <?php else: ?>
                  <img src="../../recursos/imagenes/escudo.png">
               <?php endif; ?>
            </td>
				<td align="center" valign="middle" style="padding:20px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
">
					<b>Certificado de Existencia y Habitabilidad</b><br>
					<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">Fecha de Emisión: <?php echo $this->_tpl_vars['txtFecha']; ?>
</span><br>
					<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">Fecha de visita: <?php echo $this->_tpl_vars['txtFechaVisita']; ?>
</span>
				</td>
				<td width="150px" align="center" valign="middle">
					<img src="../../recursos/imagenes/bta_positiva_carta.jpg">
				</td>
			</tr>
		</table><br>
	
		<!-- INFORMACION GENERAL -->
		<table cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
			<tr><td colspan="3" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4"><b>Información General</b></td></tr>
			
			<!-- NOMBRE DEL BENEFICIARIO -->
			<tr>
				<td><b>Nombre del Beneficiario:</b></td>
				<td><b>Documento</b></td>
				<td><b>Teléfono</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['claCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtNombre2; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido2; ?>
</td>
				<td><?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocCiudadano']]; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->numDocumento; ?>
</td>
				<td><?php echo $this->_tpl_vars['claFormulario']->numTelefono1; ?>
 ó <?php echo $this->_tpl_vars['claFormulario']->numTelefono2; ?>
 Celular <?php echo $this->_tpl_vars['claFormulario']->numCelular; ?>
</td>
			</tr>
			
			<!-- NOMBRE DEL VENDEDOR -->
			<tr>
				<td><b>Vendedor, Oferente y/o Constructor:</b></td>
				<td><b>Documento</b></td>
				<td><b>Teléfono</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['txtNombreVendedor']; ?>
</td>
				<td><?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocVendedor']]; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['numDocumentoVendedor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td><?php echo $this->_tpl_vars['numTelefonoVendedor']; ?>
</td>
			</tr>
			
			<!-- DIRECCION DEL PREDIO -->
			<tr>
				<td><b>Nombre del Proyecto:</b></td>
				<td><b>Dirección</b></td>
				<td><b>Tipo de Oferta</b></td>
			</tr>
			
			<!-- PROYECTO, MODALIDAD -->
			<tr>
				<td><?php echo $this->_tpl_vars['arrProyectos'][$this->_tpl_vars['seqProyecto']]; ?>
</td>
				<td><?php echo $this->_tpl_vars['txtDireccionInmueble']; ?>
</td>
				<td><?php echo $this->_tpl_vars['arrModalidad'][$this->_tpl_vars['seqModalidad']]; ?>
 - <?php echo $this->_tpl_vars['arrSolucionDescripcion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]; ?>
</td>
			</tr>		
			
			<!-- LOCALIDAD / BARRIO O VEREDA -->
			<tr>
				<td><b>Localidad:</b></td>
				<td><b>Barrio o Vereda</b></td>
				<td><b>Tipo de Predio</b></td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['arrLocalidad'][$this->_tpl_vars['seqLocalidad']]; ?>
</td>
				<td><?php echo $this->_tpl_vars['txtBarrio']; ?>
</td>
				<td><?php echo $this->_tpl_vars['txtTipoPredio']; ?>
</td>
			</tr>
			
		</table><br>
		
		<!-- CONDICIONES ESPACIALES DE LA VIVIENDA -->
		<table cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
			<tr><td colspan="5" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4"><b>Condiciones Espaciales de la Vivienda</b></td></tr>
			
			<tr>
				<td style="border-bottom: 1px solid #999999" width="150px"><b>Descripción</b></td>
				<td style="border-bottom: 1px solid #999999" width="100px" align="right"><b>Contador</b></td>
				<td style="border-bottom: 1px solid #999999; padding-left:10px;" width="120px"><b>Estado Conexión</b></td>
				<td style="border-bottom: 1px solid #999999; padding-left:10px"><b>Observaciones</b></td>
			</tr>
			
			<!-- SERVICIO DE AGUA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Servicio de Agua</b></td>
				<td align="right"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['numContadorAgua']; ?>
</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoConexionAgua'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionAgua']; ?>
</td>
			</tr>
			
			<!-- SERVICIO DE ENERGIA -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Servicio de Energía</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numContadorEnergia'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoConexionEnergia'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionEnergia']; ?>
</td>
			</tr>
			
			<!-- SERVICIO DE ALCANTARILLADO -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Servicio de Alcantarillado</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numContadorAlcantarillado'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoConexionAlcantarillado'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionAlcantarillado']; ?>
</td>
			</tr>
			
			<!-- SERVICIO DE GAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Servicio de Gas</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numContadorGas'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoConexionGas'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionGas']; ?>
</td>
			</tr>
			
			<!-- SERVICIO DE telefono -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Servicio de Teléfono</b></td>
				<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['numContadorTelefono'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoConexionTelefono'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionTelefono']; ?>
</td>
			</tr>
			
			<!-- ANDENES -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Andenes</b></td>
				<td align="right">&nbsp;</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoAndenes'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionAndenes']; ?>
</td>
			</tr>
			
			<!-- VIAS -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Vias</b></td>
				<td align="right">&nbsp;</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoVias'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionVias']; ?>
</td>
			</tr>
			
			<!-- SERVICIOS COMUNALES -->
			<tr bgcolor="<?php echo smarty_function_cycle(array('name' => 'c3','values' => "#EAEAEA,#FFFFFF"), $this);?>
">
				<td><b>Servicios Comunales</b></td>
				<td align="right">&nbsp;</td>
				<td style="padding-left:10px;"><?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtEstadoServiciosComunales'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</td>
				<td style="padding-left:10px;"><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionServiciosComunales']; ?>
</td>
			</tr>
			
			<tr><td colspan="4">&nbsp;</td></tr>
			
			<!-- DESCRIPCION DE LA VIVIENDA -->
			<tr><td colspan="4" style="border-top: 1px solid #999999; border-bottom: 1px solid #999999;">
				<b>Descripcion de la vivienda</b>
			</td></tr>
			<tr><td colspan="4" style="padding-left:20px; padding-right:20px; padding-top:5px; padding-bottom:5px; border-bottom: 1px solid #999999;" align="justify">
				<?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionVivienda']; ?>

			</td></tr>
			
		</table><br>
		
		<table cellspacing="0" cellpadding="0" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
		
			<!-- NORMA NSR-98 -->
			 <!--
			<tr><td>
				<b>Cumple con los requisitos de la norma NSR-98:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtNormaNSR98'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
<br>
				<u>Recomendaciones:</u><br>
				<?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescipcionNormaNSR98']; ?>
&nbsp;
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			-->

			<!-- REQUISITOS DE TERMINACION -->	
			 <!--
			<tr><td>
				<b>Cumple la vivienda con los requisitos de terminación, calidad y estabilidad:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtRequisitos'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
<br>
				<u>Recomendaciones:</u><br>
				<?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionRequisitos']; ?>
&nbsp;
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			-->
			
			<!-- CRITERIOS DE EXISTENCIA Y HABITABILIDAD -->	
			<tr><td>
				<b>Cumple la vivienda con los requisitos de existencia y habitabilidad:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['claDesembolso']->arrTecnico['txtExistencia'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
<br>
				<u>Recomendaciones:</u><br>
				<?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['txtDescripcionExistencia']; ?>
&nbsp;
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			
			<!-- TEXTO DE PIE DE PAGINA PAGINA 2 -->
			<tr><td align="justify" style="padding-left: 20px; padding-right: 20px;">
				
            El presente certificado se expide con base en una visita ocular adelantada por parte del equipo técnico de la 
            <?php if (in_array ( 31 , $_SESSION['arrGrupos']['3'] ) || in_array ( 32 , $_SESSION['arrGrupos']['3'] ) || in_array ( 33 , $_SESSION['arrGrupos']['3'] )): ?>
               Caja de vivienda popular;
            <?php else: ?>
               Subdirección de Recursos Públicos;
            <?php endif; ?>
            en esta no se observa que la vivienda presente afectaciones o fallas estructurales que pongan en riesgo a sus habitantes o afecten la 
            habitabilidad del inmueble. La vivienda dispone de los servicios públicos básicos definitivos y cumple con lo establecido en la Resolución 
            844 de 09 de octubre de 2014, modificada por la Resolución 575 de 05 de junio de 2015
            <?php if (in_array ( 31 , $_SESSION['arrGrupos']['3'] ) || in_array ( 32 , $_SESSION['arrGrupos']['3'] ) || in_array ( 33 , $_SESSION['arrGrupos']['3'] )): ?>
               y el art&iacute;culo 8 del decreto 255 de 2014
            <?php endif; ?>.<br>
            <?php if (in_array ( 31 , $_SESSION['arrGrupos']['3'] ) || in_array ( 32 , $_SESSION['arrGrupos']['3'] ) || in_array ( 33 , $_SESSION['arrGrupos']['3'] )): ?>
               La Caja de Vivienda Popular
            <?php else: ?>
               La Secretaria Distrital de Hábitat 
            <?php endif; ?>
            <b>NO</b> garantiza la calidad estructural de la vivienda, la calidad de los materiales empleados, 
            ni la correcta ejecución del proceso constructivo adelantado en la construcción de esta vivienda.<br>
            El presente certificado se expide a los <?php echo $this->_tpl_vars['numDiaActual']; ?>
 dias del mes de <?php echo $this->_tpl_vars['txtMesActual']; ?>
 de <?php echo $this->_tpl_vars['numAnoActual']; ?>
.
			</td></tr>
			
			<!-- FIRMA DEL ARQUITECTO -->
			<tr>
				<td><table valign="bottom"  cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
" ><tr><td>
				
				<td height ="120px" valign="bottom" align="left" style="padding: 20px">
                                    
                                    <!--
					 VoBo. ________________________________________<br><br>
					 FABIO H OSPINA J<br> T.P 2570050993CND<br>COORDINADOR AREA TECNICA
                                    
                                    -->
                                    
				</td>
				<td height="120px" valign="bottom" align="right" style="padding: 20px">
					_____________________________________________<br><br>
					M.P. <?php echo $this->_tpl_vars['txtMatriculaProfesional']; ?>
<br><br>
					<?php echo $this->_tpl_vars['txtUsuarioSesion']; ?>

				</td>
				</td></tr></table></td>
			</tr>
			
		</table>
		
<!-- FIN PAGINA 2 -->

		<p class="salto">&nbsp;</p>

<!-- INICIO PAGINAS DINAMICAS DE ACUERDO AL NUMERO DE FOTOS CARGADAS -->
		
		<?php $this->assign('numImagenes', count($this->_tpl_vars['claDesembolso']->arrTecnico['imagenes'])); ?>
		<?php echo smarty_function_math(array('equation' => "( x / y )",'x' => $this->_tpl_vars['numImagenes'],'y' => 6,'assign' => 'numPaginas'), $this);?>

		<?php echo smarty_function_math(array('equation' => "x + y",'x' => $this->_tpl_vars['numPaginas'],'y' => 1,'assign' => 'numPaginas'), $this);?>

		
		<?php unset($this->_sections['paginas']);
$this->_sections['paginas']['name'] = 'paginas';
$this->_sections['paginas']['loop'] = is_array($_loop=ceil($this->_tpl_vars['numPaginas'])) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['paginas']['start'] = (int)1;
$this->_sections['paginas']['show'] = true;
$this->_sections['paginas']['max'] = $this->_sections['paginas']['loop'];
$this->_sections['paginas']['step'] = 1;
if ($this->_sections['paginas']['start'] < 0)
    $this->_sections['paginas']['start'] = max($this->_sections['paginas']['step'] > 0 ? 0 : -1, $this->_sections['paginas']['loop'] + $this->_sections['paginas']['start']);
else
    $this->_sections['paginas']['start'] = min($this->_sections['paginas']['start'], $this->_sections['paginas']['step'] > 0 ? $this->_sections['paginas']['loop'] : $this->_sections['paginas']['loop']-1);
if ($this->_sections['paginas']['show']) {
    $this->_sections['paginas']['total'] = min(ceil(($this->_sections['paginas']['step'] > 0 ? $this->_sections['paginas']['loop'] - $this->_sections['paginas']['start'] : $this->_sections['paginas']['start']+1)/abs($this->_sections['paginas']['step'])), $this->_sections['paginas']['max']);
    if ($this->_sections['paginas']['total'] == 0)
        $this->_sections['paginas']['show'] = false;
} else
    $this->_sections['paginas']['total'] = 0;
if ($this->_sections['paginas']['show']):

            for ($this->_sections['paginas']['index'] = $this->_sections['paginas']['start'], $this->_sections['paginas']['iteration'] = 1;
                 $this->_sections['paginas']['iteration'] <= $this->_sections['paginas']['total'];
                 $this->_sections['paginas']['index'] += $this->_sections['paginas']['step'], $this->_sections['paginas']['iteration']++):
$this->_sections['paginas']['rownum'] = $this->_sections['paginas']['iteration'];
$this->_sections['paginas']['index_prev'] = $this->_sections['paginas']['index'] - $this->_sections['paginas']['step'];
$this->_sections['paginas']['index_next'] = $this->_sections['paginas']['index'] + $this->_sections['paginas']['step'];
$this->_sections['paginas']['first']      = ($this->_sections['paginas']['iteration'] == 1);
$this->_sections['paginas']['last']       = ($this->_sections['paginas']['iteration'] == $this->_sections['paginas']['total']);
?>
		
			<!-- TITULO DE LA CARTA DE IMPRESION -->
			<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border: 1px solid #999999;">
				<tr>
					<td width="150px" height="80px" align="center" valign="middle">
                  <?php if (in_array ( 31 , $_SESSION['arrGrupos']['3'] ) || in_array ( 32 , $_SESSION['arrGrupos']['3'] ) || in_array ( 33 , $_SESSION['arrGrupos']['3'] )): ?>
                     <img src="../../recursos/imagenes/cvp.png">
                  <?php else: ?>
                     <img src="../../recursos/imagenes/escudo.png">
                  <?php endif; ?>
               </td>
					<td align="center" valign="middle" style="padding:20px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
">
						<b>Certificado de Existencia y Habitabilidad</b><br>
						<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">Fecha de Emisión: <?php echo $this->_tpl_vars['txtFecha']; ?>
</span><br>
						<span style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">Fecha de visita: <?php echo $this->_tpl_vars['txtFechaVisita']; ?>
</span>
					</td>
					<td width="150px" align="center" valign="middle">
						<img src="../../recursos/imagenes/bta_positiva_carta.jpg">
					</td>
				</tr>
			</table><br>
		
			<!-- INFORMACION GENERAL -->
			<table cellspacing="0" cellpadding="1" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
				<tr><td colspan="3" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4"><b>Información General</b></td></tr>
				
				<!-- NOMBRE DEL BENEFICIARIO -->
				<tr>
					<td><b>Nombre del Beneficiario:</b></td>
					<td><b>Documento</b></td>
					<td><b>Teléfono</b></td>
				</tr>
				<tr>
					<td><?php echo $this->_tpl_vars['claCiudadano']->txtNombre1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtNombre2; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido1; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->txtApellido2; ?>
</td>
					<td><?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocCiudadano']]; ?>
 <?php echo $this->_tpl_vars['claCiudadano']->numDocumento; ?>
</td>
					<td><?php echo $this->_tpl_vars['claFormulario']->numTelefono1; ?>
 ó <?php echo $this->_tpl_vars['claFormulario']->numTelefono2; ?>
 Celular <?php echo $this->_tpl_vars['claFormulario']->numCelular; ?>
</td>
				</tr>
				
				<!-- NOMBRE DEL VENDEDOR -->
				<tr>
					<td><b>Vendedor, Oferente y/o Constructor:</b></td>
					<td><b>Documento</b></td>
					<td><b>Teléfono</b></td>
				</tr>
				<tr>
					<td><?php echo $this->_tpl_vars['txtNombreVendedor']; ?>
</td>
					<td><?php echo $this->_tpl_vars['arrTipoDocumento'][$this->_tpl_vars['tipoDocVendedor']]; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['numDocumentoVendedor'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ',', '.') : number_format($_tmp, 0, ',', '.')); ?>
</td>
					<td><?php echo $this->_tpl_vars['numTelefonoVendedor']; ?>
</td>
				</tr>
				
				<!-- DIRECCION DEL PREDIO -->
				<tr>
					<td><b>Nombre del Proyecto:</b></td>
					<td><b>Dirección</b></td>
					<td><b>Tipo de Oferta</b></td>
				</tr>
				
				<!-- PROYECTO, MODALIDAD -->
				<tr>
					<td><?php echo $this->_tpl_vars['arrProyectos'][$this->_tpl_vars['seqProyecto']]; ?>
</td>
					<td><?php echo $this->_tpl_vars['txtDireccionInmueble']; ?>
</td>
					<td><?php echo $this->_tpl_vars['arrModalidad'][$this->_tpl_vars['seqModalidad']]; ?>
 - <?php echo $this->_tpl_vars['arrSolucionDescripcion'][$this->_tpl_vars['seqModalidad']][$this->_tpl_vars['seqSolucion']]; ?>
</td>
				</tr>			
				
				<!-- LOCALIDAD / BARRIO O VEREDA -->
				<tr>
					<td><b>Localidad:</b></td>
					<td><b>Barrio o Vereda</b></td>
					<td><b>Tipo de Predio</b></td>
				</tr>
				<tr>
					<td><?php echo $this->_tpl_vars['arrLocalidad'][$this->_tpl_vars['seqLocalidad']]; ?>
</td>
					<td><?php echo $this->_tpl_vars['txtBarrio']; ?>
</td>
					<td><?php echo $this->_tpl_vars['txtTipoPredio']; ?>
</td>
				</tr>
				
			</table><br>		
			
			<table cellspacing="5" cellpadding="0" border="0" width="100%" style="<?php echo $this->_tpl_vars['txtFuente10']; ?>
">
				<tr><td colspan="3" style="padding:5px; <?php echo $this->_tpl_vars['txtFuente12']; ?>
" bgcolor="#E4E4E4">
					<b>Registro Fotográfico</b>
				</td></tr>
				<?php echo smarty_function_math(array('equation' => "x * y",'x' => $this->_sections['paginas']['index'],'y' => 6,'assign' => 'numLoops'), $this);?>

				<?php echo smarty_function_math(array('equation' => "x - y",'x' => $this->_sections['paginas']['index'],'y' => 1,'assign' => 'numIndice'), $this);?>

				<?php echo smarty_function_math(array('equation' => "x * y",'x' => $this->_tpl_vars['numIndice'],'y' => 6,'assign' => 'numStart'), $this);?>

				<?php unset($this->_sections['lineas']);
$this->_sections['lineas']['name'] = 'lineas';
$this->_sections['lineas']['loop'] = is_array($_loop=$this->_tpl_vars['numLoops']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['lineas']['start'] = (int)$this->_tpl_vars['numStart'];
$this->_sections['lineas']['show'] = true;
$this->_sections['lineas']['max'] = $this->_sections['lineas']['loop'];
$this->_sections['lineas']['step'] = 1;
if ($this->_sections['lineas']['start'] < 0)
    $this->_sections['lineas']['start'] = max($this->_sections['lineas']['step'] > 0 ? 0 : -1, $this->_sections['lineas']['loop'] + $this->_sections['lineas']['start']);
else
    $this->_sections['lineas']['start'] = min($this->_sections['lineas']['start'], $this->_sections['lineas']['step'] > 0 ? $this->_sections['lineas']['loop'] : $this->_sections['lineas']['loop']-1);
if ($this->_sections['lineas']['show']) {
    $this->_sections['lineas']['total'] = min(ceil(($this->_sections['lineas']['step'] > 0 ? $this->_sections['lineas']['loop'] - $this->_sections['lineas']['start'] : $this->_sections['lineas']['start']+1)/abs($this->_sections['lineas']['step'])), $this->_sections['lineas']['max']);
    if ($this->_sections['lineas']['total'] == 0)
        $this->_sections['lineas']['show'] = false;
} else
    $this->_sections['lineas']['total'] = 0;
if ($this->_sections['lineas']['show']):

            for ($this->_sections['lineas']['index'] = $this->_sections['lineas']['start'], $this->_sections['lineas']['iteration'] = 1;
                 $this->_sections['lineas']['iteration'] <= $this->_sections['lineas']['total'];
                 $this->_sections['lineas']['index'] += $this->_sections['lineas']['step'], $this->_sections['lineas']['iteration']++):
$this->_sections['lineas']['rownum'] = $this->_sections['lineas']['iteration'];
$this->_sections['lineas']['index_prev'] = $this->_sections['lineas']['index'] - $this->_sections['lineas']['step'];
$this->_sections['lineas']['index_next'] = $this->_sections['lineas']['index'] + $this->_sections['lineas']['step'];
$this->_sections['lineas']['first']      = ($this->_sections['lineas']['iteration'] == 1);
$this->_sections['lineas']['last']       = ($this->_sections['lineas']['iteration'] == $this->_sections['lineas']['total']);
?>
					<?php $this->assign('numPosicion', $this->_sections['lineas']['index']); ?>
					
					
					<?php if (fmod ( $this->_tpl_vars['numPosicion'] , 3 ) == 0): ?>
						<tr>
					<?php endif; ?>
					
					<td width="33%" 
						height="250px" 
						style="padding:5px; border: 1px dotted #999999;"
						valign="top"
					>
						<?php if (isset ( $this->_tpl_vars['claDesembolso']->arrTecnico['imagenes'][$this->_tpl_vars['numPosicion']] )): ?>
							<b><?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['imagenes'][$this->_tpl_vars['numPosicion']]['nombre']; ?>
</b><hr>
							<center>
							<img src="../../recursos/imagenes/desembolsos/<?php echo $this->_tpl_vars['claDesembolso']->arrTecnico['imagenes'][$this->_tpl_vars['numPosicion']]['ruta']; ?>
"
								 width="220px"
								 height="220px"
							/>
							</center>
						<?php else: ?>
							&nbsp;
						<?php endif; ?>
					</td>
					
					<?php if ($this->_tpl_vars['numPosicion'] != 0): ?>
						<?php if (fmod ( ( $this->_tpl_vars['numPosicion'] + 1 ) , 3 ) == 0): ?>
							</tr></tr>
						<?php endif; ?>
					<?php endif; ?>
					
				<?php endfor; endif; ?>
			</table>
			
			<p class="salto">&nbsp;</p>
			
				
		<?php endfor; endif; ?>

<!-- FIN PAGINAS DINAMICAS -->

		<?php endif; ?>
						
	</body>
</html>