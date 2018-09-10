<link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
      crossorigin="anonymous"
>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">
                Listado general de reportes
            </h6>
        </div>
        <div class="panel-body text-center">
            <table id="listadoAadPry" data-order='[[ 0, "asc" ]]' class="table table-hover" width="850px">
                <thead>
                <tr>
                    <th>Nombre del reportes</th>
                    <th>Descripción</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$arrReporte key=txtClave item=arrDatos}
                    <tr>
                        <td width="300px">{$arrDatos.titulo}</td>
                        <td>{$arrDatos.descripcion}</td>
                        <td width="30px" align="center">
                            <a href="#"
                               onClick="
                               {if $arrDatos.url == ''}
                                       location.href='./contenidos/reportes/complementariedad/listadoReportes.php?reporte={$txtClave}'
                               {else}
                                       location.href='{$arrDatos.url}';
                               {/if}
                                       ">
                                <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="listadoAadProyectos"></div>