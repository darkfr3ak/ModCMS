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
    
    public $article_id;
    public $article_title;
    public $article_summary;
    public $article_content;
    public $article_author;
    public $article_date;
    public $article_editDate;
    
    public function __construct($article_id) {
        $this->getById($article_id);
    }
    
    private function getById($article_id) {
        $query = "SELECT * FROM core_articles WHERE article_id = '%d'";
        $sql = sprintf($query, $article_id);
        $db = $this->getDbo();
        $row = $db->loadSingleResult($sql);
        if ($row){
            if ( isset( $row->article_id ) ) $this->article_id = (int) $row->article_id;
            if ( isset( $row->article_date ) ) $this->article_date = $this->formatDate($row->article_date, true);
            if ( isset( $row->article_editDate ) ) $this->article_editDate = $this->formatDate($row->article_editDate);
            if ( isset( $row->article_title ) ) $this->article_title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $row->article_title );
            if ( isset( $row->article_summary ) ) $this->article_summary = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $row->article_summary );
            if ( isset( $row->article_content ) ) $this->article_content = $row->article_content;
        }
    }
}
