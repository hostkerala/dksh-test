<?php

/* @var $this Controller */

$this->widget('zii.widgets.CMenu', array(
	'items' => array(
		array('label' => 'Home', 'url' => array('/')),
		array('label' => 'Infos', 'url' => array('/site/page', 'view' => 'about')),
		array('label' => 'Contact', 'url' => array('/site/contact')),
		array('label' => 'Help', 'url' => array('/site/page', 'view' => 'about')),
	),
));
?>
