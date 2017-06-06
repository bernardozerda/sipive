
    {php} setlocale(LC_TIME , 'spanish' ); {/php}

    {assign var="numAncho"   value="130px"}
    {assign var="numAlto"    value="40px"}
    {assign var="numPadding" value="2"}
    {assign var="numBorde"   value="0"}
    
    {assign var="txtVerde"    value="#d0ffd8"}
    {assign var="txtRojo"     value="#ffd7d7"}
    {assign var="txtAmarillo" value="#ffffd7"}
      
    <div id="regresar" hidden></div>
    
<!-- CONTROLES PARA EL MODULO -->
    <div id="controles" 
         style="width:98%; padding-top: 10px;"
         align="center"
    >
        <table border="{$numBorde}" cellpadding="0" cellspacing="{$numPadding}" width="100%">
            <tr align="center" style="vertical-align: middle;">
                <td width="{$numAncho}">
                    <strong>Registro de la Oferta</strong>
                </td>
                <td width="{$numAncho}" style="border-left: 1px dotted #666666;">
                    <strong>Revisi&oacute;n Jur&iacute;dica</strong>
                </td>
                <td width="{$numAncho}" style="border-left: 1px dotted #666666;">
                    <strong>Revisi&oacute;n T&eacute;cnica</strong>
                </td>
                <td width="{$numAncho}" style="border-left: 1px dotted #666666;">
                    <strong>Primera <br>Verificaci&oacute;n</strong>
                </td>
                <td width="{$numAncho}" style="border-left: 1px dotted #666666;">
                    <strong>Postulaci&oacute;n</strong>
                </td>
                <td width="{$numAncho}" style="border-left: 1px dotted #666666;">
                    <strong>Segunda<br>Verificaci&oacute;n</strong>
                </td>
            </tr>
        </table>
    </div>
    
