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
        #panel-1-inside, #panel-2-inside, #panel-3-inside {
            margin-right: -15px;
            margin-left: -15px;
            border: 0;
            box-shadow: 5px 5px 15px #333;
            opacity: 0.9;
            color: #2e3d49;
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

        #panel-2, #panel-3 {
            display: none;
            position: relative;
        }

        #btn-quart, .btn[type=submit] {
            font-size: 16px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #score {
            width: 100%;
            margin-left: 5%;
            font-size: 32px;
            color: #007E33;
        }

        @media screen and (min-width: 992px) {

            #panel-1, #panel-3 {
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
            #panel-1, #panel-2, #panel-3{
                margin-top: 1em;
                height: 80%;
            }
            #panel-1-inside, #panel-2-inside, #panel-3-inside {
                margin-right: 0;
                margin-left: 0;
            }

            .panel-body {
                font-size: 18px;
            }

            #panel-2 , #panel-3 {display: none;}

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

            #panel-1, #panel-2, #panel-3 {
                margin-top: 0;
            }



            #panel-2, #panel-3{display: none;}

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
                            <span id='score'>92%</span>
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
     // a variable to determine whether the map is clickable or not
     var clickable = true;
     var user_id = <?php echo $id ?>;
     console.log("user id : " + user_id);
     var user_markers = [];
     var centres_markers = [];
     var distances = [];

     // pass the variables from php to JavaScript
     var quart_ids = [<?php echo $quart_ids[0] . ", " . $quart_ids[1] . ", " . $quart_ids[2]?>];
     var quart_noms = [<?php echo '"' . $quart_noms[0] . '", "' . $quart_noms[1] . '", "' . $quart_noms[2] . '"'?>];
     var centres_lat = [<?php echo $centres_lat[0] . ", " . $centres_lat[1] . ", " . $centres_lat[2]?>];
     var centres_lng = [<?php echo $centres_lng[0] . ", " . $centres_lng[1] . ", " . $centres_lng[2]?>];


     $("#btn-quart").text(quart_noms[counter]);
     $("#btn-quart").attr('title', quart_noms[counter]);

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
        map.setOptions({ draggableCursor: 'crosshair' });
         // Different zoom for mobile devices
        if ($('.navbar').css('top') == '-60px') {
            map.setZoom(13); // for mobile
        }

        function addLatLng(event) {
          // Add a new marker at the new plotted point
          marker.setPosition(event.latLng);
          marker.setMap(map);
        }

        // Add a listener for the click event
        google.maps.event.addListener(map, 'click', function(event) {
            if (clickable) {
                var marker = new google.maps.Marker({animation: google.maps.Animation.DROP});
                marker.setPosition(event.latLng);
                marker.setMap(map);
                user_markers.push(marker);
                lat = marker.getPosition().lat();
                lng = marker.getPosition().lng();
                console.log(user_markers);
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
                map.setOptions({ draggableCursor: 'default' });
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
            if (counter < 3 && $('input[name="quart_choice"]:checked').val() != null) {
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

                // send the answer to the server
                answer = $('input[name="quart_choice"]:checked').val();
                console.log(answer);
                $.ajax({
                    url: '../private/ajax/quartiers_centres.ajax.php',
                    type: 'GET',
                    data: {
                        'id' : user_id,
                        'quart_id' : quart_ids[counter],
                        'quart_choix' : answer,
                        'user_center_lat' : lat,
                        'user_center_lng' : lng
                    }
                });

                // reset the radio buttons' answer
                $('input[name="quart_choice"]').prop('checked', false);

                if (counter < 2 && $('input[name="quart_choice"]:checked').val() != '') { // Doesn't apply to final step
                    // show panel-1 again
                    setTimeout(function() {
                        $('#panel-1').slideDown(500);
                        console.log(counter);
                        counter += 1;
                        $("#btn-quart").text(quart_noms[counter]);
                        $("#btn-quart").attr('title', quart_noms[counter]);
                    }, 600);
                }


                // allow the click event on the map again
                clickable = true;
                map.setOptions({ draggableCursor: 'crosshair' });
            }

            // the final step
            if (counter == 2 && $('input[name="quart_choice"]:checked').val() != '') { // start if statement
                var infowindow = new google.maps.InfoWindow();
                var bounds = new google.maps.LatLngBounds();
                var average_distance = 1637.390751; // The avereage distance between all the
                // centroids and the nearest centroid (used near geoprocessing tool in ArcGIS)
                var scores = [];
                for (var i = 0; i < quart_noms.length; i++) { // start for loop
                    // create a marker for each center
                    marker = new google.maps.Marker({
                    position: new google.maps.LatLng(centres_lat[i], centres_lng[i]),
                    map: map,
                    icon: "http://localhost/evs4/public/icons/flag-blue_44.png",
                    animation: google.maps.Animation.DROP,
                    animation: google.maps.Animation.BOUNCE
                  });

                    // set the infowindow for each marker
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(quart_noms[i]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));

                    // Define a symbol using SVG path notation, with an opacity of 1.
                    // this symbol is for the lines between each two points
                    var lineSymbol = {
                      path: 'M 0,-1 0,1',
                      strokeColor: '#fff',
                      strokeOpacity: 1,
                      scale: 3
                    };

                    // Create the polyline, passing the symbol in the 'icons' property.
                    // Give the line an opacity of 0.
                    // Repeat the symbol at intervals of 20 pixels to create the dashed effect.
                    var line = new google.maps.Polyline({
                      path: [{lat: centres_lat[i], lng: centres_lng[i]}, {lat: user_markers[i].getPosition().lat(), lng: user_markers[i].getPosition().lng()}],
                      strokeOpacity: 0,
                      icons: [{
                        icon: lineSymbol,
                        offset: '0',
                        repeat: '15px'
                      }],
                      map: map
                    });

                    // extend the bounds to include all the markers
                    // extend the bounds to include the user added marker
                    var LatLng_user = new google.maps.LatLng(user_markers[i].getPosition().lat(),
                     user_markers[i].getPosition().lng());
                    bounds.extend(LatLng_user);

                    // extend the bounds to include the marker of the actual center
                    var LatLng_center = new google.maps.LatLng(centres_lat[i],
                     centres_lng[i]);
                    bounds.extend(LatLng_center);

                    // calculate distances
                    distance = google.maps.geometry.spherical.computeDistanceBetween(
                        LatLng_center, LatLng_user);
                    distances.push(distance);
                    console.log(distances);
                    // calculate the score for this point
                    score = ((average_distance - (distance - 50)) / average_distance) * 100;
                    if (score >= 100) {score = 100;}
                    // add the score to the array of scores
                    scores.push(score);

                } // end of for loop

                // calculate final score
                var sum = scores.reduce(function(a, b) { return a + b; });
                var avg_score = Math.floor(sum / scores.length) + 1;
                // add the average score to the third panel
                $('#score').text(avg_score + '%');

                // show the score panel
                setTimeout(function() {
                    $('#panel-3').slideDown(2000);
                });

                // prevent click after last step
                clickable = false;
                map.setOptions({ draggableCursor: 'normal' });


            } // end of if statement
        });

   </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYy2PP3wd5eysIDe9q-qL3cQ4Sx80nz_M&libraries=geometry&callback=initMap" async defer>
    </script>
    <audio id="drop-audio" src="sounds/Button.mp3"></audio>
   <script src="js/bootstrap.min.js"></script>
</body>