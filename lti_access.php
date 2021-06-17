<?php  session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>PostemLike</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

 <!--   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
-->	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<link rel="stylesheet" href="https://postemlike.duquenoy.org/_css/styles.css" >

<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
-->
</head>
<body style="background-color: #FFFFFF">

<div class="container-fluid">
<!-- 
	Tentative de conception d'un Post'em LTI 
	Eric DUQUENOY - ULCO - <?php echo date("Y"); ?></h2>
-->
<?php
//Variables de débogage
$debug = FALSE;
if($debug){echo "MODE DEBUG ACTIF !<br>";}
//error_reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors", 1);

require_once "lti_util_complement.php";
require_once "classpostemlike.php";
$error = false;
$context = new BLTIPOST(false, false);
if($context->valid != 1){
	print_r($context);
	$error=TRUE;
}
else{
	if($debug){
		echo "Connexion OK<br>";
		//print_r($context);
	}
}
if(!$error){  //Pas d'erreur, on peut commencer

	//Lecture des données de l'appelant
	$courseID = $context->getCourseLKey(); //Identifiant du cours appelant
	$userID = $context->getUserEmail(); //Identifiant de l'usager = email A REVOIR : il faudrait que cela soit réglable
	$userRole = $context->getRoleLTI(); //Rôle de l'usager
	if($context->isInstructor()){
		//Instructor
		/* A faire
		- principe de nommage des fichiers IDCours_numero.csv ou IDCours_nom.csv : champ demandé

		- affichage d'une liste des fichiers disponibles : 
		Titre | Créé par | Dernière modification par |	Date de dernière modification | Diffusé | Bouton Voir | Bouton Voir un participant | Bouton Mettre à jour | Bouton Supprimer | Bouton Télécharger

		*/

		$instructor = new PTL_INSTRUCTOR($courseID, $userID);
		//L'affichage ne sera pas le même selon qu'un fichier existe ou pas

		//Affichage en tabulation
		echo '<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
		  			<button class="nav-link active" id="filelistzone-tab" data-bs-toggle="tab" data-bs-target="#filelistzone" type="button" role="tab" aria-controls="filelistzone" aria-selected="true">Bulletin de liaison</button>
				</li>
				<li class="nav-item" role="presentation">
		  			<button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Ajouter</button>
				</li>
	  		</ul>';
		
		echo '<div class="tab-content" id="myTabContent">'; //Contenu des tabulations
		
		
		echo '<div class="tab-pane fade show active" id="filelistzone" role="tabpanel" aria-labelledby="filelistzone-tab">';//Zone réservée à l'affichage du tableau de synthèse
		$instructor->displayFilesList();
		
		echo "<div id='zoneall' ></div>";//Zone réservée à l'affichage du contenu d'un fichier
		echo "</div>";//Zone réservée à l'affichage d'un contenu

		echo '  <div class="tab-pane fade " id="upload" role="tabpanel" aria-labelledby="upload-tab">';//Formulaire
		$instructor->uploadFile();//Dépot d'un fichier
		echo "</div>";
		
		echo "</div>";
		//print_r($_FILES);
	}
	else{ 
		//Student 
		/* A faire :
		- vérifier que le fichier .csv existe, sinon message "Pas d'information à afficher"
		- Si existe, charger le fichier dans un tableau
		- rechercher l'email 
		- afficher la ligne correspondante */
		$learner = new PTL_LEARNER($courseID, $userID);
		$filesFound = $learner->getFilesList();
		$learner->displayMyInformations($filesFound);
		
	} 
}
else{
    echo "Erreur de connexion LTI ! - Veuillez contacter un administrateur <br>";
}
//Afficher identifiant et rôle utilisateur
if($debug){
echo "Identifiant : ".$context->getSakaiEuid()."<br>";
echo "Nom complet : ".$context->getUserName()."<br>";
echo "ID du l'utilisateur : ".$context->getUserLKey()."<br>";
echo "Rôle LTI : ".$context->getRoleLTI()."<br>";
echo "Rôle Sakai : ".$context->getUserRoleSakai()."<br>";
echo "Nom de l'espace LMS : ".$context->getCourseName()."<br>";
echo "ID de l'espace LMS : ".$context->getCourseLKey()."<br>";
echo "ID de l'espace LMS : ".$context->getCourseKey()."<br>";
echo "URL appelante : ".$context->getUrlConsumer()."<br>";
echo "Email : ".$context->getUserEmail()."<br>"; 
echo "Liste des participants de cet espace : ";print_r($context->getUsersList());echo"<br>";
//print_r($_POST);
}
echo '<footer  class="footer">
<div class="container" style="background-color:#EEE; text-align: center; ">
	<div class="row">
		<div class="card-footer text-muted ">
			<span style="color:#FFF; font-style: italic;
			text-align: center;
			font-size: smaller;">Conception E.Duquenoy - '.date("Y").' </span>
		</div>
	</div>
</div>
</footer>';
?>

</div>

</body>
</html>
</body>
<!-- <script  type="text/javascript" src="_js/jquery-1.11.2.min.js"></script> -->
<script  type="text/javascript" src="_js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="_js/messcripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>
