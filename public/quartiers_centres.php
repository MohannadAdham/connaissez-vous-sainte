<?php
    require_once("../private/connect/connect.php");

    function get_unique_id() {
        if (isset($_COOKIE['id'])) {
            $uniqID = $_COOKIE['id'];
            return $uniqID;
        } else {
            alert("Please take the first test");
        }
    }

    function id_from_unique_id($db, $uniq_id) {
        $stmt = $db->prepare('SELECT utilisateur_id FROM utilisateurs WHERE uniq_id = :uniq_id');
        $stmt->bindParam(':uniq_id', $uniq_id);
        $stmt->execute();
        $row = $stmt->fetch();
        $id = $row[0];
        return $id;
    }

    $uniq_id = get_unique_id();
    $id = id_from_unique_id($db, $uniq_id);


    function get_quartiers($db, $id) {
        $stmt = $db->query("SELECT quartID, quartNom FROM  quartiers INNER JOIN  rel_utilisateur_quartier ON (quart_id = quartID) WHERE utilisateur_id = {$id} ORDER BY rel_utilisateur_quartier.familiarite DESC");
        $quart_noms = [];
        $quart_ids = [];
        for ($i=0; $i < 6; $i++) {
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $quart_ids[$i] = $row[0];
            $quart_noms[$i] = $row[1];
        }
        return [$quart_ids, $quart_noms];
    }

    $quartiers = get_quartiers($db, $id);
    $quart_ids_6 = $quartiers[0];
    $quart_noms_6 = $quartiers[1];
    $quart_ids = [];
    $quart_noms = [];
    // Get three randomly chosen quartiers from the list of six quartiers
    $randoms = [];
    for ($j=0; $j < 3; $j++) {
        do {
            $random = rand(0, 5);
        } while (in_array($random, $randoms));
        $randoms[] = $random;
        $quart_ids[] = $quart_ids_6[$random];
        $quart_noms[] = $quart_noms_6[$random];
    };

    function get_centres($db, $quart_ids) {
        $centres_lat = [];
        $centres_lng = [];
        for ($j=0; $j<3; $j++) {
            $quart_id = $quart_ids[$j];
            $stmt = $db->query("SELECT lng, lat FROM centroides_quartiers
                WHERE quart_id = $quart_id");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $centres_lat[$j] = $row['lat'];
            $centres_lng[$j] = $row['lng'];
        }
        return [$centres_lat, $centres_lng];
    }

    $centres = get_centres($db, $quart_ids);
    $centres_lat = $centres[0];
    $centres_lng = $centres[1];

?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centres des Quartiers</title>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/jquery.ui.touch-punch.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/quartiers_centres.css">

</head>



<body >


    <nav  role="navigation" class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Connaissez vous Sain<i Style="color: #B34; font-size: 28px" class="fa fa-map-signs" aria-hidden="true"></i>é ?</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li ><a href="index.php"><span class="glyphicon glyphicon-home"
                         aria-hidden="true"></span> Accueil</a></li>
                    <li><a href="about.html"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> À propos <span class="label label-danger" style="font-size: 8px">beta</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                         role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span>
                         Tests <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="quartiers.php">Noms des Quartiers</a></li>
                            <li class="active"><a href="#">Centres des Quartiers</a></li>
                            <li><a href="interes_reperes.php">Points d'Interêts VS de Repères</a></li>
                            <li><a href="interes.php">Points d'Interêts</a></li>
                            <li><a href="reperes.php">Points de Repères</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> Contact</a></li>
                </ul>
            </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div id="map" class="col-md-8 col-md-push-4"></div>
        <div id="side-bar" class="col-xs-12 col-md-4 col-md-pull-8">
            <div class="row" style="height: 100%">
                <div id="panel-0" class="col-md-12" style="height: 100px"><div>
                <div id="panel-1" class="col-xs-12 col-md-12">
                    <div id="panel-1-inside" class="panel panel-primary">
                        <div class="panel-body">Indiquer le point central du quartier suivant en cliquant sur la carte <br><br>
                        <div id="btn-quart" class="btn btn-block btn-lg btn-primary" data-toggle="tooltip" title="quartier name" disabled></div>
                        <span style=" font-weight: 400"><span style="color: #395; margin-top:1.5em" class="glyphicon glyphicon-info-sign glyphicon-success"></span>&nbsp; vous pouvez zoomer et vous déplacer dans la carte</span><br><br>
                        </div>
                    </div>
                </div>
                 <div id="panel-2" class="col-xs-12 col-md-12">
                    <div id="panel-2-inside" class="panel panel-primary">
                        <div class="panel-body">Comment connaissez-vous ce quartier ? <br>
                        <form class="form">
                            <div class="radio">
                              <label><input type="radio" name="quart_choice" value="habite">J'y habite ou j'y ai habité</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="quart_choice" value="travail">J'y travaille ou j'y ai travaillé</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="quart_choice" value="etude">J'y etudie ou j'y ai etudié</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="quart_choice" value="autre" >Autre</label>
                            </div>
                             <button type="submit" class="btn-submit btn btn-success btn-block btn-lg">Enregistrer et Continuer</button>
                        </form>
                        </div>
                    </div>
                </div>
                <div id="panel-3" class="col-xs-12 col-md-12">
                    <div id="panel-3-inside" class="panel panel-primary">
                        <div class="panel-body">Votre score est : &nbsp;&nbsp;
                            <span id='score'></span>
                            <br>
                            <div id="distances">
                                Votre estimation a été à :
                                <ul>
                                    <li><span id="distance-1"></span> du centre de <?php echo $quart_noms[0]?></li>
                                    <li><span id="distance-2"></span> du centre de <?php echo $quart_noms[1]?></li>
                                    <li><span id="distance-3"></span> du centre de <?php echo $quart_noms[2]?></li>
                                </ul>
                                <div class="btn-group btn-group-justified">
                                        <a class="btn btn-primary" value="Refresh Page" onClick="window.location.reload()">Rejouer &nbsp;&nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></a>
                                        <a href="interes_reperes.php" class="btn btn-success">Suivant &nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    </div>

    <script type="text/javascript">
     var user_id = <?php echo "'" . $uniq_id . "'" ?>;
     var quart_ids = [<?php echo $quart_ids[0] . ", " . $quart_ids[1] . ", " . $quart_ids[2]?>];
     var quart_noms = [<?php echo '"' . $quart_noms[0] . '", "' . $quart_noms[1] . '", "' . $quart_noms[2] . '"'?>];
     var centres_lat = [<?php echo $centres_lat[0] . ", " . $centres_lat[1] . ", " . $centres_lat[2]?>];
     var centres_lng = [<?php echo $centres_lng[0] . ", " . $centres_lng[1] . ", " . $centres_lng[2]?>];
    </script>

    <script type="text/javascript" src="js/quartiers_centres.js"></script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYy2PP3wd5eysIDe9q-qL3cQ4Sx80nz_M&libraries=geometry&callback=initMap" async defer>
    </script>
    <audio id="drop-audio" src="sounds/Button.mp3"></audio>
   <script src="js/bootstrap.min.js"></script>
</body>