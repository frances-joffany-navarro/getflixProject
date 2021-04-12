<?php
use PHPMailer\PHPMailer\PHPMailer;
// check if submit button is set
if (isset($_POST['reset-request-submit'])) {
    // get the value in email input
    $email = htmlspecialchars($_POST['email']);

    $userEmail = filter_var($email,FILTER_SANITIZE_EMAIL);
        if(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
            header("Location: reset-password.php?status=emailerror&email=". $userEmail);
            exit();
        }
    //Create tokens
    //bin to hex
    $selector = bin2hex(random_bytes(8)); 
    $token = random_bytes(32); // authenticate user to make sure that it is the same user

    //create a link to send to users by email address
    $url = "http://localhost/getflixProject/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    //expiry date
    $expires = date("U") + 1800; // 1 hour ahead

    // Start accessing the database
    try {
        //connect to dbase
        require "DB/dbConnection.php";
        //
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //check if email add is in the database
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = $dbConnection->prepare($sql);
        
        if (!$stmt) {
            header("Location: reset-password.php?status=dberror");
            exit();
        } else {
            $stmt->bindParam(1, $userEmail);

            //execute query
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->rowCount();
            if($row == 0){
                header("Location: reset-password.php?status=notrecognized&email=".$userEmail);
                exit();
            }else{
                //delete existing token from same user in the Database
                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";
                //
                $stmt = $dbConnection->prepare($sql);
                if (!$stmt) {
                    header("Location: reset-password.php?status=dberror");
                    exit();
                } else {
                    $stmt->bindParam(1, $userEmail);
                    //execute query
                    $stmt->execute();
                }

                //insert token to database
                $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES (?,?,?,?)";
                $stmt = $dbConnection->prepare($sql);
                if (!$stmt) {
                    header("Location: reset-password.php?status=dberror");
                    exit();
                } else {
                    // hash token
                    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                    //bind parameters
                    $stmt->bindParam(1, $userEmail);
                    $stmt->bindParam(2, $selector);
                    $stmt->bindParam(3, $hashedToken);
                    $stmt->bindParam(4, $expires);
                    //execute query
                    $stmt->execute();
                }

                //Start email information
                $to = $userEmail;
                $subject = "Reset your password for Getflix";
                $message = "<p>We received a password reset request. The link to reset your password is below. This link will only be available for <b>1 hour</b>. <i>If you did not make this request, you can ignore this email.</i></p>";
                $message .= "<p>Here is your password reset link: </br>";
                $message .= "<a href='" . $url . "'>" . $url . "</a></p>";

                require_once "PHPMailer/PHPMailer.php";
                require_once "PHPMailer/SMTP.php";
                require_once "PHPMailer/Exception.php";

                $mail = new PHPMailer();
                //Start SMTP settings
                $mail->isSMTP();    
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '';
                $mail->Password = '';    
                $mail->Port = '465';
                $mail->SMTPSecure = 'ssl';    
                //End SMTP settings

                //Start email settings
                $mail->isHTML();    
                $mail->SetFrom('no-reply@gmail.com','No Reply');
                $mail->AddAddress($to);
                $mail->Subject = ("no-reply.gmail.com ($subject)");
                $mail->Body = $message;
                //End email settings

                //Email sending
                if($mail->send()){
                    header("Location: reset-password.php?status=success");
                    exit();
                }else{
                    $error = "Something is wrong: <br>". $mail->ErrorInfo;
                    header("Location: reset-password.php?status=failed&message=" . $error);
                    exit();
                }
            }
        }        
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
    $dbConnection = null;
    //End accessing database
} else {
    header("Location: index.php");
}
