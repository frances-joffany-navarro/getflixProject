<?php

if (isset($_POST['reset-password-submit'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];

    if (empty($password) || empty($passwordRepeat)) {
        header("Location: create-new-password.php?newpwd=empty");
        exit();
    } elseif ($password != $passwordRepeat) {
        header("Location: create-new-password.php?newpwd=pwdnotsame");
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
            echo "There was an error!";
            exit();
        } else {
            $stmt->bindParam(1, $selector);
            $stmt->bindParam(2, $currentDate);

            //execute query
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            //fetch the result
            $account = $stmt->fetch();
            //print_r($account) ;

            if ($result->rowCount() == 0) {
                header("Location: reset-password.php?message=requestagain");
                exit();
            } else {
                //convert validator to bin
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $account["pwdResetToken"]);

                if ($tokenCheck === false) {
                    header("Location: reset-password.php?message=requestagain");
                    exit();
                } elseif ($tokenCheck === true) {
                    $tokenEmail = $account['pwdResetEmail'];
                    $sql = "SELECT * FROM users WHERE email=?";
                    $stmt = $dbConnection->prepare($sql);
                    if (!$stmt) {
                        echo "There was an error!";
                        exit();
                    } else {
                        $stmt->bindParam(1, $tokenEmail);
                        //execute query
                        $stmt->execute();
                        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        if ($result->rowCount() == 0) {
                            header("Location: reset-password.php?message=requestagain");
                            exit();
                        } else {
                            $sql = "UPDATE users SET password=? WHERE email=?;";
                            $stmt = $dbConnection->prepare($sql);
                            if (!$stmt) {
                                echo "There was an error!";
                                exit();
                            } else {
                                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);

                                $stmt->bindParam(1, $newPwdHash);
                                $stmt->bindParam(2, $tokenEmail);
                                //execute query
                                $stmt->execute();

                                //delete existing token the same user in the Database
                                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";

                                $stmt = $dbConnection->prepare($sql);
                                if (!$stmt) {
                                    echo "There was an error!";
                                    exit();
                                } else {
                                    $stmt->bindParam(1, $tokenEmail);
                                    //execute query
                                    $stmt->execute();
                                    header("Location: indexBis.php?message=passwordupdated");
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
