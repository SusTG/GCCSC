<?php defined('_JEXEC') or die('Restricted access'); ?>

<form class="form-horizontal" role="form" method="post" action="<?php echo JRoute::_('index.php?option=com_noticias'); ?>" enctype="multipart/form-data">
    
    <div class="panel panel-default">

        <div class="panel-heading">
            <div class="botones">
                <input type="reset" class="btn btn-default" value="Limpiar" />
                <input type="submit" class="btn btn-primary" value="Modifica" />
            </div>
            <h1>Modificar la noticia <?php echo $this->getModel()->getTitulo(); ?></h1>
        </div>
        
        <div class="panel-body">
            <input type="hidden" name="task" value="modificar" />
            <input type="hidden" name="id" value="<?php echo $this->getModel()->getId(); ?>" />
            <div class="form-group <?php echo $this->modelo->hasError('titulo') ? 'has-error' : ''; ?>">
                <label for="titulo" class="col-sm-2 control-label">Título</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="titulo" placeholder="Titulo de la notícia" name="titulo" value="<?php echo $this->modelo->getTitulo(); ?>">
                    <span class="help-block">Título de la noticia a añadir.</span>
                    <?php if ($this->modelo->hasError('titulo')): ?>
                        <div class="error"><?php echo $this->modelo->getError('titulo'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group <?php echo $this->modelo->hasError('resumen') ? 'has-error' : ''; ?>">
                <label for="resumen" class="col-sm-2 control-label">Resumen</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="resumen" placeholder="Breve descripción de la noticia" name="resumen"><?php echo $this->modelo->getResumen(); ?></textarea>
                    <span class="help-block">Breve descripción de la noticia, que se utilizará en el listado de noticias.</span>
                    <?php if ($this->modelo->hasError('resumen')): ?>
                        <div class="error"><?php echo $this->modelo->getError('resumen'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group <?php echo $this->modelo->hasError('contenido') ? 'has-error' : ''; ?>">
                <label for="contenido" class="col-sm-2 control-label">Contenido</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="10" id="resumen" placeholder="Contenido de la noticia" name="contenido"><?php echo $this->modelo->getContenido(); ?></textarea>
                    <span class="help-block">Texto con el contenido completo de la noticia. Se mostrará al acceder a los detalles de la misma.</span>
                    <?php if ($this->modelo->hasError('contenido')): ?>
                        <div class="error"><?php echo $this->modelo->getError('contenido'); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <fieldset>
                <legend>Gestionar imagenes</legend>
                
                <div>
                    
                    <?php foreach ($this->modelo->getImagenes() as $imagen): ?>
                        <img src="<?php echo $this->baseurl . '/' . $imagen ?>" />
                    <?php endforeach; ?>
                </div>
            
                <div id="imagenes">
                    <div id="imagen-base" class="imagen <?php echo $this->modelo->hasError('imagen') ? 'has-error' : ''; ?>">
                        <div class="form-group">
                            <label for="imagen" class="col-sm-2 control-label">Imagen</label>
                            <div class="col-sm-10">
                                <input type="file" id="imagen" name="imagen[]" />
                                <span class="help-block">Imagen de la noticia. Se mostrará al acceder a los detalles de la misma (opcional).</span>
                                <?php if ($this->modelo->hasError('imagen')): ?>
                                    <div class="error"><?php echo $this->modelo->getError('imagen'); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pie_imagen" class="col-sm-2 control-label">Pie de la imagen</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pie_imagen" placeholder="Pie de la imagen de la noticia" name="pie-imagen[]">
                                <span class="help-block">Pie que se mostrará con la imagen de la noticia.</span>
                            </div>
                        </div>
                    </div>
                    <div class="link-mas">
                        <a href="#" id="aniadir-imagen">Mas</a>
                    </div>
                </div>
                <script>
                    jQuery(function () {
                        jQuery('#aniadir-imagen').click(function(e) {
                           e.preventDefault();
                           jQuery('#imagen-base')
                               .clone()
                                   .appendTo(jQuery('#imagenes'));
                        });
                    });
                </script>
            
            </fieldset>
            
        </div>
        
        <div class="panel-footer">
            <input type="reset" class="btn btn-default" value="Limpiar" />
            <input type="submit" class="btn btn-primary" value="Modifica" />
        </div>

    </div>

</form>