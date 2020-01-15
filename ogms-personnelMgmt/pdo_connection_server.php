<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ogmstest', 'ogmstest', 'ogms123');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// $sql="show tables;";
// $statement = $pdo->prepare($sql);
// $statement->execute();
// while($row = $statement->fetch(PDO::FETCH_ASSOC)){
//   echo($row['Tables_in_ogmstest']);
// }

?>
