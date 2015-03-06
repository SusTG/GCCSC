<?php defined('_JEXEC') or die('Restricted access'); ?>
<h1>Subir nueva noticia</h1>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_nivoslider'); ?>">
	<input type="hidden" name="task" value="subir" />
	<div class="form-group">
		<label for="imagen" class="col-sm-2 control-label">Imagen</label>
		<div class="col-sm-10">
			<input type="file" class="form-control" id="imagen" placeholder="Imagen a subir" name="imagen">
			<span class="help-block">Imagen a añadir al carrusel.</span>
		</div>
	</div>
	<div class="form-group">
		<input type="submit" value="Enviar" />
	</div>
</form>
