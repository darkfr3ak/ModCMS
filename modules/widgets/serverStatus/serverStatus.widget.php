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
 * Description of sidebarNav
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class serverStatus extends WidgetsBase{

    //put your code here
    public function __construct() {
        
    }
    
    public function display() {
        echo '<div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Server-Status</h3>
                </div>
                <div class="panel-body">';
                $serverIP = "185.5.174.133";
                $ip = gethostbyname($serverIP);
                $ports = array(13363, 13002, 16002);
                $names = array("Auth", "CH 1", "CH 2");
                for ($i = 0; $i < count($ports); $i++) {
                    echo $names[$i].": ";
                    $online = @fsockopen($ip, $ports[$i], $errno, $errstr, 1);
                    if (!$online){
                        echo "OFF<br>";
                    }else{
                        echo "ON<br>";
                    }
                    @fclose($online);
                }
        echo '</div>
            </div>';
    }
}
