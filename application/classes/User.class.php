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
 * Description of User
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class User extends Base{
    
    public $user_id = 0;
    public $user_name = "";
    public $user_email = "";
    private $db = "";
    private $user_acl;

    //put your code here
    public function __construct($user_id) {
        $this->user_id = $user_id;
        $this->db = $this->getDbo();
        $this->user_acl = new ACL($user_id);
        $this->getData();
    }
    
    public function hasAccess($area = "") {
        if($this->user_acl->hasPermission($area)){
            return true;
        }
        return false;
    }
    
    private function getData() {
        $sql = sprintf("SELECT user_name, user_email FROM `".Conf::$DB_PREFIX."core_users` WHERE user_id = '%s'", $this->user_id);
	$db = $this->getDbo();				
	$rows = $db->loadSingleResult($sql);
        $this->user_name = $rows->user_name;
        $this->user_email = $rows->user_email;
    }
    
    public function getAllUsers() {
        $sql = "SELECT user_id, user_name FROM `".Conf::$DB_PREFIX."core_users`";
        $db = $this->getDbo();				
        $users = $db->loadResult($sql);
        return $users;
    }

}
