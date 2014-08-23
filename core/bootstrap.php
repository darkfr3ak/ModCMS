<?php

/* 
 * Copyright (C) 2014 darkfr3ak
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
error_reporting(E_ALL ^ E_NOTICE);
ob_start();
ini_set('session.use_trans_sid', false);
ini_set('session.use_only_cookies', true);
ini_set('url_rewriter.tags', '');
header("Content-type:text/html; charset=utf-8"); 

define("DS", DIRECTORY_SEPARATOR);
define("DEBUG_MODE", 0);
define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT'].DS);

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once(SITE_ROOT."core/libraries/PasswordCompatibility.lib.php");
}

include SITE_ROOT."core/include/autoload.php";

HTTP::init();
$errors = new ErrorHandler(0);
$tmpl = new TemplateBase();
$session = new Session($tmpl->getDbo());