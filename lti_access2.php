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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="_css/styles.css" >
<link rel="stylesheet" href="_css/popups.css" >

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
require_once "config.php";
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
	$courseId = $context->getCourseLKey(); //Identifiant du cours appelant
	$userId = $context->getUserEmail(); //Identifiant de l'usager = email A REVOIR : il faudrait que cela soit réglable
	$userRole = $context->getRoleLTI(); //Rôle de l'usager
	echo '<input id="courseid" name="datas" type="hidden" value="'.$courseId.'">';
	echo '<input id="userid" name="datas" type="hidden" value="'.$userId.'">';
	echo '<input id="userole" name="datas" type="hidden" value="'.$userRole.'">';

	if($context->isInstructor()){
		//Instructor
		/* A faire
		- principe de nommage des fichiers IDCours_numero.csv ou IDCours_nom.csv : champ demandé
		- affichage d'une liste des fichiers disponibles : 
		Titre | Créé par | Dernière modification par |	Date de dernière modification | Diffusé | Bouton Voir | Bouton Voir un participant | Bouton Mettre à jour | Bouton Supprimer | Bouton Télécharger
		*/


		$instructor = new PTL_INSTRUCTOR($courseId, $userId);
		//L'affichage ne sera pas le même selon qu'un fichier existe ou pas

		//Affichage en tabulation : Onglet Principal et onglet Ajouter
/*		echo '<ul class="nav nav-tabs" id="instructorTab" role="tablist">
				<li class="nav-item" role="presentation">
		  			<button class="nav-link active" id="filelistzone-tab" data-bs-toggle="tab" data-bs-target="#filelistzone" type="button" role="tab" aria-controls="filelistzone" aria-selected="true">Bulletin de liaison</button>
				</li>
				<li class="nav-item" role="presentation">
		  			<button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Ajouter</button>
				</li>
	  		</ul>';
*/		echo '<ul class="nav nav-tabs" id="instructorTab" role="tablist">
				<li class="nav-item" role="presentation">
		  			<button class="nav-link active" id="filelistzone-tab" data-bs-toggle="tab" data-bs-target="#filelistzone" type="button" role="tab" >Bulletin de liaison</button>
				</li>
				<li class="nav-item" role="presentation">
		  			<button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" >Ajouter</button>
				</li>
	  		</ul>';
		
		echo '<div class="tab-content" id="instructorTabContent">'; //Contenu des tabulations

//		echo '<div class="tab-pane fade show active" id="filelistzone" role="tabpanel" aria-labelledby="filelistzone-tab">';//Zone réservée à l'affichage du tableau de synthèse
		echo '<div class="tab-pane fade show active" id="filelistzone" role="tabpanel" >';//Zone réservée à l'affichage du tableau de synthèse
		$instructor->displayFilesList();
		
		echo "<div id='zoneall'></div>";//Zone réservée à l'affichage du contenu d'un fichier
		echo "</div>";//Zone réservée à l'affichage d'un contenu

//		echo '  <div class="tab-pane fade " id="upload" role="tabpanel" aria-labelledby="upload-tab">';//Formulaire
		echo '  <div class="tab-pane fade " id="upload" role="tabpanel" >';//Formulaire
		//$instructor->uploadFile();//Dépot d'un fichier

			echo '<h1></h1>';
        	echo '<div class="card text-dark bg-light" style="max-width: 40rem;">';
        		echo '<div class="card-header">Instructions</div>
        				<div class="card-body>
        <p class="card-text">
        <ul>
        <li>Votre fichier de commentaires doit être enregistré au format <code>.csv</code> (valeurs séparées par une virgule).</li>
        <li>La <strong>première colonne</strong> de votre fichier doit contenir des <strong>emails</strong> d’utilisateurs.</li>
        <li>La <strong>première ligne</strong> de votre fichier doit contenir les <strong>noms des colonnes</strong>.</li> 
        <ul><p/>';
        echo '</div>';
        echo '</div>';
        echo '<p></p>';
        echo '<div class="mb-3" style="max-width: 40rem;">';
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="30000" />';
        echo '<input type="hidden" id="courseid" name="COURSE_ID" value="'.$courseId.'" />'; 
        echo '<input type="hidden" id="filetype" name="FILE_TYPE" value="'.$fileType.'" />';
        echo '<label for="userfilename" class="form-label">Saisir un nom de fichier</label>';

        echo '<input id="userfilename" name="USER_FILE_NAME" class="form-control" type="text" placeholder="Nom de fichier " aria-label="default input example">';
        echo '</div><h1></h1>';
        echo '  <div class="mb-3" style="max-width: 40rem;">
                <h1></h1>
                <label for="uploadfile" class="form-label">Choisir un fichier à envoyer : </label>
                <input class="form-control" name="userfile" id="uploadfile" type="file" >
                </div>';     
       	echo '</form>'; 
		echo '	<h1></h1>
				<div class="mb-3">
					<button class="btn btn-primary" id="form-submit" type="submit">Valider</button>
				</div>';
		echo "</div>";		
		echo "</div>";
	}
	else{ 
		//Student 
		/* A faire :
		- vérifier que le fichier .csv existe, sinon message "Pas d'information à afficher"
		- Si existe, charger le fichier dans un tableau
		- rechercher l'email 
		- afficher la ligne correspondante 
		- Affichage tableau : Titre | Date dernière modification du fichier | Bouton Voir*/

		echo '
			<ul class="nav nav-tabs" id="learnerTab" role="tablist">
				<li class="nav-item" role="presentation">
			  		<button class="nav-link active" id="filelistzone-tab" data-bs-toggle="tab" data-bs-target="#filelistzone" type="button" role="tab" aria-controls="filelistzone" aria-selected="true">Bulletin de liaison</button>
				</li>
			</ul>';
		
		echo '<div class="tab-content" id="learnerTabContent">'; //Contenu des tabulations
		echo '<div class="tab-pane fade show active" id="filelistzone" role="tabpanel" aria-labelledby="filelistzone-tab">';//Zone réservée à l'affichage du tableau de synthèse

		echo "<div id='zoneall' ></div>";//Zone réservée à l'affichage du contenu d'un fichier
		
		echo '</div></div>';
		
			$learner = new PTL_LEARNER($courseId, $userId);
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

echo '<footer  class="footer" >
	<div class="row">
		<div class="card-footer text-muted ">
			<a rel="license" href="https://creativecommons.org/licenses/by-nc-sa/4.0/" target=_"blank">
			 <img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png" /></a>
			 - Code disponible sur <a href="https://github.com/eduquenoy/postemlike" target="_blank" >Github</a> 
			 <br/>
			 <a href="https://eric.duquenoy.org" target=_"blank">E.Duquenoy - '.date("Y").'</a><br/>		
			 <span id="version">Version</span>
		</div>
	</div>
</footer>';
?>

<div class="modal" id="informationModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="modalTitle" >Modal Title</h4>
         </div>
         <div class="modal-body" id="modalBody">
            Modal body..
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="informationModal-ok" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>


<!-- <button class="btn btn-default" id="btn-confirm">Confirm</button> -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
    <!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="myModalLabel">Confirmer</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-si">Oui</button>
        <button type="button" class="btn btn-primary" id="modal-btn-no">Non</button>
      </div>
    </div>
  </div>
</div>

<div class="alert" role="alert" id="result"></div>







</body>

<!-- <script  type="text/javascript" src="_js/jquery-1.11.2.min.js"></script> -->
<script type="text/javascript" src="_js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script type="text/javascript" src="_js/popups.js"></script>
<script type="text/javascript" src="_js/messcripts.js"></script>


</html>
