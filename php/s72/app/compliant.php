<?php
// SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
// SPDX-License-Identifier: GPL-3.0-or-later

require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT code_zas, zas, polluant, MAX(valeur), count(valeur) FROM mesures_originales WHERE validite = 1 GROUP BY code_zas, zas, polluant ORDER BY zas, polluant;');

$i = 0;
while ($row = $result->fetch_row()) {
	printf('%s: %s[%s] %s -(max)-> %s over(%s)'.PHP_EOL, $i, $row[1], $row[0], $row[2], $row[3], $row[4]);
	$i++;
}

mysqli_close($mysqli);
