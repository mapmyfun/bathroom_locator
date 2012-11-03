<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | List</title>
		<?php
			require("header.php");
			include("../db/data.php");
			$db = new Data();
			$filtered = $db->filter(array("name", "latitude", "longitude"));
			$data = $db->all_json($filtered);
		?>

	</head>
	<body>
		<script type='text/javascript'>
			var b = <?= $data; ?>;
			var stanfordLatLng = new google.maps.LatLng(37.428729,-122.171329);
			var list = [];	
			for(var i in b) {
				var bathroom = b[i];
				var loc = new google.maps.LatLng(bathroom.latitude, bathroom.longitude);
				var dist = google.maps.geometry.spherical.computeDistanceBetween(stanfordLatLng, loc);
				var li = document.createElement("li");
				var a = document.createElement("a");
				a.innerHTML = "<h3>" + bathroom.name + "</h3><p>Extra info</p>";
				li.appendChild(a);
				list.push(li);

				$(a).click((function(name) {
						return function() { window.location = "specificBathroom.php?origin=list&name=" + name; }
					})(bathroom.name));
			}
		
			$('#home').live('pageinit', function(event) {
				var ul = $("<ul>");
				$("#home").append(ul);
				$("#bathroom_list").append(list).listview();
			});			
		</script>


		<div data-role="page" id="home">
			<div data-role="controlgroup" data-type="horizontal">
				<a data-role="button" id="filter_link">Filter</a>
				<a data-role="button" id="help_link">Help</a>
				<a data-role="button" id="map_link">Map</a>
			</div>

			<script type="text/javascript">
				$("#filter_link").click(function() {
					window.location = "filter.php?origin=list";
				});
				$("#help_link").click(function() {
					window.location = "help.php?origin=list";
				});
				$("#map_link").click(function() {
					window.location = "map.php";
				});
			</script>

			<div data-role="content">
				<ul  data-inset="true" data-split-icon="arrow-r" data-split-theme="a" id="bathroom_list">
					<li id="bathroom-divider" data-role="list-divider">Bathrooms</li>				
				</ul>
			</div>
		</div>
	</body>
</html>
