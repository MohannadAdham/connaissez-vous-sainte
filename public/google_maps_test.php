<!-- This is the corresponding "starter code" for 04_Hello Map in Udacity and Google's Maps
API Course, Lesson 1 -->
<html>
 <head>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">




 <!-- styles put here, but you can include a CSS file and reference it instead! -->
   <style type="text/css">
     html, body { height: 100%; margin: 0; padding: 0; }
     #map, #satellite { height: 100%; }
   </style>
 </head>
 <body>
    <div class="container-fluid">
      <div class="row">
        <div id="map" class="col-md-6"></div>
        <div id="satellite" class="col-md-6"></div>
      </div>
    </div>


   <script>
     // TODO: Create a map variable
     var map;
     var satelleite;
     // TODO: Complete the following function to initialize the map
     function initMap() {
       // TODO: use a constructor to create a new map JS object. You can use the coordinates
       // we used, 40.7413549, -73.99802439999996 or your own!
       map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 45.439695, lng: 4.387178},
        zoom: 13
       });

       satellite = new google.maps.Map(document.getElementById('satellite'), {
        center: {lat: 45.439695, lng: 4.387178},
        zoom: 13
       });

       var beaulieu = {lat: 45.428, lng: 4.416 };
       var marker = new google.maps.Marker({
        position: beaulieu,
        map: map,
        title: 'Beaulieu'
       });

        var marker2 = new google.maps.Marker({
        position: beaulieu,
        map: satellite,
        title: 'Beaulieu'
       });

       var infowindow = new google.maps.InfoWindow({
        content: "<div class='container-fluid'><div class='panel panel-primary'><div class='panel .panel-heading'>Bealieu</div><div class='panel panel-body'>C'est le centre du quartier de <b style='color: red'>Beaulieu</b><br><br><button class='btn btn-success'>Continue</button></div><iframe src='https://coursera.org'></iframe></div></div>"

       });

       marker.addListener('click', function() {
        infowindow.open(map, marker);
       });

       marker2.addListener('click', function() {
        infowindow.open(satellite, marker);
       });

     }
   </script>
   <!--TODO: Load the JS API ASYNCHRONOUSLY below.-->

   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYy2PP3wd5eysIDe9q-qL3cQ4Sx80nz_M&callback=initMap" async defer>
   </script>
 </body>
</html>
