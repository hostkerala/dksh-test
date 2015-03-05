<?php

class ClientActiveForm extends CActiveForm
{
	public $isAjax = false;
	public $ajaxTarget = '#content';
	public $bulkMode = false;
	public $fieldNamesPrefix = '';
	public $ajaxInlineForm = false;
	
	public function init()
	{
		if( $this->isAjax )
		{
			$this->htmlOptions['onsubmit'] = 'js:ajax_form_submit(this);return false;';
			$this->htmlOptions['data-target'] = $this->ajaxTarget;
		}

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->id;
		else
			$this->id=$this->htmlOptions['id'];

		if( $this->ajaxInlineForm )
			echo CHtml::openTag( 'div' );
		elseif($this->stateful)
			echo CHtml::statefulForm($this->action, $this->method, $this->htmlOptions);
		else
			echo CHtml::beginForm($this->action, $this->method, $this->htmlOptions);
			
		if($this->errorMessageCssClass===null)
			$this->errorMessageCssClass=CHtml::$errorMessageCss;
	}
	
	public function run()
	{
		if( $this->ajaxInlineForm )
			echo CHtml::closeTag( 'div');
		else
			parent::run();
	}
	
	public function textField( $model, $attribute, $htmlOptions = array() )
	{
		$this->preprocessTextFieldHtmlOptions($htmlOptions, $model, $attribute);
		return parent::textField($model, $attribute, $htmlOptions);
	}
	
	public function emailField( $model, $attribute, $htmlOptions = array() )
	{
		$this->preprocessTextFieldHtmlOptions($htmlOptions, $model, $attribute);
		return parent::textField($model, $attribute, $htmlOptions);
	}

	public function numberField( $model, $attribute, $htmlOptions = array() )
	{
		$this->preprocessTextFieldHtmlOptions($htmlOptions, $model, $attribute);
		return parent::numberField($model, $attribute, $htmlOptions);
	}
	
	public function passwordField( $model, $attribute, $htmlOptions = array() )
	{
		$this->preprocessTextFieldHtmlOptions($htmlOptions, $model, $attribute);
		return parent::passwordField($model, $attribute, $htmlOptions);
	}
	
	public function dropDownList( $model, $attribute, $data, $htmlOptions = array() )
	{
		$this->preprocessTextFieldHtmlOptions($htmlOptions, $model, $attribute);
		return parent::dropDownList($model, $attribute, $data, $htmlOptions);
	}
	
	public function datePickerField( $model, $attribute, $htmlOptions = array() )
	{
		$this->preprocessTextFieldHtmlOptions($htmlOptions, $model, $attribute);
		return Html::activeDatePickerField($model, $attribute, $htmlOptions);
	}
        
        
        public function fileField( $model, $attribute, $htmlOptions = array() )
	{
		return Html::activeFileField($model, $attribute, $htmlOptions);
	}

	protected function preprocessTextFieldHtmlOptions( &$htmlOptions, $model, $attribute )
	{
		if( empty($htmlOptions['class']) )
		{
			$htmlOptions['class'] = 'form-control';
		}
		
		if( !isset($htmlOptions['name']) )
		{
			$htmlOptions['name'] = CHtml::resolveName($model, $attribute);
		}
		
		// for bulk mode we have name like ModelName[ID][attribute]
		if( !empty($this->bulkMode) )
		{
			$htmlOptions['name'] = preg_replace('/([^\[]+)(.*)/', "$1[$model->id]$2", $htmlOptions['name']);
		}
		
		if( !empty($this->fieldNamesPrefix) )
		{
			$htmlOptions['name'] = str_replace('[', '][', $htmlOptions['name']);
			$htmlOptions['name'] = $this->fieldNamesPrefix . '[' . trim($htmlOptions['name'], ']') . ']';
		}
	}
}