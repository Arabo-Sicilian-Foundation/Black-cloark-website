<?php
session_start();
$titre = "Forum - Black Cloark";
include("includes/identifiant.php");
include("includes/debut.php");
?>

<h1>Forum</h1>
<?php
$totaldesmessages = 0;
$categorie = NULL;
?>

<?php

$membres=$db->prepare('SELECT * FROM forum_membres');
$query->execute();
$posts=$db->prepare('SELECT * FROM forum_post');
$query->execute();
$topics=$db->prepare('SELECT * FROM forum_topic');
$query->execute();
?>

<table class="topic">
	<tr>
		<th>Sujet</th>
		<th>Autueur</th>
		<th>Messages</th>
		<th>Dernier message</th>
	</tr>
<?php

while($stmt = $query->fetch())
{
	echo '
	<tr>
		<td><a href="topic.php?topic_id='.$stmt['topic_id'].'">'.$stmt['topic_titre'].'</a></td>
		<td>'.$stmt['topic_createur'].'</td>
		<td>'.$stmt['topic_post'].'</td>
		<td>'.$stmt['topic_last_post'].'</td>
	</tr>';
}

echo '</table>';
