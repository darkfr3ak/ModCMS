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
$myACL = new ACL($_SESSION['user_id']);
$user = new User($_SESSION['user_id']);
?>
        <div class="page-header">
            <h2>User-Verwaltung</h2>
        </div>
        <ol class="breadcrumb">
            <li><a href="?app=admin">Dashboard</a></li>
            <li class="active">Benutzer</li>
        </ol>
        <hr> 
        <div class="btn-group">
            <a href="?app=admin&task=roles" class="btn btn-hover btn-primary">Benutzer-Gruppen</a>
            <a href="?app=admin&task=perms" class="btn btn-hover btn-primary">Berechtigungen</a>
        </div>
        <hr>  
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gruppen</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUsers = $user->getAllUsers();
                foreach ($allUsers as $value) {
                    $userACL = new ACL($value->user_id);
                    $userRoles = $userACL->getUserRoles();
                    $roleOut = "";
                    foreach ($userRoles as $role) {
                        $roleOut .= $userACL->getRoleNameFromID($role)." ";
                    }
                ?>
                <tr>
                    <td><?php echo $value->user_id; ?></td>
                    <td><?php echo $value->user_name; ?></td>
                    <td><?php echo $roleOut; ?></td>
                    <td><a class="btn btn-hover btn-warning btn-xs" href="index.php?app=admin&task=banUser&userID=<?php echo $value->user_id; ?>"><span class="glyphicon glyphicon-ban-circle"></span></a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>