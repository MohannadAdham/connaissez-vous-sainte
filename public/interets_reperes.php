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
    <link rel="stylesheet" type="text/css" href="css/timer.css">
    <link rel="stylesheet" type="text/css" href="css/interets_reperes.css">


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

    <div class="container-fluid">
      <div class="row">
        <div id="pano" class="col-md-12"></div>
        <div id="side-bar" class="col-xs-12 col-md-12">
            <div class="row" style="height: 100%">
<!--                 <div id="panel-1" class="col-xs-12 col-md-12">
                    <div id="panel-1-inside" class="panel panel-primary">
                        <div class="panel-body">Indiquer le point central du quartier suivant en cliquant sur la carte <br><br>
                        <div id="btn-quart" class="btn btn-block btn-lg btn-primary" data-toggle="tooltip" title="quartier name" disabled></div>
                        <span style=" font-weight: 400"><span style="color: #395; margin-top:1.5em" class="glyphicon glyphicon-info-sign glyphicon-success"></span>&nbsp; vous pouvez zoomer et vous déplacer dans la carte</span><br><br>
                        </div>
                    </div>
                </div> -->

                    <div class="col-xs-6 col-sm-3  col-md-4 ">
                        <button id="btn-interets" class="btn btn-lg btn-danger"> Points d'Interets </button>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-sm-push-6 col-md-4 col-md-push-4">
                        <button id="btn-reperes" class="btn btn-lg btn-primary">Points de reperes</button>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-sm-pull-3 col-md-4 col-md-pull-4">
                        <?php include_once("timer.php"); ?>
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
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiSZwMauUGqaWkRb-y0s17UlpdlaTafhk&libraries=geometry,places&callback=init&" async defer>
    </script>

  </body>
</html>