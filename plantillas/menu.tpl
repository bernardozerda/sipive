<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>


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
                                           onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);">
                                            {$objPadre->txtEspanol} </a>
                                    </li>

                                {/if}
                                {foreach from=$objPadre->hijos key=seqHijo item=objHijo}
                                    <li><a href="#menu-{$objHijo->txtEspanol}"
                                           onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);">
                                            {$objHijo->txtEspanol} </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    {else}
                        <li>
                            <a href="#menu-{$objPadre->txtEspanol}"
                                    {if $objPadre->txtEspanol|lower == 'inicio' }
                                        onClick="location.reload(true);"
                                    {else}
                                        onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"
                                    {/if}
                            >{$objPadre->txtEspanol}</a>
                        </li>
                    {/if}
                {/foreach}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>
                        <select name="proyecto" id="proyecto" class="selector"
                                onChange="cargarContenido('bodyHtml', './index.php', 'proyecto=' + this.options[ this.selectedIndex ].value, true);">
                            {foreach from=$arrProyectos key=seqProyecto item=objProyecto}
                                <option value="{$seqProyecto}"
                                        {if $seqProyectoPost == $seqProyecto} selected {/if}
                                >{$objProyecto->txtProyecto}</option>
                            {/foreach}
                        </select>
                    </a>
                </li>
                <li><a href="#" id="ayuda" onClick="popUpAyuda()">
                        <img src="./recursos/imagenes/library.png" width="14px" >
                    </a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>