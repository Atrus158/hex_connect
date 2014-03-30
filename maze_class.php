<?php
session_start();

require_once('hexagons.php');

class hexMaze {
	
	public $hex = array();

	// The hexes_filled array records every hex that is added to the maze.
	// It is then used to check if the maze is full
	// and to find new spots in the maze to continue from.
	public $hexes_filled = array();

	public function __construct($hex_array) {
		$this->hex = $hex_array;
	}

	public function buildMaze($connection,$ajax_status) {

		$maze_complete = false;
		$start_new_path = false;
		$random_num = 0;
		$random_hex = array();

		//Create paths until the maze is complete.
		while ($maze_complete == false) {

			if (count($this->hexes_filled) == 0) {

				//Set up starting conditions in the center hexagon.
				$new_start_hex = 31;
				//Get node id and assign it.
				$new_node_id = $this->findRandomNodeId($connection);
				$this->hex[$new_start_hex]->node_id = $new_node_id;
				//Get node name and assign it.
				$node_name = $this->getNodeNameById($connection, $new_node_id);
				$this->hex[$new_start_hex]->node_name = $node_name;

				$current_hex = $this->hex[$new_start_hex];
				$this->hexes_filled[0]=$new_start_hex;

				//Add node info to start hex.
				$this->addNodeInfo($connection, $new_start_hex, $new_node_id);

			} else {
				$new_start_hex = $this->findNewStart();
				//echo 'New start is :' . $new_start_hex . '<br />';
			}

			$this->buildPath($connection, $this->hex[$new_start_hex], $this->hex[$new_start_hex]->node_id);

			//Check to see if the maze is complete.
			if (count($this->hexes_filled) == 61) {
				$maze_complete = true;


				$json_hex = $this->hex;
				// echo json_encode($json_hex);
				// $my_array = json_encode($json_hex);
				if ($ajax_status == true) {
					echo json_encode($json_hex);
				}
				
				//echo 'The maze is done!';
			}
		}
	}//End buildMaze function.

	public function findNewStart(){

		$hexToTry = 0;

		//Working backward from the end of the path,
		//find a cell that isn't a dead end, and continue from there.
		for ($a=(count($this->hexes_filled)-2); $a>0; $a--) {

			$hexToTry = $this->hexes_filled[$a];
			//echo 'hex to try = ' . $hexToTry . '<br />';

			if ($this->checkForDeadEnd($this->hex[$hexToTry]) == false) {
				$hexToStart = $hexToTry;
				return $hexToStart;
				break;
			}
		}
	}

	public function buildPath($connection, $cur_hex) {

		$wayBlocked = false;

		while ($wayBlocked == false) {


			//Get the node id associated with the current hexagon.
			$cur_id = $cur_hex->node_id;

			//Check to see if the path has reached a dead end.
			//Do I need to do this before and after each cell selection?
			//$wayBlocked = $this->checkForDeadEnd($cur_hex);
			if ($this->checkForDeadEnd($cur_hex) == true) { $wayBlocked = true; }
			if ($wayBlocked == true) { break; }

			//Pick the next cell in the maze and go there.
			$result = $this->pickNextCellAndGo($cur_hex);

			//Pick the node info for the next cell, 
			//apply it to the hex object,
			//and display it.
			$this->addNodeInfo($connection, $result, $cur_id);

			//echo 'Cell: ' . $result . '</br >';

			//Record cells from path into array.
			$this->hexes_filled[]=$result;
			//echo 'Hex array has ' . count($this->hexes_filled) . ' entries.<br />' ;

			//Update current hex
			$cur_hex = $this->hex[$result];

			//Check to see if the path has reached a dead end.
			if ($this->checkForDeadEnd($cur_hex) == true) { $wayBlocked = true; }

			//Stop if the maze is complete.
			if (count($this->hexes_filled) == 91) { $wayBlocked = true; }
			//echo 'wayBlocked2: ' . $wayBlocked;
		}
	}

	public function checkForDeadEnd($cur_hex) {

		$blocked = false;
		$block_counter = 0;
		$check_array = array();

		$check_array = $this->availableDirects($cur_hex);

		foreach ($check_array AS $value) {
			if ($value == true) { $block_counter = $block_counter + 1; }
		}

		if ($block_counter == 6) { $blocked = true; }

		//Keep for testing.
		//if ($blocked == true) {echo 'Blocked is true. <br />';}

		return $blocked;
	}

