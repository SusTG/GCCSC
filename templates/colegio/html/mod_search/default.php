<?php // no direct access

defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" role="search" class="search<?php echo $params->get('moduleclass_sfx') ?>">
	<?php
	    
	    $output = '<div class="form-group"><input name="searchword" id="mod_search_searchword" maxlength="'.$maxlength.'" size="'.$width.'" alt="'.$button_text.'" class="form-control inputbox'.$moduleclass_sfx.'" type="text" placeholder="'.$text.'" /></div>';
	
		if ($button) :
			$button = ' <button type="submit" class="btn btn-default button'.$moduleclass_sfx.'" onclick="this.form.searchword.focus();">';
		    if ($imagebutton) :
		        $button .= '<span class="glyphicon glyphicon-search"></span>';
		    else :
		        $button .= $button_text;
		    endif;
			$button .= '</button> ';
		endif;

		switch ($button_pos) :
		    case 'top' :
			    $button = $button.'<br />';
			    $output = $button.$output;
			    break;

		    case 'bottom' :
			    $button = '<br />'.$button;
			    $output = $output.$button;
			    break;

		    case 'right' :
			    $output = $output.$button;
			    break;

		    case 'left' :
		    default :
			    $output = $button.$output;
			    break;
		endswitch;

		echo $output;
	?>
	<input type="hidden" name="task"   value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
</form>