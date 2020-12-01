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
    <title>Interets vs. Reperes</title>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/jquery.ui.touch-punch.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/timer.css">
    <link rel="stylesheet" type="text/css" href="css/interets_reperes.css">


</head>

    <script type="text/javascript">
    $(window).on('load',function(){
        $('#largeModal').modal('show');
    });
    </script>



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
                            <li ><a href="#">Centres des Quartiers</a></li>
                            <li class="active"><a href="interes_reperes.php">Points d'Interêts VS de Repères</a></li>
                            <li><a href="interes.php">Points d'Interêts</a></li>
                            <li><a href="reperes.php">Points de Repères</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> Contact</a></li>
                </ul>
            </div>
    </nav>
        <div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Points d'interêts VS. Points de repères</h4>
          </div>
          <div class="modal-body">
            <h4 style="color:#28d">Points de repères</h4>
            <p>Les Points de Repères servent à s'orienter. Ils sont de nature très variée : un bâtiment original, une rue au tracé particulier, une place historique, un pont, un obstacle à la circulation...</p>
            <h4 style="color:#d45">Points d'interêts</h4>
            <p>Un lieu d’intérêt est un élément localisé ayant un attrait commercial, touristique, culturel, sportif, ludique ou autre. Il peut s’agir d’hôpitaux, de stations services, de monuments touristiques ou de n’importe quel type de magasins.</p>
            <img src="images/example.jpg" height="50%" width="50%">

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-lg btn-primary" <!-- data-dismiss="modal" -->Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div id="pano" class="col-md-12"></div>
        <div id="side-bar" class="col-xs-12 col-md-12">
            <div class="row" style="height: 100%">

                    <div class="col-xs-6 col-sm-3  col-md-4 ">
                        <button id="btn-interets" class="btn btn-lg btn-danger"> Point d'Interet </button>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-sm-push-6 col-md-4 col-md-push-4">
                        <button id="btn-reperes" class="btn btn-lg btn-primary">Point de Repere</button>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-sm-pull-3 col-md-4 col-md-pull-4">
                        <?php include_once("timer.php"); ?>
                        <div id='question'>Est-il bien situé ?<div>
                    </div>


            </div>
        </div>
      </div>
    </div>
    </div>
    <div id="map"></div>
    <audio id="watch-tick" src="sounds/watch-tick.wav"></audio>



    <script src="js/interets_reperes.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/timer.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiSZwMauUGqaWkRb-y0s17UlpdlaTafhk&libraries=geometry,places&callback=init" async defer>
    </script>

  </body>
</html>