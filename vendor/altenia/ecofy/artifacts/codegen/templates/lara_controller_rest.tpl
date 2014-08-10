<%namespace name="common" file="/codegen_common.tpl"/><%
    import re

    def get_plural(name, capitalize = False):
        retval = name
        if (name[len(name)-1] != 's'):
            if (name[len(name)-1] == 'y'):
                name = name[:len(name)-1] + 'ie'
            retval = name + 's'
        if (capitalize):
            retval = retval.capitalize();
        return retval

    # Convert underscore to camelCase
    under_pat = re.compile(r'_([a-z])')
    def to_camelcase(text, capitalize=False, pluralize=False):
        retval = text
        if (pluralize):
            retval = get_plural(retval, capitalize)
        elif (capitalize):
            retval = retval.capitalize()
        return under_pat.sub(lambda x: x.group(1).upper(), retval)

    # Generate service method invocation code
    def service_call(name, method, pluralize=True):
        return '$this->' + to_camelcase(entity_name) + 'Service->' + method + to_camelcase(entity_name, True, pluralize);

%><?php
/**
 * Models from schema: ${ model['schema-name'] } version ${ model['version'] }
 * Code generated by ${params['TASK_TYPE_NAME']}
 *
 */


% for entity_name, entity_def in model['entities'].iteritems():
/**
 * Controller class that provides REST API to ${common.to_camelcase(entity_name, True)} resource
 *
 * @todo: Add following line in app/routes.php
 * Route::resource('${entity_name}', '${common.to_camelcase(entity_name, True)}ApiController');
 */
class ${common.to_camelcase(entity_name, True)}ApiController extends \BaseController {

    // The service object
	protected $${common.to_camelcase(entity_name)}Service;

	/**
	 * Constructor
	 */
	public function __construct() {
        //$this->${entity_name}Service = new Service\${common.to_camelcase(entity_name, True)}Service();
        $this->${common.to_camelcase(entity_name)}Service = App::make('${entity_name}_service');
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

		$records = ${service_call(entity_name, 'list', True)}($qparams, $offset, $limit);
		return $this->toJson($result);;
	}

	/**
	 * Showing the form is not supported
	 *
	 */
	public function create()
	{
		App::abort(404);
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
            $record = ${service_call(entity_name, 'create', False)}($data);
            return Response::json(array(
                'sid' => $record->sid),
                200
            );
        } catch (Exception $e) {
            return Response::json(array(
                'error' => $e->getMessage()),
                400
            );
        }
	}

	/**
	 * Return JSON representation of the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record = ${service_call(entity_name, 'find', False)}($id);

		return $record;
	}

	/**
	 * Showing the form is not supported in API.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	    App::abort(404);
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
            $record = ${service_call(entity_name, 'update', False)}($id, $data);
            return Response::json(array(
                'sid' => $record->sid),
                200
            );
        } catch (Exception $e) {
            return Response::json(array(
                'error' => $e->getMessage()),
                400
            );
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
		$result = ${service_call(entity_name, 'destroy', False)}($id, $data);

		if ($result) {
		    return Response::json(array(
                'error' => false),
                200
            );
		} else {
		    App::abort(404);
		}
	}
}
% endfor