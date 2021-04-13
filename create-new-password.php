<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name=description content="create new password">
            <meta name="author" content="NoS1gnal"/>
            <title>Reset Password</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
            <link rel="stylesheet" href="css/indexBis.css">
            
        </head>
        <body>
        <div class="login-form">    
        <?php
          $selector = $_GET['selector'];
          $validator = $_GET['validator'];

          //check if tokens is empty
          if (empty($selector) || empty($validator)) {
            header("Location: indexBis.php?status=emptytoken");
          }else{
            //see if hexa decimal format
            if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
              //form to reset password
              if (isset($_GET['status'])) {
                if ($_GET['status'] == "pwdupdated") { ?>
                  <div class="alert alert-success" role="alert">
                  <p>Your password was successfully updated.</p>
                  </div>
                <?php }elseif ($_GET['status'] == "allempty") { ?>
                  <div class="alert alert-danger" role="alert">
                  <p>All inputs are empty.</p>
                  </div>
                <?php }elseif ($_GET['status'] == "oneempty"){ ?>
                  <div class="alert alert-danger" role="alert">
                  <p>One of the inputs is empty.</p>
                  </div>
                <?php }elseif ($_GET['status'] == "pwdnotsame"){ ?>
                  <div class="alert alert-danger" role="alert">
                  <p>Password must be the same.</p>
                  </div>
                <?php }elseif ($_GET['status'] == "dberror"){ ?>
                  <div class="alert alert-danger" role="alert">
                  <h6>Password cannot be updated.</h6>
                  <p class="fw-lighter">There was an error in the database.</p>
                  </div>
            <?php   }
                 } ?>  
              <!-- Start of create new password form -->
              <form action="reset-password1.php" method="post">
                <h2 class="text-center">Create new password</h2>
                <!-- Hidden inputs for selector and validator passed in the url-->
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                <!-- New password input-->
                <div class="form-floating mb-3">
                  <input type="password" name="pwd" class="form-control" id="InputPassword1" autocomplete="off" required autofocus="autofocus">
                  <label for="InputPassword1" class="form-label">Enter your new password</label>
                </div>
                <!-- Reenter new password input-->
                <div class="form-floating mb-3">                  
                  <input type="password" name="pwd-repeat" class="form-control" id="InputPassword2" required autocomplete="off">
                  <label for="InputPassword2" class="form-label">Repeat your new password</label>
                </div>
                <!-- Submit button-->
                <div class="text-center">
                  <button type="submit" name="reset-password-submit" class="btn btn-primary ">Reset password</button>
                </div>                
              </form>
              <!-- End of create new password form -->
      <?php }else{
              echo "Tokens are invalid.";
            }
          } ?>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    </body>
</html>
