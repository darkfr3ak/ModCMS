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
 * Description of Default
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class DownloadApp extends ApplicationBase {
    
    private $db;
    
    public function __construct() {
        $this->db = $this->getDbo();
    }
    
    function display(){
        $this->includeFile();
    }
    
    private function includeFile($file = "dashboard") {
        include $file.'.inc.php';
    }
    
    private function getFiles($cat = "all") {
        if(!$this->sanitize($cat) == "all"){
            $sql = sprintf("SELECT * FROM mycms_download_files WHERE file_cat ='%s' LIMIT 1", $this->sanitize($cat));
        }else{
            $sql = "SELECT * FROM mycms_download_files";
        }
        return $this->db->loadResult($sql);
    }
    
    public function getFile($id = 0) {
        $sql = sprintf("SELECT * FROM mycms_download_files WHERE file_id = '%u';", $this->sanitize($id));
        return $this->db->loadSingleResult($sql);
    }
    
    public function add(){
        if(isset($_SESSION['user_id'])){
            $user = $_SESSION['user_id'];
        }else{
            $user = 0;
        }
        if(count($this->checkBasket($this->sanitize(HTTP::$GET['id']), $user)) == 0){
            $sql1 = "INSERT INTO mycms_download_cart(cart_fileID, cart_userID) VALUES (".$this->sanitize(HTTP::$GET['id']).", ".$user.")";
            $this->db->query($sql1);
        }
        $this->includeFile("cart");
    }
    
    private function checkBasket($file = "", $user = 0) {
        $sql = "SELECT * FROM mycms_download_cart WHERE cart_fileID = '".$file."' AND cart_userID = '".$user."'";
        return $this->db->loadResult($sql);
    }


    public function loadBasket($user = 0) {
        $sql = "SELECT * FROM mycms_download_cart WHERE cart_userID = '".$user."';";
        return $this->db->loadResult($sql);
    }
    
    public function showCart() {
        $this->includeFile("cart");
    }
    
    public function remove() {
        if(isset(HTTP::$GET['id'])){
            $sql1 = "DELETE FROM mycms_download_cart WHERE cart_fileID = '".$this->sanitize(HTTP::$GET['id'])."'";
            $this->db->query($sql1);
            $this->includeFile("cart");
        }
    }
    
    public function file() {
        if(isset(HTTP::$GET['id'])){
            $this->includeFile("file");
        }
    }

}
