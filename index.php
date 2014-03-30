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
	<script type="text/javascript">

		//When the program loads, this sends a GET to maze_process.php,
		//which builds the maze and returns the hex_array via AJAX
		//thereby making the hex_array available to javascript.
		var connected = new Array();

		$(window).load(function()
		{
			//clickable and non-clickable are used to disable
			//clicking while program accesses database
			$(".hex, .hex_text").addClass("clickable");

			$(document).ajaxStart(function(){
				$(".hex, .hex_text").removeClass("clickable");
				$(".hex, .hex_text").addClass("not-clickable");
			})

			$(document).ajaxStop(function(){
				$(".hex, .hex_text").addClass("clickable");
				$(".hex, .hex_text").removeClass("not-clickable");
			})

			$("#new_game").submit(function(){

	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data){
							hex_array = data;

							//Reset everything on the page
							won=false;
							current_hex = 31;
							document.getElementById("message").value  = "";
							for (i=1; i<62; i++) { 
								var pseudo_text = toString(i);
								document.getElementById(i).src = "images/hex_bl.png";
							}
							document.getElementById(5).src = "images/hex_re.png";
							document.getElementById(31).src = "images/hex_ye.png";
							document.getElementById("message").style.background = "white";
							document.getElementById("connection").value = "";

							//Add the text to the hexagons.
							$('.hex_text').each(function(index,element)
							{
								var counter = parseInt(index+1);

								var node_text = hex_array[counter]['node_name'];

								index+' '+$(element).text(node_text.substring(0,17));
								//console.log(index+' '+$(element).text(node_text.substring(0,17)));
							})

							document.getElementById("node").value = hex_array[31]['node_name'];
							document.getElementById("description").value = hex_array[31]['node_desc'];

							//Populate hidden menu with current node.
							document.getElementById("first_node").value = hex_array[31]['node_id'];

							//console.log(data);
						},'json'
					);
	            	return false;
	        });

			$("#nodes_info").submit(function(){

	            $.post(
	            	$(this).attr('action'),
	            	$(this).serialize(),
	            	function(data)
	            	{	
	            		connected = data;

	            		afterHexCheck();
	        		},
	        		'json'
	            );
	            return false;
	        });


	    });  //End of the window load AJAX functions.

		//Set the value of the current hexagon.		
		var current_hex = 31;

		var won = false;
		var clicked_node = 0;
		var hex_clicked = 0;

		//Time delay added because of delay that happens with database call.
		//This basically prevents double-clicks that cause a hexagon to turn green
		//when it should stay yellow.  Only a problem when online, but not when testing locally.
		var time_last= new Date();

		function hexReact(clicked_id) {
			// $(document).ajaxStop(function(){
			if($(".hex").hasClass("clickable")){
				// var time_now = new Date();
				// if ( time_now - time_last >= 400){ // 1000 = 1second
					hex_clicked = clicked_id;
					//console.log(connected);

					//Disallow further moves if game is over.
					if (won == true) {
						document.getElementById("message").value  = " The game is over. Reset the grid to play again.";
						return;
					}

					var adjacent = false;
					//connected['boolean'] = false;

					//document.getElementById("test").innerHTML = clicked_id;

					document.getElementById("node").value = hex_array[clicked_id]['node_name'];
					document.getElementById("description").value = hex_array[clicked_id]['node_desc'];

					clicked_node = hex_array[clicked_id]['node_id'];
					current_node = hex_array[current_hex]['node_id'];
					if (clicked_node == current_node) {
						document.getElementById("message").value  = " Sorry, you can't connect two of the same thing."; 
						document.getElementById("message").style.background = "#F08080";  //light red
						document.getElementById("message").style.background = "#00FFFF";  //Cyan
						return;
					}

					//Populate the hidden form with the "to" and "from" hexes,
					//so that they can be posted and processed via AJAX.
					document.getElementById("first_node").value = current_node;
					document.getElementById("second_node").value = clicked_node;

					//Check to see if the clicked hexagon is adjacent to the current hexagon.
					//If is isn't, send the message, "Pleae click on a node adjacent to the current one."
					//If the new node is adjacent to the selected one, see if they are connected.
					//If they aren't connected, send the message "No connection found in database."
					//If they are connected and the new hexagon is number 5
					//then complete the maze and congratulate the player.
					//Otherwise turn the new cell yellow, turn the last cell green, and change the value of the current cell.

					if (hex_array[current_hex]['ne'] == clicked_id) { adjacent = true; }
					if (hex_array[current_hex]['e'] == clicked_id) { adjacent = true; }
					if (hex_array[current_hex]['se'] == clicked_id) { adjacent = true; }
					if (hex_array[current_hex]['sw'] == clicked_id) { adjacent = true; }
					if (hex_array[current_hex]['w'] == clicked_id) { adjacent = true; }
					if (hex_array[current_hex]['nw'] == clicked_id) { adjacent = true; }

					if (adjacent == false) { 
						document.getElementById("message").value  = " Click on a node adjacent to the current one."; 
						document.getElementById("message").style.background = "#F08080";  //light red
						document.getElementById("message").style.background = "#00FFFF";  //Cyan
					}
					if (clicked_id == current_hex) { 
						document.getElementById("message").value  = "";
						document.getElementById("message").style.background = "white";
					}
					if (adjacent == true) {

						//Submit the hidden form that contains the node ids of the current cell and the clicked cell.
						//(Works as a jQuery submit command, but not as a JavaScript submit).
						$('#nodes_info').submit();
						//console.log(connected);
					}
					// console.log(time_last, time_now, time_now-time_last,"not too fast");
				// } else { /* console.log(time_last, time_now, time_now-time_last, "clicking too fast"); */ }
				// time_last = new Date();
			}
			// })
		}

		function afterHexCheck(){
			//This needed to be in a separte function from where the form was submitted,
			//so that it could be called AFTER/by the AJAX process.

			//Display the connection if there is one.
	        document.getElementById("connection").value = connected['describe_connect'];

			if (connected['boolean']==true){
				document.getElementById("message").value  = "";
				document.getElementById("message").style.background = "white";
				document.getElementById(hex_clicked).src = "images/hex_ye.png";
				document.getElementById(current_hex).src = "images/hex_gr.png";
				current_hex = hex_clicked;
				connected['boolean']==false;
				
				//Win
				if (hex_clicked == 5 ) {
					won = true;
					document.getElementById(hex_clicked).src = "images/hex_gr.png";
					document.getElementById("message").value  = " Congratulations! You did it!" + '\r' + " Start a new game or reset the grid to play again.";
					document.getElementById("message").style.background  = "#7FFF00";	//Chartreuse (Flourescent green)
				}
			} else {
				document.getElementById("message").value  = " No connection found in database.";
				document.getElementById("message").style.background = "#F08080";  //light red
				document.getElementById("message").style.background = "#00FFFF";  //Cyan
			}
		}

		function gridReset(){
			current_hex = 31;
			won = false;
			clicked_node = 0;
			hex_clicked = 0;

			document.getElementById("node").value = hex_array[current_hex]['node_name'];
			document.getElementById("description").value = hex_array[current_hex]['node_desc'];
			document.getElementById("connection").value =""
			document.getElementById("message").value ="Game reset."
			document.getElementById("message").style.background = "white";
			//Reset all hexes to blue.
			for (a=1; a<62; a++) {
				document.getElementById(a).src="images/hex_bl.png";
			}
			document.getElementById(5).src="images/hex_re.png";
			document.getElementById(31).src="images/hex_ye.png";
		}

	</script>
