<?php
// <!-- connexion a la database --> 
$host="localhost";
$dbname="event_manager";
$username="root";
$password="";

try {
    
    //connexion a la database
    $pdo=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données");
}


?>