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
 * Description of Todolist
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class TodolistApp extends ApplicationBase {
    
    private $task = "";
    
    //put your code here
    public function __construct() {
        $this->task = $this->sanitize($_GET['task']);
    }
    
    public function addtodotask(){
        $title = $_REQUEST['title'];
	$desc = $_REQUEST['desc'];
	$sql = "INSERT INTO ".Conf::$DB_PREFIX."todolist_tasks VALUES(NULL,'$title','$desc')";
	$db = $this->getDbo();				
	if($db->query($sql)){				
            $this->redirect('?app=todolist&task=viewtodolist');				
	}else{
            $this->redirect();				
	}
    }
    
    public function viewtodolist(){
        $db = $this->getDbo();
        $sql = "SELECT * FROM ".Conf::$DB_PREFIX."todolist_tasks";
        $rows = $db->loadResult($sql);    
        
        $this->displayDashboard();
        ?>
        <div class="panel panel-default">
            <table class="table table-striped">
                <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php                
                foreach($rows as $row){
                ?>
                    <tr>
                        <td><?php echo $row->title;?></td>
                        <td><?php echo $row->desc;?></td>
                        <td>
                           <a href="?app=todolist&task=edittaskform&taskid=<?php echo $row->id;?>">Edit</a> | 
                           <a href="?app=todolist&task=deletetask&taskid=<?php echo $row->id;?>">Delete</a>
                         </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>            
        <?php
    }
    
    public function deletetask(){
	$id = $_REQUEST['taskid'];
	$db = $this->getDbo();
	$sql = "DELETE FROM ".Conf::$DB_PREFIX."todolist_tasks WHERE id=$id";
	$db->query($sql);
	$this->redirect('index.php?app=todolist&task=viewtodolist');	
    }
    
    public function display(){
        $this->displayDashboard();
    }
    
    private function displayDashboard(){
	?>
	    <div class="page-header">
                <h1 id="tiles">Todolist Application Dashboard</h1>
            </div>
            <ul class="nav nav-pills">
                <li <?php if($this->task == "addtaskform"){echo 'class="active"';} ?>><a href="?app=todolist&task=addtaskform">Add Todo Task</a></li>
                <li <?php if($this->task == "viewtodolist"){ echo 'class="active"';} ?>><a href="?app=todolist&task=viewtodolist">View Todo List</a></li>
            </ul>
	<?php
    }
    
    public function addtaskform(){
        echo $this->displayDashboard();
        ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" action="" method="POST">
                    <input type="hidden" name="app" value="todolist"/>
                    <input type="hidden" name="task" value="addtodotask"/>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title"/>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="desc" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                    <a href="?app=todolist&task=viewtodolist" class="btn btn-default">Back</a>
                </form>
            </div>
        </div>			  
	<?php
    }
    
    public function edittaskform(){
	$id = $_REQUEST['taskid'];
	$sql = "SELECT * FROM ".Conf::$DB_PREFIX."todolist_tasks WHERE id=$id";
	$db = $this->getDbo();
	$row = $db->loadSingleResult($sql);
        
	echo $this->displayDashboard();
        ?>
	   <div class="panel panel-default">
               <div class="panel-body">
                    <form class="form-horizontal" action="" method="POST">
                        <input type="hidden" name="app" value="todolist"/>
                        <input type="hidden" name="task" value="edittodotask"/>
                        <input type="hidden" name="id" value="<?php echo $row->id;?>"/>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo $row->title;?>"/>
                        </div>
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea name="desc" class="form-control"><?php echo $row->desc;?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Task</button>
                        <a href="?app=todolist&task=viewtodolist" class="btn btn-default">Back</a>			
                    </form>
               </div>
	   </div>			  
	<?php
    }
    
    public function edittodotask(){			
	$id = $_REQUEST['id'];
	$title = $_REQUEST['title'];
	$desc = $_REQUEST['desc'];
	$sql = "UPDATE ".Conf::$DB_PREFIX."todolist_tasks as tasks SET tasks.title='$title',tasks.desc='$desc' WHERE id=$id";
	$db = $this->getDbo();				
	if($db->query($sql)){					
            $this->redirect('index.php?app=todolist&task=viewtodolist');				
	}else{				
            $this->redirect();
	}			
    }
}
