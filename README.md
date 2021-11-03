# Postemlike
## Français
 Un modeste équivalent, cependant à la norme IMS LTI, de l'outil [Post'Em](https://sakai.screenstepslive.com/s/sakai_help/m/50750/l/464124-what-is-the-postem-tool)  du [LMS Sakai](https://www.sakailms.org/)
### Qu'est-ce que l'outil Post'Em ?
#### Présentation
L'outil intitulé Bulletin de liaison (ou Post'Em en anglais), permet la publication rapide de __tableaux__ issus de logiciels tel que Excel ou LibreOffice Calc. Il s'agit d'un outil proche du bulletin de notes, mais en beaucoup plus simple

#### Intérêt de l'outil
Imaginons que vous veniez de corriger des comptes-rendus de travaux pratiques et que vous vouliez transmettre les notes à chaque étudiant de manière individualisée (un étudiant ne voit pas les notes des autres étudiants) et personnalisée (vous souhaitez ajouter un petit commentaire à chacun). Il suffit de créer, à l'aide d'un tableur, une feuille de calcul où :
- la __première ligne__ contient obligatoirement les intitulés de colonnes. Cependant, rien est imposé pour leur libellé,
- la __première colonne__ contiendra obligatoirement les emails des participants auxquels vous vous adressez,
- à partir de la seconde colonne, vous ajoutez les informations que vous souhaitez : texte ou valeur numérique.  
- à partir de la __deuxième ligne__, chaque ligne correspondra aux informations destinés à un usager,
- à partir de la __deuxième ligne__, vous pouvez saisir du texte ou des valeurs numériques (comme des notes par exemple).
- une fois votre feuille de calcul complétée, il vous reste à l'exporter au format .csv (on exporte donc que la feuille courante du classeur)

#### Installation
- l'outil est développé en PHP, il nécessite donc un serveur supportant ce langage. 
- il faudra également modifier le fichier `config.txt`  qui conient les clefs/secrets du protocole LTI (norme v1)
- l'URL de lancement de l'outil ressemble à https://mon-url.com/lti_access.php

#### Développements à prévoir (feuille de route)
L'outil est encore en développement mais fonctionne correctement. Plusieurs améliorations, visibles ou d'arrière plan, sont à envisager :
- la plus chronophage : le passage à une bibliothèque LTI plus récente que l'actuelle (développée à l'origine par Dr. Chuck _alias_ [Charles Severance](https://github.com/csev/sakai-lti-test)). Peut-être une migration vers [Tsugi](https://www.tsugi.org/) ?
- l'ajout d'une base de données (il n'y en a pas actuellement), pour améliorer la saisie des noms de fichiers et leur gestion, peut-être y ajouter un commentaire ou un sous-titre, ...,
- la possibilité de publier/dépublier les fichiers sans les supprimer pour autant (c'est une fonctionnalité qui existe dans le Post'Em de Sakai),
- vérifier lors du téléversement du fichier, que les emails contenus dans le fichier correspondent bien à des usagers inscrits dans le cours. Cependant, cela n'est actuellement pas possible à cause de la bibliothèque LTI qui ne permet pas d'accèder à la liste des participants (le _Roster_),
- proposer un modèle de fichier par défaut (idem que l'amélioration précédente, cela nécessite l'accès à la liste des participants),
-  amélioration de la sécurité (coté backend notamment).

## English
A modest equivalent, however to the IMS LTI standard, of the [Post'Em] tool (https://sakai.screenstepslive.com/s/sakai_help/m/50750/l/464124-what-is-the-postem -tool) from [LMS Sakai] (https://www.sakailms.org/)

### What's the Post'Em tool?
#### Presentation
This tool allows the rapid publication of __tables__ from software such as Excel or LibreOffice Calc. It is a tool similar to the GradeBook, but much simpler

#### Interest of the tool
Imagine that you have just corrected practical work reports and you want to send the notes to each student individually (a student does not see the notes of other students) and personalized (you want to add a small comment to each). Just create an array where:
- the __first line__ must contain the column titles. However, nothing is imposed for their wording,
- the __first column__ must contain the emails of the participants to whom you are addressing,
- from the __second line__, each line will correspond to the information intended for a user,
- from the __second line__, you can enter text or numeric values ​​(like notes for example)

#### Installation
- the tool is developed in PHP, so it requires a server supporting this language.
- it will also be necessary to modify the `config.txt` file which contains the keys / secrets of the LTI protocol (standard v1)
- the tool launch URL looks like https://mon-url.com/lti_access.php


#### Developments to be planned (roadmap)
The tool is still in development but works fine. Several improvements, visible or in the background, should be considered:
- the most time-consuming: the switch to an LTI library more recent than the current one (originally developed by Dr. Chuck _alias_ [Charles Severance](https://github.com/csev/sakai-lti-test)) . Maybe a migration to [Tsugi](https://www.tsugi.org/)?
- the addition of a database (there is not currently one), to improve the entry of file names and their management, perhaps add a comment or a subtitle, ...
- the ability to publish / unpublish files without deleting them (this is a feature that exists in Sakai's Post'Em)
- check when uploading the file that the emails contained in the file correspond to users registered in the course. However, this is currently not possible because of the LTI library which does not allow access to the list of participants (the _Roster_)
- propose a default file template (same as the previous improvement, this requires access to the list of participants)