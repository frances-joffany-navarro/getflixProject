<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="./css/indexBis.css">
            <title>Reset Password</title>
        </head>
        <body>
        
        <div class="login-form">        
            <form action="reset-request.php" method="post">
                <h2 class="text-center">Reset password</h2>
                <p class="text-center text-muted">An email will be send to you with instructions on how to reset your password.</p>       
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" name="reset-request-submit" class="btn btn-primary btn-block">Send an email</button>
                </div>                  
            </form>            
            <p class="text-center"><a href="indexBis.php">Go back to Sign in page</a></p>
            <?php
                if (isset($_GET['message'])) {
                    if ($_GET['message'] == "success") {
                        echo "<p class='text-success'>An email has been sent to the requested account with further information. If
                        you do not receive an email then please confirm you have entered the same   
                        email address used during account registration.</p>";
                    }elseif ($_GET['message'] == "requestagain") {
                        echo "<p class='text-danger'>You need to re-submit your reset password request.</p>";
                    }
                }
                ?>
        </div>
        <?php include "footer.php" ?>
        </body>
</html>
