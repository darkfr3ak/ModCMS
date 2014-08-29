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
?>
        <div class="page-header">
            <h2>Dashboard</h2>
        </div>
        <div class="row">
        <ol class="breadcrumb">
            <li class="active">Dashboard</li>
        </ol>
            <ul class="ds-btn">
                <li>
                    <a class="btn btn-lg btn-primary" href="index.php?app=admin&task=appInstaller">
                    <i class="glyphicon glyphicon-user pull-left"></i><span>Apps<br><small>Lorem ipsum dolor</small></span></a> 

                </li>
                <li>
                    <a class="btn btn-lg btn-success " href="index.php?app=admin&task=widgets">
                    <i class="glyphicon glyphicon-dashboard pull-left"></i><span>Widgets<br><small>Lorem ipsum dolor</small></span></a> 

                </li>
                <li>
                    <a class="btn btn-lg btn-info" href="index.php?app=admin&task=users">
                    <i class="glyphicon glyphicon-list pull-left"></i><span>Users<br><small>Lorem ipsum dolor</small></span></a> 
                </li>
                <li>
                    <a class="btn btn-lg btn-warning" href="index.php?app=admin&task=roles">
                    <i class="glyphicon glyphicon-list pull-left"></i><span>User-Gruppen<br><small>Lorem ipsum dolor</small></span></a> 
                </li>
                <li>
                    <a class="btn btn-lg btn-outline" href="index.php?app=admin&task=perms">
                    <i class="glyphicon glyphicon-list pull-left"></i><span>Berechtigungen<br><small>Lorem ipsum dolor</small></span></a> 
                </li>
                <li>
                    <a class="btn btn-lg btn-info" href="index.php?app=admin&task=users">
                    <i class="glyphicon glyphicon-list pull-left"></i><span>Users<br><small>Lorem ipsum dolor</small></span></a> 
                </li>
                <?php
                $admApps = $this->getAdminFromApps();
                for ($index = 0; $index < count($admApps); $index++) {
                    ?>
                    <li>
                        <a class="btn btn-lg btn-info" href="index.php?app=admin&task=ext&man=<?php echo $admApps[$index]['name']; ?>">
                        <i class="glyphicon glyphicon-list pull-left"></i><span><?php echo $admApps[$index]['title']; ?><br><small>Lorem ipsum dolor</small></span></a> 
                    </li>
                    <?php
                }
                ?>
            </ul>
	</div>