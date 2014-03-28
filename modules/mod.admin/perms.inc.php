<?php
if (realpath(__FILE__) == realpath($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'])){
    Header("Location: ../../index.php");
}
$myACL = new ACL();
if(isset(HTTP::$GET['action']) && isset(HTTP::$GET['permID'])){
    if($this->sanitize(HTTP::$GET['action']) == "delete"){
        $myACL->deletePerm($this->sanitize(HTTP::$GET['permID']));
    }
}
if (isset(HTTP::$POST['action'])){
    switch(HTTP::$POST['action']){
        case 'savePerm':
            if(isset(HTTP::$POST['permID'])){
                $permID = $this->sanitize(HTTP::$GET['permID']);
            }else{
                $permID = '';
            }
            $savePermArr = array(
                "permID" => $permID,
                "permName" => $this->sanitize(HTTP::$POST['permName']),
                "permKey" => $this->sanitize(HTTP::$POST['permKey'])
            );
            $myACL->updatePerm($savePermArr);
            break;
        case 'delPerm':
            $myACL->deletePerm($this->sanitize(HTTP::$POST['permID']));
            break;
    }
}
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
?>
        <div class="page-header">
            <h2>Benutzer-Gruppen</h2>
        </div>
        <ol class="breadcrumb">
            <li><a href="?app=admin">Dashboard</a></li>
            <li><a href="?app=admin&task=users">Benutzer</a></li>
            <li class="active">Berechtigungen</li>
        </ol>
    <?php if (HTTP::$GET['action'] == '') { ?>
    	<h2>Select a Permission to Manage:</h2>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th>Name</th>
                            <th style="width: 10%">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $roles = $myACL->getAllPerms('full');
                        if (count($roles) < 1){
                            echo "No permissions yet.<br />";
                        }
                        foreach ($roles as $k => $v){
                        ?>
                        <tr>
                            <td><?php echo $v['ID']; ?></td>
                            <td><?php echo $v['Name']; ?></td>
                            <td>
                                <a class="btn btn-hover btn-primary btn-xs" href="index.php?app=admin&task=perms&action=perm&permID=<?php echo $v['ID'] ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-hover btn-warning btn-xs" href="index.php?app=admin&task=perms&action=delete&permID=<?php echo $v['ID']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="index.php?app=admin&task=perms&action=perm" class="btn btn-hover btn-primary"><span class="glyphicon glyphicon-plus"></span> Neue Berechtigung</a>
            <?php } 
            if (HTTP::$GET['action'] == 'perm') { 
                if (HTTP::$GET['permID'] == '') { 
            ?>
            <h3>New Permission:</h3>
            <?php } else { ?>
            <h3>Manage Permission: (<?php echo $myACL->getPermNameFromID(HTTP::$GET['permID']); ?>)</h3><?php } ?>
            <form action="index.php?app=admin&task=perms" method="post" class="form-horizontal">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="permName">Name:</label>
                            <?php
                            if (HTTP::$GET['permID'] == '') {
                            ?>
                            <input type="text" class="form-control" name="permName" id="permName" value="" maxlength="30" />
                            <?php
                            }else{
                               ?>
                            <input type="text" class="form-control" name="permName" id="permName" value="<?php echo $myACL->getPermNameFromID(HTTP::$GET['permID']); ?>" maxlength="30" />
                            <?php 
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="permKey">Key:</label>
                            <?php
                            if (HTTP::$GET['permID'] == '') {
                            ?>
                            <input type="text" class="form-control" name="permKey" id="permKey" value="" maxlength="30" />
                            <?php
                            }else{
                               ?>
                            <input type="text" class="form-control" name="permKey" id="permKey" value="<?php echo $myACL->getPermKeyFromID(HTTP::$GET['permID']); ?>" maxlength="30" />
                            <?php 
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" value="savePerm" />
                            <input type="hidden" name="permID" value="<?php echo HTTP::$GET['permID']; ?>" />
                            <button class="btn btn-hover btn-primary" type="submit" name="Submit" value="Submit" ><span class="glyphicon glyphicon-floppy-save"></span> Eintragen</button>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </form>
            <?php } ?>