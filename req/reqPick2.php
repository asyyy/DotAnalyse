

<?php
function reqPick2($id,$bdd){
try {
echo "
<tr>
   ";
   echo "
   <td>";
      $res = $bdd->prepare("SELECT name
      FROM heroes,(SELECT `picks_bans/14/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/14/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/15/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/15/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/16/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/16/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/17/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/17/hero_id`= heroes.id
      ");
      $res->execute();
      $res->setFetchMode(PDO::FETCH_COLUMN,0);
      echo "
<tr>
   ";
   echo "
   <td>";
      echo "<h2 style = \"font-family:calibri;color : RED;text-align:center ;text-decoration:underline;\">Deuxième phase de pick</h2>";
      echo "
   </td>
   ";
   echo "
   <table border bgcolor = #FFFFFF align=center>
      ";
      echo "
      <td>Pick 5</td>
      <td>Pick 6</td>
      <td>Pick 7</td>
      <td>Pick 8</td>
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
