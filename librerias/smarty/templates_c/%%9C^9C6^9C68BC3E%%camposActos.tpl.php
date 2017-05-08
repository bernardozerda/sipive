<?php /* Smarty version 2.6.26, created on 2017-05-05 08:47:22
         compiled from actosAdministrativos/camposActos.tpl */ ?>

<div style="padding-bottom: 3px;">
   <b><?php echo $this->_tpl_vars['arrCaracteristica']['txtNombre']; ?>
</b>
</div>
<div style="height: 100%;">
   <?php if ($this->_tpl_vars['arrCaracteristica']['txtTipo'] == 'textarea'): ?>
      <textarea
         name="caracteristicas[<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
]"
         id="<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
         style="width: 100%; height: 100%"
      ><?php echo $this->_tpl_vars['objActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]; ?>
</textarea>
   <?php endif; ?>   
   <?php if ($this->_tpl_vars['arrCaracteristica']['txtTipo'] == 'texto'): ?>
      <input 
         type="text"
         name="caracteristicas[<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
]"
         id="<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF'; sinCaracteresEspeciales(this);"
         style="width: 200px;"
         value="<?php echo $this->_tpl_vars['objActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]; ?>
"
      >
   <?php endif; ?>   
   <?php if ($this->_tpl_vars['arrCaracteristica']['txtTipo'] == 'numero'): ?>
      <input 
         type="text"
         name="caracteristicas[<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
]"
         id="<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF'; soloNumeros(this);"
         style="width: 200px;"
         value="<?php echo $this->_tpl_vars['objActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]; ?>
"
      >
   <?php endif; ?>   
   <?php if ($this->_tpl_vars['arrCaracteristica']['txtTipo'] == 'fecha'): ?>
      <input 
         type="text"
         name="caracteristicas[<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
]"
         id="<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
"
         onFocus="this.style.backgroundColor = '#ADD8E6';"
         onBlur="this.style.backgroundColor = '#FFFFFF';"
         style="width: 200px;"
         value="<?php echo $this->_tpl_vars['objActo']->arrCaracteristicas[$this->_tpl_vars['seqCaracteristica']]; ?>
"
         readonly
         > <a href="#" onClick="calendarioPopUp('<?php echo $this->_tpl_vars['seqCaracteristica']; ?>
')">Calendario</a>
   <?php endif; ?>   
</div>
      
