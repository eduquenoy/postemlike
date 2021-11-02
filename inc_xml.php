<?php
//Fonctions de traitement du XML pour sakai
/*
 * Dans le programme appelant, il faut ajouter quelque chose comme :
 * $xml = new SimpleXMLElement($xmlstr); 
 * où $xmlstr contient la chaine XML
 */
function SAKAI_XMLUserList_FindInfo($xml,$euid,$info)
{
	foreach ($xml->user as $user) 
	{
		if((string) $user->id == $euid)
			{
				return((string) $user->$info);
			}
	}
}


/*Renvoi une info connaissant le nom (title) du groupe
 * 
 * */
function SAKAI_XMLGroupList_FindInfo($xml,$title,$info)
{
	foreach ($xml->group as $group) 
	{
		if((string) $group->title == $title)
			{
				return((string) $group->$info);
			}
	}
}

/*
 * La fonction XML_FindInfo 
 * renvoie, pour une liste XML $xml quelconque
 * l'information demandée dans $child
 * */
function XML_FindInfo($xml,$child)
{
	
	foreach ($xml->children() as $children)
	{
		
		if($children->getName() == $child) 
		{
			return (trim((string)$children));
		}
	}
}
function XML_FindInfo2($xml,$info)
{
	foreach ($xml->group as $group) 
	{
		if((string) $group->title == $info)
			{
				return((string) $group->$info);
			}
	}
}
/*
 * La fonction SAKAI_XMLUserList_List 
 * renvoie une liste, sous forme de tableau
 * des utilisateurs.
 * $xml : contient la liste au format XML
 *
 */ 
function SAKAI_XMLUserList_List($xml)
{
	$liste = array();
	$i = 0;
	foreach ($xml->user as $user) 
	{
		$liste[$i] =(string) $user->name;
		$i++;
	}
	return($liste);
}
/*
 * La fonction SAKAI_XMLUserList_LTI 
 * renvoie une liste, sous forme de tableau
 * des utilisateurs.
 * $xml : contient la liste au format XML
 *
 */ 
function SAKAI_XMLUserList_LTI($xml)
{
	$liste = array();
	$i = 0;
	foreach ($xml->children() as $child){
		$tmp = $child->getName();
		if($tmp == "members"){
			//echo "TRUE<br>";
			//print_r($child);
			foreach($child->children() as $member){
				$liste[$i] =(string)$member->person_name_full;
				$i++;
				//echo $member->person_name_full."<br>";
				//print_r($member);
			}
		}
	}
	return($liste);
}
/*
 * La fonction SAKAI_XMLEuidList_List 
 * renvoie une liste, sous forme de tableau
 * des identifiants.
 * $xml : contient la liste au format XML
 *
 */ 
function SAKAI_XMLEuidList_List($xml)
{
	$liste = array();
	$i = 0;
	foreach ($xml->user as $user) 
	{
		$liste[$i] =(string) $user->id;
		$i++;
	}
	return($liste);
}
/*
 * La fonction SAKAI_XMLRoleList_List 
 * renvoie une liste, sous forme de tableau
 * des roles.
 * $xml : contient la liste au format XML
 *
 */ 
function SAKAI_XMLRoleList_List($xml)
{
	$liste = array();
	$i = 0;
	foreach ($xml->user as $user) 
	{
		$liste[$i] =(string) $user->role;
		$i++;
	}
	return($liste);
}
/*
 * La fonction SAKAI_XMLGroupList_List 
 * renvoie une liste, sous forme de tableau
 * des groupes du site.
 * $xml : contient la liste au format XML
 *
 */ 
function SAKAI_XMLGroupList_List($xml)
{
	$liste = array();
	$i = 0;
	foreach ($xml->group as $group) 
	{
		$liste[$i] =(string) $group->title;
		$i++;
	}
	return($liste);
}
?>
