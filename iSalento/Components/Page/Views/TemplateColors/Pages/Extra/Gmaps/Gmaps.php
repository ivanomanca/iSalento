<?

Isp_Loader::loadClass('Isp_View_Page');

/**
 *  Pagina Scheda Spiaggia
 */

class Gmaps extends Isp_View_Page {
	
	public function skeleton() {
		
		$body['all'] = "<!DOCTYPE html \"-//W3C//DTD XHTML 1.0 Strict//EN\" 
						  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
						<html xmlns=\"http://www.w3.org/1999/xhtml\">
						  <head>
						    <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"/>
						    <title>Google Maps JavaScript API test isalento</title>
						    
						    <!-- Load delle API -->
						    <script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA0EF9Wv2o57cNi7vLHZiGKBSwojDxMfCp-aTVzYt0mTPmW-p7uxR-n58KYMVbsDEuNT_RW-5PcIg_Fg&sensor=false\"
						            type=\"text/javascript\"></script>
						    <script type=\"text/javascript\">
						
						    var map;
						    var geocoder;
						
						    function initialize() {
						      map = new GMap2(document.getElementById(\"map_canvas\"));
						      map.setCenter(new GLatLng(40.0531465,17.9761626), 10);
						      map.addControl(new GLargeMapControl);
						      geocoder = new GClientGeocoder();
						    }
						
						    // addAddressToMap() is called when the geocoder returns an
						    // answer.  It adds a marker to the map with an open info window
						    // showing the nicely formatted version of the address and the country code.
						    function addAddressToMap(response) {
						      map.clearOverlays();
						      if (!response || response.Status.code != 200) {
						        alert(\"Sorry, we were unable to geocode that address\");
						      } else {
						        place = response.Placemark[0];
						        point = new GLatLng(place.Point.coordinates[1],
						                            place.Point.coordinates[0]);
						        marker = new GMarker(point);
						        map.addOverlay(marker);
						        marker.openInfoWindowHtml('<b>Indirizzo:</b>' + place.address + '<br>' +
						        '<br>**Oggetto JSON, scomposizione indirizzo** <br>' +
						        '<b>latlng:</b>' + place.Point.coordinates[1] + \",\" + place.Point.coordinates[0] + '<br>' +    '<b>Nazione:</b> ' + place.AddressDetails.Country.CountryNameCode + '<br>' +
							        '<b>Area amministrativa:</b>' + place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName + '<br>' +
							        '<b>Area subamministrativa:</b>' + place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.SubAdministrativeAreaName + '<br>' +
							        '<b>Localita:</b>' + place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName + '<br>' 
							        /*
							        +
							        '<b>livello strada:</b>' + place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.Thoroughfare.ThoroughfareName + '<br>'  +
							        '<b>Codice postale:</b>' + place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber
						        */
						        );
						      }
						    }
						
						    // showLocation() is called when you click on the Search button
						    // in the form.  It geocodes the address entered into the form
						    // and adds a marker to the map at that location.
						    function showLocation() {
						      var address = document.forms[0].place.value;
						      geocoder.getLocations(address, addAddressToMap);
						    }
						    
						    </script>
						  </head>
						
						  
						  <body onload=\"initialize()\" onunload=\"GUnload()\">
						      	<h1>Geo coding diretto</h1>
						  	<form action=\"#\" onsubmit=\"showLocation(); return false;\">
						      <p>
						        <input type=\"text\" name=\"place\" value=\"\" class=\"address_input\" size=\"40\" />
						        <input type=\"submit\" name=\"find\" value=\"Search\" />
						      </p>
						    </form>
						     <div id=\"map_canvas\" style=\"width: 500px; height: 300px\"></div>
							

						  </body>
						
						</html>";
		
		return $body;
		
	}
	
	
}


?>