<?php
    class Users extends MY_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model("User");
        }
        
        public function index(){
            if($this->session->userdata(USER) === null){
                $this->load->view("Users/users_index", array("login_errors" => LOGIN_ERRORS));
            }
            else{
                redirect("/Walls/index");
            }
        }

        public function login(){
            $login_details = $this->input->post(NULL, true);
            $validate_result = $this->User->validate_login();
            if($validate_result === "valid"){
                $login_result = $this->User->login($login_details);
                if($login_result["type"] !== "valid"){
                    $this->session->set_flashdata(LOGIN_ERRORS, $login_result["content"]);
                    redirect("/Users/index");
                }
                $user = $login_result["content"];
                $this->session->set_userdata(USER, array("user_id" => $user["id"],
                                                        "first_name" => $user["first_name"],
                                                        "last_name" => $user["last_name"]
                ));
                redirect("/Walls/index");
            }
            $this->session->set_flashdata(LOGIN_ERRORS, $validate_result);
            redirect("/Users/index");           
        }

        public function logoff(){
            $this->session->unset_userdata(USER);
            redirect("Users/index");
        }

        public function register(){
            $this->load->view("Users/register", array("register_errors" => REGISTER_ERRORS));
        }

        public function create_user(){
            $user_details = $this->input->post(NULL, true);     
            $validate_result = $this->User->validate_register();
            if($validate_result === "valid"){
                $this->User->create_user($user_details);
                redirect("Users/index");     
            }
            else{
                $this->session->set_flashdata(REGISTER_ERRORS, $validate_result);                
                redirect("Users/register");
            }
        }
    }    
?>