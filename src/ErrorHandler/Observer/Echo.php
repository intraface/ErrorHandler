<?php
/**
 * Gives a simpe error message printed on the screen, if something happens in the program.
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

class ErrorHandler_Observer_Echo
{
    /**
     * @var string callback
     */
    private $translator;

    /**
     * Constructor
     *
     * @param mixed $translator Either an object or a callback
     *
     * @return void
     */
    function __construct()
    {
        
    }


    /**
     * Display errors for users
     *
     * @param array $input Array with the error input
     *
     * @return void
     */
    public function update($input)
    {
          echo ''.@$input['code'].': '.@$input['message'].' in '.@$input['file'].' line '.@$input['line'].' (Request: '.$input['request'].')';
    }
}