<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'agastya');


// define('DB_SERVER', 'sql311.epizy.com');
// define('DB_USERNAME', 'epiz_31672719');
// define('DB_PASSWORD', 'Fzs3jC7ivfavsJ');
// define('DB_NAME', 'epiz_31672719_agastya');

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id18897201_ritikkanotra');
define('DB_PASSWORD', '(0_k/NX[UkVFXIJb');
define('DB_NAME', 'id18897201_agastya');
 
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
else {
    // echo 'Connected';
}
?>