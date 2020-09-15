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
				<li class="active">Arrivages stock</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Arrivages stock</h1>
			</div>
		</div><!--/.row-->

		<?php
		$action = 'ListPrds';
		if (isset($_POST['add_entrer']))
		{
			CreateInventor($connexion, $_POST["model"], $_POST["supplier_id"]);
			$action = 'ListPrds';
		}

		else if (isset($_POST['delete_inv'])) {
			$inv_id = $_POST['inv_id'];
			DeleteInventor($connexion,$inv_id);
			$action = 'ListPrds';
		}
		else if (isset($_POST['see_inv'])) {
			$inv_id = $_POST['inv_id'];
			print_r($_POST);
			$action = "EditPrd";
		}
		else if (isset($_POST['add_product_by_ref'])) {
			$inv_id = $_POST['inv_id'];
			$resultat = GetInventorInput($connexion,$inv_id);
			if ($resultat) {
				
			}
			else {
				$input = $_POST['inputed'];
				$qte = $_POST['quantite'];
				$prd_id = GetProductId_($connexion,$input);
				InsertInventorInput($connexion,$inv_id,$prd_id,$qte);
			}
			
			$action = 'EditPrd';
		}
		else if (isset($_POST['qte_add_inv'])) {
			$inv_id = $_POST['inv_id'];
			$prd_id = $_POST['prd_id'];
			$qte = $_POST['qte'];
			UpdateInventorInput($connexion,$inv_id,$prd_id,$qte);
			$action = 'EditPrd';
		}
		if (isset($_POST['BarCodeBtn']) || isset($_POST['BarCodeInput'])) {
			$msg_error = '';
			$inv_id = $_POST['inv_id'];
			$resultat = GetInventorInput($connexion,$inv_id);
			if ($resultat) {
				
			}
			else {
				$code_barre = $_POST['BarCodeInput'];
				$prd_id = GetProductId($connexion,$code_barre);
				InsertInventorInput($connexion,$inv_id,$prd_id,1);
			}
			
			
			$action = 'EditPrd';
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
		else;
		 
		print_r($_POST);

		if ($action=='ListPrds') {
		?>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<!-- <div class="panel panel-default hidden"> -->
					<div class="panel-body">
						<form class="form-horizontal">
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
										<button type="button" class="btn btn-success btn-lg pull-right" data-toggle="modal" data-target="#CreateNewProduct">
										<em class="fa fa-plus"></em> Cree Un Arrivage</button>
									</div>
								</div>
								
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<?php 
				
			?>
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-body tabs">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<table class="table table-striped">
								  <thead>
								    <tr>
								      <th scope="col">Libelle</th>
								      <th scope="col">Date</th>
								      <th scope="col">Stock</th>
								      <th scope="col">Fournisseur</th>
								      <th scope="col">Quantite</th>
								      <th scope="col">Montant</th>
								      <th scope="col">Date de paiment</th>
								      <th scope="col">Status</th>
								      <th scope="col"> </th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php 
								  		$requet_prod = GetInventors($connexion);

								  		 while ( $value=$requet_prod->fetch()){
								  				echo "<tr>
												      <th scope='row'>".$value['label']."</th>
												      <td>".$value['date_facture']."
												      </td>
												      <td>".$value['stock']."
												      </td>
												      <td>
												      	<button type='button' class='btn btn-warning' >".$value['fournisseur']."
												      		</button>
												      </td>
												      <td></td>
												      <td></td>
												      <td>".$value['date_paiement']."
												      </td>
												      <td>
														<button type='button' class='btn btn-danger'>".$value['status']."</button>
												      </td>
												      <td>
												      <form action='invetories.php' method='post'>
												      	<input type='hidden' name='inv_id' value='".$value['label']."'/>";

												      	echo "<button type='submit' class='btn btn-primary' name='see_inv'><em class='fa fa-file-o'></em></button>";
														if ($value['status']=="E")
															echo "<button type='submit' class='btn btn-danger' name='delete_inv'><em class='fa fa-trash'></em></button>";
												      echo "</form>
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
		?>
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<form action="invetories.php" method="post">
							Arrivages stock : <?php echo $inv_id;?>
							<button type="submit" class="btn btn-md btn-link pull-right" name="to_listPrd"><em class="fa fa-arrow-left"></em> Retour</button>	
						</form>
					</div>
					<div class="col-sm-12">
						<form method="post" action="invetories.php" name="RefFourForm">
							<div class="form-group" >

								<div class="col-md-3">
									<input type="hidden" name="inv_id" <?php echo "value='".$inv_id."'";?>/>
									<input id="reffpornisseur" name="inputed" type="text" placeholder="Ref Fournisseur/Libille" class="form-control">
								</div>
								<div class="col-md-1">
									<input id="quantite" name="quantite" type="number" class="form-control">
								</div>
								<!-- CreateNewCategory -->
								<div class="col-md-5">
									<button name="add_product_by_ref" type="submit" class="btn btn-primary btn-lg">
									<em class="fa fa-plus"></em></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-sm-12">
						<form method="post" action="invetories.php" name="BarCodeForm">
							<div class="form-group" >
								<div class="col-md-6">
									<div class="input-group">
										<input type="hidden" name="inv_id" <?php echo "value='".$inv_id."'";?>/>
										<input id="BarCodeInput" name="BarCodeInput" class="form-control input-md" placeholder="Ajouter Produit" /><span class="input-group-btn">
											<button type="submit" class="btn btn-primary btn-md" name="BarCodeBtn" value="BarCodeBtn"><em class="fa fa-plus"></em></button>
										</span>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="panel-body tabs">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<table class="table table-striped">
								  <thead>
								    <tr>
								      <th scope="col">ID</th>
								      <th scope="col">Produit</th>
								      <th scope="col">Quantite</th>
								      <th scope="col">Prix d'achat HT</th>
								      <th scope="col">Total</th>
								      <th scope="col">Action</th>
								      <th scope="col"> </th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php
								  		$requet_inv = GetInventorInputs($connexion,$inv_id );
								  		$i = 0;
								  		$quantite_total = 0;
								  		$prix_total = 0;
								  		while ( $value=$requet_inv->fetch()){
								  			$quantite_total += $value['quantity'];
								  			$prix_total += $value['quantity']*$value['supplyPrice'];
					  				echo "<tr>
									      <th scope='row'>".$i."</th>
									      <td>
									      	<p>".$value['model']."</p>
									      	<p>Ref. fournisseur : ".$value['supplierReference']."</p>
									      	<p>Code-barres : ".$value['barcode']."</p>
									      </td>
									    <td class='col-md-1'>
									    	<form method='post' action='invetories.php' name='QuantityForm'>
												<div class='form-group'>
													
														<div class='input-group'>
															<input id='inv_id' name='inv_id' type='hidden' class='form-control input-md' value='".$inv_id."' />
														<div class='input-group'>
															<input id='prd_id' name='prd_id' type='hidden' class='form-control input-md' value='".$value['id']."' />
															<input name='qte' class='form-control input-md' value='".$value['quantity']."' /><span class='input-group-btn'>
																<button type='submit' class='btn btn-primary btn-md' name='qte_add_inv'><em class='fa fa-check'></em></button>
															</span>
														</div>
													</div>
												
												</form>
										</td>
										<td class='col-md-1'>
									    	<form method='post' action='invetories.php' name='SupplyPriceForm' >
												<div class='form-group'>
													
														<div class='input-group '>
															<input id='sale_id' name='sale_id' type='hidden' value='".$value['quantity']."' />
															<input id='BarCodeInput' name='BarCodeInput' class='form-control input-md ' value='".$value['supplyPrice']."' /><span class='input-group-btn'>
																<button type='submit' class='btn btn-primary btn-md' name='BarCodeBtn' value='BarCodeBtn'><em class='fa fa-check'></em></button>
															</span>
														</div>
													</div>
												
												</form>
										</td>
									      <td>".$value['quantity']*$value['supplyPrice']."</td>
									      <td></td>
									      <td>
									      <form action='invetories.php' method='post'>
												      	<input type='hidden' name='prd_id' value='".$inv_id."'/>";
												    if ($value['recieved']=='0') {
												    	echo "<button type='submit' class='btn btn-primary' name='see_produit'><em class='fa fa-thumbs-o-up'></em> receptionner</button>";
												    }
												    else {
												    	echo "<button type='submit' class='btn btn-warning' name='delete_produit'><em class='fa fa-thumbs-o-down'></em> dereceptionner</button>";
												    }
												      		echo "</form></td>";
												    
												    
													
									      
									    echo "</tr>";
									    $i++;
								  		}
								  		echo "
								  		<tr>
								  			<td colspan='2'><label>cout de livraison : </label></td>
									  		<td class='col-md-1'>
									  			<form method='post' action='invetories.php' name='PaieDateForm' >
												<div class='form-group'>
														<div class='input-group'>

															<input id='sale_id' name='sale_id' type='hidden' value='".$inv_id."' />
															<input id='BarCodeInput' name='BarCodeInput' class='form-control input-md ' value='".$value['quantity']."' /><span class='input-group-btn'>
																<button type='submit' class='btn btn-primary btn-md' name='BarCodeBtn' value='BarCodeBtn'><em class='fa fa-check'></em></button>
															</span>
														</div>
													</div>
												</form>
									  		</td>
								  		</tr>";
								  		echo "
								  		<tr>
								  			<td colspan='1'><label>Date de paiement : </label></td>
									  		<td colspan='6'>
									  			<form method='post' action='invetories.php' name='PaieDateForm' >
												<div class='form-group'>
														<div class='input-group'>

															<input id='sale_id' name='sale_id' type='hidden' value='".$inv_id."' />
															<input id='BarCodeInput' name='BarCodeInput' class='form-control input-md ' type='date' value='".$value['quantity']."' /><span class='input-group-btn'>
																<button type='submit' class='btn btn-primary btn-md' name='BarCodeBtn' value='BarCodeBtn'><em class='fa fa-check'></em></button>
															</span>
														</div>
													</div>
												</form>
									  		</td>
								  		</tr>";
								  		echo "
								  		<tr>
								  			<td colspan='1'><label>Date de Facture : </label></td>
									  		<td colspan='6'>
									  			<form method='post' action='invetories.php' name='PaieDateForm' >
												<div class='form-group'>
														<div class='input-group'>

															<input id='sale_id' name='sale_id' type='hidden' value='".$inv_id."' />
															<input id='BarCodeInput' name='BarCodeInput' class='form-control input-md '  type='date' value='".$value['quantity']."' /><span class='input-group-btn'>
																<button type='submit' class='btn btn-primary btn-md' name='BarCodeBtn' value='BarCodeBtn'><em class='fa fa-check'></em></button>
															</span>
														</div>
													</div>
												</form>
									  		</td>
								  		</tr>";
								  		echo "
								  		<tr>
								  			<td colspan='2'><label>Total: </label></td>
									  		<td colspan='2'>
									  			<label>".$quantite_total."</label></td>
									  		</td>
									  		<td colspan='2'>
									  			<label>".$prix_total."</label></td>
									  		</td>
								  		</tr>";
								  	?>
								  </tbody>
								</table>
							</div>
						</div>
				</div><!--/.panel-->
			</div><!--/.col-->
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
				        <h1 class="modal-title align-middle" id="exampleModalLongTitle">Créer un arrivage</h1>
				      </div>
				      <div class="modal-body">
				        <form class="form-horizontal" action="invetories.php" method="post">
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
										<label class="col-md-3 control-label">Fournisseurs</label>
										<div class="col-md-7">
											<select class="form-control" name='supplier_id'>
												<option value=NULL selected>veuillez choisir un fournisseur</option>
												<?php 
												$listSuppliers= GetSuppliers($connexion);
												while ( $value=$listSuppliers->fetch())
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
										<button type="submit" class="btn btn-primary btn-md pull-right" name="add_entrer">Enregistre</button>
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