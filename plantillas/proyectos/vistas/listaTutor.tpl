<script src="librerias/javascript/jquery-ui.js"></script>
<link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
<link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
    <div bgcolor="#E4E4E4" class="col-sm-1">
        <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosTutor.php?tipo=1', '', true);">
            <img src="recursos/imagenes/add.png" width="24px">
        </a>
    </div>
    <thead >
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Nombre del Tutor</b></th>
            <th bgcolor="#E4E4E4" ><b>&nbsp;</b></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Nombre del Tutor</b></th>
            <th bgcolor="#E4E4E4" ><b>&nbsp;</b></th>
        </tr>
    </tfoot>

    {foreach from=$arrTutor key=keyTutor item=value}                    
        <tr>
            <td  align="center"><b>{$value.seqTutorProyecto}</b>&nbsp;</td>
            <td >{$value.txtNombreTutor|upper}</td>

            <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosTutor.php?tipo=2&seqTutor={$value.seqTutorProyecto}', '', true);">
                    <img src="recursos/imagenes/list.png" width="24px"></a>
            </td>

        </tr>
    {/foreach}
</table>
