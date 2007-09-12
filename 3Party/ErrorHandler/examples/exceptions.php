<?php
set_include_path('../src/');

require_once 'ErrorHandler/ErrorHandler.php';
require_once 'ErrorHandler/Logger/User.php';
require_once 'ErrorHandler/Logger/BlueScreen.php';

function exceptionhandler($e)
{
    $logger = new ErrorHandler_Logger_BlueScreen;

    $errorhandler = new ErrorHandler;
    $errorhandler->addLogger($logger);

    return $errorhandler->handleException($e);
}

set_exception_handler('exceptionhandler');

throw new Exception('Exception');
?>