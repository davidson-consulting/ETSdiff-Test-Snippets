<?php
require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT code_zas, zas, polluant FROM mesures_originales WHERE validite = 1 ORDER BY valeur DESC LIMIT 10000;');

$i = 0;
while ($row = $result->fetch_row()) {
	printf('%s: [%s]%s %s'.PHP_EOL, $i, $row[0], $row[1], $row[2]);
	$i++;
}

mysqli_close($mysqli);