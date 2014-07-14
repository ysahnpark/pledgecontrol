<?php namespace DocuFlow\Helper;

/**
 * Helper class that provides HTML rendering functionalites.
 */
class DfFormat {

	/**
	 * Generates links to download files
	 */
	public static function date($date)
	{
		$formatted = '';
		if (is_string($date)) {
			$formatted = date("Y/m/d ", strtotime($date));
		}
		return $formatted;
	}

	public static function currency($amount)
	{
		$formatted = money_format('%(#10n', $amount);
		return $formatted;
	}
}