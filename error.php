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
if(isset(HTTP::$POST['save_xml'])){
    //print_r(HTTP::$POST);
    $appBase = new ApplicationBase();
    $xml = new XML();
    
    $r = $xml->createRoot("Application");
    
    $main = $r->addChild("app");
    $main->addAttribute("title", $appBase->sanitize(HTTP::$POST['app_title']), false);
    //add the childs of the root file
    $app_data = $main->addChild("app_data");
    $app_data->addAttribute("app_name", lcfirst($appBase->sanitize(HTTP::$POST['app_name'])), false);
    $app_data->addAttribute("app_author", $appBase->sanitize(HTTP::$POST['app_author']), false);
    $icon = $appBase->sanitize(HTTP::$POST['app_icon']);
    $icon = explode("-", $icon);
    
    $app_data->addAttribute("app_icon", $icon[1], false);
    $app_data->addAttribute("app_level", $appBase->sanitize(HTTP::$POST['app_level']), false);
    $app_data->addAttribute("app_link", $appBase->sanitize(HTTP::$POST['app_link']), false);
    $app_data->addAttribute("app_linkText", $appBase->sanitize(HTTP::$POST['app_linkText']), false);
    $install_data = $main->addChild("install_data");
    
    $tables = $appBase->sanitize(HTTP::$POST['tables']);
    $sql = $appBase->sanitize(HTTP::$POST['tables']);
    $require = $appBase->sanitize(HTTP::$POST['required_app']);
    if(!empty($tables)){
        $install_data->addAttribute("tables", $tables, false);
    }
    if(!empty($sql)){
        $install_data->addAttribute("sql", $sql, false);
    }else{
        $install_data->addAttribute("sql", "/* please leave this comment */", false);
    }
    if(!empty($require)){
        $install_data->addAttribute("require", $require, false);
    }
    
    $xml->toFile("apps/".lcfirst($appBase->sanitize(HTTP::$POST['app_name']))."/", $appBase->sanitize(HTTP::$POST['app_name']).".app.xml", true);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href='themes/default/css/bootstrap.min.css' rel='stylesheet'/>
        <link href='themes/default/css/font-awesome.css' rel='stylesheet'/>
        <link href='themes/default/css/default.css' rel='stylesheet'/>
        <link href='themes/default/css/signin.css' rel='stylesheet'/>
        <link href='themes/default/css/icon-picker.min.css' rel='stylesheet'/>
        <style>
            
        </style>
    </head>  
    <body>
        <div id="wrapper" class="">
            <form class="form-horizontal" action="" method="POST">
                <fieldset>

                    <!-- Form Name -->
                    <legend>XML-Creator</legend>

                    <!-- Multiple Checkboxes (inline) -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="app_options">Optionen</label>
                        <div class="col-md-4">
                            <label class="checkbox-inline" for="app_options-0">
                                <input type="checkbox" name="is_required" id="is_required" value="is_required">
                                App ist zwingend nötig
                            </label>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Beschreibung</label>  
                        <div class="col-md-4">
                            <input id="app_title" name="app_title" type="text" placeholder="Kurzbeschreibung der App" class="form-control input-md" required="">
                        </div>
                    </div>
                    <fieldset>

                        <!-- Form Name -->
                        <legend>App-Daten</legend>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="textinput">App-Name</label>  
                            <div class="col-md-4">
                                <input id="app_name" name="app_name" type="text" placeholder="Name der App" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">App-Autor</label>  
                          <div class="col-md-4">
                          <input id="app_author" name="app_author" type="text" placeholder="Autor der App" class="form-control input-md" required="">

                          </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="app_icon">App-Icon</label>  
                            <div class="col-md-4">
                                <input id="app_icon" name="app_icon" type="text" class="icon-picker form-control input-md" required="" />
                            </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">App-Userlevel</label>  
                          <div class="col-md-4">
                          <input id="app_level" name="app_level" type="text" placeholder="Level der Usergruppe mit Zugriff" class="form-control input-md" required="">

                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">App-Link</label>  
                          <div class="col-md-4">
                          <input id="app_link" name="app_link" type="text" placeholder="Link zur App (meist ?app=app_name)" class="form-control input-md" required="">

                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="textinput">Link-Text</label>  
                          <div class="col-md-4">
                          <input id="app_linkText" name="app_linkText" type="text" placeholder="Link-Text" class="form-control input-md" required="">

                          </div>
                        </div>

                    </fieldset>
                    <fieldset>

                        <!-- Form Name -->
                        <legend>Install-Daten</legend>
                            <!-- Prepended checkbox -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="prependedcheckbox">Benötigt</label>
                                <div class="col-md-4">
                                    <input id="required_app" name="required_app" class="form-control" type="text" placeholder="Benötigte App">
                                    <p class="help-block">Benötigt die App eine andere? Wenn mehrere Apps benötigt werden, folgendes Format nutzen: App1|App2</p>
                                </div>
                            </div>
                            
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">Tabellen-Name(n)</label>  
                                <div class="col-md-4">
                                    <input id="tables" name="tables" type="text" placeholder="Name der Tabellen" class="form-control input-md">
                                    <p class="help-block">Tabellennamen mit | OHNE Leerzeichen dazwischen trennen</p>
                                </div>
                            </div>

                            <!-- Textarea -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="sql">SQL</label>
                                <div class="col-md-4">                     
                                    <textarea class="form-control" id="sql" name="sql" rows="10">SQL für Tabellen</textarea>
                                </div>
                            </div>
                        </fieldset>
                    <!-- Button (Double) -->
                    <div class="form-group">
                      <label class="col-md-4 control-label" for="button1id"></label>
                      <div class="col-md-8">
                          <button type="submit" id="button1id" name="save_xml" class="btn btn-success">Erstellen</button>
                          <button type="reset" id="button2id" name="reset_form" class="btn btn-danger">Zurücksetzen</button>
                      </div>
                    </div>

                </fieldset>
            </form>
        </div>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="themes/default/js/jquery-1.11.0.min.js"></script>
        <script src="themes/default/js/bootstrap.min.js"></script>
        <script src="themes/default/js/iconPicker.min.js"></script>
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("active");
            });
             $(function () {
                $(".icon-picker").iconPicker();
            });
        </script>
    </body>
</html>