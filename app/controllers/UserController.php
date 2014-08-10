<?php
/**
 * Models from schema: AldosEngine version 0.1
 * Code generated by TransformTask
 *
 */

use Altenia\Ecofy\Controller\GenericServiceController;

/**
 * Controller class that provides REST API to User resource
 */
class UserController extends GenericServiceController {

	public function __construct() {
		parent::__construct('layouts.workspace', 'svc:user', 'User');
		$this->indexRetrievalMethod = 'paginate';
	}

	public function editAuxData($record) {
		$auxdata = array();

		return $auxdata;
	}

	private function getRoleService()
	{
		return App::make('svc:role');
	}
	
}