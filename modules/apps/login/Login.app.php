<?php

/*
 * Copyright (C) 2014 darkfr3ak <info at darkfr3ak.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


/**
 * Description of Default
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class LoginApp extends ApplicationBase {
    //put your code here
    public function __construct() {
    }
    
    function display(){
        $this->showLoginForm();
    }
    
    public function showLoginForm() {
        echo '<div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title">Login</h1>
                <div class="account-wall">
                    <img class="profile-img" src="'.$this->getCurrentApp().'img/photo.png" alt="">
                    <form class="form-signin" action="login.php" method="post" role="form" name="loginform">
                    <input type="text" id="login_input_username" name="user_name" class="form-control" placeholder="Your Username" required autofocus>
                    <input type="password" name="user_password" id="login_input_password" class="form-control" placeholder="Your Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
                    <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                    </form>
                </div>
                <a href="index.php?app=register" class="text-center new-account">Register here</a>
            </div>
        </div>';
    }
    

}