</head>

<body>
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
			<h2  class="main_header">The Connection Game</h2>
			<p>Your goal is to make it from the yellow hexagon in the center to the red hexagon on the edge.<br />  
				Each hexagon contains a subject (called a node), and each node connects to one or more of the nodes around it.<br />
				Follow the connections to find your way. Keep in mind that your position is indicated by the yellow hexagon,<br />
				and you may have to retrace your path over the green hexagons where you have aleady been.</p>
		</div>

		<div class="playing_area">
			<div class="hex_grid">
				<!-- Row 1 -->
				<div class="hex_text row1 column6" onClick='hexReact(1)'>
				</div> 
				<div class="hex row1 column6" >
					<img id="1" class="hex_img" src="images/hex_bl.png" usemap="#hexmap1" />
				</div>

				<div class="hex_text row1 column8" onClick='hexReact(2)'>
				</div> 
				<div class="hex row1 column8">
					<img id="2" class="hex_img" src="images/hex_bl.png" usemap="#hexmap2" />
				</div>

				<div class="hex_text row1 column10" onClick='hexReact(3)'>
				</div> 
				<div class="hex row1 column10">
					<img id="3" class="hex_img" src="images/hex_bl.png" usemap="#hexmap3" />
				</div>

				<div class="hex_text row1 column12" onClick='hexReact(4)'>
				</div> 
				<div class="hex row1 column12">
					<img id="4" class="hex_img" src="images/hex_bl.png" usemap="#hexmap4" />
				</div>

				<div class="hex_text row1 column14" onClick='hexReact(5)'>
				</div> 
				<div class="hex row1 column14">
					<img id="5" class="hex_img" src="images/hex_re.png" usemap="#hexmap5" />
				</div>


				<!-- Row 2 -->
				<div class="hex_text row2 column5" onClick='hexReact(6)'>
				</div> 
				<div class="hex row2 column5">
					<img id="6" class="hex_img" src="images/hex_bl.png" usemap="#hexmap6" />
				</div>

				<div class="hex_text row2 column7" onClick='hexReact(7)'>
				</div> 
				<div class="hex row2 column7">
					<img id="7" class="hex_img" src="images/hex_bl.png" usemap="#hexmap7" />
				</div>

				<div class="hex_text row2 column9" onClick='hexReact(8)'>
				</div> 
				<div class="hex row2 column9">
					<img id="8" class="hex_img" src="images/hex_bl.png" usemap="#hexmap8" />
				</div>

				<div class="hex_text row2 column11" onClick='hexReact(9)'>
				</div> 
				<div class="hex row2 column11">
					<img id="9" class="hex_img" src="images/hex_bl.png" usemap="#hexmap9" />
				</div>

				<div class="hex_text row2 column13" onClick='hexReact(10)'>
				</div> 
				<div class="hex row2 column13">
					<img id="10" class="hex_img" src="images/hex_bl.png" usemap="#hexmap10" />
				</div>

				<div class="hex_text row2 column15" onClick='hexReact(11)'>
				</div> 
				<div class="hex row2 column15">
					<img id="11" class="hex_img" src="images/hex_bl.png" usemap="#hexmap11" />
				</div>

				<!-- Row 3 -->
				<div class="hex_text row3 column4" onClick='hexReact(12)'>
				</div> 
				<div class="hex row3 column4">
					<img id="12" class="hex_img" src="images/hex_bl.png" usemap="#hexmap12" />
				</div>

				<div class="hex_text row3 column6" onClick='hexReact(13)'>
				</div> 
				<div class="hex row3 column6">
					<img id="13" class="hex_img" src="images/hex_bl.png" usemap="#hexmap13" />
				</div>

				<div class="hex_text row3 column8" onClick='hexReact(14)'>
				</div> 
				<div class="hex row3 column8">
					<img id="14" class="hex_img" src="images/hex_bl.png" usemap="#hexmap14" />
				</div>

				<div class="hex_text row3 column10" onClick='hexReact(15)'>
				</div> 
				<div class="hex row3 column10">
					<img id="15" class="hex_img" src="images/hex_bl.png" usemap="#hexmap15" />
				</div>

				<div class="hex_text row3 column12" onClick='hexReact(16)'>
				</div> 
				<div class="hex row3 column12">
					<img id="16" class="hex_img" src="images/hex_bl.png" usemap="#hexmap16" />
				</div>

				<div class="hex_text row3 column14" onClick='hexReact(17)'>
				</div> 
				<div class="hex row3 column14">
					<img id="17" class="hex_img" src="images/hex_bl.png" usemap="#hexmap17" />
				</div>

				<div class="hex_text row3 column16" onClick='hexReact(18)'>
				</div> 
				<div class="hex row3 column16">
					<img id="18" class="hex_img" src="images/hex_bl.png" usemap="#hexmap18" />
				</div>

				<!-- Row 4 -->
				<div class="hex_text row4 column3" onClick='hexReact(19)'>
				</div> 
				<div class="hex row4 column3">
					<img id="19" class="hex_img" src="images/hex_bl.png" usemap="#hexmap19" />
				</div>

				<div class="hex_text row4 column5" onClick='hexReact(20)'>
				</div> 
				<div class="hex row4 column5">
					<img id="20" class="hex_img" src="images/hex_bl.png" usemap="#hexmap20" />
				</div>

				<div class="hex_text row4 column7" onClick='hexReact(21)'>
				</div> 
				<div class="hex row4 column7">
					<img id="21" class="hex_img" src="images/hex_bl.png" usemap="#hexmap21" />
				</div>

				<div class="hex_text row4 column9" onClick='hexReact(22)'>
				</div> 
				<div class="hex row4 column9">
					<img id="22" class="hex_img" src="images/hex_bl.png" usemap="#hexmap22" />
				</div>

				<div class="hex_text row4 column11" onClick='hexReact(23)'>
				</div> 
				<div class="hex row4 column11">
					<img id="23" class="hex_img" src="images/hex_bl.png" usemap="#hexmap23" />
				</div>

				<div class="hex_text row4 column13" onClick='hexReact(24)'>
				</div> 
				<div class="hex row4 column13">
					<img id="24" class="hex_img" src="images/hex_bl.png" usemap="#hexmap24" />
				</div>

				<div class="hex_text row4 column15" onClick='hexReact(25)'>
				</div> 
				<div class="hex row4 column15">
					<img id="25" class="hex_img" src="images/hex_bl.png" usemap="#hexmap25" />
				</div>

				<div class="hex_text row4 column17" onClick='hexReact(26)'>
				</div> 
				<div class="hex row4 column17">
					<img id="26" class="hex_img" src="images/hex_bl.png" usemap="#hexmap26" />
				</div>

				<!-- Row 5 -->
				<div class="hex_text row5 column2" onClick='hexReact(27)'>
				</div> 
				<div class="hex row5 column2">
					<img id="27" class="hex_img" src="images/hex_bl.png" usemap="#hexmap27" />
				</div>

				<div class="hex_text row5 column4" onClick='hexReact(28)'>
				</div> 
				<div class="hex row5 column4">
					<img id="28" class="hex_img" src="images/hex_bl.png" usemap="#hexmap28" />
				</div>

				<div class="hex_text row5 column6" onClick='hexReact(29)'>
				</div> 
				<div class="hex row5 column6">
					<img id="29" class="hex_img" src="images/hex_bl.png" usemap="#hexmap29" />
				</div>

				<div class="hex_text row5 column8" onClick='hexReact(30)'>
				</div> 
				<div class="hex row5 column8">
					<img id="30" class="hex_img" src="images/hex_bl.png" usemap="#hexmap30" />
				</div>

				<div class="hex_text row5 column10" onClick="hexReact(31)" />
				</div> 
				<div class="hex row5 column10">
					<img id="31" class="hex_img" src="images/hex_ye.png" usemap="#hexmap31"/>
				</div>

				<div class="hex_text row5 column12" onClick='hexReact(32)'>
				</div> 
				<div class="hex row5 column12">
					<img id="32" class="hex_img" src="images/hex_bl.png" usemap="#hexmap32" />
				</div>

				<div class="hex_text row5 column14" onClick='hexReact(33)'>
				</div> 
				<div class="hex row5 column14">
					<img id="33" class="hex_img" src="images/hex_bl.png" usemap="#hexmap33" />
				</div>

				<div class="hex_text row5 column16" onClick='hexReact(34)'>
				</div> 
				<div class="hex row5 column16">
					<img id="34" class="hex_img" src="images/hex_bl.png" usemap="#hexmap34" />
				</div>

				<div class="hex_text row5 column18" onClick='hexReact(35)'>
				</div> 
				<div class="hex row5 column18">
					<img id="35" class="hex_img" src="images/hex_bl.png" usemap="#hexmap35" />
				</div>

				<!-- Row 6 -->
				<div class="hex_text row6 column3" onClick='hexReact(36)'>
				</div> 
				<div class="hex row6 column3" onClick='hexReact(37)'>
					<img id="36" class="hex_img" src="images/hex_bl.png" usemap="#hexmap36" />
				</div>

				<div class="hex_text row6 column5" onClick='hexReact(37)'>
				</div> 
				<div class="hex row6 column5">
					<img id="37" class="hex_img" src="images/hex_bl.png" usemap="#hexmap37" />
				</div>

				<div class="hex_text row6 column7" onClick='hexReact(38)'>
				</div> 
				<div class="hex row6 column7">
					<img id="38" class="hex_img" src="images/hex_bl.png" usemap="#hexmap38" />
				</div>

				<div class="hex_text row6 column9" onClick='hexReact(39)'>
				</div> 
				<div class="hex row6 column9">
					<img id="39" class="hex_img" src="images/hex_bl.png" usemap="#hexmap39" />
				</div>

				<div class="hex_text row6 column11" onClick='hexReact(40)'>
				</div> 
				<div class="hex row6 column11">
					<img id="40" class="hex_img" src="images/hex_bl.png" usemap="#hexmap40" />
				</div>

				<div class="hex_text row6 column13" onClick='hexReact(41)'>
				</div> 
				<div class="hex row6 column13">
					<img id="41" class="hex_img" src="images/hex_bl.png" usemap="#hexmap41" />
				</div>

				<div class="hex_text row6 column15" onClick='hexReact(42)'>
				</div> 
				<div class="hex row6 column15">
					<img id="42" class="hex_img" src="images/hex_bl.png" usemap="#hexmap42" />
				</div>

				<div class="hex_text row6 column17" onClick='hexReact(43)'>
				</div> 
				<div class="hex row6 column17">
					<img id="43" class="hex_img" src="images/hex_bl.png" usemap="#hexmap43" />
				</div>

				<!-- Row 7 -->
				<div class="hex_text row7 column4" onClick='hexReact(44)'>
				</div> 
				<div class="hex row7 column4">
					<img id="44" class="hex_img" src="images/hex_bl.png" usemap="#hexmap44" />
				</div>

				<div class="hex_text row7 column6" onClick='hexReact(45)'>
				</div> 
				<div class="hex row7 column6">
					<img id="45" class="hex_img" src="images/hex_bl.png" usemap="#hexmap45" />
				</div>

				<div class="hex_text row7 column8" onClick='hexReact(46)'>
				</div> 
				<div class="hex row7 column8">
					<img id="46" class="hex_img" src="images/hex_bl.png" usemap="#hexmap46" />
				</div>

				<div class="hex_text row7 column10" onClick='hexReact(47)'>
				</div> 
				<div class="hex row7 column10">
					<img id="47" class="hex_img" src="images/hex_bl.png" usemap="#hexmap47" />
				</div>

				<div class="hex_text row7 column12" onClick='hexReact(48)'>
				</div>
				<div class="hex row7 column12">
					<img id="48" class="hex_img" src="images/hex_bl.png" usemap="#hexmap48" />
				</div>

				<div class="hex_text row7 column14" onClick='hexReact(49)'>
				</div>
				<div class="hex row7 column14">
					<img id="49" class="hex_img" src="images/hex_bl.png" usemap="#hexmap49" />
				</div>

				<div class="hex_text row7 column16" onClick='hexReact(50)'>
				</div>
				<div class="hex row7 column16">
					<img id="50" class="hex_img" src="images/hex_bl.png" usemap="#hexmap50" />
				</div>

				<!-- Row 8 -->
				<div class="hex_text row8 column5" onClick='hexReact(51)'>
				</div>
				<div class="hex row8 column5">
					<img id="51" class="hex_img" src="images/hex_bl.png" usemap="#hexmap51" />
				</div>

				<div class="hex_text row8 column7" onClick='hexReact(52)'>
				</div>
				<div class="hex row8 column7">
					<img id="52" class="hex_img" src="images/hex_bl.png" usemap="#hexmap52" />
				</div>

				<div class="hex_text row8 column9" onClick='hexReact(53)'>
				</div>
				<div class="hex row8 column9">
					<img id="53" class="hex_img" src="images/hex_bl.png" usemap="#hexmap53" />
				</div>

				<div class="hex_text row8 column11" onClick='hexReact(54)'>
				</div>
				<div class="hex row8 column11">
					<img id="54" class="hex_img" src="images/hex_bl.png" usemap="#hexmap54" />
				</div>

				<div class="hex_text row8 column13" onClick='hexReact(55)'>
				</div>
				<div class="hex row8 column13">
					<img id="55" class="hex_img" src="images/hex_bl.png" usemap="#hexmap55" />
				</div>

				<div class="hex_text row8 column15" onClick='hexReact(56)'>
				</div>
				<div class="hex row8 column15">
					<img id="56" class="hex_img" src="images/hex_bl.png" usemap="#hexmap56" />
				</div>

				<!-- Row 9 -->
				<div class="hex_text row9 column6" onClick='hexReact(57)'>
				</div>
				<div class="hex row9 column6">
					<img id="57" class="hex_img" src="images/hex_bl.png" usemap="#hexmap57" />
				</div>

				<div class="hex_text row9 column8" onClick='hexReact(58)'>
				</div>
				<div class="hex row9 column8">
					<img id="58" class="hex_img" src="images/hex_bl.png" usemap="#hexmap58" />
				</div>

				<div class="hex_text row9 column10" onClick='hexReact(59)'>
				</div>
				<div class="hex row9 column10">
					<img id="59" class="hex_img" src="images/hex_bl.png" usemap="#hexmap59" />
				</div>

				<div class="hex_text row9 column12" onClick='hexReact(60)'>
				</div>
				<div class="hex row9 column12">
					<img id="60" class="hex_img" src="images/hex_bl.png" usemap="#hexmap60" />
				</div>

				<div class="hex_text row9 column14" onClick='hexReact(61)'>
				</div>
				<div class="hex row9 column14">
					<img id="61" class="hex_img" src="images/hex_bl.png" usemap="#hexmap61" />
				</div>
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

				<form id="new_game" action="maze_process.php" method="post">
					<input type="hidden" name="action" value="reset">
			    	<input type="submit" class="reset_button" value="Start New Game">
				</form>

				<input type="submit" class="reset_button" value="Reset Grid" onclick="gridReset()">

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