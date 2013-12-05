<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

if ( ! defined('modMainMenuXMLCallbackDefined') )
{
function modMainMenuXMLCallback(&$node, $args)
{
	global $vistoUl;
	
	$user	= &JFactory::getUser();
	$menu	= &JSite::getMenu();
	$active	= $menu->getActive();
	$path	= isset($active) ? array_reverse($active->tree) : null;

	if ($node->name() == 'ul') {
		if (!$vistoUl) {
			$vistoUl = true;
		}
		else {
			$node->addAttribute('class', 'dropdown-menu');
		}
	}

	if (($node->name() == 'li') && isset($node->ul)) {
		$node->addAttribute('class', 'dropdown');
	}
	
	// Hacemos toggleables los enlaces raiz
	if ($node->name() == 'a' && $node->level() == 2) {
		$node->addAttribute('class', 'dropdown-toggle');
		$node->addAttribute('data-toggle', 'dropdown');
	}

	if (isset($path) && (in_array($node->attributes('id'), $path) || in_array($node->attributes('rel'), $path)))
	{
		if ($node->attributes('class')) {
			$node->addAttribute('class', $node->attributes('class').' active');
		} else {
			$node->addAttribute('class', 'active');
		}
	}

	$node->removeAttribute('id');
	$node->removeAttribute('rel');
	$node->removeAttribute('level');
	$node->removeAttribute('access');
}
	define('modMainMenuXMLCallbackDefined', true);
}

$params->set('class_sfx', ' nav navbar-nav');
modMainMenuHelper::render($params, 'modMainMenuXMLCallback');
