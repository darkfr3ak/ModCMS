<?php

/*
 * Copyright (C) 2014 darki
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
 * Description of Article
 *
 * @author darki
 */
class Article extends Base{
    
    private $_db = null;
    public $articleData = array();
    
    public function __construct($articleID = null) {
        $this->_db = $this->getDbo();
        
        $this->articleData = $this->getArticle($articleID);
    }
    
    private function getArticle($articleID = null) {
        $sql = sprintf("SELECT * FROM ".Conf::$DB_PREFIX."core_articles WHERE article_id = '%d'", $this->sanitize($articleID));
        $result = $this->_db->loadSingleResult($sql);
        return $result;
    }
    
    public function getAllArticles() {
        $sql = "SELECT * FROM ".Conf::$DB_PREFIX."core_articles";
        $result = $this->_db->loadResult($sql);
        return $result;
    }
    
    public function addArticle($articleData = array()) {
        
    }
    
    public function deleteArticle($articleID = null) {
        
    }
}
