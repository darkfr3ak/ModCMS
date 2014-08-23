<?php
if(defined("DEBUG_MODE") && DEBUG_MODE == 1){
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
                  <!--<li><a>Link1<span class="sub_icon glyphicon glyphicon-link"></span></a></li>
                  <li><a>link2<span class="sub_icon glyphicon glyphicon-link"></span></a></li>-->
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
                                <?php echo $this->appOutput(); ?>
                            </div>
                            <div class="col-md-2"><br>
                                <?php $this->widgetOutput('sidebarRight');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                if(defined("DEBUG_MODE") && DEBUG_MODE == 1){
                    $timer->stop();
                    echo " This page took ".$timer->retrieve()." milliseconds to load.";
                }
                ?>
            
        </div>
        <div class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <p class="navbar-text pull-left">© 2014 - Site Built By darkfr3ak | 
                    <!--<a href="http://html5.validator.nu/?doc=http%3A%2F%2Fdarkfr3ak.pf-control.de%2F" target="_blank">HTML 5 Validation</a>-->
                    <a href="http://html5.validator.nu/?doc=http%3A%2F%2Fdarkfr3ak.pf-control.de%2F" target="_blank">
                        <img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png" height="32" alt="HTML5 Powered with CSS3 / Styling, and Semantics" title="HTML5 Powered with CSS3 / Styling, and Semantics">
                    </a>
                </p>
            </div>
        </div>    
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/jquery-1.11.0.min.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/bootstrap.min.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/bootstrap-datepicker.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/jquery-ui-1.10.4.custom.js"></script>
        <script src="<?php echo $this->getCurrentApp();?>js/script.js"></script>
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("active");
            });
            $('.input-daterange').datepicker({
                todayBtn: "linked",
                language: "de",
                todayHighlight: true
            });
            $(document).ready(function(){ 
                $(function() {
                    $('.draggable-list').sortable({
                        connectWith: '.draggable-list',
                        update: function (event, ui) {
                            var data = "wid=>" + $(this).sortable('toArray').toString() + "|pos=>" + this.id + ";";
                            if(this.id != "avail_list"){
                                $('#qrystr').val($('#qrystr').val() + data);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>
