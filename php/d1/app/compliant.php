<?php
// SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
// SPDX-License-Identifier: GPL-3.0-or-later

require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT count(*) FROM mesures_originales WHERE code_site = "FR01011";');
$row = $result->fetch_row();
$max = $row[0];
printf("max -> %s\n", $max);

$i = 0;
while ($i < $max) {
	if ($i % 2 == 0) {
		$result = $mysqli->query('SELECT vERROR FROM mesures_originales WHERE code_site = "FR01011" ORDER BY polluant LIMIT 1 OFFSET 1;');
	} else {
		$result = $mysqli->query('SELECT valeur FROM mesures_originales WHERE code_site = "FR01011" ORDER BY polluant LIMIT 1 OFFSET 1;');
	}
	if (is_bool($result)) {
 		printf('%s: %s'.PHP_EOL, $i, $mysqli->error);
 	}
	if ($i % 2 != 0) {
		$row = $result->fetch_row();
		printf('%s: %s'.PHP_EOL, $i, $row[0]);
	}
	$i++;
}

mysqli_close($mysqli);
