<?php
set_include_path('../src/');

require_once 'ErrorHandler/ErrorHandler.php';
require_once 'ErrorHandler/Logger/User.php';
require_once 'ErrorHandler/Logger/BlueScreen.php';

function errorhandler($errno, $errstr, $errfile, $errline, $errcontext) {
    $errorhandler = new ErrorHandler;
    $errorhandler->addLogger(new ErrorHandler_Logger_User);
    $errorhandler->addLogger(new ErrorHandler_Logger_BlueScreen);
    return $errorhandler->handleError($errno, $errstr, $errfile, $errline, $errcontext);
}

set_error_handler('errorhandler');

trigger_error('usererror', E_USER_ERROR);