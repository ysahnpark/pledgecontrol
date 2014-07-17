<?php

/*
|--------------------------------------------------------------------------
| Register objects to the IoC
|--------------------------------------------------------------------------
|
|
*/

use Illuminate\Auth\Guard;

App::singleton('svc:account', function()
{
    return new \Service\AccountService();
});

App::singleton('svc:transaction', function()
{
    return new \Service\TransactionService();
});


App::singleton('svc:issue', function()
{
    return new \Service\IssueService();
});