<?php

class ImportController extends BaseController {

	protected $layout = 'layouts.workspace';

	protected $typeToModel = null;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->addBreadcrumb(['import']);
		$this->setContentTitle('Import' );

		$this->typeToModel = array(
				'accounts' => 'Account',
				'transactions' => 'Transaction',
				'tickets' => 'Ticket',
				'accounts_plus' => 'Account'
			);
    }


	private function getAccountService()
	{
		return App::make('svc:account');
	}

	private function getTransactionService()
	{
		return App::make('svc:transaction');
	}

	private function getService($serviceName)
	{
		return App::make('svc:' . $serviceName);
	}

	public function auxdata()
	{
		$auxdata['opt_Type'] = array(
			'accounts' => Lang::get('account._name'),
			'transactions' => Lang::get('transaction._name'),
			'tickets' => Lang::get('ticket._name'),
			'accounts_plus' => 'Accounts with Trans and Ticket'
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

		$rows = DocuFlow\Helper\CsvUtil::toAssociativeArray($data);


		$result = $this->processRecords($type, $mode, $rows);

		$this->layout->content = View::make('import.form')
			->with('mode', $mode)
			->with('type', $type)
			->with('data', $data)
			->with('rows', $rows)
			->with('isvalid', empty($result['errors']))
			->with('result', $result)
			->with('auxdata', $this->auxdata());
	}


	private function processRecords($type, $mode, &$rows) {
		$result = array(
			'errors' => array(),
			'items_count' => 0,
			'items_processed' => 0,
			'items_skipped' => 0
			);
		$errors = array();
		$modelName = $this->typeToModel[$type];
		$modelFqn = '\\' . $modelName;
		$serviceGetterMethod = 'get' . $modelName . 'Service';
		$service = $this->$serviceGetterMethod();
		$createMethod = 'create' . $modelName;

		$linenum = 0;
		foreach ($rows as &$row) {
			$linenum++;
			
			$this->beforeRecordInsert($type, $row, $errors);
			$validator = $modelFqn::validator($row);

	        if (!$validator->passes()) {
	        	$errors[] = array('line' => $linenum, 'message' => $validator->messages()->toArray());
			} else {
				if ($mode == 'process') {
					try {
						$record = $service->$createMethod($row);
						$this->afterRecordInsert($record, $type, $row, $errors);
						$result['items_processed']++;
					} catch (Exception $ex) {
						$errors[] = array('line' => $linenum, 'message' => $ex->getMessage());
					}
				}
			}
		}
		$result['errors'] = $errors;
		$result['items_count'] = count($rows);

		return $result;
	}

	/**
	 * Called before the main record is inserted.
	 * Sample use: populate referencing data prior insertion
	 */
	private function beforeRecordInsert($type, &$row)
	{
		if ($type === 'transactions') {
			if (!array_key_exists('AccountID', $row) && array_key_exists('Name', $row)) {
				$account = $this->getAccountService()->findAccountByName($row['Name']);
				if (!empty($account)) {
					$row['AccountID'] = $account->ID;
					$row['Name'] = $account->Name;
				}
			}
		}  else if ($type === 'accounts_plus') {
			if (strlen($row['PaymentPeriod']) > 1){
				$row['PeriodUnit'] = substr($row['PaymentPeriod'], -1);
				$row['PaymentPeriod'] = substr($row['PaymentPeriod'], 0, -1);
			} else {
				$row['PeriodUnit'] = '';
				$row['PaymentPeriod'] = 'm';
			}
			// Convert years to months
			if (ends_with($row['Duration'], 'y')) {
				$row['Duration'] = substr($row['Duration'], 0, -1) * 12;
			}
			
		}
	}

	/**
	 * Called after the main record was inserted.
	 * Sample use: Create a new related records which has FK reference to the newely inserted record
	 */
	private function afterRecordInsert($record, $type, &$row)
	{
		if ($type === 'accounts_plus') {
			// $record is an account record

			// Create a transaction with the accumulated amount
			if (isset($row['AccumulatedAmout']) && $row['AccumulatedAmout'] > 0) 
			{
				$trans = array('AccountID' => $record->ID, 'Name' => $record->Name,
					'PaymentDate' => $row['LastTransactionDate'],
					'Amount' => $row['AccumulatedAmout'],
					);
				$this->getTransactionService()->createTransaction($trans);
			}

			// Create a ticket if data was provided 
			if (isset($row['TicketCategory']) && !empty($row['TicketCategory']))
			{
				$ticket = array('AccountID' => $record->ID,
					'TicketDate' => $row['TicketDate'],
					'Category' => $row['TicketCategory']
					);
				$this->getService('ticket')->createTicket($ticket);
			}
		}
	}

}