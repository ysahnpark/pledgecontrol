<?php
/**
 * Models from schema: AldosEngine version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides REST API to User resource
 */
class TransactionController extends \GenericServiceController {

	public function __construct() {
		parent::__construct('layouts.workspace', 'svc:transaction', 'Transaction');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();

		try {
			$createMethod = 'create' . $this->modelName;
            $record = $this->service->$createMethod($data);
            Session::flash('message', 'Successfully created!');
            
            return $this->redirectAfterPost(
            	array('save' => route($this->moduleNamePlural . '.edit', array($record->ID))),
            	route($this->moduleNamePlural . '.index')
            	);
        } catch (Service\ValidationException $ve) {
            return Redirect::to( route($this->moduleNamePlural . '.index'))
                ->withErrors($ve->getObject());
        }
	}

	/**
	 * Method to return values that 
	 * Overridable 
	 */
	public function indexAuxData() {
		$auxdata = array();
		$auxdata['opt_Method'] = array(
			'cash' => 'Cash', 
			'check' => 'Check', 
			'creditcard' => 'Credit Card', 
			'transfer' => 'Transfer', 
			'other' => 'Other'
			);
		$auxdata['PaymentDate'] = (new \DateTime)->format('Y-m-d');;
		return $auxdata;
	}

	public function editAuxData($record) {
		$auxdata = array();

		return $auxdata;
	}

	public function report() {

		$this->addBreadcrumb(['report']);
		$this->setContentTitle(Lang::get($this->moduleName . '._name') . ' - Report' );


		$queryCtx = new \DocuFlow\Helper\DfQueryContext(true);
		$criteria = $queryCtx->buildCriteria();

		$records = $this->service->report($criteria);

		// More reports;
		$report_data = array();
		$report_data['regist_family'] = 200;
		$report_data['participating_family'] = 170;

		// Collection status
		$report_data['pledge_total'] = 200;
		$report_data['pledge_accumulated'] = 200;
		$report_data['pledge_expected'] = 200;

		// Plege Trend
		// Query count(), group by (date), 
		
		// Distribution of Delinquent donors
		// Query count(), group by (??) WHERE amountDue > 0

		// Reminder Letter 



		if ($queryCtx->format === null || $queryCtx->format === 'html') {
			// Default retun: 
			$this->layout->content = View::make($this->moduleName . '.report')
				->with('queryCtx', $queryCtx)
				->with('auxdata', $this->indexAuxData())
			    ->with('records', $records);
		} else {
			return $this->indexOfFormat($queryCtx->format, $records);
		}
	}

}