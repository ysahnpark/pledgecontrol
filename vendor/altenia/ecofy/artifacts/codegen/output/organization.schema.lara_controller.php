<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides web access to Organization resource
 *
 * @todo: Add following line in app/routes.php
 * Route::resource('organization', 'OrganizationController');
 */
class OrganizationController extends \BaseController {

    // The service object
	protected $organizationService;

	protected $layout = 'layouts.master';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->addBreadcrumb([ Lang::get('document._name')]);
		$this->setContentTitle(Lang::get('document._name_plural'));
        //$this->organizationService = new Service\OrganizationService();
        $this->organizationService = App::make('organization_service');
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

		$records = $this->organizationService->paginateOrganizations($criteria, $queryCtx->limit);
		$count = $this->organizationService->countOrganizations($qparams);

        // $qparams is used by view to generate query string
		$qparams[self::PAGE_SIZE_PNAME] = $page_size;
		$this->layout->content = View::make('organization.index')
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
		$this->setContentTitle('New ' . Lang::get('organization._name') );

		$this->layout->content = View::make('organization.create');
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
            $record = $this->organizationService->createOrganization($data);
            Session::flash('message', 'Successfully created!');

            return $this->redirectAfterPost(
            	array('save' => route('organizations.edit', array($record->sid))),
            	route('organizations.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('organizations/create')
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
		$record = $this->organizationService->findOrganization($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('organization._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('organization.show')
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
	    $record = $this->organizationService->findOrganization($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('organization._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('organization.edit')
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
            $record = $this->organizationService->updateOrganization($id, $data);

            // @todo: Redirect to proper URL
            Session::flash('message', 'Successfully updated!');
            
            return $this->redirectAfterPost(
            	array('save' => route('organizations.edit', array($record->sid))),
            	route('organizations.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('organizations/' . $id . '/edit')
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
		$success = $this->organizationService->destroyOrganization($id);

		if ($success) {
            Session::flash('message', 'Successfully deleted!');
            return Redirect::to('organizations');
        } else {
            Session::flash('message', 'Entry not found');
            return Redirect::to('organizations');
        }
	}
}