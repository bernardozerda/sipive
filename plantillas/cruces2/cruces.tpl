

<table cellpadding="10" cellspacing="0" width="98%" border="0" align="center">

    <tr>
        <td align="center" >
            <form method="post" onsubmit="someterFormulario('contenido',this,'./contenidos/cruces2/cruces.php',false,true); return false;">
                <table id="listadoCruces" class="table table-condensed table-hover" width="100%">
                    <thead>
                        <th align="center" width="90px">Creación</th>
                        <th align="center" width="90px">Actualización</th>
                        <th align="center" width="90px">Fecha</th>
                        <th align="center">Nombre</th>
                        <th align="center" width="30px">&nbsp;</th>
                        <th align="center" width="40px">&nbsp;</th>
                        <th align="center" width="40px">Aplicar</th>
                        <th align="center" style="display: none">Usuario Creación</th>
                        <th align="center" style="display: none">Usuario Actualización</th>
                        <th align="center" style="display: none">Documentos</th>
                    </thead>
                    <thead>
                        <th>
                            <input id="creacionInicio"
                                   name="creacionInicio"
                                   type="text"
                                   placeholder="inicio"
                                   onfocus="this.value='';calendarioPopUp('creacionInicio')"
                                   style="width:80px; margin-bottom: 3px;"
                                   value="{if $arrPost.creacionInicio != null}{$arrPost.creacionInicio->format('Y-m-d')}{/if}"
                                   >
                            <input id="creacionFinal"
                                   name="creacionFinal"
                                   type="text"
                                   placeholder="final"
                                   onfocus="this.value='';calendarioPopUp('creacionFinal')"
                                   style="width:80px"
                                   value="{if $arrPost.creacionFinal != null}{$arrPost.creacionFinal->format('Y-m-d')}{/if}"
                                   >
                        </th>
                        <th>
                            <input id="updateInicio"
                                   name="updateInicio"
                                   type="text"
                                   placeholder="inicio"
                                   onfocus="this.value='';calendarioPopUp('updateInicio')"
                                   style="width:80px; margin-bottom: 3px;"
                                   value="{if $arrPost.updateInicio != null}{$arrPost.updateInicio->format('Y-m-d')}{/if}"
                                   >
                            <input id="updateFinal"
                                   name="updateFinal"
                                   type="text"
                                   placeholder="final"
                                   onfocus="this.value='';calendarioPopUp('updateFinal')"
                                   style="width:80px;"
                                   value="{if $arrPost.updateFinal != null}{$arrPost.updateFinal->format('Y-m-d')}{/if}"
                                   >
                        </th>
                        <th>
                            <input id="cruceInicio"
                                   name="cruceInicio"
                                   type="text"
                                   placeholder="inicio"
                                   onfocus="this.value='';calendarioPopUp('cruceInicio')"
                                   style="width:80px; margin-bottom: 3px;"
                                   value="{if $arrPost.cruceInicio != null}{$arrPost.cruceInicio->format('Y-m-d')}{/if}"
                                   >
                            <input id="cruceFinal"
                                   name="cruceFinal"
                                   type="text"
                                   placeholder="final"
                                   onfocus="this.value='';calendarioPopUp('cruceFinal')"
                                   style="width:80px;"
                                   value="{if $arrPost.cruceFinal != null}{$arrPost.cruceFinal->format('Y-m-d')}{/if}"
                                   >
                        </th>
                        <th valign="top">
                            <input type="text" name="nombre" value="{$arrPost.nombre}" placeholder="Nombre del cruce" style="width:100%;">
                        </th>
                        <th colspan="2" valign="top">
                            <input type="number" name="documento" value="{$arrPost.documento}" placeholder="Post.Principal" style="width:120px;">

                        </th>
                        <th align="center" valign="top">
                            <button type="submit" class="inputLogin" style="width: 18px; height: 18px">✔</button>
                        </th>
                    </thead>
                    <tbody>
                        {foreach from=$arrCruces key=seqCruce item=arrCruce}
                            <tr>
                                <td align="center">{$arrCruce.fchCreacionCruce->format('Y-m-d')}</td>
                                <td align="center">{$arrCruce.fchActualizacionCruce->format('Y-m-d')}</td>
                                <td align="center">{$arrCruce.fchCruce->format('Y-m-d')}</td>
                                <td>{$arrCruce.txtNombre}</td>
                                <td align="center"><a href="#">Ver</a></td>
                                <td align="center"><a href="#">Exportar</a></td>
                                <td align="center">
                                    {if isset($smarty.session.arrGrupos.3.20)}
                                        <a href="#">Eliminar</a>
                                    {/if}
                                </td>
                                <td style="display: none">{$arrCruce.txtUsuarioCreacion}</td>
                                <td style="display: none">{$arrCruce.txtUsuarioActualiza}</td>
                                <td style="display: none">{$arrCruce.documentos}</td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td align="center">
            Crear Cruce
            <button>✔</button>
        </td>
    </tr>
</table>


<div id="listadoCrucesListener"></div>
