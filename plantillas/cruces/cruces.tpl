{php}
    date_default_timezone_set("America/Bogota");
    setlocale(LC_TIME , 'spanish' );
{/php}

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="630px">
    <tr>
        <!-- LISTADO DE CRUCES -->
        <td width="150px" valign="top" style="padding-right:5px; border-right: 1px dotted #999999;">
            
                <div style="padding:5px; border-bottom: 1px dotted #999999;">
                    <strong>Listado de Cruces</strong>
                </div>
                <div style="padding:5px; height:94%; overflow:auto;">
                    {foreach from=$arrCruces key=seqCruce item=arrInfo}
                        <li style="cursor: pointer; padding-bottom: 2px; border-bottom: 1px dotted #999999;"
                            onMouseOver="this.style.background='#e4e4e4';"
                            onMouseOut="this.style.background='#f9f9f9';"
                            onClick="cargarContenido('listado','./contenidos/cruces/leerCruce.php','seqCruce={$seqCruce}',true);"
                        >
                            {$arrInfo.nombre|upper}
                        </li>
                    {/foreach}
                </div>
            
        </td>
        
        <!-- FORMULARIO DE CRUCES -->
        <td valign="top">
            <div style="padding-top:0px; padding-left: 10px" id="estados">
                <div style="padding:5px; border-bottom: 1px dotted #999999;">
                    <strong>Seleccione los estados para listar los hogares</strong>
                </div>
                <div style="padding:5px; border-bottom: 1px dotted #999999;">
                    <form onSubmit="return false;" id="frmListosCruce">
                        
                        <fieldset style="border: 1px dotted #999999;">
                            <legend><strong>Inscripci&oacute;n</strong></legend>
                            <input type="checkbox" 
                                   name="estados[inscripcion][]" 
                                   value="37"
                                   onClick="someterFormulario('listado', this.form , './contenidos/cruces/listosCruce.php', false, true );"
                            > 
                            Inscripci&oacute;n - Hogar Actualizado<br>
                            
                            <input type="checkbox" 
                                   name="estados[inscripcion][]" 
                                   value="44"
                                   onClick="someterFormulario('listado', this.form , './contenidos/cruces/listosCruce.php', false, true );"
                            > 
                            Inscripci&oacute;n - CEM - Primera Verificaci&oacute;n<br>
                            
                        </fieldset>
                        <fieldset style="border: 1px dotted #999999;">
                            <legend><strong>Postulaci&oacute;n</strong></legend>
                            <input type="checkbox" 
                                   name="estados[postulacion][]" 
                                   value="47"
                                   onClick="someterFormulario('listado', this.form , './contenidos/cruces/listosCruce.php', false, true );"
                            > 
                            Postulaci&oacute;n - CEM - Hogar Postulado<br>
                            
                            <input type="checkbox" 
                                   name="estados[postulacion][]" 
                                   value="54"
                                   onClick="someterFormulario('listado', this.form , './contenidos/cruces/listosCruce.php', false, true );"
                            > 
                            Postulaci&oacute;n - IND - Hogar Postulado<br>
                            
                            <input type="checkbox" 
                                   name="estados[postulacion][]" 
                                   value="7"
                                   onClick="someterFormulario('listado', this.form , './contenidos/cruces/listosCruce.php', false, true );"
                            > 
                            Postulaci&oacute;n - Calificación Vulnerabilidad<br>
                        </fieldset>
                    </form>
                </div>
                <div style="padding:5px;">
                    <button onclick="exportarInhabilidadesExcel( 'frmListadoListos' );" style="width:70px;">
                        <img src="./recursos/imagenes/excel.gif" width="25px" height="25px"><br>
                        <span style="font-size: 10px; font-weight: bold;">Exportar <br>a Excel</span>
                    </button>
                    <button onClick="exportarInhabilidadesPdf( 'frmListadoListos' );" style="width:70px;">
                        <img src="./recursos/imagenes/pdf.gif" width="25px" height="25px"><br>
                        <span style="font-size: 10px; font-weight: bold;">Exportar <br>a PDF</span>
                    </button>
                    <button onClick="cargarCruce();"  style="width:70px;">
                        <img src="./recursos/imagenes/subir.png" width="25x" height="25px"><br>
                        <span style="font-size: 10px; font-weight: bold;">Cargar<br>Cruce</span>
                    </button>
                </div>
            </div>
            <div style="padding:5px; height:460px; overflow:auto;" id="listado">
                {include file="cruces/listosCruce.tpl"}
            </div>
        </td>
    </tr>
</table>
            
<div id="dlgCargaCruces" class="yui-pe-content" hidden>
	<div class="hd">Formulario para carga de cruces</div>
	<div class="bd">
        <form method="POST" 
              action="./contenidos/cruces/salvarCruces.php" 
              enctype="multipart/form-data"
              id="frmCargaCruces"
              onSubmit="return false;"
        >
            <table border="0" cellpadding="3" cellspacing="0" width="100%">
                
                <!-- NOMBRE DEL CRUCE -->
                <tr>
                    <td><label for="elaboro"><b>Nombre:</b></label></td>
                    <td>
                        <input type="textbox" 
                               name="nombre" 
                               value="" 
                               style="width:90%" 
                               onFocus="autocompletar( 'reviso' , 'contenedorReviso' , './contenidos/cruces/nombresReviso.php' , '' )"
                        >
                    </td>
                </tr>
                
                <!-- FECHA DEL CRUCE -->
                <tr>
                    <td><label for="fecha"><b>Fecha del Cruce:</b></label></td>
                    <td>
                        <input type="textbox" 
                               id="fecha" 
                               name="fecha" 
                               
                               readonly
                        >
                        <a href="#" onClick="calendarioPopUp('fecha')">Calendario</a>
                    </td>
                </tr>
                
                <!-- ARCHIVO DE CRUCES -->
                <tr>
                    <td><label for="archivo"><b>Archivo de Cruces:</b></label></td>
                    <td><input type="file" name="archivo"></td>
                </tr>
                
                <!-- CUERPO DE LA CARTA -->
                <tr>
                    <td valign="top"><label for="archivo"><b>Cuerpo de la carta:</b></label></td>
                    <td><textarea name="cuerpo" style="width:90%; height:150px;"></textarea></td>
                </tr>
                
                <!-- PIE DE LA CARTA -->
                <tr>
                    <td valign="top"><label for="archivo"><b>Pie de la carta:</b></label></td>
                    <td><textarea name="pie" style="width:90%; height:150px;"></textarea></td>
                </tr>
                
                <!-- FIRMA DE LA CARTA -->
                <tr>
                    <td><label for="firma"><b>Firma de la Carta:</b></label></td>
                    <td>
                        <input type="textbox" name="firma" value="ANA LUC&Iacute;A QUINTERO MOJICA" style="width:300px">
                    </td>
                </tr>
                
                <!-- ELABORO LA CARTA -->
                <tr>
                    <td><label for="elaboro"><b>Elabor&oacute;:</b></label></td>
                    <td>
                        <input type="textbox" name="elaboro" value="{$txtUsuario}" style="width:300px">
                    </td>
                </tr>
                
                <!-- REVISO LA CARTA -->
                <tr>
                    <td><label for="reviso"><b>Revis&oacute;:</b></label></td>
                    <td height="30px" valign="top">
                        <input id="reviso" 
                               type="text" 
                               name="reviso"
                               style="width:300px"
                        >
                        <div id="contenedorReviso" style="width:300px"></div>
                    </td>
                </tr>
            </table>
		</form>
	</div>
</div>

            

