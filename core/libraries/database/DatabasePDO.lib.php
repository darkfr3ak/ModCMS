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
 * Description of DatabasePDO
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class DatabasePDO {
    
    private $_dbname     = 'database';
    private $_dbuser     = 'username';
    private $_dbpass     = 'password';
    private $_dbserver   = 'localhost';
    private $_db;   //this variable stores the connection to db
    
    public $tables = array();
    
    public function set_config($server, $db, $user, $pass){
        $this->_dbserver = $server;
        $this->_dbname = $db;
        $this->_dbuser = $user;
        $this->_dbpass = $pass;
    }
    
    private function connect(){
        try {
            $this->_db = new PDO("mysql:dbname=".$this->_dbname.";host=".$this->_dbserver, $this->_dbuser, $this->_dbpass);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $ex) {
            trigger_error($ex->getMessage(), E_USER_ERROR);
        }
    }
    
    public function query($sql){			
	$this->connect();
        $this->tables = $this->getDBTables();
        $query = $this->_db->prepare($sql);
        try {
            $query->execute();
            return $query->rowCount();
        } catch (PDOException $ex) {
            trigger_error($ex->getMessage(), E_USER_ERROR);
        }
    }
    
    public function loadResult($sql){
	$this->connect();
        $query = $this->_db->prepare($sql);
        try {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            trigger_error($ex->getMessage(), E_USER_ERROR);
        }
    }
    
    public function loadSingleResult($sql){
	$this->connect();
        $query = $this->_db->prepare($sql);
        try {
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            trigger_error($ex->getMessage(), E_USER_ERROR);
        }
    }
    
    public function getDBTables() {
        $this->connect();
        $sql = "SHOW TABLES;";
        $query = $this->_db->prepare($sql);
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            while (list($key, $value) = each($result)){
                $this->tables[] = $value['Tables_in_mycmsdb'];
            }
            return $this->tables;
        } catch (PDOException $ex) {
            trigger_error($ex->getMessage(), E_USER_ERROR);
        }
    }
    
    public function __construct() {
        $this->tables = $this->getDBTables();
    }

}
