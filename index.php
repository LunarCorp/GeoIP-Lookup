<?php



require ('./GeoIP.php');

if (isset($_REQUEST['ip_address'])) {
	$ip_address = urldecode($_REQUEST['ip_address']);
} else {
	$ip_address = $_SERVER['REMOTE_ADDR'];
}

$geoip = Net_GeoIP::getInstance('GeoLiteCity.dat');

$location = $geoip->lookupLocation($ip_address);

?>
<html>
<title>Amax GeoIP Lookup</title>
<link rel="icon" 
      type="image/png" 
      href="globe-logo.png">
<link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <style>
        .header {
  background-color: #000;
  padding: 0px;
  text-align: left;
  color:white;
  font-family: 'Quicksand', sans-serif;
}
    </style>
    <style>
  @keyframes spinning {
    from { transform: rotate(0deg) }
    to { transform: rotate(360deg) }
  }
  .spin {
    animation-name: spinning;
    animation-duration: 3s;
    animation-iteration-count: infinite;
    /* linear | ease | ease-in | ease-out | ease-in-out */
    animation-timing-function: linear;
  }
</style>
    <div class="header">
  <h1><img src = 'globe-logo.png' style='vertical-align: middle' class="spin"  /> Amax GeoIP Lookup</h1>
  
</div>

<body>

    <style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: rgba(255, 255, 255, 0.05);
  border-radius:3px;
  border:1px solid ;
  border-color:rgba(255, 255, 255, 0.05);
}

li {
  float: left;
  border-radius:3px;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  border-radius:3px;
  
}


li a:hover {
  background-color: #111;
  border-radius:3px;
}
</style>
<ul>
  <li><a href="#home">Home</a></li>
  <li><a href="#vpn">VPN</a></li>
  <li><a href="#theme">Theme</a></li>
  <li><a href="#about">About</a></li>
</ul>
<center>
           <div id="clock"></div>
              
            <br></br>
            <br></br>
            <br></br>
            <form method="GET" action="index.php">
            IP: <input type="text" size="41" name="ip_address" value="<?=$ip_address?>"><input type="submit" value="Submit">
            
            
            </form>
            <table id="vertical-1">
            
            <tr>
                <th>City</th>
                <td>  <?php echo $location->city ?></td>
            </tr>
            <tr>
                <th>Region</th>
                <td>  <?php echo $location->region ?></td>
            </tr>
            <tr>
                <th>Postal Code</th>
                <td>  <?php echo $location->postalCode ?></td>
            </tr>
            <tr>
                <th>Area Code</th>
                <td>  <?php echo $location->areaCode ?></td>
            </tr>
            <tr>
                <th>Coordinates</th>
                <td>  Lat: <?php echo $location->latitude ?>, Long: <?php echo $location->longitude ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?php echo $location->countryName ?></td>
            </tr>
             <tr>
                <th>Country Code</th>
                <td><?php echo $location->countryCode3 ?></td>
            </tr>
            </table>
         <div id="mapid" style="width: 600px; height: 400px;"></div>
<script>

	var mymap = L.map('mapid').setView([<?php echo $location->latitude ?>, <?php echo $location->longitude ?>], 13);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://vpn.amax.store">Amax Maps</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);
	
	L.marker([<?php echo $location->latitude ?>, <?php echo $location->longitude ?>]).addTo(mymap)
		.bindPopup("<b><?=$ip_address?></b><br /><?php echo $location->latitude ?>, <?php echo $location->latitude ?>").openPopup();

</script>
           <script id="rendered-js" >
function currentTime() {
  var date = new Date(); /* creating object of Date class */
  var hour = date.getHours();
  var min = date.getMinutes();
  var sec = date.getSeconds();
  hour = updateTime(hour);
  min = updateTime(min);
  sec = updateTime(sec);
  document.getElementById("clock").innerText = hour + " : " + min + " : " + sec; /* adding time to the div */
  var t = setTimeout(function () {currentTime();}, 1000); /* setting timer */
}

function updateTime(k) {
  if (k < 10) {
    return "0" + k;
  } else
  {
    return k;
  }
}

currentTime(); /* calling currentTime() function to initiate the process */
//# sourceURL=pen.js
    </script>

</center>
</body>
</html>