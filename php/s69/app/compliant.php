<?php
require('../env.php');

$query = 'SELECT code_zas, zas, polluant, MAX(valeur), count(valeur) FROM mesures_originales WHERE validite = 1 GROUP BY code_zas, zas, polluant ORDER BY zas, polluant';
$max_row = 0;

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

if ($result = $mysqli->query('SELECT count(*) FROM (' . $query . ') as dtable;')) {
	$row = $result->fetch_row();
	$max_row = $row[0];
	printf('max: %s'.PHP_EOL, $max_row);
}

if ($result = $mysqli->query($query . ';')) {
	$i = 0;
	for ($i = 0; $i < $max_row; $i++) {
		$row = $result->fetch_row();
		printf('%s: %s[%s] %s -(max)-> %s over(%s)'.PHP_EOL, $i, $row[1], $row[0], $row[2], $row[3], $row[4]);
	}
}

mysqli_close($mysqli);
