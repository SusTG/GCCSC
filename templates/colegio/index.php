<?php

defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();

//$this -> _scripts = array();

$document -> addStyleSheet(JRoute::_('templates/' . $this -> template . '/css/bootstrap.min.css'));
$document -> addStyleSheet(JRoute::_('templates/' . $this -> template . '/css/bootstrap-theme.min.css'));
$document -> addStyleSheet(JRoute::_('templates/' . $this -> template . '/css/colegio.css'));

//$document -> addScript(JRoute::_('templates/' . $this -> template . '/js/jquery-1.9.0.min.js'));
//$document -> addScript(JRoute::_('templates/' . $this -> template . '/js/bootstrap.min.js'));

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" 
   xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

	<head>
        <?php
            unset($this->_scripts[JURI::root(true).'/media/jui/js/bootstrap.min.js']);
        ?>

        <jdoc:include type="head" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	</head>

	<body>

		<nav class="navbar navbar-fixed-top" role="navigation">

			<div class="container">

				<div class="navbar-brand">
					<a href="<?php echo JURI::base(); ?>">
					    <span class="pequeno">Colegio Público</span>
					    <span>VILLAFRÍA DE OTERO</span>
					    
					</a>
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

                    <ul class="nav navbar-nav navbar-right navbar-default">
                        <li><jdoc:include type="modules" name="user4"/></li>
                    </ul>

                    <div class="navbar-form navbar-right">
                        <jdoc:include type="modules" name="user1"/>
                    </div>

				</div>

			</div>

		</nav>

		<div class="container">

            <jdoc:include type="message"/>

			<div class="row">
			    <div class="col-md-9">
                    <jdoc:include type="modules" name="user2"/>
			    </div>
			    <div class="col-md-3 lateral-cabecera">
                    <jdoc:include type="modules" name="user3"/>
			    </div>
			</div>
			
			<jdoc:include type="component" />

		</div>

        <script src="<?php echo JRoute::_('templates/' . $this -> template . '/js/bootstrap.min.js'); ?>"></script>

	</body>

</html>