<?php
// SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
// SPDX-License-Identifier: GPL-3.0-or-later

require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
	or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT DISTINCT code_zas, zas FROM mesures_originales ORDER BY zas');
$zas_rows = $result->fetch_all(MYSQLI_ASSOC);

$result = $mysqli->query('SELECT DISTINCT polluant FROM mesures_originales ORDER BY polluant');
$polluant_rows = $result->fetch_all(MYSQLI_ASSOC);

$stmt = $mysqli->prepare('SELECT MAX(valeur), count(valeur) FROM mesures_originales WHERE validite = 1 AND code_zas = ? AND zas = ? AND polluant = ?');

$i = 0;
foreach($zas_rows as $zas_row) {
	foreach($polluant_rows as $polluant_row) {
		$stmt->bind_param('sss', $zas_row['code_zas'], $zas_row['zas'], $polluant_row['polluant']);
		$stmt->execute();
		$stmt->bind_result($max, $count);
		$stmt->fetch();

		if ($count > 0) {
			printf('%s: %s[%s] %s -(max)-> %s over(%s)'.PHP_EOL, $i, $zas_row['zas'], $zas_row['code_zas'], $polluant_row['polluant'], $max, $count);
			$i++;
		}
	}
}

$stmt->close();

mysqli_close($mysqli);
