<?php
/**
 * Pimpin Harry's pretty blue screen
 *
 * Handles errors and exceptions. Inspired by
 * http://www.sitepoint.com/blogs/2006/08/12/pimpin-harrys-pretty-bluescreen/
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
 * Pimpin Harry's pretty blue screen
 *
 * Handles errors and exceptions.
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
class ErrorHandler
{
    /**
     * @var array
     */
    private $observers = array();

    /**
     * Adds observers and sets when the logger should handle an error.
     *
     * @param object  $logger     A logger implementing the update method
     * @param integer $errorlevel When should the logger be notified
     *
     * @return void
     */
    public function addObserver($observer, $errorlevel = E_ALL)
    {
        if (!method_exists($observer, 'update')) {
            // Are we able to throw an exception as the errorhandler is also able to handle exceptions!
            throw new Exception('The observer ' . get_class($observer) . ' does not implement an updated method.');
        }
        $this->observers[] = array('observer' => $observer, 'errorlevel' => $errorlevel);
    }

    /**
     * Gets all observers
     *
     * @return array
     */
    protected function getObservers()
    {
        return $this->observers;
    }

    /**
     * Notifies all observers. This handles when an observer is adviced.
     *
     * @param array $error The error array
     *
     * @return void
     */
    protected function notifyObservers($error)
    {
        foreach ($this->getObservers() as $logger) {
            if ($error['errno'] & $logger['errorlevel']) {
                $logger['observer']->update($error);
            }
        }
    }

    /**
     * Hook for error handling
     *
     * @param integer Error level
     * @param string Error message
     * @param string Error file
     * @param integer Line
     * @param array Context (all defined vars)
     *
     * @return void nothing
     */
    public function handleError($errno, $errstr, $errfile, $errline, $errcontext) {
        // Error types
        $error_types = array(
            1 => 'ERROR',
            2 => 'WARNING',
            4 => 'PARSE',
            8 => 'NOTICE',
            16 => 'CORE_ERROR',
            32 => 'CORE_WARNING',
            64 => 'COMPILE_ERROR',
            128 => 'COMPILE_WARNING',
            256 => 'USER_ERROR',
            512 => 'USER_WARNING',
            1024 => 'USER_NOTICE',
            2047 => 'ALL',
            2048 => 'STRICT',
            4096 => 'RECOVERABLE_ERROR'
        );

        // Filling up details
        $details['date']    = date('Y-m-d H:i:s');
        $details['type']    = 'Error';
        $details['code']    = $error_types[$errno];
        $details['errno']   = $errno;
        $details['message'] = preg_replace("%\s\[<a href='function\.[\d\w-_]+'>function\.[\d\w-_]+</a>\]%", '', $errstr); // Removing PHP function links
        $details['line']    = $errline;
        $details['file']    = $errfile;
        $details['trace']   = array();
        $details['request'] = $_SERVER['REQUEST_URI'];

        // Building exception-like backtrace
        $backtrace = debug_backtrace();
        for($i = 1; $i < sizeof($backtrace); $i++) {
            $details['trace'][$i - 1]['file']     = @$backtrace[$i]['file'];
            $details['trace'][$i - 1]['line']     = @$backtrace[$i]['line'];
            $details['trace'][$i - 1]['function'] = @$backtrace[$i]['function'];
            $details['trace'][$i - 1]['class']    = @$backtrace[$i]['class'];
            $details['trace'][$i - 1]['type']     = @$backtrace[$i]['type'];
            $details['trace'][$i - 1]['args']     = @$backtrace[$i]['args'];
        }
        return self::handleAny($details);
    }

    /**
     * Hook for exception handling
     *
     * @param Exception exception to handle
     *
     * @return void
     */
    public function handleException($e) {
        $details['date'] = date('Y-m-d H:i:s');
        $details['type'] = get_class($e);
        $details['code'] = $e->getCode();
        $details['errno'] = '';
        $details['message']= $e->getMessage();
        $details['line'] = $e->getLine();
        $details['file'] = $e->getFile();
        $details['trace'] = $e->getTrace();
        $details['request'] = $_SERVER['REQUEST_URI'];
        return self::handleAny($details);
    }

    /**
     * Handle either Errors or Exceptions
     *
     * @param array details
     *
     * @return void
     */
    private function handleAny($details) {
        $this->notifyObservers($details);
    }
}
?>