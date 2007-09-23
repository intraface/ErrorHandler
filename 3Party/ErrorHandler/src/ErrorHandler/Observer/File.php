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
require_once 'Log.php';

class ErrorHandler_Observer_File
{
    /**
     * @var object
     */
    private $logger;

    /**
     * Constructor
     *
     * @param string error file name
     *
     * @return void
     */
    function __construct($logger = null)
    {
        // todo maybe a test for read and write access
        if (null === $logger) {
            $this->logger = &Log::factory('file', './error.log', 'INTRAFACE');
        } elseif (is_object($logger)) {
            $this->logger = $logger;
        } elseif (is_string($logger)) {
            $this->logger = &Log::factory('file', $logger, 'INTRAFACE');
        }
    }

    /**
     * Write error to log file
     *
     * @param array error details
     *
     * @return void
     */
    public function update($input) {
        
        $out  = str_repeat('-', 60)."\n";
        $out .= date('r')." - ".$input['type'].": ".$input['message']."\n";
        $out .= "in ".$input['file']." line ".$input['line']."\n";
        $out .= "Request: ".$_SERVER['REQUEST_URI']."\n";
        
        // Possible other pattern for logging filling less lines, probably making it easier to parse.
        // $out = $input['type'].": ".$input['message']." in ".$input['file']." line ".$input['line']. " (Request: ".$_SERVER['REQUEST_URI'].")";
        
        $this->logger->log($out);
    }
}
