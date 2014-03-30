<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>About The Connection Game</title>
	<meta name="description" content="Information about the connection game"/>
	<link rel="stylesheet" type="text/css" href="connect_style.css">
</head>
<body class="about_body">
<div class="wrapper">
	<?php
		include('nav_bar.php');
	?>
	<div class="main_content">
		<h1>About the Connection Game</h1>
	</div>
	<div class="about_content">
		<p><em>The Connection Game</em> is loosely based on the six degrees of separation concept – an idea that was first expressed by Hungarian author Frigyes Karinthy.  Karinthy's theory is that there is a series of connections linking every person to every other person.  In addition, each of us is connected to each other individual by a chain of five (or fewer) acquaintances.  This idea was brought into popular consciousness by John Guare's play <em>Six Degrees of Separation</em> and gained notoriety due to the pop culture game it inspired: <em>The Six Degrees of Kevin Bacon.</em></p>

		<p>In <em>The Connection Game</em>, you’ll make connections between a wider variety of subjects, not just people and actors, but places, music, books, games, and historical events, as well as TV shows and movies.  These subjects are referred to as nodes.  While providing a brief description of each, <em>The Connection Game</em> does not focus on the nodes themselves, but on the commonalities between them.</p>

		<p>Personally, I have found that creating and playing <em>The Connection Game</em> has caused me to learn a lot more than I thought there was to know about my own interests.   I am frequently surprised by how subjects are interrelated, and I hope you find it as intriguing as I do.</p>

		<p>Bruce A. Smith</p>
	</div>

	<div class="about_content">
		<h3>Submissions</h3>
		<p>If you would like to suggest nodes/subjects or connections, please email your ideas to <a href="mailto:basdude@aol.com">basdude@aol.com</a>.
			If you already have, thank you!  Occasionally, I won't add suggestions 
			to the database because they don't correspond with my interests.  Limiting <em>The Connection Game</em>
			to those subjects that I am interested in is the only thing that keeps it from getting completely out of control.
		</p>
	</div>

	<div class="about_content">
		<h3>FAQ</h3>
		<p><b>Is there always a path through the grid?</b></p>
		<p>Yes.  The maze algorithm guarantees this.</p>

		<p><b>Why are there duplicate subjects on the grid?</b></p>
		<p>Subjects get repeated on the grid for several reasons.  The main reason is that the whole point of the game is to
			find connections between nodes, while demonstrating how many of these subjects are related in tightly woven little webs.
			As a result, nodes show up over and over again so that the player can see how they are connected to other nodes.
			The secondary reason for this repetition is simply because of how the nodes are connected.  Sometimes the only way to get to
			a node that has a lot of branches is to go through the one that doesn't. Lastly, the grid is random, so repetition is inevitable.
		</p>

		<p><b>The game shows that two nodes aren't connected, but I know of a way that they are.</b></p>
		<p>Yes, there are numerous connections that I haven't managed to catalog in the database, so the key message that
				you should pay attention to is the one that says "No connection found in database."
				In other words, "Yeah, there may be a connection,
				it just hasn't been added."  Please email me if you feel there are some that should be.
		</p>

		<p><b>How did you program this?</b></p>
		<p>The database was created using MySQL Workbench.  The underlying layout for the hexagonal grid and the maze
			were created in PHP, which also handles all the database queries.  JavaScript is used to display the grid and the maze
			client-side (on your browser), while JQuery and AJAX are used for the Node Information screen.  If you would like to
			see the code or use it to create your own connection game, it is available at 
			<a href="https://github.com/Atrus158/connect_game.git">https://github.com/Atrus158/connect_game.git<a>.
		</p>
	</div>

</div>
</body>
</html>