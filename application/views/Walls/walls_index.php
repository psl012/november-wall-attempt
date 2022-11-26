<!DOCTYPE html>
<html>
    <head>
        <title>The Wall</title>
    </head>
    <body>
        <header>
            <h1>Coding Dojo Wall</h1>
            <h3>Welcome <?=$user_data["first_name"]?></h3>
            <a href="/Users/logoff">log off</a>
        </header>
        <section>
            <h2>Post a message</h2>
            <form action="/Walls/post_message" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                <textarea name="message" placeholder="Insert Message Here"></textarea>
                <input type="submit" value="Post a message" />
            </form>
<?php foreach($fetched_contents as $content){ ?>
            <div class="message">
                <h4><?=$content["first_name"]?> <?=$content["last_name"]?> <?=date_format(date_create($content["created_at"]), "F dS y")?></h4>
                <p><?=$content["message"]?></p>
                <form action="/Walls/delete_message" method="POST">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />                    
                    <input type="hidden" name="message_id" value="<?=$content["message_id"]?>" />
                    <input type="submit" value="Delete Message" />                    
                </form>
<?php foreach($content["comments"] as $comment){ ?>
                <div class="comment">
                    <h4><?=$comment["first_name"]?> <?=$comment["last_name"]?> <?=date_format(date_create($comment["created_at"]), "F dS y")?></h4>
                    <p><?=$comment["comment"]?></p>
                </div>
                <form action="/Walls/delete_comment" method="Post">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />                    
                    <input type="hidden" name="comment_id" value="<?=$comment["comments_id"]?>" />
                    <input type="submit" value="Delete Comment" />
                </form>
<?php } ?>
                <form action="/Walls/post_comment" method="POST">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <input type="hidden" name="message_id" value="<?=$content["message_id"]?>" />
                    <textarea name="comment" placeholder="Insert Comment here"></textarea>
                    <input type="submit" value="Post a comment" />
                </form>
            </div>
<?php } ?>
        </section>
    </body>
</html>