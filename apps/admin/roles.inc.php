<?php
if (realpath(__FILE__) == realpath($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'])){
    Header("Location: ../../index.php");
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
$myACL = new ACL();

if(isset(HTTP::$GET['action']) && isset(HTTP::$GET['roleID'])){
    print_r(HTTP::$GET);
    if($this->sanitize(HTTP::$GET['action']) == "delete"){
        $myACL->deleteRole($this->sanitize(HTTP::$GET['roleID']));
    }
}

if (isset(HTTP::$POST['action'])){
    switch(HTTP::$POST['action']){
        case 'saveRole':
            $param = array(
                "roleID" => HTTP::$POST['roleID'],
                "roleName" => HTTP::$POST['roleName']
            );
            $upd = $myACL->updateRole($param);
            
            if ($upd > 1){
		$roleID = HTTP::$POST['roleID'];
            } else {
		$roleID = $upd;
            }
            foreach (HTTP::$POST as $k => $v){
                if (substr($k,0,5) == "perm_"){
                    $permID = str_replace("perm_","",$k);
                    if ($v == 'X'){
                        $rpArr = array(
                            "roleID" => $roleID,
                            "permID" => $permID
                        );
                        $myACL->deleteRolePerm($rpArr);
                        continue;
                    }
                    $rpArr = array(
                        "roleID" => $roleID,
                        "permID" => $permID,
                        "value" => $v
                    );
                    $myACL->updateRolePerm($param);
		}
            }
            break;
    }
}

?>
        <div class="page-header">
            <h2>Benutzer-Gruppen</h2>
        </div>
        <ol class="breadcrumb">
            <li><a href="?app=admin">Dashboard</a></li>
            <li><a href="?app=admin&task=users">Benutzer</a></li>
            <li class="active">Benutzer-Gruppen</li>
        </ol>
        <?php if (HTTP::$GET['action'] == '') { ?>
    	<h3>Select a Role to Manage:</h3>
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
                $roles = $myACL->getAllRoles('full');
                foreach ($roles as $k => $v){
                ?>
                <tr>
                    <td><?php echo $v['ID']; ?></td>
                    <td><?php echo $v['Name']; ?></td>
                    <td>
                        <a class="btn btn-hover btn-primary btn-xs" href="index.php?app=admin&task=roles&action=role&roleID=<?php echo $v['ID'] ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-hover btn-warning btn-xs" href="index.php?app=admin&task=roles&action=delete&roleID=<?php echo HTTP::$GET['roleID']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="index.php?app=admin&task=roles&action=role" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Neue Gruppe</a>
        <?php } 
        if (HTTP::$GET['action'] == 'role') { 
            if (HTTP::$GET['roleID'] == '') { 
		?>
                <h3>New Role:</h3>
        <?php } else { ?>
                <h3>Manage Role: (<?php echo $myACL->getRoleNameFromID(HTTP::$GET['roleID']); ?>)</h3>
        <?php } ?>
        <form action="index.php?app=admin&task=roles" method="post" class="form-horizontal">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="roleName">Name:</label>
                        <input class="form-control" type="text" name="roleName" id="roleName" value="<?php echo $myACL->getRoleNameFromID(HTTP::$GET['roleID']); ?>" />
                        <input type="hidden" name="action" value="saveRole" />
                        <input type="hidden" name="roleID" value="<?php echo HTTP::$GET['roleID']; ?>" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="Submit" value="Submit">Speichern</button>
                        <?php if (HTTP::$GET['roleID'] != '') { ?>
                        <a class="btn btn-warning" href="index.php?app=admin&task=roles&action=delete&roleID=<?php echo HTTP::$GET['roleID']; ?>">Löschen</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th></th>
                            <th>Allow</th>
                            <th>Deny</th>
                            <th>Ignore</th>
                        </tr>
                        <?php
                        if (HTTP::$GET['roleID'] != '') { 
                            $rPerms = $myACL->getRolePerms(HTTP::$GET['roleID']);
                        }
                        $aPerms = $myACL->getAllPerms('full');
                        foreach ($aPerms as $k => $v){

                            echo "<tr><td><label>" . $v['Name'] . "</label></td>";
                            echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_1\" value=\"1\"";
                            if ($rPerms[$v['Key']]['value'] === true && HTTP::$GET['roleID'] != '') {
                                echo " checked=\"checked\""; 
                            }
                            echo " /></td>";
                            echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_0\" value=\"0\"";
                            if ($rPerms[$v['Key']]['value'] != true && HTTP::$GET['roleID'] != '') {
                                echo " checked=\"checked\""; 
                            }
                            echo " /></td>";
                            echo "<td><input type=\"radio\" name=\"perm_" . $v['ID'] . "\" id=\"perm_" . $v['ID'] . "_X\" value=\"X\"";
                            if (HTTP::$GET['roleID'] == '' || !array_key_exists($v['Key'],$rPerms)) { echo " checked=\"checked\""; }
                            echo " /></td>";
                            echo "</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </form>
    <?php } ?>