<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="./css/indexBis.css">
            <title>Login</title>
        </head>
        <body>
        
        <div class="login-form">
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
                                <strong>Error</strong> incorrect password
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Error</strong> incorrect email
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Error</strong> account doesn't exist
                            </div>
                        <?php
                        break;
                    }
                }
                ?> 
            
            <form action="connexion.php" method="post">
                <h2 class="text-center">Log in</h2>       
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </div>   
                <p class="text-center"><a href="reset-password.php">Forgot your password?</a></p>
            </form>
            
            <p class="text-center"><a href="inscription.php">Create a new account</a></p>
            <hr>
            <p class="text-center"><a href="index.php">Return to homepage</a></p>
            <?php
                if (isset($_GET['message'])) {
                    if ($_GET['message'] == "passwordupdated") {
                        echo "<p class='text-center text-success'>Password successfully updated.</p>";
                    }elseif ($_GET['message'] == "validate") {
                        echo "<p class='text-center text-danger'>Could not validate your request!</p>";
                    }
                }
                ?>
        </div>
        </body>
</html>