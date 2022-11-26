<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The Wall</title>
        <link rel="stylesheet" type="text/css" href="/assets/styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/assets/styles/user_index.css" />
    </head>
    <body>
        <h1>Login</h1>
        <div>
            <?=$this->session->flashdata($login_errors)?>
        </div>
        <form action="/Users/login" method="POST">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
            <input type="email" name="email"  value="" placeholder="(Email)" />
            <input type="password" name="password" value="" placeholder="(Password)" />
            <input type="submit" value="login" />
        </form>
        <a href="/Users/register">Need an account? Click here to register</a>
    </body>
</html>