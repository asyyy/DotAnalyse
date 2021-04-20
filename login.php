<!DOCTYPE HTML>
<TYPE HTML>
<html>
   <head>
      <meta http-equiv="content-type" content = "text/html;charset=UTF-8"  />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <title>Login</title>
      <link rel="shortcut icon" type="image/png" href="favicon.png"/>
   </head>
   <body class = "login">
     <!-- Formulaire pour se connecter -->
      <form action = "identification.php" method = "POST">
      <table class= "login" align = "center">
         <th align = center  colspan=2 class = "login">LOGIN</th>
         <tr>
            <td class = "login">Nom d'utilisateur :  </td>
         </tr>
         <tr>
            <td><input type = "Text" name = "name" placeholder="myusername"></td>
         </tr>
         <tr>
            <td class = "login">Mot de passe : </td>
         </tr>
         <tr>
            <td> <input type = "password" name = "psw" placeholder="eg. X8df!90EO">
         </tr>
         <tr colspan =2 >
            <td align = center><input type ="submit" value = "Login" ></td>
         </tr>
         <tr colspan =2 >
            <td align = center><a href=inscription.php>Créer un compte</a></td>
         </tr>
         <!-- Au retour d'une connexion raté, affichera un message d'erreur -->
         <?php
            $s=$_GET['statut'];

            if(strcasecmp(trim($s),"nop") == 0){

              echo("<tr><td align = center>Identification échoué</td></tr>");

            }

            ?>
      </table>
   </body>
</html>
