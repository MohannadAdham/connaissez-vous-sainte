<?php
    include('connect/connect.php');

    $stmt = $db->query("SELECT * FROM quartiers");
    $results = $stmt->fetchAll(PDO::FETCH_BOTH);

?>