<?php
    class Wall extends CI_Model{
        public function get_all_message(){
            $query = "SELECT messages.id as message_id, user_id, message, messages.created_at,
                        first_name, last_name 
                        FROM messages 
                        INNER JOIN users ON messages.user_id = users.id
                        ORDER BY messages.created_at DESC";
            
            return $this->db->query($query)->result_array();
        }

        public function get_all_comments(){
            $query = "SELECT comments.id as comments_id, message_id, user_id, comment, comments.created_at,
                        first_name, last_name 
                        FROM comments
                        INNER JOIN users ON comments.user_id = users.id
                        ORDER BY comments.created_at ASC";

            return $this->db->query($query)->result_array();
        }

        public function create_message($user, $message_details){
            $query = "INSERT INTO messages(user_id, message, created_at, updated_at)
                        VALUES(?,?,?,?)";
            $values = array($this->security->xss_clean($user["user_id"]),
                            $this->security->xss_clean($message_details["message"]),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")));
            
            return $this->db->query($query, $values);
        }

        public function delete_message($user, $message_id){
            $query = "SELECT * FROM messages where id = ?";
            $values = array($this->security->xss_clean($message_id));
            $message = $this->db->query($query, $values)->row_array();
            if($message["user_id"] !== $user["user_id"]){
                return;
            }
            
            // Delete all subcomments
            $query = "DELETE FROM comments WHERE message_id = ?";
            $this->db->query($query, $values);

            // Delete the message
            $query = "DELETE FROM messages WHERE id = ?";
            return $this->db->query($query, $values);        
        }

        public function edit_message($user, $message_details){
            // Security Server side
            $query = "SELECT * FROM messages where id = ?";
            $values = array($this->security->xss_clean($message_details["message_id"]));
            $message = $this->db->query($query, $values)->row_array();
            if($message["user_id"] !== $user["user_id"]){
                return;
            }

            $query = "UPDATE messages
                        SET message = ?, updated_at = ?
                        WHERE id = ?";

            $values = array($this->security->xss_clean($message_details["new_message"]), 
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean($message_details["message_id"]));

            return $this->db->query($query, $values);
        }

        public function create_comments($user, $comment_details){
            $query = "INSERT INTO comments(message_id, user_id, comment, created_at, updated_at)
                        VALUES(?,?,?,?,?)";
            $values = array($this->security->xss_clean($comment_details["message_id"]),
                            $this->security->xss_clean($user["user_id"]),
                            $this->security->xss_clean($comment_details["comment_box"]),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean(date("Y-m-d, H:i:s")));
            
            return $this->db->query($query, $values);
        }

        public function edit_comment($user, $comment_details){
            // Security Server side
            $query = "SELECT * FROM comments where id = ?";
            $values = array($this->security->xss_clean($comment_details["comments_id"]));
            $message = $this->db->query($query, $values)->row_array();
            if($message["user_id"] !== $user["user_id"]){
                return;
            }

            $query = "UPDATE comments
                        SET comment = ?, updated_at = ?
                        WHERE id = ?";

            $values = array($this->security->xss_clean($comment_details["new_comment"]), 
                            $this->security->xss_clean(date("Y-m-d, H:i:s")),
                            $this->security->xss_clean($comment_details["comments_id"]));

            return $this->db->query($query, $values);
        }

        public function delete_comments($user, $comment_id){
            $query = "SELECT * FROM comments WHERE id = ?";
            $values = array($this->security->xss_clean($comment_id));
            $comment = $this->db->query($query, $values)->row_array();
            
            // Check if user DOES NOT own the comment
            if($comment["user_id"] !== $user["user_id"]){
                return;
            }
            $query = "DELETE FROM comments WHERE id = ?";
            return $this->db->query($query, $values);
        }

        public function organized_content(){
            // This will organize messages and comments to make them easier to foreach loop on the view file
            $fetched_messages = $this->get_all_message();
            $fetched_comments = $this->get_all_comments();
            $organized_comments = array();
            foreach($fetched_comments as $comment){
                $organized_comments[$comment["message_id"]][] = $comment;
            }
            $organized_contents = $fetched_messages;
            foreach($organized_contents as $key => $message){
                if(isset($organized_comments[$message["message_id"]])){
                    $organized_contents[$key]["comments"] = $organized_comments[$message["message_id"]];
                }
                else{
                    $organized_contents[$key]["comments"] = [];
                }
            }

            return $organized_contents;
        }
    }
?>