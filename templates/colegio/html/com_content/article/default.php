<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);
JHtml::_('behavior.caption');
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
    || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));


$app = JFactory::getApplication();
require_once 'templates/' . $app->getTemplate() . '/funciones.php';

?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h1> Prueba<?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
<?php endif;?>

<div class="panel panel-default" itemscope itemtype="http://schema.org/Article">

    <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />

<?php
if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
{
    echo $this->item->pagination;
}
?>

    <?php if (!$useDefList && $this->print) : ?>
        <div id="pop-print" class="btn hidden-print">
            <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
        </div>
        <div class="clearfix"> </div>
    <?php endif; ?>

    <div class="panel-heading">
        <?php if ($params->get('show_title') || $params->get('show_author')) : ?>
            <h2 itemprop="name">
                <?php if ($params->get('show_title')) : ?>
                    <?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
                        <a href="<?php echo $this->item->readmore_link; ?>" itemprop="url"> <?php echo $this->escape($this->item->title); ?></a>
                    <?php else : ?>
                        <?php echo $this->escape($this->item->title); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </h2>
            <?php if ($this->item->state == 0) : ?>
                <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
            <?php endif; ?>
            <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
                <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
            <?php endif; ?>
            <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00') : ?>
                <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!$this->print) : ?>
            <div class="iconos">    
                <div class="dropdown pull-right">
                    <a href="#" data-toggle="dropdown">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($params->get('show_print_icon')) : ?>
                            <li class="print-icon">
                                <?php echo JHtml::_('icon.print_popup', $this->item, $params, array(), false); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($params->get('show_email_icon')) : ?>
                            <li class="email-icon">
                                <?php echo JHtml::_('icon.email', $this->item, $params, array(), false); ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($canEdit) : ?>
                            <li class="edit-icon">
                                <?php if (esNoticia($this->item)): ?>
                                    <a href="<?php echo JRoute::_("index.php?option=com_noticias&view=modifica&id=" . $this->item->id); ?>">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        Editar
                                    </a>
                                <?php else: ?>
                                    <?php echo JHtml::_('icon.edit', $this->item, $params, array(), false); ?>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php else : ?>
            <?php if ($useDefList) : ?>
                <div id="pop-print" class="btn hidden-print">
                    <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="panel-body">
        
        <div class="fecha">
            <?php echo JLayoutHelper::render('joomla.content.info_block.publish_date', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
        </div>
        
        <?php echo $this->item->text; ?>
    
    </div>

    <div class="panel-footer">
        <?php
            if (!empty($this->item->pagination)) {
                echo $this->item->pagination;
            }
        ?>
    </div>

</div>