<?php
	session_start();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Admin Page</title>
	<meta name="description" content=""/>
	<link rel="stylesheet" type="text/css" href="connect_style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript">

		$(window).load(function()
		{
			$("#search_box").on("keyup submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	        			$('#node_list').html(data.html);
	        			if (data.first_row != null) {
	        				$('#select_result1').val(data.first_row.node);
	        			} else {
	        				$('#select_result1').val('');
	        			}
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#node_list').html('<tr class="black"><td class="col1">Node</td><td class="col2">Description</td><td class="col3">Type</td></tr>');
	        			}
	        		},
	        		"json"
	            );
	            return false;
	        });

	        $("#search_box2").on("keyup submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	        			$('#node_list2').html(data.html);
	        			if (data.first_row != null) {
	        				$('#select_result2').val(data.first_row.node);
	        			} else {
	        				$('#select_result2').val('');
	        			}
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#node_list2').html('<tr class="black"><td class="col1">Node</td><td class="col2">Description</td><td class="col3">Type</td></tr>');
	        			}
	        		},
	        		"json"
	            );
	            return false;
	        });

	       	$("#vpn").on("submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	        			$('#node_list3').html(data.html);
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#node_list3').html('<tr class="black"><td class="width125">Node</td><td class="width375">Description</td><td class="width50">Type</td><td class="width100">Submitter</td><td class="width100">Email</td><td class="width50">Approve</td></tr>');
	        			}
	        		},
	        		"json"
	            );
	            return false;
	        });

	        $("#van").on("submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	        			$('#node_list3').html(data.html);
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#node_list3').html('<tr class="black"><td class="width125">Node</td><td class="width375">Description</td><td class="width50">Type</td><td class="width100">Submitter</td><td class="width100">Email</td><td class="width50">Approve</td></tr>');
	        			}
	        		},
	        		"json"
	            );
	            return false;
	        });

	        $("#vpc").on("submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	        			$('#node_list4').html(data.html);
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#node_list4').html('<tr class="black"><td class="width125">Node 1</td><td class="width375">Connection</td><td class="width125">Node 2</td><td class="width100">Submitter</td><td class="width100">Email</td><td class="width50">Action</td></tr>');
						}
	        		},
	        		"json"
	            );
	            return false;
	        });

	        $("#vac").on("submit",function()
	        {
	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	        			$('#node_list4').html(data.html);
	        			if (data == '') {
	        				//Blank spaces in the html below will cause errors.
	        				$('#node_list4').html('<tr class="black"><td class="width125">Node 1</td><td class="width375">Connection</td><td class="width125">Node 2</td><td class="width100">Submitter</td><td class="width100">Email</td><td class="width50">Action</td></tr>');
						}
	        		},
	        		"json"
	            );
	            return false;
	        });

	    });
	</script>
</head>
<body class="admin_body">
<div class="wrapper">
	<?php
		include('nav_bar.php');
	?>
	<div class="main_content_admin">
		<div class="login">
			<?php
			if (isset($_SESSION['email'])) {
				echo 'You are currently logged in under ' . $_SESSION['email'] . '.<br />';
				echo '<a href="process.php?logout=1">Logout</a>';
			} else {
				echo 	
					    '<div class="login_blocks login_message">';
							
							if (isset($_SESSION['log_error']['message'])) {
								echo 	'<div class="login_errors">
											<p>' . $_SESSION['log_error']['message'] . '</p>
										</div>';
							} 
							if (!isset($_SESSION['log_error']['message']) AND !isset($_SESSION['reg_error']['message'])) {
								echo '<span>Log in to make submissions.</span>';
							}
					
					echo'</div>
					    <div class="login_blocks login_login">
							<span>Log in</span>
							<form class="form_indented" action="process.php" method="post">
								<input type="hidden" name="action" value="login_admin">
								<input type="text" name="email" placeholder="Email Address">
								<input type="password" name="password" placeholder="Password">
						    	<input type="submit" value="Log in" class="width123 submit_button">
							</form>
						</div>';
			}
			?>
		</div><!-- End Login section -->

		<div class = "submit_input">

			<h2 class="submit_header">Add a New Node</h2>
			<form class="admin_add" action="process.php" method="post">
				<input type="hidden" name="action" value="add_node">
				
				<label>Node Name:</label>
				<input type="text" class="node_name" name="node" />
				<label>Node Description:</label>
				<input type="textarea" rows="3" columns="5" class="node_description" name="n_descript" />

				<label>Node Type:
				<select name="type">
					<option value="Actor">Actor</option>
					<option value="Artist">Artist</option>
					<option value="Book">Book</option>
					<option value="Board game">Board Game</option>
					<option value="City">City</option>
					<option value="Comedian">Comedian</option>
					<option value="Company">Company</option>
					<option value="Computer game">Computer Game</option>
					<option value="Concept">Concept</option>
					<option value="Director">Director (Movie/TV)</option>
					<option value="Historical figure">Historical Figure</option>
					<option value="Movie">Movie</option>
					<option value="Musical artist">Musical Artist or Group</option>
					<option value="Musical">Musical</option>
					<option value="Person">Person</option>
					<option value="Place">Place</option>
					<option value="Play">Play</option>
					<option value="TV show">TV Show</option>
					<option value="Writer">Writer</option>
					<option value="Multiple">Fits Multiple Categories</option>
					<option value="Other">Other</option>
				</select>
				<input type="submit" class="submit_button" value="Submit">
			</form>
