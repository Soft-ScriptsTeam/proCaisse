<?php 

function GetSale($connexion,$id)
{
	try{
        include 'connect_database.php';
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `num_mokh`, `date_mokh`, `cin`, `type_mokh`, `address`, `date_recu`, `notes` FROM `mokhalafa_table`";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();   
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
    $connexion=NULL;
}