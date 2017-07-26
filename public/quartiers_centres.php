<?php
    include_once("../private/connect/connect.php");
    include_once("../private/fetchall.php");
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/bootstrap-social.css" rel="stylesheet">
<!--     <link rel="stylesheet" href="css/style.css">
 -->

    <style type="text/css">
        html, body, { height: 100%; margin: 0; padding: 0; overflow: hidden}
        #map { height: 100%;
               z-index: 1 }
        body {
            background: #1c262f;
        }
        .panel-group {
            margin-top: 100px;
        }
        #side-bar {
            box-shadow: -5px 5px 20px black;
            background-color: #2c363f;
            z-index: 10;
            height: 100%;
        }
        .navbar {
            background-color: #1c262f;
             box-shadow: 0 5px 10px 0;
              border-color:transparent;
        }

        .panel-body {
            font-weight: bold;
            font-size: 16px;
        }


        @media screen and (max-width: 991px) {
            #map {height: 70%;}
            #side-bar {
                height: 30%;
                padding-top: 1em;
                overflow: hidden;
            }
            #panel-1, #panel-2 {
                margin-top: 1em;
                height: 80%;
            }
            #panel-1 { margin-right: -5px; margin-left: 5px; }
            #panel-2 { margin-left: -5px; }
        }



        @media screen and (max-width: 520px) {
            #map {height: 50%;}

            #side-bar {
                height: 50%;
                padding-top: 1em;
                overflow: hidden;
            }

            #panel-1, #panel-2 {
                margin-top: 1em;
                height: 80%;
            }

            #panel-1 { margin-right: -5px; margin-left: 5px; }
            #panel-2 { margin-left: -5px; }
            }

            .panel-body {
                font-size: 12px;
            }


            .navbar {
                position: fixed;
                top: -60px;
            }
            .navbar-toggle {
                position: relative;
                top: 60px;
                z-index: 10;
                background-color: #1c262f ;
            }

            .navbar-brand {
                font-size: 14px;
            }

            #side-bar {
                box-shadow: 0px -5px 20px #222;
            }
        }

        @media screen and (min-width: 992px) {

            #panel-1 {
                height: 35%;
                margin-top: 20%;
            }
            #panel-2 {
                height: 50%;
                margin-top: 30px;

            }

        }








   </style>
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
        <div id="map" class="col-md-9"></div>
        <div id="side-bar" class="col-xs-12 col-md-3">
            <div class="row" style="height: 100%">
                <div id="panel-1" class="col-xs-6 col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">Indiquer le point central du quartier suivant en cliquant sur la carte <br><br>
                        <span style=" font-weight: 400"><span style="color: #395;" class="glyphicon glyphicon-info-sign glyphicon-success"></span>&nbsp; vous pouvez zoomer et vous déplacer dans la carte</span><br><br>
                        <div class="btn btn-block btn-lg btn-primary" disabled>Chateaucreux</div>
                        <br>
</div>
                    </div>
                </div>
                 <div id="panel-2" class="col-xs-6 col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">Comment connaissez-vous ce quartier ? <br>
                        <form class="form">
                            <div class="radio">
                              <label><input type="radio" name="optradio">J'y habite ou j'y ai habité</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="optradio">J'y travaille ou j'y ai travaillé</label>
                            </div>
                            <div class="radio">
                              <label><input type="radio" name="optradio" >Autre</label>
                            </div>
                            <br>
                             <button type="submit" class="btn btn-success btn-block btn-lg">Enregistrer et Continuer</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    </div>

   <script>
     // Create a map variable
     var map;
     // Initialize the map
     function initMap() {
       // Use a constructor to create a new map JS object
       map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 45.439695, lng: 4.387178},
        zoom: 14,
        styles: [{
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [  { visibility: "off" }]
                    }],
        streetViewControl:false,
        panControl:false,
        mapTypeId: google.maps.MapTypeId.HYBRID
       });

       var beaulieu = {lat: 45.428, lng: 4.416 };
       var marker = new google.maps.Marker({
        position: beaulieu,
        map: map,
        title: 'Beaulieu'
       });

       var infowindow = new google.maps.InfoWindow({
        content: "<div class='container-fluid'><div class='panel panel-primary'><div class='panel .panel-heading'>Bealieu</div><div class='panel panel-body'>C'est le centre du quartier de <b style='color: red'>Beaulieu</b><br><br><button class='btn btn-success'>Continue</button></div><iframe src='https://coursera.org'></iframe></div></div>"

       });

       marker.addListener('click', function() {
        infowindow.open(map, marker);
       });

     }
   </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYy2PP3wd5eysIDe9q-qL3cQ4Sx80nz_M&callback=initMap" async defer>
    </script>

   <script src="js/bootstrap.min.js"></script>
</body>