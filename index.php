<?php 
session_start();
// require 'src/Controller/connection.php';
// require 'src/Controller/sales.php';
// require 'src/Controller/categories.php';
// require 'src/Controller/main_controller.php';
require 'Controller/main_controller.php';



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SoftCaisse - Login</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php 
		if (isset($_POST['LogIn'])) {

			$userName = $_POST['userName'];
			$password = $_POST['password'];
			$resultat = LogInVendor($connexion,$userName,$password);
			// print_r($resultat);
			if ($resultat !=-1) {
				$_SESSION['userId'] = $resultat['id'];
		        $_SESSION['userPrenom'] = $resultat['firstName'];
		        $_SESSION['userNom'] = $resultat['lastName'];
		        if ($resultat['role']=='admin') {
		        	$_SESSION['userType'] = "admin";
		        	header('location:admin/index.php');
		        }
		        else if ($resultat['role']=='vendor') {
		        	$_SESSION['userType'] = "vendor";
		        	header('location:vendor/index.php');
		        }
		        else;
		       
			}

			
		}
		if (isset($_GET['LogOut'])) {
			session_unset();
			session_destroy();
			
		}
	?>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading"><center>SoftBoutik</center></div>
				<div class="panel-body">
					<?php 
					if (isset($resultat) && $resultat ==-1) {
						echo '<div class="alert bg-danger" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em>Mauvais compte sélectionné ou mot de passe incorrect, veuillez réessayer<a href="#" class="pull-right"><em class="fa fa-lg fa-close"></em></a></div>';
					}
					
					?>
					<form role="form" action="index.php" method="post">
						<fieldset>
							<div class="form-group">
								<!-- <input class="form-control" placeholder="E-mail" name="userName" type="text" autofocus=""> -->
								<select class="form-control" name='userName'>
											<option value=NULL selected>veuillez choisir un compte</option>
											<?php 
												$list_users = getUsers($connexion);
												 while ( $value=$list_users->fetch()){
													echo "<option value='".$value['userName']."' >".$value['userName']."</option>";
												}
											?>
								</select>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block pull-right" value="LogIn" name="LogIn">Login</button>							</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	

<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
