<?php
/**
 * Gives a generic error message to the user, if something happens in the program.
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
 * Gives a generic error message to the user, if something happens in the program.
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
class ErrorHandler_Observer_User
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
    function __construct($translator = null)
    {
        if (is_object($translator)) {
            $this->translator = array($translator, '__');
        } elseif (is_string($translator)) {
            $this->translator = $translator;
        } elseif (null === $translator) {
            $this->translator = array($this, 'translate');
        }
    }

    /**
     * Hook for translation
     *
     * @param string $phrase Translates the phrase
     *
     * @return void
     */
    function translate($phrase)
    {
        return $phrase;
    }

    /**
     * Hook for translation
     *
     * @param string $phrase Translates the phrase
     *
     * @return void
     */
    function __($phrase)
    {
        return call_user_func($this->translator, $phrase);
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
            
            ob_end_clean();
            ?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
            <html xml:lang="da" xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <title><?php echo $this->__('An error occured'); ?></title>
                    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
                    <style type="text/css">
                    html {
                        font-size: 85%;
                    }
                    body {
                        font-family: verdana, sans-serif;
                        font-size: 1em;
                        text-align: center;
                    }
                    #container {
                        border: 5px solid #ccc;
                        width: 30em;
                        margin: 3em auto;
                        text-align: left;
                        padding: 2em;
                    }
                    </style>
                </head>
                <body>
                <div id="container">
                <h1><?php echo $this->__('An error occured'); ?></h1>
                <p><?php echo $this->__('We are looking into the problems.'); ?></p>
                <p><?php echo $this->__('Sorry for the inconvenience.'); ?></p>
                </div>
                </body>
            </html>
            <?php
            exit;
    }
}