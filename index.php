<?php
require_once ("Utility/autoload.php");
require_once ("Utility/StartSmarty.php");
require_once ("Utility/SessionHelper.php");
require_once ("Utility/configDB.php");

$FrontController = new CFrontController();
//$FrontController->run($_SERVER['REQUEST_URI']);
$FrontController->run("/homepage/ded-homepage");
