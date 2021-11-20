<?php

class YcdDataAccess
{
	public static function getAllDataAcess()
	{
		$access = array(
			'comingSoonSchedule' => array('hideLevels' => array(YCD_SILVER_VERSION))
		);

		return apply_filters('ycdDataAccessObjects', $access);
	}

	public static function isHidden($key)
	{
		$accessObjects = self::getAllDataAcess();

		if (!empty($accessObjects[$key])) {
			return !in_array(YCD_PKG_VERSION, $accessObjects[$key]['hideLevels']);
		}

		return true;
	}
}