<!-- 			<div>
				<?php
					if(isset($_SESSION['error'])) {
						foreach ($_SESSION['error'] as $msg => $value) {
							echo '<p>' . $value . '</p>';
						};
					};
					if(isset($_SESSION['success_message'])) {
					 	echo $_SESSION['success_message'];
					};
				?>
			</div> -->
		</div><!-- End submit input -->
		<div class="divider">
		</div>

			<div class="submit_input">
				<h2 class="submit_header">Add a New Connection</h2>

				<!-- First Node -->
				<form id="search_box" action="process.php" method="post">
					<input type="hidden" name="action" value="search_text1">
					<label >Select the first node: <input id="search_text" type="text" name="search_text"/></label>
				</form>

				<div id="node_div">
					<table id="node_list">
						<tr class="black">
							<td class="col1">Node</td>
							<td class="col2">Description</td>
							<td class="col3">Type</td>
						</tr>
						<!-- Search results go here -->
					</table>
				</div>

				<!-- Second Node -->
				<form id="search_box2" action="process.php" method="post">
					<input type="hidden" name="action" value="search_text2">
					<label >Select the second node: <input id="search_text" type="text" name="search_text"/></label>
				</form>

				<div id="node_div">
					<table id="node_list2">
						<tr class="black">
							<td class="col1">Node</td>
							<td class="col2">Description</td>
							<td class="col3">Type</td>
						</tr>
						<!-- Search results go here -->
					</table>
				</div>
		
				<div class="connect_div">
					<form id="submit_connect" action="process.php" method="post">
						<input type="hidden" name="action" value="add_connect">
						<label>First node selected: <input id="select_result1" type="text" name="first_node" /></label>
						<br />
						<label>Second node selected: <input id="select_result2" type="text" name="second_node" /></label><br />
						<label class="connect_label">Enter the connection: <input class="connection_text" type="text" name="connect" /></label>


				    	<input type="submit" class="submit_button" value="Submit">
					</form>
				</div>
			</div><!-- End Submit Input -->

			<div class="divider">
			</div>

			<div class="submit_input">
				<h2 class="submit_header">Approve Nodes</h2>

				<form id="vpn" class="float_left" action="process.php" method="post">
					<input type="hidden" name="action" value="view_pending_nodes">
					<input type="submit" class="submit_button" value="View Pending">
				</form>

				<form id="van" class="float_left" action="process.php" method="post">
					<input type="hidden" name="action" value="view_approved_nodes">
					<input type="submit" class="submit_button" value="View Approved">
				</form>

				<form id="change" class="float_right" action="process.php" method="post">
					<input type="hidden" name="action" value="apply_change">
					<input type="submit" class="submit_button" value="Apply">
				</form>

				<div id="node_div2">
					<table id="node_list3">
						<tr class="black">
							<td class="width125">Node</td>
							<td class="width375">Description</td>
							<td class="width50">Type</td>
							<td class="width100">Submitter</td>
							<td class="width100">Email</td>
							<td class="width50">Action</td>
						</tr>
						<!-- Search results go here -->
					</table>
				</div>
			</div>

			<div class="divider">
			</div>

			<div class="submit_input">
				<h2 class="submit_header">Approve Connections</h2>

				<form id="vpc" class="float_left" action="process.php" method="post">
					<input type="hidden" name="action" value="view_pending_connections">
					<input type="submit" class="submit_button" value="View Pending">
				</form>

				<form id="vac" class="float_left" action="process.php" method="post">
					<input type="hidden" name="action" value="view_approved_connections">
					<input type="submit" class="submit_button" value="View Approved">
				</form>
				
				<form id="change" class="float_right" action="process.php" method="post">
					<input type="hidden" name="action" value="apply_change">
					<input type="submit" class="submit_button" value="Apply">
				</form>

				<div id="node_div2">
					<table id="node_list4">
						<tr class="black">
							<td class="width125">Node 1</td>
							<td class="width375">Connection</td>
							<td class="width125">Node 2</td>
							<td class="width100">Submitter</td>
							<td class="width100">Email</td>
							<td class="width50">Action</td>
						</tr>
						<!-- Search results go here -->
					</table>
				</div>
			</div>

		</div><!-- End Main Content Submit -->
</div>
</body>
</html>