<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=ogms', 'dhruv', 'pass123');
//$pdo = new PDO('mysql:host=localhost;port=3306;dbname=ogms', 'ogmstest', 'ogms123');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
