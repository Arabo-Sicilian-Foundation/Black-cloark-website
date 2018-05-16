<?php
session_start();
$titre="Forum - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");

if ($id==0) erreur(ERR_ISNT_CO);

if(isset($_POST['post']))
{
    $post=$db->prepare('INSERT INTO forum_post(post_createur,post_texte,post_time,topic_id) VALUES (:createur,:texte,CURRENT_TIMESTAMP,:topicID)');
    $post->bindParam(':createur',$_SESSION['pseudo']);
    $post->bindParam(':texte',$_POST['texte']);
    $post->bindParam(':topicID',$_GET['topic_id']);
    $post->execute();
}

if(isset($_GET['topic_id']))
{
	$posts = $db->prepare('SELECT * FROM forum_post WHERE topic_id=:topicID');
	$posts->bindParam(':topicID',$_GET['topic_id']);
	$posts->execute();

	$discussion = $posts->fetchAll();

	?>
	<table class="discussion">
		<tr>
			<th>Contenu</th>
			<th>Auteur</th>
			<th>Date</th>
		</tr>

	<?php
	for ($i=0; $i < $posts->rowCount(); $i++)
	{
		$membres = $db->prepare('SELECT membre_pseudo FROM forum_membres,forum_post WHERE membre_id=:idposteur');
		$membres->bindParam(':idposteur',$discussion[$i]['post_createur']);
		$membres->execute();
		$posteur = $membres->fetch();
		echo '
		<tr>
		<td>'.$discussion[$i]['post_texte'].'</a></td>
		<td>'.$posteur.'</td>
		<td>'.$result_discuss[$i]['post_time'].'</td>';
		if($_SESSION['pseudo']==$posteur)
		{
		  	echo '<td><a href="delete.php?idpost='.$discussion[$i]['post_id'].'&idtopic='.$_GET['topic_id'].'">supprimer</a></td>';
    	}
    	echo '</tr>';
  	}
}
?>
<form class="newpost" action="topic.php?topic_id=<?php$_GET['topic_id']?>" method="post">
	<textarea rows="10" cols="100" name="texte" placeholder="contenu" required></textarea>
	<br>
	<input type="submit" value="Poster">
</form>



</body>
</html>
