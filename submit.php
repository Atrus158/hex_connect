<?php
	session_start();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>The Connection Game</title>
	<meta name="description" content="Submit nodes and connections for the connection game."/>
	<link rel="stylesheet" type="text/css" href="connect_style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript">

		$(window).load(function()
		{		
			//Turn the login box red if someone attempts to submit a node without registering first.
			$("#node_name2").on("keyup submit",function() {
				$('#login_msg').html('<div class="login_errors"><p>Please log in or register to make submissions</p></div>');
	            return false;
	        });
	        $("#node_descript").on("keyup submit",function() {
				$('#login_msg').html('<div class="login_errors"><p>Please log in or register to make submissions</p></div>');
	            return false;
	        });

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
	    });
	</script>
</head>
<body class="submit_body">
<div class="wrapper">
	<?php
		include('nav_bar.php');
	?>
	<div class="main_content_submit">
		<div class="login">
			<?php
			if (isset($_SESSION['email'])) {
				echo 'You are currently logged in under ' . $_SESSION['email'] . '.<br />';
				echo '<a href="process.php?logout=0">Logout</a>';
			} else {
				echo 	'<div class="login_blocks">
					  		<span>Register</span>
					  		<form class="form_indented" action="process.php" method="post">
								<input type="hidden" name="action" value="register">
								<input type="text" name="first_name" placeholder="First Name">
								<input type="text" name="last_name" placeholder="Last Name">
								<input type="email" name="email" placeholder="Email Address">
								<input type="password" name="password" placeholder="Password">
						    	<input type="submit" value="Register" class="width123 submit_button">
						    </form>
					    </div>
					    <div id="login_msg" class="login_blocks login_message">';
							
							if (isset($_SESSION['log_error']['message'])) {
								echo 	'<div class="login_errors">
											<p>' . $_SESSION['log_error']['message'] . '</p>
										</div>';
							}
							if (isset($_SESSION['reg_error']['message'])) {
								echo 	'<div class="login_errors">
											<p>' . $_SESSION['reg_error']['message'] . '</p>
										</div>';
							}
							if (!isset($_SESSION['log_error']['message']) AND !isset($_SESSION['reg_error']['message'])) {
								echo 	'<div class="login_errors blue">
											<p>Please register or log in to make submissions</p>
										</div>';
							}
					
					echo'</div>
					    <div class="login_blocks login_login">
							<span>Log in</span>
							<form class="form_indented" action="process.php" method="post">
								<input type="hidden" name="action" value="login">
								<input type="text" name="email" placeholder="Email Address">
								<input type="password" name="password" placeholder="Password">
						    	<input type="submit" value="Log in" class="width123 submit_button">
							</form>
						</div>';
			}
			?>
		</div><!-- End Login section -->

		<div class = "submit_input">

			<h2 class="submit_header">Submit a New Node</h2>
			<form class="admin_add" action="process.php" method="post">
				<input type="hidden" name="action" value="submit_node">
				
				<label>Node Name:</label>
				<input id="node_name2" type="text" class="node_name" name="node" />
				<label>Node Description:</label>
				<input id="node_descript" type="textarea" rows="3" columns="5" class="node_description" name="n_descript" />

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

			<?php
				if (isset($_SESSION['node_msg'])){
					echo '<div class="sub_msg ';
					if ($_SESSION['node_msg']=="Thanks for your submission!") {
						echo 'green"';
					} else {
						echo '"';
					}
					echo '>' . $_SESSION['node_msg'] . '</div>';
				}
			?>

		</div><!-- End submit input -->
		<div class="divider">
		</div>

			<div class="submit_input">
				<h2 class="submit_header">Submit a New Connection</h2>
				<span>A connection must connect two existing nodes. If a node does not exist,</span><br />
				<span>you will need to submit it above before it can be connected to another node.</span>

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
						<input type="hidden" name="action" value="submit_connect">
						<span>Use the options above to select nodes.</span><br />
						<label>First node selected: <input id="select_result1" type="text" name="first_node" readonly/></label>
						<br />
						<label>Second node selected: <input id="select_result2" type="text" name="second_node" readonly/></label><br />
						<label class="connect_label">Enter the connection: <input class="connection_text" type="text" name="connect" /></label>

				    	<input type="submit" class="submit_button" value="Submit">
					</form>
				</div>

				<?php
					if (isset($_SESSION['submit_msg'])){
						echo '<div class="sub_msg ';
						if ($_SESSION['submit_msg']=="Thanks for your submission!") {
							echo 'green"';
						} else {
							echo '"';
						}
						echo '>' . $_SESSION['submit_msg'] . '</div>';
					}
				?>
			</div><!-- End Submit Input -->
			<div class="footer_text">
				<p>If you have submitted new nodes and/or connections, thank you!  All nodes and connections are reviewed prior
					to being added to the database.  The only thing that keeps this project from getting completely out of control
					is that I limit it to topics I like, so if I don't add any suggestions to the database, it is probably because they
					don't correspond with my interests.</p>
			</div>
		</div><!-- End Main Content Submit -->
</div>
</body>
</html>