<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Test Application',
	'theme' => 'public',
	'defaultController' => 'site',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.components.*',
		'application.models.*',
		'application.helpers.*',
		'ext.components.yii-mail.YiiMailMessage',
                'ext.yii-pdf.EYiiPdf',
	),

	'modules'=>array(
		'clientarea',

		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'parola',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.177.210','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'mail' => array(
			'class' => 'ext.components.yii-mail.YiiMail',
                        'transportType'=>'smtp',
                        'logging'=>false,
                        'dryRun' => false,
                        'viewPath' => 'application.modules.clientarea.views.item',
                        'transportOptions'=>array(
                        'host'=>'smtp.lookathere.com',
                        //'encryption' => 'ssl',
                        'username'=>'roopz@lookathere.com',
                        'password'=>'TESTroopz@123',
                        'port'=>'25'
                    ),
                ),           
                'ePdf' => array(
                'class'         => 'ext.yii-pdf.EYiiPdf',
                    'params'        => array(
                        'mpdf'     => array(
                            'librarySourcePath' => 'application.vendors.mpdf.*',
                            'constants'         => array(
                                '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                            ),
                            'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                            /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                                'mode'              => '', //  This parameter specifies the mode of the new document.
                                'format'            => 'A4', // format A4, A5, ...
                                'default_font_size' => 0, // Sets the default document font size in points (pt)
                                'default_font'      => '', // Sets the default font-family for the new document.
                                'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                                'mgr'               => 15, // margin_right
                                'mgt'               => 16, // margin_top
                                'mgb'               => 16, // margin_bottom
                                'mgh'               => 9, // margin_header
                                'mgf'               => 9, // margin_footer
                                'orientation'       => 'P', // landscape or portrait orientation
                            )*/
                        ),
                        'HTML2PDF' => array(
                            'librarySourcePath' => 'application.vendor.html2pdf.*',
                            'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                            /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                                'orientation' => 'P', // landscape or portrait orientation
                                'format'      => 'A4', // format A4, A5, ...
                                'language'    => 'en', // language: fr, en, it ...
                                'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                                'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                                'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                            )*/
                        )
                    )
                ),
		
		'format' => array(
			'class' => 'application.components.Formatter',
			'dateFormat' => 'd/m/Y',
			'timeFormat' => 'H:i',
			'datetimeFormat' => 'd/m/Y H:i',
		),

		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false, 
//			'urlSuffix'=>'.html',
			'rules' => require( dirname(__FILE__).DIRECTORY_SEPARATOR. 'routes.php' ),
		),


		'db' => array_merge(
			//require( dirname(__FILE__).DIRECTORY_SEPARATOR. 'db.php' ), // Prod DB Conf
			require( dirname(__FILE__).DIRECTORY_SEPARATOR. 'db-local.php' ) // DEV DB Conf
		),

		'clientScript' => array(
			'class' => 'ext.core.NLSClientScript',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		/*'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
					'ipFilters'=>array('127.0.0.1','192.168.1.215'),
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),

			),
		),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'office@nego-solutions.com',
                'uploadDir'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'mail_pdf',            
                'customerStatement'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'customer_statement'.DIRECTORY_SEPARATOR.'test.pdf',            
	),
);