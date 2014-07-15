<?php namespace Service;

/**
 * namespace is same as the foldername
 * There should be an entry in composer.json
 * in the array property autoload.classmap
 * additional element: "app/services"
 */


/**
 * Service class that provides business logic for Account
 */
class AccountService  {


    public function buildQuery($criteria)
    {
        if (empty($criteria)) $criteria = array();
        $queryBuilder = new \DocuFlow\Helper\DfQueryBuilderEloquent();
        $query = \Account::query();
        $queryBuilder->buildQuery($criteria, $query);
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
    public function listAccounts($criteria, $sortParams = array(), $offset = 0, $limit=100)
    {
        $query = $this->buildQuery($criteria);
        //$query = \Account::query();
        //$query->where()

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
    public function paginateAccounts($criteria, $sortParams = array(), $page_size = 20)
    {
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
    public function countAccounts($criteria)
    {
        $query = $this->buildQuery($criteria);
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
    public function createAccount($data)
    {
        $validator = \Account::validator($data);
        if ($validator->passes()) {
            $record = new \Account();
            $record->fill($data);

            // Compute the amount per period
            $record->AmountPerPeriod = $record->PledgeAmount / ($record->Duration / $record->PaymentPeriod);

            /*
             * @todo: assign default values as needed
             */
            $now = new \DateTime;
            $now_str = $now->format('Y-m-d H:i:s');
            //$record->PaymentDate = $now_str;

            $record->save();

            //print_r($record);
            //die();

            return $record;
        } else {
            throw new ValidationException($validator);
        }
    }

    /**
     * Retrieves a single record.
     *
     * @param  int $pk  The primary key for the search
     * @return Account
     */
    public function findAccountByPK($pk)
    {
        $record = \Account::find($pk);

        return $record;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int   $pk    The primary key of the record to update
     * @param  array $data  The data of the update
     * @return mixed null if successful, validation if validation error
     */
    public function updateAccount($pk, $data)
    {
        
        $validator = \Account::validator($data, false);
        if ($validator->passes()) {
            $record = \Account::find($pk);
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
    public function destroyAccount($pk)
    {
        // delete
        $record = \Account::find($pk);
        if (!empty($record)) {
            $record->delete();
            return $record;
        }
        return null;
    }

    public function listAccounts2($criteria, $sortParams = array(), $offset = 0, $limit=100)
    {
        $sql = "
        (SELECT ID, SignupDate, Name, PledgeStartDate, PledgeAmount, Duration,
            PaymentPeriod, PeriodUnit, AmountPerPeriod, SparePeriod, 
            PaidAmount, RemainingAmount, Status
            Email, Phone, Address, City, State, PostalCode, ThankyouLetterSentDate, 
            CEIL(TIMESTAMPDIFF(MONTH, PledgeStartDate, NOW()) / PaymentPeriod) as PeriodsPassed
            FROM accounts WHERE PeriodUnit= 'm')
        UNION
        (SELECT ID, SignupDate, Name, PledgeStartDate, PledgeAmount, Duration,
            PaymentPeriod, PeriodUnit, AmountPerPeriod, SparePeriod,
            PaidAmount, RemainingAmount, Status
            Email, Phone, Address, City, State, PostalCode, ThankyouLetterSentDate, 
            CEIL(TIMESTAMPDIFF(WEEK, PledgeStartDate, NOW()) / PaymentPeriod) as PeriodsPassed
            FROM accounts WHERE PeriodUnit= 'w')
        ORDER BY Name;";

        // AmountDueNowRaw =  PeriodsPassed * AmountPerPeriod;
        // AmountDueNow =  (PeriodsPassed * AmountPerPeriod) - PaidAmount;
        $result = \DB::select(\DB::raw($sql));

        //print_r($result);
        return $result;
    }

    public function totals()
    {
        $records = $this->listAccounts2(array());

        $total_PledgeAmount = 0; 
        $total_AmountExpectedNow = 0;
        $total_AmountDueNow = 0;
        $total_PaidAmount = 0;
        $total_RemainingAmount = 0;

        foreach($records as $record)
        {
            $model = new \Account();
            $model->fill( (array)$record);
            //$amountExpectedNow = ($record->PeriodsPassed * $record->AmountPerPeriod) ;
            //$amountDueNow = $amountExpectedNow - $record->PaidAmount ;
            $total_PledgeAmount += $model->PledgeAmount;
            $total_AmountExpectedNow += $model->getAmountExpectedNow();
            $total_AmountDueNow += $model->getAmountDueNow();
            $total_PaidAmount += $model->PaidAmount;
            $total_RemainingAmount += $model->RemainingAmount;
        }
        $totals = array(
            'TotalPledgeAmount' => $total_PledgeAmount,
            'TotalAmountExpectedNow' => $total_AmountExpectedNow,
            'TotalAmountDueNow' => $total_AmountDueNow,
            'TotalPaidAmount'   => $total_PaidAmount,
            'TotalRemainingAmount' => $total_RemainingAmount
            );
        return $totals;
    }

    /**
     * Returns [{date, count}]
     */
    public function signupTrend()
    {
        $sql = "
        SELECT YEAR(PledgeStartDate) AS PledgeStartDateYear, MONTH(PledgeStartDate) AS PledgeStartDateMonth, 
            COUNT(ID) as SignupCount
        FROM accounts
        GROUP BY YEAR(PledgeStartDate), MONTH(PledgeStartDate)
        ORDER BY PledgeStartDate;";

        $result = \DB::select(\DB::raw($sql));

        return $result;
    }
}