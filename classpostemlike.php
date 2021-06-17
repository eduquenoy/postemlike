<?php
require_once("config.php");

//Objet postem
class  POSTEMLIKE{
    /*
    Si rôle Learner, on cherche le fichier correspondant à l'ID de cours puis dedans la ligne correspondant à l'email du Learner 
    */
    //un nouvel objet est créé pour 1 ID de cours et 1 ID d'étudiant
    protected $courseId,$userId,$fileType;

    function __construct($courseId, $userId) {
        $this->courseId = $courseId;
        $this->userId = $userId;
        $this->fileType = ".csv";//Pourra être modifié dans de futures versions...
        //echo "userID : ".$this->userId."<br>";
        //echo "courseID : ".$this->courseId."<br>";
        

    }
    function getFilesList(){
        //Renvoie la liste de fichiers pour l'ID du cours
        $uploaddir = getcwd()."/files//";
        //echo "CourseID : ".$this->courseId."<br>";
        $courseIdLength = strlen($this->courseId)+1;

        // string to search in a filename.
        $searchString = $this->courseId."_";
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
    function existFile(){
        //Verification de l'existance d'un ou plusieurs fichiers correspondant à l'ID du cours
        //Le format est courseId_options.csv (options : pour de futures version à plusieurs fichiers)

        $dossier = getcwd();
        $filename = $dossier."/files//".$this->courseId.".csv";
        if(file_exists($filename)){
            return true;
        }else{
            return false;

        }    
    }
    
    function readFile($fileName){ //Renvoie un tableau contenant la totalité du fichier passé en paramètre
        $dossier = getcwd();
        $filename = $dossier."/files//".$this->courseId."_".$fileName.".csv";
        $row = 0;
        $table = array(); //Contiendra 2 lignes : entêtes de colonnes et données utilisateur
        if (($handle = fopen($filename, "r")) !== FALSE){//ouverture du fichier
            while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                $table[$row++] = $data;//On lit les entêtes
            }
        }
        //print_r($table);
        fclose($handle);
        return($table);
    }
    function writeFile($fileName,$table){//Ecrit le fichier sur le disque
        $dossier = getcwd();
        $filename = $dossier."/files//".$this->courseId."_".$fileName.".csv";
        if (($handle = fopen($filename, "w")) !== FALSE){//ouverture du fichier
            foreach($table as $line){
                fputcsv($handle,$line,',','"');
            }
        }
        //print_r($table);
        fclose($handle);
    }
    function message($message){
        switch($message){
            case "#NODATA" : 
                echo "Aucune donnée à afficher<br>";
                break;
            default:
                echo "Erreur d'affichage<br>";
        }
    }
}

/*
L'instructeur :
- voit si un fichier a été déposé
- si il y a un fichier, il peut :
    - le supprimer
    - en déposer un nouveau
- sinon il peut en déposer un
- il devrait pouvoir lister le contenu du fichier
*/
class PTL_INSTRUCTOR extends POSTEMLIKE{
    private $fileListHeader = array("Titre", "Voir", "Mettre à jour", "Supprimer", "Télécharger"),
    $fileListHeaderType = array("display","update","delete","download");
    function __construct($courseId, $userId){
        parent::__construct($courseId, $userId);
    }
    
