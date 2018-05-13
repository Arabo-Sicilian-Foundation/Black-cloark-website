<?php
try
{
	$db = new PDO('mysql:host=localhost;dbname=web', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>
