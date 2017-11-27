&nbsp;
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Listado de cruces</h4>
    </div>
    <div class="panel-body">
        <form method="post" onsubmit="someterFormulario('contenido',this,'./contenidos/cruces2/cruces.php',false,true); return false;">
            <table id="listadoCruces" class="table table-condensed table-hover" width="100%">
                <thead>
                    <th align="center" width="90px">Creación</th>
                    <th align="center" width="90px">Actualización</th>
                    <th align="center" width="90px">Fecha</th>
                    <th align="center">Nombre</th>
                    <th align="center" width="30px">&nbsp;</th>
                    <th align="center" width="40px">&nbsp;</th>
                    <th align="center" width="40px">&nbsp;</th>
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
                        <td align="center">
                            <a href="#" onClick="cargarContenido('contenido','./contenidos/cruces2/ver.php','seqCruce={$seqCruce}',true)">
                                Ver
                            </a>
                        </td>
                        <td align="center">
                            <a href="#" onclick="location.href='./contenidos/cruces2/exportar.php?seqCruce={$seqCruce}'">
                                Exportar
                            </a>
                        </td>
                        <td align="center">
                            {if isset($smarty.session.arrGrupos.3.20)}
                                <a href="#" onClick="cargarContenido('mensajes','./contenidos/cruces2/eliminar.php','seqCruce={$seqCruce}',true);">
                                    Eliminar
                                </a>
                            {/if}
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </form>
    </div>
    <div class="panel-footer" align="center">
        <button class="btn btn-primary" onclick="cargarContenido('contenido','./contenidos/cruces2/formularioCruces.php','',true);">
            Crear Cruce
        </button>
    </div>
</div>

<div id="listadoCrucesListener"></div>
