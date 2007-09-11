<?php
class ErrorHandler_Logger_File
{
    private $logfile;

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
    public function write($input) {
        //if(self::isUnique($input)) {
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
        //}
    }

    public function update($input)
    {
        $this->write($input);
    }
}
