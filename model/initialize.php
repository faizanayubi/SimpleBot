<?php
//error_reporting(0);

//model directory
$dir_root = 'C:/wamp/www/swiftbot/';
$dir_model = $dir_root.'model/';
$dir_config = $dir_model.'config/';
$dir_class = $dir_model.'class/';
$dir_functions = $dir_model.'functions/';


//important files
require_once($dir_config.'config.php');
require_once($dir_functions.'functions.php');
require_once($dir_class.'class.database.php');
require_once($dir_class.'class.database_object.php');

require_once($dir_class.'class.product.php');
require_once($dir_class.'class.image.php');
require_once($dir_class.'class.photograph.php');

$time = strftime("%Y-%m-%d %H:%M:%S", time()+1800);
?>