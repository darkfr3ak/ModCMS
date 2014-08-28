<?php
include 'application/bootstrap.php';
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

if(isset(HTTP::$GET['app'])){
    
    $str="apps/".HTTP::$GET['app']."/".HTTP::$GET['app'].".app.xml";
    
    $sxml = simplexml_load_file($str);
    echo "<pre>";
    print_r($sxml->app->app_data);
    echo "</pre><hr>";
}

$base = new Base();
/*
$allApps = $base->getAppsFromDir("apps");
foreach ($allApps as $value) {
    $files = $base->recursive_file_exists($value.".app.xml", "apps/".$value);
    $installed = $base->isAppInstalled($value);
    if($installed){
        $installed = "(installiert)";
    }else{
        $installed = "(nicht installiert)";
    }
    if($files){
        echo "<br>gefunden: <a href='test.php?app=".$value."'>".$value."</a> ".$installed;
    }else{
        echo "<br>gibbet net hier: ".$value." ".$installed;
    }
}
 * 
 */
$apps = $base->getLocalApps("apps");
print_r($apps);
echo "<hr>";
foreach ($apps as $key => $value) {
    if($value["installed"] == "false"){
        echo $value["dir"]." => ".$value["installed"]."<br>";
    }
}