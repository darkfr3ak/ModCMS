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
 * Description of Application
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class ApplicationBase extends Base{

    //put your code here
    public function __construct() {
        echo 'this is base constructor';
    }
    
    public function run(){
        $method = (isset($_REQUEST['task'])) ? $_REQUEST['task'] : 'display';
        $this->$method();
    }
    
    public function display(){
	echo 'this is base display';
    }
    
    protected function redirect($url = null, $msg = null){
	if(empty($url)){
            header('Location:index.php');
            exit(0);
	}else{
            header('Location:'.$url);
            exit(0);
	}
    }

}
