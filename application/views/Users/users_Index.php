<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The Wall</title>
        <link rel="stylesheet" type="text/css" href="/assets/styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/assets/styles/users_index.css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="login">
                <h1>Login</h1>
                <div id="errors">
                    <?=$this->session->flashdata($login_errors)?>
                </div>
                <form action="/Users/login" method="POST">                    
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <label>Email</label>
                    <input type="email" name="email"  value="" placeholder="Type here" />
                    <label>Password</label>
                    <input type="password" name="password" value="" placeholder="Type here" />
                    <input type="submit" value="login" />
                </form>
                <a href="/Users/register">Need an account? Click here to register</a>
            </div>
        </div>
    </body>
</html>