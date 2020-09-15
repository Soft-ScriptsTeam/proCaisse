<?php 
// require 'src/Controller/connect.php';
// require 'src/Controller/sales.php';
// require 'src/Controller/categories.php';
require '../Controller/main_controller.php';



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SoftCaisse - Produits</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="../js/html5shiv.js"></script>
	<script src="../js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php $currentPage = 'produits';?>
	<?php require 'navbar.php';?>
	<?php require 'sidebar.php' ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Ventes</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Ventes</h1>
			</div>
		</div><!--/.row-->

		<?php
		$action = 'ListPrds';
		if (isset($_POST['add_category']))
		{
			$isEnabled = 0;
			if (isset($_POST['isEnabled'])) {
				$isEnabled = 1;
			}
			InsertCategory($connexion, $_POST["model"], $_POST["category_id"], $isEnabled);
			$action = 'ListPrds';
		}
		if (isset($_POST['add_produit']))
		{
			InsertProduct($connexion, $_POST["model"], $_POST["brand_id"], $_POST["category_id"], $_POST["price"], $_POST["supplyPrice"], $_POST["taxe_id"]);
			$action = 'ListPrds';
		}
		else if (isset($_POST['delete_produit'])) {
			$prd_id = $_POST['prd_id'];
			DeleteProduct($connexion,$prd_id);
			$action = 'ListPrds';
		}
		else if (isset($_POST['see_produit'])) {
			$prd_id = $_POST['prd_id'];
			$action = "EditPrd";
		}
		else if (isset($_POST['edit_produit'])) {
			print_r($_POST);
			EditProduct($connexion,$_POST['id'], $_POST['model'], $_POST['barcode'], $_POST['brand_id'], $_POST['supplier_id'], $_POST['price'], $_POST['supplyPrice'], $_POST['discountPrice'], $_POST['category_id'], "NULL","NULL", $_POST['supplierReference'],"NULL","NULL", "NULL", "NULL", "");
			$action = "EditPrd";
			$prd_id = $_POST['id'];
		}
		else if (isset($_POST['to_listPrd'])) {
			$action = 'ListPrds';
		}
		else if (isset($_POST['importe_image'])) {
			$prd_id = $_POST['prd_id'];
			$file = $_FILES['image'];
			ImportImage($connexion,$file,$prd_id);
			$action = "EditPrd";
		}
		else;
		 
		print_r($_POST);

		if ($action=='ListPrds') {
		?>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<!-- <div class="panel panel-default hidden"> -->
					<div class="panel-body">
						<form class="form-horizontal" action="" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<div class="col-md-3">
										<input id="name" name="name" type="text" placeholder="ID/Code Barre/Libille" class="form-control">
									</div>
									<div class="col-md-4">
										<button type="submit" class="btn btn-primary btn-lg">Recherch</button>
									</div>
									<!-- CreateNewCategory -->
									<div class="col-md-5 widget-right">
										<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#CreateNewCategory">
										<em class="fa fa-plus"></em> Cree Une Categorie</button>
										<button type="button" class="btn btn-success btn-lg pull-right" data-toggle="modal" data-target="#CreateNewProduct">
										<em class="fa fa-plus"></em> Cree Un Produit</button>
									</div>
								</div>
								
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<?php 
				$requet_prod = GetProducts($connexion);
			?>
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-body tabs">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<table class="table table-striped">
								  <thead>
								    <tr>
								      <th scope="col">ID</th>
								      <th scope="col">Image</th>
								      <th scope="col">Libele</th>
								      <th scope="col">Prix de Vente</th>
								      <th scope="col"> </th>
								      <th scope="col" style="background-color: ;color: ;"> </th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php 
								  		 while ( $value=$requet_prod->fetch()){
								  				echo "<tr>
												      <th scope='row'>".$value['id']."</th>
												      <td>
												      <div class='card'>
													  	<img class='card-img-top' src='../".$value['image_link']."' alt='Card image'>
													  </div></td>
												      <td>
												      		<button type='button' class='btn btn-link'>".$value['model']."</button>
												      		<br>
												      		<button type='button' class='btn btn-warning' style='color:".$value['category_color'].";background-color:".$value['category_bckColor']."; ba'>".$value['category_name']."
												      		</button>
												      </td>
												      <td>".$value['price']."  MAD</td>
												      <td> OUT:0 </td>
												      <td>
												      <form action='products.php' method='post'>
												      	<input type='hidden' name='prd_id' value='".$value['id']."'/>
												      	<button type='submit' class='btn btn-primary' name='see_produit'><em class='fa fa-file-o'></em></button>
														<button type='submit' class='btn btn-danger' name='delete_produit'><em class='fa fa-trash'></em></button>
												      </form>
												      </td>
												    </tr>";
								  		}
								  	?>
								   
								  </tbody>
								</table>
							</div>
						</div>
				</div><!--/.panel-->
			</div><!--/.col-->
		</div>

		<?php
	}
	else if($action=='EditPrd') {
			
			$current_product = GetProduct($connexion,$prd_id);
			$listSuppliers = GetSuppliers($connexion);
			
			
		?>
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<form action="products.php" method="post">
							Editer Produit 
							<button type="submit" class="btn btn-md btn-link pull-right" name="to_listPrd"><em class="fa fa-arrow-left"></em> Retour</button>	
						</form>
					</div>
					<div class="panel-body">
						<div class="col-sm-12">
							<div class="col-sm-2">
								<div class='card'>
									<?php echo "<img class='card-img-top' src='../".$current_product['image_link']."' alt='Card image'>" ?>
								  </div>
							</div>
							<div class="col-sm-10">
								<?php echo "<h2>".$current_product['model']."</h2>";?>
								<?php echo "<button type='button' class='btn btn-warning btn-lg' style='color:".$current_product['category_color'].";background-color:".$current_product['category_bckColor']."; ba'>".$current_product['category_name']."
												      		</button>";?>
								<?php echo "<h2>".$current_product['price']." MAD</h2>";?>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<form class="form-horizontal" action="products.php" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="col-sm-6">
									<h4>Informations produit</h4>
									<div class="form-group">
										<label class="col-md-3 control-label" for="name">Libellé</label>
										<?php echo "<div class='col-md-9'>
											<input id='id' name='id' type='hidden' value ='".$current_product['id']."' class='form-control'>
										</div>";?>
										<?php echo "<div class='col-md-9'>
											<input id='model' name='model' type='text' value ='".$current_product['model']."' class='form-control'>
										</div>";?>
										
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Catégorie</label>
										<div class="col-md-9">
											<select class="form-control" name='category_id'>
												<option value=NULL>veuillez choisir une catégorie</option>
												<?php 
												$listCategories = GetCategories($connexion);
												while ( $value=$listCategories->fetch())
												{
													if ($value['id']==$current_product['category_id']) 
														echo "<option  value='".$value['id']."'  selected>".$value["name"]."</option>";
														
													else
														echo "<option value='".$value['id']."' >".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Marque</label>
										<div class="col-md-9">
											<select class="form-control" name='brand_id'>
												<option value=NULL>veuillez choisir une marque</option>
												<?php 
												$listBrands = GetBrands($connexion);
												while ( $value=$listBrands->fetch())
												{
													if ($value['id']==$current_product['brand_id']) 
														echo "<option value='".$value['id']."'  selected>".$value["name"]."</option>";
														
													else
														echo "<option value='".$value['id']."'>".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<h4>Prix d'achat et fournisseur</h4>
									<div class="form-group">
										<label class="col-md-3 control-label" for="email">Prix d'achat HT</label>
										<?php echo "<div class='col-md-9'>
											<input id='supplyPrice'name='supplyPrice' type='number' value ='".$current_product['supplyPrice']."' class='form-control'>
										</div>";?>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Fournisseur</label>
										<div class="col-md-9">
											<select class="form-control"  name='supplier_id'>
												<option value=NULL>veuillez choisir un fournisseur</option>

												<?php 
												while ( $value=$listSuppliers->fetch())
												{
													if ($value['id']==$current_product['supplier_id']) 
														echo "<option value='".$value['id']."'  selected>".$value["name"]."</option>";
														
													else
														echo "<option value='".$value['id']."' >".$value["name"]."</option>";
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="name">Ref. fournisseur</label>
										<?php echo "<div class='col-md-9'>
											<input id='supplierReference' name='supplierReference' type='text' value ='' class='form-control'>
										</div>";?>
									</div>
								</div>
								<div class="col-md-12">
									<hr>
								</div>
								<div class="col-sm-6">
									<h4>Prix de vente et taxes</h4>
									<div class="form-group">
										<label class="col-md-3 control-label" for="name">Prix de vente</label>
										<?php echo "<div class='col-md-9'>
											<input id='price' name='price' type='number' value ='".$current_product['price']."' class='form-control'>
										</div>";?>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label" for="name">Prix soldé</label>
											<?php echo "<div class='col-md-9'>
											<input id='discountPrice' name='discountPrice' type='number' value ='".$current_product['discountPrice']."' class='form-control'>
										</div>";?>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Taxe</label>
										<div class="col-md-9">
											<select class="form-control">
												<option>veuillez choisir une Taxe</option>
												<option>Option 2</option>
												<option>Option 3</option>
												<option>Option 4</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<hr>
								</div>
								<div class="col-sm-6">
									<h4>Gestion stock</h4>
									<div class="form-group">
										<label class="col-md-3 control-label" for="name">Code-barres</label>
										<?php echo "<div class='col-md-9'>
											<input id='barcode' name='barcode' type='number' value ='".$current_product['barcode']."' class='form-control'>
										</div>";?>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Gestion stock</label>
										<div class="col-md-9">
											<div class="checkbox">
											<label>
												<input type="checkbox" value="">
											</label>
										</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Emplacement</label>
										<div class="col-md-9">
											<select class="form-control">
												<option>veuillez choisir une marque</option>
												<option>Option 2</option>
												<option>Option 3</option>
												<option>Option 4</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<h4>Gestion des déclinaisons</h4>
									<div class="form-group">
										<label class="col-md-4 control-label" for="email">Type de déclinaison</label>
										<div class="col-md-8">
											<select class="form-control">
												<option>ce produit n'a pas de declinaison</option>
												<option>Option 2</option>
												<option>Option 3</option>
												<option>Option 4</option>
											</select>
										</div>
									</div>
									<h4>Divers</h4>
									<div class="form-group">
										<label class="col-md-3 control-label">Multiple </label>
										<div class="col-md-9">
											<select class="form-control">
												<option>1</option>
												<option>Option 2</option>
												<option>Option 3</option>
												<option>Option 4</option>
											</select>
										</div>
									</div>
							
								<!-- Email input-->
								
								
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-12 widget-right">
										<button type="submit" class="btn btn-primary btn-md pull-right" name="edit_produit">Sauvgarder</button>
									</div>
								</div>
							</fieldset>
						</form>
						<div class="col-md-12">
									<hr>
								</div>
						<div class="col-sm-6">
							<form action="products.php" method="post" enctype="multipart/form-data">
								<h4>Image</h4>
								<?php echo "<input id='prd_id' name='prd_id' type='hidden' value ='".$current_product['id']."' >";?>
								<div class="form-group">
									<div class='col-md-9'>
										<input type="file" name="image" class='form-control'>
									</div>
									<div class="col-md-3">
										<button type="submit" class="btn btn-primary btn-lg " name="importe_image">
											<em class='fa fa-upload'></em></button>
									</div>
								</div>
							</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php }
			
		?>
			</div>
			<div class="row">
				<!-- Modal -->
				<div class="modal fade" id="CreateNewProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h1 class="modal-title align-middle" id="exampleModalLongTitle">Créer un produit</h1>
				      </div>
				      <div class="modal-body">
				        <form class="form-horizontal" action="products.php" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Libellé</label>
									<div class="col-md-7">
										<input id="model" name="model" type="text" placeholder="Libellé" class="form-control">
									</div>
								</div>
								<!-- Category input-->
								<div class="form-group">
										<label class="col-md-3 control-label">Catégorie</label>
										<div class="col-md-7">
											<select class="form-control" name='category_id'>
												<option value=NULL selected>veuillez choisir une catégorie</option>
												<?php 
												$listCategories = GetCategories($connexion);
												while ( $value=$listCategories->fetch())
												{
													echo "<option value='".$value['id']."' >".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
									</div>

								<div class="form-group">
										<label class="col-md-3 control-label">Marque</label>
										<div class="col-md-7">
											<select class="form-control" name='brand_id'>
												<option value=NULL>veuillez choisir une marque</option>
												<?php 
												$listBrands = GetBrands($connexion);
												while ( $value=$listBrands->fetch())
												{
													if ($value['id']==$current_product['brand_id']) 
														echo "<option value='".$value['id']."'  selected>".$value["name"]."</option>";
														
													else
														echo "<option value='".$value['id']."'>".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
									</div>

								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="email">Prix de vente</label>
									<div class="col-md-5">
										<input id="price" name="price" type="number" class="form-control">
									</div>
								</div>
								
								<!-- Message body -->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Prix d'achat HT</label>
									<div class="col-md-5">
										<input id="supplyPrice" name="supplyPrice" type="number" class="form-control">
									</div>
								</div>

								<!-- Category input-->
								<div class="form-group">
										<label class="col-md-3 control-label">Taxe</label>
										<div class="col-md-7">
											<select class="form-control" name='taxe_id'>
												<?php 
												$listCategories = GetTaxes($connexion);
												while ( $value=$listCategories->fetch())
												{
													echo "<option value='".$value['id']."' >".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
									</div>
								
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-10 widget-right">
										<button type="submit" class="btn btn-primary btn-md pull-right" name="add_produit">Enregistre</button>
									</div>
								</div>
							</fieldset>
						</form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
			<div class="row">
				<!-- Modal -->
				<div class="modal fade" id="CreateNewCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-centered" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h1 class="modal-title align-middle" id="exampleModalLongTitle">Créer une Categorie</h1>
				      </div>
				      <div class="modal-body">
				        <form class="form-horizontal" action="products.php" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Nom</label>
									<div class="col-md-7">
										<input id="model" name="model" type="text" placeholder="Nom" class="form-control">
									</div>
								</div>
								<!-- Category input-->
								<div class="form-group">
										<label class="col-md-3 control-label">Catégorie Parent</label>
										<div class="col-md-7">
											<select class="form-control" name='category_id'>
												<option value=NULL selected>veuillez choisir une catégorie</option>
												<?php 
												$listCategories = GetCategories($connexion);
												while ( $value=$listCategories->fetch())
												{
													echo "<option value='".$value['id']."' >".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Enabled: </label>
										<div class="col-md-9">
											<div class="checkbox">
											<label>
												<input name="isEnabled" type="checkbox" value="">
											</label>
										</div>
										</div>
									</div>
								<!-- Email input-->
								<!-- <div class="form-group">
									<label class="col-md-3 control-label" for="email">Couleur de Fon</label>
									<div class="col-md-5">
										<input id="price" name="price" type="text" class="form-control">
									</div>
								</div> -->
								
								<!-- Message body -->
								<!-- <div class="form-group">
									<label class="col-md-3 control-label" for="name">Backgroun Couleur</label>
									<div class="col-md-5">
										<input id="supplyPrice" name="supplyPrice" type="number" class="form-control">
									</div>
								</div> -->

								<!-- Category input-->
								<!-- <div class="form-group">
										<label class="col-md-3 control-label">Taxe</label>
										<div class="col-md-7">
											<select class="form-control" name='taxe_id'>
												<?php 
												$listCategories = GetTaxes($connexion);
												while ( $value=$listCategories->fetch())
												{
													echo "<option value='".$value['id']."' >".$value["name"]." </option>";
												}
												?>
											</select>
										</div>
								</div> -->
								
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-10 widget-right">
										<button type="submit" class="btn btn-primary btn-md pull-right" name="add_category">Enregistre</button>
									</div>
								</div>
							</fieldset>
						</form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
				<p class="back-link">SoftCaisse Theme by <a href="https://www.softandscripts.com">Soft&Scripts</a></p>
			</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	
	<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/chart.min.js"></script>
	<script src="../js/chart-data.js"></script>
	<script src="../js/easypiechart.js"></script>
	<script src="../js/easypiechart-data.js"></script>
	<script src="../js/bootstrap-datepicker.js"></script>
	<script src="../js/custom.js"></script>
	<script>
		window.onload = function () {
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
	responsive: true,
	scaleLineColor: "rgba(0,0,0,.2)",
	scaleGridLineColor: "rgba(0,0,0,.05)",
	scaleFontColor: "#c5c7cc"
	});
};
	</script>
		
</body>
</html>