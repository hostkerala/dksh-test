<?php

include_once(dirname(__FILE__).'/functions_global.php');

// change the following paths if necessary
$yii = dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/config/console.php';

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once( $yii );

$app=Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH.'/cli/commands');

$env = @getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
	$app->commandRunner->addCommands($env);

$app->run();
