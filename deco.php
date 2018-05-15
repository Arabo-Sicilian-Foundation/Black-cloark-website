<?php
session_start();
session_destroy();
$titre="Déconnexion - Black Cloark";
include("includes/debut.php");
include("includes/menu.php");

if ($id==0) erreur(ERR_IS_NOT_CO);

echo '<p>Déconnecté<br>';
echo '</div></body></html>';
?>
