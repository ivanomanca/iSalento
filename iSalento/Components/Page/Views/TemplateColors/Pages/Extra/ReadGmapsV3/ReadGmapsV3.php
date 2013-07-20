<?

Isp_Loader::loadClass('Isp_View_Page');

/**
 *  Pagina Scheda Spiaggia
 */

class ReadGmapsV3 extends Isp_View_Page {
	
	
	public function getIngredients(){
		$ingredients['beanStruttura'] = array("B7Struttura", "userParams");
		return $ingredients;
	}
	
	public function skeleton() {
		
		$lat = $this->beanStruttura->Struttura->latgmap_struttura;
		$lng = $this->beanStruttura->Struttura->lnggmap_struttura;
		
		$body['all'] = "<html>
<meta name=\"viewport\" content=\"initial-scale=1.0, user-scalable=no\" />
<head>
<style type=\"text/css\">
  div#map {
    position: relative;
  }

  div#crosshair {
    position: absolute;
    top: 192px;
    height: 19px;
    width: 19px;
    left: 50%;
    margin-left: -8px;
    display: block;
    background: url(crosshair.gif);
    background-position: center center;
    background-repeat: no-repeat;
}
</style>
<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>
<script type=\"text/javascript\">
  var map;
  var geocoder;
  var centerChangedLast;
  var reverseGeocodedLast;
  var currentReverseGeocodeResponse;

  function initialize() {
    var latlng = new google.maps.LatLng(40.0531465,17.9761626);
    var myOptions = {
      zoom: 9,
      center: latlng,
      navigationControl: true,
      mapTypeControl: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    //carico l'oggetto che conterrà la mappa
    map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);

    //carico l'oggetto geocoder
    geocoder = new google.maps.Geocoder();
	
    var address = \"".$lat.",".$lng."\";	

    geocode(address);	

  }

  //funzione chiamata al click del bottone Search 
  function geocode(address) {
    //var address = document.getElementById(\"address\").value;
    geocoder.geocode({
      'address': address,
      'partialmatch': true}, geocodeResult);
    
  }

  //funzione chiamata dal geocoder per ottenere il risultato
  function geocodeResult(results, status) {
    if (status == 'OK' && results.length > 0) {
      map.fitBounds(results[0].geometry.viewport);
      //salvo il risultato
      currentReverseGeocodeResponse = results;
      //aggiunge il marker nella mappa
      addMarkerAtCenter();
    } else {
      alert(\"Geocode was not successful for the following reason: \" + status);
    }
  }

  function addMarkerAtCenter() {
    //setto le opzioni per il marker
    var marker = new google.maps.Marker({position: map.getCenter(),
                                              map: map,
					draggable: true
                                        });
    
    if(currentReverseGeocodeResponse) {
      var addr = '';
      var lat = '';
      var lng = '';
      var types = '';

      if(currentReverseGeocodeResponse.size == 0) {
        addr = 'None';
      } else {
        lat = map.getCenter().lat(); //setto la lat
	lng = map.getCenter().lng(); //setto la lng
        addr = currentReverseGeocodeResponse[0].formatted_address; //setto l'indirizzo
        types = currentReverseGeocodeResponse[0].types; //la strada precisa
       
      }
	text = '<b>Lat: </b>'+lat+ 
	     '<br><b>Lng: </b>'+lng+
             '<br><b>formatted_address: </b>'+addr+
             '<br><b>types: </b>'+types;
	//tutte le caratteristiche
        for(var i in currentReverseGeocodeResponse[0].address_components)
	{
             text += '<br><b>'+currentReverseGeocodeResponse[0].address_components[i].types+': </b>'+currentReverseGeocodeResponse[0].address_components[i].long_name;
	}
    }

    //setto il fumetto
    var infowindow = new google.maps.InfoWindow({ content: text });

    //apro il fumetto
    infowindow.open(map,marker);
  }

</script>
</head>
<body onload=\"initialize()\">
  
  <h1>Read</h1>

  <div id=\"map\">
    <div id=\"map_canvas\" style=\"width:530px; height:400px\"></div>
    <div id=\"crosshair\"></div>
  </div>

</body>
</html>";
		
		return $body;
		
	}
	
	
}


?>