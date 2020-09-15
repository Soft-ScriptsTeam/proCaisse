<?php


function InsertCustomer($connexion, $firstName, $lastName, $email, $tel)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `customers`(`firstName`, `lastName`, `email`, `phoneNumber`) VALUES ('".$firstName."','".$lastName."','".$email."','".$tel."')";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function EditCustomer($connexion,$id, $firstName, $lastName, $email, $country, $taxNumber, $phoneNumber, $birthDate)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `customers` SET `firstName`='".$firstName."', `lastName`='".$lastName."' ,`email`='".$email."', `country`='".$country."', `taxNumber`='".$taxNumber."', `phoneNumber`='".$phoneNumber."' ,`birthDate`='".$birthDate."' WHERE `id`=".$id;
       // echo "SQL :".$chercherPseudo."<br>";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetCustomers($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `customers`.`id`,`customers`.`firstName`, `customers`.`lastName`, `customers`.`email`,SUM(`sales`.`total`) as 'CA' ,COUNT(`sales`.`id`) as 'ventes' ,MAX(`sales`.`createdAt`) as 'Dernier achat' FROM `customers`, `sales` WHERE `customers`.`id`= `sales`.`customer_id`";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetCustomers_($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `customers`.`id`,`customers`.`firstName`, `customers`.`lastName`, `customers`.`email` FROM `customers` WHERE `customers`.`id` not in 
        (SELECT `customers`.`id` FROM `customers`, `sales` WHERE `customers`.`id`= `sales`.`customer_id`)";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetCustomerValidatedSales($connexion,$clt_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `createdAt`, `total`, `payment` FROM `sales` WHERE `customer_id`='".$clt_id."' AND `completedAt`<>'0000-00-00 00:00:00' ORDER BY `completedAt`";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetCustomerUnValidatedSales($connexion,$clt_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id`, `createdAt`, `total`, `payment` FROM `sales` WHERE `customer_id`='".$clt_id."' AND `completedAt`='0000-00-00 00:00:00' ORDER BY `completedAt`";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetCustomerProducts($connexion,$clt_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `sales`.`id` as 'sale_id', `products`.`id`, `products`.`model`,`products`.`price`, `sale_lines`.`quantity` FROM `sales`,`products`,`sale_lines` WHERE `sales`.`id` = `sale_lines`.`sale_id` AND `products`.`id`=`sale_lines`.`product_id` AND `sales`.`customer_id`='".$clt_id."' AND `completedAt`<>'0000-00-00 00:00:00' ";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}
// 

function GetCustomer($connexion,$clt_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `customers`.`id`,`customers`.`firstName`, `customers`.`lastName`, `customers`.`email`, `customers`.`country`, `customers`.`taxNumber`, `customers`.`phoneNumber`, `customers`.`birthDate`, `customers`.`vat`,SUM(`sales`.`total`) as 'CA' ,COUNT(`sales`.`id`) as 'sales' ,MAX(`sales`.`createdAt`) as 'lastSale' FROM `customers`, `sales` WHERE `customers`.`id`= `sales`.`customer_id` AND `customers`.`id` = ".$clt_id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       if ($resultat=$requete->fetch()) {
         return $resultat;
       }

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function getUsers($connexion)
{

  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `firstName`, `lastName`, `userName` FROM `vendors` ";
       $requete=$connexion->prepare($chercherPseudo);
       // print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }

}
?>