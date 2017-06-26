<?php
	include 'database.php';
	session_start();
	if (isset($_SESSION['login'])) 
	{
	  	header("location: index.php");
	 }

	$login = $password = $error ="";

	if (!empty($_POST))
	{
		$login		=checkInput($_POST['login']);
		$password	=checkInput($_POST['password']);
		
		$statement = $db -> prepare("SELECT * FROM utilisateur WHERE login = ? and password = ?");
		$statement->execute(array($login,$password));

		if ($statement ->fetch())
		{
			$_SESSION['login'] = $login;
			header("location: index.php");
		}
		else
		{
			$error ="Identifiant ou mot de passe incorrect";
		}

	}

	function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Connexion - Trombinoscope</title>
		<meta http-equiv="X-UA-Compatible" content="IE=7">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="Outil de trombinoscope ">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<!-- Utilisation de Bootsrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
		<link rel="icon" type="image/png" href="../images/logo.png" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		 
	</head>
	<body>
		<header class="container">
			<div class="row">
				<div class="col-md-2">		
				</div>
				<div class="col-md-6">
				<div class="header-trombi">
						<div class="main-menu">
							<a href="../index.php"><img src="../images/logo_accueil.png" style="margin-bottom: 10px"></a>
						</div>
					</div>						
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<!-- <div class="main-menu-connexion">
						<ul class="fa-ul">
							<a href="login.php"><li><i class="fa fa-lock" ></i> Connexion</li></a>		
						</ul> -->
					</div>						
				</div>
			</div>
		</header>
		<section id="formulaire">
			<div class="container">
				<div class="red-bar">
					<div class="administration-trombi">
						<div class="row">
							<div class="col-md-3 col-sm-2 col-xs-2"></div>
							<form action="login.php" role="form" class="form-vertical col-md-9 col-sm-8 col-xs-8" method="POST">
								<fieldset>
									<legend style="width: 500px;"><span style="color: #6DA542;"><em>Trombinoscope - Connexion Administrateur</em></span><a href="../index.php" class="btn" ><span class="glyphicon glyphicon-arrow-left"></span> Retour</a></legend>
									<div class="form-group">
										<label for="identifiant">Identifiant :</label>	
										<input class="form-nom" type="text" id="login"  placeholder="nom d'utilisateur" style="margin-left: 20px;" name="login" required="">
									</div>
									<br>
									<div class="form-group">
										<label for="motdepasse">Mot de passe :</label>	
										<input class="form-nom" type="password" id="password" placeholder="mot de passe" name="password" required="">
									</div>
									<span class="help-inline" style="color: red"><?php echo $error;?></span>
									<button type="submit" class="btn" style="margin-left: 120px;" name="connexion" value="connexion">Se connecter</button>
								</fieldset>						
							</form>						
						</div>
					</div>				
				</div>
			</div>
		</section>
		<footer>
			<div class="container">
				<div class="red-bar">
					<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-3"></div>
							<div class="footer-trombi col-md-7 col-sm-7 col-xs-7">
								<br />
								<br />
								<ul>
									<li class="end">EGETRA SA &copy;2009 - Tous droits réservés</li> 
									<li class="sign">Powered by Debian GNU / Linux<a href="http://wiki.resgestrans.int"><img src="../images/tuxlogo.png" style="vertical-align:middle" alt="Debian" /></a> - Apache<img src="../images/apachelogo.png" style="vertical-align:middle" alt="LE serveur Web !" /></a> - Designed By Seb2A</li>
								</ul>
							</div>			
						</div>					
					</div>
				</div>
			</div>			
		</footer>
	</body>
</html>