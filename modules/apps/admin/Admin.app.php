<?php
define("ADMIN_ACTIVE", "true");
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
class AdminApp extends ApplicationBase {
    
    private $task = "";
    private $app = "";
    private $login;
    private $user;
    private $userToBan = "";


    //put your code here
    public function __construct() {
        $this->app = $this->sanitize($_GET['app']);
        $this->task = $this->sanitize($_GET['task']);
        
        $this->login = new Login();
        $this->user = new User($this->login->user_id);
        
        $this->checkLogin();
    }
    
    private function checkLogin() {
        if(!$this->login->authenticated()){
            header("Location: index.php");
        }elseif(!$this->user->hasAccess("access_admin")){
            header("Location: index.php");
        }
    }
    
    private function includeFile($file = "dashboard") {
        $this->checkLogin();
        include $file.'.inc.php';
    }
    
    private function getAdminFromApps() {
        $defaultApps = array(
            "default",
            "login",
            "register",
            "user",
            "empty",
            "admin"
        );
        $i = 0;
        $localApps = $this->getAllApps();
        for ($index = 0; $index < count($localApps); $index++) {
            if(!in_array($localApps[$index]->app_name, $defaultApps)){
                $apps[$i]['name'] = $localApps[$index]->app_name;
                $apps[$i]['title'] = $localApps[$index]->app_linkText;
                $i++;
            }
        }
        
        return $apps;
    }
    
    public function display(){
        $this->includeFile();
    }
    
    public function appInstaller() {
        $this->includeFile($this->task);
    }
    
    public function users() {
        $this->includeFile($this->task);
    }
    
    public function roles() {
        $this->includeFile($this->task);
    }
    
    public function perms() {
        $this->includeFile($this->task);
    }
    
    public function widgets() {
        $this->includeFile($this->task);
    }
    
    public function banUser() {
        $this->userToBan = new User(HTTP::$GET['userID']);
        $this->includeFile($this->task);
    }
    
    public function ext() {
        $app = $this->sanitize(HTTP::$GET['man']);
        include 'modules/apps/'.$app."/admin/admin.php";
    }
    
    public function uninstall() {
        if(isset(HTTP::$GET['name'])){
            $app = $this->sanitize(HTTP::$GET['name']);
            $str = SITE_ROOT."modules/apps/".$app."/".$app.".app.xml";
            $sxml = simplexml_load_file($str);
            $tmp_data = json_decode(json_encode($sxml));
            unset($tmp_data->app->title);
            unset($tmp_data->app->install_data->sql);
            if(!$this->removeApp($tmp_data)){
                trigger_error("Couldn't remove App: ".$app, E_USER_WARNING);
            }else{
                $this->redirect("index.php?app=admin&task=appInstaller");
            }
        }else{
            trigger_error("App not found or hacking attempt!", E_USER_ERROR);
        }
    }
    
    public function install() {
        if(isset(HTTP::$GET['name'])){
            $app = $this->sanitize(HTTP::$GET['name']);
            $app_data = array();
            if($this->recursive_file_exists($app.".app.xml", SITE_ROOT."modules/apps/".$app)){
                $str = SITE_ROOT."modules/apps/".$app."/".$app.".app.xml";
                $sxml = simplexml_load_file($str);
                $app_data = json_decode(json_encode($sxml));

                if(!$this->installApp($app_data)){
                    trigger_error("Couldn't install App: ".$app, E_USER_WARNING);
                }else{
                    $this->redirect("index.php?app=admin&task=appInstaller");
                }
            }else{
                trigger_error("App not found or hacking attempt: ".$app, E_USER_ERROR);
            }
        }else{
            trigger_error("App not found or hacking attempt!", E_USER_ERROR);
        }
    }
    
    public function delete() {
        if(isset(HTTP::$GET['name'])){
            $app = $this->sanitize(HTTP::$GET['name']);
            if($this->deleteApp(SITE_ROOT."modules/apps/".$app)){
                $this->redirect("index.php?app=admin&task=appInstaller");
            }
        }
    }

}
