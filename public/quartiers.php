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
    <meta name="viewport" content="width=device-width, initial-scale=1" id="scale1">
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
            background-color: #1c262f;
        }
        .btn-block {
                margin-bottom: 14px;
                text-align: left;
        }
        svg {
            background: url("images/Basemap_small.png");
            background-size:auto 100%;
            margin: 0;
            position: relative;
            z-index: 0;
            border: solid 1px #222;
            vertical-align: middle;
        }
        .navbar-brand {
            position: relative;
            top: -5px;
            left: -10px;
        }
        .side-bar {
            background: #ccc;
            padding-top: 3%;
            padding-bottom: 3%;
            margin: 0;
            position: relative;
            z-index: 1;
            border: 0;
        }
        #side-bar-left {
            box-shadow: 10px 10px 25px 0;
        }
        #side-bar-right {
            box-shadow: -10px 10px 25px 0;
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

    @media screen and (max-width: 767px) {
        nav {
            position: fixed;
            top: -60px;
        }

        svg {
            height: 53vh;
        }

        .btn-block {
            padding-bottom: 3px;
            padding-top: 3px;
            height: 15%;
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
            width: 140%;
            margin-left: -28%;
            margin-top: -19%;
            background-position: 52% 36%;
        }

        .mobile_group_2, .mobile_group_3 {
            display: none;
        }
        #side-bar-right {
            display: none;
        }
        #side-bar-left {
            height: 39vh;
        }
    }


      .row.equal {
        display: flex;
        flex-wrap: wrap;
    }


    @media (min-width: 768px) {
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
    <nav style="background-color: #1c262f; box-shadow: 0 5px 10px 0; border-color:transparent;" role="navigation" class="navbar navbar-inverse navbar-static-top">
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
                            <li><a href="interets.php">Points d'Interêts</a></li>
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
                         echo '<button  style="background: #999; border-color: #999; class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me" data-toggle="tooltip" title="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                    }

                    if ($quart_id >= 14 && $quart_id % 2 == 0) {
                         echo '<button  style="background: #1c262f; border-color: #1c262f; class="btn btn-success btn-block"><span id="quart_' . $quart_id . '"  class="drag-me" data-toggle="tooltip" title="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
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

            <div id="side-bar-left" class="col-xs-12 col-sm-6 col-md-3 col-md-pull-6 side-bar btn-group-vertical"  >

            <?php
                // Add the names of the neighborhoods randomly to the buttons to avoid
                // the bias that could be generated by the arrangement of the buttons
                $id_quart_ajoute = []; // an array contains the IDs of the added neighborhoods
                $counter = 0;
                while ($counter < 9) {
                    // Add mobile classes
                    if ($counter < 6) {
                        $mobile_class = "mobile_group_1";
                    } else {
                        $mobile_class = "mobile_group_2";
                    }
                    $random_index = rand(0, 17);
                    $row = $results[$random_index];
                    $quart_id = $row['quartID'];
                    $quartier = $row['quartNom'];
                    if ($counter % 2 != 0  && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button data-toggle="tooltip" style="background: #999; border-color: #999; box-shadow: 0px 0px 2px #1c262f" class="btn btn-success btn-block ' . $mobile_class . '" ><span id="quart_' . $quart_id . '"  class="drag-me" data-toggle="tooltip" title="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                         $id_quart_ajoute[] = $quart_id;
                         $counter += 1;
                    }

                    if ($counter % 2 == 0 && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #1c262f; border-color: #1c262f; box-shadow: 0px 0px 2px #1c262f" class="btn btn-success btn-block ' . $mobile_class . '"><span id="quart_' . $quart_id . '"  class="drag-me" data-toggle="tooltip" title="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                        $id_quart_ajoute[] = $quart_id;
                        $counter += 1;
                    }
                }
            ?>
        </div>


            <div id="side-bar-right" class="col-xs-12 col-sm-6 col-md-3 side-bar btn-group-vertical"   >

            <?php
                $counter = 0;
                while ($counter < 9) {
                    if ($counter < 3) {
                        $mobile_class = "mobile_group_2";
                    } else {
                        $mobile_class = "mobile_group_3";
                    }
                    $random_index = rand(0, 17);
                    $row = $results[$random_index];
                    $quart_id = $row['quartID'];
                    $quartier = $row['quartNom'];
                    if ($counter % 2 == 0  && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #999; border-color: #999; box-shadow: 0px 0px 2px #1c262f" class="btn btn-success btn-block ' . $mobile_class . '"><span id="quart_' . $quart_id . '"  class="drag-me" data-toggle="tooltip" title="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                         $id_quart_ajoute[] = $quart_id;
                         $counter += 1;
                    }

                    if ($counter % 2 != 0 && !in_array($quart_id, $id_quart_ajoute)) {
                         echo '<button style="background: #1c262f; border-color: #1c262f; box-shadow: 0px 0px 2px #1c262f" class="btn btn-success btn-block ' . $mobile_class . '"><span id="quart_' . $quart_id . '"  class="drag-me" data-toggle="tooltip" title="' . $quartier . '"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp; ' . $quartier . '</span></button>';
                        $id_quart_ajoute[] = $quart_id;
                        $counter += 1;
                    }
                }
            ?>



        </div>
    </div>
</div>


    <footer  class="row-footer" style="background-color: #1c262f">
        <div class="container">
            <div class="row">
                <div class="col-xs-5 col-xs-offset-1 col-sm-2 col-sm-offset-1">
                </div>
                <div class="col-xs-6 col-sm-5">
                </div>
                <div class="col-xs-12 col-sm-4">

                </div>
                </div>
                <div class="col-xs-12">
                    <p style="padding:10px;"></p>
                    <p style="color: #88a;" align=center>© Copyright 2017 Université Jean Monnet</p>
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