    function displayAllInformations($fileName){
        $table = $this->readFile($fileName); //Contient toutes les données
        $sizeTable = count($table);
        //echo "Nombre de ligne ".$sizeTable."<br>";
        $head = $table[0]; //Récupération de l'entête
        $sizeHead = count($head); //Nombre d'éléments de l'entête
        //Il faut construire un tableau HTML
        echo "<table id=tableall class='table table-striped table-bordered'>";
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
                echo "<td>".$line[$c]."</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
    function uploadFile(){
       // echo '<form class="row g-3" enctype="multipart/form-data" id="form" action="" method="post">';
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
//        echo '<form enctype="multipart/form-data" id="form" action="" method="post">';
        echo '<input type="hidden" name="MAX_FILE_SIZE" value="30000" />';
        echo '<input type="hidden" id="courseid" name="COURSE_ID" value="'.$this->courseId.'" />'; 
        echo '<input type="hidden" id="filetype" name="FILE_TYPE" value="'.$this->fileType.'" />';
        echo '<label for="userfilename" class="form-label">Saisir un nom de fichier</label>';

        echo '<input id="userfilename" name="USER_FILE_NAME" class="form-control" type="text" placeholder="Nom de fichier " aria-label="default input example">';
        //echo 'Nom du fichier : <input type="text" id="userfilename" name="USER_FILE_NAME" />';
        echo '</div><h1></h1>';
        echo '  <div class="mb-3" style="max-width: 40rem;">
                <h1></h1>
                <label for="uploadfile" class="form-label">Choisir un fichier à envoyer : </label>
                <input class="form-control" name="userfile" id="uploadfile" type="file" >
                </div>';
        
        
       // echo ' Sélectionnez un fichier : <input id="uploadfile"  class="custom-select" name="userfile" type="file" />';
//        echo '<input type="submit" value="Envoyer le fichier" />';
        echo '</form>'; 
//        echo '<button type="submit" id="form-submit" class="btn btn-success btn-lg pull-right ">Valider</button>';
echo '<h1></h1><div class="mb-3">
<button class="btn btn-primary" id="form-submit" type="submit">Valider</button>
</div>';
    }
    function displayFilesList(){
        //Affichage de la liste des fichiers

        $filesList = $this->getFilesList(); //Récupère la liste des fichiers
        echo "<table id='tablefilelist' class='table table-striped table-bordered'>";
        echo "<thead class='thead-dark'><tr>";
            for($c=0;$c<count($this->fileListHeader);$c++){
                echo "<th>".$this->fileListHeader[$c]."</th>";
            }
            echo "</tr></thead>";
        $fileNumber=0;    
        foreach($filesList as $fileName){
            echo "<tr>";
            echo "<td>".$fileName."</td>";
            for($d=1;$d<count($this->fileListHeader);$d++){
                echo "<td>"."<button class='btn btn-primary' id='".$this->fileListHeaderType[$d-1].$fileNumber."' name='".$fileName."' value='".$this->courseId."'>".$this->fileListHeader[$d]."</button>"."</td>";
            }
            echo "</tr>";
            $fileNumber++; 
        }
        echo "</table>";
    }
    

}
class PTL_LEARNER extends POSTEMLIKE{

    function __construct($courseId, $userId){
        parent::__construct($courseId, $userId);
    }
    function displayMyInformations($filesFound){ //Affichage du contenu des fichiers pour l'usager

        if($filesFound){
            echo '<h1></h1>';
            echo '<div class="accordion " id="accordionStudent">';
            $i = 0;
			foreach($filesFound as $fileName ){ //On traite chaque fichier
                echo '<div class="accordion-item">';
                echo '<h2 class="accordion-header" id="flush-heading'.$i.'">';
                echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'.$i.'" aria-expanded="false" aria-controls="flush-collapse'.$i.'">';
                echo $fileName; 
                echo '</button>';
                echo '</h2>';    
                
                echo '<div id="flush-collapse'.$i.'" class="accordion-collapse collapse" aria-labelledby="flush-heading'.$i.'" data-bs-parent="#accordionStudent">';
                echo '<div class="accordion-body">';
      
               $table = $this->readFile($fileName); //Contient toutes les données
                $sizeTable = count($table);
        
                $head = $table[0]; //Récupération de l'entête
                $sizeHead = count($head); //Nombre d'éléments de l'entête (=nombre de colonnes du tableau)
        
                $myInformations = array(); //Les informations de l'usager
        
                //Recherche, dans le tableau, de la ligne de l'étudiant
                $myId = $this->userId; //Le critère de recherche est l'ID
                $flag = FALSE;
                $myLine = -1; // Numéro de ligne contenant les informations de l'usager
                for($c=1;$c<$sizeTable;$c++){
                    $line = $table[$c];
                    if(strcmp($myId,trim($line[0]))==0){
                        $myInformations = $line; //On a trouvé la ligne d'information de l'usager
                        $myLine = $c;
                        $flag=TRUE;
                    }
                }
                
                //Affichage des informations de l'usager
                if($flag){
                    echo "<table id='tableuser' class='table table-striped table-bordered'>";
                    for($c = 0;$c<$sizeHead-1;$c++){ //On affiche tous les entêtes sauf le dernier ("dernier accès")
                        echo "<tr>";
                        echo "<th>".$head[$c]."&nbsp;: </th><td class='text-break'>".$myInformations[$c]."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    // Réecriture du fichier avec la date de consultation
                    
                    $date = date("d/m/Y G:i");
                    $table[$myLine][$sizeHead-1] = $date;
                    $this->writeFile($fileName,$table);
                    //print_r($table);  
                }else{
                    echo $this->message("#NODATA");
                }
                //print_r($table);
                echo '</div></div></div>';  
                $i++;      
                }
            echo '</div>'; 
            //On peut réécrire le tableau avec la date du dernier accès
           
		}
		else{
			$this->message("#NODATA");
		}	

    }
}
?>

