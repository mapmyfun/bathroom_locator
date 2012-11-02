<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />		
		<?php
			require("header.php");
		?>
		<script src="../assets/javascript/markers.js"></script>
		<script src="../assets/javascript/bathroomService.js"></script>
		<?php
		include("../db/data.php");
		$db = new Data();
		$data = $db->all_json($db->filter(array("name", "latitude", "longitude")));
		?>

		<script type="text/javascript">
			function success(position) { 
				var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			  	var myOptions = {
			    	zoom: 15,
			    	center: latlng,
				    mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				createMap(myOptions, latlng);
			}
				
			function notsuccess() {
				var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
				var mapOptions = {
					center: stanfordLatLng,
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				createMap(mapOptions, null);
			}

			function createMap(options, knownlocation) {
				var map = new google.maps.Map(document.getElementById("map_canvas"),
						options);

				var manager = new MarkerManager(map);
				var json = <?= $data; ?>;
				manager.addMarkersFromJSON(json);
				

				var service = new BathroomService(manager);
				if(knownlocation!=null){
					var marker = new google.maps.Marker({
			    	position: knownlocation, 
			      	map: map, 
			      	title:"You are here!",
			      	icon: "../assets/images/28-star.png"
			  	});
				}

				function callback(places, status) {
					if(status == google.maps.places.PlacesServiceStatus.OK) {
						for (var i = 0; i < places.length; i++) {
							var place = places[i];
							var marker = new google.maps.Marker({
						  		map: map,
						  		title: place.name,
						  		position: place.geometry.location,
						  		visible: true
							});
							markers.push(marker);
						}
					}
				}

				var input = document.getElementById('target');
				input.onchange = function(evt) {
					var request = {
						location: stanfordLatLng,
						query: input.value,
						radius: 1000
					}
					service.textSearch(request);
				}
			}

			function loadMap(){
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(success, notsuccess);
				} else {
					notsuccess();
				}
			}
			
		</script>
	</head>
	<body onload="loadMap()">
		<div data-role="page" data-title="Map">
			<div data-role="header" id="search-panel">
				<div data-role="controlgroup" data-type="horizontal">
					<div data-role="fieldcontain">
						<div class="ui-grid-a">
							<div class="ui-block-a">
								<input data-mini="true" id="target" type="search" placeholder="Search Box" autocomplete="off">
							</div>
							<div class="ui-block-b">
								<a data-role="button" id="target_button" type="button">Search</a>
								<a id="list_link" data-role="button">List</a>			
								<a id="filter_link" data-role="button">Filter</a>
							</div>
						</div><!-- /grid-a -->

						<script type="text/javascript">
						var button = document.getElementById("target_button");
						button.onclick = function(evt) {

						}

						$("#filter_link").click(function() {
							window.location = "filter.php?origin=map";
						});
						$("#list_link").click(function() {
							window.location = "list.php";
						});
						</script>
					</div>
				</div>
			</div>

			<div data-role="content" id="map_canvas"></div>
			<?php
				require("footer.php");
			?>
		</div>
	</body>
</html>
