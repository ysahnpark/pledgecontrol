<?php namespace Service;

/**
 * namespace is same as the foldername
 * There should be an entry in composer.json
 * in the array property autoload.classmap
 * additional element: "app/services"
 */


/**
 * Service class that provides business logic for Transaction
 */
class TransactionService  {


    public function buildQuery($criteria)
    {
        if (empty($criteria)) $criteria = array();
        $queryBuilder = new \DocuFlow\Helper\DfQueryBuilderEloquent();
        $query = \Transaction::query();
        $query = $queryBuilder->buildQuery($criteria, $query);
        return $query; 
    }

    /**
     * Returns list of the records.
     *
     * @param array $queryParams  Parameters used for querying
     *                            They key is of format "colname-op"
     * @param int   $offset       The starting record
     * @param int   $limit        Maximum number of records to retrieve
     * @return Response
     */
    public function listTransactions($criteria, $sortParams = array(), $offset = 0, $limit=100)
    {
        $query = $this->buildQuery($criteria);
        $records = $query->skip($offset)->take($limit)->get();

        return $records;
    }


    /**
     * Returns paginated list of the records.
     *
     * @param array $criteria     Parameters used for querying
     * @param int   $page_size    The max number of entries shown per page
     * @return Response
     */
    public function paginateTransactions($criteria, $sortParams = array(), $page_size = 20)
    {
        // @TODO: pending
        $query = $this->buildQuery($criteria);
        $records = $query->paginate($page_size);
        return $records;
    }

    /**
     * Returns the count of records satisfying the critieria.
     *
     * @param array $queryParams  Parameters used for querying
     * @return int number of records that satisfied the criteria
     */
    public function countTransactions($criteria)
    {
        $query = $this->buildQuery($criteria);
        $count = $query->query()->count();
        return $count;
    }

    /**
     * Creates a new records.
     * Mostly wrapper around insert with pre and post processing.
     *
     * @param array $data  Parameters used for creating a new record
     * @return mixed  null if successful, validation object validation fails
     */
    public function createTransaction($data)
    {
        $validator = \Transaction::validator($data);
        if ($validator->passes()) {
            $record = new \Transaction();
            $record->fill($data);

            /*
             * @todo: assign default values as needed
             */
            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            $record->PaymentDate = $now_str;

            $record->save();
            return $record;
        } else {
            throw new ValidationException($validator);
        }
    }

    /**
     * Retrieves a single record.
     *
     * @param  int $pk  The primary key for the search
     * @return Transaction
     */
    public function findTransactionByPK($pk)
    {
        $record = \Transaction::find($pk);

        return $record;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int   $pk    The primary key of the record to update
     * @param  array $data  The data of the update
     * @return mixed null if successful, validation if validation error
     */
    public function updateTransaction($pk, $data)
    {
        
        $validator = \Transaction::validator($data, false);
        if ($validator->passes()) {
            $record = \Transaction::find($pk);
            $record->fill($data);
            $record->save();
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
    public function destroyTransaction($pk)
    {
        // delete
        $record = \Transaction::find($pk);
        if (!empty($record)) {
            $record->delete();
            return $record;
        }
        return null;
    }

}