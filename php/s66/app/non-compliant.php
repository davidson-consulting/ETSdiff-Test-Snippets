<?php
// SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
// SPDX-License-Identifier: GPL-3.0-or-later

require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT count(valeur) FROM mesures_originales;');

$row = $result->fetch_row();

$i = 0;
while ($i < $row[0]) {
	$var = "$i: My variable with replacement"; 
	if ($i % 1000 == 0) {
		printf('%s'.PHP_EOL, $var);
	}
	$i++;
}

mysqli_close($mysqli);
