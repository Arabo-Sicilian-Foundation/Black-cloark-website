<?php
session_start();
$titre="Forum - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");

if ($id==0) erreur(ERR_ISNT_CO);

if(isset($_POST['texte']))
{

	$stmt = $db->prepare('SELECT membre_id FROM forum_membres WHERE membre_pseudo=:id');
	$stmt->bindParam('id',$_SESSION['pseudo']);
	$stmt->execute();
	$auteur=$stmt->fetch();

	try
	{
		$post=$db->prepare('INSERT INTO forum_post (post_createur,post_texte,topic_id)
		VALUES (:createur,:texte,:topicID)');

	    $post->bindParam(':createur',$auteur['membre_id']);
	    $post->bindParam(':texte',$_POST['texte']);
	    $post->bindParam(':topicID',$_GET['topic_id']);
	    $post->execute();
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
	$stmt->CloseCursor();
}

if(isset($_GET['topic_id']))
{
	if($_SESSION['pseudo'] == $posteur['membre_pseudo'] || $_SESSION['level'] == 3)
	{
		echo '<a class="delete" href="delete.php?idtopic='.$_GET['topic_id'].'&delete=1">supprimer le topic</a>';
	}

	$posts = $db->prepare('SELECT * FROM forum_post WHERE topic_id=:topicID');
	$posts->bindParam(':topicID',$_GET['topic_id']);
	$posts->execute();

	$discussion = $posts->fetchAll();

	for ($i=0; $i < $posts->rowCount(); $i++)
	{
		$membres = $db->prepare('SELECT membre_pseudo FROM forum_membres,forum_post WHERE membre_id=:idposteur');
		$membres->bindParam(':idposteur',$discussion[$i]['post_createur']);
		$membres->execute();
		$posteur = $membres->fetch();
		echo '<section class="post">';
		if($_SESSION['pseudo'] == $posteur['membre_pseudo'] || $_SESSION['level'] == 3)
		{
		  	echo '<a href="delete.php?idpost='.$discussion[$i]['post_id'].'&idtopic='.$_GET['topic_id'].'">supprimer</a>';
    	}
		echo '<h3>'.$posteur['membre_pseudo'].'</h3>
		<p>'.$discussion[$i]['post_texte'].'</p>';
    	echo '</section>';
		$membres->CloseCursor();
  	}
	echo'
	<form class="newpost" action="topic.php?topic_id='.$_GET['topic_id'].'" method="post">
		<textarea rows="5" cols="100" name="texte" placeholder="Ecrire un réponse" required></textarea>
		<br>
		<input type="submit" value="Poster">
		</form>';
}

	$posts->CloseCursor();
?>
</body>
</html>
