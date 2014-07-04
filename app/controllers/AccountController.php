<?php
/**
 * Models from schema: AldosEngine version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides REST API to User resource
 */
class AccountController extends \GenericServiceController {

	public function __construct() {
		parent::__construct('layouts.workspace', 'svc:account', 'Account');
	}

	public function createAuxData() {
		$auxdata = array();

		$auxdata['opt_PaymentPeriod'] = array('monthly', 'bi-monthly');

		return $auxdata;
	}

	public function editAuxData() {

		return $this->createAuxData();
	}

}