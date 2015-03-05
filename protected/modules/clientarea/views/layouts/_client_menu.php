<?php

/* @var $this ClientareaController */ // we do not know the controller of this here, so for IDE we can use parent class
/* @var $user User */

?>
<?php if( $this->id == 'dashboard' ) : // this nav is only for dashboard ?>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
	<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="dropdown open">
					<a href="#" class="dropdown-toggle">Tab1</span></a>
					<ul class="dropdown-menu" role="menu">
						<li class="open"><a href="<?php echo Html::url('/clientarea/dashboard/calendar'); ?>" data-alias="#calendar">Subtab 1.1</a></li>
						<li><a href="#">Subtab 1.2</a></li>
						<li><a href="#">Subtab 1.3</a></li>
						<li><a href="#">Subtab 1.4</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle">Tab 2</span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo Html::url('/clientarea/item/index'); ?>" data-alias="#items">Subtab 2.1</a></li>
                        <li><a href="<?php echo Html::url(array('item/index','categoryType' => Category::TYPE_OUT)); ?>" data-alias="#items">Subtab 2.2</a></li>
						<li><a href="#">Subtab 2.3</a></li>
					</ul>
				</li>
				<li><a href="#">Tab 3</a></li>
				<li><a href="#">Tab 4</a></li>
				<li><a href="#">Tab 5</a></li>
				<li><a href="#">Tab 6</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<?php endif; ?>