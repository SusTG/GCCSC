<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componentes
 * @license    GNU/GPL
*/
 
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 

class NoticiasViewNueva extends JView
{
    function display($tpl = null)
    {
        $greeting = "¡Noticias!";
        $this->assignRef( 'greeting', $greeting );
 
        parent::display($tpl);
    }
}