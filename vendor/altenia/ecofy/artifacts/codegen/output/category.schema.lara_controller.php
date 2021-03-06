<?php
/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */


/**
 * Controller class that provides web access to Category resource
 *
 * @todo: Add following line in app/routes.php
 * Route::resource('category', 'CategoryController');
 */
class CategoryController extends \BaseController {

    // The service object
	protected $categoryService;

	protected $layout = 'layouts.master';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->addBreadcrumb([ Lang::get('document._name')]);
		$this->setContentTitle(Lang::get('document._name_plural'));
        //$this->categoryService = new Service\CategoryService();
        $this->categoryService = App::make('category_service');
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

		$records = $this->categoryService->paginateCategories($criteria, $queryCtx->limit);
		$count = $this->categoryService->countCategories($qparams);

        // $qparams is used by view to generate query string
		$qparams[self::PAGE_SIZE_PNAME] = $page_size;
		$this->layout->content = View::make('category.index')
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
		$this->setContentTitle('New ' . Lang::get('category._name') );

		$this->layout->content = View::make('category.create');
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
            $record = $this->categoryService->createCategory($data);
            Session::flash('message', 'Successfully created!');

            return $this->redirectAfterPost(
            	array('save' => route('categories.edit', array($record->sid))),
            	route('categories.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('categories/create')
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
		$record = $this->categoryService->findCategory($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('category._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('category.show')
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
	    $record = $this->categoryService->findCategory($id);

		$this->addBreadcrumb([$record->getName(), Request::url()]);
		$this->setContentTitle(Lang::get('category._name') . ' - ' .  $record->getName());

		$this->layout->content = View::make('category.edit')
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
            $record = $this->categoryService->updateCategory($id, $data);

            // @todo: Redirect to proper URL
            Session::flash('message', 'Successfully updated!');
            
            return $this->redirectAfterPost(
            	array('save' => route('categories.edit', array($record->sid))),
            	route('categories.index')
            	);
        } catch (Services\ValidationException $ve) {
            return Redirect::to('categories/' . $id . '/edit')
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
		$success = $this->categoryService->destroyCategory($id);

		if ($success) {
            Session::flash('message', 'Successfully deleted!');
            return Redirect::to('categories');
        } else {
            Session::flash('message', 'Entry not found');
            return Redirect::to('categories');
        }
	}
}
