<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>
            <meta name=description content="Reset password for user who forgot it">
            <title>Reset Password</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
            <link rel="stylesheet" href="css/indexBis.css">

        </head>
        <body>
        <div class="login-form">
        <?php if (isset($_GET['status'])) {
                if ($_GET['status'] == "success") {?>
                        <div class="alert alert-success" role="alert">
                        <h6>Email is successfully sent.</h6>
                        <p class="fw-lighter">Please check your email.</p>
                        </div>
                    <?php } elseif ($_GET['status'] == "requestagain") {?>
                        <div class="alert alert-danger" role="alert">
                        <h6>Password cannot be updated.</h6>
                        <p class="fw-lighter">Tokens are invalid. Please re-submit your request again.</p>
                        </div>
                    <?php } elseif ($_GET['status'] == "failed") {?>
                        <div class="alert alert-danger " role="alert">
                        <h6>Email cannot be send.</h6>
                        <p class="fw-lighter text-wrap" style="width: 15rem;"><?php echo $_GET['message'] ?></p>
                        </div>
                    <?php } elseif ($_GET['status'] == "notrecognized") {?>
                        <div class="alert alert-danger" role="alert">
                        <h6>Email cannot be send.</h6>
                        <p class="fw-lighter">Your email is not recognized. Please check your email address and try again.</p>
                        </div>
                    <?php } elseif ($_GET['status'] == "dberror") {?>
                        <div class="alert alert-danger" role="alert">
                        <h6>Email cannot be send.</h6>
                        <p class="fw-lighter">There was an error in the database.</p>
                        </div>
                    <?php } elseif ($_GET['status'] == "emailerror") {?>
                        <div class="alert alert-danger" role="alert">Please enter a valid email address.</div>
            <?php }
                }?>
            <form action="reset-request.php" method="post">
            <h2 class="text-center">Reset password</h2>
            <div class="mb-3">
                <label for="InputEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="InputEmail" value="<?php if (isset($_GET['email'])) {echo htmlspecialchars($_GET['email']);}?>" aria-describedby="emailHelp" required autocomplete="off" autofocus="autofocus">
                <div id="emailHelp" class="form-text">An email will be send to you with instruction on how to reset your password.</div>
            </div>
            <div class="text-center">
                <button type="submit" name="reset-request-submit" class="btn btn-primary">Receive new password by email</button>
            </div>
            </form>
            <p class="text-center"><a href="indexBis.php">Go back to Sign in page</a></p>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        </body>
</html>
