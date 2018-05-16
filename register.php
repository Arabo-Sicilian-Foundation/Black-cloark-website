<?php
session_start();
$titre="Register - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");

if ($id!=0) erreur(ERR_IS_CO);

if (empty($_POST['pseudo']))
{
?>
    <h1 class="register">Inscription</h1>

	<form method="post" action="register.php" class="register">
    		Pseudo :<input name="pseudo" type="text"><br>(le pseudo doit contenir entre 3 et 15 caractères)
			<br>
    		Mot de Passe :<input type="password" name="pswrd">
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
    $pseudo=$_POST['pseudo'];
    $email = $_POST['email'];
    $pass = md5($_POST['pswrd']);
    $confirm = md5($_POST['confirm']);

	// Verif Pseudo
	$query=$db->prepare('SELECT COUNT(*) AS nbr FROM forum_membres WHERE membre_pseudo =:pseudo');
    $query->bindParam(':pseudo',$pseudo);
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

   // On test si l'email existe deja
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

   if ($i==0)
   {
		echo'<h1>Inscription terminée</h1>';
        echo'<p>Bienvenue '.$_POST['pseudo'].' vous êtes maintenant inscrit</p>';

		try
		{
	        $query=$db->prepare('INSERT INTO forum_membres (membre_pseudo, membre_mdp, membre_email)
	        VALUES (:pseudo, :pass, :email)');

			$query->bindValue(':pseudo', $pseudo);
			$query->bindValue(':pass', $pass);
			$query->bindValue(':email', $email);
	        $query->execute();
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}

        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['id'] = $db->lastInsertId(); ;
        $_SESSION['level'] = 2;
        $query->CloseCursor();

		echo '
		    <script type="text/javascript">
		    document.location.href="accueil.php";
		    </script>
		    ';
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
