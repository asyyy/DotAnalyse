<?php

/*
  Cette fonction permet de créer nouvelle page php qui servira pour l'affichage
  des données d'une seule partie.
  Elle recréé entièrement une page HTML/PHP et  récupére les informations de
  la partie demandé par des rêquetes dans d'autres PHP (Fichier "req").
  L'idée est de n'avoir qu'une seule page php qui va se réécrire pour afficher différentes parties.
*/

   function creatPhp($id){

     $filename = 'match.php';
     $somecontent = "<?php
      session_start();
      ?>
<!DOCTYPE HTML>
<TYPE HTML>
<html>
   <head>
      <meta http-equiv=\"content-type\" content = \"text/html; charset= ANSI\"  />
      <link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
      <title>Partie</title>
      <link rel=\"shortcut icon\" type=\"image/png\" href=\"favicon.png\"/>
      <link rel='stylesheet' type='text/css' href='banniere-defilante.css' />
   </head>
   <body bgcolor = #212f3d>
      <table class = \"body\" width = 100% id=\"haut\">
         <tr>
            <td>
               <table>
                  <td width = 20%><a align=center href=index.php class=\"logo\" ><img src = \"dotanalyse.png\" style=\"margin-right:200px\"></a></td>
                  <td width = 70%>
                     <div class='banniere'>
                        <img src=\"gallery/banniere1test.jpg\" title='Image 1' alt='Image 1' />
                        <img src=\"gallery/banniere2.jpg\" title='Image 3' alt='Image 3' />
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
                     if(isset(\$_SESSION['username']) AND isset(\$_SESSION['password'])){
                         echo '<td><a href= monprofil.php class = \"button\"  style=\"margin-left:100px\">Profil</a></td><td><a href= deconnexion.php class = \"button\"  style=\"margin-right:25px\" >Déconnexion</a></td>';
                       }else {
                         session_destroy();
                         echo '<td><a href= login.php?statut=try class = \"button\" style=\"margin-left:100px\">Connexion</a></td>';
                         echo '<td><a href= inscription.php class = \"button\" style=\"margin-right:25px\">Inscription</a></td>';
                       }
                       ?>
               </table>
            </td>
         </tr>
         <tr>
            <td bgcolor = #34495e>
               <table align = center>
                  <td class =\"button\"><a href= index.php class = \"type2\">Accueil</a></td>
                  <td class =\"button\"><a href= heroes.php class = \"type2\">Héros</a></td>
                  <td class =\"button\"><a href= analyse.php class = \"type2\">Analyse <= contient des schémas en camembert!</a></td>
                  <?php
                     if(isset(\$_SESSION['username']) AND isset(\$_SESSION['password'])){
                         echo '<td class =\"Hello\">Bonjour '.\$_SESSION['username'].'</td>';;
                       }
                       ?>
               </table>
            </td>
         </tr>
         <tr>
            <td>
               <h1>Pick et Ban de la game $id</h1>
            </td>
         </tr>
         <?php
            try{
            \$bdd = new PDO('mysql:host=localhost;dbname=id9485828_dotanalyse','id9485828_user','password',array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            // TABLE ban 1

            require_once(\"req/reqBan1.php\");
            reqBan1($id,\$bdd);

            ////////////////////////////////////////////////////////////////

            // TABLE pick 1

            require_once(\"req/reqPick1.php\");
            reqPick1($id,\$bdd);

            ////////////////////////////////////////////////////////////////

            // Table ban 2

            require_once(\"req/reqBan2.php\");
            reqBan2($id,\$bdd);

            ////////////////////////////////////////////////////////////////

            // TABLE pick 2

            require_once(\"req/reqPick2.php\");
            reqPick2($id,\$bdd);

            ////////////////////////////////////////////////////////////////

            // Table ban 3

            require_once(\"req/reqBan3.php\");
            reqBan3($id,\$bdd);

            ////////////////////////////////////////////////////////////////

            // TABLE pick 3

            require_once(\"req/reqPick3.php\");
            reqPick3($id,\$bdd);

            ////////////////////////////////////////////////////////////////
            }

            catch (PDOException \$e){
              echo \"<p>ERREUR : \".\$e->getMessage();
            }
            ?>
      </table>
   </body>
</html>
";

// Savoir si on peut ouvrir le fichier
if (!$handle = fopen($filename, 'w')) {
echo "Impossible d'ouvrir le fichier ($filename)";
exit;
}

// Savoir si on peut écrire dans le fichier
if (fwrite($handle, $somecontent) === FALSE) {
echo "Impossible d'écrire dans le fichier ($filename)";
exit;
}

//Ferme le fichier
fclose($handle);
}
?>
