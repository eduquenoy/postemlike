
$('[id^="display"]').click(function(){
    if($('#zoneall').html().length == 0){
        console.log("Invisible");
        //$('#zoneall').removeClass('visually-hidden');
    
    var fileName = $(this).attr("name");
    var courseId = $(this).attr("value");
        var data = 'code=0'+'&filename='+fileName+"&courseid="+courseId; 
        $.ajax({
            url : 'controler.php',
            type : 'POST', // Le type de la requête HTTP, ici devenu POST
            data : data, // On fait passer nos variables, exactement comme en GET, au script more_com.php
            dataType : 'html',
            success: function(php_script_response){
                //alert(php_script_response);
                $('#zoneall').html(php_script_response);
                //confirm(php_script_response); 
                //console.log(php_script_response);
                
            },       
            error : function(resultat, statut, erreur){
                console.log("Resultat : "+resultat);
                console.log("Statut : "+statut);
                console.log("Erreur : "+erreur); 
            }
        });
    }else{
        console.log("Visible");
        $('#zoneall').html('');
    }
    //alert("Display : "+val);
});

$('[id^="update"]').click(function(){
    //La mise à jour est un dépot de fichier mais avec un nom imposé
    var fileName = $(this).attr("name");
    var courseId = $(this).attr("value");
    var data = 'code=1'+'&filename='+fileName+"&courseid="+courseId; 
    //Il faut afficher le formulaire de téléchargement mais en vérouillant le nom de fichier
    //Commuter affichage onglet :
    $('div #filelistzone').removeClass('show active');
    $('div #upload').addClass('show active');
    $('#userfilename').val(fileName);
    $('#userfilename').attr('disabled',true );
    
    //alert("Display : "+val);
});
$('[id^="delete"]').click(function(){
    var fileName = $(this).attr("name");
    var courseId = $(this).attr("value");
    if (window.confirm('Cliquez sur ok pour supprimer')) {
        var data = 'code=2'+'&filename='+fileName+"&courseid="+courseId; 
        $.ajax({
            url : 'controler.php',
            type : 'POST', // Le type de la requête HTTP, ici devenu POST
            data : data, // On fait passer nos variables, exactement comme en GET, au script more_com.php
            dataType : 'html',
            success: function(php_script_response){
                //alert(php_script_response);
                document.location.reload();
                                //confirm(php_script_response); 
                //console.log(php_script_response);
                
            },       
            error : function(resultat, statut, erreur){
                console.log("Resultat : "+resultat);
                console.log("Statut : "+statut);
                console.log("Erreur : "+erreur);
    
            }
        });

    };
//    alert("Display : "+val);
});
$('[id^="download"]').click(function(){
    var fileName = $(this).attr("name");
    var courseId = $(this).attr("value");
    console.log("CourseID = "+courseId);
    var data = 'code=3'+'&filename='+fileName+"&courseid="+courseId; 
    //alert("Display : "+fileName);
    
    $.ajax({
        url : 'controler.php',
        type : 'POST', // Le type de la requête HTTP, ici devenu POST
        data : data, // On fait passer nos variables, exactement comme en GET, au script more_com.php
        dataType : 'html',
        success: function(php_script_response){
            if (window.confirm('Cliquez sur ok pour télécharger')) {
                window.location.href=php_script_response;
            };
            //confirm(php_script_response); 
            //console.log(php_script_response);
            
        },       
        error : function(resultat, statut, erreur){
            console.log("Resultat : "+resultat);
            console.log("Statut : "+statut);
            console.log("Erreur : "+erreur);

        }
    });
    
});
$('[id^="rename"]').click(function(){
    //il faut renommer le fichier
    var fileName = $(this).attr("name");
    var courseId = $(this).attr("value");
    var data = 'code=1'+'&filename='+fileName+"&courseid="+courseId; 
    //Il faut afficher le formulaire de téléchargement mais en vérouillant le nom de fichier
    //Commuter affichage onglet :
    $('div #filelistzone').removeClass('show active');
    $('div #upload').addClass('show active');
    $('#userfilename').val(fileName);
    $('#userfilename').attr('disabled',true );
    
    //alert("Display : "+val);
});

//Traitement du formulaire de dépôt de fichier
$('#form-submit').click(function(){//On a cliqué sur le bouton de soumission
    //On récupère les infos
    var file_data = $('#uploadfile').prop('files')[0];
    var courseId = $('#courseid').prop('value'); //L'ID de l'espace de cours
    var fileType = $('#filetype').prop('value'); //Le type de fichier imposé
    var userFileName = RemoveAccents($('#userfilename').prop('value').trim()); //Le nom de fichier souhaité
    console.log("Nom : "+userFileName);
    if(userFileName.length < 1){
        alert("Vous devez saisir un nom de fichier .csv!");
    }else{
        //userFileName = userFileName.trim();
        var fileName = courseId + "_" + userFileName + fileType;
        //console.log(Object.entries(file_data));
        //alert(file_data);
        var otherinformation = "toto";
        //var content = new Array();
        content = fileName; // the body of the new file...
        console.log(fileName);
        //content["otherinformation"] =  otherinformation;
        var blob = new Blob([content], { type: "text/strings"});
        var form_data = new FormData();
        form_data.append("informations", blob);
        form_data.append('file', file_data);
        //  form_data.append('filename',fileName);
        //form_data.set('userfile',data);
        //alert(form_data);                             
        $.ajax({
            url: 'upload.php', // <-- point to server-side PHP script 
            dataType: 'text',  // <-- what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
        //contentType: 'multipart/form-data',
            processData: false,
            data: form_data,                         
            type: 'POST',
            success: function(php_script_response){
                //alert(php_script_response); // <-- display response from the PHP script, if any
                location.reload();
                
        }

     });
     if($('#userfilename').prop('disabled')){
        $('#userfilename').attr('disabled',false );
        $('div #upload').removeClass('show active');
        $('div #filelistzone').addClass('show active');
        $('#userfilename').val('');
     }
    }
     //window.location.reload();
    
});
function RemoveAccents(strAccents) {
    var strAccents = strAccents.split('');
    var strAccentsOut = new Array();
    var strAccentsLen = strAccents.length;
    var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž _';
    var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz--";
    for (var y = 0; y < strAccentsLen; y++) {
        if (accents.indexOf(strAccents[y]) != -1) {
            strAccentsOut[y] = accentsOut.substr(accents.indexOf(strAccents[y]), 1);
        } else
            strAccentsOut[y] = strAccents[y];
    }
    strAccentsOut = strAccentsOut.join('');
    return strAccentsOut;
};
