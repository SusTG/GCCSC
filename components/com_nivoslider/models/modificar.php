<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	com_noticias/models/noticias.php
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.folder');

jimport('colegiocomun.imagen');

class NivosliderModelModificar extends JModelLegacy
{
    
    function getImagenes() {
        
        $db = JFactory::getDbo();
        
        $consulta = $db->getQuery(true);
        $consulta->select($db->quoteName(array('id', 'title', 'params')));
        $consulta->from($db->quoteName('#__modules'));
        $consulta->where($db->quoteName('module'). ' = \'mod_nivoslider\'');
        
        $db->setQuery($consulta);
        
        $modulos = array();
        $resultados = $db->loadObjectList();
        foreach ($resultados as $resultado) {
            $parametros = json_decode($resultado->params);
            
            $imagenes = explode("\r\n", $parametros->imagenes);;
            foreach ($imagenes as &$imagen) {
                $imagen = array(
                    'path' => '/carrusel/' . $imagen,
                    'nombre' => $imagen );   
            }
            
            $modulo = new stdClass;
            $modulo->id = $resultado->id;
            $modulo->imagenes = $imagenes;
            $modulo->nombre = $resultado->title;
            
            $modulos[] = $modulo;
        }
        
        return $modulos;
    }
	
}