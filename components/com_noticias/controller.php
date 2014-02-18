<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componentes
 * @license    GNU/GPL
 */
 

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
jimport('joomla.environment.request');

class NoticiasController extends JController
{
 
	function crear(){
 		
		$noticia = JRequest::get('post');
		
		$modelo = $this->getModel('noticia');
		$modelo->crear();
		
		die();
 	}
    
}