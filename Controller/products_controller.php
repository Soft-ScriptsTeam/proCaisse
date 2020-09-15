<?php

function GetProductId($connexion,$code_barre)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id` FROM `products` WHERE `barcode`=".$code_barre;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       if ($resultat=$requete->fetch()) {
         return $resultat['id'];
       }

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetProductId_($connexion,$input)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `id` 
       FROM `products` WHERE `supplierReference`='".$input."' OR `model`='".$input."'";
       $requete=$connexion->prepare($chercherPseudo);
       
       // echo "GetProductId_ : ";print_r($requete);
       $requete->execute();
       if ($resultat=$requete->fetch()) {
         return $resultat['id'];
       }

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function GetProduct($connexion,$id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `products`.`id`, `model`, `barcode`, `brand_id`, `image_link`,  `supplier_id`, `price`, `supplyPrice`, `discountPrice`, `supplierReference`, `category_id` , `taxe_id` ,`name` as `category_name`,`bckColor` as `category_bckColor`, `color` as `category_color`, `sizeType_id`, `stockManagment`, `supplierReference`, `vat`, `display`, `arch`, `serialNumber`, `comments` FROM `products`, `categories` WHERE `products`.`category_id` = `categories`.`id` AND `products`.`id`=".$id;
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

function GetProducts($connexion)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="SELECT `products`.`id`, `model`, `barcode`, `brand_id`, `image_link`,  `supplier_id`, `price`, `supplyPrice`, `discountPrice`, `category_id`,`name` as `category_name`,`bckColor` as `category_bckColor`, `color` as `category_color`, `sizeType_id`, `stockManagment`, `supplierReference`, `vat`, `display`, `arch`, `serialNumber`, `comments` FROM `products`, `categories` WHERE `products`.`category_id` = `categories`.`id`";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
      return $requete;

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function InsertProduct($connexion, $model, $brand_id, $category_id, $price, $supplyPrice, $taxe_id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="INSERT INTO `products`( `model`, `brand_id`, `category_id`, `price`, `supplyPrice`, `taxe_id`) VALUES ('".$model."',".$brand_id.",".$category_id.",".$price.",".$supplyPrice.",".$taxe_id.")";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;

    }
    catch(PDOException $e){
      // echo"echec de la connexion:".$e->getMessage();
      return -1;
    }
}

function EditProduct($connexion,$id, $model, $barcode, $brand_id, $supplier_id, $price, $supplyPrice, $discountPrice, $category_id, $sizeType_id, $stockManagment, $supplierReference, $vat, $display, $arch, $serialNumber, $comments)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `products` SET `model`='".$model."',`barcode`='".$barcode."',`brand_id`=".$brand_id.",`supplier_id`=".$supplier_id.",`price`=".$price.",`supplyPrice`=".$supplyPrice.",`discountPrice`=".$discountPrice.",`category_id`=".$category_id.",`sizeType_id`=".$sizeType_id.",`stockManagment`=".$stockManagment.",`supplierReference`='".$supplierReference."',`vat`=".$vat.",`display`=".$display.",`arch`=".$arch.",`serialNumber`=".$serialNumber.",`comments`='".$comments."' WHERE `id`=".$id."";
       // echo "SQL :".$chercherPseudo."<br>";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;

    }
    catch(PDOException $e){
      // echo"echec de la connexion:".$e->getMessage();
      return -1;
    }
}

function EditProductSupplyPrice($connexion,$id, $supplyPrice)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `products` SET `supplyPrice`=".$supplyPrice." WHERE `id`=".$id."";
       echo "SQL :".$chercherPseudo."<br>";
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();

    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


function ImportImage($connexion,$file,$product_id)
{
  if (!isset($file['tmp_name']))
  echo "Please select a profile pic";
else
      {
      $target_dir = "../img/products_images/";
      
      // $target_file = $target_dir . basename($file["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
      $target_file = $target_dir . "produit_".$product_id.".".$imageFileType;

      // Check if image file is a actual image or fake image
      
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          echo "File is not an image.";
          $uploadOk = 0;
        }

      // Check if file already exists
      if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
      }

      echo "File Size: ".$file["size"];
      echo "File Type: ".$imageFileType;
      // Check file size
      // if ($file["size"] > 2500) {
      //   echo "Sorry, your file is too large.";
      //   $uploadOk = 0;
      // }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
      }
      echo "path".$file["tmp_name"];

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
          UpdateProductImage($connexion,$product_id,$target_file);
          echo "The file ". basename( $file["name"]). " has been uploaded.";
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }}
}

function UpdateProductImage($connexion,$id,$image_link)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="UPDATE `products` SET `image_link` = '".$image_link."' WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}

function DeleteProduct($connexion,$id)
{
  try{
       //requette de selection de l'enregistrement de l'utulisateur
       $chercherPseudo="DELETE FROM `products` WHERE `id`=".$id;
       $requete=$connexion->prepare($chercherPseudo);
       $requete->execute();
       return 1;
    }
    catch(PDOException $e){
      echo"echec de la connexion:".$e->getMessage();
    }
}


?>