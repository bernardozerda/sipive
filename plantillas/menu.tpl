<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<nav class="navbar navbar-default" style="background-color: #FDFDFD">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" style="padding-left: 10px;">
            <button type="button" class="navbar-toggle pull-left collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {*<a class="navbar-brand" href="#">Brand</a>*}
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                {foreach name=menuPrincipal from=$arrMenu key=seqPadre item=objPadre}
                    {if not empty( $objPadre->hijos ) }
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {$objPadre->txtEspanol}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                {if $objPadre->txtCodigo != 'subsidios/vacio'}
                                    <li><a href="#menu-{$objPadre->txtEspanol}"
                                           onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true);
                                                   cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);">
                                            {$objPadre->txtEspanol} </a>
                                    </li>
                                {/if}
                                {foreach from=$objPadre->hijos key=seqHijo item=objHijo}
                                    <li><a href="#menu-{$objHijo->txtEspanol}"
                                           onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true);
                                                   cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);">
                                            {$objHijo->txtEspanol} </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    {else}
                        {assign var=ruta value=""}
                        <li>
                            <a href="#menu-{$objPadre->txtEspanol}"
                               {if $objPadre->txtEspanol|lower == 'inicio' }
                                   onClick="location.reload(true);"
                               {else}
                                   {assign var=varArchivo value="?"|explode:$objPadre->txtCodigo} 
                                   {if $varArchivo|@count gt 0}  
                                       {assign var=ruta value=$objPadre->txtCodigo".php"}                              
                                    {else}   
                                        {assign var=ruta value=$varArchivo[0]".php?"$varArchivo[1]} 
                                   {/if}
                                   onClick="cargarContenido('contenido', './contenidos/{$ruta}', '', true);
                                           cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"
                               {/if}
                               >{$objPadre->txtEspanol}</a>
                        </li>
                    {/if}
                {/foreach}
            </ul>


            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Opciones<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            {foreach from=$arrProyectos key=seqProyecto item=objProyecto}
                                <a href="#" onClick="cargarContenido('bodyHtml', './index.php', 'proyecto={$seqProyecto}', true);">
                                    <img src="./recursos/imagenes/casa.png" width="10px"> {$objProyecto->txtProyecto}
                                </a>
                            {/foreach}
                        </li>
                        <li>
                            <a href="./consultaGeneralInterna.php" id="ayuda" target="_blank">
                                <img src="./recursos/imagenes/iconoLupa.png" width="10px"> Consulta General
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="ayuda" onClick="popUpAyuda()">
                        <img src="./recursos/imagenes/library.png" width="10px">
                    </a>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>