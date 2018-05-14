<!DOCTYPE html>
<html>
	<head>

<?php
	echo (!empty($titre))?'<title>'.$titre.'</title>':'<title> Forum - Black Cloark </title>';
?>

		<meta charset="utf-8">
		<title>Black Cloark Production</title>
		<link href="accueil.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image" href="favicon.png">
	</head>

	<body>
  	  <div class="connexion">
  		  <a href="connexion.php">se connecter</a>
  		  <br>
  		  <a href="register.php">créer un compte</a>
  	  </div>

  	  <img src="logo_nom.png" alt="BlackCloarkProd" height="300">

  	  <table class="menu">
  		  <tr>
  			<th> <a href="accueil.html">ACCUEIL</a> </th>
  			<th> <a href="actualite.html">ACTUALITÉ</a> </th>
  			<th> <a href="prog.php">PROGRAMMATION</a> </th>
  			<th> <a href="media.html">MÉDIA</a> </th>
  			<th> <a href="index.php">FORUM</a> </th>
  			<th> <a href="contact.html">CONTACT</a> </th>
        </tr>
      </table>

<?php

//Attribution des variables de session
$lvl=(isset($_SESSION['level']))?(int) $_SESSION['level']:1;
$id=(isset($_SESSION['id']))?(int) $_SESSION['id']:0;
$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';

include("function.php");
include("constants.php");
?>
