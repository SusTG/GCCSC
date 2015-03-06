<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$template = & JFactory::getApplication()->getTemplate();
require_once (JPATH_BASE.'/templates/'.$template.'/funciones.php');

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
?>
<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
    || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
    <div class="system-unpublished">
<?php endif; ?>

<div class="panel-heading">

    <h2><?php echo $this->item->title; ?></h2>

    <div class="iconos">    
        <?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
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
        <?php endif; ?>
        
        <?php if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>
            <?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
        <?php endif; ?>
        
        <?php // Todo Not that elegant would be nice to group the params ?>
        <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
            || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') ); ?>

    </div>
            
</div>

<div class="panel-body">

    <div class="fecha">
        <?php echo JLayoutHelper::render('joomla.content.info_block.publish_date', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
    </div>
    
    <?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>
    
    
    <?php if (!$params->get('show_intro')) : ?>
        <?php echo $this->item->event->afterDisplayTitle; ?>
    <?php endif; ?>
    <?php echo $this->item->event->beforeDisplayContent; ?> <?php echo $this->item->introtext; ?>
    
    <?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
        <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
    <?php  endif; ?>
    
    <?php if ($params->get('show_readmore') && $this->item->readmore) :
        if ($params->get('access-view')) :
            $link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
        else :
            $menu = JFactory::getApplication()->getMenu();
            $active = $menu->getActive();
            $itemId = $active->id;
            $link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
            $returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
            $link = new JUri($link1);
            $link->setVar('return', base64_encode($returnURL));
        endif; ?>
    
        <?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>
    
    <?php endif; ?>
    
    <?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
        || ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
    </div>
    <?php endif; ?>
    
    <?php echo $this->item->event->afterDisplayContent; ?>

</div>