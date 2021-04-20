<?php
// Initialisation de la session.

session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// détruit complètement la session, efface également le cookie de session.
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
}

// Finalement, on détruit la session.
session_destroy();
header("Location: index.php?deco=succes");
exit();
?>
