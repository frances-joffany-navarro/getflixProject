<?php
$errors = array('pwd' => '', 'pwd-repeat' => '');
if (isset($_POST['reset-password-submit'])) {
    $selector = htmlspecialchars($_POST['selector']);
    $validator = htmlspecialchars($_POST['validator']);
    $password = htmlspecialchars($_POST['pwd']);
    $passwordRepeat = htmlspecialchars($_POST['pwd-repeat']);
    
    //check password input
    if (empty($password) && empty($passwordRepeat)) {
        header("Location: create-new-password.php?status=allempty&selector=$selector&validator=$validator");
        exit();
    } else if (empty($password) || empty($passwordRepeat)) {
        header("Location: create-new-password.php?status=oneempty&selector=$selector&validator=$validator");
        exit();
    } else if ($password != $passwordRepeat) {
        header("Location: create-new-password.php?status=pwdnotsame&selector=$selector&validator=$validator");
        exit();
    }

    //check if token is expired or not
    $currentDate = date("U");
    try {
        include "DB/dbConnection.php";
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector = ? AND pwdResetExpires >= ?";

        $stmt = $dbConnection->prepare($sql);

        if (!$stmt) {
            header("Location: create-new-password.php?status=dberror&selector=$selector&validator=$validator");
            exit();
        } else {
            $stmt->bindParam(1, $selector);
            $stmt->bindParam(2, $currentDate);

            //execute query
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            //fetch the result
            $account = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                header("Location: reset-password.php?status=requestagain");
                exit();
            } else {
                //convert validator to bin
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $account["pwdResetToken"]);

                if ($tokenCheck === false) {
                    header("Location: reset-password.php?status=requestagain");
                    exit();
                } elseif ($tokenCheck === true) {
                    $tokenEmail = $account['pwdResetEmail'];
                    $sql = "SELECT * FROM users WHERE email = ?";
                    $stmt = $dbConnection->prepare($sql);
                    if (!$stmt) {
                        header("Location: create-new-password.php?status=dberror&selector=$selector&validator=$validator");
                        exit();
                    } else {
                        $stmt->bindParam(1, $tokenEmail);
                        //execute query
                        $stmt->execute();
                        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        if ($stmt->rowCount() == 0) {
                            header("Location: reset-password.php?status=requestagain");
                            exit();
                        } else {
                            $sql = "UPDATE users SET password=? WHERE email=?;";
                            $stmt = $dbConnection->prepare($sql);
                            if (!$stmt) {
                                header("Location: create-new-password.php?status=dberror&selector=$selector&validator=$validator");
                                exit();
                            } else {
                                //hash new password
                                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);

                                $stmt->bindParam(1, $newPwdHash);
                                $stmt->bindParam(2, $tokenEmail);
                                //execute query
                                $stmt->execute();

                                //delete existing token the same user in the Database
                                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ?";

                                $stmt = $dbConnection->prepare($sql);
                                if (!$stmt) {
                                    header("Location: create-new-password.php?status=dberror&selector=$selector&validator=$validator");
                                    exit();
                                } else {
                                    $stmt->bindParam(1, $tokenEmail);
                                    //execute query
                                    $stmt->execute();
                                    header("Location: indexBis.php?status=pwdupdated");
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
            //fetch the result
            // $images = $stmt->fetchAll();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    header("Location: index.php");
}
