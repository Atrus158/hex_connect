<?php
session_start();
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>The Connection Game</title>
	<meta name="description" content="Find subject information relevant to the connection game"/>
	<link rel="stylesheet" type="text/css" href="connect_style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript">
		$(window).load(function()
		{
			//Using .on with keyup and submit prevents the page from going to search.process
			//when you hit the enter button.
			$("#node_box").on("keyup submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	            		var html_string = "<table>";

	        			$('#connect_list').html(data.html);
	        			$('#node_name').val(data.node_name);
	        			$('#node_descript').val(data.node_description);
	        			$('#node_type').val(data.node_type);
	        			//clear the list if nothing entered
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#connect_list').html('<tr class="black centered"><td class="col1">Related Node</td><td class="col2">Description</td></tr>');
	        			}

	        			if (data.names != undefined) {
		        			for (i=0, j=data.names.length; i<j; i++) {
		        				if (i%2 == 0) {html_string += '<tr class="lyellow"><td class="node_search">' + data.names[i] + '</td></tr>'};
		        				if (i%2 != 0) {html_string += '<tr class="lblue"><td class="node_search">' + data.names[i] + '</td></tr>'};
		        			}
	        			}
	        			html_string += '</table>';
	        			$('#search_display').html(html_string);
	        		},
	        		"json"
	            );
	            return false;
	        });
	    });
	</script>
</head>
<body class="node_body">
<div class="wrapper">
	<?php
		include('nav_bar.php');
	?>
	<div class="main_content">
		<h1 class="node_header">Node Information</h1>
		<p class="header_note">Get Details About Individual Nodes</p>

		<form id="node_box" class="admin_add" action="process.php" method="post">
			<input type="hidden" name="action" value="node_view">			
			<label><b>Search:</b></label>
			<input type="text" class="blocktext light_blue" name="node" autocomplete="off"/>
			<div id="search_display">
				<!-- node names go here -->
			</div>
		</form>

		<form>
			<label class="labels">Node Name:<label>
			<input id="node_name" type="text" class="blocktext" readonly />
			<label class="labels">Node Type:</label>
			<input id="node_type" type="text" class="blocktext" readonly />
			<label class="labels">Node Description:</label>
		    <textarea id="node_descript" rows="3" columns="5" class="blocktext width600" readonly >
			</textarea>
		</form>

		<div id="connect_div">
			<table id="connect_list">
				<tr class="black centered">
					<td class="col1">Related Node</td>
					<td class="col2">Description</td>
				</tr>
				<!-- Search results go here -->
			</table>
		</div>

	</div><!-- End Main Content -->
</div><!-- End Wrapper -->

</body>
</html>