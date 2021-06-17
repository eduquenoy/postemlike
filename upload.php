<?php
require_once("config.php");

//print_r($_FILES);
//echo "Fichier : ".$_FILES['informations']['tmp_name'];

//  print_r($_POST);
//On traite le blob en premier
$uploaddir = getcwd()."/files//";
$tmpfname = tempnam($uploaddir, "FOO"); //Création d'un fichier temporaire
//echo $tmpfname;
if ( 0 < $_FILES['informations']['error'] ) {
    echo 'Error: ' . $_FILES['informations']['error'] . '<br>';
}
else {
    $uploaddir = getcwd();
    $uploadfile = $uploaddir."/files//".basename($_FILES['informations']['name']);
    //$uploadfile = $uploaddir."/files//".$fileName;
    move_uploaded_file($_FILES['informations']['tmp_name'], $tmpfname);
}
//On recharge le fichier temporaire
if (($handle = fopen($tmpfname, "r")) !== FALSE){//ouverture du fichier temporaire
    $contents = fread($handle, filesize($tmpfname));
}

//print_r($table);
fclose($handle);
unlink($tmpfname);
$fileName = $contents;


if ( 0 < $_FILES['file']['error'] ) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
    $uploaddir = getcwd();
    $uploadfile = $uploaddir."/files//".$fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

    //Traitement du fichier : ajout d'un champ "Consultation" visible uniquement par l'instructor
    $row = 1;
    $table= array();
    if (($handle = fopen($uploadfile, "r+")) !== FALSE) {
        while (($data = fgetcsv($handle, 0, $separator, $enclosure)) !== FALSE) {
            
            if($row == 1){
                array_push($data,"Dernier accès");
            }else{
                array_push($data,"never");
            }
            $table[$row] = $data;
//            print_r($data);
  //          $num = count($data);
                $row++;
        }
        fclose($handle);
    if (($handle = fopen($uploadfile, "w")) !== FALSE) {
        foreach($table as $line){
            fputcsv($handle,$line,$separator,$enclosure);
        }
    }
    fclose($handle);

    }




    echo "Success !".$uploadfile;
}


?>
