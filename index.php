<?php
require_once ("Utility/autoload.php");
require_once ("Utility/StartSmarty.php");
require_once ("Utility/SessionHelper.php");
require_once("Utility/config.php");

$FrontController = new CFrontController();
$FrontController->run();