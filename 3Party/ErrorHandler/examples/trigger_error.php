<?php
set_include_path('../src/' . PATH_SEPARATOR . get_include_path());

require_once 'ErrorHandler.php';
require_once 'ErrorHandler/Observer/User.php';
require_once 'ErrorHandler/Observer/BlueScreen.php';
require_once 'ErrorHandler/Observer/File.php';

function errorhandler($errno, $errstr, $errfile, $errline, $errcontext) {
    $errorhandler = new ErrorHandler;
    $errorhandler->addObserver(new ErrorHandler_Observer_File);
    $errorhandler->addObserver(new ErrorHandler_Observer_User);
    $errorhandler->addObserver(new ErrorHandler_Observer_BlueScreen);
    return $errorhandler->handleError($errno, $errstr, $errfile, $errline, $errcontext);
}

set_error_handler('errorhandler');

trigger_error('usererror', E_USER_ERROR);