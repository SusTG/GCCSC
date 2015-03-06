<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Renders the pagination footer
 *
 * @param   array   $list  Array containing pagination footer
 *
 * @return  string         HTML markup for the full pagination footer
 *
 * @since   3.0
 */
function pagination_list_footer($list)
{
    return $list['pageslinks'];
}

/**
 * Renders the pagination list
 *
 * @param   array   $list  Array containing pagination information
 *
 * @return  string         HTML markup for the full pagination object
 *
 * @since   3.0
 */
function pagination_list_render($list)
{
    // Calculate to display range of pages
    $currentPage = 1;
    $range = 1;
    $step = 3;
    foreach ($list['pages'] as $k => $page)
    {
        if (!$page['active'])
        {
            $currentPage = $k;
        }
    }
    if ($currentPage >= $step)
    {
        if ($currentPage % $step == 0)
        {
            $range = ceil($currentPage / $step) + 1;
        }
        else
        {
            $range = ceil($currentPage / $step);
        }
    }

    $html = '<ul class="pagination pagination-sm">';
    $html .= $list['start']['data'];
    $html .= $list['previous']['data'];

    foreach ($list['pages'] as $k => $page)
    {
        if (in_array($k, range($range * $step - ($step + 1), $range * $step)))
        {
            if (($k % $step == 0 || $k == $range * $step - ($step + 1)) && $k != $currentPage && $k != $range * $step - $step)
            {
                $page['data'] = preg_replace('#(<a.*?>).*?(</a>)#', '$1...$2', $page['data']);
            }
        }

        $html .= $page['data'];
    }

    $html .= $list['next']['data'];
    $html .= $list['end']['data'];

    $html .= '</ul>';
    return $html;
}

/**
 * Renders an active item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string                    HTML markup for active item
 *
 * @since   3.0
 */
function pagination_item_active(&$item)
{
    $class = '';

    // Check for "Start" item
    if ($item->text == JText::_('JLIB_HTML_START'))
    {
        $display = '<span class="glyphicon glyphicon-fast-backward"></span>';
    }

    // Check for "Prev" item
    if ($item->text == JText::_('JPREV'))
    {
        $display = '<span class="glyphicon glyphicon-backward"></span>';
    }

    // Check for "Next" item
    if ($item->text == JText::_('JNEXT'))
    {
        $display = '<span class="glyphicon glyphicon-forward"></span>';
    }

    // Check for "End" item
    if ($item->text == JText::_('JLIB_HTML_END'))
    {
        $display = '<span class="glyphicon glyphicon-fast-forward"></span>';
    }

    // If the display object isn't set already, just render the item with its text
    if (!isset($display))
    {
        $display = $item->text;
        $class   = ' class="hidden-phone"';
    }

    return '<li' . $class . '><a title="' . $item->text . '" href="' . $item->link . '">' . $display . '</a></li>';
}

/**
 * Renders an inactive item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string  HTML markup for inactive item
 *
 * @since   3.0
 */
function pagination_item_inactive(&$item)
{
    // Check for "Start" item
    if ($item->text == JText::_('JLIB_HTML_START'))
    {
        $item->text = '<span class="glyphicon glyphicon-fast-backward"></span>';
    }

    // Check for "Prev" item
    if ($item->text == JText::_('JPREV'))
    {
        $item->text = '<span class="glyphicon glyphicon-backward"></span>';
    }

    // Check for "Next" item
    if ($item->text == JText::_('JNEXT'))
    {
        $item->text = '<span class="glyphicon glyphicon-forward"></span>';
    }

    // Check for "End" item
    if ($item->text == JText::_('JLIB_HTML_END'))
    {
        $item->text = '<span class="glyphicon glyphicon-fast-forward"></span>';
    }

    // Check if the item is the active page
    if (isset($item->active) && ($item->active))
    {
        return '<li class="active hidden-phone"><a>' . $item->text . '</a></li>';
    }

    // Doesn't match any other condition, render a normal item
    return '<li class="disabled hidden-phone"><a>' . $item->text . '</a></li>';
}
