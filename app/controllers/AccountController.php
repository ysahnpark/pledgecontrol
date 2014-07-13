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

	public function createAuxData($record) {
		$auxdata = array();

		$auxdata['opt_PaymentPeriod'] = array('monthly', 'bi-monthly');

		return $auxdata;
	}

	public function showAuxData($record) {
		$auxdata = array();

		return $auxdata;
	}

	public function editAuxData($record) {

		return $this->createAuxData($record);
	}

	public function indexOfFormat($format, $records) {

		if ($format === 'csv') {
			$csv_output = '';
		    foreach ($records as $row) {
		        $csv_output .= implode(',', $row->toArray()) . "\n";
		    }
		    $csv_output = rtrim($csv_output, "\n");
		    //$output =  mb_convert_encoding($csv_output, 'UCS-2LE', 'UTF-8');
		    $output =  $csv_output;

		    $headers = array(
		        'Content-Type' => 'text/csv',
		        'charset' => 'utf-8',
		        'Content-Disposition' => 'attachment; filename="account.csv"',
		    );
		 
		    return Response::make($output, 200, $headers);
		} else if ($format === 'xls') {
			/** Include PHPExcel */
			//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("PC")
										 ->setTitle("Pledge Control Account")
										 ->setSubject("Account Report")
										 ->setDescription("Account Report")
										 ->setCategory("Report");

			$row = 2;
			foreach ($records as $record) {
				$col = 0;
				foreach ($record->toArray() as $fieldName => $fieldVal) {
					if ($row ==2) {
						// first row, output header
						$objPHPExcel->setActiveSheetIndex(0)
			            	->setCellValueByColumnAndRow($col, 1, $fieldName);
					}
			        $objPHPExcel->setActiveSheetIndex(0)
			            ->setCellValueByColumnAndRow($col, $row, $fieldVal);
			        $col++;
		        }
		        $row++;
		    }

			// Rename worksheet
			$objPHPExcel->getActiveSheet()->setTitle('계정');


			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);


			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
			header('Content-Disposition: attachment;filename="01simple.xlsx"');
			header('Cache-Control: max-age=0');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit;
		}
	}

	public function report() {
		$queryCtx = new \DocuFlow\Helper\DfQueryContext(true);
		$criteria = $queryCtx->buildCriteria();

		$records = $this->service->listAccounts2($criteria, array(), /*$queryCtx->limit*/ 5);

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