<?php namespace Service;

/**
 * namespace is same as the foldername
 * There should be an entry in composer.json
 * in the array property autoload.classmap
 * additional element: "app/services"
 */


/**
 * Service class that provides business logic for Ticket
 */
class TicketService  {

    private $accountService = null;

    public function buildQuery($criteria)
    {
        if (empty($criteria)) $criteria = array();
        $queryBuilder = new \DocuFlow\Helper\DfQueryBuilderEloquent();
        $query = \Ticket::query();
        $query = $queryBuilder->buildQuery($criteria, $query);
        return $query; 
    }

    public function getAcountService()
    {
        if ($this->accountService === null) {
            $this->accountService = \App::make('svc:account');
        }
        return $this->accountService;
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
    public function listTickets($criteria, $sortParams = array(), $offset = 0, $limit=100)
    {
        $query = $this->buildQuery($criteria);
        $records = $query->skip($offset)->take($limit)->orderBy('TicketDate', 'desc')->get();

        return $records;
    }


    /**
     * Returns paginated list of the records.
     *
     * @param array $criteria     Parameters used for querying
     * @param int   $page_size    The max number of entries shown per page
     * @return Response
     */
    public function paginateTickets($criteria, $sortParams = array(), $page_size = 20)
    {
        // @TODO: pending
        $query = $this->buildQuery($criteria);
        $records = $query->orderBy('TicketDate', 'desc')->paginate($page_size);
        return $records;
    }

    /**
     * Returns the count of records satisfying the critieria.
     *
     * @param array $queryParams  Parameters used for querying
     * @return int number of records that satisfied the criteria
     */
    public function countTickets($criteria)
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
    public function createTicket($data)
    {
        $validator = \Ticket::validator($data);
        if ($validator->passes()) {

            $record = new \Ticket();
            $record->fill($data);

            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            $record->TicketDate = $now_str;
            $record->Status = 'Created';

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
     * @return Ticket
     */
    public function findTicketByPK($pk)
    {
        $record = \Ticket::find($pk);

        return $record;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int   $pk    The primary key of the record to update
     * @param  array $data  The data of the update
     * @return mixed null if successful, validation if validation error
     */
    public function updateTicket($pk, $data)
    {
        
        $validator = \Ticket::validator($data, false);
        if ($validator->passes()) {
            $record = \Ticket::find($pk);
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
    public function destroyTicket($pk)
    {
        // delete
        $record = \Ticket::find($pk);
        if (!empty($record)) {
            $record->delete();
            return $record;
        }
        return null;
    }

    public function report($criteria)
    {
        $sql = "
        SELECT month(PaymentDate) AS Month,
               year(PaymentDate) AS Year,
               sum(Amount) AS MonthTotal,
               count(Amount) AS TransCount
        FROM trans
        GROUP BY YEAR(PaymentDate), MONTH(PaymentDate)
        ORDER BY PaymentDate DESC;";

        // AmountDueNowRaw =  PeriodsPassed * AmountPerPeriod;
        // AmountDueNow =  (PeriodsPassed * AmountPerPeriod) - PaidAmount;
        $result = \DB::select(\DB::raw($sql));
        //print_r($result);
        return $result;
    }
}