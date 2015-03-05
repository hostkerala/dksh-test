<?php /* @var $this Controller */ ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">

<title>TestApp</title>

<link rel="stylesheet" href="<?php echo Html::themeUrl(); ?>/assets/css/customForms.css" type="text/css" />
<link rel="stylesheet" href="<?php echo Html::themeUrl(); ?>/assets/css/style.css" type="text/css" />

<!--
<script src="<?php echo Html::themeUrl(); ?>/assets/js/jquery.min.js"></script>
-->
<script src="<?php echo Html::themeUrl(); ?>/assets/js/jquery-ui.js"></script>
<script src="<?php echo Html::themeUrl(); ?>/assets/js/jqueryCustomForms.js"></script>
<script src="<?php echo Html::themeUrl(); ?>/assets/js/jquery.form.min.js"></script>
<script src="<?php echo Html::themeUrl(); ?>/assets/js/main.js"></script>


<!--[if lt IE 9]>
<script src="<?php echo Html::themeUrl(); ?>/assets/js/IE9.js"></script>
<![endif]-->

<!-- disable iPhone inital scale -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
<!-- media queries css -->
<link href="<?php echo Html::themeUrl(); ?>/assets/css/media-queries.css" rel="stylesheet" type="text/css">

<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>
	<script src="<?php echo Html::themeUrl(); ?>/assets/js/html5shiv.js"></script>
<![endif]-->

<!-- css3-mediaqueries.js for IE less than 9 -->
<!--[if lt IE 9]>
	<script src="<?php echo Html::themeUrl(); ?>/assets/js/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body>	
    <div id="main">
    	
       <div id="headerContainer">
       
       		<div class="header">
            	<div class="logo">
                	<img src="<?php echo Html::themeUrl(); ?>/assets/images/logo.png" alt="logo">
                </div>
                <div class="nav">
                	<?php $this->renderPartial('//layouts/_main_menu'); ?>
                </div>
                <div class="user">
					<?php if( Yii::app()->user->isGuest ) : ?>
						<?php echo Html::ajaxButton('Login', array('/user/login'), 
								array( 'success' => 'js:show_popup', 'beforeSend' => 'js:show_popup_shadow' ), 
								array('class' => 'button', 'id' => 'btn_login')); ?>

						<?php echo Html::ajaxButton('Create Account', array('/user/register'), 
								array( 'success' => 'js:show_popup', 'beforeSend' => 'js:show_popup_shadow' ), 
								array('class' => 'button button_1', 'id' => 'btn_register')); ?>
					<?php else : ?>
						<?php echo Html::link('Logout', array('user/logout'), array('class' => 'button')); ?>
					<?php endif; ?>
                </div>
            </div>
       
       </div> 
       
       <div class="container">
        
		<?php echo $content; ?> 
       
           <div class="clear"></div>
            
           <div class="footer">
            
                <div class="content">
                    <div class="social-widget">
                        <img src="<?php echo Html::themeUrl(); ?>/assets/images/twitter-post.png" alt="twitter">
                        Nie musisz już więcej samodzielnie drukować dokumentów, które mają zostać zawarte w przesyłce, adresować kopert, udawać się do urzędów pocztowych i stać w długich kolejkach - możesz to zrobić wprost z komputera przez Internet.<br>
                        <span class="right">- Web developer</span>
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="footCol">
                        <h3>Aktualności</h3>
                        Wyliczanie zobowiązań podatkowych (PIT, VAT) i ubezpieczeniowych  odbywa się automatycznie - wystarczy jedno kliknięcie.<br><br>
                        <input type="text" class="textbox" placeholder="wprowadź swój adres email" id="email" name="email" value=""><span class="gap1"><input type="submit" class="button_2 button_3" name="subscribe" value="Subskrybuj"></span>
                        <div class="clear"></div>
                        
                        <div class="social-icon">
                            <span><a href="#"><img src="<?php echo Html::themeUrl(); ?>/assets/images/twitter-icon.png" alt="twitter"></a></span>
							<span><a href="#"><img src="<?php echo Html::themeUrl(); ?>/assets/images/facebook-icon.png" alt="facebook"></a></span>
							<span><a href="#"><img src="<?php echo Html::themeUrl(); ?>/assets/images/linkedin-icon.png" alt="linkedin"></a></span><br>
                            
                            <span class="right">Copyright © 2014 TEST.COM</span>
                        </div>
                    </div>
                    <div class="footCol right">
                        <h3>Formularz kontaktowy</h3>
                        <div class="col-2">
                            <input type="text" class="textbox textbox_1" placeholder="" id="name" name="name" value="">
                            <input type="text" class="textbox textbox_1" placeholder="" id="email" name="email" value="">
                            <input type="text" class="textbox textbox_1" placeholder="" id="phone" name="phone" value="">
                        </div>
                        <div class="col-2 right">
                            <textarea placeholder="" class="textbox textbox_1 txtarea" id="query" name="query"></textarea><br>
                            
                            <span><input type="submit" class="button_2 button_3" name="send" value="Wyślij"></span>
                        </div>
                    </div>
                </div>
            
           </div>
               
    </div>
    
    </body>
</html>
