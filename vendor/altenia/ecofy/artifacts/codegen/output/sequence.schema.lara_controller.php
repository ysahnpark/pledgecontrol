<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides web access to SequenceNumber resource
 *
 * @todo: Add following line in app/routes.php
 * Route::resource('sequence_number', 'SequenceNumberController');
 */
class SequenceNumberController extends \BaseController {

    // The service object
	protected $sequenceNumberService;

	protected $layout = 'layouts.master';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->addBreadcrumb([ Lang::get('document._name')]);
		$this->setContentTitle(Lang::get('document._name_plural'));
        //$this->sequenceNumberService = new Service\SequenceNumberService();
        $this->sequenceNumberService = App::make('sequence_number_service');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$queryCtx = new \DocuFlow\Helper\DfQueryContext(true);
		$criteria = $queryCtx->buildCriteria();

		$records = $this->sequenceNumberService->paginateSequenceNumbers($criteria, $queryCtx->limit);
		$count = $this->sequenceNumberService->countSequenceNumbers($qparams);

        // $qparams is used by view to generate query string
		$qparams[self::PAGE_SIZE_PNAME] = $page_size;
		$this->layout->content = View::make('sequence_number.index')
		    ->with('qparams', $queryCtx->qparams)
		    ->with('records', $records)
		    ->with('count', $count);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->addBreadcrumb(['new']);
		$this->setContentTitle('New ' . Lang::get('sequence_number._name') );

		$this->layout->content = View::make('sequence_number.create');
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
            $record = $this->sequenceNumberService->createSequenceNumber($data);
            Session::flash('message', 'Successfully created!');

            return $this->redirectAfterPost(
            	array('save' => route('sequence_numbers.edit', array($record->sid))),
            	route('sequence_numbers.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('sequence_numbers/create')
                ->withErrors($ve->getObject());
                //->withInput(Input::except('password'));
        } 
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record = $this->sequenceNumberService->findSequenceNumber($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('sequence_number._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('sequence_number.show')
			->with('record', $record);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	    $record = $this->sequenceNumberService->findSequenceNumber($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('sequence_number._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('sequence_number.edit')
		    ->with('record', $record);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$data = Input::all();

        try {
            $record = $this->sequenceNumberService->updateSequenceNumber($id, $data);

            // @todo: Redirect to proper URL
            Session::flash('message', 'Successfully updated!');
            
            return $this->redirectAfterPost(
            	array('save' => route('sequence_numbers.edit', array($record->sid))),
            	route('sequence_numbers.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('sequence_numbers/' . $id . '/edit')
                ->withErrors($ve->getObject());
                //->withInput(Input::except('password'));
        } 
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$success = $this->sequenceNumberService->destroySequenceNumber($id);

		if ($success) {
            Session::flash('message', 'Successfully deleted!');
            return Redirect::to('sequence_numbers');
        } else {
            Session::flash('message', 'Entry not found');
            return Redirect::to('sequence_numbers');
        }
	}
}
