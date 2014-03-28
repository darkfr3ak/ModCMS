<?php
include 'header.inc.php';
$login = new Login();
if ($login->messages) {
    foreach ($login->messages as $message) {
        echo $message;    
    }
    header('Location: index.php');
}
?>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">Login</h1>
                <?php
                if ($login->errors) {
                    foreach ($login->errors as $error) {
                        echo '<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Error!</strong> '.$error.'</div>';    
                    }
                }
                ?>
                <div class="account-wall">
                    <img class="profile-img" src="assets/img/photo.png" alt="">
                    <form class="form-signin" action="" method="post" role="form" name="loginform">
                        <input type="text" id="login_input_username" name="user_name" class="form-control" placeholder="Your Username" required autofocus>
                        <input type="password" name="user_password" id="login_input_password" class="form-control" placeholder="Your Password" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
                        <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                    </form>
                </div>
                <a href="index.php?app=register" class="text-center new-account">Register here</a>
            </div>
        </div>
<?php
include 'footer.inc.php';
?>