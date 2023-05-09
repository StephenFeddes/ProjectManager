<?php
// Creates connection to the database.
$dsn = "mysql: dbname=id20687287_project; host=localhost";
$username = "id20687287_root";
$password = "JTMLwv+Gjgl7&/44";
$pdo = new PDO($dsn, $username, $password);

// Catch any connection errors
try {
  $conn = new PDO($dsn, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->query("USE id20687287_project");
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>