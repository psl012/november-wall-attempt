<?php
    class Walls extends MY_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->model("Wall");
        }

        public function index(){
            $organized_contents = $this->Wall->organize_content();
            $user_data = $this->session->userdata(USER);
            $this->load->view("Walls/walls_index", array("user_data" => $user_data,
                                                        "fetched_contents" => $organized_contents));
        }

        public function post_message(){
            $message_details = $this->input->post(NULL, true);
            $this->Wall->create_message($this->session->userdata(USER), $message_details);
            redirect("/Walls/index");
        }

        public function delete_message(){
            $message_details = $this->input->post(NULL, true);
            $this->Wall->delete_message($this->session->userdata(USER), $message_details["message_id"]);
            redirect("/Walls/index");
        }

        public function post_comment(){
            $comment_details = $this->input->post(NULL, true);
            $this->Wall->create_comment($this->session->userdata(USER), $comment_details);
            redirect("/Walls/index");
        }

        public function delete_comment(){
            $comment_details = $this->input->post(NULL, true);
            $this->Wall->delete_comment($this->session->userdata(USER), $comment_details["comment_id"]);
            redirect("/Walls/index");
        }
    }
?>