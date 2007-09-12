<?php
set_include_path('../src/');

require_once 'ErrorHandler.php';
require_once 'ErrorHandler/Observer/User.php';
require_once 'ErrorHandler/Observer/BlueScreen.php';

function exceptionhandler($e)
{
    $logger = new ErrorHandler_Observer_BlueScreen;

    $errorhandler = new ErrorHandler;
    $errorhandler->addObserver($logger);

    return $errorhandler->handleException($e);
}

set_exception_handler('exceptionhandler');

throw new Exception('Exception');
?>