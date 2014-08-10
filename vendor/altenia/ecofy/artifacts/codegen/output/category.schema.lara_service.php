<?php namespace Service;

/**
 * Models from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */

use Altenia\Ecofy\Service\BaseService;

/**
 * Service class that provides business logic for category
 */
class CategoryService extends BaseService {

    /**
     * Constructor
     */
    public function __construct($dao, $id = 'category')
    {
        parent::__construct($dao, $id);
    }

	/**
	 * Returns list of the records.
	 *
	 * @param array $queryParams  Parameters used for querying
	 * @param int   $offset       The starting record
	 * @param int   $limit        Maximum number of records to retrieve
	 * @return Response
	 */
	public function listCategories($queryParams, $offset = 0, $limit=100)
	{
		$query = \Category::query();
		$query = $this->parseQueryParams($query, $queryParams);
        $records = $query->skip($offset)->take($limit)->get();
		return $records;
	}

	/**
	 * Returns paginated list of the records.
	 *
	 * @param array $queryParams  Parameters used for querying
	 * @param int   $page_size    The max number of entries shown per page
	 * @return Response
	 */
	public function paginateCategories($queryParams, $page_size = 20)
	{
		$query = \Category::query();
		$query = $this->parseQueryParams($query, $queryParams);
        $records = $query->paginate($page_size);
		return $records;
	}

    /**
	 * Returns the count of records satisfying the critieria.
	 *
	 * @param array $queryParams  Parameters used for querying
	 * @return int number of records that satisfied the criteria
	 */
	public function count{common.to_camelcase(entity_name, True, True)}($queryParams)
	{
		$query = \Category::query();
		$query = $this->parseQueryParams($query, $queryParams);
        $count = $query->count();
		return $count;
	}

	/**
	 * Creates a new records.
	 * Mostly wrapper around insert with pre and post processing.
	 *
	 * @param array $data  Parameters used for creating a new record
	 * @return mixed  null if successful, validation object validation fails
	 */
	public function createCategory($data)
	{

		$validator = \Category::validator($data);
        if ($validator->passes()) {
            $record = new \Category();
            $record->fill($data);

            /*
             * @todo: assign default values as needed
             */
            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            $record->uuid = uniqid();
            $record->created_dt = $now_str;
            $record->updated_dt = $now_str;
            $record->save();
            return $record;
        } else {
            throw new ValidationException($validator);
        }
	}

	/**
	 * Retrieves a single record.
	 *
	 * @param  int $id  The primary key for the search
	 * @return Category
	 */
	public function findCategory($id)
	{
		$record = \Category::find($id);

		return $record;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int   $id    The primary key of the record to update
	 * @param  array $data  The data of the update
	 * @return mixed null if successful, validation if validation error
	 */
	public function updateCategory($id, $data)
	{
		$validator = \Category::validator($data);
        if ($validator->passes()) {
            $record = \Category::find($id);
            $record->fill($data);

            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            $record->updated_dt = $now_str;
            $record->save();
            return $record;
        } else {
            throw new ValidationException($validator);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return bool true if deleted, false otherwise
	 */
	public function destroyCategory($id)
	{
		// delete
		$record = \Category::find($id);
		if (!empty($record)) {
		    $record->delete();
		    return true;
		}
		return false;

	}
}