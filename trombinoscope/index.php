<?php     
    include 'admin/database.php';
    session_start();
    $champInvalide = "";

    if(!empty($_POST)) 
    {

        $nomEmploye         = checkInput($_POST['nom_employe']);
        $prenomEmploye      = checkInput($_POST['prenom_employe']);
        $agenceEmploye      = checkInput($_POST['agence_employe']);
        $posteEmploye       = checkInput($_POST['poste_employe']);
        $succes 			= true;

    }
    if (empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && empty($posteEmploye)) 
    {
    	$champInvalide = 'Vous devez remplir au moins un champ';
    	$succes = false;
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
		<title>Recherche - Trombinoscope</title>
		<meta http-equiv="X-UA-Compatible" content="IE=7">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="Outil de trombinoscope ">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- Utilisation de Bootsrap -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
		<link rel="icon" type="image/png" href="images/logo.png" />
		 
	</head>
	<body>
	<header class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="header-trombi">
						<div class="main-menu">
							<a href="index.php"><img src="images/logo.png"></a>
						</div>
					</div>			
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="main-menu-connexion">
						<ul class="fa-ul">
							<?php
								if (!isset($_SESSION['login'])) 
								{
								  	echo '<a href="admin/login.php"><li><i class="fa fa-lock" ></i> Connexion</li></a>';
								}
								else if (isset($_SESSION['login'])) 
								{
									echo '<a href="admin/session_destroy.php"><li><i class="fa fa-unlock" ></i> Déconnexion</li></a>';
								}   
							?>		
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
							<form role="form" class="form-vertcial col-md-9" method="post" action="index.php">
								<fieldset>
									<legend><span style="color: #6DA542; font-style: normal; padding-left: 0.5em;"> <em>Trombinoscope - Recherche</em></span></legend>
									<div class="form-group" for="agence">
										<label id="agence">Agence :</label>	
										<select class="selector" style="margin-left: 3px;" name="agence_employe">
											<option value=""></option>
											<?php
												$db = Database::connect();
					                           	foreach ($db->query('SELECT * FROM agence') as $row) 
					                           	{
					                                echo '<option value="'. $row['nom_agence'] .'">'. $row['nom_agence'] . '</option>';;
					                           	}
					                           	Database::disconnect();													
											?>
										</select>
									</div>
									<div class="form-group" for="poste">
										<label id="poste">Poste :</label>	
										<select class="selector" style="margin-left: 16px;" name="poste_employe">
											<option value=""></option>
											<?php
												$db = Database::connect();
					                           	foreach ($db->query('SELECT * FROM poste') as $row) 
					                           	{
					                                echo '<option value="'. $row['nom_poste'] .'">'. $row['nom_poste'] . '</option>';;
					                           	}
					                           	Database::disconnect();													
											?>
										</select>
									</div>
									<div class="form-group" for="nom">
										<label id="nom">Nom :</label>	
										<input class="form-nom" type="text" name="nom_employe" id="nom_employe" placeholder="nom de l'employé" style="margin-left: 25px;">
									</div>
									<div class="form-group" for="prenom">
										<label id="prenom">Prénom :</label>	
										<input class="form-nom" type="text" name="prenom_employe" id="prenom-employe" placeholder="prénom de l'employé" style="margin-left: 3px;">
									</div>
									<p class="alert alert-warning" style="width:380px">Vous devez remplir au moins un champ du formulaire</p>
									<br>
									<button type="submit" class="btn" style="margin-left: 65px;">Rechercher</button>
								</fieldset>						
							</form>						
						</div>
					</div>				
				</div>
			</div>
		</section>
		<?php 
		if(!empty($_POST) && $succes) 
	    {
	    	?>
			<section id="formulaire">
				<div class="container">
					<div class="red-bar">
						<div class="administration-trombi">
							<div class="row">
								<h1><strong>Liste des employés</strong></h1>
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

				                      	/* TRAITEMENT SI TOUS LES CHAMPS SONT SAISIS*/

					                    if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										
				                      	/* TRAITEMENT SI LES CHAMPS NOM, PRENOM ET AGENCE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}	
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS NOM, PRENOM ET POSTE SONT SAISIS*/									

										if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS NOM, AGENCE ET POSTE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS PRENOM, AGENCE ET POSTE SONT SAISIS*/	

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										
				                      	/* TRAITEMENT SI LES CHAMPS NOM ET PRENOM SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										
				                      	/* TRAITEMENT SI LES CHAMPS NOM ET AGENCE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && empty($posteEmploye)) 
					                    {
					                      	$db = Database::connect();
					                      	$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'"  AND agence_employe = "'.$agenceEmploye.'"');
					                        while($employe = $statement-> fetch()) 
					                        {
					                            echo '<tr>';
					                            echo '<td>'. $employe['nom_employe'] . '</td>';
					                            echo '<td>'. $employe['prenom_employe'] . '</td>';
					                            echo '<td>'. $employe['agence_employe'] . '</td>';			                         
					                            echo '<td>'. $employe['poste_employe'] . '</td>';
					                            echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
					                            echo '</tr>';

					                            Database::disconnect();
					                        }
					                    }
					                        
				                      	/* TRAITEMENT SI LES CHAMPS NOM ET POSTE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();	
										}

				                      	/* TRAITEMENT SI LES CHAMPS PRENOM ET AGENCE SONT SAISIS*/	

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS PRENOM ET POSTE SONT SAISIS*/										

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										

				                      	/* TRAITEMENT SI LES CHAMPS AGENCE ET POSTE SONT SAISIS*/

										if ($succes == true && empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE agence_employe = "'.$agenceEmploye.'" AND poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();	
										}
											

					                    /* TRAITEMENT SI IL Y A JUSTE LE NOM DE SELECTIONNER */

					                    if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										

										/* TRAITEMENT SI IL Y A JUSTE LE PRENOM DE SELECTIONNER */

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										

										/* TRAITEMENT SI IL Y A JUSTE L'AGENCE DE SELECTIONNER */

										if ($succes == true && empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE agence_employe = "'.$agenceEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
										
										/* TRAITEMENT SI IL Y A JUSTE LE POSTE DE SELECTIONNER */

										if ($succes == true && empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && !empty($posteEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE poste_employe = "'.$posteEmploye.'"');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['nom_employe'] . '</td>';
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td>'. $employe['agence_employe'] . '</td>';			                         
											echo '<td>'. $employe['poste_employe'] . '</td>';
											echo '<td><img src="images/'.$employe['image_employe'].'" alt=""></td>';
											echo '</tr>';
											}
											Database::disconnect();
										}
					                    ?>
				                  </tbody>
				                </table>
							</div>
						</div>				
					</div>
				</div>
			</section>
	        <?php
	    }
		?>
		
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
									<li class="sign">Powered by Debian GNU / Linux<a href="http://wiki.resgestrans.int"><img src="images/tuxlogo.png" style="vertical-align:middle" alt="Debian" /></a> - Apache<img src="images/apachelogo.png" style="vertical-align:middle" alt="LE serveur Web !" /></a> - Designed By Seb2A</li>
								</ul>
							</div>			
						</div>					
					</div>
				</div>
			</div>			
		</footer>
	</body>
</html>