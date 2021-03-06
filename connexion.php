<?php
session_start();
include './DB/dbConnection.php';
include './user.php';

// voir si les données de mon POST  du form de indexBis.php existent

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    // stocker les POST dans des  htmlspecialchars pour éviter les piratage 
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // voir si la personne est bien inscrit dans la base de données
    $check = $dbConnection->prepare('SELECT id, first_name, last_name, email, password FROM users WHERE email = ?');
    //on met toutes les données dans un tableau 
    $check->execute(array($email));
    // on stocke les donné dans data et on le chercher avec fetch
    $data = $check->fetch();
    // avec rowCount on va vérifier si la table existe
    $row = $check->rowCount();

    // si la valeur de rowCount égale à 1 , c'est que la personne  existe
    if ($row == 1) {
        // vérifier que l'adresse email est bien valide
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (password_verify($password, $data['password'])) {
                $user = new User();
                $user->id = $data['id'];
                $user->firstName = $data['first_name'];
                $user->lastName = $data['last_name'];
                $user->email = $data['email'];
                $user->password = $data['password'];

                $_SESSION['user'] = $user;
                header('Location: index.php');
                die();
            } else {
                header('Location: indexBis.php?login_err=password');
                die();
            }
            // si l'email n'est pas valide on va le renvoyer dans indexBis.php
        } else {
            header('Location: indexBis.php?login_err=email');
            die();
        }
        //Sinon la personne n'existe pas
    } else {
        header('Location: indexBis.php?login_err=already');
        die();
    }
}
