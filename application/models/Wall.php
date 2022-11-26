<?php
    class Wall extends CI_Model{
        public function get_all_messages(){
            $query = "SELECT messages.id as message_id, user_id, message, first_name, last_name, messages.created_at 
                        FROM messages 
                        INNER JOIN users ON messages.user_id = users.id 
                        ORDER BY created_at DESC";
            return $this->db->query($query)->result_array();
        }

        public function get_all_comments(){
            $query = "SELECT comments.id as comments_id, user_id, message_id, comment, comments.created_at, 
                        first_name, last_name 
                        FROM comments 
                        INNER JOIN users ON comments.user_id = users.id
                        ORDER BY created_at ASC";

            return $this->db->query($query)->result_array();
        }

        public function create_message($user, $message_details){
            $query = "INSERT INTO messages(user_id, message, created_at, updated_at)
                        VALUES(?,?,?,?)";
            $values = array($this->security->xss_clean($user["user_id"]),
                            $this->security->xss_clean($message_details["message"]),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean(date("Y-m-d, H:i:s"))
            );

            $this->db->query($query, $values);
        }

        public function create_comment($user, $comment_details){
            $query = "INSERT INTO comments(message_id, user_id, comment, created_at, updated_at)
                        VALUES(?,?,?,?,?)";
            $values = array($this->security->xss_clean($comment_details["message_id"]),    
                            $this->security->xss_clean($user["user_id"]),
                            $this->security->xss_clean($comment_details["comment"]),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean(date("Y-m-d, H:i:s"))
            );

            $this->db->query($query, $values);            
        }

        public function delete_message($user, $message_id){
            $query = "SELECT * FROM messages WHERE id = ?";
            $values = array($this->security->xss_clean($message_id));
            $message = $this->db->query($query, $values)->row_array();
            if($message["user_id"] !== $user["user_id"]){
                return;
            }
            else{
                $query = "DELETE FROM comments WHERE message_id = ?";
                $sub_values = array($this->security->xss_clean($message_id));
                $this->db->query($query, $sub_values);

                $query = "DELETE FROM messages WHERE id =?";
                $this->db->query($query, $values);
                return;
            }
        }

        public function delete_comment($user, $comment_id){
            $query = "SELECT * FROM comments WHERE id = ?";
            $values = array($this->security->xss_clean($comment_id));
            $comment = $this->db->query($query, $values)->row_array();
            if($comment["user_id"] !== $user["user_id"]){
                return;
            }
            else{
                $query = "DELETE FROM comments WHERE id = ?";
                return $this->db->query($query, $values);
            }
        }

        public function organize_content(){
            $content = $this->get_all_messages();
            $comments = $this->get_all_comments();
            $organized_comments = [];
            foreach($comments as $comment){
                $organized_comments[$comment["message_id"]][] = $comment;
            }

            foreach($content as $key => $message){
                if(!isset($organized_comments[$message["message_id"]])){
                    $content[$key]["comments"] = [];
                }
                else{
                    $content[$key]["comments"] = $organized_comments[$message["message_id"]];
                }
            }

            return $content;
        }
    }
?>