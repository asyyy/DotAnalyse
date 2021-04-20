<?php
   session_start();
   ?>
<!DOCTYPE HTML>
<TYPE HTML>
<html>
   <head>
      <meta http-equiv="content-type" content = "text/html; charset= ANSI"  />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <title>Heroes</title>
      <link rel="shortcut icon" type="image/png" href="favicon.png"/>
      <link rel='stylesheet' type='text/css' href='banniere-defilante.css' />
   </head>
   <body bgcolor = #212f3d>
      <table class = "body" width = 100%>
      <tr>
         <td>
            <table>
               <td width = 20%><a align=center href=accueil.php class="logo" ><img src = "dotanalyse.png" style="margin-right:200px"></a></td>
               <td width = 70%>
                  <div class='banniere'>
                     <img src="gallery/banniere1test.jpg" title='Image 1' alt='Image 1' />
                     <img src="gallery/banniere2.jpg" title='Image 3' alt='Image 3' />
                  </div>
                  <!-- Javascript -->
                  <script language='Javascript' type='text/javascript' src='jquery.js'></script>
                  <script language='Javascript' type='text/javascript'
                     src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
                  <script language='Javascript' type='text/javascript'
                     src='timer.js'></script>
                  <script language='Javascript' type='text/javascript'
                     src='banniere-defilante.js'></script>
               </td>
               <?php
                  if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
                      echo '<td><a href= monprofil.php class = "button" style="margin-left:100px">Profil</a></td><td><a href= deconnexion.php style="margin-right:25px" class = "button">Déconnexion</a></td>';
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
            <table align =center>
               <td class ="button"><a href= index.php class = "type2">Accueil</a></td>
               <td class ="button"><a href= heroes.php class = "type2">Héros</a></td>
               <td class ="button"><a href= analyse.php class = "type2">Analyse <= contient des schémas en camembert!</a></td>
               <?php
                  if(isset($_SESSION['username']) AND isset($_SESSION['password'])){
                      echo '<td class ="Hello">Bonjour '.$_SESSION['username'].'</td>';;
                    }
                    ?>
            </table>
         </td>
      </tr>
      <tr>
         <td bgcolor = #34495e>
            <table>
               <tr>
                  <?php
                     try{
                         echo "<td>";
                         $pdo = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
                         $pdo -> setAttribute(PDO::ATTR_ERRMODE,
                                              PDO::ERRMODE_EXCEPTION);
                         $pdostat = $pdo->prepare("SELECT id, name FROM heroes ORDER BY id");
                         $pdostat->execute();
                         $pdostat->setFetchMode(PDO::FETCH_ASSOC);
                         echo "<h1>Id : Nom du champion</h1>";
                         echo "<ul>";
                         foreach ($pdostat as $ligne) {
                             echo "<li>" . $ligne['id']. ": " . $ligne['name']."</li>";
                         }
                         echo "</ul>";
                         echo "</td>";
                         echo "<tr>";
                         echo "<td>";
                         echo "<ol>";
                         foreach ($pdostat as $ligne) {
                             echo "<li>" . $ligne['id']. ": " . $ligne['name']."</li>";
                         }
                         echo "</ol>";
                         echo "</td>";

                      }
                      catch (PDOException $e){
                          echo "<p>ERREUR : ".$e->getMessage();
                      }
                     ?>
               </tr>
            </table>
   </body>
</html>
