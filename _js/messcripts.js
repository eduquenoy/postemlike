//Chargement
$( document ).ready(function() {
   // afficherPopupInformation("Ceci est un message");
  

   //Il faut consulter un élément pour savoir dans quel mode, Instructor ou Learner, on se trouve
    var userId = $('#userid').val();
    var courseId = $('#courseid').val();
    var userRole = $('#userole').val();
    var locale = $('#locale').val();
    switch(locale){
        case 'fr':
        case 'fr_FR':
            var lang = "fr";
            break;
        case 'es':
        case 'es_ES':
            var lang = "es";
            break;
        default :
        var lang = "en";
    }
    console.log("Langue détectée : "+lang);
    /*console.log("Chargement outil Postemlike");
    console.log("UserId : "+userId);
    console.log("CourseId : "+courseId);
    console.log("UserRole : "+userRole);
*/
    if(userRole == "Instructor"){
  //      console.log("Mode Instructeur");
        
        //Rendu des onglets
        $('#filelistzone-tab').addClass('active');
        $('#upload-tab').removeClass('active');
        $('div #upload').removeClass('show active');
        $('div #filelistzone').addClass('show active');

        //Mise à jour du texte des boutons d'onglets
        $('#filelistzone-tab').html(message('##TITLE_TAB_POSTEM##',lang));
        $('#upload-tab').html(message('##TITLE_TAB_UPLOAD##',lang));

        //Mise à jour du texte contenu dans l'onglet Add file
        $('#title-card-upload').html(message('##TITLE_CARD_UPLOAD##',lang));
        $('#text-card-upload').html(message('##TEXT_CARD_UPLOAD##',lang));
        $('#form-label-name').html(message('##LABEL_FORM_NAME_FILE##',lang));
        $('#form-label-file').html(message('##LABEL_FORM_UPLOAD##',lang));
        $('#form-label-file-text').html(message('##LABEL_FORM_TEXT_UPLOAD##',lang));
        $('#form-submit').html(message('##BUTTON_FORM_SUBMIT##',lang));
        $('#userfilename').attr('placeholder',message('##PLACE_HOLDER_FORM_FILE##',lang));
        
        //Mise à jour texte des modals 
        $('#myModalLabel').html(message('##CONFIRM##',lang));
        $('#modal-btn-si').html(message('##YES##',lang));
        $('#modal-btn-no').html(message('##NO##',lang));
        //Affichage de la liste des fichiers
       var data = 'code=6'+"&courseid="+courseId; 
       instructorView(data,courseId,lang);
        
    }
    else{
      //  console.log("Mode Learner");
    }
    $('span#version').html("Version : "+version());
   
});
function displayFilesList(tableau,courseId,lang){
    var fileListHeader = [message("##TITLE_COLUMN_TITLE##",lang), message("##TITLE_COLUMN_DISPLAY##",lang), message("##TITLE_COLUMN_UPDATE##",lang), message("##TITLE_COLUMN_DELETE##",lang), message("##TITLE_COLUMN_DOWNLOAD##",lang)];
    var fileListHeaderType = ["display","update","delete","download"];

    /* 
    console.log(tableau.length);
    for(var c=0;c<tableau.length;c++){
        console.log("Element "+c+" Contenu : "+tableau[c]);
    }*/
    html = "<table id='tablefilelist' class='table table-striped table-bordered'>" +
            "<thead class='thead-dark'><tr>";
    for(c=0;c<fileListHeader.length;c++){
                html = html + "<th>" + fileListHeader[c] +"</th>";
            }   
    html = html + "</tr></thead>";
    var fileNumber=0;
    for(c=0;c<tableau.length;c++){
        //Ajout d'une ligne au tableau :fileNumber, tableau[c], fileListHeader, fileListHeaderType, courseId, 
        html = html + "<tr id='tableTr" + fileNumber  + "'>" + "<td>" + tableau[c] + "</td>"; 
        for(d=1;d<fileListHeader.length;d++){
            html = html + "<td>" + "<button class='btn btn-primary' id='" + fileListHeaderType[d-1] + fileNumber + "' name='" + tableau[c] + "' value='" + courseId + "'>" + fileListHeader[d] +"</button>"+"</td>";

        }
        html = html + "</tr>";
        fileNumber++; 
    }
    html = html + "</table>";
    html = html + "<div id='zoneall'></div>"

    $('#filelistzone').html(html);

};

