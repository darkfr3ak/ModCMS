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
 * Description of Hello
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class UserInfo extends WidgetsBase{

    //put your code here
    public function __construct() {
        
    }
    
    public function display() {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                if(isset($_SESSION['user_name'])){
                    echo "Hello ".$_SESSION['user_name'];
                }
                ?>
            </div>
            <div class="panel-body">
                userinfo :P
            </div>
        </div>
        <hr>
        <?php
    }

}
