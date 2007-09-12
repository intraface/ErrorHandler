<?php
/**
 * Sends an email on error
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
 * Sends an email on error
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
class ErrorHandler_Logger_Email
{

    /**
     * @var string
     */
    private $email;

    /**
     * Constructor
     *
     * @param string $email Email address
     *
     * @return void
     */
    function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Send an e-mail with the error to the support/administrator - is it possible to make anything with unique
     * when we abstract this?
     *
     * @param array $input Error details
     *
     * @return void
     */
    public static function log($input) {
        // building mail text
        $out  = $input['type']." making ".$_SERVER['REQUEST_METHOD']." request to ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\n";
        $out .= "Message: ".$input['message']."\n";
        $out .= "In: ".$input['file']." line ".$input['line']."\n";
        $out .= "At: ".date('r')."\n\n";
        $out .= "Click here to reproduce the error (hopefully): \n\n  > ";
        $out .= ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http')."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\n\n";
        $out .= "Request details: \n\n".self::getRequestHeaders();

        // sending mail
        mail($this->email, "Error on ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $out);
    }

    /**
     * Returns the request headers
     *
     * @return string Request headers
     */
    private static function getRequestHeaders() {
        $result = '';
        if (!function_exists('apache_request_headers')) return $result;
        foreach(apache_request_headers() as $key => $value) {
            $result .= htmlspecialchars($key.': '.$value."\n");
        }
        return $result;
    }
}
