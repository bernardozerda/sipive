<?php /* Smarty version 2.6.26, created on 2017-05-04 21:34:07
         compiled from mensajes.tpl */ ?>
	
<!--
	ARCHIVO QUE MUESTRA LA TABLA DE ERRORES (ver funciones.php funcion imprimirMensajes )
	PENDIENTES TODOS LOS CAMBIOS REFERENTES A LAS PLANTILLAS DE DISE�O
	@author Bernardo Zerda 
	@version 0.1 Abil de 2009
-->

    <table cellpadding="0" cellspacing="0" border="0" width="100%" id="tablaMensajes" style="padding:5px" class="<?php echo $this->_tpl_vars['estilo']; ?>
">
        <?php $_from = $this->_tpl_vars['arrImprimir']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['txtMensaje']):
?>
            <tr><td class="<?php echo $this->_tpl_vars['estilo']; ?>
"><li><?php echo $this->_tpl_vars['txtMensaje']; ?>
</li></td></tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
    
    <?php if ($this->_tpl_vars['idDivOculto'] != ""): ?>
    	<div id="<?php echo $this->_tpl_vars['idDivOculto']; ?>
"></div>
    <?php endif; ?>
    