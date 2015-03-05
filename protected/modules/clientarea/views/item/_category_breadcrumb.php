<?php

/* @var $category Category */

if( !empty($category) )
{
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink' => false,
		'tagName' => 'ul',
		'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
		'inactiveLinkTemplate' => '<li>{label}</li>',
		'separator' => '',
		'htmlOptions' => array('class' => 'breadcrumb'),
		'links' => array(
			$category->parent()->find()->category_title => '#',
			$category->category_title,
		),
	));
}