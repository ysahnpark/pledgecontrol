<?php namespace Service;
/**
 * Mongo Service from schema: ecofy version 0.1
 * Code generated by TransformTask
 *
 */

/**
 * Service class that provides business logic for code_ref
 */
class CodeRefServiceMongo extends BaseServiceMongo {

    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct('code_ref');
    }

	/**
	 * Returns list of the records.
	 *
	 * @param array $criteria     Parameters used for querying
	 * @param int   $sortParams   Parameters used for sorting
	 * @param int   $offset       The starting record
	 * @param int   $limit        Maximum number of records to retrieve
	 * @return Response
	 */
	public function listCodeRefs($criteria, $sortParams = array(), $offset = 0, $limit=100)
	{
		$criteria = array(); // The criteria
        $cursor = $this->db_collection->find( $criteria )->skip($offset)->limit($limit);

        $records = array();
        while ($cursor->hasNext())
        {
            $doc = $cursor->getNext();
            $records[] = $this->toModel($doc);
        }
        $result = new \Illuminate\Support\Collection($records);
        
        return $result;
	}

	/**
	 * Returns paginated list of the records.
	 *
	 * @param array $queryParams  Parameters used for querying
	 * @param int   $page_size    The max number of entries shown per page
	 * @return Response
	 */
	public function paginateCodeRefs($queryParams, $page_size = 20)
	{
	    // @TODO: pending
		$query = \CodeRef::query();
		$query = $this->parseQueryParams($query, $queryParams);
        $records = $query->paginate($page_size);
		return $records;
	}

    /**
	 * Returns the count of records satisfying the critieria.
	 *
	 * @param array $criteria  Parameters used for querying
	 * @return int number of records that satisfied the criteria
	 */
	public function countCodeRefs($criteria)
	{
		$count = $this->db_collection->find( $criteria )->count();
		return $count;
	}

	/**
	 * Creates a new records.
	 * Mostly wrapper around insert with pre and post processing.
	 *
	 * @param array $data  Parameters used for creating a new record
	 * @return mixed  null if successful, validation object validation fails
	 */
	public function createCodeRef($data)
	{

		$validator = \CodeRef::validator($data);
        if ($validator->passes()) {
            $record = new \CodeRef();
            $record->fill($data);

            /*
             * @todo: assign default values as needed
             */
            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            $record->uuid = uniqid();
            $record->created_dt = $now_str;
            $record->updated_dt = $now_str;

            $arrModel = $record->toArray();
            $arrModel['_id'] = new \MongoId();
            $record->sid = (string)$arrModel['_id'];

            $this->db_collection->insert( $arrModel );

            return $record;
        } else {
            throw new ValidationException($validator);
        }
	}

	/**
	 * Retrieves a single record.
	 *
	 * @param  int $criteria  The primary key for the search
	 * @return CodeRef
	 */
	public function findCodeRef($criteria)
	{
        $doc = $this->db_collection->findOne( $criteria );

        $record = null;
        if (!empty($doc))
        {
            $record = $this->toModel($doc);
        }

		return $record;
	}

	/**
	 * Retrieves a single record.
	 *
	 * @param  int $pk  The primary key for the search
	 * @return CodeRef
	 */
	public function findCodeRefByPK($pk)
	{
		$criteria = array( '_id' => new \MongoId($pk) );
        return $this->findCodeRef($criteria);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int   $pk    The primary key of the record to update
	 * @param  array $data  The data of the update
	 * @return mixed null if successful, validation if validation error
	 */
	public function updateCodeRef($pk, $data)
	{
		$validator = \CodeRef::validator($data);
        if ($validator->passes()) {
            $record = $this->findCodeRefByPK($pk);
            $record->fill($data);

            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            $record->updated_dt = $now_str;

            $arrModel = $record->toArray();
            $criteria = array( '_id' => new \MongoId($pk) );
            $this->db_collection->update( $criteria, $arrModel );

            return $record;
        } else {
            throw new ValidationException($validator);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $pk
	 * @return Object the object that was deleted, null if not found
	 */
	public function destroyCodeRef($pk)
	{
		$record = $this->findCodeRefByPK($pk);
		if (!empty($record)) {
		    $criteria = array( '_id' => new \MongoId($pk) );
		    $this->db_collection->remove( $criteria );
		    return $record;
		}
		return null;
	}

	/**
	 * Returns the Laravel model object
	 */
    private function toModel($doc)
    {
        $model = new \CodeRef();
        $model->sid = (string)$doc['_id'];
        $model->fill($doc);
        return $model;
    }
}
