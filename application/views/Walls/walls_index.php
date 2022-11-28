<!DOCTYPE html>
<html>
    <head>
        <title>The Wall</title>
        <link rel="stylesheet" type="text/css" href="/assets/styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/assets/styles/walls_index.css" />
        <script type="text/javascript" src="/assets/JS/jquery-3.6.1.js"></script> 
        <script type="text/javascript">
            $(document).ready(function(){
                $(".edit_button").click(function(){
                    let current_text = $(this).parent(".message, .comment").children("p").text();
                    $(this).parent(".message, .comment").children("p").hide();
                    $(this).siblings("div").children(".edit_form").children("textarea").val(current_text);
                    $(this).siblings().children(".edit_form").show();
                    $(this).siblings().children(".cancel_button").show();
                    $(this).siblings(".delete_form").hide();
                    $(this).hide();
                });
                $(".cancel_button").click(function(){
                    $(this).siblings(".edit_form").hide();
                    $(this).parent().parent().children("p").show();        
                    $(this).parent().parent().parent().siblings(".edit_button").show();
                    $(this).parent().siblings(".edit_button").show();
                    $(this).parent().siblings(".delete_form").show();
                    $(this).hide();
                });
            });
        </script>        
    </head>
    <body>
        <div id="wrapper">
            <header>
                <h1>CodingDojo Wall</h1>
                <div>
                    <h3>Welcome <?=$user_data["first_name"]?> <?=$user_data["last_name"]?></h3>
                    <a href="/Users/logoff">log off</a>
                </div>
            </header>
            <section>
                <div class="error">
                    <?=$this->session->flashdata("message_error")?>
                    <?=$this->session->flashdata("comment_error")?>
                </div>
                <h2>Post a message</h2>
                <form action="/Walls/post_message" method="POST">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <textarea name="message" placeholder="Insert Message Here"></textarea>
                    <input class="post_button" type="submit" value="Post a message" /> 
                </form>
    <?php foreach($fetched_contents as $content){ ?>
                <div class="message">
                    <h4><?=$content["first_name"]?> <?=$content["last_name"]?> - <?=date_format(date_create($content["created_at"]), "F dS Y")?></h4>
                    <p><?=$content["message"]?></p>  
<?php if($content["user_id"] === $user_data["user_id"]){ ?>
                    <div>      
                        <form class="edit_form" action="/Walls/edit_message" method="POST">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />     
                            <input type="hidden" name="message_id" value="<?=$content["message_id"]?>"/>
                            <textarea name="new_message" placeholder="Insert New message here"></textarea> 
                            <div>          
                                <input type="submit" value="Submit" />   
                            </div>                    
                        </form>
                        <button class="cancel_button">Cancel</button>  
                    </div>

                    <button class="edit_button">Edit</button>   
                    <form class="delete_form" action="/Walls/delete_message" method="POST">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                            <input type="hidden" name="message_id" value="<?=$content["message_id"]?>"/>
                            <input type="submit" value="Delete message" />
                    </form>              
<?php } ?>
    <?php foreach($content["comments"] as $comment){ ?>
                    <div class="comment">
                        <h4><?=$comment["first_name"]?> <?=$comment["last_name"]?> - <?=date_format(date_create($comment["created_at"]), "F dS Y")?></h4>
                        <p><?=$comment["comment"]?></p>
<?php if($comment["user_id"] === $user_data["user_id"]){ ?>   
                        <div>      
                            <form class="edit_form" action="/Walls/edit_comment" method="POST">
                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />     
                                <input type="hidden" name="comments_id" value="<?=$comment["comments_id"]?>"/>
                                <textarea name="new_comment" placeholder="Insert New message here"></textarea> 
                                <div>          
                                    <input type="submit" value="Submit" />   
                                </div>                    
                            </form>
                            <button class="cancel_button">Cancel</button>  
                        </div>
                        <button class="edit_button">Edit</button>  
                        <form class="delete_form" action="/Walls/delete_comment" method="POST">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                            <input type="hidden" name="comment_id" value="<?=$comment["comments_id"]?>"/>
                            <input type="submit" value="Delete Comment" />
                        </form>
<?php } ?>                        
                    </div>
    <?php } ?>
                    <div class="inside_comment">
                        <h3>Post a Comment</h3>
                        <form action="/Walls/post_comment" method="POST">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />                    
                            <input type="hidden" name="message_id" value="<?=$content["message_id"]?>" />
                            <textarea name="comment_box" placeholder="Insert Comment Here"></textarea>
                            <input class="post_button" type="submit" value="Post a comment" />
                        </form>
                    </div>
                </div>
    <?php } ?>           
            </section>
        </div>
    </body>
</html>