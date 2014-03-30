<?php
	session_start();
	require_once('connection.php');


	/////////////////////// Register & Login & Logout ////////////////////////

	function register($connection)
	{

		//clear previous errors
		unset($_SESSION['reg_error']);
		unset($_SESSION['log_error']);
		unset($_SESSION['submit_msg']);
		unset($_SESSION['node_msg']);
		
		//Use b-crypt method to secure password.
		$salt = bin2hex(openssl_random_pseudo_bytes(22));
		$hash = crypt($_POST['password'], $salt);

		if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password']))
			{
				$_SESSION['reg_error']['message']= 'Please complete all registration fields.';
			}
			else
			{
				if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
				{
						$_SESSION['reg_error']['message'] = 'The email address is not valid.';
						// header('Location: submit.php');
						// exit;
				}
				else
				{
					$query = "SELECT email, password
							  FROM submitters
							  WHERE email = '".$_POST['email']."'";
					$result = mysqli_query($connection, $query);
					$row = mysqli_fetch_assoc($result);

					if (!empty($row))
					{
						$_SESSION['reg_error']['message'] = 'The email address ' . $_POST['email'] .
						' has already been registered.  Please log in instead.';
					} 
					else
					{
					 	$query = "INSERT INTO submitters (first_name, last_name, email, password, created_at, updated_at)
								  VALUES ('" . $_POST['first_name'] . "', '" . $_POST['last_name'] ."', '" . $_POST['email'] ."', '" . $hash . "', NOW(), NOW())";
						
					mysqli_query($connection, $query);

					$user_id=mysqli_insert_id($connection);

					$_SESSION['email'] = $_POST['email'];
					$_SESSION['user_id'] = $user_id;
					$_SESSION['first_name'] = $_POST['first_name'];
					$_SESSION['last_name'] = $_POST['last_name'];

					// header('Location: submit.php');
					// exit;
				}
			}
		}
		header('Location: submit.php');
		exit;
	}

	function login($connection,$privilege) {

		//clear previous errors.
		unset($_SESSION['log_error']);
		unset($_SESSION['reg_error']);
		unset($_SESSION['submit_msg']);
		unset($_SESSION['node_msg']);

		if(empty($_POST['email']) || empty($_POST['password']))
			{
			 	$_SESSION['log_error']['message'] = "Please complete all fields";
			 	header('Location: submit.php');
				exit;
			}
			// else
				if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
					{
						$_SESSION['log_error']['message'] = 'The email address is not valid.';
						header('Location: submit.php');
						exit;
					}
					else
					{
						$query = "SELECT id, first_name, last_name, password
								  FROM submitters
								  WHERE email = '".$_POST['email']."'";

						$result = mysqli_query($connection, $query);
						$row = mysqli_fetch_assoc($result);
					 }  
				
			if(empty($row))
			{
				$_SESSION['log_error']['message'] = "Could not find email in database.";
			} 
			else
				if (crypt($_POST['password'], $row['password']) != $row['password'])
				{
					$_SESSION['log_error']['message'] = 'Incorrect password';
				}
			else
			{
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['first_name'] = $row['first_name'];
				$_SESSION['last_name'] = $row['last_name'];

				// header('Location: submit.php');
				// exit;
		}
		if ($privilege == 1) {
			header('Location: admin.php');
		} else {
			header('Location: submit.php'); 
		}
		exit;
	}

	function logout($param) {
		unset($_SESSION['email']);
		unset($_SESSION['user_id']);
		unset($_SESSION['first_name']);
		unset($_SESSION['last_name']);
		unset($_SESSION['log_error']);
		unset($_SESSION['reg_error']);
		unset($_SESSION['password']);
		unset($_SESSION['submit_msg']);
		unset($_SESSION['node_msg']);

		if ($param == 0) {
			header('Location: submit.php');
		} else {
			header('Location: admin.php');
		}
		exit;
	}

	/////////////////////// End Register & Login & Logout ////////////////////////


	function newNode($connection, $pending) {

		//New nodes from admin = 1 (pending = false).
		//Pending nodes from users = 0 (pending = true).

		//Clear session errors
		unset($_SESSION['reg_error']);
		unset($_SESSION['log_error']);
		unset($_SESSION['success_message']);
		unset($_SESSION['submit_msg']);
		unset($_SESSION['node_msg']);

		$node = $_POST['node'];

		if (empty($_SESSION['user_id'])) { 
			$_SESSION['node_msg'] = "Please log in prior to making submissions.";
		} else {

			if(empty($node)) {
				$_SESSION['node_msg'] = "Please complete all fields.";
			};

			$n_descript = $_POST['n_descript'];
			if(empty($n_descript)) {
				$_SESSION['node_msg'] = "Please complete all fields.";
			};
			if(strlen($node)>100) {
				$_SESSION['node_msg'] = "The node name cannot be more than 100 characters.";
			};	

			if (strlen($n_descript) > 255) {
				$_SESSION['node_msg'] = "The node description cannot be more than 255 characters.";
			};
		};

		$type = $_POST['type'];


		if(!isset($_SESSION['node_msg'])) {

			//Save information to database
			//The Mysqli escape strings are necessary for $node and $n_descript so that apostrophes can be entered in by the user.
			$query = "INSERT INTO nexus.nodes (node, description, type, pending, created_at, updated_at, submitters_id)
			VALUES ('".mysqli_real_escape_string($connection, $node)."', '".mysqli_real_escape_string($connection, $n_descript)."', '$type', '$pending', NOW(), NOW(), " . $_SESSION['user_id'] . ")";

			mysqli_query($connection, $query);

			$_SESSION['node_msg']="Thanks for your submission!";
		};

		if($pending == 1) { header('Location: admin.php'); }
		else { header('Location: submit.php'); }
		exit;
	}

	function searchForNode($connection) {

		$data = array();

		$query="SELECT * FROM nexus.nodes
				WHERE node LIKE '" . $_POST['search_text'] . "%'
				ORDER BY node ASC";

		$result = mysqli_query($connection, $query);
		
		$html = NULL;
		$row_count=1;
		//Create the first row of the table.
		$data['html'][0]= '<tr class="black">
								<td class="col1">Node</td>
								<td class="col2">Description</td>
								<td class="col3">Type</td>
							</tr>';
			
		//Add the remaining rows from the database.
		while($row = mysqli_fetch_assoc($result))	  
		{
			$html = '<tr ';

					//highlight the first column
					//and store the data from the top row in a separate array;
					if ($row_count == 1) {
						$html .= 'class="yellow" ';
						$data['first_row']['id']=$row['id'];
						$data['first_row']['node'] = $row['node'];
						$data['first_row']['description'] = $row['description'];
						$data['first_row']['type'] = $row['type'];
					}
					//Add a class of light blue for every other column.
					if ($row_count%2 == 0) { $html .= 'class="light_blue" '; }
					//Add a class of yellow for the first column.
					if ($row_count == 1 ) { $html .= 'class="yellow" '; }

					//Populate rows.
					$html .= '>
						<td class="col1">' . $row['node'] . '</td>
						<td class="col2">' . $row['description'] . '</td>
						<td class="col3">' . $row['type'] . '</td>
					</tr>';

			$row_count = $row_count+1;

			$data['html'][]=$html;
			$_SESSION['node_msg'] = "Thanks for your submission!";
		}
		echo json_encode($data);
	}

	function newConnect($connection,$pending) {

		unset($_SESSION['reg_error']);
		unset($_SESSION['log_error']);
		unset($_SESSION['submit_msg']);
		unset($_SESSION['node_msg']);

		if (empty($_POST['first_node']) || empty($_POST['second_node']) || empty($_POST['connect'])) {
			$_SESSION['submit_msg']="Please complete all fields";
		}
		if (empty($_SESSION['user_id'])) {
			$_SESSION['submit_msg']="Please log in or register to make submissions";
		}
		if (isset($_SESSION['submit_msg'])){
			if($pending == 1) { header('Location: admin.php'); }
			else { header('Location: submit.php'); }
			exit;
		}

		$query1 = "SELECT id as node1 FROM nodes WHERE node = '" . mysqli_real_escape_string($connection, $_POST['first_node']) . "'";
		$result1 = mysqli_query($connection, $query1);
		$row1 = mysqli_fetch_assoc($result1);
		//echo $row1['node1'];

		$query2 = "SELECT id as node2 FROM nodes WHERE node = '" . mysqli_real_escape_string($connection, $_POST['second_node']) . "'";
		$result2 = mysqli_query($connection, $query2);
		$row2 = mysqli_fetch_assoc($result2);
		//echo $row2['node2'];

		$query3 = "INSERT INTO connections (descript, pending, created_at, updated_at, nodes_id1, nodes_id2, submitters_id)
					VALUES ('" . mysqli_real_escape_string($connection, $_POST['connect']) . "', '$pending', NOW(), NOW(), '" . mysqli_real_escape_string($connection, $row1['node1']) ."', '". mysqli_real_escape_string($connection, $row2['node2']) . "', '" . $_SESSION['user_id'] . "')";
		$result3 = mysqli_query($connection, $query3);

		$_SESSION['submit_msg']="Thanks for your submission!";

		if($pending == 1) { header('Location: admin.php'); }
		else { header('Location: submit.php'); }
		exit;
	}

	function searchForConnects($connection) {
		$data = array();

		//Find the node information for whatever is being typed in.
		$query="SELECT nodes.id, nodes.node, nodes.type, nodes.description FROM nexus.nodes
				JOIN connections ON connections.id = nodes.id
				WHERE nodes.node LIKE '" . $_POST['node'] . "%'
				ORDER BY node ASC";

		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($result);
		$data['node_name']=$row['node'];
		$data['names'][0]=$row['node'];
		$data['node_description']=$row['description'];
		$data['node_type']=$row['type'];
		$data['node_id']=$row['id'];

		while($row = mysqli_fetch_assoc($result)){
		 	$data['names'][]=$row['node'];
		}
		
		//This returns a list of all Nodes_Id2's and their descriptions that belong to the selected node:
		$query2 = "SELECT nodes_id2, nodes.node, nodes.description
					 FROM nexus.nodes
					 JOIN connections ON connections.nodes_id2 = nodes.id
					 WHERE nodes_id1 = " . $data['node_id'] . " ";

		//This returns a list of all Nodes_Id1's and their descriptions that belong to the selected node:
		$query3 = "SELECT nodes_id1, nodes.node, nodes.description
				   FROM nexus.nodes
				   JOIN connections ON connections.nodes_id1 = nodes.id
				   WHERE nodes_id2 = " . $data['node_id'] . " ";

		$result1 = mysqli_query($connection, $query2);
		$result2 = mysqli_query($connection, $query3);
		$connect_results = NULL;

		 //Dump the results of the two queries into a single array
		 while($row = mysqli_fetch_assoc($result1)){
		 	$connect_results[]=array("node"=>$row['node'],"description"=>$row['description']);
		 }
		 while($row = mysqli_fetch_assoc($result2)){
		 	$connect_results[]=array("node"=>$row['node'],"description"=>$row['description']);
		 }

		if($connect_results!=NULL) {sort($connect_results);}

		 //Take all the connecions and put them into table row format.
		$html = NULL;
		$row_count=1;

		//Create the first row of the table.
		$data['html'][0]= '<tr class="black centered">
								<td class="col1">Related Node</td>
								<td class="col2">Description</td>
							</tr>';
			
		//Add the remaining rows from the database.
		$loop_count = count($connect_results);

		for ($i=0; $i<$loop_count; $i++)	  
		{		
			$html = '<tr ';

					//Add a class of light blue for every other column.
					if ($row_count%2 == 0) { $html .= 'class="lblue" '; }
					if ($row_count%2 != 0) { $html .= 'class="lyellow" '; }

					//Populate rows.
					$html .= '>
						<td class="col1">' . $connect_results[$i]['node'] . '</td>
						<td class="col2">' . $connect_results[$i]['description'] . '</td>
					</tr>';

			$row_count = $row_count+1;

			$data['html'][]=$html;
		}

		echo json_encode($data);
	}

	function listNodes($connection,$pending) {

		$data=array();
		$row_count=0;
		
		$query='SELECT node, description, type, first_name, last_name, email
				FROM nexus.nodes
				JOIN submitters ON submitters.id = submitters_id
				WHERE pending = '. $pending .'';


		$result = mysqli_query($connection, $query);

		$data['html'][0]= '<tr class="black">
								<td class="width125">Node</td>
								<td class="width375">Description</td>
								<td class="width50">Type</td>
								<td class="width100">Submitter</td>
								<td class="width100">Email</td>
								<td class="width50">Action</td>
							</tr>';

		while($row = mysqli_fetch_assoc($result)){
			if ($row_count%2 != 0) { 
				$data['html'][]= '<tr class="light_blue">
									<td class="width125">' . $row['node'] . '</td>
									<td class="width375">' . $row['description'] . '</td>
									<td class="width50">' . $row['type'] . '</td>
									<td class="width100">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
									<td class="width100">' . $row['email'] . '</td>
									<td class="width50"><input type="submit" class="submit_button" value="Approve"></td>
								</tr>';
			} else {
				$data['html'][]= '<tr>
									<td class="width125">' . $row['node'] . '</td>
									<td class="width375">' . $row['description'] . '</td>
									<td class="width50">' . $row['type'] . '</td>
									<td class="width100">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
									<td class="width100">' . $row['email'] . '</td>
									<td class="width50"><input type="submit" class="submit_button" value="Approve"></td>
								</tr>';
			}
			$row_count = $row_count+1;
		}

		echo json_encode($data);

	}

	function listConnects($connection,$pending) {
		$combined = array();
		$data = array();
		$row_count = 0;

		$node1_query = 'SELECT node
						FROM connections 
						JOIN nodes ON nodes.id = connections.nodes_id1
						WHERE connections.pending = '. $pending .'';

		$node2_query = 'SELECT node
						FROM connections 
						JOIN nodes ON nodes.id = connections.nodes_id2
						WHERE connections.pending = '. $pending .'';

		$connect_query = 'SELECT descript, first_name, last_name, email
						  FROM connections
						  JOIN submitters on submitters.id = submitters_id
						  WHERE pending = '. $pending .'';

		$result1 = mysqli_query($connection, $node1_query);
		$result2 = mysqli_query($connection, $node2_query);
		$result3 = mysqli_query($connection, $connect_query);

		//Combine the three queries
		while($row1=mysqli_fetch_assoc($result1)){
			$row2=mysqli_fetch_assoc($result2);
			$row3=mysqli_fetch_assoc($result3);

			  $combined[$row_count]['node1'] = $row1['node'];
			  $combined[$row_count]['descript'] = $row3['descript'];
			  $combined[$row_count]['node2'] = $row2['node'];
			  $combined[$row_count]['first_name'] = $row3['first_name'];
			  $combined[$row_count]['last_name'] = $row3['last_name'];
			  $combined[$row_count]['email'] = $row3['email'];

			  $row_count = $row_count + 1;
		}

		$loop_count = count($combined);

		//Set table header
		$data['html'][0]= '<tr class="black">
						<td class="width125">Node</td>
						<td class="width375">Description</td>
						<td class="width125">Type</td>
						<td class="width100">Submitter</td>
						<td class="width100">Email</td>
						<td class="width50">Action</td>
					</tr>';

		//Convert combined array into html
		for ($i=0; $i<$loop_count; $i++) {

			if ($i%2 != 0) {
			$data['html'][] = 	'<tr class="light_blue">
									<td class="width125">'. $combined[$i]['node1'] .'</td>
									<td class="width375">'. $combined[$i]['descript'] .'</td>
									<td class="width125">'. $combined[$i]['node2'] .'</td>
									<td class="width100">'. $combined[$i]['first_name'] . ' ' . $combined[$i]['last_name']  . '</td>
									<td class="width100">'. $combined[$i]['email'] .'</td>
									<td class="width50"><input type="submit" class="submit_button" value="Approve"></td>
								</tr>';
			} else {
			$data['html'][] = 	'<tr>
									<td class="width125">'. $combined[$i]['node1'] .'</td>
									<td class="width375">'. $combined[$i]['descript'] .'</td>
									<td class="width125">'. $combined[$i]['node2'] .'</td>
									<td class="width100">'. $combined[$i]['first_name'] . ' ' . $combined[$i]['last_name']  . '</td>
									<td class="width100">'. $combined[$i]['email'] .'</td>
									<td class="width50"><input type="submit" class="submit_button" value="Approve"></td>
								</tr>';
			}

		}

		echo json_encode($data);
	}

	//////////////////////////  Function Calls ///////////////////////////

	if(isset($_POST['action']) && $_POST['action'] == 'login') {
		login($connection, 0);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'login_admin') {
		login($connection, 1);
	}

	if (isset($_GET['logout']))
	{
		if ($_GET['logout'] ==  0) {
			logout(0);
		} else {
			logout(1);
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'register') {
		register($connection);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'add_node') {
		newNode($connection, 1);
		//New nodes from admin = 1 (pending = false).
	}

	if(isset($_POST['action']) && $_POST['action'] == 'submit_node') {
		newNode($connection, 0);
		//Pending nodes from users = 0 (pending = true).
	}

	if(isset($_POST['action']) && $_POST['action'] == 'add_connect') {
		newConnect($connection, 1);
		//New connections from admin = 1 (pending = false).
	}

	if(isset($_POST['action']) && $_POST['action'] == 'submit_connect') {
		newConnect($connection, 0);
		//Pending connections from admin = 0 (pending = true).
	}

	if(isset($_POST['action']) && $_POST['action'] == 'search_text1') {
		// Additional code allows clearing of table if nothing entered.
		if ($_POST['search_text'] != '') {
			searchForNode($connection);
		} else {
			$data = '';
			echo json_encode($data);
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'search_text2') {
		// Additional code allows clearing of table if nothing entered.
		if ($_POST['search_text'] != '') {
			searchForNode($connection);
		} else {
			$data = '';
			echo json_encode($data);
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'node_view') {

		// Additional code allows clearing of table if nothing entered.
		if ($_POST['node'] != '') {
			searchForConnects($connection);
		} else {
			$data = '';
			echo json_encode($data);
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == 'view_pending_nodes') {
		listNodes($connection,0);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'view_approved_nodes') {
		listNodes($connection,1);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'view_pending_connections') {
		listConnects($connection,0);
	}

	if(isset($_POST['action']) && $_POST['action'] == 'view_approved_connections') {
		listConnects($connection,1);
	}



?>
