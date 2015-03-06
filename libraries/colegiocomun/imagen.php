<?php

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class ColegiocomunImagen {
    
    const PATH_IMAGENES = '/images';
    
    public function __construct($destino = null, $nombre = null) {
        $this->directorio = ColegiocomunImagen::PATH_IMAGENES . $destino;
        $this->nombre = $nombre;
    }
    
    public static function subirGrupo($nombre, $destino) {
        
        $ficheros = array();
        
        if (isset($_FILES[$nombre]['name']) && is_array($_FILES[$nombre]['name'])) {
            for ($i = 0; $i < count($_FILES[$nombre]['name']); $i++) {
                $ficheros [] = ColegiocomunImagen::subir($nombre, $destino, $i);
            }
        }
        
        return $ficheros;
    }
    
    public static function subir($nombre, $destino, $indice = false) {

        $imagen = new ColegiocomunImagen();
        $imagen->directorio = ColegiocomunImagen::PATH_IMAGENES . $destino;
        
        if (!file_exists($imagen->directorio)) {
            mkdir($imagen->directorio, 0777, true);
        }
               
        $imagenes = array();
        
        if ($indice !== false) {
            
            // Comprobamos que exista el fichero
            if (!isset($_FILES[$nombre]) || !isset($_FILES[$nombre]['name'][$indice])) {
                $imagen->error = 'Fichero a subir no encontrado';
                return $imagen;
            }
        
            $fichero = array(
                    'error' => $_FILES[$nombre]['error'][$indice],
                    'size' => $_FILES[$nombre]['size'][$indice],
                    'tmp_name' => $_FILES[$nombre]['tmp_name'][$indice],
                    'name' => $_FILES[$nombre]['name'][$indice],
                );
        }
        else {

            // Comprobamos que exista el fichero
            if (!isset($_FILES[$nombre])) {
                $imagen->error = 'Fichero a subir no encontrado';
                return $imagen;
            } 
            
            $fichero = $_FILES[$nombre];
        }
        
        // Comprobar errores en la subida del fichero

        $errorFichero = $fichero['error'];

        if ($errorFichero > 0) {
            switch ($errorFichero) {
            case 1:
                $imagen->error = JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );
                break;
            case 2:
                $imagen->error = JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
                break;
            case 3:
                $imagen->error = JText::_( 'ERROR PARTIAL UPLOAD' );
                break;
            case 4:
                $imagen->error = JText::_( 'ERROR NO FILE' );
                break;
            }
            return $imagen;
        }

        // Comprobar el tamaño del fichero
        $tamanioFichero = $fichero['size'];

        if($tamanioFichero > 2000000) {
            $imagen->error = JText::_( 'FILE BIGGER THAN 2MB' );
            return $imagen;
        }
 
        // Comprobar extension del fichero (debe ser una imagen)
        $nombreFichero = JFile::makeSafe($fichero['name']);
        $indicePunto = strrpos($nombreFichero, '.');
        
        $imagen->extension = JFile::getExt($nombreFichero);
        $imagen->nombreSinExtension = JFile::stripExt($nombreFichero);
            
        $extensionesValidas = array('jpeg', 'jpg', 'png', 'gif');
            
        $extensionCorrecta = false;
        foreach($extensionesValidas as $clave => $valor) {

            if (preg_match("/$valor/i", $imagen->extension)) {
                $extensionCorrecta = true;
                break;
            }
        }

        if (!$extensionCorrecta) {
            $imagen->error = JText::_( 'INVALID EXTENSION' );
            return $imagen;
        }

        // Comprobamos el tipo mime
    
        $ficheroTemporal = $fichero['tmp_name'];
        $informacionImagen = getimagesize($ficheroTemporal);
 
        $tipoMimeValidos = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');
    
        if( !is_int($informacionImagen[0]) || !is_int($informacionImagen[1]) ||  !in_array($informacionImagen['mime'], $tipoMimeValidos)) {
            $imagen->error = JText::_( 'INVALID FILETYPE' );
            return $imagen;
        }

        // Limpiar caracteres "raros" del nombre de fichero
        $imagen->nombre = $imagen->nombreSinExtension . '.' . $imagen->extension;

        if (!JFile::upload($ficheroTemporal, $imagen->getPathUnico())) {
            $imagen->error = JText::_( 'ERROR MOVING FILE' );
        }

        return $imagen;
    }

    public function tieneError() {
        return isset($this->error);
    }

    public function getError() {
        return $this->error;
    }
    
    public function getPathUnico() {
        $contador = 0;
        $modificacion = '';
        do {
            if ($contador > 0) {
                $modificacion = '_' . $contador;
            }
            $contador++;
            $path = JPATH_BASE . $this->directorio . '/' . $this->nombreSinExtension . $modificacion . '.' . $this->extension; 
        }
        while (JFile::exists($path));
        return $path;
    }
    
    public function getPath() {
        return JPATH_SITE . $this->directorio . '/'. $this->nombre;
    }

    public function getPathLocal() {
        return $this->directorio . '/' . $this->nombre;
    }
    
    private function crearGDImage() {
        $info = getimagesize($this->getPath());
        switch ($info['mime']) {
            case 'image/jpeg':
                return imagecreatefromjpeg($this->getPath());
            case 'image/png':
                return imagecreatefrompng($this->getPath());
            default:
                return false;
        }
    }

    public function escalar($ancho, $alto, $conservarOriginal = true, $modificacionDestino = '') {

        $imagen = $this->crearGDImage();
        if ($imagen !== false) {
            
            $this->nombreSinExtension = $this->nombreSinExtension . $modificacionDestino;
            $this->nombre = $this->nombreSinExtension . '.' . $this->extension;

            $imagenEscalada = imagescale($imagen, $ancho, $alto);
            imagejpeg($imagenEscalada, $this->getPath());
            imagedestroy($imagen);
            imagedestroy($imagenEscalada);
            
            if (!$conservarOriginal && $modificacionDestino != '') {
                unlink($this->getPath());
            }
            
            return true;
        }
        else {
            return false;
        }
    }
    
    public function borrar() {
        unlink($this->getPath());
    }
}
