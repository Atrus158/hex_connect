<?php

//constants
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');

define('DB_DATABASE', 'nexus');

//connect to database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

// check connection
if (mysqli_connect_errno()) {
    echo "Connect failed: ";
    echo mysqli_connect_error();
    exit();
}

?>