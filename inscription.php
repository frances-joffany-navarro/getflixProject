<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="inscription.css">
            <title>Connexion</title>
        </head>
        <body>
        <div class="login-form">
        <!-- mettre un petit alert  si on a une erreur lors de la connection  (voir la partie inscription_traitement.php) -->
            <?php 
             // vérifier si la variable existe 
                if(isset($_GET['reg_err']))
                {
                     // si elle existe on va le stocker dans le  $err avec le htmlspecialchars
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> inscription réussie !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email trop long
                            </div>
                        <?php 
                        break;

                        case 'first_length':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> prénom trop long
                                </div>
                            <?php 
                            break;

                        case 'last_name_length':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> prénom trop long
                            </div>
                        <?php 
                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte deja existant
                            </div>
                        <?php 

                    }
                }
                ?>
                <h2 class=" getflix text-center"> GETFLIX LOGO</h2>
            
                <div class="ligne">
            <form action="PInscription.php" method="post">
                <p class=" titreForm text-center">Create an Account</p>       
                <div class="form-group">
                <label for="first_name">first name</label><br>
                    <input class="parametre" type="text" name="first_name" class="form-control" placeholder="" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                <label for="last_name"> last name</label><br>
                    <input class="parametre" type="text" name="last_name" class="form-control" placeholder="" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                <label for="email">email</label><br>
                    <input class="parametre" type="email" name="email" class="form-control" placeholder="" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                <label for="password">password</label><br>
                    <input class="parametre" type="password" name="password" class="form-control" placeholder="" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                <label for="password">password retype</label><br>
                    <input class="parametre" type="password" name="password_retype" class="form-control" placeholder="" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Sign up</button>
                </div> 
                <hr>
                <div>
                    <p>Already have an account > <a href="profil.php">Sign in </a></p>
                </div>
                <hr>
                   <p class="text-center"><a href="" >Go back to Home page</a></p>
            </form>
            </div>
        </div>
       
        </body>
</html>