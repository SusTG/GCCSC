<?php

//No puede tener acceso directo
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
require_once(dirname(__FILE__).'/helper.php');

$imagenes = ModNivoSliderHelper::getImagenes($params);

require(JModuleHelper::getLayoutPath('mod_nivoslider'));

?>