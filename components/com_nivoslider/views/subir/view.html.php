<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componentes
 * @license    GNU/GPL
*/
 
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');
 

class NivosliderViewSubir extends JViewLegacy
{
    function display($tpl = null)
    {
        if (isset($this->modelo)) {
            $this->assignRef("modelo", $this->modelo);
        }
        else {
            $this->assignRef("modelo", $this->getModel());
        }
 
        parent::display($tpl);
    }
}