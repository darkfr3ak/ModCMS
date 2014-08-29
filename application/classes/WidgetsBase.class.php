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
 * Description of Widgets
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class WidgetsBase extends Base{
    
    private $widgetPath = '';
    public $widgetName = '';
    public $parameters = array();
    
    public function setWidgetPath($widgetName){
        //here will be logic to set path to widget file which is extending CmsWidget class.
        $this->widgetPath = 'modules/widgets/'.$widgetName.'/';
        $this->widgetName = $widgetName;
    }
    
    public function getWidgetPath(){
        return $this->widgetPath;
    }
    
    public function display(){
        echo 'this will be default output of widget if this function is not overrided by derived class';
    }
    
    public function run($widgetName, $params){
        // this function will be called by template function class to display widget
        $this->parameters = $params;
        $this->setWidgetPath($widgetName);
        $this->display();
    }

}
