<?php 
// require 'src/Controller/connection.php';
// require 'src/Controller/sales.php';
// require 'src/Controller/categories.php';
// require 'src/../Controller/main_controller.php';
require '../Controller/main_controller.php';



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SoftCaisse - Ventes</title>
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
	<?php $currentPage = 'ventes';?>
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
		$action = 'ListVentes';
		$sale_id = 1;
		$taken_money = 0;
		$currentCat ='3';
		if (!isset($_SESSION['userId'])) {
			header('location:../index.php');
		}
		if (isset($_POST['NewSale'])) 
		{
			if ($_POST['NewSale']) $sale_id = CreateSale_($connexion,$_SESSION['userId'],$_POST['NewSale']);
			else 
			$sale_id = CreateSale($connexion,$_SESSION['userId']);
			$action = 'SeeSale';

		}
		if (isset($_POST['DeleteSale'])) {
			$sale_id = $_POST['sale_id'];
			DeleteSale($connexion,$sale_id);
		}
		if (isset($_POST['AddPrd'])) 
		{
			$sale_id = $_POST['sale_id'];
			$currentCat = $_POST['cat_id'];
			AddToChart($connexion,$sale_id,$_POST['prd_id']);
			$action = 'SeeSale';
				
		}
		if (isset($_POST['AddQte'])) {
			$sale_id = $_POST['sale_id'];
			$product_id = $_POST['prd_id'];
			$qte = $_POST['prd_qte'];
			plusQte($connexion,$sale_id,$product_id,$qte+1);
			$action = 'SeeSale';
		}
		if (isset($_POST['RdcQte'])) {
			$sale_id = $_POST['sale_id'];
			$product_id = $_POST['prd_id'];
			$qte = $_POST['prd_qte'];
			if ($qte > 1) plusQte($connexion,$sale_id,$product_id,$qte-1);
			else DeleteSaleLine($connexion,$sale_id,$product_id);
			$action = 'SeeSale';
			 
			}
		if (isset($_POST['DltQte'])) {
				$sale_id = $_POST['sale_id'];
				$product_id = $_POST['prd_id'];
				DeleteSaleLine($connexion,$sale_id,$product_id);
				$action = 'SeeSale';
			}
		if (isset($_POST['VisitSale']))
		{
			// echo "pst : ".$_POST['sale_id']."<br>";
			$sale_id = $_POST['sale_id'];
			$action = 'ValidateSale';
		}
		if (isset($_POST['EditSale']))
		{
			// echo "pst : ".$_POST['sale_id']."<br>";
			if ($_POST['EditSale']) {
				$sale_id = $_POST['EditSale'];
			}
			else 
			$sale_id = $_POST['sale_id'];
			$action = 'SeeSale';
		}
		if (isset($_POST['RenduSale'])) {
			$sale_id = $_POST['sale_id'];
			$taken_money = $_POST['screen'];
			$action = 'ValidateSale';
		}
		if (isset($_POST['ValidateSale'])) {
				$sale_id = $_POST['sale_id'];
				$total = $_POST['total'];
				ValidateSale($connexion,$sale_id,$total);
				$action = 'ValidateSale';
			}
		if (isset($_POST['CloseSale'])) {
				$sale_id = $_POST['sale_id'];
				$paiement = $_POST['CloseSale'];
				CloseSale($connexion,$sale_id,$paiement);
				$action = 'ValidateSale';
		}
		if (isset($_POST['EditPaymentSale'])) {
			$sale_id = $_POST['sale_id'];
			$paiement = $_POST['EditPaymentSale'];
			EditPaymentSale($connexion,$sale_id,$paiement);
			$action = 'ValidateSale';
		}
		if (isset($_POST['BarCodeBtn']) || isset($_POST['BarCodeInput'])) {

			$sale_id = $_POST['sale_id'];
			$code_barre = $_POST['BarCodeInput'];
			$prd_id = GetProductId($connexion,$code_barre);
			AddToChart($connexion,$sale_id,$prd_id);
			$action = 'SeeSale';
		}
		if (isset($_POST['ClientCodeBtn']) || isset($_POST['ClientCodeInput'])) {
			if (isset($_POST['clt_id'])) {
				$sale_id = $_POST['clt_id'];
				$code_barre = $_POST['ClientCodeInput'];
				$prd_id = GetProductId($connexion,$code_barre);
				AddToChart($connexion,$sale_id,$prd_id);
				$action = 'SeeSale';
			}
		}
		// print_r($_POST);
		// echo "The Action : ".$action."</br>";
		// echo "The Sale : ".$sale_id."</br>";
		// print_r($_POST);echo "</br>";


		if ($action=='ListVentes') {
		?>

		<div class="row">

			
			<?php 
				$table_array = GetAvariableTables($connexion,$_SESSION['userId']);
				// print_r( $table_array);
				// print_r(array_key_exists("001",$table_array));
			?>

			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Salle !
						<span class="pull-right clickable panel-toggle"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<form class="form-horizontal" action="index.php" method="post">
							<fieldset>
								<!-- Name input-->

								<div class="form-group">
									<div class="col-md-8">
										<?php 
										if (array_key_exists("001",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['001']['sale_id']."'>Table 001</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="001" class="btn btn-lg btn-default btn-block">Table 001</button>';
										}
										?>
										
									</div>
									<div class="col-md-4">
										<?php
											if (array_key_exists("002",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['002']['sale_id']."'>Table 002</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="002" class="btn btn-lg btn-default btn-block">Table 002</button>';
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										<?php 
										if (array_key_exists("003",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['003']['sale_id']."'>Table 003</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="003" class="btn btn-lg btn-default btn-block">Table 003</button>';
										}
										?>
									</div>
									<div class="col-md-4">
										<?php 
										if (array_key_exists("004",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['004']['sale_id']."'>Table 004</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="004" class="btn btn-lg btn-default btn-block">Table 004</button>';
										}
										?>
									</div>
									<div class="col-md-4">
										<?php 
										if (array_key_exists("005",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['005']['sale_id']."'>Table 005</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="005" class="btn btn-lg btn-default btn-block">Table 005</button>';
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-8">
										<?php 
										if (array_key_exists("006",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['006']['sale_id']."'>Table 006</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="006" class="btn btn-lg btn-default btn-block">Table 006</button>';
										}
										?>
									</div>
									<div class="col-md-4">
										<?php 
										if (array_key_exists("007",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['007']['sale_id']."'>Table 007</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="007" class="btn btn-lg btn-default btn-block">Table 007</button>';
										}
										?>
									</div>
								</div>
								
							
							</fieldset>
						</form>
					</div>
				</div>
			</div><!--/.col-->
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Salle !
						<span class="pull-right clickable panel-toggle"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<form class="form-horizontal" action="index.php" method="post">
							<fieldset>
								<!-- Name input-->

								<div class="form-group">
									<div class="col-md-8">
										<?php 
										if (array_key_exists("008",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['008']['sale_id']."'>Table 008</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="008" class="btn btn-lg btn-default btn-block">Table 008</button>';
										}
										?>
										
									</div>
									<div class="col-md-4">
										<?php
											if (array_key_exists("009",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['009']['sale_id']."'>Table 009</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="009" class="btn btn-lg btn-default btn-block">Table 009</button>';
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										<?php 
										if (array_key_exists("010",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['010']['sale_id']."'>Table 010</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="010" class="btn btn-lg btn-default btn-block">Table 010</button>';
										}
										?>
									</div>
									<div class="col-md-4">
										<?php 
										if (array_key_exists("011",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['011']['sale_id']."'>Table 011</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="011" class="btn btn-lg btn-default btn-block">Table 011</button>';
										}
										?>
									</div>
									<div class="col-md-4">
										<?php 
										if (array_key_exists("012",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['012']['sale_id']."'>Table 012</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="012" class="btn btn-lg btn-default btn-block">Table 012</button>';
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-8">
										<?php 
										if (array_key_exists("013",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['013']['sale_id']."'>Table 013</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="013" class="btn btn-lg btn-default btn-block">Table 013</button>';
										}
										?>
									</div>
									<div class="col-md-4">
										<?php 
										if (array_key_exists("014",$table_array)) {
											echo "<button type='submit' class='btn  btn-lg btn-primary btn-block' name='EditSale' value='".$table_array['014']['sale_id']."'>Table 014</button>";
										}
										else {
											echo '<button type="submit" name="NewSale" value="014" class="btn btn-lg btn-default btn-block">Table 014</button>';
										}
										?>
									</div>
								</div>
								
							
							</fieldset>
						</form>
					</div>
				</div>
			</div><!--/.col-->


		<?php
	}
	else {
		
		if ($action == 'SeeSale') {
			// print_r($sale_id);
			$current_sale = GetSale($connexion,$sale_id);
		
		?>
			<div class="col-sm-7">
				<div class="panel panel-default">
					<div class="panel-heading">
						<form action="index.php" method ="post" class="form-group">
							<div class="col-md-3">
								<button type="submit" class="btn btn-md btn-primary pull-left"><em class="fa fa-arrow-left"></em></button>
							</div>
						</form>
					</div>
					<div class="panel-body">
						<div class="panel panel-default">
							<div class="panel-body tabs">
								<ul class="nav nav-pills nav-stacked col-md-3">
									<?php
										$list_cat = GetCategories($connexion);
										// print_r($list_cat);
										 while ( $value=$list_cat->fetch()) {
											// echo "=".$value['category_id']."=";
											if ($value['id']=='1') {
												echo "<li class='active'><a href='#pilltab1' data-toggle='tab'>".$value['name']."</a></li>";
											}
											else echo "<li><a href='#pilltab".$value['id']."' data-toggle='tab'>".$value['name']."</a></li>";
										}
									?>
									<!-- <li class="active"><a href="#pilltab1" data-toggle="tab">Cat 1</a></li>
									<li><a href="#pilltab2" data-toggle="tab">Cat 2</a></li>
									<li><a href="#pilltab3" data-toggle="tab">Cat 3</a></li> -->
								</ul>
								<div class="tab-content col-md-9">
									<?php
										$cnd = '';
										
										$list_cat = GetCategories($connexion);
										// print_r($list_prods);echo "<br>";
										
										while ( $value=$list_cat->fetch()) {
											// print_r($value);
											$cnd = '';
											if ($value['id']==$currentCat) $cnd='in active';

											echo '<div class="tab-pane fade '.$cnd.'" id="pilltab'.$value['id'].'">
												<h4>'.$value['name'].'</h4>
												<div class="row">';
											$list_prods = GetProducts($connexion);
											while ( $valuep=$list_prods->fetch()) {
												if ($valuep['category_id']==$value['id']){
													echo '<div class="col-sm-3">
															<div class="card text-center">
															  <img src="'.$valuep['image_link'].'" class="card-img-top" >
															  <div class="card-img-overlay">
															  	<h5 class="card-title">'.$valuep['model'].'</h5>
															    <form action="index.php" method="post">
															    	<input id="sale_id" name="sale_id" type="hidden" class="form-control input-md" value="'.$sale_id.'" />
															    	<input id="prd_id" name="prd_id" type="hidden" class="form-control input-md" value="'.$valuep['id'].'" />
															    	<input id="cat_id" name="cat_id" type="hidden" class="form-control input-md" value="'.$value['id'].'" />
															    	<button type="submit" class="btn btn-primary" name="AddPrd" value="AddPrd"><em class="fa fa-plus"></em></button>
															    </form>
															  </div>
															</div>
														</div>';
													}
											}
											echo "</div></div>";
											# code...
										}
									?>
								</div>
							</div>
						</div><!--/.panel-->
					</div>
				</div>
			</div>

		<?php 
			}
			$current_sale = GetSale($connexion,$sale_id);
			if ($action == 'ValidateSale') {
		?>
			<div class="col-sm-7">
				<div class="panel panel-default">
					<form action="index.php" method="post">
					<div class="panel-heading">
						Paiement
						
							<button type="submit" class="btn btn-md btn-link pull-right" name="back" ><em class="fa fa-arrow-left"></em> Retour</button>
						
					</div>
					</form> 
					<div class="panel-body">
					
						<?php 
							if ($current_sale['completedAt']!='0000-00-00 00:00:00') {
						?>
							<div class="alert bg-success" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Cette vente a été cloturée, il n'est donc pas possible d'y ajouter de nouveaux produits</div>
							<center>
								<h4>Date de validation : <?php echo $current_sale['completedAt'] ?></h4>
								<h4>Date de création : <?php echo $current_sale['createdAt'] ?></h4>
								<h4>ID : 2020-08-1-6</h4>
								<h4>Z : 20200819</h4>
								<h4>Total : <?php echo $current_sale['total'] ?> DH</h4>
							</center>
						<?php 
							}
							else echo "<h4>Total :  ".$current_sale['total']."</h4>";
						?>
						
						<div class="row">
							<div class="col-md-12">
								<form method="post" action="index.php">
								<?php 
								$actif_CCard ="";
								$actif_Cash ="";
								$actif_Div ="";
								$paiement = "";
								if ($current_sale['payment']=='CCARD')
									{
										$actif_CCard =" active";
										$paiement = "CCARD";
									}
								else if ($current_sale['payment']=='CASH')
									{ 
										$actif_Cash =" active";
										$paiement = "CASH";
									}
								else
									{ 
										$actif_Div =" active";
										$paiement = "DIV";
									}

								echo '<input type="hidden" name="sale_id" value="'.$current_sale['id'].'">';
								echo '<button type="submit" class="btn btn-lg btn-default'.$actif_CCard.'" name="EditPaymentSale" value="CCARD"><em class="fa fa-credit-card-alt"></em> CCard</button> ';
								echo '<button type=submitn" class="btn btn-lg btn-default'.$actif_Cash.'" name="EditPaymentSale" value="CASH"><em class="fa fa-money"></em> Cash</button> ';
								// echo '<button type="submit" name="" class="btn btn-lg btn-default'.$actif_Div.'" name=""><em class="fa fa-scissors"></em> Div</button>';
								?>
								</form>
							</div>
							</div>
						<hr>
						<?php 
							 if ($current_sale['payment']=='CASH'){
						?>
						<div class="row">
							<form class="col-md-4 form-horizontal" name="calculator" method="post" action="index.php">
								<div class="form-group" >
									<div class="col-md-10">
										<?php 
											echo '<input type="hidden" name="sale_id" value="'.$current_sale['id'].'">';
											echo '<input id="screen" name="screen" type="text"  class="form-control" value='.$taken_money.'>';
										?>
										
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-3">
										<button type="button" name="" name="b7" class="btn btn-default btn-md" onClick="calcNumbers(7)">7</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="b8" class="btn btn-default btn-md" onClick="calcNumbers(8)">8</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="b9" class="btn btn-default btn-md" onClick="calcNumbers(9)">9</button>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-3">
										<button type="button" name="" name="b4" class="btn btn-default btn-md" onClick="calcNumbers(4)">4</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="b5" class="btn btn-default btn-md" onClick="calcNumbers(5)">5</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="b6" class="btn btn-default btn-md" onClick="calcNumbers(6)">6</button>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-3">
										<button type="button" name="" name="b1" class="btn btn-default btn-md" onClick="calcNumbers(1)">1</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="b2" class="btn btn-default btn-md" onClick="calcNumbers(2)">2</button>
									</div>
									<div class="col-md-3">
										<button type="submit" name="" name="b3" class="btn btn-default btn-md" onClick="calcNumbers(3)">3</button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-3">
										<button type="button" name="" name="b0" class="btn btn-default btn-md" onClick="calcNumbers(0)">0</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="b." class="btn btn-default btn-md" onClick="calcNumbers('.')">.</button>
									</div>
									<div class="col-md-3">
										<button type="button" name="" name="trash" class="btn btn-default btn-md" onClick="calcNumbers(-1)"><em class="fa fa-trash"></em></button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-10">
										<button type="submit" name="RenduSale" class="btn btn-primary btn-block ">rendu</button>
									</div>
								</div>
							</form>
							<div class="col-md-8">
							<?php if($taken_money) 
								{ ?>
								
								<h4>Donne : <?php echo $taken_money; ?></h4>
								<h4>Rendue : <?php echo $taken_money-$current_sale['total']; ?></h4>
								
							<?php }?>
							<button type="submit" name="" class="btn btn-lg btn-info btn-block"><em class="fa fa-money"></em> Overture tiroir</button>
								</div>
						</div>


					<?php }?>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<button type="submit" name="" class="btn btn-lg btn-info"><em class="fa fa-print"></em> Imprimer Ticket</button>
								<button type="submit" name="" class="btn btn-lg btn-info"><em class="fa fa-file-o"></em> PDF A4</button>
								<button type="submit" name="" class="btn btn-lg btn-info"><em class="fa a-paper-plane"></em> Email</button>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<form method="post" action="index.php">
							<div class="input-group col-lg-12">
							<input type="hidden" name="sale_id" <?php echo 'value="'.$sale_id.'"'; ?> >
							<input type="hidden" name="paiement" <?php echo 'value="'.$paiement.'"'; ?> >
							<?php 
							if ($current_sale['completedAt']=='0000-00-00 00:00:00') {
							?>
								<button type="submit" class="btn btn-primary btn-lg btn-block" name="CloseSale" value="CASH">Valider Vente</button>
							<?php }
							else {
								?>
							
							<button type="submit" class="btn btn-success btn-lg btn-block" value="NewSale" name="NewSale"><em class="fa fa-plus"></em> Nouvelle Vente</button>
							<?php }?>
						</div>
						</form>
						
					</div>
				</div>
			</div>
			<?php
			} 
				
			?>
			<div class="col-sm-5">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo "Vente ".$current_sale['id']." - ".$current_sale['createdAt']; ?>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="index.php" method="post">
							<fieldset>
								<!-- Name input-->
								<div class="form-group">
									<div class="col-md-9">
										<div class="input-group">
											<input id="ClientCodeInput" name="ClientCodeInput" type="text" class="form-control input-md" placeholder="Information Client" /><span class="input-group-btn">
												<button class="btn btn-primary btn-md" id="btn-chat" name="ClientCodeBtn"><em class="fa fa-check"></em></button>
											</span>
										</div>
									</div>
									
								</div>
								<hr>
								<!-- Email input-->
								<div class="form-group">
									<div class="col-md-12">
										<ul class="todo-list">
								<?php 
									
									$list_sale_line = GetSaleLines($connexion,$sale_id);
									$somme = 0;
									$cpt = 0;
									while ( $value=$list_sale_line->fetch()) {
										// print_r($value);
										$somme += $value['quantity']*$value['price'];
										$cpt ++;
										echo '<li class="todo-list-item">
												<div class="checkbox">
													<input type="checkbox" id="checkbox-1" />
													<label for="checkbox-1">'.$value['quantity'].' x '.$value['model'].'</label>
												</div>

												<div class="pull-right action-buttons"> 
												<form action="index.php" method="post">
												<input id="sale_id" name="sale_id" type="hidden" class="form-control input-md" value="'.$sale_id.'" />
												<input id="prd_id" name="prd_id" type="hidden" class="form-control input-md" value="'.$value['product_id'].'" />
												<input id="prd_qte" name="prd_qte" type="hidden" class="form-control input-md" value="'.$value['quantity'].'" />
												'.$value['quantity']*$value['price'].' DH
												<button type="submit" class="btn btn-sm btn-link"  value="AddQte" name="AddQte"><em class="fa fa-plus"></em></button>
												<button type="submit" class="btn btn-sm btn-link"  value="RdcQte" name="RdcQte"><em class="fa fa-minus"></em></button>
												<button type="submit" class="btn btn-sm btn-link"  value="DltQte" name="DltQte"><em class="fa fa-trash"></em></button>
												</form>
												</div>
											</li>';
									}
									if ($somme!=0) UpdateSale($connexion,$sale_id,$somme);
								?> 
										</ul>
									</div>
								</div>
								
								<!-- Message body -->
								<div class="form-group">
									<div class="col-md-12">
										<div class="panel panel-blue">
											<div class="panel-body">
												<p> <?php echo $cpt; ?> Article(s)</p>
												<dl>TOTAL MAD <span class="pull-right"><?php echo $somme." DH"; ?></span>
												</dl>
												<!-- <?php 
													$taxes = $current_sale['taxes'];
													foreach ($taxes as $key => $value) {
														echo '<p>dont TVA ('.$value['tax_value_p'].') <span class="pull-right">'.$value['total_vat'].'</span></p>';
													}
												?> -->
											</div>
										</div>
									</div>
								</div>
								<form method="post" action="index.php" name="BarCodeForm">
								<div class="form-group" >
									<div class="col-md-9">
										<div class="input-group">
											<?php echo'<input id="sale_id" name="sale_id" type="hidden" class="form-control input-md" value="'.$sale_id.'" />';?>
											<input id="BarCodeInput" name="BarCodeInput" class="form-control input-md" placeholder="Ajouter Produit" /><span class="input-group-btn">
												<button type="submit" class="btn btn-primary btn-md" name="BarCodeBtn" value="BarCodeBtn"><em class="fa fa-plus"></em></button>
											</span>
										</div>
									</div>
								</div>
								</form>
								<!-- Form actions -->
								<?php 
									if ($somme == 0) {
										echo '<form action="index.php" method="post">
									<div class="form-group">
										<div class="col-md-12">
											<input type="hidden" name="sale_id" value="'.$current_sale['id'].'">
											<button type="submit" class="btn btn-danger btn-lg col-md-12" value="DeleteSale" name="DeleteSale">
											<em class="fa fa-trash"></em> Supprimer Vente</button>
										</div>
									</div>
								</form>';
									}
								?>
								
								
								<form action="index.php" method="post">
									<?php echo '<input type="hidden" name="sale_id" value="'.$current_sale['id'].'">';?>
									<?php echo '<input type="hidden" name="total" value="'.$somme.'">';?>
									<?php 
									$disabled ='';
									if ($somme == 0 || $current_sale['completedAt']!='0000-00-00 00:00:00')$disabled = 'disabled';
									echo '<div class="form-group">
										<div class="col-md-12">
											<button type="submit" class="btn btn-success btn-lg col-md-12" value="ValidateSale" name="ValidateSale" '.$disabled.'>
											<em class="fa fa-credit-card-alt"></em> Paiement</button>
										</div>
									</div>';
									?>
								</form>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<?php }?>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
				<p class="back-link">SoftCaisse Theme by <a href="https://www.softandscripts.com">Soft&Scripts</a></p>
			</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	<script>
	function calcNumbers(result){
		// console.log(result);
		if (result==-1) 
		{
			calculator.screen.value='0';
		}
		else
		{
			if (calculator.screen.value==0)
				calculator.screen.value=result;
			else
				calculator.screen.value=calculator.screen.value+result;
		}
		
	}

	</script>
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