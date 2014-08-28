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
 * Description of Template
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class TemplateBase extends Base{
    
    //All CMS template management related functions will be here.
    public $templateName = 'default';    //by default template would be "default" template
    public $siteSettings = array();


    //put your code here
    public function __construct() {
        $this->getSiteSettings();
    }
    
    public function show($file = "index.php"){
        require_once($this->getCurrentTemplatePath().$file);
    }
    
    public function getCurrentTemplatePath(){
        return 'themes/'.$this->templateName.'/';
    }
    
    //this will set template which we want to use    
    public function setTemplate($templateName){
        $this->templateName = $templateName;
    }
    
    public function appOutput(){
	$appname = (isset($_REQUEST['app'])) ? $_REQUEST['app'] : 'default';
        $file = 'apps/'.$appname.'/'.ucfirst($appname).'.app.php';
        if(file_exists($file)){
            require_once($file);
            $application = ucfirst($appname).'App';
            $app = new $application();
            $app->run();
        }else{
            trigger_error("App not found: ".ucfirst($appname), E_USER_ERROR);
        }
    }
}
