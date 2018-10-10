<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

{if not empty($claInscripcion->arrErrores)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {foreach from=$claInscripcion->arrErrores item=txtError}
            <li>{$txtError}</li>
        {/foreach}
    </div>
{/if}

{if not empty($claInscripcion->arrMensajes)}
    <div class="alert alert-success alert-dismissible" role="alert" style="font-size: 12px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Hecho!</strong> {$claInscripcion->arrMensajes.0}
    </div>
{/if}

<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Listado cargues complementariedad</h6>
    </div>
    <div class="panel-body">

        <table id="listadoAadPry" class="table table-hover" data-order='[[ 0, "desc" ]]' width="850px">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tipo</th>
                    <th>Fecha Cargue</th>
                    <th>Archivo</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$claInscripcion->listadoCargues() item=arrCargue}
                    <tr>
                        <td width="30px">{$arrCargue.seqCargue}</td>
                        <td width="30px">{$arrCargue.txtTipo}</td>
                        <td width="120px">{$arrCargue.fchCargue}</td>
                        <td>{$arrCargue.txtArchivo}</td>
                        <td width="120px">{$arrCargue.txtEstado}</td>
                        <td>{$arrCargue.txtUsuario}</td>
                        <td width="30px">
                            <a href="./contenidos/inscripcionFonvivienda/descargar.php?seqCargue={$arrCargue.seqCargue}" class="text-success">
                                <span class="glyphicon glyphicon-download-alt"></span>
                            </a>
                        </td>
                        {if $arrCargue.seqEstado == 1} <!-- En espera -->
                            <td width="30px"></td>
                            <td width="30px">
                                <a href="#" class="text-danger" onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/eliminar.php','seqCargue={$arrCargue.seqCargue}')">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        {elseif $arrCargue.seqEstado == 2} <!-- Procesando novedades -->
                            <td width="30px">
                                <a href="#" class="text-primary" onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/informacion.php','seqCargue={$arrCargue.seqCargue}')">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                            <td width="30px"></td>
                        {elseif $arrCargue.seqEstado == 3} <!-- Novedades procesadas con errores -->
                            <td width="30px">
                                <a href="#" class="text-primary" onclick="verErroresFNV({$arrCargue.seqCargue})">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                            <td width="30px">
                                <a href="#" class="text-danger" onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/eliminar.php','seqCargue={$arrCargue.seqCargue}')">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        {elseif $arrCargue.seqEstado == 4} <!-- En revision -->
                            <td width="30px">
                                <a href="#" class="text-primary" onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/informacion.php','seqCargue={$arrCargue.seqCargue}')">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                            <td width="30px">
                                <a href="#" class="text-danger" onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/eliminar.php','seqCargue={$arrCargue.seqCargue}')">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        {else} <!-- otros estados -->
                            <td width="30px">
                                <a href="#" class="text-primary" onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/informacion.php','seqCargue={$arrCargue.seqCargue}')">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </a>
                            </td>
                            <td width="30px"></td>
                        {/if}
                    </tr>
                {/foreach}
            </tbody>
        </table>

    </div>
    <div class="panel-footer text-center">
        {if isset($smarty.session.arrGrupos.3.20)}
            <button type="button"
                    class="btn btn-primary {if $claInscripcion->hayCarguesPendientes() == true} disabled {/if}"
                    onclick="cargarContenido('contenido','./contenidos/inscripcionFonvivienda/nuevoCargue.php','',true);"
                    {if $claInscripcion->hayCarguesPendientes() == true} disabled {/if}
            >
                Nuevo Cargue
            </button>
        {else}
            <p>&nbsp;</p>
        {/if}
    </div>
</div>

<div id="listadoAadProyectos"></div>
<div id="verErroresFNV"></div>
