<?php

class ImportController extends BaseController {

	protected $layout = 'layouts.workspace';
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->addBreadcrumb(['import']);
		$this->setContentTitle('Import' );
    }


	private function getAccountService()
	{
		return App::make('svc:account');
	}

	private function getTransactionService()
	{
		return App::make('svc:transaction');
	}

	public function auxdata()
	{
		$auxdata['opt_Type'] = array(
			'Account' => Lang::get('account._name'),
			'Transaction' => Lang::get('transaction._name'),
			'Ticket' => Lang::get('ticket._name')
			);
		return $auxdata;
	}
	
	public function getForm() {
		$type = \Input::get('Type');
		$data = \Input::get('Data');
		$this->layout->content = View::make('import.form')
			->with('type', $type)
			->with('data', $data)
			->with('auxdata', $this->auxdata());
	}

	public function postForm() {
		$type = \Input::get('Type');
		$data = \Input::get('Data');
		$mode = \Input::get('mode');

		$records = DocuFlow\Helper\CsvUtil::toAssociativeArray($data);

		$result = $this->processRecords($type, $mode, $records);

		$this->layout->content = View::make('import.form')
			->with('mode', $mode)
			->with('type', $type)
			->with('data', $data)
			->with('records', $records)
			->with('isvalid', empty($result['errors']))
			->with('result', $result)
			->with('auxdata', $this->auxdata());
	}

	private function processRecords($type, $mode, &$records) {
		$result = array(
			'errors' => array(),
			'items_count' => 0,
			'items_processed' => 0,
			'items_skipped' => 0
			);
		$errors = array();
		$modelName = '\\' . $type;
		$serviceGetterMethod = 'get' . $type . 'Service';
		$service = $this->$serviceGetterMethod();
		$createMethod = 'create' . $type;

		$linenum = 0;
		foreach ($records as &$record) {
			$linenum++;
			
			//try {
				$this->preProcess($type, $record, $errors);
			//} catch ( $ex) {
			//	$errors[] = array('line' => $linenum, 'message' => $ex->getMessage());
			//}
			$validator = $modelName::validator($record);

	        if (!$validator->passes()) {
	        	$errors[] = array('line' => $linenum, 'message' => $validator->messages()->toArray());
			} else {
				if ($mode == 'process') {
					$service->$createMethod($record);
					$result['items_processed']++;
				}
			}
		}
		$result['errors'] = $errors;
		$result['items_count'] = count($records);

		return $result;
	}

	private function preProcess($type, &$record)
	{
		if ($type === 'Transaction') {
			if (!array_key_exists('AccountID', $record) && array_key_exists('Name', $record)) {
				$account = $this->getAccountService()->findAccountByName($record['Name']);
				if (!empty($account)) {
					$record['AccountID'] = $account->ID;
				}
			}
		}
	}

}