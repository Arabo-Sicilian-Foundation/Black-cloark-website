<?php
session_start();
$titre = "Forum - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");
?>

		<form class="search" action="recherche.php" method="post">
			<input type="text" name="recherche" placeholder="rechercher un évènement"><input type="submit" value="Rechercher">
		</form>

		<section>
			<h2>Résultat de la recherche :</h2>
	<?php
		if(isset($_POST['recherche']))
		{
			$recherche = $_POST['recherche'];
			$event = fopen('event.txt','r');
			$i = 0;
			if($event)
			{
				while(!feof($event))
				{
					$ligne = fgets($event);
					$pos = strripos($ligne,$recherche);

					if($pos !== false)
					{
						$liste = explode (";",$ligne);
						echo '<a class="event" href="'.$liste[2].'">'.$liste[1].'</a> <br>';
						$i++;
					}
				}
				if($i === 0)
				{
					echo 'Aucun évènement ne correspond à votre recherche.';
				}
				fclose($event);
			}
			else
			{
				echo 'fichier event introuvable.';
			}
		}
	?>
	<h2>Évènements à venir :</h2>

	<?php
		$evenement = fopen('event.txt','r');
		$ajd = date("d-m-Y");

		if($evenement)
		{
			while(!feof($evenement))
			{
				$ligne = fgets($evenement);
				$liste = explode(";",$ligne);
				$date = date("d-m-Y",strtotime($liste[0]));
				// Si l'évenement n'a pas encore eu lieu
				if(strtotime($date) >= strtotime($ajd))
				{
					echo '<a class="event" href="'.$liste[2].'">'.$liste[1].'</a><br>';
				}
			}
			fclose($evenement);
		}
		else
		{
			echo 'fichier event introuvable';
		}
	?>

	<h2>Évènements antérieurs :</h2>

	<?php
		$evenement = fopen('event.txt','r');
		$ajd = date("d-m-Y");

		if($evenement)
		{
			while(!feof($evenement))
			{
				$ligne = fgets($evenement);
				$liste = explode(";",$ligne);
				$date = date("d-m-Y",strtotime($liste[0]));
				// Si l'évenement a déjà eu lieu
				if(strtotime($date) < strtotime($ajd))
				{
					echo '<a class="event" href="'.$liste[2].'">'.$liste[1].'</a><br>';
				}
			}
			fclose($evenement);
		}
		else
		{
			echo 'fichier event introuvable';
		}
	?>
</section>

</body>
</html>
