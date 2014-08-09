<?php namespace Altenia\Ecofy\CoreService;

use Altenia\Ecofy\Service\BaseService;


class PredefinedAcl
{
    // @TODO take this away from here
    public static $serviceAcl = array();

    public static function get($role) {
        if (self::$serviceAcl == null) {
            self::$serviceAcl = array();
            $adminAc = new \AccessControl();
            $adminAc->permissions = 31;
            $adminAc->setPolicyFromJson('
                    {
                        "svc:user": {"@permissions": 31},
                        "svc:organization": {"@permissions": 31},
                        "svc:role": {"@permissions": 31},
                        "svc:document_type": {"@permissions": 31},
                        "svc:workflow": {"@permissions": 31}
                    }');
            self::$serviceAcl['admin'] = $adminAc;

            $staffAc = new \AccessControl();
            $staffAc->permissions = 31;
            $staffAc->setPolicyFromJson('
                    {
                        "svc:user": {"@permissions": 15},
                        "svc:organization": {"@permissions": 31},
                        "svc:document_type": {"@permissions": 7}
                    }');
            self::$serviceAcl['staff'] = $staffAc;


            $defaultAc = new \AccessControl();
            $defaultAc->permissions = 1;
            $defaultAc->setPolicyFromJson('
                    {
                    }');
            self::$serviceAcl['default'] = $defaultAc;
        }
        if (array_key_exists($role, self::$serviceAcl)) {
            return self::$serviceAcl[$role];
        }
        return self::$serviceAcl['default'];
    }
}

/**
 * Service class that provides business logic for access_control
 */
class AccessControlService extends BaseService {

    /**
     * Constructor
     */
    public function __construct($dao, $id = 'access_control')
    {
    	parent::__construct($dao, $id, 'access_control');
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
	public function listAccessControls($criteria, $sortParams = array(), $offset = 0, $limit=100)
	{
        $result = $this->dao->query($criteria, $sortParams, $offset, $limit);
        return $result;
	}

	/**
	 * Returns paginated list of the records.
	 *
	 * @param array $queryParams  Parameters used for querying
	 * @param int   $page_size    The max number of entries shown per page
	 * @return Response
	 */
	public function paginateAccessControls($queryParams, $page_size = 20)
	{
	    // @TODO: pending
		$query = \AccessControl::query();
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
	public function countAccessControls($criteria)
	{
		return $this->dao->count($criteria);
	}

	/**
	 * Creates a new records.
	 * Mostly wrapper around insert with pre and post processing.
	 *
	 * @param array $data  Parameters used for creating a new record
	 * @return mixed  null if successful, validation object validation fails
	 */
	public function createAccessControl($data)
	{
		$validator = \AccessControl::validator($data);
        if ($validator->passes()) {
            $record = new \AccessControl();
            $record->fill($data);

            return $dao->insert($record);
        } else {
            throw new ValidationException($validator);
        }
	}

	/**
	 * Retrieves a single record.
	 *
	 * @param  int $criteria  The primary key for the search
	 * @return AccessControl
	 */
	public function findAccessControl($criteria)
	{
		return $dao->find($criteria);
	}

	/**
	 * Retrieves a single record.
	 *
	 * @param  int $pk  The primary key for the search
	 * @return AccessControl
	 */
	public function findAccessControlByPK($pk)
	{
        return $this->dao->findByPK($pk);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int   $pk    The primary key of the record to update
	 * @param  array $data  The data of the update
	 * @return mixed null if successful, validation if validation error
	 */
	public function updateAccessControl($pk, $data)
	{
		$validator = \AccessControl::validator($data);
        if ($validator->passes()) {

            return $this->dao->update( $pk, $data );
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
	public function destroyAccessControl($pk)
	{
		return $this->dao->delete($pk);
	}


    //////////

	/**
	 * Retrieves a access control of a user.
	 *
	 * @param  User $user  The primary key for the search
	 * @return AccessControl
	 */
	public function findAccessControlByUser($user)
	{
		$retval = null;
		if (!empty($user)) {
			if (!empty($user->role_sid)) {
				//$criteria = array( '_id' => new \MongoId($user->role_sid) );
				$criteria = array( 'role_sid' => $user->role_sid, 'service' => 'root' );
		        $retval = $this->findAccessControl($criteria);
		    }
		    if (empty($retval)) {
		    	$retval = PredefinedAcl::get($user->type);
		    }
		}
    	if (empty($retval)) {
    		$retval = PredefinedAcl::get('default');
    	}
		
	    return $retval;
	}
}
