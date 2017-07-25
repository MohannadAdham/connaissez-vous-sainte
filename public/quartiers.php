<?php
    include_once("../private/connect/connect.php");
    include_once("../private/fetchall.php");
    if (isset($_COOKIE['id'])) {
        $uniqID = $_COOKIE['id'];
    } else {
        do {
        $uniqID = uniqid();
        $exists = $db->query("SELECT * FROM utilisateurs WHERE uniq_id = {$uniqID}");
        } while ($exists == 1);

        setcookie('id', $uniqID, time() + (86400 * 30));

        try {
            $stmt = $db->prepare("INSERT INTO utilisateurs (uniq_id) VALUES (:uniqID)");
            $stmt->bindParam(':uniqID', $uniqID);
            $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Puzzle - Quartiers</title>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <script src="js/jquery.ui.touch-punch.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"> -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

<!--     <script type="text/javascript">
    $(window).on('load',function(){
        $('#largeModal').modal('show');
    });
    </script> -->




    <style>

        html, body {margin: 0; height: 100%; overflow: hidden
        }
        body {
            background-color: #222;
        }
        .btn-block {
                margin-bottom: 14px;
                text-align: left;
        }
        svg {
            background: url(http://localhost/evs4/public/images/Basemap_small.png);
            background-size:auto 100%;
            margin: 0;
            position: relative;
            z-index: 0;
            border: solid 1px #222;
            vertical-align: middle;
        }
        .side-bar {
        background: #ccc;
        padding-top: 3%;
        padding-bottom: 3%;
        margin: 0;
        position: relative;
        z-index: 1;
        border: #222 solid 1px;

        }
        .btn {
            overflow: hidden;
            text-overflow:ellipsis;
        }
        .drag-me:hover, .btn:hover {
            cursor: move;
        }

        .drag-me {
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black, 3px 3px 6px #222;
        }

        .fa-map-marker {
            font-size: 18px;
            color: #C36;
        }

        path {
            stroke: #444 ;
        }

        .row-footer {
           background-color: #222;
           position: relative;
           z-index: 2;
        }

        .modal {

        }

    @media screen and (max-width: 520px) {
        nav {
            position: fixed;
            top: -60px;
        }

        .btn-block {
            padding-bottom: 3px;
            padding-top: 3px;
        }

        .navbar-toggle {
            position: relative;
            top: 60px;
            z-index: 10;
        }

        .navbar-brand {
            font-size: 14px;
        }

        svg {
            width: 125%;
            margin-left: -17%;
            margin-top: -18%;
        }

    }



    @media (min-width: 200px) {
      .row.equal {
        display: flex;
        flex-wrap: wrap;
      }
    }

    @media (min-width: 1000px) {
        .row.equal {
        overflow: hidden;
    }

    .row.equal [class*="col-"]{
        margin-bottom: -99999px;
        padding-bottom: -99999px;
    }
    }



    @media screen and (max-width: 1200px) {
        .btn-block {
            margin-bottom: 5px;
        }
    }



    </style>



<body >
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
                         Tests <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="active"><a href="quartiers.php">Noms des Quartiers</a></li>
                            <li><a href="quartiers_centres.php">Centres des Quartiers</a></li>
                            <li><a href="interes_reperes.php">Points d'Interêts VS de Repères</a></li>
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
            <h4 class="modal-title" id="myModalLabel">Large Modal</h4>
          </div>
          <div class="modal-body">
            <h3>Modal Body</h3>
            <?php
                foreach($results as $row) {
                    $quart_id = $row['quartID'];
                    $quartier = $row['quartNom'];
                    if ($quart_id >= 14 && $quart_id % 2 != 0) {
                         echo '<button style="background: #999; border-color: #222" class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me" nom="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                    }

                    if ($quart_id >= 14 && $quart_id % 2 == 0) {
                         echo '<button style="background: #222; border-color: #999" class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me" nom="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                    }
                }
            ?>

                <form action="index.php">
                    <input type="submit" class='btn btn-success' value="Go to Homepage" />
                </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-lg btn-primary" <!-- data-dismiss="modal" -->Close</button>
          </div>
        </div>
      </div>
    </div>



    <div class="container-fluid" style="margin-top: -20px; margin-bottom: -10px;" >
        <div class="row equal">
            <div class="col-xs-12 col-sm-12 col-md-6 col-md-push-3" style="margin: 0; padding: 0">
                <?php
                    include_once("svg/quartiers.svg")
                ?>
            </div>

            <div id="side-bar-left" class="col-xs-6 col-sm-6 col-md-3 col-md-pull-6 side-bar btn-group-vertical" height="100%" >

            <?php
                // Add the names of the neighborhoods randomly to the buttons to avoid
                // the bias that could be generated by the arrangement of the buttons
                $id_quart_ajoute = []; // an array contains the IDs of the added neighborhoods
                $counter = 0;
                while ($counter < 9) {
                    $random_index = rand(0, 17);
                    $row = $results[$random_index];
                    $quart_id = $row['quartID'];
                    $quartier = $row['quartNom'];
                    if ($counter % 2 != 0  && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #999; border-color: #222" class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me" nom="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                         $id_quart_ajoute[] = $quart_id;
                         $counter += 1;
                    }

                    if ($counter % 2 == 0 && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #222; border-color: #222" class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me" nom="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                        $id_quart_ajoute[] = $quart_id;
                        $counter += 1;
                    }
                }
            ?>
        </div>


            <div id="side-bar-right" class="col-xs-6 col-sm-6 col-md-3 side-bar btn-group-vertical" height="600px"  >

            <?php
                $counter = 0;
                while ($counter < 9) {
                    $random_index = rand(0, 17);
                    $row = $results[$random_index];
                    $quart_id = $row['quartID'];
                    $quartier = $row['quartNom'];
                    if ($counter % 2 != 0  && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #999; border-color: #222" class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                         $id_quart_ajoute[] = $quart_id;
                         $counter += 1;
                    }

                    if ($counter % 2 == 0 && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #222; border-color: #222" class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                        $id_quart_ajoute[] = $quart_id;
                        $counter += 1;
                    }
                }
            ?>



        </div>
    </div>
</div>


    <footer  class="row-footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1 col-sm-2 col-sm-offset-1">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-xs-6 col-sm-5">
                    <h5>Our Address</h5>
                    <address>
                      Université Jean Monnet, 42100 Saint Etienne<br>
                      <i class="fa fa-phone"></i>: +852 1234 5678<br>
                      <i class="fa fa-fax"></i>: +852 8765 4321<br>
                      <i class="fa fa-envelope"></i>:
                        <a href="mailto:confusion@food.net">confusion@food.net</a>
                   </address>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="nav navbar-nav" style="padding: 40px 10px;">
                        <a class="btn btn-social-icon btn-google-plus" href="http://google.com/+"><i class="fa fa-google-plus"></i></a>
                        <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/profile.php?id="><i class="fa fa-facebook"></i></a>
                        <a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/in/"><i class="fa fa-linkedin"></i></a>
                        <a class="btn btn-social-icon btn-twitter" href="http://twitter.com/"><i class="fa fa-twitter"></i></a>
                        <a class="btn btn-social-icon btn-youtube" href="http://youtube.com/"><i class="fa fa-youtube"></i></a>
                        <a class="btn btn-social-icon" href="mailto:"><i class="fa fa-envelope-o"></i></a>
                    </div>
                </div>
                <div class="col-xs-12">
                    <p style="padding:10px;"></p>
                    <p align=center>© Copyright 2017 Université Jean Monnet</p>
                </div>
            </div>
        </div>
    </footer>
    <audio id="drop-audio" src="sounds/Button.mp3"></audio>
    <script type="text/javascript" src="js/quartiers.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>