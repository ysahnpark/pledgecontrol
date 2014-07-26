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
			'account' => Lang::get('account._name'),
			'transaction' => Lang::get('transaction._name'),
			'issue' => Lang::get('issue._name')
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

		$errors = array();
		$linenum = 0;
		if ($type === 'account') {
			foreach ($records as $record) {
				$linenum++;
				$validator = \Account::validator($record);
		        if (!$validator->passes()) {
		        	$errors[] = array('line' => $linenum, 'message' => $validator->messages()->toArray());
				} else {
					if ($mode == 'process') {
						$this->getAccountService()->createAccount();
					}
				}
			}
		}

		$this->layout->content = View::make('import.form')
			->with('mode', $mode)
			->with('data', $data)
			->with('data', $data)
			->with('records', $records)
			->with('isvalid', empty($errors))
			->with('dataerrors', $errors)
			->with('auxdata', $this->auxdata());
	}

}