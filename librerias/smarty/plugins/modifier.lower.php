<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 * 			 and replace some latin characters with html entities
 * @link http://smarty.php.net/manual/en/language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @author   Bernardo Zerda <bernardo.zerda@gmail.com>
 * @param string
 * @return string
 */
function smarty_modifier_lower($string)
{
    return strtolower($string);
}

?>
