<?php 
    require_once 'config.php';


    // on vérifie si toute les variables POST existe
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        // on stocke dans des htmlspecialchars pour ne pas se faire pirater
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        // vérifier s'il existe dans la base de donnée
        $check = $bdd->prepare('SELECT pseudo, email, password FROM utilisateur WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();


        // rowCount égale à 0 , c'est que la personne n'est pas dans la base donnée
        if($row == 0){ 
            // le pseudo n'a pas plus de 100 caractères 
            if(strlen($pseudo) <= 100){
                // l'adresse email n'a pas plus de 100 caractères 
                if(strlen($email) <= 100){
                    // vérifier que l'adresse email est bien valide
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        if($password == $password_retype){

                            $cost = ['cost' => 12];
                            //  toujours hasher le mot de passe avec des algorithme de hash 
                            //  car ça peut compromettre les données de l'utilisateur
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            
                            $ip = $_SERVER['REMOTE_ADDR'];
                            
                            //   inserer les données  dans la base de donées
                            $insert = $bdd->prepare('INSERT INTO utilisateur(pseudo, email, password, ip) VALUES(:pseudo, :email, :password, :ip)');
                            $insert->execute(array(
                                'pseudo' => $pseudo,
                                'email' => $email,
                                'password' => $password,
                                'ip' => $ip
                            ));
                            header('Location:inscription.php?reg_err=success');
                            die();
                        }else{ header('Location: inscription.php?reg_err=password'); die();}
                    }else{ header('Location: inscription.php?reg_err=email'); die();}
                   // le nombre de caractère d'adresse mail est  est trop grand 
                }else{ header('Location: inscription.php?reg_err=email_length'); die();}
                // le nombre de caractère du pseudo est trop grand
            }else{ header('Location: inscription.php?reg_err=pseudo_length'); die();}
            // c'est que la personne est dans la personne est dans la base de donnée
        }else{ header('Location: inscription.php?reg_err=already'); die();}
    }