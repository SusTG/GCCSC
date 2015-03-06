<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componentes
 * @license    GNU/GPL
 */
 

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
jimport('joomla.environment.request');

class NivosliderController extends JControllerLegacy
{
 
	function subir(){
 		
        $input = JFactory::getApplication()->input;
        
		$modelo = $this->getModel('subir');
		if ($modelo->subir()) {
		    die('Imagen subida');
		}
        else {
            $input->set('view', 'nueva');
            $vista =& $this->getView($input->get('view'), 'html');
            $vista->modelo = $modelo;
            $this->display();
        }
 	}
    
    function borrar() {
        
        $this->getModel('borrar')->borrar();
        die('Imagen borrada');
    }
    
}