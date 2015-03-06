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

class NivosliderModelSubir extends JModelLegacy
{

    function subir() {
        
        $imagen = ColegiocomunImagen::subir('imagen', '/carrusel');
        $this->errores = $imagen->tieneError() ?  $imagen->getError() : false;
        if (empty($this->errores)) {

            $imagen->escalar(848, 196, false);
            
            $db = JFactory::getDbo();
            
            $consulta = $db->getQuery(true);
            $consulta->select($db->quoteName(array('id', 'params')));
            $consulta->from($db->quoteName('#__modules'));
            $consulta->where($db->quoteName('module'). ' = \'mod_nivoslider\'');
            
            $db->setQuery($consulta);
            
            $resultados = $db->loadObjectList();
            foreach ($resultados as $resultado) {
                $parametros = json_decode($resultado->params);
                if (trim($parametros->imagenes) != '') {
                    $parametros->imagenes .= "\r\n";
                }
                $parametros->imagenes .= $imagen->nombre;
                $resultado->params = json_encode($parametros);
            }
            
            foreach ($resultados as $resultado) {
                $consulta = $db->getQuery(true);
                $consulta->update($db->quoteName('#__modules'));
                $consulta->set($db->quoteName('params') . ' = ' . $db->quote($resultado->params, true));
                $consulta->where($db->quoteName('id') . '=' . $resultado->id);
                $db->setQuery($consulta);
                $db->execute();
            }
            
            die('Foto subida');
        }
    }

    function hasError($campo) {
        return isset($this->errores[$campo]);
    }
    
    function getError($campo) {
        return $this->errores[$campo];
    }	
	
}