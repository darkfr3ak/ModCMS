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
 * Description of EventCalAdmin
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class EventCalAdmin extends Base{
    
    private $db;

    //put your code here
    public function __construct() {
        $this->db = $this->getDbo();
    }
    
    public function getEvents() {        
        $sql = "SELECT * FROM mycms_events_calendar;";
        return $this->db->loadResult($sql);
    }
    
    public function getEvent($eventID = 0) {
        $sql = sprintf("SELECT * FROM mycms_events_calendar WHERE event_id = %u LIMIT 1", $eventID);
        return $this->db->loadSingleResult($sql);
    }
    
    public function editEvent($eventID = 0, $eventData = array()) {
        
    }
    
    public function addEvent($eventData = array()) {
        
    }
    
    public function deleteEvent($eventID = 0) {        
        $sql = sprintf("DELETE FROM mycms_events_calendar WHERE event_id = %u LIMIT 1", $eventID);
        return $this->db->query($sql);
    }

}
