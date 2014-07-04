<?php namespace DocuFlow\Helper;

/**
 * Helper class that provides HTML rendering functionalites.
 */
class DfHtml {

	/**
	 * Generates links to download files
	 */
	public static function downloadLinks($fileInfos)
	{
		$html = '';
		if (!empty($fileInfos)) {
			foreach ($fileInfos as $fileInfo) {
				$html .= '<a href="/' . $fileInfo['uri'] . '" title="' . $fileInfo['name'] . '" > <span class="glyphicon glyphicon-file"></span></a>'; 
			}
		}
		return $html;
	}
}