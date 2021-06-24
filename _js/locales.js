function message(code,lang){
    console.log("Clef : "+code+" Langue : "+lang);
    var ptlStr;
    switch(lang){
        case 'fr':
            var ptlStr =
                {
                    '##YES##' : 'Oui',
                    '##NO##' : 'Non',
                    '##TITLE_TAB_POSTEM##' : "Bulletin de liaison",
                    '##TITLE_TAB_UPLOAD##' : "Ajouter fichier",
                    '##TITLE_COLUMN_TITLE##' : 'Titre',
                    '##TITLE_COLUMN_DISPLAY##' : 'Voir',
                    '##TITLE_COLUMN_UPDATE##' : 'Mettre à jour',
                    '##TITLE_COLUMN_DELETE##' : 'Supprimer',
                    '##TITLE_COLUMN_DOWNLOAD##' : 'Télécharger',
                    '##TITLE_CARD_UPLOAD##' : 'Instructions',
                    '##TEXT_CARD_UPLOAD##' : '<ul>\
                        <li>Votre fichier de commentaires doit être enregistré au format <code>.csv</code> (valeurs séparées par une virgule).</li>\
                        <li>La <strong>première colonne</strong> de votre fichier doit contenir des <strong>emails</strong> d’utilisateurs.</li>\
                        <li>La <strong>première ligne</strong> de votre fichier doit contenir les <strong>noms des colonnes</strong>.</li>\
                        </ul>',
                    '##LABEL_FORM_NAME_FILE##' : 'Saisir un nom de fichier :',
                    '##LABEL_FORM_TEXT_UPLOAD##' : 'Cliquez ci-dessous pour choisir un fichier :',
                    '##LABEL_FORM_UPLOAD##' : 'Cliquer pour choisir un fichier...',
                    '##BUTTON_FORM_SUBMIT##' : 'Valider',
                    '##PLACE_HOLDER_FORM_FILE##'  : 'Saisir un nom de fichier ici !',
                    '##CONFIRM##' : 'Confirmez !',
                    '##ALERT_CHOOSE_FILE_AND_NAME##' : 'Vous devez choisir un fichier .csv et saisir un nom'
                };
                break;
        case 'es':
            var ptlStr =
            {
                '##YES##' : 'Si',
                '##NO##' : 'No',
                '##TITLE_TAB_POSTEM##' : "Postem",
                '##TITLE_TAB_UPLOAD##' : "Añadir",
                '##TITLE_COLUMN_TITLE##' : 'Título',
                '##TITLE_COLUMN_DISPLAY##' : 'Ver',
                '##TITLE_COLUMN_UPDATE##' : 'Actualizar',
                '##TITLE_COLUMN_DELETE##' : 'Eliminar',
                '##TITLE_COLUMN_DOWNLOAD##' : 'Descargar',
                '##TITLE_CARD_UPLOAD##' : 'Instrucciones',
                '##TEXT_CARD_UPLOAD##' : '<ul>\
                    <li>Su archivo de comentarios debe guardarse en formato <code> .csv </code> (valores separados por comas).</li>\
                    <li>La <strong> primera columna </strong> de su archivo debe contener <strong> correos electrónicos </strong> de los usuarios.</li>\
                    <li>La <strong> primera línea </strong> de su archivo debe contener los <strong> nombres de columna.</strong>.</li>\
                    </ul>',
                '##LABEL_FORM_NAME_FILE##' : 'Haga clic a continuación para ingresar un nombre de archivo :',
                '##LABEL_FORM_TEXT_UPLOAD##' : 'Haga clic a continuación para elegir un archivo :',
                '##LABEL_FORM_UPLOAD##' : 'Haga clic para elegir un archivo para enviar ...',
                '##BUTTON_FORM_SUBMIT##' : 'Enviar',
                '##PLACE_HOLDER_FORM_FILE##'  : 'Ingrese un nombre de archivo',
                '##CONFIRM##' : '¡Confirmar!',
                '##ALERT_CHOOSE_FILE_AND_NAME##' : 'Elija un archivo .csv y un nombre'

            }; 
            break;
        default :  
        var ptlStr =
            {
                '##YES##' : 'Yes',
                '##NO##' : 'No','##TITLE_TAB_POSTEM##' : "Post'Em",
                '##TITLE_TAB_UPLOAD##' : "Add file",
                '##TITLE_COLUMN_TITLE##' : 'Title',
                '##TITLE_COLUMN_DISPLAY##' : 'Display',
                '##TITLE_COLUMN_UPDATE##' : 'Update',
                '##TITLE_COLUMN_DELETE##' : 'Delete',
                '##TITLE_COLUMN_DOWNLOAD##' : 'Download',
                '##TITLE_CARD_UPLOAD##' : 'Instructions',
                '##TEXT_CARD_UPLOAD##' : '<ul>\
                    <li>Your comments file must be saved in <code> .csv </code> format (comma separated values).</li>\
                    <li>The <strong> first column </strong> of your file should contain <strong> emails </strong> from users.</li>\
                    <li>The <strong> first line </strong> of your file should contain the <strong> column names </strong>.</li>\
                    </ul>',
                '##LABEL_FORM_NAME_FILE##' : 'Click below to enter a file name:',
                '##LABEL_FORM_TEXT_UPLOAD##' : 'Click below to choose a file:',
                '##LABEL_FORM_UPLOAD##' : 'Click to choose a file to send...',
                '##BUTTON_FORM_SUBMIT##' : 'Send',
                '##PLACE_HOLDER_FORM_FILE##'  : 'Enter a file name',
                '##CONFIRM##' : 'Confirm! !',
                '##ALERT_CHOOSE_FILE_AND_NAME##' : 'Choose a .csv file and a name'

            };  
    }

//console.log("Texte : "+ptlStr[code]);
    return ptlStr[code];
}