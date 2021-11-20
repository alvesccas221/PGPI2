<?php

namespace ycd;

use \SxGeo;

class HelperFunction
{

	public static function createAttrs($attrs)
	{
		$attrString = '';
		if(!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		return $attrString;
	}

	public static function getIpAddress()
	{
		if (getenv('HTTP_CLIENT_IP'))
			$ipAddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipAddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipAddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipAddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipAddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipAddress = getenv('REMOTE_ADDR');
		else
			$ipAddress = 'UNKNOWN';
		
		return $ipAddress;
	}

	public static function getCountryName($ip)
	{
		require_once(YCD_LIB_PATH.'SxGeo/SxGeo.php');

		$SxGeo = new SxGeo(YCD_LIB_PATH.'SxGeo/SxGeo.dat');
		$country = $SxGeo->getCountry($ip);

		return $country;
	}

	public static function createSelectBox($data, $selectedValue, $attrs)
	{
		$selected = '';
		$attrString = self::createAttrs($attrs);

		$selectBox = '<select '.$attrString.'>';

		foreach($data as $value => $label) {

			/*When is multiselect*/
			if(is_array($selectedValue)) {
				$isSelected = in_array($value, $selectedValue);
				if($isSelected) {
					$selected = 'selected';
				}
			}
			else if($selectedValue == $value) {
				$selected = 'selected';
			}
			else if(is_array($value) && in_array($selectedValue, $value)) {
				$selected = 'selected';
			}

			$selectBox .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
			$selected = '';
		}

		$selectBox .= '</select>';

		return $selectBox;
	}
}