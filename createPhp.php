<?php
$id=$_GET['id'];
require_once("oneGame.php");
creatPhp($id);
$URL="match.php";
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
?>
