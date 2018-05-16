<?php
session_start();
$titre="Connexion - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");

if ($id!=0) erreur(ERR_IS_CO);

if(isset($_POST['pswrd']) && isset($_POST['pseudo']))
{
	$stmt = $db->prepare("SELECT * FROM forum_membres WHERE membre_pseudo =:pseudo");
	$stmt->bindParam(':pseudo',$_POST['pseudo']);
	$stmt->execute();
	$res = $stmt->fetch();

	if($res['membre_mdp'] == md5($_POST['pswrd']))
	{
		$_SESSION['pseudo'] = $res['membre_pseudo'];
		$_SESSION['level'] = $res['membre_rang'];
		$_SESSION['id'] = $res['membre_id'];
		$stmt->CloseCursor();

		$pseudo = $_SESSION['pseudo'];
	  	echo '<p>Bienvenue '.$pseudo.'.</p>';
		echo '
		    <script type="text/javascript">
		    document.location.href="accueil.php";
		    </script>
		    ';
  	}
	else
	{
    	if ($_SESSION['pseudo'] != $_POST['pseudo'])
		{
			?>
			<p>login ou mot de passe incorrect<p>
			<form class="connexion2" action="connexion.php" method="post">
				<input type="text" name="pseudo" placeholder="login" required>
				<br>
				<input type="password" name="pswrd" placeholder="mot de passe" required>
				<br>
				<input type="submit" value="connexion">
			</form>
			<p><a class="connexion2" href="register.php">créer un compte</a></p>
			<?php
    	}
  	}
}

else
{
	?>
	<h2>Connexion :</h2>
	<form class="connexion2" action="connexion.php" method="post">
		<input type="text" name="pseudo" placeholder="login" required>
		<br>
		<input type="password" name="pswrd" placeholder="mot de passe" required>
		<br>
		<input type="submit" value="connexion">
	</form>
	<p><a class="connexion2" href="register.php">créer un compte</a></p>
	<?php
}
?>
