<?php
    include_once("../connect/connect.php");
    $id = $_GET['id'];
    $quart_correct = $_GET['quart_correct'];
    $score = 18;
    foreach($quart_correct as $quartID) {
        try {
        $stmt = $db->prepare("UPDATE quartiers SET familiarite = familiarite + :score
            WHERE quartID = :quartID");

        $stmt->bindParam(':score', intval($score));
        $stmt->bindParam(':quartID', intval($quartID));
        $stmt->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $i += 1;
        $score -= 1;
    }
?>