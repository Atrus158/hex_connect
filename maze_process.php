<?php
	require_once('connection.php');
	include_once('maze_class.php');

	if(isset($_POST['action']) && $_POST['action'] == 'reset') {

		unset($_SESSION['hex']);
		unset($_SESSION['node']);
		$new_maze = new hexMaze($maze_hex);
		$new_maze->buildMaze($connection, true);
		//header('Location: home.php');
		//exit;
	}

	if(isset($_POST['action']) && $_POST['action'] == 'create_regular_maze') {
		
		unset($_SESSION['hex']);
		$maze_maze = new hexMaze($maze_hex);
		$maze_maze->buildMaze($connection, false);
		header('Location: maze.php');
		exit;
	}

	if(isset($_POST['action']) && $_POST['action'] == 'hex_click') {
		
		$first_node = $_POST['first_node'];
		$second_node = $_POST['second_node'];
		//$connected = false;
		$connected = array();
		$connected['boolean'] = false;
		$connected['describe_connect'] = '';
		$connected['node1'] = 'node1';
		$connected['node2'] = 'node2';

		//Pull all nodes connected to the current one.
		$query = "SELECT * FROM nexus.connections
			      WHERE nodes_id1 = $first_node OR nodes_id2 = $first_node";

		//See if the selected node id matches the current one.
		$result = mysqli_query($connection, $query);
		if (empty($result)) { 
			$connected['boolean'] = false; 
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				if ($first_node == $row['nodes_id1'] AND $second_node == $row['nodes_id2']) { $connected['boolean'] = true; } 
				if ($first_node == $row['nodes_id2'] AND $second_node == $row['nodes_id1']) { $connected['boolean'] = true; }
				if ($connected['boolean'] == true) { 
						$connected['describe_connect'] = $row['descript'];
						$connected['node1'] = $row['nodes_id1'];
						$connected['node2'] = $row['nodes_id2'];
						break;
				}
			}
		}

		if ($first_node == $second_node) { $connected['boolean'] = true; }

		echo json_encode($connected);

	}
	

	// if(isset($_GET['hex_array']))
	// {
		//If you var dump anything here, it will show up in the network tab in Chrome
		//but there won't be a page redirect, and the var dump won't show up on the page
		//because this is being handled with AJAX.
	// 	$new_maze = new hexMaze($maze_hex);
	// 	$new_maze->buildMaze($connection, true);
	// }
?>
