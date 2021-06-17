<?php echo "1"; session_start(); ?>
<?php
//Variables de débogage
$debug = TRUE;
if($debug){echo "1";}
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

require_once "lti_util_complement.php";
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
if(!$error){    
    echo '<iframe src="https://edt.univ-littoral.fr/direct/myplanning.jsp" width=100% height=100%></iframe>';
}
else{
    echo "Erreur de connexion LTI ! - Veuillez contacter un administrateur <br>";
}
//Afficher identifiant et rôle utilisateur
/*
echo "Identifiant : ".$context->getSakaiEuid()."<br>";
echo "Nom complet : ".$context->getUserName()."<br>";
echo "ID du l'utilisateur : ".$context->getUserLKey()."<br>";
echo "Rôle LTI : ".$context->getRoleLTI()."<br>";
echo "Rôle Sakai : ".$context->getUserRoleSakai()."<br>";
echo "Nom de l'espace Sakai : ".$context->getCourseName()."<br>";
echo "ID de l'espace Sakai : ".$context->getCourseLKey()."<br>";
echo "URL appelante : ".$context->getUrlConsumer()."<br>";
echo "Liste des participants de cet espace : ";print_r($context->getUsersList());echo"<br>";
*/
?>