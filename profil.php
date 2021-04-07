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
    <link rel="stylesheet" href="css/profil.css">
    <title>Document</title>
</head>
<body>
    <section class="sectionOne">
    

        <p class="GETFLIX">GETFLIX</p>
        <p class="LOGO">LOGO</p>

        <button class="logout" type="submit">Logout</button>
    

    </section>
    <!-- ------------------------------- -->
    <section>
        <img class="image" src="img/avatar-profilPhp.jpg" alt="">

        <article class="login-form">
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
            
            <form action="" method="post">
                           
                    <div class="form-group">
                        <label for="first_name">first name</label><br>
                        <input type="text" name="first_name" class="form-control" placeholder="first name" required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="last_name"> last name</label><br>
                        <input type="text" name="last_name" class="form-control" placeholder=" last_name" required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label><br>
                        <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="password">password</label><br>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                    </div>   
                
                </form>

        </article>
    </section>

</body>
</html>