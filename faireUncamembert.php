<?php
   function makeAcamembert($title,$req,$labels){

     require_once("src/jpgraph.php");
     require_once("src/jpgraph_pie.php");
     $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
     $pdo -> setAttribute(PDO::ATTR_ERRMODE,
                          PDO::ERRMODE_EXCEPTION);
     $pdostat = $pdo->prepare($req);
     $pdostat->execute();
     $pdostat->setFetchMode(PDO::FETCH_COLUMN,1);
     $list = array();
     foreach ($pdostat as $key => $value) {
       $temp = array($value);
       $list = array_merge($list,$temp);
     }
     $donnees= $list;

     $largeur = 500;
     $hauteur = 500;

     // Initialisation du graphique
     $graphe = new PieGraph($largeur, $hauteur);

     // Creation du camembert
     $camembert = new PiePlot($donnees);
     $camembert->SetLabels($labels);
     $camembert->SetLabelPos(0.9);
     $camembert->SetLabelType(PIE_VALUE_PER);
     $camembert->value->Show();

     // Ajout du camembert au graphique
     $graphe->add($camembert);

     // Ajout du titre du graphique
     $graphe->title->set($title);


     // Affichage du graphique

     $graphe->Stroke("gallery/".$title.".png");
   }
   ?>
