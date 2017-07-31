     var counter = 0;
     var map_center = {lat: 45.439695, lng: 4.387178};
     // a variable to determine whether the map is clickable or not
     var clickable = true;
     console.log("user id : " + user_id);
     var user_markers = [];
     var centres_markers = [];
     var distances = [];
     var user_centers_lat = [];
     var user_centers_lng = [];
     answers = [];

     $("#btn-quart").text(quart_noms[counter]);
     $("#btn-quart").attr('title', quart_noms[counter]);

     // Create a map variable
     var map;
     // Initialize the map
     function initMap() { // start initMap function
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
                // Add the coordinates to the arrays
                user_centers_lat.push(lat);
                user_centers_lng.push(lng);
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

         } // end initMap function

        // Hide navbar while the mouse is over the map
        $('#map').mouseenter(
            function() {
                $('.navbar').slideUp(1000);
        });

        $('#map').mouseleave(function() {
                $('.navbar').slideDown(1000);
        });

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
                if (counter < 2) {
                    // reset the map center and zoom
                    map.setCenter(map_center);
                    // Different zoom for mobile devices
                    if ($('.navbar').css('top') == '-60px') {
                        map.setZoom(13); // for mobile
                    } else {
                    map.setZoom(14); // for desktop, laptop and tablet
                    }
                }
                // get the answer from radio buttons
                answer = $('input[name="quart_choice"]:checked').val();
                answers.push(answer);
                console.log(answer);

                // reset the radio buttons' answer
                $('input[name="quart_choice"]').prop('checked', false);

                if (counter < 2) { // Doesn't apply to final step
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
                var image = {
                        url: "icons/flag-blue_44.png",
                        size: new google.maps.Size(44, 44),
                        // The origin for this image is (0, 0).
                        origin: new google.maps.Point(0, 0),
                        // The anchor for this image is the base of the flagpole at (10, 40).
                        anchor: new google.maps.Point(10, 40)
                        };
                for (var i = 0; i < quart_noms.length; i++) { // start for loop
                    // create a marker for each center
                    marker = new google.maps.Marker({
                    position: new google.maps.LatLng(centres_lat[i], centres_lng[i]),
                    map: map,
                    icon: image,
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
                      strokeColor: '#222',
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
                    // add the distance to the score panel
                    $('#distance-' + (i+1)).text(Math.round(distance) + ' m') ;

                    //change the color of the distance in the score panel according to
                    // the distance value
                    if (distance < 500) {
                        $('#distance-' + (i+1)).css('color', '#007E33');
                    } else if (distance < 900) {
                        $('#distance-' + (i+1)).css('color', '#FF8800');
                    } else if (distance >= 900) {
                        $('#distance-' + (i+1)).css('color', '#CC0000');
                    }
                    // add the distance to the array of distances
                    distances.push(distance);
                    console.log(distances);
                    // calculate the score for this point
                    score = ((average_distance - (distance - 50)) / average_distance) * 100;
                    if (score >= 100) {score = 100;};
                    // to avoid that one point affect the global score by more than 1/3
                    if (score <= 0) {score = 0};
                    console.log('score ' + i + ' = ' + score);

                    // add the score to the array of scores
                    scores.push(score);

                } // end of for loop

                // set the bounds of the map
                map.setMapTypeId('terrain');
                map.fitBounds(bounds);

                // Change the height of the map and the bar for mobile devices
                if ($('.navbar').css('top') == '-60px') {
                        $('#map, #side-bar').height('50%');

                };
                // calculate final score
                var sum = scores.reduce(function(a, b) { return a + b; });
                var avg_score = Math.floor(sum / scores.length) + 1;
                // add the average score to the third panel
                $('#score').text(avg_score + '%');
                // change the score color
                if (avg_score < 65) {
                    $('#score').css('color', '#FF8800'); // orange color
                };
                if (avg_score < 35) {
                    $('#score').css('color', '#CC0000'); // red color
                };

                // Send the results to the server
                $.ajax({
                    url: '../private/ajax/quartiers_centres.ajax.php',
                    type: 'GET',
                    data: {
                        'uniq_id' : user_id,
                        'quart_ids' : quart_ids,
                        'quart_choix' : answers,
                        'user_centers_lat' : user_centers_lat,
                        'user_centers_lng' : user_centers_lng ,
                        'user_scores' : scores,
                        'global_score' : avg_score
                    }
                });

                // show the score panel
                setTimeout(function() {
                    $('#panel-3').slideDown(600);
                }, 1000);

                // prevent click after last step
                clickable = false;
                map.setOptions({ draggableCursor: 'normal' });

            } // end of if statement
        });