<?php 

/* A faire :
- vérification URL appelante 
*/
require_once("config.php");

//print_r($_POST);//
$code = $_POST['code'];
$fileName = $_POST['filename'];
$courseId=$_POST['courseid'];
$userId=$_POST['userid'];
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
        break;
    
    case 5: //update file with the last consultation date
        updateFileWithConsultationDate($fileName,$courseId,$userId);
        break;
    
    case 6: //Display the file list for the intructor
        displayFilesList($courseId,$fileListHeader,$fileListHeaderType);
        break;
    default :
        break;
}
function updateFileWithConsultationDate($fileName,$courseId,$userId){
    //Met à jour le fichier avec la date de consultation par l'étudiant
    //Lecture du fichier
    $table = getFile($fileName,$courseId);
    $sizeTable = count($table);
    $sizeHead = count($table[0]);
    //echo "ID : ".$userId;
    //echo "Taille tableau : ".$sizeTable." Taille ligne : ".$sizeHead;
    //Modification de la ligne
    //Recherche, dans le tableau, de la ligne de l'étudiant
    $myId = $userId; //Le critère de recherche est l'ID
    $flag = FALSE;
    $myLine = -1; // Numéro de ligne contenant les informations de l'usager
    for($c=1;$c<$sizeTable;$c++){
        $line = $table[$c];
        if(strcasecmp($myId,trim($line[0]))==0){
            $myInformations = $line; //On a trouvé la ligne d'information de l'usager
            $myLine = $c;
            $flag=TRUE;
            //echo "trouvé";
            break;
        }
    }
    if($flag){
        // Réecriture du fichier avec la date de consultation
        $date = date("d/m/Y G:i");
        $table[$myLine][$sizeHead-1] = $date;
        writeFile($fileName,$courseId,$table);
        //echo "Ecriture ok";
        //print_r($table);  
    }else{
        //echo "Aucune donnée à afficher";
    }
}
function writeFile($fileName,$courseId,$table){//Ecrit le fichier sur le disque
    $dossier = getcwd();
    $filename = $dossier."/files//".$courseId."_".$fileName.".csv";
    if (($handle = fopen($filename, "w")) !== FALSE){//ouverture du fichier
        foreach($table as $line){
            fputcsv($handle,$line,',','"');
        }
    }
    fclose($handle);
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
function getFilesList($courseId){
    //Renvoie la liste de fichiers pour l'ID du cours
    $uploaddir = getcwd()."/files//";
    //echo "CourseID : ".$this->courseId."<br>";
    $courseIdLength = strlen($courseId)+1;

    // string to search in a filename.
    $searchString = $courseId."_";
    // all files in my/dir with the extension 
    // .php 
    $files = glob($uploaddir.'*.csv');
    // array populated with files found 
    // containing the search string.
    $filesFound = array();

    // iterate through the files and determine 
    // if the filename contains the search string.
    foreach($files as $file) {
        $name = pathinfo($file, PATHINFO_FILENAME);
        //echo $name." Chaine de recherche : ".$searchString."Position : ".stripos($name, $searchString)."<br>";

        // determines if the search string is in the filename.
        if(stripos($name, $searchString)===0) {
            $filesFound[] = substr($name,$courseIdLength);
            //echo "HELLO!!!";
        } 
    }    
    // output the results.
    //echo "Liste des fichiers : ";
    //print_r($filesFound);
    if(!empty($filesFound)){
        return($filesFound);
    }else{
        return(FALSE);
    }
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
function displayFilesList($courseId,$fileListHeader,$fileListHeaderType){
    //Affichage de la liste des fichiers

    $filesList = getFilesList($courseId); //Récupère la liste des fichiers
    echo "<table id='tablefilelist' class='table table-striped table-bordered'>";
    echo "<thead class='thead-dark'><tr>";
        for($c=0;$c<count($fileListHeader);$c++){
            echo "<th>".$fileListHeader[$c]."</th>";
        }
        echo "</tr></thead>";
    $fileNumber=0;    
    foreach($filesList as $fileName){
        echo "<tr>";
        echo "<td>".$fileName."</td>";
        for($d=1;$d<count($fileListHeader);$d++){
            echo "<td>"."<button class='btn btn-primary' id='".$fileListHeaderType[$d-1].$fileNumber."' name='".$fileName."' value='".$courseId."'>".$fileListHeader[$d]."</button>"."</td>";
        }
        echo "</tr>";
        $fileNumber++; 
    }
    echo "</table>";
}

?>