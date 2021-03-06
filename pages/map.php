<!DOCTYPE html>
<html>
	<head>
		<title>Flush | Map</title>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />		
		<?php
			require("header.php");
			include("../db/data.php");
			$db = new Data();
			$filter = $db->getFilter();
			$buildings = $db->all_buildings_that_match($filter);
			for ($i = 0; $i < count($buildings); $i++) {
				//echo var_dump($buildings[$i]);
				$specific_counts = $db->count_features($buildings[$i]["Building_Name"], $buildings[$i]["Building_Number"]);
				$buildings[$i]['male_count'] = $specific_counts['male'];
				$buildings[$i]['female_count'] = $specific_counts['female'];
				$buildings[$i]['handicap_count'] = $specific_counts['handicap'];
				//echo var_dump($buildings[$i]);
			}
			$data = $db->all_json($buildings);
		?>
	</head>
	<body>
		<div data-role="page" data-title="Map" class="map_home">
			<script src="../assets/javascript/markers.js"></script>
			<script src="../assets/javascript/bathroomService.js"></script>
			<script type="text/javascript">
				function success(position) { 
					var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				  	var myOptions = {
				    	zoom: 18,
				    	center: latlng,
				    	zoomControl: true,
						panControl: true,
					    mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					createMap(myOptions, latlng);
				}
					
				function notsuccess() {
					var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
					var mapOptions = {
						center: stanfordLatLng,
						zoom: 18,
						zoomControl: true,
						panControl: true,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					createMap(mapOptions, null);
				}

				function createMap(options, knownlocation) {
					var maps = $(".map_canvas")[0];
					var map = new google.maps.Map(maps,
							options);

					var manager = new MarkerManager(map);
					var json = <?= $data; ?>;
					var filterHash = filter_from_params();
					var params = get_params();

					for(var i in json) {
						var building = json[i];
						if (params.show == 1) {
							if (params.Building_Number != building.Building_Number) {
								delete json[i];
							}
							else map.panTo(new google.maps.LatLng(building.Latitude, building.Longitude));
						} 
					}
					
					manager.addMarkersFromJSON(json);
					

					var service = new BathroomService(manager);
					if(knownlocation!=null){
						var marker = new google.maps.Marker({
				    	position: knownlocation, 
				      	map: map, 
				      	title:"You are here!",
				      	icon: "../assets/images/bathroom_pin_30x62.png"
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
							  		visible: true,
							  		icon: "../assets/images/blue.png"

								});
								markers.push(marker);
							}
						}
					}
				}

				function loadMap(){
					disable_safari();

					var header = $("#search-panel").height();
					var footer = $("#footerlist").height();
					$(".map_canvas").height(document.height - header - footer - 42);
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(success, notsuccess);
					} else {
						notsuccess();
					}
				}

				var makeFooter = function() {
					var originParams = escape("?" + stringify_params(get_params()));
					var links = [
					{name:"Map", url:"#", icon:"custom"}, 
					{name:"List", url:"list.php" + query_string(old_params(), {}), icon:"custom"},
					{name:"Filter", url:"filter.php" + query_string(old_params(), {origin:"map"}), icon:"custom"}, 				
					{name:"Help", url:"help.php" + query_string(old_params(), {origin:"map", originParams:originParams}), icon:"custom"}];
					SetFooterLinks(".map_home", links);
				}

				$(document).delegate(".map_home", 'pagebeforecreate', function(event) {
					makeFooter();
				});
				
				$(document).delegate(".map_home", 'pageshow', function(event) {
		    		disable_safari();
		    		loadMap();
		    		$(".map_home #map_footer_link").addClass("ui-btn-active");
		    	});
			</script>

			<div data-role="header" id="search-panel">
				<h2>Map</h2>
				<a data-role="button" data-mini="true" data-theme="b" data-inline="true" rel="external" href="map.php">Show all</a>
			</div>

			<div data-role="content" class="map_canvas"></div>

			<?php
				require ("footer.php");
			?>
		</div>
	</body>
</html>
