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
    $user_centers_lat = $_GET['user_centers_lat'];
    $user_centers_lng = $_GET['user_centers_lng'];
    $user_scores = $_GET['user_scores'];
    $global_score = $_GET['global_score'];
    echo "global score = " . $global_score . "<br>";
    echo "user_id = " . $id . "<br>";
    print_r($quart_ids);

    function update_score($db, $id, $global_score) {
        try {
        $stmt = $db->prepare("UPDATE utilisateurs SET score_test_2 = :score
            WHERE utilisateur_id = :id and score_test_2 < :score");
        $stmt->bindParam(":score", $global_score);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
    // update the global score of the second game
    update_score($db, $id, $global_score);


    for ($i = 0; $i < 3; $i++) {
        try {
        $stmt = $db->prepare("UPDATE rel_utilisateur_quartier SET
            user_center_lat = :user_center_lat, user_center_lng = :user_center_lng
            WHERE utilisateur_id = :id and quart_id = :quart_id and user_center_lat is Null");
        // $stmt->bindParam(":choice", $quart_choix[$i]);
        $stmt->bindParam(":user_center_lat", $user_centers_lat[$i]);
        $stmt->bindParam(":user_center_lng", $user_centers_lng[$i]);
        $stmt->bindParam(":id", $id);
        echo "id = " . $id . "<br>";
        $stmt->bindParam(":quart_id", $quart_ids[$i]);
        echo "quart_id = " . $quart_ids[$i] . "<br>";
        $stmt->execute();

        } catch (Exception $e) {
            $e->getMessage();
        }

        switch ($quart_choix[$i]) {
            case 'etude':
                $stmt = $db->query("UPDATE rel_utilisateur_quartier SET etude = True
                    WHERE utilisateur_id = $id and quart_id = $quart_ids[$i]");
                break;
            case 'habite':
                $stmt = $db->query("UPDATE rel_utilisateur_quartier SET habite = True
                    WHERE utilisateur_id = $id and quart_id = $quart_ids[$i]");
                break;
            case 'travail':
                $stmt = $db->query("UPDATE rel_utilisateur_quartier SET travail = True
                    WHERE utilisateur_id = $id and quart_id = $quart_ids[$i]");
                break;
        }

    }

?>