<?php    
	include'database.php'; 
    session_start();
	if (!isset($_SESSION['login'])) 
	{
	  	header("location: login.php");
	}
	if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        /*suppression de la photo de l'employé*/
        $nomImage = $db ->prepare('SELECT image_employe FROM employe WHERE id_employe = ?');
        $nomImage->execute(array($id));
        $employe = $nomImage->fetch();
        $image = $employe['image_employe'];
        unlink('../images/'.$image); 

        /*suppression de l'employé de la BDD*/
        $statement = $db->prepare("DELETE FROM employe WHERE id_employe = ?");
        $statement->execute(array($id));
       
        header("Location: index.php");
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
			         <div class="administration-trombi">
						<div class="row">
							<div class="col-md-3 col-sm-2 col-xs-2"></div>
							<div class="col-md-7 col-sm-7 col-xs-7">
								<form class="form" action="delete.php" role="form" method="post">
									<legend style="width: 380px;"><span style="color: #6DA542;"> <em>Administration - Supprimer un employé</em></span></legend>
				                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
				                    <p class="alert alert-warning" style="width:380px">Êtes-vous sur de vouloir supprimer l'employé ?</p>
				                    <div class="form-actions" style="margin-left: 140px">
				                      <button type="submit" class="btn btn-warning">Oui</button>
				                      <a class="btn btn-default" href="index.php">Non</a>			                      
			                    	</div>		                    			                    
			                	</form>
			                </div>								
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