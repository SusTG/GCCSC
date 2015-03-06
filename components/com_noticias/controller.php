<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componentes
 * @license    GNU/GPL
 */
 

defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
jimport('joomla.environment.request');

class NoticiasController extends JControllerLegacy
{
 
	function crear(){
 		
        $input = JFactory::getApplication()->input;
        
		$modelo = $this->getModel('nueva');
		$modelo->setDatos();
		if ($modelo->validar()) {
		    $modelo->crear();
		    $this->setRedirect(JURI::root(), 'La noticia "' . $modelo->getTitulo() . '" se creo correctamente', 'success');
		}
        else {
            
            JFactory::getApplication()->enqueueMessage('No se pudo crear la noticia', 'warning');   
            
            $input->set('view', 'nueva');
            $vista =& $this->getView($input->get('view'), 'html');
            $vista->modelo = $modelo;
            $this->display();
        }
 	}
    
    function modificar(){
        
        $input = JFactory::getApplication()->input;

        $modelo = $this->getModel('modifica');
        $modelo->setDatos();
        if ($modelo->validar()) {
            $modelo->modificar();
            $this->setRedirect(JURI::root(), 'La noticia "' . $modelo->getTitulo() . '" se modificó correctamente', 'success');
        }
        else {
            
               JFactory::getApplication()->enqueueMessage('No se pudo modificar la noticia', 'warning');   
            
            $input->set('view', 'modifica');
            $vista =& $this->getView($input->get('view'), 'html');
            $vista->modelo = $modelo;
            $this->display();
        }
    }
    
}