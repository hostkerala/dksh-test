<?php

class Formatter extends CFormatter
{
	public function formatTimestamp( $input )
	{
		if( empty($input) ) return $input;
		if( is_numeric($input) ) return $input;
		$input = preg_replace('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})(.*)/', '$3-$2-$1$4', $input);
		$timestamp = strtotime($input);
		return $timestamp;
	}
	
	public function formatDatetimeSQL( $input )
	{
		$timestamp = $this->formatTimestamp($input);
		return date('Y-m-d H:i:s', $timestamp);
	}	
}