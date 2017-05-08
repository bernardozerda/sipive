<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!--<link href="recursos/estilos/layout.css" rel="stylesheet" type="text/css" />
        <link href="recursos/estilos/menu.css" rel="stylesheet" type="text/css" />
<div id="menu" class="yuimenubar yuimenubarnav">
    <div class="bd">
        <ul class="first-of-type">
{foreach name=menuPrincipal from=$arrMenu key=seqPadre item=objPadre}
    <li class="yuimenubaritem first-of-type">
        <a class="yuimenubaritemlabel" href="#menu-{$objPadre->txtEspanol}"
    {if $objPadre->txtEspanol|lower == 'inicio' }
        onClick="location.reload(true);"
    {else}
        onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"
    {/if}
    >{$objPadre->txtEspanol}</a>
    {if not empty( $objPadre->hijos ) }
        <div id="menu-{$objPadre->txtEspanol}" class="yuimenu">
            <div class="bd">
                <ul>
        {foreach from=$objPadre->hijos key=seqHijo item=objHijo}
            <li class="yuimenuitem">
                <a class="yuimenuitemlabel" href="#menu-{$objHijo->txtEspanol}" 
                   onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);"
                   >{$objHijo->txtEspanol}</a>
            </li>
        {/foreach}
    </ul>
</div>
</div>
    {/if}

</li>
{/foreach}
<li style="position: relative; float: right;"> 
    <a href="#" id="ayuda" onClick="popUpAyuda()">
        <img src="./recursos/imagenes/ayuda.png" width="22px" height="22px">
    </a>
</li>
</ul>
</div>
</div>-->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                {foreach name=menuPrincipal from=$arrMenu key=seqPadre item=objPadre}
                    {if not empty( $objPadre->hijos ) }                    
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{$objPadre->txtEspanol} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    {if $objPadre->txtEspanol|lower != 'inicio' and  $objPadre->txtEspanol|lower != 'proceso' and  $objPadre->txtEspanol|lower != 'esquemas' and  $objPadre->txtEspanol|lower != 'administracion'}   
                                        <li><a href="#menu-{$objPadre->txtEspanol}"                                                                             
                                               onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"
                                               >{$objPadre->txtEspanol} </a> </li>
                                        {/if}
                                        {foreach from=$objPadre->hijos key=seqHijo item=objHijo}
                                        <li><a href="#menu-{$objHijo->txtEspanol}" onClick="cargarContenido('contenido', './contenidos/{$objHijo->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqHijo}', false);">{$objHijo->txtEspanol} </a> </li>
                                        {/foreach}
                                </ul>                            
                        </li>
                    {else}

                        <li>  
                            <a  href="#menu-{$objPadre->txtEspanol}"
                                {if $objPadre->txtEspanol|lower == 'inicio' }
                                    onClick="location.reload(true);"
                                {else}
                                    onClick="cargarContenido('contenido', './contenidos/{$objPadre->txtCodigo}.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu={$seqPadre}', false);"
                                {/if}
                                >{$objPadre->txtEspanol}</a></li>
                        {/if}

                {/foreach}
                <!-- First dropdown menu here-->

                <!-- D<ropdown ending here-->
                <li style="left: 12%;">
                    <a>
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
            </ul>           
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

</nav>
