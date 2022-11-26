<?php
    class User extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->library("form_validation");
        }

        public function get_one_user($email){
            $query = "SELECT * FROM users WHERE email = ?";
            $values = array($this->security->xss_clean($email));

            return $this->db->query($query, $values)->row_array();
        }

        public function create_user($user_details){
            $encrypted_password = md5($this->security->xss_clean($user_details["password"]));

            $query = "INSERT INTO users(email, password, first_name, last_name, created_at, updated_at)
                        VALUES(?,?,?,?,?,?)";
            $values = array($this->security->xss_clean($user_details["email"]),
                            $encrypted_password,
                            $this->security->xss_clean($user_details["first_name"]),
                            $this->security->xss_clean($user_details["last_name"]),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean(date("Y-m-d, H:i:s"))
            );

            return $this->db->query($query, $values);
        }

        public function login($user_details){
            $user = $this->get_one_user($user_details["email"]);
            if($user === null){
                return array("type" => "invalid", "content" => "<p>Invalid Email</p>");
            }
            $encrypted_password = md5($user_details["password"]);
            if($encrypted_password !== $user["password"]){
                return array("type" => "invalid", "content" => "<p>Invalid Password</p>");
            }

            return array("type" => "valid", "content" => $user);
        }

        public function validate_login(){
            $this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
            $this->form_validation->set_rules("password", "Password", "trim|required");
            if($this->form_validation->run()){
                return "valid";
            }

            return validation_errors();
        }

        public function validate_register(){
            $this->form_validation->set_rules("email", "Email", "trim|required|valid_email|is_unique[users.email]");
            $this->form_validation->set_rules("password", "Password", "trim|required|matches[confirm_password]");
            $this->form_validation->set_rules("confirm_password", "Confirm Password", "trim|required");
            $this->form_validation->set_rules("first_name", "First Name", "trim|required");
            $this->form_validation->set_rules("last_name", "Last Name", "trim|required");
            if($this->form_validation->run()){
                return "valid";
            }

            return validation_errors();
        }
    }
?>