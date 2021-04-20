<?php
/*
  Validation du formulaire d'inscription.
  -On récupère les données et chiffre le mot de passe.

  -On vérifie qu'ils ne sont pas vides et respecte tous la taille demandé
  (Je sais qu'une sha256 devrait toujours être de 64 caractères mais dans le
  doute, je préfère laisser).

  -On vérifie que l'email ou le nom d'utilisateur donnée n'existe pas déjà
  dans la BDD.

  -> Si n'existe pas, on ajoute les nouvelles données.
  -> Sinon on redirige vers inscription.php avec une erreur.


*/
   require("usefull.php");
   $mail = $_POST['mail'];
   $name = $_POST['name'];
   $psw = hash('sha256',$_POST['psw']);

   if($mail != "" && $name != "" && $psw != ""){
     if(strlen($mail)<=50 && strlen($name)<=13 && strlen($psw) == 64){
       try{
         $bdd = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

         $alreadyExist = $bdd->prepare("SELECT mail,username FROM `user`WHERE mail = \"$mail\" OR username = \"$name\" ");
         $alreadyExist->execute();
         $nbr=$alreadyExist->rowCount();

         if($nbr == 0){
           $req = $bdd->prepare("INSERT INTO user (mail, username, password) VALUES (\"$mail\",\"$name\",\"$psw\")");
           $req->execute();
           sendMailInscription($mail,$name);
           exit();
         }else {
           header("Location: inscription.php?error=alreadyExist");
           die();
         }
       }
       catch (PDOException $e){
           echo "<p>ERREUR : ".$e->getMessage();
       }
     }else {
       header("Location: inscription.php?error=tooLong");
       die();
     }

   }

   ?>
