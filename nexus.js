

//When the program loads, this sends a GET to maze_process.php,
//which builds the maze and returns the hex_array via AJAX
//thereby making the hex_array available to javascript.
var connected = new Array();

$(window).load(function()
{
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
						document.getElementById(i).src = "images/hex_bl_bevel.png";
					}
					document.getElementById(5).src = "images/hex_re_bevel.png";
					document.getElementById(31).src = "images/hex_ye_bevel.png";
					document.getElementById('node31').style.color = "black";
					document.getElementById("message").style.background = "white";
					document.getElementById("connection").value = "";

					//Add the text to the hexagons.
					$('.hex_text').each(function(index,element)
					{
						var counter = parseInt(index+1);

						var node_text = hex_array[counter]['node_name'];

						//console.log(element);
						//'element' is an object containing the full text div.

						index+' '+$(element).text(node_text.substring(0,5));
						
						//Experiments with changing font size.
						// index+' '+$(element).text(node_text);
						// if (node_text.length > 7) { element.style.fontSize="12px"; }
						// if (node_text.length > 15) { element.style.fontSize="10px"; }
						//End font experiment
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

//Used to track the value of the hexagon that is being hovered over
var hover_hex = 0;

var won = false;
var clicked_node = 0;
var hex_clicked = 0;

//Time delay added because of delay that happens with database call.
//This basically prevents double-clicks that cause a hexagon to turn green
//when it should stay yellow.  Only a problem when online, but not when testing locally.
var time_last= new Date();

function hexReact(clicked_id) {
	// console.log(hover_hex);
	// console.log(clicked_id);
	// alert('clicked');
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
				document.getElementById("message").style.background = "#71CCEB";  //Another blue
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
				document.getElementById("message").style.background = "#71CCEB";  //Another blue
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
		document.getElementById(hex_clicked).src = "images/hex_ye_bevel.png";
		document.getElementById(current_hex).src = "images/hex_gr_bevel.png";
		current_hex = hex_clicked;
		connected['boolean']==false;
		
		//Win
		if (hex_clicked == 5 ) {
			won = true;
			document.getElementById(hex_clicked).src = "images/hex_gr_bevel.png";
			document.getElementById("message").value  = " Congratulations! You did it!" + '\r' + " Start a new game or reset the grid to play again.";
			document.getElementById("message").style.background  = "#7FFF00";	//Chartreuse (Flourescent green)
		}
	} else {
		document.getElementById("message").value  = " No connection found in database.";
		document.getElementById("message").style.background = "#F08080";  //light red
		document.getElementById("message").style.background = "#00FFFF";  //Cyan
		document.getElementById("message").style.background = "#71CCEB";  //Another blue
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
		document.getElementById(a).src="images/hex_bl_bevel.png";
	}
	document.getElementById(5).src="images/hex_re_bevel.png";
	document.getElementById(31).src="images/hex_ye_bevel.png";
}

function displayBox(row,col,node) {

	hover_hex = node;
	var nodeId = "node" + node;
	var nodeIdPlusOne = "node" + (node+1);
	var nodeIdMinusOne = "node" + (node-1);

	var pOne = getPlusOne(node);
	if (pOne != 0) { nodeIdPlusOne = pOne; }

	var mOne = getMinusOne(node);
	if (mOne != 0) { nodeIdMinusOne = mOne; }

	//Exit the function if the maze hasn't been built yet.
	if (typeof hex_array == 'undefined') { return false; }

	document.getElementById('hover_display').style.display='block';
	if (row=='r1') { document.getElementById('hover_display').style.top="15px"; }
	if (row=='r2') { document.getElementById('hover_display').style.top="65px"; }
	if (row=='r3') { document.getElementById('hover_display').style.top="115px"; }
	if (row=='r4') { document.getElementById('hover_display').style.top="165px"; }
	if (row=='r5') { document.getElementById('hover_display').style.top="215px"; }
	if (row=='r6') { document.getElementById('hover_display').style.top="265px"; }
	if (row=='r7') { document.getElementById('hover_display').style.top="315px"; }
	if (row=='r8') { document.getElementById('hover_display').style.top="365px"; }
	if (row=='r9') { document.getElementById('hover_display').style.top="415px"; }

	if (col=='c2') { document.getElementById('hover_display').style.left="0px"; }
	if (col=='c3') { document.getElementById('hover_display').style.left="12px"; }
	if (col=='c4') { document.getElementById('hover_display').style.left="41px"; }
	if (col=='c5') { document.getElementById('hover_display').style.left="70px"; }
	if (col=='c6') { document.getElementById('hover_display').style.left="99px"; }
	if (col=='c7') { document.getElementById('hover_display').style.left="128px"; }
	if (col=='c8') { document.getElementById('hover_display').style.left="157px"; }
	if (col=='c9') { document.getElementById('hover_display').style.left="186px"; }
	if (col=='c10') { document.getElementById('hover_display').style.left="215px"; }
	if (col=='c11') { document.getElementById('hover_display').style.left="244px"; }
	if (col=='c12') { document.getElementById('hover_display').style.left="273px"; }
	if (col=='c13') { document.getElementById('hover_display').style.left="302px"; }
	if (col=='c14') { document.getElementById('hover_display').style.left="331px"; }
	if (col=='c15') { document.getElementById('hover_display').style.left="360px"; }
	if (col=='c16') { document.getElementById('hover_display').style.left="389px"; }
	if (col=='c17') { document.getElementById('hover_display').style.left="418px"; }
	if (col=='c18') { document.getElementById('hover_display').style.left="447px"; }

	document.getElementById('hover_display').innerHTML = hex_array[node]['node_name'];

	//For testing. Currently, this is the longest node name at 48 characters.
	//document.getElementById('hover_display').innerHTML = "The Curious Incident of the Dog in the Nighttime";

	//When the user hovers over a hexagon,
	//you have to make the text transparent for that hexagon
	//and for the hexagons to the left and to the right.
	//Otherwise the text will overlap the hover display box.
	//Adjusting the z-index does not work, because the origin text box needs to
	//be accessible for mouse-clicks.
	//The hover display box cannot be used for mouse-clicks.
	//One reason is that it is the wrong size.
	document.getElementById(nodeId).style.color="transparent";
	document.getElementById(nodeIdPlusOne).style.color="transparent";
	document.getElementById(nodeIdMinusOne).style.color="transparent";
	
}

function hideBox(node) {
	
	var nodeId = "node" + node;
	var nodeIdPlusOne = "node" + (node+1);
	var nodeIdMinusOne = "node" + (node-1);

	var pOne = getPlusOne(node);
	if (pOne != 0) { nodeIdPlusOne = pOne; }

	var mOne = getMinusOne(node);
	if (mOne != 0) { nodeIdMinusOne = mOne; }

	document.getElementById(nodeId).style.color="black";
	document.getElementById(nodeIdPlusOne).style.color="black";
	document.getElementById(nodeIdMinusOne).style.color="black";

	// document.getElementById("node" + current_hex).style.color="black";

	document.getElementById('hover_display').style.display='none';

}

//document.getElementById("hover_display").addEventListener("click", myTest, false);

function getMinusOne(node) {

	var minusOne = 0;

	switch(node) {
		case 1:
			minusOne = 1;
		break;
		case 6:
			minusOne = 6;
		break;
		case 12:
			minusOne = 12;
		break;
		case 19:
			minusOne = 19;
		break;
		case 27:
			minusOne = 27;
		break;
		case 36:
			minusOne = 36;
		break;
		case 44:
			minusOne = 44;
		break;
		case 51:
			minusOne = 51;
		break;
		case 57:
			minusOne = 57;
		break;
	}
	return minusOne;
}

function getPlusOne(node) {

	var plusOne = 0;

	switch(node) {
		case 5:
			plusOne = 5;
		break;
		case 11:
			plusOne = 11;
		break;
		case 18:
			plusOne = 18;
		break;
		case 26:
			plusOne = 26;
		break;
		case 35:
			plusOne = 35;
		break;
		case 43:
			plusOne = 43;
		break;
		case 50:
			plusOne = 50;
		break;
		case 55:
			plusOne = 56;
		break;
		case 61:
			plusOne = 61;
		break;
	}
	return plusOne;
}


