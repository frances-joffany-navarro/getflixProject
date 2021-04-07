<?php

try
{
  $bdd = new PDO('mysql:host=localhost;dbname=getflix;charset=utf8', 'root', 'root');

  echo " tout est bon !";
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());

   echo "c'est mauvais !";     
}

?>