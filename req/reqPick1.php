

<?php
function reqPick1($id,$bdd){
try {
echo "
<tr>
   ";
   echo "
   <td>";
      $res = $bdd->prepare("SELECT name
      FROM heroes,(SELECT `picks_bans/6/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/6/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/7/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/7/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/8/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/8/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/9/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/9/hero_id`= heroes.id
      ");
      $res->execute();
      $res->setFetchMode(PDO::FETCH_COLUMN,0);
      echo "
<tr>
   ";
   echo "
   <td>";
      echo "<h2 style = \"font-family:calibri;color : RED;text-align:center ;text-decoration:underline;\">Première phase de pick</h2>";
      echo "
   </td>
   ";
   echo "
   <table border bgcolor = #FFFFFF align=center>
      ";
      echo "
      <td>Pick 0</td>
      <td>Pick 1</td>
      <td>Pick 2</td>
      <td>Pick 3</td>
      ";
      echo "
      <tr>
         ";
         foreach($res as $value){
         echo "
         <td>".$value ."</td>
         ";
         }
         echo "
      </tr>
      ";
      echo "
   </table>
   ";
   echo "</td>";
   echo "
</tr>
";
}
catch (PDOException $e){
echo "
<p>ERREUR : ". $e->getMessage();
   }
   }
