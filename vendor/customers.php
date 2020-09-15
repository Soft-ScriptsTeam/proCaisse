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
	<title>SoftCaisse - Clients</title>
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
	<?php $currentPage = 'clients';?>
	<?php require 'navbar.php';?>
	<?php require 'sidebar.php' ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Clients</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Clients</h1>
			</div>
		</div><!--/.row-->

		<?php
		$action = 'ListClients';
		// $action = 'ListClients';
		if (isset($_POST['add_produit']))
		{
			InsertCustomer($connexion, $_POST["nom"], $_POST["prenom"], $_POST["email"], $_POST["tel"]);
			$action = 'ListClients';
		}
		else if (isset($_POST['delete_client'])) {
			$clt_id = $_POST['clt_id'];
			DeleteProduct($connexion,$clt_id);
			$action = 'ListClients';
		}
		else if (isset($_POST['see_client'])) {
			$clt_id = $_POST['clt_id'];
			$action = "EditClt";
		}
		else if (isset($_POST['edit_client'])) {
			// print_r($_POST);
			EditCustomer($connexion,$_POST['id'], $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['country'], $_POST['taxNumber'], $_POST['phoneNumber'], $_POST['birthDate']);
			$action = "EditClt";
			$clt_id = $_POST['id'];
		}
		else if (isset($_POST['to_listClt'])) {
			$action = 'ListClients';
		}
		else;
		echo "The Action : ".$action;

		if ($action=='ListClients') {
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
									<div class="col-md-4">
										<input id="name" name="name" type="text" placeholder="Nom/Prenom/Email/Id" class="form-control">
									</div>
									<div class="col-md-4">
										<button type="submit" class="btn btn-primary btn-lg">Recherch</button>
									</div>
									<div class="col-md-4 widget-right">
										<button type="button" class="btn btn-success btn-lg pull-right" data-toggle="modal" data-target="#CreateNewProduct">
										<em class="fa fa-plus"></em> Cree Un Client</button>
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
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1" data-toggle="tab">Clients Actif</a></li>
							<li><a href="#tab2" data-toggle="tab">Clients Inactif</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
								<table class="table table-striped">
								  <thead>
								    <tr>
								      <th scope="col">ID</th>
								      <th scope="col">Client</th>
								      <th scope="col">Ventes</th>
								      <th scope="col">CA</th>
								      <th scope="col">Points</th>
								      <th scope="col">Dernier achat</th>
								      <th scope="col"> </th>
								    </tr>
								  </thead>
								  <tbody>
								  	<?php 
								  		$requet_cust = GetCustomers($connexion);
								  		 while ( $value=$requet_cust->fetch()){
								  				echo "<tr>
												      <th scope='row'>".$value['id']."</th>
												      <td>".$value['firstName']." ".$value['lastName']."</td>
												      <td>".$value['ventes']."</td>
												      <td>".$value['CA']."</td>
												      <td>0</td>
												      <td>".$value['Dernier achat']."</td>
												      <td><form action='customers.php' method='post'>
												      	<input type='hidden' name='clt_id' value='".$value['id']."'/>
												      	<button type='submit' class='btn btn-primary' name='see_client'><em class='fa fa-file-o'></em></button>
												      </form></td>
												    </tr>";
								  		}
								  	?> 
								  </tbody>
								</table>
							</div>
							<div class="tab-pane fade in active" id="tab2">
								<table class="table table-striped">
								  <thead>
								    <tr>
								      <th scope="col">ID</th>
								      <th scope="col">Client</th>
								      <th scope="col"> </th>
								    </tr>
								  </thead>
								  <tbody>
								  <?php 
								  		$requet_cust = GetCustomers_($connexion);
								  		 while ( $value=$requet_cust->fetch()){
								  				echo "<tr>
												      <th scope='row'>".$value['id']."</th>
												      <td>".$value['firstName']." ".$value['lastName']."</td>
												      <td><form action='customers.php' method='post'>
												      	<input type='hidden' name='clt_id' value='".$value['id']."'/>
												      	<button type='submit' class='btn btn-primary' name='see_client'><em class='fa fa-file-o'></em></button>
												      </form></td>
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
	else if($action=='EditClt') {
		?>
			<div class="col-sm-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						Details Client
					</div>
					<?php $current_clt = GetCustomer($connexion,$clt_id );
						// print_r($current_clt);
					?>
					<div class="panel-body">
						<form class="form-horizontal" action="customers.php" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="name">Nom</label>
									<div class="col-md-7">
										<?php echo '<input id="id" name="id" type="hidden" class="form-control" value="'.$current_clt['id'].'">';?>
										<?php echo '<input id="firstName" name="firstName" type="text"class="form-control" value="'.$current_clt['firstName'].'">';?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-5 control-label" for="name">Prenom</label>
									<div class="col-md-7">
										<?php echo '<input id="lastName" name="lastName" type="text"class="form-control" value="'.$current_clt['lastName'].'">';?>
									</div>
								</div>
							
								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="email">E-mail</label>
									<div class="col-md-7">
										<?php echo '<input id="email" name="email" type="text" class="form-control" value="'.$current_clt['email'].'">';?>
									</div>
								</div>

								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="email">Pays</label>
									<div class="col-md-7">
										<?php echo '<input id="country" name="country" type="text" class="form-control" value="'.$current_clt['country'].'">';?>
									</div>
								</div>

								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="email">Numéro de taxe</label>
									<div class="col-md-7">
										<?php echo '<input id="taxNumber" name="taxNumber" type="text" class="form-control" value="'.$current_clt['taxNumber'].'">';?>
									</div>
								</div>

								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="email">Téléphone</label>
									<div class="col-md-7">
										<?php echo '<input id="phoneNumber" name="phoneNumber" type="number" class="form-control" value="'.$current_clt['phoneNumber'].'">';?>
									</div>
								</div>
								
								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="email">Date de naissance</label>
									<div class="col-md-7">
										<?php echo '<input id="birthDate" name="birthDate" type="date" class="form-control" value="'.$current_clt['birthDate'].'">';?>
									</div>
								</div>

								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-5 control-label" for="email">Validité</label>
									<div class="col-md-7">
										<?php echo '<input id="vat" name="vat" type="text" class="form-control" value="'.$current_clt['vat'].'">';?>
									</div>
								</div>
								
								<!-- Form actions -->
								<div class="form-group">
									<div class="col-md-12 widget-right">
										<button type="submit" class="btn btn-default btn-md pull-right" name="edit_client">Enregistre</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-8">

				<div class="panel panel-default">
					<div class="panel-heading">
						<form action="customers.php" method="post">
							Editer Produit 
							<button type="submit" class="btn btn-md btn-link pull-right" name="to_listClt"><em class="fa fa-arrow-left"></em> Retour</button>	
						</form>
					</div>
					<div class="panel-body">
						<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-blue"></em>
							<h3>CA</h3>
							<div class="text-muted"><?php echo $current_clt['CA'];?></div>
							
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-comments color-orange"></em>
							<h3>Ventes</h3>
							<div class="text-muted"><?php echo $current_clt['sales'];?></div>
							
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-teal"></em>
							<h3 >Fidélité</h3>
							<div class="text-muted"><?php echo $current_clt['sales'];?></div>
							
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-search color-red"></em>
							<h3>Dernier achat</h3>
							<div class="text-muted"><?php echo $current_clt['lastSale'];?></div>
							
						</div>
					</div>
				</div>
			</div><!--/.row-->
			<hr>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="panel-group" id="accordion">
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h3 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Ventes validées</a>
				      </h3>
				    </div>
				    <div id="collapse1" class="panel-collapse collapse">
				      <div class="panel-body">
				      	<table class="table table-striped">
					  <thead>
					    <tr>
					      <th scope="col">ID</th>
					      <th scope="col">Date</th>
					      <th scope="col">Mode De Paiement</th>
					      <th scope="col">Montant</th>
					      <th scope="col">Points</th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					  <?php 

					  		$requet_cust = GetCustomerValidatedSales($connexion,$clt_id );
					  		$somme_total = 0;
					  		$somme_pts=0;
					  		 while ( $value=$requet_cust->fetch()){
					  		 	$somme_total += $value['total'];
					  			$somme_pts +=1;
					  				echo "<tr>
									      <th scope='row'>".$value['id']."</th>
									      <td>".$value['createdAt']."</td>
									      <td>".$value['payment']."</td>
									      <td>".$value['total']."</td>
									      <td>0</td>
									      <td><form action='index.php' method='post'>
									      	<input type='hidden' name='sale_id' value='".$value['id']."'/>
									      	<button type='submit' class='btn btn-primary' name='VisitSale' value='VisitSale'><em class='fa fa-file-o'></em></button>
									      </form></td>
									    </tr>";
					  		}
					  		if ($somme_total)
					  		echo "
					  		<tr>
						  		<td colspan='3'>Total</td>
						  		<td>".$somme_total."</td>
						  		<td>".$somme_pts."</td>
					  		</tr>";
					  		else echo "
					  		<tr>
						  		<td colspan='6'>Il n'y a pas de ventes pour ce client.</td>
					  		</tr>";
					  	?> 

					  	
					  </tbody>
					</table>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Ventes en attente</a>
				      </h4>
				    </div>
				    <div id="collapse2" class="panel-collapse collapse">
				      <div class="panel-body">
					<table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">ID</th>
						      <th scope="col">Date</th>
						      <th scope="col">Mode De Paiement</th>
						      <th scope="col">Montant</th>
						      <th scope="col">Points</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
						  <?php 

						  		$requet_cust = GetCustomerUnValidatedSales($connexion,$clt_id );
						  		$somme_total = 0;
						  		$somme_pts=0;
						  		 while ( $value=$requet_cust->fetch()){
						  		 	$somme_total += $value['total'];
						  			$somme_pts +=1;
						  				echo "<tr>
										      <th scope='row'>".$value['id']."</th>
										      <td>".$value['createdAt']."</td>
										      <td>".$value['payment']."</td>
										      <td>".$value['total']."</td>
										      <td>0</td>
										      <td><form action='index.php' method='post'>
										      	<input type='hidden' name='sale_id' value='".$value['id']."'/>
										      	<button type='submit' class='btn btn-primary' name='EditSale' value='EditSale'><em class='fa fa-file-o'></em></button>
										      </form></td>
										    </tr>";
						  		}
						  		if ($somme_total)
						  		echo "
						  		<tr>
							  		<td colspan='3'>Total</td>
							  		<td>".$somme_total."</td>
							  		<td>".$somme_pts."</td>
						  		</tr>";
						  		else echo "
						  		<tr>
							  		<td colspan='6'>Il n'y a pas de ventes pour ce client.</td>
						  		</tr>";
						  	?> 

						  	
						  </tbody>
						</table>
				      </div>
				    </div>
				  </div>
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Produits</a>
				      </h4>
				    </div>
				    <div id="collapse3" class="panel-collapse collapse">
				      <div class="panel-body"><table class="table table-striped">
						  <thead>
						    <tr>
						      <th scope="col">ID</th>
						      <th scope="col">Produit</th>
						      <th scope="col">Prix</th>
						      <th scope="col">Quantite</th>
						      <th scope="col">Points</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
						  <?php 

						  		$requet_cust = GetCustomerProducts($connexion,$clt_id );
						  		$somme_total = 0;
						  			$somme_pts =0;
						  		 while ( $value=$requet_cust->fetch()){
						  		 	$somme_total += $value['price'];
						  			$somme_pts +=0;
						  				echo "<tr>
										      <th scope='row'>".$value['sale_id']."</th>
										      <td>".$value['model']."</td>
										      <td>".$value['price']."</td>
										      <td>".$value['quantity']."</td>
										      <td>0</td>
										      <td><form action='products.php' method='post'>
												      	<input type='hidden' name='prd_id' value='".$value['id']."'/>
												      	<button type='submit' class='btn btn-primary' name='see_client'><em class='fa fa-file-o'></em></button>
												      </form></td>
										    </tr>";
						  		}
						  		if ($somme_total)
						  		echo "
						  		<tr>
							  		<td colspan='2'>Total</td>
							  		<td>".$somme_total."</td>
							  		<td> </td>
							  		<td>".$somme_pts."</td>
						  		</tr>";
						  		else echo "
						  		<tr>
							  		<td colspan='6'>Il n'y a pas de ventes pour ce client.</td>
						  		</tr>";
						  	?> 

						  	
						  </tbody>
						</table></div>
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
				        	<center>
				        		<h3 class="modal-title align-middle" id="exampleModalLongTitle">Créer un Client</h3>
				        	</center>
				      </div>
				      <div class="modal-body">
				        <form class="form-horizontal" action="customers.php" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="name">Nom</label>
									<div class="col-md-7">
										<input id="nom" name="nom" type="text" placeholder="" class="form-control">
									</div>
								</div>
								<!-- Category input-->
								<div class="form-group">
										<label class="col-md-3 control-label">Prénom</label>
										<div class="col-md-7">
										<input id="prenom" name="prenom" type="text" placeholder="" class="form-control">
									</div>
									</div>

								<div class="form-group">
										<label class="col-md-3 control-label">Email</label>
										<div class="col-md-7">
										<input id="email" name="email" type="text" placeholder="" class="form-control">
									</div>
									</div>

								<!-- Email input-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="email">Telephone</label>
									<div class="col-md-7">
										<input id="tel" name="tel" type="Number" placeholder="" class="form-control">
									</div>
								</div>
								
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