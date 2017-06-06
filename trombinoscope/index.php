<?php     
    include 'admin/database.php';
    session_start();

    if(!empty($_POST)) 
    {

        $nomEmploye         = checkInput($_POST['nom_employe']);
        $prenomEmploye      = checkInput($_POST['prenom_employe']);
        $agenceEmploye      = checkInput($_POST['agence_employe']);
        $posteEmploye       = checkInput($_POST['poste_employe']); 

        
        if(!empty($nomEmploye) && !empty($prenomEmploye) && !empty($agenceEmploye) && !empty($posteEmploye)) 
        {

        }
        elseif(!empty($prenomEmploye)) 
        {
            $prenomError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($agenceEmploye)) 
        {
            $agenceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($posteEmploye)) 
        {
            $posteError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image)) 
        {
            $imageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 1000000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 1Mo";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
        
        if($isSuccess && $isUploadSuccess) 
        {

        	$db = Database::connect();
            $statement = $db->prepare("INSERT INTO employe(nom_employe,prenom_employe,agence_employe,poste_employe,image_employe) values(?, ?, ?, ?, ?)");
            $statement->execute(array($nomEmploye,$prenomEmploye,$agenceEmploye,$posteEmploye,$image));
            Database::disconnect();
            header("Location: insert.php");

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
					                                echo '<option value="'. $row['id_agence'] .'">'. $row['nom_agence'] . '</option>';;
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
					                                echo '<option value="'. $row['id_poste'] .'">'. $row['nom_poste'] . '</option>';;
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
									<button type="submit" class="btn" style="margin-left: 65px;">Rechercher</button>
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