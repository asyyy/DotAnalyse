<?php
   session_start();
   $name = $_POST['name'];
   $psw = $_POST['psw'];
   $chiffre = hash('sha256',$psw);
   try{
       $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
       $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
       $pdoreq = $pdo -> prepare("SELECT COUNT(`username` = '$name' AND `password` = '$chiffre'),`username`,`password`  FROM `user` WHERE `username` = '$name' AND `password` = '$chiffre'");
       $pdoreq->execute();
       $pdoreq->setFetchMode(PDO::FETCH_ASSOC);

       if(count($pdoreq) == 1){
         foreach ($pdoreq as $ligne) {

           if($ligne['COUNT(`username` = \''.$name.'\' AND `password` = \''.$chiffre.'\')'] == 1 && $ligne['username'] == $name && $ligne['password'] == $chiffre){

                $_SESSION['username'] = $name;
                $_SESSION['CONNECT'] = 'YES';
                header("Location: index.php?connect=succes");
                exit();
           }
       }
        header("Location: login.php?statut=nop");
        exit();
      }
     }
    catch (PDOException $e){
        echo "<p>ERREUR : ".$e->getMessage();
    }
?>
