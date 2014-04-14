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
</head>
<body class="maze_body">
<div class="wrapper">
	<?php
		include('nav_bar.php');
	?>
	<div class="main_content">
		<h2  class="main_header maze_header">The Maze</h2>
		<p class="intro_text">The program for creating the connection game is based on a maze algorithm. 
			As it builds the maze, it adds nodes to the maze's path, basically layering the nodes on top of the maze's path.
			But while there should always be only one way through the underlying maze, there may be many ways across the connection grid,
			because the nodes are more interconnected than the path they are built on.</p>
			
		<p class="intro_text2">If a grid has just been built on the home page, the maze below will show the original path through the maze.</p>

		<div class="maze_holder">
			<div class="maze_grid">
				<img class="yellow_back" src="images/maze_back3.png" />
				<!-- Row 1 -->
				<div class="maze_text maze_row1 maze_column6">
				</div>
				<div class="hex maze_row1 maze_column6">
				<img id="1"
				<?php
					if (!empty($_SESSION['hex'][1])) {
						echo 'src="images/y_' . $_SESSION['hex'][1] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row1 maze_column8">
				</div>
				<div class="hex maze_row1 maze_column8">
				<img id="2"
				<?php
					if (!empty($_SESSION['hex'][2])) {
						echo 'src="images/y_' . $_SESSION['hex'][2] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row1 maze_column10">
				</div>
				<div class="hex maze_row1 maze_column10">
				<img id="3"
				<?php
					if (!empty($_SESSION['hex'][3])) {
						echo 'src="images/y_' . $_SESSION['hex'][3] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row1 maze_column12">
				</div>
				<div class="hex maze_row1 maze_column12">
				<img id="4"
				<?php
					if (!empty($_SESSION['hex'][4])) {
						echo 'src="images/y_' . $_SESSION['hex'][4] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row1 maze_column14">
				</div>
				<div class="hex maze_row1 maze_column14">
				<img id="5"
				<?php
					if (!empty($_SESSION['hex'][5])) {
						echo 'src="images/y_' . $_SESSION['hex'][5] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- maze_row 2 -->
				<div class="maze_text maze_row2 maze_column5">
				</div>
				<div class="hex maze_row2 maze_column5">
				<img id="6"
				<?php
					if (!empty($_SESSION['hex'][6])) {
						echo 'src="images/y_' . $_SESSION['hex'][6] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row2 maze_column7">
				</div>
				<div class="hex maze_row2 maze_column7">
				<img id="7"
				<?php
					if (!empty($_SESSION['hex'][7])) {
						echo 'src="images/y_' . $_SESSION['hex'][7] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row2 maze_column9">
				</div>
				<div class="hex maze_row2 maze_column9">
				<img id="8"
				<?php
					if (!empty($_SESSION['hex'][8])) {
						echo 'src="images/y_' . $_SESSION['hex'][8] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row2 maze_column11">
				</div>
				<div class="hex maze_row2 maze_column11">
				<img id="9"
				<?php
					if (!empty($_SESSION['hex'][9])) {
						echo 'src="images/y_' . $_SESSION['hex'][9] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row2 maze_column13">
				</div>
				<div class="hex maze_row2 maze_column13">
				<img id="10"
				<?php
					if (!empty($_SESSION['hex'][10])) {
						echo 'src="images/y_' . $_SESSION['hex'][10] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row2 maze_column15">
				</div>
				<div class="hex maze_row2 maze_column15">
				<img id="11"
				<?php
					if (!empty($_SESSION['hex'][11])) {
						echo 'src="images/y_' . $_SESSION['hex'][11] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- maze_row 3 -->
				<div class="maze_text maze_row3 maze_column4">
				</div>
				<div class="hex maze_row3 maze_column4">
				<img id="12"
				<?php
					if (!empty($_SESSION['hex'][12])) {
						echo 'src="images/y_' . $_SESSION['hex'][12] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row3 maze_column6">
				</div>
				<div class="hex maze_row3 maze_column6">
				<img id="13"
				<?php
					if (!empty($_SESSION['hex'][13])) {
						echo 'src="images/y_' . $_SESSION['hex'][13] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row3 maze_column8">
				</div>
				<div class="hex maze_row3 maze_column8">
				<img id="14"
				<?php
					if (!empty($_SESSION['hex'][14])) {
						echo 'src="images/y_' . $_SESSION['hex'][14] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row3 maze_column10">
				</div>
				<div class="hex maze_row3 maze_column10">
				<img id="15" 
				<?php
					if (!empty($_SESSION['hex'][15])) {
						echo 'src="images/y_' . $_SESSION['hex'][15] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row3 maze_column12">
				</div>
				<div class="hex maze_row3 maze_column12">
				<img id="16"
				<?php
					if (!empty($_SESSION['hex'][16])) {
						echo 'src="images/y_' . $_SESSION['hex'][16] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row3 maze_column14">
				</div>
				<div class="hex maze_row3 maze_column14">
				<img id="17" 
				<?php
					if (!empty($_SESSION['hex'][17])) {
						echo 'src="images/y_' . $_SESSION['hex'][17] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row3 maze_column16">
				</div>
				<div class="hex maze_row3 maze_column16">
				<img id="18"
				<?php
					if (!empty($_SESSION['hex'][18])) {
						echo 'src="images/y_' . $_SESSION['hex'][18] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- maze_row 4 -->
				<div class="maze_text maze_row4 maze_column3">
				</div>
				<div class="hex maze_row4 maze_column3">
				<img id="19"
				<?php
					if (!empty($_SESSION['hex'][19])) {
						echo 'src="images/y_' . $_SESSION['hex'][19] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column5">
				</div>
				<div class="hex maze_row4 maze_column5">
				<img id="20"
				<?php
					if (!empty($_SESSION['hex'][20])) {
						echo 'src="images/y_' . $_SESSION['hex'][20] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column7">
				</div>
				<div class="hex maze_row4 maze_column7">
				<img id="21"
				<?php
					if (!empty($_SESSION['hex'][21])) {
						echo 'src="images/y_' . $_SESSION['hex'][21] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column9">
				</div>
				<div class="hex maze_row4 maze_column9">
				<img id="22"
				<?php
					if (!empty($_SESSION['hex'][22])) {
						echo 'src="images/y_' . $_SESSION['hex'][22] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column11">
				</div>
				<div class="hex maze_row4 maze_column11">
				<img id="23"
				<?php
					if (!empty($_SESSION['hex'][23])) {
						echo 'src="images/y_' . $_SESSION['hex'][23] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column13">
				</div>
				<div class="hex maze_row4 maze_column13">
				<img id="24"
				<?php
					if (!empty($_SESSION['hex'][24])) {
						echo 'src="images/y_' . $_SESSION['hex'][24] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column15">
				</div>
				<div class="hex maze_row4 maze_column15">
				<img id="25"
				<?php
					if (!empty($_SESSION['hex'][25])) {
						echo 'src="images/y_' . $_SESSION['hex'][25] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row4 maze_column17">
				</div>
				<div class="hex maze_row4 maze_column17">
				<img id="26"
				<?php
					if (!empty($_SESSION['hex'][26])) {
						echo 'src="images/y_' . $_SESSION['hex'][26] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- maze_row 5 -->
				<div class="maze_text row5 maze_column2">
				</div>
				<div class="hex maze_row5 maze_column2">
				<img id="27" 
				<?php
					if (!empty($_SESSION['hex'][27])) {
						echo 'src="images/y_' . $_SESSION['hex'][27] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column4">
				</div>
				<div class="hex maze_row5 maze_column4">
				<img id="28"
				<?php
					if (!empty($_SESSION['hex'][28])) {
						echo 'src="images/y_' . $_SESSION['hex'][28] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column6">
				</div>
				<div class="hex maze_row5 maze_column6">
				<img id="29"
				<?php
					if (!empty($_SESSION['hex'][29])) {
						echo 'src="images/y_' . $_SESSION['hex'][29] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column8">
				</div>
				<div class="hex maze_row5 maze_column8">
				<img id="30"
				<?php
					if (!empty($_SESSION['hex'][30])) {
						echo 'src="images/y_' . $_SESSION['hex'][30] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column10">
				</div>
				<div class="hex maze_row5 maze_column10">
				<img id="31"
				<?php
					if (!empty($_SESSION['hex'][31])) {
						echo 'src="images/y_' . $_SESSION['hex'][31] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column12">
				</div>
				<div class="hex maze_row5 maze_column12">
				<img id="32"
				<?php
					if (!empty($_SESSION['hex'][32])) {
						echo 'src="images/y_' . $_SESSION['hex'][32] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column14">
				</div>
				<div class="hex maze_row5 maze_column14">
				<img id="33"
				<?php
					if (!empty($_SESSION['hex'][33])) {
						echo 'src="images/y_' . $_SESSION['hex'][33] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column16">
				</div>
				<div class="hex maze_row5 maze_column16">
				<img id="34"
				<?php
					if (!empty($_SESSION['hex'][34])) {
						echo 'src="images/y_' . $_SESSION['hex'][34] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row5 maze_column18">
				</div>
				<div class="hex maze_row5 maze_column18">
				<img id="35"
				<?php
					if (!empty($_SESSION['hex'][35])) {
						echo 'src="images/y_' . $_SESSION['hex'][35] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- Row 6 -->
				<div class="maze_text maze_row6 maze_column3">
				</div>
				<div class="hex maze_row6 maze_column3">
				<img id="36"
				<?php
					if (!empty($_SESSION['hex'][36])) {
						echo 'src="images/y_' . $_SESSION['hex'][36] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column5">
				</div>
				<div class="hex maze_row6 maze_column5">
				<img id="37"
				<?php
					if (!empty($_SESSION['hex'][37])) {
						echo 'src="images/y_' . $_SESSION['hex'][37] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column7">
				</div>
				<div class="hex maze_row6 maze_column7">
				<img id="38"
				<?php
					if (!empty($_SESSION['hex'][38])) {
						echo 'src="images/y_' . $_SESSION['hex'][38] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column9">
				</div>
				<div class="hex maze_row6 maze_column9">
				<img id="39"
				<?php
					if (!empty($_SESSION['hex'][39])) {
						echo 'src="images/y_' . $_SESSION['hex'][39] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column11">
				</div>
				<div class="hex maze_row6 maze_column11">
				<img id="40"
				<?php
					if (!empty($_SESSION['hex'][40])) {
						echo 'src="images/y_' . $_SESSION['hex'][40] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column13">
				</div>
				<div class="hex maze_row6 maze_column13">
				<img id="41"
				<?php
					if (!empty($_SESSION['hex'][41])) {
						echo 'src="images/y_' . $_SESSION['hex'][41] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column15">
				</div>
				<div class="hex maze_row6 maze_column15">
				<img id="42"
				<?php
					if (!empty($_SESSION['hex'][42])) {
						echo 'src="images/y_' . $_SESSION['hex'][42] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row6 maze_column17">
				</div>
				<div class="hex maze_row6 maze_column17">
				<img id="43"
				<?php
					if (!empty($_SESSION['hex'][43])) {
						echo 'src="images/y_' . $_SESSION['hex'][43] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- Row 7 -->
				<div class="maze_text maze_row7 maze_column4">
				</div>
				<div class="hex maze_row7 maze_column4">
				<img id="44"
				<?php
					if (!empty($_SESSION['hex'][44])) {
						echo 'src="images/y_' . $_SESSION['hex'][44] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row7 maze_column6">
				</div>
				<div class="hex maze_row7 maze_column6">
				<img id="45"
				<?php
					if (!empty($_SESSION['hex'][45])) {
						echo 'src="images/y_' . $_SESSION['hex'][45] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row7 maze_column8">
				</div>
				<div class="hex maze_row7 maze_column8">
				<img id="46" 
				<?php
					if (!empty($_SESSION['hex'][46])) {
						echo 'src="images/y_' . $_SESSION['hex'][46] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row7 maze_column10">
				</div>
				<div class="hex maze_row7 maze_column10">
				<img id="47"
				<?php
					if (!empty($_SESSION['hex'][47])) {
						echo 'src="images/y_' . $_SESSION['hex'][47] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row7 maze_column12">
				</div>
				<div class="hex maze_row7 maze_column12">
				<img id="48"
				<?php
					if (!empty($_SESSION['hex'][48])) {
						echo 'src="images/y_' . $_SESSION['hex'][48] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row7 maze_column14">
				</div>
				<div class="hex maze_row7 maze_column14">
				<img id="49"
				<?php
					if (!empty($_SESSION['hex'][49])) {
						echo 'src="images/y_' . $_SESSION['hex'][49] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row7 maze_column16">
				</div>
				<div class="hex maze_row7 maze_column16">
				<img id="50"
				<?php
					if (!empty($_SESSION['hex'][50])) {
						echo 'src="images/y_' . $_SESSION['hex'][50] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- Row 8 -->
				<div class="maze_text maze_row8 maze_column5">
				</div>
				<div class="hex maze_row8 maze_column5">
				<img id="51"
				<?php
					if (!empty($_SESSION['hex'][51])) {
						echo 'src="images/y_' . $_SESSION['hex'][51] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row8 maze_column7">
				</div>
				<div class="hex maze_row8 maze_column7">
				<img id="52"
				<?php
					if (!empty($_SESSION['hex'][52])) {
						echo 'src="images/y_' . $_SESSION['hex'][52] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row8 maze_column9">
				</div>
				<div class="hex maze_row8 maze_column9">
				<img id="53"
				<?php
					if (!empty($_SESSION['hex'][53])) {
						echo 'src="images/y_' . $_SESSION['hex'][53] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row8 maze_column11">
				</div>
				<div class="hex maze_row8 maze_column11">
				<img id="54"
				<?php
					if (!empty($_SESSION['hex'][54])) {
						echo 'src="images/y_' . $_SESSION['hex'][54] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row8 maze_column13">
				</div>
				<div class="hex maze_row8 maze_column13">
				<img id="55"
				<?php
					if (!empty($_SESSION['hex'][55])) {
						echo 'src="images/y_' . $_SESSION['hex'][55] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row8 maze_column15">
				</div>
				<div class="hex maze_row8 maze_column15">
				<img id="56"
				<?php
					if (!empty($_SESSION['hex'][56])) {
						echo 'src="images/y_' . $_SESSION['hex'][56] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<!-- Row 9 -->
				<div class="maze_text maze_row9 maze_column6">
				</div>
				<div class="hex maze_row9 maze_column6">
				<img id="57"
				<?php
					if (!empty($_SESSION['hex'][57])) {
						echo 'src="images/y_' . $_SESSION['hex'][57] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row9 maze_column8">
				</div>
				<div class="hex maze_row9 maze_column8">
				<img id="58"
				<?php
					if (!empty($_SESSION['hex'][58])) {
						echo 'src="images/y_' . $_SESSION['hex'][58] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row9 maze_column10">
				</div>
				<div class="hex maze_row9 maze_column10">
				<img id="59"
				<?php
					if (!empty($_SESSION['hex'][59])) {
						echo 'src="images/y_' . $_SESSION['hex'][59] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row9 maze_column12">
				</div>
				<div class="hex maze_row9 maze_column12">
				<img id="60"
				<?php
					if (!empty($_SESSION['hex'][60])) {
						echo 'src="images/y_' . $_SESSION['hex'][60] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>

				<div class="maze_text maze_row9 maze_column14">
				</div>
				<div class="hex maze_row9 maze_column14">
				<img id="61"
				<?php
					if (!empty($_SESSION['hex'][61])) {
						echo 'src="images/y_' . $_SESSION['hex'][61] . '_bevel.png"';
					} else { echo 'src="images/hex_green_50_by_57_bevel.png"';}
				?>
				>
				</div>
			</div><!-- End Hex Grid -->
			<div>
				<form action="maze_process.php" method="post">
					<input type="hidden" name="action" value="create_regular_maze">
			    	<input id="new_button" type="submit" class="generate_button" value="Generate New Maze">
				</form>
			</div>

		</div><!-- End Maze Holder -->
	</div><!-- End main content -->
</div><!-- End wrapper -->
</body>
</html>