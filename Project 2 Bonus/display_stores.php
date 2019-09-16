<html>
    <body style="margin: auto;">
      <div style="margin: auto; text-align: center;">
    <?php
include "dbconfig.php";
$connect= mysqli_connect($server, $login, $password, $dbname) or die("<br>Cannot connect to Database");
$result= mysqli_query($connect, "SELECT sid, name, zipcode, state, city, address, latitude, longitude 
                  from CPS3740.Stores 
                  WHERE sid is NOT NULL and name is NOT NULL and
                  city is NOT NULL and state is NOT NULL and
                  zipcode is NOT NULL and latitude is NOT NULL and
                  longitude is NOT NULL and address is NOT NULL");

      $id = array();
      $name = array();
      $addr = array();
      $cty = array();
      $st = array();
      $zpcd = array();
      $lat = array();
      $long = array();
      $ct = 0;

    if($result) {
    if(mysqli_num_rows($result)>0) {
        echo "<center><TABLE border=1>";
        echo "<b>The following stores are in the database</b>";
        echo "<TR><TH>Store ID<TH>Name<TH>Address<TH>City<TH>State<TH>Zipcode<TH>Location(Latitude,Longitude)";

        while($row = mysqli_fetch_array($result)){
            $id[$ct]=$row['sid'];
            $name[$ct]=$row['name'];
            $addr[$ct]=$row['address'];
            $cty[$ct]=$row['city'];
            $st[$ct]=$row['state'];
            $zpcd[$ct]=$row['zipcode'];
            $lat[$ct]=$row['latitude'];
            $long[$ct]=$row['longitude'];

            $sid=$row['sid'];
            $names=$row['name'];
            $address=$row['address'];
            $city=$row['city'];
            $state=$row['state'];
            $zipcode=$row['zipcode'];
            $latitude=$row['latitude'];
            $longitude=$row['longitude'];

        echo "<TR><TD>$sid<TD>$names<TD>$address<TD>$city<TD>$state<TD>$zipcode<TD>($latitude, $longitude)";
        $ct++;
        $sumlat += $latitude;
        $sumlong += $longitude;
        $centerlat = $sumlat / $ct;
        $centerlon = $sumlong / $ct;
      }
  }
  echo "</table></center>";
}

?>
      
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script>
        var i = 0;
        function initializeMap() {
            var mapOptions = {
                    zoom: 3,
    
                    center: new google.maps.LatLng(<?php echo "$centerlat"?>,<?php echo "$centerlon"?>),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
           };
    
           var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    
           var infowindow = new google.maps.InfoWindow();
    
        var markerIcon = {
            scaledSize: new google.maps.Size(80, 80),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(32,65),
              labelOrigin: new google.maps.Point(40,33)
        };
            var location;
            var mySyms;
            var marker, m;
    
            var MarkerPlace= [
                        <?php
              for($i=0;$i<count($long);$i++){
echo("['$id[$i]', '$name[$i]', '$addr[$i]', '$cty[$i]', '$st[$i]', '$zpcd[$i]', '$lat[$i]', '$long[$i]'],\n");
              }
//['$id[0]', '$name[1]', '$addr[2]', '$cty[3]', '$st[4]', '$zpcd[5]', '$lat[6]', '$long[7]']

            ?> ];
    
    for (m = 0; m < MarkerPlace.length; m++) {
    
            location = new google.maps.LatLng(MarkerPlace[m][6], MarkerPlace[m][7]),
            marker = new google.maps.Marker({ 
            map: map, 
            position: location, 
            icon: markerIcon,   
            label: {
            text: MarkerPlace[m][0] ,
            color: "black",
                fontSize: "16px",
                fontWeight: "bold"
            }
        });
    
          google.maps.event.addListener(marker, 'click', (function(marker, m) {
            return function() {
              infowindow.setContent("Store Name: " + MarkerPlace[m][1] + "<br>"
                                    + MarkerPlace[m][2] + ", " + MarkerPlace[m][3] + ", " + MarkerPlace[m][4] + " " + MarkerPlace[m][5]);
              infowindow.open(map, marker);
            }
          })(marker, m));
     }
    }
      google.maps.event.addDomListener(window, 'load', initializeMap);
    </script>
    <div id="map-canvas" style="height: 400px; width: 720px; margin: auto;"></div>
    </div>
    </body>
    </html>