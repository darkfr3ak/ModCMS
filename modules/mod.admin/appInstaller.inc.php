<?php
if (realpath(__FILE__) == realpath($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'])){
    Header("Location: ../../index.php");
}

    if($_FILES["zip_file"]["name"]) {
        $filename = $_FILES["zip_file"]["name"];
        $source = $_FILES["zip_file"]["tmp_name"];
        $type = $_FILES["zip_file"]["type"];
        $name = explode(".", $filename);
        $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
        $success = false;
        
        foreach($accepted_types as $mime_type) {
            if($mime_type == $type) {
                $okay = true;
                break;
            } 
        }

        $continue = strtolower(end($name)) == 'zip' ? true : false;
        if(!$continue) {
            trigger_error("The file you are trying to upload is not a .zip file. Please try again.", E_USER_WARNING);
            exit(1);
            
        }

        $target_path = SITE_ROOT."files/upload/".$filename;  // change this to the correct site path
        if(move_uploaded_file($source, $target_path)) {
            $zip = new ZipArchive();
            $x = $zip->open($target_path);
            if ($x === true) {
                switch ($name[1]) {
                    case "app":
                        $zip->extractTo(SITE_ROOT."modules/"); // change this to the correct site path
                        $success = true;
                        break;
                    case "widget":
                        $zip->extractTo(SITE_ROOT."modules/"); // change this to the correct site path
                        $success = true;
                        break;
                    case "theme":
                        $zip->extractTo(SITE_ROOT."themes/"); // change this to the correct site path
                        $success = true;
                        break;
                    default:
                        trigger_error("The file you are trying to upload is not valid. Please try again.", E_USER_WARNING);
                        break;
                }
                $zip->close();
                if($success){
        
                    if(isset(HTTP::$POST['install_app'])){
                        $app = $name[0];
                        $app_data = array();
                        if($this->recursive_file_exists($app.".app.xml", SITE_ROOT."modules/mod.".$app)){
                            $str = SITE_ROOT."modules/mod.".$app."/".$app.".app.xml";
                            $sxml = simplexml_load_file($str);
                            $app_data = json_decode(json_encode($sxml));

                            if(!$this->installApp($app_data)){
                                trigger_error("Couldn't install App: ".$app, E_USER_WARNING);
                            }else{
                                echo '<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Success!</strong> '.$filename.' file was uploaded and installed.
                              </div>';
                            }

                            unlink($target_path);
                        }
                    }else{
                        echo '<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Success!</strong> '.$filename.' file was uploaded and unpacked.
                              </div>';
                    }
                }
            }
        } else {	
            trigger_error("There was a problem with the upload. Please try again.", E_USER_ERROR);
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
            <h2>AppInstaller</h2>
        </div>
        <ol class="breadcrumb">
            <li><a href="?app=admin">Dashboard</a></li>
            <li class="active">App-Installer</li>
        </ol>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Panel title</h3>
                <span class="pull-right">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class="active"><a href="#install" data-toggle="tab">App installieren</a></li>
                        <li><a href="#uninstall" data-toggle="tab">Installierte Apps</a></li>
                    </ul>
                </span>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="install">
                        <div class="page-header">
                            <h5>App hochladen</h5>
                        </div>
                        <form enctype="multipart/form-data" method="post" action="">
                            <label for="zip_file">Choose a zip file to upload:</label>
                            <input type="file" name="zip_file" class="filestyle" data-classButton="btn" data-buttonText="Find file">
                                
                            <div class="form-group">
                                <label class="checkbox-inline" for="install_app">
                                    <input type="checkbox" name="install_app" id="install_app" value="install_app">
                                    App installieren
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm" name="submit" value="Upload" >Upload</button>
                        </form>
                        <hr>
                        <div class="page-header">
                            <h5>Nicht installierte Apps</h5>
                        </div>
                        
                        <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Icon</th>
                                            <th>Name</th>
                                            <th>Beschreibung</th>
                                            <th>Autor</th>
                                            <th>Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $notInstalled = $this->getLocalApps("apps");

                                    foreach ($notInstalled as $key => $value) {
                                        if($value["installed"] == "false"){
                                            $str="modules/mod.".$value["dir"]."/".$value["dir"].".app.xml";
                                            $sxml = simplexml_load_file($str);
                                            
                                            echo "<tr>";
                                            echo "<td><i class='glyphicon glyphicon-".$sxml->app->app_data->app_icon."'></i></td>";
                                            echo "<td>".$sxml->app->app_data->app_linkText."</td>";
                                            echo "<td>".$sxml->app->title."</td>";
                                            echo "<td>".$sxml->app->app_data->app_author."</td>";
                                            echo "<td><a href='?app=admin&task=install&name=".$value["dir"]."'>Installieren</a> | <a href='?app=admin&task=delete&name=".$value["dir"]."'>Löschen</a></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    for ($index = 0; $index < count($allApps); $index++) {                                      
                                        
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="tab-pane" id="uninstall">
                        <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Icon</th>
                                            <th>Name</th>
                                            <th>Beschreibung</th>
                                            <th>Autor</th>
                                            <th>Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $allApps = $this->getAllApps();
                                    for ($index = 0; $index < count($allApps); $index++) {  
                                        $str="modules/mod.".$allApps[$index]->app_name."/".$allApps[$index]->app_name.".app.xml";
                                        $sxml = simplexml_load_file($str);                                    
                                        echo "<tr>";
                                        echo "<td>".$allApps[$index]->app_id."</td>";
                                            echo "<td><i class='glyphicon glyphicon-".$sxml->app->app_data->app_icon."'></i></td>";
                                            echo "<td><a href='index.php?app=".$allApps[$index]->app_name."' target='_blank'>".$sxml->app->app_data->app_linkText."</a></td>";
                                            echo "<td>".$sxml->app->title."</td>";
                                            echo "<td>".$sxml->app->app_data->app_author."</td>";
                                        echo "<td><a href='?app=admin&task=uninstall&name=".$allApps[$index]->app_name."'>Deinstallieren</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
