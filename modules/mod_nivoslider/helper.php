<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModNivoSliderHelper
{

	public static function getImagenes($params) {
		
		$carpeta = $params->get('carpeta');
		$imagenes = split("\n", $params->get('imagenes'));
		$urls = array();
		foreach ($imagenes as $imagen) {
			$urls[] = $carpeta . '/' . $imagen;
		}
		
		return $urls;
	}  
 
}

?>