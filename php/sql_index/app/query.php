<?php
// SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
// SPDX-License-Identifier: GPL-3.0-or-later

require('../env.php');

$mysqli = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
    or die('Impossible de se connecter : ' . mysql_error());

$result = $mysqli->query('SELECT code_zas, zas, polluant FROM mesures_originales GROUP BY code_zas, zas, polluant ORDER BY zas, polluant;');

$i = 0;
while ($row = $result->fetch_row()) {
	printf('%s: %s[%s] %s'.PHP_EOL, $i, $row[1], $row[0], $row[2]);
	$i++;
}

mysqli_close($mysqli);
