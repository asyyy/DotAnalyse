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
               <h1>Les 30 dernières parties : </h1>
            </td>
         </tr>
         <tr>
            <td>
               <!-- Affiche les 30 dernières parties enregistrés dans la base de données dans un tableau. -->
               <!-- l'id de la partie est un lien cliquable qui renvera vers un code php qui va créer une nouvelle page php contenant les informations de la partie. -->
               <!-- L'idée est de n'avoir qu'une seule page php qui va se réécrire pour afficher différentes parties -->
               <?php
                require_once("usefull.php");
                lastThirtyGame();
                  ?>
            </td>
         </tr>
         <tr>
            <td align = center><a href="#haut">Remonter en haut</a></td>
         </tr>
      </table>
      <!-- Au retour d'une inscription réussi affichera un pop-up -->
      <?php
         if(isset($_GET['register'])){
           if($_GET['register'] == 'done'){
           echo '<script>alert("Inscription effectuée, vous allez recevoir un mail de confirmation")</script>';
           }
         }
         ?>
   </body>
</html>