function instructorView(data,courseId,lang){
    $.ajax({

        url : 'controler.php',
        type : 'POST', // Le type de la requête HTTP, ici devenu POST
        data : data, // On fait passer nos variables, exactement comme en GET, au script controleur.php
        dataType : 'json',
        success: function(php_script_response){
            //alert(php_script_response);
            displayFilesList(php_script_response,courseId,lang)
            //alert(php_script_response);
            //$('#zoneall').html(php_script_response);
            //confirm(php_script_response); 
            //console.log(php_script_response);
           // alert($('#filelistzone').html());
           //control();
           $('#display0').hover(function(){
            console.log("Survol");
        });
       


        //Boutons instructor
        
        $('[id^="display"]').click(function(){ //Clic sur bouton "Voir"
            console.log("Display");
        
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
            $('#filelistzone-tab').removeClass('active');
            $('div #upload').addClass('show active');
            $('#upload-tab').addClass('active');
            $('#userfilename').val(fileName);
            $('#userfilename').attr('disabled',true );
               
            
        
        
            //alert("Display : "+val);
        });
        $('[id^="delete"]').click(function(){
            var fileName = $(this).attr("name");
            var courseId = $(this).attr("value");
            var tableTr = $(this).parent().parent().attr('id');//Le nom de la ligne du tableau
            console.log("fileName : " + fileName + " courseId : "+courseId+" tableTr : "+tableTr);
            $("#mi-modal").modal('show');
        //    if (window.confirm('Cliquez sur ok pour supprimer')) 
            modalConfirm(function(confirm){
            if(confirm){
                var data = 'code=2'+'&filename='+fileName+"&courseid="+courseId; 
                $.ajax({
                    url : 'controler.php',
                    type : 'POST', // Le type de la requête HTTP, ici devenu POST
                    data : data, // On fait passer nos variables, exactement comme en GET, au script more_com.php
                    dataType : 'html',
                    success: function(php_script_response){
                        //alert(php_script_response);
                        //document.location.reload();
                        console.log("Ligne à supprimer : "+tableTr);
                        $('#'+tableTr).remove();
                        tableHide();
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
            });
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






        },       
        error : function(resultat, statut, erreur){
            console.log("Resultat : "+resultat);
            console.log("Statut : "+statut);
            console.log("Erreur : "+erreur); 
        }
    });
    
 }




//Boutons 
//Instructor
$('#filelistzone-tab').click(function(){
    console.log("Bulletin liaison");
});

// Learner
$('[id^="accordion-button"]').click(function(){
    var buttonState = $(this).attr("aria-expanded");
    var fileName = $(this).text();
    var courseId = $(this).attr("courseid");
    var userId = $(this).attr("userid");
    var data = 'code=5'+'&filename='+fileName+"&courseid="+courseId+"&userid="+userId; 

    if(buttonState=="true"){    
        console.log("Bouton cliqué. Nom fichier : "+fileName+ "  Id cours : "+courseId+" UserId : "+userId);
        $.ajax({
            url : 'controler.php',
            type : 'POST', // Le type de la requête HTTP, ici devenu POST
            data : data, // On fait passer nos variables, exactement comme en GET, au script more_com.php
            dataType : 'html',
            success: function(php_script_response){
                //alert(php_script_response);
                //$('#zoneall').html(php_script_response);
                //confirm(php_script_response); 
                //console.log(php_script_response);
                
            },       
            error : function(resultat, statut, erreur){
                console.log("Resultat : "+resultat);
                console.log("Statut : "+statut);
                console.log("Erreur : "+erreur); 
            }
        });
    }


});

//Traitement du formulaire de dépôt de fichier
$('input[type=file]').change(function(e){
    $in=$(this);
    var fullFileName = $in.val();
    console.log("Nom du fichier : "+$in.val()+ " Nom seul : "+fullFileName.substr(fullFileName.lastIndexOf("\\")+1));
    $('#form-label-file').html(fullFileName.substr(fullFileName.lastIndexOf("\\")+1));
  });

  
$('#form-submit').click(function(){//On a cliqué sur le bouton de validation dans le formulaire d'ajout de fichier
    //On récupère les infos
    var locale = $('#locale').val();
    switch(locale){
        case 'fr':
        case 'fr_FR':
            var lang = "fr";
            break;
        case 'es':
        case 'es_ES':
            var lang = "es";
            break;
        default :
        var lang = "en";
    }
    console.log("Langue détectée : "+lang);
    var file_data = 0;
    file_data = $('#uploadfile').prop('files')[0];
    var courseId = $('#courseid').prop('value'); //L'ID de l'espace de cours
    var fileType = $('#filetype').prop('value'); //Le type de fichier imposé
    var userFileName = RemoveAccents($('#userfilename').prop('value').trim()); //Le nom de fichier souhaité
      
   // console.log("Nom : "+userFileName);
    if(userFileName.length < 1 || !file_data){

        displayModal("Attention",message('##ALERT_CHOOSE_FILE_AND_NAME##',lang),1);
       //alert("Vous devez saisir un nom de fichier .csv!");
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
             //   displayModal("Envoi","Votre fichier a été envoyé avec succès",0);
             //   $('tableTr tr:last').append();
             //location.reload();

             //Bascule onglet principal
            $('#filelistzone-tab').addClass('active');
            $('#upload-tab').removeClass('active');
            $('div #upload').removeClass('show active');
            $('div #filelistzone').addClass('show active');
            //console.log("Après chargement fichier, courseId : ")
            var data = 'code=6'+"&courseid="+courseId; 
            instructorView(data,courseId,lang);
           
        }

     });
     //bascule onglet principal
     if($('#userfilename').prop('disabled')){
         console.log("Bascule onglet principal");
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
function tableHide(){
    if($('[id^="display"]').length<1){
        console.log('Table vide');
        $('#tablefilelist').css('visibility','hidden');
        $('#zoneall').html("Aucune donnée à afficher");           

    }else{
        console.log('Table non vide');
        $('#zoneall').html("");           

        $('#tablefilelist').css('visibility',''); 
    }
}
function version(){
    var version = 0.2;
    return version;
}



