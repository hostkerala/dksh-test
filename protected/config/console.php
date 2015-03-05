<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db' => array_merge(
			//require( dirname(__FILE__).DIRECTORY_SEPARATOR. 'db.php' ), // Prod DB Conf
			require( dirname(__FILE__).DIRECTORY_SEPARATOR. 'db-local.php' ) // DEV DB Conf
		),
		// uncomment the following to use a MySQL database
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);