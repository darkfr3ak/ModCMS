<?php

class ErrorHandler{
    
    private $debug = 0;

    public function __construct(){
        $this->debug = Conf::$DEBUG_MODE;
        set_error_handler(array($this, 'handleError'));
    }

    public function handleError($errorType, $errorString, $errorFile, $errorLine){
        if (!(error_reporting() & $errorType)) {
            // This error code is not included in error_reporting
            return;
        }

        switch ($errorType) {
        case E_USER_ERROR:
            echo "<div class='alert alert-danger'><b>FATAL ERROR</b> [$errorType] $errorString<br>"
                . "On line $errorLine in file $errorFile,<br>"
                . "PHP-Version " . PHP_VERSION . " (on " . PHP_OS . ")<br>"
                . "Aborting...</div>";
            exit(1);
            break;
        case E_ERROR:
            echo "<div class='alert alert-danger'><b>FATAL ERROR</b> [$errorType] $errorString<br>"
                . "On line $errorLine in file $errorFile,<br>"
                . "PHP-Version " . PHP_VERSION . " (on " . PHP_OS . ")<br>"
                . "Aborting...</div>";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<div class='alert alert-warning alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <b>WARNING</b> [$errorType] $errorString</div> \n";
            break;

        case E_WARNING:
            echo "<div class='alert alert-warning alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<b>WARNING</b> [$errorType] $errorString</div> \n";
            if($this->debug){
                echo "On line $errorLine in file $errorFile,<br>\n";
            }
            
            break;

        case E_USER_NOTICE:
            echo "<b>NOTICE</b> [$errorType] $errorString<br /> \n";
            break;

        case E_NOTICE:
            echo "<b>NOTICE</b> [$errorType] $errorString<br /> \n";
            break;

        default:
            echo "Unknown error type: [$errorType] $errorString<br /> \n";
            echo "On line $errorLine in file $errorFile,<br /> \n ";
            break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }
} 

?>