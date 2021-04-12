<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>
            <meta name=description content="Sign in page">
            <title>Login</title>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="./css/indexBis.css">
            
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

                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == "pwdupdated") {?>
                            <div class="alert alert-success" role="alert">
                            <h6>Password successfully updated.</h6>
                            <p class="fw-lighter">You can now use your new password to login.</p>
                            </div>
                        <?php }elseif ($_GET['status'] == "emptytoken") { ?>
                            <div class="alert alert-danger" role="alert">
                            <h6>Link is invalid.</h6>
                            <p class="fw-lighter">Please open the link sent to your email.</p>
                            </div>
                    <?php }
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
                <p class="text-center">New on Getflix! <a href="inscription.php">Create your account</a></p>
                <p class="text-center"><a href="index.php">Return to Home page</a></p>    
            </div>
        </body>
</html>