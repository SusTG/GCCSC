<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	com_noticias/models/noticias.php
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

jimport('colegiocomun.imagen');

require_once JPATH_COMPONENT_SITE . '/models/noticia.php';

class NoticiasModelNueva extends NoticiaModel
{
    
    function _getCategoriaModel() {
        $pathModelosContent = JPATH_ADMINISTRATOR.'/components/com_categories/models';
        JModelLegacy::addIncludePath($pathModelosContent);
        $pathTablesContent = JPATH_ADMINISTRATOR.'/components/com_categories/tables';
        JTable::addIncludePath($pathTablesContent);
        return JModelLegacy::getInstance( 'category', 'CategoriesModel' );
    }
    
    /*
    function _subirFicheros($fichero) {
        
        $imagenes = array();
        
        // Comprobamos que exista el fichero
        if (!isset($_FILES[$fichero]) || !$_FILES[$fichero]['tmp_name'][0]) {
            return null;
        } 

        for ($i = 0; $i < count($_FILES[$fichero]['name']); $i++) {
 
            $errorFichero = $_FILES[$fichero]['error'][$i];
        
            // Comprobar errores en la subida del fichero
            
            if ($errorFichero > 0) {
                switch ($errorFichero) {
                    case 1:
                        $this->errores[$fichero] = JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );
                    return false;
                case 2:
                    $this->errores[$fichero] = JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
                    return false;
                case 3:
                    $this->errores[$fichero] = JText::_( 'ERROR PARTIAL UPLOAD' );
                    return false;
                case 4:
                    $this->errores[$fichero] = JText::_( 'ERROR NO FILE' );
                        return false;
                }
            }

            // Comprobar el tamaño del fichero
            $tamanioFichero = $_FILES[$fichero]['size'][$i];

            if($tamanioFichero > 2000000) {
                $this->errores[$fichero] = JText::_( 'FILE BIGGER THAN 2MB' );
                return false;
            }
 
            // Comprobar extension del fichero (debe ser una imagen)
            $nombreFichero = $_FILES[$fichero]['name'][$i];
            $indicePunto = strrpos($nombreFichero, '.');
            $extensionFichero = substr($nombreFichero, $indicePunto + 1);
            $nombreFicheroSinExtension = substr($nombreFichero, 0, $indicePunto);
            
            $extensionesValidas = array('jpeg', 'jpg', 'png', 'gif');
            
            $extensionCorrecta = false;
            foreach($extensionesValidas as $clave => $valor) {

                if (preg_match("/$valor/i", $extensionFichero)) {
                    $extensionCorrecta = true;
                    break;
                }
            }
    
            if (!$extensionCorrecta) {
                $this->errores[$fichero] = JText::_( 'INVALID EXTENSION' );
                return false;
            }

            // Comprobamos el tipo mime
    
            $ficheroTemporal = $_FILES[$fichero]['tmp_name'][$i];
            $informacionImagen = getimagesize($ficheroTemporal);
 
            $tipoMimeValidos = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');
    
            if( !is_int($informacionImagen[0]) || !is_int($informacionImagen[1]) ||  !in_array($informacionImagen['mime'], $tipoMimeValidos)) {
                $this->errores[$fichero] = JText::_( 'INVALID FILETYPE' );
                return false;
            }
 
            // Limpiar caracteres "raros" del nombre de fichero
            $nombreFichero = preg_replace("/[^A-Za-z0-9]/i", "-", $nombreFicheroSinExtension)
                . '.'
                . preg_replace("/[^A-Za-z0-9]/i", "-", $extensionFichero);
            $nombreThumb = preg_replace("/[^A-Za-z0-9]/i", "-", $nombreFicheroSinExtension) . '_thumb'
                . '.'
                . preg_replace("/[^A-Za-z0-9]/i", "-", $extensionFichero);

            // Subir el fichero
            $pathSubida = JPATH_SITE.'/images/noticias/';

            if (!JFile::upload($ficheroTemporal, $pathSubida . $nombreFichero)) {
                $this->errores = JText::_( 'ERROR MOVING FILE' );
                return false;
            }
            else {
                
                $imagen = $this->_crearGDImage($pathSubida . $nombreFichero);
                if ($imagen !== false) {
                    $imagenEscalada = imagescale($imagen, 250, 250);
                    imagejpeg($imagenEscalada, $pathSubida . $nombreThumb);
                    imagedestroy($imagen);
                    imagedestroy($imagenEscalada);
                    $imagenes[] = array('img' => 'images/noticias/'.$nombreFichero, 'thumb' => 'images/noticias/'.$nombreThumb);
                }
                else {
                    $imagenes[] = array('img' => 'images/noticias/'.$nombreFichero, 'thumb' => 'images/noticias/'.$nombreFichero);
                }
            }
        }

        return $imagenes;
    }

    function _crearGDImage($path) {
        $info = getimagesize($path);
        switch ($info['mime']) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            default:
                return false;
        }
    }
     */
    
