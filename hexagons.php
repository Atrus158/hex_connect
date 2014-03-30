<?php

class hex {

	//Side count of 63 means all edges are blocked.
	public $side_count = 63;
	public $maze_loc = 0;
	public $color;
	public $node_id = 0;
	public $node_name = 'nada';
	public $node_desc = 'this is the description';

	//Direction values indicate the number (e.g. hex1 or hex2) of the hexagons in the given directions.
	//If the number is zero, then the current hexagon is at the edge of the maze
	//and there isn't a hexagon in that direction.
	public $ne = 0;
	public $e = 0;
	public $se = 0;
	public $sw = 0;
	public $w = 0;
	public $nw = 0;

	public function __construct($maze_loc, $north_e, $east, $south_e, $south_w, $west, $north_w) {

		$this->maze_loc = $maze_loc;
		$this->ne = $north_e;
		$this->e = $east;
		$this->se = $south_e;
		$this->sw = $south_w;
		$this->w = $west;
		$this->nw = $north_w;
	}
}


$maze_hex = array();

//Row 1
$maze_hex[1]=new hex(1, 0, 2, 7, 6, 0, 0);
$maze_hex[2]=new hex(2, 0, 3, 8, 7, 1, 0);
$maze_hex[3]=new hex(3, 0, 4, 9, 8, 2, 0);
$maze_hex[4]=new hex(4, 0, 5, 10, 9, 3, 0);
$maze_hex[5]=new hex(5, 0, 0, 11, 10, 4, 0);

//Row 2
$maze_hex[6]=new hex(6, 1, 7, 13, 12, 0, 0);
$maze_hex[7]=new hex(7, 2, 8, 14, 13, 6, 1);
$maze_hex[8]=new hex(8, 3, 9, 15, 14, 7, 2);
$maze_hex[9]=new hex(9, 4, 10, 16, 15, 8, 3);
$maze_hex[10]=new hex(10, 5, 11, 17, 16, 9, 4);
$maze_hex[11]=new hex(11, 0, 0, 18, 17, 10, 5);

//Row 3
$maze_hex[12]=new hex(12, 6, 13, 20, 19, 0, 0);
$maze_hex[13]=new hex(13, 7, 14, 21, 20, 12, 6);
$maze_hex[14]=new hex(14, 8, 15, 22, 21, 13, 7);
$maze_hex[15]=new hex(15, 9, 16, 23, 22, 14, 8);
$maze_hex[16]=new hex(16, 10, 17, 24, 23, 15, 9);
$maze_hex[17]=new hex(17, 11, 18, 25, 24, 16, 10);
$maze_hex[18]=new hex(18, 0, 0, 26, 25, 17, 11);

//Row 4
$maze_hex[19]=new hex(19, 12, 20, 28, 27, 0, 0);
$maze_hex[20]=new hex(20, 13, 21, 29, 28, 19, 12);
$maze_hex[21]=new hex(21, 14, 22, 30, 29, 20, 13);
$maze_hex[22]=new hex(22, 15, 23, 31, 30, 21, 14);
$maze_hex[23]=new hex(23, 16, 24, 32, 31, 22, 15);
$maze_hex[24]=new hex(24, 17, 25, 33, 32, 23, 16);
$maze_hex[25]=new hex(25, 18, 26, 34, 33, 24, 17);
$maze_hex[26]=new hex(26, 0, 0, 35, 34, 25, 18);

//Row 5
$maze_hex[27]=new hex(27, 19, 28, 36, 0, 0, 0);
$maze_hex[28]=new hex(28, 20, 29, 37, 36, 27, 19);
$maze_hex[29]=new hex(29, 21, 30, 38, 37, 28, 20);
$maze_hex[30]=new hex(30, 22, 31, 39, 38, 29, 21);
$maze_hex[31]=new hex(31, 23, 32, 40, 39, 30, 22);
$maze_hex[32]=new hex(32, 24, 33, 41, 40, 31, 23);
$maze_hex[33]=new hex(33, 25, 34, 42, 41, 32, 24);
$maze_hex[34]=new hex(34, 26, 35, 43, 42, 33, 25);
$maze_hex[35]=new hex(35, 0, 0, 0, 43, 34, 26);

//Row 6
$maze_hex[36]=new hex(36, 28, 37, 44, 0, 0, 27);
$maze_hex[37]=new hex(37, 29, 38, 45, 44, 36, 28);
$maze_hex[38]=new hex(38, 30, 39, 46, 45, 37, 29);
$maze_hex[39]=new hex(39, 31, 40, 47, 46, 38, 30);
$maze_hex[40]=new hex(40, 32, 41, 48, 47, 39, 31);
$maze_hex[41]=new hex(41, 33, 42, 49, 48, 40, 32);
$maze_hex[42]=new hex(42, 34, 43, 50, 49, 41, 33);
$maze_hex[43]=new hex(43, 35, 0, 0, 50, 42, 34);

//Row 7
$maze_hex[44]=new hex(44, 37, 45, 51, 0, 0, 36);
$maze_hex[45]=new hex(45, 38, 46, 52, 51, 44, 37);
$maze_hex[46]=new hex(46, 39, 47, 53, 52, 45, 38);
$maze_hex[47]=new hex(47, 40, 48, 54, 53, 46, 39);
$maze_hex[48]=new hex(48, 41, 49, 55, 54, 47, 40);
$maze_hex[49]=new hex(49, 42, 50, 56, 55, 48, 41);
$maze_hex[50]=new hex(50, 43, 0, 0, 56, 49, 42);

//Row 8
$maze_hex[51]=new hex(51, 45, 52, 57, 0, 0, 44);
$maze_hex[52]=new hex(52, 46, 53, 58, 57, 51, 45);
$maze_hex[53]=new hex(53, 47, 54, 59, 58, 52, 46);
$maze_hex[54]=new hex(54, 48, 55, 60, 59, 53, 47);
$maze_hex[55]=new hex(55, 49, 56, 61, 60, 54, 48);
$maze_hex[56]=new hex(56, 50, 0, 0, 61, 55, 49);

//Row 9
$maze_hex[57]=new hex(57, 52, 58, 0, 0, 0, 51);
$maze_hex[58]=new hex(58, 53, 59, 0, 0, 57, 52);
$maze_hex[59]=new hex(59, 54, 60, 0, 0, 58, 53);
$maze_hex[60]=new hex(60, 55, 61, 0, 0, 59, 54);
$maze_hex[61]=new hex(61, 56, 0, 0, 0, 60, 55);

?>