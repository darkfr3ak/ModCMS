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

function cmsAutoLoad($class_name) {

    # List all the class directories in the array.
    $array_paths = array(
        SITE_ROOT.'core/classes/', 
        SITE_ROOT.'core/libraries/', 
        SITE_ROOT.'core/libraries/database/', 
        SITE_ROOT.'core/libraries/interfaces/', 
    );

    # Count the total item in the array.
    $total_paths = count($array_paths);

    # Set the class file name.
    $file_name = $class_name.'.class.php';

    # Loop the array.
    for ($i = 0; $i < $total_paths; $i++) {
        if(file_exists($array_paths[$i].$file_name)) {
            require_once $array_paths[$i].$file_name;
        } 
    }

    # Set the class file name.
    $file_name = $class_name.'.lib.php';

    # Loop the array.
    for ($i = 0; $i < $total_paths; $i++) {
        if(file_exists($array_paths[$i].$file_name)) {
            require_once $array_paths[$i].$file_name;
        } 
    }
}

spl_autoload_register('cmsAutoLoad');