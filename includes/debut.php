<!DOCTYPE html>
<html>
	<head>

<?php
	echo (!empty($titre))?'<title>'.$titre.'</title>':'<title> Forum - Black Cloark </title>';
	//Attribution des variables de session
	$lvl=(isset($_SESSION['level']))?(int) $_SESSION['level']:1;
	$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
	$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';
?>

		<meta charset="utf-8">
		<title>Black Cloark Production</title>
		<link href="accueil.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image" href="favicon.png">
		<script type="text/javascript" src="redirection.js"></script>
	</head>

	<body>
		<?php
		if($id == 0)
		{
			echo'<div class="connexion">
  		  		<a href="connexion.php">se connecter</a>
  		  		<br>
  		  		<a href="register.php">créer un compte</a>
  	  		</div>';
		}
		else
		{
			echo '<p class="connexion">Connecté en tant que :<br>'.$_SESSION['pseudo'].'<br><a class="connexion" href="deco.php">déconnexion</a></p>';
		}
		?>
  	  <img src="logo_nom.png" alt="BlackCloarkProd" height="300">

  	  <table class="menu">
  		  <tr>
  			<th> <a href="accueil.php">ACCUEIL</a> </th>
  			<th> <a href="prog.php">PROGRAMMATION</a> </th>
  			<th> <a href="index.php">FORUM</a> </th>
  			<th> <a href="contact.php">CONTACT</a> </th>
        </tr>
      </table>

<?php


include("function.php");
include("constants.php");
?>
