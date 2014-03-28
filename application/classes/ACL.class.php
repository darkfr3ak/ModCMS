<?php

class ACL extends ApplicationBase{
    
    public $perms = array();    //Array : Stores the permissions for the user
    private $userID = 0;        //Integer : Stores the ID of the current user
    private $userRoles = array();    //Array : Stores the roles of the current user
    private $db;
            
    public function __construct($userID = '') {
        $this->db = $this->getDbo();
        if ($userID != '') {
            $this->userID = $userID;
        }elseif(isset ($_SESSION['user_id'])) {
            $this->userID = $_SESSION['user_id'];
        }else{
            $this->userID = 1;
        }
        $this->userRoles = $this->getUserRoles();
        $this->buildACL();
    }
    
    private function buildACL() {
        //first, get the rules for the user's role
        if (count($this->userRoles) > 0) {
            $this->perms = array_merge($this->perms, $this->getRolePerms($this->userRoles));
        }
        //then, get the individual user permissions
        $this->perms = array_merge($this->perms, $this->getUserPerms($this->userID));
    }
    
    public function getPermKeyFromID($permID) {
        $strSQL = "SELECT `permKey` FROM `".Conf::$DB_PREFIX."acl_permissions` WHERE `ID` = " . $permID . " LIMIT 1";
        $row = $this->db->loadSingleResult($strSQL);
        return $row->permKey;
    }
    
    public function getPermNameFromID($permID) {
        $strSQL = "SELECT `permName` FROM `".Conf::$DB_PREFIX."acl_permissions` WHERE `ID` = '" . $permID . "' LIMIT 1";
        $row = $this->db->loadSingleResult($strSQL);
        return $row->permName;
    }
    
    public function getRoleNameFromID($roleID) {
        $strSQL = "SELECT `roleName` FROM `".Conf::$DB_PREFIX."acl_roles` WHERE `ID` = '" . $roleID . "' LIMIT 1";
        $row = $this->db->loadSingleResult($strSQL);
        return $row->roleName;
    }
    
    public function getUserRoles() {
        $strSQL = "SELECT * FROM `".Conf::$DB_PREFIX."acl_user_roles` WHERE `userID` = '" . $this->userID . "' ORDER BY `addDate` ASC";
        $resp = array();
        $rows = $this->db->loadResult($strSQL);
        foreach ($rows as $row) {
            $resp[] = $row->roleID;
        }
        return $resp;
    }
    
    public function getAllRoles($format = 'ids') {
        $format = strtolower($format);
        $strSQL = "SELECT * FROM `".Conf::$DB_PREFIX."acl_roles` ORDER BY `roleName` ASC";
        $resp = array();
        $rows = $this->db->loadResult($strSQL);
        foreach ($rows as $row) {
            if ($format == 'full') {
                $resp[] = array("ID" => $row->ID,"Name" => $row->roleName);
            } else {
                $resp[] = $row->ID;
            }
        }
        return $resp;
    }
    
    public function getAllPerms($format = 'ids') {
        $format = strtolower($format);
        $strSQL = "SELECT * FROM `".Conf::$DB_PREFIX."acl_permissions` ORDER BY `permName` ASC";
        $resp = array();
        $rows = $this->db->loadResult($strSQL);
        foreach ($rows as $row) {
            if ($format == 'full') {
                $resp[$row->permKey] = array('ID' => $row->ID, 'Name' => $row->permName, 'Key' => $row->permKey);
            } else {
                $resp[] = $row->ID;
            }
        }
        return $resp;
    }

    public function getRolePerms($role) {
        if (is_array($role)) {
            $roleSQL = "SELECT * FROM `".Conf::$DB_PREFIX."acl_role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
        } else {
            $roleSQL = "SELECT * FROM `".Conf::$DB_PREFIX."acl_role_perms` WHERE `roleID` = " . $role . " ORDER BY `ID` ASC";
        }
        $perms = array();
        $rows = $this->db->loadResult($roleSQL);
        foreach ($rows as $row) {
            $pK = strtolower($this->getPermKeyFromID($row->permID));
            if ($pK == '') { continue; }
            if ($row->value === '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row->permID),'ID' => $row->permID);
        }
        return $perms;
    }
    
    public function getUserPerms($userID) {
        $strSQL = "SELECT * FROM `".Conf::$DB_PREFIX."acl_user_perms` WHERE `userID` = " . $userID . " ORDER BY `addDate` ASC";
        $perms = array();
        $rows = $this->db->loadResult($strSQL);
        foreach ($rows as $row) {
            $pK = strtolower($this->getPermKeyFromID($row->permID));
            if ($pK == '') { continue; }
            if ($row->value == '1') {
                $hP = true;
            } else {
                $hP = false;
            }
            $perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row->permID),'ID' => $row->permID);
        }
        return $perms;
    }
    
    public function userHasRole($roleID) {
        foreach($this->userRoles as $k => $v) {
            if ($v === $roleID) {
                return true;
            }   
        }
        return false;
    }
    
    public function hasPermission($permKey) {
        $permKey = strtolower($permKey);
        if (array_key_exists($permKey,$this->perms)) {
            if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function getUsername($userID) {
        $strSQL = "SELECT `user_name` FROM `".Conf::$DB_PREFIX."acl_users` WHERE `user_id` = '".$userID."' LIMIT 1";
        $row = $this->db->loadSingleResult($strSQL);
        return $row->user_name;
    }
    
    public function deleteRole($roleID) {
        $strSQL = sprintf("DELETE FROM `".Conf::$DB_PREFIX."acl_roles` WHERE `ID` = %u LIMIT 1", $roleID);
        $this->db->query($strSQL);
        $strSQL = sprintf("DELETE FROM `".Conf::$DB_PREFIX."acl_user_roles` WHERE `roleID` = %u", $roleID);
        $this->db->query($strSQL);
        $strSQL = sprintf("DELETE FROM `".Conf::$DB_PREFIX."acl_role_perms` WHERE `roleID` = %u", $roleID);
        $this->db->query($strSQL);
        return true;
    }
    
    public function deleteRolePerm($param) {
        $strSQL = sprintf("DELETE FROM `".Conf::$DB_PREFIX."acl_role_perms` WHERE `roleID` = %u AND `permID` = %u", $param['roleID'], $param['permID']);
        return $this->db->query($strSQL);
    }
    
    public function updateRolePerm($param) {
        $strSQL = sprintf("REPLACE INTO `".Conf::$DB_PREFIX."acl_role_perms` SET `roleID` = %u, `permID` = %u, `value` = %u, `addDate` = '%s'", $param['roleID'], $param['permID'], $param['value'], date ("Y-m-d H:i:s"));
        return $this->db->query($strSQL);
    }
    
    public function updateRole($param) {
        $strSQL = sprintf("REPLACE INTO `".Conf::$DB_PREFIX."acl_roles` SET `ID` = %u, `roleName` = '%s'", $param['roleID'], $param['roleName']);
        return $this->db->query($strSQL);
    }
    
    public function updatePerm($param) {
        $strSQL = sprintf("REPLACE INTO `".Conf::$DB_PREFIX."acl_permissions` SET `ID` = %u, `permName` = '%s', `permKey` = '%s'", $param['permID'], $param['permName'], $param['permKey']);
        return $this->db->query($strSQL);
    }
    
    public function deletePerm($param) {
        $strSQL = sprintf("DELETE FROM `".Conf::$DB_PREFIX."acl_permissions` WHERE `ID` = %u LIMIT 1", $param);
        return $this->db->query($strSQL);
    }
}

?>