<?php
session_start();
$titre="Enregistrement";
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/menu.php");
?>

<?php
if ($id!=0) erreur(ERR_IS_CO);

if (empty($_POST['pseudo']))
{
?>
    <h1>Inscription</h1>

	<form method="post" action="register.php">
    		Pseudo :<input name="pseudo" type="text"> (le pseudo doit contenir entre 3 et 15 caractères)
			<br>
    		Mot de Passe :<input type="password" name="password">
			<br>
    		Confirmer le mot de passe :<input type="password" name="confirm">
			<br>
			adresse Mail :<input type="email" name="email">
    	<p><input type="submit" value="S'inscrire" /></p>
	</form>
<?php
}

// Traitement
else
{
	$pseudo_erreur1 = NULL;
    $pseudo_erreur2 = NULL;
    $mdp_erreur = NULL;
    $email_erreur1 = NULL;
    $email_erreur2 = NULL;

	// On recup les variables
	$i = 0;
    $temps = time();
    $pseudo=$_POST['pseudo'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);
    $confirm = md5($_POST['confirm']);

	// Verif Pseudo
	$query=$db->prepare('SELECT COUNT(*) AS nbr FROM forum_membres WHERE membre_pseudo =:pseudo');
    $query->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);
    $query->execute();
    $pseudo_free=($query->fetchColumn()==0)?1:0;
    $query->CloseCursor();
    if(!$pseudo_free)
    {
        $pseudo_erreur1 = "Ce pseudo est déjà utilisé";
		$i++;
    }

    if (strlen($pseudo) < 3 || strlen($pseudo) > 15)
    {
        $pseudo_erreur2 = "Votre pseudo doit contenir entre 3 et 15 caractères";
		$i++;
    }

	//Vérification du mdp
    if ($pass != $confirm || empty($confirm) || empty($pass))
    {
        $mdp_erreur = "Mots de passes différents ou manquants";
		$i++;
    }

	//Vérification de l'adresse email

   // On test si l'adresse existe deja
   $query=$db->prepare('SELECT COUNT(*) AS nbr FROM forum_membres WHERE membre_email =:mail');
   $query->bindValue(':mail',$email, PDO::PARAM_STR);
   $query->execute();
   $mail_free=($query->fetchColumn()==0)?1:0;
   $query->CloseCursor();

   if(!$mail_free)
   {
	   $email_erreur1 = "Email déjà utilisé";
	   $i++;
   }

   // Forme
   if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $email) || empty($email))
   {
	   $email_erreur2 = "email invalide";
	   $i++;
   }

   if ($i==0)
   {
		echo'<h1>Inscription terminée</h1>';
        echo'<p>Bienvenue '.stripslashes(htmlspecialchars($_POST['pseudo'])).' vous êtes maintenant inscrit</p>
		<p>Cliquez <a href="acceuil.html">ici</a> pour revenir à la page d accueil</p>';

        $query=$db->prepare('INSERT INTO forum_membres (membre_pseudo, membre_mdp, membre_email, membre_inscrit,
        membre_derniere_visite)
        VALUES (:pseudo, :pass, :email, :temps, :temps)');
		$query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$query->bindValue(':pass', $pass, PDO::PARAM_INT);
		$query->bindValue(':email', $email, PDO::PARAM_STR);
		$query->bindValue(':temps', $temps, PDO::PARAM_INT);
        $query->execute();

		//Et on définit les variables de sessions
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['id'] = $db->lastInsertId(); ;
        $_SESSION['level'] = 2;
        $query->CloseCursor();
    }
    else
    {
        echo'<h1>Inscription interrompue</h1>';
        echo'<p>Une ou plusieurs erreurs se sont produites pendant l incription</p>';
        echo'<p>'.$i.' erreur(s)</p>';
        echo'<p>'.$pseudo_erreur1.'</p>';
        echo'<p>'.$pseudo_erreur2.'</p>';
        echo'<p>'.$mdp_erreur.'</p>';
        echo'<p>'.$email_erreur1.'</p>';
        echo'<p>'.$email_erreur2.'</p>';

?>

		<form method="post" action="register.php">
	    	<fieldset><legend>Identifiants</legend>
	    		Pseudo :<input name="pseudo" type="text"> (le pseudo doit contenir entre 3 et 15 caractères)
				<br>
	    		Mot de Passe :<input type="password" name="password">
				<br>
	    		Confirmer le mot de passe :<input type="password" name="confirm">
				<br>
				adresse Mail :<input type="email" name="email">
	    	</fieldset>
	    	<p><input type="submit" value="S'inscrire" /></p>
		</form>
<?php
    }
}
?>
</body>
</html>
