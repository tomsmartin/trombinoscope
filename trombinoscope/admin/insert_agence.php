<?php 
	session_start();
	if (!isset($_SESSION['login'])) 
	{
	  	header("location: login.php");
	 }      
    include 'database.php';
 
    $nomError =  "";

    if(!empty($_POST)) 
    {

        $nomAgence        = checkInput($_POST['nom_agence']);
        $isSuccess          = true;

        
        if(empty($nomAgence)) 
        {
            $nomError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        
        if($isSuccess) 
        {

        	$db = Database::connect();
            $statement = $db->prepare("INSERT INTO agence(nom_agence) values(?)");
            $statement->execute(array($nomAgence));
            Database::disconnect();
            header("Location: admin_agence.php");

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
		<title>Administration - Trombinoscope</title>
		<meta http-equiv="X-UA-Compatible" content="IE=7">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="Outil de trombinoscope ">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<!-- Utilisation de Bootsrap -->
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
		<link rel="icon" type="image/png" href="../images/logo.png" />
		 
	</head>
	<body>
		<header class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="header-trombi">
						<div class="main-menu">
							<a href="../index.php"><img src="../images/logo_accueil.png" style="margin-left: 180px; margin-bottom:20px"></a>
						</div>
					</div>			
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="main-menu-connexion">
						<ul class="fa-ul">
							<a href="session_destroy.php"><li><i class="fa fa-unlock" ></i> Déconnexion</li></a>		
						</ul>
					</div>						
				</div>
			</div>
		</header>
		<section id="formulaire">
			<div class="container">
				<div class="red-bar">
					<div class="administration-trombi">
						<div class="row">
							<div class="col-md-3"></div>
							<form action="insert_agence.php" role="form" class="form-vertcial col-md-9" method="post">
								<fieldset>
									<legend><span style="color: #6DA542; font-style: normal; padding-left: 0.5em;"> <em>Trombinoscope - Ajout d'une agence</em></span></legend>
									<div class="form-group" for="nom">
										<label id="nom">Nom de l'agence :</label>	
										<input class="form-nom" type="text" name="nom_agence" placeholder="nom de l'agence" style="margin-left: 20px;" required="">
										<br>
										<span class="help-inline" style="color: red"><?php echo $nomError;?></span>
									</div>
									<button type="submit" class="btn" style="margin-left: 65px;" name="validation">Ajouter l'agence</button>
									<a href="index.php" class="btn" style="margin-left: 25px;"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
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
						<div class="col-md-3"></div>
							<div class="footer-trombi col-md-7">
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
</html>''