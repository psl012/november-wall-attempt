<?php
    class MY_Controller extends CI_Controller{
        public function __construct(){
            parent::__construct();
            define("USER", "user");
            define("REGISTER_ERRORS", "register_errors");
            define("LOGIN_ERRORS", "login_errors");
        }
    }
?>