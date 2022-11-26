<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The Wall</title>
        <link rel="stylesheet" type="text/css" href="/assets/styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/assets/styles/register.css" />
    </head>
    <body>
        <h1>Register</h1>
        <div>
            <?=$this->session->flashdata($register_errors)?>
        </div>
        <form action="/Users/create_user" method="post">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
            <input type="email" name="email" value="test@yahoo.com" placeholder="(Email)" />
            <input type="password" name="password" value="123" placeholder="(Password)" />
            <input type="password" name="confirm_password" value="123" placeholder="(Confirm Password)" />
            <input type="text" name="first_name" value="Test" placeholder="(First Name)"  />
            <input type="text" name="last_name" value="Daman" placeholder="(Last Name)" />
            <input type="submit" value="Register" />    
        </form>
        <a href="/Users/index">Already have an account? Click here to login</a>
    </body>
</html>