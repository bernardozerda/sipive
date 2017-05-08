<?php /* Smarty version 2.6.26, created on 2017-05-05 07:37:25
         compiled from menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', 'menu.tpl', 13, false),)), $this); ?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
<link rel="stylesheet" href="recursos/estilos/bootstrap.min.css" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!--<link href="recursos/estilos/layout.css" rel="stylesheet" type="text/css" />
        <link href="recursos/estilos/menu.css" rel="stylesheet" type="text/css" />
<div id="menu" class="yuimenubar yuimenubarnav">
    <div class="bd">
        <ul class="first-of-type">
<?php $_from = $this->_tpl_vars['arrMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuPrincipal'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuPrincipal']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['seqPadre'] => $this->_tpl_vars['objPadre']):
        $this->_foreach['menuPrincipal']['iteration']++;
?>
    <li class="yuimenubaritem first-of-type">
        <a class="yuimenubaritemlabel" href="#menu-<?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
"
    <?php if (((is_array($_tmp=$this->_tpl_vars['objPadre']->txtEspanol)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'inicio'): ?>
        onClick="location.reload(true);"
    <?php else: ?>
        onClick="cargarContenido('contenido', './contenidos/<?php echo $this->_tpl_vars['objPadre']->txtCodigo; ?>
.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu=<?php echo $this->_tpl_vars['seqPadre']; ?>
', false);"
    <?php endif; ?>
    ><?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
</a>
    <?php if (! empty ( $this->_tpl_vars['objPadre']->hijos )): ?>
        <div id="menu-<?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
" class="yuimenu">
            <div class="bd">
                <ul>
        <?php $_from = $this->_tpl_vars['objPadre']->hijos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqHijo'] => $this->_tpl_vars['objHijo']):
?>
            <li class="yuimenuitem">
                <a class="yuimenuitemlabel" href="#menu-<?php echo $this->_tpl_vars['objHijo']->txtEspanol; ?>
" 
                   onClick="cargarContenido('contenido', './contenidos/<?php echo $this->_tpl_vars['objHijo']->txtCodigo; ?>
.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu=<?php echo $this->_tpl_vars['seqHijo']; ?>
', false);"
                   ><?php echo $this->_tpl_vars['objHijo']->txtEspanol; ?>
</a>
            </li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>
</div>
    <?php endif; ?>

</li>
<?php endforeach; endif; unset($_from); ?>
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
                <?php $_from = $this->_tpl_vars['arrMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menuPrincipal'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menuPrincipal']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['seqPadre'] => $this->_tpl_vars['objPadre']):
        $this->_foreach['menuPrincipal']['iteration']++;
?>
                    <?php if (! empty ( $this->_tpl_vars['objPadre']->hijos )): ?>                    
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
 <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (((is_array($_tmp=$this->_tpl_vars['objPadre']->txtEspanol)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'inicio' && ((is_array($_tmp=$this->_tpl_vars['objPadre']->txtEspanol)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'proceso' && ((is_array($_tmp=$this->_tpl_vars['objPadre']->txtEspanol)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'esquemas' && ((is_array($_tmp=$this->_tpl_vars['objPadre']->txtEspanol)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) != 'administracion'): ?>   
                                        <li><a href="#menu-<?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
"                                                                             
                                               onClick="cargarContenido('contenido', './contenidos/<?php echo $this->_tpl_vars['objPadre']->txtCodigo; ?>
.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu=<?php echo $this->_tpl_vars['seqPadre']; ?>
', false);"
                                               ><?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
 </a> </li>
                                        <?php endif; ?>
                                        <?php $_from = $this->_tpl_vars['objPadre']->hijos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqHijo'] => $this->_tpl_vars['objHijo']):
?>
                                        <li><a href="#menu-<?php echo $this->_tpl_vars['objHijo']->txtEspanol; ?>
" onClick="cargarContenido('contenido', './contenidos/<?php echo $this->_tpl_vars['objHijo']->txtCodigo; ?>
.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu=<?php echo $this->_tpl_vars['seqHijo']; ?>
', false);"><?php echo $this->_tpl_vars['objHijo']->txtEspanol; ?>
 </a> </li>
                                        <?php endforeach; endif; unset($_from); ?>
                                </ul>                            
                        </li>
                    <?php else: ?>

                        <li>  
                            <a  href="#menu-<?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
"
                                <?php if (((is_array($_tmp=$this->_tpl_vars['objPadre']->txtEspanol)) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == 'inicio'): ?>
                                    onClick="location.reload(true);"
                                <?php else: ?>
                                    onClick="cargarContenido('contenido', './contenidos/<?php echo $this->_tpl_vars['objPadre']->txtCodigo; ?>
.php', '', true); cargarContenido('rutaMenu', './rutaMenu.php', 'menu=<?php echo $this->_tpl_vars['seqPadre']; ?>
', false);"
                                <?php endif; ?>
                                ><?php echo $this->_tpl_vars['objPadre']->txtEspanol; ?>
</a></li>
                        <?php endif; ?>

                <?php endforeach; endif; unset($_from); ?>
                <!-- First dropdown menu here-->

                <!-- D<ropdown ending here-->
                <li style="left: 12%;">
                    <a>
                        <select name="proyecto" id="proyecto" class="selector"
                                onChange="cargarContenido('bodyHtml', './index.php', 'proyecto=' + this.options[ this.selectedIndex ].value, true);">
                            <?php $_from = $this->_tpl_vars['arrProyectos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['seqProyecto'] => $this->_tpl_vars['objProyecto']):
?>
                                <option value="<?php echo $this->_tpl_vars['seqProyecto']; ?>
"
                                        <?php if ($this->_tpl_vars['seqProyectoPost'] == $this->_tpl_vars['seqProyecto']): ?> selected <?php endif; ?>
                                        ><?php echo $this->_tpl_vars['objProyecto']->txtProyecto; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </a>
                </li>
            </ul>           
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

</nav>