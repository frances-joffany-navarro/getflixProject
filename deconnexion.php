<?php 
    session_start();
    session_destroy();
    header('Location:indexBis.php');
    die();