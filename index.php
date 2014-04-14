<?php
session_start();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>The Connection Game</title>
	<meta name="description" content="The connection game: a maze based loosely on the six degrees of separation concept."/>
	<link rel="stylesheet" type="text/css" href="connect_style.css">

	<script src="js/jquery-1.10.2.js"></script>
	<script src="nexus.js"></script>
</head>

<body class="index_body">
<div class="wrapper">
	<?php
		include('nav_bar.php');
	?>
	<form id="nodes_info" class="hex" action="maze_process.php" method="post">
		<input type="hidden" name="action" value="hex_click">
		<input id="first_node" type="hidden" name="first_node" value="0">
		<input id="second_node" type="hidden" name="second_node" value="0">
	</form>
	
	<div class="main_content">
		<div class="header">
			<h2 class="main_header">The Connection Game</h2>
			<span>Your goal: make it from the yellow hexagon to the red hexagon.</span> 
			<ul class="rules">
				<li>Click "Start New Game" to populate the grid.</li>
				<li>Your position is indicated by the yellow hexagon.</li>
				<li>Each hexagon contains a subject (called a node).</li>
				<li>Each node connects to one or more of the nodes around it.</li>
				<li>Click on any node to find out more about it.</li>
				<li>Follow the connections to find your way.</li>
				<li>You many have to backtrack.</li>
			</ul>
		</div>

		<div class="playing_area">

			<div id="hover_display" class="hover_display_box" onClick="alert('Hello');">
				<!-- Used to show display of node info on mouseover -->
			</div>

			<div class="hex_grid">
				<!-- Row 1 -->
				<div id="node1" class="hex_text r1 c6" onClick='hexReact(1)' onMouseOver='displayBox("r1","c6",1)'  onMouseOut='hideBox(1)'>
				</div>

				<div class="hex r1 c6" >
					<img id="1" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap1" />
				</div>

				<div id="node2" class="hex_text r1 c8" onClick='hexReact(2)' onMouseOver='displayBox("r1","c8",2)' onMouseOut='hideBox(2)'>
				</div> 
				<div class="hex r1 c8">
					<img id="2" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap2" />
				</div>

				<div id="node3" class="hex_text r1 c10" onClick='hexReact(3)' onMouseOver='displayBox("r1","c10",3)' onMouseOut='hideBox(3)'>
				</div> 
				<div class="hex r1 c10">
					<img id="3" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap3" />
				</div>

				<div id="node4" class="hex_text r1 c12" onClick='hexReact(4)' onMouseOver='displayBox("r1","c12",4)' onMouseOut='hideBox(4)'>
				</div> 
				<div class="hex r1 c12">
					<img id="4" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap4" />
				</div>

				<div id="node5" class="hex_text r1 c14" onClick='hexReact(5)' onMouseOver='displayBox("r1","c14",5)' onMouseOut='hideBox(5)'>
				</div> 
				<div class="hex r1 c14">
					<img id="5" class="hex_img" src="images/hex_re_bevel.png" usemap="#hexmap5" />
				</div>


				<!-- Row 2 -->
				<div id="node6" class="hex_text r2 c5" onClick='hexReact(6)' onMouseOver='displayBox("r2","c5",6)' onMouseOut='hideBox(6)'>
				</div> 
				<div class="hex r2 c5">
					<img id="6" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap6" />
				</div>

				<div id="node7" class="hex_text r2 c7" onClick='hexReact(7)' onMouseOver='displayBox("r2","c7",7)' onMouseOut='hideBox(7)'>
				</div> 
				<div class="hex r2 c7">
					<img id="7" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap7" />
				</div>

				<div id="node8" class="hex_text r2 c9" onClick='hexReact(8)' onMouseOver='displayBox("r2","c9",8)' onMouseOut='hideBox(8)'>
				</div> 
				<div class="hex r2 c9">
					<img id="8" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap8" />
				</div>

				<div id="node9" class="hex_text r2 c11" onClick='hexReact(9)' onMouseOver='displayBox("r2","c11",9)' onMouseOut='hideBox(9)'>
				</div> 
				<div class="hex r2 c11">
					<img id="9" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap9" />
				</div>

				<div id="node10" class="hex_text r2 c13" onClick='hexReact(10)' onMouseOver='displayBox("r2","c13",10)' onMouseOut='hideBox(10)'>
				</div> 
				<div class="hex r2 c13">
					<img id="10" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap10" />
				</div>

				<div id="node11" class="hex_text r2 c15" onClick='hexReact(11)' onMouseOver='displayBox("r2","c15",11)' onMouseOut='hideBox(11)'>
				</div> 
				<div class="hex r2 c15">
					<img id="11" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap11" />
				</div>

				<!-- Row 3 -->
				<div id="node12" class="hex_text r3 c4" onClick='hexReact(12)' onMouseOver='displayBox("r3","c4",12)' onMouseOut='hideBox(12)'>
				</div> 
				<div class="hex r3 c4">
					<img id="12" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap12" />
				</div>

				<div id="node13" class="hex_text r3 c6" onClick='hexReact(13)' onMouseOver='displayBox("r3","c6",13)' onMouseOut='hideBox(13)'>
				</div> 
				<div class="hex r3 c6">
					<img id="13" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap13" />
				</div>

				<div id="node14" class="hex_text r3 c8" onClick='hexReact(14)' onMouseOver='displayBox("r3","c8",14)' onMouseOut='hideBox(14)'>
				</div> 
				<div class="hex r3 c8">
					<img id="14" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap14" />
				</div>

				<div id="node15" class="hex_text r3 c10" onClick='hexReact(15)' onMouseOver='displayBox("r3","c10",15)' onMouseOut='hideBox(15)'>
				</div> 
				<div class="hex r3 c10">
					<img id="15" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap15" />
				</div>

				<div id="node16" class="hex_text r3 c12" onClick='hexReact(16)' onMouseOver='displayBox("r3","c12",16)' onMouseOut='hideBox(16)'>
				</div> 
				<div class="hex r3 c12">
					<img id="16" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap16" />
				</div>

				<div id="node17" class="hex_text r3 c14" onClick='hexReact(17)' onMouseOver='displayBox("r3","c14",17)' onMouseOut='hideBox(17)'>
				</div> 
				<div class="hex r3 c14">
					<img id="17" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap17" />
				</div>

				<div id="node18" class="hex_text r3 c16" onClick='hexReact(18)' onMouseOver='displayBox("r3","c16",18)' onMouseOut='hideBox(18)'>
				</div> 
				<div class="hex r3 c16">
					<img id="18" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap18" />
				</div>

				<!-- Row 4 -->
				<div id="node19" class="hex_text r4 c3" onClick='hexReact(19)' onMouseOver='displayBox("r4","c3",19)' onMouseOut='hideBox(19)'>
				</div> 
				<div class="hex r4 c3">
					<img id="19" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap19" />
				</div>

				<div id="node20" class="hex_text r4 c5" onClick='hexReact(20)' onMouseOver='displayBox("r4","c5",20)' onMouseOut='hideBox(20)'>
				</div> 
				<div class="hex r4 c5">
					<img id="20" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap20" />
				</div>

				<div id="node21" class="hex_text r4 c7" onClick='hexReact(21)' onMouseOver='displayBox("r4","c7",21)' onMouseOut='hideBox(21)'>
				</div> 
				<div class="hex r4 c7">
					<img id="21" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap21" />
				</div>

				<div id="node22" class="hex_text r4 c9" onClick='hexReact(22)' onMouseOver='displayBox("r4","c9",22)' onMouseOut='hideBox(22)'>
				</div> 
				<div class="hex r4 c9">
					<img id="22" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap22" />
				</div>

				<div id="node23" class="hex_text r4 c11" onClick='hexReact(23)' onMouseOver='displayBox("r4","c11",23)' onMouseOut='hideBox(23)'>
				</div> 
				<div class="hex r4 c11">
					<img id="23" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap23" />
				</div>

				<div id="node24" class="hex_text r4 c13" onClick='hexReact(24)' onMouseOver='displayBox("r4","c13",24)' onMouseOut='hideBox(24)'>
				</div> 
				<div class="hex r4 c13">
					<img id="24" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap24" />
				</div>

				<div id="node25" class="hex_text r4 c15" onClick='hexReact(25)' onMouseOver='displayBox("r4","c15",25)' onMouseOut='hideBox(25)'>
				</div> 
				<div class="hex r4 c15">
					<img id="25" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap25" />
				</div>

				<div id="node26" class="hex_text r4 c17" onClick='hexReact(26)' onMouseOver='displayBox("r4","c17",26)' onMouseOut='hideBox(26)'>
				</div> 
				<div class="hex r4 c17">
					<img id="26" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap26" />
				</div>

				<!-- Row 5 -->
				<div id="node27" class="hex_text r5 c2" onClick='hexReact(27)' onMouseOver='displayBox("r5","c2",27)' onMouseOut='hideBox(27)'>
				</div> 
				<div class="hex r5 c2">
					<img id="27" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap27" />
				</div>

				<div id="node28" class="hex_text r5 c4" onClick='hexReact(28)' onMouseOver='displayBox("r5","c4",28)' onMouseOut='hideBox(28)'>
				</div> 
				<div class="hex r5 c4">
					<img id="28" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap28" />
				</div>

				<div id="node29" class="hex_text r5 c6" onClick='hexReact(29)' onMouseOver='displayBox("r5","c6",29)' onMouseOut='hideBox(29)'>
				</div> 
				<div class="hex r5 c6">
					<img id="29" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap29" />
				</div>

				<div id="node30" class="hex_text r5 c8" onClick='hexReact(30)' onMouseOver='displayBox("r5","c8",30)' onMouseOut='hideBox(30)'>
				</div> 
				<div class="hex r5 c8">
					<img id="30" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap30" />
				</div>

				<div id="node31" class="hex_text r5 c10" onClick="hexReact(31)" onMouseOver='displayBox("r5","c10",31)' onMouseOut='hideBox(31)'>
				</div> 
				<div class="hex r5 c10">
					<img id="31" class="hex_img" src="images/hex_ye_bevel.png" usemap="#hexmap31"/>
				</div>

				<div id="node32" class="hex_text r5 c12" onClick='hexReact(32)' onMouseOver='displayBox("r5","c12",32)' onMouseOut='hideBox(32)'>
				</div> 
				<div class="hex r5 c12">
					<img id="32" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap32" />
				</div>

				<div id="node33" class="hex_text r5 c14" onClick='hexReact(33)' onMouseOver='displayBox("r5","c14",33)' onMouseOut='hideBox(33)'>
				</div> 
				<div class="hex r5 c14">
					<img id="33" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap33" />
				</div>

				<div id="node34" class="hex_text r5 c16" onClick='hexReact(34)' onMouseOver='displayBox("r5","c16",34)' onMouseOut='hideBox(34)'>
				</div> 
				<div class="hex r5 c16">
					<img id="34" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap34" />
				</div>

				<div id="node35" class="hex_text r5 c18" onClick='hexReact(35)' onMouseOver='displayBox("r5","c18",35)' onMouseOut='hideBox(35)'>
				</div> 
				<div class="hex r5 c18">
					<img id="35" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap35" />
				</div>

				<!-- Row 6 -->
				<div id="node36" class="hex_text r6 c3" onClick='hexReact(36)' onMouseOver='displayBox("r6","c3",36)' onMouseOut='hideBox(36)'>
				</div> 
				<div class="hex r6 c3" onClick='hexReact(37)'>
					<img id="36" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap36" />
				</div>

				<div id="node37" class="hex_text r6 c5" onClick='hexReact(37)' onMouseOver='displayBox("r6","c5",37)' onMouseOut='hideBox(37)'>
				</div> 
				<div class="hex r6 c5">
					<img id="37" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap37" />
				</div>

				<div id="node38" class="hex_text r6 c7" onClick='hexReact(38)' onMouseOver='displayBox("r6","c7",38)' onMouseOut='hideBox(38)'>
				</div> 
				<div class="hex r6 c7">
					<img id="38" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap38" />
				</div>

				<div id="node39" class="hex_text r6 c9" onClick='hexReact(39)' onMouseOver='displayBox("r6","c9",39)' onMouseOut='hideBox(39)'>
				</div> 
				<div class="hex r6 c9">
					<img id="39" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap39" />
				</div>

				<div id="node40" class="hex_text r6 c11" onClick='hexReact(40)' onMouseOver='displayBox("r6","c11",40)' onMouseOut='hideBox(40)'>
				</div> 
				<div class="hex r6 c11">
					<img id="40" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap40" />
				</div>

				<div id="node41" class="hex_text r6 c13" onClick='hexReact(41)' onMouseOver='displayBox("r6","c13",41)' onMouseOut='hideBox(41)'>
				</div> 
				<div class="hex r6 c13">
					<img id="41" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap41" />
				</div>

				<div id="node42" class="hex_text r6 c15" onClick='hexReact(42)' onMouseOver='displayBox("r6","c15",42)' onMouseOut='hideBox(42)'>
				</div> 
				<div class="hex r6 c15">
					<img id="42" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap42" />
				</div>

				<div id="node43" class="hex_text r6 c17" onClick='hexReact(43)' onMouseOver='displayBox("r6","c17",43)' onMouseOut='hideBox(43)'>
				</div> 
				<div class="hex r6 c17">
					<img id="43" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap43" />
				</div>

				<!-- Row 7 -->
				<div id="node44" class="hex_text r7 c4" onClick='hexReact(44)' onMouseOver='displayBox("r7","c4",44)' onMouseOut='hideBox(44)'>
				</div> 
				<div class="hex r7 c4">
					<img id="44" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap44" />
				</div>

				<div id="node45" class="hex_text r7 c6" onClick='hexReact(45)' onMouseOver='displayBox("r7","c6",45)' onMouseOut='hideBox(45)'>
				</div> 
				<div class="hex r7 c6">
					<img id="45" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap45" />
				</div>

				<div id="node46" class="hex_text r7 c8" onClick='hexReact(46)' onMouseOver='displayBox("r7","c8",46)' onMouseOut='hideBox(46)'>
				</div> 
				<div class="hex r7 c8">
					<img id="46" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap46" />
				</div>

				<div id="node47" class="hex_text r7 c10" onClick='hexReact(47)' onMouseOver='displayBox("r7","c10",47)' onMouseOut='hideBox(47)'>
				</div> 
				<div class="hex r7 c10">
					<img id="47" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap47" />
				</div>

				<div id="node48" class="hex_text r7 c12" onClick='hexReact(48)' onMouseOver='displayBox("r7","c12",48)' onMouseOut='hideBox(48)'>
				</div>
				<div class="hex r7 c12">
					<img id="48" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap48" />
				</div>

				<div id="node49" class="hex_text r7 c14" onClick='hexReact(49)' onMouseOver='displayBox("r7","c14",49)' onMouseOut='hideBox(49)'>
				</div>
				<div class="hex r7 c14">
					<img id="49" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap49" />
				</div>

				<div id="node50" class="hex_text r7 c16" onClick='hexReact(50)' onMouseOver='displayBox("r7","c16",50)' onMouseOut='hideBox(50)'>
				</div>
				<div class="hex r7 c16">
					<img id="50" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap50" />
				</div>

				<!-- Row 8 -->
				<div id="node51" class="hex_text r8 c5" onClick='hexReact(51)' onMouseOver='displayBox("r8","c5",51)' onMouseOut='hideBox(51)'>
				</div>
				<div class="hex r8 c5">
					<img id="51" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap51" />
				</div>

				<div id="node52" class="hex_text r8 c7" onClick='hexReact(52)' onMouseOver='displayBox("r8","c7",52)' onMouseOut='hideBox(52)'>
				</div>
				<div class="hex r8 c7">
					<img id="52" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap52" />
				</div>

				<div id="node53" class="hex_text r8 c9" onClick='hexReact(53)' onMouseOver='displayBox("r8","c9",53)' onMouseOut='hideBox(53)'>
				</div>
				<div class="hex r8 c9">
					<img id="53" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap53" />
				</div>

				<div id="node54" class="hex_text r8 c11" onClick='hexReact(54)' onMouseOver='displayBox("r8","c11",54)' onMouseOut='hideBox(54)'>
				</div>
				<div class="hex r8 c11">
					<img id="54" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap54" />
				</div>

				<div id="node55" class="hex_text r8 c13" onClick='hexReact(55)' onMouseOver='displayBox("r8","c13",55)' onMouseOut='hideBox(55)'>
				</div>
				<div class="hex r8 c13">
					<img id="55" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap55" />
				</div>

				<div id="node56" class="hex_text r8 c15" onClick='hexReact(56)' onMouseOver='displayBox("r8","c15",56)' onMouseOut='hideBox(56)'>
				</div>
				<div class="hex r8 c15">
					<img id="56" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap56" />
				</div>

				<!-- Row 9 -->
				<div id="node57" class="hex_text r9 c6" onClick='hexReact(57)' onMouseOver='displayBox("r9","c6",57)' onMouseOut='hideBox(57)'>
				</div>
				<div class="hex r9 c6">
					<img id="57" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap57" />
				</div>

				<div id="node58" class="hex_text r9 c8" onClick='hexReact(58)' onMouseOver='displayBox("r9","c8",58)' onMouseOut='hideBox(58)'>
				</div>
				<div class="hex r9 c8">
					<img id="58" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap58" />
				</div>

				<div id="node59" class="hex_text r9 c10" onClick='hexReact(59)' onMouseOver='displayBox("r9","c10",59)' onMouseOut='hideBox(59)'>
				</div>
				<div class="hex r9 c10">
					<img id="59" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap59" />
				</div>

				<div id="node60" class="hex_text r9 c12" onClick='hexReact(60)' onMouseOver='displayBox("r9","c12",60)' onMouseOut='hideBox(60)'>
				</div>
				<div class="hex r9 c12">
					<img id="60" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap60" />
				</div>

				<div id="node61" class="hex_text r9 c14" onClick='hexReact(61)' onMouseOver='displayBox("r9","c14",61)' onMouseOut='hideBox(61)'>
				</div>
				<div class="hex r9 c14">
					<img id="61" class="hex_img" src="images/hex_bl_bevel.png" usemap="#hexmap61" />
				</div>

				<form id="new_game" action="maze_process.php" method="post">
					<input type="hidden" name="action" value="reset">
			    	<input type="submit" class="reset_button" value="Start New Game">
				</form>
				
			</div><!-- End Hex Grid -->

			<div class="interface">
				<form>
					<label>Node: </label>
			    	<input id="node" type="text" class="home_text" readonly />
			    	<label class="labels">Description: </label>
			    	<textarea id="description" rows="6" cols="50" class="home_text" readonly></textarea>
			    	<label class="labels">Most Recent Connection: </label>
			    	<textarea id="connection" rows="6" cols="50" class="home_text" readonly></textarea>
			    	<label class="messages labels">Messages: </label>
			    	<textarea id="message" rows="2" cols="50" class="home_text" readonly></textarea>
				</form>

				<input type="submit" class="reset_button" value="Reset Grid with Same Nodes" onclick="gridReset()">

			</div><!-- End interface div -->
		</div><!-- End playing area-->

		<!-- area maps for hexagons -->
		<?php 
			for ($i=1; $i<62; $i++){
			  echo "<map name=hexmap" . $i . ">
			  	<area shape=\"poly\" coords=\"0,14,24,0,25,0,49,14,49,12,25,56,24,56,0,42,0,14\" onClick=\"hexReact(" . $i . ")\">
			  </map>";
			 } 
		?>
	</div><!-- End main content -->
</div><!-- End wrapper -->

</body>
</html>

