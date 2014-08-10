<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides web access to Role resource
 *
 * @todo: Add following line in app/routes.php
 * Route::resource('role', 'RoleController');
 */
class RoleController extends \BaseController {

    // The service object
	protected $roleService;

	protected $layout = 'layouts.master';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->addBreadcrumb([ Lang::get('document._name')]);
		$this->setContentTitle(Lang::get('document._name_plural'));
        //$this->roleService = new Service\RoleService();
        $this->roleService = App::make('role_service');
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

		$records = $this->roleService->paginateRoles($criteria, $queryCtx->limit);
		$count = $this->roleService->countRoles($qparams);

        // $qparams is used by view to generate query string
		$qparams[self::PAGE_SIZE_PNAME] = $page_size;
		$this->layout->content = View::make('role.index')
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
		$this->setContentTitle('New ' . Lang::get('role._name') );

		$this->layout->content = View::make('role.create');
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
            $record = $this->roleService->createRole($data);
            Session::flash('message', 'Successfully created!');

            return $this->redirectAfterPost(
            	array('save' => route('roles.edit', array($record->sid))),
            	route('roles.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('roles/create')
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
		$record = $this->roleService->findRole($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('role._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('role.show')
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
	    $record = $this->roleService->findRole($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('role._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('role.edit')
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
            $record = $this->roleService->updateRole($id, $data);

            // @todo: Redirect to proper URL
            Session::flash('message', 'Successfully updated!');
            
            return $this->redirectAfterPost(
            	array('save' => route('roles.edit', array($record->sid))),
            	route('roles.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('roles/' . $id . '/edit')
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
		$success = $this->roleService->destroyRole($id);

		if ($success) {
            Session::flash('message', 'Successfully deleted!');
            return Redirect::to('roles');
        } else {
            Session::flash('message', 'Entry not found');
            return Redirect::to('roles');
        }
	}
}