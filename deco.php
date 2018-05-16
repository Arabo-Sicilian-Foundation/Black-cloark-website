<?php
session_start();
session_destroy();
$titre="Déconnexion - Black Cloark";
include("includes/debut.php");

if ($id==0) erreur(ERR_IS_NOT_CO);

echo '<p>Déconnecté<br>';
echo '</div></body></html>';
echo '
    <script type="text/javascript">
    document.location.href="accueil.php";
    </script>
    ';
?>
</body>
</html>
