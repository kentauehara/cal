<?php

$dsn = 'mysql:dbname=uriage;host=localhost';
$user = 'testuser';
//$password = 'testuser';

try{
    $dbh = new PDO($dsn, $user);
     header("Location:index.php");
 }catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}?>


<html>
    <head>認証</head>
    
</html>