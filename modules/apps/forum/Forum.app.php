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
class ForumApp extends ApplicationBase {
    
    private $_db;
    
    //put your code here
    public function __construct() {
        $this->_db = $this->getDbo();
    }
    
    function display(){
        ?>
        <div class="page-header">
            <h2>Forum</h2>
        </div>
        <?php
        $this->getCats();
        //include 'front.inc.php';
    }
    
    private function getCats($parent = 0) {
        ?>
            <div class="panel-group" id="accordion">
        <?php
        $sql = "SELECT * FROM mycms_forum_cats";
        $rows = $this->_db->loadResult($sql); 
        foreach ($rows as $cat) {
            $coll = str_replace(" ", "_", $cat->cat_name)
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $coll; ?>">
                                <?php echo $cat->cat_name; ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse<?php echo $coll; ?>" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?php echo $cat->cat_desc; ?>
                                </div>

                                    <?php
                                    if($cat->cat_hasSubCats == 1){
                                        echo '<div class="panel-footer">';
                                        $subs = $this->getSubCats($cat->cat_id);
                                        foreach ($subs as $subCat) {
                                            ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading"><?php echo $subCat->sub_name; ?></div>
                                                <div class="panel-body">
                                                    <?php echo $subCat->sub_desc; ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        echo '</div>';
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
        ?>
            </div>
        <?php
    }
    
    private function getSubCats($parent = 0) {
        $sql = "SELECT * FROM mycms_forum_subCats WHERE sub_parent = ".$parent;
        $rows = $this->_db->loadResult($sql); 
        return $rows;
    }
    
    public function getPosts($param) {
        
    }
    
    public function addPost($param) {
        
    }
    
    public function addCat($param) {
        
    }
    
    public function editPost($param) {
        
    }
    
    public function editCat($param) {
        
    }
    
    public function deletePost($param) {
        
    }
    
    public function deleteCat($param) {
        
    }

}