	public function availableDirects($cur_hex) {

		$cellsBlocked = array(0,0,0,0,0,0);

		$hexToCheck = $cur_hex->ne;
		if ($hexToCheck != 0 AND $this->hex[$hexToCheck]->side_count < 63) { $cellsBlocked[0]=1; }
		if ($hexToCheck == 0) { $cellsBlocked[0]=1; }

		$hexToCheck = $cur_hex->e;	
		if ($hexToCheck != 0 AND $this->hex[$hexToCheck]->side_count < 63) { $cellsBlocked[1]=1; }
		if ($hexToCheck == 0) { $cellsBlocked[1]=1; }

		$hexToCheck = $cur_hex->se;
		if ($hexToCheck != 0 AND $this->hex[$hexToCheck]->side_count < 63) { $cellsBlocked[2]=1; }
		if ($hexToCheck == 0) { $cellsBlocked[2]=1; }

		$hexToCheck = $cur_hex->sw;
		if ($hexToCheck != 0 AND $this->hex[$hexToCheck]->side_count < 63) { $cellsBlocked[3]=1; }
		if ($hexToCheck == 0) { $cellsBlocked[3]=1; }

		$hexToCheck = $cur_hex->w;
		if ($hexToCheck != 0 AND $this->hex[$hexToCheck]->side_count < 63) { $cellsBlocked[4]=1; }
		if ($hexToCheck == 0) { $cellsBlocked[4]=1; }

		$hexToCheck = $cur_hex->nw;
		if ($hexToCheck != 0 AND $this->hex[$hexToCheck]->side_count < 63) { $cellsBlocked[5]=1; }
		if ($hexToCheck == 0) { $cellsBlocked[5]=1; }

		return $cellsBlocked;
	}

	public function pickNextCellAndGo($cur_hex) {

		$direction = 0;
		$nextCell = 0;
		$directChose = true;
		$directArray = array();
		$total_options = 0;
		$counter = 0;
		$option_counter = 0;
		$options = array(false, false, false, false, false, false);
		$choice = 0;

		//Find all available directions from the current cell.
		$directArray = $this->availableDirects($cur_hex);

		//Count the number of available directions.
		//Fill the options array with true if that option (direction) is available.;
		foreach ($directArray AS $value) {
			if ($value == 0) {
				$total_options = $total_options+1;
				$options[$counter]=true;
			}
			$counter = $counter+1;
		}

		//Pick a random number based on the number of available directions.
		//From 0 to 5 (for 6 options) and so on.
		$choice = rand(0,$total_options-1);
		//echo 'Choice: ' . $choice . '<br />';

		//Assign a direction based on the random number picked
		//using only the available directions.
		$option_counter = 0;
		foreach ($options AS $key=>$value) {
			//if ($value !=true) { $option_counter = $option_counter + 1;}
			if ($value == true) {
				if ($option_counter==$choice){
					$direction = $key;
				} 
				$option_counter = $option_counter + 1;
			}
		}	

		//echo 'Direction chosen: ' . $direction . '<br /><br />';

		switch ($direction) {
			case 0:
			$nextCell = $cur_hex->ne;
			break;

			case 1:
			$nextCell = $cur_hex->e;
			break;

			case 2:
			$nextCell = $cur_hex->se;
			break;
			
			case 3:
			$nextCell = $cur_hex->sw;
			break;
			
			case 4:
			$nextCell = $cur_hex->w;
			break;
			
			case 5:
			$nextCell = $cur_hex->nw;
			break;
		}

		//Break walls
		switch ($direction) {
			case 0:
			$cur_hex->side_count = $cur_hex->side_count - 1;
			$this->hex[$nextCell]->side_count = ($this->hex[$nextCell]->side_count - 8);
			break;

			case 1:
			$cur_hex->side_count = $cur_hex->side_count - 2;
			$this->hex[$nextCell]->side_count = ($this->hex[$nextCell]->side_count - 16);
			break;

			case 2:
			$cur_hex->side_count = $cur_hex->side_count - 4;
			$this->hex[$nextCell]->side_count = ($this->hex[$nextCell]->side_count - 32);
			break;
			
			case 3:
			$cur_hex->side_count = $cur_hex->side_count - 8;
			$this->hex[$nextCell]->side_count = ($this->hex[$nextCell]->side_count - 1);
			break;
			
			case 4:
			$cur_hex->side_count = $cur_hex->side_count - 16;
			$this->hex[$nextCell]->side_count = ($this->hex[$nextCell]->side_count - 2);
			break;
			
			case 5:
			$cur_hex->side_count = $cur_hex->side_count - 32;
			$this->hex[$nextCell]->side_count = ($this->hex[$nextCell]->side_count - 4);
			break;
		}	

		$_SESSION['hex'][$cur_hex->maze_loc]=$cur_hex->side_count;
		//echo 'session value recorded: ' . $_SESSION['hex'][$cur_hex->maze_loc] . '<br />';
		$_SESSION['hex'][$nextCell] = $this->hex[$nextCell]->side_count;

		return $nextCell;
	}//End pickNextCellAndGo function.

