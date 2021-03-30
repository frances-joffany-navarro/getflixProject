<?php
echo "say hi";

include './DB/dbConnection.php';

// (D) START SESSION
session_start();
// (A) LET'S SAY THE LOGIN FORM POST TO THIS SCRIPT
$_POST = [
    "email" => "john@doe.com",
    "password" => "123456"
  ];
  
  // (B) WE FETCH THE USER FROM DATABASE & VERIFY THE PASSWORD
  //require "2a-core.php";
  $stmt = $dataBase->prepare("SELECT * FROM `users` LEFT JOIN `roles` USING (`id`) WHERE `email`=?");
  $stmt->execute([$_POST['email']]);
  $user = $stmt->fetchAll();
  $pass = count($user)>0;
  if ($pass) {
    $pass = $user[0]['user_password'] == $_POST['password'];
  }
  
  // (C) IF VERIFIED - WE PUT THE USER & PERMISSIONS INTO THE SESSION
  if ($pass) {
    $_SESSION['user'] = $user[0];
    $_SESSION['user']['permissions'] = [];
    unset($_SESSION['user']['user_password']); // Security...
    $stmt = $dataBase->prepare("SELECT * FROM `roles_permissions` WHERE `role_id`=?");
    $stmt->execute([$user[0]['role_id']]);
    while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
      if (!isset($_SESSION['user']['permissions'][$row['category']])) {
        $_SESSION['user']['permissions'][$row['category']] = [];
      }
      $_SESSION['user']['permissions'][$row['category']][] = $row['permission_id'];
    }
  }
  
  // (D) DONE!
  echo $pass ? "OK" : "<br>Invalid email/password" ;
  echo "<br><br>SESSION DUMP<br>";
  print_r($_SESSION);