<?php
session_start();
session_destroy();
$titre="Déconnexion";
include("includes/debut.php");
include("includes/menu.php");

if ($id==0) erreur(ERR_IS_NOT_CO);

echo '<p>Déconnecté<br>
<a href="./index.php">Revenir à l\'accueil</a></p>';
echo '</div></body></html>';
?>
