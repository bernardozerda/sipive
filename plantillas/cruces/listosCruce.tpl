
<div id="seleccionados" style="padding:5px;">
    {$arrHogares|@count} Hogares Listados 0 Seleccionados
</div>

<table border="0" cellpadding="2" cellspacing="0" width="100%" bgcolor="#e4e4e4">    
    <tr>
        <td width="20px;" align="center">
            <input type="checkbox" id="0" onClick="seleccionarCheck('frmListadoListos','0');">
        </td>   
        <td width="20px;">
            &nbsp;
        </td>
        <td width="85px" align="right">
            <strong>Documento</strong>
        </td>
        <td width="238px" style="padding-left:5px;">
            <strong>Nombre</strong>
        </td>
        <td>
            <strong>Estado</strong>
        </td>
    </tr>
</table>

<form id="frmListadoListos" onSubmit="return false;">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">   
        {foreach from=$arrHogares key=seqFormulario item=arrInfo}
            <tr bgcolor="{cycle values='#F9F9F9,#E4E4E4'}">
                <td width="20px;" align="center">
                    <input id="{$seqFormulario}" 
                           type="checkbox" 
                           name="exportar[]"
                           value="{$seqFormulario}"
                           onClick="seleccionarCheck('frmListadoListos','{$seqFormulario}');"
                    >
                </td>
                <td align="center" width="20px;">
                    {if isset( $arrInfo.carta ) && $arrInfo.carta == 1}
                        <div style="background-color: red; font-size: 7px; color: white; font-weight: bold; width:100%; height: 10px;">
                            PDF
                        </div>                        
                    {elseif isset( $arrInfo.carta ) && $arrInfo.carta == 0}
                        <div style="background-color: green; font-size: 7px; color: white; font-weight: bold; width:100%; height: 10px;">
                            OK
                        </div>
                    {else}
                        &nbsp;
                    {/if}
                </td>
                <td align="right" width="85px">{$arrInfo.documento|number_format}</td>
                <td style="padding-left:5px;" width="238px">{$arrInfo.nombre}</td>
                <td>{$arrInfo.estado}</td>
            </tr>  
        {/foreach}
    </table>
    <input type="hidden" id="seqCruce" name="seqCruce" value="{$seqCruce}">
</form>

