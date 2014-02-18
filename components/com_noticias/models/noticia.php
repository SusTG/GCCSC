<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	com_noticias/models/noticias.php
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');


class NoticiasModelNoticia extends JModel
{
	
	function _getArticuloModel() {
		$pathModelosContent = JPATH_ROOT.DS.'components'.DS.'com_content'.DS.'models';
		JModel::addIncludePath($pathModelosContent);
		return JModel::getInstance( 'article', 'ContentModel' );
	}
	
	function crear() {
		
		$datos['title'] = 'Noticia de prueba';
		$datos['text'] = 'Esto es una noticia de prueba creada con el componente';
		$datos['sectionid'] = 1;
		$datos['catid'] = 1;
		$datos['state'] = 1;
		$datos['details[publish_up]'] = '2014-02-18 17:57';
		$this->_getArticuloModel()->store($datos);
		
	}
	
	
}