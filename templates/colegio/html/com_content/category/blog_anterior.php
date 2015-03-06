<?php
defined('_JEXEC') or die('Restricted access');
$cparams =& JComponentHelper::getParams('com_media');
?>

<?php if ($this->params->get('show_page_title')) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>

<?php if ($this->params->def('show_description', 1) || $this->params->def('show_description_image', 1)) :?>

	<?php if ($this->params->get('show_description_image') && $this->section->image) : ?>
		<img src="<?php echo $this->baseurl . '/' . $cparams->get('image_path') . '/'. $this->section->image;?>" align="<?php echo $this->section->image_position;?>" hspace="6" alt="" />
	<?php endif; ?>
	<?php if ($this->params->get('show_description') && $this->section->description) : ?>
		<?php echo $this->section->description; ?>
	<?php endif; ?>

<?php endif; ?>

<?php if ($this->params->def('num_leading_articles', 1)) : ?>

	<?php for ($i = $this->pagination->limitstart; $i < ($this->pagination->limitstart + $this->params->get('num_leading_articles')); $i++) : ?>
		<?php if ($i >= $this->total) : break; endif; ?>

        <div class="panel panel-default blog-item">
    		<?php
    			$this->item =& $this->getItem($i, $this->params);
    			echo $this->loadTemplate('item');
    		?>
		</div>

	<?php endfor; ?>

<?php else : $i = $this->pagination->limitstart; endif; ?>

<?php
	$startIntroArticles = $this->pagination->limitstart + $this->params->get('num_leading_articles');
	$numIntroArticles = $startIntroArticles + $this->params->get('num_intro_articles', 4);
	if (($numIntroArticles != $startIntroArticles) && ($i < $this->total)) :
?>
        <div class="misma-altura-md">
    	<?php
    		$filas = (int) ($this->params->get('num_intro_articles', 4) / $this->params->get('num_columns'));
    		$columnas = $this->params->get('num_columns');
    		$colClase = (int)12 / $columnas;
    		for ($fila = 0; $fila < $filas; $fila++):
    	?>
    		<div class="row">
    			<?php
    				for ($columna = 0; $columna < $columnas; $columna++):
    			?>
    				<div class="col-md-<?php echo $colClase?> col panel panel-default blog-item">
    					<?php
    						$this->item =& $this->getItem($i, $this->params);
    						echo $this->loadTemplate('item');
    						$i++;
    					?>
    				</div>
    			<?php
    				endfor;
    			?>
    		</div>
    	<?php
    		endfor;
    	?>
        </div>
<?php endif; ?>
<?php if ($this->params->def('num_links', 4) && ($i < $this->total)) : ?>

			<?php
				$this->links = array_splice($this->items, $i - $this->pagination->limitstart);
				echo $this->loadTemplate('links');
			?>

<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2)) : ?>

		<?php echo $this->pagination->getPagesLinks(); ?>

<?php endif; ?>
<?php if ($this->params->def('show_pagination_results', 1)) : ?>

		<?php echo $this->pagination->getPagesCounter(); ?>

<?php endif; ?>



