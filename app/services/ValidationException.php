<?php

/**
 * namespace is same as the foldername
 * There should be an entry in composer.json
 * in the array property autoload.classmap
 * additional element: "app/services"
 */
namespace Service;

/**
 * Service class that provides business logic for User
 */
class ValidationException extends ServiceException {

	public function __construct($validator = null) 
	{
		// Should the first param be: (string)$validator->messages()->getMessages()
		parent::__construct((string)$validator->messages(), ServiceException::CODE_VALIDATION, null, $validator);
    }

}
