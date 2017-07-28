<?php
    include_once("../private/connect/connect.php");
    // setcookie('id', '', time() - (86400 * 30));
    if (!isset($_COOKIE['id'])) {
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
    <title>Connaissez-vous Sainté ?</title>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"> -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <style >
        .card {
            margin-top: 2em;
            box-shadow: 5px 5px 25px 0;
            border-radius: 0.375em;
            height: 22.5em;
            background-color: #fff;

            }

        .navbar-brand {
            position: relative;
            top: -5px;
            left: -10px;
        }
        footer {
            margin-top: 4em;
        }

        .card-head {
            margin-left: 5%;
            margin-right: 5%;
            margin-top: 4%;
            font-weight: 500;
            font-size: 2rem;;
            line-height: 2.25rem;
            color: #2e3d49;
            font-family: "Open Sans", sans-serif;
        }

        .card-body {
            margin-left: 5%;
            margin-right: 5%;
            margin-top: 4%;
            font-size: 1.5rem;
            color: #2e3d49;
            font-weight: 500;
            font-family: "Open Sans", sans-serif;
        }
    </style>


</head>

<body style="background: #DDD">
    <nav style="background-color: #1c262f; box-shadow: 0 5px 15px black; border-color:transparent;" role="navigation" class="navbar navbar-inverse navbar-fixed-top">
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
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"
                         aria-hidden="true"></span> Accueil</a></li>
                    <li><a href="about.html"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> À propos</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                         role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span>
                         Tests <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="quartiers.php">Noms des Quartiers</a></li>
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

    <header class="jumbotron">
        <div class="container-fluid">
            <div class="row row-header">
                <div class="col-xs-8 col-sm-7 col-md-6 col-md-offset-1">
                    <h1 id="header1">Connaissez-Vous Sainté ?</h1>
                </div>
            </div>
        </div>
    </header>

    <section class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4" >
                <div class="card">
                   <a href="quartiers.php"><img  src="images/quartiers.png" class="img-responsive"></a>
                   <div class="card-head">Test 1 : Positions des Quartiers</div>
                   <div class="card-body">condition préalable : Aucune</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card">
                    <img  src="images/quartiers_centres_2.png" class="img-responsive">
                    <div class="card-head">Test 2 : Centres des Quartiers</div>
                   <div class="card-body">condition préalable : Test 1</div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card">
                    <img  src="images/quartiers.png" class="img-responsive">
                    <div class="card-head">Test 3 : Points d'Interets VS Points de repères</div>
                   <div class="card-body">condition préalable : Test 2</div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6"></div>
        </div>


    </section>




    <footer class="row-footer">
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
                      121, Clear Water Bay Road<br>
                      Clear Water Bay, Kowloon<br>
                      HONG KONG<br>
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
                    <p align=center>© Copyright 2015 Ristorante Con Fusion</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>