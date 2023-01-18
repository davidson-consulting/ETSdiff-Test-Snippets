<?php
require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT count(valeur) FROM mesures_originales;');

$row = $result->fetch_row();

$i = 0;
while ($i < $row[0]) {
	$var = "$i: My variable with replacement"; 
	printf('%s'.PHP_EOL, $var);
	$i++;
}

mysqli_close($mysqli);