    function _buscarIdCategoriaPorAlias($alias, $aliasPadre = false, $aliasAbuelo = false) {

        $db = $this->getDbo();

        $whereAncestros = '';
        if ($aliasPadre !== false) {
            $whereAncestros .= ' AND ' . $db->quoteName('p.alias') . ' = ' . $db->quote($aliasPadre);
            if ($aliasAbuelo !== false) {
                $whereAncestros .= ' AND ' . $db->quoteName('p.alias') . ' = ' . $db->quote($aliasPadre);
            }
        }

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('c.id')))
            ->from($db->quoteName('#__categories', 'c'))
            ->join('INNER', $db->quoteName('#__categories', 'p'), ' ON (' . $db->quoteName('c.parent_id') . ' = ' . $db->quoteName('p.id') . ')')
            ->where($db->quoteName('c.published') . '= 1 AND ' . $db->quoteName('c.alias') . '=' . $db->quote($alias) . $whereAncestros);
        
        $db->setQuery($query);
        
        $listaCategoria = $db->loadObjectList();

        if (empty($listaCategoria)) {
            return false;
        }
        else {
            return $listaCategoria[0]->id;
        }
    }
    
    function _getCategoriaMes() {
        
        switch (date('n')) {
            case 1: $mes = 'enero'; break;
            case 2: $mes = 'febrero'; break;
            case 3: $mes = 'marzo'; break;
            case 4: $mes = 'abril'; break;
            case 5: $mes = 'mayo'; break;
            case 6: $mes = 'junio'; break;
            case 7: $mes = 'julio'; break;
            case 8: $mes = 'agosto'; break;
            case 9: $mes = 'septiembre'; break;
            case 10: $mes = 'octubre'; break;
            case 11: $mes = 'noviembre'; break;
            case 12: $mes = 'diciembre'; break;
            default: return false;
        }
        $anio = date('o');
        
        $idCategoria = $this->_buscarIdCategoriaPorAlias($mes, $anio, 'noticia');

        if ($idCategoria === false) {

            // Crear la categoria (noticia nueva este mes)

            $idPadre = $this->_buscarIdCategoriaPorAlias($anio, 'noticia');
 
            $categoria = $this->_getCategoriaModel();
            
            if ($idPadre === false) {

                $idPadre = $this->_buscarIdCategoriaPorAlias('noticia');
                
                $categoria->save(array(
                        'id' => 0,
                        'title' => $anio,
                        'alias' => $anio,
                        'published' => true,
                        'parent_id' => $idPadre,
                        'extension' => 'com_content'
                    ));
                
                $idPadre = $categoria->getState('category.id');
            }
            
            $categoria->save(array(
                    'id' => 0,
                    'title' => $mes,
                    'alias' => $mes,
                    'published' => true,
                    'parent_id' => $idPadre,
                    'extension' => 'com_content'
                ));
            
            return $categoria->getState('category.id');
        }
        else {
            return $idCategoria;
        }
    }

    function _subirAdjunto() {
        if (isset($_FILES['adjunto']['tmp_name']) && $_FILES['adjunto']['tmp_name']) {
            $path_destino = JPATH_BASE . '/media/noticias/adjuntos';
            if (!file_exists($path_destino)) {
                mkdir($path_destino, 0777, true);
            }
            $path_destino .= '/' . $_FILES['adjunto']['name'];
            JFile::upload($_FILES['adjunto']['tmp_name'], $path_destino);
            return JUri::base(true) . '/media/noticias/adjuntos/' . $_FILES['adjunto']['name'];
        }
        else {
            return false;
        }
    }
	
	function crear() {
      
        $catid = $this->_getCategoriaMes();
        
        $aliasNoticia = $catid . '_' . $this->alias;

        // Ahora subimos las imagenes
        $imagenes = ColegiocomunImagen::subirGrupo('imagen', '/noticias/' . $aliasNoticia);
        $imagenesNoticia = array();
        $i = 0;
        $hayImagen = false;
        foreach ($imagenes as $imagen) {
            if (!$imagen->tieneError()) {   

                $hayImagen = true;
                //$pathImagen = $imagen->getPathLocal();
                //$imagen->escalar(250, 250, true, '_thumb');
                //$pathThumb = $imagen->getPathLocal();
                
                //$imagenesNoticia[] = array(
                //    'img' => $pathImagen,
                //    'thumb' => $pathThumb,
                //    'pie' => ($i < count($pies)) ? $pies[$i] : false);
            }
            $i++;
        }

        $adjunto = $this->_subirAdjunto();
        
        if ($adjunto) {
            $htmlAdjunto = '<div class="adjunto"><a href="' . $adjunto . '">Descargar adjunto</a></div>';
        }
        else {
            $htmlAdjunto = '';
        }
        
        if ($hayImagen) {
            $galeria = '{gallery}noticias/' . $aliasNoticia . '{/gallery}';
        }
        else {
            $galeria = '';
        }
        
        $contenidoFinal = $htmlAdjunto . $this->resumen . '<hr id="system-readmore" />' . $galeria . $this->contenido;
        
        //$datos['jform[attribs][adjunto]'] = 'Adjunto';
        $datos['title'] = $this->titulo;
        $datos['alias'] = $this->alias;
        $datos['articletext'] = $contenidoFinal;
        $datos['sectionid'] = 1;
        $datos['catid'] = $catid;
        $datos['state'] = 1;
        $datos['language'] = '*';
        $datos['publish_up'] = JFactory::getDate()->toSQL();
        $datos['checked_out'] = JFactory::getDate()->toSQL();
        
        $articulo = $this->_getArticuloModel();
        $articulo->save($datos);
 	}

}