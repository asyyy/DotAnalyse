<?php
/* lastThirtyGame,

    Va chercher dans la BDD les 30 dernières parties et affichera dans un
    tableau, l'ID, la DATE, l'EQUIPE gagnante, et le CHAMPIONNANT de la partie.

    -L'ID devient un lien cliquable vers createPHP.php qui va créer une page
    ayant plus d'informations sur cette partie.

    -La Date doit être traduite.

    -L'EQUIPE gagnante est dans la BDD un boolean, il faut donc le traduire
      -> True, Radiant gagne.
      -> False, Dire gagne.
*/

function lastThirtyGame(){
  try{
      $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE,
                           PDO::ERRMODE_EXCEPTION);
      $pdostat = $pdo->prepare("SELECT match_id, start_time, radiant_win, name FROM matches ORDER BY match_id DESC LIMIT 30");
      $pdostat->execute();
      $pdostat->setFetchMode(PDO::FETCH_ASSOC);

      echo "<table border class=\"twenty\" align=center>";
      echo '<th><p class="title">Id</p></th><th><p class="title">Date</p></th><th><p class="title">Vainqueur</p></th><th><p class="title">Nom du championnat</p></th>';

      foreach($pdostat as $ligne){
        $epoch = $ligne['start_time'];
        $dt = new DateTime("@$epoch"); // <-- C'est ça que mon binome a codé
        $id = $ligne['match_id'];
        echo "<tr>";
        echo "<td class = \"type3\" > <a href=createPhp.php?id=$id>$id</a></td>";
        echo "<td class = \"type3\"  >  " .$dt->format('d-m-Y') . "  </td>";
        if($ligne['radiant_win'] == "true"){
          echo "<td class = \"radiant\" >  Radiant  </td>";
        }else{
          echo "<td class = \"dire\" >  Dire  </td>";
        }
        echo "<td class = \"type3\" >  " .$ligne['name'] . "  </td>";
        echo "</tr>";
      }
      echo "</table>";
   }
   catch (PDOException $e){
       echo "<p>ERREUR : ".$e->getMessage();
   }
}
/* recupLabels($req),
    @param $req, une requête SQL
    @return $res, tableau de String.
*/

function recupLabels($req)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse', 'id9485828_user', 'password', array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdostat = $pdo->prepare($req);
        $pdostat->execute();
        $pdostat->setFetchMode(PDO::FETCH_COLUMN, 2);
        $res = array();
        foreach ($pdostat as $key => $value) {
            $temp = array(
                $value
            );
            $res  = array_merge($res, $temp);
        }
        return $res;
    }
    catch (PDOException $e) {
        echo "<p>ERREUR : " . $e->getMessage();
    }
}

/* properArray($labels),
    @param $labels, tableau de String. Nom des données pour décrire les données
                  du graphique (ex: la partie bleu du graphique représente le
                  héros nommé "johnDoe", johnDoe sera dans $labels)
    Les données de $labels récupérées dans la BDD n'ont pas la bonne syntaxe pour
    respecté norme demandé par la fonction créant les graphiques.
    On doit donc les recréer avec la bonne syntaxe.
*/
function properArray($labels)
{
    $res = array();
    foreach ($labels as $key => $value) {
        $temp = array(
            $value . "\n(%.1f%%)"
        );
        $res  = array_merge($res, $temp);
    }
    return $res;
}

/* idToName($list),
    @param $list, tableau d'id
    @return $res, tableau associatif contenant l'id des héros et leur nom.
*/
function idToName($list)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse', 'id9485828_user', 'password', array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdostat = $pdo->prepare("SELECT * FROM heroes");
        $pdostat->execute();
        $pdostat->setFetchMode(PDO::FETCH_ASSOC);
        $res = array();
        foreach ($list as $key => $value) {
            foreach ($pdostat as $ligne) {
                if ($value == $ligne['id']) {
                    $temp = array(
                        $ligne['name']
                    );
                    $res  = array_merge($res, $temp);
                }
            }
        }
        return $res;
    }
    catch (PDOException $e) {
        echo "<p>ERREUR : " . $e->getMessage();
    }
}

/* sendMailInscription($email,$username),
    @param $email, une adresse e-mail.
    @param $username, un nom d'utilisateur.

    Envoie un mail à $email et redirige vers index.php

*/
function sendMailInscription($email, $username)
{
    header("Location: index.php?register=done");
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from    = "dotanalyse@gmail.com";
    $to      = $email;
    $subject = "Confirmation d'inscription sur DotAnalyse";
    $message = $username . " nous vous confirmons votre inscription sur DotAnalyse.";
    $headers = "From:" . $from;
    mail($to, $subject, $message, $headers);
    die();
}
/* sendMailInscription($email,$username),
    @param $email, une adresse e-mail.
    @param $username, un nom d'utilisateur.

    Envoie un mail à $email et redirige vers monprofil.php

*/
function sendMailChangementPSW($email, $username)
{
    header("Location: monprofil.php?change=done");
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from    = "dotanalyse@gmail.com";
    $to      = $email;
    $subject = "Confirmation de changement de mot de passe effectuée";
    $message = $username . " nous vous confirmons le changement de votre mot de passe.";
    $headers = "From:" . $from;
    mail($to, $subject, $message, $headers);
    die();
}

/* wayToPepe($username,$way),
    @param $username, un nom d'utilisateur.
    @param $way, nom de la nouvelle image de profil.

    Pour l'utilisateur donner, va supprimer l'ancienne image de profil du dossier
    "upload", et mettre à jour dans la BDD le nom de la nouvelle image de profil.
*/
function wayToPepe($username, $way)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse', 'id9485828_user', 'password', array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $suppOld = $pdo->prepare("SELECT cheminPP FROM `user` WHERE username = '$username' ");
        $suppOld->execute();
        $suppOld->setFetchMode(PDO::FETCH_COLUMN, 0);
        foreach ($suppOld as $value) {
            $suppOld = $value;
        }
        if ($suppOld != 'johnDoe.jpg') {
            unlink('upload/' . $suppOld);
        }
        $update = $pdo->prepare("UPDATE `user` SET cheminPP = '$way' WHERE username = '$username' ");
        $update->execute();
    }
    catch (PDOException $e) {
        echo "<p>ERREUR : " . $e->getMessage();
    }
}
/* echoImg($username),
    @param $username, nom d'utilisateur.

    Va chercher dans la BDD le nom de l'image de profil de $username
    et l'affiche.
*/
function echoImg($username)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse', 'id9485828_user', 'password', array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdostat = $pdo->prepare("SELECT cheminPP FROM `user` WHERE username = '$username'");
        $pdostat->execute();
        $pdostat->setFetchMode(PDO::FETCH_COLUMN, 0);
        foreach ($pdostat as $value) {
            $pdostat = $value;
        }
        echo '<img src = upload/' . $pdostat . ' />';
    }
    catch (PDOException $e) {
        echo "<p>ERREUR : " . $e->getMessage();
    }
}
/*
  Tentative pour ajuster la taille de l'image. <- N'arrive pas à le faire marcher
*/
function store_uploaded_image($html_element_name, $new_img_width, $new_img_height)
{
    require("resize.php");
    $target_dir  = "upload/";
    $target_file = $target_dir . basename($_FILES[$html_element_name]["name"]);
    $image       = new SimpleImage();
    $image->load($_FILES[$html_element_name]['tmp_name']);
    $image->resize($new_img_width, $new_img_height);
    $image->save($target_file);
    return $target_file; //return name of saved file in case you want to store it in you database or show confirmation message to user

}
?>
