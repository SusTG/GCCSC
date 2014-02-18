<?php
/**
 * @package    Joomla.colegio
 * @subpackage Componente: components/com_noticias/noticias.php
 * @license    GNU/GPL
*/
 
// Impedir acceso diracto
defined( '_JEXEC' ) or die( 'Restricted access' );
 
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
$controller = new NoticiasController();
 
$controller->execute( JRequest::getWord( 'task' ) );
$controller->redirect();