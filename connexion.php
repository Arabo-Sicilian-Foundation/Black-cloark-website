<?php
session_start();
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/menu.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>connexion-Black Cloark Production</title>
		<link rel="icon" type="image/png" href="favicon.png">
		<link href="prog.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<img src="logo_nom.png" alt="BlackCloarkProd" height="300">

<?php
if (!isset($_POST['pseudo'])) //On est dans la page de formulaire
{
    echo '<div class="connexion">
			<form action="connexion.php" method="post">
				<input type="text" name="login" placeholder="login">
				<br>
				<input type="password" name="pswrd" placeholder="mot de passe">
				<input type="submit" value="connexion">
			</form>
			<a href="register.php">créer un compte</a>
		 </div>';
}

else
{
	if(isset($_POST['login']) && isset($_POST['pswrd']))
	{
		$login = $_POST['login'];
		$pswrd =  $_POST['pswrd'];

		$query = $db->prepare('SELECT membre_mdp, membre_id, membre_rang, membre_pseudo FROM forum_membres WHERE membre_pseudo = :login');

		$query->bindParam(':login','$login');
		$query->execute();
		$data = $query->fetch();

		// Si bon mot de passe
		if($data['membre_mdp'] == md5($pswrd))
		{
			$_SESSION['login'] = $data['membre_pseudo'];
			$_SESSION['id'] = $data['membre_id'];
			$_SESSION['rang'] = $data['membre_rang'];

			echo '<p>Bienvenue '.$data['membre_pseudo'].'</p>';
			echo '<a href="accueil.html">Acceuil</a>';
		}

		// mdp pas bon
		else
		{
			echo '<p>Login ou mot de passe incorrect, veuillez réessayer<p>';
			echo '<div class="connexion">
	  		  		<form action="connexion.php" method="post">
	  			  		<input type="text" name="login" placeholder="login">
						<br>
						<input type="password" name="pswrd" placeholder="mot de passe">
	  			  		<input type="submit" value="connexion">
	  		  		</form>
	  		  		<a href="register.php">créer un compte</a>
	  	  		</div>';
		}
		$query->CloseCursor();
		$pdo = null;
	}
}
?>
</body>
</html>
