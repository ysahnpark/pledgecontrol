<?php

/**
 * namespace is same as the foldername
 * There should be an entry in composer.json
 * in the array property autoload.classmap
 * additional element: "app/services"
 * Also run `php artisan dump-autoload`
 */
namespace Service;

/**
 * Service class that provides business logic for User
 */
class ServiceException extends \Exception {

	const CODE_VALIDATION = 10;
	const CODE_DATA_ACCES = 20;

	// Object that 
	private $object = null;

	public function __construct($message = null, $code = 0, Exception $previous = null, 
		$object = null) 
	{
		parent::__construct($message, $code, $previous);
        $this->object = $object;
    }

    public function getObject()
    {
    	return $this->object;
    }
}