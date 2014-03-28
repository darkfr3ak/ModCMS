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
 * Description of CMSBase
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class Base {
    
    private $stylesheets = array();
    
    public function getDbo(){
        static $dbobject = null;
        if (null === $dbobject) {
            $dbobject = new DatabasePDO();            
        }
        return $dbobject;
    }
    
    public function getAllApps() {
        $sql = "SELECT * FROM ".Conf::$DB_PREFIX."core_apps";
	$db = $this->getDbo();				
	$rows = $db->loadResult($sql);
        return $rows;
    }
    
    private static function cleanInput($input) {

        $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }
    
    public static function sanitize($input) {
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = self::sanitize($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input  = self::cleanInput($input);
            $output = self::mysql_escape_mimic($input);
        }
        return $output;
    }
    
    public static function securityToken() {
	if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = strtoupper(substr(sha1(rand(0, 9999).sha1(time())), 0, 20));
	}

	return $_SESSION['token'];
    }
    
    public static function formatDate($date = "", $withTime = false) {
        if($withTime){
            return date("d.m.Y H:m:s", strtotime($date));
        }else{
            return date("d.m.Y", strtotime($date));
        }
    }
    
    private static function mysql_escape_mimic($inp) { 
        if(is_array($inp)) 
            return array_map(__METHOD__, $inp); 

        if(!empty($inp) && is_string($inp)) { 
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
        } 

        return $inp; 
    } 
    
    public function getCurrentApp() {
        if(isset(HTTP::$GET['app']) && !isset(HTTP::$GET['man'])){
            return 'modules/mod.'.$this->sanitize(HTTP::$GET['app']).'/';
        }elseif(isset(HTTP::$GET['app']) && isset(HTTP::$GET['man'])){
            return 'modules/mod.'.$this->sanitize(HTTP::$GET['man']).'/';
        }else{
            return 'modules/mod.main/';
        }
    }
    
    public function getSiteSettings() {
        $db = $this->getDbo();
        $sql = "SELECT * FROM ".Conf::$DB_PREFIX."core_settings";
        $rows = $db->loadResult($sql);
        for ($index = 0; $index < count($rows); $index++) {
            $this->siteSettings[$rows[$index]->property] = $rows[$index]->value;
        }
        
    }
    
    public function installApp($app_data = array()) {
        $sql = "INSERT INTO ".Conf::$DB_PREFIX."core_apps VALUES
                    (NULL,
                    '".$app_data->app->app_data->app_name."',
                    '".$app_data->app->app_data->app_level."',
                    '".$app_data->app->app_data->app_author."',
                    '".$app_data->app->app_data->app_icon."',
                    '".$app_data->app->app_data->app_link."',
                    '".$app_data->app->app_data->app_linkText."',
                    '".$app_data->app->app_data->app_showInMenu."')";
        $db = $this->getDbo();				
        if($db->query($sql)){
            $this->installData($app_data);
            return true;
        }
        return false;
    }
    
    public function removeApp($app_data = array()) {
        $sql = "DELETE FROM ".Conf::$DB_PREFIX."core_apps WHERE app_name = '".$app_data->app->app_data->app_name."'";
        $db = $this->getDbo();				
        if($db->query($sql)){
            $tables = $app_data->app->install_data->tables;
            if(isset($tables)){
                $tmp = explode("|", $tables);
                foreach ($tmp as $value) {
                    $sqlDelTable = "DROP TABLE IF EXISTS `".$value."`;";
                    $db->query($sqlDelTable);
                }
            }
            return true;
        }
    }
    
    private function installData($data = array()) {
        $db = $this->getDbo();
        
        if(isset($data->app->install_data->sql)){
            $sql = $data->app->install_data->sql;
            if($db->query($sql)){
                return true;
            }
        }else{
            return true;
        }
    }

    public function getLocalApps($directory = "modules") {
        if ($handle = opendir($directory)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $files[$entry]["dir"] = $entry;
                    if($this->isAppInstalled($entry)){
                        $files[$entry]["installed"] = "true";
                    }else{
                        $files[$entry]["installed"] = "false";
                    }
                }
            }
            closedir($handle);
        }
        return $files;
    }
    
    /*
    * @Search recursively for a file in a given directory
    *
    * @param string $filename The file to find
    *
    * @param string $directory The directory to search
    *
    * @return bool
    *
    */
    public function recursive_file_exists($filename, $directory){
       try{
           /*** loop through the files in directory ***/
           foreach(new recursiveIteratorIterator( new recursiveDirectoryIterator($directory)) as $file){
               /*** if the file is found ***/
               if( $directory.DS.$filename == $file ){
                   return true;
               }
           }
           /*** if the file is not found ***/
           return false;
       }
       catch(Exception $e){
           /*** if the directory does not exist or the directory
               or a sub directory does not have sufficent
               permissions return false ***/
           return false;
       }
    }
   
    private function isAppInstalled($app_name = "") {
        $installedApps = $this->getAllApps();
        for ($index = 0; $index < count($installedApps); $index++) {
            if($app_name == $installedApps[$index]->app_name){
                return true;
            }
        }
        return false;
    }
    
    public function deleteApp($path){
        if (is_dir($path) === true){
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($files as $file){
                if (in_array($file->getBasename(), array('.', '..')) !== true){
                    if ($file->isDir() === true){
                        rmdir($file->getPathName());
                    }else if (($file->isFile() === true) || ($file->isLink() === true)){
                        unlink($file->getPathname());
                    }
                }
            }

            return rmdir($path);
        }else if ((is_file($path) === true) || (is_link($path) === true)){
            return unlink($path);
        }

        return false;
    }
    
    public function getActiveWidgets() {
        $db = $this->getDbo();
        $sql = "SELECT ".Conf::$DB_PREFIX."widgets_active.active_position, ".Conf::$DB_PREFIX."widgets_all.widget_name FROM ".Conf::$DB_PREFIX."widgets_active, ".Conf::$DB_PREFIX."widgets_all WHERE ".Conf::$DB_PREFIX."widgets_active.active_widget = ".Conf::$DB_PREFIX."widgets_all.widget_id;";
        $rows = $db->loadResult($sql); 
        return $rows;
    }
    
    public function setActiveWidget($param) {
        $sql = "INSERT INTO ".Conf::$DB_PREFIX."widgets_active VALUES('$title','$desc')";
	$db = $this->getDbo();				
	if($db->query($sql)){
            return true;
        }
        return false;
    }
    
    public function getWigdets() {
        $db = $this->getDbo();
        $sql = "SELECT * FROM ".Conf::$DB_PREFIX."widgets_all";
        $rows = $db->loadResult($sql);
        return $rows; 
    }
    
    public function getWigdetPositions() {
        $db = $this->getDbo();
        $sql = "SELECT * FROM ".Conf::$DB_PREFIX."widgets_positions";
        $rows = $db->loadResult($sql);
        return $rows; 
    }
    
    public function widgetOutput($position='default'){
        if(!empty($this->widgetPositions[$position])){
            //if there is any widget present at given position
            $widgets=$this->widgetPositions[$position];//gets all widgets in given position
            foreach($widgets as $widgetObject){
                $widgetName = $widgetObject->name;
                $widgetParameters = $widgetObject->parameters;
                $file = 'modules/com.'.$widgetName.'/'.ucfirst($widgetName).'.widget.php';
                if(file_exists($file)){
                    require_once($file);
                    $widgetclass = ucfirst($widgetName);
                    $widget = new $widgetclass();
                    $widget->run($widgetName,$widgetParameters);
                }else{
                    trigger_error("Widget not found: ".ucfirst($widgetName), E_USER_ERROR);
                }
            }
        }
    }
    
    public function setWidget($position,$widgetName,$params = array()){
        $widget = new StdClass;
        $widget->name = $widgetName;
        $widget->parameters = $params;
        //if there is no widget in position then create a new array
        if(empty($this->widgetPositions[$position])) {
            $this->widgetPositions[$position] = array($widget);
        }else{
            //if there is already a widget present in that position then just push new widget in array
            array_push($this->widgetPositions[$position],$widget);
        }        
    }
}
