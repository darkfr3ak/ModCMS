<?php
if(Conf::$DEBUG_MODE == 1){
    $timer = new Timer();
    $timer->start();
}

$login = new Login();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title><?php echo $this->siteSettings['site_title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href='<?php echo $this->getCurrentTemplatePath();?>css/bootstrap.min.css' rel='stylesheet'/>
        <link href='<?php echo $this->getCurrentTemplatePath();?>css/datepicker3.css' rel='stylesheet'/>
        <link href='<?php echo $this->getCurrentTemplatePath();?>css/font-awesome.css' rel='stylesheet'/>
        <link href='<?php echo $this->getCurrentTemplatePath();?>css/default.css' rel='stylesheet'/>
        <link href='<?php echo $this->getCurrentTemplatePath();?>css/signin.css' rel='stylesheet'/>
        <link href='<?php echo $this->getCurrentApp(); ?>css/style.css' rel='stylesheet'/>
    </head>  
    <body>
        <div id="wrapper" class="">
            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul id="sidebar_menu" class="sidebar-nav">
                    <li class="sidebar-brand"><a id="menu-toggle" href="#">
                        <?php
                        if($login->authenticated()){
                            echo $_SESSION['user_name'];
                        }else{
                            echo "Menu";
                        }
                        ?>
                        <span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a>
                    </li>
                </ul>
                <ul class="sidebar-nav" id="sidebar">
                  <?php
                    $allApps = $this->getAllApps();
                    if($login->authenticated()){
                        $user = new User($login->user_id);
                        foreach ($allApps as $value) {
                            if($value->app_name == "admin"){
                                if(!$user->hasAccess("access_admin")){
                                    continue;
                                }
                            }
                            if($value->app_name == "login" || $value->app_name == "register"){
                                continue;
                            }else{
                                echo "<li><a href='".$value->app_link."'>".$value->app_linkText." <span class='sub_icon glyphicon glyphicon-".$value->app_icon."'></span></a></li>";
                            }
                        }
                        echo "<li><a href='index.php?logout'>Logout <span class='sub_icon glyphicon glyphicon-log-out'></span></a></li>";
                    }else{
                        foreach ($allApps as $value) {
                            if(!$value->app_level > 0){
                                echo "<li><a href='".$value->app_link."'>".$value->app_linkText." <span class='sub_icon glyphicon glyphicon-".$value->app_icon."'></span></a>";
                            }
                        }
                        echo "<li><a href='login.php'>Login <span class='sub_icon glyphicon glyphicon-log-in'></span></a></li>";
                        echo "<li><a href='register.php'>Register <span class='sub_icon glyphicon glyphicon-plus-sign'></span></a></li>";
                    }
                ?>
                </ul>
            </div>

            <!-- Page content -->
            <div id="page-content-wrapper">
                <!-- Keep all page content within the page-content inset div! -->
                <div class="page-content inset">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-10">
                                <!--<?php
                                if($login->authenticated()){
                                ?>
                                <nav class="navbar navbar-inverse navbar-xs" role="navigation">
                                    <div class="navbar-header">
                                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                      </button>
                                      <a class="navbar-brand" href="#"><b>User</b> Menu</a>
                                    </div>

                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                      <ul class="nav navbar-nav">
                                        <li><a href="#"><i class="glyphicon glyphicon-adjust"></i></a></li>
                                        <li><a href="#"><i class="glyphicon glyphicon-bell"></i></a></li>
                                        <li><a href="#"><i class="glyphicon glyphicon-user"></i></a></li>
                                        <li class="dropdown">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b></a>
                                          <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">One more separated link</a></li>
                                          </ul>
                                        </li>
                                      </ul>
                                    </div>
                                  </nav>
                                <?php
                                }
                                ?>-->