<?php 
require_once("config.php");

//print_r($_POST);//
$code = $_POST['code'];
$fileName = $_POST['filename'];
$courseId=$_POST['courseid'];
$newName = $_POST['newname'];
switch($code){ 
    case 0: //display
        //On renvoie un contenu HTML complet avec le contenu du fichier qu'on affichera sur la zone dédiée (div)
        displayAllInformations($fileName,$courseId);
        break;

    case 1: //update
        break;

    case 2: //delete
        $uploaddir = getcwd()."/files//"; //Chemin vers dépôt des fichiers
        $fullFileName = $uploaddir.$courseId."_".$fileName.".csv";
        if(unlink($fullFileName)){
            echo "Suppression effectuée. Rafraichir la fenêtre pour mettre à jour l'affichage";
        }else{
            echo "La suppression n'a pas pu être effectuée";
        }

        break;

    case 3: //download
//        $uploaddir = getcwd()."/files//";
        $url = "https://postemlike.duquenoy.org/files/".$courseId."_".$fileName.".csv";
        //echo "<a href='".$url."' target='_blank'>Votre fichier</a>";
        echo $url;
        break;
    case 4: //rename file
        $uploaddir = getcwd()."/files//"; //Chemin vers dépôt des fichiers
        $fullFileName = $uploaddir.$courseId."_".$fileName.".csv";
}

function getFile($fileName,$courseId){ //Renvoie un tableau contenant la totalité du fichier passé en paramètre
    $dossier = getcwd(); //Dossier racine
    $filename = $dossier."/files//".$courseId."_".$fileName.".csv"; //Fichier avec chemin complet
    $row = 0;
    $table = array(); //Contiendra 2 lignes : entêtes de colonnes et données utilisateur
    if (($handle = fopen($filename, "r")) !== FALSE){//ouverture du fichier
        while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
            $table[$row++] = $data;//On lit les entêtes
        }
    }
    //print_r($table);
    fclose($handle);
    return($table);//Le tableau contient toutes les données
}

function displayAllInformations($fileName,$courseId){
    $table = getFile($fileName,$courseId); //Contient toutes les données
    $sizeTable = count($table);
    //echo "Nombre de ligne ".$sizeTable."<br>";
    $head = $table[0]; //Récupération de l'entête
    $sizeHead = count($head); //Nombre d'éléments de l'entête
    //Il faut construire un tableau HTML
    echo "<table id=tableall class='table table-striped table-bordered caption-top'>";
    echo '<caption>'.$fileName.'</caption>';
    //Entête
    echo "<thead class='thead-dark'><tr>";
    for($c=0;$c<$sizeHead;$c++){
        echo "<th>".$head[$c]."</th>";
    }
    echo "</tr></thead>";
    //Lignes
    echo "<tbody>";
    for($d=1;$d<$sizeTable;$d++){
        echo "<tr>";
        $line = $table[$d];
        for($c=0;$c<$sizeHead;$c++){
            if($c==0 && !strcasecmp($line[$sizeHead-1],"never")){
                echo "<td class='text-break' style='color:red;'>".$line[$c]."</td>";
            }else{
                echo "<td class='text-break'>".$line[$c]."</td>";
            }
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

?>