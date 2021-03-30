<?php
    // DB CONNECTION
    try {
        $dataBase = new PDO('mysql:host=localhost;dbname=getflix;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }
