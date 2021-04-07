<?php
use PHPMailer\PHPMailer\PHPMailer;
if (isset($_POST['reset-request-submit'])) {
    //check if email is in the dbase
    // start tokens
    //bin to hex
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    //create a link to send to users email address
    $url = "http://localhost/getflixProject/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    //expiry date
    $expires = date("U") + 1800;

    //insert to Database
    include "DB/dbConnection.php";
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userEmail = $_POST['email'];

    //delete existing token the same user in the Database
    $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";

    $stmt = $dbConnection->prepare($sql);
    if (!$dbConnection) {
        echo "There was an error!";
        exit();
    } else {
        $stmt->bindParam(1, $userEmail);
        //execute query
        $stmt->execute();
    }

    //insert token to dbased
    $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES (?,?,?,?)";
    $stmt = $dbConnection->prepare($sql);
    if (!$stmt) {
        echo "There was an error!";
        exit();
    } else {
        // hash token
        $hashToken = password_hash($token, PASSWORD_DEFAULT);
        $stmt->bindParam(1, $userEmail);
        $stmt->bindParam(2, $selector);
        $stmt->bindParam(3, $hashToken);
        $stmt->bindParam(4, $expires);
        //execute query
        $stmt->execute();
    }
    $dbConnection = null;

    //sending email
    $to = $userEmail;
    $subject = "Reset your password for Getflix";
    $message = "<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignote this email.</p>";
    $message .= "<p>Here is your password reset link: </br>";
    $message .= "<a href='" . $url . "'>" . $url . "</a></p>";

    //headers for the email
    $headers = "From: Frances Joffany Navarro <francesjoffanynavarro@gmail.com>\r\n";
    $headers .= "Reply-To: francesjoffanynavarro@gmail.com\r\n";
    $headers .= "Content-type: text/html\r\n";

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();
    //smtp settings
    $mail->isSMTP();    
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = '';
    $mail->Password = '';    
    $mail->Port = '465';
    $mail->SMTPSecure = 'ssl';
    

    //email settings
    $mail->isHTML();    
    $mail->SetFrom('no-reply@gmail.com','No Reply');
    $mail->AddAddress($to);
    $mail->Subject = ("no-reply.gmail.com ($subject)");
    $mail->Body = $message;

    if($mail->send()){
        header("Location: reset-password.php?message=success");
        //$status = "success";
        //$response = "Email is sent!";
    }else{
        $status = "failed";
        $response = "Something is wrong: <br>". $mail->ErrorInfo;
        echo $response;
    }
} else {
    header("Location: index.php");
}
