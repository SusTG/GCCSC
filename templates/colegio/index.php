<?php

defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument(); 

$this->_scripts = array();

$document->addStyleSheet(JRoute::_('templates/' . $this->template . '/css/bootstrap.min.css'));
$document->addStyleSheet(JRoute::_('templates/' . $this->template . '/css/bootstrap-theme.min.css'));
$document->addStyleSheet(JRoute::_('templates/' . $this->template . '/css/colegio.css'));

$document->addScript(JRoute::_('templates/' . $this->template . '/js/jquery-1.9.0.min.js'));
$document->addScript(JRoute::_('templates/' . $this->template . '/js/bootstrap.min.js'));

?>
<!DOCTYPE html>
<html lang="es">
	
	<head>

		<jdoc:include type="head" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
	</head>
	
	<body>
		
		<div class="container">
		
			<nav class="navbar navbar-default" role="navigation">
				
				<div class="navbar-brand">
					<a href="#">Colegio</a>
				</div>

				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
					<jdoc:include type="modules" name="top" />
					
					<div class="navbar-form navbar-right">
						<jdoc:include type="modules" name="user1"/>
					</div>

				</div>
			</nav>
			
			<jdoc:include type="modules" name="user2"/>
					
			<jdoc:include type="component" />

		</div>
		
	</body>
	
</html>
