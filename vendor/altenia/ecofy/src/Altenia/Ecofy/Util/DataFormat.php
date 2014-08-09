<?php namespace Altenia\Ecofy\Util;

/**
 * Helper class that provides HTML rendering functionalites.
 */
class DataFormat {

	public static $defaultDateFormat = "M d Y";

	/**
	 * Formats date
	 */
	public static function date($date)
	{
		$formatted = '';
		if (is_string($date)) {
			$formatted = date(self::$defaultDateFormat, strtotime($date));
		}
		return $formatted;
	}

	public static function currency($amount)
	{
		$formatted = money_format('%(#10n', $amount);
		return $formatted;
	}
}