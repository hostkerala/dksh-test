<?php $assetsPath = Html::themeUrl() . '/assets/'; ?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Test Application dashboard</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Nego" >

	<link href="<?php echo $assetsPath; ?>css/customForms.css" rel="stylesheet" />
	<link href="<?php echo $assetsPath; ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $assetsPath; ?>css/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo $assetsPath; ?>css/jquery-ui-theme.css" rel="stylesheet" />
	<link href="<?php echo $assetsPath; ?>css/style.css" rel="stylesheet">        
        <link href="<?php echo $assetsPath; ?>js/file_input/css/fileinput.css" rel="stylesheet" />


	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="<?php echo $assetsPath; ?>js/html5shiv.js"></script>
	<![endif]-->

	<!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $assetsPath; ?>img/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $assetsPath; ?>img/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $assetsPath; ?>img/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo $assetsPath; ?>img/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?php echo $assetsPath; ?>img/favicon.png">

	<script>$=jQuery.noConflict();</script>
	<script src="<?php echo $assetsPath; ?>js/jquery-ui.min.js"></script>
	<script src="<?php echo $assetsPath; ?>js/jquery.form.min.js"></script>
	<script src="<?php echo $assetsPath; ?>js/jqueryCustomForms.js"></script>
	<script src="<?php echo $assetsPath; ?>js/bootstrap.min.js"></script>
	<script src="<?php echo $assetsPath; ?>js/autocomplit-combo.js"></script>
	<script src="<?php echo $assetsPath; ?>js/scripts.js"></script> 
        <script src="<?php echo $assetsPath; ?>js/file_input/js/fileinput.js"></script>
</head>
<?php
	$user = User::model()->findByPk( Yii::app()->user->id );
?>
<body>
	<div id="header">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<?php 
                                        Yii::app()->controller->renderFile(Yii::app()->basePath.'/../themes/clientarea/views/layouts/_header.php',array('user' => $user));
                                        //$this->renderPartial('//layouts/_header', array('user' => $user)); ?>
				</div>
			</div>
			<div class="row clearfix">
				<?php 
					if( $this->id != 'site' )
						$this->renderPartial('/layouts/_client_menu', array('user' => $user)); 
				?>
			</div>
		</div>
	</div>
	<div id="content" class="container">
		<?php echo $content; ?>
	</div>
</body>
</html>
