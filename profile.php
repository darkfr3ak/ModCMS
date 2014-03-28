<?php
include 'application/bootstrap.php';

$activeWidgets = $tmpl->getActiveWidgets();

foreach ($activeWidgets as $value) {
    $tmpl->setWidget($value->active_position, $value->widget_name);
}
$tmpl->show("profile");