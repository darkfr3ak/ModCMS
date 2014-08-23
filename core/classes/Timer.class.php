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
 * Description of Timer
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class Timer {

    private $start_time;
    private $end_time;
    private $accumulated_time;
  
    //Public constructor
    public function __construct() {
        $this->start_time = NULL;
        $this->end_time = NULL;
        $this->accumulated_time = 0;
    }

    //Public functions
    public function start() {
        if ($this->is_stopped()) {
            //add time so far to accumulated time
            //reset end time and set start time
            $this->accumulated_time += ($this->end_time - $this->start_time); 
            $this->start_time = $this->get_timestamp();
            $this->end_time = NULL;
        }else if (!$this->is_started()) {
            $this->start_time = $this->get_timestamp();
        }
    }

    public function stop() {
        if ($this->is_started()) {
            $this->end_time = $this->get_timestamp();
        }
    }

    public function reset() {
        $this->__construct(); 
    }

    public function retrieve() {
        $this->stop();
        return round($this->accumulated_time + ($this->end_time - $this->start_time));
    } 

    //Private functions
    private function is_started() {
        //if start is numeric but end is null, we are started
        if(is_numeric($this->start_time) && is_null($this->end_time)) {
            return true;
        }
        return false;
    }

    private function is_stopped() {
        //if end time is numeric, we have a stopped timer
        if(is_numeric($this->end_time)) {
            return true;
        }
        return false;
    }

    private function get_timestamp() {    
        //retrieve seconds and microseconds (one millionth of a second)
        //multiply by 1000 to get milliseconds
        $timeofday = gettimeofday();
        return 1000*($timeofday['sec'] + ($timeofday['usec'] / 1000000));
    } 
}
