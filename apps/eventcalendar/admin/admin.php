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
include 'EventCalAdmin.class.php';
$cal = new EventCalAdmin();

if(isset(HTTP::$GET['editID'])){
    echo "edit: ".HTTP::$GET['editID'];
    print_r($cal->getEvent($cal->sanitize(HTTP::$GET['editID'])));
}elseif(isset (HTTP::$GET['delID'])){
    $cal->deleteEvent($cal->sanitize(HTTP::$GET['delID']));
}
?>
        <div class="page-header">
            <h2>Event-Kalender-Administration</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="page-header">
                    <h4>Vorhandene Events</h4>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 15%">Datum</th>
                            <th style="width: 25%">Titel</th>
                            <th>Beschreibung</th>
                            <th style="width: 15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                <?php                
                $events = $cal->getEvents();
                foreach ($events as $event) {
                    ?>
                        <tr>
                            <td><?php echo $this->formatDate($event->event_date) ?>, <?php echo $event->event_time ?></td>
                            <td><?php echo $event->event_title ?></td>
                            <td><?php echo $event->event_desc ?></td>
                            <td>
                                <a class="btn btn-hover btn-primary btn-xs" href="index.php?app=admin&task=ext&man=eventcalendar&editID=<?php echo $event->event_id ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-hover btn-warning btn-xs" href="index.php?app=admin&task=ext&man=eventcalendar&delID=<?php echo $event->event_id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                <?php
                }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="page-header">
                    <h4>Neues Event</h4>
                </div>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="event_title" class="control-label">Titel</label>
                        <input type="text" class="form-control" name="event_title" id="event_title" />
                    </div>
                    <div class="form-group">
                        <label for="event_desc" class="control-label">Beschreibung</label>
                        <textarea class="form-control" name="event_desc" id="event_desc" rows="7" ></textarea>
                    </div>
                    
                </form>
            </div>
        </div>
