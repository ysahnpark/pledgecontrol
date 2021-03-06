<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides web access to User resource
 *
 * @todo: Add following line in app/routes.php
 * Route::resource('user', 'UserController');
 */
class UserController extends \BaseController {

    // The service object
	protected $userService;

	protected $layout = 'layouts.master';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->addBreadcrumb([ Lang::get('document._name')]);
		$this->setContentTitle(Lang::get('document._name_plural'));
        //$this->userService = new Service\UserService();
        $this->userService = App::make('user_service');
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

		$records = $this->userService->paginateUsers($criteria, $queryCtx->limit);
		$count = $this->userService->countUsers($qparams);

        // $qparams is used by view to generate query string
		$qparams[self::PAGE_SIZE_PNAME] = $page_size;
		$this->layout->content = View::make('user.index')
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
		$this->setContentTitle('New ' . Lang::get('user._name') );

		$this->layout->content = View::make('user.create');
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
            $record = $this->userService->createUser($data);
            Session::flash('message', 'Successfully created!');

            return $this->redirectAfterPost(
            	array('save' => route('users.edit', array($record->sid))),
            	route('users.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('users/create')
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
		$record = $this->userService->findUser($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('user._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('user.show')
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
	    $record = $this->userService->findUser($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('user._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('user.edit')
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
            $record = $this->userService->updateUser($id, $data);

            // @todo: Redirect to proper URL
            Session::flash('message', 'Successfully updated!');
            
            return $this->redirectAfterPost(
            	array('save' => route('users.edit', array($record->sid))),
            	route('users.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('users/' . $id . '/edit')
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
		$success = $this->userService->destroyUser($id);

		if ($success) {
            Session::flash('message', 'Successfully deleted!');
            return Redirect::to('users');
        } else {
            Session::flash('message', 'Entry not found');
            return Redirect::to('users');
        }
	}
}
