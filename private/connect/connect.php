<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=evs_v4;charset=utf8', 'root', '');
} catch (Exception $e) {
    echo $e->getMessage();
}
?>