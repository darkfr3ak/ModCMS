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
if(isset(HTTP::$GET['month']) && isset(HTTP::$GET['year'])){
    $month = $this->sanitize(HTTP::$GET['month']);
    $year = $this->sanitize(HTTP::$GET['year']);
}elseif(isset(HTTP::$POST['month']) && isset(HTTP::$POST['year'])) {
    $month = $this->sanitize(HTTP::$POST['month']);
    $year = $this->sanitize(HTTP::$POST['year']);
}else{
    $month = date("m");
    $year = date("Y");
}
?>
        <div class="page-header">
            <h2>Events</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <?php
                echo '<h3 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h3>';
                echo '<div style="clear:both;"></div>';
                echo $this->draw_calendar($month, $year);
                ?>
            </div>
            <div class="col-md-4"><?php echo $this->showControls(); ?></div>
        </div>
