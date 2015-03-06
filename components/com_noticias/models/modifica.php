<?php

/**
 * @version     1.0
 * @package     Joomla
 * @subpackage  com_noticias/models/modifica.php
 * @license     GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('colegiocomun.imagen');

require_once JPATH_COMPONENT_SITE . '/models/noticia.php';

class NoticiasModelModifica extends NoticiaModel
{
    public function __construct() {
        parent::__construct();
        
        $input = JFactory::getApplication()->input;
        
        $this->articulo = $this->_getArticuloModel();
        $this->articulo = $this->articulo->getItem($input->get('id', ''));

        $textoCompleto = $this->articulo->introtext;
 
        $this->id = $this->articulo->id;
        $this->titulo = $this->articulo->title;
        $this->resumen = preg_replace('/<div.*<\/div>/', '', $this->articulo->introtext);
        $this->contenido = preg_replace('/{gallery}.*{\/gallery}/', '', $this->articulo->fulltext);
        
        $coincidencias = array();
        if (preg_match('/<div.*<\/div>/', $this->articulo->fulltext, $coincidencias)){
            $this->adjunto = $coincidencias[0];
        }
        else {
            $this->adjunto = '';
        }
        
        $coincidencias = array();
        if (preg_match('/{gallery}.*{\/gallery}/', $this->articulo->fulltext, $coincidencias)) {
            $this->galeria = $coincidencias[0];
        }
        else {
            $this->galeria = '';
        }
    }
    
    /*
    private static function getArticuloModel() {
        $pathModelosContent = JPATH_ADMINISTRATOR.'/components/com_content/models';
        require_once (JPATH_SITE.'/components/com_content/helpers/query.php');
        JModelLegacy::addIncludePath($pathModelosContent);
        return JModelLegacy::getInstance( 'article', 'ContentModel' );
    }
    */

   public function modificar() {
       
        // Ahora subimos las imagenes
        $imagenes = ColegiocomunImagen::subirGrupo('imagen', '/noticias/' . $this->articulo->catid . '_' . $this->articulo->alias);
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

        if ($hayImagen && $this->galeria == '') {
            $this->galeria = '{gallery}noticias/' . $this->articulo->catid . '_' . $this->articulo->alias . '{/gallery}';
        }

        $contenidoFinal = $this->adjunto . $this->resumen . '<hr id="system-readmore" />' . $this->galeria . $this->contenido;
        
        $datos['id'] = $this->id;
        $datos['title'] = $this->getTitulo();
        $datos['articletext'] = $contenidoFinal;
        $datos['sectionid'] = $this->articulo->sectionid;
        $datos['catid'] = $this->articulo->catid;
        $datos['state'] = $this->articulo->state;
        
        $hoy = JFactory::getDate()->toSQL();
        $datos['publish_up'] = $hoy;
        $datos['checked_out'] = $hoy;
        
        $articulo = $this->_getArticuloModel();
        $articulo->save($datos);
    }

    public function getImagenes() {
        
        $imagenes = array();
        
        $directorioLocal = ColegiocomunImagen::PATH_IMAGENES . '/noticias/' . $this->articulo->catid . '_' . $this->articulo->alias;
        $directorio = JPATH_BASE . $directorioLocal;
        if (is_dir($directorio)) {
            $ficheros = scandir($directorio);

            foreach ($ficheros as $fichero) {
                if ($fichero == '.' || $fichero == '..') {
                    continue;
                }
                if (is_dir($directorio . '/' + $fichero)) {
                    continue;
                }
                
                $imagenes[] = $directorioLocal . '/' . $fichero;
            }
        }
        
        return $imagenes;
    }
}