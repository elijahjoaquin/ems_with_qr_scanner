<?php

define('DB_HOST','localhost');
define('DB_USER','u630461016_root');
define('DB_PASS','HajekQEnterprise123!');
define('DB_NAME','u630461016_hajekems');

$conn = mysqli_connect('localhost','u630461016_root','HajekQEnterprise123!','u630461016_hajekems') or die(mysqli_error());

// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

?>
