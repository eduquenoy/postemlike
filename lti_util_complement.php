<?php
require_once 'util/lti_util.php';
include_once("inc_xml.php");

class BLTIPOST extends BLTI
{
	private $secret;
	function __construct($usesession, $doredirect){
		$this->secret = $this->getSecret($_POST["oauth_consumer_key"]);
		parent::__construct($this->secret, $usesession, $doredirect); 
	} 
	
	 function getUrlConsumer()
	 {
		$url = parse_url($_POST['launch_presentation_return_url']);
		$urlConsumer = $url['scheme']."://".$url['host'];
		if(!empty($url['port'])){
			$urlConsumer = $urlConsumer.":".$url['port'];
			}
		return($urlConsumer);
	 }
	 function getLocale(){
		 return($_POST['launch_presentation_locale']);
	 }
	 function getUserRoleSakai()
	 {
		return($_POST['ext_sakai_role']);
	 }
	 
	 function getCustomPrivateKey()
	 {
		return($_POST['custom_private_key']);
	 }
	 function getSakaiEuid(){
		 return($_POST['ext_sakai_eid']);
	 }
	 function getSakaiUserId(){
		 return($this->info['user_id']);
	 }
	 
	 function getRole(){
		 return(strip_tags($_POST['ext_sakai_role']));
	 } 
	 function getRoleLTI(){
		 $roles = $this->info['roles'];
		 return($roles);
		 
	 }
	 function displayPOST(){
		 print_r($_POST);
	 }
	 function getUsersList(){
		//echo "HELLO";
		 
		// if ( $_POST['ext_ims_lis_memberships_id'] && $_POST['ext_ims_lis_memberships_url'] ) {
		 if ( $_POST['custom_context_memberships_url'] ) {
		//	if (strlen($oauth_consumer_secret) < 1 ) $oauth_consumer_secret = $this->secret;
		/*	if(!in_array($_SERVER['HTTP_HOST'],array('localhost','127.0.0.1')) && strpos($url,'localhost') > 0){
				echo "Erreur d'exécution<br>";
			}
		*/	$message = 'basic-lis-readmembershipsforcontext';
			
			$url = $_POST['custom_context_memberships_url'];
			//$url = $_POST['ext_ims_lis_memberships_url'];
			$data = array(
				'lti_message_type' => $message,
				//'id' => $_POST['ext_ims_lis_memberships_id']);
				'id' => $_POST['custom_context_memberships_url']);
				$oauth_consumer_key = $_POST['oauth_consumer_key'];
 				$oauth_consumer_secret=$this->secret;
			$newdata = signParameters($data, $url, 'POST', $oauth_consumer_key, $oauth_consumer_secret);
			ksort($newdata);
			foreach($newdata as $key => $value ) {
				$value = stripslashes($value);
				//print "$key=$value (".mb_detect_encoding($value).")\n";
			}
			print_r($newdata);
			//$url = "/mod/lti/services.php/CourseSection/2/bindings/2/memberships?rlid=2";
			//print_r($newdata);
			global $LastOAuthBodyBaseString;
			echo "HELLO<br>";

			//$retval = utf8_encode(do_post_request($url, http_build_query($newdata)));
			$retval = do_get($url);
			print_r($retval);

			$xml = new SimpleXMLElement($retval);

			$users = SAKAI_XMLUserList_LTI($xml);
			//print_r($users);
			//echo "HELLO";

			return($users);
		}	
	 }
	function getSecret($key){
		$fileConfig = getcwd()."/config.txt";
		$table = array();

		$handle = fopen($fileConfig, "r" );
		//echo "Taille : ".filesize($fileConfig);
		if ($handle){
   			while (!feof($handle)){
     			$buffer = fgets($handle);//Lecture d'une ligne
				if(strpos($buffer,"key") == 0){//si c'est une clef, on la récupère
					$tmpKey = explode("=",$buffer);//On récupère la clef dans un tableau temporaire
					$buffer = fgets($handle);//Lecture d'une ligne //lecture de la ligne suivant pour récupérer le secret
					$tmpSecret = explode("=",$buffer);
					$table[trim($tmpKey[1])] = trim($tmpSecret[1]);
				}
				// echo "Buffer :".$buffer;

   			}
   		fclose($handle);
		}
		//print_r($table);
		if(array_key_exists($key,$table)){
			return($table[$key]);
		}else{
			return(FALSE);
		}
	}
}


?>