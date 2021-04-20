<?php

  /*
    Permet de changer le mot de passe d'un utilitateur toujours en restant
    chiffré. On vérifie encore s'ils sont vides (old,new), que leur taille est
    bien celle d'un sha256. Après s'être connecté à la BDD, on vérifie que
    l'utilisateur en question possède bien l'ancien mot de passe, si oui
    on modifie le mot de passe dans la BDD(toujours chiffré).
    On envoie un email de confirmation de changement de mot de passe et qui nous
    redigera vers "monprofil.php".
    Sinon on est redirigé vers "monprofil.php" avec un message d'erreur.
  */

   require("usefull.php");
   $user = $_POST['username'];
   $old = hash('sha256',$_POST['old']);
   $new = hash('sha256',$_POST['new']);

   if($old != "" && $new != ""){
     if(strlen($old) == 64 && strlen($new) == 64){
       try{
         $bdd = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

         $alreadyExist = $bdd->prepare("SELECT username FROM `user` WHERE username = '$user' AND password = '$old' ");
         $alreadyExist->execute();
         $nbr=$alreadyExist->rowCount();

         $mail = $bdd->prepare("SELECT mail FROM `user` WHERE username = '$name' AND password = '$old' ");
         $mail->execute();
         $mail->setFetchMode(PDO::FETCH_COLUMN,0);

         foreach ($mail as $value) {
           $email = $value;
         }

         if($nbr == 1){
           $req = $bdd->prepare("UPDATE `user` SET password = \"$new\" WHERE username = \"$user\" ");

           $req->execute();
           sendMailChangementPSW($email,$user);
           exit();
         }else {
           header("Location: monprofil.php?error=NotFound");
           die();
         }
       }
       catch (PDOException $e){
           echo "<p>ERREUR : ".$e->getMessage();
       }
     }
   }

?>
