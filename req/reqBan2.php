<?php
function reqBan2($id,$bdd){
try {
echo "
<tr>
   ";
   echo "
   <td>";
      $res = $bdd->prepare("SELECT name
      FROM heroes,(SELECT `picks_bans/10/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/10/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/11/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/11/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/12/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/12/hero_id`= heroes.id
      UNION
      SELECT name
      FROM heroes,(SELECT `picks_bans/13/hero_id`
      FROM `matches` WHERE match_id = $id
      )as temp
      WHERE temp.`picks_bans/13/hero_id`= heroes.id
      ");
      $res->execute();
      $res->setFetchMode(PDO::FETCH_COLUMN,0);
      echo "
<tr>
   ";
   echo "
   <td>";
      echo "<h2 style = \"font-family:calibri;color : YELLOW;text-align:center ;text-decoration:underline;\">Deuxième phase de ban</h2>";
      echo "
   </td>
   ";
   echo "
   <table border bgcolor = #FFFFFF align=center>
      ";
      echo "
      <td>Ban 6</td>
      <td>Ban 7</td>
      <td>Ban 8</td>
      <td>Ban 9</td>
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
