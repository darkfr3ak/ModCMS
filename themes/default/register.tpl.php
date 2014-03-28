<?php
include 'header.inc.php';
?>
<h1 class="page-header">Register</h1>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="post" action="register.php" name="registerform">   
            <div class="form-group">
                <!-- the user name input field uses a HTML5 pattern check -->
                <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
                <input id="login_input_username" class="form-control" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
            </div>
            <div class="form-group">
                <!-- the email input field uses a HTML5 email type check -->
                <label for="login_input_email">Your email</label>    
                <input id="login_input_email" class="form-control" type="email" name="user_email" required />        
            </div>
            <div class="form-group">
                <label for="login_input_password_new">Password (min. 6 characters)</label>
                <input id="login_input_password_new" class="form-control" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />  
            </div>
            <div class="form-group">
                <label for="login_input_password_repeat">Repeat password</label>
                <input id="login_input_password_repeat" class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />        
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="register" value="Register" >Register</button>
            <a href="login.php" class="btn btn-primary btn-block">Back to Login Page</a>
        </form>

        <!-- backlink -->
        
    </div>
    <div class="col-md-3"></div>
</div>

<?php
include 'footer.inc.php';
?>