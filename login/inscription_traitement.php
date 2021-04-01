<?php
include '../DB/dbConnection.php';

// on vérifie si toute les variables POST existe
$registrationIsFilled = !empty($_POST['firstName']) &&
    !empty($_POST['lastName']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password']) &&
    !empty($_POST['password_retype']);

if (!$registrationIsFilled) {
    return;
}

// on stocke dans des htmlspecialchars pour ne pas se faire pirater
$firstName = htmlspecialchars($_POST['firstName']);
$lastName = htmlspecialchars($_POST['lastName']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$password_retype = htmlspecialchars($_POST['password_retype']);

// vérifier s'il existe dans la base de donnée
$check = $dbConnection->prepare('SELECT * FROM users WHERE email = ?');
$check->execute(array($email));
$data = $check->fetch();
$rowCount = $check->rowCount();

// rowCount superior a 0 , c'est que la personne existe dans la base donnée
$userExists = $rowCount > 0;

if ($userExists) {
    header('Location: inscription.php?reg_err=already');
    die();
}

// le nombre de caractère du nom est trop grand
if (strlen($firstName) > 100) {
    header('Location: inscription.php?reg_err=firstName_length');
    die();
}

if (strlen($lastName) > 100) {
    header('Location: inscription.php?reg_err=lastName_length');
    die();
}

// le nombre de caractère d'adresse mail est  est trop grand 
if (strlen($email) > 100) {
    header('Location: inscription.php?reg_err=email_length');
    die();
}

// vérifier que l'adresse email est bien valide
$isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$isEmailValid) {
    header('Location: inscription.php?reg_err=email');
    die();
}

if ($password != $password_retype) {
    header('Location: inscription.php?reg_err=password');
    die();
}

$cost = ['cost' => 12];
//  toujours hasher le mot de passe avec des algorithme de hash 
//  car ça peut compromettre les données de l'utilisateur
$password = password_hash($password, PASSWORD_BCRYPT, $cost);

//$ip = $_SERVER['REMOTE_ADDR'];

//   inserer les données  dans la base de donées
$insert = $dbConnection->prepare('INSERT INTO users(first_name, last_name, email, password) VALUES(:first_name, :last_name, :email, :password)');
$insert->execute(array(
    'first_name' => $firstName,
    'last_name' => $lastName,
    'email' => $email,
    'password' => $password,
));
header('Location:inscription.php?reg_err=success');
die();

    //if ($rowCount == 0) {
    // le pseudo n'a pas plus de 100 caractères 
    //if (strlen($pseudo) <= 100) {
    // l'adresse email n'a pas plus de 100 caractères 
    //if (strlen($email) <= 100) {
    // vérifier que l'adresse email est bien valide
    //if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //if ($password == $password_retype) {

    //     $cost = ['cost' => 12];
    //     //  toujours hasher le mot de passe avec des algorithme de hash 
    //     //  car ça peut compromettre les données de l'utilisateur
    //     $password = password_hash($password, PASSWORD_BCRYPT, $cost);

    //     //$ip = $_SERVER['REMOTE_ADDR'];

    //     //   inserer les données  dans la base de donées
    //     $insert = $dbConnection->prepare('INSERT INTO utilisateur(pseudo, email, password, ip) VALUES(:pseudo, :email, :password, :ip)');
    //     $insert->execute(array(
    //         'pseudo' => $pseudo,
    //         'email' => $email,
    //         'password' => $password,
    //         'ip' => $ip
    //     ));
    //     header('Location:inscription.php?reg_err=success');
    //     die();
    // //} 
    //else {
        //header('Location: inscription.php?reg_err=password');
        //die();
    //}
    //} else {
    //header('Location: inscription.php?reg_err=email');
    //die();
    //}
    // le nombre de caractère d'adresse mail est  est trop grand 
    //} else {
    //header('Location: inscription.php?reg_err=email_length');
    //die();
    //}
    // le nombre de caractère du pseudo est trop grand
    //} else {
    //header('Location: inscription.php?reg_err=pseudo_length');
    //die();
    //}
    // c'est que la personne est dans la personne est dans la base de donnée
    //} else {
    // header('Location: inscription.php?reg_err=already');
    //die();
    //}
