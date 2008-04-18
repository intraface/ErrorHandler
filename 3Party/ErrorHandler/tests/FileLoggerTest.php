<?php
require_once 'config.test.php';

require_once 'PHPUnit/Framework.php';

require_once 'MDB2.php';
require_once '../src/ErrorHandler.php';
require_once '../src/ErrorHandler/Observer/File.php';

class FileLoggerTest_Logger {
    
    public $text;
    
    function  log($text) {
        $this->text = $text;
    }
}

class FileLoggerTest extends PHPUnit_Framework_TestCase
{
    
    function setUp()
    {
        
    }
    
    function createErrorHandler() {
        
        $eh = new ErrorHandler();
        $eh->addObserver(new ErrorHandler_Observer_File(new FileLoggerTest_Logger));
        return $eh;
        
    }

    function testConstructor()
    {
        $error = $this->createErrorHandler();
        $this->assertTrue(is_object($error));
    }

    function testTriggerError() {
        
        $logger = $this->getMock('Logger', array('log'));
        $logger->expects($this->once())
                 ->method('log')
                 ->with($this->equalTo('Error: This is not really an error in myfile line 101 (Request: unknown)'));
        
        $error = new ErrorHandler();
        $error->addObserver(new ErrorHandler_Observer_File($logger));
        
        
        $error->handleError(1, 'This is not really an error', 'myfile', '101', '');
    }
    
    function testTriggerErrorRemovesNewLinesInError() {
        
        $logger = $this->getMock('Logger', array('log'));
        $logger->expects($this->once())
                 ->method('log')
                 ->with($this->equalTo('Error: This is not really an error in myfile line 101 (Request: unknown)'));
        
        $error = new ErrorHandler();
        $error->addObserver(new ErrorHandler_Observer_File($logger));
        
        
        $error->handleError(1, "This is not\nreally an error", 'myfile', '101', '');
    }
}

