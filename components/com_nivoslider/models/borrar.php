<?php
/**
 * @version     1.0
 * @package     Joomla
 * @subpackage  com_noticias/models/noticias.php
 * @license     GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.folder');

jimport('colegiocomun.imagen');

class NivosliderModelBorrar extends JModelLegacy
{
    public function borrar() {
            
        $input = JFactory::getApplication()->input;
 
        $id = (int)$input->get('idSlider');
        $nombre = $input->get('nombre');
        
        $db = JFactory::getDbo();
            
        $consulta = $db->getQuery(true);
        $consulta->select($db->quoteName(array('id', 'params')));
        $consulta->from($db->quoteName('#__modules'));
        $consulta->where($db->quoteName('id'). ' = '. $id);
        
        $db->setQuery($consulta);
        
        $resultado = $db->loadObject();
        if ($resultado != null) {
            $parametros = json_decode($resultado->params);
            $imagenes = explode("\r\n", $parametros->imagenes);
            $i = array_search($nombre, $imagenes);
            unset($imagenes[$i]);
            
            // Meter array de imagenes en imagen
            $strImagenes = '';
            foreach ($imagenes as $imagen) {
                if ($strImagenes != '') {
                    $strImagenes .= "\r\n";
                }
                $strImagenes .= $imagen;
            }
            $parametros->imagenes = $strImagenes;
            $resultado->params = json_encode($parametros);

            $consulta = $db->getQuery(true);
            $consulta->update($db->quoteName('#__modules'));
            $consulta->set($db->quoteName('params') . ' = ' . $db->quote($resultado->params, true));
            $consulta->where($db->quoteName('id') . '=' . $resultado->id);
            $db->setQuery($consulta);
            $db->execute();
        }
        
        $imagen = new ColegiocomunImagen('/carrusel', $nombre);
        $imagen->borrar();
    }
}