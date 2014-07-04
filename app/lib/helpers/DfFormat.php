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
			$formatted = date("M d Y", strtotime($date));
		}
		return $formatted;
	}
}