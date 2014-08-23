<?php

/**
 * Class login
 *
 * handles the user login/logout/session
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Login extends ApplicationBase{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var string The user's name
     */
    private $user_name = "";
    /**
     * @var string The user's mail
     */
    private $user_email = "";
    /**
     * @var string The user's mail
     */
    public $user_id = 0;
    /**
     * @var string The user's password hash
     */
    private $user_password_hash = "";
    /**
     * @var boolean The user's login status
     */
    private $user_is_logged_in = false;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct(){

        // TODO: adapt the minimum check like in 0-one-file version
        $this->db_connection = $this->getDbo();

        // create/read session
        session_start();

        // check the possible login actions:
        // 1. logout (happen when user clicks logout button)
        // 2. login via session data (happens each time user opens a page on your php project AFTER he has sucessfully logged in via the login form)
        // 3. login via post data, which means simply logging in via the login form. after the user has submit his login/password successfully, his
        //    logged-in-status is written into his session data on the server. this is the typical behaviour of common login scripts.

        // if user tried to log out
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // if user has an active session on the server
        elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) {
            $this->loginWithSessionData();
        }
        // if user just submitted a login form
        elseif (isset($_POST["login"])) {
            $this->loginWithPostData();
        }
    }

    /**
     * log in with session data
     */
    private function loginWithSessionData(){
        // set logged in status to true, because we just checked for this:
        // !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
        // when we called this method (in the constructor)
        $this->user_is_logged_in = true;
        $this->messages[] = "Successfully logged in!";
    }

    /**
     * log in with post data
     */
    private function loginWithPostData(){
        // if POST data (from login form) contains non-empty user_name and non-empty user_password
        if (!empty(HTTP::$POST['user_name']) && !empty(HTTP::$POST['user_password'])) {
            
            if (empty(HTTP::$POST['user_name'])) {
                $this->errors[] = "Username field was empty.";
            } elseif (empty(HTTP::$POST['user_password'])) {
                $this->errors[] = "Password field was empty.";
            }
                // escape the POST stuff
                $this->user_name = $this->sanitize(HTTP::$POST['user_name']);
                // database query, getting all the info of the selected user
                $checklogin = $this->db_connection->loadSingleResult("SELECT user_id, user_name, user_email, user_password_hash FROM mycms_core_users WHERE user_name = '" . $this->user_name . "';");
                
                // if this user exists
                if (isset($checklogin->user_email)) {

                    // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
                    if (password_verify(HTTP::$POST['user_password'], $checklogin->user_password_hash)) {

                        // write user data into PHP SESSION [a file on your server]
                        $_SESSION['user_name'] = $checklogin->user_name;
                        $_SESSION['user_email'] = $checklogin->user_email;
                        $_SESSION['user_id'] = $checklogin->user_id;
                        $this->user_id = $checklogin->user_id;
                        $_SESSION['user_logged_in'] = 1;

                        // set the login status to true
                        $this->user_is_logged_in = true;
                        $this->securityToken();
                        $this->messages[] = "Successfully logged in!";
                    } else {
                        $this->errors[] = "Wrong username or password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
    }

    /**
     * perform the logout
     */
    public function doLogout(){
        $_SESSION = array();
        session_destroy();
        $this->user_is_logged_in = false;
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function authenticated(){
        return $this->user_is_logged_in;
    }
}
