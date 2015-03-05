<?php
/* @var $this DashboardController */
/* @var $events array */
?>


<?php
	$this->widget('ext.widgets.fullcalendar.FullcalendarGraphWidget' ,
		array(
			'data' => $events,
				'options'=>array(
					'editable' => true,
					'header' => array('left'=>'prev,next today','center'=>'title', 'right'=>'month,agendaWeek,agendaDay'),
				),
				'htmlOptions'=>array(
					'style' => 'margin: 0 auto;'
				),
			'scriptFile' => array('fullcalendar.js'),
		)
	); 
?>