	public function addNodeInfo($connection, $next_cell, $cur_node_id) {

		$chosen_node = 0;

		//Query the database for the id of the next node.
		$node_query = "SELECT * FROM nexus.connections
					   WHERE nodes_id1 = $cur_node_id OR nodes_id2 = $cur_node_id AND pending = 1
					   ORDER BY RAND() LIMIT 0,1";

		//echo $node_query;

		$result = mysqli_query($connection, $node_query);
		$row = mysqli_fetch_assoc($result);


		//The $query returns 2 node id's.
		//One should match the node id that was entered in the query,
		//so we need to pick the other one.
		$node1 = $row['nodes_id1'];
		$node2 = $row['nodes_id2'];

		if ($cur_node_id == $node1) {
			$chosen_node = $node2;
		} else {
			$chosen_node = $node1;
		}

		//Assign the node id to the current hex.
		$this->hex[$next_cell]->node_id = $chosen_node;

		//echo 'Node Id: ' . $this->hex[$next_cell]->node_id . '<br />';

		//Get the node name based on the node id.
		$node_name = $this->getNodeNameById($connection, $chosen_node);
		//echo 'Node Name: ' $node_name . '<br />';

		//Assign the node name to the current hex.
		$this->hex[$next_cell]->node_name = $node_name;
		
		//Display the node info on the maze.
		$position = $this->hex[$next_cell]->maze_loc;
		$_SESSION['node'][$position] = $node_name;

		//Get the node description based on the Id and add it to the hex array.
		$node_desc = $this->getNodeDescById($connection, $chosen_node);
		$this->hex[$next_cell]->node_desc = $node_desc;

	}

	public function findRandomNodeId($connection) {
		
		//Find a random node, but make sure it has at least one connection.
		$test_row = null;
		
		while ($test_row == null) {
			$query = "SELECT * FROM nexus.nodes
					  WHERE pending = 1
				      ORDER BY RAND() LIMIT 0,1";

			$result = mysqli_query($connection, $query);
			$row = mysqli_fetch_assoc($result);
			$possible_id = $row['id'];

			$node_query = "SELECT * FROM nexus.connections
				   WHERE nodes_id1 = $possible_id OR nodes_id2 = $possible_id AND pending = 1
				   ORDER BY RAND() LIMIT 0,1";

			$test_result = mysqli_query($connection, $node_query);
			$test_row = mysqli_fetch_assoc($test_result);
		}
		return $row['id'];
	}

	public function getNodeNameById($connection, $node_id) {
		
		//This shouldn't need the pending qualification
		//because it is handled when the node is selected.
		$query = "SELECT * FROM nexus.nodes
				  WHERE id = $node_id";

		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($result);

		return $row['node'];
	}

	public function getNodeDescById($connection, $node_id) {

		//This shouldn't need the pending qualification
		//because it is handled when the node is selected.
		$query = "SELECT * FROM nexus.nodes
				  WHERE id = $node_id";

		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($result);

		return $row['description'];
	}

	public function confirmConnectedHex($connection, $current_node_id, $node_to_check) {

		$connected = false;

		//Pull all nodes connected to the current one.
		$query = "SELECT * FROM nexus.connections
			      WHERE nodes_id1 = $current_node_id OR nodes_id2 = $current_node_id AND pending = 1";

		//See if the selected node id matches the current one.
		$result = mysqli_query($connection, $query);
		if (empty($result)) { 
			$connected = false; 
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				if ($current_node_id == $row['nodes_id1'] AND $node_to_check == $row['nodes_id2']) { $connected = true; }
				if ($current_node_id == $row['nodes_id2'] AND $node_to_check == $row['nodes_id1']) { $connected = true; }
			}
		}

		if ($current_node_id == $node_to_check) { $connected = true; }

		return $connected;
		//echo json_encode($connected);
	}

} //End the hexMaze class.

?>