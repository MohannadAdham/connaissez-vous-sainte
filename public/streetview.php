<?php

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Google Street View Double Click</title>
	<script type="text/javascript" src="js/jquery1.8.3.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style_2.css">
	<script type="text/javascript" src=js/script.js></script>

</head>
<body >
	<div id="instructions">Double-cliquez sur un endroit pour afficher des informations connexes</div>
	<div id="pano"></div>

	<div id="side-menu" >

	<form action="#">
	  <p>
	    <input type="checkbox" id="chbox1" />
	    <label for="chbox1" >Choix 1</label>
	  </p>
	  <p>
	    <input type="checkbox" id="chbox2" />
	    <label for="chbox2">Choix 2</label>
	  </p>
	  <p>
	    <input type="checkbox" id="chbox3"/>
	    <label for="chbox3">Choix 3</label>
	  </p>
	    <p>
	      <input type="checkbox" id="chbox4" />
	      <label for="chbox4">Choix 4</label>
	  </p>
	  	  <p>
	    <input type="checkbox" id="chbox5" />
	    <label for="chbox5">Choix 5</label>
	  </p>
	  <p>
	    <input type="checkbox" id="chbox6" />
	    <label for="chbox6">Choix 6</label>
	  </p>
	  <p>
	    <input type="checkbox" id="chbox7"/>
	    <label for="chbox7">Choix 7</label>
	  </p>
	    <p>
	      <input type="checkbox" id="chbox8" />
	      <label for="chbox8">Choix 8</label>
	  </p>
	  <br/>
	  <h4 id="suggest-label">Autre suggestion</h4>
	  <input id="suggestion" type="text" name="suggestion"><br>
	  <br/>
	  <input type="submit" name="valider">

</form>




	</div>

	<div id="map"></div>







    <script
  	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiSZwMauUGqaWkRb-y0s17UlpdlaTafhk&libraries=geometry,places&callback=init&" async defer>
	</script>
</body>
</html>