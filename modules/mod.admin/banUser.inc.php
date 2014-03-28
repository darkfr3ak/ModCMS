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
            <h2>User bannen <small><?php echo $this->userToBan->user_name; ?></small></h2>
        </div>
        <ol class="breadcrumb">
            <li><a href="?app=admin">Dashboard</a></li>
            <li><a href="?app=admin&task=users">Benutzer</a></li>
            <li class="active">Benutzer bannen</li>
        </ol>
        <form action="" method="POST">
            <div class="col-md-5">
                <!-- Textarea -->
                <div class="form-group">
                    <label class="control-label" for="sql">Grund für den Bann</label>
                    <div class="">                     
                        <textarea class="form-control" id="sql" name="sql" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Dauer</label>
                    <div class="input-daterange input-group" id="datepicker">
                        <span class="input-group-addon">Von</span>
                        <input type="text" class="input-sm form-control" name="start" />
                        <span class="input-group-addon">bis</span>
                        <input type="text" class="input-sm form-control" name="end" />
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="control-label" for="button1id"></label>
                    <div class="">
                        <button type="submit" id="button1id" name="save_xml" class="btn btn-success">Bannen!</button>
                        <button type="reset" id="button2id" name="reset_form" class="btn btn-danger">Zurücksetzen</button>
                    </div>
                </div>
            </div>
        </form>