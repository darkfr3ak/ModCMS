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
class MainApp extends ApplicationBase {
    private $article = NULL;
    //put your code here
    public function __construct() {
        $this->article = new Article(1);
    }
    
    function display(){
        echo'<div class="jumbotron">
          <h1>'.$this->article->articleData->article_title.'</h1>
          <p>'.$this->article->articleData->article_summary.'</p>
          <p><a class="btn btn-primary btn-lg">Learn more</a></p>
      </div>';
    }
}
