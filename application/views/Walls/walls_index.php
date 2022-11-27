<!DOCTYPE html>
<html>
    <head>
        <title>The Wall</title>
        <link rel="stylesheet" type="text/css" href="/assets/styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/assets/styles/walls_index.css" />
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
                    <form action="/Walls/delete_message" method="POST">
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
                        <form action="/Walls/delete_comment" method="POST">
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