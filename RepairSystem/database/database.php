<?php
//Supports PDO and mysqli

$config = [
  'host' => 'localhost',
  'username' => 'root',
  'password' => '',
  'dbname' => 'it6repairproject'
];

//for PDO sa seeder
return $config;

//for mysqli productions
$mysqli = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['dbname']
);

if ($mysqli->connect_error) {
  die("MySQLi Connection failed: " . $mysqli->connect_error);
}

/*try {

  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "it6repairproject";

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn->connect_error) {
    die("Database connection unsuccessful: " . $conn->connect_error);
  }

} catch (\Exception $e) {
  echo "Error: " . $e;
}*/