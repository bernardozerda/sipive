{if $boolMostrar == 1}
    <div class="divLeftP">
        <h1>SECRETARÍA DISTRITAL DEL HÁBITAT</h1>
        <h2>SUBSECRETARÍA DE GESTIÓN FINANCIERA</h2>
        <h3>FICHA DE PROYECTOS APROBADOS EN COMITÉ DE ELEGIBILIDAD PARA VIVIENDA NUEVA</h3>
    </div>
    <div class="divRightP">
        <img src="recursos/imagenes/bta_positiva.png" />
    </div>

    <div class="bodyP" id="bodyP">
        <table>
            <tr>
                <th colspan="2">NOMBRE DEL PROYECTO</th>
                <td  colspan="4">
                    <select id="seqProyecto" name="seqProyecto" onchange="obtenerDatos(this.value)">
                        <option value="0">Seleccione</option>
                        {foreach key=key item=item from=$arrListaProyectos}
                            <option value="{$key}">{$item}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        </table>
    </div>
{/if}
<div id="divDatos" class="bodyP">
    <table>
        {foreach key=cid item=con from=$arrDatosProy}
            {assign var=fchResol value="-"|explode:$con.resolucion} 
            {assign var=fchEleg value="-"|explode:$con.elegibilidad} 
            <tr>
                {if $con.elegibilidad != ""}
                    <th>RESOLUCIÓN DE ELEGIBILIDAD</th>
                    <td>{$fchEleg[0]} de {$fchEleg[1]|date_format:" %e %B de %Y"}</td>
                {/if}
                {if $con.resolucion !=""}

                    <th>RESOLUCIÓNES <br> MODIFICATORIAS E <br> INDEXACIÒN</th>
                    <td colspan="3">{$fchResol[0]} de {$fchResol[1]|date_format:" %e %B de %Y"}</td>
                {/if}
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">LOCALIZACIÓN</th>
            </tr>
            <tr>
                {if $con.txtDireccion != ""}
                    <th>DIRECCIÓN</th>
                    <td>{$con.txtBarrio} <br>{$con.TxtNombrePlanParcial} / {$con.txtDireccion}</td>
                    {/if}
                    {if $con.resolucion !=""}
                    <th>LOCALIDAD</th>
                    <td colspan="3">{$con.txtLocalidad}</td>
                {/if}
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">OFERENTE / CONSTRUCTOR / INTERVENTOR</th>
            </tr>
            <tr>
                {if $con.txtNombreOferente != ""}
                    <th>OFERENTE</th>
                    <td>{$con.txtNombreOferente}</td>
                {/if}
                <th>CONSTRUCTOR</th>
                <td>{$con.txtNombreConstructor}</td>
                <th>INTERVENTOR</th>
                <td>{$con.interventor}</td>
            </tr>
            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">DATOS GENERALES DEL PROYECTO RELACIONADOS CON EL SUBSIDIO</th>
            </tr>
            <tr>
                {if $con.Costos != ""}
                    <th>VALOR DEL PROYECTO</th>
                    <td>$ {$con.Costos|number_format:0:',':'.'}</td>
                {/if}
                {if $con.soluciones !=""}
                    <th>No. SOLUCIONES VIP</th>
                    <td>{$con.soluciones}</td>
                {/if}
                {if $con.soluciones !=""}
                    <th>No. SOLUCIONES VIs</th>
                    <td>0</td>
                {/if}
            </tr>
            <tr>
                {if $con.valSDVE != ""}
                    <th>VALOR DEL SDVE</th>
                    <td>$ {$con.valSDVE|number_format:0:',':'.'}</td>
                {/if}
                {if $con.valTorres !=""}
                    <th>No. TORRES VIP</th>
                    <td>{$con.valTorres }</td>
                {/if}
                {if $con.soluciones !=""}
                    <th>No. TORRES VIS</th>
                    <td>0</td>
                {/if}
            </tr>
            <tr>
                <th>MODALIDAD DE DESEMBOLSO / ESQUEMA FINANCIACIÓN</th>
                <td>{$con.ModalidadDesembolso}</td>
                <th>AREA CONSTRUIDA UNIDAD VIP</th>
                <td>{$con.area}</td>
                <th>AREA CONSTRUIDA UNIDAD VIS</th>
                <td>0</td>

            </tr>
            <tr>
                <th>FIDICIARIA</th>
                <td>{$con.fiduciaria}</td>
                <th>TIPO DE SOLUCIÓN VIP</th>
                <td>{$con.txtTipoSolucion}</td>
                <th>TIPO DE SOLUCIÓN VIS</th>
                <td>0</td>
            </tr>

            <tr>
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="6" id="backth">BENEFICIARIOS</th>
            </tr>
            <tr>
                <th>POBLACIÓN BENEFICIARIA</th>
                <td>Vulnerable/ Desplazado/ Reasentamiento/ VIPA</td>
                {if $con.cuposvinculados !=""}
                    <th>CUPOS VINCULADOS</th>
                    <td colspan="3">{$con.cuposvinculados}</td>
                {/if}
            </tr>
            <tr>
                <th>ESQUEMA DE POSTULACIÓN</th>
                <td>{$con.txtTipoEsquema}</td>
                {if $con.cuposvinculados !=""}
                    <th>CUPOS POR VINCULAR</th>
                    <td colspan="3">{$con.soluciones-$con.cuposvinculados}</td>
                {/if}
            </tr>
        {/foreach}   
    </table>
    <table>
        <tr>
            <th>Entidad</th>
            <th>Código</th>
            <th>Trámite</th>
            <th>Comentario</th>
        </tr>
        {foreach key=idList item=lista from=$arrListaEntidades}
            <tr>
                <td>{$lista.txtNombreEntidad}</td>
                <td>{$lista.txtCodigoEntidad}</td>
                <td>{$lista.txtTramiteEntidad}</td>
                <td>{$lista.txtComentarioEntidad}</td>
            </tr>
        {/foreach}
    </table>
</div>

