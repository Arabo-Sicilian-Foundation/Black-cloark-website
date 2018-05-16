<?php
session_start();
$titre = "Forum - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");

if ($id==0) erreur(ERR_ISNT_CO);

if(isset($_GET['idpost']) && isset($_GET['idtopic']))
{
	$query = $db->prepare('DELETE FROM forum_post WHERE post_id=:idpost AND topic_id=:idtopic');
	$query->bindParam(':idpost',$_GET['idpost']);
	$query->bindParam(':idtopic',$_GET['idtopic']);
	$query->execute();
	echo '
	<script type="text/javascript">
	document.location.href="topic.php?topic_id='.$_GET['idtopic'].'";
	</script>';
}

else if(isset($_GET['idtopic']) && isset($_GET['delete']))
{
	$query = $db->prepare('DELETE FROM forum_topic WHERE topic_id=:idtopic');
	$query->bindParam(':idtopic',$_GET['idtopic']);
	$query->execute();
	echo '
	<script type="text/javascript">
	document.location.href="index.php";
	</script>';
}


?>
</body>
</html>
