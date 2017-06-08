<?php  
	include'database.php';   
    session_start();
	if (!isset($_SESSION['login'])) 
	{
	  	header("location: login.php");
	}

	if(!empty($_POST)) 
    {

        $nomEmploye         = checkInput($_POST['nom_employe']);
        $prenomEmploye      = checkInput($_POST['prenom_employe']);
        $agenceEmploye      = checkInput($_POST['agence_employe']);
        $serviceEmploye     = checkInput($_POST['service_employe']);
        $succes 			= true;

    }
    if (empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && empty($serviceEmploye)) 
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
							<a href="../index.php"><img src="../images/logo_accueil.png" style="margin: 0px 0px 0px 180px "></a>
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
							<form role="form" class="form-vertcial col-md-9" method="post" action="index.php">
								<fieldset>
									<legend><span style="color: #6DA542; font-style: normal; padding-left: 0.5em;"> <em>Trombinoscope - Recherche</em></span><a href="../index.php" class="btn" style="margin-left: 65px;"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a></legend>
									<div class="form-group" for="agence">
										<label id="agence">Agence :</label>	
										<select class="selector" style="margin-left: 11px;" name="agence_employe">
											<option value=""></option>
											<?php
												$db = Database::connect();
					                           	foreach ($db->query('SELECT * FROM agence ORDER BY nom_agence ASC') as $row) 
					                           	{
					                                echo '<option value="'. $row['nom_agence'] .'">'. $row['nom_agence'] . '</option>';;
					                           	}
					                           	Database::disconnect();													
											?>
										</select>
									</div>
									<div class="form-group" for="service">
										<label id="service">Service :</label>	
										<select class="selector" style="margin-left: 6px;" name="service_employe">
											<option value=""></option>
											<?php
												$db = Database::connect();
					                           	foreach ($db->query('SELECT * FROM service ORDER BY nom_service ASC') as $row) 
					                           	{
					                                echo '<option value="'. $row['nom_service'] .'">'. $row['nom_service'] . '</option>';;
					                           	}
					                           	Database::disconnect();													
											?>
										</select>
									</div>
									<div class="form-group" for="nom">
										<label id="nom">Nom :</label>	
										<input class="form-nom" type="text" name="nom_employe" id="nom_employe" placeholder="nom de l'employé" style="margin-left: 30px;">
									</div>
									<div class="form-group" for="prenom">
										<label id="prenom">Prénom :</label>	
										<input class="form-nom" type="text" name="prenom_employe" id="prenom-employe" placeholder="prénom de l'employé" style="margin-left: 9px;">
									</div>
										
									<br>

									<?php
										if (!isset($_SESSION['login'])) 
										{
										  	?>
										  	<button type="submit" class="btn" style="margin-left: 70px;">Rechercher</button>
										  	
										  	<?php
										}
										if (isset($_SESSION['login'])) 
										{
											?>
											<button type="submit" class="btn" >Rechercher</button>
											<a href="insert.php" class="btn">Ajouter un employé</a>

											<?php
										}
									?>
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
				                      <th>Agence</th>
				                      <th>Service</th>
				                      <th>Nom</th>
				                      <th>Prénom</th>
				                      <th>Image</th>
				                    </tr>
				                  </thead>
				                  <tbody>			                  
				                      <?php

				                      	/* TRAITEMENT SI TOUS LES CHAMPS SONT SAISIS*/

					                    if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC ');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										
				                      	/* TRAITEMENT SI LES CHAMPS NOM, PRENOM ET AGENCE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}	
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS NOM, PRENOM ET SERVICE SONT SAISIS*/									

										if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS NOM, AGENCE ET SERVICE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS PRENOM, AGENCE ET SERVICE SONT SAISIS*/	

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										
				                      	/* TRAITEMENT SI LES CHAMPS NOM ET PRENOM SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND prenom_employe = "'.$prenomEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										
				                      	/* TRAITEMENT SI LES CHAMPS NOM ET AGENCE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && empty($serviceEmploye)) 
					                    {
					                      	$db = Database::connect();
					                      	$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'"  AND agence_employe = "'.$agenceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
					                        while($employe = $statement-> fetch()) 
					                        {
					                            echo '<tr>';
					                            echo '<td>'. $employe['agence_employe'] . '</td>';
												echo '<td>'. $employe['service_employe'] . '</td>';
												echo '<td>'. $employe['nom_employe'] . '</td>';			                         
												echo '<td>'. $employe['prenom_employe'] . '</td>';
					                            echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
					                            echo '<td width=300>';			                         
					                            echo ' ';
					                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
					                            echo ' ';
					                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
					                            echo '</td>';
					                            echo '</tr>';

					                            Database::disconnect();
					                        }
					                    }
					                        
				                      	/* TRAITEMENT SI LES CHAMPS NOM ET SERVICE SONT SAISIS*/

										if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();	
										}

				                      	/* TRAITEMENT SI LES CHAMPS PRENOM ET AGENCE SONT SAISIS*/	

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" AND agence_employe = "'.$agenceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}

				                      	/* TRAITEMENT SI LES CHAMPS PRENOM ET SERVICE SONT SAISIS*/										

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src=".../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										

				                      	/* TRAITEMENT SI LES CHAMPS AGENCE ET SERVICE SONT SAISIS*/

										if ($succes == true && empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE agence_employe = "'.$agenceEmploye.'" AND service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';;
											}
											Database::disconnect();	
										}
											

					                    /* TRAITEMENT SI IL Y A JUSTE LE NOM DE SELECTIONNER */

					                    if ($succes == true && !empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE nom_employe = "'.$nomEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										

										/* TRAITEMENT SI IL Y A JUSTE LE PRENOM DE SELECTIONNER */

										if ($succes == true && empty($nomEmploye) && !empty($prenomEmploye) && empty($agenceEmploye) && empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE prenom_employe = "'.$prenomEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										

										/* TRAITEMENT SI IL Y A JUSTE L'AGENCE DE SELECTIONNER */

										if ($succes == true && empty($nomEmploye) && empty($prenomEmploye) && !empty($agenceEmploye) && empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE agence_employe = "'.$agenceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
				                            echo '</tr>';
											}
											Database::disconnect();
										}
										
										/* TRAITEMENT SI IL Y A JUSTE LE SERVICE DE SELECTIONNER */

										if ($succes == true && empty($nomEmploye) && empty($prenomEmploye) && empty($agenceEmploye) && !empty($serviceEmploye)) 
										{
											$db = Database::connect();
											$statement = $db->query('SELECT * FROM employe WHERE service_employe = "'.$serviceEmploye.'" ORDER BY agence_employe ASC, service_employe ASC, nom_employe ASC, prenom_employe ASC');
											while($employe = $statement-> fetch()) 
											{
											echo '<tr>';
											echo '<td>'. $employe['agence_employe'] . '</td>';
											echo '<td>'. $employe['service_employe'] . '</td>';
											echo '<td>'. $employe['nom_employe'] . '</td>';			                         
											echo '<td>'. $employe['prenom_employe'] . '</td>';
											echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
											echo '<td width=300>';			                         
				                            echo ' ';
				                            echo '<a class="btn " href="update.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
				                            echo ' ';
				                            echo '<a class="btn " href="delete.php?id='.$employe['id_employe'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
				                            echo '</td>';
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
		<section id="formulaire">
			<div class="container">
				<div class="red-bar">
					<div class="administration-trombi">
						<div class="row">
							<h1><strong>Liste des employés  </strong><a href="insert.php" class="btn" style="margin-left: 25px;"><span class="glyphicon glyphicon-plus"></span> Ajouter un employé</a><a href="admin_agence.php" class="btn" style="margin-left: 25px;"> Liste des Agences</a><a href="admin_service.php" class="btn" style="margin-left: 25px;"></span> Liste des Services</a><a href="../index.php" class="btn" style="margin-left: 25px;"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a></h1>
			                <table class="table table-striped table-bordered">
			                  <thead>
			                    <tr>
			                      <th>Agence</th>
			                      <th>Service</th>
			                      <th>Nom</th>
			                      <th>Prénom</th>
			                      <th>Image</th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                      <?php			                        
			                        $db = Database::connect();
			                        $statement = $db->query('SELECT * FROM employe ORDER BY agence_employe ASC,service_employe ASC, nom_employe ASC, prenom_employe ASC');
			                        while($employe = $statement-> fetch()) 
			                        {
			                            echo '<tr>';
			                            echo '<td>'. $employe['agence_employe'] . '</td>';
			                            echo '<td>'. $employe['service_employe'] . '</td>';
			                            echo '<td>'. $employe['nom_employe'] . '</td>';			                         
			                            echo '<td>'. $employe['prenom_employe'] . '</td>';
			                            echo '<td><img src="../images/'.$employe['image_employe'].'" alt="" width="120" height="120"></td>';
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