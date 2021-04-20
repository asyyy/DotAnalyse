<?php
   session_start();
   ?>
<!DOCTYPE HTML>
<TYPE HTML>
<html>
   <head>
      <meta http-equiv="content-type" content = "text/html; charset= ANSI"  />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <title>Accueil</title>
      <link rel="shortcut icon" type="image/png" href="favicon.png"/>
      <link rel='stylesheet' type='text/css' href='banniere-defilante.css' />
      <!-- Javascript qui vérifie si les champs ne sont pas vides et si l'ancien mot de passe n'est pas le même que le nouveau -->
      <script>
         function validation()
           {
             if ((document.mon_form.old.value=="")||
               (document.mon_form.new.value=="")||
               (document.mon_form.old.value==document.mon_form.new.value))
               {
                 window.alert ("Certains champs sont vides ou les mots de passe sont les mêmes.")
                 return false;
             }

         }
      </script>
   </head>
   <body bgcolor = #212f3d>
      <table class = "body" width = 100% id="haut">
         <tr>
            <td>
               <table>
                  <td width = 20%><a align=center href=index.php class="logo" ><img src = "dotanalyse.png" style="margin-right:200px"></a></td>
                  <td width = 70%>
                     <div class='banniere'>
                       <!-- Choix des images pour la bannière -->
                        <img src="gallery/banniere1test.jpg" title='Image 1' alt='Image 1' />
                        <img src="gallery/banniere2.jpg" title='Image 3' alt='Image 3' />
                     </div>
                     <!-- Javascript pour la bannière défilante -->
                     <script language='Javascript' type='text/javascript' src='jquery.js'></script>
                     <script language='Javascript' type='text/javascript'
                        src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
                     <script language='Javascript' type='text/javascript'
                        src='timer.js'></script>
                     <script language='Javascript' type='text/javascript'
                        src='banniere-defilante.js'></script>
                  </td>
                  <!-- Affiche "profil/deconnexion" au lieu de "login/inscription" s'il détecte une session d'utilisateur -->
                  <?php
                     if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
                         echo '<td><a href= monprofil.php class = "button"  style="margin-left:100px">Profil</a></td><td><a href= deconnexion.php class = "button"  style="margin-right:25px" >Déconnexion</a></td>';
                       }else {
                         session_destroy();
                         echo '<td><a href= login.php?statut=try class = "button" style="margin-left:100px">Connexion</a></td>';
                         echo '<td><a href= inscription.php class = "button" style="margin-right:25px">Inscription</a></td>';
                       }
                       ?>
               </table>
            </td>
         </tr>
         <tr>
            <td bgcolor = #34495e>
               <table align = center>
                  <td class ="button"><a href= index.php class = "type2">Accueil</a></td>
                  <td class ="button"><a href= heroes.php class = "type2">Héros</a></td>
                  <td class ="button"><a href= analyse.php class = "type2">Analyse <= contient des schémas en camembert!</a></td>
                  <!-- Affiche le nom de l'utilisateur connecté -->
                  <?php
                     if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
                         echo '<td class ="Hello">Bonjour '.$_SESSION['username'].'</td>';;
                       }
                       ?>
               </table>
            </td>
         </tr>
         <tr>
            <td>
               <table border class = "analyse" align = center>
                  <tr>
                     <td><U>Nom d'utilisateur :</U> <?php echo $_SESSION['username'];?></td>
                     <td rowspan="7">
                        <table>
                           <tr>
                              <td align = center>
                                 Image de profil : (Pas trop grand conseillé, j'ai pas réussi le ré-ajustement)
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <p align =center>
                                   <!-- affiche l'image associé à l'utilisteur en allant récupérer le nom de l'image dans la BDD
                                        par défaut l'image est "johnDoe.jpg"-->
                                    <?php
                                       require_once("usefull.php");
                                       echoImg($_SESSION['username']);
                                       ?>
                                 </p>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                <!-- Formulaire pour changer son image de profil, avec une taille max de fichier. Envoie vers upload.php -->
                                 <form method="POST" action="upload.php" enctype="multipart/form-data">
                                    <input type="hidden" name="username" value= <?php echo $_SESSION['username'];?> />
                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">Changer votre image de profil :
                              </td>
                           </tr>
                           <tr><td align = center>
                           <input type="file" name="avatar">
                           </tr></td>
                           <tr><td align = center>
                           <input type="submit" name="envoyer" value="Envoyer le fichier"></form>
                           </td></tr>
                        </table>
                     </td>
                  </tr>
                  <!-- Formulaire pour changer de mot de passe, envoie de l'ancien, du nouveau mot de passe
                  et du nom de l'utilisateur vers changermdp.php" -->
                  <form action = "changermdp.php" method=post name="mon_form" onSubmit="return validation(this.form)">
                  <tr>
                     <td><U>Pour changer de mot de passe, completez les champs ci-dessous.</U></td>
                  </tr>
                  <tr>
                     <td class = "login">Ancien mot de passe : </td>
                  </tr>
                  <tr>
                     <td align = center> <input type = "password" name = "old" placeholder="eg. X8df!90EO" required></td>
                  </tr>
                  <tr>
                     <td class = "login">Nouveau mot de passe : </td>
                  </tr>
                  <tr>
                     <td align = center> <input type = "password" name = "new" placeholder="eg. X8df!90EO" required></td>
                  </tr>
                  <input type="hidden" name="username" value= <?php echo $_SESSION['username'];?> />
                  <tr>
                     <td align = center><input type ="submit" value = "Changer de mot de passe" ></td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      <!-- Au retour d'une erreur lors d'une changement de mot de passe, ou du changement de photo de profil raté, affiche un message d'erreur -->
      <?php
         if(isset($_GET['change'])){
           if($_GET['change'] == 'done'){
           echo '<script>alert("Changement effectuée, vous allez recevoir un mail de confirmation.")</script>';
           }
         }
         if(isset($_GET['error'])){
           if($_GET['error'] == 'none'){
           echo '<script>alert("Changement de l\'image de profil effectuée.")</script>';
           }
           if($_GET['error'] == 'size'){
           echo '<script>alert("Le fichier est trop gros...")</script>';
           }
           if($_GET['error'] == 'type'){
           echo '<script>alert("Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...")</script>';
           }
           if($_GET['error'] == 'upload'){
           echo '<script>alert("Erreur lors de l\'upload du fichier.")</script>';
           }
           if($_GET['error'] == 'NotFound'){
           echo '<script>alert("L\'ancien mot de passe ne correspond pas.")</script>';
           }

         }

         ?>
   </body>
</html>
