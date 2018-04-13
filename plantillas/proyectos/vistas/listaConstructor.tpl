<script src="librerias/javascript/jquery-ui.js"></script>
<link rel="stylesheet" href="recursos/estilos/jquery-ui.css"/> 
<link rel="stylesheet" href="librerias/jquery/css/bootstrap.min.css"/> 

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%" >
    <div bgcolor="#E4E4E4" class="col-sm-1">
        <a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosConstructor.php?tipo=1', '', true);">
            <img src="recursos/imagenes/add.png" width="24px">
        </a>
    </div>
    <thead >
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Constructor</b></th>
            <th bgcolor="#E4E4E4" ><b>Nit</b></th>        
            <th bgcolor="#E4E4E4" >&nbsp;</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th bgcolor="#E4E4E4" align="center" ><b>Id</b></th>
            <th bgcolor="#E4E4E4" ><b>Constructor</b></th>
            <th bgcolor="#E4E4E4" ><b>Nit</b></th>        
            <th bgcolor="#E4E4E4" >&nbsp;</th>

        </tr>
    </tfoot>

    {foreach from=$arrConstructor key=keyContructor item=value}                    
        <tr>
            <td  align="center"><b>{$value.seqConstructor}</b>&nbsp;</td>
            <td >{$value.txtNombreConstructor|upper}</td>
            <td >{$value.numDocumentoConstructor}</td>  
            <td width="5%"><a href="#" onclick="cargarContenido('contenido', './contenidos/proyectos/contenidos/datosConstructor.php?tipo=2&seqConstructor={$value.seqConstructor}&page=datosConstructor.php', '', true);">
                    <img src="recursos/imagenes/list.png" width="24px"></a>
            </td>

        </tr>
    {/foreach}
</table>
