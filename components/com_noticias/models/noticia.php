<?php

/**
 * @version     1.0
 * @package     Joomla
 * @subpackage  com_noticias/models/noticia.php
 * @license     GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

class NoticiaModel extends JModelLegacy
{
    protected $errores = array();
    
    protected $contenido = '';
    protected $resumen = '';
    protected $titulo = '';
    protected $alias = '';
    protected $pies = array();

    function _getArticuloModel() {

        $pathModelosContent = JPATH_ADMINISTRATOR.'/components/com_content/models';
        JModelLegacy::addIncludePath($pathModelosContent);
        return JModelLegacy::getInstance( 'article', 'ContentModel' );
    }

    function hasError($campo) {
        return isset($this->errores[$campo]);
    }
    
    function getError($campo) {
        return $this->errores[$campo];
    }
    
    public function getErrores() {
        return $this->errores;
    }

    public function getId() {
        return $this->id;
    }
    
    public function getTitulo() {
       return $this->titulo;
    }

    public function getResumen(){
       return $this->resumen;
    }
    
    public function getContenido(){
        return $this->contenido;
    }
    
    function setDatos() {
 
        $input = JFactory::getApplication()->input;
      
        $this->contenido = $input->get('contenido', '', 'STRING');
        $this->resumen = $input->get('resumen', '', 'STRING');
        $this->titulo = $input->get('titulo', '', 'STRING');
        $this->alias = JApplication::stringURLSafe($this->titulo);
        $this->pies = $input->getArreay('pie-imagen');
    }
    
    function validar() {
        if (strlen($this->resumen) > 150) {
            $this->errores['resumen'] = 'El resumen no puede ser mayor de 150 caracteres.'; 
        }
        
        if (trim($this->titulo) == '') {
            $this->errores['titulo'] = 'El título no puede estar vacío.';
        }
        
        if (trim($this->resumen) == '') {
            $this->errores['resumen'] = 'El resumen no puede estar vacío.';
        }
        
        if (trim($this->contenido) == '') {
            $this->errores['contenido'] = 'El contenido no puede estar vacío.';
        }
        
        return count($this->errores) == 0;
    }

}