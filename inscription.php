<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="NoS1gnal" />
    <meta name=description content="Registration for user that has no account">
    <title>Register</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/inscription.css">
    
</head>

<body>
    <div class="login-form">
        <!-- mettre un petit alert  si on a une erreur lors de la connection  (voir la partie inscription_traitement.php) -->
        <?php
        // vérifier si la variable existe 
        if (isset($_GET['reg_err'])) {

            // si elle existe on va le stocker dans le  $err avec le htmlspecialchars
            $err = htmlspecialchars($_GET['reg_err']);

            switch ($err) {

                case 'success':
        ?>
                    <div class="alert alert-success">
                        <strong>Succes</strong> registration completed !
                    </div>
                <?php
                    break;

                case 'password':
                ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong> passwords don't match
                    </div>
                <?php
                    break;

                case 'email':
                ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong> invalid email
                    </div>
                <?php
                    break;

                case 'email_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong> email too long
                    </div>
                <?php
                    break;

                case 'firstName_length':
                ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong> first name too long
                    </div>
                <?php

                case 'lastName_length':

                ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong> last name too long
                    </div>
                <?php

                case 'already':
                ?>
                    <div class="alert alert-danger">
                        <strong>Error</strong> the account already exists
                    </div>
        <?php
            }
        }
        ?>

        <form action="inscription_traitement.php" method="post">
            <h2 class="text-center">Register</h2>
            <div class="form-group">
                <input type="text" name="firstName" class="form-control" placeholder="First Name" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="text" name="lastName" class="form-control" placeholder="Last Name" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="password_retype" class="form-control" placeholder="Confirm password" required="required" autocomplete="off">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="newsletter" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="newsletter">Join our newsletter</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
        </form>
        <p class="text-center">Already have an account? <a href="indexBis.php">Sign in</a></p>
    </div>
</body>

</html>