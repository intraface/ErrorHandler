<?php
/**
 * Logs an error message
 *
 * PHP Version 5
 *
 * @package   ErrorHandler
 * @author    Lars Olesen <lars@legestue.net>
 * @author    Sune Jensen <sj@sunet.dk>
 * @copyright 2007 Authors
 * @license   GPL http://www.opensource.org/licenses/gpl-license.php
 * @version   @package-version@
 * @link      http://www.sitepoint.com/blogs/2006/08/12/pimpin-harrys-pretty-bluescreen/
 */

/**
 * Logs an error message
 *
 * @package   ErrorHandler
 * @author    Lars Olesen <lars@legestue.net>
 * @author    Sune Jensen <sj@sunet.dk>
 * @copyright 2007 Authors
 * @license   GPL http://www.opensource.org/licenses/gpl-license.php
 * @version   @package-version@
 * @example   examples/trigger_error.php
 * @example   examples/exceptions.php
 * @link      http://www.sitepoint.com/blogs/2006/08/12/pimpin-harrys-pretty-bluescreen/
 */
class ErrorHandler_Logger_File
{
    /**
     * @var string
     */
    private $logfile;

    /**
     * Constructor
     *
     * @param string error file name
     *
     * @return void
     */
    function __construct($logfile = './error.log')
    {
        // todo maybe a test for read and write access
        $this->logfile = $logfile;
    }

    /**
     * Write error to log file
     *
     * @param array error details
     *
     * @return void
     */
    public function log($input) {
        /*
        $out = str_repeat('-', 60)."\n";
        $out .= date('r')." - ".$input['type'].": ".$input['message']."\n";
        $out .= "in ".$input['file']." line ".$input['line']."\n";
        $out .= "Request: ".$_SERVER['REQUEST_URI']."\n";
        */

        $error = array(
            'date' => date('r'),
            'type' => $input['type'],
            'message' => $input['message'],
            'file' => $input['file'],
            'line' => $input['line'],
            'request' => $_SERVER['REQUEST_URI']
        );

        if(touch($this->logfile)) {
            file_put_contents($this->logfile, serialize($error) . "\n", FILE_APPEND);
        }
    }
}
