<?php namespace Altenia\Ecofy\CoreService;

use Altenia\Ecofy\Dao\BaseDaoEloquent;

/**
 * DAO class that provides business logic for User
 */
class RoleDaoEloquent extends BaseDaoEloquent  {

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('Altenia\Ecofy\CoreService\Role');
    }

}