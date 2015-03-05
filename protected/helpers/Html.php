<?php

class Html extends CHtml
{
	/**
	 *	return URL to current theme
	 */
	public static function themeUrl()
	{
		return Yii::app()->theme->baseUrl;
	}

	/**
	 *	return relative URL on the server
	 */
	public static function baseUrl()
	{
		return Yii::app()->request->baseUrl;
	}	

	/**
	 *	generate URL based on route
	 */
	public static function url( $route, $params = array() )
	{
		if( !is_array($route) )
		{
			return Yii::app()->createUrl($route, $params);
		}
		else
		{
			return self::normalizeUrl( array_merge($route, $params) );
		}
	}
	
	/**
	 * print activeDateField with custom html options to init datepicker
	 * assume that jquery ui is loaded on the page
	 * @param CModel $model
	 * @param string $attribute
	 * @param array $htmlOptions
	 */
	public static function activeDatePickerField( $model, $attribute, $htmlOptions = array() )
	{
		$formatted_date = "";
		if( !empty($model->$attribute) )
		{
			$timestamp = Yii::app()->format->format($model->$attribute, 'timestamp');
			$formatted_date = Yii::app()->format->format($timestamp, 'date');
		}
		
		$datepicker_options = CJSON::encode( array(
			'dateFormat' => strtr(Yii::app()->format->dateFormat, array('d' => 'dd', 'm' => 'mm', 'Y' => 'yy', 'y' => 'yy')),
			'changeMonth' => true,
			'changeYear' => true,
		));
		
		$unique_id = self::ID_PREFIX.self::$count++;
		$htmlOptions['id'] = $unique_id;
		$htmlOptions['value'] = $formatted_date;

		// register script
		Yii::app()->clientScript->registerScript($unique_id, "$('#$unique_id').datepicker({$datepicker_options})");
		// print input
		return Html::activeTextField($model, $attribute, $htmlOptions);
	}
	
	public static function activeAutocompleteCombo($model, $attribute, $data, $options = array())
	{
		$id = self::ID_PREFIX.self::$count++;
		
		$options = array_merge(array(
			'defaultValue' => '',
			'empty' => 'Select from list or type',
			'onSelect' => null,
			'comboParams' => null,
		), $options);
		
		$select_name = Html::resolveName($model, $attribute);
		if( $options['bulkMode'] )
		{
			$select_name = preg_replace('/([^\[]+)(.*)/', "$1[$model->id]$2", $select_name);
		}
		
		// check value and update $data if defaultValue missing in array
		$value = $model->$attribute? $model->$attribute : $options['defaultValue'];
		if( !isset($data[$value]) )
		{
			$data[$value] = $value;
		}
		
		$html = Html::openTag('div', array('id' => $id, 'class' => 'autocomplete-combo-wrapper'));
		$select_options = array(
			'id' => $id . '_select',
			'name' => $select_name,
			'empty' => $options['empty'],
			'class' => 'autocomplete-combo-select',
		);
		$list_options = self::listOptions($value, $data, $select_options);
		$html .= Html::tag('select', $select_options, $list_options);
		$html .= Html::closeTag('div');
	
		$js_options = array(
			'value' => $value,
			'onSelect' => $options['onSelect'],
			'params' => $options['comboParams'],
 		);
		
		$javascript = "$('#$id select').combobox(".CJavaScript::encode($js_options).");";
		Yii::app()->clientScript->registerScript($id, $javascript);
		
		return $html;
	}
}
