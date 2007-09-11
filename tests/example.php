<?php
set_include_path('../src/');

require_once 'ErrorHandler/ErrorHandler.php';
require_once 'ErrorHandler/Logger/User.php';
require_once 'ErrorHandler/Logger/BlueScreen.php';

function errorhandler($errno, $errstr, $errfile, $errline, $errcontext) {
    $logger = new ErrorHandler_Logger_User;

    $errorhandler = new ErrorHandler;
    $errorhandler->addLogger($logger);

    return $errorhandler->handleError($errno, $errstr, $errfile, $errline, $errcontext);
}

function exceptionhandler($e)
{
    $logger = new ErrorHandler_Logger_BlueScreen;

    $errorhandler = new ErrorHandler;
    $errorhandler->addLogger($logger);

    return $errorhandler->handleException($e);
}

set_error_handler('errorhandler');
set_exception_handler('exceptionhandler');

throw new Exception('Exception');

trigger_error('usererror', E_USER_ERROR);