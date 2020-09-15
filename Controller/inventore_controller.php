<?php



function GetInventors($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `inventories`.`id` as 'inv_id',`label`, `date_facture`, `date_paiement`, `status`, `suppliers`.`name` as 'fournisseur',`stores`.`name` as 'stock' , `total_cost`, `total_qte`  FROM `inventories`, `stores`, `suppliers` WHERE ( `inventories`.`stock_id` =`stores`.`id` or `inventories`.`stock_id` =0)and `inventories`.`supplier_id` = `suppliers`.`id`  ";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetInventor($connexion,$inv_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `inventories`.`id` as 'inv_id',`label`, `date_facture`, `date_paiement`, `status`, `suppliers`.`name` as 'fournisseur',`stores`.`name` as 'stock' , `liv_cost`, `total_cost` FROM `inventories`, `stores`, `suppliers` WHERE ( `inventories`.`stock_id` =`stores`.`id` or `inventories`.`stock_id` =0)and `inventories`.`supplier_id` = `suppliers`.`id`  AND `inventories`.`id` = ".$inv_id;
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

function CreateInventor($connexion,$label,$supplier_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `inventories`(`label`, `date_facture`, `supplier_id`)  VALUES ('".$label."','".date("Y-m-d")."','".$supplier_id."')";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
    }
    catch(PDOException $e){
      echo"CreateSale: echec de la connexion:".$e->getMessage();
      // echo "<br> ".$chercherPseudo;
    }
}

function DeleteInventor($connexion,$id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="DELETE FROM `inventories` WHERE `label`='".$id."';";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function GetInventorInputs($connexion,$inv_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `products`.`id`,`products`.`model`,`products`.`supplierReference`,`products`.`barcode`,`products`.`supplyPrice`, `quantity`, `recieved` FROM `inventoryinputs`,`products` WHERE `inventoryinputs`.`product_id`=`products`.`id` and `inv_id` = '".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "GetInventorInputs : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetInventorInput($connexion,$inv_id,$product_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `product_id`, `quantity` FROM `inventoryinputs` WHERE `inv_id`='".$inv_id."' and `product_id`='".$product_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "GetInventorInputs : ";print_r($requete);
       $requete->execute();
       if ($resultat=$requete->fetch()) {
         return $resultat;
       }

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function InsertInventorInput($connexion,$inv_id,$product_id,$quantity)
{
	try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `inventoryinputs`(`inv_id`, `product_id`, `quantity`) VALUES ('".$inv_id."','".$product_id."','".$quantity."')";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "InsertInventorInput : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function UpdateInventorInput($connexion,$inv_id,$product_id,$quantity)
{
	try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventoryinputs` SET `quantity`='".$quantity."' WHERE `inv_id`='".$inv_id."' and `product_id`='".$product_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventorInput : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function UpdateInventorInputStatus($connexion,$inv_id,$product_id,$status)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventoryinputs` SET `recieved`='".$status."' WHERE `inv_id`='".$inv_id."' and `product_id`='".$product_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventorInput : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function UpdateInventorInputsStatus($connexion,$inv_id,$status)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventoryinputs` SET `recieved`='".$status."' WHERE `inv_id`='".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventorInput : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function UpdateInventoryDateFacture($connexion,$inv_id,$date)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventories` SET `date_facture`='".$date."' WHERE `id`='".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventoryDateFacture : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function UpdateInventoryDatePaiement($connexion,$inv_id,$date)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventories` SET `date_paiement`='".$date."' WHERE `id`='".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventoryDateFacture : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function UpdateInventoryLivCost($connexion,$inv_id,$liv_cost)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventories` SET `liv_cost`='".$liv_cost."' WHERE `id`='".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventoryDateFacture : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function UpdateInventoryTotalCost($connexion,$inv_id,$new_total,$new_qte)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventories` SET `total_cost`=".$new_total.",total_qte=".$new_qte." WHERE `id`='".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventoryDateFacture : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function UpdateInventoryStatus($connexion,$inv_id,$status)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `inventories` SET `status`='".$status."' WHERE `id`='".$inv_id."'";
       $requete=$connexion->prepare($chercherPseudo);
        // echo "UpdateInventoryDateFacture : ";print_r($requete);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function InsertCategory($connexion, $name, $idParent, $enabled)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `categories`(`name`, `idParent`,`enabled`)
        VALUES ('".$name."',".$idParent.", ".$enabled.")";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
       // return 'la catégorie "'.$name.'" a été ajoutée avec succès';

    }
    catch(PDOException $e){
      // echo"echec de la connexion:".$e->getMessage();
      return -1;
      // return "une erreur s'est produite lors de l'ajout de la catégorie";

    }
}


?>