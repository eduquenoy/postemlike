<?php
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
//    $uploadfile = $uploaddir."/files//".basename($_FILES['file']['name']);
    $uploadfile = $uploaddir."/files//".$fileName;
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
    echo "Success !";
}


?>
