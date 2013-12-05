<?php
	
	//No puede tener acceso directo
	defined('_JEXEC') or die('Direct Access to this location is not allowed.');

	$document = JFactory::getDocument();
	$document->addScript(JRoute::_('modules/mod_nivoslider/scripts/jquery.nivo.slider.pack.js'));
	$document->addStyleSheet(JRoute::_('modules/mod_nivoslider/css/themes/default/default.css'));
	$document->addStyleSheet(JRoute::_('modules/mod_nivoslider/css/nivo-slider.css'));

	$id = uniqid('slider_');
?>
<div class="theme-default">
	<div id="<?php echo $id; ?>" class="nivoSlider">
		<?php foreach ($imagenes as $imagen): ?>
			<img src="<?php echo JRoute::_($imagen); ?>"/>
		<?php endforeach; ?>
	</div>
</div>

<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('#<?php echo $id; ?>').nivoSlider();
	});
</script>