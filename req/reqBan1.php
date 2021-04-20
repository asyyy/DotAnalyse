<?php
function reqBan1($id,$bdd){
try {
echo "
<tr>
   ";
   echo "
   <td>";
      $res = $bdd->prepare("SELECT name
      FROM heroes,(SELECT `picks_bans/0/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/0/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/1/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/1/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/2/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/2/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/3/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/3/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/4/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/4/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/5/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/5/hero_id`= heroes.id
      ");
      $res->execute();
      $res->setFetchMode(PDO::FETCH_COLUMN,0);
      echo "
<tr>
   ";
   echo "
   <td>";
      echo "<h2 style = \"font-family:calibri;color : YELLOW;text-align:center ;text-decoration:underline;\">Première phase de ban</h2>";
      echo "
   </td>
   ";
   echo "
   <table border bgcolor = #FFFFFF align=center>
      ";
      echo "
      <td>Ban 0</td>
      <td>Ban 1</td>
      <td>Ban 2</td>
      <td>Ban 3</td>
      <td>Ban 4</td>
      <td>Ban 5</td>
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
