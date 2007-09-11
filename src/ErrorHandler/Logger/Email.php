<?php
class ErrorHandler_Logger_Email
{

    private $email;

    function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Send an e-mail with the error to the support/administrator - is it possible to make anything with unique
     * when we abstract this?
     *
     * @param array error details
     *
     * @return void
     */
    public static function log($input) {
        //if(self::isUnique($input)) {
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
        //}
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
