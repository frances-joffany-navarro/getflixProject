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
            
            <?php
          $selector = $_GET['selector'];
          $validator = $_GET['validator'];

          //check if tokens exist in dbased
          if (empty($selector) || empty($validator)) {
            header("Location: indexBis.php?message=validate");
          }else{
            //see if hexa decimal format
            if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
              //form to reset password
              ?>  
              <form action="reset-password1.php" method="post">
                <h2 class="text-center">Reset password</h2>                 
                <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                <div class="form-group ">
                  <input type="password" name="pwd" class="form-control" placeholder="Enter a new password..." required="required" autocomplete="off">
                </div>
                <div class="form-group">
                  <input type="password" name="pwd-repeat" class="form-control" placeholder="Repeat new password..." required="required" autocomplete="off">
                </div>
                <div class="form-group">
                  <button type="submit" name="reset-password-submit" class="btn btn-primary btn-block">Change to new password</button>
                </div>            
              </form>
              
              <?php 
            }
          }
          ?>
        </div>
        <?php include "footer.php" ?>
        </body>
</html>
