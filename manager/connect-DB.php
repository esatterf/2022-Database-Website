<!-- Connecting -->
<?php
$databaseName = 'ESATTERF_Final';
$dsn = 'mysql:host=webdb.uvm.edu;dbname=' . $databaseName;
$username = '*********';
$password = '*********';

$pdo = new PDO($dsn, $username, $password);
?>
<!-- Connection complete -->
