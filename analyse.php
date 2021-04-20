<?php
   session_start();
   include("faireUncamembert.php");
   require("usefull.php");
   ?>
<!DOCTYPE HTML>
<TYPE HTML>
<html>
   <head>
      <meta http-equiv="content-type" content = "text/html; charset= ANSI"  />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <title>Analyse</title>
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
               <table align = center class="analyse">
                  <th colspan=2 class = "analyse"> Différentes analyses</th>
                  <tr>
                     <td class = "analyse"  colspan=2>(les images sont créés en php en récupérant des données par des requêtes SQL)</td>
                  </tr>
                  <tr>
                     <td class = "img">
                        <p class = "title">Ratio de victoire Radiant/Dire</p>
                        <!-- On lui donne un nom, une requête SQL, il recréer une tableau pour avoir la bonne syntaxe et créer l'image demandé -->
                        <?php
                           $title = "radiantVsdire";//ON N'UTILISE PAS LES ESPACES
                           $req = "SELECT `radiant_win`,COUNT(`radiant_win`) FROM matches GROUP BY `radiant_win` ORDER BY COUNT(`radiant_win`) DESC ";
                           $labels = properArray(array("Radiant","Dire"));
                           makeAcamembert($title,$req,$labels);
                           ?>
                        <img src = "<?php echo "gallery/".$title.".png";?>"/>
                     </td>
                     <td class = "img">
                        <p class = "title">Le TOP 10 des premiers bans</p>
                        <!-- On lui donne un nom, une requête SQL, il recréer une tableau pour avoir la bonne syntaxe et créer l'image demandé -->
                        <?php
                           $title = "MostFirstBan";//ON N'UTILISE PAS LES ESPACES
                           $req = "SELECT `picks_bans/0/hero_id`,COUNT(`picks_bans/0/hero_id`),heroes.name
                                   FROM matches
                                   INNER JOIN heroes ON matches.`picks_bans/0/hero_id` = heroes.id
                                   GROUP BY `picks_bans/0/hero_id`
                                   ORDER BY COUNT(`picks_bans/0/hero_id`) DESC LIMIT 10";
                           $labels = properArray(recupLabels($req));

                           makeAcamembert($title,$req,$labels);
                           ?>
                        <img src = "<?php echo "gallery/".$title.".png";?>"/>
                     </td>
                  </tr>
                  <tr>
                     <td class = "img">
                        <p class = "title">Top ban de la première phase</p>
                        <!-- On lui donne un nom, une requête SQL, il recréer une tableau pour avoir la bonne syntaxe et créer l'image demandé -->
                        <?php
                           $title = "topFirstBanPhase";//ON N'UTILISE PAS LES ESPACES
                           $req = "SELECT `picks_bans/0/hero_id`, COUNT(*),heroes.name AS Nb FROM
                           (SELECT `picks_bans/0/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/0/hero_id`
                           UNION ALL SELECT `picks_bans/1/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/1/hero_id`
                           UNION ALL SELECT `picks_bans/2/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/2/hero_id`
                           UNION ALL SELECT `picks_bans/3/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/3/hero_id`
                           UNION ALL SELECT `picks_bans/4/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/4/hero_id`
                           UNION ALL SELECT `picks_bans/5/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/5/hero_id` )
                           AS Nb
                           INNER JOIN heroes ON `picks_bans/0/hero_id` = heroes.id
                           GROUP BY `picks_bans/0/hero_id` ORDER BY COUNT(`picks_bans/0/hero_id`) DESC LIMIT 30 ";
                           $labels = properArray(recupLabels($req));
                           makeAcamembert($title,$req,$labels);
                           ?>
                        <img src = "<?php echo "gallery/".$title.".png";?>"/>
                     </td>
                     <td class = "img">
                        <p class = "title">Top Pick de la première phase</p>
                        <!-- On lui donne un nom, une requête SQL, il recréer une tableau pour avoir la bonne syntaxe et créer l'image demandé -->
                        <?php
                           $title = "topFirstPickPhase";//ON N'UTILISE PAS LES ESPACES
                           $req = "SELECT `picks_bans/6/hero_id`, COUNT(*),heroes.name AS Nb FROM
                           (SELECT `picks_bans/6/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/6/hero_id`
                           UNION ALL SELECT `picks_bans/6/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/6/hero_id`
                           UNION ALL SELECT `picks_bans/7/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/7/hero_id`
                           UNION ALL SELECT `picks_bans/8/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/8/hero_id`
                           UNION ALL SELECT `picks_bans/9/hero_id`, COUNT(*) AS Nb FROM matches GROUP BY `picks_bans/9/hero_id`)
                           AS Nb
                           INNER JOIN heroes ON `picks_bans/6/hero_id` = heroes.id
                           GROUP BY `picks_bans/6/hero_id` ORDER BY COUNT(`picks_bans/6/hero_id`) DESC ";
                           $labels = properArray(recupLabels($req));
                           makeAcamembert($title,$req,$labels);
                           ?>
                        <img src = "<?php echo "gallery/".$title.".png";?>"/>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>
