<?php

$username_db = "root";
$password_db = "";

try {

  $db = new PDO("mysql:host=localhost;dbname=quizup", $username_db, $password_db);

} catch (PDOException $e) {

  print "Erreur :" . $e->getMessage() . "<br/>";
  die;
  
}