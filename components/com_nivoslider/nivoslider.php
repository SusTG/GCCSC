<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componente: components/com_noticias/noticias.php
 * @license    GNU/GPL
*/
 
// Impedir acceso diracto
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
$controller = JControllerLegacy::getInstance('Nivoslider');
 
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task' ));

$controller->redirect();