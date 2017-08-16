<div id="guiaProyectos">
    <p>
    <form action="return false" method="post">
        <table>
            <tr>
                <td width="120px">
                    <label for="seqProyecto">
                        <strong>Proyecto</strong>
                    </label>
                </td>
                <td>
                    <select name="seqProyecto" onChange="someterFormulario('guiaProyectos',this.form,'./contenidos/actosAdministrativos/plantillaProyectoUnidadHabitacional.php',false,true);">
                        <option value="0">Seleccione</option>
                        {foreach from=$arrProyectos item=arrProyecto}
                            <option value="{$arrProyecto.seqProyecto}" {if $arrPost.seqProyecto == $arrProyecto.seqProyecto} selected {/if}>
                                {$arrProyecto.txtNombreProyecto}
                            </option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        </table>
    </form>
    </p>
    <p>
        {if is_array( $arrUnidades ) && not empty( $arrUnidades )}
            <div style="overflow: auto; height:400px;">
            {foreach name=unidades from=$arrUnidades key=seqProyecto item=arrProyecto}
                <p>
                    <label>
                        {math equation="x - y" x=$arrProyecto.total y=$arrProyecto.disponibles|intval assign="numNoDisponibles"}
                        <strong>{$arrProyecto.nombre}: </strong>
                        <span class="msgVerde"
                              onClick="tablaPlantillaProyectoUnidadHabitacional( 'unidades{$seqProyecto}Disponibles' , 'unidades{$seqProyecto}NoDisponibles' );"
                              style="cursor: hand;">
                            Disponibles [{$arrProyecto.disponibles|intval}]
                        </span>
                        <span class="msgError"
                              onClick="tablaPlantillaProyectoUnidadHabitacional( 'unidades{$seqProyecto}NoDisponibles' , 'unidades{$seqProyecto}Disponibles' );"
                              style="cursor: hand;">
                            No Disponibles [{$numNoDisponibles|intval}]
                        </span>
                    </label>

                    <div id="unidades{$seqProyecto}Disponibles" style="overflow: auto; height:300px; display: none;">
                        <label class="msgVerde">Disponibles</label>
                        <table cellpadding="3px" border="0" width="100%">
                            {foreach from=$arrProyecto.unidades key=seqUnidadProyecto item=arrUnidadProyecto}
                                {if $arrUnidadProyecto.disponible == 0}
                                    <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                                        <td width="50%">{$arrUnidadProyecto.nombre}</td>
                                        {if doubleval( $arrUnidadProyecto.documento != 0 )}
                                            <td class="msgError">Unidad tomada por {$arrUnidadProyecto.documento}</td>
                                        {else}
                                            <td class="msgVerde">Unidad disponible</td>
                                        {/if}
                                    </tr>
                                {/if}
                            {/foreach}
                        </table>
                    </div>
                    <div id="unidades{$seqProyecto}NoDisponibles" style="overflow: auto; height:300px; display: none;">
                        <label class="msgError">No Disponibles</label>
                        <table cellpadding="3px" border="0" width="100%">
                            {foreach from=$arrProyecto.unidades key=seqUnidadProyecto item=arrUnidadProyecto}
                                {if $arrUnidadProyecto.disponible == 1}
                                    <tr bgcolor="{cycle values="#eeeeee,#d0d0d0"}">
                                        <td width="50%">{$arrUnidadProyecto.nombre}</td>
                                        {if doubleval( $arrUnidadProyecto.documento != 0 )}
                                            <td class="msgError">Unidad tomada por {$arrUnidadProyecto.documento}</td>
                                        {else}
                                            <td class="msgVerde">Unidad disponible</td>
                                        {/if}
                                    </tr>
                                {/if}
                            {/foreach}
                        </table>
                    </div>
                </p>
            {/foreach}
            </div>
        {/if}
    </p>
</div>