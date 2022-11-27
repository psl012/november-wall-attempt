<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The Wall</title>
        <link rel="stylesheet" type="text/css" href="/assets/styles/normalize.css" />
        <link rel="stylesheet" type="text/css" href="/assets/styles/register.css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="register">
                <h1>Register</h1>
                    <div id="errors">
                        <?=$this->session->flashdata($register_errors)?>
                    </div>
                <form action="/Users/create_user" method="post">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <label>Email-Address</label>
                    <input type="email" name="email" value="" placeholder="Type here" />
                    <label>Password</label>
                    <input type="password" name="password" value="" placeholder="Type here" />
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" value="" placeholder="Type here" />
                    <label>First Name</label>
                    <input type="text" name="first_name" value="" placeholder="Type here"  />
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="" placeholder="Type here" />
                    <input type="submit" value="Register" />    
                </form>
                <a href="/Users/index">Already have an account? Click here to login</a>    
            </div>
        </div>
    </body>
</html>