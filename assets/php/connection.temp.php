<?php

$con = mysqli_connect("HOST_NAME", "DB_USERNAME", "DB_PASSWORD", "DB_NAME")
or die("Unable to connect to the database server!");
$db = mysqli_select_db($con, 'DB_NAME')
or die("Unable to connect to the database server!");

//Email Configuration
define('EMAIL_HOST', 'HOST_NAME');
define('EMAIL_PORT', 'PORT_NUMBER');
define('EMAIL_USERNAME', 'EMAIL_USERNAME');
define('EMAIL_PASSWORD', 'EMAIL_PASSWORD');
define('EMAIL_NAME', 'EMAIL_NAME');

?>