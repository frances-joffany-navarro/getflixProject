<?php
include './DB/dbConnection.php';

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

//   inserer les données  dans la base de donées
$insert = $dbConnection->prepare('INSERT INTO users(first_name, last_name, email, password) VALUES(:first_name, :last_name, :email, :password)');
$insert->execute(array(
    'first_name' => $firstName,
    'last_name' => $lastName,
    'email' => $email,
    'password' => $password,
));
//get user last user id from DB
$last_id = $dbConnection->lastInsertId();

//insert user role
$inserationUserRole = "INSERT INTO user_roles (`user_id`, `role_id` ) VALUES($last_id, 2)";
try {
    $result = $dbConnection->exec($inserationUserRole);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}

header('Location:inscription.php?reg_err=success');

//newsletter proceeding with mailchimp
if(isset($_POST['newsletter'])){
    require('.\mailchimp\Mailchimp.php');    // You may have to modify the path based on your own configuration.
    
    $api_key = "e99621dde35f1d52e87f032bd8fb0395-us1";
    $list_id = "8f0e6a9d56";
    
    $Mailchimp = new Mailchimp( $api_key );
    $Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
    
        $subscriber = $Mailchimp_Lists->subscribe(
            $list_id,
            array('email' => $_POST['email']),      // Specify the e-mail address you want to add to the list.
            array('FNAME' => $_POST['firstName'], 'LNAME' => $_POST['lastName']),   // Set the first name and last name for the new subscriber.
            'html',    // Specify the e-mail message type: 'html' or 'text'
            FALSE,     // Set double opt-in: If this is set to TRUE, the user receives a message to confirm they want to be added to the list.
            TRUE       // Set update_existing: If this is set to TRUE, existing subscribers are updated in the list. If this is set to FALSE, trying to add an existing subscriber causes an error.
        ); 
    }
    ?>