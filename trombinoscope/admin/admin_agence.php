<?php
	include 'database.php';
	session_start();
	if (!isset($_SESSION['login'])) 
	{
	  	header("location: login.php");
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
					<div class="main-menu-connexion">
						<ul class="fa-ul">
							<a href="login.php"><li><i class="fa fa-unlock" ></i> Déconnexion</li></a>		
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
								<h1><strong>Liste des agences  </strong><a href="insert_agence.php" class="btn" style="margin-left: 65px;"><span class="glyphicon glyphicon-plus"></span> Ajouter</a><a href="index.php" class="btn" style="margin-left: 65px;"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a></h1>
				                <table class="table table-striped table-bordered">
				                  <thead>
				                    <tr>
				                      <th>Agence</th>
				                      <th>Action</th>
				                    </tr>
				                  </thead>
				                  <tbody>			                  
								    <?php
								    	$db = Database::connect();
										$agence = 'SELECT * FROM agence ORDER BY nom_agence ASC';
										$req = $db->query($agence);

										while ($row = $req->fetch()) 
										{
											echo "<tr>";
											echo "<td>".$row['nom_agence']."</td><td><a href='delete_agence.php?id=".$row['id_agence']."'>Supprimer</a></td>";
											echo "</tr>";
										}
										Database::disconnect();
									?>

				                  </tbody>
				                </table>
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
</html>