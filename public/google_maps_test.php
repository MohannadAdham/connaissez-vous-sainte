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
    <link rel="stylesheet" href="css/style.css">




   <style type="text/css">
     html, body { height: 100%; margin: 0; padding: 0; }
     #map { height: 100%; }
   </style>
 </head>


 <body>

    <nav role="navigation" class="navbar navbar-inverse navbar-static-top">
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
                    <li><a href="about.html"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> À propos</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                         role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span>
                         Testes <span class="caret"></span></a>
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
        <div id="map" class="col-md-12"></div>
      </div>
    </div>


   <script>
     var map;
     // Initialize the map
     function initMap() {
       // TODO: use a constructor to create a new map JS object. You can use the coordinates
       // we used, 40.7413549, -73.99802439999996 or your own!
       map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 45.439695, lng: 4.387178},
        zoom: 13
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
 </body>
</html>
