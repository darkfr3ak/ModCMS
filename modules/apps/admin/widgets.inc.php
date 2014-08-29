<?php
if (realpath(__FILE__) == realpath($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'])){
    Header("Location: ../../index.php");
}

if(isset(HTTP::$POST['qrystr']) && isset(HTTP::$POST['sub_wid'])){
    $data = HTTP::$POST['qrystr'];

    $tmp = explode(";", $data);
    $retArr = array();
    print_r($data);
    foreach ($tmp as $value) {
        $val = explode("|", $value);
        foreach ($val as $v) {
            $pos = strpos($v,",");
            if($pos != false){
                $v1 = explode(",", $v);
                foreach ($v1 as $vOut) {
                    //echo $vOut."<br>";
                }
            }else{
                //echo $v."<br>";
            }
        }
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
            <h2>Widgets</h2>
        </div>
        <ol class="breadcrumb">
            <li><a href="?app=admin">Dashboard</a></li>
            <li class="active">Widgets</li>
        </ol>
<div class="row">
    <form action="" method="POST">
        <div class="col-md-3">Info</div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Verfügbare Widgets</div>
                <div class="panel-body">
                    <div class="draggable-list" id="avail_list">
                        <?php
                        $allWidgets = $this->getWigdets();
                        foreach ($allWidgets as $widget) {
                            ?>
                            <div class="draggable-item" id="<?php echo $widget->widget_name; ?>">
                                <p style="float:right"> <?php echo $widget->widget_name; ?> </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?php
                    $allPos = $this->getWigdetPositions();
                    foreach ($allPos as $pos) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo $pos->pos_name; ?></div>
                            <div class="panel-body">
                                <div class="draggable-list" id="<?php echo $pos->pos_name; ?>">

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <input type="text" name="qrystr" id="qrystr" />
    <input type="text" name="posstr" id="posstr" />
    <button class="btn btn-primary" type="submit" name="sub_wid">Speichern</button>
    </form>
</div>