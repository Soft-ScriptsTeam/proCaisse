<?php 
require 'connect.php';
require 'customers_controller.php';
require 'inventore_controller.php';
require 'products_controller.php';
require 'sales_controller.php';
// require 'Model/Product.php';


function GetSuppliers($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `name` FROM `suppliers` WHERE `enabled`=1";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }

}

function GetCategories($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `name` FROM `categories` WHERE `enabled`=1";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }

}

function GetTaxes($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `name` FROM `taxes` WHERE `enabled`=1";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }

}

function GetBrands($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `name` FROM `brands` WHERE `enabled`=1";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }

}

function GetAvariableTables($connexion,$id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `table_num`,`id` FROM `sales` WHERE `vendor_id`=".$id." AND `completedAt` = '0000-00-00 00:00:00' AND `table_num`<>''";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      if ($resultat=$requete->fetchAll()) {
        $array = array(); //simple array
        $array['000']['sale_id'] = '' ;
        foreach ($resultat as $value){
          // print_r($value);
          // echo "<br>";
            $sale_id = $value['id'];
            $table_num = $value['table_num'];
            $array[$table_num]['sale_id'] = $sale_id ;
        }
          return $array;
       }
       $array = array(); //simple array
      $array['000']['sale_id'] = '' ;
      return $array;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

// print_r(AddToChart($connexion,1,3));


function LogInVendor($connexion,$userName,$password)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `firstName`, `lastName`, `role`  FROM `vendors` WHERE `userName`='".$userName."' AND `password`='".$password."'";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       if ($resultat=$requete->fetch())
         return $resultat;
        return -1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}
