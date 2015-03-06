<?php

defined('_JEXEC') or die;

$lang   = JFactory::getLanguage();
$class = ' class="first"';
?>

<?php if (count($this->children[$this->category->id]) > 0) : ?>
    <ul class="pagination">
    <?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
        <?php
        if ($this->params->get('show_empty_categories') || $child->getNumItems(true) || count($child->getChildren())) :
            if (!isset($this->children[$this->category->id][$id + 1])) :
                $class = ' class="last"';
            endif;
        ?>

            <?php $class = ''; ?>
            <?php if ($lang->isRTL()) : ?>
            <li>
                <?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
                    <span class="badge badge-info tip hasTooltip" title="<?php echo JHtml::tooltipText('COM_CONTENT_NUM_ITEMS'); ?>">
                        <?php echo $child->getNumItems(true); ?>
                    </span>
                <?php endif; ?>
                <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id));?>">
                <?php echo $this->escape($child->title); ?></a>

                <?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
                    <a href="#category-<?php echo $child->id;?>" data-toggle="collapse" data-toggle="button" class="btn btn-mini pull-right"><span class="icon-plus"></span></a>
                <?php endif;?>
            </li>
            <?php else : ?>
            <li><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id));?>">
                <?php echo $this->escape($child->title); ?></a>
                <?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
                    <span class="badge badge-info tip hasTooltip" title="<?php echo JHtml::tooltipText('COM_CONTENT_NUM_ITEMS'); ?>">
                        <?php echo $child->getNumItems(true); ?>
                    </span>
                <?php endif; ?>

                <?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
                    <a href="#category-<?php echo $child->id;?>" data-toggle="collapse" data-toggle="button" class="btn btn-mini pull-right"><span class="icon-plus"></span></a>
                <?php endif;?>
            <?php endif;?>
            </li>
            <?php if ($this->params->get('show_subcat_desc') == 1) :?>
                <?php if ($child->description) : ?>
                    <div class="category-desc">
                        <?php echo JHtml::_('content.prepare', $child->description, '', 'com_content.category'); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (count($child->getChildren()) > 0 && $this->maxLevel > 1) :?>
            <div class="collapse fade" id="category-<?php echo $child->id;?>">
                <?php
                $this->children[$child->id] = $child->getChildren();
                $this->category = $child;
                $this->maxLevel--;
                echo $this->loadTemplate('children');
                $this->category = $child->getParent();
                $this->maxLevel++;
                ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
