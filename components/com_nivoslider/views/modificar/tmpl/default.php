<?php defined('_JEXEC') or die('Restricted access'); ?>

<h1>Gesionar imagenes de los slider</h1>
<?php foreach ($this->getModel()->getImagenes() as $modulo): ?>
    <div class="cabecera-imagenes-nivoslider">
        <h2><?php echo $modulo->nombre ?></h2>
        <a href="<?php echo JRoute::_('index.php?option=com_nivoslider&view=subir'); ?>" class="btn btn-success">
            <span class="glyphicon glyphicon-plus-sign"></span> Añadir una nueva imagen a <?php echo $modulo->nombre; ?>
        </a>
    </div>
    <?php foreach ($modulo->imagenes as $imagen): ?>
        <div class="modificar-imagen-nivoslider">
            <div class="botonera">
                <a href="<?php echo JRoute::_('index.php?option=com_nivoslider&task=borrar&idSlider=' . $modulo->id . '&nombre=' . $imagen['nombre']); ?>" class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash"></span> Borrar
                </a>
            </div>
            <img src="<?php echo JUri::root(true) . '/images' . $imagen['path'] ?>"/>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>