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
 * Description of databaseMySql
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
/*
 * Deprecated
 * 
class DatabaseMySql {
    
    private $dbname     = 'mycmsdb';
    private $dbuser     = 'root';
    private $dbpass     = 'root';
    private $dbserver   = 'localhost';
    private $con;   //this variable stores the connection to db
    
    function set_config($server,$db,$user,$pass){
        $this->dbserver = $server;
        $this->dbname = $db;
        $this->dbuser = $user;
        $this->dbpass = $pass;
    }
    
    private function connect(){
        $this->con = mysql_connect($this->dbserver,$this->dbuser,$this->dbpass);//data server connection
        mysql_select_db($this->dbname,$this->con);
        if (!$this->con){
            die('Could not connect: ' . mysql_error());
        }
    }

    private function disconnect(){
        mysql_close($this->con);
    }
    
    public function query($sql){			
	$this->connect();
	$res = mysql_query($sql);
	$this->disconnect();
	return $res;
    }
    
    public function loadResult($sql){
	$this->connect();
	$sth = mysql_query($sql);
	$rows = array();
	while($r = mysql_fetch_object($sth)) {
            $rows[] = $r;
	}
	$this->disconnect();
	return $rows;
    }
    
    public function loadSingleResult($sql){
	$this->connect();
	$sth = mysql_query($sql);
	$row = mysql_fetch_object($sth);		
	$this->disconnect();
	return $row;
    }
}
*/