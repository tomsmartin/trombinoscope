<?php     
    session_start();
	if (!isset($_SESSION['login'])) 
	{
	  	header("location: login.php");
	 }      

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Recherche - Trombinoscope</title>
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
							<a href="../index.php"><img src="../images/logo.png"></a>
						</div>
					</div>			
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="main-menu-connexion">
						<ul class="fa-ul">
							<a href="session_destroy.php"><li><i class="fa fa-lock" ></i> Déconnexion</li></a>		
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
							<h1><strong>Liste des employés   </strong><a href="insert.php" class="btn" style="margin-left: 65px;"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
			                <table class="table table-striped table-bordered">
			                  <thead>
			                    <tr>
			                      <th>Nom</th>
			                      <th>Prénom</th>
			                      <th>Agence</th>
			                      <th>Poste</th>
			                      <th>Image</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                      <?php
			                        include 'database.php';
			                        
			                        $db = Database::connect();
			                        $statement = $db->query('SELECT * FROM employe ORDER BY nom_employe ASC');
			                        while($employe = $statement-> fetch()) 
			                        {
			                            echo '<tr>';
			                            echo '<td>'. $employe['nom_employe'] . '</td>';
			                            echo '<td>'. $employe['prenom_employe'] . '</td>';
			                            echo '<td>'. $employe['agence_employe'] . '</td>';			                         
			                            echo '<td>'. $employe['poste_employe'] . '</td>';
			                            echo '<td><img src="../images/'.$employe['image_employe'].'>" alt=""></td>';
			                            echo '<td width=300>';			                         
			                            echo ' ';
			                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
			                            echo ' ';
			                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
			                            echo '</td>';
			                            echo '</tr>';
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