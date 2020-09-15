<?php


function CreateSale($connexion,$vendor_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `sales`( `createdAt`, `vendor_id`) VALUES ('".date("Y-m-d H:i:s")."','".$vendor_id."')";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       $last_id = $connexion->lastInsertId();
       return $last_id;
    }
    catch(PDOException $e){
      echo"CreateSale: echec de la connexion:".$e->getMessage();
      echo "<br> ".$chercherPseudo;
    }
}

function CreateSale_($connexion,$vendor_id,$table_num)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `sales`( `createdAt`, `vendor_id`, `table_num`) VALUES ('".date("Y-m-d H:i:s")."','".$vendor_id."','".$table_num."')";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       $last_id = $connexion->lastInsertId();
       return $last_id;
    }
    catch(PDOException $e){
      echo"CreateSale: echec de la connexion:".$e->getMessage();
      echo "<br> ".$chercherPseudo;
    }
}


function DeleteSale($connexion,$id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="DELETE FROM `sales` WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}
function GetSales($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `sales`.`id`, `customers`.`firstName` as 'customer_first_name',`customers`.`lastName` as 'customer_last_name', `sales`.`createdAt`, `sales`.`completedAt`, `vendors`.`firstName` as 'vendor_first_name',`vendors`.`lastName` as 'vendor_last_name' ,`sales`.`currency_code`, `sales`.`total`, `sales`.`payment`
          FROM `sales`,`customers`,`vendors` WHERE `sales`.`customer_id` = `customers`.`id` AND `sales`.`vendor_id` = `vendors`.`id` OR `sales`.`customer_id` is NULL";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetSale($connexion,$id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `sales`.`id`, `sales`.`createdAt`,`sales`.`completedAt`, `sales`.`total`, `sales`.`payment`, `vendors`.`firstName` as 'vendor_first_name',`vendors`.`lastName` as 'vendor_last_name' 
          FROM `sales`,`vendors` WHERE  `sales`.`vendor_id` = `vendors`.`id` AND `sales`.`id` = ".$id;
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

function GetEncaissement($connexion,$date_debut='0000-00-00 00:00:00',$date_fin='2020-09-02 10:53:23')
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT SUM(`total`) as caisse
       FROM `sales` 
       WHERE `completedAt` <= '".$date_fin."' AND `completedAt` >='".$date_debut."'";
       $requete=$connexion->prepare($chercherPseudo);
       // print_r($requete);
       $requete->execute();

      if ($resultat=$requete->fetch()) {
         return $resultat['caisse'];
       }


    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetFontCaisse($connexion,$Encaissement,$date_debut='0000-00-00 00:00:00',$date_fin='2020-09-02 10:53:23')
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       // $chercherPseudo="SELECT (SELECT SUM(`mnt`) FROM `operation` WHERE `is_retrait`=0 AND `date_time` <= '".$date_fin."' AND `date_time` >='".$date_debut."')-(SELECT SUM(`mnt`) FROM `operation` WHERE `is_retrait`=1 AND `date_time` <= '".$date_fin."' AND `date_time` >='".$date_debut."') as 'mnt'";

       $chercherPseudo="SELECT (SELECT SUM(`mnt`) FROM `operation` WHERE `is_retrait`=0 AND `date_time` >= '".$date_fin."')-(SELECT SUM(`mnt`) FROM `operation` WHERE `is_retrait`=1 AND `date_time` >= '".$date_fin."') as 'mnt'";
       $requete=$connexion->prepare($chercherPseudo);
       // print_r($requete);
       $requete->execute();
      if ($resultat=$requete->fetch()) {
         return $Encaissement - $resultat['mnt'];
       }


    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function ValidateSale($connexion,$id,$total)
{
  //
 try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `sales` SET `total`= ".$total." WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function CloseSale($connexion,$id,$payment)
{
  //
 try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `sales` SET `payment`= '".$payment."',`sales`.`completedAt`='".date("Y-m-d H:i:s")."' WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function UpdateSale($connexion,$id,$total)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `sales` SET`total`=".$total." WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function EditPaymentSale($connexion,$id,$payment)
{
  //
 try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `sales` SET `payment`= '".$payment."' WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function AddToChart($connexion,$sale_id,$product_id)
{
  if ($quantity=GetSaleLine($connexion,$sale_id,$product_id)) {
     return plusQte($connexion,$sale_id,$product_id,$quantity+1);
  }
  else return CreateSaleLine($connexion,$sale_id,$product_id);

}


function plusQte($connexion,$sale_id,$product_id,$qte)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `sale_lines` SET `quantity`=".$qte." WHERE `sale_id`=".$sale_id." AND `product_id`=".$product_id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function CreateSaleLine($connexion,$sale_id,$product_id)
{
   try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `sale_lines`(`sale_id`, `product_id`) VALUES (".$sale_id.",".$product_id.")";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetSaleLine($connexion,$sale_id,$product_id)
{
  //
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `sale_lines`.`quantity`
       FROM `sale_lines` 
       WHERE `sale_lines`.`sale_id`=".$sale_id." AND `sale_lines`.`product_id`=".$product_id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       if ($resultat=$requete->fetch()) {
         return $resultat["quantity"];
       }
       return 0;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
  
}

function GetSaleLines($connexion,$sale_id)
{
  //
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `sale_lines`.`quantity`,`products`.`model`,`sale_lines`.`product_id` , `products`.`price` FROM `sale_lines`,`products` WHERE `sale_lines`.`product_id`=`products`.`id` and `sale_lines`.`sale_id`=".$sale_id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
  
}

function DeleteSaleLine($connexion,$sale_id,$product_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="DELETE FROM `sale_lines` 
       WHERE `sale_lines`.`sale_id`=".$sale_id." AND `sale_lines`.`product_id`=".$product_id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetOperations($connexion,$dateD,$dateF)
{
  //
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="
      SELECT `date_time`, CONCAT(`vendors`.`firstName`,' ',`vendors`.`lastName`) as user, `is_retrait`, `mnt`, `cmt` 
      FROM `operation`,`vendors` WHERE `operation`.`user_id`=`vendors`.`id` AND `date_time`>= '".$dateD."' AND `date_time`<= '".$dateF."'";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
  
}

function CreateOperation($connexion,$vendor_id,$is_retrait,$mnt,$cmt)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `operation`(`date_time`, `user_id`, `is_retrait`, `mnt`, `cmt`) VALUES ('".date("Y-m-d H:i:s")."','".$vendor_id."',".$is_retrait.",".$mnt.",'".$cmt."')";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       $last_id = $connexion->lastInsertId();
       return $last_id;
    }
    catch(PDOException $e){
      echo"CreateSale: echec de la connexion:".$e->getMessage();
      // echo "<br> ".$chercherPseudo;
    }
}

?>