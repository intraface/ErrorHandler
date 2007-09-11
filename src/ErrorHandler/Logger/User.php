<?php
class ErrorHandler_Logger_User
{
    private $translator;

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

    function translate($phrase)
    {
        return $phrase;
    }

    function __($phrase)
    {
        return call_user_func($this->translator, $phrase);
    }

    /**
     * A static function display errors for users
     *
     * @param array details, see self::displayException()
     */
    public function log($input) {
            // saving previously buffered output for later
            // egentlig b�r denne jo bare sende videre til en anden side?

            $previous_output = ob_get_contents();
            //ob_end_clean();

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