<?php
   if (isset($_GET['error'])) {
       $error = $_GET['error'];
       if ($error == "alreadyExist") {
           echo ("Email/Nom d'utilisateur déjà existant.");
       }
       if ($error == "tooLong") {
           echo ("La limite de caractère de l'e-mail est 50 et la limite de caractère du Nom d'utilisateur/Mot de passe est de 13.");
       }
   }
  ?>

<!DOCTYPE HTML>
<TYPE HTML>
<html>
   <head>
      <meta http-equiv="content-type" content = "text/html;charset=UTF-8"  />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <title>Inscription</title>
      <link rel="shortcut icon" type="image/png" href="favicon.png"/>
      <!-- Javascript qui vérifie si les champs ne sont pas vides et si l'email correspond bien au format d'un email (ex : azer@ty.com) -->
      <script>
         function validation()
           {
             var cara = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
             if ((document.mon_form.mail.value=="")||
               (document.mon_form.name.value=="")||
               (document.mon_form.psw.value=="") ||
               !cara.test(document.mon_form.mail.value))
               {
                 window.alert ("Certains champs sont vides ou l'email contient des caractères spéciaux.")
                 return false;
             }

         }
      </script>
   </head>
   <body bgcolor = "#34495e">
     <!-- Formulaire d'inscription vers "validation.php" -->
      <form action = "validation.php" method=post name="mon_form" onSubmit="return validation(this.form)">
      <table  align = center class = "inscription">
         <th align = center  colspan=2 class = "login">Inscription</th>
         <tr>
            <td class = "login">Email :  </td>
         </tr>
         <tr>
            <td><input type = "Text" name = "mail" placeholder="myemail@email.com" required></td>
         </tr>
         <tr>
            <td class = "login">Nom d'utilisateur :  </td>
         </tr>
         <tr>
            <td><input type = "Text" name = "name" placeholder="myusername" required></td>
         </tr>
         <tr>
            <td class = "login">Mot de passe : </td>
         </tr>
         <tr>
            <td> <input type = "password" name = "psw" placeholder="eg. X8df!90EO" required>
         </tr>
         <tr colspan =2 >
            <td align = center><input type ="submit" value = "M'enregistrer" ></td>
         </tr>

      </table>
   </body>
</html>
