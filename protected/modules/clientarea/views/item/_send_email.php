<div class="form-wrap form-horizontal">
    <div class="alert alert-info" style="display:none" id="loading-indicator" >Sending Mail. Please wait...</div>
    <div class="row">
            <div class="form-group">
                <?php echo $form->labelEx($model,'from', array('class' => 'control-label')); ?>
                <?php echo $form->textField($model,'from',array('size'=>30)); ?>
                <?php echo $form->error($model,'from'); ?>
            </div>
            <div class="form-group">
                    <?php echo $form->labelEx($model,'to', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model,'to',array('placeholder'=>"Comma seperated To address",'type'=>'text','size'=>30)); ?>                             
                    <?php echo $form->error($model,'to'); ?>
            </div>
            <div class="form-group">
                    <?php echo $form->labelEx($model,'cc', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model,'cc',array('placeholder'=>"Comma seperated CC address",'type'=>'text','size'=>30)); ?>         
                    <?php echo $form->error($model,'cc'); ?>
            </div>
            <div class="form-group">
                    <?php echo $form->labelEx($model,'subject', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model,'subject',array('maxlength'=>128,'size'=>30)); ?>
                    <?php echo $form->error($model,'subject'); ?>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'body', array('class' => 'control-label')); ?>
                <?php 
                $editMe = $this->widget('ext.editMe.widgets.ExtEditMe', array(
                    'name'  =>'SendMailForm[body]',
                    'value' => $model->body,
                    'toolbar'=>
                        array(
                            array(
                               'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates',
                           ),
                           array(
                               'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo',
                           ),
                           array(
                               'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
                           ),
                           array(
                               'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'
                           ),
                           '/',
                           array(
                               'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                           ),
                           array(
                               'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl',
                           ),
                           array(
                               'Link', 'Unlink', 'Anchor',
                           ),
                           array(
                               'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'
                           ),
                           '/',
                           array(
                               'Styles', 'Format', 'Font', 'FontSize',
                           ),
                           array(
                               'TextColor', 'BGColor',
                           ),
                           array(
                               'Maximize', 'ShowBlocks',
                           ),
                           array(
                               'About',
                           ),
                    )
                ));
                ?>
                <?php echo $form->error($model,'body'); ?>     
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <?php echo $form->labelEx($model,'attach_customer_statement',array('class'=>'no-padding')); ?>                    
                </div>
                <div class="col-md-6">
                    <?php echo $form->checkBox($model,'attach_customer_statement',array('style'=>'margin-top:50px;')); ?>                    
                </div>      
                    <?php echo $form->error($model,'attach_customer_statement'); ?>  
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <?php echo $form->labelEx($model,'attach_pdf'); ?>                
                </div>
                <div class="col-md-6">
                    <?php echo $form->checkBox($model,'attach_pdf'); ?>         
                </div>      
                    <?php echo $form->error($model,'attach_pdf'); ?>                
            </div>
        
            <div class="form-group">
                <div class="col-md-6">
                    <?php echo $form->labelEx($model,'attach_files', array('class' => 'control-label','style'=>'text-align:left')); ?>
                </div>
                 <div class="col-md-4 buttons" style="padding-top:0px;text-align:left">
                     <span class="btn btn-primary btn-file">
                        Attach Files <input name ="attach_files[]" type="file" multiple>                        
                    </span>
                    <span id="file-feedback">Nothing Attached</span>
                 </div>
                <?php echo $form->error($model,'attach_files'); ?>
            </div>
        
            <div class="form-group">
                <div class="buttons">
                    <?php   echo $form->hiddenField($model,'selected_items');  ?>
                    <?php   echo CHtml::submitButton('Send', array('class' => 'btn btn-primary')); ?>            
                    <?php   echo Html::link('Cancel', 
                                        array( ItemController::LIST_ACTION_ROUTE ), 
                                        array('data-target' => '#item-content', 'class' => 'btn btn-default')
                                ); 
                    ?>
                </div>
            </div>
        </div>
    </div>
<style>

#loading-indicator 
{
    display: none;
    width:300px;
    height: 50px;
    position: fixed;
    top: 50%;
    left: 50%;
    text-align:center;
    padding:10px;
    font:normal 16px Tahoma, Geneva, sans-serif;
    margin-left: -50px;
    margin-top: -50px;
    z-index:2;
    overflow: auto;
} 

.checkboxArea
{
     margin-top:20px;
}
.checkboxAreaChecked
{    
    margin-top:20px;
}

.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>

<script>
    $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    $(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        $("#file-feedback").html(numFiles+" Files attached");
    });
    });

    $(document).ajaxSend(function(event, request, settings) {
      $('#loading-indicator').show();
    });

    $(document).ajaxComplete(function(event, request, settings) {
      $('#loading-indicator').hide();
    });
    
</script>   