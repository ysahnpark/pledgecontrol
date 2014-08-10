<?php

/*
|--------------------------------------------------------------------------
| Register objects to the IoC
|--------------------------------------------------------------------------
|
|
*/
use \Altenia\Ecofy\Service\ServiceRegistry;
use Illuminate\Auth\Guard;

\Altenia\Ecofy\Util\DataFormat::$defaultDateFormat = 'Y-m-d';


App::singleton('svc:user', function()
{
	$dao = new \Altenia\Ecofy\CoreService\UserDaoEloquent();
    return new \Altenia\Ecofy\CoreService\UserService($dao);
});

App::singleton('svc:account', function()
{
    return new \Service\AccountService();
});

App::singleton('svc:transaction', function()
{
    return new \Service\TransactionService();
});

App::singleton('svc:ticket', function()
{
    $svc = new \Service\TicketService();
    $svc->setClosingStatuses(array('resolved', 'dropped'));
    return $svc ;
});


ServiceRegistry::instance()->addEntry('user', Lang::get('user._name_plural'), 
	\URL::to('users'), 'glyphicon-user');

