<?php
require("usefull.php");
$user        = $_POST['username'];
$dossier     = 'upload/';
$fichier     = basename($_FILES['avatar']['name']);
$taille_maxi = 100000;
$taille      = filesize($_FILES['avatar']['tmp_name']);
$extensions  = array(
    '.png',
    '.gif',
    '.jpg',
    '.jpeg'
);
$extension   = strrchr($_FILES['avatar']['name'], '.');
//Début des vérifications de sécurité...
if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
    $erreur = 'type';
    //Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...
}
if ($taille > $taille_maxi) {
    $erreur = 'size';
    //'Le fichier est trop gros...'
}
if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
    {
    //On formate le nom du fichier ici...
    //Pour vérifié qu'il ne contient pas de caractère bizarre...
    $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
        //Change dans la BDD le chemin vers la nouvelle image + supprime l'ancienne image.
        wayToPepe($user, $fichier);

        //On rédirige en mode "forcé" car header ne marchait pas (n'affichait même pas de message d'erreur).
        $URL = "monprofil.php?error=none";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

    } else //Sinon (la fonction renvoie FALSE).
        {
        $URL = "monprofil.php?error=upload";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
} else {
    //Redirige vers monprofil.php avec l'erreur.
    $URL = "monprofil.php?error=$erreur";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>
