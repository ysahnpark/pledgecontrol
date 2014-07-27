<?php

class ReportController extends BaseController {

	protected $layout = 'layouts.workspace';
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->addBreadcrumb(['report']);
		$this->setContentTitle('Report' );
    }


	private function getAccountService()
	{
		return App::make('svc:account');
	}

	private function getTransactionService()
	{
		return App::make('svc:transaction');
	}

	private function getTicketService()
	{
		return App::make('svc:ticket');
	}
	
	public function getGeneral() {
		$this->setContentTitle( 'Summary' );

		$queryCtx = new \DocuFlow\Helper\DfQueryContext(true);
		$criteria = $queryCtx->buildCriteria();

		$records = $this->getTransactionService()->report($criteria);

		// More reports;
		$report_data = array();
		$report_data['transactions_monthly'] = $records;

		// Demographics
		$demographics = array();
		// @todo - PARAMETERIZE DATA
		$demographics['registered'] = 200;
		$demographics['goal'] = 175;
		$demographics['participating'] = $this->getAccountService()->countAccounts(array('PledgeAmount' => array('$gt' => 0)));

		$report_data['demographics'] = $demographics;

		// Collection status
		$report_data['totals'] = $this->getAccountService()->totals();

		// Plege Trend
		$report_data['signup_trend'] = $this->getAccountService()->signupTrend();
		
		// Distribution of Delinquent donors
		$amountDueSql = '(CEIL(TIMESTAMPDIFF({INTER_UNIT}, PledgeStartDate, NOW())  / PaymentPeriod) * AmountPerPeriod) - PaidAmount';
		$criteria = array( $amountDueSql => array('$gt' => 1));
		$accountsOverDue = $this->getAccountService()->listAccounts2($criteria);
		$histogram = $this->histogram($accountsOverDue, 'PledgeAmount');
		$report_data['overdue_histogram'] = $histogram;

		// Tickets
		$ticketCategories = $this->getTicketService()->reportOnCategory(null);
		$report_data['ticket_bycategory'] = $ticketCategories;

		if ($queryCtx->format === null || $queryCtx->format === 'html') {
			// Default retun: 
			$this->layout->content = View::make('report.general')
				->with('queryCtx', $queryCtx)
			    ->with('report_data', $report_data);
		} else {
			return $this->indexOfFormat($queryCtx->format, $report_data);
		}
	}

	public function histogram($list, $pivotField)
	{
		$histogram = array();
		foreach($list as $record)
		{
			if (array_key_exists($record->$pivotField, $histogram)) {
				$histogram[$record->$pivotField] += 1;
			} else {
				$histogram[$record->$pivotField] = 1;
			}
		}
		krsort($histogram);
		return $histogram;
	}

}
