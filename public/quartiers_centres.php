<?php
    require_once("../private/connect/connect.php");
    include_once("../private/fetchall.php");
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
        for ($i=0; $i < 3; $i++) {
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $quart_ids[$i] = $row[0];
            $quart_noms[$i] = $row[1];
        }
        return [$quart_ids, $quart_noms];
    }

    $quartiers = get_quartiers($db, $id);
    $quart_ids = $quartiers[0];
    $quart_noms = $quartiers[1];
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

        #side-bar {
            box-shadow: 15px 15px 35px black;
            background-color: #2c363f;
            z-index: 10;
            height: 100%;
        }
        #panel-1-inside, #panel-2-inside {
            margin-right: -15px;
            margin-left: -15px;
            border: 0;
            box-shadow: 5px 5px 15px #333;
            opacity: 0.9;
        }
        .navbar {
            background-color: #1c262f;
            box-shadow: 0 5px 15px black;
            border-color:transparent;
        }
        .navbar-brand {
            position: relative;
            top: -5px;
            left: -10px;
        }

        .panel-body {
            font-weight: bold;
            font-size: 16px;
        }

        #panel-2 {
            display: none;
            position: relative;
        }

        #btn-quart, .btn[type=submit] {
            font-size: 16px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media screen and (min-width: 992px) {

            #panel-1 {
                margin-top: 25%;
            }
            #panel-2 {
                margin-top: 5%;
            }
            #side-bar {
                overflow: hidden;
            }
        }


        @media screen and (max-width: 991px) and (min-width: 521px) {
            html, body, { height: 100%; margin: 0; padding: 0; overflow: hidden;}
            #map {height: 70%;}
            #side-bar {
                height: 30%;
                padding-top: 1em;
                overflow: hidden;
                box-shadow: 0 -5px 10px 0;
            }
            #panel-1, #panel-2 {
                margin-top: 1em;
                height: 80%;
            }
            #panel-1-inside, #panel-2-inside {
                margin-right: 0;
                margin-left: 0;
            }

            .panel-body {
                font-size: 18px;
            }

            #panel-2 {display: none;}

            #btn-quart, .btn[type=submit] {
                position: relative;
/*                top: 0.7rem;
*/                font-size: 22px;
            }

        }



        @media screen and (max-width: 520px) {
            #map {height: 60%;}

            #side-bar {
                height: 40%;
                padding-top: 1em;
                overflow: hidden;
            }

            #panel-1, #panel-2 {
                margin-top: 0;
            }



            #panel-2 {display: none;}

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
            .panel-body {
                font-size: 14px;
            }
            #btn-quart, .btn[type=submit] {
                font-size: 14px;
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
        <div id="map" class="col-md-8 col-md-push-4"></div>
        <div id="side-bar" class="col-xs-12 col-md-4 col-md-pull-8">
            <div class="row" style="height: 100%">
                <div id="panel-0" class="col-md-12" style="height: 100px"><div>
                <div id="panel-1" class="col-xs-12 col-md-12">
                    <div id="panel-1-inside" class="panel panel-primary">
                        <div class="panel-body">Indiquer le point central du quartier suivant en cliquant sur la carte <br><br>
                        <span style=" font-weight: 400"><span style="color: #395;" class="glyphicon glyphicon-info-sign glyphicon-success"></span>&nbsp; vous pouvez zoomer et vous déplacer dans la carte</span><br><br>
                        <div id="btn-quart" class="btn btn-block btn-lg btn-primary" data-toggle="tooltip" title="quartier name" disabled></div>
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
                              <label><input type="radio" name="optradio" >Autre</label>
                            </div>
                             <button type="submit" class="btn-submit btn btn-success btn-block btn-lg">Enregistrer et Continuer</button>
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
     var counter = 0;
     var map_center = {lat: 45.439695, lng: 4.387178};
     var clickable = true;
     var markersArray = [];
     var quart_ids = [<?php echo $quart_ids[0] . ", " . $quart_ids[1] . ", " . $quart_ids[2]?>];
     var quart_noms = [<?php echo '"' . $quart_noms[0] . '", "' . $quart_noms[1] . '", "' . $quart_noms[2] . '"'?>];

     $("#btn-quart").text(quart_noms[counter]);

     // Create a map variable
     var map;
     // Initialize the map
     function initMap() {
       // Use a constructor to create a new map JS object
        map = new google.maps.Map(document.getElementById('map'), {
        center: map_center,
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

         // Different zoom for mobile devices
        if ($('.navbar').css('top') == '-60px') {
            map.setZoom(13); // for mobile
        }

        function addLatLng(event) {
          // Add a new marker at the new plotted point on the polyline.
          marker.setPosition(event.latLng);
          marker.setMap(map);
        }

        // Add a listener for the click event
        google.maps.event.addListener(map, 'click', function(event) {
            if (clickable) {
                var marker = new google.maps.Marker({animation: google.maps.Animation.DROP});
                marker.setPosition(event.latLng);
                marker.setMap(map);
                markersArray.push(marker);
                console.log(markersArray);
                // Hide the first panel for tablet and mobile devices
                if ($('#btn-quart').css('font-size') == '22px' ||
                    $('.navbar').css('top') == '-60px') {
                    $('#panel-1').slideUp(400);
                }
                // Show the second panel for all devices
                setTimeout(function() {
                    $('#panel-2').slideDown(600);
                    $("#drop-audio").get(0).play();
                }, 600);
                clickable = false;
        }
        });

        var infowindow = new google.maps.InfoWindow({
        content: "<div class='container-fluid'><div class='panel panel-primary'><div class='panel .panel-heading'>Bealieu</div><div class='panel panel-body'>C'est le centre du quartier de <b style='color: red'>Beaulieu</b><br><br><button class='btn btn-success'>Continue</button></div><iframe src='https://coursera.org'></iframe></div></div>"

       });

       //  marker.addListener('click', function() {
       //  infowindow.open(map, marker);
       // });
     }

        // prohobit the submit button from refresh the page
        $("form").submit(function(e) {
            e.preventDefault();
            });


        $(".btn-submit").click(function() {
            if (counter < 2) {
                // hide the two panels one after the other
                $("#panel-2").slideUp(500);
                setTimeout(function() {
                    $('#panel-1').slideUp(500);
                }, 550);
                // reset the map center and zoom
                map.setCenter(map_center);
                // Different zoom for mobile devices
                if ($('.navbar').css('top') == '-60px') {
                    map.setZoom(13); // for mobile
                } else {
                map.setZoom(14); // for desktop, laptop and tablet
                }
                // reset the radio buttons' answer
                $('input[name="quart_choice"]').prop('checked', false);
                // show panel-1 again
                setTimeout(function() {
                    $('#panel-1').slideDown(500);
                    $("#btn-quart").text(quart_noms[counter + 1]);
                    counter += 1;
                }, 600);
                // allow the click event on the map again
                clickable = true;
            }
        });

   </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYy2PP3wd5eysIDe9q-qL3cQ4Sx80nz_M&callback=initMap" async defer>
    </script>
    <audio id="drop-audio" src="sounds/Button.mp3"></audio>
   <script src="js/bootstrap.min.js"></script>
</body>