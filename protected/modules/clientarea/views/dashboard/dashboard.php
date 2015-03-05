<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/views/website/assets/js/jquery.min.js',CClientScript::POS_HEAD); ?>
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
            <a class="navbar-brand" href="#">Navigation</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">TAB 1<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" id="subtab_1_1">SUBTAB 1.1</a></li>
                        <li><a href="#">SUBTAB 1.2</a></li>
                        <li><a href="#">SUBTAB 1.3</a></li>
                        <li><a href="#">SUBTAB 1.4</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">TAB 2<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" id="subtab_1">SUBTAB 2.1</a></li>
                        <li><a href="#">SUBTAB 2.2</a></li>
                        <li><a href="#">SUBTAB 2.3</a></li>
                    </ul>
                </li>
                <li><a href="#">TAB 3</a></li>
                <li><a href="#">TAB 4</a></li>
                <li><a href="#">TAB 5</a></li>
                <li><a href="#">TAB 6</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="row clearfix" id="dashboard-content" style="display: none">
    <div class="col-md-4 column">
        <div class="panel-group" id="panel-259328">
            <?php foreach($categories as $category) : ?>
                <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="panel-title" data-toggle="collapse" data-parent="#panel-259328" href="#panel-element-<?php echo $category->CategoryID; ?>"><?php echo $category->CategoryTitle?></a>
                </div>
                <div id="panel-element-<?php echo $category->CategoryID; ?>" class="panel-collapse collapse">
                    <?php foreach($subcat[$category->CategoryID] as $key=>$val) :?>
                    <div class="panel-body">
                        <a href="#" id="<?php echo $key; ?>"><?php echo $val; ?></a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
            <div class="jumbotron">
                <div class="container">
            <?php echo CHtml::link('Read','javascript:;', array('class' => 'btn btn-default read-item'));?><?php echo CHtml::link('Edit','javascript:;', array('class' => 'btn btn-default edit-item'));?><?php echo CHtml::link('Delete','javascript:;', array('class' => 'btn btn-default delete-item'));?>
                </div>
            </div>
    </div>
    <div class="col-md-8 column" id="add-item">
        <?php foreach($subcategories as $subcategory) : ?>
        <ul class="breadcrumb">
            <li>
                <a href="javascript;:"><?php echo $subcategory->category->CategoryTitle; ?></a>
            </li>
            <li class="active">
                <?php echo $subcategory->SubcategoryTitle; ?>
            </li>
        </ul>
        <?php $items = Items::model()->findAll('SubcategoryID=:subcat_id', array(':subcat_id'=>$subcategory->SubcategoryID))?>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>
                        <?php echo CHtml::checkBox('check_all','',array('data-id'=>$subcategory->SubcategoryID))?>
                    </th>
                    <th>
                        #
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Create Time
                    </th>
                    <th>
                        Submit Time
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Amount Left
                    </th>
                    <th>
                        Total
                    </th>
                    <th>
                        Type
                    </th>
                </tr>
            </thead>
        <?php foreach($items as $item) : ?>
            <tbody>
                <tr id="row-item-<?php echo $item->ItemID;?>">
                    <td>
                        <p><?php echo CHtml::checkBox('','',array('value'=>$item->ItemID,'class'=>'item_id_'.$subcategory->SubcategoryID.' item-id'))?>
                    </td>
                    <td>
                        <?php echo $item->ItemID; ?>
                    </td> 
                    <td>
                        <?php echo $item->ItemName; ?>
                    </td>
                    <td>
                        <?php echo date('d/m/Y', strtotime($item->CreateTime)); ?>
                    </td>
                    <td>
                        <?php echo date('d/m/Y', strtotime($item->SubmitTime)); ?>
                    </td>
                    <td>
                        <?php echo $item->ItemAmount; ?>
                    </td>
                    <td>
                        <?php echo $item->ItemAmountLeft; ?>
                    </td>
                    <td>
                        <?php echo $item->ItemTotal; ?>
                    </td>
                    <td>
                        <?php echo $item->ItemType; ?>
                    </td>
            </tbody>
            <?php endforeach;?>
        </table>
        <?php endforeach; ?>
    </div>
</div>

 <?php
    $this->widget('application.extensions.fullcalendar.FullcalendarGraphWidget' ,
        array(
       	 'data'=>$i,
            'options'=>array(
                'editable'=>true,
                'header'=>array('left'=>'prev,next today','center'=>'title', 'right'=>'month,agendaWeek,agendaDay'),
            ),
            'htmlOptions'=>array(
                   'style'=>'width:800px;margin: 0 auto;'
            ),
        )
    ); 
 ?>

