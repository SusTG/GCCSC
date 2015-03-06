<?php // no direct access

defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" role="search" class="search<?php echo $params->get('moduleclass_sfx') ?>">

    <div class="input-group">
        <input name="searchword" id="mod_search_searchword" maxlength="<?php echo $maxlength; ?>" size="<?php echo $width; ?>" alt="<?php echo $button_text; ?>" class="form-control col-xs-2 inputbox<?php echo $moduleclass_sfx; ?>" type="text" placeholder="<?php echo $text; ?>" />
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </div>

    <input type="hidden" name="task"   value="search" />
    <input type="hidden" name="option" value="com_search" />
    <input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />

</form>