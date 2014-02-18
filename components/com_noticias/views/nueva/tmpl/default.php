<?php defined('_JEXEC') or die('Restricted access'); ?>
<h1><?php echo $this->greeting; ?></h1>

<form class="form-horizontal" role="form" method="post" action="<?php echo JRoute::_('index.php?option=com_noticias'); ?>">
	<input type="hidden" name="task" value="crear" />
	<div class="form-group">
		<label for="titulo" class="col-sm-2 control-label">Título</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="titulo" placeholder="Titulo de la notícia">
			<span class="help-block">Título de la noticia a añadir.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="resumen" class="col-sm-2 control-label">Resumen</label>
		<div class="col-sm-10">
			<textarea class="form-control" id="resumen" placeholder="Breve descripción de la noticia"></textarea>
			<span class="help-block">Breve descripción de la noticia, que se utilizará en el listado de noticias.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="imagen" class="col-sm-2 control-label">Imagen</label>
		<div class="col-sm-10">
			<input type="file" id="imagen" />
			<span class="help-block">Imagen de la noticia. Se mostrará al acceder a los detalles de la misma (opcional).</span>
		</div>
	</div>
	<div class="form-group">
		<label for="pie_imagen" class="col-sm-2 control-label">Pie de la imagen</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="pie_imagen" placeholder="Pie de la imagen de la noticia">
			<span class="help-block">Pie que se mostrará con la imagen de la noticia.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="adjunto" class="col-sm-2 control-label">Adjunto</label>
		<div class="col-sm-10">
			<input type="file" id="imagen" />
			<span class="help-block">Fichero para adjuntar con la noticia (opcional).</span>
		</div>
	</div>
	<div class="form-group">
		<label for="contenido" class="col-sm-2 control-label">Contenido</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="10" id="resumen" placeholder="Contenido de la noticia"></textarea>
			<span class="help-block">Texto con el contenido completo de la noticia. Se mostrará al acceder a los detalles de la misma.</span>
		</div>
	</div>
	<div class="form-group">
		<input type="submit" value="Enviar" />
	</div>
</form>
