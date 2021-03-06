<?php 
	session_start();
	if (!isset($_SESSION['login'])) 
	{
	  	header("location: login.php");
	}
	if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }     
    include 'database.php';
 
    $imageError = $nomError = $prenomError = $posteError = $agenceError = "";

    if(!empty($_POST)) 
    {

        $nomEmploye         = checkInput($_POST['nom_employe']);
        $prenomEmploye      = checkInput($_POST['prenom_employe']);
        $agenceEmploye      = checkInput($_POST['agence_employe']);
        $serviceEmploye     = checkInput($_POST['service_employe']); 
        $image              = checkInput($_FILES["image"]["name"]);
        $imagePath          = '../images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;
        
        if(empty($nomEmploye)) 
        {
            $nomError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($prenomEmploye)) 
        {
            $prenomError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($agenceEmploye)) 
        {
            $agenceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($serviceEmploye)) 
        {
            $posteError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image)) 
        {
            $isImageUpdated = false;
        }
        else
        {
        	$isImageUpdated = true;
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
                $imageError = "Le fichier ne doit pas depasser 1Mo";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload, vérifier la taille de l'image (1Mo max)";
                    $isUploadSuccess = false;
                } 
            } 
        }
        
        if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        {

        	
        	if ($isImageUpdated) 
        	{
        		$statement = $db->prepare("UPDATE employe SET nom_employe=?,prenom_employe=?,agence_employe=?,service_employe=?,image_employe=? WHERE id_employe=?");
            	$statement->execute(array($nomEmploye,$prenomEmploye,$agenceEmploye,$serviceEmploye,$image,$id));
        	}
        	else
        	{
        		$statement = $db->prepare("UPDATE employe SET nom_employe=?,prenom_employe=?,agence_employe=?,service_employe=? WHERE id_employe=?");
            	$statement->execute(array($nomEmploye,$prenomEmploye,$agenceEmploye,$serviceEmploye,$id));
        	}

            
            header("Location: index.php");

        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
        	
            $statement = $db->prepare("SELECT * FROM employe where id = ?");
            $statement->execute(array($id));
            $employe = $statement->fetch();
            $image = $employe['image_employe'];
            
        }

    }

    else
    {
    	$statement = $db ->prepare("SELECT * FROM employe WHERE id_employe=?");
    	$statement->execute(array($id));
    	$employe = $statement->fetch();
    	$nomEmploye         = $employe['nom_employe'];
        $prenomEmploye      = $employe['prenom_employe'];
        $agenceEmploye      = $employe['agence_employe'];
        $serviceEmploye     = $employe['service_employe']; 
        $image              = $employe['image_employe'];
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
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<div class="header-trombi col-md-2"></div>
					<div class="col-md-7 col-sm-7 col-xs-7">
						<a href="../index.php"><img src="../images/logo_accueil.png" style="margin: 60px 20px"></a>				
					</div>
					<div class="main-menu-connexion col-md-3 col-sm-3 col-xs-3">
						<ul class="fa-ul">
							<?php
								if (!isset($_SESSION['login'])) 
								{
								  	echo '<a href="admin/login.php"><li><i class="fa fa-lock" ></i> Connexion</li></a>';
								}
								else if (isset($_SESSION['login'])) 
								{
									echo '<a href="session_destroy.php"><li><i class="fa fa-unlock" ></i> Déconnexion</li></a>';
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
					<div class="administration-trombi ">
						<div class="row">
							<div class="col-md-3 col-sm-2 col-xs-2"></div>
							<form action="<?php echo 'update.php?id=' .$id; ?>" role="form" class="form-vertcial col-md-8 col-sm-7 col-xs-7" method="post" enctype="multipart/form-data">
								<fieldset>
									<legend style="width: 468px;"><span style="color: #6DA542;"><em>Administration - Modifier les informations</em></span><a href="index.php" class="btn""><span class="glyphicon glyphicon-arrow-left"></span> Retour</a></legend>
									<div class="form-group" for="photo">
										<label for="photo_employe" id="photo">Sélectionner une nouvelle image (max. 1 Mo):</label>
										<p><?php echo $image;?></p>
										<input type="file" id="photo_employe" name="image" placeholder="photo de l'employé">
										<br>
										<span class="help-inline" style="color: red"><?php echo $imageError;?></span>
									</div>
									<div class="form-group" for="nom">
										<label id="nom">Nom :</label>	
										<input class="form-nom" type="text" name="nom_employe" placeholder="nom de l'employé" style="margin-left: 27px;" value="<?php echo $nomEmploye;?>" required="">
										<br>
										<span class="help-inline" style="color: red"><?php echo $nomError;?></span>
									</div>
									<div class="form-group" for="prenom">
										<label id="prenom">Prenom :</label>	
										<input class="form-nom" type="text" name="prenom_employe" placeholder="prenom de l'employé" value="<?php echo $prenomEmploye;?>" required="" style="margin-left: 7px;">
										<br>
										<span class="help-inline" style="color: red"><?php echo $prenomError;?></span>
									</div>
									<div class="form-group" for="agence">
										<label id="agence">Agence :</label>	
										<select class="selector" style="margin-left: 9px;" name="agence_employe">
											<?php
												
					                           	foreach ($db->query('SELECT * FROM agence ORDER BY nom_agence ASC') as $row) 
					                           	{
					                           		if($row['nom_agence'] == $agenceEmploye)
				                                        echo '<option selected="selected" value="'. $row['nom_agence'] .'">'. $row['nom_agence'] . '</option>';
				                                    else
				                                       echo '<option value="'. $row['nom_agence'] .'">'. $row['nom_agence'] . '</option>';
					                           	}
					                           												
											?>
										</select>
										<span class="help-inline" style="color: red"><?php echo $agenceError;?></span>
									</div>
									<div class="form-group" for="service">
										<label id="service">Service :</label>	
										<select class="selector" style="margin-left: 4px;" name="service_employe">
											<?php
												
					                           	foreach ($db->query('SELECT * FROM service ORDER BY nom_service ASC') as $row) 
					                           	{
					                           		if($row['nom_service'] == $serviceEmploye)
				                                        echo '<option selected="selected" value="'. $row['nom_service'] .'">'. $row['nom_service'] . '</option>';
				                                    else
					                                echo '<option value="'. $row['nom_service'] .'">'. $row['nom_service'] . '</option>';;
					                           	}
					                           													
											?>
										</select>
										<span class="help-inline" style="color: red"><?php echo $posteError;?></span>
									</div>
									<button type="submit" class="btn" style="margin-left: 120px;" name="validation">Modifier</button>
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