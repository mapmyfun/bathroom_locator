<!DOCTYPE html>
<html>	
	<head>
		<title>Flush | Help</title>

		<?php
			require("header.php");
		?>

	</head>
	<body>
		<div data-role="page" class="help_home">
			<script type="text/javascript">

				var makeFooter = function() {
					var url = $(".help_home").data('url');
					//console.log(url);
					var originParams = get_params(url).originParams;
					//console.log(originParams);
					var query = unescape(originParams);
					//console.log(query);
					var links = [
					{name:"Map", url:"map.php" + query, icon:"custom"}, 
					{name:"List", url:"list.php" + query, icon:"custom"},
					{name:"Filter", url:"filter.php" + query, icon:"custom"}, 				
					{name:"Help", url:"#", icon:"custom"}];
					SetFooterLinks(".help_home", links);
				}

				$(document).delegate('.help_home', 'pagebeforecreate', function(event) {
					var params = get_params();
					makeFooter(unescape(params.originParams));
				});

				$(document).delegate('.help_home', 'pageshow', function(event) {
					disable_safari();
					
					$(".help_home #help_footer_link").addClass("ui-btn-active");
					var params = get_params();
					//console.log(params);
					if (params.originParams) {
						//console.log(params.originParams);
						params.originParams = unescape(params.originParams);
				
						$("#cancel_link").attr("href", params.origin + ".php" + params.originParams);
					}
					else {
						$("#cancel_link").attr("href", params.origin + ".php" + query_string(old_params(), {}));
					}
				});			
			</script>
			<div data-role="header">
				<h2>Help</h2>
				<a data-role="button" rel="external" data-mini="true" data-inline="true" id="cancel_link">Cancel</a>
			</div>

			<div data-role="content">
				<p>Welcome to <b>Flush</b>!</p>  

				<p>Find bathrooms, when and where you need them.</p>

				<p>Flush automatically finds your location and displays the nearby buildings with public bathrooms.</p>

				<p>Filter your search by gender or handicap accessibility.
					Use the "Show All" button to clear the filter, or go back to the filter page to re-filter.</p>
				<table>
					<tr>
						<td class = "man_icon_help"></td>
						<td>Male</td>
					</tr>
					<tr>
						<td class = "woman_icon_help"></td>
						<td>Female</td>
					</tr>
					<tr>
						<td class = "handicap_icon_help"></td>
						<td>Handicap Accessible</td>
					</tr>
				</table>
			</div>
			<?php
				require ("footer.php");
			?>
		</div>		
	</body>
</html>