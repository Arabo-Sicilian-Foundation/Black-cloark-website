<?php
session_start();
$titre = "Forum - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");

if ($id==0) erreur(ERR_ISNT_CO);
?>

<h1>Forum</h1>
<?php
if(isset($_POST['sujet']))
{
	$stmt = $db->prepare('SELECT membre_id FROM forum_membres WHERE membre_pseudo=:id');
	$stmt->bindParam('id',$_SESSION['pseudo']);
	$stmt->execute();
	$auteur=$stmt->fetch();

	try
	{
		$post=$db->prepare('INSERT INTO forum_topic (topic_titre,topic_createur)
		VALUES (:sujet,:auteur)');

	    $post->bindParam(':sujet',$_POST['sujet']);
		$post->bindParam(':auteur',$auteur['membre_id']);
	    $post->execute();
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}

	$stmt->CloseCursor();
}
?>

<?php

$membres=$db->prepare('SELECT * FROM forum_membres');
$membres->execute();
$posts=$db->prepare('SELECT * FROM forum_post');
$posts->execute();
$topics=$db->prepare('SELECT * FROM forum_topic');
$topics->execute();
?>

<table class="topic">
	<tr>
		<th>Sujet</th>
		<th>Auteur</th>
		<th>Messages</th>
	</tr>
<?php

while($data = $topics->fetch())
{
	$nbPosts=$db->prepare('SELECT * FROM forum_post WHERE topic_id=:id');
	$nbPosts->bindParam(':id',$data['topic_id']);
	$nbPosts->execute();
	$nombreMessages = $nbPosts->rowCount();

	$stmt=$db->prepare('SELECT membre_pseudo FROM forum_membres WHERE membre_id=:idmembre');
	$stmt->bindParam(':idmembre',$data['topic_createur']);
	$stmt->execute();
	$auteur = $stmt->fetch();

	echo '
	<tr>
		<td><a href="topic.php?topic_id='.$data['topic_id'].'">'.$data['topic_titre'].'</a></td>
		<td>'.$auteur['membre_pseudo'].'</td>
		<td>'.$nombreMessages.'</td>
	</tr>';
}

echo '</table>';

echo'
<form class="newTopic" action="index.php" method="post">
	<input type="text" name="sujet" placeholder="Sujet" required>
	<br>
	<input type="submit" value="Créer">
	</form>';

?>
</body>
</html>
