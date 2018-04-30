<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<nav class="navbar navbar-default" style="background-color: #FDFDFD">
    <div class="container-fluid">
        <div class="navbar-header" style="padding-left: 10px;">
            <button type="button" class="navbar-toggle pull-left collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {*<a class="navbar-brand" href="#">Brand</a>*}
        </div>
        <div class="dropdown">
            <ul class="nav navbar-nav">
                {foreach name=menuPrincipal from=$arrMenu key=seqPadre item=objPadre}
                    {if $objPadre->posicion == 0}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"{if $objPadre->txtEspanol|lower == 'inicio' }
                               onClick="location.reload(true);"
                            {else}
                                onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true);
                                        cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"
                            {/if} >
                            {$objPadre->txtEspanol}
                        </a>
                    </li>
                    {else}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                {$objPadre->txtEspanol}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                {foreach from=$objPadre->hijos key=seqHijo item=objHijo}
                                    {if $objHijo->posicion == 2 && $objHijo->seqPadre == $seqPadre}
                                        <li><a tabindex="-1" href="#" onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true);
                                                cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);">{$objHijo->txtEspanol}</a></li>      

                                    {/if}
                                    {if $objHijo->posicion == 3 && $objHijo->seqPadre == $seqPadre}
                                        <li class="dropdown-submenu">
                                            <a class="test" tabindex="-1" href="#" onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true);
                                                cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);"> {$objHijo->txtEspanol}  <span class="caret" style="    position: absolute;
    right: 0;
    margin-top: 6px;
    margin-right: 15px;
    border-top: 4px solid transparent;
    border-bottom: 4px solid transparent;
    border-left: 4px dashed;"></span></a>
                                            <ul class="dropdown-menu" style="position: absolute; left: 100%;margin-top: -20px; float: left; z-index: 1000">
                                                {foreach from=$arrNietos key=seqNieto item=objNieto}
                                                    {if $objNieto->posicion == 4 && $objNieto->seqPadre == $seqHijo}
                                                        <li><a tabindex="-1" href="#" onClick="cargarContenido('contenido', './contenidos/{$objNieto->txtCodigo}.php', '', true);
                                                                cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqNieto}', false);">{$objNieto->txtEspanol}</a></li>
                                                        {/if}

                                                {/foreach}                                  
                                            </ul>
                                        </li>

                                    {/if}

                                {/foreach}
                            </ul>
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
                        </div>
                    </div>
                </nav>
                <div id="divNietos"></div>                            

