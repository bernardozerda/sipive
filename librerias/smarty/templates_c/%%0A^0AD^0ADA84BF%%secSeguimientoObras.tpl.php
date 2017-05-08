<?php /* Smarty version 2.6.26, created on 2017-05-05 08:07:13
         compiled from proyectos/secSeguimientoObras.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'proyectos/secSeguimientoObras.tpl', 9, false),)), $this); ?>
<p><img src="recursos/imagenes/blank.gif" onload="init();">
<table border="0" cellspacing="2" cellpadding="0" width="860">
	<tr><td class="tituloTabla" colspan="7">VISITAS DE SEGUIMIENTOS A OBRA</td></tr>
	<tr><td colspan="7" align="right"><div onClick="addSeguimientoObras('<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialTerreno; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalTerreno; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncTerreno; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActTerreno; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPreliminarConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPreliminarConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPreliminarConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPreliminarConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCimentacionConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCimentacionConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCimentacionConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCimentacionConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialDesaguesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalDesaguesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncDesaguesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActDesaguesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialEstructuraConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalEstructuraConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncEstructuraConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActEstructuraConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialMamposteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalMamposteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncMamposteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActMamposteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPanetesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPanetesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPanetesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPanetesConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialHidrosanitariasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalHidrosanitariasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncHidrosanitariasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActHidrosanitariasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialElectricasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalElectricasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncElectricasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActElectricasConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCubiertaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCubiertaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCubiertaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCubiertaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCarpinteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCarpinteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCarpinteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCarpinteriaConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPisosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPisosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPisosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPisosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialSanitariosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalSanitariosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncSanitariosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActSanitariosConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialExterioresConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalExterioresConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncExterioresConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActExterioresConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialAseoConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalAseoConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncAseoConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActAseoConstruccion; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialPreliminarUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalPreliminarUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncPreliminarUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActPreliminarUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialCimentacionUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalCimentacionUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncCimentacionUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActCimentacionUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialDesaguesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalDesaguesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncDesaguesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActDesaguesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialViasUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalViasUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncViasUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActViasUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialParquesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalParquesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncParquesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActParquesUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchInicialAseoUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->fchFinalAseoUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->porcIncAseoUrbanismo; ?>
', '<?php echo $this->_tpl_vars['objFormularioProyecto']->valActAseoUrbanismo; ?>
')" style="cursor: hand">Adicionar Visita<img src="recursos/imagenes/plus_icon.gif"></div></td></tr>
</table>
<div style="width:860px; height:500px; overflow: scroll;">
	<table border="0" cellspacing="2" cellpadding="0" width="1700" id="tablaSeguimientoObras"><tr><td>
		<?php $this->assign('num', '0'); ?>
		<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'num'), $this);?>

		<?php $_from = $this->_tpl_vars['arrSeguimientoCronogramaObras']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqSeguimientoCronogramaObras'] => $this->_tpl_vars['arrSeguimiento']):
?>
			<?php echo smarty_function_counter(array('print' => false), $this);?>

			<?php $this->assign('actual', "r_".($this->_tpl_vars['num'])); ?>
		<div class="accordionItem">
			<h2>Visita <?php echo $this->_tpl_vars['arrSeguimiento']['fchVisita']; ?>

			<input type="hidden" name="fchVisita[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchVisita[<?php echo $this->_tpl_vars['actual']; ?>
]" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchVisita']; ?>
">
			<input type="hidden" name="seqSeguimientoCronogramaObras[<?php echo $this->_tpl_vars['actual']; ?>
]" id="seqSeguimientoCronogramaObras[<?php echo $this->_tpl_vars['actual']; ?>
]" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['seqSeguimientoCronogramaObras']; ?>
"></h2>
			<div>
				<table border="0" cellspacing="2" cellpadding="0" width="100%">
								<tr class="tituloTabla">
								<th align="center" style="padding:3px;" rowspan="2" width="12%">Actividad</th>
								<th align="center" style="padding:3px; border-width: 2px; border-style: dotted;" colspan="3">Fecha Inicial Actividad</th>
								<th align="center" style="padding:3px; border-width: 2px; border-style: dotted;" colspan="3">Fecha Final Actividad</th>
								<th align="center" style="padding:3px; border-width: 2px; border-style: dotted;" colspan="3">% Incidencia</th>
								<th align="center" style="padding:3px; border-width: 2px; border-style: dotted;" colspan="3">Valor Actividad</th></tr>
								<tr class="tituloTabla">
								<th align="center" style="padding:3px;" width="7%">Proyectada</th>
								<th align="center" style="padding:3px;" width="7%">Ejecutada</th>
								<th align="center" style="padding:3px;" width="7%">Desfase (D&iacute;as)</th>
								<th align="center" style="padding:3px;" width="7%">Proyectada</th>
								<th align="center" style="padding:3px;" width="7%">Ejecutada</th>
								<th align="center" style="padding:3px;" width="7%">Desfase (D&iacute;as)</th>
								<th align="center" style="padding:3px;" width="7%">Proyectado</th>
								<th align="center" style="padding:3px;" width="7%">Ejecutado</th>
								<th align="center" style="padding:3px;" width="7%">Desfase</th>
								<th align="center" style="padding:3px;" width="7%">Proyectado</th>
								<th align="center" style="padding:3px;" width="7%">Ejecutado</th>
								<th align="center" style="padding:3px;" width="7%">Desfase</th>
								<!-- //////////////////////////////////////////////// TERRENO ///////////////////////////////////////////////////// -->
			<tr><td class="tituloNivel0" colspan="9">Terreno</td></tr>
		<!-- TERRENO (TERRENO) -->
			<tr class="fila_0"><td class="tituloNivel1">Terreno</td>
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialTerrenoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialTerrenoSeg']; ?>
" /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialTerreno']; ?>
" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalTerrenoPry']; ?>
"></td>	
				<td align="center" valign="top"><input type="text" name="fchFinalTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalTerrenoSeg']; ?>
" /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalTerreno']; ?>
" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncTerrenoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncTerrenoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncTerreno']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActTerrenoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActTerrenoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActTerrenoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActTerrenoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActTerreno[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActTerreno']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- //////////////////////////////////////////// CONSTRUCCION//////////////////////////////////////////////////// -->
			<tr><td class="tituloNivel0" colspan="9">Construcci&oacute;n</td></tr>
		<!-- PRELIMINARES (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Preliminares</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPreliminarConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPreliminarConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialPreliminarConstruccion']; ?>
" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPreliminarConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPreliminarConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalPreliminarConstruccion']; ?>
" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPreliminarConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPreliminarConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncPreliminarConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPreliminarConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPreliminarConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPreliminarConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActPreliminarConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActPreliminarConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActPreliminarConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- CIMENTACION (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Cimentaci&oacute;n</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCimentacionConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCimentacionConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialCimentacionConstruccion']; ?>
" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCimentacionConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCimentacionConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalCimentacionConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCimentacionConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCimentacionConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncCimentacionConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCimentacionConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCimentacionConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCimentacionConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActCimentacionConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActCimentacionConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActCimentacionConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- DESAGUES (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Desag&uuml;es e instalaciones sanitarias</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialDesaguesConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialDesaguesConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialDesaguesConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalDesaguesConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalDesaguesConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalDesaguesConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncDesaguesConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncDesaguesConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncDesaguesConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActDesaguesConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActDesaguesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActDesaguesConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActDesaguesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActDesaguesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActDesaguesConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- ESTRUCTURA (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Estructura en concreto</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialEstructuraConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialEstructuraConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialEstructuraConstruccion']; ?>
" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalEstructuraConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalEstructuraConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalEstructuraConstruccion']; ?>
" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncEstructuraConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncEstructuraConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncEstructuraConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActEstructuraConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActEstructuraConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActEstructuraConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActEstructuraConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActEstructuraConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActEstructuraConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- MAMPOSTERIA (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Mamposter&iacute;a</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialMamposteriaConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialMamposteriaConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialMamposteriaConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalMamposteriaConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalMamposteriaConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalMamposteriaConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncMamposteriaConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncMamposteriaConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncMamposteriaConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActMamposteriaConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActMamposteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActMamposteriaConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActMamposteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActMamposteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActMamposteriaConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- PANETES (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Pa&ntilde;etes y resanes</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPanetesConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPanetesConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialPanetesConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPanetesConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPanetesConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalPanetesConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPanetesConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPanetesConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncPanetesConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPanetesConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPanetesConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPanetesConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActPanetesConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActPanetesConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActPanetesConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- HIDROSANITARIA (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Instalaciones hidrosanitarias</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialHidrosanitariasConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialHidrosanitariasConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialHidrosanitariasConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalHidrosanitariasConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalHidrosanitariasConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalHidrosanitariasConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncHidrosanitariasConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncHidrosanitariasConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncHidrosanitariasConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActHidrosanitariasConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActHidrosanitariasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActHidrosanitariasConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActHidrosanitariasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActHidrosanitariasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActHidrosanitariasConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- ELECTRICAS (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Instalaciones el&eacute;ctricas</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialElectricasConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialElectricasConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialElectricasConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalElectricasConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalElectricasConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalElectricasConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncElectricasConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncElectricasConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncElectricasConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActElectricasConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActElectricasConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActElectricasConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActElectricasConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActElectricasConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActElectricasConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- CUBIERTA (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Cubierta</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCubiertaConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCubiertaConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialCubiertaConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCubiertaConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCubiertaConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalCubiertaConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCubiertaConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCubiertaConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncCubiertaConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCubiertaConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCubiertaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCubiertaConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActCubiertaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActCubiertaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActCubiertaConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- CARPINTERIA (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Carpinter&iacute;a met&aacute;lica</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCarpinteriaConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCarpinteriaConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialCarpinteriaConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCarpinteriaConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCarpinteriaConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalCarpinteriaConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCarpinteriaConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCarpinteriaConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncCarpinteriaConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCarpinteriaConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCarpinteriaConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCarpinteriaConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActCarpinteriaConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActCarpinteriaConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActCarpinteriaConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- PISOS (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Pisos, enchapes y acabados</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPisosConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPisosConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialPisosConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPisosConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPisosConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalPisosConstruccion']; ?>
" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPisosConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPisosConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncPisosConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPisosConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPisosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPisosConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActPisosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActPisosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActPisosConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- SANITARIOS (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Aparatos sanitarios y lavaplatos</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialSanitariosConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialSanitariosConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialSanitariosConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalSanitariosConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalSanitariosConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalSanitariosConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncSanitariosConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncSanitariosConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncSanitariosConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActSanitariosConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActSanitariosConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActSanitariosConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActSanitariosConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActSanitariosConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActSanitariosConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- EXTERIORES (CONSTRUCCION) -->
			<tr class="fila_0"><td class="tituloNivel1">Obras exteriores</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialExterioresConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialExterioresConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialExterioresConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalExterioresConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalExterioresConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalExterioresConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncExterioresConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncExterioresConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncExterioresConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActExterioresConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActExterioresConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActExterioresConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActExterioresConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActExterioresConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActExterioresConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- ASEO (CONSTRUCCION) -->
			<tr class="fila_1"><td class="tituloNivel1">Aseo</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialAseoConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialAseoConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialAseoConstruccion']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalAseoConstruccionPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalAseoConstruccionSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" size="6" style="text-align:right" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalAseoConstruccion']; ?>
" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncAseoConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncAseoConstruccionSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncAseoConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActAseoConstruccionPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActAseoConstruccionSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActAseoConstruccionSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActAseoConstruccionPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActAseoConstruccion[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActAseoConstruccion']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- //////////////////////////////////////////////// URBANISMO /////////////////////////////////////////////////-->
			<tr><td class="tituloNivel0" colspan="9">Urbanismo</td></tr>
		<!-- PRELIMINARES (URBANISMO) -->
			<tr class="fila_0"><td class="tituloNivel1">Preliminares</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPreliminarUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialPreliminarUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialPreliminarUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPreliminarUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalPreliminarUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalPreliminarUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPreliminarUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncPreliminarUrbanismoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncPreliminarUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPreliminarUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActPreliminarUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActPreliminarUrbanismoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActPreliminarUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActPreliminarUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActPreliminarUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		
		<!-- CIMENTACION (URBANISMO) -->
			<tr class="fila_1"><td class="tituloNivel1">Cimentaci&oacute;n</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCimentacionUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialCimentacionUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialCimentacionUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCimentacionUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalCimentacionUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalCimentacionUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCimentacionUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncCimentacionUrbanismoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncCimentacionUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCimentacionUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActCimentacionUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActCimentacionUrbanismoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActCimentacionUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActCimentacionUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActCimentacionUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- DESAGUES (URBANISMO) -->
			<tr class="fila_0"><td class="tituloNivel1">Desag&uuml;es e instalaciones sanitarias</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialDesaguesUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialDesaguesUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialDesaguesUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalDesaguesUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalDesaguesUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalDesaguesUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncDesaguesUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncDesaguesUrbanismoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncDesaguesUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActDesaguesUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActDesaguesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActDesaguesUrbanismoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActDesaguesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActDesaguesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActDesaguesUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- VIAS Y ANDENES (URBANISMO) -->
			<tr class="fila_1"><td class="tituloNivel1">Estructura en concreto</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialViasUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialViasUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialViasUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalViasUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalViasUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalViasUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncViasUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncViasUrbanismoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncViasUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActViasUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActViasUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActViasUrbanismoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActViasUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActViasUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActViasUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- PARQUES Y CESIONES (URBANISMO) -->
			<tr class="fila_0"><td class="tituloNivel1">Mamposter&iacute;a</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialParquesUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialParquesUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialParquesUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalParquesUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalParquesUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalParquesUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncParquesUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncParquesUrbanismoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncParquesUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActParquesUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActParquesUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActParquesUrbanismoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActParquesUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActParquesUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActParquesUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
		<!-- ASEO (URBANISMO) -->
			<tr class="fila_1"><td class="tituloNivel1">Aseo</td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchInicialAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchInicialAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialAseoUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchInicialAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchInicialAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchInicialAseoUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchInicialAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchInicialAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchInicialAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchInicialAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchInicialAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchInicialAseoUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="fchFinalAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="fchFinalAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" size="10" style="text-align:center" class="campoReadonly" readonly value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalAseoUrbanismoPry']; ?>
"></td>	
				<td align="center" valign="top"><input name="fchFinalAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="fchFinalAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['fchFinalAseoUrbanismoSeg']; ?>
" size="10" style="text-align:center" readonly /><a href="#" onClick="javascript: calendarioPopUpCalcula( 'fchFinalAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]', document.getElementById('fchFinalAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difFchFinalAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]' ); "><img src="recursos/imagenes/calendar_icon_tr.gif"></a></td>	
				<td class="fechaNivel1" valign="top"><input type="text" name="difFchFinalAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difFchFinalAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difFchFinalAseoUrbanismo']; ?>
" size="6" style="text-align:right" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncAseoUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="porcIncAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="porcIncAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['porcIncAseoUrbanismoSeg']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('porcIncAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difPorcIncAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " class="campoPesos" size="12"></td>	
				<td class="campoNivel1" valign="top"><input type="text" name="difPorcIncAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difPorcIncAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difPorcIncAseoUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActAseoUrbanismoPry']; ?>
" class="campoPesosReadonly" size="12" readonly></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="valActAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" id="valActAseoUrbanismoSeg[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['valActAseoUrbanismoSeg']; ?>
" class="campoPesos" size="12" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this ); diferenciaValores(this, document.getElementById('valActAseoUrbanismoPry[<?php echo $this->_tpl_vars['actual']; ?>
]'), 'difValActAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]'); " ></td>	
				<td class="campoNivel1" valign="top">$ <input type="text" name="difValActAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" id="difValActAseoUrbanismo[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrSeguimiento']['difValActAseoUrbanismo']; ?>
" class="campoPesos" size="12" readonly ></td></tr>
				</table>
			</div>
		</div>
			<!--<?php echo smarty_function_counter(array('print' => false), $this);?>

			<?php $this->assign('actual', "r_".($this->_tpl_vars['num'])); ?>
			<div class="accordionItem">
				<h2>How to use a JavaScript accordion</h2>
				<div>
					<table>
						<tr>
							<td align="center" width="18%" valign="top" style="padding:6px;">
								<?php echo smarty_function_counter(array('print' => false), $this);?>

								<?php $this->assign('actual', "r_".($this->_tpl_vars['num'])); ?>
								<input type="hidden" name="seqCronogramaFecha[<?php echo $this->_tpl_vars['actual']; ?>
]" id="seqCronogramaFecha" value="<?php echo $this->_tpl_vars['arrCronograma']['seqCronogramaFecha']; ?>
" >
								Num. <input name="numActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="numActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['numActaDescriptiva']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:right" style="text-align:center" />
								 A&ntilde;o <input name="numAnoActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" type="text" id="numAnoActaDescriptiva[<?php echo $this->_tpl_vars['actual']; ?>
]" value="<?php echo $this->_tpl_vars['arrCronograma']['numAnoActaDescriptiva']; ?>
" onBlur="sinCaracteresEspeciales( this ); soloNumeros( this );" size="6" style="text-align:right" style="text-align:center" />
							</td>
							<td align="center" width="10%" valign="top" style="padding:6px;">
								<input type='button' value='Eliminar' onclick='return confirmaRemoverLineaFormulario(this);'>
							</td>
						</tr>
					</table>
				</div>
			</div>-->
		<?php endforeach; endif; unset($_from); ?>
	</td></tr></table>
</div>
</p>