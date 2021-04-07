<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <!-- google font -->
     <link rel="preconnect" href="https://fonts.gstatic.com"> 
     <link href="https://fonts.googleapis.com/css2?family=Chango&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="profil.css">
    <title>Document</title>
</head>
<body>

            <!-- mettre un petit alert  si on a une erreur lors de la connection (voir les else dans connexion.php dans la partie session) -->
            <?php 
            // vérifier si la variable existe 
                if(isset($_GET['login_err']))
                {
                    // si elle existe on va le stocker dans le  $err avec le htmlspecialchars
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> email incorrect
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> compte non existant
                            </div>
                        <?php
                        break;
                    }
                }
                ?> 

                
    <h2 class=" getflix text-center"> GETFLIX LOGO</h2>
        <div class="ligne">    
            <form action="profilConnexion.php" method="post">
                    <div class="form-group">
                        <label for="email">email</label><br>
                        <input class="parametre" type="email" name="email" class="form-control"  required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">password</label><br>
                        <input class="parametre" type="password" name="password" class="form-control"  required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </div> 
                    <hr>
                      <div>
                          <p class="text-center">New on Getflix</p>
                      </div>
                     <p class="text-center"><a href="inscription.php">Sign up</a></p>
                      <div>
                      <p class="text-center"><a href="" >Go back to Home page</a></p>
                      </div>
            </form>
        </div>

        </div>

</body>
</html>