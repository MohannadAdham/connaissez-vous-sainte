<?php
    include_once("../connect/connect.php");
    $uniq_id = $_GET['id'];
    $quart_correct = $_GET['quart_correct'];
    $score = 18;
    foreach($quart_correct as $quartID) {
        // Update the'quartiers' table
        try {
            $stmt = $db->prepare("UPDATE quartiers SET familiarite = familiarite + :score
                WHERE quartID = :quartID");
            $stmt->bindParam(':score', $score);
            $stmt->bindParam(':quartID', $quartID);
            $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        // Update 'rel_utilisateur_quartier' table
        try {
            $stmt = $db->prepare('SELECT utilisateur_id FROM utilisateurs WHERE uniq_id = :uniq_id');
            $stmt->bindParam(':uniq_id', $uniq_id);
            $stmt->execute();
            $row = $stmt->fetch();
            $id = $row[0];
            echo "id = " . gettype($id) . "<br>";
            $stmt = $db->query("SELECT * FROM rel_utilisateur_quartier WHERE utilisateur_id = {$id} AND quart_id = {$quartID}");
            $row = $stmt->fetch();
            $exists = $row[1];
            echo "exists value is " . $exists. "<br>";

            if ($exists) {
                $stmt = $db->prepare("UPDATE rel_utilisateur_quartier SET familiarite = familiarite + :score
                    WHERE quart_id = :quartID AND utilisateur_id = :utilisateur_id");
                $stmt->bindParam(':score', $score);
                $stmt->bindParam(':quartID', $quartID);
                $stmt->bindParam(':utilisateur_id', $id);
                $stmt->execute();
                echo "if statement executed" . "<br>";

            } else {
                $stmt = $db->prepare("INSERT INTO rel_utilisateur_quartier VALUES (:utilisateur_id, :quartID, :score)");
                $stmt->bindParam(':utilisateur_id', $id);
                $stmt->bindParam(':quartID', $quartID);
                $stmt->bindParam(':score', $score);
                $stmt->execute();
                echo "else statement executed";
            }


        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $score -= 1;
    }
?>