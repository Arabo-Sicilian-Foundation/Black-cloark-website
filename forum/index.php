<!DOCTYPE html>
<html>
<head>
<title>Index forum</title>
<meta charset="utf-8"/>
</head>
<body>

<br /><br />

<?php
$servername = "mira2.univ-st-etienne.fr";
$username = "ml04444r";
$password = "LJWNRKDJ";
try {
    $pdo = new PDO("mysql:host=$servername;dbname=ml04444r",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
	$sql = "INSERT INTO forum_topic (topic_titre,topic_createur) VALUES ('Autre','John')";

    $pdo->exec($sql);
echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

$pdo = null;
?>
</body>
</html>
