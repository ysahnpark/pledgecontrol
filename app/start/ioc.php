<?php

/*
|--------------------------------------------------------------------------
| Register objects to the IoC
|--------------------------------------------------------------------------
|
|
*/

use Illuminate\Auth\Guard;

\Altenia\Ecofy\Util\DataFormat::$defaultDateFormat = 'Y-m-d';

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
    return new \Service\TicketService();
});
