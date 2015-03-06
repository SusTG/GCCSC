<?php
	
	//No puede tener acceso directo
	defined('_JEXEC') or die('Direct Access to this location is not allowed.');

    JHtml::_('jquery.framework');

	$document = JFactory::getDocument();
	$document->addScript(JRoute::_('modules/mod_nivoslider/scripts/jquery.nivo.slider.pack.js'));
	$document->addStyleSheet(JRoute::_('modules/mod_nivoslider/css/themes/default/default.css'));
	$document->addStyleSheet(JRoute::_('modules/mod_nivoslider/css/nivo-slider.css'));

	$id = uniqid('slider_');
    $usuario = JFactory::getUser();
?>
<div class="theme-default contenedor-nivoslider">
	<div id="<?php echo $id; ?>" class="nivoSlider">
		<?php foreach ($imagenes as $imagen): ?>
			<img src="<?php echo JRoute::_($imagen); ?>"/>
		<?php endforeach; ?>
	</div>

    <?php if (!$usuario->guest): ?>
        <div class="links-nivoslider">
            <a href="<?php echo JRoute::_('index.php?option=com_nivoslider&view=modificar') ?>">
                <span class="glyphicon glyphicon-cog"></span>
                Modificar sliders
            </a>
        </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('#<?php echo $id; ?>').nivoSlider();
	});
</script>