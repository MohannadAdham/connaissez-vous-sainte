<?php
    include_once("../connect/connect.php");
    function id_from_unique_id($db, $uniq_id) {
        $stmt = $db->prepare('SELECT utilisateur_id FROM utilisateurs WHERE uniq_id = :uniq_id');
        $stmt->bindParam(':uniq_id', $uniq_id);
        $stmt->execute();
        $row = $stmt->fetch();
        $id = $row[0];
        return $id;
    }

    $uniq_id = $_GET['uniq_id'];
    $id = id_from_unique_id($db, $uniq_id);
    $quart_ids = $_GET['quart_ids'];
    $quart_choix = $_GET['quart_choix'];
    $user_centers_lat = $_GET['user_center_lat'];
    $user_centers_lat = $_GET['user_center_lat'];
    $user_scores = $_GET['user_scores'];
    $global_score = $_GET['global_score'];

    for ($i = 0; $i < 3; $i++) {

    }

?>