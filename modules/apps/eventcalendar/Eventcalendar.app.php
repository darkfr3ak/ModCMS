<?php

/*
 * Copyright (C) 2014 darkfr3ak <info at darkfr3ak.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License,  or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not,  write to the Free Software
 * Foundation,  Inc.,  59 Temple Place - Suite 330,  Boston,  MA  02111-1307,  USA.
 */


/**
 * Description of Default
 *
 * @author darkfr3ak <info at darkfr3ak.de>
 */
class EventcalendarApp extends ApplicationBase {
    
    private $events = array();
    
    //put your code here
    public function __construct() {

    }
    
    function display(){
        //echo 'Diese App ist absichtlich leer. Sie dient nur als Vorlage für neue Apps!';
        //echo $this->draw_calendar(date("m"), date("Y"));
        //echo $this->showControls();
        include 'cal.inc.php';
    }
    
    /* draws a calendar */
    private function draw_calendar($month,$year){
        $this->getEvents($month, $year);
        
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Mo','Di','Mi','Do','Fr','Sa','So'); //reorder labels, starting with monday
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('N',mktime(0, 0, 0, $month, 1, $year))-1;
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day"><div style="position:relative;height:80px;">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			
			$event_day = $year.'-'.$month.'-'.$list_day;
			if(isset($this->events[$event_day])) {
                            foreach($this->events[$event_day] as $event) {
                                $calendar.= '<div class="event">'.$event->event_time.':<br><b>'.$event->event_title.'</b></div>';
                            }
			}
			else {
				$calendar.= str_repeat('<p>&nbsp;</p>',2);
			}
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
    }
    
    public function getEvents($month, $year) {
        $db = $this->getDbo();
        $events = array();
        $sql = "SELECT event_title, event_time, DATE_FORMAT(event_date,'%Y-%m-%d') AS event_date FROM mycms_events_calendar WHERE event_date LIKE '$year-$month%' ORDER BY event_time ASC;";
        $rows = $db->loadResult($sql);
        foreach ($rows as $value) {
            $this->events[$value->event_date][] = $value;
        }
        
        return $this->events;
    }
    
    private function showControls() {
        /* date settings */
        $month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
        $year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

        /* select month control */
        $select_month_control = '<select name="month" id="month" class="form-control">';
        for($x = 1; $x <= 12; $x++) {
            $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
        }
        $select_month_control.= '</select>';

        /* select year control */
        $year_range = 7;
        $select_year_control = '<select name="year" id="year" class="form-control">';
        for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
            $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
        }
        $select_year_control.= '</select>';

        /* "next month" control */
        $next_month_link = '<a href="index.php?app=eventcalendar&month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-forward"></span></a>';

        /* "previous month" control */
        $previous_month_link = '<a href="index.php?app=eventcalendar&month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-backward"></span></a>';

        /* bringing the controls together */
        $controls = '<form method="POST" action="index.php?app=eventcalendar" class="form-horizontal"><div class="form-group">'.$select_month_control.'</div><div class="form-group">'.$select_year_control.'</div><div class="form-group"><input type="submit" name="submit" class="btn btn-default btn-sm"/>      '.$previous_month_link.'     '.$next_month_link.'</div></form>';

        return $controls;
    }

}
