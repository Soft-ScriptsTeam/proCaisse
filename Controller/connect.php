<?php
    $serveur="localhost";
    $nomBD="softcaisse";
    $login="root";
    $password="";
    try{
      $connexion=new PDO("mysql:host=$serveur;dbname=$nomBD",$login,$password);
      $connexion->setattribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      //requette pour la mise en position UTF8
      $connexion->exec("SET NAMES 'utf8'");
      // echo "haha";
    }
    catch(PDOException $e)
    {
      echo"echec de la connexion:".$e->getMessage();
    }