<!-- CONTENIDOS DE CASA EN MANO -->
    <div id="cem" 
         style="width:98%; height:680px"
    ><p>
        <div>
            <table border="{$numBorde}" cellpadding="0" cellspacing="{$numPadding}" width="100%">
                {foreach from=$arrCasaMano key=seqCasaMano item=objCasaMano name=fases}
                    <tr align="center" style="vertical-align: middle;" bgcolor="{cycle values="#FFFFFF,#E4E4E4"}">

                        <!-- REGISTRO DE VIVIENDA -->
                        <td width="{$numAncho}" 
                            height="{$numAlto}"
                            style="cursor: pointer;"
                            onClick="cambioCEM(
                                        './contenidos/casaMano/registroOferta.php',
                                        'seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}&modificar={$smarty.foreach.fases.last}'
                                    );"
                        >
                            {if esFechaValida( $objCasaMano->fchRegistroVivienda )}
                                {$objCasaMano->fchRegistroVivienda|date_format|upper}
                            {else}
                                &nbsp;
                            {/if}
                        </td>

                        <!-- REVISION JURIDICA -->
                        <td width="{$numAncho}" 
                            height="{$numAlto}" 
                            style="border-left: 1px dotted #666666; 
                                   {if $objCasaMano->bolRevisionJuridica == 0}
                                       background-color: {$txtAmarillo}
                                   {elseif $objCasaMano->bolRevisionJuridica == 1}
                                       background-color: {$txtVerde}
                                   {else}
                                       background-color: {$txtRojo}
                                   {/if}
                            "
                            {if $objCasaMano->txtRevisionJuridica != ""}
                                onMouseOver="mostrarTooltip( this , '<div align=left>{$objCasaMano->txtRevisionJuridica}</div>' );"
                            {/if}
                        >
                            {if esFechaValida( $objCasaMano->fchRevisionJuridica )}
                                <div style="padding-bottom:5px; cursor: pointer;" 
                                     onClick="cambioCEM('./contenidos/casaMano/revisionJuridica.php',
                                                        'seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}&modificar={$smarty.foreach.fases.last}'
                                              );"
                                >
                                    {$objCasaMano->fchRevisionJuridica|date_format|upper}
                                </div>
                                <div style="cursor: pointer; 
                                            background-color: 
                                                {if $objCasaMano->numDiasRevisionJuridica >= $objCasaMano->numDiasLimiteRevsionJuridica} 
                                                    red 
                                                {else} 
                                                    green 
                                                {/if}; 
                                            font-size: 7px; 
                                            color: white; 
                                            font-weight: bold; 
                                            width:30px; 
                                            height: 10px;"
                                >
                                    {$objCasaMano->numDiasRevisionJuridica}
                                </div>
                            {else}
                                {if in_array( $claFormulario->seqEstadoProceso , $objCasaMano->arrFases.cem.revisionJuridica.permisos ) && $smarty.foreach.fases.last == 1}
                                    <button style="cursor: pointer;" onClick="cambioCEM('./contenidos/casaMano/revisionJuridica.php','seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}&modificar={$smarty.foreach.fases.last}');">
                                        <img src="./recursos/imagenes/plus_icon.gif">
                                    </button>
                                {/if}
                            {/if}
                        </td>

                        <!-- REVISION TECNICA -->
                        <td width="{$numAncho}" 
                            height="{$numAlto}" 
                            style="border-left: 1px dotted #666666; 
                                   {if $objCasaMano->bolRevisionTecnica == 0}
                                       background-color: {$txtAmarillo}
                                   {elseif $objCasaMano->bolRevisionTecnica == 1}
                                       background-color: {$txtVerde}
                                   {else}
                                       background-color: {$txtRojo}
                                   {/if}
                            "
                            {if $objCasaMano->txtRevisionTecnica != ""}
                                {if $objCasaMano->bolRevisionTecnica eq 0}
										onMouseOver="mostrarTooltip(this, '<div align=left>Concepto Final: En Proceso</div>');"
									{elseif $objCasaMano->bolRevisionTecnica eq 1}
										onMouseOver="mostrarTooltip(this, '<div align=left>Concepto Final: Viabilizado</div>');"
								{else}
										onMouseOver="mostrarTooltip(this, '<div align=left>Concepto Final: No viabilizado</div>');"
                            {/if}
                            {/if}
                        >
                            {if esFechaValida( $objCasaMano->fchRevisionTecnica )}
                                <div style="padding-bottom:5px; cursor: pointer;" 
                                     onClick="cambioCEM('./contenidos/casaMano/revisionTecnica.php',
                                                        'seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}&modificar={$smarty.foreach.fases.last}'
                                              );"
                                >
                                    {$objCasaMano->fchRevisionTecnica|date_format|upper}
                                </div>
                                
                                
                                
                                <div style="cursor: pointer; 
                                            background-color: 
                                                {if $objCasaMano->numDiasRevisionTecnica >= $objCasaMano->numDiasLimiteRevsionTecnica} 
                                                    red 
                                                {else} 
                                                    green 
                                                {/if}; 
                                            font-size: 7px; 
                                            color: white; 
                                            font-weight: bold; 
                                            width:30px; 
                                            height: 10px;"
                                    onClick="
                                       {if $objCasaMano->bolRevisionTecnica == 1}                                    
                                          
                                       {else}
                                          popUpPdfCasaMano( 'habitabilidadPdf.php' , 'exportar[]={$seqFormulario}' , '{$seqCasaMano}' )
                                       {/if}
                                    "
                                >
                                   {$objCasaMano->numDiasRevisionTecnica}
                                </div>
                            {else}
                                {if in_array( $claFormulario->seqEstadoProceso , $objCasaMano->arrFases.cem.revisionTecnica.permisos ) && $smarty.foreach.fases.last == 1}
                                    <button style="cursor: pointer;" onClick="cambioCEM('./contenidos/casaMano/revisionTecnica.php','seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}&modificar={$smarty.foreach.fases.last}');">
                                        <img src="./recursos/imagenes/plus_icon.gif">
                                    </button>
									<input type="checkbox" id="bolVisita" name="bolVisita">Con visita
                                {/if}
                            {/if}
                        </td>

                        <!-- PRIMERA VERIFICACION -->
                        <td width="{$numAncho}" 
                            height="{$numAlto}" 
                            style="border-left: 1px dotted #666666; 
                                   {if $objCasaMano->bolPrimeraVerificacion == 1}
                                       background-color: {$txtVerde}
                                   {elseif $objCasaMano->bolPrimeraVerificacion == 2}
                                       background-color: {$txtRojo}
                                   {/if}
                            "
                        >
                            {if esFechaValida( $objCasaMano->fchPrimeraVerificacion )}
                                <div style="padding-bottom:5px">
                                    {$objCasaMano->fchPrimeraVerificacion|date_format|upper}
                                </div>
                                {if $objCasaMano->bolPrimeraVerificacion == 2}
                                    <div style="cursor: pointer; 
                                                background-color: red; 
                                                font-size: 7px; 
                                                color: white; 
                                                font-weight: bold; 
                                                width:30px; 
                                                height: 10px;"
                                         onClick="popUpPdfCasaMano( 'exportarPdf.php' , 'exportar[]={$seqFormulario}' , '{$objCasaMano->seqPrimeraVerificacion}' )"
                                    >
                                        PDF
                                    </div>
                                {/if}    
                            {else}
                                &nbsp;
                            {/if}
                        </td>

                        <!-- POSTULACION -->
                        <td width="{$numAncho}" 
                            height="{$numAlto}" 
                            style="border-left: 1px dotted #666666;"
                            
                        >
							{if $objCasaMano->bolPrimeraVerificacion == 1 && ($objCasaMano->bolRevisionTecnica == 1)}
								{if esFechaValida( $objCasaMano->fchPostulacion )}
									<div style="cursor: pointer;" onClick="cambioCEM('./contenidos/casaMano/postulacion.php','seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}');">
										{$objCasaMano->fchPostulacion|date_format|upper}
									</div>
								{else}
									{if in_array( $claFormulario->seqEstadoProceso , $objCasaMano->arrFases.cem.postulacion.permisos ) && $smarty.foreach.fases.last == 1}
										<button style="cursor: pointer;" onClick="cambioCEM('./contenidos/casaMano/postulacion.php','seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&seqCasaMano={$seqCasaMano}');">
											<img src="./recursos/imagenes/plus_icon.gif">
										</button>
									{/if}
								{/if}
							{/if}
                        </td>

                        <!-- SEGUNDA VERIFICACION -->
                        <td width="{$numAncho}" 
                            height="{$numAlto}" 
                            style="border-left: 1px dotted #666666; 
                                   {if $objCasaMano->bolSegundaVerificacion == 1}
                                       background-color: {$txtVerde}
                                   {elseif $objCasaMano->bolSegundaVerificacion == 2}
                                       background-color: {$txtRojo}
                                   {/if}
                            "
                         >
                            {if esFechaValida( $objCasaMano->fchSegundaVerificacion )}
                                <div style="padding-bottom:5px">
                                    {$objCasaMano->fchSegundaVerificacion|date_format|upper}
                                </div>
                                {if $objCasaMano->bolSegundaVerificacion == 2}
                                    <div style="cursor: pointer; 
                                                background-color: red; 
                                                font-size: 7px; 
                                                color: white; 
                                                font-weight: bold; 
                                                width:30px; 
                                                height: 10px;"
                                         onClick="popUpPdfCasaMano( 'exportar[]={$seqFormulario}' , '{$objCasaMano->seqSegundaVerificacion}' )"
                                       >
                                        PDF
                                    </div>
                                {/if}
                            {else}
                                &nbsp;
                            {/if}
                        </td>
                    </tr>
                {/foreach}
                
                <!-- 
                    LINEA PARA ADICIONAR REGISTROS DE VIVIENDA
                    SOLO SI ESTA EN EL ESTADO DE HOGAR POSTULADO
                -->
                
                {if $claFormulario->seqEstadoProceso == 37 || $claFormulario->seqEstadoProceso == 43}
                    <tr align="center" style="vertical-align: bottom;">
                        <td width="{$numAncho}">
                            <button onClick="cambioCEM( 
                                                './contenidos/casaMano/registroOferta.php' , 
                                                'seqFormulario={$seqFormulario}&cedula={$arrPost.cedula}&modificar=1'
                                             );"
                            >
                                <img src="./recursos/imagenes/plus_icon.gif">
                            </button>
                        </td>
                        <td width="{$numAncho}" style="border-left: 1px dotted #666666;">&nbsp;</td>
                        <td width="{$numAncho}" style="border-left: 1px dotted #666666;">&nbsp;</td>
                        <td width="{$numAncho}" style="border-left: 1px dotted #666666;">&nbsp;</td>
                        <td width="{$numAncho}" style="border-left: 1px dotted #666666;">&nbsp;</td>
                        <td width="{$numAncho}" style="border-left: 1px dotted #666666;">&nbsp;</td>
                    </tr>
                {/if}
                
            </table>
        </div>
        <p><div>
            {include file="./cruces/datosHogar.tpl"}
        </div></p>
    </p></div>

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
			<input type="hidden" name="seqFormulario" id="seqFormulario" value="{$seqFormulario}">
		</form>
		</div>
	</div>